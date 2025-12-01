<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session configuration for security
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
ini_set('session.cookie_secure', 0); // Set to 1 if using HTTPS

// Start session
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'cybercart_store');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application Settings
define('SITE_NAME', 'CyberCart Store');
define('SITE_URL', 'http://localhost/cybercart-store');
define('ADMIN_EMAIL', 'admin@cybercartstore.com');
define('SUPPORT_EMAIL', 'support@cybercartstore.com');

// File Paths
define('ROOT_PATH', dirname(__DIR__));
define('INCLUDE_PATH', ROOT_PATH . '/includes');
define('TEMPLATE_PATH', ROOT_PATH . '/templates');
define('UPLOAD_PATH', ROOT_PATH . '/assets/images/uploads/');
define('PRODUCT_IMAGE_PATH', '/assets/images/products/');
define('AVATAR_PATH', '/assets/images/avatars/');

// E-commerce Settings
define('CURRENCY', 'USD');
define('CURRENCY_SYMBOL', '$');
define('TAX_RATE', 0.08); // 8% tax
define('SHIPPING_COST', 9.99);
define('FREE_SHIPPING_MIN', 100.00);
define('MAX_PRODUCT_QUANTITY', 10);

// Security Settings
define('PEPPER', 'cybercart_secret_pepper_2024_change_this_in_production');
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOCKOUT_TIME', 900); // 15 minutes in seconds
define('CSRF_TOKEN_LIFETIME', 3600); // 1 hour

// JSON Data Files
define('PRODUCTS_JSON', ROOT_PATH . '/data/products.json');
define('CATEGORIES_JSON', ROOT_PATH . '/data/categories.json');
define('ORDERS_JSON', ROOT_PATH . '/data/orders.json');
define('USERS_JSON', ROOT_PATH . '/data/users.json');
define('SETTINGS_JSON', ROOT_PATH . '/data/settings.json');
define('ADMIN_USERS_JSON', ROOT_PATH . '/data/admin_users.json');

// Default categories if none exist
$DEFAULT_CATEGORIES = [
    ['id' => '1', 'name' => 'Laptops', 'icon' => 'fas fa-laptop', 'slug' => 'laptops'],
    ['id' => '2', 'name' => 'Smartphones', 'icon' => 'fas fa-mobile-alt', 'slug' => 'smartphones'],
    ['id' => '3', 'name' => 'Tablets', 'icon' => 'fas fa-tablet-alt', 'slug' => 'tablets'],
    ['id' => '4', 'name' => 'Accessories', 'icon' => 'fas fa-headphones', 'slug' => 'accessories'],
    ['id' => '5', 'name' => 'Gaming', 'icon' => 'fas fa-gamepad', 'slug' => 'gaming']
];

// Default admin user if none exist
$DEFAULT_ADMIN_USER = [
    'id' => '1',
    'name' => 'Admin User',
    'email' => 'admin@cybercartstore.com',
    'password' => hash('sha256', 'admin123' . PEPPER), // Default password: admin123
    'role' => 'super_admin',
    'avatar' => '',
    'created_at' => date('Y-m-d H:i:s'),
    'updated_at' => date('Y-m-d H:i:s'),
    'active' => true
];

/**
 * Database Connection Function
 */
function getDBConnection() {
    try {
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        $pdo = new PDO($dsn, DB_USER, DB_PASS);
        
        // Set PDO attributes
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        
        return $pdo;
        
    } catch (PDOException $e) {
        // Log error and show user-friendly message
        error_log("Database Connection Failed: " . $e->getMessage());
        return false;
    }
}

/**
 * JSON Data Management Functions
 */
function getJSONData($file_path, $default = []) {
    if (!file_exists($file_path)) {
        // Create directory if it doesn't exist
        $dir = dirname($file_path);
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
        
        // Create file with default data
        file_put_contents($file_path, json_encode($default, JSON_PRETTY_PRINT));
        return $default;
    }
    
    $data = file_get_contents($file_path);
    if ($data === false) {
        return $default;
    }
    
    $decoded = json_decode($data, true);
    return $decoded !== null ? $decoded : $default;
}

function saveJSONData($file_path, $data) {
    $dir = dirname($file_path);
    if (!is_dir($dir)) {
        mkdir($dir, 0755, true);
    }
    
    $result = file_put_contents($file_path, json_encode($data, JSON_PRETTY_PRINT));
    return $result !== false;
}

/**
 * Security Functions
 */
function sanitizeInput($data) {
    if (is_array($data)) {
        return array_map('sanitizeInput', $data);
    }
    
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

function generateCSRFToken() {
    if (empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_token_time']) || 
        (time() - $_SESSION['csrf_token_time']) > CSRF_TOKEN_LIFETIME) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        $_SESSION['csrf_token_time'] = time();
    }
    return $_SESSION['csrf_token'];
}

function validateCSRFToken($token) {
    if (empty($_SESSION['csrf_token']) || empty($_SESSION['csrf_token_time'])) {
        return false;
    }
    
    // Check if token has expired
    if ((time() - $_SESSION['csrf_token_time']) > CSRF_TOKEN_LIFETIME) {
        unset($_SESSION['csrf_token'], $_SESSION['csrf_token_time']);
        return false;
    }
    
    return hash_equals($_SESSION['csrf_token'], $token);
}

function generateRandomString($length = 32) {
    return bin2hex(random_bytes($length));
}

function hashPassword($password) {
    return hash('sha256', $password . PEPPER);
}

function verifyPassword($password, $hashedPassword) {
    return hashPassword($password) === $hashedPassword;
}

/**
 * Utility Functions
 */
function formatPrice($price) {
    return CURRENCY_SYMBOL . number_format($price, 2);
}

function calculateTax($amount) {
    return round($amount * TAX_RATE, 2);
}

function calculateShipping($subtotal) {
    return $subtotal >= FREE_SHIPPING_MIN ? 0 : SHIPPING_COST;
}

function calculateTotal($subtotal) {
    $tax = calculateTax($subtotal);
    $shipping = calculateShipping($subtotal);
    return $subtotal + $tax + $shipping;
}

function redirect($url) {
    header("Location: $url");
    exit();
}

function isLoggedIn() {
    return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}

function getCurrentUserName() {
    return $_SESSION['user_name'] ?? 'Guest';
}

/**
 * Error Handling and Logging
 */
function logError($message) {
    $log_file = ROOT_PATH . '/logs/error.log';
    $timestamp = date('Y-m-d H:i:s');
    $log_message = "[$timestamp] ERROR: $message" . PHP_EOL;
    
    // Create logs directory if it doesn't exist
    $log_dir = dirname($log_file);
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);
}

function logActivity($activity, $user_id = null) {
    $log_file = ROOT_PATH . '/logs/activity.log';
    $timestamp = date('Y-m-d H:i:s');
    $user_id = $user_id ?? ($_SESSION['user_id'] ?? 'unknown');
    $log_message = "[$timestamp] USER:$user_id - $activity" . PHP_EOL;
    
    $log_dir = dirname($log_file);
    if (!is_dir($log_dir)) {
        mkdir($log_dir, 0755, true);
    }
    
    file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);
}

/**
 * Initialize required data files on first run
 */
function initializeDataFiles() {
    global $DEFAULT_CATEGORIES, $DEFAULT_ADMIN_USER;
    
    $required_files = [
        PRODUCTS_JSON => ['products' => []],
        CATEGORIES_JSON => ['categories' => $DEFAULT_CATEGORIES],
        ORDERS_JSON => ['orders' => []],
        USERS_JSON => ['users' => []],
        SETTINGS_JSON => ['settings' => [
            'store_name' => SITE_NAME,
            'store_email' => ADMIN_EMAIL,
            'support_email' => SUPPORT_EMAIL,
            'currency' => CURRENCY,
            'tax_rate' => TAX_RATE,
            'shipping_cost' => SHIPPING_COST,
            'free_shipping_min' => FREE_SHIPPING_MIN,
            'store_address' => '',
            'store_phone' => '',
            'store_description' => 'Your trusted technology destination'
        ]],
        ADMIN_USERS_JSON => ['users' => [$DEFAULT_ADMIN_USER]]
    ];
    
    foreach ($required_files as $file => $default_data) {
        if (!file_exists($file)) {
            saveJSONData($file, $default_data);
        }
    }
    
    // Create necessary directories
    $directories = [
        ROOT_PATH . '/assets/images/products',
        ROOT_PATH . '/assets/images/avatars',
        ROOT_PATH . '/assets/images/uploads',
        ROOT_PATH . '/logs',
        ROOT_PATH . '/data'
    ];
    
    foreach ($directories as $dir) {
        if (!is_dir($dir)) {
            mkdir($dir, 0755, true);
        }
    }
}

/**
 * Product-related functions
 */
function getProductById($id) {
    $products_data = getJSONData(PRODUCTS_JSON, ['products' => []]);
    
    foreach ($products_data['products'] as $product) {
        if ($product['id'] == $id) {
            return $product;
        }
    }
    
    return null;
}

function getProductsByCategory($category_id) {
    $products_data = getJSONData(PRODUCTS_JSON, ['products' => []]);
    $filtered_products = [];
    
    foreach ($products_data['products'] as $product) {
        if ($product['category'] == $category_id) {
            $filtered_products[] = $product;
        }
    }
    
    return $filtered_products;
}

function getFeaturedProducts() {
    $products_data = getJSONData(PRODUCTS_JSON, ['products' => []]);
    $featured_products = [];
    
    foreach ($products_data['products'] as $product) {
        if (isset($product['featured']) && $product['featured'] === true) {
            $featured_products[] = $product;
        }
    }
    
    return $featured_products;
}

/**
 * Cart-related functions
 */
function getCartCount() {
    if (!isset($_SESSION['cart'])) {
        return 0;
    }
    
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
    
    return $count;
}

function getCartTotal() {
    if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
        return 0;
    }
    
    $total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $product = getProductById($item['product_id']);
        if ($product) {
            $total += $product['price'] * $item['quantity'];
        }
    }
    
    return $total;
}

// Auto-initialize on include
initializeDataFiles();

// Generate CSRF token for forms
if (empty($_SESSION['csrf_token'])) {
    generateCSRFToken();
}

// Set default timezone
date_default_timezone_set('America/New_York');
?>

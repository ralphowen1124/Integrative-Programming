<?php
function getProducts($category = 'all') {
    $productsFile = 'data/products.json';
    
    // Create directory if it doesn't exist
    $dataDir = dirname($productsFile);
    if (!is_dir($dataDir)) {
        mkdir($dataDir, 0755, true);
    }
    
    if (!file_exists($productsFile)) {
        $defaultProducts = [
            'products' => []
        ];
        
        file_put_contents($productsFile, json_encode($defaultProducts, JSON_PRETTY_PRINT));
        return [];
    }
    
    $productsData = file_get_contents($productsFile);
    $data = json_decode($productsData, true);

    if ($data === null || !isset($data['products'])) {
        return [];
    }
    
    $products = $data['products'];
    
    if ($category !== 'all') {
        $products = array_filter($products, function($product) use ($category) {
            return isset($product['category']) && $product['category'] === $category;
        });
    }
    
    return $products;
}

function getProductById($id) {
    $products = getProducts();
    
    foreach ($products as $product) {
        if (isset($product['id']) && $product['id'] == $id) {
            return $product;
        }
    }
    
    return null;
}

function getFeaturedProducts() {
    $products = getProducts();
    
    return array_filter($products, function($product) {
        return isset($product['featured']) && $product['featured'] === true;
    });
}

function saveProduct($productData) {
    $productsFile = 'data/products.json';
    
    // Create directory if it doesn't exist
    $dataDir = dirname($productsFile);
    if (!is_dir($dataDir)) {
        mkdir($dataDir, 0755, true);
    }
    
    $products = getProducts();
    
    if (!isset($productData['id']) || empty($productData['id'])) {
        $maxId = 0;
        foreach ($products as $product) {
            if (isset($product['id']) && $product['id'] > $maxId) {
                $maxId = $product['id'];
            }
        }
        $productData['id'] = $maxId + 1;
    }
    
    $found = false;
    foreach ($products as &$product) {
        if (isset($product['id']) && $product['id'] == $productData['id']) {
            $product = array_merge($product, $productData);
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        $products[] = $productData;
    }
    
    $data = ['products' => $products];
    return file_put_contents($productsFile, json_encode($data, JSON_PRETTY_PRINT));
}

function deleteProduct($id) {
    $productsFile = 'data/products.json';
    
    // Create directory if it doesn't exist
    $dataDir = dirname($productsFile);
    if (!is_dir($dataDir)) {
        mkdir($dataDir, 0755, true);
    }
    
    $products = getProducts();
    $products = array_filter($products, function($product) use ($id) {
        return isset($product['id']) && $product['id'] != $id;
    });
    
    $data = ['products' => array_values($products)];
    return file_put_contents($productsFile, json_encode($data, JSON_PRETTY_PRINT));
}

function getCartCount() {
    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
    return count($cart);
}

function formatPrice($price) {
    return '$' . number_format($price, 2);
}

function generateStarRating($rating) {
    $stars = '';
    $fullStars = floor($rating);
    $hasHalfStar = ($rating - $fullStars) >= 0.5;
    
    for ($i = 1; $i <= 5; $i++) {
        if ($i <= $fullStars) {
            $stars .= '<i class="fas fa-star"></i>';
        } elseif ($i == $fullStars + 1 && $hasHalfStar) {
            $stars .= '<i class="fas fa-star-half-alt"></i>';
        } else {
            $stars .= '<i class="far fa-star"></i>';
        }
    }
    
    return $stars;
}
?>

<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location:login.php');
    exit();
}

$admin_data = [
    'name' => 'Jeffrey Principe',
    'stats' => [
        'orders' => 156,
        'products' => 42,
        'customers' => 1246,
        'revenue' => 512458
    ]
];

$recent_orders = [
    [
        'id' => 'ORD-2025',
        'customer' => 'Jeffrey Principe',
        'date' => '2025-11-19 14:30:49',
        'amount' => 299.99,
        'status' => 'completed'
    ],
    [
        'id' => 'ORD-2025', 
        'customer' => 'Justin De Lara',
        'date' => '2025-11-19 09:22:31',
        'amount' => 599.99,
        'status' => 'pending'
    ]
];

$low_stock_products = [
    [
        'name' => 'iPhone 15 Pro',
        'category' => 'Smartphones',
        'price' => 999.99,
        'stock' => 9
    ],
    [
        'name' => 'AirPods Pro',
        'category' => 'Accessories', 
        'price' => 199.99,
        'stock' => 12
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - CyberCart Store</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        :root {
            --primary: #1a1a2e;
            --secondary: #4cc9f0;
            --accent: #4361ee;
            --light: #f8f9fa;
            --dark: #212529;
            --success: #28a745;
            --warning: #ffc107;
            --danger: #dc3545;
            --gray: #6c757d;
        }
        
        body {
            background-color: #f5f7fa;
            color: var(--dark);
            display: flex;
            min-height: 100vh;
        }
        
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, var(--primary) 0%, #16213e 100%);
            color: white;
            padding: 20px 0;
        }
        
        .logo {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            margin-bottom: 20px;
        }
        
        .logo h1 {
            font-size: 24px;
            font-weight: bold;
        }
        
        .logo span {
            color: var(--secondary);
        }
        
        .nav-menu {
            list-style: none;
            padding: 0 15px;
        }
        
        .nav-menu li {
            margin-bottom: 5px;
        }
        
        .nav-menu a {
            display: block;
            padding: 12px 15px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.3s;
        }
        
        .nav-menu a:hover, .nav-menu a.active {
            background: rgba(76, 201, 240, 0.1);
            color: white;
        }
        
        .main-content {
            flex: 1;
            padding: 30px;
            overflow-y: auto;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        
        .header h1 {
            color: var(--primary);
            font-size: 28px;
        }
        
        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            background: var(--secondary);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 15px;
        }
        
        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
        }
        
        .stat-icon.orders { background: #e3f2fd; color: #1976d2; }
        .stat-icon.products { background: #f3e5f5; color: #7b1fa2; }
        .stat-icon.customers { background: #e8f5e8; color: #388e3c; }
        .stat-icon.revenue { background: #fff3e0; color: #f57c00; }
        
        .stat-info h3 {
            color: var(--gray);
            font-size: 14px;
            margin-bottom: 5px;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: bold;
            color: var(--primary);
        }
        
        .content-section {
            background: white;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .section-header {
            margin-bottom: 20px;
        }
        
        .section-header h2 {
            color: var(--primary);
            font-size: 20px;
        }
        
        .data-table {
            width: 100%;
            border-collapse: collapse;
        }
        
        .data-table th {
            text-align: left;
            padding: 12px 15px;
            background: #f8f9fa;
            color: var(--gray);
            font-weight: 600;
            border-bottom: 1px solid #dee2e6;
        }
        
        .data-table td {
            padding: 12px 15px;
            border-bottom: 1px solid #f0f0f0;
        }
        
        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-completed {
            background: #e8f5e8;
            color: var(--success);
        }
        
        .status-pending {
            background: #fff3cd;
            color: var(--warning);
        }
        
        .status-low {
            background: #f8d7da;
            color: var(--danger);
        }
        
        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 12px;
        }
        
        .btn-view {
            background: var(--secondary);
            color: white;
        }
        
        .product-list {
            display: grid;
            gap: 15px;
        }
        
        .product-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: 1px solid #f0f0f0;
            border-radius: 8px;
        }
        
        .product-info h4 {
            margin-bottom: 5px;
        }
        
        .product-meta {
            color: var(--gray);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="logo">
            <h1>CyberCart<span>Store</span> Admin</h1>
        </div>
        <ul class="nav-menu">
            <li><a href="admin_dashboard.php" class="active">📊 Dashboard</a></li>
            <li><a href="products.php">📦 Products</a></li>
            <li><a href="orders.php">🛒 Orders</a></li>
            <li><a href="customers.php">👥 Customers</a></li>
            <li><a href="../index.php" target="_blank">🏪 View Store</a></li>
            <li><a href="logout.php">🚪 Logout</a></li>
        </ul>
    </div>

    <div class="main-content">
        <div class="header">
            <h1>Dashboard</h1>
            <div class="user-info">
                <div class="user-avatar">AU</div>
                <div><?php echo htmlspecialchars($admin_data['name']); ?></div>
            </div>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon orders">📦</div>
                <div class="stat-info">
                    <h3>Total Orders</h3>
                    <div class="stat-value"><?php echo $admin_data['stats']['orders']; ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon products">📱</div>
                <div class="stat-info">
                    <h3>Products</h3>
                    <div class="stat-value"><?php echo $admin_data['stats']['products']; ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon customers">👥</div>
                <div class="stat-info">
                    <h3>Customers</h3>
                    <div class="stat-value"><?php echo number_format($admin_data['stats']['customers']); ?></div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon revenue">💰</div>
                <div class="stat-info">
                    <h3>Revenue</h3>
                    <div class="stat-value">$<?php echo number_format($admin_data['stats']['revenue']); ?></div>
                </div>
            </div>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>Recent Orders</h2>
            </div>
            <table class="data-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_orders as $order): ?>
                    <tr>
                        <td>#<?php echo $order['id']; ?></td>
                        <td><?php echo htmlspecialchars($order['customer']); ?></td>
                        <td><?php echo $order['date']; ?></td>
                        <td>$<?php echo number_format($order['amount'], 2); ?></td>
                        <td>
                            <span class="status-badge status-<?php echo $order['status']; ?>">
                                <?php echo ucfirst($order['status']); ?>
                            </span>
                        </td>
                        <td>
                            <button class="btn btn-view" onclick="viewOrder('<?php echo $order['id']; ?>')">
                                View
                            </button>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div class="content-section">
            <div class="section-header">
                <h2>Low Stock Products</h2>
            </div>
            <div class="product-list">
                <?php foreach ($low_stock_products as $product): ?>
                <div class="product-item">
                    <div class="product-info">
                        <h4><?php echo htmlspecialchars($product['name']); ?></h4>
                        <div class="product-meta">
                            <?php echo htmlspecialchars($product['category']); ?> • 
                            $<?php echo number_format($product['price'], 2); ?>
                        </div>
                    </div>
                    <div>
                        <span class="status-badge status-low">
                            Low Stock (<?php echo $product['stock']; ?> left)
                        </span>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script>
        function viewOrder(orderId) {
            alert('Viewing order: ' + orderId);
        }
    </script>
</body>
</html>

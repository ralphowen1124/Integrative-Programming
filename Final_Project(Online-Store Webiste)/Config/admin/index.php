<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CyberCart Store Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <h1>CyberCart Store Admin</h1>
            </div>
            
            <nav class="admin-menu">
                <ul>
                    <li>
                        <a href="index.php" class="active">
                            <i class="fas fa-tachometer-alt"></i>
                            <span class="menu-text">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="manage-products.php">
                            <i class="fas fa-box"></i>
                            <span class="menu-text">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="orders.php">
                            <i class="fas fa-shopping-cart"></i>
                            <span class="menu-text">Orders</span>
                        </a>
                    </li>
                    <li>
                        <a href="customers.php">
                            <i class="fas fa-users"></i>
                            <span class="menu-text">Customers</span>
                        </a>
                    </li>
                    <li>
                        <a href="analytics.php">
                            <i class="fas fa-chart-bar"></i>
                            <span class="menu-text">Analytics</span>
                        </a>
                    </li>
                    <li>
                        <a href="../index.php" target="_blank">
                            <i class="fas fa-external-link-alt"></i>
                            <span class="menu-text">View Store</span>
                        </a>
                    </li>
                    <li>
                        <a href="logout.php">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="menu-text">Logout</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header">
                <h1>Dashboard</h1>
                <div class="admin-user">
                    <span>Admin User</span>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <h3>156</h3>
                        <p>Total Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-box"></i>
                    </div>
                    <div class="stat-info">
                        <h3>42</h3>
                        <p>Products</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>893</h3>
                        <p>Customers</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-info">
                        <h3>$512,458</h3>
                        <p>Revenue</p>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="card-header">
                    <h2>Recent Orders</h2>
                    <a href="orders.php" class="btn btn-outline">View All</a>
                </div>
                <div class="card-body">
                    <table class="admin-table">
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
                            <tr>
                                <td><strong>#ORD-001</strong></td>
                                <td><strong>Jeffrey Principe</strong></td>
                                <td>2025-01-15</td>
                                <td><strong>$299.99</strong></td>
                                <td><span class="status-badge status-active">Completed</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline">View</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>#ORD-002</strong></td>
                                <td><strong>Justin De Lara</strong></td>
                                <td>2024-01-14</td>
                                <td><strong>$599.99</strong></td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline">View</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                                <td><strong>#ORD-003</strong></td>
                                <td><strong>Ralp Owen Castillo</strong></td>
                                <td>2025-01-14</td>
                                <td><strong>$599.99</strong></td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline">View</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                                <td><strong>#ORD-004</strong></td>
                                <td><strong>Jaypee Miranda</strong></td>
                                <td>2025-01-14</td>
                                <td><strong>$599.99</strong></td>
                                <td><span class="status-badge status-pending">Pending</span></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline">View</button>
                                        <button class="btn btn-sm btn-danger">Delete</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="admin-card">
                <div class="card-header">
                    <h2>Low Stock Products</h2>
                    <a href="manage-products.php" class="btn btn-primary">Manage Products</a>
                </div>
                <div class="card-body">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Stock</th>
                                <th>Price</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>iPhone 15 Pro</strong></td>
                                <td>Smartphones</td>
                                <td>3</td>
                                <td><strong>$999.99</strong></td>
                                <td><span class="status-badge status-warning">Low Stock</span></td>
                            </tr>
                            <tr>
                                <td><strong>AirPods Pro</strong></td>
                                <td>Accessories</td>
                                <td>5</td>
                                <td><strong>$249.99</strong></td>
                                <td><span class="status-badge status-warning">Low Stock</span></td>
                            </tr>
                            <td><strong>Samsung s24</strong></td>
                                <td>Smartphones</td>
                                <td>5</td>
                                <td><strong>$1299.99</strong></td>
                                <td><span class="status-badge status-warning">Low Stock</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>

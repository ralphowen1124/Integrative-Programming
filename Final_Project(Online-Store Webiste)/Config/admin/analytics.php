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
    <title>Analytics - CyberCart Store Admin</title>
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
                    <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> <span
                                class="menu-text">Dashboard</span></a></li>
                    <li><a href="manage-products.php"><i class="fas fa-box"></i> <span
                                class="menu-text">Products</span></a></li>
                    <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> <span
                                class="menu-text">Orders</span></a></li>
                    <li><a href="customers.php"><i class="fas fa-users"></i> <span
                                class="menu-text">Customers</span></a></li>
                    <li><a href="analytics.php" class="active"><i class="fas fa-chart-bar"></i> <span
                                class="menu-text">Analytics</span></a></li>
                    <li><a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> <span
                                class="menu-text">View Store</span></a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span
                                class="menu-text">Logout</span></a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header">
                <h1>Analytics Dashboard</h1>
                <div class="admin-user">
                    <span>Admin User</span>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-info">
                        <h3>+15.2%</h3>
                        <p>Sales Growth</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <h3>156</h3>
                        <p>This Month</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3>+89</h3>
                        <p>New Customers</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-info">
                        <h3>$45.2K</h3>
                        <p>Revenue</p>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="card-header">
                    <h2>Sales Overview</h2>
                    <div class="card-actions">
                        <select class="form-control">
                            <option>Last 7 Days</option>
                            <option>Last 30 Days</option>
                            <option>Last 90 Days</option>
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div style="text-align: center; padding: 60px; background: #f8fafc; border-radius: 8px;">
                        <i class="fas fa-chart-bar" style="font-size: 3rem; color: #cbd5e1; margin-bottom: 20px;"></i>
                        <p style="color: #64748b;">Sales chart will be displayed here</p>
                        <p style="color: #94a3b8; font-size: 0.9rem;">In a real application, this would show interactive
                            charts</p>
                    </div>
                </div>
            </div>

            <div class="admin-card">
                <div class="card-header">
                    <h2>Top Selling Products</h2>
                </div>
                <div class="card-body">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Category</th>
                                <th>Units Sold</th>
                                <th>Revenue</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td><strong>iPhone 15 Pro</strong></td>
                                <td>Smartphones</td>
                                <td>45</td>
                                <td><strong>$44,999.55</strong></td>
                            </tr>
                            <tr>
                                <td><strong>MacBook Pro 16"</strong></td>
                                <td>Laptops</td>
                                <td>28</td>
                                <td><strong>$67,199.72</strong></td>
                            </tr>
                            <tr>
                                <td><strong>AirPods Pro</strong></td>
                                <td>Accessories</td>
                                <td>89</td>
                                <td><strong>$22,249.11</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

</html>

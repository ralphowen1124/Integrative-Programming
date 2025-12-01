<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$productId = $_GET['id'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product - CyberCart Store Admin</title>
    <link rel="stylesheet" href="admin.css">
</head>
<body>
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-brand">
                <h1>CyberCart<span>Store</span> Admin</h1>
            </div>
            
            <nav class="admin-menu">
                <ul>
                    <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> <span class="menu-text">Dashboard</span></a></li>
                    <li><a href="manage-products.php"><i class="fas fa-box"></i> <span class="menu-text">Products</span></a></li>
                    <li><a href="add-product.php"><i class="fas fa-plus"></i> <span class="menu-text">Add Product</span></a></li>
                    <li><a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> <span class="menu-text">View Store</span></a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span class="menu-text">Logout</span></a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header">
                <h1>Edit Product #<?php echo $productId; ?></h1>
                <a href="manage-products.php" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>

            <div class="admin-card">
                <div class="card-header">
                    <h2>Edit Product Information</h2>
                </div>
                <div class="card-body" style="padding: 30px;">
                    <form id="edit-product-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="productName">Product Name *</label>
                                <input type="text" id="productName" name="productName" class="form-control" value="MacBook Pro 16&#34;" required>
                            </div>
                            <div class="form-group">
                                <label for="productPrice">Price *</label>
                                <input type="number" id="productPrice" name="productPrice" class="form-control" value="2399.99" step="0.01" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="productCategory">Category *</label>
                                <select id="productCategory" name="productCategory" class="form-control" required>
                                    <option value="laptops" selected>Laptops</option>
                                    <option value="smartphones">Smartphones</option>
                                    <option value="accessories">Accessories</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="productStock">Stock Quantity *</label>
                                <input type="number" id="productStock" name="productStock" class="form-control" value="15

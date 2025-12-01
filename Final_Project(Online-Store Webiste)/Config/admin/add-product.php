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
    <title>Add Product - CyberCart Store Admin</title>
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
                    <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> <span
                                class="menu-text">Dashboard</span></a></li>
                    <li><a href="manage-products.php"><i class="fas fa-box"></i> <span
                                class="menu-text">Products</span></a></li>
                    <li><a href="add-product.php" class="active"><i class="fas fa-plus"></i> <span
                                class="menu-text">Add Product</span></a></li>
                    <li><a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> <span
                                class="menu-text">View Store</span></a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span
                                class="menu-text">Logout</span></a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header">
                <h1>Add New Product</h1>
                <a href="manage-products.php" class="btn btn-outline">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>

            <div class="admin-card">
                <div class="card-header">
                    <h2>Product Information</h2>
                </div>
                <div class="card-body" style="padding: 30px;">
                    <form id="add-product-form">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="productName">Product Name *</label>
                                <input type="text" id="productName" name="productName" class="form-control" required>
                            </div>
                            <div class="form-group">
                                <label for="productPrice">Price *</label>
                                <input type="number" id="productPrice" name="productPrice" class="form-control"
                                    step="0.01" required>
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="productCategory">Category *</label>
                                <select id="productCategory" name="productCategory" class="form-control" required>
                                    <option value="">Select Category</option>
                                    <option value="laptops">Laptops</option>
                                    <option value="smartphones">Smartphones</option>
                                    <option value="accessories">Accessories</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="productStock">Stock Quantity *</label>
                                <input type="number" id="productStock" name="productStock" class="form-control"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="productDescription">Description *</label>
                            <textarea id="productDescription" name="productDescription" class="form-control" rows="4"
                                required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="productImage">Product Image</label>
                            <input type="file" id="productImage" name="productImage" class="form-control"
                                accept="image/*">
                            <small>Recommended size: 500x500 pixels</small>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="productStatus">Status</label>
                                <select id="productStatus" name="productStatus" class="form-control">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="productFeatured">Featured Product</label>
                                <select id="productFeatured" name="productFeatured" class="form-control">
                                    <option value="0">No</option>
                                    <option value="1">Yes</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="productSpecs">Specifications (JSON)</label>
                            <textarea id="productSpecs" name="productSpecs" class="form-control" rows="3"
                                placeholder='{"ram": "16GB", "storage": "512GB SSD"}'></textarea>
                        </div>

                        <div class="form-actions" style="display: flex; gap: 15px; margin-top: 30px;">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Save Product
                            </button>
                            <button type="reset" class="btn btn-outline">
                                <i class="fas fa-redo"></i> Reset
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    </div>

    <script>
        document.getElementById('add-product-form').addEventListener('submit', function (e) {
            e.preventDefault();
            alert('Product added successfully!');
            window.location.href = 'manage-products.php';
        });
    </script>
</body>

</html>

<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

include '../includes/functions.php';

$products = getProducts();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Products - CyberCart Store Admin</title>
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
                    <li><a href="manage-products.php" class="active"><i class="fas fa-box"></i> <span
                                class="menu-text">Products</span></a></li>
                    <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> <span
                                class="menu-text">Orders</span></a></li>
                    <li><a href="customers.php"><i class="fas fa-users"></i> <span
                                class="menu-text">Customers</span></a></li>
                    <li><a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> <span
                                class="menu-text">View Store</span></a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span
                                class="menu-text">Logout</span></a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header">
                <h1>Manage Products</h1>
                <a href="add-product.php" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Add New Product
                </a>
            </div>

            <div class="search-box">
                <input type="text" placeholder="Search products..." class="form-control">
                <button class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>

            <div class="filters">
                <div class="filter-group">
                    <label>Category:</label>
                    <select class="form-control">
                        <option value="">All Categories</option>
                        <option value="laptops">Laptops</option>
                        <option value="smartphones">Smartphones</option>
                        <option value="accessories">Accessories</option>
                        <option value="tablets">Tablets</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Status:</label>
                    <select class="form-control">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="admin-card">
                <div class="card-header">
                    <h2>Products (<?php echo count($products); ?>)</h2>
                    <div class="card-actions">
                        <button class="btn btn-outline">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (empty($products)): ?>
                        <div style="text-align: center; padding: 40px; color: var(--secondary);">
                            <i class="fas fa-box-open" style="font-size: 3rem; margin-bottom: 20px;"></i>
                            <h3>No Products Found</h3>
                            <p>Get started by adding your first product.</p>
                            <a href="add-product.php" class="btn btn-primary" style="margin-top: 15px;">
                                <i class="fas fa-plus"></i> Add First Product
                            </a>
                        </div>
                    <?php else: ?>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                    <th>Rating</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($products as $product): ?>
                                    <tr>
                                        <td><?php echo $product['id']; ?></td>
                                        <td>
                                            <div class="product-image-preview">
                                                <img src="../assets/images/products/<?php echo $product['image']; ?>"
                                                    alt="<?php echo $product['name']; ?>"
                                                    onerror="this.src='../assets/images/products/placeholder.jpg'">
                                            </div>
                                        </td>
                                        <td>
                                            <strong><?php echo $product['name']; ?></strong>
                                            <?php if (isset($product['featured']) && $product['featured']): ?>
                                                <span class="status-badge status-active" style="margin-left: 5px;">Featured</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo ucfirst($product['category']); ?></td>
                                        <td><strong><?php echo formatPrice($product['price']); ?></strong></td>
                                        <td>
                                            <div style="color: var(--warning);">
                                                <?php echo generateStarRating($product['rating']); ?>
                                                <small
                                                    style="color: var(--secondary); margin-left: 5px;">(<?php echo $product['rating']; ?>)</small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="action-buttons">
                                                <a href="edit-product.php?id=<?php echo $product['id']; ?>"
                                                    class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger"
                                                    onclick="deleteProduct(<?php echo $product['id']; ?>)">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <script>
        function deleteProduct(productId) {
            if (confirm('Are you sure you want to delete this product? This action cannot be undone.')) {
                alert('Product #' + productId + ' would be deleted in a real application.');

            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const searchInput = document.querySelector('.search-box input');
            const searchButton = document.querySelector('.search-box .btn');

            if (searchButton) {
                searchButton.addEventListener('click', function () {
                    const searchTerm = searchInput.value.toLowerCase();
                    const rows = document.querySelectorAll('.admin-table tbody tr');

                    rows.forEach(row => {
                        const productName = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
                        if (productName.includes(searchTerm)) {
                            row.style.display = '';
                        } else {
                            row.style.display = 'none';
                        }
                    });
                });
            }
        });
    </script>
</body>

</html>

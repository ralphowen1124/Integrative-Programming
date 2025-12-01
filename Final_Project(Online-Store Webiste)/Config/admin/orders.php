<?php
session_start();

if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$ordersFile = __DIR__ . '../data/orders.json';

$orders = [];

if (file_exists($ordersFile)) {
    $ordersData = file_get_contents($ordersFile);

    $orders = json_decode($ordersData, true);

    if (!is_array($orders)) {
        $orders = [];
    }
} else {
    $orders = [];
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders - CyberCart Store Admin</title>
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
                    <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
                    <li><a href="manage-products.php"><i class="fas fa-box"></i> Products</a></li>
                    <li><a href="orders.php" class="active"><i class="fas fa-shopping-cart"></i> Orders</a></li>
                    <li><a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> View Store</a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header">
                <h1>Manage Orders</h1>
                <div class="admin-user">
                    <img src="../assets/images/icons/admin-avatar.jpg" alt="Admin">
                    <span>Admin User</span>
                </div>
            </div>

            <div class="admin-card">
                <div class="card-header">
                    <h2>All Orders (<?= count($orders); ?>)</h2>
                    <div class="card-actions">
                        <button class="btn btn-outline">
                            <i class="fas fa-download"></i> Export
                        </button>
                    </div>
                </div>

                <div class="card-body">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Order ID</th>
                                <th>Customer</th>
                                <th>Date</th>
                                <th>Items</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Payment</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php if (empty($orders)): ?>
                                <tr>
                                    <td colspan="8" style="text-align:center; padding:20px;">
                                        No orders found.
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($orders as $order): ?>

                                    <?php
                                    $statusClass = match ($order['order_status']) {
                                        'delivered'  => 'status-active',
                                        'shipped'    => 'status-success',
                                        'processing' => 'status-pending',
                                        default      => 'status-inactive',
                                    };
                                    ?>

                                    <tr>
                                        <td><?= $order['order_id']; ?></td>

                                        <td>
                                            <strong><?= $order['customer_info']['firstName'] . ' ' . $order['customer_info']['lastName']; ?></strong><br>
                                            <small><?= $order['customer_info']['email']; ?></small>
                                        </td>

                                        <td><?= date('M j, Y', strtotime($order['order_date'])); ?></td>

                                        <td><?= count($order['items']); ?> items</td>

                                        <td>₱<?= number_format($order['final_total'], 2); ?></td>

                                        <td>
                                            <span class="status-badge <?= $statusClass; ?>">
                                                <?= ucfirst($order['order_status']); ?>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="status-badge status-active">
                                                <?= ucfirst(str_replace('_', ' ', $order['payment_status'])); ?>
                                            </span>
                                        </td>

                                        <td>
                                            <div class="action-buttons">
                                                <button class="btn btn-sm btn-outline"
                                                    onclick="viewOrder('<?= $order['order_id']; ?>')">
                                                    <i class="fas fa-eye"></i>
                                                </button>

                                                <button class="btn btn-sm btn-warning"
                                                    onclick="editOrder('<?= $order['order_id']; ?>')">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </main>
    </div>

    <script>
        function viewOrder(orderId) {
            alert('View order: ' + orderId);
        }

        function editOrder(orderId) {
            alert('Edit order: ' + orderId);
        }
    </script>

</body>

</html>

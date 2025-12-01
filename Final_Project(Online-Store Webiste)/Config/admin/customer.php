<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

$customers = [
    [
        'id' => 1,
        'name' => 'Jeffrey Principe',
        'email' => 'jeffreyprincipe@gmail.com',
        'phone' => '+63-9638782564',
        'join_date' => '2025-011-15',
        'orders_count' => 5,
        'total_spent' => 1250.50,
        'status' => 'active'
    ],
    [
        'id' => 2,
        'name' => 'Justin De Lara',
        'email' => 'justindelara@gmail.com',
        'phone' => '+63-97856437823',
        'join_date' => '2025-01-10',
        'orders_count' => 3,
        'total_spent' => 899.99,
        'status' => 'active'
    ],
    [
        'id' => 3,
        'name' => 'Ralp Owen Castillo',
        'email' => 'ralpowencastillo@gamil.com',
        'phone' => '+63-97865637846',
        'join_date' => '2025-01-05',
        'orders_count' => 8,
        'total_spent' => 2450.75,
        'status' => 'active'
    ],
    [
        'id' => 4,
        'name' => 'Jaypee Miranda',
        'email' => 'jaypeemiranda@gmail.com',
        'phone' => '+63-98764785634',
        'join_date' => '2025-10-20',
        'orders_count' => 1,
        'total_spent' => 299.99,
        'status' => 'inactive'
    ],
    [
        'id' => 5,
        'name' => 'David Brown',
        'email' => 'davidbrown@gmail.com',
        'phone' => '+63-98674563782',
        'join_date' => '2025-01-25',
        'orders_count' => 0,
        'total_spent' => 0.00,
        'status' => 'new'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers - CyberCart Store Admin</title>
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
                    <li><a href="index.php"><i class="fas fa-tachometer-alt"></i> <span class="menu-text">Dashboard</span></a></li>
                    <li><a href="manage-products.php"><i class="fas fa-box"></i> <span class="menu-text">Products</span></a></li>
                    <li><a href="orders.php"><i class="fas fa-shopping-cart"></i> <span class="menu-text">Orders</span></a></li>
                    <li><a href="customers.php" class="active"><i class="fas fa-users"></i> <span class="menu-text">Customers</span></a></li>
                    <li><a href="analytics.php"><i class="fas fa-chart-bar"></i> <span class="menu-text">Analytics</span></a></li>
                    <li><a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> <span class="menu-text">View Store</span></a></li>
                    <li><a href="logout.php"><i class="fas fa-sign-out-alt"></i> <span class="menu-text">Logout</span></a></li>
                </ul>
            </nav>
        </aside>

        <main class="admin-main">
            <div class="admin-header">
                <h1>Manage Customers</h1>
                <div class="admin-user">
                    <span>Admin User</span>
                </div>
            </div>

            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo count($customers); ?></h3>
                        <p>Total Customers</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </div>
                    <div class="stat-info">
                        <h3><?php echo array_sum(array_column($customers, 'orders_count')); ?></h3>
                        <p>Total Orders</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-dollar-sign"></i>
                    </div>
                    <div class="stat-info">
                        <h3>$<?php echo number_format(array_sum(array_column($customers, 'total_spent')), 2); ?></h3>
                        <p>Total Revenue</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <div class="stat-info">
                        <h3>$<?php 
                            $activeCustomers = array_filter($customers, function($customer) {
                                return $customer['status'] === 'active' && $customer['orders_count'] > 0;
                            });
                            $avgSpent = count($activeCustomers) > 0 ? 
                                array_sum(array_column($activeCustomers, 'total_spent')) / count($activeCustomers) : 0;
                            echo number_format($avgSpent, 2);
                        ?></h3>
                        <p>Avg. Customer Value</p>
                    </div>
                </div>
            </div>

            <div class="search-box">
                <input type="text" placeholder="Search customers by name, email, or phone..." class="form-control">
                <button class="btn btn-primary">
                    <i class="fas fa-search"></i> Search
                </button>
            </div>

            <div class="filters">
                <div class="filter-group">
                    <label>Status:</label>
                    <select class="form-control">
                        <option value="">All Status</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                        <option value="new">New</option>
                    </select>
                </div>
                
                <div class="filter-group">
                    <label>Sort By:</label>
                    <select class="form-control">
                        <option value="newest">Newest First</option>
                        <option value="oldest">Oldest First</option>
                        <option value="orders">Most Orders</option>
                        <option value="spent">Highest Spent</option>
                    </select>
                </div>
            </div>

            <div class="admin-card">
                <div class="card-header">
                    <h2>All Customers (<?php echo count($customers); ?>)</h2>
                    <div class="card-actions">
                        <button class="btn btn-outline">
                            <i class="fas fa-download"></i> Export
                        </button>
                        <button class="btn btn-primary">
                            <i class="fas fa-plus"></i> Add Customer
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Customer</th>
                                <th>Contact</th>
                                <th>Join Date</th>
                                <th>Orders</th>
                                <th>Total Spent</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($customers as $customer): ?>
                            <tr>
                                <td>#<?php echo $customer['id']; ?></td>
                                <td>
                                    <strong><?php echo $customer['name']; ?></strong>
                                </td>
                                <td>
                                    <div><?php echo $customer['email']; ?></div>
                                    <small><?php echo $customer['phone']; ?></small>
                                </td>
                                <td><?php echo date('M j, Y', strtotime($customer['join_date'])); ?></td>
                                <td>
                                    <strong><?php echo $customer['orders_count']; ?></strong> orders
                                </td>
                                <td>
                                    <strong>$<?php echo number_format($customer['total_spent'], 2); ?></strong>
                                </td>
                                <td>
                                    <?php
                                    $statusClass = '';
                                    switch($customer['status']) {
                                        case 'active': $statusClass = 'status-active'; break;
                                        case 'inactive': $statusClass = 'status-inactive'; break;
                                        case 'new': $statusClass = 'status-new'; break;
                                        default: $statusClass = 'status-inactive';
                                    }
                                    ?>
                                    <span class="status-badge <?php echo $statusClass; ?>">
                                        <?php echo ucfirst($customer['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn btn-sm btn-outline" onclick="viewCustomer(<?php echo $customer['id']; ?>)">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        <button class="btn btn-sm btn-warning" onclick="editCustomer(<?php echo $customer['id']; ?>)">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                        <button class="btn btn-sm btn-danger" onclick="deleteCustomer(<?php echo $customer['id']; ?>)">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <div id="customerModal" class="modal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3>Customer Details</h3>
                        <span class="close">&times;</span>
                    </div>
                    <div class="modal-body">
                        <div id="customerDetails">
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <style>
    .status-new {
        background: #dbeafe;
        color: #1e40af;
        border: 1px solid #93c5fd;
    }

    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.5);
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 0;
        border-radius: 10px;
        width: 90%;
        max-width: 600px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.2);
    }

    .modal-header {
        padding: 20px 25px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        color: var(--dark);
    }

    .close {
        font-size: 1.5rem;
        cursor: pointer;
        color: var(--secondary);
    }

    .close:hover {
        color: var(--dark);
    }

    .modal-body {
        padding: 25px;
    }

    .customer-detail {
        margin-bottom: 15px;
        padding: 15px;
        background: #f8fafc;
        border-radius: 8px;
    }

    .customer-detail label {
        font-weight: 600;
        color: var(--dark);
        display: block;
        margin-bottom: 5px;
    }

    .customer-detail span {
        color: var(--secondary);
    }
    </style>

    <script>
    function viewCustomer(customerId) {
        const customerDetails = `
            <div class="customer-detail">
                <label>Customer ID:</label>
                <span>#${customerId}</span>
            </div>
            <div class="customer-detail">
                <label>Name:</label>
                <span>Customer Name ${customerId}</span>
            </div>
            <div class="customer-detail">
                <label>Email:</label>
                <span>customer${customerId}@gmail.com</span>
            </div>
            <div class="customer-detail">
                <label>Phone:</label>
                <span>+1 (555) 123-4567</span>
            </div>
            <div class="customer-detail">
                <label>Join Date:</label>
                <span>November 15, 2025</span>
            </div>
            <div class="customer-detail">
                <label>Total Orders:</label>
                <span>5 orders</span>
            </div>
            <div class="customer-detail">
                <label>Total Spent:</label>
                <span>$1,250.50</span>
            </div>
        `;
        
        document.getElementById('customerDetails').innerHTML = customerDetails;
        document.getElementById('customerModal').style.display = 'block';
    }

    function editCustomer(customerId) {
        alert('Edit customer: #' + customerId);
    }

    function deleteCustomer(customerId) {
        if (confirm('Are you sure you want to delete customer #' + customerId + '?')) {
            alert('Customer #' + customerId + ' deleted successfully!');
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('customerModal');
        const closeBtn = document.querySelector('.close');
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                modal.style.display = 'none';
            });
        }
        
        window.addEventListener('click', function(event) {
            if (event.target === modal) {
                modal.style.display = 'none';
            }
        });

        const searchInput = document.querySelector('.search-box input');
        const searchButton = document.querySelector('.search-box .btn');
        
        if (searchButton) {
            searchButton.addEventListener('click', function() {
                const searchTerm = searchInput.value.toLowerCase();
                alert('Searching for: ' + searchTerm);
            });
        }
    });
    </script>
</body>
</html>

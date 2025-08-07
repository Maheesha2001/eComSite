<?php
    include('../include/connect.php');
    include('../functions/common_functions.php');
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom style.css -->
    <link rel="stylesheet" href="../style.css">
    <style>
        .theme-green { color: #43a047 !important; }
        .btn-theme-green { background-color: #43a047 !important; border-color: #43a047 !important; color: #fff !important; }
        .btn-theme-green:hover { background-color: #388e3c !important; border-color: #388e3c !important; }
        a.theme-green-link { color: #43a047 !important; }
        a.theme-green-link:hover { color: #2e7031 !important; }
        
        .order-table {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .table-header {
            background: #e3f2fd;
            color: #1976d2;
        }
        
        .table-row {
            background: #424242;
            color: #fff;
        }
        
        .table-row:hover {
            background: #616161;
        }
        
        .btn-confirm {
            background: #4caf50;
            color: white;
            border: none;
            padding: 5px 15px;
            border-radius: 4px;
            text-decoration: none;
        }
        
        .btn-confirm:hover {
            background: #45a049;
            color: white;
        }
    </style>
</head>
<body style="background-color: #f8f9fa;">
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">
                <img src="../images/logo.png" alt="Logo" height="30" class="d-inline-block align-text-top">
                E-Commerce
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>
                </span>
                <a class="nav-link" href="../index.php">Home</a>
                <a class="nav-link" href="profile.php">Profile</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card order-table">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-list me-2"></i>Order Details
                        </h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-header">
                                    <tr>
                                        <th>Sl no</th>
                                        <th>Order number</th>
                                        <th>Amount Due</th>
                                        <th>Total products</th>
                                        <th>Invoice number</th>
                                        <th>Date</th>
                                        <th>Complete/Incomplete</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if(isset($_SESSION['username'])) {
                                        $username = $_SESSION['username'];
                                        $get_user = "SELECT * FROM user_table WHERE user_name='$username'";
                                        $result_user = mysqli_query($conn, $get_user);
                                        
                                        if($result_user && mysqli_num_rows($result_user) > 0) {
                                            $user_data = mysqli_fetch_array($result_user);
                                            $user_id = $user_data['user_id'];
                                            
                                            // Get all orders for this user
                                            $orders_query = "SELECT * FROM user_orders WHERE user_id=$user_id ORDER BY order_date DESC";
                                            $orders_result = mysqli_query($conn, $orders_query);
                                            
                                            $sl_no = 1;
                                            while($order = mysqli_fetch_array($orders_result)) {
                                                $order_id = $order['user_id'];
                                                $amount_due = $order['amount_due'];
                                                $total_products = $order['total_products'];
                                                $invoice_number = $order['invoice_number'];
                                                $order_date = $order['order_date'];
                                                $order_status = $order['order_status'];
                                                
                                                // Determine if order is complete or incomplete
                                                $completion_status = ($order_status == 'completed') ? 'Complete' : 'Incomplete';
                                                
                                                echo "<tr class='table-row'>";
                                                echo "<td>$sl_no</td>";
                                                echo "<td>$order_id</td>";
                                                echo "<td>LKR $amount_due</td>";
                                                echo "<td>$total_products</td>";
                                                echo "<td>$invoice_number</td>";
                                                echo "<td>" . date('Y-m-d H:i:s', strtotime($order_date)) . "</td>";
                                                echo "<td>$completion_status</td>";
                                                echo "<td>";
                                                if($order_status == 'pending') {
                                                    echo "<a href='confirm_order.php?order_id=$order_id' class='btn-confirm'>Confirm</a>";
                                                } else {
                                                    echo "<span class='badge bg-success'>Confirmed</span>";
                                                }
                                                echo "</td>";
                                                echo "</tr>";
                                                
                                                $sl_no++;
                                            }
                                            
                                            if($sl_no == 1) {
                                                echo "<tr><td colspan='8' class='text-center py-4'>No orders found</td></tr>";
                                            }
                                        }
                                    } else {
                                        echo "<tr><td colspan='8' class='text-center py-4'>Please login to view your orders</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                
                <!-- Back to Profile Button -->
                <div class="text-center mt-4">
                    <a href="profile.php" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Profile
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
<?php
// Show success message if payment was confirmed
if(isset($_GET['payment_success'])) {
    echo "<div class='alert alert-success text-center mb-4'>
            <i class='fas fa-check-circle me-2'></i>
            Payment confirmed successfully! Your order status has been updated.
          </div>";
}

// Get user orders from database
if(isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $get_user = "SELECT * FROM user_table WHERE user_name='$username'";
    $result_user = mysqli_query($conn, $get_user);
    
    if($result_user && mysqli_num_rows($result_user) > 0) {
        $user_data = mysqli_fetch_array($result_user);
        $user_id = $user_data['user_id'];
        
        // Get all user orders
        $orders_query = "SELECT * FROM user_orders WHERE user_id=$user_id ORDER BY order_date DESC";
        $orders_result = mysqli_query($conn, $orders_query);
        
        if(mysqli_num_rows($orders_result) > 0) {
            echo "<div class='card shadow-sm mb-4'>";
            echo "<div class='card-header bg-primary text-white'>";
            echo "<h5 class='mb-0'><i class='fas fa-list me-2'></i>My Orders</h5>";
            echo "</div>";
            echo "<div class='card-body p-0'>";
            echo "<div class='table-responsive'>";
            echo "<table class='table table-hover mb-0'>";
            echo "<thead class='table-primary'>";
            echo "<tr>";
            echo "<th>Sl no</th>";
            echo "<th>Amount Due</th>";
            echo "<th>Total products</th>";
            echo "<th>Invoice number</th>";
            echo "<th>Date</th>";
            echo "<th>Complete/Incomplete</th>";
            echo "<th>Status</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";
            
            $sl_no = 1;
            while($order = mysqli_fetch_array($orders_result)) {
                $status_class = $order['order_status'] == 'pending' ? 'text-warning' : 'text-success';
                $status_badge = $order['order_status'] == 'pending' ? 'bg-warning' : 'bg-success';
                
                echo "<tr>";
                echo "<td><strong>$sl_no</strong></td>";
                echo "<td><strong>LKR " . $order['amount_due'] . "</strong></td>";
                echo "<td>" . $order['total_products'] . "</td>";
                echo "<td><strong>#" . $order['invoice_number'] . "</strong></td>";
                echo "<td>" . date('Y-m-d H:i:s', strtotime($order['order_date'])) . "</td>";
                echo "<td><span class='badge " . ($order['order_status'] == 'pending' ? 'bg-warning' : 'bg-success') . "'>" . 
                     ($order['order_status'] == 'pending' ? 'Incomplete' : 'Complete') . "</span></td>";
                if($order['order_status'] == 'pending') {
                    echo "<td><a href='confirm_payment.php?order_id=" . $order['order_id'] . "' class='btn btn-sm btn-outline-primary'>Confirm</a></td>";
                } else {
                    echo "<td><span class='badge bg-success'>Paid</span></td>";
                }
                echo "</tr>";
                $sl_no++;
            }
            
            echo "</tbody>";
            echo "</table>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
        } else {
            echo "<div class='card shadow-sm mb-4'>";
            echo "<div class='card-body text-center py-4'>";
            echo "<i class='fas fa-shopping-bag text-muted mb-3' style='font-size: 3rem;'></i>";
            echo "<h5 class='text-muted'>No Orders Found</h5>";
            echo "<p class='text-muted'>You haven't placed any orders yet.</p>";
            echo "<a href='../index.php' class='btn btn-success'>Start Shopping</a>";
            echo "</div>";
            echo "</div>";
        }
    } else {
        echo "<div class='alert alert-warning text-center'>
                <i class='fas fa-exclamation-triangle me-2'></i>
                User not found
              </div>";
    }
} else {
    echo "<div class='alert alert-warning text-center'>
            <i class='fas fa-exclamation-triangle me-2'></i>
            Please login to view your orders
          </div>";
}
?>
<?php
// delete_account.php
if(isset($_POST['delete_account'])) {
    if(isset($_SESSION['username'])) {
        $username = $_SESSION['username'];
        
        // Get user data
        $get_user = "SELECT * FROM user_table WHERE user_name='$username'";
        $result_user = mysqli_query($conn, $get_user);
        
        if($result_user && mysqli_num_rows($result_user) > 0) {
            $user_data = mysqli_fetch_array($result_user);
            $user_id = $user_data['user_id'];

            // // Delete user's payments (before deleting orders!)
            // $delete_payments = "DELETE FROM user_payments WHERE order_id IN (SELECT order_id FROM user_orders WHERE user_id=$user_id)";
            // mysqli_query($conn, $delete_payments);

            // // Delete user's orders
            // $delete_orders = "DELETE FROM user_orders WHERE user_id=$user_id";
            // mysqli_query($conn, $delete_orders);

            // // Delete user's cart
            // $user_ip = $user_data['user_ip'];
            // $delete_cart = "DELETE FROM cart_details WHERE ip_address='$user_ip'";
            // mysqli_query($conn, $delete_cart);

            // // Delete pending orders
            // $delete_pending = "DELETE FROM orders_pending WHERE user_id=$user_id";
            // mysqli_query($conn, $delete_pending);

            // Delete profile image
            if(!empty($user_data['user_image']) && file_exists("user_images/" . $user_data['user_image'])) {
                unlink("user_images/" . $user_data['user_image']);
            }

            // Delete user
            $delete_user = "DELETE FROM user_table WHERE user_id=$user_id";
            if(mysqli_query($conn, $delete_user)) {
                session_destroy();
                echo "<script>alert('Account deleted successfully!'); window.location.href = '../index.php';</script>";
                exit();
            } else {
                $error_message = "Failed to delete account. Please try again.";
            }
        } else {
            $error_message = "User not found.";
        }
    } else {
        $error_message = "Please login to delete your account.";
    }
}
?>

<!-- Delete Account UI -->
<div class="card shadow-sm mb-4 p-4 text-center" style="border-left: 5px solid #dc3545;">
    <h3 class="text-danger mb-3"><i class="fas fa-user-times me-2"></i>Deleting Account</h3>

    <?php if(isset($error_message)): ?>
        <div class="alert alert-danger">
            <i class="fas fa-exclamation-triangle me-2"></i>
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>

    <p class="text-muted">
        <i class="fas fa-exclamation-triangle warning-icon" style="font-size: 3rem; color: #dc3545;"></i><br>
        This action cannot be undone. All your data including orders, payments, and profile information will be permanently deleted.
    </p>

    <form method="post" action="">
        <div class="d-grid gap-2 col-md-6 mx-auto">
            <button type="submit" name="delete_account" class="btn btn-danger"
                    onclick="return confirm('Are you absolutely sure you want to delete your account? This action cannot be undone.')">
                <i class="fas fa-trash me-2"></i>Delete Account
            </button>
            <a href="profile.php" class="btn btn-secondary">
                <i class="fas fa-times me-2"></i>Don't Delete
            </a>
        </div>
    </form>

    <div class="text-center mt-3">
        <small class="text-muted">
            <i class="fas fa-info-circle me-1"></i>You can always change your mind and keep your account
        </small>
    </div>
</div>

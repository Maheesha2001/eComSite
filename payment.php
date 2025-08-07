<?php
    include('./include/connect.php');
    include('./functions/common_functions.php');
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Portal</title>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom style.css -->
    <link rel="stylesheet" href="style.css">
    <style>
        .theme-green { color: #43a047 !important; }
        .btn-theme-green { background-color: #43a047 !important; border-color: #43a047 !important; color: #fff !important; }
        .btn-theme-green:hover { background-color: #388e3c !important; border-color: #388e3c !important; }
        .payment-card { transition: transform 0.2s; }
        .payment-card:hover { transform: translateY(-5px); }
        .payment-icon { font-size: 3rem; margin-bottom: 1rem; }
    </style>
</head>
<body style="background-color: #f8f9fa;">
    <!-- Navigation -->
    <?php
$user_ip = visitorIP(); // Use your existing function
$get_user = "SELECT * FROM user_table WHERE user_ip='$user_ip'";
$result = mysqli_query($conn, $get_user);
$run_query = mysqli_fetch_array($result);
$user_id = $run_query['user_id'];
?>

    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white text-center">
                        <h3><i class="fa fa-credit-card me-2"></i>Choose Payment Method</h3>
                    </div>
                    <div class="card-body p-4">
                        <!-- Order Summary -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h5 class="text-center mb-3">Order Summary</h5>
                                <div class="d-flex justify-content-between align-items-center p-3 bg-light rounded">
                                    <span><strong>Total Amount:</strong></span>
                                    <span class="h5 mb-0 theme-green">LKR<?php total_cart_price(); ?>/-</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Methods -->
                        <div class="row g-4">
                            <!-- PayPal Payment -->
                            <div class="col-md-6">
                                <div class="card payment-card h-100 border-2 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="payment-icon text-primary">
                                            <i class="fab fa-paypal"></i>
                                        </div>
                                        <h5 class="card-title">PayPal Payment</h5>
                                        <p class="card-text text-muted">Pay securely with your PayPal account</p>
                                        <img src="images/paypal.jpg" alt="PayPal" class="img-fluid mb-3" style="max-height: 60px;">
                                        <button class="btn btn-primary w-100" onclick="processPayPal()">
                                            <i class="fab fa-paypal me-2"></i>Pay with PayPal
                                        </button>
                                    </div>  
                                </div>
                            </div>

                            <!-- Offline Payment -->
                            <div class="col-md-6">
                                <div class="card payment-card h-100 border-2 shadow-sm">
                                    <div class="card-body text-center p-4">
                                        <div class="payment-icon text-success">
                                            <i class="fas fa-money-bill-wave"></i>
                                        </div>
                                        <h5 class="card-title">Offline Payment</h5>
                                        <p class="card-text text-muted">Pay on delivery or bank transfer</p>
                                        <div class="mb-3">
                                            <i class="fas fa-truck text-success me-2"></i>
                                            <small class="text-muted">Cash on Delivery Available</small>
                                        </div>
                                        <a href="order.php?user_id=<?php echo $user_id; ?>" class="btn btn-theme-green w-100">
                                            <i class="fas fa-shopping-cart me-2"></i>Place Order
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Back to Cart -->
                        <div class="text-center mt-4">
                            <a href="cart.php" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Cart
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function processPayPal() {
            // Redirect to PayPal homepage
            window.open('https://www.paypal.com/fr/home', '_blank');
        }
    </script>
</body>
</html>
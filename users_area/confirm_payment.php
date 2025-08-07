<?php
    include ('../include/connect.php');
    include('../functions/common_functions.php');
    session_start();
    
    if(isset($_GET['order_id'])){
        $order_id = $_GET['order_id'];
        
        // Get order details
        $order_query = "SELECT * FROM user_orders WHERE order_id=$order_id";
        $order_result = mysqli_query($conn, $order_query);
        
        if($order_result && mysqli_num_rows($order_result) > 0) {
            $order_data = mysqli_fetch_array($order_result);
            $invoice_number = $order_data['invoice_number'];
            $amount_due = $order_data['amount_due'];
            
            // Handle form submission
            if(isset($_POST['confirm_payment'])) {
                $payment_mode = $_POST['payment_mode'];
                
                // Insert into user_payments table
                $insert_payment = "INSERT INTO user_payments (order_id, invoice_number, amount, payment_mode, date) 
                                 VALUES (?, ?, ?, ?, NOW())";
                $stmt = mysqli_prepare($conn, $insert_payment);
                mysqli_stmt_bind_param($stmt, "iiis", $order_id, $invoice_number, $amount_due, $payment_mode);
                
                if(mysqli_stmt_execute($stmt)) {
                    // Update order status to complete
                    $update_order = "UPDATE user_orders SET order_status='complete' WHERE order_id=$order_id";
                    mysqli_query($conn, $update_order);
                    
                    // Redirect to profile with success message
                    echo "<script>
                        alert('Payment confirmed successfully!');
                        window.location.href = 'profile.php?my_orders&payment_success=1';
                    </script>";
                    exit();
                } else {
                    $error_message = "Failed to confirm payment. Please try again.";
                }
            }
        } else {
            $error_message = "Order not found.";
        }
    } else {
        $error_message = "No order ID provided.";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirm Payment</title>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom style.css -->
    <link rel="stylesheet" href="../style.css">
    <style>
        body {
            background-color: #343a40;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .payment-form-card {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            max-width: 500px;
            width: 100%;
        }
        
        .payment-header {
            background: linear-gradient(135deg, #007bff, #0056b3);
            color: white;
            border-radius: 15px 15px 0 0;
        }
        
        .form-control {
            border: 2px solid #e9ecef;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s ease;
        }
        
        .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 0 0.2rem rgba(0,123,255,0.25);
        }
        
        .btn-confirm {
            background: linear-gradient(135deg, #28a745, #20c997);
            border: none;
            border-radius: 10px;
            padding: 12px 30px;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-confirm:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(40,167,69,0.4);
        }
        
        .form-label {
            font-weight: 600;
            color: #495057;
            margin-bottom: 8px;
        }
        
        .alert {
            border-radius: 10px;
            border: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="payment-form-card">
                    <div class="payment-header text-center py-4">
                        <h3 class="mb-0">
                            <i class="fas fa-credit-card me-2"></i>Confirm Payment
                        </h3>
                    </div>
                    
                    <div class="card-body p-4">
                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger text-center">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <?php echo $error_message; ?>
                            </div>
                        <?php endif; ?>
                        
                        <form method="post" action="">
                            <div class="mb-4">
                                <label for="invoice_number" class="form-label">Invoice Number</label>
                                <input type="text" class="form-control" id="invoice_number" name="invoice_number" 
                                       value="<?php echo isset($invoice_number) ? $invoice_number : ''; ?>" readonly>
                            </div>
                            
                            <div class="mb-4">
                                <label for="amount" class="form-label">Amount</label>
                                <input type="text" class="form-control" id="amount" name="amount" 
                                       value="<?php echo isset($amount_due) ? 'LKR ' . $amount_due : ''; ?>" readonly>
                            </div>
                            
                            <div class="mb-4">
                                <label for="payment_mode" class="form-label">Select Payment Mode</label>
                                <select class="form-control" id="payment_mode" name="payment_mode" required>
                                    <option value="">Choose payment method...</option>
                                    <option value="Credit Card">Credit Card</option>
                                    <option value="Debit Card">Debit Card</option>
                                    <option value="PayPal">PayPal</option>
                                    <option value="Bank Transfer">Bank Transfer</option>
                                    <option value="Cash on Delivery">Cash on Delivery</option>
                                    <option value="Digital Wallet">Digital Wallet</option>
                                </select>
                            </div>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="confirm_payment" class="btn btn-confirm text-white">
                                    <i class="fas fa-check-circle me-2"></i>Confirm
                                </button>
                            </div>
                        </form>
                        
                        <div class="text-center mt-4">
                            <a href="profile.php?my_orders" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to Orders
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
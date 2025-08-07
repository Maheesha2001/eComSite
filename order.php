<?php
    include ('./include/connect.php');
    include('./functions/common_functions.php');
    

    if(isset($_GET['user_id'])){   
        $user_id = $_GET['user_id'];
    } else {
        // Get user_id from session or IP if not provided
        $user_ip = visitorIP();
        $get_user = "SELECT * FROM user_table WHERE user_ip='$user_ip'";
        $result = mysqli_query($conn, $get_user);
        if($result && mysqli_num_rows($result) > 0) {
            $run_query = mysqli_fetch_array($result);
            $user_id = $run_query['user_id'];
        } else {
            $user_id = null;
        }
    }
    
    $get_ip_address = visitorIP();
    $total_price = 0;
    $cart_query_price = "SELECT * FROM `cart_details` WHERE ip_address = '$get_ip_address'";
    $result_cart_price = mysqli_query($conn, $cart_query_price);
    $invoice_number = mt_rand();
    $status = 'pending';
    $count_products = mysqli_num_rows($result_cart_price);
    
    while($row_price = mysqli_fetch_assoc($result_cart_price)){
        $product_id = $row_price['product_id'];
        $quantity = $row_price['quantity']; // Get quantity for this specific product
        $select_product = "SELECT * FROM `products` WHERE product_id = $product_id";
        $result_product = mysqli_query($conn, $select_product);
        while($row_product_price = mysqli_fetch_assoc($result_product)){
            $product_price = $row_product_price['product_price'];
            $total_price += ($product_price * $quantity); // Multiply price by quantity for this product
        }
    }   

    // Use the correctly calculated total_price as subtotal
    $subtotal = $total_price;

    //insert order  
    $insert_orders = "INSERT INTO `user_orders` (user_id, amount_due, invoice_number, total_products, order_date, order_status) VALUES ($user_id, $subtotal, $invoice_number, $count_products, NOW(), '$status')";
    $result_query = mysqli_query($conn, $insert_orders);
    if($result_query){
        echo "<script>alert('Orders are submitted successfully')</script>";
        echo "<script>window.open('./users_area/profile.php', '_self')</script>";
    }

    //orders pending
    $insert_pending_orders = "INSERT INTO `orders_pending` (user_id, invoice_number, product_id, quantity, order_status) VALUES ($user_id, $invoice_number, $product_id, $quantity, '$status')";
    $result_pending_orders = mysqli_query($conn, $insert_pending_orders);
  
    //delete items from cart
    $empty_cart = "DELETE FROM `cart_details` WHERE ip_address = '$get_ip_address'";
    $result_delete = mysqli_query($conn, $empty_cart);
   
    ?>
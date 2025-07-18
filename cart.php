<?php
        include ('./include/connect.php');
        include('./functions/common_functions.php');
   ?>
   <!DOCTYPE html>     
    <head>
        <!-- Font Awesome CDN for cart icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8" />
        <title>Cart Details</title>
    </head>
    <body>

        <nav class="custom-navbar">
            <div style="margin:0px; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; gap:1.5em; align-items:center;">
                    <a href="index.php" style="display:flex; align-items:center;"><img src="images/logo.png" alt="Logo" class="logo"></a>
                    <a href="index.php">Home</a>
                    <a href="display_all.php">Products</a>
                    <a href="users_area/user_registration.php">Register</a>
                    <a href="#">Contact</a>
                    <a href="cart.php" style="font-size:1.2em;"><i class="fa fa-shopping-cart"></i><sup><?php cart_items();?></sup></a>
                 
                </div>
               
            </div>  
        </nav>
        <?php 
        cart();
        ?>
        <div class="inline-row">
    <p>Welcome guest</p>
    <a class="nav-link" href="./users_area/user_login.php">Login</a>
</div>
       <!-- cart table -->
        <form action="" method="post">
            <table class="table table-bordered text-center align-middle" style="margin: 2em auto; max-width: 900px; background: #fff;">
                <thead style="background: #e3f2fd;">
                  
<?php
global $conn;
$get_ip_add = visitorIP();
$total_price = 0;
$cart_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_add'";
$result = mysqli_query($conn, $cart_query);
$result_count = mysqli_num_rows($result);
if($result_count>0){
    echo "
      <tr>
                        <th>Product Title</th>
                        <th>Product Image</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Remove</th>
                        <th>Operations</th>
                    </tr>
                </thead>
                <tbody>
    ";
while($row = mysqli_fetch_array($result)){
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];
    $select_products = "SELECT * FROM products WHERE product_id='$product_id'";
    $result_products = mysqli_query($conn, $select_products);
    while($row_product_price = mysqli_fetch_array($result_products)){
        $price_table = $row_product_price['product_price'];
        $product_title = $row_product_price['product_title'];
        $product_image1 = $row_product_price['product_image1'];
        $total_price += $price_table * $quantity;
        ?>
        <tr>
            <td><?php echo $product_title ?></td>
            <td><img src='admin_area/images/<?php echo $product_image1 ?>' alt='<?php echo $product_title ?>' style='width:60px; height:60px; object-fit:contain;'></td>
            <td><input type='number' name='qty[<?php echo $product_id; ?>]' value='<?php echo $quantity; ?>' style='width:60px;'></td>
            <td><?php echo $price_table * $quantity ?></td>
            <td><input type='checkbox' name='removeitem[]' value='<?php echo $product_id; ?>'></td>
            <td>
                <input type='submit' value='Update Cart' class='btn btn-info btn-sm' style='color:#fff; text-transform:capitalize;' name='update_cart'>
                <input type='submit' value='Remove Item' class='btn btn-danger btn-sm' style='color:#fff; text-transform:capitalize;' name='remove_cart'/>
            </td>
        </tr>
        <?php
    }
}
}else{
    echo '
<div style="text-align:center; padding:3em 0;">
    <i class="fa fa-shopping-cart" style="font-size:3em; color:#bdbdbd;"></i>
    <h2 style="margin-top:0.5em; color:#03a9f4; font-size:2em; letter-spacing:1px;">Your Cart is Empty!</h2>
    <p style="color:#757575; font-size:1.1em;">Looks like you haven\'t added anything yet.</p>
    <a href="display_all.php" class="btn btn-primary" style="margin-top:1em;">Browse Products</a>
</div>
';
}
?>
                </tbody>
            </table>
        </form>

<?php
$get_ip_add = visitorIP();
if(isset($_POST['update_cart']) && isset($_POST['qty'])){
    foreach($_POST['qty'] as $product_id => $quantity){
        $product_id = intval($product_id);
        $quantity = intval($quantity);
        $update_cart = "UPDATE cart_details SET quantity=$quantity WHERE ip_address='$get_ip_add' AND product_id=$product_id";
        mysqli_query($conn, $update_cart);
    }
    // Optionally, reload the page to show updated values
    echo "<script>window.open('cart.php','_self');</script>";
}
?>
<!-- function to remove item -->
<?php
function remove_cart_item(){
    global $conn;
    if(isset($_POST['remove_cart'])){
        foreach($_POST['removeitem'] as $remove_id){
            $delete_query = "DELETE FROM cart_details WHERE product_id=$remove_id";
            $run_delete = mysqli_query($conn, $delete_query);
            if($run_delete){
                echo "<script>window.open('cart.php','_self');</script>";
            }
        }
    }
}

echo remove_cart_item();
?>

<?php
$get_ip_add = visitorIP();
$cart_query = "SELECT * FROM cart_details WHERE ip_address='$get_ip_add'";
$result = mysqli_query($conn, $cart_query);
$result_count = mysqli_num_rows($result);
if($result_count>0){
    echo "
<div style='max-width:900px; margin:0 auto; display:flex; align-items:center; justify-content:space-between; padding:1em 0;'>
    <div style='font-size:1.2em; font-weight:bold;'>Subtotal: <span style='color:#03a9f4;'>
$total_price/-</span></div>
    <div>
        <a href='index.php' class='btn btn-primary' style='margin-right:0.5em;'>Continue Shopping</a>
        <a href='checkout.php' class='btn btn-secondary'>Checkout</a>
    </div>
</div>";

} ?>
        <?php include './include/footer.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
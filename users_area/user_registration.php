<?php
        include ('../include/connect.php');
        include('../functions/common_functions.php');
   ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
    </style>
</head>
<body>
    <div class="container" style="max-width: 500px; margin: 3em auto; background: #fff; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.07); padding: 2em;">
        <h2 class="text-center mb-4 theme-green"><i class="fa fa-user-plus me-2"></i>Register</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="user_image" class="form-label">User Image</label>
                <input type="file" class="form-control" id="user_image" name="user_image" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="mb-3">
                <label for="address" class="form-label">Address</label>
                <input type="text" class="form-control" id="address" name="address" required>
            </div>
            <div class="mb-3">
                <label for="contact" class="form-label">Contact</label>
                <input type="text" class="form-control" id="contact" name="contact" required>
            </div>
            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-theme-green" name="register">Register</button>
            </div>
            <div class="text-center">
                <span>Already have an account? <a href="user_login.php" class="theme-green-link">Login</a></span>
            </div>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?php
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $address = trim($_POST['address']);
    $contact = trim($_POST['contact']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $user_image = $_FILES['user_image']['name'];
    $user_image_tmp = $_FILES['user_image']['tmp_name'];
    $user_ip = visitorIP();
    // Check for empty fields
    if (empty($username) || empty($email) || empty($address) || empty($contact) || empty($password) || empty($confirm_password) || empty($user_image)) {
        echo "<div class='alert alert-danger text-center'>All fields are required.</div>";
    } elseif ($password !== $confirm_password) {
        echo "<div class='alert alert-danger text-center'>Passwords do not match.</div>";
    } else {
        // Check for duplicate username or email
        $check_query = "SELECT * FROM user_table WHERE user_name=? OR user_email=?";
        $stmt = mysqli_prepare($conn, $check_query);
        mysqli_stmt_bind_param($stmt, "ss", $username, $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        if (mysqli_num_rows($result) > 0) {
            echo "<div class='alert alert-danger text-center'>Username or Email already exists.</div>";
        } else {
            // Hash the password
            $hash_password = password_hash($password, PASSWORD_DEFAULT);

            // Move uploaded image  
            $image_folder = "user_images";
            if (!is_dir($image_folder)) {
                mkdir($image_folder, 0777, true);
            }
            $image_path = $image_folder . "/" . basename($user_image);
            move_uploaded_file($user_image_tmp, $image_path);

            // Insert user
            $insert_query = "INSERT INTO user_table (user_name, user_email, user_password, user_image, user_ip, user_address, user_mobile) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($conn, $insert_query);
            mysqli_stmt_bind_param($stmt, "sssssss", $username, $email, $hash_password, $user_image, $user_ip, $address, $contact);
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                echo "<div class='alert alert-success text-center'>Registration successful! <a href='user_login.php' class='theme-green-link'>Login here</a>.</div>";
            } else {
                echo "<div class='alert alert-danger text-center'>Registration failed. Please try again.</div>";
            }
        }
    }

    // selecting cart items
    $select_cart_items="SELECT * FROM `cart_details` WHERE ip_address='$user_ip'";
    $result_cart=mysqli_query($conn,$select_cart_items);
    $rows_count=mysqli_num_rows($result_cart);
    if($rows_count>0){
        $_SESSION['username']=$username;
        echo "<script>alert('You have items in your cart')</script>";
        echo "<script>window.open('/eComSite/checkout.php','_self')</script>";
    }else{
        echo "<script>window.open('../index.php','_self')</script>";
    }
}
?>
</body>
</html>
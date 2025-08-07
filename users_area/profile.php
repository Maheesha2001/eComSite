<?php
         include ('../include/connect.php');
        include('../functions/common_functions.php');
        session_start();
   ?>
   <!DOCTYPE html>     
    <head>
        <!-- Font Awesome CDN for cart icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">
        <meta charset="UTF-8" />
        <title>My Store</title>
        <style>
            .theme-green { color: #43a047 !important; }
            .btn-theme-green { background-color: #43a047 !important; border-color: #43a047 !important; color: #fff !important; }
            .btn-theme-green:hover { background-color: #388e3c !important; border-color: #388e3c !important; }
            a.theme-green-link { color: #43a047 !important; }
            a.theme-green-link:hover { color: #2e7031 !important; }
            
            /* Sidebar Styling */
            .sidebar {
                background: #f8f9fa;
                min-height: 100vh;
                border-right: 1px solid #dee2e6;
            }
            
            .profile-header {
                border-radius: 0;
            }
            
            .profile-menu {
                background: #343a40;
                padding: 1rem 0;
            }
            
            .profile-menu .nav-link {
                color: #adb5bd !important;
                padding: 0.75rem 1.5rem;
                border: none;
                transition: all 0.3s ease;
            }
            
            .profile-menu .nav-link:hover {
                color: #fff !important;
                background-color: #495057;
            }
            
            .profile-menu .nav-link.active {
                color: #fff !important;
                background-color: #007bff;
            }
            
            .main-content-area {
                background: #fff;
                min-height: 100vh;
            }
        </style>
    </head>
    <body>

        <nav class="custom-navbar">
            <div style="margin:0px; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; gap:1.5em; align-items:center;">
                    <a href="index.php" style="display:flex; align-items:center;"><img src="../images/logo.png" alt="Logo" class="logo"></a>
                    <a href="../index.php">Home</a>
                    <a href="../display_all.php">Products</a>
                    <?php 
                        if(isset($_SESSION['username'])){
                            echo "<a href='users_area/profile.php'>My Account</a>";
                        } else {
                            echo "<a href='users_area/user_registration.php'>Register</a>";
                        }
                    ?>
                    <a href="#">Contact</a>
                    <a href="../cart.php" style="font-size:1.2em;"><i class="fa fa-shopping-cart"></i><sup><?php cart_items();?></sup></a>
                    <a href="#">Total Price <?php total_cart_price();?>/-</a>            
                </div>
                <form class="d-flex" role="search" action="../search_product.php" method="get">
                    <input class="form-control me-2" type="search" name="search-data" placeholder="Search" aria-label="Search" style="min-width:180px;">
                    <input type="submit" value="search" class="btn btn-outline-light" name="search-data-product">
                </form>
            </div>  
        </nav>
        <?php 
        cart();
        ?>
        <div class="row">
            <!-- Left Sidebar -->
            <div class="col-md-3 col-lg-2">
                <div class="sidebar">
                    <!-- Profile Header -->
                    <div class="profile-header bg-primary text-white text-center py-3">
                        <h5 class="mb-0">Your Profile</h5>
                    </div>
                    <?php
                    $username = $_SESSION['username'];
                    $get_user = "SELECT * FROM user_table WHERE user_name='$username'";
                    $result_user = mysqli_query($conn, $get_user);
                    $user_data = mysqli_fetch_array($result_user);
                    $user_image = $user_data['user_image'];
                    // <!-- Profile Picture -->
                    echo "
                        
                    <div class='profile-picture text-center py-4'>
                        <img src='./user_images/$user_image' alt='Profile Picture' class='rounded-circle' style='width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff; box-shadow: 0 2px 10px rgba(0,0,0,0.1);'>
                    </div>
                    ";
                    ?>
                   
                    
                    <!-- Navigation Menu -->
                    <div class="profile-menu">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php">
                                    <i class="fas fa-clock me-2"></i>Pending orders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php?edit_account">
                                    <i class="fas fa-user-edit me-2"></i>Edit Account
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php?my_orders">
                                    <i class="fas fa-list me-2"></i>My Orders
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="profile.php?delete_account">
                                    <i class="fas fa-trash me-2"></i>Delete Account
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="user_logout.php">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Main Content Area -->
            <div class="col-md-9 col-lg-10">
                <div class="main-content-area p-4">
                    <!-- Welcome Section -->
                    <div class="card shadow-sm mb-4">
                        <div class="card-body text-center py-4">
                            <h3 class="text-success mb-3">
                                <i class="fas fa-user-circle me-2"></i>Welcome, <?php echo isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest'; ?>!
                            </h3>
                            <p class="text-muted">Manage your orders and account settings here.</p>
                        </div>
                    </div>

                    <!-- Pending Orders Section -->
                    <div class="card shadow-sm mb-4">
                    <?php 
                        // <div class="card-header bg-primary text-white">
                        //     <h5 class="mb-0">
                        //         <i class="fas fa-clock me-2"></i>Order Status
                        //     </h5>
                        // </div>
                        //<div class="card-body p-4">
                           
                            get_user_order_details();
                            if(isset($_GET['edit_account'])){
                                include('edit_account.php');
                            }
                            if(isset($_GET['my_orders'])){
                                include('user_orders.php');
                            }
                            ?>
                            <!-- <?php
                            if(isset($_SESSION['username'])) {
                                $username = $_SESSION['username'];
                                $get_user = "SELECT * FROM user_table WHERE user_name='$username'";
                                $result_user = mysqli_query($conn, $get_user);
                                if($result_user && mysqli_num_rows($result_user) > 0) {
                                    $user_data = mysqli_fetch_array($result_user);
                                    $user_id = $user_data['user_id'];
                                    
                                    // Count pending orders
                                    $pending_query = "SELECT * FROM user_orders WHERE user_id=$user_id AND order_status='pending'";
                                    $pending_result = mysqli_query($conn, $pending_query);
                                    $pending_count = mysqli_num_rows($pending_result);
                                    
                                   
                                    // Show recent orders
                                    $recent_orders_query = "SELECT * FROM user_orders WHERE user_id=$user_id ORDER BY order_date DESC LIMIT 5";
                                    $recent_orders_result = mysqli_query($conn, $recent_orders_query);
                                    
                                    if(mysqli_num_rows($recent_orders_result) > 0) {
                                        echo "<h6 class='text-muted mb-3'>Recent Orders:</h6>";
                                        echo "<div class='table-responsive'>";
                                        echo "<table class='table table-hover'>";
                                        echo "<thead class='table-light'>";
                                        echo "<tr><th>Order ID</th><th>Amount</th><th>Date</th><th>Status</th></tr>";
                                        echo "</thead><tbody>";
                                        
                                        while($order = mysqli_fetch_array($recent_orders_result)) {
                                            $status_class = $order['order_status'] == 'pending' ? 'text-warning' : 'text-success';
                                            echo "<tr>";
                                            echo "<td><strong>#" . $order['invoice_number'] . "</strong></td>";
                                            echo "<td><strong>LKR" . $order['amount_due'] . "</strong></td>";
                                            echo "<td>" . date('d M Y', strtotime($order['order_date'])) . "</td>";
                                            echo "<td><span class='badge bg-warning'>" . ucfirst($order['order_status']) . "</span></td>";
                                            echo "</tr>";
                                        }
                                        
                                        echo "</tbody></table>";
                                        echo "</div>";
                                    }
                                }
                            } else {
                                echo "<div class='alert alert-warning text-center'>
                                        <i class='fas fa-exclamation-triangle me-2'></i>
                                        Please login to view your orders
                                      </div>";
                            }
                            ?> -->
                            
                            <div class="text-center mt-4">
                                <a href="order_details.php" class="btn btn-outline-primary">
                                    <i class="fas fa-list me-2"></i>View All Orders
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-shopping-bag text-success mb-3" style="font-size: 2.5rem;"></i>
                                    <h5 class="mb-3">Continue Shopping</h5>
                                    <a href="../index.php" class="btn btn-success">Browse Products</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card shadow-sm h-100">
                                <div class="card-body text-center p-4">
                                    <i class="fas fa-shopping-cart text-primary mb-3" style="font-size: 2.5rem;"></i>
                                    <h5 class="mb-3">View Cart</h5>
                                    <a href="../cart.php" class="btn btn-primary">Go to Cart</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php include '../include/footer.php'; ?>
                 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
         <script>
             // Force refresh profile image when coming from edit account
             if (window.location.search.includes('updated=1')) {
                 const profileImg = document.querySelector('.profile-picture img');
                 if (profileImg) {
                     const currentSrc = profileImg.src;
                     const separator = currentSrc.includes('?') ? '&' : '?';
                     profileImg.src = currentSrc + separator + 'refresh=' + Date.now();
                 }
                 
                 // Remove the updated parameter from URL to prevent multiple refreshes
                 setTimeout(function() {
                     const url = new URL(window.location);
                     url.searchParams.delete('updated');
                     window.history.replaceState({}, '', url);
                 }, 2000);
             }
         </script>
     </body>
     </html>
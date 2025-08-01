<?php
        include ('./include/connect.php');
        
   ?>
   <!DOCTYPE html>     
    <head>
        <!-- Font Awesome CDN for cart icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="style.css">
        <meta charset="UTF-8" />
        <title>Checkout Page</title>
    </head>
    <body>

        <nav class="custom-navbar">
            <div style="margin:0px; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; gap:1.5em; align-items:center;">
                    <a href="index.php" style="display:flex; align-items:center;"><img src="images/logo.png" alt="Logo" class="logo"></a>
                    <a href="index.php">Home</a>
                    <a href="display_all.php">Products</a>
                    <a href="#">Register</a>
                    <a href="#">Contact</a>

                </div>
                <form class="d-flex" role="search" action="search_product.php" method="get">
                    <input class="form-control me-2" type="search" name="search-data" placeholder="Search" aria-label="Search" style="min-width:180px;">
                    <input type="submit" value="search" class="btn btn-outline-light" name="search-data-product">
                </form>
            </div>  
        </nav>
        
        <div class="inline-row">
    <p>Welcome guest</p>
    <p>Login</p>
</div>
        <div class="main-content">
            <div class="products-grid">
                <?php  
                    if(!isset($_SESSION['username'])){
                        include('users_area/user_login.php');
                    } else {
                        include('payment.php');
                    }
                ?>    
            </div>
           
        </div>
        <?php include './include/footer.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
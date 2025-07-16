<!DOCTYPE html>     
    <head>
        <!-- Font Awesome CDN for cart icon -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="../style.css">
        <meta charset="UTF-8" />
        <title></title>
    </head>
    <body>

        <nav class="custom-navbar">
            <div style="margin:0px; display:flex; align-items:center; justify-content:space-between;">
                <div style="display:flex; gap:1.5em; align-items:center;">
                    <a href="index.php" style="display:flex; align-items:center;"><img src="../images/logo.png" alt="Logo" class="logo" style="height:32px; margin-right:0.75em;"></a>
                         
                </div>
                <div>
                    <p>WELCOME GUEST
                </div>
            </div>
        </nav>
        <div style="display:flex">
            <div class="admin-section">
                <div class="admin-section-header">
                    Manage Details
                </div>
                    <!-- Add more admin content here if needed -->
                <div class="admin-submenu">
                    <div class="admin-profile">
                        <img src="../images/admin.png" alt="Admin" />
                        <p>Admin Name</p>
                    </div>
                    <div class="admin-buttons">
                        <button><a href="insert_products.php">Insert Products</a></button>
                        <button><a href="#">View products</a></button>
                        <button><a href="index.php?insert_category">Insert Categories</a></button>
                        <button><a href="#">View Categories</a></button>
                        <button><a href="index.php?insert_brand">Insert Brands</a></button>
                        <button><a href="#">View Brands</a></button>
                        <button><a href="#">All orders</a></button>
                        <button><a href="#">All payments</a></button>
                        <button><a href="#">List users</a></button>
                        <button><a href="#">Logout</a></button>
                    </div>
                </div>
            </div>
            <div class="container">
                <!-- disokay the form here, when the button is clicked -->
                 <?php 
                    if(isset($_GET['insert_category'])){
                        include('insert_categories.php');
                    }
                    if(isset($_GET['insert_brand'])){
                        include('insert_brands.php');
                    }
                 ?>
            </div>
        </div>        

        <?php include '../include/footer.php'; ?>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    </body>
    </html>
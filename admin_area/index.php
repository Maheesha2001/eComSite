<?php 
 include ('../include/connect.php');
 include('../functions/common_functions.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   
    <style>
        footer.custom-footer {
    text-align: center;
    padding: 1em 0;
    background: #4caf50;
    color: #fff;
    width: 100%;
}
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            width: 250px;
            min-height: 100vh;
            background-color: #343a40;
            padding: 1.5rem 1rem;
        }
        .sidebar h4 {
            color: white;
            margin-bottom: 1rem;
            text-align: center;
        }
        .sidebar .admin-image {
            text-align: center;
            margin-bottom: 1rem;
        }
        .sidebar .admin-image img {
            width: 120px;
            border-radius: 50%;
        }
        .sidebar .nav-link {
            color: #adb5bd;
            margin: 0.25rem 0;
            font-weight: 500;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            color: white;
            background-color: #495057;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-success">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <img src="../images/logo.png" alt="Logo" style="height: 30px;">
            </a>
            <span class="navbar-text text-white">
                WELCOME GUEST
            </span>
        </div>
    </nav>

    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar">
            <h4>Manage Details</h4>
            <div class="admin-image">
                <img src="../images/admin.png" alt="Admin">
                <p class="text-white mt-2">Admin Name</p>
            </div>
            <nav class="nav flex-column">
                <a href="insert_products.php" class="nav-link"><i class="fas fa-plus-circle me-2"></i>Insert Products</a>
                <a href="index.php?view_products" class="nav-link"><i class="fas fa-eye me-2"></i>View Products</a>
                <a href="index.php?insert_category" class="nav-link"><i class="fas fa-folder-plus me-2"></i>Insert Categories</a>
                <a href="index.php?view_categories" class="nav-link"><i class="fas fa-folder-open me-2"></i>View Categories</a>
                <a href="index.php?insert_brand" class="nav-link"><i class="fas fa-tags me-2"></i>Insert Brands</a>
                <a href="index.php?view_brands" class="nav-link"><i class="fas fa-eye me-2"></i>View Brands</a>
                <a href="#" class="nav-link"><i class="fas fa-shopping-cart me-2"></i>All Orders</a>
                <a href="#" class="nav-link"><i class="fas fa-credit-card me-2"></i>All Payments</a>
                <a href="#" class="nav-link"><i class="fas fa-users me-2"></i>List Users</a>
                <a href="#" class="nav-link"><i class="fas fa-sign-out-alt me-2"></i>Logout</a>
            </nav>
        </div>

        <!-- Main Content -->
        <div class="container-fluid p-4">
            <?php 
                if(isset($_GET['insert_category'])){
                    include('insert_categories.php');
                }
                if(isset($_GET['insert_brand'])){
                    include('insert_brands.php');
                }
                if(isset($_GET['view_products'])){
                    include('view_products.php');
                }
                if(isset($_GET['edit_products'])){
                    include('edit_products.php');
                }
                if(isset($_GET['delete_products'])){
                    include('delete_products.php');
                }
                if(isset($_GET['view_categories'])){
                    include('view_categories.php');
                }
                if(isset($_GET['edit_categories'])){
                    include('edit_categories.php');
                }
                if(isset($_GET['delete_categories'])){
                    include('delete_categories.php');
                }
                if(isset($_GET['view_brands'])){
                    include('view_brands.php');
                }
                if(isset($_GET['edit_brands'])){
                    include('edit_brands.php');
                }
                if(isset($_GET['delete_brands'])){
                    include('delete_brands.php');
                }
            ?>
        </div>
    </div>

    <?php include '../include/footer.php'; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

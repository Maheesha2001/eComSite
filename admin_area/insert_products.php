<?php
    include ('../include/connect.php');

    if(isset($_POST['product_title'])){
        $product_title = mysqli_real_escape_string($conn, trim($_POST['product_title']));
        $product_description = mysqli_real_escape_string($conn, trim($_POST['product_description']));
        $product_keywords = mysqli_real_escape_string($conn, trim($_POST['product_keywords']));
        $product_category = intval($_POST['product_category']);
        $product_brand = intval($_POST['product_brand']);
        $product_price = floatval($_POST['product_price']);
        $product_status = 'true';

        // Handle images
        $img1 = $_FILES['product_image1']['name'];
        $img2 = $_FILES['product_image2']['name'];
        $img3 = $_FILES['product_image3']['name'];
        $tmp_img1 = $_FILES['product_image1']['tmp_name'];
        $tmp_img2 = $_FILES['product_image2']['tmp_name'];
        $tmp_img3 = $_FILES['product_image3']['tmp_name'];

        // check empty condition
        if(empty($product_title) || empty($product_description) || empty($product_keywords) ||
        empty($product_category) || empty($product_brand) || empty($product_price) || empty($img1)) {
            echo "<script>alert('Please fill all the required fields and upload at least the first image.')</script>";
        } else {
            $upload_dir = './images/';
            
            move_uploaded_file($tmp_img1, $upload_dir.$img1);
            if($img2) move_uploaded_file($tmp_img2, $upload_dir.$img2);
            if($img3) move_uploaded_file($tmp_img3, $upload_dir.$img3);

            $insert_query = "INSERT INTO products (product_title, product_description, product_keywords, 
            category_id, brand_id, product_image1, product_image2, product_image3, product_price, date, status)
            VALUES ('$product_title', '$product_description', '$product_keywords', $product_category, 
            $product_brand, '$img1', '$img2', '$img3', $product_price, NOW(), '$product_status')";
            $result = mysqli_query($conn, $insert_query);
            if($result){
                echo "<script>alert('Product has been inserted successfully')</script>";
            } else {
                echo "<script>alert('Error inserting product')</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Insert Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
</head>
<body>
    <div class="container" style="max-width: 550px; margin: 3em auto;">
        <h2 class="mb-4 text-center" style="color:#217a1b; font-weight:bold;">Insert Product</h2>
        <form action="" method="post" enctype="multipart/form-data" class="admin-form">
            <div class="mb-3">
                <label for="product_title" class="form-label">Product Title</label>
                <input type="text" class="form-control" id="product_title" name="product_title" required>
            </div>
            <div class="mb-3">
                <label for="product_description" class="form-label">Product Description</label>
                <textarea class="form-control" id="product_description" name="product_description" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="product_keywords" class="form-label">
                    Product Keywords <span style="font-weight:normal; color:#888;">(separate with commas)</span>
                </label>
                <input type="text" class="form-control" id="product_keywords" name="product_keywords" required placeholder="e.g. fresh,organic,fruit">
            </div>
            <div class="mb-3">
                <label for="product_category" class="form-label">Category</label>
                <select class="form-select" id="product_category" name="product_category" required>
                    <option value="">Select a category</option>
                    <?php
                        $cat_query = "SELECT * FROM categories";
                        $cat_result = mysqli_query($conn, $cat_query);
                        while($row = mysqli_fetch_assoc($cat_result)) {
                            echo '<option value="' . htmlspecialchars($row['category_id']) . '">' . htmlspecialchars($row['category_title']) . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="product_brand" class="form-label">Brand</label>
                <select class="form-select" id="product_brand" name="product_brand" required>
                    <option value="">Select a brand</option>
                    <?php 
                        $brand_query = "SELECT * FROM brands";
                        $brand_result = mysqli_query($conn, $brand_query);
                        while($row = mysqli_fetch_assoc($brand_result)) {
                            echo '<option value="' . htmlspecialchars($row['brand_id']) . '">' . htmlspecialchars($row['brand_title']) . '</option>';
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Product Image 1</label>
                <input type="file" class="form-control" name="product_image1" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Product Image 2</label>
                <input type="file" class="form-control" name="product_image2" accept="image/*">
            </div>
            <div class="mb-3">
                <label class="form-label">Product Image 3</label>
                <input type="file" class="form-control" name="product_image3" accept="image/*">
            </div>
            <div class="mb-3">
                <label for="product_price" class="form-label">Product Price</label>
                <input type="number" class="form-control" id="product_price" name="product_price" min="0" step="0.01" required>
            </div>
            <button type="submit" class="btn btn-success w-100">Insert Product</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 
<?php 
if (isset($_GET['edit_products'])) {
    $edit_id = $_GET['edit_products'];
    $get_data = "SELECT * FROM products WHERE product_id=$edit_id";
    $result = mysqli_query($conn, $get_data);
    $row = mysqli_fetch_assoc($result);

    // Extract product data
    $product_title = $row['product_title'];
    $product_description = $row['product_description'];
    $product_keywords = $row['product_keywords'];
    $product_category = $row['category_id'];
    $product_brand = $row['brand_id'];
    $product_image1 = $row['product_image1'];
    $product_image2 = $row['product_image2'];
    $product_image3 = $row['product_image3'];
    $product_price = $row['product_price'];

    // Get current category title
    $cat_query = "SELECT category_title FROM categories WHERE category_id = $product_category";
    $cat_result = mysqli_query($conn, $cat_query);
    $cat_row = mysqli_fetch_assoc($cat_result);
    $category_title = $cat_row['category_title'];

    // Get current brand title
    $brand_query = "SELECT brand_title FROM brands WHERE brand_id = $product_brand";
    $brand_result = mysqli_query($conn, $brand_query);
    $brand_row = mysqli_fetch_assoc($brand_result);
    $brand_title = $brand_row['brand_title'];
}
?>

<div class="container" style="max-width: 550px; margin: 3em auto;">
    <h2 class="mb-4 text-center" style="color:#217a1b; font-weight:bold;">Edit Product</h2>
    <form action="" method="post" enctype="multipart/form-data" class="admin-form">
        <div class="mb-3">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" class="form-control" id="product_title" name="product_title" required value="<?php echo htmlspecialchars($product_title); ?>">
        </div>
        <div class="mb-3">
            <label for="product_description" class="form-label">Product Description</label>
            <textarea class="form-control" id="product_description" name="product_description" rows="3" required><?php echo htmlspecialchars($product_description); ?></textarea>
        </div>
        <div class="mb-3">
            <label for="product_keywords" class="form-label">Product Keywords</label>
            <input type="text" class="form-control" id="product_keywords" name="product_keywords" required value="<?php echo htmlspecialchars($product_keywords); ?>">
        </div>
        <div class="mb-3">
            <label for="product_category" class="form-label">Category</label>
            <select class="form-select" id="product_category" name="product_category" required>
                <option value="<?php echo $product_category; ?>" selected><?php echo htmlspecialchars($category_title); ?></option>
                <?php
                $cat_query_all = "SELECT * FROM categories WHERE category_id != $product_category";
                $cat_result_all = mysqli_query($conn, $cat_query_all);
                while ($row = mysqli_fetch_assoc($cat_result_all)) {
                    echo '<option value="' . $row['category_id'] . '">' . htmlspecialchars($row['category_title']) . '</option>';
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="product_brand" class="form-label">Brand</label>
            <select class="form-select" id="product_brand" name="product_brand" required>
                <option value="<?php echo $product_brand; ?>" selected><?php echo htmlspecialchars($brand_title); ?></option>
                <?php
                $brand_query_all = "SELECT * FROM brands WHERE brand_id != $product_brand";
                $brand_result_all = mysqli_query($conn, $brand_query_all);
                while ($row = mysqli_fetch_assoc($brand_result_all)) {
                    echo '<option value="' . $row['brand_id'] . '">' . htmlspecialchars($row['brand_title']) . '</option>';
                }
                ?>
            </select>
        </div>
        <!-- Product Image 1 -->
        <div class="mb-3">
            <label class="form-label">Product Image 1</label><br>
            <?php if (!empty($product_image1)): ?>
                <a href="images/<?php echo $product_image1; ?>" target="_blank">
                    <img src="images/<?php echo $product_image1; ?>" alt="Image 1" width="100" style="margin-bottom: 10px;">
                </a><br>
            <?php endif; ?>
            <input type="file" class="form-control" name="product_image1" accept="image/*">
        </div>

        <!-- Product Image 2 -->
        <div class="mb-3">
            <label class="form-label">Product Image 2</label><br>
            <?php if (!empty($product_image2)): ?>
                <a href="images/<?php echo $product_image2; ?>" target="_blank">
                    <img src="images/<?php echo $product_image2; ?>" alt="Image 2" width="100" style="margin-bottom: 10px;">
                </a><br>
            <?php endif; ?>
            <input type="file" class="form-control" name="product_image2" accept="image/*">
        </div>

        <!-- Product Image 3 -->
        <div class="mb-3">
            <label class="form-label">Product Image 3</label><br>
            <?php if (!empty($product_image3)): ?>
                <a href="images/<?php echo $product_image3; ?>" target="_blank">
                    <img src="images/<?php echo $product_image3; ?>" alt="Image 3" width="100" style="margin-bottom: 10px;">
                </a><br>
            <?php endif; ?>
            <input type="file" class="form-control" name="product_image3" accept="image/*">
        </div>

        <div class="mb-3">
            <label for="product_price" class="form-label">Product Price</label>
            <input type="number" class="form-control" id="product_price" name="product_price" min="0" step="0.01" required value="<?php echo htmlspecialchars($product_price); ?>">
        </div>
        <button type="submit" class="btn btn-success w-100">Update Product</button>
        <a href="index.php?view_products" class="btn btn-info w-100">All Products</a>


    </form>
</div>



<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $product_title = mysqli_real_escape_string($conn, $_POST['product_title']);
    $product_description = mysqli_real_escape_string($conn, $_POST['product_description']);
    $product_keywords = mysqli_real_escape_string($conn, $_POST['product_keywords']);
    $product_category = (int) $_POST['product_category'];
    $product_brand = (int) $_POST['product_brand'];
    $product_price = (float) $_POST['product_price'];

    // Basic validation
    if (
        empty($product_title) || empty($product_description) || empty($product_keywords) ||
        empty($product_category) || empty($product_brand) || $product_price < 0
    ) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } else {
        // Image handling
        $update_image1 = $product_image1;
        $update_image2 = $product_image2;
        $update_image3 = $product_image3;

        if (isset($_FILES['product_image1']) && $_FILES['product_image1']['error'] === 0) {
            $update_image1 = $_FILES['product_image1']['name'];
            move_uploaded_file($_FILES['product_image1']['tmp_name'], "images/$update_image1");
        }

        if (isset($_FILES['product_image2']) && $_FILES['product_image2']['error'] === 0) {
            $update_image2 = $_FILES['product_image2']['name'];
            move_uploaded_file($_FILES['product_image2']['tmp_name'], "images/$update_image2");
        }

        if (isset($_FILES['product_image3']) && $_FILES['product_image3']['error'] === 0) {
            $update_image3 = $_FILES['product_image3']['name'];
            move_uploaded_file($_FILES['product_image3']['tmp_name'], "images/$update_image3");
        }

        // Update query
        $update_query = "UPDATE products SET 
            product_title = '$product_title',
            product_description = '$product_description',
            product_keywords = '$product_keywords',
            category_id = $product_category,
            brand_id = $product_brand,
            product_image1 = '$update_image1',
            product_image2 = '$update_image2',
            product_image3 = '$update_image3',
            product_price = $product_price,
            date = NOW()
            WHERE product_id = $edit_id";

        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "<script>alert('Product updated successfully.');</script>";
            echo "<script>window.location.href = 'index.php?view_products';</script>";
        } else {
            echo "<script>alert('Failed to update product.');</script>";
        }
    }
}
?>

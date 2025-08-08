<?php 
if (isset($_GET['edit_categories'])) {
    $edit_id = $_GET['edit_categories'];

    $get_data = "SELECT * FROM categories WHERE category_id=$edit_id";
    $result = mysqli_query($conn, $get_data);
    $row = mysqli_fetch_assoc($result);

    // Extract product data
    $category_title = $row['category_title'];
}
?>

<div class="container" style="max-width: 550px; margin: 3em auto;">
    <h2 class="mb-4 text-center" style="color:#217a1b; font-weight:bold;">Edit Category</h2>
    <form action="" method="post" enctype="multipart/form-data" class="admin-form">
        <div class="mb-3">
            <label for="category_title" class="form-label">Category Title</label>
            <input type="text" class="form-control" id="category_title" name="category_title" required value="<?php echo htmlspecialchars($category_title); ?>">
        </div>
       
       
        <button type="submit" class="btn btn-success w-100">Update Category</button>
        <a href="index.php?view_categories" class="btn btn-info w-100">All Categories</a>


    </form>
</div>



<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $category_title = mysqli_real_escape_string($conn, $_POST['category_title']);
   
    // Basic validation
    if (empty($category_title) ) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } else {
     
        // Update query
        $update_query = "UPDATE categories SET 
            category_title = '$category_title'
            WHERE category_id = $edit_id";

        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "<script>alert('Category updated successfully.');</script>";
            echo "<script>window.location.href = 'index.php?view_categories';</script>";
        } else {
            echo "<script>alert('Failed to update category.');</script>";
        }
    }
}
?>

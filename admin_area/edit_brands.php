<?php 
if (isset($_GET['edit_brands'])) {
    $edit_id = $_GET['edit_brands'];

    $get_data = "SELECT * FROM brands WHERE brand_id=$edit_id";
    $result = mysqli_query($conn, $get_data);
    $row = mysqli_fetch_assoc($result);

    // Extract product data
    $brand_title = $row['brand_title'];
}
?>

<div class="container" style="max-width: 550px; margin: 3em auto;">
    <h2 class="mb-4 text-center" style="color:#217a1b; font-weight:bold;">Edit brand</h2>
    <form action="" method="post" enctype="multipart/form-data" class="admin-form">
        <div class="mb-3">
            <label for="brand_title" class="form-label">brand Title</label>
            <input type="text" class="form-control" id="brand_title" name="brand_title" required value="<?php echo htmlspecialchars($brand_title); ?>">
        </div>
       
       
        <button type="submit" class="btn btn-success w-100">Update brand</button>
        <a href="index.php?view_brands" class="btn btn-info w-100">All brands</a>


    </form>
</div>



<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize inputs
    $brand_title = mysqli_real_escape_string($conn, $_POST['brand_title']);
   
    // Basic validation
    if (empty($brand_title) ) {
        echo "<script>alert('Please fill in all required fields.');</script>";
    } else {
     
        // Update query
        $update_query = "UPDATE brands SET 
            brand_title = '$brand_title'
            WHERE brand_id = $edit_id";

        $update_result = mysqli_query($conn, $update_query);

        if ($update_result) {
            echo "<script>alert('brand updated successfully.');</script>";
            echo "<script>window.location.href = 'index.php?view_brands';</script>";
        } else {
            echo "<script>alert('Failed to update brand.');</script>";
        }
    }
}
?>

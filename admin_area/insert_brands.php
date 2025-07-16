<?php 
    include ('../include/connect.php');
    if(isset($_POST['brand_name'])){
        $brand_name = ucfirst(strtolower(trim($_POST['brand_name'])));
        // Check if brand already exists
        $select_query = "SELECT * FROM brands WHERE brand_title='$brand_name'";
        $result_select = mysqli_query($conn, $select_query);
        $number = mysqli_num_rows($result_select);
        if($number > 0){
            echo "<script>alert('This brand already exists!')</script>";
        } else {
            $insert_query = "INSERT INTO brands (brand_title) VALUES ('$brand_name')";
            $result = mysqli_query($conn, $insert_query);
            if($result){
                echo "<script>alert('Brand has been inserted successfully')</script>";
            }
        }
    }
?>
<form action="" method="post" class="category-form">
    <h4>Insert Brand</h4>
    <div class="mb-3">
        <label for="brand_name" class="form-label">Brand Name</label>
        <input type="text" class="form-control" id="brand_name" name="brand_name" required>
    </div>
    <button type="submit" class="btn btn-success">Add Brand</button>
</form> 
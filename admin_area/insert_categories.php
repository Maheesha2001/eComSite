<?php 
    include ('../include/connect.php');
    if(isset($_POST['category_name'])){
        $category_name = ucfirst(strtolower(trim($_POST['category_name'])));
        // Check if brand already exists
        $select_query = "SELECT * FROM categories WHERE category_title='$category_name'";
        $result_select = mysqli_query($conn, $select_query);
        $number = mysqli_num_rows($result_select);
        if($number > 0){
            echo "<script>alert('This Category already exists!')</script>";
        } else {
            $insert_query = "INSERT INTO categories (category_title) VALUES ('$category_name')";
            $result = mysqli_query($conn, $insert_query);
            if($result){
                echo "<script>alert('Category has been inserted successfully')</script>";
            }
        }
    }
?>
<form action="" method="post" class="category-form">
    <h4>Insert Category</h4>
    <div class="mb-3">
        <label for="category_name" class="form-label">Category Name</label>
        <input type="text" class="form-control" id="category_name" name="category_name" required>
    </div>
    <button type="submit" class="btn btn-success">Add Category</button>
</form>



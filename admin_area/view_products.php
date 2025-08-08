<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">All Products</h3>
    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>Product ID</th>
                <th>Product Title</th>
                <th>Product Image</th>
                <th>Product Price</th>
                <th>Total Sold</th>
                <th>Status</th>
                <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $select_query = "SELECT * FROM products ORDER BY product_id";
        $result_query = mysqli_query($conn, $select_query);

        while($row = mysqli_fetch_assoc($result_query)) {
            $product_id = $row['product_id'];
            $product_title = $row['product_title'];
            $product_description = $row['product_description'];
            $product_image1 = $row['product_image1'];
            $product_price = $row['product_price'];
            $category_id = $row['category_id'];
            $brand_id = $row['brand_id'];
            $status = $row['status'];
        
            ?>


          
            <tr>
                <td><?php echo $product_id; ?></td>
                <td><?php echo $product_title;  ?></td>
                <td><img src='images/<?php echo $product_image1; ?>' width='80'></td>
                <td>Rs. <?php echo $product_price ?></td>
                <td>
                    <?php
                        $get_count="SELECT * FROM orders_pending WHERE product_id=$product_id";
                        $result_count=mysqli_query($conn, $get_count);
                        $rows_count=mysqli_num_rows($result_count);
                        echo $rows_count;
                    ?>
                </td>
                <td><?php echo $status;  ?></td>
                <td><a href='index.php?edit_products=<?php echo $product_id; ?>' class='btn btn-sm btn-primary'>Edit</a></td>
                <td><a href='index.php?delete_products=<?php echo $product_id; ?>' class='btn btn-sm btn-danger'>Delete</a></td>
            </tr>
            
            <?php } ?>
       
        </tbody>
    </table>
</div>
</body>
</html>
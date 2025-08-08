<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Products</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h3 class="mb-4">All brands</h3>
    <table class="table table-bordered table-hover text-center">
        <thead class="table-dark">
            <tr>
                <th>Slno</th>
                <th>brand Title</th>
                 <th>Edit</th>
                <th>Delete</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $select_query = "SELECT * FROM brands ORDER BY brand_id";
        $result_query = mysqli_query($conn, $select_query);

        while($row = mysqli_fetch_assoc($result_query)) {
            $brand_id = $row['brand_id'];
            $brand_title = $row['brand_title'];
            
            ?>


          
            <tr>
                <td><?php echo $brand_id; ?></td>
                <td><?php echo $brand_title;  ?></td>
             
                <td><a href='index.php?edit_brands=<?php echo $brand_id; ?>' class='btn btn-sm btn-primary'>Edit</a></td>
                <td><a href='index.php?delete_brands=<?php echo $brand_id; ?>' class='btn btn-sm btn-danger'>Delete</a></td>
            </tr>
            
            <?php } ?>
       
        </tbody>
    </table>
</div>
</body>
</html>
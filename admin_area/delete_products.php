<?php
// Delete product
if (isset($_GET['delete_products'])) {
    $delete_id = intval($_GET['delete_products']); // Safer to cast as integer
   
    $delete_query = "DELETE FROM products WHERE product_id = $delete_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>alert('Product deleted successfully');</script>";
        echo "<script>window.location.href='index.php?view_products';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete product');</script>";
    }
}
?>

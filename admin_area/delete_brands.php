<?php
// Delete brand          
if (isset($_GET['delete_brands'])) {
    $delete_id = intval($_GET['delete_brands']); // Safer to cast as integer
   
    $delete_query = "DELETE FROM brands WHERE brand_id = $delete_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>alert('brand deleted successfully');</script>";
        echo "<script>window.location.href='index.php?view_brands';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete brand');</script>";
    }
}
?>

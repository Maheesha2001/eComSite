<?php
// Delete category          
if (isset($_GET['delete_categories'])) {
    $delete_id = intval($_GET['delete_categories']); // Safer to cast as integer
   
    $delete_query = "DELETE FROM categories WHERE category_id = $delete_id";
    $delete_result = mysqli_query($conn, $delete_query);

    if ($delete_result) {
        echo "<script>alert('Category deleted successfully');</script>";
        echo "<script>window.location.href='index.php?view_categories';</script>";
        exit();
    } else {
        echo "<script>alert('Failed to delete category');</script>";
    }
}
?>

<?php
include 'db.php';

if (isset($_GET['id']) && isset($_GET['current_status'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $current = $_GET['current_status'];

    // Flip logic: Active -> Inactive OR Inactive -> Active
    $new_status = ($current == 'Active') ? 'Inactive' : 'Active';

    $sql = "UPDATE customers SET status = '$new_status' WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?msg=status_updated");
        exit();
    }
}
header("Location: index.php");
exit();
?>
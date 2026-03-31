<?php
include 'db.php';

// 1. Check if the 'id' parameter exists in the URL
if (isset($_GET['id'])) {
    // Sanitize the ID to prevent SQL Injection
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 2. Fetch the record first to identify the image file path
    $find_sql = "SELECT profile_image FROM customers WHERE id = $id";
    $result = mysqli_query($conn, $find_sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $image_path = $row['profile_image'];

        // 3. FILE CLEANUP: Remove the image from the server folder
        // We ensure we don't delete the 'default.png' placeholder
        if ($image_path != "uploads/default.png" && file_exists($image_path)) {
            unlink($image_path); // This physically deletes the file
        }

        // 4. DATABASE CLEANUP: Delete the row from MySQL
        $delete_sql = "DELETE FROM customers WHERE id = $id";

        if (mysqli_query($conn, $delete_sql)) {
            // Redirect back to index.php with a success message
            header("Location: index.php?msg=deleted");
            exit();
        } else {
            // If the SQL fails, show the error
            echo "Error deleting record: " . mysqli_error($conn);
        }
    } else {
        // If the ID doesn't exist in the database, just go back
        header("Location: index.php");
        exit();
    }
} else {
    // If no ID was provided at all, redirect to the dashboard
    header("Location: index.php");
    exit();
}
?>
<?php
// Database Configuration
$host = "localhost";      // Your database server (usually localhost)
$user = "root";           // Your database username (default is root)
$pass = "";               // Your database password (default is empty for XAMPP)
$dbname = "customer_db";  // The name of the database you created

// 1. Create the Connection
$conn = mysqli_connect($host, $user, $pass, $dbname);

// 2. Check Connection
if (!$conn) {
    // If connection fails, stop the script and show the error
    die("<div style='color:red; font-family:sans-serif;'>
            <h3>Database Connection Error!</h3>
            <p>Check if MySQL is running in XAMPP/WAMP.</p>
            <hr>
            Error: " . mysqli_connect_error() . "
         </div>");
}

// 3. Set Charset to UTF-8
// This ensures that special characters (like ñ or symbols) 
// are saved and displayed correctly in your system.
mysqli_set_charset($conn, "utf8mb4");

// Note: This file is included at the top of all your other PHP files.
?>
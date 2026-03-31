<?php
include 'db.php';

if (isset($_POST['submit'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $contact    = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $address    = mysqli_real_escape_string($conn, $_POST['address']);
    $status     = mysqli_real_escape_string($conn, $_POST['status']); // New

    $customer_code = "CUST-" . rand(1000, 9999);
    $final_image = "uploads/default.png"; 
    
    if (!empty($_FILES['profile_image']['name'])) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) { mkdir($target_dir, 0777, true); }

        $file_ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_file_name = time() . "_" . bin2hex(random_bytes(4)) . "." . $file_ext;
        $target_file = $target_dir . $new_file_name;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            $final_image = $target_file;
        }
    }

    $sql = "INSERT INTO customers (customer_code, first_name, last_name, email, contact_no, address, profile_image, status) 
            VALUES ('$customer_code', '$first_name', '$last_name', '$email', '$contact', '$address', '$final_image', '$status')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php?msg=added");
        exit();
    } else {
        $error_msg = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add New Customer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h4 class="mb-0">Register New Customer</h4>
                </div>
                <div class="card-body p-4">
                    <form action="add.php" method="POST" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">First Name</label>
                                <input type="text" name="first_name" class="form-control" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Last Name</label>
                                <input type="text" name="last_name" class="form-control" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Email</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Address</label>
                            <textarea name="address" class="form-control" rows="2" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">Contact</label>
                            <input type="text" name="contact_no" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold">Profile Picture</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" name="submit" class="btn btn-primary">Save Customer</button>
                            <a href="index.php" class="btn btn-outline-secondary">Back</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
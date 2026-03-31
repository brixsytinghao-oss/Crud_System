<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    $sql = "SELECT * FROM customers WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    if (!$row) { header("Location: index.php"); exit(); }
}

if (isset($_POST['update'])) {
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $last_name  = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email      = mysqli_real_escape_string($conn, $_POST['email']);
    $contact    = mysqli_real_escape_string($conn, $_POST['contact_no']);
    $address    = mysqli_real_escape_string($conn, $_POST['address']);
    $status     = mysqli_real_escape_string($conn, $_POST['status']); 
    
    $final_image = $row['profile_image']; 

    if (!empty($_FILES['profile_image']['name'])) {
        $file_ext = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION);
        $new_file_name = time() . "_" . bin2hex(random_bytes(4)) . "." . $file_ext;
        $target_file = "uploads/" . $new_file_name;

        if (move_uploaded_file($_FILES['profile_image']['tmp_name'], $target_file)) {
            if ($row['profile_image'] != "uploads/default.png" && file_exists($row['profile_image'])) {
                unlink($row['profile_image']);
            }
            $final_image = $target_file;
        }
    }

    $update_sql = "UPDATE customers SET 
                   first_name = '$first_name', last_name = '$last_name', 
                   email = '$email', contact_no = '$contact', 
                   address = '$address', profile_image = '$final_image',
                   status = '$status' 
                   WHERE id = $id";

    if (mysqli_query($conn, $update_sql)) {
        header("Location: index.php?msg=updated");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">Update Customer: <?php echo $row['customer_code']; ?></h4>
                </div>
                <div class="card-body p-4">
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="text-center mb-4">
                            <img src="<?php echo $row['profile_image']; ?>" width="120" height="120" class="rounded-circle border mb-2">
                            <input type="file" name="profile_image" class="form-control mx-auto" style="max-width: 300px;">
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">First Name</label>
                                <input type="text" name="first_name" class="form-control" value="<?php echo htmlspecialchars($row['first_name']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Last Name</label>
                                <input type="text" name="last_name" class="form-control" value="<?php echo htmlspecialchars($row['last_name']); ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Email</label>
                                <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="fw-bold">Contact Number</label>
                                <input type="text" name="contact_no" class="form-control" value="<?php echo htmlspecialchars($row['contact_no']); ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="fw-bold">Status</label>
                            <select name="status" class="form-select">
                                <option value="Active" <?php echo ($row['status'] == 'Active') ? 'selected' : ''; ?>>Active</option>
                                <option value="Inactive" <?php echo ($row['status'] == 'Inactive') ? 'selected' : ''; ?>>Inactive</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="fw-bold">Address</label>
                            <textarea name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($row['address']); ?></textarea>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" name="update" class="btn btn-warning fw-bold">Save Changes</button>
                            <a href="index.php" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
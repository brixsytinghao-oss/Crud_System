<?php
include 'db.php';

// 1. Get the ID from URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // 2. Fetch customer data
    $sql = "SELECT * FROM customers WHERE id = $id";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Redirect if customer doesn't exist
    if (!$row) {
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Profile - <?php echo $row['first_name']; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-card-img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 5px solid #fff;
        }
        .info-label {
            font-weight: bold;
            color: #6c757d;
            text-transform: uppercase;
            font-size: 0.8rem;
        }
    </style>
</head>
<body class="bg-light">

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0 overflow-hidden">
                <div class="bg-primary py-5 text-center">
                    <img src="<?php echo $row['profile_image']; ?>" 
                         class="rounded-circle profile-card-img shadow-sm" 
                         alt="Profile Picture">
                </div>
                
                <div class="card-body p-4 pt-5 text-center">
                    <h3 class="mb-1"><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></h3>
                    <span class="badge bg-light text-primary border mb-4"><?php echo $row['customer_code']; ?></span>
                    
                    <hr>
                    
                    <div class="row text-start mt-4">
                        <div class="col-sm-6 mb-3">
                            <div class="info-label">Email Address</div>
                            <div class="fw-bold"><?php echo htmlspecialchars($row['email']); ?></div>
                        </div>
                        <div class="col-sm-6 mb-3">
                            <div class="info-label">Contact Number</div>
                            <div class="fw-bold"><?php echo htmlspecialchars($row['contact_no']); ?></div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="info-label">Home Address</div>
                            <div class="fw-bold"><?php echo nl2br(htmlspecialchars($row['address'])); ?></div>
                        </div>
                    </div>
                </div>

                <div class="card-footer bg-white p-3 d-flex justify-content-between">
                    <a href="index.php" class="btn btn-outline-secondary">Back to List</a>
                    <div>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-warning">Edit Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
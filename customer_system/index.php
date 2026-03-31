<?php 
include 'db.php'; 
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';

// Search logic includes First Name, Last Name, Email, Code, and Contact Number
$query = "SELECT * FROM customers WHERE 
          first_name LIKE '%$search%' OR 
          last_name LIKE '%$search%' OR 
          email LIKE '%$search%' OR 
          customer_code LIKE '%$search%' OR
          contact_no LIKE '%$search%'
          ORDER BY id DESC";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Customer System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-img { width: 45px; height: 45px; object-fit: cover; border-radius: 50%; }
        .status-toggle { text-decoration: none; display: inline-block; transition: 0.1s; }
        .status-toggle:hover { transform: scale(1.05); }
    </style>
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Customer Database</h2>
        <a href="add.php" class="btn btn-success">+ Add New Customer</a>
    </div>

    <?php if(isset($_GET['msg'])): ?>
        <div id="greeting-alert" class="alert alert-primary alert-dismissible fade show" role="alert">
            <strong>Notification:</strong> 
            <?php 
                if($_GET['msg'] == 'added') echo "Customer added successfully!";
                elseif($_GET['msg'] == 'updated') echo "Profile updated successfully!";
                elseif($_GET['msg'] == 'deleted') echo "Record deleted successfully!";
                elseif($_GET['msg'] == 'status_updated') echo "Status changed successfully!";
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <form action="" method="GET" class="mb-4">
        <div class="input-group">
            <input type="text" name="search" class="form-control" placeholder="Search customers..." value="<?php echo htmlspecialchars($search); ?>">
            <button class="btn btn-primary">Search</button>
        </div>
    </form>

    <div class="table-responsive shadow-sm">
        <table class="table table-hover bg-white align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Photo</th>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Email</th> <th>Contact</th>
                    <th>Status</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><img src="<?php echo $row['profile_image']; ?>" class="profile-img border"></td>
                    <td><?php echo $row['customer_code']; ?></td>
                    <td><?php echo htmlspecialchars($row['first_name'] . " " . $row['last_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td> <td><?php echo htmlspecialchars($row['contact_no']); ?></td>
                    <td>
                        <a href="toggle_status.php?id=<?php echo $row['id']; ?>&current_status=<?php echo $row['status']; ?>" class="status-toggle">
                            <span class="badge rounded-pill <?php echo ($row['status'] == 'Active') ? 'bg-success' : 'bg-secondary'; ?>">
                                <?php echo $row['status']; ?>
                            </span>
                        </a>
                    </td>
                    <td class="text-center">
                        <a href="view.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-primary">View</a>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-warning">Edit</a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" 
                           class="btn btn-sm btn-outline-danger" 
                           onclick="return confirm('Are you sure do you want to delete this Customer?')">
                           Delete
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const alert = document.getElementById('greeting-alert');
        if (alert) {
            setTimeout(function() {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 2500); 
        }
    });
</script>

</body>
</html>
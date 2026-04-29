<?php
session_start();
include '../includes/db.php';

// Check if admin is logged in
if(!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true){
    header('location:admin.php');
    exit();
}

$msg = "";

// Handle Approval
if(isset($_POST['approve'])){
    $id = (int)$_POST['id'];
    // Fetch user details
    $res = mysqli_query($con, "SELECT * FROM `pending_users` WHERE id=$id");
    if($row = mysqli_fetch_assoc($res)){
        $user = mysqli_real_escape_string($con, $row['user']);
        $password = mysqli_real_escape_string($con, $row['password']);
        $role = mysqli_real_escape_string($con, $row['role']);
        
        // Insert into loginform
        $insert = "INSERT INTO `loginform` (user, password, role) VALUES ('$user', '$password', '$role')";
        if(mysqli_query($con, $insert)){
            // Delete from pending
            mysqli_query($con, "DELETE FROM `pending_users` WHERE id=$id");
            $msg = "<div class='alert alert-success'>Successfully approved $role account for <strong>$user</strong>.</div>";
        } else {
            $msg = "<div class='alert alert-danger'>Error approving account.</div>";
        }
    }
}

// Handle Rejection
if(isset($_POST['reject'])){
    $id = (int)$_POST['id'];
    if(mysqli_query($con, "DELETE FROM `pending_users` WHERE id=$id")){
        $msg = "<div class='alert alert-success'>Successfully rejected and deleted the request.</div>";
    } else {
        $msg = "<div class='alert alert-danger'>Error rejecting account.</div>";
    }
}

// Handle Logout
if(isset($_GET['logout'])){
    session_destroy();
    header('location:admin.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Admin Dashboard - Library Zone</title>
</head>
<body class="bg-light">
    <?php include '../includes/navbar.php'; ?>

    <div class="container mt-5">
        <h2 class="mb-4">Pending Registrations</h2>
        <?php echo $msg; ?>
        
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <table class="table table-striped table-hover m-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Username</th>
                            <th>Requested Role</th>
                            <th class="text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $pending_res = mysqli_query($con, "SELECT * FROM `pending_users`");
                        if(mysqli_num_rows($pending_res) > 0){
                            while($row = mysqli_fetch_assoc($pending_res)){
                                echo "<tr>";
                                echo "<td>" . $row['id'] . "</td>";
                                echo "<td><strong>" . htmlspecialchars($row['user']) . "</strong></td>";
                                echo "<td><span class='badge badge-info p-2'>" . strtoupper(htmlspecialchars($row['role'])) . "</span></td>";
                                echo "<td class='text-center'>
                                        <form method='post' class='d-inline'>
                                            <input type='hidden' name='id' value='" . $row['id'] . "'>
                                            <button type='submit' name='approve' class='btn btn-sm btn-success mr-2'>Approve</button>
                                            <button type='submit' name='reject' class='btn btn-sm btn-danger'>Reject</button>
                                        </form>
                                      </td>";
                                echo "</tr>";
                            }
                        } else {
                            echo "<tr><td colspan='4' class='text-center p-4'>No pending registrations requiring approval.</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

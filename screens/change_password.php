<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$username = $_SESSION['username'];
$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';

$message = '';
$message_type = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify current password
    $stmt = $con->prepare("SELECT * FROM `loginform` WHERE user = ? AND password = ? LIMIT 1");
    $stmt->bind_param("ss", $username, $current_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        if ($new_password === $confirm_password) {
            if (strlen($new_password) >= 6) {
                // Update password
                $update_stmt = $con->prepare("UPDATE `loginform` SET password = ? WHERE user = ?");
                $update_stmt->bind_param("ss", $new_password, $username);
                
                if ($update_stmt->execute()) {
                    $message = "Password updated successfully!";
                    $message_type = "success";
                } else {
                    $message = "Error updating password. Please try again.";
                    $message_type = "danger";
                }
            } else {
                $message = "New password must be at least 6 characters long.";
                $message_type = "warning";
            }
        } else {
            $message = "New passwords do not match.";
            $message_type = "danger";
        }
    } else {
        $message = "Incorrect current password.";
        $message_type = "danger";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Change Password - Library Zone</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body class="bg-light">
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
        <a class="navbar-brand" href="<?php echo ($role === 'faculty') ? 'staff.php' : (($role === 'librarian') ? 'librarian.php' : 'home.php'); ?>">
            <h6 class="m-0"><b style="color: white;">WELCOME TO LIBRARY <span style="color: rgb(236, 134, 17)">ZONE</span></b></h6>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link text-white font-weight-bold" href="<?php echo ($role === 'faculty') ? 'staff.php' : (($role === 'librarian') ? 'librarian.php' : 'home.php'); ?>">
                        <i class="fas fa-arrow-left"></i> Back to Dashboard
                    </a>
                </li>
            </ul>
            
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white font-weight-bold" href="#" id="navbarDropdown" role="button" data-toggle="dropdown">
                        <i class="fas fa-user-circle"></i> Welcome, <?php echo htmlspecialchars($username); ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="change_password.php">Change Password</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item text-danger" href="../scripts/logout.php">Logout</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Change Password Form -->
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-dark text-white">
                        <h4 class="mb-0"><i class="fas fa-key"></i> Change Password</h4>
                    </div>
                    <div class="card-body p-4">
                        <?php if(!empty($message)): ?>
                            <div class="alert alert-<?php echo $message_type; ?> alert-dismissible fade show">
                                <?php echo htmlspecialchars($message); ?>
                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                            </div>
                        <?php endif; ?>

                        <form method="post" action="change_password.php">
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-secondary">Current Password</label>
                                <input type="password" name="current_password" class="form-control form-control-lg" required placeholder="Enter current password">
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-secondary">New Password</label>
                                <input type="password" name="new_password" class="form-control form-control-lg" required placeholder="Enter new password">
                            </div>
                            
                            <div class="form-group mb-4">
                                <label class="font-weight-bold text-secondary">Confirm New Password</label>
                                <input type="password" name="confirm_password" class="form-control form-control-lg" required placeholder="Re-enter new password">
                            </div>
                            
                            <button type="submit" class="btn btn-primary btn-lg btn-block font-weight-bold mt-4">
                                Update Password
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
</body>
</html>

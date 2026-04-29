<?php
session_start();

$role = isset($_SESSION['role']) ? $_SESSION['role'] : '';
// If admin was logged in (which might use a different session key sometimes)
$is_admin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

session_unset();
session_destroy();

// Redirect based on role
if ($is_admin) {
    header("Location: ../screens/admin.php");
} elseif ($role === 'faculty') {
    header("Location: ../screens/faculty.php");
} elseif ($role === 'librarian') {
    header("Location: ../screens/sample.php");
} else {
    header("Location: ../screens/home.php");
}
exit();
?>

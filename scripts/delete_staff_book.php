<?php
session_start();
include '../includes/db.php';

if (!isset($_SESSION['username'])) {
    header("Location: sample.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($con, $_GET['id']);
    
    $query = "DELETE FROM books WHERE id = '$id'";
    
    if (mysqli_query($con, $query)) {
        header("Location: ../screens/librarian.php?msg=Staff record deleted successfully");
    } else {
        header("Location: ../screens/librarian.php?msg=Error deleting record");
    }
} else {
    header("Location: ../screens/librarian.php");
}
?>

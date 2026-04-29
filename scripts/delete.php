<?php

include '../includes/db.php';

$id = $_GET['id'];

$q = "   DELETE FROM `bookdata` WHERE id = $id   ";

mysqli_query($con,$q);

header('location:../screens/librarian.php');

?>
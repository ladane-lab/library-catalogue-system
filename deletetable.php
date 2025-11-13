<?php

include 'conn.php';

echo '<script>alert("registration completed Successfully!")</script>';
$q = "   DELETE FROM `new`";

mysqli_query($con,$q);

header('location:librarian.php');

?>
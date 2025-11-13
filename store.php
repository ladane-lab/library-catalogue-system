<?php
include 'conn.php';

if(isset($_POST['done'])){
    $id = $_GET['id'];
    $name = $_POST['name'];
    $author = $_POST['author'];
    $publication = $_POST['publication'];
    $edition = $_POST['edition'];
    $class = $_POST['class'];
    $sem = $_POST['sem'];

    //$q = "insert into 'crudtable'('username','password') VALUES ( '$username', '$password');"
    //$q = "INSERT INTO `bookdata` (`name`, `author`, 'publication', 'edition') VALUES ('$name', '$author', '$publication', '$edition')";
    $q = "   INSERT INTO `bookdata`(`id`, `name`, `author`, `publication`, `edition`, `class`, `sem`) VALUES ('$id','$name','$author','$publication','$edition','$class','$sem')   ";
    $query = mysqli_query($con, $q);

    header('location:librarian.php');

}
?>
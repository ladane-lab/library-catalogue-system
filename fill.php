<?php
include 'conn.php';

if(isset($_POST['submit'])){
    $isbn = $_POST['isbn'];
    $author = $_POST['author'];
    $title = $_POST['title'];
    $edn = $_POST['edn'];
    $price = $_POST['price'];
    $edition = $_POST['edition'];
    $qty = $_POST['qty'];
    $yop = $_POST['yop'];

    //$q = "insert into 'crudtable'('username','password') VALUES ( '$username', '$password');"
   // $q = "INSERT INTO `new` (`isbn`, `author`,'title','edn','price','edition','qty','yop') 
   // VALUES ('$isbn', '$author','$title','$edn','$price','$edition','$qty','$yop')";
   $q = "INSERT INTO `new`(`isbn`, `author`, `title`, `edn`, `price`, `edition`, `qty`, `yop`) VALUES ('$isbn', '$author','$title','$edn','$price','$edition','$qty','$yop')";

    $query = mysqli_query($con, $q);
    header('location:filldata.php');

}
?>
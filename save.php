<?php

include 'conn.php';

if(isset($_POST['submit'])){
    
    $datas=$_POST['data'];
   /*$isbn = $_POST['isbn'];
    $author = $_POST['author'];
    $title = $_POST['title'];
    $edn = $_POST['edn'];
    $price = $_POST['price'];
    $edition = $_POST['edition'];
    $qty = $_POST['qty'];
    $yop = $_POST['yop'];*/
    echo $datas;

    $q = "INSERT INTO `books`(`isbn`, `author`, `title`, `edn`, `price`, `edition`, `qty`, `yop`) VALUES ('$isbn', '$author','$title','$edn','$price','$edition','$qty','$yop')";

    $query_run = mysqli_query($con, $q);
    
    if($query_run)
    {
        $_SESSION['status'] = "inserted successfully";
        echo "data stored successfully";

        
    }
   
    
        
}
else{
    header('location:staff.php');
}
   



?>
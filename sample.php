<?php
include 'conn.php';

if(isset($_POST['username'])){
  $user = $_POST['username'];
  $password = $_POST['password'];

  $sql=" SELECT * FROM `loginform` WHERE user='".$user."' AND  password='".$password."'
  limit 1 ";
  
  $result=mysqli_query($con,$sql);
  
  if(mysqli_num_rows($result)==1){
    
    header('location:librarian.php');
    exit();

  }
  else{
    echo "You Have Entered Incorrect Username/Password";
    exit();
  }
}

?>


<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Hello, world!</title>
  </head>
  <body>
    <div class="header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    
    

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="right-side">
    <a class="navbar-brand mx-auto" href="index.php">Home |</a>
      <a class="navbar-brand mx-auto" href="student.php">Student |</a>
      <a class="navbar-brand mx-auto" href="sample2.php">Staff |</a>
      <a class="navbar-brand mx-auto" href="sample.php">Librarian</a>
    </ul>
 
    
  </div>
  <h6><b style="color: white ">WELCOME TO LIBRARY   </br> <b style="color: rgb(236, 134, 17)"> ZONE</b></h6>
   <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  
</nav>
<section class="header">
  <div class="register-wrapper">
      <div class="register-block">
        <h3 class="register-title">Log in Into Library</h3>

        <form method="post" action="#">
          <input type="text" name="username" placeholder="Enter Your Username" />
          <input type="password" name="password" placeholder=" Enter  Your Password" />
          <input type="submit" name="submit" placeholder="Log in" />

        </form>

      </div>
  </div>
</section>

   

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>
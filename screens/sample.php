<?php
session_start();
include '../includes/db.php';

if(isset($_POST['username'])){
  $user = $_POST['username'];
  $password = $_POST['password'];

  $sql=" SELECT * FROM `loginform` WHERE user='".$user."' AND  password='".$password."' AND role='librarian' limit 1 ";
  
  $result=mysqli_query($con,$sql);
  
  if(mysqli_num_rows($result)==1){
    $_SESSION['username'] = $user;
    $_SESSION['role'] = 'librarian';
    header('location:librarian.php');
    exit();

  }
  else{
    $login_error = "You Have Entered Incorrect Username/Password";
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
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Hello, world!</title>
  </head>
  <body>
    <div class="header">
    <?php include '../includes/navbar.php'; ?>
<section class="header">
  <div class="register-wrapper">
      <div class="register-block">
        <h3 class="register-title">Log in Into Library</h3>
        <?php if(isset($login_error)): ?>
            <div class="alert alert-danger p-2 mb-3" style="font-size: 14px;"><?php echo $login_error; ?></div>
        <?php endif; ?>
        <form method="post" action="#">
          <input type="text" name="username" placeholder="Enter Your Username" />
          <input type="password" name="password" placeholder=" Enter  Your Password" />
          <input type="submit" name="submit" value="Log in" />
          <p style="text-align: center; margin-top: 20px; font-size: 14px;">
              <a href="librarian_signup.php" style="color: #666; font-size: 14px; padding-top: 0; text-shadow: none; font-family: Arial, sans-serif;">New Librarian? Sign Up here</a>
          </p>
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
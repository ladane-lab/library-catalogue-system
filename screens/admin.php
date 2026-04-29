<?php
session_start();

if(isset($_POST['submit'])){
  $user = $_POST['username'];
  $password = $_POST['password'];

  // Hardcoded Admin Credentials
  if($user === 'admin' && $password === 'admin123'){
    $_SESSION['admin_logged_in'] = true;
    header('location:admin_dashboard.php');
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
    <title>Admin Login</title>
  </head>
  <body>
    <div class="header">
    <?php include '../includes/navbar.php'; ?>

<section class="header">
  <div class="register-wrapper">
      <div class="register-block">
        <h3 class="register-title text-danger">Super Admin Login</h3>
        <?php if(isset($login_error)): ?>
            <div class="alert alert-danger p-2 mb-3" style="font-size: 14px;"><?php echo $login_error; ?></div>
        <?php endif; ?>
        <form method="post" action="admin.php">
          <input type="text" name="username" placeholder="Admin Username" required />
          <input type="password" name="password" placeholder="Admin Password" required />
          <input type="submit" name="submit" value="Log in" />
        </form>
      </div>
  </div>
</section>

    <!-- Optional JavaScript -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.7/dist/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>

<?php
include 'conn.php';

$error = '';
$success = '';

if(isset($_POST['submit'])){
  $user = mysqli_real_escape_string($con, $_POST['username']);
  $password = mysqli_real_escape_string($con, $_POST['password']);
  
  if(empty($user) || empty($password)){
      $error = "Please fill in all fields.";
  } else {
      // Check if username exists in either table
      $check_sql = "SELECT user FROM `loginform` WHERE user='$user' UNION SELECT user FROM `pending_users` WHERE user='$user'";
      $check_res = mysqli_query($con, $check_sql);
      
      if(mysqli_num_rows($check_res) > 0){
          $error = "Username already exists. Please choose another.";
      } else {
          // Insert new user to pending
          $insert_sql = "INSERT INTO `pending_users` (user, password, role) VALUES ('$user', '$password', 'faculty')";
          if(mysqli_query($con, $insert_sql)){
              $success = "Registration successful! Please wait for Admin approval before logging in.";
          } else {
              $error = "Registration failed. Please try again.";
          }
      }
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
    <title>Faculty Sign Up</title>
  </head>
  <body>
    <div class="header">
    <?php include 'navbar.php'; ?>
<section class="header">
  <div class="register-wrapper">
      <div class="register-block">
        <h3 class="register-title" style="font-size: 20px;">Faculty Registration</h3>

        <?php if($error != ''): ?>
            <div class="alert alert-danger p-2 mb-3" style="font-size: 14px;"><?php echo $error; ?></div>
        <?php endif; ?>

        <?php if($success != ''): ?>
            <div class="alert alert-success p-2 mb-3" style="font-size: 14px;">
                <?php echo $success; ?>
                <br>
                <a href="faculty.php" style="font-size: 14px; color: #155724; text-shadow: none; padding-top: 5px; display: inline-block;"><strong>Click here to Login</strong></a>
            </div>
        <?php endif; ?>

        <form method="post" action="faculty_signup.php">
          <input type="text" name="username" placeholder="Choose a Username" required />
          <input type="password" name="password" placeholder="Choose a Password" required />
          <input type="submit" name="submit" value="Sign Up" />
          
          <p style="text-align: center; margin-top: 20px; font-size: 14px;">
              <a href="faculty.php" style="color: #666; font-size: 14px; padding-top: 0; text-shadow: none; font-family: Arial, sans-serif;">Already registered? Login here</a>
          </p>
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

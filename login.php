<?php

include "connection.php";

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - Online Library Management System</title>
  <link rel="stylesheet" href="./css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>

  </style>
</head>

<body>

  <!-- Responsive Navbar -->
  <?php

  include "navbar.php"

  ?>

  <div class="form-container">

    <h2>User Login</h2>
    <form name="login" action="" method="post">
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" placeholder="Enter your username" name="Username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" name="password" class="form-control" placeholder="Enter your password" required>
      </div>
      <input type="submit" class="btn btn-primary w-100" value="Log in" name="submit">
      <div class="form-links">
        <a href="forgot_password.html">Forgot Password?</a> | <a href="signup.html">Sign Up</a>
      </div>
    </form>

    <?php

if(isset($_POST['submit'])){

  $password =$_POST['password'];
  $username =$_POST['Username'];

  $res = mysqli_query($db,"SELECT * FROM `student` WHERE  username ='$username' &&  password ='$password'; ");

  $count = mysqli_num_rows($res);

  if($count==0){

    echo '<div class="alert alert-danger">' . "The username and password doesn't match" . '</div>';
  }else{

    ?>
    <script type="text/javascript">

      window.location="index.php"

      </script>


    <?php
  }
}
?>

  </div>

  <footer class="text-center py-3 bg-dark text-white mt-auto">
    <p>Email: Online.library@gmail.com | Mobile: +2547********</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
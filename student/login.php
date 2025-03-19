
<?php

 session_start();

if(isset($_SESSION["user"])){

	header ("Location: index.php");
}

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

  <div class="form-container" style="min-width: 400px">

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
        <a href="forgot_password.html">Forgot Password?</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <a href="signup.php">Sign Up</a>
      </div>
    </form>

    <?php

if(isset($_POST['submit'])){

  $password =$_POST['password'];
  $Username =$_POST['Username'];

  require_once "connection.php";

  // Prepare a secure SQL statement
  $stmt = mysqli_prepare($conn, "SELECT * FROM `student` WHERE `Username` = ?");
  mysqli_stmt_bind_param($stmt, "s", $Username);
  mysqli_stmt_execute($stmt);
  
  $result = mysqli_stmt_get_result($stmt);
  $user = mysqli_fetch_assoc($result);
  
  if ($user) {
      // Verify the password with password_verify()
      if (password_verify($password, $user['Password'])) {
          echo "<div class='alert alert-success'>Login successful!</div>";
          header("Location: index.php");
          $_SESSION['user'] = "yes";
      } else {
          echo "<div class='alert alert-danger'>Incorrect password.</div>";
      }
  } else {
      echo "<div class='alert alert-danger'>Username does not Exist.</div>";
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
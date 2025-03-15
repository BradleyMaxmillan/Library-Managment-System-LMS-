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

    <?php

if (isset($_POST["submit"])) {

  $Username = $_POST["Username"];
  $password = $_POST["password"];

  $errors = array();

  // Check if passwords match
  if ($password !== $repeatPassword) {
    array_push($errors, "Passwords do not match.");
  }

    // Check for duplicate Username

  $res=mysqli_query($db,"SELECT username from Student");
  while($row=mysqli_fetch_assoc($res)){
    if($row['username'] == $Username);
    {
      array_push($errors, "Username already Exists");
      break;
    }

   ?>
    <form>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" placeholder="Enter your username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" placeholder="Enter your password" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Login</button>
      <div class="form-links">
        <a href="forgot_password.html">Forgot Password?</a> | <a href="signup.html">Sign Up</a>
      </div>
    </form>
  </div>

  <footer class="text-center py-3 bg-dark text-white mt-auto">
    <p>Email: Online.library@gmail.com | Mobile: +2547********</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
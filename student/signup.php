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
  <title>Online Library Management System</title>
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
  <!-- Registration Form -->
  <div class="form-container">
    <h2>User Registration</h2>

    <?php

    if (isset($_POST["submit"])) {

      $fullName = $_POST["fullName"];
      $Username = $_POST["Username"];
      $password = $_POST["password"];
      $repeatPassword = $_POST["repeatPassword"];
      $rollNo = $_POST["rollNo"];
      $email = $_POST["email"];

      $passwordHash = password_hash($password, PASSWORD_DEFAULT);

      $errors = array();

      // Validate email
      if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        array_push($errors, "Email is not valid.");
      }

      // Check password length
      if (strlen($password) < 8) {
        array_push($errors, "Password must be at least 8 characters long.");
      }
      // Check if passwords match
      if ($password !== $repeatPassword) {
        array_push($errors, "Passwords do not match.");
      }
      
      require_once "connection.php"; 

      $stmt = mysqli_prepare($conn, "SELECT * FROM `student` WHERE email = ? or Username = ?");
      mysqli_stmt_bind_param($stmt, "ss", $email,$Username);
      mysqli_stmt_execute($stmt);
      
      
      $result = mysqli_stmt_get_result($stmt);
      $user = mysqli_fetch_assoc($result);
      
      
      if ($user) {
        if ($user['Email'] === $email) {
            array_push($errors, "Email is already registered.");
        }
        if ($user['Username'] === $Username) {
            array_push($errors, "Username is already taken.");
        }
    }
    

      // Display errors
      if (count($errors) > 0) {
        foreach ($errors as $error) {
          echo '<div class="alert alert-danger">' . $error . '</div>';
        }
      } else {
        require_once "connection.php";
        $sql ="INSERT INTO `student` (`Full Name`, `Username`, `Password`, `Roll No`, `Email`) VALUES (?,?,?,?,?)";



        $stmt = mysqli_stmt_init($conn);

        $prepareStmt = mysqli_stmt_prepare($stmt, $sql);

        if ($prepareStmt) {
          mysqli_stmt_bind_param($stmt, "sssis", $fullName, $Username, $passwordHash, $rollNo, $email);

          mysqli_stmt_execute($stmt);
          echo "<div class='alert alert-success'>Your registered successfully</div>";
        }
        else{

          die( "Something went wrong");

        }
      
      }
    }

    ?>

    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">Full Name</label>
        <input type="text" class="form-control" placeholder="Full Name" name="fullName" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" placeholder="Username" name="Username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" placeholder="Password" name="password" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Repeat Password</label>
        <input type="password" class="form-control" placeholder="Repeat your password" name="repeatPassword" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Roll No</label>
        <input type="text" class="form-control" placeholder="Roll Number" name="rollNo" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="Email" name="email" required>
      </div>
      <input type="submit" class="btn btn-primary w-100" value="Sign Up" name="submit">
    </form>
  </div>

  <footer class="text-center py-3 bg-dark text-white mt-auto">
    <p>Email: Online.library@gmail.com | Mobile: +2547********</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
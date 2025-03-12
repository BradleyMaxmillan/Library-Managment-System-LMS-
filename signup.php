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

      $firstName = $_POST["firstName"];
      $lastName = $_POST["lastName"];
      $Username = $_POST["Username"];
      $password = $_POST["password"];
      $repeatPassword = $_POST["repeatPassword"];
      $rollNo = $_POST["rollNo"];
      $email = $_POST["email"];

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

      // Display errors
      if (count($errors) > 0) {
        foreach ($errors as $error) {
          echo '<div class="alert alert-danger">' . $error . '</div>';
        }
      } else {

        
      }
    }


    ?>



    <form method="POST" action="">
      <div class="mb-3">
        <label class="form-label">First Name</label>
        <input type="text" class="form-control" placeholder="Enter your first name" name="firstName" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Last Name</label>
        <input type="text" class="form-control" placeholder="Enter your last name" name="lastName" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Username</label>
        <input type="text" class="form-control" placeholder="Enter your username" name="Username" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Password</label>
        <input type="password" class="form-control" placeholder="Enter your password" name="password" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Repeat Password</label>
        <input type="password" class="form-control" placeholder="Repeat your password" name="repeatPassword" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Roll No</label>
        <input type="text" class="form-control" placeholder="Enter your roll number" name="rollNo" required>
      </div>
      <div class="mb-3">
        <label class="form-label">Email</label>
        <input type="email" class="form-control" placeholder="Enter your email" name="email" required>
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
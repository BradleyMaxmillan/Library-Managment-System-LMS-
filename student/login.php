<?php
ob_start(); // ✅ Start output buffering
session_start(); // ✅ Start session at the beginning

if (isset($_SESSION["user"])) {
    if ($_SESSION["user_type"] == "admin") {
        header("Location: admin_dashboard.php");
    } else {
        header("Location: index.php");
    }
    exit();
}

require_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    $Username = trim($_POST['Username']);
    $password = trim($_POST['password']);

    // ✅ First, check in the student table
    $stmt = mysqli_prepare($conn, "SELECT * FROM `student` WHERE `Username` = ?");
    mysqli_stmt_bind_param($stmt, "s", $Username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user = mysqli_fetch_assoc($result);

    if ($user && password_verify($password, $user['Password'])) {
        $_SESSION['user'] = $Username;
        $_SESSION['user_type'] = "student"; // ✅ Set session user type
        header("Location: index.php");
        exit();
    }

    // ✅ If not found in student, check the admin table
    $stmt = mysqli_prepare($conn, "SELECT * FROM `admin` WHERE `username` = ?");
    mysqli_stmt_bind_param($stmt, "s", $Username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $admin = mysqli_fetch_assoc($result);

    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['user'] = $Username;
        $_SESSION['user_type'] = "admin"; // ✅ Set session user type
        header("Location: admin_dashboard.php");
        exit();
    }

    // ✅ If no match found
    echo "<script>alert('Incorrect username or password!'); window.location='login.php';</script>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Online Library Management System</title>
  <link rel="stylesheet" href="./css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
        background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center center fixed;
        background-size: cover;
        color: #e0e0e0;
        font-family: 'Georgia', serif;
        position: relative;
        min-height: 100vh;
    }
    .overlay {
        background: rgba(0, 0, 0, 0.75);
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: -1;
    }
    .form-container {
        background: rgba(0, 0, 0, 0.6);
        padding: 40px;
        border-radius: 12px;
        text-align: center;
        width: 50%;
        max-width: 400px;
        margin: auto;
        box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        transition: transform 0.3s ease-in-out;
    }
    .form-container:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
    }
    .form-container h2 {
        font-size: 24px;
        font-weight: bold;
        color: #d4af37;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 15px;
    }
    .form-control {
        background: rgba(255, 255, 255, 0.2);
        border: none;
        color: #e0e0e0;
        padding: 10px;
        border-radius: 8px;
        margin-bottom: 10px;
    }
    .form-control:focus {
        background: rgba(255, 255, 255, 0.3);
        color: #fff;
        box-shadow: none;
    }
    .btn-primary {
        background: #d4af37;
        border: none;
        padding: 10px;
        border-radius: 8px;
        font-size: 16px;
        transition: background 0.3s ease-in-out;
    }
    .btn-primary:hover {
        background: #b8942e;
    }
    .form-links {
        margin-top: 10px;
    }
    .form-links a {
        color: #d4af37;
        text-decoration: none;
    }
    .form-links a:hover {
        text-decoration: underline;
    }
    @media (max-width: 768px) {
        .form-container {
            width: 80%;
            padding: 30px;
        }
    }
    @media (max-width: 480px) {
        .form-container {
            width: 90%;
            padding: 25px;
        }
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <?php include "navbar.php"; ?>

  <div class="container d-flex align-items-center justify-content-center" style="height: 80vh;">
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
          <a href="forgot_password.html">Forgot Password?</a> &nbsp;&nbsp;|&nbsp;&nbsp; <a href="signup.php">Sign Up</a>
        </div>
      </form>
    </div>
  </div>

  <?php ob_end_flush(); ?>
</body>
</html>

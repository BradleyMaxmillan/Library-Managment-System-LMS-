<?php
ob_start(); // ✅ Start output buffering
session_start(); // ✅ Start session at the beginning

if (isset($_SESSION["user"])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Online Library Management System</title>
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
      <h2>User Registration</h2>
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
          <label class="form-label">Email</label>
          <input type="email" class="form-control" placeholder="Email" name="email" required>
        </div>
        <input type="submit" class="btn btn-primary w-100" value="Sign Up" name="submit">
      </form>
    </div>
  </div>
</body>
</html>

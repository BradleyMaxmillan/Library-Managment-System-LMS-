<?php
session_start();
// Restrict access to admins only
if (!isset($_SESSION["user"]) || $_SESSION["user_type"] != "admin") {
  header("Location: login.php");
  exit();
}

include "connection.php";

// Fetch dynamic stats from your database

// Get total books count
$sqlBooks = "SELECT COUNT(*) AS totalBooks FROM books";
$resultBooks = mysqli_query($conn, $sqlBooks);
if ($resultBooks) {
  $row = mysqli_fetch_assoc($resultBooks);
  $totalBooks = $row['totalBooks'];
} else {
  $totalBooks = 0;
}

// Get registered users count (assuming only students are registered users)
$sqlUsers = "SELECT COUNT(*) AS totalUsers FROM student";
$resultUsers = mysqli_query($conn, $sqlUsers);
if ($resultUsers) {
  $row = mysqli_fetch_assoc($resultUsers);
  $registeredUsers = $row['totalUsers'];
} else {
  $registeredUsers = 0;
}

// You can similarly fetch other stats from your database if needed
$activeLoans = 0;
$overdueReturns = 0;
$booksIssuedToday = 0;
$booksReturnedToday = 0;
$newRegistrations = 0;
$pendingReservations = 0;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard - Library Management</title>
  <link rel="stylesheet" href="./css/style.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    /* Background & overlay */
    body {
      background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center center fixed;
      background-size: cover;
      color: #e0e0e0;
      font-family: 'Georgia', serif;
      margin: 0;
      padding: 0;
    }
    .overlay {
      background: rgba(0, 0, 0, 0.85);
      filter: blur(8px);
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      z-index: -1;
    }
    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 70px;
      left: 0;
      bottom: 0;
      width: 250px;
      background: rgba(0, 0, 0, 0.8);
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      overflow-y: auto;
      transition: all 0.3s ease;
    }
    .sidebar .logo {
      font-size: 24px;
      font-weight: bold;
      color: #d4af37;
      margin-bottom: 30px;
      text-align: center;
    }
    .sidebar ul {
      list-style: none;
      padding: 0;
    }
    .sidebar ul li {
      margin: 20px 0;
    }
    .sidebar ul li a {
      color: #e0e0e0;
      text-decoration: none;
      font-size: 18px;
      display: flex;
      align-items: center;
      transition: color 0.3s;
    }
    .sidebar ul li a i {
      margin-right: 10px;
      font-size: 28px;
    }
    .sidebar ul li a:hover {
      color: #d4af37;
    }
    .sidebar .logout-btn {
      margin-top: 20px;
    }
    /* Content Area */
    .content {
      margin-left: 250px;
      padding: 40px;
      min-height: 100vh;
      transition: margin-left 0.3s ease;
    }
    .content header {
      top: 0;
      left: 250px;
      right: 0;
      padding: 20px 40px;
      z-index: 10;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(212, 175, 55, 0.5);
    }
    .content header h1 {
      font-size: 32px;
      color: #d4af37;
      margin: 0;
    }
    .dashboard-body {
      margin-top: 100px;
    }
    /* Cards & Chart */
    .cards {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      margin-bottom: 40px;
    }
    .card {
      background: rgba(0, 0, 0, 0.6);
      border: none;
      border-radius: 12px;
      box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      flex: 1;
      min-width: 250px;
      padding: 20px;
      color: #e0e0e0;
      transition: transform 0.3s ease-in-out;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
    }
    .card h3 {
      font-size: 24px;
      margin-bottom: 15px;
      color: #d4af37;
    }
    /* Section Titles & Table */
    .section-title {
      font-size: 28px;
      color: #d4af37;
      margin: 30px 0 20px;
      border-bottom: 2px solid rgba(212, 175, 55, 0.5);
      padding-bottom: 10px;
    }
    .table-responsive {
      background: transparent;
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      margin-bottom: 40px;
    }
    .table {
      background: transparent !important;
    }
    .table thead th {
      color: #d4af37;
      background: transparent !important;
    }
    .table tbody td {
      color: #e0e0e0;
      background: transparent !important;
    }
    /* List Group */
    .list-group-item {
      background: rgba(0, 0, 0, 0.6);
      border: none;
      border-radius: 8px;
      margin-bottom: 10px;
      box-shadow: 0 4px 10px rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      color: #e0e0e0;
    }
    .list-group-item i {
      margin-right: 10px;
      color: #d4af37;
    }
    /* Responsive Adjustments */
    @media (max-width: 992px) {
      .sidebar {
        width: 200px;
        padding: 15px;
      }
      .content {
        margin-left: 200px;
        padding: 30px;
      }
      .content header {
        left: 200px;
        padding: 15px 30px;
      }
    }
    @media (max-width: 768px) {
      .sidebar {
        width: 180px;
      }
      .content {
        margin-left: 180px;
        padding: 20px;
      }
      .content header {
        left: 180px;
        padding: 10px 20px;
      }
      .cards {
        flex-direction: column;
      }
    }
    @media (max-width: 576px) {
      .sidebar {
        width: 100%;
        position: relative;
        flex-direction: row;
        justify-content: space-around;
      }
      .sidebar ul {
        display: flex;
        flex-direction: row;
        justify-content: space-around;
        width: 100%;
        margin: 0;
      }
      .sidebar ul li {
        margin: 10px 0;
      }
      .content {
        margin-left: 0;
        padding: 10px;
      }
      .content header {
        position: relative;
        left: 0;
        padding: 10px;
      }
    }
  </style>
</head>

<body>
  <div class="overlay"></div>
  <?php include "navbar.php" ?>

  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">Library Admin</div>
    <ul>
      <li><a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
      <li><a href="manage_books.php"><i class="fas fa-book"></i> Manage Books</a></li>
      <!-- <li><a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a></li> -->
      <!-- <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
      <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li> -->
    </ul>
    <div class="logout-btn">
      <a href="logout.php" class="btn btn-primary w-100"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>

  <!-- Main Content -->
  <div class="content">
    <header>
      <h1>Dashboard</h1>
      <div><span style="color: #d4af37;">Welcome, Admin!</span></div>
    </header>

    <!-- Dashboard Body -->
    <div class="dashboard-body container mt-4">
      <div class="cards row">
        <!-- Total Books Card -->
        <div class="col-md-6 mb-3">
          <div class="card text-center">
            <h3><i class="fas fa-book"></i> Total Books</h3>
            <p class="display-4"><?php echo $totalBooks; ?></p>
          </div>
        </div>
        <!-- Registered Users Card -->
        <div class="col-md-6 mb-3">
          <div class="card text-center">
            <h3><i class="fas fa-user"></i> Registered Students</h3>
            <p class="display-4"><?php echo $registeredUsers; ?></p>
          </div>
        </div>
      </div>
      <!-- You can add more cards for other stats as needed -->
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>

<?php
session_start();
// Restrict access to admins only
if (!isset($_SESSION["user"]) || $_SESSION["user_type"] != "admin") {
    header("Location: login.php");
    exit();
}

// You can fetch existing settings from your database here.
$libraryName = "City Library";
$libraryEmail = "info@citylibrary.com";
$libraryPhone = "123-456-7890";
$libraryAddress = "123 Main St, Metropolis";
$overdueFine = "0.50"; // per day
$notificationEmail = "admin@citylibrary.com";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Settings - Library Management</title>
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
      top: 0;
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
      position: fixed;
      top: 0;
      left: 250px;
      right: 0;
      padding: 20px 40px;
      background: rgb(0, 0, 0);
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
    /* Form & Card Styles */
    .settings-card {
      background: rgba(0, 0, 0, 0.6);
      border: none;
      border-radius: 12px;
      padding: 20px;
      margin-bottom: 30px;
      box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      color: #e0e0e0;
    }
    .settings-card h3 {
      color: #d4af37;
      margin-bottom: 20px;
    }
    .settings-card label {
      margin-bottom: 5px;
    }
    .settings-card .form-control {
      background: rgba(0, 0, 0, 0.8);
      border: 1px solid #d4af37;
      color: #e0e0e0;
    }
    .settings-card .btn-primary {
      background: #d4af37;
      border: none;
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
  
  <!-- Sidebar -->
  <div class="sidebar">
    <div class="logo">Library Admin</div>
    <ul>
      <li><a href="admin_dashboard.php"><i class="fas fa-home"></i> Dashboard</a></li>
      <li><a href="manage_books.php"><i class="fas fa-book"></i> Manage Books</a></li>
      <li><a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a></li>
      <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
      <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
    </ul>
    <div class="logout-btn">
      <a href="logout.php" class="btn btn-primary w-100"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>
  
  <!-- Content Area -->
  <div class="content">
    <header>
      <h1>Settings</h1>
      <div>
        <span>Welcome, Admin!</span>
      </div>
    </header>
    
    <div class="dashboard-body">
      <!-- General Library Information -->
      <div class="settings-card">
        <h3>General Library Information</h3>
        <form action="update_settings.php" method="post">
          <div class="mb-3">
            <label for="libraryName" class="form-label">Library Name</label>
            <input type="text" class="form-control" id="libraryName" name="libraryName" value="<?php echo htmlspecialchars($libraryName); ?>" required>
          </div>
          <div class="mb-3">
            <label for="libraryEmail" class="form-label">Contact Email</label>
            <input type="email" class="form-control" id="libraryEmail" name="libraryEmail" value="<?php echo htmlspecialchars($libraryEmail); ?>" required>
          </div>
          <div class="mb-3">
            <label for="libraryPhone" class="form-label">Phone Number</label>
            <input type="text" class="form-control" id="libraryPhone" name="libraryPhone" value="<?php echo htmlspecialchars($libraryPhone); ?>" required>
          </div>
          <div class="mb-3">
            <label for="libraryAddress" class="form-label">Address</label>
            <input type="text" class="form-control" id="libraryAddress" name="libraryAddress" value="<?php echo htmlspecialchars($libraryAddress); ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Update Library Info</button>
        </form>
      </div>
      
      <!-- Fine & Notification Settings -->
      <div class="settings-card">
        <h3>Fine & Notification Settings</h3>
        <form action="update_settings.php" method="post">
          <div class="mb-3">
            <label for="overdueFine" class="form-label">Overdue Fine (per day)</label>
            <input type="text" class="form-control" id="overdueFine" name="overdueFine" value="<?php echo htmlspecialchars($overdueFine); ?>" required>
          </div>
          <div class="mb-3">
            <label for="notificationEmail" class="form-label">Notification Email</label>
            <input type="email" class="form-control" id="notificationEmail" name="notificationEmail" value="<?php echo htmlspecialchars($notificationEmail); ?>" required>
          </div>
          <button type="submit" class="btn btn-primary">Update Fine/Notification</button>
        </form>
      </div>
      
      <!-- Account Settings -->
      <div class="settings-card">
        <h3>Account Settings</h3>
        <form action="update_settings.php" method="post">
          <div class="mb-3">
            <label for="currentPassword" class="form-label">Current Password</label>
            <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
          </div>
          <div class="mb-3">
            <label for="newPassword" class="form-label">New Password</label>
            <input type="password" class="form-control" id="newPassword" name="newPassword" required>
          </div>
          <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirm New Password</label>
            <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
          </div>
          <button type="submit" class="btn btn-primary">Update Password</button>
        </form>
      </div>
      
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

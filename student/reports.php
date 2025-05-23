<?php
session_start();
// Restrict access to admins only
if (!isset($_SESSION["user"]) || $_SESSION["user_type"] != "admin") {
    header("Location: login.php");
    exit();
}

// (Optional) Process filter submission
$startDate = isset($_POST['startDate']) ? $_POST['startDate'] : '';
$endDate   = isset($_POST['endDate']) ? $_POST['endDate'] : '';

// Query your database here based on filter values to retrieve report data
// For demonstration, we use static values.
$reportData = [
  ['date' => '2025-01-15', 'issued' => 30, 'returned' => 25],
  ['date' => '2025-02-15', 'issued' => 35, 'returned' => 28],
  ['date' => '2025-03-15', 'issued' => 40, 'returned' => 32],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reports - Library Management</title>
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
      top: 0; left: 0; right: 0; bottom: 0;
      z-index: -1;
    }
    /* Sidebar */
    .sidebar {
      position: fixed;
      top: 0; left: 0; bottom: 0;
      width: 250px;
      background: rgba(0, 0, 0, 0.8);
      padding: 20px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      overflow-y: auto;
      transition: all 0.3s ease;
    }
    .sidebar .logo { font-size: 24px; font-weight: bold; color: #d4af37; margin-bottom: 30px; text-align: center; }
    .sidebar ul { list-style: none; padding: 0; }
    .sidebar ul li { margin: 20px 0; }
    .sidebar ul li a {
      color: #e0e0e0; text-decoration: none; font-size: 18px;
      display: flex; align-items: center; transition: color 0.3s;
    }
    .sidebar ul li a i { margin-right: 10px; font-size: 28px; }
    .sidebar ul li a:hover { color: #d4af37; }
    .sidebar .logout-btn { margin-top: 20px; }
    /* Content Area */
    .content { margin-left: 250px; padding: 40px; min-height: 100vh; transition: margin-left 0.3s ease; }
    .content header {
      position: fixed; top: 0; left: 250px; right: 0;
      padding: 20px 40px; background: rgb(0, 0, 0);
      z-index: 10; display: flex; justify-content: space-between;
      align-items: center; border-bottom: 1px solid rgba(212, 175, 55, 0.5);
    }
    .content header h1 { font-size: 32px; color: #d4af37; margin: 0; }
    .reports-body { margin-top: 100px; }
    /* Filter Form */
    .filter-form {
      background: rgba(0,0,0,0.6); padding: 20px; border-radius: 12px;
      box-shadow: 0 8px 20px rgba(255,255,255,0.1); backdrop-filter: blur(10px);
      margin-bottom: 30px;
    }
    .filter-form label { margin-bottom: 5px; }
    .filter-form .form-control {
      background: rgba(0,0,0,0.8); border: 1px solid #d4af37; color: #e0e0e0;
    }
    /* Section Titles & Table */
    .section-title {
      font-size: 28px; color: #d4af37; margin: 30px 0 20px;
      border-bottom: 2px solid rgba(212,175,55,0.5); padding-bottom: 10px;
    }
    .table-responsive {
      background: transparent; /* Set table background to transparent */
      border-radius: 12px; padding: 20px;
      box-shadow: 0 8px 20px rgba(255,255,255,0.1); backdrop-filter: blur(10px);
      margin-bottom: 40px;
    }
    .table { background: transparent !important; }
    .table thead th { color: #d4af37; background: transparent !important; }
    .table tbody td { color: #e0e0e0; background: transparent !important; }
    /* Responsive Adjustments */
    @media (max-width: 992px) {
      .sidebar { width: 200px; padding: 15px; }
      .content { margin-left: 200px; padding: 30px; }
      .content header { left: 200px; padding: 15px 30px; }
    }
    @media (max-width: 768px) {
      .sidebar { width: 180px; }
      .content { margin-left: 180px; padding: 20px; }
      .content header { left: 180px; padding: 10px 20px; }
    }
    @media (max-width: 576px) {
      .sidebar {
        width: 100%; position: relative; flex-direction: row; justify-content: space-around;
      }
      .sidebar ul {
        display: flex; flex-direction: row; justify-content: space-around; width: 100%; margin: 0;
      }
      .sidebar ul li { margin: 10px 0; }
      .content { margin-left: 0; padding: 10px; }
      .content header { position: relative; left: 0; padding: 10px; }
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
      <li><a href="manage_users.php"><i class="fas fa-users"></i> Manage Users</a></li>
      <li><a href="reports.php"><i class="fas fa-chart-bar"></i> Reports</a></li>
      <li><a href="settings.php"><i class="fas fa-cog"></i> Settings</a></li>
    </ul>
    <div class="logout-btn">
      <a href="logout.php" class="btn btn-primary w-100"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
  </div>
  
  <!-- Main Content -->
  <div class="content">
    <header>
      <h1>Reports</h1>
      <div><span>Welcome, Admin!</span></div>
    </header>
    
    <div class="reports-body">
      <!-- Filter Form -->
      <section class="filter-form">
        <form action="reports.php" method="post" class="row g-3">
          <div class="col-md-4">
            <label for="startDate" class="form-label">Start Date</label>
            <input type="date" class="form-control" id="startDate" name="startDate" value="<?php echo htmlspecialchars($startDate); ?>">
          </div>
          <div class="col-md-4">
            <label for="endDate" class="form-label">End Date</label>
            <input type="date" class="form-control" id="endDate" name="endDate" value="<?php echo htmlspecialchars($endDate); ?>">
          </div>
          <div class="col-md-4 align-self-end">
            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Apply Filter</button>
            <button type="button" class="btn btn-secondary"><i class="fas fa-file-export"></i> Export</button>
          </div>
        </form>
      </section>
      
      <!-- Detailed Activity Chart -->
      <section>
        <h2 class="section-title">Year-to-Date Book Issuance</h2>
        <canvas id="detailedChart" width="400" height="200"></canvas>
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
          const ctxDetailed = document.getElementById('detailedChart').getContext('2d');
          const detailedChart = new Chart(ctxDetailed, {
            type: 'line',
            data: {
              labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
              datasets: [{
                label: 'Books Issued',
                data: [30,35,40,38,45,50,48,42,47,53,55,50],
                backgroundColor: 'rgba(212,175,55,0.4)',
                borderColor: 'rgba(212,175,55,1)',
                borderWidth: 2,
                fill: true,
              }]
            },
            options: {
              scales: { y: { beginAtZero: true } }
            }
          });
        </script>
      </section>
      
      <!-- Detailed Report Table -->
      <section>
        <h2 class="section-title">Detailed Report</h2>
        <div class="table-responsive">
          <table class="table">
            <thead>
              <tr>
                <th>Date</th>
                <th>Books Issued</th>
                <th>Books Returned</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($reportData as $row): ?>
              <tr>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['issued']); ?></td>
                <td><?php echo htmlspecialchars($row['returned']); ?></td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </section>
      
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

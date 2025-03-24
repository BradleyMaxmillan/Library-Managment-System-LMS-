<?php
session_start();
// Restrict access to admins only
if (!isset($_SESSION["user"]) || $_SESSION["user_type"] != "admin") {
    header("Location: login.php");
    exit();
}

include "connection.php";

// Handle deletion if 'delete' parameter is set
if (isset($_GET['delete'])) {
    $bookId = intval($_GET['delete']);
    $sqlDelete = "DELETE FROM books WHERE id = ?";
    $stmtDel = $conn->prepare($sqlDelete);
    $stmtDel->bind_param("i", $bookId);
    if ($stmtDel->execute()) {
        $stmtDel->close();
        // Redirect back with a success message (optional)
        header("Location: manage_books.php?msg=deleted");
        exit();
    } else {
        echo "Error deleting record: " . $stmtDel->error;
        exit();
    }
}

// Fetch all books from the database
$sql = "SELECT id, Title, Author, type, published_date FROM books ORDER BY Title ASC";
$result = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Manage Books - Library Admin</title>
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
      background: rgb(0, 0, 0);
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
    /* Table Styles */
    .table-responsive {
      background: rgba(0, 0, 0, 0.6);
      border-radius: 12px;
      padding: 20px;
      box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(10px);
      margin-bottom: 40px;
    }
    .table thead th {
      color: #d4af37;
    }
    .table tbody td {
      color: #e0e0e0;
    }
    .action-links a {
      margin-right: 10px;
      color: #d4af37;
      text-decoration: none;
    }
    .action-links a:hover {
      text-decoration: underline;
    }
    /* Section Titles */
    .section-title {
      font-size: 28px;
      color: #d4af37;
      margin: 30px 0 20px;
      border-bottom: 2px solid rgba(212, 175, 55, 0.5);
      padding-bottom: 10px;
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
        position: fixed;
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
      <h1>Manage Books</h1>
      <div>
        <a href="./books/insert_books.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Book</a>
      </div>
    </header>
    <div class="dashboard-body">
      <?php if(isset($_GET['msg']) && $_GET['msg'] == 'deleted'): ?>
        <div class="alert alert-success">Book deleted successfully.</div>
      <?php endif; ?>
      <h2 class="section-title">Book List</h2>
      <div class="table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th>ID</th>
              <th>Title</th>
              <th>Author</th>
              <th>Type</th>
              <th>Published</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if($result && mysqli_num_rows($result) > 0): ?>
              <?php while($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                  <td><?php echo htmlspecialchars($row['id']); ?></td>
                  <td><?php echo htmlspecialchars($row['Title']); ?></td>
                  <td><?php echo htmlspecialchars($row['Author']); ?></td>
                  <td><?php echo htmlspecialchars($row['type']); ?></td>
                  <td><?php echo htmlspecialchars($row['published_date']); ?></td>
                  <td class="action-links">
                    <a href="edit_book.php?id=<?php echo $row['id']; ?>"><i class="fas fa-edit"></i> Edit</a>
                    <a href="manage_books.php?delete=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this book?');"><i class="fas fa-trash-alt"></i> Delete</a>
                  </td>
                </tr>
              <?php endwhile; ?>
            <?php else: ?>
              <tr>
                <td colspan="6" class="text-center">No books found.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

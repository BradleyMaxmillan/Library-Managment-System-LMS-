<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Online Library Management System</title>
  
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <style>
    /* Navbar Custom Styles */
    .navbar {
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
      padding: 0.75rem 1rem;
    }
    .navbar-brand {
      font-weight: 700;
      font-size: 1.5rem;
      letter-spacing: 0.5px;
    }
    .navbar-nav .nav-link {
      font-size: 1rem;
      margin-right: 1rem;
      transition: background-color 0.3s, color 0.3s;
    }
    .navbar-nav .nav-link:hover {
      background-color: rgba(255, 255, 255, 0.1);
      border-radius: 4px;
    }
    .dropdown-menu {
      border: none;
      border-radius: 0.5rem;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .dropdown-item:hover {
      background-color: #f8f9fa;
    }
    /* Ensure fixed-top is truly sticky */
    body {
      padding-top: 70px;
    }
    /* Custom Offcanvas Styling */
    .offcanvas.offcanvas-end {
      background: rgba(23, 23, 23, 0.5); /* Semi-transparent background */
      backdrop-filter: blur(8px);   /* Blur effect */
      border: none;
	                /* Remove any default border */
    }
	
  </style>
</head>
<body>
  <nav class="navbar navbar-expand-lg navbar-dark  fixed-top" style=" background: rgba(18, 18, 18, 0.92); ">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <i class="fa-solid fa-book me-2"></i>Online Library
      </a>

      <!-- Toggler button: only visible on small screens -->
      <button class="navbar-toggler d-lg-none" type="button" data-bs-toggle="offcanvas"
              data-bs-target="#offcanvasNavbar" aria-controls="offcanvasNavbar" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <!-- Inline navigation for large screens -->
      <div class="collapse navbar-collapse d-none d-lg-block">
        <ul class="navbar-nav ms-auto align-items-center">
          <li class="nav-item">
            <a class="nav-link" href="index.php">
              <i class="fa-solid fa-house me-1"></i> Home
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="books.php">
              <i class="fa-solid fa-book-open me-1"></i> Books
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="feedback.php">
              <i class="fa-solid fa-comment me-1"></i> Feedback
            </a>
          </li>
          <!-- Profile Dropdown -->
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button"
               data-bs-toggle="dropdown" aria-expanded="false">
              <i class="fa-solid fa-user me-1"></i> Account
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown">
              <li>
                <a class="dropdown-item" href="login.php">
                  <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                </a>
              </li>
              <li>
                <a class="dropdown-item" href="signup.php">
                  <i class="fa-solid fa-pen-to-square me-1"></i> Register
                </a>
              </li>
              <li><hr class="dropdown-divider"></li>
              <li>
                <a class="dropdown-item text-danger" href="logOut.php">
                  <i class="fa-solid fa-door-open me-1"></i> Logout
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </div>

      <!-- Offcanvas navigation: only visible on small screens -->
      <div class="offcanvas offcanvas-end d-lg-none" tabindex="-1" id="offcanvasNavbar">
        <div class="offcanvas-header">
          <h5 class="offcanvas-title" id="offcanvasNavbarLabel" style="color:rgb(175, 175, 175);">Menu</h5>
          <button type="button" class="btn-close" style="background-color: white;" data-bs-dismiss="offcanvas"
                  aria-label="Close"></button>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link" href="index.php">
                <i class="fa-solid fa-house me-1"></i> Home
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="books.php">
                <i class="fa-solid fa-book-open me-1"></i> Books
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="feedback.php">
                <i class="fa-solid fa-comment me-1"></i> Feedback
              </a>
            </li>
            <!-- Profile Dropdown within Offcanvas -->
            <li class="nav-item dropdown">
              <a class="nav-link dropdown-toggle" href="#" id="accountDropdown2" role="button"
                 data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-user me-1"></i> Account
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown2">
                <li>
                  <a class="dropdown-item" href="login.php">
                    <i class="fa-solid fa-right-to-bracket me-1"></i> Login
                  </a>
                </li>
                <li>
                  <a class="dropdown-item" href="signup.php">
                    <i class="fa-solid fa-pen-to-square me-1"></i> Register
                  </a>
                </li>
                <li><hr class="dropdown-divider"></li>
                <li>
                  <a class="dropdown-item text-danger" href="logOut.php">
                    <i class="fa-solid fa-door-open me-1"></i> Logout
                  </a>
                </li>
              </ul>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- Bootstrap JS (Required for Offcanvas and Dropdown) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

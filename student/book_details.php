<?php
session_start();

// Require login
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

// Check if `id` is provided in the URL
if (!isset($_GET['id'])) {
    echo "No book selected!";
    exit();
}

$bookId = intval($_GET['id']);

// Connect to DB
include "connection.php";

// Fetch book details
$sql = "SELECT * FROM books WHERE id = $bookId";
$res = mysqli_query($conn, $sql);

// If no book found, show an error
if (!$res || mysqli_num_rows($res) == 0) {
    echo "Book not found!";
    exit();
}

// Get the book data
$book = mysqli_fetch_assoc($res);

// Optional fields with placeholders if not available
$coverImage     = isset($book['cover_image']) ? $book['cover_image'] : "https://via.placeholder.com/300x400?text=No+Cover";
$rating         = isset($book['rating'])      ? $book['rating']      : "N/A"; 
$published_date = isset($book['published_date']) ? $book['published_date'] : "Unknown";

// Dynamic meta values (ensure these columns exist in your table)
$type   = isset($book['type'])   ? $book['type']   : "General";
$genre  = isset($book['genre'])  ? $book['genre']  : "N/A";
$status = isset($book['status']) ? $book['status'] : "Unknown";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title><?php echo $book['Title']; ?> - Book Details</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Optional: Bootstrap Icons for star icon -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
  
  <style>
    body {
      background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center center fixed;
      background-size: cover;
      color: #e0e0e0;
      font-family: 'Georgia', serif;
      min-height: 100vh;
      position: relative;
    }
    .overlay {
      background: rgba(0, 0, 0, 0.75);
      position: absolute;
      top: 0; left: 0; right: 0; bottom: 0;
      z-index: -1;
    }
    /* Hero section styling */
    .hero {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 2rem;
      margin-top: 2rem;
      background: rgba(0,0,0,0.5);
      border-radius: 12px;
      padding: 1.5rem;
      box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(6px);
    }
    .hero-img {
      width: 300px;
      min-width: 250px;
      max-height: 400px;
      object-fit: cover;
      border-radius: 8px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.6);
    }
    .hero-content {
      flex: 1;
    }
    .hero-title {
      font-size: 1.8rem;
      font-weight: bold;
      color: #d4af37;
      margin-bottom: 0.5rem;
    }
    .hero-meta {
      font-size: 0.95rem;
      margin-bottom: 1rem;
      color: #bbb;
    }
    .hero-description {
      font-size: 1rem;
      line-height: 1.5;
      margin-bottom: 1rem;
    }
    .btn-custom {
      background-color: #d4af37;
      color: black;
      border: none;
      font-weight: 600;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background-color: #b89b2e;
      color: #fff;
    }
    /* Meta badges styling */
    .meta-badges {
      margin-bottom: 1rem;
    }
    .meta-badges .badge {
      margin-right: 0.5rem;
    }
  </style>
</head>
<body>
<div class="overlay"></div>

<!-- Navbar -->
<?php include "navbar.php"; ?>

<div class="container my-5">
  <div class="hero">
    <!-- Book Cover -->
    <img src="<?php echo $coverImage; ?>" alt="Cover" class="hero-img">

    <div class="hero-content">
      <!-- Title -->
      <h1 class="hero-title"><?php echo $book['Title']; ?></h1>

      <!-- Meta Info (Author, Type, Rating, Published Date) -->
      <div class="hero-meta">
        <strong>Author:</strong> <?php echo $book['Author']; ?> 
        &nbsp;|&nbsp;
        <strong>Type:</strong> <?php echo $type; ?>
        &nbsp;|&nbsp;
        <strong>Rating:</strong> 
        <i class="bi bi-star-fill" style="color: #ffd700;"></i> <?php echo $rating; ?>
        &nbsp;|&nbsp;
        <strong>Published:</strong> <?php echo $published_date; ?>
      </div>

      <!-- Dynamic Meta Badges -->
      <div class="meta-badges">
        <span class="badge bg-info"><?php echo $type; ?></span>
        <span class="badge bg-secondary"><?php echo $genre; ?></span>
        <span class="badge bg-warning text-dark"><?php echo $status; ?></span>
      </div>

      <!-- Description -->
      <p class="hero-description">
        <?php echo $book['Description']; ?>
      </p>

      <!-- Action Buttons -->
      <button class="btn btn-custom me-2">Add to List</button>
      <button class="btn btn-outline-light">Share</button>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

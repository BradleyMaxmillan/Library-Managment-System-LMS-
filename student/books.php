<?php
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}
include "connection.php";

// Query for popular books (adjust query as needed)
$popularSql = "SELECT * FROM books ORDER BY rating DESC LIMIT 5";
$popularRes = mysqli_query($conn, $popularSql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Book List - Online Library Management System</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  
  <!-- Bootstrap Icons (for the star icon) -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

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
      position: fixed;  /* Fixed to cover entire screen */
      top: 0;
      left: 0;
      width: 100vw;  /* Full viewport width */
      height: 100vh;  /* Full viewport height */
      z-index: -1;
    }
    .header-title {
      font-size: clamp(24px, 5vw, 32px);
      font-weight: bold;
      color: #d4af37;
      text-transform: uppercase;
      text-align: center;
      margin-bottom: 30px;
      letter-spacing: 1.5px;
    }
    /* Container for each book poster + the hover card */
    .card-container {
      position: relative;
      width: 180px;    /* approximate width (adjust as needed) */
      margin: auto;
      cursor: pointer;
    }
    /* The book cover (poster) */
    .book-cover {
      width: 100%;
      height: 270px;   /* adjust for the tall look */
      object-fit: cover;
      border-radius: 6px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      transition: transform 0.3s ease;
      display: block;
    }
    .book-cover:hover {
      transform: scale(1.03);
    }
    /* The hidden info card that appears on hover (only on large devices) */
    .info-card {
      display: none;
      position: absolute;
      top: 100px;
      left: 100px;  /* shift to the right of the poster */
      width: 230px; 
      background: rgba(0,0,0,0.9);
      color: #fff;
      padding: 0.4rem;
      border-radius: 8px;
      box-shadow: 0 8px 16px rgba(0,0,0,0.5);
      z-index: 999;
    }
    .info-card::before {
      content: "";
      position: absolute;
      top: 1.5rem;
      left: -15px;
      width: 0; 
      height: 0; 
      border-top: 10px solid transparent;
      border-bottom: 10px solid transparent;
      border-right: 15px solid rgba(0,0,0,0.9);
    }
    @media (min-width: 992px) {
      .card-container:hover .info-card {
        display: block;
      }
    }
    /* Info card text styling */
    .info-card h5 {
      margin-bottom: 0.3rem;
      color: #ffd700;
    }
    .info-card .desc {
      font-size: 0.8rem;
      line-height: 1.4;
      margin-bottom: 0.5rem;
    }
    /* Button styling */
    .btn-custom {
      background-color: #d4af37;
      color: #000;
      border: none;
      font-weight: bold;
      padding: 0.1rem;
      margin: 0 auto;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background-color: #b89b2e;
      color: #fff;
    }
    /* Sidebar styling */
    .sidebar {
      background: rgba(0, 0, 0, 0.8);
      padding: 1rem;
      border-radius: 8px;
      color: #fff;
    }
    .sidebar h4 {
      border-bottom: 1px solid #555;
      padding-bottom: 0.5rem;
      margin-bottom: 1rem;
    }
    .popular-book {
      display: flex;
      margin-bottom: 1rem;
    }
    .popular-book img {
      width: 60px;
      height: 90px;
      object-fit: cover;
      border-radius: 4px;
      margin-right: 0.5rem;
    }
    .popular-book-title {
      font-size: 0.9rem;
      color: #ffd700;
    }
  </style>
</head>
<body>
<div class="overlay"></div>

<!-- Navbar -->
<?php include "navbar.php"; ?>

<div class="container my-5">
  <h1 class="header-title">Book List</h1>
  <div class="row">
    <!-- Main Content Column -->
    <div class="col-lg-9">
      <div class="row row-cols-2 row-cols-md-5 g-4">
        <?php
          $sql = "SELECT * FROM books";
          $res = mysqli_query($conn, $sql);

          while ($row = mysqli_fetch_assoc($res)) {
            // Fallback cover image if you don't have one
            $cover = "https://via.placeholder.com/300x450?text=No+Cover";

            // Book metadata
            $id       = $row["id"];
            $title    = $row["Title"];
            $author   = $row["Author"];
            $type     = $row["type"] ?? "General";
            $genre    = $row["genre"] ?? "N/A";
            $rating   = $row["rating"] ?? "N/A";
            $pages    = $row["pages"] ?? "???";
            $status   = $row["status"] ?? "Unknown";
            $pubDate  = $row["published_date"] ?? "N/A";
            $publisher= $row["publisher"] ?? "N/A";
            $language = $row["language"] ?? "English";

            // Short snippet of description
            $desc = substr($row["Description"], 0, 70) . "...";
        ?>
          <div class="col d-flex justify-content-center">
            <div class="card-container">
              <!-- Poster (click => details page) -->
              <a href="book_details.php?id=<?php echo $id; ?>">
                <img src="<?php echo $cover; ?>" class="book-cover" alt="Cover">
              </a>

              <!-- Hover Info Card -->
              <div class="info-card">
                <!-- Top row: rating + book-relevant badges -->
                <div class="d-flex align-items-center mb-2">
                  <!-- Star icon + rating -->
                  <span class="me-2" style="font-size: 1.2rem; color: #ffd700;">
                    <i class="bi bi-star-fill"></i> <?php echo $rating; ?>
                  </span>
                  <!-- Book type badge -->
                  <span class="badge bg-secondary me-1"><?php echo $type; ?></span>
                  <!-- Genre badge -->
                  <span class="badge bg-secondary me-1"><?php echo $genre; ?></span>
                </div>

                <!-- Title -->
                <h5><?php echo $title; ?></h5>

                <!-- Short snippet (description) -->
                <div class="desc">
                  <?php echo $desc; ?>
                </div>

                <!-- Aired/Published date + Status row -->
                <div class="mb-2" style="font-size: 0.9rem;">
                  <strong>Published:</strong> <?php echo $pubDate; ?><br>
                  <strong>Status:</strong> <?php echo $status; ?>
                </div>

                <!-- Genre row -->
                <div class="mb-2" style="font-size: 0.9rem;">
                  <strong>Genres:</strong> <?php echo $genre; ?>
                </div>

                <!-- "Read Now" Button -->
                <a href="book_details.php?id=<?php echo $id; ?>" class="btn btn-custom">Read Now</a>
              </div>
            </div>
          </div>
        <?php } ?>
      </div>
    </div>
    <!-- Sidebar Column -->
    <div class="col-lg-3 mt-4 mt-lg-0">
      <div class="sidebar">
        <h4>Popular Books</h4>
        <?php while($pRow = mysqli_fetch_assoc($popularRes)): 
          $pCover = $pRow["cover"] ?? "https://via.placeholder.com/300x450?text=No+Cover";
        ?>
          <div class="popular-book">
            <a href="book_details.php?id=<?php echo $pRow['id']; ?>">
              <img src="<?php echo $pCover; ?>" alt="Popular Book">
            </a>
            <div>
              <div class="popular-book-title">
                <?php echo $pRow["Title"]; ?>
              </div>
              <small>By <?php echo $pRow["Author"]; ?></small>
            </div>
          </div>
        <?php endwhile; ?>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS (Required for Offcanvas and Dropdown) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

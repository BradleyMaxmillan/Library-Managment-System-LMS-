<?php 
session_start();
if (!isset($_SESSION["user"])) {
    header("Location: ../login.php");
    exit();
}
include "connection.php";

// Query for popular books (adjust query as needed)
$popularSql = "SELECT * FROM books ORDER BY rating DESC LIMIT 5";
$popularRes = mysqli_query($conn, $popularSql);

// Query for spotlight slider books (adjust query as needed)
$sliderSql = "SELECT * FROM books ORDER BY published_date DESC LIMIT 5";
$sliderRes = mysqli_query($conn, $sliderSql);

// Query for trending books (adjust query as needed)
$trendingSql = "SELECT * FROM books ORDER BY rating DESC LIMIT 4";
$trendingRes = mysqli_query($conn, $trendingSql);
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
    /* Main page background */
    body {
      background: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f') no-repeat center center fixed;
      background-size: cover;
      color: #e0e0e0;
      font-family: 'Georgia', serif;
      position: relative;
      min-height: 100vh;
    }
    .overlay {
      background: rgba(22, 22, 22);
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
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
      width: 180px;
      margin: auto;
      cursor: pointer;
    }
    .book-cover {
      width: 100%;
      height: 270px;
      object-fit: cover;
      border-radius: 6px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.3);
      transition: transform 0.3s ease;
      display: block;
    }
    .book-cover:hover {
      transform: scale(1.03);
    }
    .info-card {
      display: none;
      position: absolute;
      top: 100px;
      left: 100px;
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
    .info-card h5 {
      margin-bottom: 0.3rem;
      color: #ffd700;
    }
    .info-card .desc {
      font-size: 0.8rem;
      line-height: 1.4;
      margin-bottom: 0.5rem;
    }
    .btn-custom {
      background-color: #d4af37;
      color: #000;
      border: none;
      font-weight: bold;
      padding: 0.4rem 0.8rem;
      margin: 0 auto;
      transition: 0.3s;
    }
    .btn-custom:hover {
      background-color: #b89b2e;
      color: #fff;
    }

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

    .book-spotlight {
      margin-bottom: 30px;
      background: black;
      color: #fff;
    }
    .carousel-item {
      position: relative;
      min-height: 400px;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 2rem 1rem;
    }
    .spotlight-container {
      display: flex;
      flex-direction: row;
      flex-wrap: wrap;
      max-width: 1200px;
      width: 100%;
      margin: 0 auto;
      position: relative;
    }
    /* Text on the left */
    .spotlight-text {
      flex: 1 1 50%;
      padding-right: 1.5rem;
      display: flex;
      flex-direction: column;
      justify-content: center;
      min-width: 300px;
    }
    .spotlight-text .badge {
      background-color: #ffd700;
      color: #000;
      font-weight: bold;
      display: inline-block;
      margin-bottom: 1rem;
      padding: 0.4rem 0.6rem;
    }
    .spotlight-text h2 {
      font-size: 2rem;
      font-weight: bold;
      margin-bottom: 1rem;
      color: #ffd700;
    }
    .spotlight-text p {
      font-size: 1rem;
      margin-bottom: 1rem;
      line-height: 1.4;
      color: #e0e0e0;
    }

    /* Image on the right with fade from right to black */
    .spotlight-image-wrapper {
      flex: 1 1 50%;
      position: relative;
      min-width: 300px;
      display: flex;
      align-items: center;
      justify-content: center;
      overflow: hidden;
    }
    .spotlight-image {
      max-height: 450px;
      width: auto;
      object-fit: contain;
      position: relative;
      z-index: 1;
    }
    /* Fade from right to black */
    .spotlight-image-wrapper::before {
      content: "";
      position: absolute;
      top: 0; 
      bottom: 0;
      left: 0; 
      right: 0;
      background: linear-gradient(to right, rgba(0,0,0,0), rgba(0,0,0,1) 70%);
      z-index: 2;
      pointer-events: none;
    }

    /* Carousel controls override (white icons) */
    .carousel-control-prev-icon,
    .carousel-control-next-icon {
      filter: invert(1);
  
    }

    /* Trending Section */
    .trending-section {
      padding: 20px;
    }
    .trending-section h3 {
      color: #d4af37;
      margin-bottom: 15px;
    }
    .trending-container {
      display: flex;
      gap: 10px;
      flex-wrap: wrap;
    }
    .trending-item {
      text-align: center;
      width: 100px; /* adjust if needed */
    }
    .trending-item img {
      width: 100px;
      height: 150px;
      object-fit: cover;
      border-radius: 6px;
    }
    .trending-item p {
      text-align: center;
      color: #ffd700;
      font-size: 0.9rem;
      margin-top: 5px;
    }
  </style>
</head>
<body>
  <div class="overlay"></div>

  <!-- Navbar -->
  <?php include "navbar.php"; ?>

  <!-- Book Spotlight Slider -->
  <div id="bookSpotlightCarousel" class="carousel slide book-spotlight" data-bs-ride="carousel">
    <div class="carousel-inner">
      <?php 
      $activeSet = false;
      $slideIndex = 1; // for "#1 Spotlight", "#2 Spotlight", etc.
      while ($sRow = mysqli_fetch_assoc($sliderRes)):
        // Process cover image
        if (!empty($sRow["cover"])) {
          $sImgInfo = getimagesizefromstring($sRow["cover"]);
          $sMime = $sImgInfo ? $sImgInfo["mime"] : "image/jpeg";
          $sCover = 'data:' . $sMime . ';base64,' . base64_encode($sRow["cover"]);
        } else {
          $sCover = "https://via.placeholder.com/300x450?text=No+Cover";
        }
        $sId = $sRow["id"];
        $sTitle = $sRow["Title"];
        // Show first ~120 chars of description
        $sDesc = substr($sRow["Description"], 0, 120) . "...";
      ?>
      <div class="carousel-item <?php if (!$activeSet) { echo 'active'; $activeSet = true; } ?>">
        <div class="spotlight-container">
          <!-- Text on the left -->
          <div class="spotlight-text">
            <span class="badge">#<?php echo $slideIndex; ?> Spotlight</span>
            <h2><?php echo $sTitle; ?></h2>
            <p><?php echo $sDesc; ?></p>
            <a href="book_details.php?id=<?php echo $sId; ?>" class="btn btn-custom">Read Now</a>
          </div>

          <!-- Image on the right -->
          <div class="spotlight-image-wrapper">
            <img src="<?php echo $sCover; ?>" alt="<?php echo $sTitle; ?>" class="spotlight-image">
          </div>
        </div>
      </div>
      <?php 
        $slideIndex++;
      endwhile; 
      ?>
    </div>
    <!-- Carousel Controls -->
    <button class="carousel-control-prev" type="button" data-bs-target="#bookSpotlightCarousel" data-bs-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="false"></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bookSpotlightCarousel" data-bs-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="visually-hidden">Next</span>
    </button>
  </div>

  <!-- Trending Section -->
  <div class="trending-section container">
    <h3>Trending</h3>
    <div class="trending-container">
      <?php while($tRow = mysqli_fetch_assoc($trendingRes)):
        if (!empty($tRow["cover"])) {
          $tImgInfo = getimagesizefromstring($tRow["cover"]);
          $tMime = $tImgInfo ? $tImgInfo["mime"] : "image/jpeg";
          $tCover = 'data:' . $tMime . ';base64,' . base64_encode($tRow["cover"]);
        } else {
          $tCover = "https://via.placeholder.com/300x450?text=No+Cover";
        }
      ?>
      <div class="trending-item">
        <a href="book_details.php?id=<?php echo $tRow['id']; ?>">
          <img src="<?php echo $tCover; ?>" alt="Trending Book">
        </a>
        <p><?php echo $tRow["Title"]; ?></p>
      </div>
      <?php endwhile; ?>
    </div>
  </div>

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
              // If there's cover data, convert to a data URI
              if (!empty($row["cover"])) {
                $imgInfo = getimagesizefromstring($row["cover"]);
                $mime = $imgInfo ? $imgInfo["mime"] : "image/jpeg";
                $cover = 'data:' . $mime . ';base64,' . base64_encode($row["cover"]);
              } else {
                // Fallback cover if no data
                $cover = "https://via.placeholder.com/300x450?text=No+Cover";
              }

              // Book metadata
              $id        = $row["id"];
              $title     = $row["Title"];
              $author    = $row["Author"];
              $type      = $row["type"] ?? "General";
              $genre     = $row["genre"] ?? "N/A";
              $rating    = $row["rating"] ?? "N/A";
              $pages     = $row["pages"] ?? "???";
              $status    = $row["status"] ?? "Unknown";
              $pubDate   = $row["published_date"] ?? "N/A";
              $publisher = $row["publisher"] ?? "N/A";
              $language  = $row["language"] ?? "English";

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
                  <div class="d-flex align-items-center mb-2">
                    <span class="me-2" style="font-size: 1.2rem; color: #ffd700;">
                      <i class="bi bi-star-fill"></i> <?php echo $rating; ?>
                    </span>
                    <span class="badge bg-secondary me-1"><?php echo $type; ?></span>
                    <span class="badge bg-secondary me-1"><?php echo $genre; ?></span>
                  </div>
                  <h5><?php echo $title; ?></h5>
                  <div class="desc">
                    <?php echo $desc; ?>
                  </div>
                  <div class="mb-2" style="font-size: 0.9rem;">
                    <strong>Published:</strong> <?php echo $pubDate; ?><br>
                    <strong>Status:</strong> <?php echo $status; ?>
                  </div>
                  <div class="mb-2" style="font-size: 0.9rem;">
                    <strong>Genres:</strong> <?php echo $genre; ?>
                  </div>
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
            if (!empty($pRow["cover"])) {
              $pImgInfo = getimagesizefromstring($pRow["cover"]);
              $pMime = $pImgInfo ? $pImgInfo["mime"] : "image/jpeg";
              $pCover = 'data:' . $pMime . ';base64,' . base64_encode($pRow["cover"]);
            } else {
              $pCover = "https://via.placeholder.com/300x450?text=No+Cover";
            }
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

  <!-- Bootstrap JS -->
 
</body>
</html>

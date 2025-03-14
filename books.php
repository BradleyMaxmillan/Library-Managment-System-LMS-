<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Books - Online Library Management System</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #111;
      color: white;
      font-family: Arial, sans-serif;
      padding-top: 70px;
    }

    .book-section {
      margin: 20px;
    }

    .book-list {
      display: flex;
      overflow-x: auto;
      gap: 15px;
      padding-bottom: 10px;
      scrollbar-width: thin;
    }

    .book-item {
      flex: 0 0 auto;
      width: 150px;
      text-align: center;
      position: relative;
    }

    .book-item img {
      width: 100%;
      border-radius: 8px;
    }

    .rating {
      position: absolute;
      top: 5px;
      right: 5px;
      background: rgba(0, 0, 0, 0.7);
      color: yellow;
      padding: 3px 6px;
      border-radius: 5px;
      font-size: 12px;
    }

    .section-header {
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .more-link {
      color: #ff9800;
      text-decoration: none;
      font-size: 14px;
    }

    .search-bar {
      width: 300px;
    }
  </style>
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">ONLINE LIBRARY MANAGEMENT SYSTEM</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-center" id="navbarNav">
        <input type="text" id="searchInput" class="form-control search-bar" placeholder="Search books...">

        <ul class="navbar-nav ms-auto">
          <li class="nav-item"><a class="nav-link" href="index.php">HOME</a></li>
          <li class="nav-item"><a class="nav-link" href="books.php">BOOKS</a></li>
          <li class="nav-item"><a class="nav-link" href="login.php">STUDENT-LOGIN</a></li>
          <li class="nav-item"><a class="nav-link" href="signup.php">REGISTRATION</a></li>

        </ul>
      </div>
    </div>
  </nav>

  <div class="container">
    <div class="book-section">
      <div class="section-header">
        <h2>Popular Books</h2>
        <a href="#" class="more-link">More ></a>
      </div>
      <div id="popularBooks" class="book-list"></div>
    </div>
    <div class="book-section">
      <div class="section-header">
        <h2>Suggestions</h2>
        <a href="#" class="more-link">More ></a>
      </div>
      <div id="suggestedBooks" class="book-list"></div>
    </div>
    <div class="book-section">
      <div class="section-header">
        <h2>Trending Now 🔥</h2>
        <a href="#" class="more-link">More ></a>
      </div>
      <div id="trendingBooks" class="book-list"></div>
    </div>
    <div class="book-section">
      <div class="section-header">
        <h2>Oscar Winners</h2>
        <a href="#" class="more-link">More ></a>
      </div>
      <div id="oscarBooks" class="book-list"></div>
    </div>
    <div class="book-section">
      <div class="section-header">
        <h2>Top Sci-Fi</h2>
        <a href="#" class="more-link">More ></a>
      </div>
      <div id="scifiBooks" class="book-list"></div>
    </div>
  </div>

  <footer class="text-center py-3 bg-dark text-white mt-auto">
    <p>Email: Online.library@gmail.com | Mobile: +2547********</p>
  </footer>

  <script>
  async function fetchBooks(query, elementId) {
    try {
      const res = await fetch(`https://www.googleapis.com/books/v1/volumes?q=${query}`);
      const data = await res.json();
      document.getElementById(elementId).innerHTML = (data.items || []).map(book => {
        let info = book.volumeInfo;
        return `
          <div class="book-item">
            <img src="${info.imageLinks?.thumbnail || 'https://via.placeholder.com/150'}" alt="Book">
            <div class="rating">${info.averageRating ? `⭐ ${info.averageRating}` : 'No Rating'}</div>
            <p>${info.title}</p>
          </div>`;
      }).join('');
    } catch {
      document.getElementById(elementId).innerHTML = "<p style='color:red;'>Failed to load books.</p>";
    }
  }

  ['popular', 'suggestions', 'trending', 'oscar winning', 'science fiction'].forEach(query => 
    fetchBooks(query, query.replace(/\s+/g, '') + 'Books')
  );

  document.getElementById('searchInput').addEventListener('input', e => fetchBooks(e.target.value, 'popularBooks'));
</script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    	<!-- Responsive Navbar -->
<?php

include "navbar.php"

?>
<!-- comment section -->
    <div class="form-container" style="min-width: 600px">
        <h3 class="mb-4">Comments</h3>
        <form action="submit_comment.php" method="POST">
            <div class="mb-3">
                <input type="text" class="form-control" name="username" placeholder="Your Name" required>
            </div>
            <div class="mb-3">
                <textarea class="form-control" name="comment" placeholder="Add a comment..." required></textarea>
            </div>
            <input type="submit" class="btn btn-primary" name="submit" value="Post Comment">
        </form>
        
        <div class="mt-4">
            <?php include 'fetch_comments.php'; ?>
        </div>
    </div>
    <footer class="text-center py-3 bg-dark text-white mt-auto">
    <p>Email: Online.library@gmail.com | Mobile: +2547********</p>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

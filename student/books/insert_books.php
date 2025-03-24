<?php
session_start();

if (!isset($_SESSION["user"])) {
    header("Location: login.php");
    exit();
}

include "connection.php";

// Function to insert a book into the database using a BLOB for the cover image.
function insertBook($title, $author, $type, $description, $genre, $rating, $pages, $status, $published_date, $publisher, $language, $coverData, $conn) {
    $sql = "INSERT INTO books (Title, Author, type, Description, genre, rating, pages, status, published_date, publisher, language, cover) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $nullBlob = null;
    // Bind parameters; note that the last parameter 'b' is for the BLOB.
    $stmt->bind_param("sssssdissssb", $title, $author, $type, $description, $genre, $rating, $pages, $status, $published_date, $publisher, $language, $nullBlob);
    $stmt->send_long_data(11, $coverData);
    if ($stmt->execute()) {
        return "Book '$title' added successfully!";
    } else {
        return "Error: " . $stmt->error;
    }
    $stmt->close();
}

$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve and sanitize form inputs
    $title           = $_POST["title"] ?? "";
    $author          = $_POST["author"] ?? "";
    $type            = $_POST["type"] ?? "";
    $description     = $_POST["description"] ?? "";
    $genre           = $_POST["genre"] ?? "";
    $rating          = floatval($_POST["rating"] ?? 0);
    $pages           = intval($_POST["pages"] ?? 0);
    $status          = $_POST["status"] ?? "";
    $published_date  = $_POST["published_date"] ?? "";
    $publisher       = $_POST["publisher"] ?? "";
    $language        = $_POST["language"] ?? "";
    
    // Process the uploaded cover image file
    if (isset($_FILES["cover"]) && $_FILES["cover"]["error"] == 0) {
        $coverData = file_get_contents($_FILES["cover"]["tmp_name"]);
    } else {
        $coverData = "";
    }
    
    $message = insertBook($title, $author, $type, $description, $genre, $rating, $pages, $status, $published_date, $publisher, $language, $coverData, $conn);
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>Insert New Book - Online Library Management System</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link rel="stylesheet" href="./css/style.css">
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
			position: absolute;
			top: 0;
			left: 0;
			right: 0;
			bottom: 0;
			z-index: -1;
		}
		.box {
			background: rgba(0, 0, 0, 0.6);
			padding: 40px;
			border-radius: 12px;
			text-align: left;
			width: 50%;
			max-width: 600px;
			margin: auto;
			box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
			backdrop-filter: blur(10px);
			transition: transform 0.3s ease-in-out;
		}
		.box:hover {
			transform: translateY(-5px);
			box-shadow: 0 10px 25px rgba(255, 255, 255, 0.2);
		}
		.box h1 {
			font-size: clamp(24px, 5vw, 28px);
			font-weight: bold;
			color: #d4af37;
			text-transform: uppercase;
			letter-spacing: 2px;
			margin-bottom: 20px;
			text-align: center;
		}
		.box label {
			font-weight: 600;
		}
		.box .form-control, .box .form-select {
			background: rgba(255, 255, 255, 0.1);
			border: none;
			color: #e0e0e0;
		}
		.box .form-control:focus, .box .form-select:focus {
			box-shadow: none;
			border-color: #d4af37;
		}
		.box .btn-primary {
			background-color: #d4af37;
			border: none;
			color: #000;
		}
		.box .btn-primary:hover {
			background-color: #b89b2e;
		}
		@media (max-width: 768px) {
			.box {
				width: 80%;
				padding: 30px;
			}
		}
		@media (max-width: 480px) {
			.box {
				width: 90%;
				padding: 25px;
			}
			.box h1 {
				font-size: 22px;
			}
		}
	</style>
</head>
<body>
	<div class="overlay"></div>
	<!-- Responsive Navbar -->
	<?php include "navbar.php"; ?>
	<section>
		<div class="container d-flex align-items-center justify-content-center" style="min-height: 80vh;">
			<div class="box">
				<h1>Insert New Book</h1>
				<?php if(!empty($message)): ?>
					<div class="alert alert-info"><?php echo $message; ?></div>
				<?php endif; ?>
				<form method="POST" enctype="multipart/form-data">
					<div class="mb-3">
						<label for="title" class="form-label">Title:</label>
						<input type="text" name="title" id="title" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="author" class="form-label">Author:</label>
						<input type="text" name="author" id="author" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="type" class="form-label">Type:</label>
						<input type="text" name="type" id="type" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="description" class="form-label">Description (100 words):</label>
						<textarea name="description" id="description" rows="5" class="form-control" required></textarea>
					</div>
					<div class="mb-3">
						<label for="genre" class="form-label">Genre:</label>
						<input type="text" name="genre" id="genre" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="rating" class="form-label">Rating:</label>
						<input type="number" step="0.1" name="rating" id="rating" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="pages" class="form-label">Pages:</label>
						<input type="number" name="pages" id="pages" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="status" class="form-label">Status:</label>
						<input type="text" name="status" id="status" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="published_date" class="form-label">Published Date:</label>
						<input type="date" name="published_date" id="published_date" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="publisher" class="form-label">Publisher:</label>
						<input type="text" name="publisher" id="publisher" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="language" class="form-label">Language:</label>
						<input type="text" name="language" id="language" class="form-control" required>
					</div>
					<div class="mb-3">
						<label for="cover" class="form-label">Cover Image:</label>
						<input type="file" name="cover" id="cover" class="form-control" required>
					</div>
					<button type="submit" class="btn btn-primary w-100">Insert Book</button>
				</form>
			</div>
		</div>
	</section>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

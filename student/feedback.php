
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comment Section</title>
    <link rel="stylesheet" href="./css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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

        .container {
            position: relative;
            z-index: 1;
        }

        .comment-box {
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            max-width: 600px;
            margin: auto;
            text-align: center;
        }

        .comment-box h3 {
            font-size: 26px;
            font-weight: bold;
            color: #d4af37;
            text-transform: uppercase;
            letter-spacing: 1.5px;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #fff;
        }

        .form-control::placeholder {
            color: #bbb;
        }

        .btn-primary {
            background-color: #d4af37;
            border: none;
            font-weight: bold;
            transition: 0.3s ease-in-out;
        }

        .btn-primary:hover {
            background-color: #b89b2e;
            color: white;
        }

        .comments-container {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(8px);
            max-width: 800px;
            margin: auto;
            margin-top: 30px;
        }

        .card {
            background: rgba(255, 255, 255, 0.1);
            border: none;
            color: #e0e0e0;
        }

        .card h6 {
            color: #d4af37;
        }

        .card p {
            font-size: 16px;
        }

        .text-muted {
            color: #bbb !important;
        }

        @media (max-width: 768px) {
            .comment-box,
            .comments-container {
                padding: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="overlay"></div>

    <!-- Responsive Navbar -->
    <?php include "navbar.php"; ?>

    <!-- Comment Section -->
    <div class="container my-5">
        <div class="comment-box">
            <h3>Leave a Comment</h3>
            <form action="" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" name="username" placeholder="Your Name" required>
                </div>
                <div class="mb-3">
                    <textarea class="form-control" name="comment" placeholder="Add a comment..." required></textarea>
                </div>
                <input type="submit" class="btn btn-primary w-100" name="submit" value="Post Comment">
            </form>
        </div>

        <div class="comments-container mt-4">
            <h3 class="text-center">Recent Comments</h3>

            <?php
            include "connection.php";

            if (isset($_POST['submit'])) {
                $username = htmlspecialchars($_POST['username']);
                $comment = htmlspecialchars($_POST['comment']);

                $sql = "INSERT INTO comments (username, comment) VALUES ('$username', '$comment')";
                mysqli_query($conn, $sql);
                header("Location: " . $_SERVER['PHP_SELF']);
                exit();
            }

            $sql = "SELECT * FROM comments ORDER BY created_at DESC";
            $res = mysqli_query($conn, $sql);

            if (mysqli_num_rows($res) > 0) {
                while ($row = mysqli_fetch_array($res)) {
                    echo "<div class='card mb-3'>
                        <div class='card-body'>
                            <h6 class='card-title'>" . htmlspecialchars($row['username']) . "</h6>
                            <p class='card-text'>" . htmlspecialchars($row['comment']) . "</p>
                            <small class='text-muted'>" . $row['created_at'] . "</small>
                        </div>
                    </div>";
                }
            } else {
                echo "<p class='text-center text-muted'>No comments yet.</p>";
            }
            ?>
        </div>
    </div>

    <footer>
        <?php include "footer.php"; ?>
    </footer>

</body>

</html>

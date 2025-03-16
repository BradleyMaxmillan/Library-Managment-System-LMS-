
<?php

include "connection.php";

$username = $_POST['username'];
$comment = $_POST['comment'];

if (isset($_POST['submit'])) {
    

    
        $sql = "INSERT INTO comments (username, comment) VALUES ('$username', '$comment')";
        mysqli_query($db,$sql);
        
}

$sql = "SELECT * FROM comments ORDER BY created_at DESC";
$res= mysqli_query($db,$sql);

if ($res->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='card mb-3'>
                <div class='card-body'>
                    <h6 class='card-title'>" . htmlspecialchars($row['username']) . "</h6>
                    <p class='card-text'>" . htmlspecialchars($row['comment']) . "</p>
                    <small class='text-muted'>" . $row['created_at'] . "</small>
                </div>
              </div>";
    }
} else {
    echo "<p>No comments yet.</p>";
}


?>
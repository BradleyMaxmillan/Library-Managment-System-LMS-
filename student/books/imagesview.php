<?php
include "connection.php";

$sql = "SELECT Title, Author, cover FROM books";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Library Books</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            text-align: center;
        }
        table {
            width: 80%;
            margin: 0 auto;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid black;
            padding: 10px;
        }
        th {
            background-color: #f2f2f2;
        }
        img {
            width: 100px;
            height: auto;
        }
    </style>
</head>
<body>

    <h2>Library Books</h2>
    <table>
        <tr>
            <th>Title</th>
            <th>Author</th>
            <th>Cover</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()) { ?>
        <tr>
            <td><?php echo htmlspecialchars($row['Title']); ?></td>
            <td><?php echo htmlspecialchars($row['Author']); ?></td>
            <td>
                <?php if (!empty($row['cover'])) { ?>
                    <img src="data:image/jpeg;base64,<?= base64_encode($row['cover']); ?>" alt="Book Cover">

                <?php } else { ?>
                    No Image
                <?php } ?>
            </td>
        </tr>
        <?php } ?>

    </table>

</body>
</html>

<?php $conn->close(); ?>

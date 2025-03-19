<?php

$host = "localhost";  // Change if your DB is hosted elsewhere
$user = "root";       // Your database username
$pass = "bradley2003";           // Your database password (XAMPP default is empty)
$dbname = "lms";  // Change to your actual database name

$conn = mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}


?>
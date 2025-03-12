<?php

$firstName = $_POST["firstName"];
$lastName = $_POST["lastName"];
$Username = $_POST["Username"];
$password = $_POST["password"];
$repeatPassword = $_POST["repeatPassword"];
$rollNo = $_POST["rollNo"];
$email = $_POST["email"];

$errors = array();

// Check for empty fields
if (empty($firstName) || empty($lastName) || empty($Username) || empty($password) || empty($repeatPassword) || empty($rollNo) || empty($email)) {
    array_push($errors, "All fields are required.");
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    array_push($errors, "Email is not valid.");
}

// Check password length
if (strlen($password) < 8) {
    array_push($errors, "Password must be at least 8 characters long.");
}

// Check if passwords match
if ($password !== $repeatPassword) {
    array_push($errors, "Passwords do not match.");
}

// Display errors
if (count($errors) > 0) {
    foreach ($errors as $error) {
        echo "<div>$error</div>";
    }
} else {
    echo "<div>Registration successful!</div>";
}

?>

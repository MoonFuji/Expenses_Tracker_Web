<?php
session_start();
require_once "../utility/db_connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];

    // Check if username already exists in the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if ($num_rows > 0) {
        $_SESSION['error_message'] = "Username already exists. Please choose a different username.";
    } else {
        // Insert user data into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "Signup successful. Please login to continue.";
            header("Location: login.php");
        } else {
            echo "Signup failed. Please try again.";
        }
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Login - Family Expense Tracker</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
</head>

<body>
    <header>
        <h1>Family Expense Tracker</h1>
    </header>
    <main>
        <div class="container">
            <div class="card">
                <h2>signup</h2>
                <form method="post" action="">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <label for="Email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <button type="submit">signup</button>
                </form>
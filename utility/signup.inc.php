<?php
session_start();
require_once "../utility/db_connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["user-name"];
    $password = $_POST["user-pwd"];
    $Repeated_password = $_POST["user-pwd-repeated"];

    // Check if username already exists in the database
    $sql = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if($password !== $Repeated_password){
            header("Location: ../front/signup.php?error=passwordcheckuid=".$username);
            exit();
    }
    if ($num_rows > 0) {
        $_SESSION['error_message'] = "Username already exists. Please choose a different username.";
    } else {
        // Insert user data into the database
        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
        $result = mysqli_query($conn, $sql);
        if ($result) {
            echo "Signup successful. Please login to continue.";
            header("Location: ../front/login.php");
            exit();
        } else {
            echo "Signup failed. Please try again.";
        }
    }
}
?>
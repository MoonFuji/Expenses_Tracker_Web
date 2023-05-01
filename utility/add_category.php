<?php
session_start();
require_once "../utility/db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get category name from form data
    $category_name = filter_input(INPUT_POST, 'category_name', FILTER_SANITIZE_SPECIAL_CHARS);

    // Prepare and execute SQL statement to insert new category into database
    $stmt = $conn->prepare("INSERT INTO categories (user_id, category_name) VALUES (?, ?)");
    $stmt->bind_param("is", $_SESSION["user_id"], $category_name);
    $success = $stmt->execute();

    if ($success) {
        header("Location: ../index.php");
        exit();
    } else {
        // Set error message
        echo "Error: " . $stmt->error;
        $_SESSION["error_message"] = "Failed to add category. Please try again later.";
    }
}

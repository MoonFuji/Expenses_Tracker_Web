<?php
session_start();
require_once "db_connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $category_id = $_POST["category_id"];
    $category_name = $_POST["category_name"];

    $stmt = $conn->prepare("UPDATE categories SET category_name = ? WHERE category_id = ?");
    // bind parameters
    $stmt->bind_param("ss", $category_name, $category_id);

    // execute statement
    if ($stmt->execute()) {
        // redirect back to homepage with success message
        header('Location: ../pages/categories.php?message=success');
        exit();
    } else {
        // redirect back to edit page with error message
        header("Location: ../pages/edit_category.php?category_id=$category_id&message=error: " . mysqli_error($conn));
        exit();
    }
}

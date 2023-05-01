<?php
require_once "db_connection.php";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $sub_user_id = $_POST["sub_user_id"];
    $username = $_POST["username"];

    $stmt = $conn->prepare("UPDATE sub_users SET username = ? WHERE sub_user_id = ?");
    // bind parameters
    $stmt->bind_param("ss", $username, $sub_user_id);

    // execute statement
    if ($stmt->execute()) {
        // redirect back to homepage with success message
        header('Location: ../pages/sub_users.php?message=success');
        exit();
    } else {
        // redirect back to edit page with error message
        header("Location: ../pages/edit_sub_user.php?category_id=$category_id&message=error: " . mysqli_error($conn));
        exit();
    }
}

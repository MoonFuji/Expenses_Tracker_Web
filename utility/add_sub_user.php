<?php

require_once "../utility/db_connection.php";
$user_id = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    // check if username already exists
    $sql = "SELECT COUNT(*) FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        // username already exists, show error message
        echo "Username already exists.";
    } else {
        $sql = "INSERT INTO sub_users (username, password, user_id) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $is_sub_user = true;
        $stmt->bind_param("ssi", $username, $password, $user_id);
        if ($stmt->execute()) {
            // sub user added successfully, show success message
            $success_message = "Sub user added successfully.";
            header('Location: ../index.php?message=success');
        } else {
            // failed to add sub user, show error message
            $error_message = "Failed to add sub user.";
            header('Location: ../index.php?message=error');
        }
    }
}

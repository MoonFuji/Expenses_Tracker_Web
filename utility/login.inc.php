<?php
require_once "db_connection.php";
if (isset($_POST['user-name']) && isset($_POST['user-pwd'])) {
    $username = $_POST['user-name'];
    $password = $_POST['user-pwd'];
    // Prepare the statement if user
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if ($password == $row['password']) {
            // Set session token
            session_regenerate_id();
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['username'] = $username;
            header('Location: ../index.php');
            exit();
        }
    } else {
        // Prepare the statement if sub_user
        $stmt = $conn->prepare("SELECT * FROM sub_users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            if ($password == $row['password']) {
                // Set session token
                session_regenerate_id();
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['sub_user_id'] = $row['sub_user_id'];
                $_SESSION['is_sub_user'] = true;
                $_SESSION['username'] = $username;
                header('Location: ../index.php');
                exit();
            }
        } else {
            // Invalid username or password
            $_SESSION['error_message'] = "Invalid username or password.";
            header('Location: ../pages/login.php');
            exit();
        }
    }
}

<?php
session_start();
require_once "../utility/db_connection.php";
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
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
            header('Location: ../login.php');
            exit();
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
                <h2>Login</h2>
                <form method="post" action="">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Login</button>
                </form>
                <!-- button to go to signup -->
                <a href="signup.php">Don't have an account? Signup here.</a>
            </div>
        </div>
    </main>
</body>

</html>
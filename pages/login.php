<?php
session_start();
require_once "db_connection.php";
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
                <form method="post" action="login.php">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                    <button type="submit">Login</button>
                </form>
                <?php
                if (isset($_POST['username']) && isset($_POST['password'])) {
                    $username = $_POST['username'];
                    $password = $_POST['password'];
                    // Prepare the statement
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
                            exit;
                        }
                    }

                    echo "<p class='error'>Invalid username or password.</p>";
                }
                ?>
            </div>
        </div>
    </main>
</body>

</html>
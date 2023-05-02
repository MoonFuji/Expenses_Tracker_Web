<?php
$username = $_SESSION['username'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
require_once "../utility/db_connection.php";
include "../utility/get_balances.php";
$global_balance = $user_balance + $sub_users_balance;
if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/welcome.html');
    exit();
}

?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="../style/style.css">
    <title>Edit Sub user</title>
</head>

<body>
    <header>
        <a href="../index.php" class="title">
            <h2>Family Expense Tracker</h2>
        </a>
        <div class="user-profile">
            <a href="../pages/revenue.php" class="btn">Revenue</a>
            <a href="../pages/expense.php" class="btn">Expense</a>
            <a href="../pages/categories.php" class="btn">Categories</a>
            <a href="../pages/sub_users.php" class="btn">Subusers</a>
            <a href="../utility/logout.php" class="btn">Logout</a>
        </div>
    </header>


    <?php
    // retrieve the expense_id from the URL
    if (isset($_POST['sub_user_id'])) {
        $sub_user_id = $_POST['sub_user_id'];
    } else {
        // if expense_id is not set, redirect to homepage
        header("Location: ../index.php");
        exit;
    }
    // retrieve the expense information from database
    $sql = "SELECT * FROM sub_users WHERE sub_user_id = ?";
    // prepare the sql statement
    $stmt = $conn->prepare($sql);
    // bind parameters
    $stmt->bind_param("i", $sub_user_id);
    // execute statement
    if (!$stmt->execute()) {
        die("Query failed: " . mysqli_error($conn));
    }
    // get query result
    $result = $stmt->get_result();
    // check if query was successful

    // check if expense exists
    if (mysqli_num_rows($result) == 0) {
        echo "sub_user not found.";
        mysqli_close($conn);
        exit;
    }

    // retrieve the expense data
    $row = mysqli_fetch_assoc($result);
    $username = $row['username'];
    ?>
    <h3>Edit sub_user</h3>

    <div class="container-expenses">
        <form id="form" action="../utility/update_sub_user.php" method="POST">
            <input type="hidden" name="sub_user_id" value="<?php echo $sub_user_id; ?>">
            <div class="form-control">
                <label for="username">Username</label><br>
                <input type="text" name="username" value="<?php echo $username; ?>"><br>
            </div>
            <input class="btn" type="submit" value="Update">
        </form>
    </div>
</body>

</html>
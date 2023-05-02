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
    <title>Transfer</title>
</head>

<body>
    <header>
        <a href="../index.php" class="title">
            <h2>Family Expense Tracker</h2>
        </a>
        <div class="user-profile">
            <a href="../utility/logout.php" class="btn-out">Logout</a>
        </div>
    </header>
    <div class="balance">
        <h4>Your balance :</h4>
        <h1><?php echo $user_balance ?>DA</h1>
    </div>
    <!-- fetch all subusers -->
    <?php
    $sql = "SELECT * FROM sub_users WHERE user_id = $user_id";
    $result = mysqli_query($conn, $sql);
    ?>
    <h3>Transfer</h3>

    <div class="container-expenses">
        <form id="form" action="../utility/transfer.php" method="POST">
            <div class="form-control">
                <label for="amount">Amount</label>
                <input type="number" name="amount" id="amount" placeholder="Amount" required>
            </div>
            <div class="form-control">
                <label for="Send to">Send To</label>
                <select name="sub_user_id">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = "";
                        if ($row['sub_user_id'] == $sub_user_id) {
                            $selected = "selected";
                        }
                        echo '<option value="' . $row['sub_user_id'] . '" ' . $selected . '>' . $row['username'] . '</option>';
                    }
                    ?>
                </select><br>
                <input class="btn" type="submit" value="Transfer">
            </div>
</body>

</html>
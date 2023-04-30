<?php
require_once "utility/db_connection.php";
include "utility/get_balance.php";
include "utility/get_subusers_balance.php";
$global_balance = $user_balance + $sub_users_balance;
?>

<!DOCTYPE html>
<html>

<head>
    <title>Family Expense Tracker</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
</head>
<?php
if (!isset($_SESSION['user_id'])) {
    // Redirect the user to the login page
    header('Location: pages/login.php');
    exit;
} ?>

<body>
    <header>
        <h1>Family Expense Tracker</h1>
        <?php
        // Show login button if user is not logged in
        if (!isset($_SESSION['user_id'])) {
            echo '<a href="pages/login.php" class="button">Login</a>';
        } else {
            // Show user profile and logout button if user is logged in
            echo '<div class="user-profile">';
            echo '<p>Welcome, ' . $_SESSION['username'] . '</p>';
            echo '<a href="pages/profile.php" class="button">Profile</a>';
            echo '<a href="utility/logout.php" class="button">Logout</a>';
            echo '</div>';
        }
        ?>
    </header>
    <main>
        <div class="container">
            <div class="card">
                <h2>Your Balance</h2>
                <div id="user-balance" class="balance">
                    <p> <?php echo "$user_balance"  ?></p>

                </div>
            </div>
            <div class="card">
                <h2>Sub-users Balance</h2>
                <div id="sub-users-balance" class="balance">
                    <p> <?php echo "$sub_users_balance"  ?></p>

                </div>
            </div>
            <div class="card">
                <h2>Global Balance</h2>
                <div id="global-balance" class="balance">
                    <p> <?php echo "$global_balance"  ?></p>
                </div>
            </div>
        </div>
        <?php
        // Fetch the revenues from the database
        $stmt = $conn->prepare("SELECT revenue_id, description, amount FROM Revenue WHERE user_id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        ?>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['amount']; ?></td>
                        <td>
                            <button href="./pages/edit_revenue.php?revenue_id=<?php echo $row['revenue_id']; ?>">Edit</button>
                            <button>Delete</button>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>


    </main>
    <footer>
        <p>&copy; 2021 - Family Expense Tracker</p>
</body>

</html>
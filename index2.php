<?php
require_once "utility/db_connection.php";
include "utility/get_balances.php";
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
            echo '<a href="pages/signup.php" class="button">signup</a>';
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
                    <p> <?php echo $user_balance  ?></p>

                </div>
            </div>
            <div class="card">
                <h2>Sub-users Balance</h2>
                <div id="sub-users-balance" class="balance">
                    <p> <?php echo $sub_users_balance  ?></p>

                </div>
            </div>
            <div class="card">
                <h2>Global Balance</h2>
                <div id="global-balance" class="balance">
                    <p> <?php echo $global_balance ?></p>
                </div>
            </div>
        </div>
        <!-- button to add revenue  -->
        <a href="pages/add_transaction.php" class="button">Add transaction</a>
        <?php
        // Fetch the revenues from the database
        $stmt = $conn->prepare("SELECT revenue.*, categories.category_name 
        FROM revenue 
        JOIN categories ON revenue.category_id = categories.category_id 
        WHERE revenue.user_id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        ?>
        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Description</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['category_name']; ?></td>
                        <td><?php echo $row['revenue_description']; ?></td>
                        <td><?php echo $row['revenue_amount']; ?></td>
                        <td><?php echo $row['date_added']; ?></td>
                        <td>
                            <form action="pages/edit_revenue.php" method="post">
                                <input type="hidden" name="revenue_id" value="<?php echo $row['revenue_id'] ?>">
                                <button type="submit">Edit </button>
                            </form>
                            <form action="utility/delete_revenue.php" method="post">
                                <input type="hidden" name="revenue_id" value="<?php echo $row['revenue_id'] ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
        <!-- fetch expenses from database-->
        <?php
        // Fetch the expenses from the database
        $stmt = $conn->prepare("SELECT expenses.*, categories.category_name 
        FROM expenses 
        JOIN categories ON expenses.category_id = categories.category_id 
        WHERE expenses.user_id = ?");
        $stmt->bind_param("i", $_SESSION['user_id']);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();
        ?>

        <table>
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Amount</th>
                    <th>description</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $row['category_name']; ?></td>
                        <td><?php echo $row['expense_amount']; ?></td>
                        <td><?php echo $row['expense_description']; ?></td>
                        <td><?php echo $row['date_added']; ?></td>
                        <td>
                            <form action="pages/edit_expense.php" method="post">
                                <input type="hidden" name="expense_id" value="<?php echo $row['expense_id'] ?>">
                                <button type="submit">Edit </button>
                            </form>
                            <form action="utility/delete_expense.php" method="post">
                                <input type="hidden" name="expense_id" value="<?php echo $row['expense_id'] ?>">
                                <button type="submit">Delete</button>
                            </form>
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
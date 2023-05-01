<?php
$username = $_SESSION['username'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
require_once "utility/db_connection.php";
include "utility/get_balances.php";
$global_balance = $user_balance + $sub_users_balance;
if (!isset($_SESSION['user_id'])) {
    header('Location: pages/welcome.html');
    exit();
}

?>
<!doctype html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/style.css">

    <title>Familly Expense Tracker</title>
</head>

<body>
    <header>
        <h2>Family Expense Tracker</h2>
        <?php
        if (!isset($_SESSION['user_id'])) {
            echo '<a href="pages/login.php" class="button">Login</a>';
            echo '<a href="pages/signup.php" class="button">signup</a>';
        } else {
            echo '<div class="user-profile">';
            echo '<a href="utility/logout.php" class="btn-out">Logout</a>';
            echo '</div>';
        } ?>
    </header>
    <h2 class="welcome">Welcome
        <?php echo $username; ?> !</h2>
    <div class="balances">
        <div class="balance">

            <h4>Your balance :</h4>
            <h1><?php echo $user_balance ?>DA</h1>
        </div>
        <div class="balance">
            <h4>Sub Users balance :</h4>
            <h1><?php echo $sub_users_balance ?>DA</h1>
        </div>
        <div class="balance">

            <h4>Global balance :</h4>
            <h1><?php echo $global_balance ?>DA</h1>
        </div>
    </div>

    <div class="container">
        <div class="inc-exp-container">
            <a href="pages/revenue.php">
                <h4>Revenue</h4>
                <p id="money-plus" class="money plus">+ <?php echo $user_revenue ?> DA</p>
            </a>
            <a href="pages/expense.php">
                <h4>Expense</h4>
                <p id="money-minus" class="money minus">-<?php echo $user_expenses ?> DA</p>
            </a>
        </div>

        <h3>Add new Transaction</h3>
        <form id="form" action="utility/add_transaction.php" method="post">
            <div class="form-control">
                <label for="transaction">Choose a transaction (Revenue / Expense)</label>
                <select id="transaction" name="transaction">
                    <option value=''>-------Select Transaction Type------</option>
                    <option value="revenue">Revenue</option>
                    <option value="expense">Expense</option>

                </select>
            </div>
            <div class="form-control">
                <label for="amount">Amount <br />
                </label>
                <div id="amount">
                    <input type="number" placeholder="Enter amount..." required />
                </div>
            </div>

            <div class="form-control">
                <label for="text">Description</label>
                <div id="description">
                    <input type="text" placeholder="Enter name of transaction..." required />
                </div>
            </div>
            <div class="form-control">
                <label for="date">Date<br />
                </label>
                <input type="Date" name="date_added" id="date" />
            </div>
            <div class="form-control">
                <label for="categories">Category</label>
                <select id="categories" name="category_id">
                    <option value=''>-------Select category------</option>
                    <?php
                    // SQL query to get all categories
                    $sql = "SELECT * FROM categories WHERE user_id=$user_id";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<option value='" . $row["category_id"] . "'>" . $row["category_name"] . "</option>";
                        }
                    }
                    ?>
                    <option value="other">-------Go To Add Category------</option>
                </select>
            </div>
            <button class="btn">Add transaction</button>
        </form>
    </div>
    <!-- end add new transation -->
    <section>
        <div class="sub-user">
            <a href="pages/sub_users.php">
                <h3>Add or Edit Sub-user</h3>
            </a>

            <form id="form" method="post" action="utility/add_sub_user.php">
                <div class="form-control">
                    <label for="text">Name of sub-user</label>
                    <input type="text" name="username" id="text" required placeholder="Enter name sub-user..." />
                </div>
                <div class="form-control">
                    <label for="password">Password of sub-user</label>
                    <input required type="text" name="password" id="password" placeholder="Enter password sub-user..." />
                </div>
                <button class="btn" type="submit">Add Sub-user</button>
            </form>
        </div>
        <div class="add-category">
            <a href="pages/categories.php">
                <h3>Add or Edit Category</h3>
            </a>
            <form id="addcategory" method="post" action="utility/add_category.php">
                <div class="form-control">
                    <label for="text">Name of category</label>
                    <input required type="text" name="category_name" id="categories_add" placeholder="Enter name category..." />
                </div>
                <button class="btn" type="submit">Add Category</button>
            </form>
        </div>

    </section>


</body>

</html>

<script>
    var transactionSelect = document.getElementById("transaction");
    var amountDescription = document.getElementById("amount");
    var descriptionInput = document.getElementById("description");

    transactionSelect.addEventListener("change", function() {
        var selectedTransaction = transactionSelect.value;

        amountDescription.innerHTML = "<input type='number' name='" + selectedTransaction + "_amount' required>";
        descriptionInput.innerHTML = "<input type='text' name='" + selectedTransaction + "_description' required>";

    });
</script>
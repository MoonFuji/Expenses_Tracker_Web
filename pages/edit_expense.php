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
    <title>EDIT EXPENSE</title>
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
    if (isset($_POST['expense_id'])) {
        $expense_id = $_POST['expense_id'];
    } else {
        // if expense_id is not set, redirect to homepage
        header("Location: ../index.php");
        exit;
    }
    // retrieve the expense information from database
    $sql = "SELECT expense_amount, expense_description, date_added, category_id FROM expenses WHERE expense_id = ?";
    // prepare the sql statement
    $stmt = $conn->prepare($sql);
    // bind parameters
    $stmt->bind_param("i", $expense_id);
    // execute statement
    if (!$stmt->execute()) {
        die("Query failed: " . mysqli_error($conn));
    }
    // get query result
    $result = $stmt->get_result();
    // check if query was successful

    // check if expense exists
    if (mysqli_num_rows($result) == 0) {
        echo "expense not found.";
        mysqli_close($conn);
        exit;
    }

    // retrieve the expense data
    $row = mysqli_fetch_assoc($result);
    $expense_amount = $row['expense_amount'];
    $expense_description = $row['expense_description'];
    $expense_date = $row['date_added'];
    $category_id = $row['category_id'];

    // retrieve the category information from database
    $sql = "SELECT category_id, category_name FROM categories where user_id = $user_id";
    // execute statement
    if (!$result = mysqli_query($conn, $sql)) {
        die("Query failed: " . mysqli_error($conn));
    }
    ?>

    <h3>Edit Expenses</h3>

    <div class="container-expenses">
        <form id="form" action="../utility/update_expense.php" method="POST">
            <input type="hidden" name="expense_id" value="<?php echo $expense_id; ?>">

            <div class="form-control">
                <label for="expense amount">Expense Amount:</label>
                <input type="number" name="expense_amount" value="<?php echo $expense_amount; ?>"><br>
            </div>


            <div class="form-control">
                <label for="description">Description</label>
                <input type="text" name="expense_description" value="<?php echo $expense_description; ?>"><br>
            </div>
            <div class="form-control">
                <label for="date">Date:</label>
                <input type="date" name="date_added" value="<?php echo $expense_date; ?>"><br>
            </div>
            <div class="form-control">
                <label for="categories">Category</label>
                <select name="category_id">
                    <?php
                    while ($row = mysqli_fetch_assoc($result)) {
                        $selected = "";
                        if ($row['category_id'] == $category_id) {
                            $selected = "selected";
                        }
                        echo '<option value="' . $row['category_id'] . '" ' . $selected . '>' . $row['category_name'] . '</option>';
                    }
                    ?>
                </select><br>
                <input class="btn" type="submit" value="Update">
        </form>
    </div>
</body>

</html>
<?php
require_once "../utility/db_connection.php";
$user_id = $_SESSION['user_id'];

?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit expense</title>
</head>

<body>
    <h2>Edit expense</h2>
    <?php
    // retrieve the expense_id from the URL
    if (isset($_POST['expense_id'])) {
        $expense_id = $_POST['expense_id'];
    } else {
        // if expense_id is not set, redirect to homepage
        header("Location: ./index.php");
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

    <form action="../utility/update_expense.php" method="POST">
        <input type="hidden" name="expense_id" value="<?php echo $expense_id; ?>">
        <label>Amount:</label>
        <input type="number" name="expense_amount" value="<?php echo $expense_amount; ?>"><br>
        <label>Description:</label>
        <input type="text" name="expense_description" value="<?php echo $expense_description; ?>"><br>
        <label>Date:</label>
        <input type="date" name="date_added" value="<?php echo $expense_date; ?>"><br>
        <label>Category:</label>
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
        <input type="submit" value="Update">
    </form>
</body>

</html>
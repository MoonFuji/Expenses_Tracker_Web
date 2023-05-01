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
    <title>EDIT revenue</title>
</head>

<body>
    <header>
        <h2>Family Expense Tracker</h2>
        <div class="user-profile">
            <a href="../utility/logout.php" class="btn-out">Logout</a>
        </div>
    </header>


    <?php
    // retrieve the revenue_id from the URL
    if (isset($_POST['revenue_id'])) {
        $revenue_id = $_POST['revenue_id'];
    } else {
        // if revenue_id is not set, redirect to homepage
        header("Location: ../index.php");
        exit;
    }
    // retrieve the revenue information from database
    $sql = "SELECT revenue_amount, revenue_description, date_added, category_id FROM revenue WHERE revenue_id = ?";
    // prepare the sql statement
    $stmt = $conn->prepare($sql);
    // bind parameters
    $stmt->bind_param("i", $revenue_id);
    // execute statement
    if (!$stmt->execute()) {
        die("Query failed: " . mysqli_error($conn));
    }
    // get query result
    $result = $stmt->get_result();
    // check if query was successful

    // check if revenue exists
    if (mysqli_num_rows($result) == 0) {
        echo "revenue not found.";
        mysqli_close($conn);
        exit;
    }

    // retrieve the revenue data
    $row = mysqli_fetch_assoc($result);
    $revenue_amount = $row['revenue_amount'];
    $revenue_description = $row['revenue_description'];
    $revenue_date = $row['date_added'];
    $category_id = $row['category_id'];

    // retrieve the category information from database
    $sql = "SELECT category_id, category_name FROM categories where user_id = $user_id";
    // execute statement
    if (!$result = mysqli_query($conn, $sql)) {
        die("Query failed: " . mysqli_error($conn));
    }
    ?>

    <h3>Edit revenues</h3>

    <div class="container-expenses">
        <form id="form" action="../utility/update_revenue.php" method="POST">
            <input type="hidden" name="revenue_id" value="<?php echo $revenue_id; ?>">

            <div class="form-control">
                <label for="revenue amount">revenue Amount:</label>
                <input type="number" name="revenue_amount" value="<?php echo $revenue_amount; ?>"><br>
            </div>


            <div class="form-control">
                <label for="description">Description</label>
                <input type="text" name="revenue_description" value="<?php echo $revenue_description; ?>"><br>
            </div>
            <div class="form-control">
                <label for="date">Date:</label>
                <input type="date" name="date_added" value="<?php echo $revenue_date; ?>"><br>
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
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
    <title>Edit Category</title>
</head>

<body>
    <header>
        <h2>Family Expense Tracker</h2>
        <div class="user-profile">
            <a href="../utility/logout.php" class="btn-out">Logout</a>
        </div>
    </header>


    <?php
    // retrieve the expense_id from the URL
    if (isset($_POST['category_id'])) {
        $category_id = $_POST['category_id'];
    } else {
        // if expense_id is not set, redirect to homepage
        header("Location: ../index.php");
        exit;
    }
    // retrieve the expense information from database
    $sql = "SELECT * FROM categories WHERE category_id = ?";
    // prepare the sql statement
    $stmt = $conn->prepare($sql);
    // bind parameters
    $stmt->bind_param("i", $category_id);
    // execute statement
    if (!$stmt->execute()) {
        die("Query failed: " . mysqli_error($conn));
    }
    // get query result
    $result = $stmt->get_result();
    // check if query was successful

    // check if expense exists
    if (mysqli_num_rows($result) == 0) {
        echo "category not found.";
        mysqli_close($conn);
        exit;
    }

    // retrieve the expense data
    $row = mysqli_fetch_assoc($result);
    $category_name = $row['category_name'];
    $category_id = $row['category_id'];
    ?>
    <h3>Edit Category</h3>

    <div class="container-expenses">
        <form id="form" action="../utility/update_category.php" method="POST">
            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
            <div class="form-control">
                <label for="category_name">Category Name</label><br>
                <input type="text" name="category_name" value="<?php echo $category_name; ?>"><br>
            </div>
            <input class="btn" type="submit" value="Update">
        </form>
    </div>
</body>

</html>
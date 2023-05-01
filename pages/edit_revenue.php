<?php
require_once "../utility/db_connection.php";
$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit revenue</title>
</head>

<body>
    <h2>Edit revenue</h2>
    <?php
    // retrieve the revenue_id from the URL
    if (isset($_POST['revenue_id'])) {
        $revenue_id = $_POST['revenue_id'];
    } else {
        // if revenue_id is not set, redirect to homepage
        header("Location: ./index.php");
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
        echo "Revenue not found.";
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

    <form action="../utility/update_revenue.php" method="POST">
        <input type="hidden" name="revenue_id" value="<?php echo $revenue_id; ?>">
        <label>Amount:</label>
        <input type="number" name="revenue_amount" value="<?php echo $revenue_amount; ?>"><br>
        <label>Description:</label>
        <input type="text" name="revenue_description" value="<?php echo $revenue_description; ?>"><br>
        <label>Date:</label>
        <input type="date" name="date_added" value="<?php echo $revenue_date; ?>"><br>
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
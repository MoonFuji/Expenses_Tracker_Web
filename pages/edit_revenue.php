<?php
session_start();
require_once "db_connection.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Edit Revenue</title>
</head>

<body>
    <h2>Edit Revenue</h2>
    <?php
    // retrieve the revenue_id from the URL
    if (isset($_GET['revenue_id'])) {
        $revenue_id = $_GET['revenue_id'];
    } else {
        // if revenue_id is not set, redirect to homepage
        header("Location: ./index.php");
        exit;
    }
    // retrieve the revenue information from database
    $sql = "SELECT amount,description FROM Revenue WHERE revenue_id = ?";
    // prepare the sql statement
    $stmt = $conn->prepare($sql);
    // bind parameters
    $stmt->bind_param("i", $revenue_id);
    // execute statement
    if ($stmt->execute()) {
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
    $revenue_amount = $row['amount'];
    $revenue_description = $row['description'];
    ?>


    <form action="../utility/update_revenue.php" method="POST">
        <input type="hidden" name="revenue_id" value="<?php echo $revenue_id; ?>">
        <label>Amount:</label>
        <input type="number" name="amount" value="<?php echo $revenue_amount; ?>"><br>
        <label>Description:</label>
        <input type="text" name="description" value="<?php echo $revenue_description; ?>"><br>
        <input type="submit" value="Update">
    </form>
</body>

</html>
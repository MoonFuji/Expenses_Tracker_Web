<?php
require_once "../utility/db_connection.php";


// Prepare and execute the DELETE query
$stmt = $conn->prepare("DELETE FROM expenses WHERE expense_id = ?");
$stmt->bind_param("i", $_POST['expense_id']);
if (!$stmt->execute()) {
    die("Query failed: " . mysqli_error($conn));
}
// Redirect to the page that displays the updated list of revenues
header("Location: ../pages/expense.php");
exit;

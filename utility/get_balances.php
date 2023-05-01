<?php
// Connect to the database
require_once "db_connection.php";
$user_id = $_SESSION['user_id'];
$sub_user_id = $_SESSION['sub_user_id'];

// Prepare the SQL query to get the user balance
$stmt = $conn->prepare("SELECT 
        (SELECT IFNULL(SUM(revenue_amount),0) FROM revenue WHERE user_id = ? AND sub_user_id is NULL) - 
        (SELECT IFNULL(SUM(expense_amount),0) FROM expenses WHERE user_id = ? AND sub_user_id is NULL ) AS balance");
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
if ($stmt->errno) {
    echo "Error executing query: " . $stmt->error;
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_balance = $row["balance"];
} else {
    $_SESSION["error_message"] = "No balance found for the user.";
}

$stmt = $conn->prepare("SELECT SUM((SELECT IFNULL(SUM(revenue_amount),0) FROM Revenue WHERE user_id = ? AND sub_user_id IS NOT NULL) - 
(SELECT IFNULL(SUM(expense_amount),0) FROM Expenses WHERE user_id = ? AND sub_user_id IS NOT NULL)) AS balance FROM sub_users WHERE user_id = ?");
$stmt->bind_param("iii", $user_id, $user_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sub_users_balance = $row["balance"];
} else {
    $_SESSION["error_message"] = "No Sub-Users balance found.";
}

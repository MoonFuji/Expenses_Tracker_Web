<?php
// Connect to the database
require_once "db_connection.php";
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$sub_user_id = $_SESSION['sub_user_id'] ?? NULL;

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
    $_SESSION['user_balance'] = $row["balance"];
} else {
    $_SESSION["error_message"] = "No balance found for the user.";
}




// Prepare the SQL query to get the user revenue
$stmt = $conn->prepare("SELECT 
        (SELECT IFNULL(SUM(revenue_amount),0) FROM revenue WHERE user_id = ? AND sub_user_id is NULL) AS revenue");
$stmt->bind_param("i", $user_id);
$stmt->execute();
if ($stmt->errno) {
    echo "Error executing query: " . $stmt->error;
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_revenue = $row["revenue"];
} else {
    $_SESSION["error_message"] = "No revenue found for the user.";
}


// Prepare the SQL query to get the user expenses
$stmt = $conn->prepare("SELECT 
        (SELECT IFNULL(SUM(expense_amount),0) FROM expenses WHERE user_id = ? AND sub_user_id is NULL) AS expense");
$stmt->bind_param("i", $user_id);
$stmt->execute();
if ($stmt->errno) {
    echo "Error executing query: " . $stmt->error;
}

$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_expenses = $row["expense"];
} else {
    $_SESSION["error_message"] = "No revenue found for the user.";
}



// sub users balance 

$stmt = $conn->prepare("SELECT COALESCE(SUM(r.revenue_amount), 0) - COALESCE(SUM(e.expense_amount), 0) AS balance
FROM sub_users s
LEFT JOIN revenue r ON s.sub_user_id = r.sub_user_id AND r.user_id = s.user_id
LEFT JOIN expenses e ON s.sub_user_id = e.sub_user_id AND e.user_id = s.user_id
WHERE s.user_id = ?");

// $stmt = $conn->prepare("SELECT SUM((SELECT IFNULL(SUM(revenue_amount),0) FROM Revenue WHERE user_id = ? AND sub_user_id IS NOT NULL) - 
// (SELECT IFNULL(SUM(expense_amount),0) FROM Expenses WHERE user_id = ? AND sub_user_id IS NOT NULL)) AS balance FROM sub_users WHERE user_id = ?");
$stmt->bind_param("i",  $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $sub_users_balance = $row["balance"];
    $_SESSION['sub_users_balance'] = $row["balance"];
} else {
    $_SESSION["error_message"] = "No Sub-Users balance found.";
}

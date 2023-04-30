<?php
session_start();
require_once "db_connection.php";
// get revenue id from hidden input field
$revenue_id = $_POST['revenue_id'];
// get form data
$description = $_POST['description'];
$amount = $_POST['amount'];

// prepare update statement
$stmt = $conn->prepare("UPDATE revenue SET description = ? , amount = ? WHERE revenue_id = ?");

// bind parameters
$stmt->bind_param("ssdi", $description, $amount, $revenue_id);

// execute statement
if ($stmt->execute()) {
    // redirect back to homepage with success message
    header('Location: ../index.php?message=success');
    exit();
} else {
    // redirect back to edit page with error message
    header("Location: ./pages/edit_revenue.php?id=$revenue_id&message=error");
    exit();
}

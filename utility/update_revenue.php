<?php
session_start();
require_once "db_connection.php";
// get revenue id from hidden input field
$revenue_id = $_POST['revenue_id'];
// get form data
$description = $_POST['revenue_description'];
$amount = $_POST['revenue_amount'];
$category = $_POST['category_id'];
if (isset($_POST['date_added'])) {
    $date = $_POST['date_added'];
    $stmt = $conn->prepare("UPDATE revenue SET revenue_description = ?, revenue_amount = ?, category_id = ?, date_added = ? WHERE revenue_id = ?");
    // bind parameters
    $stmt->bind_param("sdisi", $description, $amount, $category, $date, $revenue_id);

    // execute statement
    if ($stmt->execute()) {
        // redirect back to homepage with success message
        header('Location: ../pages/revenue.php?message=success');
        exit();
    } else {
        // redirect back to edit page with error message
        header("Location: ../pages/edit_revenue.php?revenue_id=$revenue_id&message=error: " . mysqli_error($conn));
        exit();
    }
} else {
    $stmt = $conn->prepare("UPDATE revenue SET revenue_description = ?, revenue_amount = ?, category_id = ? WHERE revenue_id = ?");

    // bind parameters
    $stmt->bind_param("sdii", $description, $amount, $category,  $revenue_id);

    // execute statement
    if ($stmt->execute()) {
        // redirect back to homepage with success message
        header('Location: ../pages/revenue.php?message=success');
        exit();
    } else {
        // redirect back to edit page with error message
        header("Location: ../pages/edit_revenue.php?revenue_id=$revenue_id&message=error: " . mysqli_error($conn));
        exit();
    }
}

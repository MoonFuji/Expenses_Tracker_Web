<?php
session_start();
require_once "db_connection.php";
// get expense id from hidden input field
$expense_id = $_POST['expense_id'];
// get form data
$description = $_POST['expense_description'];
$amount = $_POST['expense_amount'];
$category = $_POST['category_id'];
if (isset($_POST['date_added'])) {
    $date = $_POST['date_added'];
    $stmt = $conn->prepare("UPDATE expenses SET expense_description = ?, expense_amount = ?, category_id = ?, date_added = ? WHERE expense_id = ?");
    // bind parameters
    $stmt->bind_param("sdisi", $description, $amount, $category, $date, $expense_id);

    // execute statement
    if ($stmt->execute()) {
        // redirect back to homepage with success message
        header('Location: ../index.php?message=success');
        exit();
    } else {
        // redirect back to edit page with error message
        header("Location: ../pages/edit_expense.php?expense_id=$expense_id&message=error: " . mysqli_error($conn));
        exit();
    }
} else {
    $stmt = $conn->prepare("UPDATE expenses SET expense_description = ?, expense_amount = ?, category_id = ? WHERE expense_id = ?");

    // bind parameters
    $stmt->bind_param("sdii", $description, $amount, $category,  $expense_id);

    // execute statement
    if ($stmt->execute()) {
        // redirect back to homepage with success message
        header('Location: ../index.php?message=success');
        exit();
    } else {
        // redirect back to edit page with error message
        header("Location: ../pages/edit_expense.php?expense_id=$expense_id&message=error: " . mysqli_error($conn));
        exit();
    }
}

<?php
session_start();
require_once "../utility/db_connection.php";
$user_id = $_SESSION["user_id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $transaction = filter_input(INPUT_POST, 'transaction', FILTER_SANITIZE_SPECIAL_CHARS);
    $category_id = filter_input(INPUT_POST, 'category_id', FILTER_SANITIZE_SPECIAL_CHARS);
    $date_added = filter_input(INPUT_POST, 'date_added', FILTER_SANITIZE_SPECIAL_CHARS);
    // switch case depenidng on transaction is expense or revenue 
    switch ($transaction) {
        case "expense":
            $expense_amount = filter_input(INPUT_POST, 'expense_amount', FILTER_SANITIZE_NUMBER_INT);
            $expense_description = filter_input(INPUT_POST, 'expense_description', FILTER_SANITIZE_SPECIAL_CHARS);
            if (isset($_SESSION['is_sub_user'])) {
                // prepare the sql statement
                $sql = "INSERT INTO expenses (user_id, sub_user_id, category_id, expense_amount,   expense_description,date_added  ) VALUES (?, ?, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                // bind parameters
                $stmt->bind_param("isssss", $user_id, $_SESSION['sub_user_id'], $category_id, $expense_amount, $expense_description, $date_added);
            } else {
                // prepare the sql statement
                $sql = "INSERT INTO expenses (user_id, sub_user_id, category_id, expense_amount,   expense_description,date_added  ) VALUES (?,NULL, ?, ?, ?, ?)";
                $stmt = $conn->prepare($sql);
                // bind parameters
                $stmt->bind_param("issss", $user_id, $category_id, $expense_amount, $expense_description, $date_added);
            }
            // execute statement and handle errors
            if ($stmt->execute()) {
                echo "expense added successfully";
                header('Location: ../pages/index.php?message=success');
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            break;
        case "revenue":
            $revenue_amount = filter_input(INPUT_POST, 'revenue_amount', FILTER_SANITIZE_NUMBER_INT);
            $revenue_description = filter_input(INPUT_POST, 'revenue_description', FILTER_SANITIZE_SPECIAL_CHARS);
            if (isset($_SESSION['is_sub_user'])) {
                // prepare the sql statement
                $sql = "INSERT INTO revenue (user_id, sub_user_id ,category_id, revenue_amount,  revenue_description,date_added  ) VALUES (?, ?, ?, ?, ?,?)";
                $stmt = $conn->prepare($sql);
                // bind parameters
                $stmt->bind_param("isssss", $user_id, $_SESSION['sub_user_id'], $category_id, $revenue_amount,  $revenue_description, $date_added);
            } else {
                // prepare the sql statement
                $sql = "INSERT INTO revenue (user_id, sub_user_id ,category_id, revenue_amount,  revenue_description,date_added  ) VALUES (?, NULL, ?, ?, ?,?)";
                $stmt = $conn->prepare($sql);
                // bind parameters
                $stmt->bind_param("issss", $user_id, $category_id, $revenue_amount,  $revenue_description, $date_added);
            }
            if ($stmt->execute()) {
                echo "revenue added successfully";
                header('Location: ../pages/index.php?message=success');
                exit();
            } else {
                echo "Error: " . $stmt->error;
            }
            break;
        default:
            echo "Error: invalid transaction";
    }
}

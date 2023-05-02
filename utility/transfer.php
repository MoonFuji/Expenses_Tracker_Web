<?php
require_once "../utility/db_connection.php";
include "../utility/get_balances.php";
$username = $_SESSION['username'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $amount = $_POST["amount"] ?? null;
    $sub_user_id = $_POST["sub_user_id"] ?? null;

    // Validate inputs
    if (!is_numeric($amount) || $amount <= 0) {
        // Redirect back to the transfer page with an error message
        header("Location: ../pages/transfer.php?error=Invalid amount");
        exit();
    }

    // Check if the amount exceeds the user balance
    if ($amount > $user_balance) {
        // Redirect back to the transfer page with an error message
        header("Location: ../pages/transfer.php?error=Amount exceeds your balance");
        exit();
    }

    // Get the sub_user_id of the receiver
    $stmt = $conn->prepare("SELECT sub_user_id, username FROM sub_users WHERE sub_user_id = ?");
    $stmt->bind_param("i", $sub_user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // Redirect back to the transfer page with an error message
        header("Location: ../pages/transfer.php?error=Invalid sub user");
        exit();
    }

    $row = $result->fetch_assoc();
    $sub_username = $row['username'];

    // Insert the expense into expenses table
    $stmt = $conn->prepare("INSERT INTO expenses (user_id, category_id, expense_amount, expense_description) VALUES (?, 1, ?, ?)");
    $expense_desc = "Transfer to $sub_username";
    $stmt->bind_param("ids", $user_id, $amount, $expense_desc);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO revenue (user_id, sub_user_id, category_id, revenue_amount, revenue_description) VALUES (?, ?, 1, ?, ?)");
    $revenue_desc = "Transfer from $username";
    $stmt->bind_param("iids", $user_id, $sub_user_id, $amount, $revenue_desc);
    $stmt->execute();

    $stmt = $conn->prepare("INSERT INTO transfers (from_user_id, to_user_id, amount, description) VALUES (?, ?, ?, ?)");
    $transfer_desc = "Transfer to $sub_username";
    $stmt->bind_param("iiis", $user_id, $sub_user_id, $amount, $transfer_desc);
    $stmt->execute();


    // Redirect back to the sub_users page with a success message
    header('Location: ../pages/sub_users.php?message=success');
    exit();
}

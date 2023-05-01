<?php
require_once "../utility/db_connection.php";


// Prepare and execute the DELETE query
$stmt = $conn->prepare("DELETE FROM categories WHERE category_id = ?");
$stmt->bind_param("i", $_POST['category_id']);
if (!$stmt->execute()) {
    die("Query failed: " . mysqli_error($conn));
}
// Redirect to the page that displays the updated list of revenues
header("Location: ../pages/categories.php");
exit;

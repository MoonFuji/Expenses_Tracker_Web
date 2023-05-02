<?php
$username = $_SESSION['username'] ?? null;
$user_id = $_SESSION['user_id'] ?? null;
require_once "../utility/db_connection.php";
include "../utility/get_balances.php";
$global_balance = $user_balance + $sub_users_balance;
if (!isset($_SESSION['user_id'])) {
	header('Location: ../pages/welcome.html');
	exit();
}
$stmt = $conn->prepare("SELECT * FROM sub_users WHERE user_id = ?");
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

?>
<!doctype html>
<html lang="en">

<head>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../style/style2.css">
	<title>Familly Expense Tracker</title>
</head>

<body>
	<header>
		<a href="../index.php" class="title">
			<h2>Family Expense Tracker</h2>
		</a>
		<div class="user-profile">
			<a href="../pages/revenue.php" class="btn">Revenue</a>
			<a href="../pages/expense.php" class="btn">Expense</a>
			<a href="../pages/categories.php" class="btn">Categories</a>
			<a href="../utility/logout.php" class="btn">Logout</a>
		</div>
	</header>

	<h2 class="welcome">Welcome
		<?php echo $username; ?> !</h2>
	<div class="balances">
		<div class="balance">
			<h4>Your balance :</h4>
			<h1><?php echo $user_balance ?>DA</h1>
		</div>
		<div class="balance">
			<h4>Sub Users balance :</h4>
			<h1><?php echo $sub_users_balance ?>DA</h1>
		</div>
		<div class="balance">

			<h4>Global balance :</h4>
			<h1><?php echo $global_balance ?>DA</h1>
		</div>
	</div>
	<div class="inc-exp-container">
		<a href="revenue.php">
			<h4>Revenue</h4>
			<p id="money-plus" class="money plus">+ <?php echo $user_revenue ?> DA</p>
		</a>
		<a href="expense.php">
			<h4>Expense</h4>
			<p id="money-minus" class="money minus">-<?php echo $user_expenses ?> DA</p>
		</a>
	</div>
	<a href="transfer.php">
		<button class="btn-add">Transfer</button>
	</a>


	<section>
		<h3>Sub Users</h3>
		<div class="container-expenses">
			<table>
				<thead>
					<tr>
						<th>User name</th>
						<th>Balance</th>
						<th>Actions</th>
					</tr>
				</thead>
				<?php while ($row = $result->fetch_assoc()) {
					$stmt1 = $conn->prepare("SELECT sub_users.username, sub_users.sub_user_id, 
					COALESCE(SUM(revenue.revenue_amount), 0) - COALESCE(SUM(expenses.expense_amount), 0) AS balance 
					FROM sub_users 
					LEFT JOIN revenue ON sub_users.sub_user_id = revenue.sub_user_id 
					LEFT JOIN expenses ON sub_users.sub_user_id = expenses.sub_user_id 
					WHERE sub_users.user_id = ? AND sub_users.sub_user_id = ?					
					");
					// $stmt1 = $conn->prepare("SELECT SUM((SELECT IFNULL(SUM(revenue_amount),0) FROM Revenue WHERE user_id = ? AND sub_user_id = ?) - 
					// (SELECT IFNULL(SUM(expense_amount),0) FROM Expenses WHERE user_id = ? AND sub_user_id = ? )) AS balance FROM sub_users WHERE user_id = ?");
					$stmt1->bind_param("ii", $user_id, $row['sub_user_id']);
					$stmt1->execute();
					$result1 = $stmt1->get_result();
					$row1 = $result1->fetch_assoc();
				?>
					<tbody>
						<tr>
							<td><?php echo $row['username'] ?></td>
							<td><?php echo $row1['balance'] ?? 0 ?></td>
							<td>
								<form action="../pages/edit_sub_user.php" method="post">
									<input type="hidden" name="sub_user_id" value=" <?php echo $row['sub_user_id'] ?>">
									<button type="submit" class="btn-edit">Edit</button>
								</form>
								<form action="../utility/delete_sub_user.php" method="post">
									<input type="hidden" name="sub_user_id" value=" <?php echo $row['sub_user_id'] ?>">
									<button type="submit" class="btn-delete">Delete</button>
								</form>
							</td>
						</tr>
					<?php } ?>
					</tbody>
			</table>
			<div class="btn-container">
				<button type="button" class="btn-add">Add Sub User</button>
			</div>
		</div>
</body>

</html>
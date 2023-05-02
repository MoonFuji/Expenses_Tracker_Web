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
			<a href="../pages/expense.php" class="btn">Expense</a>
			<a href="../pages/categories.php" class="btn">Categories</a>
			<a href="../pages/sub_users.php" class="btn">Subusers</a>
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
	<section>
		<h3>Revenues</h3>
		<?php
		// Fetch the revenues from the database
		$stmt = $conn->prepare("SELECT revenue.*, categories.category_name 
        FROM revenue 
        JOIN categories ON revenue.category_id = categories.category_id 
        WHERE revenue.user_id = ?");
		$stmt->bind_param("i", $_SESSION['user_id']);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		?>
		<div class="container-expenses">
			<table>
				<thead>
					<tr>
						<th>Category</th>
						<th>Amount</th>
						<th>Description</th>
						<th>Date</th>
						<th>Actions</th>
					</tr>
				</thead>
				<tbody>
					<?php while ($row = $result->fetch_assoc()) { ?>
						<tr>
							<td><?php echo $row['category_name']; ?></td>
							<td><?php echo $row['revenue_description']; ?></td>
							<td><?php echo $row['revenue_amount']; ?></td>
							<td><?php echo $row['date_added']; ?></td>
							<td>
								<form action="../pages/edit_revenue.php" method="post">
									<input type="hidden" name="revenue_id" value="<?php echo $row['revenue_id'] ?>">
									<button class="btn-edit" type="submit">Edit </button>
								</form>
								<form action="../utility/delete_revenue.php" method="post">
									<input type="hidden" name="revenue_id" value="<?php echo $row['revenue_id'] ?>">
									<button class="btn-delete" type="submit">Delete</button>
								</form>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>
		</div>
</body>

</html>
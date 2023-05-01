<?php
require_once "../utility/db_connection.php";
// Fetch the revenues from the database
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
	<link rel="stylesheet" href="../style/style3.css">

	<title>Subusers
	</title>
</head>

<body>
	<header>
		<a href="../index.php" class="title">
			<h2>Family Expense Tracker</h2>
		</a>
	</header>
	<h2 class="user-name">Charchar Imad eddine</h3>
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
					$stmt1 = $conn->prepare("SELECT SUM((SELECT IFNULL(SUM(revenue_amount),0) FROM Revenue WHERE user_id = ? AND sub_user_id = ?) - 
					(SELECT IFNULL(SUM(expense_amount),0) FROM Expenses WHERE user_id = ? AND sub_user_id = ? )) AS balance FROM sub_users WHERE user_id = ?");
					$stmt1->bind_param("iiiss", $user_id, $row['sub_user_id'], $user_id, $row['sub_user_id'], $user_id);
					$stmt1->execute();
					$result1 = $stmt1->get_result();
					$row1 = $result1->fetch_assoc();
				?>
					<tbody>
						<tr>
							<td><?php echo $row['username'] ?></td>
							<td><?php echo $row1['balance'] ?? 0 ?></td>
							<td>
								<form action="../utility/edit_sub_user.php" method="post">
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
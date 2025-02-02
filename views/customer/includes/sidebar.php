<?php
include_once '../../models/db.php';

// Start the session
if (!isset($_SESSION)) {
	session_start();
}

// Check if the customer is logged in
if (!isset($_SESSION['customer_email'])) {
	echo "You are not logged in!";
	return;
}

// Database connection
$db = new db();
$conn = $db->createConObject();

// Fetch customer data securely
$query = "SELECT customer_image, customer_name FROM customers WHERE customer_email = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $_SESSION['customer_email']);
$stmt->execute();
$result = $stmt->get_result();
$row_customers = $result->fetch_assoc();

if ($row_customers) {
	$customer_image = $row_customers['customer_image'];
	$customer_name = $row_customers['customer_name'];
} else {
	echo "Customer data not found!";
	return;
}

$stmt->close();
$db->closeCon($conn);
?>

<div class="panel panel-default sidebar-menu">
	<div class="panel-heading">
		<center>
			<?php if (!empty($customer_image)): ?>
				<img src="../customer_images/<?php echo htmlspecialchars($customer_image); ?>" class="img-responsive">
			<?php endif; ?>
		</center>
		<br>
		<h3 align="center" class="panel-title">Name: <?php echo htmlspecialchars($customer_name); ?></h3>
	</div>

	<div class="panel-bdy">
		<ul class="nav nav-pills nav-staked">
			<li class="abc">
			<li>
				<a href="my_account.php?my_order"><i class="fa fa-list-alt"></i> My Order</a>
			</li>
			<li>
				<a href="my_account.php?pay_offline"><i class="fa fa-money"></i> Pay Offline</a>
			</li>
			<li>
				<a href="my_account.php?edit_act"><i class="fa fa-pencil-square"></i> Edit Account</a>
			</li>
			<li>
				<a href="my_account.php?change_pass"><i class="fa fa-key"></i> Change Password</a>
			</li>
			<li>
				<a href="my_account.php?delete_ac"><i class="fa fa-trash"></i> Delete Account</a>
			</li>
			<li>
				<a href="logout.php"><i class="fa fa-sign-out-alt"></i> Logout</a>
			</li>
		</ul>
	</div>
</div>
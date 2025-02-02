<?php

include '../controllers/PaymentController.php';
include '../controllers/CartController.php';

if (!isset($_SESSION['customer_email'])) {
	echo "<script>window.location.href='../checkout.php';</script>";
	exit();
}

// Fetch customer data
$customer_email = $_SESSION['customer_email'];
$customer = (new db())->getCustomerByEmail($customer_email);

if (!$customer) {
	echo "Customer data not found.";
	exit();
}
// Initialize the CartController
$cartController = new CartController();

$totalItems = $cartController->getTotalItems(); // Fetch total items
$totalPrice = $cartController->getTotalPrice(); // Fetch total price
$cartProducts = $cartController->getCartProducts(); // Fetch all cart products
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Gadget store</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

	<!-- owl carousel css file cdn link  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

	<!-- font awesome cdn link  -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

	<!-- custom css file link  -->
	<link rel="stylesheet" href="../css/style.css">
	<style>


	</style>

</head>

<body>

	<div class="box">
		<h1 class="text-center">Payment Options</h1>
		<p class="lead-text-center">
			<a href="order.php?c_id=<?php echo htmlspecialchars($customer['customer_id']); ?>">
				<span>Pay Offline (COD)</span>
			</a>
		</p>
		<center>
			<p class="lead">
				<img src="customer/customer_images/pay.png" width="500" height="270" class="img-responsive"><br>
			</p>
		</center>
	</div>
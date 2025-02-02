<?php
session_start();
include '../controllers/OrderController.php'


?>
<div class="confirmation-box">
	<h1>Thank You for Your Order!</h1>
	<p>Your order has been successfully placed. You will receive an email confirmation shortly.</p>
	<a href="customer/my_account.php?my_order" class="btn btn-primary">View My Orders</a>
</div>
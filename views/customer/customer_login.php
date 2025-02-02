<?php

include_once '../../controllers/CustomerLoginController.php';

include_once '../../controllers/CartController.php';
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
	<link rel="stylesheet" href="../../css/style.css">
	<style>


	</style>

</head>

<body>


	<!-- header section starts  -->

	<header>

		<div class="header-1">

			<a href="../index.php" class="logo"> <img src="../../website/all/logo5.svg" alt="Logo image" class="hidden-xs"> </a>

			<div class="col-md-6 offer">
				<a href="#" class="btn btn-success btn-sm">
					<?php

					if (!isset($_SESSION['customer_email'])) {
						echo "Welcome Guest";
					} else {
						echo "Welcome: " . $_SESSION['customer_email'] . "";
					}


					?>
				</a>
				<a id="pr" href="#"> Shopping Cart Total Price: BDT <?php echo $totalPrice; ?>, Total Items <?php echo $totalItems; ?></a>

			</div>

		</div>

		<div class="header-2">


			<nav class="navbar">


				<ul>

					<li><a href="index.php">HOME</a></li>
					<li><a href="trimer.php">SHOP</a></li>
					<li><a href="contactus.php">CONTACT</a></li>

					<div class="col-md-6">
						<ul class="menu">
							<li>
								<div class="collapse clearfix" id="search">
									<form class="navbar-form" method="get" action="result.php">
										<div class="input-group">
											<input type="text" name="user_query" placeholder="search" class="form-control" required="">
											<button type="submit" value="search" name="search" class="btn btn-primary">
												<i class="fa fa-search"></i>
											</button>
										</div>
									</form>
								</div>
							</li>



							<li>
								<a href="cart.php" class="">
									<i class="fa fa-shopping-cart"></i>
									<span><?php echo $totalItems; ?> items in cart</span>
								</a>
							</li>


							<li>
								<a href="../customer_registration.php"><i class="fa fa-user-plus"></i>Register</a>
							</li>
							<li>
								<?php

								if (!isset($_SESSION['customer_email'])) {
									echo "<a href='checkout.php'>My Account</a>";
								} else {

									echo "<a href='customer/my_account.php?my_order'>My Account</a>";
								}

								?></li>

							<li>
								<a class="active" href="cart.php"><i class="fa fa-shopping-cart"></i>Goto Cart</a>
							</li>

							<li>
								<?php

								if (!isset($_SESSION['customer_email'])) {
									echo "<a href='../customer_login.php'>Login</a>";
								} else {

									echo "<a href='../logout.php'>Logout</a>";
								}

								?></li>
						</ul>
					</div>
				</ul>



			</nav>
		</div>
	</header>

	</section>

	<body>

		<!-- header section starts  -->

		<header>
			<div class="rx">
				<div class="box-header">
					<center>
						<h2>Login</h2>
						<p class="lead">Already our customer</p>
					</center>
				</div>
				<form action="" method="post">
					<div class="roup">
						<label>Email: </label>
						<input type="text" class="form-control" name="c_email" required="">
					</div>
					<div class="roup">
						<label>Password: </label>
						<input type="password" class="form-control" name="c_password" required="">
					</div>
					<div class="text-center">
						<button name="login" value="login" class="btn btn-primary"><i class="fa fa-sign-in"></i>Log In</button>
					</div>
				</form>
				<center><a href="../customer_registration.php">
						<h3>New ? Register Now </h3>
					</a></center>
			</div>
		</header>
	</body>

</html>
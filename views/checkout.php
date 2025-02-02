<?php
session_start();
include_once '../models/db.php';  // Ensure db.php is included
include_once '../controllers/CartController.php';  // Include the CartController




// Initialize CartController
$cartController = new CartController();

// Fetch cart details
$totalItems = $cartController->getTotalItems(); // Fetch total items
$totalPrice = $cartController->getTotalPrice(); // Fetch total price
$cartProducts = $cartController->getCartProducts(); // Fetch all cart products
$cartItems = $cartController->getCartProducts(); // Fetch all cart products

// Handle cart updates (item removal)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $remove_ids = isset($_POST['remove']) ? $_POST['remove'] : [];
  $cartController->updateCart($remove_ids, $ip_add);
}
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

  <!-- header section starts  -->

  <header>

    <div class="header-1">

      <a href="index.php" class="logo"> <img src="../website/all/logo5.svg" alt="Logo image" class="hidden-xs"> </a>

      <div class="col-md-6 offer">
        <a href="#" class="btn btn-sucess btn-sm">
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
                <a href="../views/customer_registration.php"><i class="fa fa-user-plus"></i>Register</a>
              </li>
              <li>
                <?php

                if (!isset($_SESSION['customer_email'])) {
                  echo "<a href='checkout.php'>My Account</a>";
                } else {

                  echo "<a href='my_account.php?my_order'>My Account</a>";
                }

                ?></li>

              <li>
                <a class="active" href="cart.php"><i class="fa fa-shopping-cart"></i>Goto Cart</a>
              </li>

              <li>
                <?php

                if (!isset($_SESSION['customer_email'])) {
                  echo "<a href='../views/customer/customer_login.php'>Login</a>";
                } else {

                  echo "<a href='logout.php'>Logout</a>";
                }
                ?></li>
            </ul>
          </div>
        </ul>
      </nav>
    </div>
  </header>





  <body>


    <section class="content" id="content">
      <div class="container">
        <div class="col-md-12">
          <ul class="breadcrumb">

            <li><span>Checkout</span></li>


          </ul>

        </div>
      </div>
    </section>

    <div class="content1" id="content1">
      <div class="container1">
        <div class="col-md-3">
          <?php
          include '../includes/sidebar.php';
          ?>

        </div>
      </div>
    </div>

    <div class="col-md-9">
      <?php

      if (!isset($_SESSION['customer_email'])) {
        include '../views/customer/customer_login.php';
      } else {
        include '../views/payment_options.php';
      }


      ?>
    </div>
    <!-- footer section starts  -->



    <footer class="footer" id="footer">
      <div class="cuntainer">
        <div class="wolf">

          <div class="footer-ol">
            <h4>company</h4>
            <ul>
              <li><a href="#">about us</a></li><br><br>
              <li><a href="#">our services</a></li><br><br>
              <li><a href="#">privacy policy</a></li><br><br>
              <li><a href="#">affiliate program</a></li><br><br>
            </ul>
          </div>
          <div class="footer-ol">
            <h4>get help</h4>
            <ul>
              <li><a href="#">FAQ</a></li><br><br>
              <li><a href="#">shipping</a></li><br><br>
              <li><a href="#">returns</a></li><br><br>
              <li><a href="#">order status</a></li><br><br>
              <li><a href="#">payment options</a></li><br><br>
            </ul>
          </div>
          <div class="footer-ol">
            <h4>online shop</h4>
            <ul>
              <li><a href="#">Saloon Products</a></li><br><br>
              <li><a href="#">Parlor Prtoducts</a></li><br><br>
              <li><a href="#">Garments</a></li><br><br>
              <li><a href="#">Others</a></li><br><br>
            </ul>
          </div>
          <div class="footer-ol">
            <h4>follow us</h4>
            <div class="social-links">
              <a href="#"><i class="fab fa-facebook-f fa-x" style="color: #3b5998;"></i></a>
              <a href="#"><i class="fab fa-twitter fa-x" style="color: #0084b4;"></i></a>
              <a href="#"><i class="fab fa-instagram fa-x" style="color:   #E1306C;"></i></a>
              <a href="#"><i class="fab fa-linkedin-in fa-x" style="color:  #0077B5 ;"></i></a>

            </div>
          </div>
          <div class="pal">

          </div>
          <p class="credit">Copyright &copy; <span>2025</span> | all rights reserved. </p>
        </div>
      </div>
    </footer>

    <!-- footer section ends -->

  </body>

</html>
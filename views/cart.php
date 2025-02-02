<?php
session_start();
include_once '../models/db.php';  // Ensure db.php is included
include_once '../controllers/CartController.php';  // Include the CartController

// Now, call the function to get the user's IP


// Initialize CartController
$cartController = new CartController();

// Fetch cart details
$totalItems = $cartController->getTotalItems(); // Fetch total items
$totalPrice = $cartController->getTotalPrice(); // Fetch total price
$cartProducts = $cartController->getCartProducts(); // Fetch all cart products
$cartItems = $cartController->getCartProducts(); // Fetch all cart products


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['update'])) {
    // Update cart logic
    $cartController->updateCart($_POST['product_id'], $_POST['quantity']);
  }
} elseif (isset($_GET['remove'])) {
  // Remove product from cart
  $cartController->removeProductFromCart($_GET['remove']);
} else {
  // Display cart
  $cartController->displayCart();
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

                  echo "<a href='customer/my_account.php?my_order'>My Account</a>";
                }

                ?></li>

              <li>
                <a class="active" href="cart.php"><i class="fa fa-shopping-cart"></i>Goto Cart</a>
              </li>

              <li>
                <?php

                if (!isset($_SESSION['customer_email'])) {
                  echo "<a href='checkout.php'>Login</a>";
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
  <div class="col-md-9" id="cart">
    <div class="box">
      <form action="cart.php" method="post">
        <h1>Shopping Cart</h1>

        <p class="text-muted">Currently you have <?php echo count($cartItems); ?> items in your cart</p>
        <div class="table-respon"></div>
        <table class="table">
          <thead>
            <tr>
              <th colspan="2">Product</th>
              <th>Quantity</th>
              <th>Unit Price</th>
              <th>Size</th>
              <th colspan="1">Delete</th>
              <th colspan="1">Sub Total</th>
            </tr>
          </thead>
          <tbody>
            <?php
            if (!empty($cartItems)) {
              $total = 0;
              foreach ($cartItems as $item) {
                $product = $cartController->getProductById($item['p_id']); // Get product details
                $sub_total = $product['product_price'] * $item['qty']; // Calculate sub total
                $total += $sub_total; // Add to total price
            ?>
                <tr>
                  <td><img src="admin_area/product_images/<?php echo htmlspecialchars($product['product_img1']); ?>" alt="Product Image"></td>
                  <td><?php echo htmlspecialchars($product['product_title']); ?></td>
                  <td><?php echo htmlspecialchars($item['qty']); ?></td>
                  <td>INR <?php echo htmlspecialchars($product['product_price']); ?></td>
                  <td><?php echo htmlspecialchars($item['size']); ?></td>
                  <td><input type="checkbox" name="remove[]" value="<?php echo htmlspecialchars($item['p_id']); ?>"></td>
                  <td>INR <?php echo $sub_total; ?></td>
                </tr>
              <?php }
            } else { ?>
              <tr>
                <td colspan="7" class="text-center">Your cart is empty.</td>
              </tr>
            <?php } ?>
          </tbody>
        </table>

        <div class="box-footer">
          <div class="pull-left">
            <h4>Total Price</h4>
          </div>
          <div class="pull-right">
            <h4>INR <?php echo $totalPrice; ?></h4>
          </div>
        </div>

        <div class="box-footer">
          <div class="pull-left">
            <a href="index.php" class="btn btn-default"><i class="fa fa-chevron-left"></i> Continue Shopping</a>
          </div>
          <div class="pull-right">
            <button class="btn btn-default" type="submit" name="update" value="update cart"><i class="fa fa-refresh"></i> Update Cart</button>
            <a href="checkout.php" class="btn btn-primary">Proceed to Checkout <i class="fa fa-chevron-right"></i></a>
          </div>
        </div>
      </form>
    </div>
  </div>
  <div class="col-m-3">
    <div class="box" id="order-summary">
      <div class="box-header">
        <h3>Order Summary</h3>
      </div>
      <p class="text-muted">
        Shipping and additional costs are calculated based on the values you have entered
      </p>
      <div class="table-responsive">
        <table class="table">
          <tr>
            <td>Order Sub Total</td>
            <th>BDT <?php echo isset($total) ? $total : '0'; ?></th>
          </tr>
          <tr>
            <td>Shipping and handling</td>
            <td>BDT 0</td>
          <tr>
            <td>Tax</td>
            <td>BDT 0</td>
          </tr>
          <tr class="Total">
            <td>Total</td>
            <th>BDT <?php echo $totalPrice; ?></th>

          </tr>
          </tr>
        </table>
      </div>
    </div>
  </div>
  </div>
  <div id="row same-height-row">
    <div class="col-md-3 col-sm-6">
      <div class="box same-height headlin">
        <h3 class="text-center">You also like these products</h3>
      </div>
    </div>
    <div class="d-3">
      <div class="product same-height">
        <a href="">
          <img src="../website/all/lotion.svg" class="img-responsive">
        </a>
        <div class="tet">
          <h3><a href="details.php">Nivea Lotion for men</a></h3>
          <p class="price"><i class="fa fa-BDT"></i>199</p>
        </div>
      </div>
    </div>
    <div class="d-3">
      <div class="product same-height">
        <a href="">
          <img src="../website/all/cre.svg" class="img-responsive">
        </a>
        <div class="tet">
          <h3><a href="details.php">Shaving Cream</a></h3>
          <p class="price"><i class="fa fa-BDT"></i>99</p>
        </div>
      </div>
    </div>
    <div class="d-3">
      <div class="product same-height">
        <a href="">
          <img src="../website/all/comb.svg" class="img-responsive">
        </a>
        <div class="tet">
          <h3><a href="details.php">Comb</a></h3>
          <p class="price"><i class="fa fa-BDT"></i>16</p>
        </div>
      </div>
    </div>
    <div class="d-3">
      <div class="product same-height">
        <a href="">
          <img src="../website/all/drayer.svg" class="img-responsive">
        </a>
        <div class="tet">
          <h3><a href="details.php">Hair Dryer</a></h3>
          <p class="price"><i class="fa fa-BDT"></i>340</p>
        </div>
      </div>
    </div>
    <div class="d-3">
      <div class="product same-height">
        <a href="">
          <img src="../website/all/scissor.svg" class="img-responsive">
        </a>
        <div class="tet">
          <h3><a href="details.php">Indian Scissor</a></h3>
          <p class="price"><i class="fa fa-BDT"></i>70</p>
        </div>
      </div>
    </div>
    <div class="d-3">
      <div class="product same-height">
        <a href="">
          <img src="../website/all/color.svg" class="img-responsive">
        </a>
        <div class="tet">
          <h3><a href="details.php">Hair Color</a></h3>
          <p class="price"><i class="fa fa-BDT"></i>76</p>
        </div>
      </div>
    </div>
    <div class="d-3">
      <div class="product same-height">
        <a href="">
          <img src="../website/all/blad.svg" class="img-responsive">
        </a>
        <div class="tet">
          <h3><a href="details.php">Blade</a></h3>
          <p class="price"><i class="fa fa-BDT"></i>85</p>
        </div>
      </div>
    </div>
    <div class="d-3">
      <div class="product same-height">
        <a href="">
          <img src="../website/all/napkin.svg" class="img-responsive">
        </a>
        <div class="tet">
          <h3><a href="details.php">Napkin</a></h3>
          <p class="price"><i class="fa fa-BDT"></i>20</p>
        </div>
      </div>
    </div>
  </div>

  <!-- footer section starts  -->
  <?php
  include    '../includes/footer.php';
  ?>
  <!-- footer section   -->
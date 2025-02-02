<?php
session_start();
include '../models/db.php';
include '../controllers/CartController.php';
$cartController = new CartController();
$totalItems = $cartController->getTotalItems(); // Fetch total items
$totalPrice = $cartController->getTotalPrice(); // Fetch total price
$cartProducts = $cartController->getCartProducts(); // Fetch all cart products
// Create an instance of the db class and establish a connection
$db = new db();
$con = $db->createConObject();  // Get the connection object
// Initialize the variables to avoid undefined warnings
$p_title = '';
$p_price = '';
$p_desc = '';
$p_img1 = '';
$p_img2 = '';
$p_img3 = '';
$p_cat_title = '';

// Check if the product ID is set in the URL
if (isset($_GET['pro_id'])) {
  // Get the product ID from the URL
  $pro_id = $_GET['pro_id'];

  // Connect to the database (Ensure $con is defined)


  // Fetch the product details from the database
  $get_product = "SELECT * FROM products WHERE product_id='$pro_id'";
  $run_product = mysqli_query($con, $get_product);

  // Check if the product exists and fetch the details
  if ($run_product && mysqli_num_rows($run_product) > 0) {
    $row_product = mysqli_fetch_array($run_product);

    // Get the product details
    $p_cat_id = $row_product['p_cat_id'];
    $p_title = $row_product['product_title']; // This is where $p_title is set
    $p_price = $row_product['product_price'];
    $p_desc = $row_product['product_desc'];
    $p_img1 = $row_product['product_img1'];
    $p_img2 = $row_product['product_img2'];
    $p_img3 = $row_product['product_img3'];

    // Fetch the product category details
    $get_p_cat = "SELECT * FROM product_category WHERE p_cat_id='$p_cat_id'";
    $run_p_cat = mysqli_query($con, $get_p_cat);
    if ($run_p_cat && mysqli_num_rows($run_p_cat) > 0) {
      $row_p_cat = mysqli_fetch_array($run_p_cat);
      $p_cat_title = $row_p_cat['p_cat_title'];
    }
  } else {
    echo "Product not found.";
  }
}
if (isset($_POST['add_to_cart'])) {
  // Get the selected quantity and color
  $quantity = $_POST['product_qty'];
  $size = $_POST['product_size'];

  // Ensure quantity is valid
  if ($quantity > 0) {
    // Initialize CartController and call addToCart
    $cartController = new CartController();
    $cartController->addToCart($pro_id, $quantity, $size);  // You should pass size if it's needed for the cart.
  } else {
    echo "Please select a valid quantity.";
  }
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

  <!-- header section End  -->

  <section class="content" id="content">
    <div class="container">
      <div class="col-md-12">
        <ul class="breadcrumb">

          <li><span>Product Details</span></li>


        </ul>

      </div>
    </div>
  </section>







  <div class="content1" id="content1">
    <div class="container1">
      <div class="col-md-3">
        <?php
        include '../includes/sidebar.php'
        ?>

      </div>
    </div>
  </div>
  <div class="product-details">
    <h1 class="text-center"><?php echo $p_title; ?></h1> <!-- This will now work -->
    <div class="slides">
      <!-- Slide 1 -->
      <div class="mySlides fade">
        <div class="numbertt"></div>
        <img src="../admin_area/images/product_images/<?php echo htmlspecialchars($p_img1); ?>" width="500" height="500">
      </div>

      <!-- Slide 2 -->
      <div class="mySlides fade">
        <div class="numbertt"></div>
        <img src="../admin_area/images/product_images/<?php echo htmlspecialchars($p_img2); ?>" width="500" height="500">
      </div>

      <!-- Slide 3 -->
      <div class="mySlides fade">
        <div class="numbertt"></div>
        <img src="../admin_area/images/product_images/<?php echo htmlspecialchars($p_img3); ?>" width="500" height="500">
      </div>

      <!-- Navigation Arrows -->
      <a class="prv" onclick="plusSlides(-1)">&#10094;</a>
      <a class="net" onclick="plusSlides(1)">&#10095;</a>
    </div>

    <!-- Include jQuery and Bootstrap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <!-- Custom JS for the Slide Show -->
    <script>
      var slideIndex = 1;
      showSlides(slideIndex);

      // Function to navigate through slides
      function plusSlides(n) {
        showSlides(slideIndex += n);
      }

      // Function to show the current slide
      function currentSlide(n) {
        showSlides(slideIndex = n);
      }

      // Function to control the slide display
      function showSlides(n) {
        var i;
        var slides = document.getElementsByClassName("mySlides");
        var dots = document.getElementsByClassName("dot");
        if (n > slides.length) {
          slideIndex = 1;
        }
        if (n < 1) {
          slideIndex = slides.length;
        }
        for (i = 0; i < slides.length; i++) {
          slides[i].style.display = "none";
        }
        for (i = 0; i < dots.length; i++) {
          dots[i].className = dots[i].className.replace(" active", "");
        }
        slides[slideIndex - 1].style.display = "block";
        dots[slideIndex - 1].className += " active";
      }
    </script>


    <div class="co-md-6">
      <div class="bx">
        <h1 class="text-center"><?php echo $p_title; ?></h1>

        <!-- Add to Cart form -->
        <form action="details.php?pro_id=<?php echo $pro_id; ?>" method="post" class="form-horizontal">

          <div class="form-group">
            <label class="col-md-5 control-label">Product Quantity</label>
            <div class="col-md-7">
              <select name="product_qty" class="form-control">
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label class="col-md-5 control-label">Chose Color</label>
            <div class="col-md-7">
              <select name="product_size" class="form-control">
                <option>RED & Blue</option>
                <option>khaki</option>
                <option>white</option>
                <option>gray</option>
                <option>blue</option>
              </select>
            </div>
          </div>
          <p class="price"><i class="fa fa-BDT"></i><?php echo $p_price; ?></p>
          <p class="text-center buttons">
            <button type="submit" name="add_to_cart" class="btn btn-primary">Add to Cart</button>
          </p>
        </form>
      </div>
      <div class="col-xs-4">
        <a href="#" class="thumb">
          <img src="" class="img-responsive">
        </a>
      </div>
      <div class="col-xs-4">
        <a href="#" class="thumb">
          <img src="" class="img-responsive">
        </a>
      </div>
      <div class="col-xs-4">
        <a href="#" class="thumb">
          <img src="" class="img-responsive">
        </a>
      </div>
    </div>
    <div class="boxa" id="details">
      <h4>Product details</h4>
      <p><?php echo $p_desc ?></p>
      <h4>Colors</h4>
      <ul>
        <li>Red</li>
        <li>Blue</li>
        <li>Green</li>
        <li>White</li>

      </ul>
    </div>



    <?php
    $get_product = "select * from products order by 1 LIMIT 0,5";
    $run_product = mysqli_query($con, $get_product);
    while ($row = mysqli_fetch_array($run_product)) {

      $pro_id = $row['product_id'];
      $product_title = $row['product_title'];
      $product_price = $row['product_price'];
      $product_img1 = $row['product_img1'];

      echo "
    <div class='d-3'>
    <div class='product same-height'>
    <a href='details.php?pro_id=$pro_id'>
    <img src='../admin_area/images/product_images/$product_img1' class='img-responsive' width='150' >

    </a>
    <div class='tet'>
    <h3> <a href='details.php?pro_id=$pro_id'>$product_title</a> </h3>
    <p class='price'>$product_price </p>

    </div>
    </div>
    </div>



    ";
    }

    ?>

  </div>


  <!-- footer section starts  -->
  <?php
  include '../includes/footer.php'
  ?>
  <!-- footer section   -->

</body>

</html>
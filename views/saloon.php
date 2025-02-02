<?php
session_start();
include '../models/db.php';
include '../controllers/CartController.php';
include '../controllers/ProductController.php';
$productController = new ProductController();
$productController->index();

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

    <!-- views/saloon.php -->
    <section class="content" id="content">
        <div class="container">
            <div class="col-md-12">
                <ul class="breadcrumb">
                    <li><span>OUR SERVICES</span></li>
                </ul>
            </div>
        </div>
    </section>

    <div class="col-md-9">
        <?php
        if (empty($products)) {
            echo "<div class='boxi'>
                
            </div>";
        }
        ?>
    </div>

    <div class="content1" id="content1">
        <div class="container1">
            <div class="col-md-3">
                <?php include '../includes/sidebar.php'; ?>
            </div>
        </div>
    </div>

    <div class="contt" id="contar">
        <div class="ro">
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 col-sm-6 sing">
                    <div class="prod">
                        <a href="details.php?pro_id=<?php echo $product['product_id']; ?>">
                            <img src="../admin_area/images/product_images/<?php echo $product['product_img1']; ?>" class="img-responsive" width="300" height="300">
                        </a>
                        <h3><a href="details.php?pro_id=<?php echo $product['product_id']; ?>"><?php echo $product['product_title']; ?></a></h3>
                        <p class="pric">BDT <?php echo $product['product_price']; ?></p>
                        <p class="buttons">
                            <a href="details.php?pro_id=<?php echo $product['product_id']; ?>" class="btn btn-default">View Details</a>
                            <a href="details.php?pro_id=<?php echo $product['product_id']; ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add to Cart</a>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Pagination -->
    <center>
        <ul class="pagination">
            <?php
            for ($i = 1; $i <= $total_pages; $i++) {
                echo "<li><a href='saloon.php?page=$i'>$i</a></li>";
            }
            ?>
        </ul>
    </center>

    <!-- Footer -->
    <div class="foot">

        <?php
        include '../includes/footer.php';
        ?>
</body>

</html>
</div>
</body>

</html>
<?php
session_start();
include '../controllers/HomeController.php';
include '../controllers/CartController.php';
include '../models/db.php';

// Initialize controllers
$cartController = new CartController();

// Check if the add parameter exists in the URL
if (isset($_POST['add_to_cart'])) {
    // Get the selected quantity and color
    $quantity = $_POST['product_qty'];
    $size = $_POST['product_size'];

    // Add the product to the cart
    $cartController->addToCart($pro_id, $quantity, $size);

    // Redirect to the cart page after adding the product
    echo "<script>window.location.href = 'cart.php';</script>";
} else {
    // Fetch Data for the cart
    $totalItems = $cartController->getTotalItems();
    $totalPrice = $cartController->getTotalPrice();
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
                <!-- header section ends -->

                <!-- Home Section Starts -->
                <section class="home" id="home">
                    <h1 class="heading"> <span>BEST OFFERS FOR YOU</span> </h1>
                    <div class="slideshow-container">
                        <!-- First Slider (Main) -->
                        <?php foreach ($sliders_main as $slider) { ?>
                            <div class="mySlides fade">
                                <a href="<?php echo $slider['slider_url']; ?>">
                                    <img src="../admin_area/images/slider_images/<?php echo $slider['slider_image']; ?>" width="1400" height="400">
                                </a>
                            </div>
                        <?php } ?>

                        <!-- Other Sliders -->
                        <?php foreach ($sliders_other as $slider) { ?>
                            <div class="mySlides fade">
                                <a href="<?php echo $slider['slider_url']; ?>">
                                    <img src="../admin_area/images/slider_images/<?php echo $slider['slider_image']; ?>" width="1400" height="400">
                                </a>
                            </div>
                        <?php } ?>

                        <!-- Navigation Arrows -->
                        <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
                        <a class="next" onclick="plusSlides(1)">&#10095;</a>
                    </div>

                    <br>
                    <!-- Dots for Navigation -->
                    <div style="text-align:center">
                        <?php for ($i = 1; $i <= count($sliders_main) + count($sliders_other); $i++) { ?>
                            <span class="dot" onclick="currentSlide(<?php echo $i; ?>)"></span>
                        <?php } ?>
                    </div>
                </section>
                <!-- home section ends -->
                <!-- new this week section start -->
                <!-- hot start -->

                <div class="hot">
                    <div class="box">
                        <div class="container">
                            <div class="col-md-121">
                                <h2>Latest this Week</h2>
                                <!-- dynamic latest this week images section start  -->
                                <form action="index.php" method="post" class="form-horizontal">
                                    <div class="col-sm-4">
                                        <div class="row">
                                            <?php
                                            if (empty($products)) {
                                                echo "<p>No products available at the moment.</p>";
                                            } else {
                                                foreach ($products as $product) {
                                                    // Check if keys exist before accessing
                                                    $pro_id = $product['product_id'] ?? 'N/A';
                                                    $pro_title = $product['product_title'] ?? 'Unknown Product';
                                                    $pro_price = $product['product_price'] ?? '0.00';
                                                    $pro_img1 = $product['product_img1'] ?? 'default.jpg';

                                                    // Define the image path (relative to web server root)
                                                    $image_path = "../admin_area/images/product_images/" . $pro_img1;


                                                    if (!file_exists(BASE_PATH . '/' . $image_path)) {
                                                        // If the image doesn't exist, use the fallback
                                                        $image_path = "admin_area/images/product_images/default.jpg"; // Fallback image
                                                    }
                                            ?>
                                                    <div class="col-md-4 col-sm-6 single">
                                                        <div class="product">
                                                            <a href="details.php?pro_id=<?php echo htmlspecialchars($pro_id); ?>">
                                                                <img src="<?php echo htmlspecialchars($image_path); ?>" class="img-responsive" alt="<?php echo htmlspecialchars($pro_title); ?>">
                                                            </a>
                                                            <h3><a href="details.php?pro_id=<?php echo htmlspecialchars($pro_id); ?>"><?php echo htmlspecialchars($pro_title); ?></a></h3>
                                                            <p class="price">BDT <?php echo htmlspecialchars($pro_price); ?></p>
                                                            <p class="buttons">
                                                                <a href="details.php?pro_id=<?php echo htmlspecialchars($pro_id); ?>" class="btn btn-default">View Details</a>
                                                                <a href="cart.php?add=<?php echo htmlspecialchars($pro_id); ?>" class="btn btn-primary"><i class="fa fa-shopping-cart"></i> Add to Cart</a>

                                                            </p>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            }
                                            ?>
                                        </div>
                                    </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- dynamic latest this week images section End  -->
                <!-- new this week section End -->
                <!--saloon product section starts  -->
                <!-- Trimer Start  -->
                <section class="arrival" id="arrival">
                    <h1 class="heading"> <span>SALLON PRODUCTS</span> </h1>
                    <div class="box-container">
                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=22"> <img src="../website/all/th (2).jpg" alt="" width="150"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=22">
                                    <h3>Trimer</h3>
                                </a>
                            </div>
                            <div class="overlay">
                            </div>
                        </div>
                        <!-- Trimer End  -->
                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=23"> <img src="../website/all/drayer.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=23">
                                    <h3>Dryer</h3>
                                </a>
                            </div>
                            <div class="overlay">
                            </div>
                        </div>
                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=24"> <img src="../website/all/str.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=24">
                                    <h3>Straightener</h3>
                                </a>
                            </div>
                            <div class="overlay">
                            </div>
                        </div>
                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=25"><img src="../website/all/mass.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=25">
                                    <h3>Massager</h3>
                                </a>
                            </div>
                            <div class="overlay">
                            </div>
                        </div>
                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=26"> <img src="../website/all/cre.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=26">
                                    <h3>Shaving Cream</h3>
                                </a>
                            </div>
                            <div class="overlay">
                            </div>
                        </div>
                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=27"> <img src="../website/all/blad.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=27">
                                    <h3>Blade</h3>
                                </a>
                            </div>
                            <div class="overlay">
                            </div>
                        </div>
                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=28"> <img src="../website/all/napkin.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=28">
                                    <h3>Napkin</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=29"> <img src="../website/all/lotion.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=29">
                                    <h3>Lotion</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=30"> <img src="../website/all/color.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=30">
                                    <h3>Color</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=31"> <img src="../website/all/scissor.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=31">
                                    <h3>Scissor</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=32"> <img src="../website/all/ustra.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=32">
                                    <h3>classic shaver</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=33"> <img src="../website/all/comb.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=33">
                                    <h3>Comb</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=34"> <img src="../website/all/towel.svg" alt=""></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=34">
                                    <h3>Towel</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=35"> <img src="../website/all/foam.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=35">
                                    <h3>Shaving Foam</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>
                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=36"> <img src="../website/all/kit.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=36">
                                    <h3>Facial Kit</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=37"> <img src="../website/all/powder.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=37">
                                    <h3>Powder</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                    </div>
                </section>

                <!-- saloon products section ends -->
                <!-- parlor products section starts -->

                <section class="parlor" id="parlor">

                    <h1 class="heading"> <span>PARLOR</span> </h1>

                    <div class="box-container">

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=38"> <img src="../website/all/lip.jpg" alt="" width="300"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=38">
                                    <h3>Lip Care</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>
                        <!-- Trimer End  -->

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=39"> <img src="../website/all/ey.jpg" alt="" width="250"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=39">
                                    <h3>Eye Liner</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=40"> <img src="../website/all/cr.jpg" alt="" width="300"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=40">
                                    <h3>Face Cream </h3>
                                </a>

                            </div>
                            <div class="overlay">
                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=41"><img src="../website/all/nail.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=41">
                                    <h3>Nailpolish</h3>
                                </a>

                            </div>
                            <div class="overlay">
                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=42"> <img src="../website/all/beauty.jpg" alt="" width="250"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=42">
                                    <h3>Beauty Care</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=43"> <img src="../website/all/lacme.jpg" alt="" width="330"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=43">
                                    <h3>Lacme</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=44"> <img src="../website/all/skin.jpg" alt="" width="330"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=44">
                                    <h3>Skin Care</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>


                    </div>
                </section>
                <!-- parlor products section ends -->
                <!-- garment products section start -->
                <section class="garment" id="garment">

                    <h1 class="heading"> <span>GARMENTS</span> </h1>

                    <div class="box-container">

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=45"> <img src="../website/all/inner.jpg" alt="" width="340"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=45">
                                    <h3>Inner Wear</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>
                        <!-- Trimer End  -->

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=46"> <img src="../website/all/un.jpg" alt="" width="300"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=46">
                                    <h3>Underwear</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=47"> <img src="../website/all/cap.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=47">
                                    <h3>CAP</h3>
                                </a>

                            </div>
                            <div class="overlay">
                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=48"><img src="../website/all/han.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=48">
                                    <h3>Hankey</h3>
                                </a>

                            </div>
                            <div class="overlay">
                            </div>
                        </div>


                    </div>
                </section>
                <!--garment section ends-->
                <section class="use" id="use">

                    <h1 class="heading"> <span>DAILY-USE</span> </h1>

                    <div class="box-container">

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=49"> <img src="../website/all/detergent.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=49">
                                    <h3>Detergent</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>
                        <!-- Trimer End  -->

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=50"> <img src="../website/all/deo.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=50">
                                    <h3>Deodorant</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=51"> <img src="../website/all/face.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=51">
                                    <h3>Facewash</h3>
                                </a>

                            </div>
                            <div class="overlay">
                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=52"><img src="../website/all/hair.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=52">
                                    <h3>Hair Gel</h3>
                                </a>

                            </div>
                            <div class="overlay">
                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=53"> <img src="../website/all/harp.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=53">
                                    <h3>Harpic</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=54"> <img src="../website/all/per.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=54">
                                    <h3>Perfume</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=55"> <img src="../website/all/wolet.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=55">
                                    <h3>Wallet</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=56"> <img src="../website/all/belt.jpg" alt="" width="300"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=56">
                                    <h3>Belt</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=57"> <img src="../website/all/soap.jpg" alt="" width="250"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=57">
                                    <h3>Soap</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=58"> <img src="../website/all/toth.jpg" alt="" width="250"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=58">
                                    <h3>Toothpaste</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=59"> <img src="../website/all/hand.jpg" alt="" width="200"> </a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=59">
                                    <h3>Handwash</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=60"> <img src="../website/all/shampoo.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=60">
                                    <h3>Shampoo</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=61"> <img src="../website/all/oil.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=61">
                                    <h3>Hair Oil</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=62"> <img src="../website/all/room.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=62">
                                    <h3>Room Fragrance</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                        <div class="box">
                            <div class="image">
                                <a href="trimer.php?p_cat=63"> <img src="../website/all/hai.jpg" alt="" width="200"></a>
                            </div>
                            <div class="info">
                                <a href="trimer.php?p_cat=63">
                                    <h3>Hair Spray</h3>
                                </a>

                            </div>
                            <div class="overlay">

                            </div>
                        </div>

                    </div>
                </section>


                <!-- gallery section ends -->

                <!-- Best Deals Section Starts worked -->
                <section class="deal" id="deal">
                    <h1 class="heading"> <span> BEST DEALS </span> </h1>

                    <div class="icons-container">
                        <?php foreach ($deals as $deal) { ?>
                            <div class="icons">
                                <i class="<?php echo $deal['box_icon']; ?>"></i>
                                <h3><?php echo htmlspecialchars($deal['box_title']); ?></h3>
                                <p><?php echo htmlspecialchars($deal['box_desc']); ?></p>
                            </div>
                        <?php } ?>
                    </div>
                </section>
                <!-- deal section ends -->

                <!-- newsletter section starts  -->

                <section class="newsletter" id="newsletter">

                    <h1>Newsletter</h1>
                    <p>Get In Touch For Latest Discounts And Updates</p>
                    <form action="contactus.php" method="post">


                        <input type="text" placeholder="Enter Your Name"><br>


                        <input type="email" placeholder="Enter Your Email">

                        <textarea type="txt" placeholder="Enter Your Message"></textarea>

                        <input type="submit" class="btn">
                    </form>

                </section>

                <!-- newsletter section ends -->

                <!-- footer section starts  -->

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
                <!-- footer section ends -->
            </nav>
        </div>
    </header>


    <!-- Include JavaScript woekred -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="main/js.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <script>
        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("dot");
            if (n > slides.length) {
                slideIndex = 1
            }
            if (n < 1) {
                slideIndex = slides.length
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


</body>

</html>
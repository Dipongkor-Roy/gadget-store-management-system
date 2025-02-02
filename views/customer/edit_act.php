<?php

include '../../controllers/edit_acc_Controller.php';
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
    <div class="rx">
        <center>
            <h1>Edit Your Account</h1>
        </center>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="roup">
                <label>Name</label>
                <input type="text" name="c_name" class="trol" value="<?php echo htmlspecialchars($customer['customer_name'] ?? ''); ?>" required>
            </div>
            <div class="roup">
                <label>Email</label>
                <input type="email" name="c_email" class="trol" value="<?php echo htmlspecialchars($customer['customer_email'] ?? ''); ?>" required>
            </div>
            <div class="roup">
                <label>Country</label>
                <input type="text" name="c_country" class="trol" value="<?php echo htmlspecialchars($customer['customer_country'] ?? ''); ?>" required>
            </div>
            <div class="roup">
                <label>City</label>
                <input type="text" name="c_city" class="trol" value="<?php echo htmlspecialchars($customer['customer_city'] ?? ''); ?>" required>
            </div>
            <div class="roup">
                <label>Contact Number</label>
                <input type="text" name="c_number" class="trol" value="<?php echo htmlspecialchars($customer['customer_contact'] ?? ''); ?>" required>
            </div>
            <div class="roup">
                <label>Address</label>
                <input type="text" name="c_address" class="trol" value="<?php echo htmlspecialchars($customer['customer_address'] ?? ''); ?>" required>
            </div>
            <div class="roup">
                <label>Customer Image</label>
                <input type="file" name="c_image" class="trol">
                <img src="customer_images/<?php echo htmlspecialchars($customer['customer_image'] ?? 'default.jpg'); ?>" class="img-responsive" height="70" width="70">
            </div>
            <div class="text-center">
                <button class="btn btn-primary" name="update" type="submit">
                    Update Now
                </button>
            </div>
        </form>
    </div>
</body>
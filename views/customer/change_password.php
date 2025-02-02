<?php

include '../../controllers/PasswordController.php';

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
            <h3>Change Your Password</h3>
        </center>
        <form action="" method="post">
            <div class="roup">
                <label>Enter Your Current Password</label>
                <input type="text" name="old_password" class="form-control">
            </div>
            <div class="roup">
                <label>Enter New Password</label>
                <input type="password" name="new_password" class="form-control">
            </div>
            <div class="roup">
                <label>Confirm new password</label>
                <input type="password" name="c_n_password" class="form-control">
            </div>
            <div class="text-center">
                <center><button class="btn btn-primary btn-lg" name="update" type="submit">Update Now</button></center>
            </div>
        </form>
    </div>
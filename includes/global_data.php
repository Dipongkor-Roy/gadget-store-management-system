<?php
include '../controllers/CartController.php'; // Include the controller

// Initialize the CartController
$cartController = new CartController();

// Fetch and make global variables available
$totalItems = $cartController->getTotalItems();
$totalPrice = $cartController->getTotalPrice();
$cartProducts = $cartController->getCartProducts();

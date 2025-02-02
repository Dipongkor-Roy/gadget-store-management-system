<?php
include '../models/db.php';
session_start();

class CheckoutController
{
    private $db;

    public function __construct()
    {
        $this->db = new db();
    }

    public function showCheckoutPage()
    {
        // Check if the user is logged in
        $isLoggedIn = $this->db->isCustomerLoggedIn();

        // Include the view and pass login status
        require_once "views/checkout.php";
    }
}

// Initialize the controller
$controller = new CheckoutController();
$controller->showCheckoutPage();

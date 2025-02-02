<?php

require_once __DIR__ . '/../models/db.php'; // ✅ Correct path using absolute directory reference

include_once realpath(__DIR__ . '/../views/customer/my_order.php'); // ✅ Correct path using `realpath()`


class OrderController
{
    private $db;

    public function __construct()
    {
        $this->db = new db();
    }

    public function showOrders()
    {
        $customer_email = $_SESSION['customer_email'] ?? null;

        if (!$customer_email) {
            return [];
        }

        $orders = $this->db->getOrdersByCustomerEmail($customer_email);
        return is_array($orders) ? $orders : []; // ✅ Ensures `$orders` is always an array
    }

    public function submitOrder()
    {
        // Ensure the customer is logged in and has a valid session
        if (!isset($_SESSION['customer_email'])) {
            echo "<script>alert('Please log in first.');</script>";
            echo "<script>window.location.href='login.php';</script>";
            return;
        }

        // Now check if customer_id is passed in the URL
        $customer_id = $_GET['c_id'] ?? null; // Get customer ID from URL

        if (!$customer_id) {
            return;
        }

        $ip_add = $_SERVER['REMOTE_ADDR']; // Get the user's IP
        $invoice_no = mt_rand(); // Generate a random invoice number

        // Fetch cart items
        $cartItems = $this->db->getCartItems($ip_add);

        if (empty($cartItems)) {
            echo "<script>alert('Your cart is empty. Please add items before checkout.');</script>";
            echo "<script>window.location.href='shop.php';</script>";
            return;
        }

        // Process each cart item and create an order
        foreach ($cartItems as $item) {
            $product = $this->db->getProductById($item['p_id']);

            if (!$product) {
                continue; // Skip if product not found
            }

            $sub_total = $product['product_price'] * $item['qty'];
            $this->db->insertCustomerOrder($customer_id, $item['p_id'], $sub_total, $invoice_no, $item['qty'], $item['size']);
        }

        // Clear the cart after order submission
        $this->db->clearCart($ip_add);

        // Redirect to confirmation page
        echo "<script>alert('Your order has been submitted. Thank you!');</script>";
        echo "<script>window.location.href='customer/my_account.php?my_order';</script>";
    }
}

// Initialize the controller
$controller = new OrderController();
$orders = $controller->showOrders();
$controller->submitOrder();

// Load the view

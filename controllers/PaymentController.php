<?php
include_once realpath(__DIR__ . '/../models/db.php');


class PaymentController
{
    private $db;

    public function __construct()
    {
        if (!$this->db) {
            $this->db = new db(); // ✅ Ensures only one instance is created
        }
    }

    public function confirmPayment()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['confirm_payment'])) {
            $order_id = $_GET['order_id'] ?? null;
            $invoice_number = $_POST['invoice_number'] ?? '';
            $amount = $_POST['amount'] ?? '';
            $payment_mode = $_POST['payment_mode'] ?? '';
            $trfr_number = $_POST['trfr_number'] ?? '';
            $date = $_POST['date'] ?? '';

            // Validate fields
            if (empty($invoice_number) || empty($amount) || empty($payment_mode) || empty($trfr_number) || empty($date)) {
                echo "<script>alert('All fields are required!');</script>";
                return;
            }

            // Insert payment into the database
            if ($this->db->insertPayment($invoice_number, $amount, $payment_mode, $trfr_number, $date)) {
                // Update order status
                $this->db->updateOrderStatus($order_id, "Complete");

                echo "<script>alert('Your order has been received');</script>";
                echo "<script>window.location.href='my_account.php?order';</script>";
            } else {
                echo "<script>alert('Error processing payment. Please try again.');</script>";
            }
        }
    }
    public function showPaymentOptions()
    {
        if (!isset($_SESSION['customer_email'])) {
            echo "<script>window.location.href='../checkout.php';</script>";
            exit();
        }

        $customer_email = $_SESSION['customer_email'];
        $customer = $this->db->getCustomerByEmail($customer_email);

        return $customer;
    }
}

// Initialize the controller
$controller = new PaymentController();
$controller->confirmPayment();
$customer = $controller->showPaymentOptions();

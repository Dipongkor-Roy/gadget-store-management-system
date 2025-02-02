<?php
include '../../models/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $customer_email = $_POST['c_email'];
    $customer_pass = $_POST['c_password'];

    $db = new db();
    $get_ip = $db->getUserIp();

    // Check customer credentials
    $isCustomerValid = $db->checkCustomerCredentials($customer_email, $customer_pass);

    // Debugging: Log output for validation
    if (!$isCustomerValid) {
        echo "<script>
            alert('Invalid email or password. Please try again.');
        </script>";
        exit();
    }

    // Start the session and set session variables
    session_start();
    $_SESSION['customer_email'] = $customer_email;

    // Check if the cart has items
    $hasCartItems = $db->checkCartItems($get_ip);

    // Redirect based on cart status
    if ($hasCartItems) {
        echo "<script>
            alert('You are logged in.');
            window.open('../index.php', '_self');
        </script>";
    } else {
        echo "<script>
            alert('You are logged in.');
            window.open('my_account.php', '_self');
        </script>";
    }
}

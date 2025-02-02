<?php
include_once '../controllers/DeleteAccountController.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['customer_email'])) {
        $email = $_SESSION['customer_email'];

        if (isset($_POST['yes'])) {
            $controller = new DeleteAccountController();
            $isDeleted = $controller->deleteAccount($email);

            if ($isDeleted) {
                session_destroy();
                echo "<script>alert('Your account has been deleted.');</script>";
                echo "<script>window.open('../index.php', '_self');</script>";
            } else {
                echo "<script>alert('Failed to delete your account. Please try again.');</script>";
            }
        } elseif (isset($_POST['no'])) {
            echo "<script>window.open('../index.php', '_self');</script>";
        }
    } else {
        echo "<script>window.open('../checkout.php', '_self');</script>";
    }
}

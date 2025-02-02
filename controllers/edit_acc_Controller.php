<?php
include_once '../../models/db.php';


class edit_acc_Controller
{
    private $db;

    public function __construct()
    {
        $this->db = new db(); // ✅ Using `db` instead of `UserModel`
    }


    public function editAccount()
    {
        if (!isset($_SESSION['customer_email'])) {
            echo "<script>alert('You must be logged in!'); window.location.href='login.php';</script>";
            exit();
        }

        $email = $_SESSION['customer_email'];
        $customer = $this->db->getCustomerByEmail($email);

        if (!$customer) {
            echo "<script>alert('Customer not found!');</script>";
            return;
        }

        // Handle form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
            $data = [
                "customer_name" => $_POST['c_name'] ?? '',
                "customer_email" => $_POST['c_email'] ?? '',
                "customer_country" => $_POST['c_country'] ?? '',
                "customer_city" => $_POST['c_city'] ?? '',
                "customer_contact" => $_POST['c_number'] ?? '',
                "customer_address" => $_POST['c_address'] ?? ''
            ];

            // Handle image upload
            if ($_FILES['c_image']['name']) {
                $image = $_FILES['c_image']['name'];
                $image_tmp = $_FILES['c_image']['tmp_name'];
                move_uploaded_file($image_tmp, "customer_images/$image");
            } else {
                $image = $customer['customer_image'];
            }

            if ($this->db->updateCustomer($customer['customer_id'], $data, $image)) {
                echo "<script>alert('Your details have been updated.'); window.location.href='../index.php';</script>";
            } else {
                echo "<script>alert('Error updating details. Please try again.');</script>";
            }
        }

        return $customer;
    }
}

// Initialize the controller and load customer data
$controller = new edit_acc_Controller();
$customer = $controller->editAccount();

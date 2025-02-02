<?php
session_start();
include '../models/db.php';

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Debugging: Output form data


    // Validate and sanitize form data
    $name = isset($_POST["c_name"]) ? htmlspecialchars($_POST["c_name"]) : null;
    $email = isset($_POST["c_email"]) ? htmlspecialchars($_POST["c_email"]) : null;
    $password = isset($_POST["c_password"]) ? $_POST["c_password"] : null;
    $hashedPassword = $password ? password_hash($password, PASSWORD_DEFAULT) : null;
    $country = isset($_POST["c_country"]) ? htmlspecialchars($_POST["c_country"]) : null;
    $city = isset($_POST["c_city"]) ? htmlspecialchars($_POST["c_city"]) : null;
    $contact = isset($_POST["c_contact"]) ? htmlspecialchars($_POST["c_contact"]) : null;
    $address = isset($_POST["c_address"]) ? htmlspecialchars($_POST["c_address"]) : null;

    $ip = (new db())->getUserIp();

    // Handle file upload
    $image = null;
    if (isset($_FILES["c_image"]) && $_FILES["c_image"]["error"] === UPLOAD_ERR_OK) {
        $image_path = "../customer_images";
        if (!is_dir($image_path)) {
            mkdir($image_path, 0777, true); // Create directory if it doesn't exist
        }

        $image = $_FILES["c_image"]["name"];
        $tmp_image = $_FILES["c_image"]["tmp_name"];
        $destination = "$image_path/$image";

        // Validate the uploaded file
        if ($_FILES["c_image"]["size"] > 5000000) { // 5MB limit
            die("File is too large.");
        }

        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        if (!in_array($_FILES["c_image"]["type"], $allowedTypes)) {
            die("Invalid file type. Only JPG, PNG, and JPEG are allowed.");
        }

        // Move the uploaded file
        if (!move_uploaded_file($tmp_image, $destination)) {
            die("Failed to upload file.");
        }
    } else {
        echo "No valid image uploaded.";
    }

    // Ensure all required fields are present
    if ($name && $email && $hashedPassword && $country && $city && $contact && $address && $image) {
        // Prepare user data
        $userData = [
            'customer_name' => $name,
            'customer_email' => $email,
            'customer_pass' => $hashedPassword,
            'customer_country' => $country,
            'customer_city' => $city,
            'customer_contact' => $contact,
            'customer_address' => $address,
            'customer_image' => $image,
            'customer_ip' => $ip,
        ];

        // Insert the user into the database
        $db = new db();
        if ($db->insertCustomer($userData)) {
            echo "<script>alert('User registered successfully!');</script>";
        } else {
            echo "<script>alert('Error occurred while registering the user');</script>";
        }
    } else {
        echo "Please fill in all required fields.";
    }
}

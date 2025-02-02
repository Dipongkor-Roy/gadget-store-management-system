<?php
include_once '../../models/db.php';

class PasswordController
{
    private $db;

    public function __construct()
    {
        $this->db = new db(); // ✅ Using `db` instead of `UserModel`
    }

    public function changePassword()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['update'])) {
            $email = $_SESSION['customer_email'] ?? null;
            $oldPassword = $_POST['old_password'] ?? '';
            $newPassword = $_POST['new_password'] ?? '';
            $confirmPassword = $_POST['c_n_password'] ?? '';

            // Validate session
            if (!$email) {
                echo "<script>alert('User not logged in!');</script>";
                return;
            }

            // Validate empty fields
            if (empty($oldPassword) || empty($newPassword) || empty($confirmPassword)) {
                echo "<script>alert('All fields are required!');</script>";
                return;
            }

            // Validate password match
            if ($newPassword !== $confirmPassword) {
                echo "<script>alert('New password and confirmation do not match!');</script>";
                return;
            }

            // Check current password validity
            if (!$this->db->checkCurrentPassword($email, $oldPassword)) {
                echo "<script>alert('Current password is incorrect!');</script>";
                return;
            }

            // Update password
            if ($this->db->updatePassword($email, $newPassword)) {
                echo "<script>alert('Password successfully changed!');</script>";
                echo "<script>window.location.href='my_account.php?my_order';</script>";
            } else {
                echo "<script>alert('Error updating password! Please try again.');</script>";
            }
        }
    }
}

// Create controller instance and execute password change
$controller = new PasswordController();
$controller->changePassword();

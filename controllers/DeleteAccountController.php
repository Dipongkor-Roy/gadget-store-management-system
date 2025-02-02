<?php
include_once '../models/db.php';

class DeleteAccountController
{
    private $db;

    public function __construct()
    {
        $this->db = new db(); // Initialize the database connection
    }

    public function deleteAccount($email)
    {
        // Call the model function to delete the account
        return $this->db->deleteCustomerAccount($email);
    }
}

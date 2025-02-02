<?php
include_once realpath(__DIR__ . '/../models/db.php');


if (!class_exists('CartController')) { // ✅ Prevents redeclaration
    class CartController
    {
        private $db;

        public function __construct()
        {
            if (!isset($this->db)) {
                $this->db = new db();
            }
        }

        public function getTotalPrice()
        {
            return $this->db->totalPrice();
        }

        public function getTotalItems()
        {
            return $this->db->item();
        }

        public function getCartProducts()
        {
            return $this->db->getCartProducts();
        }
        // Get the user's IP address
        private function getUserIp()
        {
            return $_SERVER['REMOTE_ADDR'];
        }

        // add to cart
        public function addToCart($productId, $quantity, $size)
        {
            // Get user IP
            $ip_add = $this->getUserIp();

            // Get the connection object
            $db = new db();
            $con = $db->createConObject();  // Get the mysqli connection object

            // Check if the product already exists in the cart
            $query = "SELECT * FROM cart WHERE p_id = ? AND ip_add = ? AND size = ?";
            $stmt = $con->prepare($query);  // Use $con (mysqli connection object) here
            $stmt->bind_param("iss", $productId, $ip_add, $size);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                // If the product exists, update the quantity
                $updateQuery = "UPDATE cart SET qty = qty + ? WHERE p_id = ? AND ip_add = ? AND size = ?";
                $stmt = $con->prepare($updateQuery);  // Again, use $con here
                $stmt->bind_param("iiss", $quantity, $productId, $ip_add, $size);
                $stmt->execute();
            } else {
                // If the product doesn't exist, insert it into the cart
                $insertQuery = "INSERT INTO cart (p_id, qty, ip_add, size) VALUES (?, ?, ?, ?)";
                $stmt = $con->prepare($insertQuery);  // Use $con here
                $stmt->bind_param("iiss", $productId, $quantity, $ip_add, $size);
                $stmt->execute();
            }

            // Redirect to the cart page after adding to cart
            header("Location: cart.php");
        }

        // Fetch cart details
        public function index()
        {
            $ip_add = $this->getUserIp(); // Get user IP
            $cartProducts = $this->db->getCartProducts($ip_add);
            $totalPrice = $this->db->getTotalPrice($ip_add);
            $totalItems = $this->db->getCartItems($ip_add);

            // Pass data to view
            $this->view('cart', [
                'cartProducts' => $cartProducts,
                'totalPrice' => $totalPrice,
                'totalItems' => $totalItems
            ]);
        }
        // Method to get product details by product ID
        public function getProductById($productId)
        {
            // Assuming the db class has a method to fetch product details
            return $this->db->getProductDetails($productId); // Adjust to your method name if needed
        }
        // Remove item from the cart
        public function removeItemFromCart($productId, $ip_add)
        {
            $con = $this->db->createConObject();  // Get the connection
            $query = "DELETE FROM cart WHERE p_id = ? AND ip_add = ?";
            $stmt = $con->prepare($query);
            $stmt->bind_param("is", $productId, $ip_add);
            $stmt->execute();
        }
        // Helper function to load views
        private function view($view, $data = [])
        {
            extract($data);
            include "../views/{$view}.php";
        }
    }
}

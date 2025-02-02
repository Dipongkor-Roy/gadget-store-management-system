<?php
include_once '../models/db.php';

class ProductController
{
    private $db;

    public function __construct()
    {
        $this->db = new db(); // Database connection (could be passed as a dependency)
    }

    public function view($product_id)
    {
        // Create the ProductModel instance and pass the DB connection if needed
        $productModel = new db($this->db);  // Use the db object here for the model

        // Fetch product and category details
        $productDetails = $productModel->getProductDetails($product_id);

        // Check if product details are found
        if ($productDetails) {
            $this->loadView('product', $productDetails);  // Correctly load the view here
        } else {
            echo "Product not found.";
        }
    }

    // A method for loading views (You might want to implement this properly)
    private function loadView($view, $data)
    {
        // Load view (this is a basic example, ideally use a view loader)
        include_once "../../views/{$view}.php";
    }

    public function showProductDetails($productId)
    {
        // Fetch product details from the model
        $productDetails = $this->db->getProductDetails($productId);

        // Fetch product category details
        $categoryDetails = $this->db->getCategoryDetails($productDetails['p_cat_id']);

        // Pass product details and category to the view
        $this->view('details', [
            'productDetails' => $productDetails,
            'categoryDetails' => $categoryDetails
        ]);
    }

    // Handle the logic for pagination and fetching products
    // In your controller
    public function index()
    {
        $per_page = 6;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;  // Get current page, default to 1
        $start_from = ($page - 1) * $per_page;  // Calculate the starting point for pagination

        // Fetch products for the current page
        $products = $this->db->getProducts($start_from, $per_page);

        // Ensure products are returned
        if (empty($products)) {
            echo ""; // For debugging, see if products are fetched
        }

        // Fetch total products for pagination
        $total_record = $this->db->getTotalProducts();
        $total_pages = ceil($total_record / $per_page);  // Calculate total pages

        // Pass products and pagination data to the view
        include_once '../views/trimer.php';
    }
}

<?php
include_once '../models/db.php';

class DetailController
{
    private $db;

    public function __construct()
    {
        $this->db = new db(); // Ensure db instance is set
    }

    // Add product to cart
    public function addToCart($product_id, $quantity, $size)
    {
        $this->db->addToCart($product_id, $quantity, $size);
    }

    // Fetch product and category data and return it to the view
    public function getProductDetails($product_id)
    {
        // Fetch product details
        $product = $this->db->getProductById($product_id);

        // If product is found, fetch category details as well
        if ($product) {
            $category = null;
            if (isset($product['p_cat_id'])) {
                $category = $this->db->getProductCategory($product['p_cat_id']);
            }
            return ['product' => $product, 'category' => $category];
        }

        return null;  // Return null if product doesn't exist
    }
}

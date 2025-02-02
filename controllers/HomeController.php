<?php
include '../models/db.php';

class HomeController
{
    private $db;

    public function __construct()
    {
        if (!isset($this->db)) {
            $this->db = new db();
        }
    }

    public function showHomePage()
    {
        // Fetch data for the homepage
        $sliders = $this->db->getSliders(0, 10);
        $sliders_main = isset($sliders[0]) ? [$sliders[0]] : [];
        $sliders_other = array_slice($sliders, 1);
        $deals = $this->db->getDeals();
        $products = $this->db->getPro(); // Fetch products using getPro()

        // Return the data as an associative array
        return [
            "sliders_main" => $sliders_main ?: [],
            "sliders_other" => $sliders_other ?: [],
            "deals" => $deals ?: [],
            "products" => $products ?: []
        ];
    }
}

// Initialize the controller and fetch data
$controller = new HomeController();
$homeData = $controller->showHomePage();

// Pass the data to the view
$sliders_main = $homeData["sliders_main"];
$sliders_other = $homeData["sliders_other"];
$deals = $homeData["deals"];
$products = $homeData["products"];

// Load the view
require_once "../views/index.php";

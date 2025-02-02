<?php
// ✅ Prevent multiple `BASE_PATH` definitions
if (!defined('BASE_PATH')) {
  define('BASE_PATH', __DIR__);
}

// ✅ Prevent multiple class declarations
if (!class_exists('db')) {
  class db
  {
    private $DBHostName = "localhost";
    private $DBUserName = "root";
    private $DBPassword = "";
    private $DBName = "e_com";

    public function __construct() {}

    public function createConObject()
    {
      $conn = new mysqli(
        $this->DBHostName,
        $this->DBUserName,
        $this->DBPassword,
        $this->DBName
      );

      if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
      }

      return $conn;
    }



    // for checkout
    public function isCustomerLoggedIn()
    {
      return isset($_SESSION['customer_email']);
    }
    // Insert user data into the database
    public function insertCustomer($data)
    {
      try {
        $conn = $this->createConObject();
        $query = "INSERT INTO customers (customer_name, customer_email, customer_pass, customer_country, customer_city, customer_contact, customer_address, customer_image, customer_ip) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
          throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param(
          "sssssssss", // String types for each column
          $data['customer_name'],
          $data['customer_email'],
          $data['customer_pass'],
          $data['customer_country'],
          $data['customer_city'],
          $data['customer_contact'],
          $data['customer_address'],
          $data['customer_image'],
          $data['customer_ip']
        );

        $result = $stmt->execute();

        if (!$result) {
          throw new Exception("Execution failed: " . $stmt->error);
        }

        $stmt->close();
        $this->closeCon($conn);

        return $result;
      } catch (Exception $e) {
        error_log($e->getMessage()); // Log the error to a file
        echo "Database error: " . $e->getMessage(); // Show the error for debugging
        return false;
      }
    }
    // edit profile

    public function getCustomerByEmail($email)
    {
      $conn = $this->createConObject();
      $query = "SELECT * FROM customers WHERE customer_email = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $customer = $result->fetch_assoc();
      $stmt->close();
      $conn->close();
      return $customer;
    }
    // Basic query function to execute the queries
    public function query($query)
    {
      $conn = $this->createConObject();
      $result = $conn->query($query);
      $conn->close();
      return $result->fetch_all(MYSQLI_ASSOC);  // Return as associative array
    }
    public function updateCustomer($customer_id, $data, $image)
    {
      $conn = $this->createConObject();
      $query = "UPDATE customers SET customer_name=?, customer_email=?, customer_country=?, customer_city=?, customer_contact=?, customer_address=?, customer_image=? WHERE customer_id=?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param(
        "sssssssi",
        $data['customer_name'],
        $data['customer_email'],
        $data['customer_country'],
        $data['customer_city'],
        $data['customer_contact'],
        $data['customer_address'],
        $image,
        $customer_id
      );

      $result = $stmt->execute();
      $stmt->close();
      $conn->close();

      return $result;
    }

    // Get the user's IP address
    function getUserIp()
    {
      switch (true) {
        case (!empty($_SERVER['HTTP_X_REAL_IP'])):
          return $_SERVER['HTTP_X_REAL_IP'];
        case (!empty($_SERVER['HTTP_CLIENT_IP'])):
          return $_SERVER['HTTP_CLIENT_IP'];
        case (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])):
          return $_SERVER['HTTP_X_FORWARDED_FOR'];
        default:
          return $_SERVER['REMOTE_ADDR'];
      }
    }
    //login 
    public function checkCustomerCredentials($email, $password)
    {
      $conn = $this->createConObject();
      $query = "SELECT customer_pass FROM customers WHERE customer_email = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $customer = $result->fetch_assoc();

      $stmt->close();
      $this->closeCon($conn);

      // Check if customer exists and verify the password
      if ($customer && password_verify($password, $customer['customer_pass'])) {
        return true; // Credentials are valid
      } else {
        return false; // Invalid credentials
      }
    }

    //update pass
    public function checkCurrentPassword($email, $oldPassword)
    {
      $conn = $this->createConObject();
      $query = "SELECT customer_pass FROM customers WHERE customer_email = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $customer = $result->fetch_assoc();
      $stmt->close();
      $conn->close();

      return ($customer && password_verify($oldPassword, $customer['customer_pass']));
    }

    public function updatePassword($email, $newPassword)
    {
      $conn = $this->createConObject();
      $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);
      $query = "UPDATE customers SET customer_pass = ? WHERE customer_email = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ss", $hashedPassword, $email);
      $result = $stmt->execute();
      $stmt->close();
      $conn->close();

      return $result;
    }

    //delete acc
    public function deleteCustomerAccount($email)
    {
      $conn = $this->createConObject();
      $query = "DELETE FROM customers WHERE customer_email = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $email);
      $result = $stmt->execute();
      $stmt->close();
      $this->closeCon($conn);

      return $result; // Return true if the account was successfully deleted
    }


    public function checkCartItems($ip)
    {
      $conn = $this->createConObject();
      $query = "SELECT * FROM cart WHERE ip_add = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $ip);
      $stmt->execute();
      $result = $stmt->get_result();
      $stmt->close();
      $this->closeCon($conn);
      return $result->num_rows > 0; // Returns true if cart items exist
    }


    // add to cart 
    public function addToCart($product_id, $quantity, $size)
    {
      // Create database connection
      $conn = $this->createConObject();

      // Get user IP address
      $ip = $this->getUserIp();
      error_log("User IP: " . $ip); // Debug log for IP address

      // Check if product exists
      $productQuery = "SELECT * FROM products WHERE product_id = ?";
      $productStmt = $conn->prepare($productQuery);
      $productStmt->bind_param("i", $product_id);
      $productStmt->execute();
      $productResult = $productStmt->get_result();
      if ($productResult->num_rows == 0) {
        die("Product not found.");
      }

      // Insert into cart
      $query = "INSERT INTO cart (p_id, ip_add, qty, size) VALUES (?, ?, ?, ?)";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("isis", $product_id, $ip, $quantity, $size);

      // Execute query and check for success
      if ($stmt->execute()) {
        $stmt->close();
        $this->closeCon($conn);
        return true;
      } else {
        error_log("Error executing query: " . $stmt->error);
        $stmt->close();
        $this->closeCon($conn);
        return false;
      }
    }

    // update cart
    public function updateCartQuantity($product_id, $quantity)
    {
      $conn = $this->createConObject();
      $ip = $this->getUserIp();

      $query = "UPDATE cart SET qty = ? WHERE p_id = ? AND ip_add = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("iis", $quantity, $product_id, $ip);

      $result = $stmt->execute();

      $stmt->close();
      $this->closeCon($conn);

      return $result; // Return true if the quantity was updated successfully
    }
    // Get Product Details by Product ID

    // remove cart 
    public function removeFromCart($product_id)
    {
      $conn = $this->createConObject();
      $ip = $this->getUserIp();

      $query = "DELETE FROM cart WHERE p_id = ? AND ip_add = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("is", $product_id, $ip);

      $result = $stmt->execute();

      $stmt->close();
      $this->closeCon($conn);

      return $result; // Return true if the product was removed successfully
    }

    public function totalPrice()
    {
      $conn = $this->createConObject(); // Database connection
      $ip = $this->getUserIp(); // Get the user's IP
      $total = 0;

      $query = "SELECT * FROM cart WHERE ip_add = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $ip);
      $stmt->execute();
      $result = $stmt->get_result();

      while ($record = $result->fetch_assoc()) {
        $pro_id = $record['p_id'];
        $pro_qty = $record['qty'];

        $priceQuery = "SELECT product_price FROM products WHERE product_id = ?";
        $priceStmt = $conn->prepare($priceQuery);
        $priceStmt->bind_param("i", $pro_id);
        $priceStmt->execute();
        $priceResult = $priceStmt->get_result();

        while ($row = $priceResult->fetch_assoc()) {
          $sub_total = $row['product_price'] * $pro_qty;
          $total += $sub_total;
        }
        $priceStmt->close();
      }

      $stmt->close();
      $this->closeCon($conn); // Close the database connection
      return $total; // Return the total price
    }
    public function getTotalPrice()
    {
      $products = $this->getCartProducts(); // Fetch all cart products
      $totalPrice = 0;

      foreach ($products as $product) {
        $totalPrice += $product['product_price'] * $product['qty']; // Calculate total price
      }

      return $totalPrice;
    }

    public function getTotalItems()
    {
      $products = $this->getCartProducts(); // Fetch all cart products
      return count($products); // Count the number of products in the cart
    }
    public function item()
    {
      $conn = $this->createConObject(); // Database connection
      $ip = $this->getUserIp(); // Get the user's IP
      $query = "SELECT COUNT(*) AS total_items FROM cart WHERE ip_add = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $ip);
      $stmt->execute();
      $result = $stmt->get_result();
      $items = 0;

      if ($row = $result->fetch_assoc()) {
        $items = $row['total_items'];
      }

      $stmt->close();
      $this->closeCon($conn); // Close the database connection
      return $items; // Return the total items
    }


    // Get total number of items in the cart
    public function itemCount($ip)
    {
      // Get the database connection object from the db class
      $conn = $this->createConObject(); // Get the database connection from the db class

      // SQL query to count the number of items in the cart for the given IP
      $query = "SELECT COUNT(*) AS item_count FROM cart WHERE ip_add = ?";

      // Prepare and execute the query
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $ip); // Bind the IP address parameter
      $stmt->execute();
      $result = $stmt->get_result();

      // Fetch the result and return the item count
      $row = $result->fetch_assoc();
      return $row['item_count'];
    }
    public function getCartProducts()
    {
      $conn = $this->createConObject(); // Create a database connection
      $ip = $this->getUserIp(); // Get the user's IP address
      $query = "SELECT c.*, p.product_title, p.product_price, p.product_img1 
              FROM cart c 
              JOIN products p ON c.p_id = p.product_id 
              WHERE c.ip_add = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $ip);
      $stmt->execute();
      $result = $stmt->get_result();
      $products = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      $this->closeCon($conn); // Close the database connection
      return $products; // Return the products array
    }
    //sidebar cat
    public function getCat()
    {
      $conn = $this->createConObject(); // Create database connection
      $query = "SELECT * FROM categories"; // Fetch all categories
      $result = $conn->query($query);

      if (
        $result->num_rows > 0
      ) {
        while ($row = $result->fetch_assoc()) {
          echo "<li><a href='category.php?cat_id=" . $row['cat_id'] . "'>" . $row['cat_title'] . "</a></li>";
        }
      } else {
        echo "<li>No categories found</li>";
      }

      $this->closeCon($conn); // Close the connection
    }
    // Fetch product category based on its ID
    public function getProductCategory($p_cat_id)
    {
      $conn = $this->createConObject();
      $query = "SELECT * FROM product_category WHERE p_cat_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $p_cat_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $category = $result->fetch_assoc();

      if ($category) {
        echo "<li>" . $category['p_cat_title'] . "</li>";
      } else {
        echo "<li>No product category found</li>";
      }

      $stmt->close();
      $this->closeCon($conn); // Close the connection
    }
    public function getProducts($productId)
    {
      // Create the connection object
      $conn = $this->createConObject();

      // Check if the connection is null before running the query
      if (!$conn) {
        die("Connection failed.");
      }

      $query = "SELECT * FROM products WHERE product_id='$productId'";
      $result = mysqli_query($conn, $query);

      if (!$result) {
        die("Query failed: " . mysqli_error($conn)); // Display query errors
      }

      return mysqli_fetch_array($result);
    }



    // product fetching functions 
    public function getFeaturedProducts($limit = 6)
    {
      $conn = $this->createConObject();
      $query = "SELECT * FROM products ORDER BY product_id DESC LIMIT 6";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $limit);
      $stmt->execute();
      $result = $stmt->get_result();
      $products = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      $conn->close();
      return $products;
    }
    // Get Product Details by Product ID
    public function getProductById($product_id)
    {
      $conn = $this->createConObject();
      $query = "SELECT * FROM products WHERE product_id = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $product_id);
      $stmt->execute();
      $result = $stmt->get_result();
      $product = $result->fetch_assoc();
      $stmt->close();
      $conn->close();
      return $product;
    }

    // Fetch related products
    public function getRelatedProducts()
    {
      $conn = $this->createConObject();
      $query = "SELECT * FROM products ORDER BY 1 LIMIT 0,5";
      $result = mysqli_query($conn, $query);
      return $result;
    }


    // payment method
    public function insertPayment($invoice_id, $amount, $payment_mode, $ref_no, $payment_date)
    {
      try {
        $conn = $this->createConObject(); // Use the existing connection method
        $query = "INSERT INTO payments (invoice_id, amount, payment_mode, ref_no, payment_date) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
          throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("sdsss", $invoice_id, $amount, $payment_mode, $ref_no, $payment_date);
        $result = $stmt->execute();

        if (!$result) {
          throw new Exception("Execution failed: " . $stmt->error);
        }

        $stmt->close();
        $this->closeCon($conn); // Close the connection

        return true; // Success
      } catch (Exception $e) {
        error_log($e->getMessage()); // Log errors
        return false; // Failure
      }
    }

    public function updateOrderStatus($order_id, $status)
    {
      try {
        $conn = $this->createConObject(); // Use the existing connection method
        $query = "UPDATE customer_order SET order_status = ? WHERE order_id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
          throw new Exception("Prepare failed: " . $conn->error);
        }

        $stmt->bind_param("si", $status, $order_id);
        $result = $stmt->execute();

        if (!$result) {
          throw new Exception("Execution failed: " . $stmt->error);
        }

        $stmt->close();
        $this->closeCon($conn); // Close the connection

        return true; // Success
      } catch (Exception $e) {
        error_log($e->getMessage()); // Log errors
        return false; // Failure
      }
    }
    // Adjust the query to fetch only a subset of products per page
    public function getPaginatedProducts($page = 1, $per_page = 10)
    {
      $start_from = ($page - 1) * $per_page; // Calculate starting point

      $conn = $this->createConObject();
      $query = "SELECT * FROM products ORDER BY product_id DESC LIMIT ?, ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ii", $start_from, $per_page);
      $stmt->execute();
      $result = $stmt->get_result();
      $products = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      $this->closeCon($conn);

      return $products;
    }

    // ORDER FUNCTION
    public function getOrdersByCustomerEmail($email, $page = 1, $limit = 10)
    {
      $conn = $this->createConObject();

      // Step 1: Get customer_id from email
      $query = "SELECT customer_id FROM customers WHERE customer_email = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $email);
      $stmt->execute();
      $result = $stmt->get_result();
      $customer = $result->fetch_assoc();
      $stmt->close();

      // If customer does not exist, return an empty array
      if (!$customer) {
        $conn->close();
        return [];
      }

      $customer_id = $customer['customer_id'];

      // Step 2: Get orders based on customer_id with pagination
      $start_from = ($page - 1) * $limit;
      $query = "SELECT * FROM customer_order WHERE customer_id = ? LIMIT ?, ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("iii", $customer_id, $start_from, $limit);
      $stmt->execute();
      $result = $stmt->get_result();
      $orders = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      $conn->close();

      return $orders ?: []; // Ensure we always return an array
    }


    // ORDER.PHP
    public function getCartItems($ip)
    {
      $conn = $this->createConObject();
      $query = "SELECT * FROM cart WHERE ip_add = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $ip);
      $stmt->execute();
      $result = $stmt->get_result();
      $cartItems = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      $conn->close();
      return $cartItems;
    }




    public function insertCustomerOrder($customer_id, $product_id, $due_amount, $invoice_no, $qty, $size)
    {
      $conn = $this->createConObject();
      $query = "INSERT INTO customer_order (customer_id, product_id, due_amount, invoice_no, qty, size, order_date, order_status) 
                  VALUES (?, ?, ?, ?, ?, ?, NOW(), 'pending')";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("iidisi", $customer_id, $product_id, $due_amount, $invoice_no, $qty, $size);
      $result = $stmt->execute();
      $stmt->close();
      $conn->close();
      return $result;
    }

    public function clearCart($ip)
    {
      $conn = $this->createConObject();
      $query = "DELETE FROM cart WHERE ip_add = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("s", $ip);
      $stmt->execute();
      $stmt->close();
      $conn->close();
    }


    public function getTotalProducts()
    {
      $conn = $this->createConObject();
      $query = "SELECT COUNT(*) as total FROM products";
      $result = $conn->query($query);
      $row = $result->fetch_assoc();
      $conn->close();

      return $row['total'];
    }
    // index 
    public function getSliders($limit_start, $limit_end)
    {
      $conn = $this->createConObject();
      $query = "SELECT * FROM slider LIMIT ?, ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ii", $limit_start, $limit_end);
      $stmt->execute();
      $result = $stmt->get_result();
      $sliders = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      $conn->close();

      return $sliders;
    }
    public function getAllProducts($limit = 6)
    {
      $conn = $this->createConObject();
      $query = "SELECT * FROM products ORDER BY product_id DESC LIMIT ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("i", $limit);
      $stmt->execute();
      $result = $stmt->get_result();
      $products = $result->fetch_all(MYSQLI_ASSOC);
      $stmt->close();
      $conn->close();
      return $products;
    }
    // get pro
    public function getPro()
    {
      $conn = $this->createConObject();
      $query = "SELECT product_id, product_title, product_price, product_img1 FROM products ORDER BY product_id DESC LIMIT 6";
      $result = $conn->query($query);

      if (!$result) {
        die("Error fetching products: " . $conn->error);
      }

      $products = $result->fetch_all(MYSQLI_ASSOC);
      $conn->close();

      return $products ?: []; // ✅ Ensure an empty array is returned if no products exist
    }


    public function getDeals()
    {
      $conn = $this->createConObject();
      $query = "SELECT * FROM boxes_section";
      $result = $conn->query($query);
      $deals = $result->fetch_all(MYSQLI_ASSOC);
      $conn->close();

      return $deals;
    }
    // Close the database connection
    public function closeCon($conn)
    {
      $conn->close();
    }
  }
}

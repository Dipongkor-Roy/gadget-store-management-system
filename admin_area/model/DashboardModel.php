<?php
class DashboardModel {
    private $con;

    public function __construct($dbConnection) {
        $this->con = $dbConnection;
    }

    public function getOrderDetails() {
        $query = "SELECT * FROM customer_order ORDER BY 1 DESC LIMIT 0,5";
        return mysqli_query($this->con, $query);
    }

    public function getCustomerEmail($customerId) {
        $query = "SELECT customer_email FROM customers WHERE customer_id='$customerId'";
        $result = mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($result)['customer_email'];
    }

    public function getCount($table) {
        $query = "SELECT COUNT(*) AS count FROM $table";
        $result = mysqli_query($this->con, $query);
        return mysqli_fetch_assoc($result)['count'];
    }
}
?>

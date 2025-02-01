<?php
function deleteCustomer($con, $delete_id) {
    echo "Function called with parameters: Connection Object, ID = $delete_id"; // Debugging

    $delete_customer = "DELETE FROM customers WHERE customer_id='$delete_id'";
    $run_delete = mysqli_query($con, $delete_customer);

    if ($run_delete) {
        echo "<script>alert('Customer Has Been Deleted')</script>";
        echo "<script>window.open('index.php?view_customer','_self')</script>";
    } else {
        // Debug error
        echo "Error: " . mysqli_error($con);
    }
}
?>

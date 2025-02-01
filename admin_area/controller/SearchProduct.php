<?php
include("../includes/db.php"); // Database connection file

$search = $_GET['search'];

if (!empty($search)) {
    $query = "SELECT * FROM products WHERE product_id LIKE '%$search%'";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<tr>
                    <td>".$row['product_id']."</td>
                    <td>".$row['product_title']."</td>
                    <td><img src='../images/product_images/".$row['product_img1']."' width='60' height='50'></td>
                    <td>".$row['product_price']."</td>
                    <td>".$row['product_keyword']."</td>
                    <td>".$row['date']."</td>
                    <td><a href='index.php?delete_product=".$row['product_id']."'> <i class='fa fa-trash'></i> Delete </a></td>
                    <td><a href='index.php?edit_product=".$row['product_id']."'> <i class='fa fa-pen'></i> Edit </a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='8'>No product found</td></tr>";
    }
} else {
    echo "<tr><td colspan='8'>Please enter a product ID</td></tr>";
}
?>

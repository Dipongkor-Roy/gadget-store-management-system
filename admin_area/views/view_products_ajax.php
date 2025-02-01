<?php  
session_start();
include("includes/db.php"); // Make sure to include your database connection file

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php','_self')</script>";
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Products</title>
    <link rel="stylesheet" href="../css/style.css">
    <script src="../ajax/searchProduct.js"></script> <!-- Link to the JavaScript file -->
</head>
<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrump">
                <li class="active">
                    <i class="fa fa-bar-chart"></i> Dashboard / View Product- (Search Ajax)
                </li>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <input type="text" id="search" placeholder="Search by Product ID" onkeyup="searchProduct()">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="fa fa-money fa-fw"> View Products </i>
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Product Id</th>
                                    <th>Product Title</th>
                                    <th>Product Image</th>
                                    <th>Product Price</th>
                                    <th>Product Keyword</th>
                                    <th>Product Date</th>
                                    <th>Delete</th>
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody id="productTable">
                                <?php 
                                $i = 0;
                                $get_product = "SELECT * FROM products";
                                $run_p = mysqli_query($con, $get_product);
                                while ($row = mysqli_fetch_array($run_p)) {
                                    $pro_id = $row['product_id'];
                                    $product_title = $row['product_title'];
                                    $product_img1 = $row['product_img1'];
                                    $product_price = $row['product_price'];
                                    $product_keyword = $row['product_keyword'];
                                    $date = $row['date'];
                                    $i++;
                                ?>
                                <tr>
                                    <td><?php echo $pro_id ?></td>
                                    <td><?php echo $product_title ?></td>
                                    <td><img src="../images/product_images/<?php echo $product_img1 ?>" width="60" height="50"></td>
                                    <td><?php echo $product_price ?></td>
                                    <td><?php echo $product_keyword ?></td>
                                    <td><?php echo $date ?></td>
                                    <td><a href="index.php?delete_product=<?php echo $pro_id ?>"> <i class="fa fa-trash"></i> Delete </a></td>
                                    <td><a href="index.php?edit_product=<?php echo $pro_id ?>"> <i class="fa fa-pen"></i> Edit </a></td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php } ?>

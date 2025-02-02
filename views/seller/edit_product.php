<?php
session_start();
require_once '../includes/db.php';

if (!isset($_SESSION['admin_email'])) {
    echo "<script>window.open('login.php', '_self')</script>";
    exit();
}

if (isset($_GET['edit_product'])) {
    $edit_id = $_GET['edit_product'];

    // Fetch product details
    $query = "SELECT * FROM products WHERE product_id = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $edit_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "<script>alert('Invalid Product ID')</script>";
        echo "<script>window.open('index.php?view_product', '_self')</script>";
        exit();
    }

    $row = $result->fetch_assoc();
    $p_id = $row['product_id'];
    $p_title = htmlspecialchars($row['product_title']);
    $p_cat = $row['p_cat_id'];
    $cat = $row['cat_id'];
    $p_image1 = $row['product_img1'];
    $p_image2 = $row['product_img2'];
    $p_image3 = $row['product_img3'];
    $p_price = $row['product_price'];
    $p_desc = htmlspecialchars($row['product_desc']);
    $p_keyword = htmlspecialchars($row['product_keyword']);
}

// Form submission for updating product
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_title = $_POST['product_title'];
    $product_cat = $_POST['product_cat'];
    $cat = $_POST['cat'];
    $product_price = $_POST['product_price'];
    $product_desc = $_POST['product_desc'];
    $product_keyword = $_POST['product_keyword'];

    // Handle image uploads
    $product_img1 = $_FILES['product_img1']['name'] ?: $p_image1;
    $product_img2 = $_FILES['product_img2']['name'] ?: $p_image2;
    $product_img3 = $_FILES['product_img3']['name'] ?: $p_image3;

    if (!empty($_FILES['product_img1']['tmp_name'])) {
        move_uploaded_file($_FILES['product_img1']['tmp_name'], "../uploads/product_images/$product_img1");
    }
    if (!empty($_FILES['product_img2']['tmp_name'])) {
        move_uploaded_file($_FILES['product_img2']['tmp_name'], "../uploads/product_images/$product_img2");
    }
    if (!empty($_FILES['product_img3']['tmp_name'])) {
        move_uploaded_file($_FILES['product_img3']['tmp_name'], "../uploads/product_images/$product_img3");
    }

    // Update query
    $update_query = "UPDATE products SET 
        product_title = ?, 
        p_cat_id = ?, 
        cat_id = ?, 
        product_price = ?, 
        product_desc = ?, 
        product_keyword = ?, 
        product_img1 = ?, 
        product_img2 = ?, 
        product_img3 = ?, 
        date = NOW() 
        WHERE product_id = ?";
    $stmt = $con->prepare($update_query);
    $stmt->bind_param(
        "siissssssi",
        $product_title,
        $product_cat,
        $cat,
        $product_price,
        $product_desc,
        $product_keyword,
        $product_img1,
        $product_img2,
        $product_img3,
        $p_id
    );

    if ($stmt->execute()) {
        echo "<script>alert('Product updated successfully')</script>";
        echo "<script>window.open('index.php?view_product', '_self')</script>";
    } else {
        echo "<script>alert('Failed to update product')</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Product</title>
</head>

<body>
    <div class="row">
        <div class="col-lg-12">
            <div class="breadcrumb">
                <li class="active">
                    <i class="fa fa-bar-chart"></i> Dashboard / Edit Product
                </li>
            </div>
        </div>
    </div>

    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title"><i class="fa fa-money fa-fw"></i> Edit Product</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" enctype="multipart/form-data">
                <!-- Product Title -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Product Title</label>
                    <div class="col-md-6">
                        <input type="text" name="product_title" class="form-control" required value="<?= $p_title; ?>">
                    </div>
                </div>
                <!-- Product Category -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Product Category</label>
                    <div class="col-md-6">
                        <select name="product_cat" class="form-control">
                            <option value="<?= $p_cat; ?>"><?= $p_cat; ?></option>
                            <?php
                            $query = "SELECT * FROM product_category";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['p_cat_id']}'>{$row['p_cat_title']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Category -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Category</label>
                    <div class="col-md-6">
                        <select name="cat" class="form-control">
                            <option value="<?= $cat; ?>"><?= $cat; ?></option>
                            <?php
                            $query = "SELECT * FROM categories";
                            $result = mysqli_query($con, $query);
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<option value='{$row['cat_id']}'>{$row['cat_title']}</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <!-- Images -->
                <?php for ($i = 1; $i <= 3; $i++) : ?>
                    <div class="form-group">
                        <label class="col-md-3 control-label">Product Image <?= $i ?></label>
                        <div class="col-md-6">
                            <input type="file" name="product_img<?= $i ?>" class="form-control">
                            <br>
                            <img src="../uploads/product_images/<?= ${"p_image$i"} ?>" width="70" height="70">
                        </div>
                    </div>
                <?php endfor; ?>
                <!-- Price -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Product Price</label>
                    <div class="col-md-6">
                        <input type="text" name="product_price" class="form-control" required value="<?= $p_price; ?>">
                    </div>
                </div>
                <!-- Keyword -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Product Keyword</label>
                    <div class="col-md-6">
                        <input type="text" name="product_keyword" class="form-control" required value="<?= $p_keyword; ?>">
                    </div>
                </div>
                <!-- Description -->
                <div class="form-group">
                    <label class="col-md-3 control-label">Product Description</label>
                    <div class="col-md-6">
                        <textarea name="product_desc" class="form-control" rows="6"><?= $p_desc; ?></textarea>
                    </div>
                </div>
                <!-- Submit -->
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-3">
                        <button type="submit" name="update" class="btn btn-primary">Update Product</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>
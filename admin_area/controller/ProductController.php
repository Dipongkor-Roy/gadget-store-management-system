<?php  
if (!isset($_SESSION['admin_email'])){

  echo "<script>window.open('login.php','_self')</script>";
  }else{

?>

<?php
if (isset($_GET['delete_p_cat'])) {
	$delete_p_cat_id=$_GET['delete_p_cat'];
	$delete_p_cat="delete from product_category where p_cat_id='$delete_p_cat_id'";
	$run_delete=mysqli_query($con,$delete_p_cat);
	if ($run_delete) {
		echo "<script>alert('Your One Product Has Been Deleted')</script>";
		echo "<script>window.open('index.php?view_product_cat','_self')</script>";
	}
}


  ?>
  <?php
if (isset($_GET['delete_product'])) {
	$delete_id=$_GET['delete_product'];
	$delete_pro="delete from products where product_id='$delete_id'";
	$run_delete=mysqli_query($con,$delete_pro);
	if ($run_delete) {
		echo "<script>alert('Your One Product Has Been Deleted')</script>";
		echo "<script>window.open('index.php?view_product','_self')</script>";
	}
}


  ?>
  <?php

if (isset($_GET['edit_p_cat'])) {
	$edit_p_cat_id=$_GET['edit_p_cat'];
	$edit_p_cat_query="select * from product_category where p_cat_id='$edit_p_cat_id'";

	$run_edit=mysqli_query($con,$edit_p_cat_query);
	$row_edit=mysqli_fetch_array($run_edit);

	$p_cat_id=$row_edit['p_cat_id'];
	$p_cat_title=$row_edit['p_cat_title'];

	$p_cat_desc=$row_edit['p_cat_desc'];

}

?>
<?php
if (isset($_POST['update'])) {
	$p_cat_title=$_POST['p_cat_title'];
	$p_cat_desc=$_POST['p_cat_desc'];

	$update_p_cat="update product_category set p_cat_title='$p_cat_title',p_cat_desc='$p_cat_desc' where p_cat_id='$p_cat_id'";

	$run_p_cat=mysqli_query($con,$update_p_cat);

	if ($run_p_cat) {
		echo "<script>alert('Product has been updated successfully')</script>";
		echo "<script>window.open('index.php?view_product_cat','_self')</script>";
	}


}


  ?>
<!-- main product controls -->
<?php

if (isset($_GET['edit_product'])) {
	$edit_id=$_GET['edit_product'];
	$get_p="select * from products where product_id='$edit_id'";
	$run_edit=mysqli_query($con,$get_p);
	$row_edit=mysqli_fetch_array($run_edit);
	$p_id=$row_edit['product_id'];
	$p_title=$row_edit['product_title'];
	$p_cat=$row_edit['p_cat_id'];
	$cat=$row_edit['cat_id'];
	$p_image1=$row_edit['product_img1'];
	$p_image2=$row_edit['product_img2'];
	$p_image3=$row_edit['product_img3'];
	$p_price=$row_edit['product_price'];
	$p_desc=$row_edit['product_desc'];
	$p_keyword=$row_edit['product_keyword'];

}

$get_p_cat="select * from product_category where p_cat_id='$p_cat'";
$run_p_cat=mysqli_query($con,$get_p_cat);
$row_p_cat=mysqli_fetch_array($run_p_cat);
$p_cat_title=$row_p_cat['p_cat_title'];
$get_cat="select * from categories where cat_id='$cat'";
$run_cat=mysqli_query($con,$get_cat);
$row_cat=mysqli_fetch_array($run_cat);
$cat_title=$row_cat['cat_title'];

?>
<?php
if (isset($_POST['update'])) {
	$product_title=$_POST['product_title'];
	$product_cat=$_POST['product_cat'];
	$cat=$_POST['cat'];
	$product_price=$_POST['product_price'];
	$product_desc=$_POST['product_desc'];
	$product_keyword=$_POST['product_keyword'];

	$product_img1=$_FILES['product_img1']['name'];
	$product_img2=$_FILES['product_img2']['name'];
	$product_img3=$_FILES['product_img3']['name'];

	$temp_name1=$_FILES['product_img1']['tmp_name'];
	$temp_name2=$_FILES['product_img2']['tmp_name'];
	$temp_name3=$_FILES['product_img3']['tmp_name'];

	move_uploaded_file($temp_name1,"../images/product_images/$product_img1");
	move_uploaded_file($temp_name2,"../images/product_images/$product_img2");
	move_uploaded_file($temp_name3,"../images/product_images/$product_img3");

	$update_product="update products set p_cat_id='$product_cat',cat_id='$cat',date=NOW(),product_title='$product_title',product_img1='$product_img1',product_img2='$product_img2',product_img3='$product_img3',product_price='$product_price',product_keyword='$product_keyword' where product_id='$p_id'";
	$run_product=mysqli_query($con,$update_product);
	if ($run_product) {
		echo "<script>alert('Product has been updated successfully')</script>";
		echo "<script>window.open('index.php?view_product','_self')</script>";
	}


}


  ?>
  <?php 
if (isset($_POST['submit'])) {
	$p_cat_title=$_POST['p_cat_title'];
	$p_cat_desc=$_POST['p_cat_desc'];

	$insert_p_cat="insert into product_category (p_cat_title,p_cat_desc) values ('$p_cat_title','$p_cat_desc')";
	$run_p_cat=mysqli_query($con,$insert_p_cat);
	if ($run_p_cat) {
		echo "<script>alert('New product category has been inserted')</script>";
		echo "<script>window.open('index.php?view_product_cat','_self')</script>";
	}
}


 ?>
<!-- insert product
 <?php
if (isset($_POST['submit'])) {
	$product_title=$_POST['product_title'];
	$product_cat=$_POST['product_cat'];
	$cat=$_POST['cat'];
	$product_price=$_POST['product_price'];
	$product_desc=$_POST['product_desc'];
	$product_keyword=$_POST['product_keyword'];

	$product_img1=$_FILES['product_img1']['name'];
	$product_img2=$_FILES['product_img2']['name'];
	$product_img3=$_FILES['product_img3']['name'];

	$temp_name1=$_FILES['product_img1']['tmp_name'];
	$temp_name2=$_FILES['product_img2']['tmp_name'];
	$temp_name3=$_FILES['product_img3']['tmp_name'];

	move_uploaded_file($temp_name1, "../images/product_images/$product_img1");
	move_uploaded_file($temp_name2, "../images/product_images/$product_img2");
	move_uploaded_file($temp_name3, "../images/product_images/$product_img3");

	$inset_product="insert into products(p_cat_id,cat_id,date,product_title,product_img1,product_img2, product_img3,product_price,product_desc,product_keyword) values ('$product_cat','$cat',NOW(),'$product_title','$product_img1','$product_img2','$product_img3','$product_price','$product_desc','$product_keyword')";

	$run_product=mysqli_query($con,$inset_product);

	if ($run_product) {
	echo "<script>alert('Product Inserted Sucessfully')</script>";
	echo "<script>window.open('index.php?view_product')</script>";
	
	}
}

  ?> -->

<?php } ?>
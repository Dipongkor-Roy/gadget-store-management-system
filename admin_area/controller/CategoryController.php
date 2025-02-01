<?php  
if (!isset($_SESSION['admin_email'])){

  echo "<script>window.open('login.php','_self')</script>";
  }else{

?>

<?php
if (isset($_GET['delete_cat'])) {
	$delete_id=$_GET['delete_cat'];
	$delete_cat="delete from categories where cat_id='$delete_id'";
	$run_delete=mysqli_query($con,$delete_cat);
	if ($run_delete) {
		echo "<script>alert('Your One Category Has Been Deleted')</script>";
		echo "<script>window.open('index.php?view_categories','_self')</script>";
	}
}


  ?>
  <?php

if (isset($_GET['edit_cat'])) {
	$edit_id=$_GET['edit_cat'];
	$edit_cat="select * from categories where cat_id='$edit_id'";

	$run_edit=mysqli_query($con,$edit_cat);
	$row_edit=mysqli_fetch_array($run_edit);

	$c_id=$row_edit['cat_id'];
	$c_title=$row_edit['cat_title'];

	$c_desc=$row_edit['cat_desc'];

}

?>
<?php
if (isset($_POST['update'])) {
	$cat_title=$_POST['cat_title'];
	$cat_desc=$_POST['cat_desc'];

	$update_cat="update categories set cat_title='$cat_title',cat_desc='$cat_desc' where cat_id='$c_id'";

	$run_cat=mysqli_query($con,$update_cat);

	if ($run_cat) {
		echo "<script>alert('One Category has been updated successfully')</script>";
		echo "<script>window.open('index.php?view_categories','_self')</script>";
	}


}


  ?>

  <!-- insert category -->
  <?php
if (isset($_POST['submit'])) {
	$cat_title=$_POST['cat_title'];
	$cat_desc=$_POST['cat_desc'];

	$insert_cat="insert into categories (cat_title,cat_desc) values ('$cat_title','$cat_desc')";

	$run_cat=mysqli_query($con,$insert_cat);

	if ($run_cat) {
		echo "<script>alert('New CAtegory has been Inserted successfully')</script>";
		echo "<script>window.open('index.php?view_categories','_self')</script>";
	}


}


  ?>


<?php } ?>
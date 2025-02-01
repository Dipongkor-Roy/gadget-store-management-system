<?php  
if (!isset($_SESSION['admin_email'])){

  echo "<script>window.open('login.php','_self')</script>";
  }else{

?>

<?php
if (isset($_GET['user_delete'])) {
	$delete_id=$_GET['user_delete'];
	$delete_user="delete from admins where admin_id='$delete_id'";

	$run_delete=mysqli_query($con,$delete_user);

	if ($run_delete) {
		echo "<script>alert('One User has been deleted')</script>";
		echo "<script>window.open('index.php?view_user','_self')</script>";
	}
}


  ?>
  <?php
if (isset($_GET['user_profile'])){
$edit_id=$_GET['user_profile'];
$get_admin="select * from admins where admin_id='$edit_id'";
$run_admin=mysqli_query($con,$get_admin);
$row_admin=mysqli_fetch_array($run_admin);
$admin_id=$row_admin['admin_id'];
$admin_name=$row_admin['admin_name'];
$admin_email=$row_admin['admin_email'];
$admin_pass=$row_admin['admin_pass'];
$admin_image=$row_admin['admin_image'];
$admin_country=$row_admin['admin_country'];
$admin_job=$row_admin['admin_job'];
$admin_contact=$row_admin['admin_contact'];
$admin_about=$row_admin['admin_about'];
}

  ?>
  <?php 
if (isset($_POST['update'])) {
	$admin_name=$_POST['admin_name'];
	$admin_email=$_POST['admin_email'];
	$admin_pass=$_POST['admin_pass'];
	$admin_country=$_POST['admin_country'];
	$admin_job=$_POST['admin_job'];
	$admin_contact=$_POST['admin_contact'];
	$admin_about=$_POST['admin_about'];
	$admin_image=$_FILES['admin_image']['name'];
	$temp_admin_image=$_FILES['admin_image']['tmp_name'];

	move_uploaded_file($temp_admin_image,"images/admin_images/$admin_image");

	$update_admin="update admins set admin_name='$admin_name',admin_email='$admin_email',admin_pass='$admin_pass',admin_image='$admin_image',admin_contact='$admin_contact',admin_country='$admin_country',admin_job='$admin_job',admin_about='$admin_about' where admin_id='$admin_id'";

	$run_admin=mysqli_query($con,$update_admin);
	if ($run_admin) {
		echo "<script>alert('User has been updated and login again')</script>";
		echo "<script>window.open('login.php','_self')</script>";

		session_destroy();
	}
}


 ?>


<?php } ?>
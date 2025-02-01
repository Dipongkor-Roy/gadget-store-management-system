<?php  
if (!isset($_SESSION['admin_email'])){

  echo "<script>window.open('../admin_area/views/login.php','_self')</script>";
  }else{

?>


<?php 
if (isset($_POST['submit'])) {
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

	$insert_admin="insert into admins (admin_name,admin_email,admin_pass,admin_image,admin_contact,admin_country,admin_job,admin_about) values ('$admin_name','$admin_email','$admin_pass','$admin_image','$admin_contact','$admin_country','$admin_job','$admin_about')";
	$run_admin=mysqli_query($con,$insert_admin);
	if ($run_admin) {
		echo "<script>alert('One New User has been inserted')</script>";
		echo "<script>window.open('../view/index.php?view_user','_self')</script>";
	}
}


 ?>

<?php } ?>
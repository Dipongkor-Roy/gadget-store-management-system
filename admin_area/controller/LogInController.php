<?php
session_start();
include("includes/db.php");


  ?>
<?php
if (isset($_POST['admin_login'])) {

	$admin_email = mysqli_real_escape_string($con, $_POST['admin_email']);
	$admin_pass = mysqli_real_escape_string($con, $_POST['admin_pass']);
  
	$get_admin = "select * from admins where admin_email='$admin_email' AND admin_pass='$admin_pass'";
  
	$run_admin = mysqli_query($con, $get_admin);
	$count = mysqli_num_rows($run_admin);
  
	if ($count == 1) {
	  $_SESSION['admin_email'] = $admin_email;
	  echo "<script>alert('You are logged')</script>";
	  echo "<script>window.open('index.php?dashboard','_self')</script>";
  
	} else {
	  echo "<script>alert('Email / Password Wrong')</script>";
	}
  }


  ?>
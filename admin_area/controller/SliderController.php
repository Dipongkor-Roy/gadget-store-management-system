<?php  
if (!isset($_SESSION['admin_email'])){

  echo "<script>window.open('login.php','_self')</script>";
  }else{

?>

<?php
if (isset($_GET['delete_slide'])) {
	$delete_id=$_GET['delete_slide'];
	$delete_slide="delete from slider where Id='$delete_id'";

	$run_delete=mysqli_query($con,$delete_slide);

	if ($run_delete) {
		echo "<script>alert('One Slide Has Been Deleted')</script>";
		echo "<script>window.open('index.php?view_slider','_self')</script>";
	}
}


  ?>
  <?php

if (isset($_GET['edit_slide'])) {
	$edit_id=$_GET['edit_slide'];
	$edit_slide="select * from slider where Id='$edit_id'";

	$run_edit=mysqli_query($con,$edit_slide);
	$row_edit=mysqli_fetch_array($run_edit);

	$slide_id=$row_edit['Id'];
	$slide_name=$row_edit['slider_name'];

	$slide_image=$row_edit['slider_image'];
	$slide_url=$row_edit['slider_url'];

}

?>
<?php
if (isset($_POST['update'])) {
	$slide_name=$_POST['slider_name'];
	$slide_image=$_FILES['slider_image']['name'];
	$temp_name=$_FILES['slider_image']['tmp_name'];
	$slide_url=$_POST['slider_url'];

	move_uploaded_file($temp_name,"images/slider_images/$slide_image");

	$update_slide="update slider set slider_name='$slide_name',slider_image='$slide_image',slider_url='$slide_url' where Id='$slide_id'";
	$run_slide=mysqli_query($con,$update_slide);
	if ($run_slide) {
		echo "<script>alert('One slide has been updated')</script>";
		echo "<script>window.open('index.php?view_slider','_self')</script>";
	}



}


  ?>

  <!-- insert slider
  <?php 
if (isset($_POST['submit'])) {
	$slide_name=$_POST['slider_name'];
	$slide_url=$_POST['slider_url'];

	$slide_image=$_FILES['slider_image']['name'];
	$temp_name=$_FILES['slider_image']['tmp_name'];


	$view_slides="select * from slider";
	$view_run_slides=mysqli_query($con,$view_slides);
	$count=mysqli_num_rows($view_run_slides);

	if ($count<10) {
		move_uploaded_file($temp_name,"images/slider_images/$slide_image");

		$insert_slide="insert into slider (slider_name,slider_image,slider_url) values ('$slide_name','$slide_image','$slide_url')";
		$run_slide=mysqli_query($con,$insert_slide);

		echo "<script>alert('New Slide has been inserted')</script>";
		echo "<script>window.open('index.php?view_slider','_self')</script>";
	}else{
		echo "<script>alert('You have already inserted 10 slides')</script>";
	}
}	



 ?> -->



<?php } ?>
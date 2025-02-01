<?php  
if (!isset($_SESSION['admin_email'])){

  echo "<script>window.open('login.php','_self')</script>";
  }else{

?>

<?php
if (isset($_GET['delete_box'])) {
	$delete_box=$_GET['delete_box'];
	$delete_box="delete from boxes_section where box_id='$delete_box'";

	$run_query=mysqli_query($con,$delete_box);

	if ($run_query) {
		echo "<script>alert('Data Deleted')</script>";
		echo "<script>window.open('index.php?view_box','_self')</script>";
	}
}


  ?>
  <?php

if (isset($_GET['edit_box'])) {
	$edit_box=$_GET['edit_box'];
	$get_box="select * from boxes_section where box_id='$edit_box'";

	$run_box=mysqli_query($con,$get_box);
	$row_box=mysqli_fetch_array($run_box);

	$box_id=$row_box['box_id'];
	$box_icon=$row_box['box_icon'];
	$box_title=$row_box['box_title'];

	$box_desc=$row_box['box_desc'];


}

?>
<?php
if (isset($_POST['submit'])) {
	$box_icon=$_POST['box_icon'];
	$box_title=$_POST['box_title'];
	$box_desc=$_POST['box_desc'];
	

	$update_box="update boxes_section set box_icon='$box_icon',box_title='$box_title',box_desc='$box_desc' where box_id='$box_id'";

	$run_box=mysqli_query($con,$update_box);

	if ($run_box) {
		echo "<script>alert('Information Updated')</script>";
		echo "<script>window.open('index.php?view_box','_self')</script>";
	}


}


  ?>
  <?php
if (isset($_POST['submit'])) {
	$box_title=$_POST['box_title'];
	$box_desc=$_POST['box_desc'];
	$box_icon=$_POST['box_icon'];

	$insert_box="insert into boxes_section (box_icon,box_title,box_desc) values ('$box_icon','$box_title','$box_desc')";

	$run_box=mysqli_query($con,$insert_box);

	if ($run_box) {
		echo "<script>alert('New box has been Inserted successfully')</script>";
		echo "<script>window.open('index.php?view_box','_self')</script>";
	}


}


  ?>


<?php } ?>
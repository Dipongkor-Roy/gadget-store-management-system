<?php
session_start();
include("../includes/db.php");

if (!isset($_SESSION['admin_email'])){
// ../admin_area/
  echo "<script>window.open('login.php','_self')</script>";
  }else{
?>

<?php
$admin_session=$_SESSION['admin_email'];
$get_admin="select * from admins where admin_email='$admin_session'";
$run_admin=mysqli_query($con,$get_admin);
$row_admin=mysqli_fetch_array($run_admin);
$admin_id=$row_admin['admin_id'];
$admin_name=$row_admin['admin_name'];
$admin_email=$row_admin['admin_email'];
$admin_image=$row_admin['admin_image'];
$admin_country=$row_admin['admin_country'];
$admin_job=$row_admin['admin_job'];
$admin_contact=$row_admin['admin_contact'];
$admin_about=$row_admin['admin_about'];


$get_pro="select * from products";
$run_pro=mysqli_query($con,$get_pro);
$count_pro=mysqli_num_rows($run_pro);

$get_cust="select * from customers";
$run_cust=mysqli_query($con,$get_cust);
$count_cust=mysqli_num_rows($run_cust);

$get_p_cat="select * from product_category";
$run_p_cat=mysqli_query($con,$get_p_cat);
$count_p_cat=mysqli_num_rows($run_p_cat);

$get_p_cat="select * from customer_order";
$run_order=mysqli_query($con,$get_p_cat);
$count_order=mysqli_num_rows($run_p_cat);
  ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>

<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- owl carousel css file cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
  <body>

    <div class="wrapper">
      <?php include '../includes/sidebar.php'; ?>
      <div class="page-wrapper">
        <div class="container-fluid">
        <?php
        //dashboard
     //      if(isset($_GET['dashboard'])) {     
     //      include 'dashboard.php';
     // }
          if(isset($_GET['dashboard'])) {     
          include 'dashboard.php';
     }
    

     //      if(isset($_GET['insert_product'])) {     
     //      include 'insert_product.php';
     // }
          if(isset($_GET['insert_product'])) {     
          include 'insert_product.php';
     }
         if(isset($_GET['view_product'])) {     
          include 'view_product.php';
     }
     //     if(isset($_GET['delete_product'])) {     
     //      include 'delete_product.php';
     // }
         if(isset($_GET['delete_product'])) {     
          include '../admin_area/controller/ProductController.php';
     }
          if(isset($_GET['edit_product'])) {     
          include 'edit_product.php';
     }
     //      if(isset($_GET['insert_product_cat'])) {     
     //      include 'insert_p_cat.php';
     // }
          if(isset($_GET['insert_product_cat'])) {     
          include 'insert_p_cat.php';
     }
          if(isset($_GET['view_product_cat'])) {     
          include 'view_p_cat.php';
     }
          if(isset($_GET['view_product_ajax'])) {     
          include 'view_products_ajax.php';
     }
     //     if(isset($_GET['delete_p_cat'])) {     
     //      include 'delete_p_cat.php';
         if(isset($_GET['delete_p_cat'])) {     
          include '../admin_area/controller/ProductController.php';
     }
     //    if(isset($_GET['edit_p_cat'])) {     
     //      include 'edit_p_cat.php';
     // }
        if(isset($_GET['edit_p_cat'])) {     
          include 'edit_p_cat.php';
     }
     //   if(isset($_GET['insert_categories'])) {     
     //      include 'insert_cat.php';
     // }
       if(isset($_GET['insert_categories'])) {     
          include 'insert_cat.php';
     }
        if(isset($_GET['view_categories'])) {     
          include 'view_cat.php';
     }
     //    if(isset($_GET['delete_cat'])) {     
     //      include 'delete_cat.php';
     // }
        if(isset($_GET['delete_cat'])) {     
          include '../admin_area/controller/CategoryController.php';
     }
     //    if(isset($_GET['edit_cat'])) {     
     //      include 'edit_cat.php';
     // }
        if(isset($_GET['edit_cat'])) {     
          include 'edit_cat.php';
     }
     //    if(isset($_GET['insert_slider'])) {     
     //      include 'insert_slider.php';
     // }
        if(isset($_GET['insert_slider'])) {     
          include 'insert_slider.php';
     }
         if(isset($_GET['view_slider'])) {     
          include 'view_slider.php';
     }
     //    if(isset($_GET['delete_slide'])) {     
     //      include 'delete_slider.php';
     // }
        if(isset($_GET['delete_slide'])) {     
          include '../admin_area/controller/SliderController.php';
     }
     //    if(isset($_GET['edit_slide'])) {     
     //      include 'edit_slider.php';
     // }
        if(isset($_GET['edit_slide'])) {     
          include 'edit_slider.php';
     }
       if(isset($_GET['view_customer'])) {     
          include 'view_customer.php';
     }
     //customer delete
     //   if(isset($_GET['customer_delete'])) {     
     //      include 'customer_delete.php';
     // }
       if(isset($_GET['customer_delete'])) {     
          include '../admin_area/controller/CustomerController.php';
     }
        if(isset($_GET['view_order'])) {     
          include 'view_order.php';
     }
     //   if(isset($_GET['order_delete'])) {     
     //      include 'order_delete.php';
     // }
       if(isset($_GET['order_delete'])) {     
          include '../admin_area/controller/OrderController.php';
     }
       if(isset($_GET['view_payments'])) {     
          include 'view_payments.php';
     }
     //  if(isset($_GET['payment_delete'])) {     
     //      include 'payment_delete.php';
     // }
      if(isset($_GET['payment_delete'])) {     
          include '../admin_area/controller/PaymentController.php';
     }
     //  if(isset($_GET['insert_user'])) {     
     //      include 'insert_user.php';
     // }
      if(isset($_GET['insert_user'])) {     
          include 'insert_user.php';
     }
      if(isset($_GET['view_user'])) {     
          include 'view_user.php';
     }
     //  if(isset($_GET['user_delete'])) {     
     //      include 'user_delete.php';
     // }
      if(isset($_GET['user_delete'])) {     
          include '../admin_area/controller/UserController.php';
     }
      if(isset($_GET['user_profile'])) {     
          include 'user_profile.php';
     }
     //  if(isset($_GET['insert_box'])) {     
     //      include 'insert_box.php';
     // }
      if(isset($_GET['insert_box'])) {     
          include 'insert_box.php';
     }
       if(isset($_GET['view_box'])) {     
          include 'view_box.php';
     }
      if(isset($_GET['delete_box'])) {     
          include '../admin_area/controller/BoxController.php';
     }
     if(isset($_GET['edit_box'])) {     
          include 'edit_box.php';
     }







      
       
         ?>  
        </div>
      </div>
    </div>
    







    <!-- jquery cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<!-- owl carousel js file cdn link  -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- custom js file link  -->
<script src="../js/main.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>  
<script>
var slideIndex = 1;
showSlides(slideIndex);

function plusSlides(n) {
  showSlides(slideIndex += n);
}

function currentSlide(n) {
  showSlides(slideIndex = n);
}

function showSlides(n) {
  var i;
  var slides = document.getElementsByClassName("mySlides");
  var dots = document.getElementsByClassName("dot");
  if (n > slides.length) {slideIndex = 1}    
  if (n < 1) {slideIndex = slides.length}
  for (i = 0; i < slides.length; i++) {
      slides[i].style.display = "none";  
  }
  for (i = 0; i < dots.length; i++) {
      dots[i].className = dots[i].className.replace(" active", "");
  }
  slides[slideIndex-1].style.display = "block";  
  dots[slideIndex-1].className += " active";
}
</script>
  </body>
 
</head>
</html>

<?php  } ?>



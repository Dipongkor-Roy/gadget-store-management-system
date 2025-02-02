<?php
// Assuming you are getting p_cat_id from the URL
$p_cat_id = isset($_GET['cat_id']) ? $_GET['cat_id'] : 0; // Default to 0 if no category is selected
include_once '../models/db.php'; // Include the DB class

// Create an instance of the db class
$db = new db();
?>
<div class="panel panel-default sidebar-menu">
	<div class="panel-heading">
		<h3 class="panel-title">CATEGORIES</h3>
	</div>
	<div class="panel-body">
		<ul class="nav nav-pills nav-stacked category-menu">
			<?php $db->getCat(); // Call the getCat() method from the db class 
			?>
		</ul>
	</div>
</div>

<div class="panel panel-default sidebar-menu">
	<div class="panel-heading">
		<h3 class="panel-title">PRODUCT CATEGORIES</h3>
	</div>
	<div class="panel-body">
		<ul class="nav nav-pills nav-stacked category-menu">
			<?php $db->getProductCategory($p_cat_id); // Call the getProductCategory() method from the db class 
			?>
		</ul>
	</div>
</div>
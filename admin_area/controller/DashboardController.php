<?php
$i = 0;
$get_order = "select * from customer_order order by 1 DESC LIMIT 0,5";
$run_order = mysqli_query($con, $get_order);
while ($row_order = mysqli_fetch_array($run_order)) {
	$order_id = $row_order['order_id'];
	$customer_id = $row_order['customer_id'];
	$product_id = $row_order['product_id'];
	$invoice_no = $row_order['invoice_no'];
	$qty = $row_order['qty'];
	$size = $row_order['size'];
	$status = $row_order['order_status'];

	$i++;


?>
	<tr>
		<td><?php echo $i ?></td>
		<td>
			<?php
			$get_cust = "select * from customers where customer_id='$customer_id'";
			$run_cust = mysqli_query($con, $get_cust);
			$row_customer = mysqli_fetch_array($run_cust);
			$customer_email = $row_customer['customer_email'];
			echo $customer_email;
			?>

		</td>
		<td><?php echo $invoice_no; ?></td>
		<td><?php echo $product_id; ?></td>
		<td><?php echo $qty; ?></td>
		<td><?php echo $size; ?></td>
		<td><?php echo $status ?></td>

	</tr>
<?php } ?>
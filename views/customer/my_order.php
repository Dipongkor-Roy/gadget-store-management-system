<?php

require_once realpath(__DIR__ . '/../../controllers/OrderController.php');
require_once realpath(__DIR__ . '/../../controllers/CartController.php');



$cartController = new CartController();

$totalItems = $cartController->getTotalItems(); // Fetch total items
$totalPrice = $cartController->getTotalPrice(); // Fetch total price
$cartProducts = $cartController->getCartProducts(); // Fetch all cart products


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gadget store</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <!-- owl carousel css file cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="../css/style.css">
    <style>


    </style>

</head>



<body>


    <div class="trx">
        <center>
            <h1>My Order</h1>
            <p>Shipping and additional costs are calculated based on the values you have entered</p>
        </center>
        <hr>
        <div class="tae-responve">
            <table class="tab">
                <thead>
                    <tr>
                        <th>Sr.No</th>
                        <th>Due Amount</th>
                        <th>Invoice Number</th>
                        <th>Quantity</th>
                        <th>Size</th>
                        <th>Order Date</th>
                        <th>Paid/Unpaid</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($orders)) { ?>
                        <?php foreach ($orders as $order) { ?>
                            <tr>
                                <td><?php echo htmlspecialchars($order['order_id']); ?></td>
                                <td><?php echo htmlspecialchars($order['due_amount']); ?></td>
                                <td><?php echo htmlspecialchars($order['invoice_no']); ?></td>
                                <td><?php echo htmlspecialchars($order['qty']); ?></td>
                                <td><?php echo htmlspecialchars($order['size']); ?></td>
                                <td><?php echo htmlspecialchars($order['order_date']); ?></td>
                                <td><?php echo $order['order_status'] === 'pending' ? 'Unpaid' : 'Paid'; ?></td>
                                <td><a href="confirm.php?order_id=<?php echo htmlspecialchars($order['order_id']); ?>" target="_blank" class="btn btn-primary btn-sm">Confirm Now</a></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td colspan="8" class="text-center">No orders found.</td>
                        </tr>
                    <?php } ?>

                </tbody>
            </table>
        </div>
    </div>
</body>
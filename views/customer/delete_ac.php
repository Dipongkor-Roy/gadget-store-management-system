<?php
if (!isset($_SESSION['customer_email'])) {
    echo "<script>window.open('../checkout.php', '_self');</script>";
    exit;
}
?>


<div class="rx">
    <center>
        <h1>Do you really want to delete your account</h1>

        <form action="../../controllers/delete_account.php" method="post">
            <input type="submit" name="yes" value="Yes, I want to delete" class="btn btn-default">
            <input type="submit" name="no" value="No, I don't want" class="btn btn-primary">
        </form>
    </center>
</div>
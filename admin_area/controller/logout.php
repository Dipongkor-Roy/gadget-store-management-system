<?php
session_start();
session_destroy();
echo "<script>window.open('../views/login.php','_self')</script>";

  ?>
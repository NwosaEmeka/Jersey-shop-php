<?php
session_start();
unset($_SESSION['currentUser']);
//unset the shopping cart as well
unset($_SESSION['cart']);
header("Location: index.php");
?>
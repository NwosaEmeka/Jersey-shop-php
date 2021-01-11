<?php
include_once "../config/pdo.php";
session_start();
unset($_SESSION['currentAdmin']);
header("Location: index.php");
?>
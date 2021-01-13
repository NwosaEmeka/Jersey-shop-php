<?php
session_start();
include_once "../config/pdo.php";

$admin = isset($_SESSION['currentAdmin']) ? $_SESSION['currentAdmin'] : "";
if (empty($admin)) {
  // the admin is not logged in so cannot access this page
  header("Location: index.php");
  return;
} else {
  //delete from orders
  if (isset($_GET['id'])) {
      $sql = "DELETE FROM orders WHERE order_id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(':id' => $_GET['id']));
      header("Location: manage_orders.php");
  }
}
?>
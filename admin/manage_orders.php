<?php
session_start();
include_once "../config/pdo.php";

// Fetch all products from db
$stmt = $pdo->prepare("SELECT * FROM orders");
$stmt->execute();

$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
$stmt = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <!-- font awesome cdn-->
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.1/css/all.css"
    integrity="sha384-vp86vTRFVJgpjF9jiIGPEEqYqlDwgyBgEF109VFjmqGmIY/Y4HV4d3Gp2irVfcrp" crossorigin="anonymous">
  <!-- end of font awsome cdn -->
  <link rel="stylesheet" href="style.css">
  <title>Orders | Manage orders</title>
</head>

<body>
  <?php
  include_once "header.php";
  ?>
  <!-- navbar ends -->
  <div class="container">
    <h1 class="header__text">ALL ORDERS</h1>
    <div class="add__btn">
      <a href="products.php" class="btn">Manage Products</a>
    </div>

    <div class="table__wrapper">
      <table class="table">
        <thead>
          <tr>
            <td>Order Id</td>
            <td>Customer Id</td>
            <td>Order Date</td>
            <td>Status Id</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($orders as $order){
          ?>
          <tr>
            <td><?= $order['order_id'] ?></td>
            <td><?= $order['customer_id'] ?></td>
            <td><?= $order['order_date'] ?></td>
            <td><?= $order['status_id'] ?></td>
            <td>
              <a href="edit_order.php?id=<?= $order['order_id'] ?>" class="act act__ed">
                <i class="far fa-edit"></i>
              </a>
              <a href="delete_order.php?id=<?= $order['order_id'] ?>"
                onclick="return confirm('Are you sure you want to delete this order?')" class="act act__del">
                <i class="far fa-trash-alt"></i>
              </a>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  </div>

</body>


</html>
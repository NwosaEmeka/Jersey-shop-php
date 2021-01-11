<?php
session_start();
include_once "./config/pdo.php";

$user = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : "";
if (empty($user)) {
  header("Location: index.php");
}

$c_id = $user['userId'];

$sql = "SELECT o.order_id AS 'id', o.order_date AS 'date', p.product_name AS 'name', p.product_img as 'img', i.quantity AS qty, i.unit_price AS 'price', i.sub_total AS 'subT', s.status_desc AS 'status' FROM orders o
LEFT JOIN status s ON (o.status_id=s.status_id)
LEFT JOIN orderitem i ON (o.order_id=i.order_id) 
LEFT JOIN products p ON (i.product_id = p.product_id)
WHERE customer_id = :c_id";

$stmt = $pdo->prepare($sql);
$stmt->execute(array(
  ':c_id' => $c_id
));

$orders = [];
while ($row = $stmt->fetch()) {
  $order = $row["id"];
  $orders[$order][] = $row;
}
$stmt = null;
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EMS JERSEY | Orders</title>

  <?php
  include_once "header.php"
  ?>
  <h3 class="section__header">My Orders</h3>


  <div class="orders">
    <?php foreach ($orders as $order) { ?>
    <div class="order">
      <table class="item">
        <thead>
          <tr>
            <th>Item</th>
            <th>Qty</th>
            <th>Price(RM)</th>
            <th>Total(RM)</th>
          </tr>
        </thead>
        <?php
          foreach ($order as $item) {
            $orderDate = $item['date'];
            $id = $item['id'];
            $status = $item['status'];
          ?>
        <tbody>
          <tr>
            <td class="item__name"><?php echo $item['name']; ?></td>
            <td class="item__qty"><?php echo $item['qty']; ?></td>
            <td class="item__price"><?php echo $item['price']; ?></td>
            <td class="item__subT"><?php echo $item['subT']; ?></td>
          </tr>
        </tbody>
        <?php  }
          ?>
      </table>
      <p class="order__id">Order Id: <?php echo $id; ?> </p>
      <p class="order__date">Placed On: <?php echo $orderDate; ?></p>
      <p class="status">Status: <?php echo $status; ?></p>
    </div>


    <?php } ?>
  </div>

  </body>

</html>
<?php
session_start();
include_once "./config/pdo.php";

$user = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : "";
if (empty($user)) {
  header("Location: index.php");
}

$cartItem = isset($_SESSION['cart'])? $_SESSION['cart'] : array();

if(!empty($cartItem)){

  $c_id = $user['userId'];
  // create order
  $order_sql = "INSERT INTO orders(customer_id, status_id) VALUES ( :c_id, :status_id)";
  $order_stmt = $pdo->prepare($order_sql);
  $order_stmt->execute(array(
    ':c_id' => $c_id,
    ':status_id' => 1
  ));
  $o_id = $pdo->lastInsertId(); //last inserted order id

  //then insert all orderitem to the order one by one
  foreach($cartItem as  $item){
    $pid = $item['id'];
    $qty = $item['quantity'];
    $uprice = $item['price'];
    $sub_t = $item['price'] * $item['quantity'];

    $sql = "INSERT INTO orderitem(order_id, product_id, quantity, unit_price, sub_total) VALUES (:o_id, :pid, :qty, :uprice, :sub_t)";
    $stmt = $pdo->prepare($sql);

    $stmt->execute(array(
      ':o_id' => $o_id,
      ':pid' => $pid,
      ':qty' => $qty,
      ':uprice' => $uprice,
      ':sub_t' => $sub_t
    ));
  }
  //empty the cart session
  unset($_SESSION['cart']);
  header("Location: orders.php");
  return;
}

?>
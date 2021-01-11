<?php
session_start();
include_once "./config/pdo.php";


$user = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : "";
if (empty($user)) {
  header("Location: index.php");
}else{

  
  //decrease item quantity
  if(isset($_POST['decrement'])){

    foreach($_SESSION['cart'] as $key=> &$cartitem){
      if($_POST['id'] === $cartitem['id']){
        //if item quantity is 0, delete from cart
        if ($cartitem['quantity'] > 1) {
          $cartitem['quantity'] -= 1;
        }else{
          unset($_SESSION['cart'][$key]);
        }
      }
    }
  }

  // increase item quantity
  if (isset($_POST['increment'])) {
    foreach($_SESSION['cart'] as $key=> &$cartitem){
      if ($_POST['id'] === $cartitem['id']) {
        //increase the queatity if item still in stock
        if ($cartitem['quantity'] < $cartitem['item_instock']) {
          $cartitem['quantity'] += 1;
        } else {
          echo '<script>alert("Item is out of stock")</script>';
        }
      }
    }
  }

  //delete item from cart
  if (isset($_POST['delete'])) {
    foreach ($_SESSION['cart'] as $key => &$cartitem) {
      if ($_POST['id'] === $cartitem['id']) {
        unset($_SESSION['cart'][$key]);
      }
    }
  }
  header("Location: cart.php");
  return;

}
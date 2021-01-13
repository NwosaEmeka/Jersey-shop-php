<?php
session_start();
include_once "./config/pdo.php";


$user = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : "";
if (empty($user)) {
  header("Location: login.php");
}else{

  if(isset($_POST['add'])){

    // create a product array to add to the cart
    $item = array(
      'id'=> $_POST['id'],
      'name'=> $_POST['name'],
      'image' => $_POST['image'],
      'price' => $_POST['price'],
      'quantity' => 1,
      'item_instock' => $_POST['instock']
    );

    $inCart = false;

    //initialize cart session to empty array
    if(!isset($_SESSION['cart'])){
      $_SESSION['cart'] = array();
    }
    
    

    // check if item in cart already
    foreach($_SESSION['cart'] as &$cartitem){
      if($_POST['id'] === $cartitem['id']){
        $inCart = true;

        if($cartitem['quantity'] < $cartitem['item_instock']){
          $cartitem['quantity']+=1;
        }else{
          echo '<script>alert("Welcome to Geeks for Geeks")</script>';
        }
        break;
      }
    }
    if(!$inCart){
      $_SESSION['cart'][] = $item;
    }
  }
  header("Location: index.php");
}
?>
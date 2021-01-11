<?php
session_start();
include_once "./config/pdo.php";

$user = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : "";
if (empty($user)) {
  header("Location: login.php");
} else { ?>
<!-- display header -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EMS JERSEY | For Your Quality and Authentic Jersey</title>
  <link rel="stylesheet" href="cartStyle.css">
  <?php
    include_once "header.php";

    $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    ?>

  <!-- display shopping cart -->
  <div class="cart_wrapper">
    <p class="cart__header">Hi, You have <?php echo count(array_keys($cart)); ?> Item(s) in basket </p>
    <table class="table">
      <thead>
        <tr>
          <th>Product</th>
          <th>Quantity</th>
          <th class="unit__price-data">Unit Price</th>
          <th>Total</th>
        </tr>
      </thead>
      <tbody>
        <?php
          $sub_total = 0.00;
          $total = 0.00;
          foreach ($cart as $item) {
            $sub_total = $item['price'] * $item['quantity'];
            $total += $sub_total;
          ?>
        <tr>
          <td class="item__detail">
            <img src="./uploads/<?php echo $item['image']; ?>" alt="<?php echo $item['name']; ?>" />
            <p><?php echo $item['name']; ?></p>
          </td>
          <td class="quantity-data">
            <form action="cart_actions.php" method="POST">
              <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
              <input type="submit" value="-" name="decrement" class="count__btn">
              <span class="item__count"><?php echo $item['quantity']; ?></span>
              <input type="submit" value="+" name="increment" class="count__btn">
              <input type="submit" value="x" name="delete" class="remove__btn">
            </form>
          </td>
          <td class="unit__price-data">
            <p class="item__price"><?php echo $item['price']; ?></p>
          </td>
          <td class="total__price-data">
            <p class="item__price"><?php echo number_format($sub_total, 2); ?></p>
          </td>
        </tr>
        <?php }
          ?>
      </tbody>
    </table>
    <div>
      <div class="final_price">
        <p>Total: </p>
        <p><?php echo number_format($total, 2); ?></p>
      </div>
      <div class="ctc__btn">
        <a href="index.php" class="ctc btn_pry">Continue Shoppping</a>
        <?php if(!empty($cart)){?>
        <div>
          <a href="address.php" class="ctc btn__login">SECURE CHECKOUT</a>
        </div>
        <?php } 
        else{ ?>
        <div></div>
        <?php } ?>

      </div>
    </div>
  </div>


  </body>

</html>




<?php }

?>
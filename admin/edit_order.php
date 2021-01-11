<?php
session_start();
include_once "../config/pdo.php";

//extract the order info as placeholder for
  if (isset($_GET['id']) && !isset($_GET['update'])) {
    // fetch the product
    $sql = "SELECT * FROM orders WHERE order_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':id' => $_GET['id']
    ));
    $order = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  $order_id = $_GET['id'];

  //update the order
  if(isset($_POST['update'])){
    $status_id = isset($_POST['status'])? $_POST['status'] : "";
    if($status_id == "" || $status_id <= 0 || $status_id >5){
      $_SESSION['order_edit_err'] = "Please fill the edit status 1 - 5";
    }else{
      $sql1 = "UPDATE orders SET status_id=:status_id WHERE order_id=:order_id";
      $stmt1 = $pdo->prepare($sql1);
      $stmt1->execute(array(
        ':status_id'=> $status_id,
        ':order_id' => $order_id
      ));

      $stmt1 = null;
      header("Location: manage_orders.php");
    }
  }
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Edit Product | Admin</title>
</head>

<body>
  <?php
  include_once "header.php";
  ?>
  <div class="container">
    <a href="manage_orders.php" class="bck_btn">Back</a>
    <h1 class="header__text">UPDATE ORDER</h1>

    <div class="form__wrapper-product">
      <form method="POST" class="form_product">
        <?php
        $errmsg = isset($_SESSION['order_edit_err']) ? $_SESSION['order_edit_err'] : "";
        if (!empty($errmsg)) {
          echo ("<span class='errMsg'> $errmsg </span>");
          unset($_SESSION['order_edit_err']);
        }
        ?>
        <div class="input__wrapper">
          <div class="left__input">
            <div class="product_input">
              <label for="product_name">Order Id:</label>
              <input type="text" name="product_name" class="form_input" readonly
                value="<?php echo htmlspecialchars($order['order_id']); ?>">
            </div>
            <div class="product_input">
              <label for="customer_id">Customer Id:</label>
              <input type="text" name="customer_id" class="form_input" readonly
                value="<?php echo htmlspecialchars($order['customer_id']); ?>">
            </div>

            <div class="product_input">
              <label for="order_date">Order Date:</label>
              <input type="text" name="order_date" class="form_input"
                value="<?php echo htmlspecialchars($order['order_date']); ?>" readonly>
            </div>
          </div>
          <div class="right__input">
            <div class="product_input">
              <label for="status">Status Id:</label>
              <input type="number" name="status" class="form_input"
                value="<?php echo htmlspecialchars($order['status_id']); ?>">
            </div>

            <input type="submit" value="Update" name="update" class="btn btn__login">
          </div>
      </form>
    </div>
  </div>
</body>

</html>
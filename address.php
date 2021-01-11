<?php
session_start();
include_once "./config/pdo.php";

$user = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : "";
if (empty($user)) {
  header("Location: index.php");
}
  $user = isset($_SESSION['currentUser']) ? $_SESSION['currentUser'] : "";
  $c_id = $user['userId'];

  // //check if the user already have registered delivery address
  $sql1 = "SELECT * FROM address WHERE customer_id = :id";
  $stmt1 =$pdo->prepare($sql1);
  $stmt1->execute(array(
    ':id'=> $c_id
  ));

  $address = $stmt1->fetch(PDO::FETCH_ASSOC);
  if(!empty($address)){
  header('Location: checkout.php');
  return;
  }
  
  if (isset($_POST['register'])) {
    $credentials = array('addr1', 'city', 'state', 'zip', 'phone_no');
    foreach ($credentials as $credential) {
      if (empty($_POST[$credential])) {
        $_SESSION['add_err'] = "Please complete all fileds";
        header("Location: address.php");
        return;
      } 
    }
    
      $sql = "INSERT INTO address (customer_id, address1, address2, city, state, zip, phone_no) VALUES (:c_id, :addr1, :addr2, :city, :state, :zip, :phone_no)";

      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':c_id' => $c_id,
        ':addr1' => $_POST['addr1'],
        ':addr2' => $_POST['addr2'],
        ':city' => $_POST['city'],
        ':state' => $_POST['state'],
        ':zip' => $_POST['zip'],
        ':phone_no' => $_POST['phone_no']
      ));

      $stmt = null;
      header('Location: checkout.php');
      
  } ?>

<!-- html goes here -->
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EMS JERSEY | For Your Quality and Authentic Jersey</title>

  <?php
    include_once "header.php"
    ?>

  <div class="form__container">
    <h3 class="section__header">Delivery Address</h3>
    <div class="form__wrapper-login">

      <form method="POST" class="form__login">
        <?php
          $errmsg = isset($_SESSION['add_err']) ? $_SESSION['add_err'] : "";
          if (!empty($errmsg)) {
            echo ("<span class='errMsg'> $errmsg </span>");
            unset($_SESSION['add_err']);
          }
          ?>
        <div class="form__element">
          <label for="addr1">Address1: </label>
          <input type="text" name="addr1" id="addr1" class="form_input">
        </div>
        <div class="form__element">
          <label for="addr2">Address2: </label>
          <input type="text" name="addr2" id="addr2" class="form_input">
        </div>
        <div class="form__element">
          <label for="city">City: </label>
          <input type="text" name="city" id="city" class="form_input">
        </div>
        <div class="form__element">
          <label for="state">State: </label>
          <input type="text" name="state" id="state" class="form_input">
        </div>
        <div class="form__element">
          <label for="zip">Zip: </label>
          <input type="text" name="zip" id="zip" class="form_input">
        </div>
        <div class="form__element">
          <label for="phone_no">Phone No: </label>
          <input type="text" name="phone_no" id="phone_no" class="form_input">
        </div>
        <div class="btn__group">
          <a href="cart.php" class="btn btn_pry">Back</a>
          <input type="submit" value="Checkout" name="register" class="btn btn__login">
        </div>
      </form>
    </div>
  </div>
  </body>

</html>
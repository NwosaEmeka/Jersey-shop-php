<?php
session_start();
include_once "../config/pdo.php";
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
  <!-- navbar -->
  <?php
  include_once "header.php";
  if (isset($_GET['id'])) {
    // fetch the product
    $sql = "SELECT * FROM products WHERE product_id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':id' => $_GET['id']
    ));
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
  }
  ?>
  <!-- navbar ends -->
  <div class="container">
    <a href="products.php" class="bck_btn">Back</a>
    <h1 class="header__text">UPDATE PRODUCT</h1>

    <div class="form__wrapper-product">
      <form method="POST" class="form_product" enctype="multipart/form-data"
        action="edit_action.php?id=<?= $product['product_id'] ?>">
        <?php
        $errmsg = isset($_SESSION['prod_add_err']) ? $_SESSION['prod_add_err'] : "";
        if (!empty($errmsg)) {
          echo ("<span class='errMsg'> $errmsg </span>");
          unset($_SESSION['prod_add_err']);
        }
        ?>
        <div class="input__wrapper">
          <div class="left__input">
            <div class="product_input">
              <label for="product_name">Product Name:</label>
              <input type="text" name="product_name" class="form_input"
                value="<?php echo htmlspecialchars($product['product_name']); ?>">
            </div>
            <div class="product_input">
              <label for="club">Club Name:</label>
              <input type="text" name="club" class="form_input"
                value="<?php echo htmlspecialchars($product['club']); ?>">
            </div>

            <div class="product_input">
              <label for="image">Product Image:</label>
              <input type="file" name="image" class="form_input"
                value="<?php echo htmlspecialchars($product['product_img']); ?>">
            </div>
          </div>
          <div class="right__input">
            <div class="product_input">
              <label for="price">Price (RM):</label>
              <input type="text" name="price" class="form_input"
                value="<?php echo htmlspecialchars($product['price']); ?>">
            </div>

            <div class="product_input">
              <label for="quantity">Quantity:</label>
              <input type="number" name="quantity" class="form_input"
                value="<?php echo htmlspecialchars($product['quantity']); ?>">
            </div>
            <div class="product_input">
              <label for="brand">Brand:</label>
              <input type="text" name="brand" class="form_input"
                value="<?php echo htmlspecialchars($product['brand']); ?>">
            </div>
          </div>
        </div>
        <div class="product_input">
          <label for="product_desc">Product Description</label>
          <textarea name="product_desc"
            class="text_area"><?php echo htmlspecialchars($product['product_desc']); ?></textarea>
        </div>
        <input type="submit" value="Update" name="update" class="btn btn__login">
      </form>
    </div>
  </div>
</body>

</html>
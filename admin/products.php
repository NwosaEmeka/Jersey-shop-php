<?php
session_start();
include_once "../config/pdo.php";

// Fetch all products from db
$stmt = $pdo->prepare("SELECT * FROM products");
$stmt->execute();

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
  <title>Products | Admin</title>
</head>

<body>
  <!-- navbar -->
  <?php
  include_once "header.php";
  ?>
  <!-- navbar ends -->
  <div class="container">
    <h1 class="header__text">ALL PRODUCTS</h1>
    <div class="add__btn">
      <a href="add_product.php" class="btn">Add new Product</a>
      <a href="manage_orders.php" class="btn">Manage Orders</a>
    </div>

    <div class="table__wrapper">
      <table class="table">
        <thead>
          <tr>
            <td>ID</td>
            <td>Name</td>
            <td>Description</td>
            <td>Image</td>
            <td>Price (RM)</td>
            <td>Club</td>
            <td>Brand</td>
            <td>Quantity</td>
            <td>Action</td>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($products as $product){
            $imgurl = '../uploads/' . $product["product_img"];
          ?>
          <tr>
            <td><?= $product['product_id'] ?></td>
            <td><?= $product['product_name'] ?></td>
            <td><?= $product['product_desc'] ?></td>
            <td class="p__image">
              <img src="<?= $imgurl ?>" alt="<?= $product['product_name'] ?>">
            </td>
            <td><?= $product['price'] ?></td>
            <td><?= $product['club'] ?></td>
            <td><?= $product['brand'] ?></td>
            <td>
              <?= $product['quantity'] ?>
            </td>
            <td>
              <a href="edit_product.php?id=<?= $product['product_id'] ?>" class="act act__ed">
                <i class="far fa-edit"></i>
              </a>
              <a href="delete_product.php?id=<?= $product['product_id'] ?>"
                onclick="return confirm('Are you sure you want to delete this product?')" class="act act__del">
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
<?php
session_start();
include_once "../config/pdo.php";

  $vars = array('product_name', 'club', 'price', 'quantity', 'brand', 'product_desc');
  $error = false;
  $admin = isset($_SESSION['currentAdmin']) ? $_SESSION['currentAdmin'] : "";
  foreach ($vars as $var) {
    if (empty(trim($_POST[$var]))) {
      $error = true;
    }
  }
  if ($error) {
    $_SESSION['prod_add_err'] = "Please fill all fields";
    header("Location: edit_product.php");
    return;
  } else {
    //first convert the price to float
    $d_price = floatval($_POST['price']);
    //Second handle the image
    $targetDir = '../uploads/';
    $filename = basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . $filename;
    $filetype = pathinfo($targetFilePath,PATHINFO_EXTENSION);
    $temp_name = $_FILES["image"]["tmp_name"];
    $allowedFiles = array('jpg', 'png', 'jpeg','svg');

    //check if the file type is supported
        if(in_array($filetype, $allowedFiles)){
          if(move_uploaded_file($temp_name, $targetFilePath)){
            $sql = "UPDATE products SET product_name=:product_name,product_desc=:product_desc,product_img=:image,price=:price,club=:club,brand=:brand,quantity=:quantity, admin_id=:admin_id WHERE product_id = :id";

            $stmt = $pdo->prepare($sql);
            $stmt ->execute(array(
              ':product_name' => $_POST['product_name'],
              ':product_desc' => $_POST['product_desc'],
              ':image' => $filename,
              ':price' => $d_price,
              ':club' => $_POST['club'],
              ':brand' => $_POST['brand'],
              ':quantity' => $_POST['quantity'],
              ':admin_id' => $admin['admin_id'],
              ':id' => $_GET['id']
            ));
            $stmt = null;
            header("Location: products.php");
          }
        }else{
            $_SESSION['prod_add_err'] = "Your file type is not supported";
            header("Location: edit_product.php");
            return;
        }
    }
    ?>
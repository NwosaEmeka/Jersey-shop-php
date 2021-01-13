<?php
session_start();
include_once "../config/pdo.php";

//Delete product and return to products.php
  $admin = isset($_SESSION['currentAdmin']) ? $_SESSION['currentAdmin'] : "";
  if (empty($admin)) {
    // the admin is not logged in so cannot access this page
    header("Location: index.php");
    return;
  }else{
  //delete image from folder first then delete the product from databse
  //delete image from folder using unlink
  if (isset($_GET['id'])) {
    //DEETE IMAGE FROM FOLDER
    $sql1 = "SELECT * FROM products WHERE product_id = :id";
    $stmt1 = $pdo->prepare($sql1);
    $stmt1->execute(array(':id' => $_GET['id']));
    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
    $filePath = '../uploads/'.$row['product_img'];
    

    if(file_exists($filePath)){
      unlink($filePath);
      //DELETE THE PRODUCT
      $sql = "DELETE FROM products WHERE product_id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(':id' => $_GET['id']));
      header("Location: products.php");
    }
    else{
      //DELETE THE PRODUCT
      $sql = "DELETE FROM products WHERE product_id = :id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(':id' => $_GET['id']));
      header("Location: products.php");
    }
  }
}
?>
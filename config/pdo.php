<?php 
try{

  $pdo = new PDO("mysql:host=localhost;port=3307;dbname=myshop",'root', '');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
}catch(PDOException $e){
  echo "Connection failed ". $e->getMessage();
}

?>
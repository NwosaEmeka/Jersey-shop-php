<?php 
include_once "./config/pdo.php";

$sql = "SELECT * FROM products";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($products, JSON_FORCE_OBJECT);
$stmt = null;
?>
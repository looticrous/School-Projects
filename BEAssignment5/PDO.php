<?php
$pdo_options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];
try {
  $pdo = new PDO("mysql:host=localhost;dbname=bnbs;charset=utf8mb4", "username", "password", $pdo_options);
} catch (PDOException $e) {
echo $e->getMessage();
}



?>

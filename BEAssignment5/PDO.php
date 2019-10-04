<?php
$pdo_options = [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
];
try {
  $pdo = new PDO("mysql:host=localhost;dbname=bnbs;charset=utf8mb4", "bnb_admin", "Th3P@ssw0rd1sN0tS3cure!!", $pdo_options);
} catch (PDOException $e) {
echo $e->getMessage();
}



?>

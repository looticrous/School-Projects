<?php
include "class.php";
  $db = new database();
  $customer = new customer($db);
  $customer->read("username", "test@test.com");
  $customer->password = "lol";
  $customer->update("username", $customer->username); 
  echo "<pre>";
  echo "</pre>";
 ?>

<?php
session_start(); 
include "class.php";
if (isset($_POST["signup"])) {
  parse_str(urldecode($_POST["signup"]), $data);
  $db = new database();
  $customer = new customer($db);
  $customer->username = $data["email_address"];
  $customer->primary_address = $data["address"];
  $customer->city = $data["city"];
  $customer->state = $data["state"];
  $customer->first_name = $data["first_name"];
  $customer->last_name = $data["last_name"];
  $customer->password = $data["password"];
  $customer->zip_code = $data["zip_code"];
  $customer->phone_number = $data["phone_number"];
  try {
    $customer->create();
    $_SESSION["user"] = $customer->username;
    print json_encode(array(
      "username" => $customer->username,
      "first_name" => $customer->first_name,
      "last_name" => $customer->last_name,
      "phone_number" => $customer->phone_number,
      "city" => $customer->city,
      "state" => $customer->state,
      "zip_code" => $customer->zip_code,
      "primary_address" => $customer->primary_address
    ));
  }
  catch(Exception $e) {
    echo "Unable to create account. The username may already be in use.";
  }


}


 ?>

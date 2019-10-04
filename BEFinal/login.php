<?php
session_start();
  include "class.php";
  if (isset($_POST["login"])) {
    parse_str(urldecode($_POST["login"]), $data);
    $db = new database();
    $customer = new customer($db);
    $attempted_username = $data["email_address"];
    $attempted_password = $data["password"];
    $customer->read("username", $attempted_username);
    if (password_verify($attempted_password, $customer->password)) {
      $_SESSION["user"] = $customer->username; 
      echo json_encode(array(
        "username" => $customer->username,
        "first_name" => $customer->first_name,
        "last_name" => $customer->last_name,
        "phone_number" => $customer->phone_number,
        "primary_address" => $customer->primary_address,
        "city" => $customer->city,
        "state" => $customer->state,
        "zip_code" => $customer->zip_code

      ));
    }
    else{
      die("Username or password is incorrect");
    }
  }
 ?>

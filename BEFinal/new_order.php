<?php
session_start();
  include "class.php";
  if (isset($_POST["new_order"])){
    parse_str(urldecode($_POST["new_order"]), $data);
    $items = $_POST["order_items"];
    $db = new database();
    if (isset($_SESSION["user"])) {
      $order = new customer_order($db);
      $order->type = $data["order_type"];
      $order->date = date("Y-m-d H:i:s");
      $order->customer = $_SESSION["user"];
      $order->create();
      $order->read($order->customer, $order->date);
      $total_price = 0;
      foreach ($items as $item) {
        $item_details = explode(" - ", $item);
        $item_price = $item_details[2];
        $menu_items = new menu_item($db);
        $menu_items->read($item_details[0], $item_details[1]);
        $order->add_to_order($menu_items->id, $order->order_number);
        $total_price += $item_price;

      }
      print json_encode(array(
        "order_details" => array(
          "Date" => $order->date,
          "items" => $items,
          "total"=> $total_price
        )
      ));

    }
    else {
      $guest = new guest($db);
      $guest->read("phone_number", $data["phone_number"]);
      if ($guest->first_name == null) {
        $guest->first_name = $data["first_name"];
        $guest->last_name = $data["last_name"];
        $guest->phone_number = $data["phone_number"];
        $guest->address = $data["address"];
        $guest->city = $data["city"];
        $guest->state = $data["state"];
        $guest->zip_code = $data["zip_code"];
        $guest->create();
      }
      $order = new guest_order($db);
      $order->type = $data["order_type"];
      $order->date = date("Y-m-d H:i:s");
      $order->guest = $data["phone_number"];
      $order->create();
      $order->read($order->date, $order->guest);
      $total_price = 0;
      foreach ($items as $item) {
        $item_details = explode(" - ", $item);
        $item_price = $item_details[2];
        $menu_items = new menu_item($db);
        $menu_items->read($item_details[0], $item_details[1]);
        $order->add_to_order($menu_items->id, $order->order_number);
        $total_price += $item_price;

      }
      print json_encode(array(
        "order_details"=> array(
          "Date" => $order->date,
          "items" => $items,
          "total" => $total_price
        )
      ));
    }


  }
 ?>

<?php
  // class definitions and implementation
  /*
    Guest Class:
      ALlows customers to place orders anonymously - to enable favorites and order tracking, the user must create an account.
    Customer Class:
      Keeps track of Customer data - Interfaces with Customer Database Table in bamboo schema / MySQL using PDO object
    Menu Item Class:
      Interface with two tables: order_items and menu_items
      Primary Table for POS items in stock. Users can read only, administrators can read, create, update and delete menu item information
    Order Class:
      Primary table which allows users to track previous orders and assign orders as favorites and read only. Administrators can create, read, update and delete order information
  */
  // Database Class is primary wrapper for PDO implementation
  class database extends PDO{
    protected $data;

    public function __construct()
    {
        $options = [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        ];
        /// Change this before uploading
        parent::__construct("geturownthings", $options);
    }
    public function run($sql, $args = NULL)
    {
        if (!$args)
        {
             return $this->query($sql);
        }
        $stmt = $this->prepare($sql);
        $stmt->execute($args);
        return $stmt;
    }

  }

  class guest {
    protected $database;
    public $all_guests;
    public $phone_number;
    public $first_name;
    public $last_name;
    public $address;
    public $city;
    public $state;
    public $zip_code;


    function __construct(database $db) {
      $this->database = $db;
    }
    function create() {
      $new_guest = array(
        $this->phone_number,
        $this->first_name,
        $this->last_name,
        $this->address,
        $this->city,
        $this->state,
        $this->zip_code
      );
      $this->database->run("INSERT INTO guests VALUES (?,?,?,?,?,?,?)", $new_guest);
    }
    function get_all_guests() {
      $this->all_guests = $this->database->select_all("guests");
    }
    function read($column, $value) {
        $data = $this->database->run("SELECT * FROM guests WHERE $column = ?", [$value])->fetch();
        $this->phone_number = $data["phone_number"];
        $this->first_name = $data["first_name"];
        $this->last_name = $data["last_name"];
        $this->address = $data["address"];
        $this->city = $data["city"];
        $this->zip_code = $data["zip_code"];
    }
    function update($clause_column, $clause_value) {
      $new_data = array(
        $this->phone_number,
        $this->first_name,
        $this->last_name,
        $this->address,
        $this->city,
        $this->state,
        $this->zip_code,
        $this->home_store,
        $clause_value
      );
      $this->database->run("UPDATE guests SET phone_number = ?, first_name = ?, last_name = ?, address = ?, city = ?, state = ?, zip_code = ? WHERE $clause_column = ?", $new_data);
    }
    function delete($column, $value) {
      $this->database->run("DELETE FROM guests WHERE $column = ?", [$value]);
    }


  }
  class customer {
      protected $database;
      public $all_customers;
      public $username; // primary key for customers table
      public $password;
      public $first_name;
      public $last_name;
      public $phone_number;
      public $primary_address;
      public $city;
      public $state;
      public $zip_code;


      function __construct($db) {
        $this->database = $db;
      }
      function create() {
        $new_customer = array (
          $this->username,
          password_hash($this->password, PASSWORD_DEFAULT), // hash password prior to db storage
          $this->first_name,
          $this->last_name,
          $this->phone_number,
          $this->primary_address,
          $this->city,
          $this->state,
          $this->zip_code
        );
          $this->database->run("INSERT INTO customers VALUES (?,?,?,?,?,?,?,?,?)", $new_customer);


      }
      function get_all_customers() {
        $this->all_customers = $this->database->run("SELECT * FROM customers")->fetchAll();
      }
      function read($column, $value) {
        if ($column == "password") {
          throw new \Exception("Cannot search for customers using this criteria", 1);
        }
        else {
          $data = $this->database->run("SELECT * FROM customers WHERE $column = ?", [$value])->fetch();
          $this->username = $data["username"];
          $this->password = $data["password"];
          $this->first_name = $data["first_name"];
          $this->last_name = $data["last_name"];
          $this->phone_number = $data["phone_number"];
          $this->primary_address = $data["primary_address"];
          $this->city = $data["city"];
          $this->state = $data["state"];
          $this->zip_code = $data["zip_code"];
        }
      }
      function update($column, $value) {
        $new_data = array(
          $this->username,
          $this->first_name,
          $this->last_name,
          $this->phone_number,
          $this->primary_address,
          $this->city,
          $this->state,
          $this->zip_code,
          $value
        );
          $this->database->run("UPDATE customers SET username = ?, first_name = ?, last_name = ?, phone_number = ?, primary_address = ?, city = ?, state = ?, zip_code = ? WHERE $column = ?", $new_data);
      }
      function reset_password($new_password, $username) {
        $this->database->run("UPDATE customers SET password = ? WHERE username = ?", [password_hash($new_password, PASSWORD_DEFAULT), $username]); 
      }
      function delete($column, $value) {
          $this->database->run("DELETE FROM customers WHERE $column = ?", [$value]);
      }

  }
  class menu_item {
     protected $database;
     public $all_items;
     public $id; // autoincrement
     public $name; // primary key for item_master table
     public $price;
     public $type; // appetizer or entree
     public $size; // small, medium or large

     function __construct($db) {
       $this->database = $db;
     }
     function create() {
      $new_menu_item = array (
        $this->name,
        $this->price,
        $this->type,
        $this->size
      );
      $this->database->run("INSERT INTO menu_items (name, price, type, size) VALUES (?,?,?,?)", $new_menu_item);
     }
     function get_all_items() {
       $this->all_items = $this->database->run("SELECT * FROM menu_items")->fetchAll();
     }
     function read($value1, $value2) {
       $data = $this->database->run("SELECT * FROM menu_items WHERE size = ? AND name = ?", [$value1, $value2])->fetch();
       $this->id = $data["item_id"];
       $this->name = $data["name"];
       $this->price = $data["price"];
       $this->size = $data["size"];
     }
     function update($column, $value) {
       $new_data = array (
         $this->id,
         $this->name,
         $this->price,
         $this->type,
         $this->size,
         $value
       );
       $this->database->run("UPDATE menu_items SET item_id = ?, name = ?, price = ?, type = ?, size = ? WHERE $column = ?", $new_data);
     }
     function delete($column, $value) {
       $this->database->run("DELETE FROM menu_items WHERE $column = ?", [$value]);
     }
  }
  class customer_order {
    protected $database;
    public $all_orders;
    public $order_number;
    public $date;
    public $type;
    public $customer;

    function __construct($db) {
      $this->database = $db;
    }
    function create() {
      $new_order = array (
        $this->date,
        $this->type,
        $this->customer
      );
      $this->database->run("INSERT INTO customer_orders (date, type, customer) VALUES (?,?,?)", $new_order);
    }
    function get_all_orders() {
      $this->all_orders = $this->database->run("SELECT * FROM customer_orders")->fetchAll();
    }
    function read($customer, $date) {
      $data = $this->database->run("SELECT * FROM customer_orders WHERE customer = ? AND date = ?", [$customer, $date])->fetch();
      $this->order_number = $data["order_number"];
      $this->date = $data["date"];
      $this->type = $data["type"];
      $this->customer = $data["customer"];
    }
    function update($column, $value) {
      $new_data = array (
        $this->order_number,
        date("Y-m-d H:i:s"),
        $this->type,
        $this->customer,
        $value
      );
      $this->database->run("UPDATE customer_orders SET order_number = ?, date = ?, type = ?, customer = ? WHERE $column = ?", $new_data);
    }
    function add_to_order($item_id, $customer_order_number) {
      $new_item = array (
        $item_id,
        $customer_order_number
      );
      $this->database->run("INSERT INTO order_items (item_id, customer_order_number) VALUES (?,?)", $new_item);
    }
    function delete($column, $value) {
      $this->database->run("DELETE FROM customer_orders WHERE $column = ?", [$value]);
    }
  }

  class guest_order {
    protected $database;
    public $order_number;
    public $date;
    public $type; // delivery or carryout
    public $guest; // customer username or guest phone number associated with the order

    function __construct($db) {
      $this->database = $db;
    }
    function create() {
      $new_order = array (
        $this->date,
        $this->type,
        $this->guest
      );
      $this->database->run("INSERT INTO guest_orders (date, type, guest) VALUES (?,?,?)", $new_order);
    }
    function read($date, $guest) {
      $data = $this->database->run("SELECT * FROM guest_orders WHERE date = ? AND guest = ?", [$date,$guest])->fetch();
      $this->order_number = $data["order_number"];
      $this->date = $data["date"];
      $this->type = $data["type"];
      $this->guest = $data["guest"];
    }
    function update($column, $value) {
      $new_data = array (
        $this->order_number,
        date("Y-m-d H:i:s"),
        $this->type,
        $this->guest,
        $value
      );
      $this->database->run("UPDATE guest_orders SET order_number = ?, date = ?, type = ?, guest = ? WHERE $column = ?", $new_data);
    }
    function delete($column, $value) {
      $this->database->run("DELETE FROM guest_orders WHERE $column = ?", [$value]);
    }
    function add_to_order($item_id, $guest_order_number) {
      $new_item = array (
        $item_id,
        $guest_order_number
      );
      $this->database->run("INSERT INTO order_items (item_id, guest_order_number) VALUES (?,?)", $new_item);
    }
    function remove_from_order($column, $value) {
      $this->database->run("DELETE FROM order_items WHERE $column = ?", [$value]);
    }

  }



?>

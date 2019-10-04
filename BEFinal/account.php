<?php
include "class.php";
session_start();
if (isset($_SESSION["user"])) {
  $db = new database();
  $customer = new customer($db);
  $customer->read("username", $_SESSION["user"]);
  if (isset($_POST["delete"])) {
    parse_str(urldecode($_POST["delete"]), $username);
    try{
        $customer->delete("username", $username);
    }
    catch(Exception $e) {
      echo $e->getMessage();
    }
  }
  if (isset($_POST["submit"])) {
    $customer->first_name = $_POST["first_name"];
    $customer->last_name = $_POST["last_name"];
    $customer->phone_number = $_POST["phone_number"];
    $customer->primary_address = $_POST["primary_address"];
    $customer->city = $_POST["city"];
    $customer->state = $_POST["state"];
    $customer->zip_code = $_POST["zip_code"];
    $customer->update("username", $_SESSION["user"]);
  }
  if (isset($_POST["reset_password"])) {
    $new_password = $_POST["password"];
    $ret_password = $_POST["retype_password"];
    if ($new_password != $ret_password) {
      echo "The passwords don't match";
    }
    else{
      $customer->reset_password($new_password, $_SESSION["user"]);
    }
  }
}
else{
  header("location: index.php");
}
 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <head>
     <meta charset="utf-8">
     <title>Welcome to The Boo!</title>
   </head>
   <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <link rel="stylesheet" href="styles.css">
   <body>
    <div class="jumbotron">
      <h3>Account Details: <span id="username"><?= $_SESSION["user"] ?></span><a href="order.php" class="btn btn-primary">Back to Orders</a></h3>
      <form action="account.php" method="post">
          <div class="form-group">
            <label for="first_name">First Name</label>
            <input type="text" name="first_name" required class="form-control" value="<?= $customer->first_name ?>">
          </div>
          <div class="form-group">
            <label for="last_name">Last Name</label>
            <input type="text" name="last_name" required class="form-control" value="<?= $customer->last_name ?>">
          </div>
          <div class="form-group">
            <label for="phone_number">Phone Number</label>
            <input type="text" name="phone_number" required class="form-control" value="<?= $customer->phone_number ?>">
          </div>
          <div class="form-group">
            <label for="primary_address">Address</label>
            <input type="text" name="primary_address" required class="form-control" value="<?= $customer->primary_address ?>">
          </div>
          <div class="form-group">
            <label for="city">City</label>
            <input type="text" name="city" required class="form-control" value="<?= $customer->city ?>">
          </div>
          <div class="form-group">
            <label for="state">State</label>
            <select class="form-control" name="state">
              <?php
                $states = json_decode(file_get_contents("states.json"));
                foreach ($states as $key => $value) {
                  if ($key == $customer->state) {
                    echo "<option selected>".$key."</option>";
                  }
                  else {
                    echo "<option>".$key."</option>";
                  }

                }
               ?>
            </select>
          </div>
          <div class="form-group">
            <label for="zip_code">Zip Code</label>
            <input type="text" name="zip_code" required class="form-control" value="<?= $customer->zip_code ?>">
          </div>
          <div class="form-group">
            <button type="submit" name="update">Update Info</button>
            <button id="delete" type="button" name="delete">I don't like this account... Delete it!</button>
          </div>
      </form>

      <form action="account.php" method="post">
        <h3>Reset My Password</h3>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" name="password" required class="form-control">
        </div>
        <div class="form-group">
          <label for="retype_password">Retype Password</label>
          <input type="password" name="retype_password" required class="form-control">
        </div>
        <div class="form-group">
          <button type="submit" name="reset_password">Reset Password</button>
        </div>
      </form>
    </div>


     <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" charset="utf-8"></script>
     <script type="text/javascript">
       $(function(){
         $("#delete").on("click", function(){
           $.ajax({
             url: "account.php",
             data: {"delete": $("#username").innerText},
             dataType: "text",
             type: "POST"
           }).fail(function (error){
             alert(error);
           }).done(function (result){
             window.location.href("index.php");
           });
         });
       });
     </script>
   </body>
 </html>

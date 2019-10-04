<?php
  session_start();
  include "class.php";
  $db = new database();
  if (isset($_SESSION["user"])) {
    $customer = new customer($db);
    $customer->read("username", $_SESSION["user"]);

  }
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>Welcome to The Boo!</title>
  </head>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="styles.css">
  <body>
    <a href="index.php"><img class="text-center" src="img\BooLogo2.jpg" alt="Home" height=100 width=100></a>
    <div class="container">
      <?php
          if (isset($_SESSION["user"])) {
            echo "<div id='logout-interface'>";
            echo "<p>Logged in as: <span><a href='account.php' id='user-type'>".$_SESSION["user"]."</a> <a id='logout-button' href='logout.php' class='btn btn-primary'>Sign Out</a> <a id='account-button' href='account.php' class='btn btn-primary'>My Account</a></span></p>";

            echo "</div>";
          }
          else {
            echo "<div id='login-interface'>";
            echo "<p>Logged in as:<span><a href='account.php' id='user-type'> guest</a></span></p>";
            echo '<button id="login-button" type="button" class="btn btn-primary">Sign In</button>';
            echo '<p>Want to check out faster and receive discounts in your inbox?</p>
            <button id="signup-button" type="button" class="btn btn-primary">I love Coupons! Sign me Up!</button>';
            echo "</div>";

          }
       ?>
    </div>

    <div class="container">
      <div class="row">
        <div class="col-lg">
          <div class="jumbotron">




            <!-- New Order Form -->
            <form id="new-order-form" action="new_order.php" method="post">
              <div class="form-group">
                <h3 class="text-center">Order Here!</h3>
                <label for="order_type">Order Type</label>
                <select id="order-type" class="form-control" name="order_type">
                  <option value="carryout">Carryout</option>
                  <option selected value="delivery">Delivery</option>
                </select>
              </div>
              <div class="form-group">
                <button type="button" id="add-items-button" class="btn btn-primary">Add Items</button>
                <select multiple class="form-control" name="order_items" id="selected-items">

                </select>
                <button class="btn btn-primary" type="button" id="remove-items-button">Remove Selected Items</button>
                <label>Total: $<span id="order-total">0.00</span></label>
              </div>
              <div class="form-group">
                <label for="first_name">First Name</label>
                <input value="<?= $customer->first_name ?>" required class="form-control" type="text" name="first_name" placeholder="First Name">
              </div>
              <div class="form-group">
                <label for="last_name">Last Name</label>
                <input value="<?= $customer->last_name ?>" required class="form-control" type="text" name="last_name" placeholder="Last Name">
              </div>
              <div class="form-group">
                <label for="phone_number">Phone Number (no dashes or spaces - 10 digits)</label>
                <input value="<?= $customer->phone_number ?>" type="text" name="phone_number" placeholder="Phone Number" required class="form-control" minlength="10" maxlength="10">
              </div>
              <div id="delivery-portion">
                <div class="form-group">
                  <label for="address">Address</label>
                  <input value="<?= $customer->primary_address ?>" class="form-control" type="text" name="address" placeholder="Address">
                </div>
                <div class="form-group">
                  <label for="city">City</label>
                  <input value="<?= $customer->city ?>" required class="form-control" type="text" name="city" placeholder="City">
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
              </div>
              <div class="form-group">
                <label for="zip_code">Zip Code</label>
                <input value="<?= $customer->zip_code ?>" required class="form-control" type="text" name="zip_code" placeholder="Zip Code" minlength="5" maxlength="5">
              </div>
              <div class="form-group">
                <button class="form-control btn-primary" type="submit" name="create_order">Check Out</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>


    <!-- Menu Items Form -->

    <div class="container" id="menu-item-form" title="Add Items">
      <select multiple class="form-control" id="menu-item-select">
        <?php
        $menu = new menu_item($db);
        $menu->get_all_items();
        foreach ($menu->all_items as $item) {
          echo "<option>".$item["size"]." - ".$item["name"]." - ".$item["price"]."</option>";
        }
         ?>
      </select>
      <button id="add-menu-items-button" type="button" class="btn btn-primary">Add Items</button>
    </div>




    <!-- Sign Up Form -->

    <div class="container" id="signup-form" title="Sign Up">
      <form id="signup-data" action="signup.php" method="post">
        <div class="form-group">
          <label for="email_address">Email address</label>
          <input class="form-control" type="email" name="email_address" placeholder="Email address" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control" type="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
          <label for="retype_password">Retype Password</label>
          <input class="form-control" type="password" name="retype_password" placeholder="Retype Password" required>
        </div>
        <div class="form-group">
          <label for="first_name">First Name</label>
          <input class="form-control" type="text" name="first_name" placeholder="First Name" required>
        </div>
        <div class="form-group">
          <label for="last_name">Last Name</label>
          <input type="text" name="last_name" placeholder="Last Name" required class="form-control">
        </div>
        <div class="form-group">
          <label for="phone_number">Phone Number (no dashes or spaces - 10 digits)</label>
          <input type="text" name="phone_number" placeholder="Phone number" required class="form-control" minlength="10" maxlength="10">
        </div>
        <div class="form-group">
          <label for="address">Address</label>
          <input type="text" name="address" placeholder="address" required class="form-control">
        </div>
        <div class="form-group">
          <label for="city">City</label>
          <input type="text" name="city" placeholder="city" required class="form-control">
        </div>
        <div class="form-group">
          <label for="state">State</label>
          <select class="form-control" name="state">
            <?php
              $states = json_decode(file_get_contents("states.json"));
              foreach ($states as $key => $value) {
                echo "<option>".$key."</option>";
              }
             ?>
          </select>
        </div>
        <div class="form-group">
          <input type="text" name="zip_code" placeholder="zip Code" required class="form-control" minlength="5" maxlength="5">
        </div>
        <div class="form-group">
          <button type="submit" id="signup-submit" name="signup">Create Account</button>
        </div>
      </form>
    </div>



    <!-- Login Form -->
    <div class="container" id="login-form" title="Log In">
      <form id="login-form-data" action="login.php" method="post">
        <div class="form-group">
          <label for="email_address">Email Address</label>
          <input class="form-control" type="email" name="email_address" placeholder="Email address" required>
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input class="form-control" type="password" name="password" placeholder="Password" required>
        </div>
        <div class="form-group">
          <button id="login-submit" type="submit" name="login">Log In</button>
        </div>
      </form>
    </div>

    <!-- Order Details Form -->
    <div class="container" id="order-details-form" title="Order Details">

    </div>

  <script src="https://code.jquery.com/jquery-3.4.1.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" charset="utf-8"></script>
  <script
  src="https://code.jquery.com/ui/1.12.0/jquery-ui.js"
  integrity="sha256-0YPKAwZP7Mp3ALMRVB2i8GXeEndvCq3eSl/WsAl1Ryk="
  crossorigin="anonymous"></script>
  <script type="text/javascript">
    $(function(){
      $("#menu-item-form, #signup-form, #login-form, #order-details-form").dialog({
        autoOpen: false,
        modal: true,
        show: "scale",
        hide: "scale",
        width: "70%"
      });
      $("#login-button").on("click", function() {
        $("#login-form").dialog("open");
        $("#login-form-data").one("submit", function(event) {
          event.preventDefault();
          $.ajax({
            url: "login.php",
            data: {"login": $("#login-form-data").serialize()},
            dataType: "JSON",
            type: "POST"
          }).fail(function(error) {
            alert(error.responseText);
            error = null;
            $("#login-form").dialog("close");
          }).done(function(result) {
            console.log(result);
            $("#user-type").empty().append(" " + result.username + " <span><a href='logout.php' id='logout-button' class='btn btn-primary'>Logout</a> <a href='account.php' id='account-button' class='btn btn-primary'>My Account</a></span>");
            $("#login-button").hide();
            $("#new-order-form").find("input[name='first_name']").val(result.first_name);
            $("#new-order-form").find("input[name='last_name']").val(result.last_name);
            $("#new-order-form").find("input[name='city']").val(result.city);
            $("#new-order-form").find("input[name='phone_number']").val(result.phone_number);
            $("#new-order-form").find("select[name='state']").val(result.state).change();
            $("#new-order-form").find("input[name='zip_code']").val(result.zip_code);
            $("#new-order-form").find("input[name='address']").val(result.primary_address);
            $("#login-form").dialog("close");
          });
        });
      });
      $("#signup-button").on("click", function() {
        $("#signup-form").dialog("open");
        $("#signup-data").one("submit", function(event){
          event.preventDefault();
          var password = $("#signup-data").find("input[name='password']").val();
          var retype = $("#signup-data").find("input[name='retype_password']").val();
          if (password == retype) {
            $.ajax({
              url: "signup.php",
              data: {"signup": $("#signup-data").serialize()},
              dataType: "JSON",
              type: "POST"
            }).fail(function(error) {
              alert(error.responseText);
            }).done(function(result){
              $("#signup-form").dialog("close");
              $("#new-order-form").find("input[name='first_name']").val(result.first_name);
              $("#new-order-form").find("input[name='last_name']").val(result.last_name);
              $("#new-order-form").find("input[name='city']").val(result.city);
              $("#new-order-form").find("input[name='phone_number']").val(result.phone_number);
              $("#new-order-form").find("select[name='state']").val(result.state).change();
              $("#new-order-form").find("input[name='zip_code']").val(result.zip_code);
              $("#new-order-form").find("input[name='address']").val(result.primary_address);
              alert("Congratulations! Your account has been created.");
            });
          }
          else{
            alert("Passwords do not match!");
          }
        });
      });
      $("#add-items-button").on("click", function() {
        $("#menu-item-form").dialog("open");
        $("#add-menu-items-button").on("click", function(){
          var items = $("#menu-item-select").val();
          for(var i = 0; i < items.length; i ++) {
            var current_total = parseFloat($("#order-total")[0].innerText);
            var item_price = parseFloat(items[i].split(" - ")[2]);
            var new_price = item_price + current_total;
            $("#selected-items").append("<option>"+items[i]+"</option>");
            $("#order-total").empty().append(new_price.toFixed(2));
          }
          $("#menu-item-select").val(null);
          $("#menu-item-form").dialog("close");
        });
      });
      $("#remove-items-button").on("click", function(){
        var items = $("#selected-items").val();
        var remove = $("#selected-items").val().html;
        for(var i = 0; i < items.length; i ++) {
          var current_total = parseFloat($("#order-total")[0].innerText);
          var item_price = parseFloat(items[i].split(" - ")[2]);
          var new_price = current_total - item_price;
          $("#order-total").empty().append(new_price.toFixed(2));
        }
        $("#selected-items").find("option").each(function(){
          console.log($(this)[0].selected);
          if ($(this)[0].selected == true) {
            $(this).remove();
          }
        });
      });
      $("#order-type").on("change", function() {
        var type = $("#order-type").val();
        if (type == "carryout") {
          $("#delivery-portion").hide();
        }
        else {
          $("#delivery-portion").show();
        }
      });
      $("#new-order-form").on("submit", function(event) {
        event.preventDefault();
        var selected = $("#selected-items")[0];
        var items = [];
        $.each(selected, function(index, item){
          items.push(item.innerText);
        });
        $.ajax({
          url: "new_order.php",
          data: {"new_order": $("#new-order-form").serialize(), "order_items": items},
          dataType: "JSON",
          type: "POST"
        }).fail(function(error){
          alert(error);
        }).done(function(result){
          console.log(result);
          $("#order-details-form").dialog("open");
          $("#order-details-form").empty().append("<h3>"+result.order_details.Date+"</h3>");
          $("#order-details-form").append("<ul>");
          $.each(result.order_details.items, function(index, item) {
            $("#order-details-form").append("<li>"+item+"</li>");
          });
          $("#order-details-form").append("</ul>");
          $("#order-details-form").append("<p>Total: " + result.order_details.total + "</p>");
        });
        items = null;
      });
    });
  </script>
  </body>
</html>

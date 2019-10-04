<?php
include "PDO.php";
if (isset($_POST["submit"])) {
  $title = $_POST["Title"];
  $bedrooms = $_POST["Bedrooms"];
  $beds = $_POST["Beds"];
  $baths = $_POST["Baths"];
  $description = $_POST["Description"];
  $superhosted = 0;

  try{
    //insert new record
    $insert_bnb = $pdo->prepare("INSERT INTO items (title, bedrooms, beds, baths, superhosted, description) VALUES (?,?,?,?,?,?);");
    $insert_bnb->execute([$title,$bedrooms,$beds,$baths,$superhosted,$description]);
    // get the id of the new record
    $get_id = $pdo->prepare("SELECT id FROM items WHERE title = ?");
    $get_id->execute([$title]);
    $id = $get_id->fetch(PDO::FETCH_ASSOC);
  }
  catch(PDOException $e) {
    echo $e->getMessage();
  }
  if (isset($_FILES["images"])) {
    for ($i = 0; $i < 3; $i++) {
      if ($_FILES["images"]["type"][$i] == "image/jpeg") {
        $new_file_name = uniqid();
        move_uploaded_file($_FILES["images"]["tmp_name"][$i], dirname(__FILE__)."\\img\\".$new_file_name.".jpg");
        try {
          $insert_image = $pdo->prepare("INSERT INTO images (image_name, id) VALUES (?,?)");
          $insert_image->execute([$new_file_name, $id["id"]]);

        }
        catch(PDOException $e) {
          echo $e->getMessage();
        }
      }
    }
    echo "New record saved...";
  }
}
?>

 <!doctype html>
 <html lang="en">
   <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

     <!-- Bootstrap CSS -->
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
     <style>
         #lg-ul {
             text-align: left;
             width: 27%;
             margin: 0 auto;
         }
         #bnb-form {
             text-align: left;
             width: 27%;
             margin: 0 auto;

         }
         .row {
             margin-bottom: 2em;
         }
         .form-control:hover, .form-control:focus {
             border-right: 5px solid blue;
         }
         .big-button{
             width: 100%;
             margin-bottom: 5px;
         }
         @media all and (max-width: 1024px) {
             #lg-ul {
                 display: none;
             }
             #bnb-form {
                 width: 100%;
             }
         }
     </style>
     <title>Add new Airbnb</title>
   </head>
   <body>
     <div class="container-fluid">
         <div class="row">
             <div class="col-md"  style="text-align: center;">
                 <h1>Add New Airbnb Here</h1>
                 <p>Fill in all the required fields below and click "Finish" when done.</p>
                 <ul id="lg-ul">
                     <li>Include a Title</li>
                     <li>Description</li>
                     <li>Number of Bedroooms, Beds, and Baths</li>
                     <li>Upload up to 3 images (jpg only)</li>
                 </ul>
             </div>
         </div>
         <div class="row">
             <div class="col-md">
                 <form id="bnb-form" action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
                     <div class="form-group">
                         <a href="index.php" class="btn btn-warning big-button">Back to Home Page</a>
                     </div>
                     <div class="form-group">
                         <label for="Title">Title *</label>
                         <input type="text" name="Title" class="form-control" placeholder="Give Your Room a Name That Pops!" required>
                     </div>
                     <div class="form-group">
                         <label for="Description">Description *</label>
                         <textarea rows="5" name="Description" class="form-control" placeholder="Describe your property. Try to make a good first impression!" required></textarea>
                     </div>
                     <div class="form-group">
                         <label for="Bedrooms">Bedrooms *</label>
                         <input type="number" min="1" max="3" name="Bedrooms" class="form-control" required>
                         <small class="form-text text-muted">Between 1 and 3... More than that and you're running a hotel!</small>
                         <label for="Beds">Beds *</label>
                         <input type="number" min="1" name="Beds" class="form-control" required>
                         <small class="form-text text-muted">Minimum of 1... Can't have people sleeping on couches and floors!</small>
                         <label for="Baths">Private Baths</label>
                         <input type="number" name="Baths" min="0" class="form-control">
                         <small class="form-text text-muted">0 If they're sharing a bathroom with you or other guests...</small>
                     </div>
                     <div class="form-group">
                         <label for="images[]">Select up to 3 images to upload *jpg only</label>
                         <input type="file" name="images[]" max="3" multiple class="form-control-file">
                     </div>
                     <div class="form-group">
                         <button type="submit" name="submit" class="btn btn-primary big-button">Finish and Create New AirBnb</button>
                     </div>
                 </form>
             </div>
         </div>
     </div>

     <!-- Optional JavaScript -->
     <!-- jQuery first, then Popper.js, then Bootstrap JS -->
     <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
   </body>
 </html>

<?php 
    include "classes.php";  
    if (isset($_SERVER["QUERY_STRING"])) {
        $query_array = explode("=",$_SERVER["QUERY_STRING"]); 
        $id = $query_array[1]; 
        $bnb = new BnB();  
        $bnb->set_bnb($id); 
        $images = $bnb->get_Images(); 
    }
    if (isset($_POST["submit"])) {
        $id = $_POST["id"]; 
        $bnb = new BnB(); 
        $bnb->set_bnb($id); 
        if (isset($_FILES["images"])) {
            if ($_FILES["images"]["error"][0] != 4) {
                $current_images = $bnb->get_Images(); 
                foreach ($current_images as $image) {
                    $bnb->delete_Image($image); 
                }
            
            
                for ($i = 0; $i < 3; $i++) {
                    if ($_FILES["images"]["type"][$i] == "image/jpeg") {
                        $bnb->save_Image(array (
                            "name" => $_FILES["images"]["name"][$i], 
                            "type" => $_FILES["images"]["type"][$i], 
                            "size" => $_FILES["images"]["size"][$i],
                            "tmp_name" => $_FILES["images"]["tmp_name"][$i], 
                            "error" => $_FILES["images"]["error"][$i]
                        )); 
                    }   
                }
            
            }
        }
        $bnb->update($id, array(
            "Title" => $_POST["Title"], 
            "Bedrooms" =>  $_POST["Bedrooms"],
            "Beds" => $_POST["Beds"], 
            "Baths" => $_POST["Baths"], 
            "Description" => $_POST["Description"], 
            "Images" => $bnb->get_Images() 
        )); 
        $bnb->save_file("bnbs.json", $bnb->data);
        //header("location: index.php");  
    }
    
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details - <?= $bnb->get_Title() ?></title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
    <style>
        .carousel-item > img {
            object-fit: cover; 
            height: 500px; 
            width: 100%; 
        }
    </style>
</head>
<body>
<div class="container-fluid">
        <div class="row">
            <div class="col-md"  style="text-align: center;">
                <h1>Edit your Airbnb</h1>
                <p>Fill in all the required fields below and click "Finish" when done. Scroll down to see what your Airbnb currently looks like.</p>
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
                        <input type="text" name="Title" class="form-control" placeholder="Give Your Room a Name That Pops!" value="<?= $bnb->get_Title() ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Description">Description *</label>
                        <textarea rows="5" name="Description" class="form-control" placeholder="Describe your property. Try to make a good first impression!" required><?= $bnb->get_Description() ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Bedrooms">Bedrooms *</label> 
                        <input type="number" min="1" max="3" name="Bedrooms" class="form-control" value="<?= $bnb->get_Bedrooms() ?>" required>
                        <small class="form-text text-muted">Between 1 and 3... More than that and you're running a hotel!</small>
                        <label for="Beds">Beds *</label>
                        <input type="number" min="1" name="Beds" class="form-control" value="<?= $bnb->get_Beds() ?>" required>
                        <small class="form-text text-muted">Minimum of 1... Can't have people sleeping on couches and floors!</small>
                        <label for="Baths">Private Baths</label>
                        <input type="number" name="Baths" min="0" class="form-control" value="<?= $bnb->get_Baths() ?>">
                        <small class="form-text text-muted">0 If they're sharing a bathroom with you or other guests...</small>
                    </div>
                    <div class="form-group">
                        <label for="images[]">Select up to 3 images to upload *jpg only</label>
                        <input type="file" name="images[]" max="3" multiple class="form-control-file">
                    </div>
                    <div class="form-group">
                        <button type="submit" name="submit" class="btn btn-primary big-button">Finished Editing - Save</button>
                    </div>
                    <input type="hidden" name="id" value="<?= $id ?>">
                </form>
            </div>
        </div>
    </div>

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-3"><?= $bnb->get_Title() ?></h1>
            <p class="lead"><?= $bnb->get_Description() ?></p>
            <hr class="my-2">
            <div id="bnbpics" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#bnbpics" data-slide-to="0" class="active"></li>
                    <li data-target="#bnbpics" data-slide-to="1"></li>
                    <li data-target="#bnbpics" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="img/<?= $images[0] ?>.jpg" alt="Image coming soon!">
                    </div>
                    <div class="carousel-item">
                        <img src="img/<?= $images[1]?>.jpg" alt="Image coming soon!">
                    </div>
                    <div class="carousel-item">
                        <img src="img/<?= $images[2] ?>.jpg" alt="Image coming soon!">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#bnbpics" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#bnbpics" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <ul>
                <?php 
                    if ($bnb->get_Superhosted()) {
                        echo "<li>This member is a Super Host! That means they are experienced and provide excellent service.</li>"; 
                    }
                ?>
                <li>Bedrooms: <?= $bnb->get_Bedrooms() ?></li>
                <li>Beds: <?= $bnb->get_Beds() ?></li>
                <li>Private Baths: <?= $bnb->get_Baths() ?></li>
            </ul>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".carousel").carousel({
                interval: 5000
            }); 
        }); 
    </script>
</body>
</html>
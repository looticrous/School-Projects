<?php 
    session_start(); 
    echo $_SESSION["error"]; 
    unset($_SESSION["error"]); 
    if (isset($_SERVER["QUERY_STRING"])) {
        $query_array = explode("=",$_SERVER["QUERY_STRING"]); 
        $id = $query_array[1]; 
        $bnb_details = $_SESSION["json_contents"][$id]; 
    }
    
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details - <?= $bnb_details["Title"] ?></title>
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
                <form id="bnb-form" action="save.php" method="post" enctype="multipart/form-data">
                    <div class="form-group"> 
                        <a href="index.php" class="btn btn-warning big-button">Back to Home Page</a>
                    </div>
                    <div class="form-group">
                        <label for="Title">Title *</label>
                        <input type="text" name="Title" class="form-control" placeholder="Give Your Room a Name That Pops!" value="<?= $_SESSION["json_contents"][$id]["Title"] ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="Description">Description *</label>
                        <textarea rows="5" name="Description" class="form-control" placeholder="Describe your property. Try to make a good first impression!" required><?= $_SESSION["json_contents"][$id]["Description"] ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="Bedrooms">Bedrooms *</label> 
                        <input type="number" min="1" max="3" name="Bedrooms" class="form-control" value="<?= $_SESSION["json_contents"][$id]["Bedrooms"] ?>" required>
                        <small class="form-text text-muted">Between 1 and 3... More than that and you're running a hotel!</small>
                        <label for="Beds">Beds *</label>
                        <input type="number" min="1" name="Beds" class="form-control" value="<?= $_SESSION["json_contents"][$id]["Beds"] ?>" required>
                        <small class="form-text text-muted">Minimum of 1... Can't have people sleeping on couches and floors!</small>
                        <label for="Baths">Private Baths</label>
                        <input type="number" name="Baths" min="0" class="form-control" value="<?= $_SESSION["json_contents"][$id]["Baths"] ?>">
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
            <h1 class="display-3"><?= $bnb_details["Title"] ?></h1>
            <p class="lead"><?= $bnb_details["Description"] ?></p>
            <hr class="my-2">
            <div id="bnbpics" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#bnbpics" data-slide-to="0" class="active"></li>
                    <li data-target="#bnbpics" data-slide-to="1"></li>
                    <li data-target="#bnbpics" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="img/<?= $_SESSION["json_contents"][$id]["Images"][0] ?>.jpg" alt="Image coming soon!">
                    </div>
                    <div class="carousel-item">
                        <img src="img/<?= $_SESSION["json_contents"][$id]["Images"][1]?>.jpg" alt="Image coming soon!">
                    </div>
                    <div class="carousel-item">
                        <img src="img/<?= $_SESSION["json_contents"][$id]["Images"][2] ?>.jpg" alt="Image coming soon!">
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
                    if ($bnb_details["Superhosted"]) {
                        echo "<li>This member is a Super Host! That means they are experienced and provide excellent service.</li>"; 
                    }
                ?>
                <li>Bedrooms: <?= $bnb_details["Bedrooms"] ?></li>
                <li>Beds: <?= $bnb_details["Beds"] ?></li>
                <li>Private Baths: <?= $bnb_details["Baths"] ?></li>
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
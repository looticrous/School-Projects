<?php
    include "PDO.php";
    if (isset($_SERVER["QUERY_STRING"])) {
        $query_array = explode("=",$_SERVER["QUERY_STRING"]);
        $id = $query_array[1];
        $get_details = $pdo->prepare("SELECT * FROM items WHERE id = ?");
        $get_details->execute([$id]);
        $bnb = $get_details->fetch(PDO::FETCH_ASSOC);
        $get_images = $pdo->prepare("SELECT * FROM images WHERE id = ?");
        $get_images->execute([$id]);
        $images = $get_images->fetchAll(PDO::FETCH_ASSOC);
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Details - <?= $bnb['title'] ?></title>
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

    <div class="jumbotron jumbotron-fluid">
        <div class="container">
            <h1 class="display-3"><?= $bnb['title']?></h1>
            <p class="lead"><?= $bnb['description'] ?></p>
            <hr class="my-2">
            <div id="bnbpics" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#bnbpics" data-slide-to="0" class="active"></li>
                    <li data-target="#bnbpics" data-slide-to="1"></li>
                    <li data-target="#bnbpics" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" role="listbox">
                    <div class="carousel-item active">
                        <img src="img/<?= $images[0]['image_name'] ?>.jpg" alt="Image coming soon!">
                    </div>
                    <div class="carousel-item">
                        <img src="img/<?= $images[1]['image_name']?>.jpg" alt="Image coming soon!">
                    </div>
                    <div class="carousel-item">
                        <img src="img/<?= $images[2]['image_name'] ?>.jpg" alt="Image coming soon!">
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
                    if ($bnb['superhosted'] == 1) {
                        echo "<li>This member is a Super Host! That means they are experienced and provide excellent service.</li>";
                    }
                ?>
                <li>Bedrooms: <?= $bnb['bedrooms']?></li>
                <li>Beds: <?= $bnb['beds'] ?></li>
                <li>Private Baths: <?= $bnb['baths'] ?></li>
            </ul>
            <p class="lead">
                <a class="btn btn-primary btn-lg" href="index.php" role="button">Home</a>
                <a class="btn btn-primary btn-lg" href="edit.php?id=<?= $id ?>" role="button">Edit This Record</a>
                <a class="btn btn-warning btn-lg" id="delete-button" href="delete-record.php?id=<?= $id ?>" role="button">Delete This Record</a>
            </p>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            $(".carousel").carousel({
                interval: 5000
            });
        $("#delete-button").click(function(event){
            event.preventDefault();
            if (confirm("WARNING! Deleting this record will permanently remove ALL information about the record. Once deleted, the only way to get it back is to recreate it, including uploading new images. Are you sure you want to proceed?")) {
                window.location.href = "delete-record.php?id=<?= $id ?>";
            }

        });
        });
    </script>
</body>
</html>

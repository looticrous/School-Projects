<?php 
include "classes.php"; 
$bnbs = new BnB(); 
$all_data = $bnbs->data; 
?>

<html lang="en">
<html>
    <head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <script
			  src="https://code.jquery.com/jquery-3.3.1.min.js"
			  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
			  crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js" integrity="sha384-xrRywqdh3PHs8keKZN+8zzc5TX0GRTLCcmivcbNJWm2rs5C8PRhcEn3czEjhAO9o" crossorigin="anonymous"></script>
    <style>
        .table {
            margin: auto;
            width: 50% !important; 
        }
    </style>

    </head>
    <body>
         <table class="table table-striped table-inverse table-responsive">
             <thead class="thead-inverse">
                 <tr>
                     <th colspan="5"><h2 style="text-align: center;">AirBnB locations near Pittsburg, KS</h2></th>
                 </tr>
                 <tr>
                     <th colspan="5"><a href="newbnb.php" class="btn btn-primary" style="width: 100%;">Add New AirBnB</a></th>   
                 </tr>
                 <tr>
                     <th>Title</th>
                     <th>Bedrooms</th>
                     <th># of Beds</th>
                     <th>Private Baths</th>
                     <th>image</th>
                 </tr>
                 </thead>
                 <tbody>
                     <?php 
                        /* Code to populate table with rows from JSON file....*/
                        foreach ($all_data as $key => $value) {
                            echo "<tr>"; 
                            echo "<td><a href='details.php?id=".$key."'>".$all_data->$key->Title."</a></td>"; 
                            echo "<td>".$all_data->$key->Bedrooms."</td>"; 
                            echo "<td>".$all_data->$key->Beds."</td>";
                            echo "<td>".$all_data->$key->Baths."</td>";
                            echo "<td><img width='175px' height='150px' src='img/".$all_data->$key->Images[0].".jpg'></td>";
                            echo "</tr>"; 
                        }
                     ?>
                </tbody>
         </table>
    </body>
</html>
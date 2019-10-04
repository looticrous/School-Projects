<?php 
    session_start(); 
    if (isset($_SERVER["QUERY_STRING"])) {
        $query_array = explode("=",$_SERVER["QUERY_STRING"]); 
        $id = $query_array[1];
        print_r($_SESSION["json_contents"][$id]);  
        foreach($_SESSION["json_contents"][$id]["Images"] as $image) {
            unlink(dirname(__FILE__)."\\img\\".$image.".jpg"); 
        }
        unset($_SESSION["json_contents"][$id]); 
        file_put_contents("bnbs.json", json_encode($_SESSION["json_contents"])); 
        header("location: index.php"); 
    }
?>

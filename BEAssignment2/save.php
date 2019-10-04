<?php 
session_start(); 

if (isset($_POST["submit"])) {
    $id = $_POST["id"];
  
        if (!file_exists($_FILES["images"]["tmp_name"][0]) || !is_uploaded_file($_FILES["images"]["tmp_name"][0])) {
            echo "No Files to upload"; 
            $current_images = $_SESSION["json_contents"][$id]["Images"]; 
            print_r($current_images); 
            $_SESSION["json_contents"][$id] = array (
                "Title" => $_POST["Title"], 
                "Bedrooms" => $_POST["Bedrooms"], 
                "Beds" => $_POST["Beds"], 
                "Baths" => $_POST["Baths"],
                "Description" => $_POST["Description"], 
                "Superhosted" => false,
                "Images" => array()
            );  
            foreach ($current_images as $image) {
                array_push($_SESSION["json_contents"][$id]["Images"],$image); 
            }
            
            file_put_contents("bnbs.json", json_encode($_SESSION["json_contents"])); 
            header("location: index.php"); 
        }
        else {
            echo "Files to upload"; 
            $_SESSION["json_contents"][$id] = array (
                "Title" => $_POST["Title"], 
                "Bedrooms" => $_POST["Bedrooms"], 
                "Beds" => $_POST["Beds"], 
                "Baths" => $_POST["Baths"],
                "Description" => $_POST["Description"], 
                "Superhosted" => false,
                "Images" => array()
            ); 
            $approved_images = array(); 
            if (Count($_FILES["images"]["tmp_name"]) > 3) {
                $_SESSION["error"] = "You have uploaded too many images. Please limit to 3."; 
                header("location: edit.php?id=".$id);
            }
            else {
                for ($i = 0; $i < Count($_FILES["images"]["type"]); $i ++ ) {
                    if ($_FILES["images"]["type"][$i] != "image/jpeg") {
                        $_SESSION["error"] = $_FILES["images"]["name"][$i]." is not the right type and will not be uploaded. Please try again.";
                        header("location: edit.php?id=".$id); 
                    }
                    else if ($_FILES["images"]["error"][$i] != UPLOAD_ERR_OK) {
                        $_SESSION["error"] = "There was an error uploading the file. Please try again.";
                        header("location: edit.php?id=".$id);
                    }
                    else {
                        array_push($approved_images, $_FILES["images"]["tmp_name"][$i]);
                    }
                }
                // rename approved uploads and move them to the correct folder with the correct name. 
                foreach ($_SESSION["json_contents"][$id]["Images"] as $image) {
                    unlink(dirname(__FILE__)."\\img\\".$image.".jpg");
                }
                for ($i = 0; $i < Count($approved_images); $i ++) {
                    $new_file_name = uniqid(); 
                    move_uploaded_file($approved_images[$i], dirname(__FILE__)."\\img\\".$new_file_name.".jpg"); 
                    array_push($_SESSION["json_contents"][$id]["Images"], $new_file_name); 
                }
                file_put_contents("bnbs.json", json_encode($_SESSION["json_contents"]));
                header("location: index.php"); 
            }
        }
    
    
}

?>
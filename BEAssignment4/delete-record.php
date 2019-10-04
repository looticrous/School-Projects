<?php 
    include "classes.php"; 
    if (isset($_SERVER["QUERY_STRING"])) {
        $query_array = explode("=",$_SERVER["QUERY_STRING"]); 
        $id = $query_array[1];  
        $bnb = new BnB();  
        $bnb->set_bnb($id); 
        $images = $bnb->get_Images(); 
        foreach ($images as $image) {
            $bnb->delete_Image($image); 
        }
        $bnb->delete($id); 
        $bnb->save_file("bnbs.json", $bnb->data); 
        header("location: index.php"); 
    }
?>

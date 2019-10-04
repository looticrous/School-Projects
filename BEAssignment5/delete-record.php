<?php
  include "PDO.php";
  if (isset($_SERVER["QUERY_STRING"])) {
      $query_array = explode("=",$_SERVER["QUERY_STRING"]);
      try {
        $id = $query_array[1];
        $get_images = $pdo->prepare("SELECT * FROM images WHERE id = ?");
        $get_images->execute([$id]);
        $images_to_delete = $get_images->fetchAll(PDO::FETCH_ASSOC);
        foreach ($images_to_delete as $image) {
           unlink(dirname(__FILE__)."\\img\\".$image["image_name"].".jpg");
        }
        $delete_record = $pdo->prepare("DELETE FROM items WHERE id = ?");
        $delete_record->execute([$id]);
        header("location: index.php");
      }
      catch(PDOException $e) {
        echo $e->getMessage();
      }


  }
 ?>

<?php
    include_once("../config/connect.php");
    
    if ($_FILES['file']) {
      $file_ary = reArrayFiles($_FILES['file']);

      foreach ($file_ary as $file) {
        $name = uniqid('', true) . '-' .$file['name'];
        $type = $file['type'];
        $size = $file['size'];
        // echo $file['tmp_name'];
        $album_name = $_POST['hidden'];

        $file_destination = '../albumPhotos/'.$name;
        move_uploaded_file($file['tmp_name'],$file_destination);

        $mysql = "INSERT INTO `images`(`album_name`, `image_name`) VALUES (?,?)";
        $query = $pdo->prepare($mysql);
        $query->execute([$album_name,$name]);

        header("Location: ../client/index.php");
      }
    }

    function reArrayFiles(&$file_post) {

        $file_ary = array();
        $file_count = count($file_post['name']);
        $file_keys = array_keys($file_post);

        for ($i=0; $i<$file_count; $i++) {
            foreach ($file_keys as $key) {
                $file_ary[$i][$key] = $file_post[$key][$i];
            }
        }

        return $file_ary;
    }



    // $name = $_POST['hidden'];
    // $file = $_FILES["file"]["name"];
    //
    // $file_destination = '../photos/'.$file;
    // move_uploaded_file($_FILES['file']['tmp_name'],$file_destination);
    //
    // $mysql = "INSERT INTO `images`(`album_name`, `image_name`) VALUES (?,?)";
    // $query = $pdo->prepare($mysql);
    // $query->execute([$name,$file]);
    //
    // header("Location: ../client/index.php");


 ?>

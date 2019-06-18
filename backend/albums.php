<?php
    include_once("../config/connect.php");

    if ($_FILES['file']) {
      $file_ary = reArrayFiles($_FILES['file']);

      $num = 0;
      foreach ($file_ary as $file) {
        $album_name = $_POST['name'];
        $name = uniqid('', true) . '-' .$file['name'];
        $type = $file['type'];
        $size = $file['size'];

        if ($num == 0) {
          $album_name = $_POST['name'];
          $album_description = $_POST['description'];

          $file_destination = '../albumPhotos/'.$name;
          copy($file['tmp_name'],$file_destination);

          $album_file_destination = '../images/'.$name;
          move_uploaded_file($file['tmp_name'],$album_file_destination);

          $mysql = "INSERT INTO `albums`(`name`, `description`,`album_image`) VALUES (?,?,?)";
          $query = $pdo->prepare($mysql);
          $query->execute([$album_name,$album_description,$name]);

          $num = 1;
        }

        $file_destination = '../albumPhotos/'.$name;
        move_uploaded_file($file['tmp_name'],$file_destination);

        $mysql = "INSERT INTO `images`(`album_name`, `image_name`) VALUES (?,?)";
        $query = $pdo->prepare($mysql);
        $query->execute([$_POST['name'],$name]);

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


    // $name = $_POST['name'];
    // $description = $_POST['description'];
    // $file =  uniqid('', true) . '-' .$_FILES["file"]["name"];
    //
    // $file_destination = '../images/'.$file;
    // move_uploaded_file($_FILES['file']['tmp_name'],$file_destination);
    //
    // $mysql = "INSERT INTO `albums`(`name`, `description`,`album_image`) VALUES (?,?,?)";
    // $query = $pdo->prepare($mysql);
    // $query->execute([$name,$description,$file]);
    //
    // header("Location: ../client/index.php");


 ?>

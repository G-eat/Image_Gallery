<?php
 include_once('../config/connect.php');

  $album_name = $_POST['album_name'];
  $mysql = "SELECT * FROM images WHERE album_name = ?";
  $queries = $pdo->prepare($mysql);
  $queries->execute([$album_name]);

  $data = $queries->fetchAll();
  echo json_encode($data);

 ?>

<?php
  include_once("../config/connect.php");

  $id = $_POST['delete'];
  echo $id;

  $mysql = "DELETE FROM `albums` WHERE id = ?";
  $query = $pdo->prepare($mysql);
  $query->execute([$id]);

  header('Location: ../client/index.php?msg=success')

?>

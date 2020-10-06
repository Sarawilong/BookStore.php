<?php
  include 'db_connection.php';
  $dbh = openCon();

  if(isset($_GET['id'])) {
    $stmt = $dbh->prepare("DELETE FROM book WHERE book_id = :book_id");
    $stmt->bindParam(':book_id', $_GET['id'], PDO::PARAM_INT);
    $stmt->execute(); 
    header('Location: /books.php');
}
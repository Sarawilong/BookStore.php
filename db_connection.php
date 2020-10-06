<?php 

function openCon()
{
  /* Connexion à une base MySQL avec l'invocation de pilote */
  $dsn = 'mysql:dbname=bookStore;host=127.0.0.1:3306';
  $user = 'root';
  $password = '';

  try {
    $dbh = new PDO($dsn, $user, $password);
  } catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
  }

  return $dbh;
}

function closeCon($dbh)
{
  $dbh->close();
}

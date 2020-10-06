<h1>Liste des livres</h1>

<table border="1">
  <tr>
    <th>Id</th>
    <th>Titre</th>
    <th>Auteur</th>
    <th></th>
  </tr>

<?php
  /* Connexion à une base MySQL avec l'invocation de pilote */
  $dsn = 'mysql:dbname=bookStore;host=127.0.0.1:3306';
  $user = 'root';
  $password = '';

  try {
    $dbh = new PDO($dsn, $user, $password);
  } catch (PDOException $e) {
    echo 'Connexion échouée : ' . $e->getMessage();
  }

  // Get datas
  $sql =  'SELECT * FROM book ORDER BY title';
  foreach ($dbh->query($sql) as $row) {

?>
  <tr>
    <td><?php echo $row['book_id']; ?></td>
    <td><?php echo $row['title']; ?></td>
    <td><?php 
      $sql =  'SELECT name FROM author WHERE author_id = :author_id';
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(':author_id', $row['author_id'], PDO::PARAM_INT);
      $stmt->execute();

      echo $stmt->fetch()['name']; 
    ?></td>
    <td>
      <a href="delete.php?id=<?php echo $row['book_id']; ?>" 
        style="text-decoration: none">Delete</a>
      <a href="formBook.php?id=<?php echo $row['book_id']; ?>" 
        style="text-decoration: none">Edit</a>
    </td>
<?php } ?>
</table>
<br/><a href="formBook.php" style="text-decoration: none">Ajouter</a>

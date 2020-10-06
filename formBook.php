<?php
include 'db_connection.php';
$dbh = openCon();

if (isset($_GET['id'])) {
  $sql = 'SELECT * FROM book WHERE book_id = :book_id';
  $stmt = $dbh->prepare($sql);
  $stmt->bindParam(':book_id', $_GET['id'], PDO::PARAM_INT);
  $stmt->execute();
  $book = $stmt->fetch();
}

// set errors forms

//if value is set
if (isset($_POST['title']) && isset($_POST['author'])) {  
  $isFormValid = true;
  $errors['title'] = [];

  if (trim($_POST['title']) == "") {
    $isFormValid = false;
    $errors['title'][] = 'Un titre est requis';
  }

  if (is_int($_POST['author'])) {
    $isFormValid = false;
    $errors['author'][] = 'Un auteur est requis';
  }

  if ($isFormValid) {
    if (isset($_GET['id'])) {
      $sql = "UPDATE book SET title = :title, author_id = :author_id WHERE book_id = :book_id";
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
      $stmt->bindParam(':author_id', $_POST['author'], PDO::PARAM_INT);
      $stmt->bindParam(':book_id', $_GET['id'], PDO::PARAM_INT);
      $stmt->execute();
      header('Location: /books.php');
      exit;
    } else {
      $sql = 'INSERT INTO `book` (`title`, `author_id`) VALUES (:title, :author_id);';
      $stmt = $dbh->prepare($sql);
      $stmt->bindParam(':title', $_POST['title'], PDO::PARAM_STR);
      $stmt->bindParam(':author_id', $_POST['author'], PDO::PARAM_INT);
      $stmt->execute();
      header('Location: /books.php');
      exit;
    }
  }
}

?>
<h1>Ajouter un livre</h1>
<form  method="post">
  <label for="title">Titre:</label>
  <input type="text" id="title" name="title" 
    value="<?php 
      if (isset($_GET['id'])) : echo $book['title']; 
      else : echo ($_POST['title']); endif;
    ?>">
  <br>
  <?php
    if (isset($errors['title'])) {
      foreach ($errors['title'] as $msg) {
        echo $msg;
      }
    }
  ?><br/>
  <label for="author">Auteur:</label>
  <select name="author" id="author">
    <option <?php if (!isset($_POST['author'])) : ?>selected<?php endif; ?>>Choisir</option>
    <?php
      $sql = 'SELECT * FROM author ORDER BY name';
      foreach ($dbh->query($sql) as $row):
    ?>
    <option value="
      <?php echo $row['author_id']; ?>" 
      <?php if (isset($_POST['author']) && $_POST['author'] == $row['author_id']) : ?>
        selected
      <?php endif; ?>
      <?php if (isset($_GET['id']) && $book['author_id'] == $row['author_id']) : ?>
        selected
      <?php endif; ?>
    >
      <?php echo $row['name']; ?>
    </option>
    <?php endforeach; ?> <br/>
  </select>
  <br/><?php
    if (isset($errors['author'])) {
      foreach ($errors['author'] as $msg) {
        echo $msg;
      }
    }
  ?> <br/>

<br/><button type="submit" value="Submit">Envoyer</button>
</form> 
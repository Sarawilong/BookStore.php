<?php
include 'db_connection.php';
$dbh = openCon();

$sth = $dbh->prepare('INSERT INTO `contact` (`email`, `message`) VALUES (:email, :message);');
$sth->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
$sth->bindParam(':message', $_POST['message'], PDO::PARAM_STR);
$sth->execute();

?>
<p>Votre message <?php echo $_POST['email'].'à bien été envoyé à'.$_POST['message'];

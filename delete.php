<?php
// DONE -- working
require_once "pdo.php";
session_start();

if ( isset($_POST['cancel']) ){
  header( "Location: index.php" );
  return;
}

if ( isset($_POST['delete']) && isset($_POST['profile_id']) ) {
    $sql = "DELETE FROM profile WHERE profile_id = :prof";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(':prof' => $_POST['profile_id']));
    $_SESSION['success'] = 'Record deleted';
    header( 'Location: index.php' ) ;
    return;
}

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}

$stmt = $pdo->prepare("SELECT profile_id, user_id, first_name, last_name FROM profile where profile_id = :prof");
$stmt->execute(array(":prof" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
}

?>
<html>
  <head>
    <title>Samuel Adams</title>
  </head>
<body>
<p>Confirm: Deleting <?= htmlentities($row['first_name']." ".htmlentities($row['last_name'])) ?></p>
<form method="post">
<input type="hidden" name="profile_id" value="<?= $row['profile_id'] ?>">
<input type="submit" value="Delete" name="delete">
<input type="submit" value="Cancel" name="cancel">
</form>
</body>
</html>

<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['cancel']) ){
  header( 'Location: index.php');
  return;
};

if ( isset($_POST['first_name']) && isset($_POST['last_name']) && isset($_POST['email']) && isset($_POST['headline']) && isset($_POST['summary']) ) {

    // Data validation
    if ( strlen($_POST['first_name']) < 1 || strlen($_POST['last_name']) < 1 || strlen($_POST['email']) < 1 || strlen($_POST['headline']) < 1 || strlen($_POST['summary']) < 1 ) {
        $_SESSION['error'] = 'All fields are required';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    };

    if ( strpos($_POST['email'],'@') === false ) {
        $_SESSION['error'] = 'Email address must contain @';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    };

    // changed for assignment specs
    $sql = 'UPDATE profile SET user_id = :uid, first_name = :fn, last_name = :ln, email = :em, headline = :he, summary = :su WHERE profile_id = :prof';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':prof' => $_GET['profile_id'],
      ':uid' => $_SESSION['user_id'],
      ':fn' => $_POST['first_name'],
      ':ln' => $_POST['last_name'],
      ':em' => $_POST['email'],
      ':he' => $_POST['headline'],
      ':su' => $_POST['summary']
    ));  
    $_SESSION['success'] = 'Record Updated';
    header( 'Location: index.php' ) ;
    return;        
};

// Guardian: Make sure that profile_id is present
if ( ! isset($_GET['profile_id']) ) {
  $_SESSION['error'] = "Missing profile_id";
  header('Location: index.php');
  return;
}
$sql = "SELECT * FROM profile where profile_id = :prof";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":prof" => $_GET['profile_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for profile_id';
    header( 'Location: index.php' ) ;
    return;
};

$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$e = htmlentities($row['email']);
$h = htmlentities($row['headline']);
$s = htmlentities($row['summary']);
$p = $row['profile_id'];
?>

<h1>Edit a Resume</h1>
<?php
// flash error message here
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
};
?>
<form method="post">
<p>First Name:
<input type="text" name="first_name" value='<?= $fn ?>'></p>
<p>Last Name:
<input type="text" name="last_name" value='<?= $ln ?>'></p>
<p>Email:
<input type="text" name="email" value='<?= $e ?>'></p>
<p>Headline:
    <input type="text" name="headline" value='<?= $h ?>'></p>
<p>Summary:
    <input type="text" name="summary" value='<?= $s ?>'></p>
    <input type="hidden" name="profile_id" value='<?= $p ?>'>
<p><input type="submit" value="Update"/>
<input type="submit" name="cancel" value="Cancel"></p>
</form>
<?php
require_once "pdo.php";
session_start();

// TODO: check profile_id in DB; check which tables I need to be querying 

// TODO: UPDATE THESE VALIDATION STEPS
if ( isset($_POST['name']) && isset($_POST['email'])
     && isset($_POST['password']) && isset($_POST['user_id']) ) {

    // Data validation
    if ( strlen($_POST['name']) < 1 || strlen($_POST['password']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }

    if ( strpos($_POST['email'],'@') === false ) {
        $_SESSION['error'] = 'Bad data';
        header("Location: edit.php?profile_id=".$_POST['profile_id']);
        return;
    }

    // changed for assignment specs
    $sql = 'UPDATE profile SET first_name = :first_name, last_name = :last_name, email = :email, headline = :headline, summary = :summary WHERE user_id = :user_id';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':uid' => $_SESSION['user_id'],
      ':fn' => $_POST['first_name'],
      ':ln' => $_POST['last_name'],
      ':em' => $_POST['email'],
      ':he' => $_POST['headline'],
      ':su' => $_POST['summary'])
    );  
    $_SESSION['success'] = 'Record Updated';
    header( 'Location: index.php' ) ;
    return;        
};

// Guardian: Make sure that user_id is present
if ( ! isset($_GET['user_id']) ) {
  $_SESSION['error'] = "Missing user_id";
  header('Location: index.php');
  return;
}
// TODO
$stmt = $pdo->prepare("SELECT * FROM profile where user_id = :xyz");
$stmt->execute(array(":xyz" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
}

// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}

$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$e = htmlentities($row['email']);
$h = htmlentities($row['headline']);
$s = htmlentities($row['summary']);
// Is this necessary ??
$user_id = $row['user_id'];
?>

<h1>Edit a Resume</h1>
<?php
// flash error message here
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
<p><input type="submit" value="Add New"/>
<input type="submit" name="cancel" value="Cancel"></p>
</form>
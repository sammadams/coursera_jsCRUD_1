<?php
require_once "pdo.php";
session_start();

if ( isset($_POST['name']) && isset($_POST['email'])
     && isset($_POST['password'])) {

    // TODO: Data validation should be updated AND happen on the client side
    if ( strlen($_POST['name']) < 1 || strlen($_POST['password']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: add.php");
        return;
    }

    if ( strpos($_POST['email'],'@') === false ) {
        $_SESSION['error'] = 'Bad data';
        header("Location: add.php");
        return;
    }
    // DONE: changed for JS_assignment_1 specs
    $sql = 'INSERT INTO Profile (user_id, first_name, last_name, email, headline, summary) VALUES ( :uid, :fn, :ln, :em, :he, :su)';
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':uid' => $_SESSION['user_id'],
      ':fn' => $_POST['first_name'],
      ':ln' => $_POST['last_name'],
      ':em' => $_POST['email'],
      ':he' => $_POST['headline'],
      ':su' => $_POST['summary'])
    );  
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index.php' ) ;
    return;
}

// Flash error message
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>
<p>Add A New Resume</p>
<form method="post">
<p>First Name:
<input type="text" name="first_name"></p>
<p>Last Name:
<input type="text" name="last_name"></p>
<p>Email:
<input type="text" name="email"></p>
<p>Headline:
    <input type="text" name="headline"></p>
<p>Summary:
    <input type="text" name="summary"></p>
<p><input type="submit" value="Add New"/>
<input type="submit" name="cancel" value="Cancel"></p>
</form>

<?php
require_once "pdo.php";
session_start();

// update validation
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
    <textarea name="summary"></textarea></p>
<p><input type="submit" value="Add New"/>
<input type="submit" name="cancel" value="Cancel"></p>
</form>

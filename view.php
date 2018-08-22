<?php
// FINISHED - I think...
session_start();
require_once("pdo.php");

// process SQL statement
$sql = "SELECT * FROM profile WHERE user_id = :user_id"
$stmt = $pdo->prepare($sql);
$stmt->execute(array(":user_id" => $_GET['user_id']));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if ( $row === false ) {
    $_SESSION['error'] = 'Bad value for user_id';
    header( 'Location: index.php' ) ;
    return;
};
// set page variables
$fn = htmlentities($row['first_name']);
$ln = htmlentities($row['last_name']);
$e = htmlentities($row['email']);
$h = htmlentities($row['headline']);
$s = htmlentities($row['summary']);
// Is this necessary ??
$user_id = $row['user_id'];
?>

<html>
	<head>
		<title>Samuel Adams</title>
	</head>
	<body>
		<div class="container">
			<h1>Profile information</h1>
			<p>First Name: 
				<?= $fn ?></p>
			<p>Last Name: 
				<?= $ln ?></p>
			<p>Email: 
				<?= $e ?> </p>
			<p>Headline:<br/>
				<?= $h ?> </p>
			<p>Summary:<br/>
				<?= $s ?> </p>
			<p><a href="index.php">Done</a></p>
		</div>
	</body>
</html>
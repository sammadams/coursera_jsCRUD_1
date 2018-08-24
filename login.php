<?php

require_once "pdo.php";
session_start();

if ( isset($_POST['cancel']) ){
	header( 'Location: index.php' );
	return;
}

// need validation PHP code
if ( isset($_POST['email']) && isset($_POST['pass']) ){
	$salt = 'XyZzy12*_';
	$check = hash('md5', $salt.$_POST['pass']);
	$sql = "SELECT user_id, name FROM users WHERE email = :em AND password = :pw";
	$stmt = $pdo->prepare($sql);
	$stmt->execute(array( 
		':em' => $_POST['email'], 
		':pw' => $check
	));
	$row = $stmt->fetch(PDO::FETCH_ASSOC);
	if ( $row !== false ) {
	    $_SESSION['name'] = $row['name'];
	    $_SESSION['user_id'] = $row['user_id'];
	    // Redirect the browser to index.php
	    header( 'Location: index.php' );
	    return;
	} else {
		$_SESSION['error'] = "Incorrect information was submitted";
		header( 'Location: login.php' );
		return;
	};
};

?>
<html>
	<head>
		<title>Samuel Adams</title>
	</head>
	<body>
		<h1>Please Log In</h1>
		<?php
			if ( isset($_SESSION['error']) ) {
			    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
			    unset($_SESSION['error']);};
		?>
		<form method="post">
			<p>Email:
				<input type="text" name="email" id="email">
			</p>
			<p>Password:
				<input type="password" name="pass" id="id_1723">	
			</p>
			<input type="submit" value="Log In" onclick="return doValidate();">
			<input type="submit" name="cancel" value="Cancel">
		</form>
	</body>
	<script>
		// add more validation for email address missing
		function doValidate() {
		    console.log('Validating...');
		    try {
		        addr = document.getElementById('email').value;
		        pw = document.getElementById('id_1723').value;
		        console.log("Validating addr="+addr+" pw="+pw);
		        if (addr == null || addr == "" || pw == null || pw == "") {
		            alert("Both fields must be filled out");
		            return false;
		        }
		        if ( addr.indexOf('@') == -1 ) {
		            alert("Invalid email address");
		            return false;
		        }
		        return true;
		    } catch(e) {
		        return false;
		    }
		    return false;
		};
	</script>
</html>
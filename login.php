<?php

session_start();

?>
<html>
	<head>
		<title>Samuel Adams</title>
	</head>
	<body>
		<h1>Please Log In</h1>
		<form action="post">
			<p>Email:
				<input type="text" name="email">
			</p>
			<p>
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
				pw = document.getElementById('id_1723').value;
				console.log("Validating pw="+pw);
				if (pw == null || pw == "") {
					alert("Both fields must be filled out");
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
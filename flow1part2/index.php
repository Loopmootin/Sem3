<?php
	session_start();
	require_once('db_con.php');
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link href="style.css" type="text/css" rel="stylesheet">
	</head>

	<body>
		<div class="container">
		<?php
			require_once('menu.php');
		?>
		
		<?php
			if (filter_input(INPUT_POST, 'create')){
				
				$un = filter_input(INPUT_POST, 'un')
					or die('Missing/illegal username parameter');
				
				$em = filter_input(INPUT_POST, 'em')
					or die('Missing/illegal username parameter');
				
				$pw = filter_input(INPUT_POST, 'pw')
					or die('Missing/illegal password parameter');
				
				$pw = password_hash($pw, PASSWORD_DEFAULT);
				
				
				$sql = 'INSERT INTO profile (email, username, password) VALUES (?,?,?)';
				$stmt = $con->prepare($sql);
				$stmt->bind_param("sss", $em, $un, $pw);
				$stmt->execute();
				
				if($stmt->affected_rows > 0){
					echo '<h2>User '.$un.' created</h2>';
				} else {
					echo '<h2>Could not create user, maybe he is in our system already! Try a diffrent name :-)</h2>';
				}
				
			}
		
		?>
		<div id="overlay">
			<div class="signupBox">
				<div class="header">
					<h1>Signup: </h1>
				</div>
				<button onclick="off()" class="closeButton">X</button>
				<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
				<fieldset>
					<input type="text" name="un" placeholder="Username" class="inputField" required/><br>
					<input type="email" name="em" placeholder="Email" class="inputField" required/><br>
					<input type="password" name="pw" placeholder="Password" class="inputField" required/><br>
					<input type="submit" value="Sign Up" name="create" class="loginButton" />
				</fieldset>
				</form>
			</div>
		</div>
		
		<?php
			if(filter_input(INPUT_POST, 'submit')) {
				
				$em = filter_input(INPUT_POST, 'em', FILTER_VALIDATE_EMAIL)
					or die('Missing/illegal username parameter');
				
				$pw = filter_input(INPUT_POST, 'pw')
					or die('Missing/illegal password parameter');
				
				
				$sql = 'SELECT id, username, password FROM profile WHERE email=?';
				$stmt = $con->prepare($sql);
				$stmt->bind_param('s', $em);
				$stmt->execute();
				$stmt->bind_result($uid, $un, $pwhash);
				
				while($stmt->fetch()){
					
				}
				
				if(password_verify($pw, $pwhash)) {
					echo '<h2 class="loginMessage">Logged in as '.$un.'</h2>';
					$_SESSION['uid'] = $uid;
					$_SESSION['username'] = $un;
				} else {
					echo '<p class="loginMessage">The login has failed try again!</p>';
				}
			}
		?>
		

		<div class="loginBox">
			<div class="header">
				<h1>Login: </h1>
			</div>
			<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
				<fieldset>
					<input type="email" name="em" placeholder="Email" class="inputField" required/><br>
					<input type="password" name="pw" placeholder="Password" class="inputField" required/><br>
					<input type="submit" value="Login" name="submit" class="loginButton"/>
				</fieldset>
			</form>
		</div>
		<button onclick="on()" class="loginButton">SIGN ME UP</button>
		</div>
		<?php
			require_once('footer.php');
		?>
		
		<script>
			function on() {
   				document.getElementById("overlay").style.display = "block";
			}
			function off() {
    			document.getElementById("overlay").style.display = "none";
			}
		</script>
		
	</body>
</html>
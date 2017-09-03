<?php
	session_start();
	require_once('db_con.php');
	
	if(isset($_POST['submit'])){
			header("location:content.php");
	}

?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Login</title>
		<link type="text/css" href="style.css" rel="stylesheet">
	</head>

	<body>
		<?php
			
			if (filter_input(INPUT_POST, 'create')){
				
				$un = filter_input(INPUT_POST, 'un')
					or die('Missing/illegal username parameter');
				
				$pw = filter_input(INPUT_POST, 'pw')
					or die('Missing/illegal password parameter');
				
				$pw = password_hash($pw, PASSWORD_DEFAULT);
				
				
				$sql = 'INSERT INTO users (username, pwhash) VALUES (?, ?)';
				$stmt = $con->prepare($sql);
				$stmt->bind_param("ss", $un, $pw);
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
				<button onclick="off()" class="closeButton">X</button>
				<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
				<fieldset>
					<input type="text" name="un" placeholder="Username" class="inputField" required/><br>
					<input type="password" name="pw" placeholder="Password" class="inputField" required/><br>
					<input type="submit" value="Sign Up" name="create" class="loginButton" onclick="off()" />
				</fieldset>
				</form>
			</div>
		</div>
		
		<?php
			if(filter_input(INPUT_POST, 'submit')) {
				
				$un = filter_input(INPUT_POST, 'un')
					or die('Missing/illegal username parameter');
				
				$pw = filter_input(INPUT_POST, 'pw')
					or die('Missing/illegal password parameter');
				
				
				$sql = 'SELECT id, pwhash FROM users WHERE username=?';
				$stmt = $con->prepare($sql);
				$stmt->bind_param('s', $un);
				$stmt->execute();
				$stmt->bind_result($uid, $pwhash);
				
				while($stmt->fetch()){
					
				}
				
				if(password_verify($pw, $pwhash)) {
					echo 'Logged in as '.$un;
					$_SESSION['uid'] = $uid;
					$_SESSION['username'] = $un;
				} else {
					echo '<p class="failedLogin">The login has failed try again!</p>';
				}
			}
		?>
		
		<div class="loginBox">
			<div class="header">
				<h1>The Rocking</h1>
			</div>
			<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
				<fieldset>
					<input type="text" name="un" placeholder="Username" class="inputField" required/><br>
					<input type="password" name="pw" placeholder="Password" class="inputField" required/><br>
					<input type="submit" value="Login" name="submit" class="loginButton"/>
				</fieldset>
			</form>
			<a class="register" onclick="on()">Register</a>
		</div>
		
		<div class="infoBox">
			<p>Hello guys! I've made a rocking page for you, all you have to do to see the amazing content, is to register down below! If you're already
			registrated just login :-)</p>
		</div>
		
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
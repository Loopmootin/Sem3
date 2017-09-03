<?php
	session_start();
?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Get Rocked</title>
		<link rel="stylesheet" href="style.css" type="text/css">
	</head>

	<body>
		
		<?php
			if(empty($_SESSION['uid'])) {
				echo 'Need to log in to see the secrets...';
				echo '<div class="hiddenCandy">
					 <h1>Why you not logged in?!</h1>
					 <a href="login.php" class="logoutButton">Back to Login</a>
					 </div>';
			} else {
				echo 'Welcome '.$_SESSION['username'].'<br>The answer is Legend27';
				echo '<div class="hiddenCandy">
						<h1>THE ROCK BBY!</h1>
						<img src="theRockImg.jpeg" class="theRockImg">
						<img src="theRockImg2.jpg" class="theRockImg">
						<a href="logout.php" class="logoutButton">Logout</a>
					</div>';
			}
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
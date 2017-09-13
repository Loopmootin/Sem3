<?php
	session_start();
	require_once('db_con.php');
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Your Memes</title>
		<link href="style.css" type="text/css" rel="stylesheet">
	</head>

	<body>
		<div class="container">
		<?php
			require_once('menu.php');
		?>
		<?php
			if(empty($_SESSION['uid'])) {
				echo 'Need to log in to see the secrets...';
				echo '<div class="hiddenCandy">
					 <h1>Why you not logged in?!</h1>
					 </div>';
			} else {
				echo '<div class="hiddenCandy">
						<h2>Upload some good shiz!</h2>
						<div class="uploadBox">
							<div class="header">
								<h1>Upload: </h1>
							</div>
							<form action="upload.php" method="post" enctype="multipart/form-data">
								<input type="text" name="title" placeholder="Image title" class="inputField" required />
								<input type="file" name="fileToUpload" id="fileToUpload" class="inputField" /><br>
								<input type="submit" value="Upload Image" name="submit" class="loginButton" />
							</form>
						</div>
					</div>';
			}
		?>
		</div>
		<?php
			require_once('footer.php')
		?>
	</body>
</html>
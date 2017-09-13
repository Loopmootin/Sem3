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
		
			$uid = $_SESSION['uid'];
		
		if (filter_input(INPUT_POST, 'update')){

					$un = filter_input(INPUT_POST, 'un')
						or die('Missing/illegal username parameter');

					$em = filter_input(INPUT_POST, 'em')
						or die('Missing/illegal username parameter');

					$pw = filter_input(INPUT_POST, 'pw')
						or die('Missing/illegal password parameter');

					$pw = password_hash($pw, PASSWORD_DEFAULT);


					$sql = 'UPDATE profile SET email = ?, username = ?, password = ? WHERE id = ?';
					$stmt = $con->prepare($sql);
					$stmt->bind_param("sssi", $em, $un, $pw, $uid);
					$stmt->execute();

					if($stmt->affected_rows > 0){
						echo '<h2>User '.$un.' updated</h2>';
					} else {
						echo '<h2>Could not update user, maybe he is in our system already! Try a diffrent name :-)</h2>';
					}

				}
		
		if(filter_input(INPUT_POST, 'delete')){
			
			$nid = filter_input(INPUT_POST, 'id')
					or die('Missing/illegal id parameter');
			
			$nurl = filter_input(INPUT_POST, 'url')
					or die('Missing/illegal id parameter');
			
			$nurl0 = substr($nurl, 0, -1);
			
			$sql = 'DELETE FROM comments WHERE imageid = ?';
			$stmt = $con->prepare($sql);
			$stmt->bind_param('i', $nid);
			$stmt->execute();
			
			$sql = 'DELETE FROM image WHERE id = ?';
			$stmt = $con->prepare($sql);
			$stmt->bind_param('i', $nid);
			$stmt->execute();
			

			if($stmt->affected_rows > 0){
				echo '<h2>Deleted image number'.$nid.'</h2>';
				unlink($nurl0);
			} else {
				echo '<h2>Could not delete image</h2>';
			}
			
		}
		
		
			if(empty($_SESSION['uid'])) {
				echo 'Need to log in to see the secrets...';
				echo '<div class="hiddenCandy">
					 <h1>Why you not logged in?!</h1>
					 </div>';
			} else {
				echo '<div class="hiddenCandy">
						<h2 class="loginMessage">These are all your uploads!</h2>
					</div>';?>
					<div id="overlay">
						<div class="signupBox">
							<div class="header">
								<h1>Update: </h1>
							</div>
							<button onclick="off()" class="closeButton">X</button>
							<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
							<fieldset>
								<input type="text" name="un" placeholder="Username" class="inputField" required/><br>
								<input type="email" name="em" placeholder="Email" class="inputField" required/><br>
								<input type="password" name="pw" placeholder="Password" class="inputField" required/><br>
								<input type="submit" value="Update" name="update" class="loginButton" />
							</fieldset>
							</form>
						</div>
					</div>
					<button onclick="on()" class="loginButton profileButton">Update Profile</button>
					<?php
						$sql = 'SELECT image.id, image.title, image.url, image.profileid FROM image, profile 
								WHERE image.profileid = profile.id AND profile.id ='.$uid.' ORDER BY creationdate DESC';
						$stmt = $con->prepare($sql);
						$stmt->bind_result($id, $title, $url, $pid);
						$stmt->execute();
				
						while($stmt->fetch()){?>
							<a href="image.php?pictureid=<?=$id?>" class="uploadedImgLink">
								<div class="uploadedImg">
									<h2><?=$title?></h2>
									<img src="<?=$url?>" width="400px" />
									</a>
									<hr>
									<form action="<?= $_SERVER['PHP_SELF'] ?>" method="post">
										<input type="hidden" name="id" value=<?=$id?>/>
										<input type="hidden" name="url" value=<?=$url?>/>
										<button type="submit" value="delete" name="delete" class="loginButton">Delete</button>
									</form>
								</div>
					<?php }?>
					
				
			<?php }?>
			<div class="padbund"></div>
		</div>
			<?php
				require_once('footer.php')
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
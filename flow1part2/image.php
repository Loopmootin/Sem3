<?php
	session_start();
	require_once('db_con.php');
	$uid = $_SESSION['uid'];
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Image</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>

	<body>
		<div class="container">
		<?php
			require_once('menu.php');
		?>
		
		<?php
				if (filter_input(INPUT_POST, 'submit')){
				
				$text = filter_input(INPUT_POST, 'comment')
					or die('Missing/illegal comment parameter');
					
				$pid = filter_input(INPUT_POST, 'imgid')
					or die('Missing/illegal imageid parameter');
			
				
				$sql = 'INSERT INTO comments (comment, profileid, imageid) VALUES (?, ?, ?)';
				$stmt = $con->prepare($sql);
				$stmt->bind_param("sii", $text, $uid, $pid);
				$stmt->execute();
				
				if($stmt->affected_rows > 0){
					echo '<h2>Comment created</h2>';
				} else {
					echo '<h2>Could not create comment! Try again :-)</h2>';
				}
				
			}
		?>
			
		<?php
			$pid = filter_input(INPUT_GET,'pictureid');
		
			$sql = 'SELECT title, url FROM image WHERE id = ?';
					$stmt = $con->prepare($sql);
					$stmt->bind_param('i', $pid);
					$stmt->execute();
					$stmt->bind_result($title, $url);
		
			while($stmt->fetch()){ ?>
				<div class="uploadedImg big">
					<h2><?=$title?></h2>
					<img src="<?=$url?>" width="600px" />
				</div>
			<?php } ?>
			
			<?php
			$sql = 'SELECT profile.username, comments.comment FROM profile, comments, image WHERE comments.profileid = profile.id AND comments.imageid = image.id AND image.id = ?';
					$stmt = $con->prepare($sql);
					$stmt->bind_param('i', $pid);
					$stmt->execute();
					$stmt->bind_result($user, $comment);
		
			while($stmt->fetch()){ ?>
				<div class="uploadedImg">
					<h3><?=$user?></h3>
					<p><?=$comment?></p>
				</div>
			<?php } ?>
			
			<form action="<?= $_SERVER['PHP_SELF'.'?pictureid='.$pid] ?>" method="post">
				<input type="hidden" name="imgid" value="<?=$pid?>">
				<textarea name="comment" value="comment" placeholder="Enter text here..." required></textarea>
				<button type="submit" value="submit" name="submit" class="loginButton">Submit</button>
			</form>
			
			<div class="padbund"></div>
		</div>
			<?php
			require_once('footer.php');
			?>
	</body>
</html>
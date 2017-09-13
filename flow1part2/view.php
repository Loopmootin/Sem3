<?php
	session_start();
	require_once('db_con.php');
?>
<!doctype html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Memes</title>
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
						<h2>Watch all the good stuff!</h2>
					</div>';?>
					
					<?php
					$sql = 'SELECT id, title, url FROM image ORDER BY creationdate DESC';
					$stmt = $con->prepare($sql);
					$stmt->execute();
					$stmt->bind_result($id, $title, $url);

					while($stmt->fetch()){?>
						<a href="image.php?pictureid=<?=$id?>" class="uploadedImgLink">
							<div class="uploadedImg">
								<h2><?=$title?></h2>
								<img src="<?=$url?>" width="400px" />
							</div>
						</a>
					<?php }?>
					
				
			<?php }?>
			<div class="padbund"></div>
		</div>
			<?php
				require_once('footer.php')
			?>
	</body>
</html>
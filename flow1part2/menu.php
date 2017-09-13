
		<?php
			session_start();
			$fn = basename($_SERVER['PHP_SELF']);
			$un = $_SESSION['username'];
		?>
		
		<div class="menu">
			<div class="menuItem">
				<a class="menuLink<?= ($fn=='uploadMeme.php')?' selected':''?>" href="uploadMeme.php">Upload Memes</a>
			</div>
			<div class="menuItem">
				<a class="menuLink<?= ($fn=='view.php')?' selected':''?>" href="view.php">View All Memes</a>
			</div>
			<div class="menuItem">
				<a class="menuLink<?= ($fn=='yourProfile.php')?' selected':''?>" href="yourProfile.php">View Your Profile</a>
			</div>
			<div class="menuItem">
				<?php if(empty($_SESSION['uid'])) { ?>
					<a class="menuLink<?= ($fn=='index.php')?' selected':''?>" href="index.php">Login</a>
				<?php } else { ?>
					<a class="menuLink<?= ($fn=='logout.php')?' selected':''?>" href="logout.php">Logout</a>
				<?php } ?>
			</div>
			<?php
				if(isset($un)){
					echo '<p>You\'re logged in as: '.$un.'</p>';
				}
			?>
		</div>
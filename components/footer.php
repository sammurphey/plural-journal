</main>
<footer id="footer">
	<nav>
		<ul>
			<li><a href="<?php echo $htp_root; ?>"><img src="<?php echo $htp_root; ?>src/icons/home.svg" class="icon bg1_icons"></a></li>
			<li><a href="<?php echo $htp_root; ?>notifications"><img src="<?php echo $htp_root; ?>src/icons/notifications.svg" class="icon bg1_icons"></a></li>
			<li><a href="<?php echo $htp_root; ?>system"><img src="<?php echo $htp_root; ?>src/icons/people.svg" class="icon bg1_icons"></a></li>
			<li><a href="<?php echo $htp_root; ?>folders"><img src="<?php echo $htp_root; ?>src/icons/folder.svg" class="icon bg1_icons"></a></li>
		</ul>
	</nav>
</footer>
<?php
	if ($fonts) {
?>
	<link href="https://fonts.googleapis.com/css?family=<?php echo $fonts; ?>" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
<?php
	}
?>
<link href="<?php echo $htp_root; ?>src/css/App.css" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
<noscript>
	<?php
		if ($fonts) {
			echo "<link href='https://fonts.googleapis.com/css?family=" . $fonts . "' rel='stylesheet' media='all'>";
		}
	?>
	<link href="<?php echo $htp_root; ?>src/css/App.css" rel="stylesheet" media="all">
</noscript>

<!-- fab button -->
<?php
	if ($page_id == "homepage") {
		echo "<button class='fab secondary_colors border_color'><a href='" . $htp_root . "new'><img src='" . $htp_root . "src/icons/edit.svg' class='icon secondary_icons'></a></button>";
	} elseif ($page_id == "post") {
		echo "<button class='fab secondary_colors border_color'><a href='#'><img src='" . $htp_root . "src/icons/style.svg' class='icon secondary_icons'></a></button>";
	}
?>
</body>
</html>

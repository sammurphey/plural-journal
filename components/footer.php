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
	$fab_url = false;
	$fab_icon = false;
	switch($page_id) {
		case "dashboard":
			$fab_url = $htp_root . "post/new";
			$fab_icon = "edit";
		break;
		case "post":
			$fab_icon = "style";
		break;
	}
	if ($fab_icon) {
		echo "<button class='fab primary_colors border_color'>";
		if ($fab_url) {echo "<a href='" . $fab_url . "'>";}
		echo "<img src='" . $htp_root . "src/icons/" . $fab_icon .".svg' class='icon primary_icons'>";
		if ($fab_url) {echo "</a>";}
		echo "</button>";
	}
?>
</body>
</html>

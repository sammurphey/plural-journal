<footer id="footer">


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
<button class="fab secondary_colors border_color"><a href="<?php echo $htp_root; ?>new"><img src="<?php echo $htp_root; ?>src/icons/add.svg" class="icon secondary_icons"></a></button>
</body>
</html>

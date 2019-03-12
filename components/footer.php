<footer id="footer">


</footer>

<link href="<?php echo $htp_root; ?>src/css/App.css" rel="stylesheet" media="none" onload="if(media!='all')media='all'">
<noscript>
	<?php
	if ($fonts) {
		echo "<link href='https://fonts.googleapis.com/css?family=" . $fonts . "' rel='stylesheet' media='all'>";
	}
	?>
	<link href="<?php echo $htp_root; ?>src/css/App.css" rel="stylesheet" media="all">
</noscript>
</body>
</html>

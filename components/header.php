<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<!-- document setup -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, minimum-scale=1, initial-scale=1">

	<!-- proper meta -->
	<title><?php echo $document_title; ?></title>
	<meta name="author" content="<?php echo $document_author; ?>">
	<meta name="robots" content="<?php echo $robots_txt; ?>">
	<meta name="version" content="<?php echo $document_version; ?>">
	<meta name="creation_date" content="<?php echo $creation_date; ?>">

	<!-- lang & alternates -->
	<meta name="language" content="<?php echo $lang; ?>">
	<link rel="alternate" href="<?php echo $document_url; ?>" hreflang="x-default">
	<link rel="alternate" href="<?php echo $document_url; ?>" hreflang="en">
	<link rel="cannonical" href="<?php echo $document_url; ?>">

    <!--favicon-->



    <!--critical styles-->
	<style>
		<?php echo file_get_contents($htp_root . "src/css/critical.css"); ?>
	</style>

</head>
<body>

	<header>
		<?php 
			if ($current_path !== "" && $current_path !== "/") {
				echo "<a id='go_back_btn' href='" . $htp_root . "'><button><</button></a>";
			}
		?>
		<a id="app_title" href="<?php echo $htp_root; ?>"><span>Dream Journal</span></a>
	</header>
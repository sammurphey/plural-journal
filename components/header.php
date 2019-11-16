<!DOCTYPE html>

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>

	<!-- document setup -->
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, user-scalable=1, initial-scale=1">

	<!-- proper meta -->
	<title><?php echo $document_title; ?></title>
	<meta name="author" content="<?php echo $document_author; ?>">
	<meta name="robots" content="<?php echo $robots_txt; ?>">
	<meta name="version" content="<?php echo $document_version; ?>">
	<meta name="creation_date" content="<?php echo $last_updated; ?>">

	<!-- lang & alternates -->
	<meta name="language" content="<?php echo $document_lang; ?>">
	<link rel="alternate" href="<?php echo $document_url; ?>" hreflang="x-default">
	<link rel="alternate" href="<?php echo $document_url; ?>" hreflang="en">
	<link rel="cannonical" href="<?php echo $document_url; ?>">

	<!--favicon-->
	<link rel="apple-touch-icon" sizes="120x120" href="<?php echo $htp_root; ?>apple-touch-icon.png?v=7k4Kkddea4">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php echo $htp_root; ?>favicon-32x32.png?v=7k4Kkddea4">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php echo $htp_root; ?>favicon-16x16.png?v=7k4Kkddea4">
	<link rel="mask-icon" href="<?php echo $htp_root; ?>safari-pinned-tab.svg?v=7k4Kkddea4" color="#5bbad5">
	<link rel="shortcut icon" href="<?php echo $htp_root; ?>favicon.ico?v=7k4Kkddea4">
	<meta name="apple-mobile-web-app-title" content="Plural Journal">
	<meta name="application-name" content="Plural Journal">
	<meta name="msapplication-TileColor" content="#603cba">
	<meta name="theme-color" content="#ffffff">

	<!--critical styles-->
	<style>
		<?php echo file_get_contents($htp_root . "src/css/critical.css"); ?>
	</style>	
</head>
<body class="bg1">

	<header class="app_header secondary_colors border_color drop_shadow">
		<?php
			echo "<label for='menu_checkbox' id='menu_btn' class='header_btn left'>";
				echo "<img src='" . $htp_root . "src/icons/menu.svg' class='icon secondary_icons'>";
			echo "</label>";
			echo "<span id='app_title' class='title secondary_text'>Plural Journal</span>";

			if ($current_path == "" || $current_path !== "/") { 
				echo "<button id='search_btn' class='header_btn right'>";
				if (!$post_data) {
					echo "<a href='" . $htp_root . "search'>";
				}
				echo "<img src='" . $htp_root . "src/icons/search.svg' class='icon secondary_icons'>";
				if (!$post_data) {
					echo "</a>";
				}
				echo "</button>";
			} else {

			}
			require_once($php_root . "components/menu.php");
		?>
	</header>
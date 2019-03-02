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
	<link rel="icon" href="favicon.png" type="image/x-icon"/>


    <!--critical styles-->
	<style>
		<?php echo file_get_contents($htp_root . "src/css/critical.css"); ?>
	</style>	
</head>
<body>

	<header>
		<?php
			echo "<label for='menu_checkbox' id='menu_btn' class='header_btn left'>";
				echo "<img src='" . $htp_root . "src/icons/baseline-menu-24px-white.svg' class='icon'>";
			echo "</label>";
			echo "<a id='app_title' class='title' href='" . $htp_root . "'><span>Dream Journal</span></a>";

			if ($current_path == "" || $current_path !== "/") { 
				echo "<button id='search_btn' class='header_btn right'><a href='" . $htp_root . "search'><img src='" . $htp_root . "src/icons/baseline-search-24px-white.svg' class='icon'></a></button>";
			} else {

			}
		?>
		<input id="menu_checkbox" name="menu_checkbox" class="checkbox_hack" type="checkbox">
		<div id="menu">
			<header class="menu_header">
				<label for='menu_checkbox' id='close_menu_btn' class='header_btn left'>
					<img src="<?php echo $htp_root; ?>src/icons/baseline-close-24px-white.svg" class="icon">
				</label>
				<p  class="title"><span>Menu</span></p>
			</header>
			<nav>
				<ul>
					<li>Item 1</li>
					<li>Item 2</li>
					<li>Item 3</li>
					<li>Item 4</li>
					<li>Item 5</li>
					<li>Item 6</li>
				</ul>
			</nav>
		</div>
	</header>
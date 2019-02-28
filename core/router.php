<?php
jsLogs("routing...");
switch($current_path) {
	case "":
	case "/":
		require_once($php_root . "views/dashboard.php");
		break;
	case "logout":
		require_once($php_root . "views/logout.php");
		break;
	case "new":
		require_once($php_root . "views/new.php");
		break;
	case "early-access":
		break;
	case "donate":
		break;
	default:
	require_once($php_root . "views/404.php");
}

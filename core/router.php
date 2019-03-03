<?php
jsLogs("routing...");
$route = true;
switch($current_path) {
	case "":
	case "/":
		require_once($php_root . "views/dashboard.php");
		break;
	case "logout":
	case "logout/":
		require_once($php_root . "views/logout.php");
		break;
	case "new":
	case "new/":
		require_once($php_root . "views/new.php");
		break;
	default:
		$cur_paths = explode("/", $current_path);
		if (count($cur_paths) >= 2) {
			$get_post = xhrFetch("?action=get_post&system=" . $cur_paths[0] . "&user=" . $cur_paths[1] . "&post=" . $cur_paths[2]);
			if (valExists("success", $get_post)) {
				$post_data = json_decode($get_post["data"], true);
				require_once($php_root . "views/post.php");
			} else {
				$route = false;
			}
		} else {
			$route = false;
		}
}

// fallback
if (!$route) {
	require_once($php_root . "views/404.php");
}
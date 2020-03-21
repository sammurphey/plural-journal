<?php
jsLogs("routing...");
$route = false;
$current_paths = explode("/", $current_path);

switch($current_paths[0]) {
	case "":
		$route = true;
		$document_title = "Dashboard";
		$page_id = "homepage";
		require_once($php_root . "views/dashboard.php");
		break;
	case "new":
		$route = true;
		$document_title = "New";
		$page_id = "new";
		require_once($php_root . "views/new.php");
	break;
	case "logout":
		$route = true;
		$page_id = "logout";
		require_once($php_root . "views/logout.php");
		break;
	case "folder":
		if (count($current_paths) > 1) {
			$route = true;
			$document_title = ucSmart($current_paths[1]);
			$folder_slug = $current_paths[1];
			$page_id = "folder";
			require_once($php_root . "views/folder.php");
		}
		break;
	case "switch":
		$route = true;
		$document_title = "Switch User";
		$page_id = "switch";
		require_once($php_root . "views/switch.php");
		break;
	default:
		if (count($current_paths) > 2) {
			$get_post = xhrFetch("?action=get_post&system=" . $current_paths[0] . "&user=" . $current_paths[1] . "&post=" . $current_paths[2]);
			if (valExists("success", $get_post)) {
				$route = true;
				$page_id = "post";
				$post_data = json_decode($get_post["data"], true);
				$document_title = $post_data["title"];
				require_once($php_root . "views/post.php");
			}
		}
	break;
}

// fallback
if (!$route) {
	$document_title = "404 - Not Found";
	require_once($php_root . "views/404.php");
}
<?php

$folder_xhr = xhrFetch("?action=get_folder&slug=" . $folder_slug);
if (valExists("success", $folder_xhr)) {
	$folder_data = json_decode($folder_xhr["data"], true);
} else {
	require_once($php_root . "views/404.php");
	die();
}

require_once($php_root . "components/header.php");

//$posts_xhr = xhrFetch("?action=return_overviews&user=" . $user_name . "&folder=" . $folder_data["slug"]);

// end
require_once($php_root . "components/footer.php");
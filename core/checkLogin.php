<?php

jsLogs("checking login...");
if ($user_name && $user_token) {
	jsLogs("has cookies");
	$verification = xhrFetch("?action=verify_token&user=" . $user_name . "&token=" . $user_token);
	if (valExists("success", $verification)) {
		$current_user_data = json_decode($verification["user_data"], true);
		jsLogs("token verified");
		require_once($php_root . "core/router.php");
	} else {
		jsLogs("bad token");
		require_once($php_root . "views/login.php");
	}
} else {
	jsLogs("no cookies");
	require_once($php_root . "views/login.php");
}

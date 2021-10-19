<?php
$isLoggedIn = false;
jsLogs("checking login...");
if ($user_name && $user_token) {
	jsLogs("has cookies");
	$verification = xhrFetch("?action=verify_token&user=" . $user_name . "&token=" . $user_token);
	if (valExists("success", $verification)) {
		$current_user_data = json_decode($verification["data"], true);
		$isLoggedIn = true;
		jsLogs("token verified");

		$sysdata = xhrFetch("?action=get_system_data&id=" . $current_user_data["system"]);
		if (valExists("success", $sysdata)) {
			$current_system_data = json_decode($sysdata["data"], true);
		}

		require_once($php_root . "core/router.php");
				
	} else {
		jsLogs("bad token");
		require_once($php_root . "views/login.php");
	}
} else {
	jsLogs("no cookies");
	require_once($php_root . "views/login.php");
}

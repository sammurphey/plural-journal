<?php

require_once($php_root . "components/header.php");

$system_data = false;
$system_xhr = xhrFetch("?action=get_system_data&system_name=" . $current_user_data["system"]);
if (valExists("success", $system_xhr)) {
	$system_data = json_decode($system_xhr["data"], true);
}
include_once($php_root . "components/switch_user.php");

echo "<button type='button'>Manage System</button> | <button type='button'>Logout</button>";

// end
require_once($php_root . "components/footer.php");
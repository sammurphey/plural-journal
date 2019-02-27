<?php

$isLoggedIn = false;
$login_msg = false;


// If currently attempting login
if (empty($_REQUEST) === false) {
    jsLogs("checking login credentials");
    
    // Sanitize provided data
	$username_input = addslashes($_REQUEST["username"]);
	$password_input = addslashes($_REQUEST["password"]);
    jsLogs("un: " . $username_input);
	jsLogs("pw: " . $password_input);
    
    // Send attempt to api
    $attempt_url = "?action=login&username=" . $username_input . "&password=" . $password_input;
	$attempt = xhrFetch($attempt_url);
    

    // API Success (the field to check here will differ on ur own api)
    if ($attempt["success"] !== false) {
        jsLogs("correct username + password");
        $isLoggedIn = true;
        
        // Save token, again this field might be called something else
		$returnedToken = $attempt["data"];
        jsLogs($returnedToken);
        
        // Commit results to cookies
		setcookie("user_name", $username_input, time() + (86400 * 30), "/");
		setcookie("user_token", $returnedToken, time() + (86400 * 30), "/");
        
        // And finally route to the next page
        require_once($php_root . "core/router.php");        
	} else {
		$login_msg = "Incorrect username or password.";
		jsLogs("Incorrect username or password.");
    }
    // Not logged in
}elseif (!$isLoggedIn) {
	jsLogs("requires login");
    require_once($php_root . "components/header.php");
    
	echo "<h1>Login</h1>";
	if ($login_msg) {
		echo "<p class='error_msg'>" . $login_msg . "</p>";
	}
	echo "<form action='" . $htp_root . "' method='POST'>";
		echo newFormField("username", "Username");
		echo newFormField("password", "Password", "password");
		echo newFormField("login", "Login", "submit", "Login");
	echo "</form>";
	require_once($php_root . "components/footer.php");
}

<?php

// Enable Error Reporting
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);


// Functions
// val checkr
function valExists($key, $arr) {
	if (is_array($arr)) {
		if (array_key_exists($key, $arr) && $arr[$key]) {
			return true;
		}
		return false;
	}
	return false;
}


// Database connect
$host = "68.66.224.29";
$db = "dreamjournal";
$user = "sammurph_dj";
$pass = "55K3YtjqXU922d5";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("<p>Failed to connect to MySQL: " . $conn->connect_error . "</p>");
}


// Check for query
if (empty($_REQUEST) === false) {

	// Collect the requests
	$data = [];
	foreach ($_REQUEST as $req) {
		$data[] = $req;
	}
	
	// Sanitize
	foreach($data as $item) {
		$item = addslashes($item);
	}

	// Prepare to build sql query
	$sql = false;
	$sql_sel = "SELECT * FROM ";
	$sql_whr = false;
	$sql_ord = false;
	$output = [];

	// Carry out ACTIONS
	if (valExists("action", $data)) {
		switch($data["action"]) {
			
			// Login ACTION
			case "login": {
				if (valExists("username", $data) && valExists("password", $data)) {
					
					// Lookup DB data for provided username
					$sql = $sql_sel . "`users` WHERE `username`='" . $data["username"] . "'";
					$rows = array();
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							$rows[] = $row;
						}
					}
					if (count($rows) == 1) {
						$rows = $rows[0];
					}
					$res = json_encode($rows);

					// Prepare PW hash to match against
					$pass_hash = hash('sha256', $data["password"] . $rows["salt"]);

					//	Verify password in exchange for token
					if ($pass_hash == $rows["password"]) {
						$output["success"] = true;
						$output["message"] = "correct username and password combo";
						//make this hash something else 4 production lol
						$output["data"] = hash('sha256', $rows["token"] . $rows["salt"]);
					} else {
						$output["success"] = false;
						$output["message"] = "Bad credentials.";
					}
				} else {
					$output["success"] = false;
					$output["message"] = "Username and password required.";
				}
				break;
			}

			// Verify Token ACTION
			case "verify_token": {
				if (valExists("token", $data) && valExists("username", $data)) {

					// Lookup DB data for provided username
					$sql = $sql_sel . "`users` WHERE `username`='" . $data["username"] . "'";
					$rows = array();
					$result = $conn->query($sql);
					if ($result->num_rows > 0) {
						while($row = $result->fetch_assoc()) {
							$rows[] = $row;
						}
					}
					if (count($rows) == 1) {
						$rows = $rows[0];
					}
					$res = json_encode($rows);

					// Prepare token to match against
					$gen_token = hash('sha256', $rows["token"] . $rows["salt"]);
					
					//Verify token 
					if ($data["token"] == $gen_token) {
						$output["success"] = true;
						$output["message"] = "Token verified.";
						$output["data"] = $res;
					} else {
						$output["success"] = false;
						$output["message"] = "Token missmatch! Invalid session should be deleted.";
					}
				} else {
					$output["success"] = false;
					$output["message"] = "Username and token required.";
				}
				break;
			}

			// Invalid ACTION
			default: {
				$output["success"] = false;
				$output["message"] = "Invalid or restricted action.";
			}
		}

	} else {
		// no ACTION
		$output["success"] = false;
		$output["message"] = "Please provide an action.";
	}
} else { 
	// empty REQUEST
	$output["success"] = false;
	$output["message"] = "Please provide a query and action.";
}


// Format and print
$output = json_encode($output);
echo $output;
die();
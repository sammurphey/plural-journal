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
$db = "sammurph_dreamjournal";
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
	if (isset($_REQUEST["action"])) {
		$data["action"] = $_REQUEST["action"];
	}
	if (isset($_REQUEST["id"])) {
		$data["id"] = $_REQUEST["id"];
	}
	if (isset($_REQUEST["user"])) {
		$data["user"] = $_REQUEST["user"];
	}
	if (isset($_REQUEST["email"])) {
		$data["email"] = $_REQUEST["email"];
	}
	if (isset($_REQUEST["password"])) {
		$data["password"] = $_REQUEST["password"];
	}
	if (isset($_REQUEST["token"])) {
		$data["token"] = $_REQUEST["token"];
	}
	if (isset($_REQUEST["title"])) {
		$data["title"] = $_REQUEST["title"];
	}
	if (isset($_REQUEST["date"])) {
		$data["date"] = $_REQUEST["date"];
	}
	if (isset($_REQUEST["text"])) {
		$data["text"] = $_REQUEST["text"];
	}
	
	// Sanitize
	foreach($data as $item) {
		$item = addslashes($item);
	}

	// Prepare to build sql query
	$sql = false;
	$sql_sel = "SELECT * FROM ";
	$sql_ins = "INSERT INTO ";
	$sql_vals = "VALUES (";
	$sql_whr = false;
	$sql_ord = false;
	$output = [];

	// Carry out ACTIONS
	if (valExists("action", $data)) {
		switch($data["action"]) {
			
			// Login ACTION
			case "login": {
				if (valExists("email", $data) && valExists("password", $data)) {
					
					// Lookup DB data for provided email
					$sql = $sql_sel . "`users` WHERE `email`='" . $data["email"] . "'";
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
						$output["message"] = "correct email and password combo";
						$output["id"] = $rows["id"];
						//make this hash something else 4 production lol
						$output["token"] = hash('sha256', $rows["token"] . $rows["salt"]);
					} else {
						$output["success"] = false;
						$output["message"] = "Bad credentials.";
					}
				} else {
					$output["success"] = false;
					$output["message"] = "Email and password required.";
				}
				break;
			}

			// Verify Token ACTION
			case "verify_token": {
				if (valExists("token", $data) && valExists("id", $data)) {

					// Lookup DB data for provided id
					$sql = $sql_sel . "`users` WHERE `id`='" . $data["id"] . "'";
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
					} else {
						$output["success"] = false;
						$output["message"] = "Token missmatch! Invalid session should be deleted.";
					}
				} else {
					$output["success"] = false;
					$output["message"] = "ID and token required.";
				}
				break;
			}

			// Save Dream ACTION
			case "save_new_dream": {

				// Check login status
				if (valExists("user", $data)) {
					$sql_ins .= "`dreams` (title, date, user";
					if (valExists("title", $data)) {
						$sql_vals .= "'" . $data["title"] . "'";
					} else {
						$sql_vals .= "'Untitled'";
					}
					if (valExists("date", $data)) {
						$sql_vals .= ", '" . $data["date"] . "'";
					} else {
						$sql_vals .= ", '" . date("Y-m-d h:m:s") . "'";
					}

					$sql_vals .= ", '" . $data["user"] . "'";

					if (valExists("text", $data)) {
						$sql_ins .= ", short_desc, text) ";
						$sql_vals .= ", '" . $data["text"] . "', '" . $data["text"] . "')";
					} else {
						$sql_ins .= ") ";
						$sql_vals .= ")";
					}

					$sql = $sql_ins . $sql_vals;
					if ($conn->query($sql)) {
						$output["success"] = true;
						$output["message"] = "Dream saved";	
					} else {
						$output["success"] = false;
						$output["message"] = "Query failed: " . $sql;
					}
				} else {
					$output["success"] = false;
					$output["message"] = "Must be logged in to perform this action.";
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
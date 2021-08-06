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
$host = "localhost";
$db = "plural_journal";
$user = "root";
$pass = "password";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("<p>Failed to connect to MySQL: " . $conn->connect_error . "</p>");
}


// Check for query
if (empty($_REQUEST) === false) {

	// Collect the requests
	$valid_requests = [
		"action",
		"date",
		"email",
		"id",
		"order",
		"password",
		"post",
		"slug",
		"system",
		"system_name",
		"title",
		"text",
		"token",
		"user"
	];
	$data = [];
	foreach ($valid_requests as $valid_request) {
		if (isset($_REQUEST[$valid_request])) {
			$data[$valid_request] = $_REQUEST[$valid_request];
		}
	}
	
	// Sanitize the data
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
				if (valExists("password", $data)) {
					
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
						$output["username"] = $rows["username"];
						//make this hash something else 4 production lol
						$output["token"] = hash('sha256', $rows["token"] . $rows["salt"]);
						$output["user_data"] = $res;
					} else {
						$output["success"] = false;
						$output["message"] = "Bad credentials. Entered: " . $pass_hash . ", Needed: " . $rows["password"];
					}
				} else {
					$output["success"] = false;
					$output["message"] = "Email and password required.";
				}
				break;
			}

			// Verify Token ACTION
			case "verify_token": {
				if (valExists("token", $data) && valExists("user", $data)) {

					// Lookup DB data for provided username
					$sql = $sql_sel . "`users` WHERE `username`='" . $data["user"] . "'";
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
						$output["user_data"] = $res;
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
			case "save_new_post": {

				// Check login status
				if (valExists("user", $data)) {
					$sql_ins .= "`posts` (title, date, user";
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
						$output["message"] = "Post saved";	
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
			case "return_overviews": {
				if (valExists("user", $data)) {
					if (valExists("order", $data)) {
						$sql_ord = " ORDER BY " . $data["order"];
					} else {
						$sql_ord = " ORDER BY `date` DESC";
					}
					$sql = $sql_sel . "`posts` WHERE `user`='" . $data["user"] . "'" . $sql_ord;
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
					if ($res) {
						$output["success"] = true;
						$output["data"] = $res;
					} else {
						$output["success"] = false;
						$output["data"] = "This user has not made any posts.";
					}
				} else {
					$output["success"] = false;
					$output["message"] = "Missing value for 'user', whose overviews are we returning?";
				}
				break;
			}
			case "return_folders": {
				if (valExists("user", $data)) {
					if (valExists("order", $data)) {
						$sql_ord = " ORDER BY " . $data["order"];
					} else {
						$sql_ord = " ORDER BY `id` DESC";
					}
					$sql = $sql_sel . "`folders` WHERE `user`='" . $data["user"] . "'" . $sql_ord;
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
					if ($res) {
						$output["success"] = true;
						$output["data"] = $res;
					} else {
						$output["success"] = false;
						$output["data"] = "This user has not made any folders.";
					}
				} else {
					$output["success"] = false;
					$output["message"] = "Missing value for 'user', whose folders are we returning?";
				}
				break;
			}
			case "get_post": {
				if (valExists("system", $data) && valExists("user", $data) && valExists("post", $data)) {
					$sql = $sql_sel . "`posts` WHERE (`system`='" . $data["system"] . "') AND (`user`='" . $data["user"] . "') AND (`post_slug`='" . $data["post"] . "')";
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
					if ($res) {
						$output["success"] = true;
						$output["data"] = $res;
					} else {
						$output["success"] = false;
						$output["data"] = "No posts found with the given info.";
					}
				} else {
					$output["success"] = false;
					$output["message"] = "Getting a post requires a system name, a user name, and the slug hash.";
				}
				break;
			}
			case "get_folder": {
				if (valExists("slug", $data)) {
					$sql = $sql_sel . "`folders` WHERE (`slug`='" . $data["slug"] . "')";
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
					if ($res) {
						$output["success"] = true;
						$output["data"] = $res;
					} else {
						$output["success"] = false;
						$output["data"] = "No folder found with this slug.";
					}
				} else {
					$output["success"] = false;
					$output["message"] = "Retrieving a folder requires a slug.";
				}
				break;
			}
			case "get_system_data": {
				if (valExists("system_name", $data)) {
					$sql = $sql_sel . "`systems` WHERE (`name`='" . $data["system_name"] . "')";
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
					if ($res) {
						$output["success"] = true;
						$output["data"] = $res;
					} else {
						$output["success"] = false;
						$output["data"] = "No system found with this name.";
					}
				} else {
					$output["success"] = false;
					$output["message"] = "Retrieving a system requires a system name.";
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
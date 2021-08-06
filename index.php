<?php
// Enable Error Reporting
ini_set("display_errors", 1);
ini_set("display_startup_errors", 1);
error_reporting(E_ALL);

// Init variables
$php_root = $_SERVER['DOCUMENT_ROOT'] . "/plural-journal/";
$htp_root = "http://localhost/plural-journal/";

// Defaults
$document_title = "Plural Journal";
$document_author = "WeirdoOnTheBus System";
$robots_txt = "NOINDEX NOFOLLOW";
$document_version = 2.0;
$last_updated = "2021-08-05";
$document_lang = "EN";
$document_url = $htp_root;
$favicon = $htp_root . "favicon.ico";
$fonts = "Ubuntu";

// Functions
require_once($php_root . "core/functions.php");
jsLogs("hello world");

// Find where we are
require_once($php_root . "core/headers.php");

// Verify user
require_once($php_root . "core/checkLogin.php");
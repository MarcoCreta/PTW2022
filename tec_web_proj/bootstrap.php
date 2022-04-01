<?php
define('SITE_NAME', 'learny');

//App Root
define('APP_ROOT', dirname(__FILE__));
define('URL_ROOT', '/');
define('URL_SUBFOLDER', '');
define("RESOURCE_DIR", "./resources/");

//DB Params
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'test_language_refactor');


session_start();
require_once("utils/functions.php");
require_once("db/database.php");
$dbh = new DatabaseHelper(DB_HOST, DB_USER, DB_PASS, DB_NAME);

?>
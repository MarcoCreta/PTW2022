<?php
require_once("bootstrap.php");
setcookie ('PHPSESSID', "", time() - 3600, '/');
session_unset();
session_destroy();
header("location:login.php");
?>
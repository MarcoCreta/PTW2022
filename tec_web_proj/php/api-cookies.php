<?php
require_once("../bootstrap.php");
require_once("../db/database.php");

session_start();

if(isset($_POST["action"])) {

    if ($_POST["action"] == "switchMode"){
            setcookie("mode", $_POST["mode"], time() + (86400 * 365), '/tec_web_proj');
    }
}

?>
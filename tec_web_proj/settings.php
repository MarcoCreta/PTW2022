<?php

require_once("bootstrap.php");


if(isUserLoggedIn()){
    $templateParams["titolo"] = "Learny - Settings";
    $templateParams["nome"] = "settings-form.php";
    $templateParams["js"] = array("js/settingsUtils.js");
}
else{
    header("location:login.php");
}

require_once('template/base.php');

?>
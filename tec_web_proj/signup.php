<?php
require_once("bootstrap.php");


if(isUserLoggedIn()){
    header('location:home.php');
}
else{
    $templateParams["js"] = array("js/jquery-3.4.1.min.js","js/signupUtils.js");
    $templateParams["titolo"] = "Learny - Sign up";
    $templateParams["components"] = array("template/signup-form.php");
}

require_once 'template/base.php';
?>



<?php
require_once("bootstrap.php");

session_start();



if(isset($_POST["l-username"]) && isset($_POST["l-password"])){
    $login_result = $dbh->checkLogin($_POST["l-username"], $_POST["l-password"]);

    if($login_result){
        registerLoggedUser($_POST["l-username"], $dbh);
    }
    else{
        $templateParams["loginError"] = "Errore! Controllare username o password!";
    }
}


if(isUserLoggedIn()){
    header("location:home.php");
}
else{
    $templateParams["titolo"] = "Learny - Login";
    $templateParams["components"] = array("template/login-form.php");
}

require 'template/base.php';

?>

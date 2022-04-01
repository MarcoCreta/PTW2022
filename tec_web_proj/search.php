<?php

require_once("bootstrap.php");

if(isUserLoggedIn()){
    $templateParams["users"] = $dbh->getUsersListWithFriends($_SESSION['username']);
    $templateParams["js"] = array("js/jquery-3.4.1.min.js","js/searchUtils.js");
    $templateParams["titolo"] = "Learny - Search";
    $templateParams["components"] = array("template/generic-container.php");

    $templateParams['container'] = array(
        array('title' => 'Cerca utenti : ', 'element' => 'template/search-user.php')
    );
}
else{
    header('location:signup.php');
}

require_once 'template/base.php';

?>
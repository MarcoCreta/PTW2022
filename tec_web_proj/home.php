<?php

require_once("bootstrap.php");

if(isUserLoggedIn()){
    $templateParams["js"] = array("js/postUtils.js","js/searchUtils.js","js/homeUtils.js","js/shopUtils.js");
    $templateParams["titolo"] = "Learny - Home";
    $templateParams['profile_username'] = $_SESSION['username'];
    $templateParams['profile_ID'] = $_SESSION['ID_profile'];
    $templateParams['posts'] = $dbh->getPostsByUserAndFriends($_SESSION['username']);

    $templateParams["components"] = array("template/post-model.php", "template/post.php");

}
else{
    $templateParams["js"] = array("js/signupUtils.js");
    $templateParams["titolo"] = "Learny - Sign up";
    $templateParams["nome"] = "signup.php";
}

require_once 'template/base.php';

?>
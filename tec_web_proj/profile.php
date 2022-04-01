<?php

require_once("bootstrap.php");

if(isUserLoggedIn()){

    if(isset($_GET["user"])){
        if($_GET["user"] == $_SESSION["username"]){
            $templateParams["js"] = array("js/postUtils.js");
            $templateParams["titolo"] = "Learny - my profile";
            $templateParams['profile_username'] = $_SESSION['username'];
            $templateParams['profile_ID'] = $_SESSION['ID_profile'];
            $templateParams['posts'] = $dbh->getProfilePostsFromUser($_SESSION['username']);
            $templateParams["components"] = array("template/post-model.php", "template/post.php");
        }
        else{

            $user = $dbh->checkUsernamePresence($_GET["user"]);
            if(isset($user['presence'])){
                $templateParams["js"] = array("js/postUtils.js");
                $templateParams["titolo"] = "Learny - ". $_GET["user"]. " profile";
                $templateParams['profile_username'] = $_GET['user'];
                $profile = $dbh->getProfile($_GET['user']);
                $friendship = $dbh->areUsersFriends($_SESSION['username'], $_GET['user']);
                if(isset($friendship['friendship'])){
                    $templateParams['profile_ID'] = $profile['ID_profile'];
                    $templateParams['posts'] = $dbh->getProfilePostsFromUser($_GET['user']);
                    $templateParams["components"] = array("template/post-model.php", "template/post.php");
                } else {
                    if($profile['private']){

                    } else {
                    $templateParams['profile_ID'] = $profile['ID_profile'];
                    $templateParams['posts'] = $dbh->getProfilePostsFromUser($_GET['user']);
                    $templateParams["components"] = array("template/post.php");       
                    }
                }

                if($profile['private']){
                    $templateParams['alert']['title'] = 'Profilo privato';
                    $templateParams['alert']['content'] = 'Non puoi visualizzare questo profilo';
                    $templateParams["components"] = array("template/alert.php");
                }
            } else {
                header("location:404.php");
            }
        }
    }
}
else{
    $templateParams["js"] = array("js/signupUtils.js");
    $templateParams["titolo"] = "Learny - Sign up";
    $templateParams["nome"] = "signup.php";
}

require 'template/base.php';

?>
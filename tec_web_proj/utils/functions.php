<?php

session_start();

function isActive($pagename){
    if(basename($_SERVER['PHP_SELF'])==$pagename){
        echo " active ";
    }
}

function isUserLoggedIn(){
    return !empty($_SESSION['username']);
}

function registerLoggedUser($username, $dbh){
    
    $result = $dbh->getProfile($username);

    if(!isset($result)){
        return false;
    } else {
        $_SESSION["username"] = $username;
        $_SESSION["ID_profile"] = $result['ID_profile'];
        $result = $dbh->getTeacherInfo($_SESSION["username"]);
        if(isset($result)){
            $_SESSION['teacher'] = $result['CF'];
        }
        return true;
    }
}

?>

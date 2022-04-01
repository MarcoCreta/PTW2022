<?php
require_once("../bootstrap.php");
require_once("../db/database.php");

if (isset($_GET['action'])) {
    if ($_GET["action"] == "getUsers"){
        $templateParams['users'] = $dbh->getUsersListWithFriends($_GET['username']);
        require 'search-user.php';
    }
} elseif(isset($_POST["action"])) {

    if ($_POST["action"] == "addFriendship"){
        $response =  json_encode($dbh->addFriendship(
            $_SESSION["username"],
            $_POST["friendship"]["user_2"],
            date("y-m-d")
        ));

    if($response){
        $email = $dbh->getUserEmail($_POST["friendship"]["user_2"]);
        if($email){
            $to = $email;
            $subject = "Nuova amicizia";
            $txt = "Tu e ". $_SESSION["username"] . " ora siete amici!";
            $headers = "From: learny@help.com" . "\r\n";

            $send = mail($to,$subject,$txt,$headers);
        }
    }

        echo $response ? json_encode(array("result" => true)) : json_encode(array("result" => false));

    } elseif ($_POST["action"] == "deleteFriendship") {
        $response =  json_encode($dbh->deleteFriendship(
            $_SESSION["username"],
            $_POST["friendship"]["user_2"]
        ));

        echo $response ? json_encode(array("result" => true)) : json_encode(array("result" => false));
    }
}

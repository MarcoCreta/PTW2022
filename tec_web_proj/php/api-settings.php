<?php
require_once("../bootstrap.php");
require_once("../db/database.php");

if(isset($_GET['action'])){
    if($_GET["action"]=="getTeacherInfo"){
        $response = $dbh->getTeacherInfo($_SESSION['username']);
        if(!isset($response)){
            echo json_encode(array('result' => false));
        } else {
            echo json_encode(array("result" => true ,'teacher' => $response));
        }
    } else if($_GET["action"]=="getPrivacySettings"){
        $response = $dbh->getPrivacySettings($_SESSION['ID_profile']);
        if(!isset($response)){
            echo json_encode(array('result' => false));
        } else {
            echo json_encode(array("result" => true ,'settings' => $response));
        }
    }
} elseif(isset($_POST['action'])){
    if($_POST["action"]=="updateTeacher"){
        $response = $dbh->updateTeacher(
            $_SESSION['username'],
            $_POST['teacher']['name'],
            $_POST['teacher']['surname'],
            $_POST['teacher']['bday'],
            $_POST['teacher']['CF']);

        echo $response ? json_encode(array("result" => true)) : json_encode(array("result" => false));

    } else if($_POST["action"]=="updatePrivacy"){
        $response = $dbh->updatePrivacySettings(
            $_SESSION['ID_profile'],
            $_POST['settings']['private']);

        echo $response ? json_encode(array("result" => true)) : json_encode(array("result" => false));

    }
}

?>


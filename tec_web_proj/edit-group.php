<?php

require_once("bootstrap.php");
require_once('php/api-teacher.php');

if(isUserLoggedIn()){
    if($_SESSION['teacher']){

        if(isset($_GET['ID_group'])){
            $templateParams["titolo"] = "Learny - Teacher Area";
            $templateParams["group"] = $dbh->getGroup($_GET['ID_group']);
            $templateParams["users"] = $dbh->getCollaborators($_GET['ID_group']);
            $templateParams["left-components"] = array("template/teacher/edit-group-info.php", "template/teacher/teachers.php");
    
            $templateParams['teachings'] = $dbh->getGroupTeachings($_GET['ID_group']);
            $templateParams["components"] = array("template/teacher/teachings.php");
    
            $templateParams["js"] = array("js/teacherUtils.js");
        } else {
            header("location:teacher-area.php");
        }
    } else {
        header("location:settings.php");
    }
}
else{
    header("location:login.php");
}

require_once('template/base.php');

?>

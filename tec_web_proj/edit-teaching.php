<?php

require_once("bootstrap.php");
require_once(APP_ROOT . '/php/api-teacher.php');

if(isUserLoggedIn()){
    if($_SESSION['teacher']){
        if(isset($_GET['ID_group'])){
            $result = $dbh->checkCollaboration($_SESSION['teacher'],$_GET['ID_group']);
            if(isset($result['group']) && isset($result['collaboration'])){ // group and collabrotation exists
                if(isset($_GET['ID_content'])){ //edit existing teaching
                    $result = $dbh->checkTeaching($_GET['ID_content'],$_GET['ID_group']);
                    if(isset($result['teaching']) && isset($result['group'])){ //teaching exist and is owned by group
                        $templateParams['categories'] = $dbh->getCategories();
                        $templateParams['teaching'] = $dbh->getTeaching($_GET['ID_content']);
                        $templateParams["titolo"] = "Learny - Edit teaching";
                        $templateParams["left-components"] = array("template/teacher/edit-teaching-settings.php");
                        $templateParams["components"] = array(
                            "template/teacher/edit-teaching-info.php",
                            "template/teacher/edit-".$templateParams['teaching']['type'].".php");
                        $templateParams["js"] = array("js/teacherUtils.js","js/editTeachingUtils.js");
                    } elseif(isset($result['teaching']) && !isset($result['group'])){ //teaching exist but isn't owned by group
                        $templateParams['alert']['type'] = 'error';
                        $templateParams['alert']['title'] = 'Permission denied';
                        $templateParams['alert']['content'] = 'you cant edit this content';
                        header("location:teacher-area.php");
                    } elseif(!isset($result['teaching'])){ //teaching does not exist
                        $templateParams['alert']['type'] = 'error';
                        $templateParams['alert']['title'] = 'Resource not found';
                        $templateParams['alert']['content'] = 'the teaching does not exists';
                        header("location:teacher-area.php");
                    }
                } else { //create new teaching
                    $templateParams['categories'] = $dbh->getCategories();
                    $templateParams["titolo"] = "Learny - New teaching";
                    $templateParams["left-components"] = array("template/teacher/edit-teaching-settings.php");
                    $templateParams["components"] = array("template/teacher/edit-teaching-info.php");
                    $templateParams["js"] = array("js/teacherUtils.js","js/editTeachingUtils.js");
                }

            } elseif (isset($result['group']) && !isset($result['collaboration'])) { // do not collaborate witht the group
                $templateParams['alert']['type'] = 'error';
                $templateParams['alert']['title'] = 'Permission denied';
                $templateParams['alert']['content'] = 'you do not collaborate with this group';
                header("location:teacher-area.php");
            } elseif (!isset($result['group'])) { // group does not exist
                $templateParams['alert']['type'] = 'error';
                $templateParams['alert']['title'] = 'Resource not found';
                $templateParams['alert']['content'] = 'the group does not exists';
                header("location:teacher-area.php");
                
            }

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
/*
<?php

require_once("bootstrap.php");
require_once(APP_ROOT . '/php/api-teacher.php');

if(isUserLoggedIn()){
    if($_SESSION['teacher']){
        if(isset($_GET['ID_group'])){
            $result = $dbh->checkCollaboration($_SESSION['teacher'],$_GET['ID_group']);
            if(isset($result['group'])){    //group esists
                if(isset($result['collaboration'])){    //user collaborate with the group
                    if(isset($_GET['teaching'])){
                        $result = $dbh->checkTeaching($_GET['teaching'],$_GET['ID_group']);
                        if(isset($result['teaching'])){ //teaching exist
                            if(isset($result['group'])){    //teaching is owned by the group
                                
                            } else {    //teaching is not owned by the group
                                $templateParams['alert']['title'] = 'Permission denied';
                                $templateParams['alert']['content'] = 'you cannot edit this teaching';
                            }

                        } else { //teaching does not exist
                            $templateParams['alert']['title'] = 'Resource not found';
                            $templateParams['alert']['content'] = 'the teaching does not exist';
                        }
                    } else { //create new teaching

                    }

                    $templateParams["titolo"] = "Learny - Teaching";

                    $templateParams["left-components"] = array("template/teacher/teachers.php");
            
                    $templateParams['teachings'] = $dbh->getGroupTeachings($_GET['ID_group']);

                    $templateParams["components"] = array("template/teacher/teachings.php");
            
                    $templateParams["js"] = array("js/teacherUtils.js");
                } else {
                    $templateParams['alert']['title'] = 'Permission denied';
                    $templateParams['alert']['content'] = 'you do not collaborate with this group';
                    header("location:teacher-area.php");
                }
            } else {
                $templateParams['alert']['title'] = 'Resource not found';
                $templateParams['alert']['content'] = 'the group does not exists';
                header("location:teacher-area.php");
            }

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

 */
?>


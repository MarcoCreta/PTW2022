<?php

require_once("bootstrap.php");
require_once(APP_ROOT . '/php/api-teacher.php');

if(isUserLoggedIn()){
    if($_SESSION['teacher']){
        $templateParams['side-nav'] = array(
            array('name' => 'groups', 'icon' =>'' , 'element' => '?tab=groups'),
            array('name' => 'teachings', 'icon' =>'' , 'element' => '?tab=teachings'),
            array('name' => 'coachings', 'icon' =>'' , 'element' => '?tab=coachings')
        );

        $templateParams["titolo"] = "Learny - Teacher Area";
        $templateParams["left-components"] = array("template/side-nav.php");

        $templateParams["js"] = array("js/sideNavUtils.js","js/teacherUtils.js");

    } else {
        header("location:settings.php");
    }
}
else{
    header("location:login.php");
}

require_once('template/base.php');

?>
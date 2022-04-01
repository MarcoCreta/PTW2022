<?php
require_once("../bootstrap.php");
require_once("../db/database.php");

session_start();

if(isset($_GET['action'])) {
    if($_GET["action"] == "getTeachings"){
        if(isset($_GET['category'])){
            echo json_encode(array($_GET['category'] => $dbh->getTeachingsByCategory($_GET['category'])));
        } else {
            $templateParams['teachings'] = $dbh->getTeachings();
            require '../template/shop-category.php';
        }
    }

} elseif(isset($_POST['action'])) {

    if($_POST["action"] == "") {
    }
}

?>
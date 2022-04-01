<?php

require_once("bootstrap.php");

if(isset($_GET["category"])){
    $templateParams["titolo"] = "Learny - ". $_GET["category"];
    $templateParams["js"] = array("js/shopUtils.js");
    $templateParams['categories'] = $dbh->getCategories();
    if(isset($_SESSION['username'])){
        $templateParams['teachings'] = array($_GET["category"] => $dbh->getTeachingsByCategory($_GET["category"],$_SESSION['username']));
    } else {
        $templateParams['teachings'] = array($_GET["category"] => $dbh->getTeachingsByCategory($_GET["category"]));
    }
    $templateParams["components"] = array("template/shop-category.php");
} else {
    $templateParams["titolo"] = "Learny - shop";
    $templateParams["js"] = array("js/shopUtils.js");
    $templateParams['categories'] = $dbh->getCategories();
    if(isset($_SESSION['username'])){
        $templateParams['teachings'] = $dbh->getTeachings($_SESSION['username']);
    } else {
        $templateParams['teachings'] = $dbh->getTeachings();
    }
    $templateParams["components"] = array("template/shop-category.php");
}

require 'template/base.php';
?>
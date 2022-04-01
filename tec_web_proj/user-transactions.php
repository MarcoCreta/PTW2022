
<?php

require_once("bootstrap.php");


if(isUserLoggedIn()){
    $templateParams["titolo"] = "Learny - Transazioni";

    $templateParams['purchase'] = $dbh->getTransactions($_SESSION['username']);
    $templateParams["components"] = array("template/trs.php");
    
}
else{
    header("location:login.php");
}

require_once('template/base.php');

?>
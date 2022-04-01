<?php
require_once("bootstrap.php");

if(isUserLoggedIn()){
    header("location:home.php");
}
else{
    header("location:welcome.php");
}

?>
<?php
require_once("../bootstrap.php");
require_once("../db/database.php");

if(isset($_POST['action'])){
    if($_POST["action"]=='signup'){
        if(isset($_POST["r-username"]) && isset($_POST["r-email"]) && isset($_POST["r1-password"])){
            if(checkSignupParams($dbh,$_POST["r-username"], $_POST["r-email"], $_POST["r1-password"], $_POST["r2-password"])){
                $signup_result = $dbh->registerUser($_POST["r-username"], $_POST["r-email"], $_POST["r1-password"]);
                if($signup_result==false){
                    //Registrazione fallita
                    echo $result ? json_encode(array("result" => true)) : json_encode(array("result" => false, "message" => "registrazione fallita"));
                } else {
                    $login_result = $dbh->checkLogin($_POST["r-username"], $_POST["r1-password"]);
                    if(!isset($login_result)){
                        //Login fallito
                        echo $result ? json_encode(array("result" => true)) : json_encode(array("result" => false, "message" => "login fallito"));
                    } else{
                        $result = registerLoggedUser($_POST["r-username"], $dbh);
                        echo $result ? json_encode(array("result" => true)) : json_encode(array("result" => false, "message" => "Si è verificato un errore"));
                    }
                }
            } else {
            }
        }
    }


    if($_POST["action"]=='checkUsername'  && isset($_POST['username'])){
        $result = $dbh->checkUsernamePresence($_POST['username']);
        echo isset($result['presence']) ? json_encode(array("result" => true)) : json_encode(array("result" => false));
    }

    if($_POST["action"] == 'checkEmail'  && isset($_POST['email'])){
        $result = $dbh->checkEmailPresence($_POST['email']);
        echo isset($result['presence']) ? json_encode(array("result" => true)) : json_encode(array("result" => false));
    }
}

function checkSignupParams($dbh, $username, $email, $password1, $password2){
    if (!preg_match('/^[A-Za-z0-9_]+$/',$username)){
        return false;
    } elseif (isset($dbh->checkUsernamePresence($username)['presence'])){
        return false;
    } elseif (!preg_match('/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/',$email)){
        return false;
    } elseif (isset($dbh->checkEmailPresence($email)['presence'])){
        return false;
    } elseif (!preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{5,10}$/',$password1)){
        return false;
    } elseif (!strcmp($password1,$password2) == 0){
        return false;
    } else {
        return true;
    }
}

?>


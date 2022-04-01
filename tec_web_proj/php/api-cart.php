<?php
require_once("../bootstrap.php");
require_once("../db/database.php");

session_start();

if(isset($_POST['action'])){
    if($_POST["action"] == "addToCart" && isset($_POST["productID"])){
        if(isset($_COOKIE['cart'])){
            //add presence control in dataset
            if(!empty($_COOKIE['cart'])){
                $cookie_data = stripslashes($_COOKIE['cart']);
                $cart_data = json_decode($cookie_data, true);
                if(!in_array($_POST["productID"],$cart_data)) {
                    array_push($cart_data, $_POST["productID"]);
                    setcookie("cart", json_encode($cart_data), time() + (86400 * 365), '/tec_web_proj');
                }
            } else{
                $_COOKIE['cart'] = json_encode(array($_POST["productID"]));
            }
        
        } else {
            setcookie("cart", json_encode(array($_POST["productID"])), time() + (86400 * 365), '/tec_web_proj');
        }
    }
    //to collapse together
    elseif($_POST["action"] == "removeFromCart" && isset($_POST["productID"])){
        if(isset($_COOKIE['cart'])){
            //add presence control in dataset
            if(!empty($_COOKIE['cart'])){
                $cookie_data = stripslashes($_COOKIE['cart']);
                $cart_data = json_decode($cookie_data,true);
                if(in_array($_POST["productID"],$cart_data)) {
                    if(count($cart_data) == 1){
                        setcookie('cart', null, -1, '/tec_web_proj'); 
                    } else {
                        unset($cart_data[array_search($_POST["productID"],$cart_data)]);
                        setcookie("cart", json_encode($cart_data), time() + (86400 * 365), '/tec_web_proj');
                    }
                }
            }
        }
        echo json_encode(array("result"=>true));

    } elseif($_POST["action"] == "placeOrder"){
        //TODO : GET ITEMS FROM POST, NOT FROM CART
        $cookie_data = stripslashes($_COOKIE['cart']);
        $cart_items = json_decode($cookie_data, true);

        if(count($cart_items) == 0){
            $info = array("msg" => "your cannot make an empty order");
            json_encode(array("result" => false, "info" => $info));
            return;
        }

        $cart_data = $dbh->getCartProducts($cart_items);
        if(count($cart_items) == count($cart_data)){

            $purchased_items = $dbh->checkProducts($_SESSION['username'], array_column($cart_data, 'ID_content'));
            if(count($purchased_items) > 0){
                $result = false;
                $info = array("msg" => "you have already bought these items", "items" => array_column($purchased_items, 'name'));
            } else {
                $amount = array_sum(array_column($cart_data, 'price'));
                $ID_transaction = $dbh->createTransaction($_SESSION["username"], $amount, 0, date("y-m-d"), date("H:i:s"));
                if(isset($ID_transaction)){
                    $result = true;
                    foreach($cart_data as $k => $item){
                        $dbh->insertPurchase($ID_transaction, $item['ID_content'], $item['price']);
                    }
                }
                //empty cart
                setcookie('cart', null, -1, '/tec_web_proj');

                if(isset($ID_transaction)){
                    $email = $dbh->getUserEmail($_SESSION['username']);
                    if($email){
                        $to = $email;
                        $subject = "Aggiornamento stato d'ordine";
                        $txt = "Il tuo ordine n°" . $ID_transaction . " è andato a buon fine";;
                        $headers = "From: learny@help.com" . "\r\n";
            
                        $send = mail($to,$subject,$txt,$headers);
                    }
                }
            }
            echo $result ? json_encode(array("result" => true)) : json_encode(array("result" => false, "info" => $info));
        } 
    } else {
        echo json_encode(array("result"=>false));
    }
    
} else if(isset($_GET['action'])){
    if($_GET["action"] == "getCart"){
        $cookie_data = stripslashes($_COOKIE['cart']);
        $cart_data = json_decode($cookie_data, true);
        echo json_encode(array("products"=>$cart_data));
    } else if ($_GET["action"] == "getCartProducts") {
        if(count($_GET["products"]) > 0){
            echo json_encode($dbh->getCartProducts($_GET["products"]));
        }
    }
}


?>



<?php

require_once("bootstrap.php");


if(isUserLoggedIn()){
    $templateParams["titolo"] = "Learny - cart";

    
    if(isset($_COOKIE['cart']) && !empty($_COOKIE['cart'])){
        $templateParams['cart']['products'] = $dbh->getCartProducts(json_decode(stripslashes($_COOKIE['cart']), true));
    } else {
        $templateParams['cart']['products'] = array();
    }

    $templateParams['side-nav'] = array(
        array('name' => 'le mie transazioni', 'icon' =>'' , 'element' => 'user-transactions.php'),
        array('name' => 'shop', 'icon' =>'' , 'element' => 'shop.php'),
    );
    $templateParams["left-components"] = array("template/side-nav.php");
    
    $templateParams["right-components"] = array("template/cart-details.php");
    $templateParams["components"] = array("template/cart-products.php");
    $templateParams["js"] = array("js/cartUtils.js");
    
}
else{
    header("location:login.php");
}

require_once('template/base.php');

?>
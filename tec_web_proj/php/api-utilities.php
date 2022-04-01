<?php 
include_once("../db/database.php");
include_once("../bootstrap.php");

if(isset($_GET['action'])){
    if($_GET['action']=='getUserSuggestions'){
        if($_GET['target']=='similar'){
            $result = $dbh->getSuggestedUsersFromFriends($_SESSION['username']);
            $templateParams['container'] = array();
            if(isset($result)){
                $templateParams["users"] = $result;
                $templateParams['container'] = array(
                    array('title' => 'Persone che potresti conoscere', 'element' => 'template/search-user.php')
                );

            }
        } elseif ($_GET['target']=='interests'){
            $result = $dbh->getSuggestedUsersFromPurchases($_SESSION['username']);
            if(isset($result)){
                $templateParams["users"] = $result;
                $templateParams['container'] = array(
                    array('title' => 'Persone simili a te', 'element' => 'template/search-user.php')
                );
            }
        }
        require APP_ROOT . "/template/generic-container.php";
    } elseif ($_GET['action']=='getProductSuggestions'){
        if($_GET['target']=='interests'){
            $result = $dbh->getSuggestedProductsFromPurchases($_SESSION['username']);
            $templateParams['container'] = array();
            
            if(isset($result)){
                $templateParams["products"] = $result;
                $templateParams['container'] = array(
                    array('title' => 'Prodotti che potrebbero interessarti', 'element' => 'template/shop-product.php')
                );

            }
            
        }
        require APP_ROOT . "/template/generic-container.php";
    }
}

?>


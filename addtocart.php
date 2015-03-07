<?php

session_start();
$prod_name = $_GET['prod_name'];
$quantity = $_GET['quantity'];

require_once('FirePHPCore/FirePHP.class.php');

include_once('products.php');

//TODO: remove this before submitting
// For debug
if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);

}
$nameout = $products['$'.$prod_name]['name'];

//TODO Now that I've changed the GET to store the product name and quantity, feeding the function the argument of the
// object no longer works.

function add_to_cart($prod_name){
   echo $nameout;
    //$nameout = $products['$'.$prod_name]['name'];



   echo $nameout;
}

add_to_cart($_GET['prod_name']);

$firephp->log($_SESSION, 'session');
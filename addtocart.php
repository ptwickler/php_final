<?php

//session_start();
$prod_name = $_GET['prod_name'];
$quantity = $_GET['quantity'];

require_once('FirePHPCore/FirePHP.class.php');

if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);

}
//TODO Now that I've changed the GET to store the product name and quantity, feeding the function the argument of the
// object no longer works.

function add_to_cart($prod_name){

    print_r($prod_name);
    exit;
}

add_to_cart($_SESSION['cart']);

$firephp->log($_SESSION, 'session');
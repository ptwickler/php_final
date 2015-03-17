<?php


ini_set('display_errors', 1);

error_reporting(E_ALL);


if (isset($_GET['out']) && $_GET['out']==1){
    session_start();

    // I'll be honest. I had to poach the code in this if statement. I couldn't get the session ID to regenerate any
    // other way. It would wipe out the data in the session, but it wouldn't renew the session ID. I was having some
    // other problems and wanted to get this piece nailed down before I went on to look for another cause.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }
// END POACHED CODE

    // Finally, destroy the session.
    session_destroy();

    //Add in a page reload so that the session_destroy() will take effect*/

        $url = "http://" . $_SERVER['HTTP_HOST'] . "/php_final/index.php";

        header("Location: ".$url) or die("Didn't work");
}

if(!isset($_SESSION)) {
    session_start();
}

ob_start();
require_once('FirePHPCore/FirePHP.class.php');
require_once('functions.php');



if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);

}


$_SESSION['cart'] = array();
// I use includes to build the head and end of the html page


if(isset($_SESSION['out_cart'])) {
    $item = $_SESSION['out_cart'];
}

include_once($_SERVER['DOCUMENT_ROOT'] ."/php_final/template_top.inc");


//TODO Add an else statement that displays the empty cart window if no items in cart yet
include_once($_SERVER['DOCUMENT_ROOT'] . "/php_final/products.php");

// This array stores the machine names of the products. It needs to be appended if you want to add another
// product to the store. The products.php file must also be appended to contain the new item's properties.
$current_products = array('amethyst','quartzorb','wizard','catseye','dragon');



$disp = '';
for ($i =0; $i < count($current_products); $i++){
    echo display($current_products[$i],$products);
}

if (isset($_SESSION['sign_in']) && $_SESSION['sign_in']== 1){
    echo "LOGGED IN";

}

if (!isset($_SESSION['sign_in']) || $_SESSION['sign_in'] !=1) {

    echo "Not Logged in";
}

require($_SERVER['DOCUMENT_ROOT'] ."/php_final/template_bottom.inc");

$firephp->log($_SESSION, 'session');
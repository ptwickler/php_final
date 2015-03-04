<?php
ini_set('display_errors', 1);

error_reporting(E_ALL);
if (isset($_GET['out'])){
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

        $url = "http://" . $_SERVER['HTTP_HOST'] . "/php_final/index.php?GOOP=1";

        header("Location: ".$url) or die("Didn't work");
}

if(!isset($_SESSION)) {
    session_start();
}

ob_start();
require_once('FirePHPCore/FirePHP.class.php');



if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);

}


$_SESSION['cart'] = array();
// I use includes to build the head and end of the html page
require($_SERVER['DOCUMENT_ROOT'] ."/php_final/template_top.inc");
/*echo' <!DOCTYPE html>
    <html lang="en">
        <head>
            <title>
Crystals, Charms, and Coffee
</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="final.css">
        </head>
    </html>
<body>';*/

include_once($_SERVER['DOCUMENT_ROOT'] . "/php_final/products.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php_final/display.php");


/*
 * @param $product
 * pulls the "properties" of the product arrays into a string to build the html for the display of the products
 */
function display($product){
    $product = $product;
    $product_display =  '<form  method="GET" action="addtocart.php">
                         <div class = "product_display">
                         <input class="disp_name" type="text" value = "'.$product['name'] .'" name="prod_name" readonly>
                         <div class ="prod_img" ><img src = "./img/' . $product["img"].'.jpg"></div>
                         <div class = "prod_weight">'.$product["weight"] . '</div>
                         <div class = "prod_price">$'.$product["price"].'</div>

                         <input type="text" size="5" name="quantity">
                         <input class="add_to_cart"  type="submit" value="Add to Cart" >
                         </form>

    </div>';

    return $product_display;

};



$current_products = array($amethyst,$quartz_orb,$wizard,$catseye,$dragon);



$disp = '';
for ($i =0; $i < count($current_products); $i++){
    echo display($current_products[$i]);
}

if (isset($_SESSION['logged']) && $_SESSION['logged']== 1){
    echo "LOGGED IN";

}

if (!isset($_SESSION['logged']) || $_SESSION['logged'] !=1) {

    echo "Not Logged in";
}

require($_SERVER['DOCUMENT_ROOT'] ."/php_final/template_bottom.inc");

//Make the number of items in each product a form/text input. When you click "add to cart", it will add the item into
// the sessions array that will be used by the shopping cart page.

//TODO make user registration form/php etc.

$firephp->log($_SESSION, 'session');
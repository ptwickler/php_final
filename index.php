<?php
//session_start();

//for debug
/*ini_set('display_errors', 1);

error_reporting(E_ALL);*/



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



if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);

}


$_SESSION['cart'] = array();
// I use includes to build the head and end of the html page


if(isset($_SESSION['p_cart'])) {
    $item = $_SESSION['p_cart'];
}

//require($_SERVER['DOCUMENT_ROOT'] ."/php_final/template_top.inc");
print ' <!DOCTYPE html>
    <html lang="en">
        <head>
            <title>
Crystals, Charms, and Coffee
</title>
            <meta charset="utf-8">
            <link rel="stylesheet" href="final.css">
        </head>
    </html>
<body>
<div>
  <form class="login" value="Sign In" action="login.php" method="POST">
    <label for="username">Name</label>
      <input class="login" type="text" size="20" name="username"/>
    <label for="password" class ="login">Password</label>
      <input class="login" name="password" size="20">
      <input type="submit" value="Sign In">
  </form>
</div>
<form class="login" action="http://localhost/php_final/index.php?out=1" method="GET">
  <input type="text" name="out" value="1" hidden>
  <input type="submit" value="Sign Out">
</form>
<div id="cart_disp">Your Cart:<br>';
print '<form name="checkout_button" action="checkout.php" method="POST">';

if(isset($_SESSION['p_cart'])) {
    foreach ($_SESSION['p_cart'] as $key => $value) {

        print '<input class="checkout_list" name="checkout_button" type="text" readonly value="'. $key . ' ' . $value["quantity"] .'"> <br>';


    }
    print '<input type="submit" value="Complete Checkout" ></form></div>';
}

elseif (!isset($_SESSION['p_cart'])) {
    print  '<input name="checkout_button" type="text" readonly ><span class="require_auth">Sign in to Purchase Items</span><br></form></div>';
}

//TODO Add an else statement that displays the empty cart window if no items in cart yet
include_once($_SERVER['DOCUMENT_ROOT'] . "/php_final/products.php");
include_once($_SERVER['DOCUMENT_ROOT'] . "/php_final/display.php");


/*
 * @param $product
 * pulls the "properties" of the product arrays into a string to build the html for the display of the products
 *
 *  $item is the product being processed and $products is the array of products in products.php.s
 */
function display($item,$products){


// Pushes the properties of the items into the html to display them. I use a hidden, read-only input called "item"
    // in the form to get the "machine" name of the item for use as an index later. I couldn't figure out a better way
    // to do this.
    $product_display =  '<form  method="GET" action="addtocart.php">
                         <div class = "product_display">
                         <input class="disp_name" type="text" value = "'.$products[$item]["name"] .'" name="prod_name" readonly>
                         <div class ="prod_img" ><img src = "./img/' . $products[$item]["img"].'.jpg"></div>
                         <div class = "prod_weight">'.$products[$item]["weight"] . '</div>
                         <div class = "prod_price">$'.$products[$item]["price"].'</div>

                         <input type="text" size="5" name="quantity">
                         <input class="add_to_cart"  type="submit" value="Add to Cart" >
                         <input type="text" name ="item" value="'.$item.'" readonly hidden="true">
                         </form>

    </div>';

    return $product_display;

};



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

//Make the number of items in each product a form/text input. When you click "add to cart", it will add the item into
// the sessions array that will be used by the shopping cart page.

//TODO make user registration form/php etc.

$firephp->log($_SESSION, 'session');
<?php


// Deletes the session if the user has clicked "log in as someone else" option.
if (isset($_GET['delete_session'])) {
    session_start();
    session_destroy(); //force the session to end

    //Add in a page reload so that the session_destroy() will take effect
    if($_SESSION && $_SESSION['name']){
        $url = "http://".$_SERVER['HTTP_HOST']."/final/index.php";
        header("Location: ".$url);
    }


}

else {
    // start the session
    session_start();
}

require_once('FirePHPCore/FirePHP.class.php');

if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);

}
$_SESSION['cart'] = array();
// I use includes to build the head and end of the html page
require($_SERVER['DOCUMENT_ROOT'] ."/php_final/template_top.inc");


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







/*
 * @param $email
 * Validates an email address and returns it if it passes the test.
 */

function validate_email($email) {
    if ((filter_var($email, FILTER_VALIDATE_EMAIL) != true)) {
        $url = "http://".$_SERVER['HTTP_HOST']."/lab13/lab13_4/index4.php?not_valid=1";
        header("Location: ".$url);
    }

    elseif (filter_var($email, FILTER_VALIDATE_EMAIL) == true) {

        $_SESSION[$email] = $email;


    }

    return $email;

}



$current_products = array($amethyst,$quartz_orb,$wizard,$catseye,$dragon);

$users = array();

$disp = '';
for ($i =0; $i < count($current_products); $i++){
    echo display($current_products[$i]);
}


require($_SERVER['DOCUMENT_ROOT'] ."/php_final/template_bottom.inc");

//Make the number of items in each product a form/text input. When you click "add to cart", it will add the item into
// the sessions array that will be used by the shopping cart page.

//TODO make user registration form/php etc.

$firephp->log($_SESSION, 'session');
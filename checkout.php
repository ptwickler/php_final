<?php
session_start();

ini_set('display_errors', 1);

error_reporting(E_ALL);


if(!isset($_SESSION)) {
    session_start();
}

ob_start();
require_once('FirePHPCore/FirePHP.class.php');



if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);

}

require_once('FirePHPCore/FirePHP.class.php');

include_once('./products.php');
print '<!DOCTYPE html>
<html lang="en">
<head>
    <title>
        Crystals, Charms, and Coffee
    </title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="final.css">
</head>

<body>
<div class="banner"><img class="banner" src="img/banner.jpg"></div>



    <form class="login" value="Sign In" action="login.php" method="POST">
        <label for="username">Name</label><br>
        <input class="login" type="text" size="20" name="username"/><br>
        <label for="password" class ="login">Password</label><br>
        <input class="login" name="password" size="20"><br>
        <input type="submit" value="Sign In">
    </form>

    <form class="login" action="http://localhost/php_final/index.php?out=1" method="GET">
        <input type="text" name="out" value="1" hidden>
        <input type="submit" value="Sign Out">
    </form>';

if (isset($_SESSION['out_cart'])) {
    $items = $_SESSION['out_cart'];
}

else {

   /* $url = "http://" . $_SERVER['HTTP_HOST'] . "/php_final/index.php";

    header("Location: ".$url) or die("Didn't work");*/


}
#-------------#
# Functions   #
#-------------#

function build_out_cart($cart,$products){

    $out_cart = '';
    $total = 0;


    foreach($cart as $key=>$value) {
        $product = $products[$key];

      $out_cart .= '<tr><td class="checkout_name">' . $product['name'] . '</td><td class="checkout_quantity">' . $cart[$key]['quantity'] . '</td><td class="checkout_price">$' . $product['price'] * intval($cart[$key]['quantity']) .'.00</td></tr>';
      $total += $product['price'] * intval($cart[$key]['quantity']);

    }

   $out_cart .= '</tbody></table><div class="total_price"> Your Total: $' .$total . '.00';
    return $out_cart;

}


$out_table = build_out_cart($items,$products);

echo '<!--<!DOCTYPE html>
        <html lang="en">
          <head>
              <title>
                  Checkout!
              </title>
              <meta charset = "utf-8">
              <link rel="stylesheet" href="final.css">
          </head>
          <body>
          <img class="banner" src="img/banner.jpg">-->
          <h2>Your Cart:</h2>
          <hr>
          <br>
          <br>
            <table><tbody><th>Item</th><th>Quantity</th><th>Price</th>' . $out_table .  '</div></body></html>';


$firephp->log($_SESSION, 'session');

?>




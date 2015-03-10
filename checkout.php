<?php
session_start();

ini_set('display_errors', 1);

error_reporting(E_ALL);


if(!isset($_SESSION)) {
    session_start();
}

ob_start();
require_once('FirePHPCore/FirePHP.class.php');



/*if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);

}

require_once('FirePHPCore/FirePHP.class.php');*/

include_once('./products.php');

if (isset($_SESSION['p_cart'])) {
    $items = $_SESSION['p_cart'];
}

/*else {

    $url = "http://" . $_SERVER['HTTP_HOST'] . "/php_final/index.php";

    header("Location: ".$url) or die("Didn't work");


}*/
#-------------#
# Functions   #
#-------------#

function build_out_cart($cart,$products){

    $out_cart = '';
    $total = 0;


    foreach($cart as $key=>$value) {
        $product = $products[$key];

      $out_cart .= '<tr><td>' . $product['name'] . '</td><td>' . $cart[$key]['quantity'] . '</td><td>' . $product['price'] * intval($cart[$key]['quantity']) .'</td></tr>';
      $total += $product['price'] * intval($cart[$key]['quantity']);

    }

   $out_cart .= '</tbody></table><div class="total_price">' .$total . '</div></body></html>';
    return $out_cart;

}


$out_table = build_out_cart($items,$products);

echo '<!DOCTYPE html>
        <html lang="en">
          <head>
              <title>
                  Checkout!
              </title>
              <meta charset = "utf-8">
              <link rel="stylesheet" href="final.css">
          </head>
          <body>
            <table><tbody>' . $out_table;


/*$firephp->log($_SESSION, 'session');*/

?>




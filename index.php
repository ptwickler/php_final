<?php


if (isset($_GET['delete_session'])) {
    session_start(); //must always use this command to access the session and its variables
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
    $product_display =  '<div class = "product_display">
                         <div class = "prod_name">'.$product["name"].' </div>
                         <div class ="prod_img" ><img src = "./img/' . $product["name"].'.jpg"></div>
                         <div class = "prod_weight">'.$product["weight"] . '</div>
                         <div class = "prod_price">$'.$product["price"].'</div>
                         <input type="submit" value="Add to Cart" action="addtocart.php">

    </div>';

    return $product_display;


};

// Handles the decisions about how to display the form based on the state of the session and then returns the html.
function form_display($ind,$val_email){

    $case = 0;
    // If the user has not downloaded the file nor submitted a form, either successful or unsuccessful.
    switch($ind) {


        case 0:
            $form = '<h4>Enter your name and email address to download the story:</h4>
      <form method="GET" action = "index4.php">

        <input type="text" size ="25" name="name" value="">
        <label for="name">Enter your name</label><br/>

        <input type="text" size="25" name="email" value=""/>
        <label for="email">Enter your email address</label><br/>
        <input type="SUBMIT" value ="Submit"/> -- Form no submit
      </form>';

            break;


        // If the user has submitted an invalid email address.
        case 1:
            $case = 1;

            $form = '<h4>Enter your name and email address to download the story:</h4>
    <span class = "not_valid">That email address does not seem to be valid. Try again.</span>
    <form method="GET" action = "index4.php">

      <input type="text" size ="25" name="name" value="">
      <label for="name">Enter your name</label><br/>

      <input type="text" size="25" name="email" value=""/>
      <label for="email">Enter your email address</label><br/>
      <input type="SUBMIT" value ="Submit"/>
    </form>';
            break;

        case 2:
            $case = 2;
            $form = 'Hello' . $_SESSION['name'] . ' DOOP , Click the link below to download the story.<br/>
      <a  href="download4.php?email="' . $_GET['email'] . '&name=downloaded>Download the story!</a><br />
      <a href="http://' . $_SERVER["HTTP_HOST"] . '/lab13/lab13_4/index4.php?delete_session=1">Not ' . $_SESSION['name'] . '</a>? Click the link to sign in<br />';

            break;

        case 3:
            $case = 3;
            $form = '<span class = "not_valid">I\'m sorry, this story can only be downloaded once per session.</span><br />
        Hello, ' . $_SESSION['name'] . ' DOOP, Click the link below to download the story.<br/>
      <a  href="#" disabled = "true">Download the story!</a><br />
      <a href="http://' . $_SERVER['HTTP_HOST'] . '/lab13/lab13_4/index4.php?delete_session=1">Not ' . $_SESSION['name'] . '</a>? Click the link to sign in<br />';
            break;
    }
    return $form;
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

$disp = '';
for ($i =0; $i < count($current_products); $i++){
    echo display($current_products[$i]);
}


require($_SERVER['DOCUMENT_ROOT'] ."/php_final/template_bottom.inc");

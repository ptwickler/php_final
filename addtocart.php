<?php


$prod_name = $_GET['product'];
$quantity = $_GET['quantity'];

function add_to_cart($quantity){

    echo $quantity;
    exit;
}

add_to_cart($quantity);
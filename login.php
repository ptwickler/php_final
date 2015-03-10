<?php
/*
 * TODO: Make note of all the places that will need adjusting to make sure that this all works on the school's system
 * too.
 */

//TODO: Remove before submitting
// FOR DEBUG
ini_set('display_errors', 1);
error_reporting(E_ALL);


session_start();


require_once('FirePHPCore/FirePHP.class.php');
require_once("index.php");
require_once("accounts.php");


ob_start();
/*if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);
}*/


if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];

    $pw = $_POST['password'];



        // Iterates through the users' array and looks for a match to the username to determine if the user is registered. If
        // they are registered, it checks the password and either logs them into the site or tells them to register or enter a
        // valid password, depending.
    foreach ($ac_users as $key => $value) {
        $user_match = preg_match('/^' . $username . '$/', $key, $matches);
        if ($user_match == 1) {
            $pw_match = preg_match('/^' . $pw . '$/', $value, $matches);
            if ($pw_match) {

                $_SESSION['sign_in'] = 1;
                $url = "http://" . $_SERVER['HTTP_HOST'] . "/php_final/index.php";
                ob_clean();
                header("Location: " . $url) or die("didn't redirect from login");


                echo "logging in no worries";

            } elseif (!$pw_match) {
                echo "Wrong Password, jerko";
            }
        } elseif ($user_match != 1) {
            echo "register to use the site.";
        }
    }
}


//TODO: REMOVE BEFORE SUBMITTING
// For debug
//$firephp->log($_SESSION, 'session');


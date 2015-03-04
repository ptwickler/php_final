<?php
ini_set('display_errors', 1);

error_reporting(E_ALL);
session_start();


require_once('FirePHPCore/FirePHP.class.php');
require_once("index.php");
require_once("accounts.php");

/*if (isset($_GET['signout']) && $_GET['signout']==1){




    $url = "http://".$_SERVER['HTTP_HOST']."/php_final/index.php";
    header("Location: ".$url);

    session_start();
    session_destroy();
    $page = "http://" . $_SERVER['HTTP_HOST'] . "/php_final/index.php";

// The refresh runs the index.php page again after the various actions of this
// file have been completed allowing the logic on the index.php page to
// display the correct html.
    //header("refresh: 1, url=$page");

}*/

// Stores the username and password as variables for later use.





ob_start();
if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);
}


if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];

    $pw = $_POST['password'];




        foreach ($ac_users as $key => $value) {
            $user_match = preg_match('/^' . $username . '$/', $key, $matches);
            if ($user_match == 1) {
                $pw_match = preg_match('/^' . $pw . '$/', $value, $matches);
                if ($pw_match) {

                    $_SESSION['logged'] = 1;
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


// Iterates through the users' array and looks for a match to the username to determine if the user is registered. If
// they are registered, it checks the password and either logs them into the site or tells them to register or enter a
// valid password, depending.


$firephp->log($_SESSION, 'session');


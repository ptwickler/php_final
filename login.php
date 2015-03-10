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


#############
# VARIABLES #
#############



require_once('FirePHPCore/FirePHP.class.php');
require_once("index.php");
require_once("accounts.php");
require_once("products.php");

#############
# FUNCTIONS #
#############

function new_user($user) {
$users = file('accounts.php');
    print_r($users);
exit;

}
function register_display() {
    print '<form name="register" action="login.php?new_use=1" method="POST">
             <label for="name">Enter your name</label>
             <input type="text" size="20" name="name">
             <label for="email">Enter your email address</label>
             <input type="text" size="20" name="email">
             <label for="password">Enter a password</label>
             <input type="text" size="20" name="password">
             <input type="submit" value="Click to register!">


           </form>';



}


ob_start();
if (!$firephp) {
    ob_start();

    $firephp = FirePHP::getInstance(true);
}
if(isset($_GET['register_new']) && $_GET['register_new'] == 1) {

   register_display();
}
/*if (isset($_GET['log']) && $_GET['log'] == 1) {*/
    if (isset($_POST['username']) && isset($_POST['password'])) {

        $username = $_POST['username'];

       /* $pw = $_POST['password'];
        echo $username . "<br>";
        echo $pw;

        exit;*/
        //$email = $_POST['email'];


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
                echo '<html><div>You do not seem to be registered. Click <a href="login.php?register_new=1" target="_blank">here</a> to register.</div></html>';
            }
        }

    /*}*/
}




if(isset($_GET['new_use']) && $_GET['new_use'] ==1){


    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $user_pw = $_POST['password'];

    new_user($user);

    $url = "http://" . $_SERVER['HTTP_HOST'] . "/php_final/index.php";
    ob_clean();
    header("Location: " . $url) or die("didn't redirect from login");
}

//TODO: REMOVE BEFORE SUBMITTING
// For debug
$firephp->log($_SESSION, 'session');


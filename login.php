<?php

session_start();

include("index.php");
include("accounts.php");

// Stores the username and password as variables for later use.
$username = $_POST['username'];
$pw = $_POST['password'];

// Iterates through the users' array and looks for a match to the username to determine if the user is registered. If
// they are registered, it checks the password and either logs them into the site or tells them to register or enter a
// valid password, depending.
foreach($ac_users as $key=>$value) {
    $user_match = preg_match('/^'.$username.'$/', $key, $matches);
    if ($user_match==1){
        $pw_match = preg_match('/'.$pw.'/', $value, $matches);
        if ($pw_match) {
            echo "logging in no worries";
        }

        elseif(!$pw_match){
            echo "Wrong Password, jerko";
        }
    }

    elseif($user_match !=1) {
        echo "register to use the site.";
    }
}





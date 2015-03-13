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

require_once("products.php");


#############
# FUNCTIONS #
#############

// This function inserts a new "account" into the accounts.txt file. This is how I keep track of login credentials.
// Basically, it implodes the values into a string and then writes it to the file accounts.txt. NOTE: The accounts.txt
// file must be primed with a blank line at the end of the file to avoid writing the new data on the end of the same
// line as the previous user's data. I know there's a lot of more clever stuff I could do to handle that
// automatically (or at least more robustly) but I didn't think it was worth it for this "simple" implementation.
function new_user($user,$pass,$email) {


    $n_user = $user;
    $n_pass = $pass;
    $n_email = $email;

    $users_list = fopen('/Library/WebServer/Documents/php_final/accounts.txt','a+');

    $user_values = array($n_user,$n_pass,$n_email);

    $user_in = implode(",",$user_values);

    $user_in_line = $user_in . PHP_EOL;

    fwrite($users_list,$user_in_line);

    fclose($users_list);
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

// If the register_new value in the GET is set and == 1, display the form for registering a new user.
if(isset($_GET['register_new']) && $_GET['register_new'] == 1) {

   register_display();
}
    // If the user has submitted the login form, iterate through the records in accounts.txt.
    // The nested for loops iterate first through the file, line by line, and then the first nested for loop
    // iterates through the line looking first for the username submitted. If it finds the username,
    // it then iterates through the same line again looking for the password. If both are found, the user is
    // logged in. If the password isn't found, it suggests you try again. If the user isn't found, it displays
    // the registration form.
    if (isset($_POST['username']) && isset($_POST['password'])) {

        $username = $_POST['username'];
        $pw = $_POST['password'];

        $g = 0; // Counter to limit the display of the "register here" verbiage.

        $user_list = file('/Library/WebServer/Documents/php_final/accounts.txt');

        for ($i = 0; $i < count($user_list); $i++){
            $line = explode(",",$user_list[$i]);

            for ($c = 0; $c < count($line); $c++) {
                $user_match = preg_match('/^' . $username . '$/', $line[$c], $matches);

                if ($matches) {

                    for ($p = 0; $p < count($line);$p++) {

                        $pw_match = preg_match('/^' . $pw . '$/', $line[$p], $match);

                        if ($match) {
                            $_SESSION['sign_in'] = 1;
                            $url = "http://" . $_SERVER['HTTP_HOST'] . "/php_final/index.php";
                            ob_clean();
                            header("Location: " . $url) or die("didn't redirect from login");

                            echo "logging in no worries";
                        }

                        elseif (!$match) {
                            echo "Wrong Password, jerko";
                        }
                    }
                }

                elseif(!$matches){
                    if ($g==1) break;
                    echo '<html><div>You do not seem to be registered. Click <a href="login.php?register_new=1">here</a> to register.</div></html>';
                    $g++; // Increments counter to control the number of times the above verbiage and link are displayed.

                }

            }
        }
    }


if(isset($_GET['new_use']) && $_GET['new_use'] ==1){


    $user_name = $_POST['name'];
    $user_email = $_POST['email'];
    $user_pw = $_POST['password'];

    new_user($user_name,$user_email,$user_pw);

    $url = "http://" . $_SERVER['HTTP_HOST'] . "/php_final/index.php";
    ob_clean();
    header("Location: " . $url) or die("didn't redirect from login");
}

//TODO: REMOVE BEFORE SUBMITTING
// For debug
$firephp->log($_SESSION, 'session');


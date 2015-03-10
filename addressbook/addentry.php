<?php

#------------------------------#
# Functions                    #
#------------------------------#

function check_input($form_array) {
    if ($form_array['first_name'] && $form_array['last_name'] && $form_array['phone'] && $form_array['address'] && $form_array['city'] && $form_array['zipcode'] && $form_array['month'] && $form_array['day'] && $form_array['year']) {
        return 1;
    }

    else return 0;
}

function get_birthday ($form_array) {
    $birthday = $form_array['year']. "-" . $form_array['month'] . "-" . $form_array['day'];
    return $birthday;
}

#-------------------#
# User Variables    #
#-------------------#

$host = "127.0.0.1";
$user = "root";
$pw = "";
$database = "addressbook";
$table_name = "addressbook";

#-------------------#
# Main Body         #
#-------------------#

if (check_input($_POST)) {
    $birthday = get_birthday($_POST);
    $db = new mysqli($host,$user,$pw,$database) or die("Cannot connect.");

    $command = "insert into " . $table_name . " (first_name,last_name,phone,address,city,state,zipcode,birthday) values ('".$db->real_escape_string($_POST['first_name'])."','".$db->real_escape_string($_POST['last_name'])."','".$db->real_escape_string($_POST['phone'])."','".$db->real_escape_string($_POST['address'])."','".$db->real_escape_string($_POST['city'])."','".$db->real_escape_string($_POST['state'])."','".$db->real_escape_string($_POST['zipcode'])."','".$db->real_escape_string($birthday)."');";

    $result = $db->query($command);

    print "Data was successfully entered.<br>";
    $db->close();
}
else { print "Data was NOT entered due to errors.<br>";}
?>

<a href="viewbook.php">View my address book</a>;

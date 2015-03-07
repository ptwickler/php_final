<?php

#----------------#
# User Variables #
#----------------#

$host = "127.0.0.1";
$user = "root";
$pw = "";
$database = "addressbook";
$table_name = "addressbook";


#----------------#
# Main Body      #
#----------------#

$db = new mysqli($host,$user,$pw,$database) or die("Cannot connect to MySQL.");

?>

<h1>My Address Book</h1>
<table BORDER="1">
    <tr><td>Name</td><td>Phone Number</td>
        <td>Address</td><td>Birthday</td></tr>

    <?php
    $command = "select * from " . $table_name . ";";


    $result = $db->query($command);

    while ($data = $result->fetch_object()) {
        print "<TR><TD>" . $data->last_name . "," . $data->first_name . "</td><td>" . $data->phone . "</td>";
        print "<td>" . $data->addresss . "<br>" . $data->city . "," . $data->state . "<br>" . $data->zipcode . "</td>";
        print "<td>" . $data->birthday . "</td></tr>\n";
    }

    $result->free();

    $db->close();

    php?>
</table>
<br>
<a href="addentry.html">Add a new entry</a>
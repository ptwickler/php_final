<?php

$post_text = $_POST['post'];
$email = $_POST['email'];
$name = $_POST['first_name'] . " " . $_POST['last_name'];

function insert_blog_entry($post_text,$email,$name) {
    $host = '127.0.0.1';
    $user = 'root';
    $pw = '';
    $database = 'blog';

    $c_name = $name;
    $c_email = $email;
    $c_post_text = $post_text;

    $db = new mysqli($host,$user,$pw,$database) or die("Cannot connect to MySQL.");

    $command = "INSERT INTO blog_entry (author_name,post_date,post_text,email) VALUES ('".$db->real_escape_string($c_name)."', now(),'".$db->real_escape_string($c_post_text)."','".$db->real_escape_string($c_email)."');";

    $db->query($command);

    $db->close();
}

function display_all_entries(){
    $host = '127.0.0.1';
    $user = 'root';
    $pw = '';
    $database = 'blog';

    $db = new mysqli($host,$user,$pw,$database) or die("Cannot connect to MySQL.");

    $command = "SELECT * FROM blog_entry;";

    $result = $db->query($command);


    print '<!DOCTYPE html>
<html lang="en">
<head>
<title>My Entries
</title>
<link rel="stylesheet" href="http://ptwickle.userworld.com/phpsql1/blog.css">
<body><h1>BLog Postsk</h1>
<table BORDER="1">
<tr><td>Name</td><td>Phone Number</td>
<td>Address</td><td>Birthday</td></tr>
';

    while ($data = $result->fetch_object()) {
        print '<div class="wrapper">
               <a href="blog_entry.php?blogId=' . $data->blogId . '">View Post</a>,<br>
                 <div class="entry">' . $data->post_text . '</div><div class="post_date">'. $data->post_date . '</div><div class="auth_name">Post by: ' . $data->author_name . '</div></div>';

    }

    print '</body></html>';
    $result->free();
    $db->close();

}


if ($_GET['entry'] == 1) {
    insert_blog_entry($post_text,$email,$name);
    display_all_entries();
}

if($_GET['blogId']) {
    $blogId = $_GET['blogId'];


    $host = '127.0.0.1';
    $user = 'root';
    $pw = '';
    $database = 'blog';

    $db = new mysqli($host,$user,$pw,$database) or die("Cannot connect to MySQL.");

    $command = "SELECT * FROM blog_entry where blogId =". $blogId . " order by post_date DESC;";


    $result = $db->query($command);

    //$data = $result->fetch_object();



    while ($data = $result->fetch_object()) {
        print '<!DOCTYPE html><html lang="en">
<head>
<title>'. $data->author_name .'
</title>
<link rel="stylesheet" href="http://ptwickle.userworld.com/phpsql1/blog.css">
<body><div class="wrapper">

               <div class="entry">' . $data->post_text . '</div><div class="post_date">'. $data->post_date . '</div>
               <div class="auth_name">Post by: ' . $data->author_name . '</div></div>';

    }

    print '<a href="blog_entry.html">Go back to the ent </body></html>';
    $result->free();
    $db->close();


}




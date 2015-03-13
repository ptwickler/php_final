<?php



$ac_users = array('peter'=>array(
    'pass'=>'12',
    'email' => 'peter.twickler@gmail.com'
),

    'joe'=>array(
        'pass'=>'22',
        'email'=> 'jjohn@taskboy.com'
    ),

    'sarah'=> array(
        'pass'=> 'cat',
        'email'=> 'scmoriarty@gmail.com'
    )
);


$jlist = json_encode($ac_users);

$llist = json_decode($jlist,true);

print_r($jlist);
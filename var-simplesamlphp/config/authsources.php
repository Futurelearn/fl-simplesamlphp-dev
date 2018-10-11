<?php

$config = array (
    'admin' => array(
        'core:AdminPassword',
    ),

    'example-userpass' => array(
        'exampleauth:UserPass',
        'joebloggs:password' => array(
            'uid' => array('joebloggs'),
            'eduPersonAffiliation' => array('member', 'employee'),
            'email' => array('joe@corp.com'),
        ),
    ),
);

?>

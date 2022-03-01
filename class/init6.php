<?php
    $config = array(
    'host'	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'dbname' => 'db_saudagar'
    );
    $db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

require '../class/user.php';
require '../class/drawing_class.php';
require '../class/comment.php';
require '../class/object.php';
require '../class/kontrak_class.php';

$Users = new Users($db);
$drawing = new Drawing($db);
$comment = new Comment($db);
$obj	= new obj($db);
$contract = new kontrak($db);


?>
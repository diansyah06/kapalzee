<?php 
    # We are storing the information in this config array that will be required to connect to the database.
    $config = array(
    'host'	=> '10.0.1.51',
    'username'	=> 'dm_userBKi',
    'password'	=> 'h89jv3twhv',
    'dbname' => 'damage_statistik'
    );
    #connecting to the database by supplying required parameters
    $db_S = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
     
    #Setting the error mode of our db object, which is very important for debugging.
    $db_S->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
require 'cSubdbStatistik.php';


	
$DSR = new DSR($db_S);

?>
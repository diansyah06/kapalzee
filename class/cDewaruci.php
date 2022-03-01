<?php 
    # We are storing the information in this config array that will be required to connect to the database.
    $config = array(
    'host'	=> 'localhost',
    'username'	=> 'dewaruci',
    'password'	=> 'h89jv3twhv',
    'dbname' => 'dewaruci'
    );
    #connecting to the database by supplying required parameters
    $db_c = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
     
    #Setting the error mode of our db object, which is very important for debugging.
    $db_c->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
require 'cSubdewaruci.php';


	
$DWR = new DWR($db_c);

?>
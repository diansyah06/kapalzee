<?php
require 'sis32/data_pdo.php';
require 'class/kpi.php';
require 'class/user.php';
require 'class/rms.php';
require 'class/sysnc.php';
require 'class/activity.php';



$kpi = new kpi($db);
$Users = new Users($db);
$rms = new rms($db);
$errors = array();
$synk= new synk($db);
$Activity = new Activity($db);

?>
<?php
include("../sis32/db_connect.php"); include "../functions.php";

//get var from post
sec_session_start();
include("../class/init2.php");
date_default_timezone_set('Asia/Jakarta');
$user_id = $_SESSION['user_id'];
$currentUser= $user_id ;
$nama_user = $_SESSION['usernama'] ;
$dsn = 'mysql:host=localhost;dbname=rms';
/* $PDO = new PDO($dsn, 'root', ''); */

$PDO =$db;

$mid = isset($_GET['id']) ? $_GET['id'] : 0;
$sql = "update message2_recips set status='D' where mid=? and status != 'D' and uid=?";
$stmt = $PDO->prepare($sql);
$args = array($mid, $currentUser);

if (!$stmt->execute($args)) {
    die('error');
}


echo "<script>window.location = '../panel.php?module=message&sub=inbox'; </script>";
die(header('Location: ../panel.php?module=message&sub=inbox'));

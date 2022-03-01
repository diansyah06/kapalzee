<?php
date_default_timezone_set('Asia/Jakarta');
include 'sis32/data_pdo.php';
include 'class/user.php';

$key=$_GET['key'];
$user = new Users($db);

$user->keyAutodel();
$user->userAutodel();
$nup = $user->keyGetNup($key);
if (empty($nup)){
	echo "activation failed or expired";
}
else
{
	$user->userActivate($nup);
	echo "activation success";
	$user->keyDel($key);
}
?>
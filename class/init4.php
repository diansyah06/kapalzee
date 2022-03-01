<?php
require '../../sis32/data_pdo.php';
require '../../class/kpi.php';
require '../../class/user.php';
require '../../class/rms.php';
require '../../class/sysnc.php';
require '../../class/activity.php';


require '../../class/object.php';
require '../../class/dccObject.php';

require '../../class/kontrak_class.php';
require '../../class/drawing_class.php';
require '../../class/tipe_objek_class.php';
require '../../class/class_upload.php';
require '../../class/comment.php';
require '../../class/class_timelines_notf.php';


$kpi = new kpi($db);
$Users = new Users($db);
$rms = new rms($db);
$errors = array();
$synk= new synk($db);
$Activity = new Activity($db);


$obj = new obj($db);
$dcc = new dcc($db);


$kontrak = new Kontrak($db);
$drawing = new Drawing($db);
$tipe_objeck = new tipe_objek($db);
$comment = new comment($db);
$time_lines = new time_lines($db);

?>
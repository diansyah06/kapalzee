<?php
require_once('../class/watermar.php');
require_once('../class/wraper.php');


$kodeHide="BIRO KLASIFIKASI INDONESIA";
$kodenumber="asdasd";
$drawingno="asdasd";
$file='TB101_ABH18048_H-32-011_Bulwark_Construction_R2.pdf';





	$decrypted = fopen($file, 'rb');
	$dumby=stream_get_contents ($decrypted);

    $watermark = new WatermarkerTCPDF(VarStream::createReference($dumby));
    $watermark->wmText($kodeHide);
    $watermark->wmText2($kodemun );
    $watermark->WatermarkBKI($drawingno);

?>
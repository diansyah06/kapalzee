<?php

$mode=$_GET['mod'];

if (!isset($mode) ){$mode=1;}

if ($mode==1){ 

	include "kontrak\input_drawing.php";

}else {

include "kontrak\list_revisi_drawing.php";


}















?>
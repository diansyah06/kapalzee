<?php
include ("../sis32/db_connect.php");

include "../functions.php";

sec_session_start();

// get var from post

include "../class/init3.php";

include "../modern.php";

date_default_timezone_set('Asia/Jakarta');
cekLoginStatus($mysqli);

// get profile user login

$user_id = $_SESSION['user_id'];
$nama_user = $Users->get_users_with_title($user_id); //nama
$biodata_users = $Users->getUser_biodata($user_id);
//$salting = $_SESSION['salt'];

$salting = $Users->get_previl($_SESSION['user_id']);

foreach($biodata_users as $biodata_user)
	{
	$displayPicture = "../" . $biodata_user['path']; //wajah
	$jabatanUser = $biodata_user['jabatan'];
	$emailUser = $biodata_user['email'];
	$hpUer = $biodata_user['handphone'];
	}

// getalluser

$listUsers = $Users->get_users();
$alluserArray = array(); // store alluseronarray

foreach($listUsers as $listUser)
	{
	$idusernya = $listUser['id_user'];
	$alluserArray[$idusernya] = $listUser['nama'];
	}

$typebidangArray = array(
	" ",
	"Structure",
	"Stability",
	"Machinery",
	"Offshore",
	"Other"
);

// array kegiatan

$namakegiatan = array(
	"uncategory",
	"Training",
	"Schooling",
	"Sidang",
	"Meeting",
	"Committee",
	"Attendance",
	"Presentation",
	"Project or Research",
	"launcing",
	"Other"
);

// curency

$currencyarray = array(
	"error",
	"IDR",
	"USD",
	"SGD",
	"GDB",
	"EUR"
);
$typeStatus = array(
	"Preparation",
	"Discussion",
	"Reject",
	"Approve"
);

// simbol gambar
// $simb_gam= array("o","ST","EL","ME","STA","SV");
//

$commentStatus = array(
	"Draft",
	"Mod.",
	"Approve",
	"Publish"
);
$simb_gam = array();
$simb_gam[0] = 'o';

// tipegambar

$tipe_gambars = $drawing->get_tipe_gambar();
$tipegambbararr = array();

foreach($tipe_gambars as $tipe_gambar)
	{
	if ($tipegambbararr['id'] != 15)
		{
		$strtipegmabr = $strtipegmabr . "<option value='$tipe_gambar[id]'> $tipe_gambar[nama]</option>";
		$id = $tipe_gambar['id'];
		$tipegambbararr[$id] = $tipe_gambar['nama'];
		}

	// simbol gambar

	$simb_gam[$tipe_gambar['id']] = $tipe_gambar['deskrip'];
	}

$statu_s = array(
	"Open",
	"Closed",
	"Info"
);
$modul = $_POST['modul'];
switch ($modul)
	{
case "moderation":
	moderation($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $obj, $statu_s, $C_client, $kontrak);
	break;

case "drawing":
	drawingmod($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj,$kontrak);
	break;

case "downloadreq":
	downloadreq($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj);
	break;

case "uploadstamp":
	uploadstamp($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj, $C_client, $kontrak);
	break;

case "commenting":
	commenting($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $obj, $statu_s, $C_client, $kontrak,$salting);
	break;

case "team":
	team($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $kontrak, $salting, $obj);
	break;

case "uploadbluck":
	uploadbluck($Activity, $user_id, $drawing, $kontrak);
	break;

case "cost":
	cost($Activity, $user_id, $kontrak, $alluserArray, $salting, $obj, $drawing, $currencyarray);
	break;

case "client":
	client($Activity, $user_id, $kontrak, $alluserArray, $salting, $C_client);
	break;

case "faq":
	faq($Activity, $user_id, $kontrak, $alluserArray, $salting, $C_client);
	break;

case "technical":
	technical($Activity, $user_id, $kontrak, $alluserArray, $salting, $C_client, $obj);
	break;

case "updateproject":
	updateproject($Activity, $user_id, $drawing, $alluserArray, $salting, $obj);
	break;

case "refreshlog":
	refreshlog($Activity, $user_id, $drawing, $alluserArray, $salting, $obj);
	break;

case "generateReport":
	generateReport($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj);
	break;

case "SetPermission":
	SetPermission($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $kontrak, $salting, $obj);
	break;

case "survey":
	survey($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj, $kontrak, $commentStatus, $obj, $C_client);
	break;

case "rules":
	rule($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj, $kontrak, $commentStatus, $obj, $C_client, $Rules);
	break;
	
case "administratif":
	administratif( $Users, $user_id, $alluserArray, $Activity, $salting, $obj,$drawing);
	break;
case "DrawingTask":
	DrawingTask( $Users, $user_id, $alluserArray, $Activity, $salting, $obj,$drawing,$tipegambbararr);
	break;
case "dashboardPerformanceEng":
	dashboardPerformanceEng( $Users, $user_id, $alluserArray, $Activity, $salting, $obj,$drawing,$tipegambbararr);
	break;
case "individualPerformance":
	individualPerformance($obj, $user_id, $Users);	
	break;	
case "ManUser":
	ManUser($Users);
	break;
case "SpecialUser":
	SpecialUser($Users,$alluserArray);
	break;
case "commentingsister":
	commentingsister($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $obj, $statu_s, $C_client);
	break;
case "supervisorApprove":
	supervisorApprove($alluserArray, $kontrak, $obj, $drawing, $user_id, $comment);
	break;
case "rejectsm":
	rejectFromSM($comment, $Users, $user_id, $alluserArray, $Activity, $drawing, $obj, $statu_s, $C_client);
	break;
case "approvalletter":
	approvalletter($drawing);
case "tasksurvey":
	taskSurvey($Users, $user_id, $Activity, $obj);
	break;

	}

function refreshlog($Activity, $user_id, $drawing, $alluserArray, $salting, $obj)
	{
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	$objectid = $pieces[1];
	$listmodifiefiles = $obj->GetLogAplicationLogs($objectid);

	// nilai balik

	echo "<table class='table table-hover' id='sample-table-1'>
															<thead>
																<tr>
																	<th class='center'>#</th>
																	<th>Date</th>
																	<th class='hidden-xs'>User</th>
																	<th>Details</th>
																	
																</tr>
															</thead>
															<tbody>
															";
	$n = 1;
	foreach($listmodifiefiles as $listaccesfile)
		{
		$createon = date("F j, Y, g:i a", strtotime($listaccesfile['created_on']));
		$logData = substr(strip_tags($listaccesfile['log_data']) , 0, 50) . "..";
		echo "
																<tr>
																	<td class='center'>$n</td>
																	<td class='hidden-xs'>$createon</td>
																	<td><a href='./panel.php?module=profile&id=$listaccesfile[created_by_id]' rel='nofollow' target='_blank'> $listaccesfile[nama]</a></td>
																	<td>$listaccesfile[nama] $listaccesfile[action]ed $listaccesfile[object_name] ....(<strong> $logData</strong>)</td>
																
																<tr>";
		$n++;
		}

	echo "	
																	
															</tbody>
														</table>	";
	}

function updateproject($Activity, $user_id, $drawing, $alluserArray, $salting, $obj)
	{
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	if ($act == "updateprojectt")
		{
		$obj->updateWorspacedatainputsurveyor($pieces[3], $pieces[4], $pieces[5], $pieces[6], date("Y-m-d", strtotime($pieces[7])) , date("Y-m-d", strtotime($pieces[8])) , date("Y-m-d", strtotime($pieces[9])) , $pieces[10], $pieces[11], $pieces[12], $pieces[13], $pieces[2], $pieces[14], $pieces[15], $pieces[16], $pieces[17], $pieces[18], $pieces[19], $pieces[20], $pieces[1]);

		// insertlogsAplikasi

		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "namaproj", $user_id, "", 0, 0, "add generalinput designation" . $stringCommand);

		// nilai balik

		echo "<script> alert('done') ; window.location.reload(); </script>";
		die;
		}
	elseif ($act == "updateprojectt")
		{
		$obj->updateWorspacedatainputsurveyor($pieces[3], $pieces[4], $pieces[5], $pieces[6], date("Y-m-d", strtotime($pieces[7])) , date("Y-m-d", strtotime($pieces[8])) , date("Y-m-d", strtotime($pieces[9])) , $pieces[10], $pieces[11], $pieces[12], $pieces[13], $pieces[2], $pieces[14], $pieces[15], $pieces[16], $pieces[17], $pieces[18], $pieces[19], $pieces[20], $pieces[1]);

		// insertlogsAplikasi

		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "namaproj", $user_id, "", 0, 0, "add generalinput designation" . $stringCommand);

		// nilai balik

		echo "<script> alert('done') ; window.location.reload(); </script>";
		die;
		}
	elseif ($act == "updatestatusdone")
		{
		if ($salting > 4)
			{
			if ($pieces[4] == 1)
				{
				$reason = "ok";
				}
			  else
				{
				$reason = $pieces[2];
				}

			$obj->tblupdateworkspacestatus($pieces[1], $pieces[3], $reason);
			$obj->WriteLogAplicationLogs($user_id, $pieces[1], "closed project ", $user_id, "", 0, 0, $stringCommand);
			echo "<script> alert('done') ; window.location.href ='panel.php?module=project' ; </script>";
			}
		  else
			{
			echo "<script>alert('you are not allow ')</script>";
			}

		die;
		}
	elseif ($act == 1)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 2)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , ht($pieces[5]) , " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 3)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 4)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , " ", " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 5)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , " ", " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 6)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 7)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , ht($pieces[5]) , ht($pieces[6]) , ht($pieces[7]) , " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 8)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , " ", " ", " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 9)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , " ", " ", " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 10)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , ht($pieces[5]) , ht($pieces[6]) , " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 11)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , " ", " ", " ", " ", " ", ht($pieces[4]) , $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 12)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , " ", " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 13)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , " ", " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 14)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , " ", " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 15)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , ht($pieces[5]) , ht($pieces[6]) , " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 16)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 17)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , ht($pieces[5]) , " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 18)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , " ", " ", " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 19)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , " ", " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 20)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , " ", " ", " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == 21)
		{
		$drawing->insert_generaldata($act, ht($pieces[2]) , ht($pieces[3]) , ht($pieces[4]) , ht($pieces[5]) , ht($pieces[6]) , " ", " ", " ", $pieces[1]);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Add generalinfo", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == "dell")
		{
		$drawing->Delete_generalData($pieces[2], $pieces[1]);
		$act = $pieces[3];
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "dell generalinfo ", $user_id, "", 0, 0, $stringCommand);
		}
	elseif ($act == "refreshall")
		{
		$act = $pieces[3];
		}

	// nilai balik

	$listdatageneral = $drawing->get_Generaldata($pieces[1], $act);
	if ($act == 1)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Previous Name</th>
												<th class='hidden-xs'>From date</th>
												<th>To date</th>
												<th class='hidden-xs'></th>
												<th></th></tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;previousname&#39;);' ><a > Delete </a></td></tr>

		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 2)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Previous Flag</th>
												<th class='hidden-xs'>Port Name</th>
												<th class='hidden-xs'>FromDate</th>
												<th>To date</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td >$listdatagenera[param4]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;previousflag&#39;);' ><a > Delete </a></td></tr>

		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 3)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th> </th>
												<th class='hidden-xs'> </th>
												<th class='hidden-xs'> </th>
												<th> </th>
												<th></th></tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td >$listdatagenera[param4]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;stateinformation&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 4)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th> </th>

												<th> </th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>

			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;anchoeequipment&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 5)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th> </th>

												<th> </th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>

			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;otherinfo&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 6)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Regulation</th>
												<th>Gross Tonnage</th>
												<th>Net Tonnage</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;tonagee&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 7)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Builder</th>
												<th>Builder Bulding ID</th>
												<th>Builder Role</th>
												<th>Project Description</th>
												<th>Contractual Responsibility</th>
												<th>Contract date</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td >$listdatagenera[param4]</td>
			  <td >$listdatagenera[param5]</td>
			  <td >$listdatagenera[param6]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;builder&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 8)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th> </th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>

			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;iacsunified&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 9)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th> </th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>

			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;imorequirement&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 10)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Freeboard</th>
												<th class='hidden-xs'>Displacement</th>
												<th class='hidden-xs'>Deadweight(ton)</th>
												<th>Calculated Freeboard(mm)</th>
												<th>State</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td >$listdatagenera[param4]</td>
			  <td >$listdatagenera[param5]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;freeboardassigment&#39;);' ><a > Delete </a></td></tr>

		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 11)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Type</th>
												<th>Prymary</th>
												<th>Location</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param8]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;material&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 12)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th> </th>

												<th> </th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>

			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;styfennersystem&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 13)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Type</th>

												<th>Number</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>

			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;bulkheadsystem&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 14)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Type</th>

												<th>Number</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>

			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;tanki&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 15)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Manufacture</th>
												<th class='hidden-xs'>Type</th>
												<th class='hidden-xs'>Rating</th>
												<th>Model</th>
												<th>Detail Spec</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td >$listdatagenera[param4]</td>
			  <td >$listdatagenera[param5]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;maipropulsion&#39;);' ><a > Delete </a></td></tr>

		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 16)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Item</th>
												<th>Type</th>
												<th>Detail Spec</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;propulsor&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 17)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Item</th>
												<th class='hidden-xs'>Material</th>
												<th class='hidden-xs'>lubrication</th>
												<th>Detail</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td >$listdatagenera[param4]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;shafting&#39;);' ><a > Delete </a></td></tr>

		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 18)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th> </th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>

			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;pipingsystem&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 19)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Item</th>

												<th>Rated Power</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>

			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;mainpower&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 20)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Compartement Capacity</th>
												<th>Volume 100%Full(CuM)</th>
												<th>Weight 100% Full(ton)</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;capacitytank&#39;);' ><a > Delete </a></td></tr>
		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	elseif ($act == 21)
		{
		echo "<table class='table table-hover' id='sample-table-1'><thead><tr>
												<th class='center'>#</th>
												<th>Item</th>
												<th class='hidden-xs'>Model No</th>
												<th class='hidden-xs'>manufacture</th>
												<th>manufacture Number</th>
												<th>SWL(ton)</th>
												<th class='hidden-xs'></th>
												</tr></thead><tbody><tr>";
		$n = 1;
		foreach($listdatageneral as $listdatagenera)
			{
			echo "<tr><td class='center'>$n</td>
			  <td >$listdatagenera[param1]</td>
			  <td >$listdatagenera[param2]</td>
			  <td >$listdatagenera[param3]</td>
			  <td >$listdatagenera[param4]</td>
			  <td >$listdatagenera[param5]</td>
			  <td href='' onClick='dellGeneraldata($pieces[1],$listdatagenera[id],$act,&#39;liftingequipment&#39;);' ><a > Delete </a></td></tr>

		";
			$n++;
			}

		echo "</tbody></table>";
		die;
		}
	}

function uploadstamp($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj, $C_client, $kontrak)
	{
	$act = $_POST['act'];
	$modertion == "no";
	if (isset($act) && !empty($act))
		{
		}
	  else
		{
		$stringCommand = $_POST['stringCommand'];
		$pieces = explode("#", $stringCommand);
		$act = $pieces[0];
		}

	$listtipeApprovals = $drawing->GetTipeapprovalDrawing();
	$kodetipeapproval = array();
	foreach($listtipeApprovals as $listtipeApproval)
		{
		$kodetipeapproval[$listtipeApproval['id_status']] = $listtipeApproval['code'];
		}

	if ($act == "add")
		{
		$id_kon = $_POST['idkontrak'];
		$id_drawing = $_POST['no_edrawinggg'];
		$gambar = $_POST['judulstamp'];
		$sdfsdfsd = $_POST['textfielddrawingnumber'];
		$rev = $_POST['revgam'];
		$tipeApprovaldrawing = $_POST['tipeApprovaldrawing'];

		//echo $tipeApprovaldrawing ;
		//die; 
		// cek exist stamp
		// upload file
		// echo $id_kon . "-" . $id_drawing . "-" . $rev ;

		if ($drawing->CekExistDrawing($id_kon, $id_drawing, $rev) == false)
			{
				$randomname = "stamp_" . getRandomFilename() . ".pdf";

				if($drawing->CekHUmanErrorByfilename($_FILES["upload"]["name"],$id_drawing,$rev,$id_kon)== true){ //check filename apakah sudah sesuai dengan yang harus di upload
					if ($drawing->uploadfilePDF($_FILES["upload"]["tmp_name"], $randomname, "../data/" . $id_kon . "/"))
						{
							
							//echo $_FILES["upload"]["name"] ;
						$drawing->InsertUploadStamp($id_drawing, $user_id, $gambar, $id_kon, $sdfsdfsd, "../data/" . $id_kon . "/" . $randomname, $rev,$tipeApprovaldrawing);

						// insertlogsAplikasi
						$obj->WriteLogAplicationLogs($user_id, $id_kon, "Upload Stamp ", $user_id, "", 0, 0, "../data/" . $id_kon . "/" . $randomname);

						//update progress task enginerr
						
						$drawing->UpdateTaskkprojectUSer($id_drawing,$rev,50,$user_id);
						$idArr = $drawing->updateTextTask($id_drawing,$rev, "submit");
						//var_dump($idArr);
						foreach($idArr as $id)
						{
							$obj->updateTaskNotif($id, $user_id, "submitted");
						}

						}
				}else{
					$nomesrubgambar= $drawing->GetIDDrawingSubFromIdgambardanrev($id_drawing,$rev) ;
					echo "Rename file anda dengan mengandung unsur di dekat file extension: ###" . $nomesrubgambar . "### misal : <strong> abcasdasd_###" .  $nomesrubgambar . "###.pdf </strong>" ; 
				}
			}
		  else
			{
			echo "<script>alert('fail, Already uploded')</script>";
			}
		}
	elseif ($act == "refressh")
		{
		$id_kon = $pieces[1];
		}
	elseif ($act == "dell")
		{
		$id_kon = $pieces[1];
		$idgambar = $pieces[2];

		if ($drawing->CekAlreadyReview($idgambar))
			{
			echo "<script>alert('cant dell already approve')</script>";
			}
		  else
			{
			$drawing->DeletedUploadStamp($idgambar, $id_kon);

			// insertlogsAplikasi

			$obj->WriteLogAplicationLogs($user_id, $id_kon, "Dell uploaded stamp Download", $user_id, "", 0, 0, "" . $stringCommand);
			}
		}
	elseif ($act == "dellmode")
		{
		$id_kon = $pieces[1];
		$idgambar = $pieces[2];
		$tipe = $pieces[3];
		$stamp = $drawing->getUploadStampArray($idgambar,$id_kon);
		$drawing->DeletedUploadStamp($idgambar, $id_kon);
		//var_dump($stamp);
		$drawing->UpdateTaskkprojectUSer($stamp['id_gambar'],$stamp['rev'],40,$user_id);
		$idArr = $drawing->updateTextTask($stamp['id_gambar'],$stamp['rev'], "reject");
		foreach($idArr as $id)
		{
			$obj->updateTaskNotif($id, $user_id, "rejected");
		}
		$modertion = "yes";

		// insertlogsAplikasi

		$obj->WriteLogAplicationLogs($user_id, $id_kon, "Dell Uploaded stamp", $user_id, "", 0, 0, "" . $stringCommand);
		}
	elseif ($act == "refreshmoderation")
		{
		$id_kon = $pieces[1];
		$tipe = $pieces[2];
		$modertion = "yes";
		}
	elseif ($act == "moderationStamp")
		{
		$id_kon = $pieces[1];
		$idgambar = $pieces[2];
		$tipe = $pieces[3];

		$drawing->UpdateUploadStamp($user_id, 1, $idgambar);
		$gambardetails = $drawing->get_UploadStampByid($idgambar, $id_kon); //get drawing detail
		foreach($gambardetails as $gambardetail)
		{
			$drawing_numberss = $gambardetail['nodrawing'];
			$idDrawing = $gambardetail['id_gambar'];
		}

		$drawingInfo = $drawing->get_proj_gambar_id($idDrawing);
		foreach($drawingInfo as $drw)
		{
			$title = $drw['judul'];
		}

		// insertlogsAplikasi

		$obj->WriteLogAplicationLogs($user_id, $id_kon, "Moderation stamp", $user_id, "", 0, 0, "" . $stringCommand);
		$modertion = "yes";
		$C_client = new client();
		$C_client->insertLogSyncClient(2, $id_kon, 'New Drawing Review ' . $drawing_numberss);

		//notification riz1212
			/*$item = "Plan approval has been issued";
			$desc = "<p>Review of drawing number $drawing_numberss $title has been issued</p>";
			$link = "link here";

			$C_client->insertNotification($id_kon, $item, $desc, $link, "approval");

			$users = $kontrak->getClientOfProject($id_kon);

			$res = $C_client->setNotifEmail($users, "(drawing number: $drawing_numberss $title)", $id_kon, "approval");


			if(!empty($res['address']))
			{
				$result = $obj->emailHandler("no-reply-zee@bki.co.id","Bahtera Zee", array(), $res['body'], "Zee Notification", $res['address']);
			}

			echo "<br>".$result;

			if($result == "Message sent!")
			{
				$C_client->setStatus($users, $id_kon, "mail", $res['notif'], "approval");
			}*/
		//
		}

	// nilai balik

	if ($modertion == "yes")
		{
		$listupload = $drawing->get_UploadStamp($id_kon,"all",$tipe);
		$idTable = 'modStamp';
		}
	  else
		{
		$listupload = $drawing->get_UploadStamp($id_kon, $user_id);
		$idTable = 'engStamp';
		}

	$strlistgambar = "<table class='table table-striped table-bordered table-hover' id='sample_$idTable'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>Nama </th>
											<th>Tipe</th>
											<th>date</th>
											<th>Approve</th>
											<th>Approve date</th>
											<th>Status</th>
											<th></th>
																					
										</tr>
									</thead>
									<tbody>";
	$no = 1;
	foreach($listupload as $get_draw)
		{

		// $z=$get_draw['tipe'];
		// $perant=$get_draw[id_kontrak] . "," . $get_draw['id']  ;

		if ($modertion == "yes")
			{
			//$strModeration = "<a class='btn btn-primary' href='#' onclick='reviewStamp($get_draw[id],$id_kon)'><i class='fa fa-share'></i></a>   <a class='btn btn-bricky' href='#' onclick='dellStampuploadmnager($get_draw[id],$id_kon)'><i class='glyphicon glyphicon-remove-circle'></i></a>";
			$strModeration = "<div class='btn-group'>
							    <button type='button' class='btn btn-purple'>
							        <i class='fa fa-cogs'></i>
							        Action
							    </button>
							    <button data-toggle='dropdown' class='btn btn-purple dropdown-toggle'>
							        <span class='caret'></span>
							    </button>
							    
							    <ul class='dropdown-menu' role='menu'>
							        <li>
							            <a onclick='openApprovalPage($id_kon, $get_draw[id]);' href='#'>
							                <i class='fa fa-check'></i>
							                Stamp Review
							            </a>
							        </li>
							        <li>
							            <a href='#' onclick='reviewStamp($get_draw[id],$id_kon);'>
							                <i class='fa fa-exclamation'></i>
							                Emergency Stamp Review
							            </a>
							        </li>
							        <li class='divider'></li>
							        <li>
							            <a href='#' onclick='dellStampuploadmnager($get_draw[id],$id_kon)'>
							                <i class='fa fa-trash-o'></i>
							                Delete Stamp
							            </a>
							        </li>
							    </ul>
							</div>"; 
			$strClick = $get_draw['nodrawing'];
			}
		  else
			{
			$strModeration = "<a class='btn btn-bricky' href='#' onclick='dellStampupload($get_draw[id],$id_kon)'><i class='glyphicon glyphicon-remove-circle'></i></a>";
			$strClick = "<a href='enginerrview.php?module=stamp&kon=" . $id_kon . "&gam=$get_draw[id]' target=_blank>" . $get_draw['nodrawing'] . " </a>";
			}

		// $nomergambar=  $get_draw['no_gambar'];

		$strlistgambar = $strlistgambar . "<tr >
									<td >$no</td>
									<td >$strClick</td>
									<td >" . $get_draw['gambar'] . " </a></td>
									<td>" . $tipegambbararr[$get_draw['tipe']] . "</td>
									<td >" . $get_draw['tanggal'] . "</td>
									<td>" . $alluserArray[$get_draw['review']] . "</td>
									<td>" . $get_draw['reviewdate'] . "</td>
									<td>" . $kodetipeapproval[$get_draw['drawingstatus']] . "</td>
									<td>" . $strModeration . "</td>

																	
									</tr>";
		$no++;
		}

	$strlistgambar = $strlistgambar . "</tbody></table><script> generatedTable('$idTable');</script>";
	echo $strlistgambar;
	}

function downloadreq($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj)
	{
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	$listgambar = "no";
	$moderationdrawing = "no";
	if ($act == "add")
		{
		$id_kon = $pieces[1];
		$id_drawing = $pieces[2];
		$nodrawing = $pieces[3];
		$drawing->insert_requestdownload($user_id, $id_kon, $id_drawing, $nodrawing);

		// insertlogsAplikasi

		$obj->WriteLogAplicationLogs($user_id, $id_kon, "Request Download", $user_id, "", 0, 0, "" . $stringCommand);
		}
	elseif ($act == "refreshlistgambar")
		{
		$id_kon = $pieces[1];
		$tipe = $pieces[2];
		$listgambar = "yes";
		}
	elseif ($act == "refreshrequestdownload")
		{
		$id_kon = $pieces[1];
		$tipe = $pieces[2];
		}
	elseif ($act == "refreshrequestmoderationdownload")
		{
		$id_kon = $pieces[1];
		$moderationdrawing = "yes";
		}
	elseif ($act == "moderationDownload")
		{
		$id_kon = $pieces[1];
		$id = $pieces[3];
		$nilai = $pieces[2];
		$moderationdrawing = "yes";

		// security managaer

		$drawing->moderationDownloadDrawing($user_id, $nilai, $id);

		// insertlogsAplikasi

		$obj->WriteLogAplicationLogs($user_id, $id_kon, "Moderasi Drawing", $user_id, "", 0, 0, "" . $stringCommand);
		}

	if ($moderationdrawing == "yes")
		{
		$listdownloadReq = $drawing->get_DownloadDrawing($id_kon);
		$strlistgambar = "<table class='table table-striped table-bordered table-hover' id='sample_3'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>Title </th>
											<th>tanggal </th>
											<th>status</th>
											<th>Approveby</th>
											<th>Approveby date</th>
											<th>Download date</th>
											<th>User req</th>
											<th>IP</th>
											<th></th>
											
										</tr>
									</thead>
									<tbody>";
		$no = 1;
		foreach($listdownloadReq as $get_draw)
			{
			if ($get_draw['status'] == 1)
				{
				$strdownload = "<a href='' >" . "Download.</a> ";
				}
			  else
				{
				$strdownload = "";
				}

			$strlistgambar = $strlistgambar . "<tr >
									<td >$no</td>
									<td >" . $get_draw['drawingno'] . " </td>
									<td >" . $get_draw['judul'] . " </td>
									<td >" . $get_draw['tanggal'] . " </a></td>
									<td >" . $get_draw['status'] . "</td>
									<td>" . $alluserArray[$get_draw['aprroveby']] . "</td>
									<td >" . $get_draw['approvedate'] . "</td>
									<td >" . $get_draw['downloadtime'] . "</td>
									<td>" . $alluserArray[$get_draw['userid']] . "</td>
									<td>" . $get_draw['ip'] . "</td>
									<td>
									<a class='btn btn-primary' href='#' onclick='moderationdownload($get_draw[id],$id_kon,1)'><i class='fa fa-share'></i></a>
									<a class='btn btn-bricky' href='#' onclick='moderationdownload($get_draw[id],$id_kon,0)'><i class='glyphicon glyphicon-remove-circle'></i></a>
									
									</td>																	
									</tr>";
			$no++;
			}

		$strlistgambar = $strlistgambar . "</tbody></table><script> generatedTable(3);</script>";
		echo $strlistgambar;
		die;
		}

	if ($listgambar == "yes")
		{
		$listdrawingstored = $drawing->get_gambarby_tipe($id_kon, $tipe);

		// nilai balik

		$strlistgambar = "<table class='table table-striped table-bordered table-hover' id='sample_4'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>Nama </th>
											<th>Tipe Gambar</th>
											<th>Masuk</th>
											<th>rev</th>
											<th>Request</th>
											
																						
										</tr>
									</thead>
									<tbody>";
		$no = 1;
		foreach($listdrawingstored as $get_draw)
			{
			$z = $get_draw['tipe'];
			$perant = $get_draw['id_kontrak'] . "," . $get_draw['id'];
			$nomergambar = $get_draw['no_gambar'];
			$strlistgambar = $strlistgambar . "<tr >
									<td >$no</td>
									<td > <a href='panel.php?module=listrevision&id=" . $id_kon . "&mod=2&draw=$get_draw[id] '>" . $get_draw['no_gambar'] . " </a></td>
									<td >" . $get_draw['judul'] . " </a></td>
									<td >" . $tipegambbararr[$z] . "</td>
									<td>" . $get_draw['tanggal'] . "</td>
									<td>" . $get_draw['rev'] . "</td>
									<td>" . "<a  onClick='requestdownload($get_draw[id],$id_kon,&#34;$nomergambar&#34;);'>" . "Req</a> " . "</td>
																	
									</tr>";
			$no++;
			}

		$strlistgambar = $strlistgambar . "</tbody></table><script> generatedTable(4);</script>";
		echo $strlistgambar;
		die;
		}

	// nilai balik

	$listdownloadReq = $drawing->get_DownloadDrawing($id_kon, $user_id);
	$strlistgambar = "<table class='table table-striped table-bordered table-hover' id='sample_5'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>tanggal </th>
											<th>status</th>
											<th>Approveby</th>
											<th>downloadtime</th>
											<th>download</th>
											
											
																						
										</tr>
									</thead>
									<tbody>";
	$no = 1;
	foreach($listdownloadReq as $get_draw)
		{
		$perant = $get_draw['id_kontrak'] . "," . $get_draw['id'];
		if (($get_draw['status'] == 1) && ($get_draw['downloadtime'] == "0000-00-00 00:00:00"))
			{
			$strdownload = "<a href='drawingdownload.php?id=$get_draw[id]' target=_blank >" . "Download.</a>  &nbsp; | &nbsp; " . "<a href='drawingdownloadzip.php?id=$get_draw[id]' target=_blank >" . "ZIP.</a>" ;
			}
		  else
			{
			$strdownload = "";
			}

		$strlistgambar = $strlistgambar . "<tr >
									<td >$no</td>
									<td >" . $get_draw['drawingno'] . " </td>
									<td >" . $get_draw['tanggal'] . " </a></td>
									<td >" . $get_draw['status'] . "</td>
									<td>" . $alluserArray[$get_draw['aprroveby']] . "</td>
									<td>" . $get_draw['downloadtime'] . "</td>
									<td>" . $strdownload . "</td>
																	
									</tr>";
		$no++;
		}

	$strlistgambar = $strlistgambar . "</tbody></table><script> alert('done');  generatedTable(5);</script>";
	echo $strlistgambar;
	}

function technical($Activity, $user_id, $kontrak, $alluserArray, $salting, $C_client, $obj)
	{
	$C_client = new client();
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	$assotioan = "no";
	if ($act == "update")
		{
		$id = $pieces[1];
		$answer = $pieces[3];
		$id_kon = $pieces[2];
		$C_client->Answertechnical($id, $answer, $user_id);
		//echo "sapi" ;
		$C_client->insertLogSyncClient(3, $id_kon, 'Answer technical Query ' . $answer);
		$obj->WriteLogAplicationLogs($user_id, $pieces[2], "Answer technical", $user_id, "Answer technical", 0, 0, $stringCommand);

		$tech = $C_client->getQuestion($id);
		foreach($tech as $t)
		{
			$question = $t['subject'];
		}

		//notification riz1212
		$item = "Technical query no $id has been answered";
		$desc = "<p>Query about '$question' has been answered</p>
				 <p>Answer:</p>
				 <p>$answer</p>";
		$link = "panel.php?module=project&projid=$id_kon&techq=1";

		$result = $C_client->notificationProcess($id_kon, $item, $desc, $link, "query", $kontrak, $obj);
		echo $result;

		/*$C_client->insertNotification($id_kon, $item, $desc, $link, "query");

		$users = $kontrak->getClientOfProject($id_kon);

		$res = $C_client->setNotifEmail($users, "", $id_kon, "query");


		if(!empty($res['address']))
		{
			$result = $obj->emailHandler("no-reply-zee@bki.co.id","Bahtera Zee", array(), $res['body'], "Zee Notification", $res['address']);
		}

		echo $result;

		if($result == "Message sent!")
		{

			$C_client->setStatus($users, $id_kon, "mail", $res['notif'], "query");

		}*/
		//end notif

		}
	elseif ($act == "dell")
		{
		$id = $pieces[1];
		$C_client->dellTechnical($id);
		$id_kon = $pieces[2];
		$obj->WriteLogAplicationLogs($user_id, $pieces[2], "dell technical", $user_id, "Answer technical", 0, 0, $stringCommand);
		}
	elseif ($act == "refresh")
		{
		$id_kon = $pieces[1];
		}
	elseif ($act == "dashboard")
		{
		$id = $pieces[1];
		$total = $C_client->GetCountAllTechnical($id);
		$answer = $C_client->GetCountAnswerTechnical($id);
		echo $total . "/" . $answer;
		die;
		}

	$n = 1;

	// nilai balik

	$listTechnical = $C_client->GetTechnicalAsk($id_kon);
	/*echo "<pre>";
	print_r($listTechnical);
	echo "</pre>";*/
	$tableStr = "<table class='table table-striped table-bordered table-hover' id='sample_8'>
											<thead>
												<tr>
													
													<th>#</th>
													<th >date</th>
													<th  >Subject</th>
													<th  >Ask</th>
													<th  >by</th>
													<th  >Answer</th>
													<th  >by</th>
													<th >date Answ</th>
													<th >Attachment</th>
													<th></th>
												</tr>
											</thead><tbody>";
	foreach($listTechnical as $listassosiat)
	{
		if($listassosiat['attachment'] == "none" || is_null($listassosiat['attachment']))
		{
			$attached = "none";
		}else
		{
			$attached = "<a href='https://armada.bki.co.id/Zee-client/$listassosiat[attachment]' target='_blank'>File</a>";
		}
		$usernya = $alluserArray[$listassosiat['answerby']];
		$tableStr = $tableStr. "
											
											
												<tr>
													
													<td>$n</td>
													<td > $listassosiat[createon]</td>
													<td > $listassosiat[subject]</td>
													<td > $listassosiat[ask]</td>
													<td > $listassosiat[aka]</td>
													<td > $listassosiat[answer]</td>
													<td > $usernya</td>
													<td > $listassosiat[answeron]</td>
													<td > $attached</td>

													<td class='center'>
													<div class='visible-md visible-lg hidden-sm hidden-xs'>
														<a href='#' onclick='dellTechnical($listassosiat[id],$id_kon);'class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
														<a href='#' onclick='AnswerTechnical($listassosiat[id],$id_kon);'class='btn btn-blue tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-share fa fa-white'></i></a>

													</div>

													</td>
												</tr>";
		$n++;
		}

	$tableStr = $tableStr. "</tbody>
										</table><script> generatedTable(8);</script>";
	echo $tableStr;
	}

function faq($Activity, $user_id, $kontrak, $alluserArray, $salting, $C_client)
	{
	$C_client = new client();
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	if ($act == "add")
		{
		$subject = $pieces[1];
		$description = $pieces[2];
		$C_client->insertFaq($subject, $description, $user_id);
		}
	elseif ($act == "dell")
		{
		$id = $pieces[1];
		$C_client->dellfaq($id);
		}

	// nilai balik

	$listfaq = $C_client->Getfaq();
	$n = 1;
	echo "<table class='table table-striped table-bordered table-hover' id='projects'>
											<thead>
												<tr>
													
													<th>#</th>
													<th >Subject</th>
													<th class='hidden-xs' >Description</th>
													
													<th></th>
												</tr>
											</thead><tbody>";
	foreach($listfaq as $listassosiat)
		{
		echo "
											
											
												<tr>
													
													<td>$n</td>
													<td class='hidden-xs'> $listassosiat[subject]</td>
													<td class='hidden-xs'> $listassosiat[description]</td>
													
													
													
													<td class='center'>
													<div class='visible-md visible-lg hidden-sm hidden-xs'>
														<a href='#' onclick='dellfaq($listassosiat[id]);'class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>

													</div>

													</td>
												</tr>";
		$n++;
		}

	echo "</tbody>
										</table>";
	}

function client($Activity, $user_id, $kontrak, $alluserArray, $salting, $C_client)
	{
	$C_client = new client();
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	$assotioan = "no";
	if ($act == "add")
		{
		$nick = $pieces[1];
		$sandi = $pieces[4];
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()) , true));

		// Create salted password (Careful not to over season)

		$sandi = hash('sha512', $sandi . $random_salt);
		$garam = $random_salt;
		$user = $user_id;
		$aka = $pieces[2];
		$email = $pieces[3];
		$tlp= $pieces[5];
		$company= $pieces[6];
		$hp= $pieces[7];
		$kontrak->insertClient($nick, $sandi, $garam, $user, $aka, $email,$tlp,$company,$hp);
		$id = $kontrak->lastInsertId();
		$C_client->insertClient($nick, $sandi, $garam, $user, $aka, $email, $id);
		}
	elseif ($act == "del")
		{
		$id = $pieces[1];
		$kontrak->dellClient($id);
		$C_client->dellClient($id);
		}
	elseif ($act == "reset")
		{
		$id = $pieces[1];
		$sandi = $pieces[2];
		$random_salt = hash('sha512', uniqid(mt_rand(1, mt_getrandmax()) , true));
		$sandi = hash('sha512', $sandi . $random_salt);
		$kontrak->update_passClientuser($id, $sandi, $random_salt);
		$C_client->update_passClientuser($id, $sandi, $random_salt);
		echo "<script>alert('done')</script>";
		}
	elseif ($act == "update")
		{
		$nick = $pieces[1];
		$id = $pieces[4];
		$aka = $pieces[2];
		$email = $pieces[3];
		$tipeClient = $pieces[5];
		$kontrak->update_infoClientuser($id, $aka, $nick, $email, $tipeClient);
		$C_client->update_infoClientuser($id, $aka, $nick, $email, $tipeClient);
		echo "<script>  location.reload(); </script>";
		die;
		}
	elseif ($act == "addassosiation")
		{
		$idclient = $pieces[1];
		$idproject = $pieces[2];
		$builder = $pieces[3];
		$colabortorr = $pieces[4];

		$kontrak->insertClientassosiated($idproject, $user_id, $idclient,$builder,$colabortorr);

		// die;

		$assotioan = "yes";
		}
	elseif ($act == "dellassosiation")
		{
		$idclient = $pieces[1];
		$idassotided = $pieces[2];
		$assotioan = "yes";
		$kontrak->dellClientassosiated($idassotided);
		}
	elseif ($act == "refreshassosiation")
		{
		$idclient = $pieces[1];
		$assotioan = "yes";
		}
	elseif ($act == "lock")
		{
		$id = $pieces[1];
		$lock = $pieces[2];
		$kontrak->update_lockClientuser($id, $lock);
		$C_client->update_lockClientuser($id, $lock);
		}
	elseif($act == "grefreshClientproject")
		{
		$projid = $pieces[1];
		$getClientproject=true ;
		}
	elseif($act=="AddclientProject"){

		$projid = $pieces[1];
		$userclientid = $pieces[2];
		$groupt = $pieces[4];
		$status = $pieces[3];

		$kontrak->insertClientassosiated($projid, $user_id, $userclientid,$groupt,$status);

		$getClientproject=true ;

	}elseif ($act == "dellassosiationproject")
		{
		$projid = $pieces[3];
		$idassotided = $pieces[2];
		$getClientproject = true;
		$kontrak->dellClientassosiated($idassotided);
		}	


		


	//nilai balik client project
	
	if ($getClientproject==true){

		$listclients=$kontrak->getClientlist( $projid);	
		foreach ($listclients as $listclient) {
			$strClientcombo=$strClientcombo. "<option value='$listclient[id_client]' >$listclient[aka] - $listclient[company] - $listclient[email] </option>";
		}

		$hasils = $kontrak->GetuserOnProject( $projid);	
		

			$STRtABLECLIENT= "	
			<hr>
			<form role=form' id='uploadStamp'  name='uploadStamp' class='form-horizontal'>
			                            <div class='form-group'>
                                          <label class='col-sm-2 control-label' for='form-field-1'>
                                          Name
                                          </label>
                                          <div class='col-sm-9'>
                                             <select name='userclientidasd' class='col-sm-2 form-control' id='userclientidasd'>
                                             $strClientcombo
                                             </select>
                                          </div>
                                       </div>
                                       <div class='form-group'>
                                          <label class='col-sm-2 control-label' for='form-field-1'>
                                          Status
                                          </label>
                                          <div class='col-sm-9'>
                                             <select name='statusClient' class='col-sm-2 form-control' id='statusClient'>
                                             <option value='0' >Client</option>
                                             <option value='1' >colaborator</option>
                                             <option value='2' >QC</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class='form-group'>
                                          <label class='col-sm-2 control-label' for='form-field-1'>
                                          Group Team
                                          </label>
                                          <div class='col-sm-9'>
                                             <select name='groupteam' class='col-sm-2 form-control' id='groupteam'>
                                             <option value='0' >Builder</option>
                                             <option value='1' >Owner</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class='form-group'>
                                          <label class='col-sm-2 control-label' for='form-field-1'>
                                          
                                          </label>
                                          <div class='col-sm-9'>
                                       <button type='button' class='btn btn-green' onclick='addUserTossosiated($projid);''>
                                       Add user
                                       </button>
                                          </div>
                                       </div>
                                       <p>
                                       <hr>
										</hr>
				</form>							
								<table class='table table-striped table-bordered table-hover' id='sample_25'>
											<thead>
												<tr>
													
													<th >no</th>
													<th >AKA</th>
													<th>email</th>
													<th>company</th>
													<th>status</th>
													<th>Group</th>
													<th></th>
												</tr>
											</thead><tbody>";
		$arrGroupteam= array('Builder','Owner' );	
		$arrGroupStatus= array('Client','Colaborator','QC' );			
		$n=1;							
		foreach ($hasils  as $hasil) 
		{
			$idclient=intval($hasil[id_client]);
												# code...
														
					$STRtABLECLIENT=$STRtABLECLIENT .  "<tr>
													
													
													<td > $n</td>
													<td > $hasil[aka]</td>
													<td > $hasil[email]</td>
													<td > $hasil[company]</td>
													<td >".  $arrGroupStatus[$hasil['colaborator']] . "</td>
													<td >" .  $arrGroupteam[$hasil['groupteam']] . "</td>
													<td ><a href='#' onClick='dellClientassosiatedProject($idclient,$hasil[id],$projid)'>Dell</a></td>

												</tr>";




		$n++; 
		}									
			echo $STRtABLECLIENT . "</tbody></table><script>generatedTable(25)</script>";
		die;	

	}		


	// nilai balik

	if ($assotioan == "yes")
		{
		echo "<table class='table table-striped table-bordered table-hover' id='projects'>
											<thead>
												<tr>
													<th>id client</th>
													<th>Project</th>
													<th class='hidden-xs'>Starting</th>
													<th>due</th>
													<th>Progress</th>
													<th>contract</th>
													<th>Class</th>
													<th>Group</th>
													<th>Status</th>
													<th></th>
												</tr>
											</thead><tbody>";
		$listassosiated = $kontrak->getClientlistassosiatedid($idclient);

		$arrGroupteam= array('Builder','Owner' );	
		$arrGroupStatus= array('Client','Colaborator','QC' );	

		foreach($listassosiated as $listassosiat)
			{
			echo "
											
											
												<tr>
													<td>$listassosiat[id_client]</td>
													<td><a href='panel.php?module=projectMod&idproj=$listassosiat[object_id]'>$listassosiat[project]</a></td>
													<td class='hidden-xs'> $listassosiat[starting]</td>
													<td class='hidden-xs'> $listassosiat[due]</td>
													<td>$listassosiat[progress]</td>
													<td>$listassosiat[id_kontrak]</td>
													<td>$listassosiat[class_id]</td>
													<td>" . $arrGroupteam[$listassosiat['groupteam']] . "</td>
													<td>" . $arrGroupStatus[$listassosiat['colaborator']] . "</td>
													
													<td class='center'>
													<div class='visible-md visible-lg hidden-sm hidden-xs'>
														<a href='#' onclick='dellClientassosiated($listassosiat[id_client],$listassosiat[id]);'class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>

													</div>

													</td>
												</tr>";
			}

		echo "</tbody>
										</table>";
		die;
		}

	echo "		
								<table class='table table-striped table-bordered table-hover' id='sample_5'>
											<thead>
												<tr>
													<th>ID</th>
													<th>Nick</th>
													<th class='hidden-xs'>AKA</th>
													<th>email</th>
													<th>company</th>
													<th>Status</th>
													<th>tanggal</th>
													<th></th>
												</tr>
											</thead><tbody>";
	$projectlists = $kontrak->getClientlist();
	$n=1;
	foreach($projectlists as $projectlist)
		{
		$tanggalselesai = date("d M Y", strtotime($projectlist['tanggal']));
		if ($projectlist['locked'] == 0)
			{
			$status = "Active";
			$nilai = 1;
			}
		  else
			{
			$status = "Locked";
			$nilai = 0;
			}

		echo "
											
											
												<tr>
													<td>$n</td>
													<td><a href='panel.php?module=clientproject&clientid=$projectlist[id_client]'>$projectlist[nick]</a></td>
													<td class='hidden-xs'> $projectlist[aka]</td>
													<td>$projectlist[email]</td>
													<td>$projectlist[company]</td>
													<td>$status</td>
													<td class='hidden-xs'>
													$tanggalselesai</td>
													
													<td class='center'>
													<div class='visible-md visible-lg hidden-sm hidden-xs'>
														<a href='#' onclick='dellClientProject($projectlist[id_client]);'class='btn btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
														<a href='#' onclick='lockClientProject($projectlist[id_client],$nilai);'class='btn btn-green tooltips' data-placement='top' data-original-title='lock'><i class='fa fa-edit fa fa-white'></i></a>
														<a href='#' onclick='ResetClientProject($projectlist[id_client]);'class='btn btn-teal tooltips' data-placement='top' data-original-title='change passwords'><i class='fa fa-share fa fa-white'></i></a>
													</div>

													</td>
												</tr>";
												$n++;
		}

	echo "</tbody>
										</table><script>generatedTable(5)</script>";
	}

function cost($Activity, $user_id, $kontrak, $alluserArray, $salting, $obj, $drawing, $currencyarray)
	{
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	if ($act == "refreshcost")
		{
		$idKegiatan = $pieces[1];
		$tipeKegiatan = 1;
		}
	elseif ($act == "refreshincome")
		{
		$idKegiatan = $pieces[1];
		$tipeKegiatan = 2;
		}
	elseif ($act == "del")
		{
		$idKegiatan = $pieces[1];
		$idcost = $pieces[2];
		$tipeKegiatan = $pieces[3];
		$kontrak->dellCostproject($idcost);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Dell income/cost", $user_id, "Dell income/cost", 0, 0, $stringCommand);
		}
	elseif ($act == "add")
		{
		$nam = $pieces[1];
		$cost = $pieces[2];
		$currency = $pieces[3];
		$tipeKegiatan = $pieces[6];
		$idKegiatan = $pieces[7];
		$decription = $_POST['richtext1'];
		$realisation = $pieces[9];
		$idr = $pieces[5];
		$kurs = $pieces[4];
		$total = $pieces[8];

		$namabaru = "fin_" . getRandomFilename() . "_"  . date("Y-m-d") . ".pdf";
		$alamat = "../data/" .$idKegiatan. "/"; //generate the destination path
		
		if($_FILES['upload']['error'] != 4)
		{
			if ($_FILES['upload']['tmp_name'])
			{
				if ($drawing->uploadfilePDF($_FILES["upload"]["tmp_name"], $namabaru, $alamat, 'noencript'))
				{
					$alamat = $alamat . $namabaru;
					$kontrak->Insertcostproject(ht($nam) , $cost, $currency, $tipeKegiatan, $idKegiatan, ht($decription) , $realisation, $idr, $kurs, $total, $user_id, $alamat);
				}
				else
				{
					echo "<script> alert('fail to upload docs ')</script>";
				}
			}
		}else
		{
			echo "insert<br>";
			$kontrak->Insertcostproject(ht($nam) , $cost, $currency, $tipeKegiatan, $idKegiatan, ht($decription) , $realisation, $idr, $kurs, $total, $user_id);
		}

		
		$obj->WriteLogAplicationLogs($user_id, $pieces[7], "Add income/cost", $user_id, "Add income/cost", 0, 0, $stringCommand);
		}

	if ($tipeKegiatan == 1)
		{
		$scostcheck = "checked='checked'";
		$sincome = "";
		}
	  else
		{
		$scostcheck = "";
		$sincome = "checked='checked'";
		}

	// nilai balik
	$listCosts = $kontrak->getCostprojectbyid($idKegiatan, $tipeKegiatan);
	echo "									<label class='radio-inline' onclick='refreshcost($idKegiatan);' >
										<input type='radio' value='' name='optionsRadioss' $scostcheck  onclick='refreshcost($idKegiatan);'>
										Cost
									</label>
									<label class='radio-inline'  onclick='refreshincome($idKegiatan);'  >
										<input type='radio' value='' name='optionsRadioss' $sincome onclick='refreshincome($idKegiatan);' >
										Income
									</label>
									<p>
									
									<table class='table table-striped table-bordered table-hover' id='sample_9'>
										<thead>
											<tr>
												<th > ID</th>
												<th > Cost Name</th>
												<th > currency</th>
												<th > Valuta </th>
												<th > Rp. </th>
												<th > Total </th>
												
												<th > Realization</th>
												<th > File</th>
												<th class='center'> Action</th>

											</tr>
										</thead>
										<tbody>";
	$n = 1;
	foreach($listCosts as $listCost)
		{

		// $label= labelStyle($listTraining[status],$listTraining[status]);

		$currency = $currencyarray[$listCost['currency']];
		$dateRealization = date("d M Y", strtotime($listCost['realisation']));
		$costformat = number_format($listCost['cost']);
		$formatliscost = number_format($listCost['idr']);
		$formatliscosTotal = "Rp " . number_format($listCost['total']);
		if($listCost['file'] == "none" || empty($listCost['file']))
		{
			$path = "none";
		}else
		{
			$path = "<a href=". $listCost['file'] . " target='_blank'>File</a>";
		}
		echo " <tr>
												<td>$n</td>
												<td><a href='panel.php?module=dcost&id=$listCost[id]&idpro=$idKegiatan' target='_blank' > $listCost[nam] </a></td>
												<td>$currency</td>
												<td>$costformat </td>
												<td>	$formatliscost </td>
												<td>$formatliscosTotal </td>
												
												<td>$dateRealization</td>
												<td>$path</td>
												<td class='center'>
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													
												
													<a  onclick='delcost($listCost[id],$idKegiatan,$tipeKegiatan);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
		$n++;
		}

	echo "</tr>
										</tbody>
									</table><script> generatedTable(9);</script>";
	}

function moderation($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $obj, $statu_s, $C_client,$kontrak)
	{
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	if ($act == "refresh")
		{
		$id_kon = $pieces[1];
		}
	elseif ($act == "update")
	{
		$id_coment = $pieces[2];
		$code = $pieces[1];
		$nilai = $pieces[3];
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$id_kon = $code;
		$semb = $comment->get_db_comment_id($id_coment);
		foreach($semb as $sem)
			{
			$open_c = $sem['status'];
			$repl = substr($sem['comment'], 0, 100);
			$nomercomm = $sem['nomer_comment'];
			$commContent = $sem['comment'];
			}

		$comment->update_db_comment_stat($nilai, $open_c, $id_coment);
		if ($nilai == 3)
		{
			$comment->review_db_comment($user_id, $current_date, $id_coment);
			$C_client = new client();
			$C_client->insertLogSyncClient(1, $id_kon, 'New Publish Comment ' . $nomercomm);

			//notification riz1212
			/*$item = "Design comment has been issued";
			$desc = "<p>Comment no $nomercomm has been issued</p>
					 <p>Comment:</p>
					 <p>$commContent</p>";
			$link = "panel.php?module=comment&projid=$id_kon&com=$id_coment";

			$C_client->insertNotification($id_kon, $item, $desc, $link, "comment");

			$users = $kontrak->getClientOfProject($id_kon);

			$res = $C_client->setNotifEmail($users, "(comment number: $nomercomm)", $id_kon, "comment");


			if(!empty($res['address']))
			{
				$result = $obj->emailHandler("no-reply-zee@bki.co.id","Bahtera Zee", array(), $res['body'], "Zee Notification", $res['address']);
			}

			echo "<br>".$result;

			if($result == "Message sent!")
			{
				$C_client->setStatus($users, $id_kon, "mail", $res['notif'], "comment");
			}*/
		}

		$comment->insert_comment_log('Merubah posisi Comment : <span class=error > ' . $repl . '</span> -..  ke posisi ' . $nilai, $id_coment, $id_kon, $current_date, $user_id);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Moderation Comment", $user_id, "Moderation Comment", 0, 0, $stringCommand);
		//notification end
	}

	// nilaibalik

	$get_comments = $comment->get_db_comment_moderation($id_kon);
	$zz = $Users->get_users();
	foreach($zz as $z)
		{
		$x = $z['id_user'];
		$userx[$x] = $z['nama'];
		}

	echo "<table class='table table-striped table-bordered table-hover' id='sample_13'>
									<thead>
										<tr>
											<th width='30'>No</th>
											<th width='250'>Drawing</th>
											<th width='100'>No Comment</th>
											<th >Comment </th>
											
											<th width='100'>Create by</th>
											<th width='100'>Date</th>
											<th width='100'>Position</th>
											<th width='50'>Status</th>
											<th width='100'>Action</th>
																						
										</tr>
									</thead>
									<tbody>";
	$no = 1;
	foreach($get_comments as $get_comment)
		{
		$d = $get_comment['create_by'];
		$tang = date("Y-m-d", strtotime($get_comment['tanggal']));
		$perant = $get_comment[id] . ",'" . $get_comment['id_kontrak'] . "',3";
		$perant2 = $get_comment[id] . ",'" . $get_comment['id_kontrak'] . "',1";
		echo "<tr class='odd gradeX'>
									<td >$no</td>
									<td>" . $get_comment['gambar'] . "</td>
									<td > <a href='panel.php?module=ed_cek&point=2&id=" . $proj_id . "&mod=2&com=$get_comment[id] '>" . $get_comment['nomer_comment'] . " </a></td>
									<td ><a href='panel.php?module=ed_cek&point=2&id=" . $proj_id . "&mod=2&com=$get_comment[id] '>" . $get_comment['comment'] . " </a></td>
									
									<td>" . $userx[$d] . "</td>
									<td>" . $tang . "</td>
									<td>" . $get_comment['point'] . "</td>
									<td>" . $statu_s[$get_comment['status']] . "</td>
									<td>" . "<a href='#'  onclick=" . "fung_moderat_comment(" . $perant . "); > Mod  | </a> " . "<a href='#'  onclick=" . "fung_moderat_comment(" . $perant2 . "); >   Cancel </a>   " . "</td>
																		
									</tr>";
		$no++;
		}

	echo "</tbody></table> <script> generatedTable(13);</script>";
	}

function commenting($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $obj, $statu_s, $C_client, $kontrak,$salting)
	{
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	if ($act == "refresh")
		{
		$proj_id = $pieces[1];
		}
	elseif ($act == "add")
		{

		// echo $stringCommand ;

		$commnet = trim($pieces[2]);
		$code = $pieces[1];
		$gambar = $pieces[3];
		$proj_id = $code;
		$commentcategory= $pieces[6];

		if ($commnet =="") { //jika comment kosong
			echo "<script>alert('Comment cant empty'); refreshcommentlist($proj_id);</script>";
			die;
		}

		// if ($pieces[5] == 'true')
		// 	{
		// 	$status = 2;
		// 	}
		//   else
		// 	{
		// 	$status = 0;
		// 	}

		if ($commentcategory==3){ // bila note maka otomatis status just info
			$status = 2;
		}elseif($commentcategory==1){
			$status = 1;
		}else{
			$status = 0;
		} 

		$point = 0;
		$current_date = Date("Y-m-d\ H:i:s\Z");
		$id_kon = $code;
		$piecess = explode(",", $gambar);
		$tipe = $pieces[4];
		$last_no_coms = $comment->get_db_comment_last($id_kon, $tipe);
		foreach($last_no_coms as $last_no_com)
			{
			$las_number = $last_no_com['nomer_comment'];
			}

		$las_number = str_replace($simb_gam[$tipe] . "-", "", $las_number);
		$nem_number = intval($las_number) + 1;
		$nomer = $simb_gam[$tipe] . "-" . $nem_number;
		$gam_bar = '';
		$gamb_infoRef = '';
		$piecess = array_unique($piecess);
		foreach($piecess as $piece)
			{
			$no_gams = $drawing->get_no_gambar_from_id($piece, $id_kon);
			$no_gams = array_unique($no_gams);
			foreach($no_gams as $no_gam)
				{
				$embuh = $no_gam['no_gambar'];
				$embuh2 = $no_gam['no_gambar'] . ", Rev. " . $no_gam['rev'];
				}

			if ($gam_bar != "")
				{
				$gam_bar = $gam_bar . "," . $embuh;
				$gamb_infoRef = $gamb_infoRef . ";" . $embuh2;
				}
			  else
				{
				$gam_bar = $embuh;
				$gamb_infoRef = $embuh2;
				}
			}

		$comment->insert_db_comment($nomer, $commnet, $gam_bar, $user_id, $point, $current_date, $id_kon, $tipe, $status, $gamb_infoRef,$commentcategory);
		$id_comen = $comment->lastInsertId();
		$comment->insert_comment_his($id_comen, $commnet, $user_id, $current_date, $id_kon); //gae history e lek ono update
		$kom_m = substr($commnet, 0, 100);
		$comment->insert_comment_log('Membuat komen baru : <span class=error > ' . $kom_m . '</span> -..', $id_comen, $id_kon, $current_date, $user_id);
		$obj->WriteLogAplicationLogs($user_id, $id_kon, "Moderation Comment", $user_id, "", 0, 0, $kom_m);
		foreach($piecess as $piece)
			{

			// get sub_id Gambar

			$resultSubDrawing = $drawing->get_lastdrawingByidgambar($piece); //getidFrom rev terakhir
			foreach($resultSubDrawing as $resultSubDrawin)
				{
				$id_subCom = $resultSubDrawin[id];
				}

			$comment->insert_subgam_comment($piece, $id_kon, $id_comen, $id_subCom);
			}
		}
	elseif ($act == "del")
		{
		$id_coment = $pieces[2];
		$code = $pieces[1];
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$id_kon = $code;
		$proj_id = $code;
		$get_jam_tang = $comment->get_db_comment_id($id_coment);
		foreach($get_jam_tang as $get_jam_tan)
			{
			$tangg = $get_jam_tan['tanggal'];
			$repl = substr($get_jam_tan['comment'], 0, 100);
			}

		// hapus commnet
		// cek 1jam belum

		if ($drawing->cek_waktu_kurang1jam($tangg, $current_date))
			{


				if($comment->CekposisiComment($id_coment)!=3){

						if($user_id==$comment->CekUserCreate($id_coment)){

						$comment->delete_db_comment($id_coment, $id_kon);
						$comment->insert_comment_log('Menghapus Koment : <span class=error > ' . $repl . '</span> -..', $id_coment, $id_kon, $current_date, $user_id);

						// hapus_gambar coment
						//die;
						$comment->del_gambar_idcom($id_coment, $id_kon);
						$obj->WriteLogAplicationLogs($user_id, $id_kon, "dell Comment", $user_id, "", 0, 0, $repl);

					}

				}else{echo "<script>alert(can't dell already moderated.)</script>" ;}

			}
		  else
			{
			
			$idJabatan= $obj->Get_idJabatan('Project Leader');
            //$lead = $kontrak->get_proj_PM_project($id_kon,$idJabatan);
            $carrijabatan_user= $kontrak->get_proj_PM_projectjabatan($id_kon,$user_id);
            	
			if ($carrijabatan_user==59)// cek pm user
				{
				if ($Users->Get_akses_kont_id($user_id, $id_kon) || $salting == 9 )
					{
					$comment->delete_db_comment($id_coment, $id_kon);
					$comment->insert_comment_log('Menghapus Koment : <span class=error > ' . $repl . '</span> -..', $id_coment, $id_kon, $current_date, $user_id);

					// hapus_gambar coment

					$comment->del_gambar_idcom($id_coment, $id_kon);
					$obj->WriteLogAplicationLogs($user_id, $id_kon, "dell Comment", $user_id, "", 0, 0, $repl);
					}
				  else
					{
					echo "<script> alert('failed to delete, you are not in charge on this project') ;</script>";
					}
				}
			  else
				{
				echo "<script> alert('failed to delete, delete only < 1 hour') ;</script>";
				}
			}
		}
	elseif ($act == "update_point")
		{
		$id_coment = $pieces[2];
		$posisi = $pieces[3];
		$code = $pieces[1];
		$proj_id = $code;
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$id_kon = $code;

		// jika bukan manager 2 doank,.. ojo lali engko di kasih if

		$posisi = 2;
		$get_jam_tang = $comment->get_db_comment_id($id_coment);
		foreach($get_jam_tang as $get_jam_tan)
			{
			$repl = substr($get_jam_tan['comment'], 0, 100);
			$point_old = $get_jam_tan['point'];
			}

		if ($point_old == 3)
			{
			$posisi = 3;
			echo "<script> alert ('you cant change position ')</script>";
			}

		$comment->update_db_comment_Point($posisi, $id_coment);
		$comment->insert_comment_log('Merubah posisi commnet untuk di moderasi : <span class=error > ' . $repl . '</span> -..dari ' . $point_old . ' ke ' . $posisi, $id_coment, $id_kon, $current_date, $user_id);
		$obj->WriteLogAplicationLogs($user_id, $id_kon, "posisi Comment moderasi", $user_id, "", 0, 0, 'Merubah posisi commnet untuk di moderasi : <span class=error > ' . $repl . '</span> -..dari ' . $point_old . ' ke ' . $posisi);
		}
	elseif ($act == "update")
		{
		$current_date = Date("Y-m-d\ H:i:s\Z");
		$commnet = $pieces[3];
		$id_komen = $pieces[2];
		$code = $pieces[1];
		$commentcategory = $pieces[4];
		$id_kon = $code;
		$proj_id = $id_kon;
		$ko = $comment->get_comment_status($id_komen);
		if ($ko)
			{
			/*if ($typeInfo == "true")
				{
				$status = 2;
				}
			  else
				{
				$status = 0;
				}*/

			// echo  $commnet  . $id_komen;
			if ($commentcategory==3){ // bila note maka otomatis status just info
				$status = 2;
			}elseif($commentcategory==1){
				$status = 1;
			}else{
				$status = 0;
			}
			/*echo "	category = $commentcategory
					<br>status = $status";*/

			$comment->update_db_comment($commnet, $current_date, $id_komen, $commentcategory, $status);
			$comment->insert_comment_his($id_komen, $commnet, $user_id, $current_date, $code);
			$kom_m = substr($commnet, 0, 100);
			$comment->insert_comment_log('Telah melakukan perubahan comment : <span class=error > ' . $kom_m . " dan status : " . $status . '</span> -..', $id_komen, $code, $current_date, $user_id);
			$obj->WriteLogAplicationLogs($user_id, $id_kon, "Edit Comment", $user_id, "", 0, 0, 'Telah melakukan perubahan comment : <span class=error > ' . $kom_m . '</span> -..');
			echo "<script>alert('updating complete')</script>";
			}
		  else
			{
			echo "<script> alert ('you cant update comment on this position')</script>";
			}
		}
	elseif ($act == "addreplay")
		{
		$commnet = $pieces[3];
		$code = $pieces[1];
		$pengirim = $pieces[4];
		$id_koment = $pieces[2];
		$current_date = Date("Y-m-d H:i:s");
		$id_kon = $code;
		if ($pengirim == 1)
		{
			$pengirim = $alluserArray[$user_id];
		}
		else
		{
			$pengirim = "owner";
		}

		$namabaru = "cmn_" . $id_koment . getRandomFilename() . "_"  . date("Y-m-d") . ".pdf";
		$alamat = "../data/" .$id_kon. "/"; //generate the destination path
		
		if($_FILES['upload']['error'] != 4)
		{
			if ($_FILES['upload']['tmp_name'])
			{
				if ($drawing->uploadfilePDF($_FILES["upload"]["tmp_name"], $namabaru, $alamat, 'noencript'))
				{
					$alamat = $alamat . $namabaru;
					$comment->insert_subreplay_comment($id_koment, $commnet, $current_date, $pengirim, $user_id, $id_kon, $alamat);
				}
				else
				{
					echo "<script> alert('fail to upload drawing ')</script>";
				}
			}
		}else
		{
			$comment->insert_subreplay_comment($id_koment, $commnet, $current_date, $pengirim, $user_id, $id_kon);	
		}
		
		$getdetailcomments = $comment->get_comment_id($id_koment, $id_kon);
		foreach($getdetailcomments as $getdetailcomment)
			{ //get detail comment
			$nomerkoments = $getdetailcomment['nomer_comment'];
			}

		$C_client = new client();
		$C_client->insertLogSyncClient(1, $id_kon, 'New Reply Comment ' . $nomerkoments);
		$kom_m = substr($commnet, 0, 100);
		$comment->insert_comment_log('Membuat balasan komen baru : <span class=error > ' . $kom_m . '</span> -.. dari ' . $pengirim, $id_koment, $id_kon, $current_date, $user_id);


		$obj->WriteLogAplicationLogs($user_id, $id_kon, "Reply Comment", $user_id, "add", 0, 0, 'Membuat balasan komen baru : <span class=error > ' . $kom_m . '</span> -.. dari ' . $pengirim);

		
		//notification riz1212
		$item = "Comment has been replied";
		$desc = "<p>Comment no $nomerkoments has been replied</p>
				 <p>Reply:</p>
				 <p>$commnet</p>";
		$link = "panel.php?module=comment&projid=$id_kon&com=$id_koment";

		$result = $C_client->notificationProcess($id_kon, $item, $desc, $link, "reply", $kontrak, $obj);
		echo $result;

		/*$C_client->insertNotification($id_kon, $item, $desc, $link, "reply");

		$users = $kontrak->getClientOfProject($id_kon);

		$res = $C_client->setNotifEmail($users, "(comment number: $nomerkoments)", $id_kon, "reply");


		if(!empty($res['address']))
		{
			$result = $obj->emailHandler("no-reply-zee@bki.co.id","Bahtera Zee", array(), $res['body'], "Zee Notification", $res['address']);
		}


		echo "<br>".$result;

		if($result == "Message sent!")
		{
			$C_client->setStatus($users, $id_kon, "mail", $res['notif'], "reply");

		}*/
		
		echo "<script>  location.reload(); </script>";
		die;
		//notification end
		}
	elseif ($act == "close")
		{
		$id_commnet = $pieces[2];
		$code = $pieces[1];
		$current_date = Date("Y-m-d\ H:i:s\Z");
		$id_kon = $code;
		$open_c = $pieces[3];
		$semb = $comment->get_db_comment_id($id_commnet);
		foreach($semb as $sem)
			{
			$point = $sem['point'];
			$repl = substr($sem['comment'], 0, 100);
			$nomerkoments = $sem['nomer_comment'];
			}

		$comment->update_db_comment_stat($point, $open_c, $id_commnet);
		$comment->update_db_comment_statClosed($user_id, $current_date, $id_commnet);
		if ($open_c == 1)
			{ //jika status closed
			$C_client = new client();
			$C_client->insertLogSyncClient(1, $id_kon, 'Update comment Closed ' . $nomerkoments);
			}

		$comment->insert_comment_log('Close Comment : <span class=error > ' . $repl . '</span> -..  ', $id_commnet, $id_kon, $current_date, $user_id);
		$obj->WriteLogAplicationLogs($user_id, $id_kon, "Closed Comment", $user_id, "", 0, 0, 'Close Comment : <span class=error > ' . $repl . '</span> -..  ');
		echo "<script> 	location.reload(); </script>";
		die;
		}
	elseif ($act == "delreplay")
		{
		$commnet = $pieces[3];
		$code = $pieces[1];
		$id_bls = $pieces[5];
		$id_koment = $pieces[2];
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$id_kon = $code;
		$get_jam_tang = $comment->get_replay_id($id_bls, $code);
		foreach($get_jam_tang as $get_jam_tan)
			{
			$tangg = $get_jam_tan['tanggal'];
			$repl = substr($get_jam_tan['replay'], 0, 100);
			}

		// cek 1jam belum

		if ($drawing->cek_waktu_kurang1jam($tangg, $current_date))
			{
			$comment->delet_replay_id($id_bls, $code);
			}
		  else
			{
			echo "<script> alert('failed to delete, delete only < 1 hour') ;</script>";
			}

		$kom_m = substr($commnet, 0, 100);
		$comment->insert_comment_log('menghapus balasan komen  : <span class=error > ' . $repl . '</span> -.. pada ', $id_koment, $id_kon, $current_date, $user_id);
		$obj->WriteLogAplicationLogs($user_id, $id_kon, "Hapus balasan Comment", $user_id, "", 0, 0, 'menghapus balasan komen  : <span class=error > ' . $repl . '</span> -.. pada');
		echo "<script> 	location.reload(); </script>";
		die;
		}
	elseif ($act == "setImportant")
		{

		// var strurl = act + "#" + code + "#" + id_koment + "#" + nilai + "#"  ;

		$nilai = $pieces[3];
		$code = $pieces[1];
		$id_koment = $pieces[2];
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$comment->setUnset_importanComment($id_koment, $nilai);
		$get_nama_coment = $comment->get_db_comment_id($id_koment);
		foreach($get_nama_coment as $get_nama_comen)
			{
			$importanThink = $get_nama_comen['importan'];
			}

		if ($importanThink == 1)
			{
			$strImportan = 'checked';
			}
		  else
			{
			$strImportan = '';
			}

		$comment->insert_comment_log('Set importan komen or Unimportan  : <span class=error > ' . $importanThink . '</span> -.. pada ', $id_koment, $code, $current_date, $user_id);
		$obj->WriteLogAplicationLogs($user_id, $code, "Set importan or Unimportan komen", $user_id, "", 0, 0, 'Set importan komen or Unimportan  : <span class=error > ' . $importanThink . '</span> -.. pada');
		echo "<input  type='checkbox' id='st1'  $strImportan onclick=setImportanComment($code,$id_koment); />
  		<label for='st1' title='when comment need to be attention in the next process'>Need to be Attention</label>";

		// echo $nilai . $code .$id_koment ;
		// echo "<script> 	location.reload(); </script>";

		die;
		}elseif($act=="viewdetailcomment"){

		$id_kon = $pieces[1] ;
		$id_koment=$pieces[2] ;

	$statu_s = array(
		"Open",
		"Closed",
		"Info"
	);
		$get_replays=$comment->get_replay_idcom($id_koment,$id_kon);
		$listdrawing= $comment->get_gambar_idcom($id_koment,$id_kon);
	//get comment
		$listComment=$comment->get_comment_id($id_koment,$id_kon);
		foreach($listComment as $listCommen){
			$strComment=$listCommen['comment'];
			$nomer_comment=$listCommen['nomer_comment'];
			$tipekoment=$listCommen['tipe'];
			$status=$statu_s[$listCommen['status']];
			$issuedby=getInitials($alluserArray[$listCommen['create_by']]);
			$commentisi=$listCommen['comment'];
			$strTglRelease=date('Y-M-d',strtotime($listCommen['reviewat']));
		}

							$get_gambs = $comment->get_gambar_idcom($id_koment,$id_kon);
							foreach ($get_gambs as $get_gamb) { //get gambar ID
								
								//get revisis num 
								if($get_gamb['id_subGam'] != 0 ){
									$listrevs= $drawing->get_gamb_by_id($get_gamb['id_subGam'] , $id_kon); 
									foreach ($listrevs as $listrev ) {
										$revisi= ", Rev. " . $listrev['revisi'] ;
									}
								}
								$strGmbrnama= $strGmbrnama . "<br>" . $get_gamb['no_gambar'] . "$revisi" ;
							}


							if ($tipekoment==15) {
								$narasis = $comment->get_SurveyNarasi($id_kon,$listCommen['create_by'],$nomer_comment);

								foreach ($narasis as $narasi) {
									$commentisi=$narasi['narasi'] ;
								}
							}



							if ($status=="Info") {
								$tipecatatan= "Information" ;
							} else{
								$tipecatatan= "Comment";
							}

							$get_replays=$comment->get_replay_idcom($id_koment,$id_kon);

							foreach ($get_replays as $get_replay) {
								$initialOleh=getInitials($get_replay[oleh]);
								$strReplay100=$get_replay[replay] ;

								$strReply= $strReply . "<br><strong>$initialOleh : </strong>$strReplay100" ;
							}


							$tipe_gambars = $drawing->get_tipe_gambar();
						$tipegambbararr = array();

						foreach($tipe_gambars as $tipe_gambar)
							{

								
								$id = $tipe_gambar['id'];
								$tipegambbararr[$id] = $tipe_gambar['nama'];

							}
						$Discipline=$tipegambbararr[$tipekoment];

							$strTable="<table style='width:100%'>
										<h3>$nomer_comment <strong>[$status]</strong></h3>
										<tr>
										<td style=' border: 1px solid black;'><strong>Issued by</strong></td>
										<td style=' border: 1px solid black;'>$issuedby</td>
										</tr>
										<tr>
										<td style=' border: 1px solid black;'><strong>Discipline</strong></td>
										<td style=' border: 1px solid black;'>$Discipline</td>
										</tr>
										<tr>
										<td style=' border: 1px solid black;'><strong>Released date</strong></td>
										<td style=' border: 1px solid black;'>$strTglRelease</td>
										</tr>
										<tr>
										<td style=' border: 1px solid black;'><strong>Approval id</strong></td>
										<td style=' border: 1px solid black;'>$nomer_comment</td>
										</tr>
										<tr>
										<td style=' border: 1px solid black;'><strong>Document</strong></td>
										<td style=' border: 1px solid black;'>$strGmbrnama</td>
										</tr>
										<tr>
										<td style=' border: 1px solid black;'><strong>Comment</strong></td>
										<td style='width:70%;border: 1px solid black;'>$commentisi</td>
										</tr>
										<tr>
										<td style=' border: 1px solid black;'><strong>Comment type</strong></td>
										<td style=' border: 1px solid black;'>$tipecatatan</td>
										</tr>
										<tr>
										<td style=' border: 1px solid black;'><strong>Reply</strong></td>
										<td style=' border: 1px solid black;'>$strReply</td>
										</tr>
										</table>";
							echo $strTable ;
							die;

}

	// nilai balik

	$get_comments = $comment->get_db_comment($proj_id);
	$zz = $Users->get_users();
	foreach($zz as $z)
		{
		$x = $z['id_user'];
		$userx[$x] = $z['nama'];
		}

	echo "<table class='table table-striped table-bordered table-hover' id='sample_6'>
									<thead>
										<tr>
											<th width='30'>No</th>
											<th >Drawing</th>
											<th width='100'>No Comment</th>
											<th >Comment </th>
											<th width='100'>Create by</th>
											<th width='50'>Date</th>
											<th width='50'>Position</th>
											<th width='50'>Status</th>
											<th width='50'>type</th>
											<th width='50' >reply</th>
											<th width='150'>Action</th>
																						
										</tr>
									</thead>
									<tbody>";
	$no = 1;
	$pointDescr = array(
		'Initial',
		'Rejected',
		'Waiting',
		'Moderated'
	);
	$strTypecomment= array('Dealt with', 'Accepted', 'Resubmited', 'Note', 'Recomendation');
	foreach($get_comments as $get_comment)
		{
		$d = $get_comment['create_by'];
		$tang = date("Y-m-d", strtotime($get_comment['tanggal']));
		$perantar = $get_comment['id'] . ",'" . $get_comment['nomer_comment'] . "'";
		$peranta = $get_comment['id'] . ",'" . $get_comment['id_kontrak'] . "'";
		$perant = $get_comment['id'] . ",'" . $get_comment['id_kontrak'] . "',2";
		$strreply = '';
		if (is_null($get_comment['oleh']))
			{
			$strreply = "Not";
			}
		  else
			{
			$strreply = getInitials($get_comment['oleh']);
			}

		$jmlGambars = explode(",", $get_comment['gambar']);
		$jmlgambar = count($jmlGambars) . ' gambar';
		if ($get_comment['importan'] == 0)
			{
			$strImportan = '';
			}
		  else
			{
			$strImportan = 'checked';
			}

		$commentRelation = $comment->get_gambar_idcom($get_comment['id'],$proj_id);
		$relatedDrwStr = "";
		foreach($commentRelation as $crl)
		{
			$relatedDrwStr = $relatedDrwStr. "<li>
									            <a href='enginerrview.php?module=read&kon=$proj_id&gam=$crl[id]' target='_blank'>
									                <i class='fa fa-file-text-o'></i>
									                $crl[no_gambar] - $crl[judul]
									            </a>
									        </li>";
		}

		echo "<tr class='odd gradeX'>
									<td >$no</td>
									<td title='$jmlgambar'>" . $get_comment['gambar'] . "</td>
									<td title='$get_comment[gamb_infoRef]'> <a target=_blank href='panel.php?module=replaycom&id=" . $proj_id . "&com=$get_comment[id] '>" . $get_comment['nomer_comment'] . " <div class='bintang'><input type='checkbox'  readonly $strImportan/><label for='st1'> </label></div></a></td>
									<td width='50%'><a target=_blank href='panel.php?module=replaycom&id=" . $proj_id . "&com=$get_comment[id] '>" . $get_comment['comment'] . " </a></td>
									
									<td>" . $userx[$d] . "</td>
									<td>" . $tang . "</td>
									<td><strong>" . $pointDescr[$get_comment['point']] . "</strong></td>
									<td><strong>" . $statu_s[$get_comment['status']] . "</strong></td>
									<td><strong>" . $strTypecomment[$get_comment['commentcategory']] . "</strong></td>
									<td title='$get_comment[replay]'>$strreply</td>
									<td>
										<div class='btn-group'>
										    <button type='button' class='btn btn-purple'>
										        <i class='fa fa-cogs'></i>
										        Action
										    </button>
										    <button data-toggle='dropdown' class='btn btn-purple dropdown-toggle'>
										        <span class='caret'></span>
										    </button>
										    
										    <ul class='dropdown-menu' role='menu'>
										        <li>
										            <a href='#editComent' data-toggle='modal'  onclick=show_update($perantar);>
										                <i class='fa fa-pencil'></i>
										                Update
										            </a>
										        </li>
										        <li>
										            <a href='#sample_6'  onclick=fung_update_point($perant);>
										                <i class='fa fa-random'></i>
										                Send for Moderation
										            </a>
										        </li>
										        <li>
										            <a href='#sample_6'  onclick=fung_del_comment($peranta);>
										                <i class='fa fa-trash-o'></i>
										                Delete
										            </a>
										        </li>
										        <li class='divider'></li>
										        <li>
										            <a>
										            <i class='fa fa-sort-desc'></i>Related Drawing
										            </a>
										        </li>
										        $relatedDrwStr
										    </ul>
										</div>
									</td>
									</tr>";
									/*<td>" . "<a href='#editComent' data-toggle='modal'  onclick=" . "show_update(" . $perantar . "); title='Update'> E &nbsp;&nbsp;</a> " . "<a href='#sample_6'  onclick=" . "fung_del_comment(" . $peranta . "); title='Delete' > D &nbsp;&nbsp;</a>   " . "<a href='#sample_6'  onclick=" . "fung_update_point(" . $perant . "); title='Send For Moderation'> P </a> " . "</td>
																		
									</tr>";*/
		$no++;
		}

	echo "</tbody>
										<tfoot>
										<tr>
											<th width='30'>No</th>
											<th >Drawing</th>
											<th width='100'>No Comment</th>
											<th >Comment </th>
											
											<th width='100'>Create by</th>
											<th width='50'>Date</th>
											<th width='50'>Position</th>
											<th width='50'>Status</th>
											<th width='50'>type</th>
											<th width='50' >reply</th>
											<th width='100'>Action</th>
																						
										</tr>
									</tfoot>
									</table><script> generatedTable(6);</script><hr>";
	}

function team($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $kontrak, $salting, $obj)
	{
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	$refresh2="";
	if ($act == "change")
		{
		$idkontract = $pieces[3];
		$iduser = $pieces[2];
		$pos = $pieces[1];
		$jabatan = $kontrak->GetjabatanteamUser($idkontract, $user_id);
		if ($jabatan  == 59 || $salting == 9) 
			{
			if ($pos == 59) //PM
				{
				$permission = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28";
				}
			elseif ((($pos >= 5) and ($pos <= 7))) // Spvs
				{
				$permission = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,23,25";
				}
			elseif ((($pos >= 14) and ($pos <= 16))) // Spvs
				{
				$permission = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,23,25";
				}
			elseif ($pos == 19) //surveyor
				{
				$permission = "1,2,5,6,7,8,9,10,11,12,13,14,24,16,21,23,27";
				}
			elseif ($pos == 21) //Supervesor structure & stability
				{
				$permission = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,23,25";
				}				
			elseif ($pos == 20) //Supervesor surveyor
				{
				$permission = "1,2,5,6,7,8,9,10,11,12,13,14,24,16,21,23,27";
				}	
			elseif ($pos == 17) //spv matkom
				{
				$permission = "1,2,3,4,5,6,7,10,11,12,13,14,16,23,27,28";
				}
			elseif ((($pos >= 2) and ($pos <= 4))) // enginer
				{
				$permission = "1,2,5,6,7,8,9,10,11,12,13,14,16,17,23";
				}
			elseif ((($pos >= 11) and ($pos <= 13))) // enginer
				{
				$permission = "1,2,5,6,7,8,9,10,11,12,13,14,16,17,23";
				}
			elseif ($pos == 18) //eng matkom
				{
				$permission = "1,2,5,6,7,8,9,10,11,12,13,14,16,23,27";
				}					
			elseif ($pos == 8)
				{
				$permission = "1,2,3,4,5,6,7,8,9,10,11,12,13,14,16,17,18,19,20";
				}
			  else
				{
				$permission = "1,3,5,16,19"; //admin
				}


			$kontrak->updateProjectteamPermission($iduser, $pos, $idkontract, $permission);
			$obj->WriteLogAplicationLogs($user_id, $pieces[3], "modification team", $user_id, "modification team", 0, 0, $stringCommand);
			}
		  else
			{
			echo "<script>alert('you are not allow')</script>";
			}
		if ($pieces[4]=='adms') 
			{
			$refresh2="yes";
			}	
		}
	elseif ($act == "dell")
		{
		$idkontract = $pieces[2];
		$iduser = $pieces[1];
		$jabatan = $kontrak->GetjabatanteamUser($idkontract, $user_id);
		if ($jabatan == 59)
			{
			$kontrak->delete_proj_team($iduser, $idkontract);
			$listteams = $kontrak->get_proj_team($idkontract);
			foreach($listteams as $listteam)
				{
				$strTeam = $strTeam . "," . $listteam['id_user'];
				}

			$obj->tblupdateworkspaceTeam($idkontract, $strTeam);
			$obj->WriteLogAplicationLogs($user_id, $pieces[2], "dell team", $user_id, "dell team", 0, 0, $stringCommand);
			}
		  else
			{
			echo "<script>alert('you are not allow ')</script>";
			}
		if ($pieces[3]=='adms') 
			{
			$refresh2="yes";
			}				
		}
	elseif ($act == "add")
		{
		$idkontract = $pieces[2];
		$iduser = $pieces[1];
		$administratif= $pieces[3];
		$datetime = date('Y-m-d');
		
		
		if ($salting == 9) {
			$jabatan=59 ;
		}else{
			$jabatan = $kontrak->GetjabatanteamUser($idkontract, $user_id);
		}

		if ($jabatan == 59)
			{
			$kontrak->delete_proj_team($iduser, $idkontract);
			$kontrak->Create_proj_team($idkontract, $iduser, $datetime, 1, "1,3,5,16,19");
			$listteams = $kontrak->get_proj_team($idkontract);
			foreach($listteams as $listteam)
				{
				$strTeam = $strTeam . "," . $listteam['id_user'];
				}

			$obj->tblupdateworkspaceTeam($idkontract, $strTeam);
			$obj->WriteLogAplicationLogs($user_id, $pieces[2], "Add team", $user_id, "Add team", 0, 0, $stringCommand);
			}
		  else
			{
			echo "<script>alert('you are not allow ')</script>";
			}
		if ($pieces[3]=='adms') 
			{
			$refresh2="yes";
			}	
		}
	elseif ($act=="refreshteamadmin") {
		$refresh2="yes";
		$idkontract = $pieces[1];
	}

	// nilai balik

	$list_jabatan_projs = $kontrak->get_Position_proj();
	$listjabatanarr = array();
	$listjabatanar = array();
	$x = 0;
	foreach($list_jabatan_projs as $list_jabatan_proj)
		{
		$listjabatanarr[$x] = $list_jabatan_proj['nama'];
		$listjabatanar[$x] = $list_jabatan_proj['id'];
		$x++;
		}

	$listTeamOgs = $Users->getOgsteam($idkontract);
	if ($refresh2=="yes") {
		echo "<table class='table table-striped table-hover' id='sample-table-1'><tbody>
										<thead>
											<tr>
												<th class='center'>Photo</th>
												<th>Full Name</th>
												<th class='hidden-xs'>Role</th>
												<th class='hidden-xs'>Email</th>
												<th class='hidden-xs'>Phone</th>
												<th></th>
											</tr>
										</thead>
										<tbody>";
		foreach($listTeamOgs as $piece)
			{
			$nama_userv = $piece['nama'];
			$displayPictures = "../" . $piece['path'];
			$emailUserv = $piece['email'];
			$posisii = $piece['posisi'];
			$idUser = $piece['id_user'];
			$tlpuserv=$piece['tlp'];

							echo 			"<tr>
												<td class='center'><img src='$displayPictures' width='50px' alt='image'/></td>
												<td>$nama_userv</td>
												<td class='hidden-xs'>$posisii</td>
												<td class='hidden-xs'>
												<a href='#' rel='nofollow' target='_blank'>
													$emailUserv
												</a></td>
												<td class='hidden-xs'>$tlpuserv</td>
													<td class='center'>
													<div>
														<div class='btn-group'>
															<a class='btn btn-primary dropdown-toggle btn-sm' data-toggle='dropdown' href='#'>
																<i class='fa fa-cog'></i> <span class='caret'></span>
															</a>
															<ul role='menu' class='dropdown-menu pull-right'>";
			$x = 0;
			foreach($listjabatanarr as $listjabatanaro)
				{
				$idjabatan = $listjabatanar[$x];
				echo "<li role='presentation'>
																	<a role='menuitem' tabindex='-1'  onclick='updatePosuserAdminst($idjabatan,$idUser,$idkontract);'>
																		<i class='fa fa-share'></i> set $listjabatanaro
																	</a>
																</li>";
				$x++;
				}

			echo "<li role='presentation'>
																	<a role='menuitem' tabindex='-1'  onclick='DelmembersuserAdminst($idUser,$idkontract);'>
																		<i class='fa fa-share'></i> Dell user
																	</a>
																  </li>";
			echo "		
															</ul>
														</div>
													</div></td>
											</tr>";
			}

		echo "</tbody></table>";
	}else
	{
		echo "<table class='table table-striped table-hover' id='sample-table-1'><tbody>";
		foreach($listTeamOgs as $piece)
			{
			$nama_userv = $piece['nama'];
			$displayPictures = "../" . $piece['path'];
			$emailUserv = $piece['email'];
			$posisii = $piece['posisi'];
			$idUser = $piece['id_user'];
			echo "	<tr>
													<td class='center'><img src='$displayPictures' width='50px' alt='image'/></td>
													<td>$nama_userv</td>
													<td class='hidden-xs'>
													<a href='#' rel='nofollow' target='_blank'>
															$posisii
													</a></td>
													<td class='center'>
													<div>
														<div class='btn-group'>
															<a class='btn btn-primary dropdown-toggle btn-sm' data-toggle='dropdown' href='#'>
																<i class='fa fa-cog'></i> <span class='caret'></span>
															</a>
															<ul role='menu' class='dropdown-menu pull-right'>";
			$x = 0;
			foreach($listjabatanarr as $listjabatanaro)
				{
				$idjabatan = $listjabatanar[$x];
				echo "<li role='presentation'>
																	<a role='menuitem' tabindex='-1'  onclick='updatePosuser($idjabatan,$idUser,$idkontract);'>
																		<i class='fa fa-share'></i> set $listjabatanaro
																	</a>
																</li>";
				$x++;
				}

			echo "<li role='presentation'>
																	<a role='menuitem' tabindex='-1'  onclick='Delmembersuser($idUser,$idkontract);'>
																		<i class='fa fa-share'></i> Dell user
																	</a>
																  </li>";
			echo "		
															</ul>
														</div>
													</div></td>
												</tr>";
			}

		echo "</tbody></table>";
	}
	}

function drawingmod($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj,$kontrak)
	{
	$act = $_POST['act'];
	if (isset($act) && !empty($act))
		{
		}
	  else
		{
		$stringCommand = $_POST['stringCommand'];
		$pieces = explode("#", $stringCommand);
		$act = $pieces[0];
		}

	if ($act == "refresh")
		{
		$act = $pieces[0];
		$id_kon = $pieces[1];
		}
	elseif ($act == "del_rev")
		{
		$id_gamb = $pieces[2];
		$draw_id = $pieces[3];
		$code = $pieces[1];
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$id_kon = $code;
		$get_jam_tang = $drawing->get_histori_gambar_id($id_gamb, $id_kon);
		foreach($get_jam_tang as $get_jam_tan)
			{
			$tangg = $get_jam_tan['tanggal'];
			$repl = substr($get_jam_tan['id_project_gamb'], 0, 100);
			}

		// hapus
		// cek 1jam belum

		if ($drawing->cek_waktu_kurang1jam($tangg, $current_date))
			{
			$drawing->Delete_id_revisi_draw($id_gamb, $id_kon); // del revisi
			$comment->insert_comment_log('Menghapus Revisi Gambar : <span class=error > ' . $repl . '</span> -..', $id_gamb, $id_kon, $current_date, $user_id);
			$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Menghapus Revisi", $user_id, "Menghapus Revisi", 0, 0, $stringCommand);
			}
		  else
			{
			$idJabatan= $obj->Get_idJabatan('Project Leader');
            	//$lead = $kontrak->get_proj_PM_project($id_kon,$idJabatan);
            	$carrijabatan_user= $kontrak->get_proj_PM_projectjabatan($id_kon,$user_id);
            	
			if ($carrijabatan_user==59)
				{
				if ($Users->Get_akses_kont_id($user_id, $id_kon))
					{
					$drawing->Delete_id_revisi_draw($id_gamb, $id_kon); // del revisi
					$comment->insert_comment_log('Menghapus Revisi Gambar : <span class=error > ' . $repl . '</span> -..', $id_gamb, $id_kon, $current_date, $user_id);
					$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Menghapus Revisi", $user_id, "Menghapus Revisi", 0, 0, $stringCommand);
					}
				  else
					{
					echo "<script> alert('failed to delete, you are not in charge on this project') ;</script>";
					}
				}
			  else
				{
				echo "<script> alert('failed to delete, delete only < 1 hour') ;</script>";
				}
			}

		// nilai balik

		$get_draws = $drawing->get_proj_gambar_id($draw_id);
		$get_hist_draws = $drawing->get_histori_gambar($draw_id, $id_kon);
		$strtablle = "<table class='table table-striped table-bordered table-hover' id='sample_1'>
												<thead>
													<tr>
														<th>No</th>
														<th>Drawing Number </th>
														<th>Nama </th>
														<th>revisi</th>
														<th>Masuk</th>
														<th>Drawing</th>
														<th>Open</th>
														<th>Action</th>
																									
													</tr>
												</thead>
												<tbody>";
		$no = 1;
		foreach($get_draws as $get_draw)
			{
			$nama_gam = $get_draw['judul'];
			$no_gam = $get_draw['no_gambar'];
			}

		foreach($get_hist_draws as $get_hist_draw)
			{
			$z = $get_draw['tipe'];
			if ($get_hist_draw['alamat'] == "none")
				{
				$edraw = "No avaible";
				}
			  else
				{
				$edraw = "Avaible";
				}

			$perant = $id_kon . "," . $get_hist_draw['id'] . "," . $draw_id;
			$strtablle = $strtablle . "<tr class='odd gradeX'>
												<td >$no</td>
												<td > " . $no_gam . "</td>
												<td >" . $nama_gam . " </a></td>
												<td >" . $get_hist_draw['revisi'] . "</td>
												<td>" . $get_hist_draw['tanggal'] . "</td>
												<td>" . $edraw . "</td>
												<td>" . "<a href='kontrak/read.php?module=re&kon=$proj_id&gam=$get_hist_draw[id]'" . "target='_blank'>" . " Open</a> " . "</td>
												<td> <a href='#'  onclick=" . "fung_del_gambar_rev(" . $perant . "); > Delete </a> " . "</td>									
												</tr>";
			$no++;
			}

		$strtablle = $strtablle . "</tbody></table>";
		echo $strtablle;
		die;
		}
	elseif ($act == "delall")
		{
		$id_gamb = $pieces[2];
		$code = $pieces[1];
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$id_kon = $code;
		$get_jam_tang = $drawing->get_proj_gambar_id($id_gamb);
		foreach($get_jam_tang as $get_jam_tan)
			{
			$tangg = $get_jam_tan['tanggal'];
			$repl = substr($get_jam_tan['judul'], 0, 100);
			}

		// hapus gambar
		// cek 1jam belum

		if ($drawing->cek_waktu_kurang1jam($tangg, $current_date))
			{
			$drawing->delete_gam($id_gamb, $id_kon); //del gambar
			$drawing->Delete_All_revisi_draw($id_gamb, $id_kon); // del revisi
			$comment->insert_comment_log('Menghapus Gambar : <span class=error > ' . $repl . '</span> -..', $id_gamb, $id_kon, $current_date, $user_id);
			$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Menghapus Revisi", $user_id, "Menghapus Revisi", 0, 0, $stringCommand);
			}
		  else
			{
			
				$idJabatan= $obj->Get_idJabatan('Project Leader');
            	//$lead = $kontrak->get_proj_PM_project($id_kon,$idJabatan);
            	$carrijabatan_user= $kontrak->get_proj_PM_projectjabatan($id_kon,$user_id);
            	
			if ($carrijabatan_user==59)
				{
				if ($Users->Get_akses_kont_id($user_id, $id_kon))
					{
					$drawing->delete_gam($id_gamb, $id_kon); //del gambar
					$drawing->Delete_All_revisi_draw($id_gamb, $id_kon); // del revisi
					$drawing->Delete_All_stampdraw($id_gamb, $id_kon); // del stamp


					$comment->insert_comment_log('Menghapus Gambar berikut stamp : <span class=error > ' . $repl . '</span> -..', $id_gamb, $id_kon, $current_date, $user_id);

					$obj->WriteLogAplicationLogs($user_id, $id_kon, "Menghapus gambar total", $user_id, "Menghapus gambar total", 0, 0, $stringCommand);
					}
				  else
					{
					echo "<script> alert('failed to delete, you are not in charge on this project') ;</script>";
					}
				}
			  else
				{
				echo "<script> alert('failed to delete, delete only < 1 hour') ;</script>";
				}
			}
		}
	elseif ($act == "uploadsebiji")
		{
		$alamat = "../data/";
		$id_ko = $_POST['idkontrak'];
		$id_kon = $id_ko;
		$judul = ht(trim($_POST['textfield']));
		$no_gam = ht(trim($_POST['textfield2']));
		$no_gam1 = ht(trim($_POST['textfield3']));
		$update_exist = $_POST['exist'];
		$tipee = $_POST['select'];
		$revisi = $_POST['select2'];
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$tanggal_saiki = $current_date;
		$no_edrw = $_POST['no_edrawing'];
		$alamat = $alamat . $id_ko;
		if (!is_dir($alamat))
			{
			mkdir($alamat, 0700);
			}

		$random_digit = rand(0000, 9999);
		$namabaru = $random_digit . "_" . $no_gam1 . "_" . $no_gam . _ . date("Y-m-d") . ".pdf";
		$alamat = $alamat . "/"; //generate the destination path
		if ($no_edrw == 0)
			{
			if ($_FILES['upload']['tmp_name'])
				{
				if ($update_exist == 0)
					{
					$kon = $drawing->cek_double_drawing($no_gam, $id_kon);
					if ($kon == false)
						{
						if ($drawing->uploadfilePDF($_FILES["upload"]["tmp_name"], $namabaru, $alamat))
							{
							$alamat = $alamat . $namabaru;
							$drawing->insert_data_gambar($id_ko, $judul, $tipee, $tanggal_saiki, $alamat, $no_gam); //insert data
							$thelast = $drawing->lastInsertId();
							$drawing->insert_data_sub_gambar($thelast, $id_ko, $tanggal_saiki, $revisi, $alamat); //insert
							$obj->WriteLogAplicationLogs($user_id, $id_kon, "Add gambar", $user_id, "Add gambar", 0, 0, $no_gam);
							}
						  else
							{
							echo "<script> alert('fail to upload drawing ')</script>";
							}
						}
					  else
						{
						echo "<script> alert('fail, Seem Drawing already exist, Please dont make double input')</script>";
						}
					}
				  else
					{
					if ($drawing->uploadfilePDF($_FILES["upload"]["tmp_name"], $namabaru, $alamat))
						{
						$alamat = $alamat . $namabaru;
						$id_ko = intval($id_ko);
						$id_gambars = $drawing->get_id_from_no_gambar($no_gam1, $id_ko);
						foreach($id_gambars as $id_gambar)
							{
							$id_gam = $id_gambar[id];
							}

						$drawing->insert_data_sub_gambar($id_gam, $id_ko, $tanggal_saiki, $revisi, $alamat); //insert
						$obj->WriteLogAplicationLogs($user_id, $id_kon, "Add gambar", $user_id, "Add gambar", 0, 0, $no_gam);
						}
					}
				}
			}
		  else
			{

			// jika ga ada gambar

			if ($update_exist == 0)
				{
				$kon = $drawing->cek_double_drawing($no_gam);
				if ($kon == false)
					{
					$alamat = "none";
					$drawing->insert_data_gambar($id_ko, $judul, $tipee, $tanggal_saiki, $alamat, $no_gam); //insert data
					$thelast = $drawing->lastInsertId();
					$drawing->insert_data_sub_gambar($thelast, $id_ko, $tanggal_saiki, $revisi, $alamat); //insert
					$obj->WriteLogAplicationLogs($user_id, $id_kon, "Add gambar", $user_id, "Add gambar", 0, 0, $no_gam);
					}
				  else
					{
					echo "<script> alert('fail, Seem Drawing already exist, Please dont make double input')</script>";
					}
				}
			  else
				{
				$alamat = "none";
				$id_ko = intval($id_ko);
				$id_gambars = $drawing->get_id_from_no_gambar($no_gam1, $id_ko);
				foreach($id_gambars as $id_gambar)
					{
					$id_gam = $id_gambar[id];
					}

				$drawing->insert_data_sub_gambar($id_gam, $id_ko, $tanggal_saiki, $revisi, $alamat); //insert
				$obj->WriteLogAplicationLogs($user_id, $id_kon, "Add gambar", $user_id, "Add gambar", 0, 0, $id_gam);
				}
			}
		}
	elseif ($act == "editproperty")
		{
		$id_kon = $pieces[1];
		$nodraw = ht(trim($pieces[3]));
		$iddraw = $pieces[2];
		$titledraw = ht(trim($pieces[4]));
		$typedraw = $pieces[5];

		if ($salting == 9) {
			$jabatan=59 ;
		}else{
			$jabatan = $kontrak->GetjabatanteamUser($id_kon, $user_id);
		}
		

		if ($jabatan  == 59 || $kontrak->GetjabatanbyName_a_Like($jabatan, "Supervisor")) 
			{
				$drawing->update_gambar_property($nodraw, $titledraw, $typedraw, $iddraw, $id_kon);
				$obj->WriteLogAplicationLogs($user_id, $id_kon, "Edit Property Gambar", $user_id, "Edit Property Gambar", 0, 0, $stringCommand);
			}
		  else
			{
			echo "<script>alert('you are not allowed')</script>";
			}
		}
	elseif ($act == "editpropertyEngfield")
		{

		// echo "sapi";

		$id_kon = $pieces[1];
		$engfield = $pieces[3];
		$iddraw = $pieces[2];
		$titledraw = ht(trim($pieces[4]));
		$typedraw = $pieces[5];

		if ($salting == 9) {
			$jabatan=59 ;
		}else{
			$jabatan = $kontrak->GetjabatanteamUser($id_kon, $user_id);
		}

		if ($jabatan  == 59 || $kontrak->GetjabatanbyName_a_Like($jabatan, "Supervisor")) 
			{
				$drawing->update_gambar_propertyEngfield($typedraw, $engfield, $iddraw, $id_kon);
				$obj->WriteLogAplicationLogs($user_id, $id_kon, "Edit Property Gambar", $user_id, "Edit Property Gambar", 0, 0, $stringCommand);
			}
		  else
			{
			echo "<script>alert('you are not allowed')</script>";
			}
		}






	// nilai balik

	$get_draws = $drawing->get_proj_gambar($id_kon);
	$strlistgambar = "<table class='table table-striped table-bordered table-hover' id='sample_2'>
									<thead>
										<tr>
											<th class='hidden-xs'>No</th>
											<th>Drawing Number </th>
											<th>Nama </th>
											<th>Tipe Gambar</th>
											<th class='hidden-xs'>Masuk</th>
											<th>Update</th>
											<th >rev</th>
											<th >Status</th>
											<th class='hidden-xs'>Property</th>
											<th class='hidden-xs'>Field</th>
											<th >Review</th>
											<th >Approved</th>
											<th>Edit</th>
											<th>Open</th>
											<th >Del</th>
																						
										</tr>
									</thead>
									<tbody>";
	$no = 1;
	$listtipeApprovals = $drawing->GetTipeapprovalDrawing();
	$kodetipeapproval = array();
	foreach($listtipeApprovals as $listtipeApproval)
		{
		$kodetipeapproval[$listtipeApproval['id_status']] = $listtipeApproval['code'];
		$Namatipeapproval[$listtipeApproval['id_status']] = $listtipeApproval['desck'];
		}

	foreach($get_draws as $get_draw)
		{
		$z = $get_draw['tipe'];
		if ($get_draw['status'] == 1)
			{
			$strReqdownload = " ok ";
			$openlink = "<a href='enginerrview.php?module=stamp&kon=" . $id_kon . "&gam=$get_draw[id_stamp]' target=_blank>" . "Open</a>";
			}
		  else
			{
			$strReqdownload = "-";
			$openlink = "<a href='enginerrview.php?module=read&kon=$id_kon&gam=$get_draw[id]'" . "target='_blank'>" . "Open</a>";
			}

		$strListStamp = "<a href='panel.php?module=liststamp&id=$id_kon&draw=$get_draw[id]'" . "target='_blank'>" . "view</a>";
		$EngginerFild = $drawing->get_tipe_gambar_field();
		$approval = array(
			"Drawing",
			"Calculation",
			"Report",
			"Misc",
			"Doc. forinfo"
		);
		$strEng = $EngginerFild[$get_draw['engfield']];
		$strinfo = $approval[$get_draw['forinfo']];
		$perant = $get_draw['id_kontrak'] . "," . $get_draw['id'];
		if (($get_draw['reviewdate'] === NULL) || ($get_draw['reviewdate'] == "0000-00-00 00:00:00"))
			{
			$reviewdatee = "";
			}
		  else
			{
			$reviewdatee = date('Y-M-d', strtotime($get_draw['reviewdate']));
			}

		$strlistgambar = $strlistgambar . "<tr >
										<td class='hidden-xs'>$no</td>
										<td > <a href='panel.php?module=listrevision&id=" . $id_kon . "&mod=2&draw=$get_draw[id] '>" . $get_draw['no_gambar'] . " </a></td>
										<td >" . $get_draw['judul'] . " ".$get_draw['tglrev']." </a></td>
										<td >" . $tipegambbararr[$z] . "</td>
										<td class='hidden-xs'>" . date('Y-M-d H:i:s', strtotime($get_draw['tanggal'])) . "</td>
										<td>" . date('Y-M-d H:i:s', strtotime($get_draw['tglrev'])) . "</td>
										<td >" . $get_draw['rev'] . "</td>
										<td >" . $kodetipeapproval[$get_draw['drawingstatus']] . " : " . $Namatipeapproval[$get_draw['drawingstatus']] . "</td>
										<th class='hidden-xs'>$strinfo</th>
										<th class='hidden-xs'>$strEng</th>
										<th >" . $alluserArray[$get_draw['userid']] . "</th>
										<th >" . $alluserArray[$get_draw['review']] . " / $reviewdatee</th>
										<td><a href='#editdrawproperty' data-toggle='modal' Onclick='setEditdraw(&#34;$get_draw[no_gambar]&#34;,&#34;$get_draw[judul]&#34;,$z,$get_draw[id])'>Edit</a>  &nbsp; <a href='#editPropertyDrawing' data-toggle='modal' Onclick='setEditdrawproperty(&#34;$get_draw[no_gambar]&#34;,&#34;$get_draw[judul]&#34;,$get_draw[forinfo],$get_draw[id],$get_draw[engfield])'>Pro.</a> </td>
										<td>" . $openlink . " $strListStamp
										</td>
										<td > <a href='#'  onclick=" . "fung_del_gambar(" . $perant . "); > Del </a> " . "</td>									
										</tr>";
		$no++;
		}

	$strlistgambar = $strlistgambar . "</tbody>
	<tfoot>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>Nama </th>
											<th>Tipe Gambar</th>
											<th>Masuk</th>
											<th>Update</th>
											<th class='hidden-xs'>rev</th>
											<th class='hidden-xs'>Status</th>
											<th class='hidden-xs'>Property</th>
											<th class='hidden-xs'>Field</th>
											<th class='hidden-xs'>Review</th>
											<th class='hidden-xs'>Approved</th>
											<th>Edit</th>
											<th>Open</th>
											<th>Del</th>
																						
										</tr>
									</tfoot></table><script> generatedTable(2);</script>";
	echo $strlistgambar;
	}

function uploadbluck($Activity, $user_id, $drawing, $kontrak)
	{
	$tipeKegiatan = $_POST['tipekegiatan'];
	$idKegiatan = $_POST['idKegiatan'];
	$act = $_POST['act'];
	$nama = $_POST['nama'];
	$idgaleri = $_POST['idgaleri'];
	$refedit == "no";
	$refmode == "no";
	$kontraks = $kontrak->get_kontrak();
	foreach($kontraks as $kontrak)
		{
		$Project_name[$kontrak['id']] = $kontrak['nama'];
		}

	if (isset($act) && !empty($act))
		{
		}
	  else
		{
		$stringCommand = $_POST['stringCommand'];
		$pieces = explode("#", $stringCommand);
		$act = $pieces[0];
		}

	if ($act == "add")
		{
		$alamat = "../data/" . $idKegiatan . "/";
		if (!is_dir($alamat))
			{
			mkdir($alamat, 0700);
			}

		$allowedExts = array(
			"pdf",
			"PDF"
		);
		for ($j = 0; $j < count($_FILES["item_file"]['name']); $j++)
			{ //loop the uploaded file array
			$filen = $_FILES["item_file"]['name']["$j"]; //file name
			$randomname = getRandomFilename() . ".pdf";
			if ($drawing->uploadfilePDF($_FILES["item_file"]["tmp_name"]["$j"], $randomname, $alamat))
				{
				$no_gamb = "";
				$judul = "";
				$tipe = "";
				$doc_tipe = 0;
				$tanggal = date("Y-m-d");
				$drawing->insert_data_gambar_temp1($_FILES["item_file"]['name']["$j"], $alamat . $randomname, $no_gamb, $judul, $tipe, $idKegiatan, $doc_tipe, $tanggal, $user_id);
				}
			}
		}
	elseif ($act == "delupload")
		{
		$ids = $pieces[1];
		$gambars = $drawing->get_proj_gambar_temp_almat($ids);
		if (file_exists($gambars))
			{
			unlink($gambars);
			}

		$drawing->Delete_proj_gambar_temp($ids);
		}
	elseif ($act == "refresh")
		{
		}
	elseif ($act == "refreshedit")
		{
		$refedit = "yes";
		}
	elseif ($act == "refreshmoderation")
		{
		$refmode = "yes";
		}
	elseif ($act == "editupload")
		{
		$refedit = "yes";
		if (isset($_POST['checkbox']))
			{
			$checkbox = $_POST['checkbox'];
			$size = count($_POST['checkbox']);
			$i = 0;
			while ($i < $size)
				{
				$id = $_POST['checkbox'][$i];
				$no_gamb = $_POST['textfield'][$id];
				$judul = $_POST['textfield2'][$id];
				$tipe = $_POST['radiobutton1'][$id];

				// $doc_tipe= $_POST['radiobutton'][$id];

				$doc_tipe = 1;
				$drawing->update_proj_gambar_temp($no_gamb, $judul, $tipe, $doc_tipe, $id);
				++$i;
				}
			}
		}
	elseif ($act == "delleditupload")
		{
		$refedit = "yes";
		$ids = $pieces[1];
		$gambars = $drawing->get_proj_gambar_temp_almat($ids);
		if (file_exists($gambars))
			{
			unlink($gambars);
			}

		$drawing->Delete_proj_gambar_temp($ids);
		}
	elseif ($act == "dellmodupload")
		{
		$refmode = "yes";
		$ids = $pieces[1];
		$gambars = $drawing->get_proj_gambar_temp_almat($ids);
		if (file_exists($gambars))
			{
			unlink($gambars);
			}

		$drawing->Delete_proj_gambar_temp($ids);
		}
	elseif ($act == "modtupload")
		{
		$refmode = "yes";
		if (isset($_POST['checkbox']))
			{
			$checkbox = $_POST['checkbox'];
			$size = count($_POST['checkbox']);
			$i = 0;
			while ($i < $size)
				{
				$id = $_POST['checkbox'][$i];
				$no_gamb = ht(trim($_POST['textfield'][$id]));
				$judul = ht(trim($_POST['textfield2'][$id]));
				$tipe = $_POST['radiobutton1'][$id];
				$id_ko = $_POST['nomerkontrak'][$id];

				// $doc_tipe= $_POST['radiobutton'][$id];

				$doc_tipe = 1;
				$current_date = Date("Y-m-d\ H:i:s\ ");
				$tanggal_saiki = $current_date;
				$revisi = 0;

				// masukan ke database drawing

				$alamat = $drawing->get_proj_gambar_temp_almat($id);
				$drawing->insert_data_gambar($id_ko, $judul, $tipe, $tanggal_saiki, $alamat, $no_gamb); //insert data
				$thelast = $drawing->lastInsertId();
				$drawing->insert_data_sub_gambar($thelast, $id_ko, $tanggal_saiki, $revisi, $alamat); //insert

				// hapus yang ini

				$drawing->Delete_proj_gambar_temp($id);
				++$i;
				}
			}
		}

	if ($refedit == "yes")
		{
		$get_draws = $drawing->get_proj_gambar_temp(0, 5000);
		echo "
<table class='table table-striped table-bordered table-hover' id='sample_1'>
                  <tr>
                    <td width='25'>&nbsp;</td>
                    <td width='70'><strong>Name of File </strong></td>
                    <td ><strong>No Drawing or Doc </strong></td>
                    <td ><strong>Title</strong></td>
                    <td ><strong>Department</strong></td>
                   
					<td width><strong>Pid</strong></td>
                    <td ><strong>Action</strong></td>
                  </tr>
                  <tr>";
		foreach($get_draws as $get_draw)
			{
			$structure = "";
			$elec = "";
			$machni = "";
			$doc = "";
			$draw = "";
			if ($get_draw['tipe'] == 1)
				{
				$structure = " checked";
				}

			if ($get_draw['tipe'] == 2)
				{
				$elec = " checked";
				}

			if ($get_draw['tipe'] == 3)
				{
				$machni = " checked";
				}

			/* 		if ($get_draw['doc_tipe']==1) {$draw=" checked"; }

			if ($get_draw['doc_tipe']==2) {$doc=" checked"; } */
			$nam_proj = $Project_name[$get_draw['kontrak_id']];
			echo "<td><input type='checkbox' name='checkbox[]' id='checkbox' value='" . $get_draw['id'] . "' /></td>
                    <td><a href='viewer.php?rev=0&id=$get_draw[id]'" . "target='_blank'>" . $get_draw['nama_file'] . "</a></td>
                    <td><label><input type='text' id='textfield[" . $get_draw['id'] . "]' name='textfield[" . $get_draw['id'] . "]' value='" . $get_draw['no_gamb'] . "' /></label></td>
                    <td><label><input  name='textfield2[" . $get_draw['id'] . "]' type='text'  value='" . $get_draw['judul'] . "'/></label></td>
					
                    <td><label><input name='radiobutton1[" . $get_draw['id'] . "]' type='radio' value='1' " . $structure . " />Structure</label><label><input name='radiobutton1[" . $get_draw['id'] . "]'  type='radio' value='3' " . $machni . "/>Machinery & system</label><label><input name='radiobutton1[" . $get_draw['id'] . "]'  type='radio' value='2' " . $elec . " />Electrical</label></td>
		
					<td title= '$nam_proj' >" . $get_draw['kontrak_id'] . "</td>
                    <td><a onclick='deleditupload($get_draw[id]);'>" . Delete . " </a></td>
                  </tr>";
			}

		echo "</table>
";
		die;
		}

	if ($refmode == "yes")
		{
		echo "		<table class='table table-striped table-bordered table-hover' id='sample_1'>
                  <tr>
                    <td width='25'>&nbsp;</td>
                    <td width='100'><strong>Name of File </strong></td>
                    <td ><strong>No Drawing or Doc </strong></td>
                    <td ><strong>Title</strong></td>
                    <td ><strong>Department</strong></td>

					<td ><strong>Pid</strong></td>
                    <td ><strong>Action</strong></td>
                  </tr>
                  <tr>";
		$get_draws = $drawing->get_proj_gambar_temp(0, 1000);
		foreach($get_draws as $get_draw)
			{
			$structure = "";
			$elec = "";
			$machni = "";
			$doc = "";
			$draw = "";
			if ($get_draw['tipe'] == 1)
				{
				$structure = " checked";
				}

			if ($get_draw['tipe'] == 2)
				{
				$elec = " checked";
				}

			if ($get_draw['tipe'] == 3)
				{
				$machni = " checked";
				}

			/* 		if ($get_draw['doc_tipe']==1) {$draw=" checked"; }

			if ($get_draw['doc_tipe']==2) {$doc=" checked"; } */
			/*
			if($get_draw['no_gamb']==""){
			$strNogambar=$get_draw['nama_file'];
			$strNogambar=str_replace(".pdf","",$strNogambar);
			$strNogambar=str_replace(".PDF","",$strNogambar);
			}else{
			$strNogambar=$get_draw['no_gamb'];
			} */
			$nam_proj = $Project_name[$get_draw['kontrak_id']];
			echo "<td><input type='checkbox' name='checkbox[]' id='checkbox' value='" . $get_draw['id'] . "' /></td>
                    <td><a href='viewer.php?rev=0&id=$get_draw[id]'" . "target='_blank'>" . $get_draw['nama_file'] . "</a></td>
                    <td><label><input type='text' id='textfield[" . $get_draw['id'] . "]' name='textfield[" . $get_draw['id'] . "]' value='" . $get_draw['no_gamb'] . "' /></label></td>
                    <td><label><input  name='textfield2[" . $get_draw['id'] . "]' type='text'  value='" . $get_draw['judul'] . "'/></label></td>
					
                    <td><label><input name='radiobutton1[" . $get_draw['id'] . "]' type='radio' value='1' " . $structure . " />Structure</label><label><input name='radiobutton1[" . $get_draw['id'] . "]'  type='radio' value='3' " . $machni . "/>Machinery & system</label><label><input name='radiobutton1[" . $get_draw['id'] . "]'  type='radio' value='2' " . $elec . " />Electrical</label></td>
					
                   
					<td title= '$nam_proj' > <input type='hidden' name='nomerkontrak[$get_draw[id]]' id='nomerkontrak[$get_draw[id]]' value='$get_draw[kontrak_id]'  />" . $get_draw['kontrak_id'] . "</td>
                    <td><a  onClick='delmodupload($get_draw[id]);'>" . Delete . " </a></td>
                  </tr>";
			}

		echo "</table>";
		die;
		}

	// nilai balik

	$get_draws = $drawing->get_proj_gambar_temp(0, 30);
	echo "<table class='table table-striped table-bordered table-hover' id='sample_1'>
									<thead>
										<tr>
											<th>No</th>
											<th>Id</th>
											<th>File Name</th>
											<th>No Drawing</th>
											<th>Title</th>
											<th>Tipe</th>
											
											<th>Pid</th>
											<th>Action</th>
																						
										</tr>
									</thead>
									<tbody>";
	$no = 1;
	foreach($get_draws as $get_draw)
		{
		$z = $get_draw['tipe'];
		$nam_proj = $Project_name[$get_draw['kontrak_id']];
		echo "<tr class='odd gradeX'>
									<td >" . $no . "</td>
									<td > <a href='viewer.php?rev=0&id=$get_draw[id]'" . "target='_blank'>" . $get_draw['id'] . "</a> " . "</td>
									<td ><a href='viewer.php?rev=0&id=$get_draw[id]'" . "target='_blank'>" . $get_draw['nama_file'] . "</a></td>
									<td >" . $get_draw['no_gamb'] . " </td>
									<td >" . $get_draw['judul'] . "</td>
									<td>" . $get_draw['tipe'] . "</td>
								
									<td>" . $nam_proj . "</td>
									<td><a  onclick='delupload($get_draw[id]);'>" . Delete . " </a></td>								
									</tr>";
		$no++;
		}

	echo "</tbody></table>";
	}

function generateReport($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj)
	{
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	$projectID = $pieces[1];
	if ($act == "weekly")
		{
		$EngginerFild = array(
			"UN",
			"STA",
			"LL",
			"MEC",
			"EL",
			"SAF",
			"STR",
			"TON",
			"INS",
			"MAT",
			"NAV",
			"PRO",
			"PIP",
			"TEL"
		);
		$approval = array(
			"DW",
			"CL",
			"RP",
			"MS"
		);
		$nameRelated = $obj->get_wokspaceByid($projectID);
		foreach($nameRelated as $namedsd)
			{
			$starting = $namedsd['starting'];
			$due = $namedsd['due'];
			}

		$numwekmonth = $pieces[2];
		if ($pieces[3] == 1)
			{
			$nameOfDay = date('w', strtotime($starting));
			$addedvalue = 6 - $nameOfDay;
			$Newstarting = date("Y-m-d H:i:s", strtotime(GetDatetimeADD($starting, $addedvalue))); //new date cut off
			if ($numwekmonth == 1)
				{ // minggu pertama telah dihitung di atas sehingga tak perlu dijumlah kembali
				$jmlTotalhari = 0;
				}
			elseif ($numwekmonth > 1)
				{
				$numwekmonth = $numwekmonth - 1; //adjustment biar tidak loncat 2 minggu
				$jmlTotalhari = $numwekmonth * 7;
				}
			}
		  else
			{
			$jmlTotalhari = $numwekmonth * 30;
			}

		$tanggal = date("Y-m-d H:i:s", strtotime(GetDatetimeADD($Newstarting, $jmlTotalhari)));

		// echo 		$tanggal;

		$listDatas = $drawing->GetDrawingListAlldata($tanggal, $projectID);
		$formattang = date('l, Y-M-d', strtotime($tanggal));
		$formatStarting = date('l, Y-M-d', strtotime($starting));
		$isireport = "<h2>Cut off Date : $formatStarting by $formattang</h2>
	<table border='0'>
									<thead>
										<tr>
											<th>Title</th>
											<th>Drawing Number</th>
											<th>Revision</th>

											<th>Approval Date</th>
											<th>Category</th>
											<th>Engineer</th>
											<th>Submission date</th>
											<th>Return date</th>											
										</tr>
									</thead>
									<tbody>
	<tbody>";

		// $no=1;

		foreach($listDatas as $listData)
			{

			// code...

			$usernya = $alluserArray[$listData['userid']];
			$usernya = getInitials($usernya);
			$isireport = $isireport . "<tr >
		 							<td >" . $listData['judul'] . "</td>
		 							<td >" . $listData['no_gambar'] . "</td>
		 							<td >" . $listData['rev'] . "</td>
									
									<td >" . $listData['upload_stamp'] . "</td>
									<td >" . $EngginerFild[$listData['engfield']] . "</td>
									<td >" . $usernya . "</td>
									<td >" . $listData['updateat'] . "</td>
									<td >" . $listData['reviewdate'] . "</td>
							
									</tr>";
			$no++;
			}

		$isireport = $isireport . "	</tbody></table>";
		$nb = "<br /><strong>Status codes =  UN:uncategory, STA:Stability, LL:Loadline, MEC:Mechanical , EL:Electrical, SAF:Safety, STR:Hull and structure, TON:Tonnage, INS:Instrumentation, MAT:Materials & Corrosion, NAV:Navigation, PRO:Process, PIP:Piping, TEL:Telecommunication, DW:Drawing, CL:Calculation, RP:Report, MS:Misc </strong></br>";

		// comment

		$get_comments = $comment->get_db_commentRange($projectID, $tanggal);
		$isireport = $isireport . $nb . "<h2> Comment List </h2> <hr><table class='table table-striped table-bordered table-hover' id='sample_11'>
									<thead>
										<tr>
											<th>no</th>
											<th width='100'>No</th>
											<th >Comment </th>
											<th width='100' >Drawing / Report Number</th>
											<th width='100'>Engineer</th>
											<th width='100'>Date</th>

											<th width='50'>Status</th>
																				
										</tr>
									</thead>
									<tbody>";
		$no = 1;
		$jmlOpenComment = 1;
		$statu_s = array(
			"Open",
			"Closed",
			"Info"
		);
		$commentStatus = array(
			'',
			'',
			'Waiting',
			'Publish'
		);
		foreach($get_comments as $get_comment)
			{
			$usernya = $alluserArray[$get_comment['create_by']];
			$usernya = getInitials($usernya);
			$isireport = $isireport . "<tr class='odd gradeX'>
								
									<td>$no</td>
									<td > " . $get_comment['nomer_comment'] . "</td>
									<td >" . $get_comment['comment'] . "</td>
									<td>" . $get_comment['gambar'] . "</td>
									<td>" . $usernya . "</td>
									<td>" . $get_comment['tanggal'] . "</td>

									<td>" . $statu_s[$get_comment['status']] . "</td>
															
									</tr>";
			if ($get_comment['status'] == 0)
				{ //untuk menghitung jumlah open comment
				$jmlOpenComment++;
				}

			$no++;
			}

		$jmlcomment = $no - 1; // jmlah comment
		$isireport = $isireport . "</tbody></table><hr> Total Comment = $jmlcomment Total Comment remain OPEN = $jmlOpenComment";
		$wrap = "<textarea class='ckeditor form-control' cols='10' rows='20' id='inforeport' name='inforeport'>" . $isireport . "</textarea><script>        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();</script>";
		echo $wrap;
		die;
		}

	if ($_POST['act'] == 'addDailyReport')
		{
		$subjectDaylireport = $_POST['SubjectDailyReport'];
		$id_kon = $_POST['id_kon'];
		$reportAt = "Day " . $_POST['reportat'];
		$uploaFile = $_POST['uploadAttacmentDayliReport'];
		$randomname = "rpt_" . getRandomFilename() . ".pdf";
		$alamat = "../data/" . $id_kon . "/";
		if (!is_dir($alamat))
			{
			mkdir($alamat, 0700);
			}

		if ($obj->getExistRegularreport($id_kon, 1, $reportAt) > 0)
			{
			echo "<script>alert('Report already exist')</script>";
			}
		  else
			{
			if ($_FILES["file"]["error"] != 4)
				{ //jika adafile di upload
				if ($drawing->uploadfilePDF($_FILES["uploadAttacmentDayliReport"]["tmp_name"], $randomname, $alamat, "noencript"))
					{
					$file = $alamat . $randomname;
					$obj->InsertRegularReport($subjectDaylireport, 1, $reportAt, $file, "", $user_id, $user_id, $id_kon);

					// insertlogsAplikasi

					$obj->WriteLogAplicationLogs($user_id, $id_kon, "create daily report", $user_id, "", 0, 0, "" . $file);
					}
				}
			}

		$listresultReport = $obj->GetRegularReport($id_kon, 1);
		$refreshreportbalik = true;
		}

	if ($_POST['act'] == 'addWeeklyReport')
		{
		$subjectDaylireport = $_POST['SubjectWeeklyReport'];
		$id_kon = $_POST['id_kon'];
		$reportAt = "Week " . $_POST['weeklyNumberdata'];
		$uploaFile = $_POST['uploadAttacmentwekkly'];
		$atta = $_POST['inforeport'];
		$randomname = "rpt_" . getRandomFilename() . ".pdf";
		$alamat = "../data/" . $id_kon . "/";
		if (!is_dir($alamat))
			{
			mkdir($alamat, 0700);
			}

		if ($obj->getExistRegularreport($id_kon, 2, $reportAt) > 0)
			{
			echo "<script>alert('Report already exist')</script>";
			}
		  else
			{
			if ($_FILES["file"]["error"] != 4)
				{ //jika adafile di upload
				if ($drawing->uploadfilePDF($_FILES["uploadAttacmentwekkly"]["tmp_name"], $randomname, $alamat, "noencript"))
					{
					$file = $alamat . $randomname;
					$obj->InsertRegularReport($subjectDaylireport, 2, $reportAt, $file, $atta, $user_id, $user_id, $id_kon);

					// insertlogsAplikasi

					$obj->WriteLogAplicationLogs($user_id, $id_kon, "create weekly report", $user_id, "", 0, 0, "" . $file);
					}
				}
			}

		$listresultReport = $obj->GetRegularReport($id_kon, 2);
		$refreshreportbalik = true;
		}

	if ($_POST['act'] == 'addMonthlyReport')
		{
		$subjectDaylireport = $_POST['SubjectMonthlyReport'];
		$id_kon = $_POST['id_kon'];
		$reportAt = "Month " . $_POST['monthlyadd'];
		$uploaFile = $_POST['uploadAttacmentmontlyReport'];
		$atta = $_POST['inforeport'];
		$randomname = "rpt_" . getRandomFilename() . ".pdf";
		$alamat = "../data/" . $id_kon . "/";
		if (!is_dir($alamat))
			{
			mkdir($alamat, 0700);
			}

		if ($obj->getExistRegularreport($id_kon, 3, $reportAt) > 0)
			{
			echo "<script>alert('Report already exist')</script>";
			}
		  else
			{
			if ($_FILES["file"]["error"] != 4)
				{ //jika adafile di upload
				if ($drawing->uploadfilePDF($_FILES["uploadAttacmentmontlyReport"]["tmp_name"], $randomname, $alamat, "noencript"))
					{
					$file = $alamat . $randomname;
					$obj->InsertRegularReport($subjectDaylireport, 3, $reportAt, $file, $atta, $user_id, $user_id, $id_kon);

					// insertlogsAplikasi

					$obj->WriteLogAplicationLogs($user_id, $id_kon, "create monthly report", $user_id, "", 0, 0, "" . $file);
					}
				}
			}

		$listresultReport = $obj->GetRegularReport($id_kon, 3);
		$refreshreportbalik = true;
		}

	if ($act == 'refreshdily')
		{
		$listresultReport = $obj->GetRegularReport($projectID, 1);
		$refreshreportbalik = true;
		$tblNum = 15;
		}

	if ($act == 'refreshweekly')
		{
		$listresultReport = $obj->GetRegularReport($projectID, 2);
		$refreshreportbalik = true;
		$tblNum = 161;
		}

	if ($act == 'refresmonthly')
		{
		$listresultReport = $obj->GetRegularReport($projectID, 3);
		$refreshreportbalik = true;
		$tblNum = 171;
		}

	if ($act == 'dell')
		{
		$id_kon = $pieces[1];
		$tipe = $pieces[2];
		$id = $pieces[3];
		$obj->DellRegularreport($id, $id_kon);
		$listresultReport = $obj->GetRegularReport($id_kon, $tipe);
		$obj->WriteLogAplicationLogs($user_id, $id_kon, "dell  report", $user_id, "", 0, 0, "" . $stringCommand);
		$refreshreportbalik = true;
		if ($tipe == 1)
			{
			$tblNum = 15;
			}
		elseif ($tipe == 2)
			{
			$tblNum = 16;
			}
		  else
			{
			$tblNum = 17;
			}
		}

	// nilai balik report regular

	if ($refreshreportbalik == true)
		{
		$listReport = "<table class='table table-striped table-bordered table-hover' id='sample_$tblNum'>
									<thead>
										<tr>
										<th>No</th>
											<th>Report</th>
											<th>Subject</th>
											<th>updateby</th>
											<th>view</th>
											<th>tanggal</th>
											<th>Action </th>
										</tr>
									</thead>
									<tbody>";
		$no = 1;
		foreach($listresultReport as $listRepor)
			{
			$listReport = $listReport . "<tr >
									<td >$no</td>
									<td >$listRepor[reportAt]</td>
									<td >$listRepor[subject]</td>
									<td >" . $alluserArray[$listRepor['updateby']] . "</td>
									<td > <a target='_blank' href='http://z2ex.bki.co.id/n_ogs/n_ogs/$listRepor[file]'" . ">View</a>  </td>
									<td >$listRepor[updateat]</td>
									<td> <a href='#' onClick='delReportRegular($listRepor[id_kon],$listRepor[tipe],$listRepor[id])'>Dell</a> </td>
									</tr>";
			$no++;
			}

		$listReport = $listReport . "</tbody></table><script> generatedTable($tblNum);</script>";
		echo $listReport;
		die;
		}

	// get kontrak info

	$nameRelated = $obj->get_wokspaceByid($projectID);
	foreach($nameRelated as $namedsd)
		{
		$nameRela = $namedsd['project'];
		$description = $namedsd['description'];
		$leader = $namedsd['lead'];
		$starting = $namedsd['starting'];
		$due = $namedsd['due'];
		$target = $namedsd['target'];
		$purpose = "Rp. " . number_format($target);
		$contract = $namedsd['id_kontrak'];
		$vesell = $namedsd['vessel'];
		$lokasi = $namedsd['lokasi'];
		$builder = $namedsd['builder'];
		$submited = $namedsd['submited'];
		$class = $namedsd['class_id'];
		$kontractlink = $namedsd['kontractlink'];

		// generaldataInput

		$classnot = $namedsd['notation'];
		$ofregnum = $namedsd['offregnum'];
		$portre = $namedsd['port'];
		$deliverydate = $namedsd['deliverydate'];
		$ibc = $namedsd['ibcigc'];
		$Ddwt = $namedsd['desaigndwt'];
		$depth = $namedsd['moldeddepth'];
		$callsign = $namedsd['callsign'];
		$datereg = $namedsd['datereg'];
		$solas = $namedsd['solas'];
		$ism = $namedsd['ism'];
		$lpp = $namedsd['lpp'];
		$bulb = $namedsd['blublengthfromfp'];
		$flag = $namedsd['flag'];
		$kellaying = $namedsd['keellaying'];
		$marpolkat = $namedsd['marpol'];
		$breadt = $namedsd['moldedbreadth'];
		$loadinginst = $namedsd['loadinginstr'];
		$trimbook = $namedsd['trimstabilitibook'];
		if ($loadinginst == 1)
			{
			$strloading = "<option value='$loadinginst' >Yes</option>";
			}
		  else
			{
			$strloading = "<option value='$loadinginst' >No</option>";
			}

		if ($trimbook == 1)
			{
			$strtrimbook = "<option value='$trimbook' >Yes</option>";
			}
		  else
			{
			$strtrimbook = "<option value='$trimbook' >No</option>";
			}
		}

	$tanggal = date("F j, Y");
	$isireport = $isireport . "<h1><span style='color:#0000FF;'><strong>" . strtoupper($nameRela) . " STATUS REPORT</strong></span></h1>";
	$isireport = $isireport . "<h2><strong>" . "BKI" . "</strong></h2><p>";
	$isireport = $isireport . "<h3><strong>" . "Report No : " . "</strong> XXX-AAAA-CCCC</h3>";
	$isireport = $isireport . "<h3><strong>" . "Date : " . "</strong> $tanggal</h3>";
	$isireport = $isireport . "<table border='0' style='float:left;marginleft:40px;'>
	<tbody>
		<tr>
			<td>Project name:</td>
			<td>$nameRelated</td>
		</tr>
		<tr>
			<td>Report title:</td>
			<td>Project Fortnightly Status Report</td>
		</tr>
		<tr>
			<td>Customer:</td>
			<td>BKI</td>
		</tr>		
		<tr>
			<td>Contact person:</td>
			<td>$submited</td>
		</tr>		<tr>
			<td>Date of issue:</td>
			<td>$tanggal</td>
		</tr>		<tr>
			<td>Project No:</td>
			<td>$contract</td>
		</tr>
		<tr>
			<td>Organisation unit:</td>
			<td>&nbsp;</td>
		</tr><tr>
			<td>Report No:</td>
			<td>XXX-AAAA-CCCC</td>
		</tr>
	
</table> ";
	$isireport = $isireport . "<table border='0'>
	<tbody>
		<tr>
			<td>PT Biro Klasifikasi Indonesia</td>
			
		</tr>
		<tr>
			<td>Head Office</td>
		
		</tr>
		<tr>
			<td>SBU Offshore</td>

		</tr>		
		<tr>
			<td>JL Yos Sudarso 38-40</td>
			
		</tr>		<tr>
			<td>Jakarta Utara</td>
		</tr>
	</tbody>
</table><p><p><br /><br /><br />";
	$isireport = $isireport . "<hr>" . $description;
	$isireport = $isireport . "<h1>Table of contents</h1>
1 PLAN APPROVAL STATUS <br />
1.1 Summary of Drawings Status for Class Submissions <br />
1.2 HHI Drawings Status for Class Submissions <br />
1.3 HHI Approval Comments Status for Class Submissions <br />
1.4 STC-JO Drawing Status for Class Submissions <br />
1.5 STC-JO Approval Comments Status for Class Submissions <br />
1.6 Verification Review Status <br />
2 STATUS OF SURVEYS IN YARD <br />
3 CMC AND VMC COORDINATION STATUS<br />
4 RED FLAG / OUTSTANDING ITEMS / AREAS OF CONCERN<br />
5 LOOK AHEAD AT ACTION ITEMS <br />
APPENDIX / ATTACHMENTS<br />
";
	$isireport = $isireport . "<h1>1 PLAN APPROVAL STATUS </h1>";
	$isireport = $isireport . "<h1>1.1 Summary of Drawings Status for Class Submissions</h1>";
	$isireport = $isireport . "<table border='1' style='border-collapse: collapse;'>
	<tbody>
		<tr>
			<td style='width: 364px;' ><strong>Status of Documentation Required for Class</strong></td>
			<td style='width: 83px;' ><strong>Total</strong></td>
		</tr>
		<tr>
			<td>Total no. of documents required</td>
			<td>1100</td>
		</tr>
		<tr>
			<td>Total no. documents received</td>
			<td>1038</td>
		</tr>		
		<tr>
			<td>Total no. documents returned</td>
			<td>1012</td>
		</tr>		<tr>
			<td>% of Documents Returned</td>
			<td>97.5</td>
		</tr>		<tr>
			<td>% of Class review progress</td>
			<td>92.0</td>
		</tr>
	
</table> <p>";
	$isireport = $isireport . "	**the numbers are updated to exclude multiple dwgs of same title and docs
discarded. New revisions are taken into count hence the total doc reqd
numbers increases at every count. The above figures are best estimates from
live NPS data<p>";
	$isireport = $isireport . "<h1>1.2 HHI Drawings Status for Class Submissions</h1>";
	$isireport = $isireport . "<table border='1' cellpadding='1' cellspacing='1' style='width:500px;border-collapse: collapse;'>
	<tbody>
		<tr>
			<td colspan='1' rowspan='2'><br />
			<span style='font-size: 11pt; color: rgb(0, 0, 0);'><b>Heading</b><br />
			<span style='font-size: 11pt;'>(all figures including revisions)</span></span><br style='line-height: normal; orphans: 2; text-align: -webkit-auto; widows: 2;' />
			&nbsp;</td>
			<td colspan='1' rowspan='2'><br />
			<span style='font-size: 11pt; color: rgb(0, 0, 0);'><b>Approval</b></span><br style='line-height: normal; orphans: 2; text-align: -webkit-auto; widows: 2;' />
			&nbsp;</td>
			<td colspan='1' rowspan='2'><br />
			<span style='font-size: 11pt; color: rgb(0, 0, 0);'><b>For Info</b></span><br style='line-height: normal; orphans: 2; text-align: -webkit-auto; widows: 2;' />
			&nbsp;</td>
			<td><br />
			<span style='font-size: 11pt; color: rgb(0, 0, 0);'><b>Total</b></span></td>
		</tr>
		<tr>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Total documents returned approved</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Total documents discarded</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Total documents returned not approved</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td>Total documents on hold</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>		
		<tr>
			<td>Total documents currently under approval</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td colspan='3' rowspan='1'>&nbsp;</td>
			<td>&nbsp;</td>
		</tr>
	</tbody>
</table>";
	$wrap = "<textarea class='ckeditor form-control' cols='10' rows='20' id='reportPreview' >" . $isireport . "</textarea><script>        CKEDITOR.disableAutoInline = true;
        $('textarea.ckeditor').ckeditor();</script>";
	echo $wrap;
	}

function SetPermission($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $kontrak, $salting, $obj)
	{
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$idProj = $pieces[1];
	$id_user = $pieces[2];
	$act = $pieces[0];
	if ($act == "update")
		{
		$jabatan = $kontrak->GetjabatanteamUser($idProj, $user_id);
		if ($jabatan  == 59 || $salting == 9) 
			{
			$proj_jabatan = $pieces[4];
			$permission = $pieces[3];
			$kontrak->updateProjectteamPermission($id_user, $proj_jabatan, $idProj, $permission);
			$obj->WriteLogAplicationLogs($user_id, $pieces[1], "namaproj", $user_id, "update", 0, 0, "update permission " . $stringCommand);
			}
		  else
			{
			echo "<script>alert('you are not allowed')</script>";
			}
		}

	$listjabatan = $kontrak->get_Position_proj();
	$idjabatan = $kontrak->GetjabatanteamUser($idProj, $id_user);
	foreach($listjabatan as $listjabata)
		{
		if ($idjabatan == $listjabata['id'])
			{
			$checked = "checked";
			}
		  else
			{
			$checked = "";
			}

		$strabbatn = $strabbatn . "<input type='radio' name='jabatanpermision' value='$listjabata[id]' $checked> $listjabata[nama] &#09; &emsp;";
		}

	$listPermision1 = $kontrak->get_permisionlist(1);
	$listPermision2 = $kontrak->get_permisionlist(2);
	$listpermision = $kontrak->get_proj_teambyID($idProj, $id_user);
	$permisionPieace = explode(",", $listpermision);
	foreach($listPermision1 as $listPermision)
		{
		if (in_array($listPermision['id'], $permisionPieace))
			{
			$strceked = "checked";
			}
		  else
			{
			$strceked = "";
			}

		$strdash = $strdash . "<input type='checkbox' name='dashcek' value='$listPermision[id]' $strceked >$listPermision[name] &#09; &emsp;";
		}

	foreach($listPermision2 as $listPermision2)
		{
		if (in_array($listPermision2['id'], $permisionPieace))
			{
			$strceked = "checked";
			}
		  else
			{
			$strceked = "";
			}

		$strdash2 = $strdash2 . "<input type='checkbox' name='dashcek' value='$listPermision2[id]' $strceked >$listPermision2[name] &#09; &emsp;";
		}

	$strbalik = "<hr><strong> Position : </strong> <br />" . $strabbatn . "</hr><hr><br /><strong>Dashboard : </strong><p>" . $strdash . "<hr>
<br /><strong>Tab menu : </strong> <br />" . $strdash2 . "</hr> ";
	echo $strbalik;

	// Nilai balik.

	}

function survey($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj, $kontrak, $commentStatus, $objx, $C_client)
	{
	$act = $_POST['act'];
	if (isset($act) && !empty($act))
		{
		}
	  else
		{
		$stringCommand = $_POST['stringCommand'];
		$pieces = explode("#", $stringCommand);
		$act = $pieces[0];
		$idkon = $pieces[1];
		}

	if ($act == "addreport")
	{
		$tanggal = date("Y-m-d", strtotime($_POST['tanggal']));
		$tipe = $_POST['form-field-select-1survey'];
		$link = $_POST['form-field-select-itemsurvey'];
		$progress = $_POST['progresssurvey'];
		$narasi = $_POST['narasisurvey'];
		$createby = $user_id;
		$id_kon = $_POST['id_kon'];
		$arrComment = $_POST['surveycomen'];
		$idkon = $id_kon;
		$tipeC = 15; //comment dari surveyor tipe 5
		$status = 0;
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$locationSurvey= $_POST['locationsurvey'];
		$tipecomment=4 ;

		// add comment

		if (is_array($arrComment))
			{
			foreach($arrComment as $commnet)
				{
				if (trim($commnet) != "")
					{
					$last_no_coms = $comment->get_db_comment_last($id_kon, $tipeC);
					foreach($last_no_coms as $last_no_com)
						{
						$las_number = $last_no_com['nomer_comment'];
						}

					$las_number = str_replace($simb_gam[$tipeC] . "-", "", $las_number);
					$nem_number = intval($las_number) + 1;
					$nomer = $simb_gam[$tipeC] . "-" . $nem_number;
					$nomerReport = $comment->genreatedReportnum($id_kon);
					$comment->insert_db_comment($nomer, $commnet, $nomerReport, $user_id, 2, $current_date, $id_kon, $tipeC, $status,'',$tipecomment);
					$id_comen = $comment->lastInsertId();
					$comment->insert_comment_his($id_comen, $commnet, $user_id, $current_date, $id_kon); //gae history e lek ono update
					$kom_m = substr($commnet, 0, 100);
					$comment->insert_comment_log('Membuat komen baru : <span class=error > ' . $kom_m . '</span> -..', $id_comen, $id_kon, $current_date, $user_id);
					$isicomment = $isicomment . $nomer . ",";

					// insertlogsAplikasi

					$obj->WriteLogAplicationLogs($user_id, $id_kon, "Create comment survey", $user_id, "", 0, 0, "" . $kom_m);
					}
				}
			}

		if ($isicomment == "")
			{
			$isicomment = "clear";
			}

		// endaddcomment

		$randomname = "svy_" . getRandomFilename() . ".pdf";
		$alamat = "../data/" . $id_kon . "/";
		if (!is_dir($alamat))
			{
			mkdir($alamat, 0700);
			}

		if ($_FILES["file"]["error"] != 4)
			{ //jika adafile di upload
			if ($drawing->uploadfilePDF($_FILES["uploadAttacmentReport"]["tmp_name"], $randomname, $alamat, "noencript"))
				{
				$file = $alamat . $randomname;
				$comment->insert_db_report($tanggal, $tipe, $narasi, $isicomment, $createby, $file, $id_kon,$locationSurvey);
				
				//link to task
				$reportId = $comment->lastInsertId();
				$comment->insertLinkReport($link, $reportId);
				$objx->updateProgressSurvey($link, $progress, $user_id);

				// insertlogsAplikasi

				$obj->WriteLogAplicationLogs($user_id, $id_kon, "create laporan survey", $user_id, "", 0, 0, "" . $file);
				$act = "refreshreport";
				}
			  else
				{
				$file = "none";
				$comment->insert_db_report($tanggal, $tipe, $narasi, $isicomment, $createby, $file, $id_kon,$locationSurvey);

				//link to task
				$reportId = $comment->lastInsertId();
				$comment->insertLinkReport($link, $reportId);
				$objx->updateProgressSurvey($link, $progress, $user_id);

				// insertlogsAplikasi

				$obj->WriteLogAplicationLogs($user_id, $id_kon, "create laporan survey", $user_id, "", 0, 0, "tanpa ATTACHMENTS" . $file);
				$act = "refreshreport";
				}
			}
	}

	if ($act == "dell")
		{
		$idreport = $pieces[2];
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$listReport = $comment->get_db_reportbyID($idkon, $idreport);
		$jabatan = $kontrak->GetjabatanteamUser($idkon, $user_id);
		foreach($listReport as $listRepor)
			{
			$tangg = $listRepor['dateCreated'];
			$publish = $listRepor['publishdate'];
			$commnet = $listRepor['comment'];
			$nomerReport = $listRepor['noreport'];
			}
			//echo $jabatan ;
		if ($jabatan < 59)
			{
			if ($drawing->cek_waktu_kurang1jam($tangg, $current_date))
				{
					
					if($user_id==$comment->CekUserCreateCommentsurvey($nomerReport, $idkon)){

						if ($publish == "0000-00-00 00:00:00")
							{
							$comment->delete_db_commentbyReport($nomerReport, $idkon); //dellcomment
							$comment->delete_db_report($idreport, $idkon); //dell report

							// insertlogsAplikasi

							$obj->WriteLogAplicationLogs($user_id, $idkon, "Dell laporan berserta comment", $user_id, "", 0, 0, "" . $nomerReport);
							}
						  else
							{
							echo "<script> alert('failed to delete, already publish.  need the leader') ;</script>";
							}
					}else{
						echo "<script> alert('failed to delete, only creator can do this action') ;</script>";
					}		
				}
			  else
				{
				echo "<script> alert('failed to delete, delete only < 1 hour $tangg ') ;</script>";
				}
			}
		  else
			{

			$comment->delete_db_commentbyReport($nomerReport, $idkon); //dellcomment
			$comment->delete_db_report($idreport, $idkon); //dell report

			// insertlogsAplikasi

			$obj->WriteLogAplicationLogs($user_id, $idkon, "Dell laporan berserta comment", $user_id, "", 0, 0, "" . $nomerReport);
			}

		$act = "refreshreport";
		}

	if ($act == "publishReport")
		{
		$idreport = $pieces[2];
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$listReport = $comment->get_db_reportbyID($idkon, $idreport);
		$jabatan = $kontrak->GetjabatanteamUser($idkon, $user_id);
		foreach($listReport as $listRepor)
			{
			$tangg = $listRepor['dateCreated'];
			$publish = $listRepor['publishdate'];
			$commnet = $listRepor['comment'];
			$nomerReport = $listRepor['noreport'];
			}

		$comment->update_db_comment_pointByreport($nomerReport, $idkon); //update comment
		$comment->publish_db_report($current_date, $user_id, $idreport); //update report

		// insertlogsAplikasi

		$obj->WriteLogAplicationLogs($user_id, $idkon, "publish report dan comment", $user_id, "", 0, 0, "" . $stringCommand);
		$C_client = new client();
		$C_client->insertLogSyncClient(1, $idkon, 'New Publish Survey Report ' . $nomerReport);
		$act = "refreshreport";
		}

	if ($act == "refreshreport")
		{
		$surveyTipe = array(
			"",
			"Regular",
			"Patrol"
		);

		// nilaibalik

		$listReportlo = $comment->get_db_report($idkon);
		$listReport = "<table class='table table-striped table-bordered table-hover' id='sample_4'>
									<thead>
										<tr>
											<th>No</th>
											<th>NoReport</th>
											<th>Location</th>
											<th>Date</th>
											<th>Type </th>
											<th>Summary[50]</th>
											<th>by</th>
											<th>Comment</th>
											<th>File</th>
											<th>Publish</th>
											<th>Action</th>								
										</tr>
									</thead>
									<tbody>";
		$no = 1;
		foreach($listReportlo as $listRepor)
			{
			if ($listRepor['file'] == 'none')
				{
				$linkFile = 'none';
				}
			  else
				{
				$linkFile = "<a href='$listRepor[file]' target=_blank > file </a>";
				}

			$isinarasiFull = strip_tags($listRepor['narasi']);
			$listReport = $listReport . "<tr >
									<td >$no</td>
									<td title='$isinarasiFull'><a href='panel.php?module=surveyreport&idproj=$idkon&id=$listRepor[id]' target=_blank >$listRepor[noreport]</a> </td>
									<td >$listRepor[location]</td>
									<td >$listRepor[tanggal]</td>
									<td >" . $surveyTipe[$listRepor['tipe']] . "</td>
									<td >" . substr($listRepor['narasi'], 0, 50) . "</td>
									<td >" . $alluserArray[$listRepor['createby']] . "</td>
									<td >$listRepor[comment]</td>
									<td >$linkFile</td>
									<td >$listRepor[publishdate]</td>
									<td > " . "<a   onclick=" . "publishReport(" . $listRepor['id'] . "," . $idkon . "); > Pub  | </a> " . "<a   onclick=" . "delReport(" . $listRepor['id'] . "," . $idkon . "); >   Dell </a>   " . "</td>
									</tr>";

			$no++;
			}

		$listReport = $listReport . "</tbody></table><script> generatedTable(4);</script>";
		echo $listReport;
		}

	if ($act == "refreshdraw")
		{
		$id_kon = $pieces[1];

		// nilai balik

		$get_draws = $drawing->get_proj_gambar($id_kon);
		$strlistgambar = "<table class='table table-striped table-bordered table-hover' id='sample_2'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>Nama </th>
											<th>Tipe Gambar</th>
											<th>Masuk</th>
											<th>Status</th>
											<th class='hidden-xs'>Property</th>
											<th class='hidden-xs'>Field</th>
											<th class='hidden-xs'>Review</th>
											<th class='hidden-xs'>Approved</th>
											
											<th>Open</th>
											<th>Download</th>
																						
										</tr>
									</thead>
									<tbody>";
		$no = 1;
		foreach($get_draws as $get_draw)
			{
			$z = $get_draw['tipe'];
			if ($get_draw['status'] == 1)
				{
				$strReqdownload = " ok ";
				$openlink = "<a href='enginerrview.php?module=stamp&kon=" . $id_kon . "&gam=$get_draw[id_stamp]' target=_blank>" . "Open</a>";
				$rekdownload = "<a onclick='requestdownload($get_draw[id],$id_kon,&#34;$get_draw[no_gambar]&#34;);'>Req</a>";
				}
			  else
				{
				$strReqdownload = "-";
				$openlink = "<a href='enginerrview.php?module=read&kon=$id_kon&gam=$get_draw[id]'" . "target='_blank'>" . "Open</a>";
				$rekdownload = '';
				}

			$EngginerFild = $drawing->get_tipe_gambar_field();
			$approval = array(
				"Drawing",
				"Calculation",
				"Report",
				"Misc",
				"doc. forinfo"
			);
			$strEng = $EngginerFild[$get_draw['engfield']];
			$strinfo = $approval[$get_draw['forinfo']];
			$perant = $get_draw['id_kontrak'] . "," . $get_draw['id'];
			if (($get_draw['reviewdate'] === NULL) || ($get_draw['reviewdate'] == "0000-00-00 00:00:00"))
				{
				$reviewdatee = "";
				}
			  else
				{
				$reviewdatee = date('Y-M-d', strtotime($get_draw['reviewdate']));
				}

			$strlistgambar = $strlistgambar . "<tr >
										<td >$no</td>
										<td > <a href='panel.php?module=listrevision&id=" . $id_kon . "&mod=2&draw=$get_draw[id] '>" . $get_draw['no_gambar'] . " </a></td>
										<td >" . $get_draw['judul'] . " </a></td>
										<td >" . $tipegambbararr[$z] . "</td>
										<td>" . $get_draw['tanggal'] . "</td>
										<td>" . $strReqdownload . "</td>
										<th class='hidden-xs'>$strinfo</th>
										<th class='hidden-xs'>$strEng</th>
										<th class='hidden-xs'>" . $alluserArray[$get_draw['userid']] . "</th>
										<th class='hidden-xs'>" . $alluserArray[$get_draw['review']] . " / $reviewdatee</th>
									
										<td>" . $openlink . "
										</td>
										<td>$rekdownload</td>									
										</tr>";
			$no++;
			}

		$strlistgambar = $strlistgambar . "</tbody></table><script> generatedTable(2);</script>";
		echo $strlistgambar;
		}

	if ($act == "refreshcomment")
		{
		$proj_id = $pieces[1];
		$tipe = $pieces[2];

		// nilai balik

		$get_comments = $comment->get_db_comment($proj_id);
		$zz = $Users->get_users();
		foreach($zz as $z)
			{
			$x = $z['id_user'];
			$userx[$x] = $z['nama'];
			}

		$strCommenet = "<table class='table table-striped table-bordered table-hover' id='sample_12'>
									<thead>
										<tr>
											<th width='30'>No</th>
											<th width='100'>No Comment</th>
											<th >Comment </th>
											<th width='100' >Drawing / Report Number</th>
											<th width='100'>Create by</th>
											<th width='100'>Date</th>
											<th width='100'>Position</th>
											<th width='50'>Status</th>
																				
										</tr>
									</thead>
									<tbody>";
		$no = 1;
		$statu_s = array(
			"Open",
			"closed",
			"Info"
		);
		foreach($get_comments as $get_comment)
			{
			$d = $get_comment['create_by'];
			$tang = date("d-M-Y", strtotime($get_comment['tanggal']));
			$perantar = $get_comment['id'] . ",'" . $get_comment['nomer_comment'] . "'";
			$peranta = $get_comment['id'] . ",'" . $get_comment['id_kontrak'] . "'";
			$perant = $get_comment['id'] . ",'" . $get_comment['id_kontrak'] . "',2";
			if ($get_comment['importan'] == 0)
				{
				$strImportan = '';
				}
			  else
				{
				$strImportan = 'checked';
				}

			if ($tipe == 0)
				{
				$link = "<a href='panel.php?module=replaycom&id=" . $proj_id . "&com=$get_comment[id] ' target=_blank>" . $get_comment['nomer_comment'] . " <div class='bintang'><input type='checkbox'  readonly $strImportan/><label for='st1'> </label></div></a>";
				}
			  else
				{
				$link = $get_comment['nomer_comment'];
				}

			$strCommenet = $strCommenet . "<tr >
									<td >$no</td>
									
									<td title='$get_comment[gamb_infoRef]' > $link </td>
									<td width='60%'>" . $get_comment['comment'] . "</td>
									<td>" . $get_comment['gambar'] . "</td>
									<td>" . $userx[$d] . "</td>
									<td>" . $tang . "</td>
									<td>" . $commentStatus[$get_comment['point']] . "</td>
									<td>" . $statu_s[$get_comment['status']] . "</td>
															
									</tr>";
			$no++;
			}

		echo $strCommenet . "</tbody></table><script> generatedTable(12);</script><hr>";
		}

	if ($act == "refreshdrawingdownload")
		{
		$id_kon = $pieces[1];

		// nilai balik

		$listdownloadReq = $drawing->get_DownloadDrawing($id_kon, $user_id);
		$strlistgambar = "<table class='table table-striped table-bordered table-hover' id='sample_5'>
									<thead>
										<tr>
											<th>No</th>
											<th>Drawing Number </th>
											<th>tanggal </th>
											<th>status</th>
											<th>Approveby</th>
											<th>downloadtime</th>
											<th>download</th>
											
											
																						
										</tr>
									</thead>
									<tbody>";
		$no = 1;
		foreach($listdownloadReq as $get_draw)
			{
			$perant = $get_draw[id_kontrak] . "," . $get_draw['id'];
			if (($get_draw['status'] == 1) && ($get_draw[downloadtime] == "0000-00-00 00:00:00"))
				{
				$strdownload = "<a href='drawingdownload.php?id=$get_draw[id]' target=_blank >" . "Download.</a> ";
				}
			  else
				{
				$strdownload = "";
				}

			$strlistgambar = $strlistgambar . "<tr >
									<td >$no</td>
									<td >" . $get_draw['drawingno'] . " </td>
									<td >" . $get_draw['tanggal'] . " </a></td>
									<td >" . $get_draw['status'] . "</td>
									<td>" . $alluserArray[$get_draw[aprroveby]] . "</td>
									<td>" . $get_draw[downloadtime] . "</td>
									<td>" . $strdownload . "</td>
																	
									</tr>";
			$no++;
			}

		$strlistgambar = $strlistgambar . "</tbody></table><script> generatedTable(5);</script>";
		echo $strlistgambar;
		}
	}

function rule($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $salting, $tipegambbararr, $obj, $kontrak, $commentStatus, $objx, $C_client, $Rules)
	{
	$Rules = new Rule();
	$stringCommand = $_POST['stringCommand'];
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	$id_kon = $pieces[1];
	if ($act == 'refreshrules')
		{
		$listRules = $Rules->getActiverules();
		$JenisTechnical_paper = array(
			"Error",
			"Rules",
			"Guidelines",
			"Guidance",
			"Reference Note"
		);
		$Statuss = array(
			"Error",
			"Active",
			"No Publish",
			"Obsolete"
		);
		$strlistrules = "<table class='table table-striped table-bordered table-hover' id='sample_15'>
																<thead>
																	<tr>
																		<th>No</th>
																		<th>ID</th>
																		<th>Rules ID</th>
																		<th>Technical Paper</th>
																		<th>Year</th>
																		<th>Part</th>
																		<th>Vol</th>
																		<th>Type</th>
																		<th>Status</th>
																		<th>Add.</th>
																							
																	</tr>
																</thead>
																<tbody>";
		$n = 1;
		foreach($listRules as $listRule)
			{
			$strlistrules = $strlistrules . "<tr >
																<td >$n</td>
																<td >" . $listRule['id'] . " </td>
																<td >" . $listRule['id_rules'] . " </a></td>
																<td ><a href='http://rnd.bki.co.id/rms/view_rule_telik.php?module=viewrules&id=$listRule[id]' target=_blank >" . $listRule['nama'] . "</a></td>
																<td>" . $listRule['tahun'] . "</td>
																<td>" . $listRule['part'] . "</td>
																<td>" . $listRule['vol'] . "</td>
																<td>" . $JenisTechnical_paper[$listRule['tipe']] . "</td>
																<td>" . $Statuss[$listRule[status]] . "</td>
																<td><a href='#' onclick='AddRulesrulesAplicable($id_kon, $listRule[id_rules], $listRule[id],&#34;$listRule[nama]&#34;)'>Add. </a></td>
																								
																</tr>";
			$n++;
			}

		$strlistrules = $strlistrules . "</tbody></table><script> generatedTable(15);</script>";
		echo $strlistrules;
		die;
		}
	elseif ($act == 'add')
		{
		$id_kon = $pieces[1];
		$idRules = $pieces[2];
		$idpublicRules = $pieces[3];
		$rules_name = $pieces[4];
		$updateat = date('Y-m-d H:s');

		// getInfo rules

		$strinfoRules = $Rules->getActiverulesbyid($idpublicRules);
		foreach($strinfoRules as $strinfoRule)
			{
			$part = $strinfoRule['part'];
			$vol = $strinfoRule['vol'];
			$tipe = $strinfoRule['tipe'];
			$tahun = $strinfoRule['tahun'];
			}

		$namarules = CreateNameRules($part, $vol, $rules_name, $tipe, $tahun);
		$obj->InsertRulesApplicable($idpublicRules, $idRules, $namarules, $id_kon, $user_id, $user_id, $updateat);
		}
	elseif ($act == 'refreshrulesRulesaplicable')
		{
		$id_kon = $pieces[1];
		}
	elseif ($act == 'dell')
		{
		$id_kon = $pieces[1];
		$id = $pieces[2];
		$obj->DellRulesApplicable($id, $id_kon);
		}

	// nilai balik

	$listRules = $obj->GetRulesApplicable($id_kon);
	$JenisTechnical_paper = array(
		"Error",
		"Rules",
		"Guidelines",
		"Guidance",
		"Reference Note"
	);
	$strlistrules = "<table class='table table-striped table-bordered table-hover' id='sample_16'>
																<thead>
																	<tr>
																		<th>No</th>
																		<th>ID</th>
																		<th>Rules ID</th>
																		<th>Technical Paper</th>
																		<th>Action</th>
																							
																	</tr>
																</thead>
																<tbody>";
	$n = 1;
	foreach($listRules as $listRule)
		{
		$strlistrules = $strlistrules . "<tr >
																<td >$n</td>
																<td >" . $listRule['idpublicRules'] . " </td>
																<td >" . $listRule['idRules'] . " </a></td>
																<td ><a href='https://servrules.bki.co.id:81/viewrules.php?id=$listRule[idRules]' target=_blank' target=_blank >" . $listRule['rules_name'] . "</a></td>
																<td><a href='#' onclick='DellRulesrulesAplicable($id_kon,$listRule[id]);' > Dell </a></td>
															
																								
																</tr>";
		$n++;
		}

	$strlistrules = $strlistrules . "</tbody></table><script> generatedTable(16);</script>";
	echo $strlistrules;

	// echo "merdeka";

	}

	function administratif( $Users, $user_id, $alluserArray, $Activity, $salting, $obj,$drawing)
	{

		$act = $_POST['act'];
		if (isset($act) && !empty($act))
		{
			}
	  else
		{
			$stringCommand = $_POST['stringCommand'];
			$pieces = explode("#", $stringCommand);
			$act = $pieces[0];
			$id_kon = $pieces[6];
		}


		if ($act=="updateImportanddate") {
			
			//kickoff meetitng
			$item="kick-off";
			$tanggal = date("Y-m-d",strtotime($pieces[1]));
			$obj->updateImportanDatefunc($tanggal,$item, $id_kon,$user_id);

			$item="keel-laying";
			$tanggal = date("Y-m-d",strtotime($pieces[2]));
			$obj->updateImportanDatefunc($tanggal,$item, $id_kon,$user_id);

			$item="launching";
			$tanggal = date("Y-m-d",strtotime($pieces[3]));
			$obj->updateImportanDatefunc($tanggal,$item, $id_kon,$user_id);

						
			$item="seatrial";
			$tanggal = date("Y-m-d",strtotime($pieces[4]));
			$obj->updateImportanDatefunc($tanggal,$item, $id_kon,$user_id);

			$item="final";
			$tanggal = date("Y-m-d",strtotime($pieces[5]));
			$obj->updateImportanDatefunc($tanggal,$item, $id_kon,$user_id);

			echo "<script>alert('done!')</script>";

		}elseif ($act=="AddTaskTurunanImportandate") {

			$importandDateArr= array("","kick-off","keel-laying","launching","seatrial","final");
		
           $listsubcriber = "," . $user_id;
           $tasktitle  = $pieces[1] ;
           $corelation= $pieces[4] ;
           $id_kon=$corelation;
           $pesan= $pieces[3] ;
           $SelectImportandate= $pieces[2] ;

           $listglInportant=$obj->GetImportanDatebyIdkon_item($id_kon,$importandDateArr[$SelectImportandate]);

           foreach ($listglInportant as $listglInportan ) {

           	$endtask=$listglInportan['tanggal'];
           }

           $tasktitle  = "[IMDATE" . $id_kon . "#" . $SelectImportandate . "] ".  $pieces[1] ;

           $starttask=date('Y-m-d');
           $asigmentto= $user_id ;

         
        	$obj->addTaskobj(5, $tasktitle, $user_id, $corelation, 0, $pesan, $endtask, $starttask, $asigmentto, $listsubcriber);

         	//echo   "<script>alert('done!');</script>";
         	$refresimportandate=true ;
		}elseif ($act=="RefresTaskImportanddate") {

			$refresimportandate=true ;
			$id_kon =$pieces[1]; 

		}elseif ($act=="AddTaskDocumentRequest") {
			$id_kon = $pieces[4] ; 
			$docTitle = $pieces[1] ; 
			$due_date = date("Y-m-d",strtotime($pieces[2])) ; 
			$pesan = $pieces[3] ; 

			$CompilasiTitle=  "[DRS" . $id_kon . "#]"  . $docTitle ;

			$starttask=date('Y-m-d');
           	$asigmentto= $user_id ;

         
        	$obj->addTaskobj(5, $CompilasiTitle, $user_id, $id_kon, 0, $pesan, $due_date, $starttask, $asigmentto, $listsubcriber);

        	$docreqestbalik= true ;

		}elseif ($act=="RefresDocumenRequest") {
			$docreqestbalik=true ;
			$id_kon =$pieces[1]; 
		}elseif ($act=="AddMatkommasterlist") {

			$itemname = $pieces[1] ; 
			$typecertmatkom = $pieces[3] ; 
			$isseudmatkomby = $pieces[4] ; 
			$rulesaplicablematkom = $pieces[5] ; 
			$cerlevelmatkom = $pieces[6] ; 
			$descrmatkom = $pieces[7] ; 
			$id_kon= $pieces[2] ; 
			$status=0 ;

			$updateat=Date("Y-m-d\ H:i:s\ ");



			$obj->InsertmatkomMaterList($itemname, $id_kon, $typecertmatkom , $descrmatkom , $status , $user_id , 0,$user_id, $updateat,$isseudmatkomby ,$rulesaplicablematkom , $cerlevelmatkom);

			$refreshMAtkomMaterList= true ; 
			$listonly=false;

		}elseif ($act=='RefresMatkommasterlist') {
			$refreshMAtkomMaterList=true ;
			$id_kon =$pieces[1]; 
		}elseif($act=='RefresMatkomlist'){

			$refreshMAtkomMaterList=true ;
			$id_kon =$pieces[1]; 
			$listonly=true;

		}elseif ($act=='DellMatkommasterlist') {
			$refreshMAtkomMaterList=true ;
			$id_kon =$pieces[1]; 
			$obj->TrashmatkomMaterList(1, $user_id,$pieces[2]);
			$listonly=false;
		}elseif ($act=='RefresMatkommaCombo') {
			$id_kon =$pieces[1]; 
			$listmaterials = $obj->getmatkomMaterLis($id_kon);
			$strListoption= "<option></option>";
			foreach ($listmaterials as $listmaterial ) {
				$strListoption .= "<option value='$listmaterial[id]'>$listmaterial[material_name]</option>" ;
			}
			$comboConstruct="<select name='tipenamematrial' class='col-sm-2 form-control' id='tipenamematrial' onchange='loadDetailMatkom($id_kon);'>" . $strListoption . "</select>" ;
            echo $comboConstruct ;                                    
                                                
		}elseif ($act=='loaddetailMatkommaCombo') {

			$id_kon =$pieces[1]; 
			$id=$pieces[2]; 

			$details= $obj->getmatkomMaterLisbyid($id_kon, $id);
			foreach ($details as $detail ) {
				$Item_name= "<pre>
					$detail[material_name]
					$detail[rules]
					$detail[issued]
				</pre>";
			}
			echo $Item_name ;
			
		}elseif ($act=='addCertificated') {

			$id_kon=$_POST['idkontrak'];
			$id_matkom= $_POST['tipenamematrial'];
			$id_certificated= $_POST['cernumber'];
			$description= $_POST['describtion'];
			$updateat=Date("Y-m-d\ H:i:s\ ");

			$randomname = "mtk_" . getRandomFilename() . ".pdf";
			$alamat = "../data/" . $id_kon . "/";
			if (!is_dir($alamat))
				{
				mkdir($alamat, 0700);
				}

			if ($_FILES["file"]["error"] != 4)
				{ //jika adafile di upload
				if ($drawing->uploadfilePDF($_FILES["upload"]["tmp_name"], $randomname, $alamat, "noencript"))
					{
					$file = $alamat . $randomname;
					
					//insertdb
					$obj->InsertisUploadCertificatedComponent($id_matkom , $id_certificated, $description, $file,$user_id,$updateat, $user_id,$id_kon );
					//set status oke

					$obj->UpdateStatusmatkomMaterList(1, $user_id,$id_matkom);


					$obj->WriteLogAplicationLogs($user_id, $id_kon, "upload Certificated Matkom", $user_id, "", 0, 0, "" . $file);
					$refreshMAtkomMaterList=true;
					$listonly=true;
					}
				}

		}elseif ($act=="DellUploadCerMatko") {
			$id_kon=$pieces[1] ; 
			$id=$pieces[2] ; 
			$id_matkom=$pieces[3] ; 
			$obj->DeletedUploadCertificatedComponent($id);
			$obj->UpdateStatusmatkomMaterList(0, $user_id,$id_matkom);
			$obj->WriteLogAplicationLogs($user_id, $id_kon, "Deleted Certificated Matkom", $user_id, "", 0, 0, "" );		
			$refreshMAtkomMaterList=true;	
			$listonly=true;	
		}elseif($act=="updateProjectquery"){
			$id_kon=$pieces[1] ; 
			$vesselname=$pieces[2] ; 
			$bkiid=$pieces[3] ; 
			$bkidesaindid=$pieces[4] ; 
			$imo=$pieces[5] ; 
			$operationstat=$pieces[6] ; 
			$flag=$pieces[7] ; 
			$port=$pieces[8] ; 
			$owner=$pieces[9] ; 
			$manager=$pieces[10] ; 
			$rulesset=$pieces[11] ; 
			$ruleedision=$pieces[12] ; 
			$classnotation=$pieces[13] ; 
			$type=$pieces[14] ; 
			$builder=$pieces[15] ; 
			$hullyard=$pieces[16] ; 
			$outfittingyard=$pieces[17] ; 
			$keellaid=date('Y-m-d H:i:s',strtotime($pieces[18])) ; 
			$launchdate=date('Y-m-d H:i:s',strtotime($pieces[19])) ; 
			$dateofbuild=date('Y-m-d H:i:s',strtotime($pieces[20])); 
			$deliverydate=date('Y-m-d H:i:s',strtotime($pieces[21])) ; 
			$loa=$pieces[22] ; 
			$lbp=$pieces[23] ; 
			$lload=$pieces[24] ; 
			$bext=$pieces[25] ; 
			$b=$pieces[26] ; 
			$d=$pieces[27] ; 
			$draught=$pieces[28] ; 
			$freeboard=$pieces[29] ; 

			$obj->Updateprojectquery($id_kon,$vesselname,$bkiid,$bkidesaindid,$imo,$operationstat,$flag,$port,$owner,$manager,$rulesset,$ruleedision,$classnotation,$type,$builder,$hullyard,$outfittingyard,$keellaid,$launchdate,$dateofbuild,$deliverydate,$loa,$lbp,$lload,$bext,$b,$d,$draught,$freeboard);

			echo "<script>alert('done');</script>";
			//echo $classnotation ;
		}





//####Bagian nilai balik 


		if ($refreshMAtkomMaterList==true) {
			
			$listTaskTurunan = $obj->getmatkomMaterLisJointuploadCert($id_kon);
			//echo $id_kon ;
	        $strTablebalik= "<table class='table table-striped table-bordered table-hover' id='sample_43'>
	                                        <thead>
	                                            <tr>
	                                            	<th>No</th>
	                                                <th>Item</th>
	                                                <th>Type</th>
	                                                <th>Organization.</th>
	                                                <th>Cert.Lvl</th>
	                                                <th>Status</th>
	                                                <th class='hidden-xs' width='100px' >Action</th>
	                                                
	                                            </tr>
	                                        </thead>
	                                        <tbody>";

	                                        $no=1;
	                                        $arrayTipeCert= array("","","Type test", "Mass","");
	                                        $arrayLvlCert= array("","Type test", "Mass","Ajib");
	                                        $arrayStatus= array("not Yet","Oke");
	        foreach ($listTaskTurunan  as $TaskList) {
				
	        	if ($listonly==true){
	        		$straction="<a href='#' onclick='DellUploadCerMatko($TaskList[id_upload],$id_kon,$TaskList[id_master])' >Dell</a>";
	        	}else{
	        		$straction="<a href='#' onclick='DellMatkommasterlist($TaskList[id_master],$id_kon)' >Dell</a>";
	        	}


	            $strTablebalik=$strTablebalik. "<tr>
	            									<td>$no </td>
	            									<td title='$TaskList[descript]'> $TaskList[material_name] </td>
	            									<td >". $arrayTipeCert[$TaskList['tipe']] ."</td>
	            									<td > $TaskList[issued] </td>
	            									<td >". $arrayLvlCert[$TaskList['certificated_level']] ."</td>
	            									<td title='$TaskList[rules]'>".  $arrayStatus[$TaskList['status']] . "</td>
	            									<td > 
	            									$straction
	            									</td>

	                                                
	                                            </tr>";

	            $no++;                                
			}							
				
			$strTablebalik=$strTablebalik. "</tbody></table>" ;

			 echo $strTablebalik .  "<script>generatedTable(43)</script>";                                
		}

		if ($docreqestbalik==true) {
			$category="[DRS" . $id_kon . "#]%" ;
	        $listTaskTurunan = $obj->getProjectTaskbyIdprojectBycategory($id_kon,$category);

	        $strTablebalik= "<table class='table table-striped table-bordered table-hover' id='sample_22'>
	                                        <thead>
	                                            <tr>

	                                                <th>Name</th>
	                                                
	                                                <th  ></th>
	                                                
	                                            </tr>
	                                        </thead>
	                                        <tbody>";

			foreach ($listTaskTurunan  as $TaskList) {
				

				$idassigment = $TaskList['assigned_to_contact_id'];
	            $taskStart   = date("M d , Y", strtotime($TaskList['start_date']));
	            $taskEnd     = date("M d , Y", strtotime($TaskList['due_date']));
	            
	            if ($TaskList['percent_completed'] == 100) {
	                $styletambahan = "style='opacity: 0.25; text-decoration: line-through;'";
	                $taskEnd       = Getbadge($taskEnd, 1);
	            } else {
	                
	                $styletambahan = "";
	                $taskEnd       = Getbadge($taskEnd, 0);
	            }
	            
	            $namaReplace=str_replace("[DRS" . $id_kon . "#" . "]" ,"",$TaskList['name']);

	            $strTablebalik=$strTablebalik. "    <tr $styletambahan>
	                                                <td ><a href='panel.php?module=projectDetail&id=$TaskList[object_id]' target=_blank><strong>$alluserArray[$idassigment] </strong>: $namaReplace</a></td>
	                                                
	                                                
	                                                <td >Start: $taskStart | due : $taskEnd</td>
	                                                
	                                            </tr>";

			}								
			$strTablebalik=$strTablebalik. "</tbody></table>" ;

			 echo $strTablebalik .  "<script>generatedTable(22)</script>";			
		}


		if($refresimportandate==true){

			$category="[IMDATE" . $id_kon . "#%" ;
	        $listTaskTurunan = $obj->getProjectTaskbyIdprojectBycategory($id_kon,$category);

	        $strTablebalik= "<table class='table table-striped table-bordered table-hover' id='sample_21'>
	                                        <thead>
	                                            <tr>

	                                                <th>Name</th>
	                                                
	                                                <th class='hidden-xs' width='300px' ></th>
	                                                
	                                            </tr>
	                                        </thead>
	                                        <tbody>";

			foreach ($listTaskTurunan  as $TaskList) {
				

				$idassigment = $TaskList['assigned_to_contact_id'];
	            $taskStart   = date("M d , Y", strtotime($TaskList['start_date']));
	            $taskEnd     = date("M d , Y", strtotime($TaskList['due_date']));
	            
	            if ($TaskList['percent_completed'] == 100) {
	                $styletambahan = "style='opacity: 0.25; text-decoration: line-through;'";
	                $taskEnd       = Getbadge($taskEnd, 1);
	            } else {
	                
	                $styletambahan = "";
	                $taskEnd       = Getbadge($taskEnd, 0);
	            }
	            
	            $namaReplace=str_replace("[IMDATE" . $id_kon . "#1" . "] " ,"",$TaskList['name']);
	            $namaReplace=str_replace("[IMDATE" . $id_kon . "#2" . "] " ,"",$namaReplace);
	            $namaReplace=str_replace("[IMDATE" . $id_kon . "#3" . "] " ,"",$namaReplace);
	            $namaReplace=str_replace("[IMDATE" . $id_kon . "#4" . "] " ,"",$namaReplace);
	            $namaReplace=str_replace("[IMDATE" . $id_kon . "#5" . "] " ,"",$namaReplace);


	            $strTablebalik=$strTablebalik. "    <tr $styletambahan>
	                                                <td class='hidden-xs'><a href='panel.php?module=projectDetail&id=$TaskList[object_id]' target=_blank><strong>$alluserArray[$idassigment] </strong>: $namaReplace</a></td>
	                                                
	                                                
	                                                <td class='hidden-xs'>Start: $taskStart | due : $taskEnd</td>
	                                                
	                                            </tr>";

			}								
			$strTablebalik=$strTablebalik. "</tbody></table>" ;

			 echo $strTablebalik .  "<script>generatedTable(21)</script>";
		}

	}

	function DrawingTask( $Users, $user_id, $alluserArray, $Activity, $salting, $obj,$drawing,$tipegambbararr){

		$act = $_POST['act'];
		if (isset($act) && !empty($act))
		{
			}
	  else
		{
			$stringCommand = $_POST['stringCommand'];
			$pieces = explode("#", $stringCommand);
			$act = $pieces[0];
			$id_kon = $pieces[6];
		}


		if ($act=="RefresDrawingTask") {
			$id_kon= $pieces[1];
			$tipe = $pieces[2];
			$refrestTask= true ;
			# code...
			//echo "sapi";
		}elseif ($act=="AddTaskDrawing") {

			$id_kon = $pieces[2];
			$asigmentto = $pieces[1];
			$duedate = date("Y-m-d",strtotime($pieces[3]));
			$id_subgambar = $pieces[4];
			$pesan = $pieces[5];

			$revisi = $pieces[8];
			$no_gam = $pieces[7];
			$id_gambar = $pieces[6];
			$tipe = $pieces[9];

			$drawingRes = $drawing->get_proj_gambar_id($id_gambar);
			foreach($drawingRes as $dr)
			{
				$title = $dr['judul'];
			}

			$CompilasiTitle=  "[DT" . $id_kon . "#] Drawing Review Cycle "  . date('Y-m-d').": ". $title;
			$starttask=date('Y-m-d');
           	$listsubcriber = "," . $user_id;

	        if ($user_id != $asigmentto) {
	            $listsubcriber = $listsubcriber . "," . $asigmentto;
	        }

			$pesan .= " <br>Please review this drawing :<br>
			1. <a href=./panel.php?module=listrevision&amp;id=$id_kon&mod=2&draw=$id_gambar'>$title [$no_gam] REV : $revisi  </a><br>

			Regards.	<br><br>"."<a href='#' class='btn btn-blue btn-xs' onclick='requestdownload($id_gambar, $id_kon, &#34;$no_gam&#34;)'>Request Download</a>";




			if ($obj->isDbCorelationTasktExist($id_subgambar)==false) {

				$idTask= $obj->addTaskobj(5, $CompilasiTitle, $user_id, $id_kon, 0, $pesan, $duedate, $starttask, $asigmentto, $listsubcriber);
				//$idTask = $obj->lastInsertId();
				//add task
				$obj->InsertDbCorelationTask( $id_subgambar, $idTask, $starttask, $duedate, $user_id );
			}else{//update

				$getlistdatas= $obj->GetdbcoralationTask($id_subgambar);
				foreach ($getlistdatas as $getlistdata) {
					$iddbcorelation=$getlistdata['id'];
					$idDbObject=$getlistdata['task_objectid'];
				}

				$obj->UpdateDbCorelationTask($starttask, $duedate,$user_id,$iddbcorelation);
				$obj->UpdateTaskProject($pesan, $duedate,$starttask,$asigmentto, $user_id , $idDbObject,$listsubcriber,$correlation);

				//update subscriber

			}

			//addtable corelation

			$refrestTask= true ;
		}elseif($act == 'refreshtaskuser'){

			$id_kon = $pieces[1];
			$tablenumber= $pieces[2];

            $resultaTaskuser=$obj->GetObjectTaskundoneByUser($id_kon,$user_id);

            //nilai balik
            $strTAsk= "<table class='table table-striped table-bordered table-hover' id='sample_" . $tablenumber ."'>
			            <thead>
			            <tr>
			            <th>Drawing</th>
			            <th>rev</th>
			            <th>due</th>
			            </tr>
			            </thead>
			            <tbody>";
            $n=1;
            foreach ($resultaTaskuser as $listRule) {

	            		 if(!is_null($listRule['start_date'])){


								$taskStart   = date("M d , Y", strtotime($listRule['start_date']));
					            $taskEnd     = date("M d , Y", strtotime($listRule['due_date']));
					            
					            if ($listRule['percent_completed'] == 100) {
					                $styletambahan = "style='opacity: 0.25; text-decoration: line-through;'";
					                $taskEnd       = Getbadge($taskEnd, 1);
																$datetime1 = date_create($listRule['start_date']); 
							$datetime2 = date_create($listRule['due_date']); 
									  
							$interval = date_diff($datetime1, $datetime2); 
							$interval= $interval->format('%a'); 
					            } else {
					                
					                $styletambahan = "";
					                $taskEnd       = Getbadge($taskEnd, 0);
							$interval	   = "-" ;
					            }
						}else{
							$taskStart ="" ;
							$taskEnd ="" ;
							$interval	   = "-" ;					
						}


	            $strTAsk=$strTAsk. "<tr >
					            <td ><a href='enginerrview.php?module=re&kon=" . $id_kon . "&gam=$listRule[id]' target=_blank>$listRule[no_gambar]</a></td>
					            <td >$listRule[revisi]</td>
					            <td >Start: $taskStart | due : $taskEnd</td>                             
					            </tr>";

	            $n++;
            }                           

            $strTAsk=$strTAsk. "</tbody></table><script> generatedTable($tablenumber);</script>";
            echo $strTAsk ;
            die;

		}


		//nilai balik 

		if ($refrestTask== true) {


			$listupload=$obj->getDrawingTask($id_kon,$tipe);


								$strlistgambar = "<table class='table table-striped table-bordered table-hover' id='sample_24'>
													<thead>
														<tr>
														<th></th>
															<th width='200'>Drawing Number </th>
															<th>Title </th>
															<th>Rev</th>
															<th>Submited</th>
															<th>Tipe</th>
															<th>Assign to</th>
															<th>by </th>
															<th class='hidden-xs' width='300px'>Target</th>
															<th>%</th>
															<th title='First day counted'>Days</th>
															<th title='Working days'>W. Days</th>
															<th title='Eng. finish' >W. Days</th>
															<th title='Spv. finish' >W. Days</th>
															<th>Action</th>
															
																									
														</tr>
													</thead>
													<tbody>";
					$no = 1;

					//print_r($listupload);
					foreach($listupload as $get_draw)
						{



						if(!is_null($get_draw['start_date'])){


								$taskStart   = date("M d , Y", strtotime($get_draw['start_date']));
					            $taskEnd     = date("M d , Y", strtotime($get_draw['due_date']));
					            
					            if ($get_draw['percent_completed'] == 100) {
					                $styletambahan = "style='opacity: 0.25; text-decoration: line-through;'";
					                $taskEnd       = Getbadge($taskEnd, 1);
																$datetime1 = date_create($get_draw['start_date']); 
							$datetime2 = date_create($get_draw['reviewdate']); 
									  
							$interval = date_diff($datetime1, $datetime2); 
							$interval= $interval->format('%a') +1 ; 
							$holidays=array("");
							$interval2= getWorkingDays(date("Y-m-d",strtotime($get_draw['start_date'])),date("Y-m-d",strtotime($get_draw['reviewdate'])),$holidays);
							$interval3= getWorkingDays(date("Y-m-d",strtotime($get_draw['start_date'])),date("Y-m-d",strtotime($get_draw['dt_enguploadstamp'])),$holidays);
							$interval4= getWorkingDays(date("Y-m-d",strtotime($get_draw['dt_enguploadstamp'])),date("Y-m-d",strtotime($get_draw['reviewdate'])),$holidays);

							$titleUploaddate=date("l,  M d , Y", strtotime($get_draw['dt_enguploadstamp']));
							$titlereview=date("l,  M d , Y", strtotime($get_draw['reviewdate']));



					            } else {
					                
					                $styletambahan = "";
					                $taskEnd       = Getbadge($taskEnd, 0);
							$interval	   = "-" ;
							$interval2	   = "-" ;
							$interval3	   = "-" ;
							$interval4	   = "-" ;

							$titleUploaddate="";
							$titlereview="";
					            }
						}else{
							$taskStart ="" ;
							$taskEnd ="" ;
							$interval	   = "-" ;
							$interval2	   = "-" ;
							$interval3	   = "-" ;
							$interval4	   = "-" ;

							$titleUploaddate="";
							$titlereview="";

						}


						$strlistgambar = $strlistgambar . "<tr >

													<td>$no</td>
													<td > <a href='enginerrview.php?module=re&kon=" . $id_kon . "&gam=$get_draw[id]' target=_blank>" . $get_draw['no_gambar'] . " </a></td>
													<td >" . $get_draw['judul'] . " </a></td>
													<td >" . $get_draw['revisi'] . " </a></td>
													<td>" . $get_draw['tanggal'] . "</td>

													<td>" . $tipegambbararr[$get_draw['tipe']] . "</td>
													
													<td><a href='./panel.php?module=projectDetail&id=$get_draw[task_objectid]' target=_blank >".  $alluserArray[$get_draw['assigned_to_contact_id']] . "</a></td>

													<td> ".  $alluserArray[$get_draw['assigned_by_id']] ."</td>
													<td class='hidden-xs' width='300px'>Start: $taskStart | due : $taskEnd</td>
													<td>$get_draw[percent_completed]</td>
													<td>$interval</td>
													<td>$interval2</td>
													<td title='$titleUploaddate'>$interval3</td>
													<td title='$titlereview'>$interval4</td>

													<td><a href='#responsiveAsigmentTask' data-toggle='modal' onclick='setIdsubIdgambara($get_draw[id],$get_draw[id_project_gamb],&#34;$get_draw[no_gambar]&#34;,&#34;$get_draw[revisi]&#34;);' > Set </a></td>
						
													</tr>";
						$no++;
						}

					$strCount=$obj->CountDrawingTaskManagement($id_kon);


					$matkomCount=$obj->GetcountMatkom($id_kon);

					$pieces = explode("#", $strCount);



					$strlistgambar = $strlistgambar . "</tbody></table>

					<script> generatedTable(24);

					document.getElementById('documentsubmitedcount').innerHTML = '$pieces[0]';
					document.getElementById('countacompolishtask').innerHTML = '$pieces[1]';
					document.getElementById('latetaskkkk').innerHTML = '$pieces[3]';
					document.getElementById('documentsubmitedcountTask').innerHTML = '$pieces[2]';
					document.getElementById('countamatkom').innerHTML = '$matkomCount[masterlist]/$matkomCount[certificated]';

					

					</script>";
					echo $strlistgambar;
		
					
		}




	}

	function dashboardPerformanceEng( $Users, $user_id, $alluserArray, $Activity, $salting, $obj,$drawing,$tipegambbararr){

		$act = $_POST['act'];
		if (isset($act) && !empty($act))
		{
			}
	  else
		{
			$stringCommand = $_POST['stringCommand'];
			$pieces = explode("#", $stringCommand);
			$act = $pieces[0];
			$id_kon = $pieces[1];
		}

		//Drawing Charts
		$drawing = $obj->GetSDashboardDrawing($id_kon);
		$drawingProperty = $drawing['propertygambar'];
		$drawingType = $drawing['tipegambar'];
		$drawingRev = $drawing['reviewed'];
		$jumlahDrawingmasuk=$drawingRev['reviewed'] + $drawingRev['not yet'] + $drawingRev['no need review'] ;
		$drawingRevs = $drawing['revisi'];
		$drawingTotalBar = $drawing['bargambar']['drawing'];
		$drawingStampBar = $drawing['bargambar']['stamp'];
		$dataProp = pieDataPrepare(array("Document Property", "Quantity"), $drawingProperty, "pie-drwprop", 3);
		$dataType = pieDataPrepare(array("Drawing Type", "Quantity"), $drawingType, "pie-drwtype", 3);
		$dataRev = pieDataPrepare(array("Drawing Review", "Quantity"), $drawingRev, "pie-drwrev", 3);
		$dataRevs = pieDataPrepare(array("Drawing Review", "Quantity"), $drawingRevs, "pie-drwrevs", 3);
		$dataBar = barDataPrepare(array("Month", "Drawing Input", "Reviewed"), "bar-drwrev", $drawingTotalBar, $drawingStampBar);

		//Commenting Charts
		$comment = $obj->GetSDashboardComment($id_kon);
		$commentType = $comment['tipecomment'];
		$y = $comment['tipecomment'];
		
		$jmlah= $y['structure'] + $y['electrical'] + $y['machinery']+ $y['stability']+ $y['statutori']+ $y['matkom']+ $y['multi'] + $y['survey'] ;
		$commentStat = $comment['statuscoment'];
		$commentNoresp = $comment['norespon'];
		$commentRelBar = $comment['barcomentcreate']['create'];
		$commentCloseBar = $comment['barcomentcreate']['closed'];
		$dataComType = pieDataPrepare(array("Comment Type", "Quantity"), $commentType, "pie-cmntype", 4);
		$dataComStat = pieDataPrepare(array("Comment Status", "Quantity"), $commentStat, "pie-cmnstat", 4);
		$dataComNoresp = pieDataPrepare(array("No Response", "Quantity"), $commentNoresp, "pie-cmnnores", 4);
		$dataComBar = barDataPrepare(array("Month", "Issued", "Closed"), "bar-cmnclose", $commentRelBar, $commentCloseBar);

		//Survey Charts
		$survey = $obj->GetSDashboardSurvey($id_kon);
		$surveyType = $survey['tipesurvey'];
		$surveyRegBar = $survey['barsurvey']['regular'];
		$surveyPatBar = $survey['barsurvey']['patrol'];
		$surveyComBar = $survey['barsurvey']['comment'];
		$dataSvyType = pieDataPrepare(array("Survey Type","Quantity"), $surveyType, "pie-svytype", 6);
		$dataSvyBar = barDataPrepare(array("Month", "Regular", "Patrol", "Comment"), "bar-svy", $surveyRegBar, $surveyPatBar, $surveyComBar);

		echo "
			<script>
				google.charts.load('current', {'packages':['corechart','gauge']});
				google.charts.load('current', { 
								   'packages': ['map'],
								   'mapsApiKey' : 'AIzaSyDnoPoA8hKYM6a99vWXozos-4PCHcA0qwU'
								   });
			</script>

			<h4>Drawing</h4>
			<h4>Total Document : $jumlahDrawingmasuk </h4>
			<hr>
			<div class='row'>
				$dataProp[container]
				$dataType[container]
				$dataRev[container]
				$dataRevs[container]
			</div>
			<div class='row'>
				$dataBar[container]
			</div>

			<h4>Commenting</h4>
			<h4>Total Comment : $jmlah </h4>
			<hr>
			<div class='row'>
				$dataComType[container]
				$dataComStat[container]
				$dataComNoresp[container]
			</div>
			<div class='row'>
				$dataComBar[container]
			</div>

			<h4>Survey</h4>
			<hr>
			<div class='row'>
				$dataSvyType[container]
			</div>
			<div class='row'>
				$dataSvyBar[container]
			</div>
			<script>
				google.charts.setOnLoadCallback(drawPie($dataProp[data], '$dataProp[id]', 'Document Property'))
				google.charts.setOnLoadCallback(drawPie($dataType[data], '$dataType[id]', 'Drawing Type'))
				google.charts.setOnLoadCallback(drawPie($dataRev[data], '$dataRev[id]', 'Drawing Review'))
				google.charts.setOnLoadCallback(drawPie($dataRevs[data], '$dataRevs[id]', 'Drawing Revision'))
				google.charts.setOnLoadCallback(drawBar($dataBar[data], '$dataBar[id]', 'Drawing Review by Month', 2, 'Qty', 'Month'))

				google.charts.setOnLoadCallback(drawPie($dataComType[data], '$dataComType[id]', 'Comment Type'))
				google.charts.setOnLoadCallback(drawPie($dataComStat[data], '$dataComStat[id]', 'Comment Status'))
				google.charts.setOnLoadCallback(drawPie($dataComNoresp[data], '$dataComNoresp[id]', 'No Response'))
				google.charts.setOnLoadCallback(drawBar($dataComBar[data], '$dataComBar[id]', 'Comment Closure by Month', 2, 'Qty', 'Month'))

				google.charts.setOnLoadCallback(drawPie($dataSvyType[data], '$dataSvyType[id]', 'Survey Type'))
				google.charts.setOnLoadCallback(drawBar($dataSvyBar[data], '$dataSvyBar[id]', 'Survey by Month', 3, 'Qty', 'Month'))
			</script>
		";
	}

	function individualPerformance($obj, $user_id, $Users)
	{
		$command = explode("#", $_POST['stringCommand']);
		$idProj = $command[0];
		$idUser = $command[1];

		$userStat = $obj->GetDashboardperson($idProj, $idUser);

		$rev = $userStat["performance"]["reviewed"];
		$op = $userStat["performance"]["opencoment"];
		$cre = $userStat["performance"]["createcomment"];
		$late = $userStat["performance"]["latetask"];
		$task = $userStat["performance"]["drawingtask"];

		$dataBarReview = $userStat["barcomment"]["review"];
		$dataBarComment = $userStat["barcomment"]["comment"];
		$dataBarOpen = $userStat["barcomment"]["opencomment"];
		$dataBarAssign = $userStat["barcomment"]["assign"];

		$dataPerson = barDataPrepare(array("Month", "Assigned", "Reviewed", "Comment", "Open Comment"), "bar-person", $dataBarAssign, $dataBarReview, $dataBarComment, $dataBarOpen);

		echo "
				<div class='row'>
					$dataPerson[container]
				</div>
				<script>
					google.charts.setOnLoadCallback(drawBar($dataPerson[data], '$dataPerson[id]', 'Drawing and Task by Month', 4, 'Qty', 'Month'))

					document.getElementById('indicator-task').innerHTML = $task
					document.getElementById('indicator-review').innerHTML = $rev
					document.getElementById('indicator-create').innerHTML = $cre
					document.getElementById('indicator-open').innerHTML = $op
					document.getElementById('indicator-late').innerHTML = $late
				</script>
			";

	}

	function ManUser ($Users){
        //baca asal input 
        $act=$_POST['act'];
        $nup=$_POST['nup'];
        //echo $nup;
        $phone=$_POST["hp"];
        

        if ($act=="add"){
            
            $pass=$_POST["pass"];
            $addpass = hash('sha512', $pass.$garam);
            $addgaram = hash('sha512',uniqid(mt_rand(1, mt_getrandmax()), true));
            
            //tambahan eka 1804
            
            //echo $pass;
            //echo "<br>";
            //echo $addpass;

            $UserNUP=$Users->get_users_nupHak($nup);

            //cek existensi NUP di tbl_user
            if (!empty($UserNUP)){
                $code = "NUP exist";
                $message = "NUP already exist...";
                $response=array("code"=>$code,"message"=>$message);
                echo json_encode($response);
            }
            else{
            //cek existensi NUP di database IT
                $arr = array ("nup"=>$nup, "usage"=>"wormhole", "paper"=>"information fought edge identity", "module"=>"registrasi");
                $str = json_encode ( $arr );
                $var = array("packet"=>$str);
                $output=$Users->httpPost("ds.bki.co.id:7777/ds/android/tunnel.php",$var);
                $gnt = json_decode($output, TRUE);
                    $nama =$gnt['name'] ;
                    $jabatan =$gnt['position'] ;
                    $email = $gnt['email'];

		            $divisi = 0;
		            $status = 1;

		            $Users->ogs_Insert($nup, $nama, $email, $phone, $phone2, $addpass, $addgaram, $jabatan, $status,$divisi);
		            $userid = $Users->lastInsertId();
      				$Users->insertBio($userid);
            }
            

        }
        elseif($act=="refresh"){  //nothing to do berarti langsung ke nilai balik
            
        }
        
        elseif($act=="activate"){
            $Users->userActivate($nup);
        }
        
        elseif($act=="edit"){
            
            $newemail=$_POST["nemail"];
            $newphone=$_POST["nhp"];
            
            //echo $newphone ; //(buat ngecek masuk datanya apa ndak
            
            $Users->editUser($newphone, $newemail, $nup);
            
        }
        
        elseif($act=="delete"){
            $Users->deleteUser($nup);
        }
        
        elseif($act=="lock"){
            $status=$_POST['status'];
            if ($status==0){
                $Users->lockUserbynup($nup);
            }
            elseif($status==2){
                $Users->unlockUserbynup($nup);
            }
        }
        
        elseif($act=="resetpass"){
            $npass=$_POST["npass"];
            
            //tambahan 2404
            $garam= hash('sha512',uniqid(mt_rand(1, mt_getrandmax()), true));
            
            $resetpass = hash('sha512', $npass.$garam);
            
            //reset password dari web 
            
            //echo $garam;
            $Users->Update_passwordsbyNup($resetpass, $garam, $nup);
                    
        }
        elseif($act=="changeprevil"){

			$posisi=$_POST['posisi'];
			$id=$_POST['id'];

			$Users->Setprevilage($id,$posisi);
		}
        
        //nilai balik : menampilkan tabel dalam web untuk tabel U List User
        $listUsers=$Users->get_users();
        $previljabatan= array('','assisten','Admin', 'manager' ,'Surveyor','Senior Manager', 'Kadiv');
        echo "
            <table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
                <thead>
                    <tr>
                        <th > No</th>
                        <th > Name</th>
                        <th > divisi</th>
                        <th > NUP</th>
                        <th > HP</th>
                        <th > Email </th>
                        <th > Registration Date </th>
                        <th > previl </th>
                        <th > Status</th>
                        <th > Action</th

                    </tr>
                </thead>
                <tbody>"; 
                
                
                $n=1;
                foreach($listUsers as $users ){
                    $nup= $users ['id_pegawai']; // $nup yang dimasukkan adalah nup pada database jadi penulisan nup sama dengan di database
                    $statusn= $users ['noactive'];
                        if ($statusn==1) {
                            $status= 'Not Active';
                        }
                        elseif ($statusn==0) {
                            $status= 'Active';
                        }
                        
                        if ($users ['locked']==1) {
                            $status= 'Locked';
                            $statusn=2 ;
                        }
                        
                    $name= $users ['nama'];
                    $phone= $users ['tlp'];
                    $email= $users ['email'];
                    $id_user = $users['id_user'];
                                                
                            
                    echo " <tr>
                            <td>$n</td>
                            <td>$users[nama]</td>
                            <td>$users[divisi]</td>
                            <td>$users[id_pegawai]</td>
                            <td>$users[tlp]</td>
                            <td>$users[email]</td>
                            <td>$users[dibuat]</td>
                            <td>". $previljabatan[$users['previl']] . "</td>
                            <td>$status</td>

                            
                            <td >
                            <div class='btn-group'>
                                <button type='button' class='btn btn-purple'>
                                    <i class='fa fa-wrench'></i>
                                    Setting
                                </button>
                                <button data-toggle='dropdown' class='btn btn-purple dropdown-toggle'>
                                    <span class='caret'></span>
                                </button>
                                
                                <ul class='dropdown-menu' role='menu'>
                                    <li>
                                        <a href='#' onclick='WebActivateUser(&#39;user&#39;, $nup);'>
                                            <i class='fa fa-user'></i>
                                            Activate
                                        </a>
                                    </li>
                                    <li>
                                        <a href='#responsive' data-toggle='modal' onclick='WebShowEditUser(&#39;user&#39;, $nup, &#39;$name&#39;, &#39;$phone&#39;, &#39;$email&#39; );'>
                                            <i class='fa fa-pencil'></i>
                                            Edit
                                        </a>
                                    </li>
                                    <li>
                                        <a href='#' onclick='WebDeleteUser(&#39;user&#39;, $nup);'>
                                            <i class='fa fa-trash-o'></i>
                                            Delete
                                        </a>
                                    </li>
                                    <li>
                                        <a href='#' onclick='WebLockUser(&#39;user&#39;, $statusn, $nup);'>
                                            <i class='fa fa-unlock'></i>
                                            Lock/Unlock
                                        </a>
                                    </li>
                                     <li>
                                        <a href='#' onclick='setpreviluser(&#39;user&#39;, &#39;admin&#39;, $id_user);'>
                                            <i class='fa fa-share'></i>
                                            set Admin
                                        </a>
                                    </li>
                                     <li>
                                        <a href='#' onclick='setpreviluser(&#39;user&#39;, &#39;manager&#39;, $id_user);'>
                                            <i class='fa fa-share'></i>
                                            set Manager
                                        </a>
                                    </li>                                    
                                     <li>
                                        <a href='#' onclick='setpreviluser(&#39;user&#39;, &#39;surveyor&#39;, $id_user);'>
                                            <i class='fa fa-share'></i>
                                            set Surveyor
                                        </a>
                                    </li>


                                     <li>
                                        <a href='#' onclick='setpreviluser(&#39;user&#39;, &#39;SM&#39;, $id_user);'>
                                            <i class='fa fa-share'></i>
                                            set SM
                                        </a>
                                    </li>
                                      <li>
                                        <a href='#' onclick='setpreviluser(&#39;user&#39;, &#39;kadiv&#39;, $id_user);'>
                                            <i class='fa fa-share'></i>
                                            set KADIV
                                        </a>
                                    </li>
                                                                       
                                     <li>
                                        <a href='#' onclick='setspecialuser(&#39;iSeefresh&#39;, 1, $id_user);'>
                                            <i class='fa fa-share'></i>
                                            set Kadiv PRB
                                        </a>
                                    </li>


                                     <li>
                                        <a href='#' onclick='setspecialuser(&#39;iSeefresh&#39;, 1, $id_user);'>
                                            <i class='fa fa-share'></i>
                                            set Kadiv PRB
                                        </a>
                                    </li>
                                     <li>
                                        <a href='#' onclick='setspecialuser(&#39;iSeefresh&#39;, 2, $id_user);'>
                                            <i class='fa fa-share'></i>
                                             set Kadiv Survey
                                        </a>
                                    </li>
                                     <li>
                                        <a href='#' onclick='setspecialuser(&#39;iSeefresh&#39;, 3, $id_user);'>
                                            <i class='fa fa-share'></i>
                                             set Kemenko
                                        </a>
                                    </li>
                                    <li class='divider'></li>
                                    <li>
                                        <a href='#reset' data-toggle='modal' onclick='WebShowResetUser(&#39;user&#39;, $nup, &#39;$name&#39;);'>
                                            <i class='i'></i>
                                            Reset Password
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            
                        
                            </td>
                            
                        </tr>
                        <script>
            jQuery(document).ready(function() {

                generatedTable(1);
        
                        $('.date-picker').datepicker({
            autoclose: true
        });



                
            });
        </script>   
                        ";
                    
                    $n++;
                    }
    }

    function SpecialUser($Users,$alluserArray) {
		$act=$_POST['act'];

		
		if ($act=="deletesession"){
			$id=$_POST['id'];
			$Users->delete_ogs_struc($id);			
		}
		
		elseif($act=="refreshS"){
			
		}elseif($act=="add"){
			$id=$_POST['id'];
			$jabatan=$_POST['statusn'];
			$Users->ogs_strucInsert($id, $jabatan);

		}
		
		
		//nilai balik ........ generatedtable untuk menampilkan tombol search
		$listSessions=$Users->Getogs_struc();
		echo "
			<table class='table table-condensed table-hover' id='sample_3'>
				<thead>
					<tr>

						<th>User</th>
						<th>Jabatan</th>
						<th>Join on</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
				
				
		<script>
			jQuery(document).ready(function() {

				generatedTable(3);
		
				        $('.date-picker').datepicker({
            autoclose: true
        });
	});
		</script>
				
				";
				
			
			
			foreach($listSessions as $sessionlis){
			$sessionid=$sessionlis['id'];
			$namuser=$alluserArray[$sessionlis['id_user']];

			$tanggalJoin= FormatTanggaljam($sessionlis['createat']);

			if ($sessionlis['jabatan']==1){
				$jabatan="Kadiv PRB";
			}elseif ($sessionlis['jabatan']==2) {
				$jabatan="Kadiv Survey";
			}elseif ($sessionlis['jabatan']==3) {
				$jabatan="Kadiv Kemenko";
			}

			echo "<tr>

						<td>$namuser</td>
						<td> $jabatan</td>
						<td>$tanggalJoin</td>
						<td>
						<div class='btn-group'>
							<button type='button' class='btn btn-xs btn-bricky' onclick='WebDeleteSessionUser(&#39;iSeefresh&#39;, $sessionid);'>
								<i class='fa fa-trash-o'></i>
								Delete
							</button>
						</div>
						</td>
					</tr>
					";
			
			}
		}
				

function commentingsister($comment, $Users, $user_id, $alluserArray, $Activity, $simb_gam, $drawing, $obj, $statu_s, $C_client)
	{
	$stringCommand = $_POST['stringCommand'];
	//echo $stringCommand ;
	$pieces = explode("#", $stringCommand);
	$act = $pieces[0];
	if ($act == "refresh")
		{
		$nocontract = $pieces[1];
		$proj_id= $obj->getProjectIdbyNocontract($nocontract);
		$projectname=$obj->getprojectNameid($proj_id);
		}else{

		}
	

	// nilai balik

	$get_comments = $comment->get_db_comment($proj_id);
	$zz = $Users->get_users();
	foreach($zz as $z)
		{
		$x = $z['id_user'];
		$userx[$x] = $z['nama'];
		}

	echo "<h3>$projectname</h3> <br> <table class='table table-striped table-bordered table-hover' id='sample_27'>
									<thead>
										<tr>
											<th width='30'>No</th>
											<th width='100'>No Comment</th>
											<th >Comment </th>
											<th >Drawing</th>
											<th width='100'>Create by</th>
											<th width='50'>Date</th>
											<th width='50'>Position</th>
											<th width='50'>Status</th>
																						
										</tr>
									</thead>
									<tbody>";
	$no = 1;
	$pointDescr = array(
		'Initial',
		'Rejected',
		'Waiting',
		'Moderated'
	);
	foreach($get_comments as $get_comment)
		{
		$d = $get_comment['create_by'];
		$tang = date("Y-m-d", strtotime($get_comment['tanggal']));
		$perantar = $get_comment['id'] . ",'" . $get_comment['nomer_comment'] . "'";
		$peranta = $get_comment['id'] . ",'" . $get_comment['id_kontrak'] . "'";
		$perant = $get_comment['id'] . ",'" . $get_comment['id_kontrak'] . "',2";
		$strreply = '';
		if (is_null($get_comment['oleh']))
			{
			$strreply = "Not";
			}
		  else
			{
			$strreply = getInitials($get_comment['oleh']);
			}

		$jmlGambars = explode(",", $get_comment['gambar']);
		$jmlgambar = count($jmlGambars) . ' gambar';
		if ($get_comment['importan'] == 0)
			{
			$strImportan = '';
			}
		  else
			{
			$strImportan = 'checked';
			}

		echo "<tr class='odd gradeX'>
									<td >$no</td>
									
									<td title='$get_comment[gamb_infoRef]'> " . $get_comment['nomer_comment'] . " <div class='bintang'><input type='checkbox'  readonly $strImportan/><label for='st1'> </label></div></td>
									<td width='50%'>" . $get_comment['comment'] . "</td>
									<td title='$jmlgambar'>" . $get_comment['gambar'] . "</td>
									<td>" . $userx[$d] . "</td>
									<td>" . $tang . "</td>
									<td><strong>" . $pointDescr[$get_comment['point']] . "</strong></td>
									<td><strong>" . $statu_s[$get_comment['status']] . "</strong></td>
																		
									</tr>";
		$no++;
		}

	echo "</tbody>
										<tfoot>
										<tr>
											<th width='30'>No</th>
											<th width='100'>No Comment</th>
											<th >Comment </th>
											<th >Drawing</th>
											<th width='100'>Create by</th>
											<th width='50'>Date</th>
											<th width='50'>Position</th>
											<th width='50'>Status</th>
																						
										</tr>
									</tfoot>
									</table><script> generatedTable(27);</script><hr>";
	}

	function supervisorApprove($alluserArray, $kontrak, $obj, $drawing, $user_id, $comment)
	{
		$str = $_POST['stringCommand'];
		$pieces = explode("#", $str);
		$idStamp = $pieces[0];
		$projId = $pieces[1];
		$commentIds = json_decode($pieces[2], TRUE);
		$newName = $pieces[3];
		$C_client = new client();

		//----------------------moderating all comment----------------------
		$desc = "<p>Comments have been issued</p>
				 <p>Comment:</p>
			     <p><ul>";
		foreach($commentIds as $id_coment)
		{
			$current_date = Date("Y-m-d\ H:i:s\ ");
			$semb = $comment->get_db_comment_id($id_coment);
			foreach($semb as $sem)
			{
				$open_c = $sem['status'];
				$repl = substr($sem['comment'], 0, 100);
				$nomercomm = $sem['nomer_comment'];
				$point = $sem['point'];
				$commContent = $sem['comment'];
			}

			if($point != 1)
			{
				$commentRelation = $comment->get_gambar_idcom($id_coment, $projId);
				$relatedDrawing = "";
				foreach($commentRelation as $commr)
				{
					$relatedDrawing = $relatedDrawing."$commr[no_gambar] - $commr[judul]<br>";
				}

				$desc = $desc."
								<li>
									<a href='panel.php?module=comment&projid=$projId&com=$id_coment' target='_blank'>[$nomercomm]</a><br>
									Applicable for:<br>
									$relatedDrawing<br>
									<i>$commContent</i>
								</li>
								";
				if ($point != 3)
				{
					$comment->update_db_comment_stat(3, $open_c, $id_coment);
					$comment->review_db_comment($user_id, $current_date, $id_coment);
					$C_client = new client();
					$C_client->insertLogSyncClient(1, $projId, 'New Publish Comment ' . $nomercomm);
					
					$comment->insert_comment_log('Merubah posisi Comment : <span class=error > ' . $repl . '</span> -..  ke posisi ' . 3, $id_coment, $projId, $current_date, $user_id);
					$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Moderation Comment", $user_id, "edit", 0, 0, $str."--".$nomercomm);
				}
			}else
			{
				echo "<script>alert('Rejected comment exists. Document review cannot be done.');</script>";
				die;
			}
		}

		//notification riz1212
		
			$item = "Design comment has been issued";
			$desc = $desc."</ul></p>";
			$link = "collective";

			$result = $C_client->notificationProcess($projId, $item, $desc, $link, "comment", $kontrak, $obj);
			echo $result;

			/*$C_client->insertNotification($projId, $item, $desc, $link, "approval");

			$users = $kontrak->getClientOfProject($projId);

			$res = $C_client->setNotifEmail($users, "(drawing number: $drawing_numberss)", $projId, "approval");


			if(!empty($res['address']))
			{
				$result = $obj->emailHandler("no-reply-zee@bki.co.id","Bahtera Zee", array(), $res['body'], "Zee Notification", $res['address']);
			}

			echo "<br>".$result;

			if($result == "Message sent!")
			{
				$C_client->setStatus($users, $projId, "mail", $res['notif'], "approval");
			}*/
		

		//---------------------moderating stamped doc-----------------
		$drawing->UpdateUploadStamp($user_id, 1, $idStamp);
		$gambardetails = $drawing->get_UploadStampByid($idStamp, $projId); //get drawing detail
		foreach($gambardetails as $gambardetail)
		{
			$drawing_numberss = $gambardetail['nodrawing'];
			$idDrawing = $gambardetail['id_gambar'];
		}
		$drawing->updateStampPath($newName, $idStamp);

		$drawingInfo = $drawing->get_proj_gambar_id($idDrawing);
		foreach($drawingInfo as $drw)
		{
			$type = $drw['tipe'];
			$title = $drw['judul'];
		}

		// insertlogsAplikasi

		$obj->WriteLogAplicationLogs($user_id, $projId, "Moderation stamp", $user_id, "edit", 0, 0, $str."--".$drawing_numberss);
		$C_client = new client();
		$C_client->insertLogSyncClient(2, $projId, 'New Drawing Review ' . $drawing_numberss);

		//notification riz1212
		$item = "Plan Approval $drawing_numberss $title";
		$desc = "<p>Review of drawing number $drawing_numberss $title has been issued</p>";
		$link = "panel.php?module=project&projid=$projId&drw=1";

		if(strlen($item) > 30)
		{
			$item = substr($item, 0, 30)."...";
		}

		$result = $C_client->notificationProcess($projId, $item, $desc, $link, "approval", $kontrak, $obj);
		echo $result;

		/*$C_client->insertNotification($projId, $item, $desc, $link, "approval");

		$users = $kontrak->getClientOfProject($projId);

		$res = $C_client->setNotifEmail($users, "(drawing number: $drawing_numberss $title)", $projId, "approval");


		if(!empty($res['address']))
		{
			$result = $obj->emailHandler("no-reply-zee@bki.co.id","Bahtera Zee", array(), $res['body'], "Zee Notification", $res['address']);
		}

		echo "<br>".$result;

		if($result == "Message sent!")
		{
			$C_client->setStatus($users, $projId, "mail", $res['notif'], "approval");
		}*/

		//--------------Mail number------------------
		$name = $alluserArray[$user_id];
		if($name = "")
		{
			$name = "Supervisor";
		}

		$con = $obj->get_wokspaceByid($projId);
		foreach($con as $c)
		{
			$connum = $c['id_kontrak'];
		}

		$date = date("Y-m-d");
		$letter = $kontrak->getMailNumber($projId, $date, $type);
		
		if(!$letter['exists'])
		{
			$params = array(
							"kepada"=>$connum,
							"nup_entry"=>$user_id,
							"nama_entry"=>$name
							);
			$url = "http://api.bki.co.id:82/api-zee/create_no_surat.php";
			$res = json_decode($obj->httpPost($url, $params), true);
			$num = $res[0]['no_surat'];

			$kontrak->insertMailNumber($projId, $num, $type);
		}else
		{
			
		}

		$stamp = $drawing->getUploadStampArray($idDrawing,$projId);
		$drawing->UpdateTaskkprojectUSer($stamp['id_gambar'],$stamp['rev'],100,$user_id);
		echo "<p>Moderation has been done</p><script>window.location.reload();</script>";
	}

	function rejectFromSM($comment, $Users, $user_id, $alluserArray, $Activity, $drawing, $obj, $statu_s, $C_client)
	{
		$stringCommand = $_POST['stringCommand'];
		$pieces = explode("#", $stringCommand);

		$id_coment = $pieces[0];
		$code = $pieces[1];
		$subgam = $pieces[2];
		$current_date = Date("Y-m-d\ H:i:s\ ");
		$id_kon = $code;
		$semb = $comment->get_db_comment_id($id_coment);
		foreach($semb as $sem)
		{
			$open_c = $sem['status'];
			$repl = substr($sem['comment'], 0, 100);
			$nomercomm = $sem['nomer_comment'];
		}

		$comment->update_db_comment_stat(1, $open_c, $id_coment);

		$comment->insert_comment_log('Merubah posisi Comment : <span class=error > ' . $repl . '</span> -..  ke posisi ' . $nilai, $id_coment, $id_kon, $current_date, $user_id);
		$obj->WriteLogAplicationLogs($user_id, $pieces[1], "Moderation Comment", $user_id, "Moderation Comment", 0, 0, $stringCommand);
			

		// nilaibalik

		$comment_currents= $comment->Get_allCommentfromIdsubdrawing($subgam, $id_kon);	//get comment

		$tableHeader =  "<table class='table table-striped table-bordered table-hover' id='sample_6'>
											<thead>
												<tr>
													<th width='100'>No Comment</th>
													<th >Comment </th>
													<th width='100'>Create by</th>
													<th width='50'>Date</th>
													<th width='50'>Position</th>
													<th width='100'>Action</th>											
												</tr>
											</thead>
											<tbody>";
			$no = 1;
			$pointDescr = array(
				'Initial',
				'Rejected',
				'Waiting',
				'Moderated'
			);

			$strTypecomment= array('Dealt with', 'Accepted', 'Resubmited', 'Note', 'Recomendation');
			$no=0 ;
			$strCurrentinitial = $tableHeader;
			$idCommentArray = array();
			$reject = 0;
			foreach($comment_currents as $get_comment)
			{
				$no++;
				$d = $get_comment['create_by'];
				$tang = date("Y-m-d", strtotime($get_comment['tanggal']));
				if ($get_comment['importan'] == 0)
				{
					$strImportan = '';
				}
			 	else
				{
					$strImportan = 'checked';
				}

				
				if($get_comment['point'] == 1)
				{
					$reject = 1;
				}else
				{
					array_push($idCommentArray, $get_comment['id_comment']);
				}
				
				$commentType = $strTypecomment[$get_comment['commentcategory']];

				$strCurrentinitial= $strCurrentinitial .  "<tr class='odd gradeX'>
											<td title='$commentType'> <a target=_blank href='panel.php?module=replaycom&id=" . $proj_id . "&com=$get_comment[id] '>" . $get_comment['nomer_comment'] . " <div class='bintang'><input type='checkbox'  readonly $strImportan/><label for='st1'> </label></div></a></td>
											<td width='50%'><a target=_blank href='panel.php?module=replaycom&id=" . $proj_id . "&com=$get_comment[id] '>" . $get_comment['comment'] . " </a></td>
											
											<td>" . $alluserArray[$d] . "</td>
											<td>" . $tang . "</td>
											<td><strong>" . $pointDescr[$get_comment['point']] . "</strong></td>
											<td><a href='#'  onclick='rejectOnSMPage($get_comment[id], $id_kon, $subgam);'> Reject</a></td>
																					
											</tr>";
					
			}

			$modComment = json_encode($idCommentArray);
			$strtablecurrentcomment= $strCurrentinitial . "</tbody>
														</table>
														<script> generatedTable(6);</script>
														<input id='mod-comment' type='hidden' value=$modComment>
														<input id='mod-reject' type='hidden' value=$reject>
														<hr>";

			echo $strtablecurrentcomment;
	}				


	function approvalletter($drawing)
	{
		$types = $drawing->get_tipe_gambar();
		$drawingType = array();
		foreach($types as $ty)
		{
			if($ty['id'] != 15)
			{
				$drawingType[$ty['id']] = $ty['nama'];
			}
		}

		$pieces = explode("#", $_POST['stringCommand']);
		$act = $pieces[0];
		$idProj = $pieces[1];

		$strListMail = "<table class='table table-striped table-bordered table-hover' id='sample_mail'>
							<thead>
								<tr>
									<th>No</th>
									<th>Mail Number</th>
									<th>Type</th>
									<th>Date</th>					
								</tr>
							</thead>
							<tbody>";

		$mails = $drawing->getMailByProjectId($idProj);
		$n = 1;
		foreach($mails as $m)
		{
			if(is_null($m['mail_number_full']))
			{
				$mailNum = "mail number";
			}else
			{
				$mailNum = $m['mail_number_full'];
			}
			$strListMail = $strListMail . "<tr >
								<td >$n</td>
								<td ><a href='#' onClick='openMail($m[id])'>$mailNum</td>
								<td >" . $drawingType[$m['type']] . " </td>
								<td >" . $m['created_at'] . "</td>
							</tr>";
			$n++;
		}
		$strListMail = $strListMail . "</tbody></table><script> generatedTable('mail');</script>";
		echo $strListMail;
	}

	function taskSurvey($Users, $user_id, $Activity, $obj)
	{
		$stringCommand = $_POST['stringCommand'];
		$pieces = explode("#", $stringCommand);

		$act = $pieces[0];
		$projectId = $pieces[1];

		if($act == "view")
		{

		}else if($act == "add")
		{

			$itpnum = $pieces[2];
			$item = $pieces[3];
			$due = date("Y-m-d",strtotime($pieces[4]));
			$desc = $pieces[5]; 
			$start = "0000-00-00 00:00:00";

			$CompilasiTitle=  "[SV$projectId#] ITP num - $itpnum : $item";
           	
			$surveyor = $Users->getUserFromProject(19, $projectId);
			$subscriber = implode(",", $surveyor);

			$idTask= $obj->addTaskobj(5, $CompilasiTitle, $user_id, $projectId, 0, $desc, $due, $start, $user_id, $subscriber);
			$obj->insertCorrelationSurvey($idTask, $projectId);
		}

		$items = $obj->getSurveyTaskbyIdproject($projectId);
		$strItemTab = "<table class='table table-striped table-bordered table-hover' id='sample_svy'>
							<thead>
								<tr>
									<th>No</th>
									<th>Item</th>
									<th>Start</th>
									<th>Due</th>					
								</tr>
							</thead>
							<tbody>";

		$n = 1;
		foreach($items as $dat)
		{
			$strItemTab = $strItemTab. "
							<tr>
								<td>$n</td>
								<td><a href='panel.php?module=projectDetail&id=$dat[object_id]' target='_blank'>$dat[name]</a></td>
								<td>$dat[start_date]</td>
								<td>$dat[due_date]</td>
							</tr>
			";
			$n++;
		}

		$strItemTab = $strItemTab."
							</tbody>
						</table>
						<script>
							generatedTable('svy');
						</script>
		";

		echo $strItemTab;

	}

?>

<?php
include("../sis32/db_connect.php");
include "../functions.php";
//get var from post
sec_session_start();

include "../class/init2.php";


 
 
$code= $_GET['cek_po'];
$id_mom= $_GET['mom'];
$broadcast= $_GET['broadcast'];


$data_rapats= $rms->get_minute_meeting_id($code,$id_mom);

foreach ($data_rapats as $data_rapat) {

$judul_agenda= $data_rapat['agenda'];
$tanggal= $data_rapat['tanggal'];
$tempat= $data_rapat['tempat'];
$hasil_rapat= $data_rapat['hasil_rapat']  	;
$waktu= $data_rapat['waktu'];
$projectType= $data_rapat['project'];
$externalEmail=$data_rapat['externalEmail'];
$fileLampiran=$data_rapat['file'];
}


if ($broadcast=="yes"){

	$scriptPrint="<script> alert('This notulent has been sent to All member'); </script>";

}elseif ($broadcast=="view") {
	$scriptPrint="";
}else {
	
		$scriptPrint="<script> window.print(); </script>";

	
}


 $rmsss=$rms->get_cek_log2($code,$id_mom);
 
 $jml_rmsss=$rms->get_cek_log2_jml($code,$id_mom);

if ($load_deskr = $mysqli->prepare("SELECT  rm_cekpoint.id_cek, rm_cekpoint.rules, rm_cekpoint.tahun, rm_cekpoint.duedate , rm_ruleslist.Rules,  rm_cekpoint.user,rm_cekpoint.sekertaris, rm_cekpoint.preparation, rm_cekpoint.teamup, rm_cekpoint.ref, rm_cekpoint.wg, rm_cekpoint.konsenering, rm_cekpoint.cetak, rm_cekpoint.karakter, rm_cekpoint.adminis, rm_cekpoint.komite, rm_cekpoint.scope, rm_cekpoint.master, rm_cekpoint.publikasi , rm_cekpoint.close FROM rm_cekpoint JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules   where id_cek = ? LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('s', $code ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					   $load_deskr->store_result();
					   $load_deskr->bind_result($cekpoint, $id_rules , $tahun, $duedate , $rules , $user, $sekertaris, $preparation,$teamup,$ref,$wg,$konsenering,$cetak,$karakter,$adminis,$komite,$scope,$master,$publikasi, $close );
					   $load_deskr->fetch();
					   
		}	


if ($projectType==0){
	$titleRapat="NOTULENSI
	  RAPAT WORKING GRUP PEMBUATAN  ".   $rules . '     ' . $tahun  	;
}else {
	$nameRelated= $obj->get_wokspaceByid($code);
	foreach($nameRelated as $namedsd){
		$nameRela=$namedsd['project'];
		$user=$namedsd['lead'];
	}	
	$titleRapat="Notulensi
	  RAPAT<br> ".$nameRela 		;	
	
}
/*$nama_ketu= $Users->get_users_id($user);

foreach ($nama_ketu as $nama_ket) {

$nama= $nama_ket['nama'];

}*/

$nama=  $Users->get_users_with_title($user);
					   
/*

database ketua
*/


function TanggalIndo($date,$jenis){
$namahari = array("Minggu","Senin","Selasa","Rabu","Kamis","Jum'at","Sabtu"); 

$day = date('w', strtotime($date));

    $BulanIndo = array("Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
 
    $tahun = substr($date, 0, 4);
    $bulan = substr($date, 5, 2);
    $tgl   = substr($date, 8, 2);
 if ($jenis== 1){
    $result = $namahari[$day] . ", " . $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;     
}else{
   $result =  $tgl . " " . $BulanIndo[(int)$bulan-1] . " ". $tahun;     
}   
    return($result);
}


?>

<?php
$head = "<html>

<head>
<title>RMS | Rules Management System | Notulen rapat  ".  TanggalIndo($tanggal,1)  . "</title>
<meta http-equiv=Content-Type content='text/html; charset=windows-1252'>
<meta name=Generator content='Microsoft Word 14 (filtered)'>
<style>
<!--
 /* Font Definitions */
 @font-face
	{font-family:Wingdings;
	panose-1:5 0 0 0 0 0 0 0 0 0;}
@font-face
	{font-family:'MS Mincho';
	panose-1:2 2 6 9 4 2 5 8 3 4;}
@font-face
	{font-family:'MS Mincho';
	panose-1:2 2 6 9 4 2 5 8 3 4;}
@font-face
	{font-family:Calibri;
	panose-1:2 15 5 2 2 2 4 3 2 4;}
@font-face
	{font-family:Tahoma;
	panose-1:2 11 6 4 3 5 4 4 2 4;}
@font-face
	{font-family:'\@MS Mincho';
	panose-1:2 2 6 9 4 2 5 8 3 4;}
 /* Style Definitions */
 p.MsoNormal, li.MsoNormal, div.MsoNormal
	{margin:0cm;
	margin-bottom:.0001pt;
	text-align:justify;
	text-indent:36.0pt;
	line-height:150%;
	font-size:11.0pt;
	font-family:'Calibri','sans-serif';}
p.MsoCommentText, li.MsoCommentText, div.MsoCommentText
	{mso-style-link:'Comment Text Char';
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:justify;
	text-indent:36.0pt;
	line-height:150%;
	font-size:10.0pt;
	font-family:'Calibri','sans-serif';}
p.MsoAcetate, li.MsoAcetate, div.MsoAcetate
	{mso-style-link:'Balloon Text Char';
	margin:0cm;
	margin-bottom:.0001pt;
	text-align:justify;
	text-indent:36.0pt;
	font-size:8.0pt;
	font-family:'Tahoma','sans-serif';}
p.MsoListParagraph, li.MsoListParagraph, div.MsoListParagraph
	{margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:36.0pt;
	margin-bottom:.0001pt;
	text-align:justify;
	text-indent:36.0pt;
	line-height:150%;
	font-size:11.0pt;
	font-family:'Calibri','sans-serif';}
p.MsoListParagraphCxSpFirst, li.MsoListParagraphCxSpFirst, div.MsoListParagraphCxSpFirst
	{margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:36.0pt;
	margin-bottom:.0001pt;
	text-align:justify;
	text-indent:36.0pt;
	line-height:150%;
	font-size:11.0pt;
	font-family:'Calibri','sans-serif';}
p.MsoListParagraphCxSpMiddle, li.MsoListParagraphCxSpMiddle, div.MsoListParagraphCxSpMiddle
	{margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:36.0pt;
	margin-bottom:.0001pt;
	text-align:justify;
	text-indent:36.0pt;
	line-height:150%;
	font-size:11.0pt;
	font-family:'Calibri','sans-serif';}
p.MsoListParagraphCxSpLast, li.MsoListParagraphCxSpLast, div.MsoListParagraphCxSpLast
	{margin-top:0cm;
	margin-right:0cm;
	margin-bottom:0cm;
	margin-left:36.0pt;
	margin-bottom:.0001pt;
	text-align:justify;
	text-indent:36.0pt;
	line-height:150%;
	font-size:11.0pt;
	font-family:'Calibri','sans-serif';}
span.BalloonTextChar
	{mso-style-name:'Balloon Text Char';
	mso-style-link:'Balloon Text';
	font-family:'Tahoma','sans-serif';}
span.CommentTextChar
	{mso-style-name:'Comment Text Char';
	mso-style-link:'Comment Text';}
.MsoChpDefault
	{font-size:10.0pt;
	font-family:'Calibri','sans-serif';}
@page WordSection1
	{size:21.0cm 841.95pt;
	margin:72.0pt 2.0cm 2.0cm 72.0pt;}
div.WordSection1
	{page:WordSection1;}
 /* List Definitions */
 ol
	{margin-bottom:0cm;}
ul
	{margin-bottom:0cm;}
-->
</style>

</head>

<body lang=EN-US>".
$scriptPrint ."

<div class=WordSection1>

<table class=MsoNormalTable border=1 cellspacing=0 cellpadding=0
 style='border-collapse:collapse;border:none'>
 <tr style='height:77.5pt'>
  <td width=65 style='width:48.55pt;border:solid black 1.0pt;border-right:solid white 1.0pt;
  padding:0cm 5.4pt 0cm 5.4pt;height:77.5pt'><img src='../img/image001.jpg' width='60' height='93'></td>
  <td width=572 style='width:428.9pt;border:solid black 1.0pt;border-left:none;
  padding:0cm 5.4pt 0cm 5.4pt;height:77.5pt'>
  <p class=MsoNormal align=center style='text-align:center;text-indent:0cm;
  line-height:115%'><b><span style='font-size:19.0pt;line-height:115%'>". $titleRapat . "</span></b></p>  </td>
 </tr>
 <tr style='height:48.8pt'>
  <td width=637 colspan=2 valign=top style='width:477.45pt;border:solid black 1.0pt;
  border-top:none;padding:0cm 5.4pt 0cm 5.4pt;height:48.8pt'>
  <p class=MsoNormal style='margin-top:6.0pt;text-indent:0cm;line-height:115%'>Tempat                 
  <span style='font-size:12.0pt;line-height:115%;margin-left:38.0pt;'> :" .  $tempat . "</span></p>
  <p class=MsoNormal style='text-indent:0cm;line-height:115%'>Hari, Tanggal      
   <span style='font-size:12.0pt;line-height:115%;margin-left:15.0pt;'> :" .  TanggalIndo($tanggal,1) . "</span></p>
  <p class=MsoNormal style='margin-bottom:6.0pt;text-indent:0cm;line-height:
  115%'>Waktu  <span style='font-size:12.0pt;line-height:115%;margin-left:43.0pt;'> :" .  $waktu . "</span></p>  </td>
 </tr>
 <tr>
  <td width=637 colspan=2 valign=top style='width:477.45pt;border:solid black 1.0pt;
  border-top:none;padding:0cm 5.4pt 0cm 5.4pt'>
  <p class=MsoNormal style='margin-top:6.0pt;text-indent:0cm;line-height:115%'><span
  style='font-size:19.0pt;line-height:115%'>Agenda Rapat:</span></p>
  <p class=MsoNormal style='margin-left:14.2pt;text-indent:0cm;line-height:
  115%'>&nbsp;</p>
  <p class=MsoNormal style='margin-left:14.2pt;text-indent:0cm;line-height:
  115%'><span style='font-size:12.0pt;line-height:115%'> " .  $judul_agenda . " </span></p>
  <p class=MsoNormal style='margin-top:6.0pt;text-indent:0cm'><span 
  
  ";
  
?>  
  
<?php  

if ($projectType==0){

  if  ($jml_rmsss > 0 ) { $head= $head . "
  
  style='font-size:18.0pt;line-height:150%'>list Amandemen:</span></p>
  <table width='643' border='1'>
    <tr>
      <th width='46' scope='col'>Sec</th>
      <th width='197' scope='col'>Origin</th>
      <th width='186' scope='col'>Change</th>
      <th width='164' scope='col'>Argument</th>
      </tr>" ; 
	 
	  $nilai_tab="</table>";
	  }else { $nilai_tab=" "; }
	
}else {

 $nilai_tab=" ";	
	
}
	
	  foreach ($rmsss as $rmss) {

						 $tableee= $tableee .  "
									<td >". $rmss['section'] . "-" . $rmss['sub_section'] . "</td>
									<td title='Section : ". $rmss['section'] . " , sub :  ". $rmss['sub_section'] ."'>". $rmss['origin'] ."</td>
									<td title='object : $objek'> " . $rmss['changes']. "</td>
									<td >". $rmss['argument'] ."</td>

									</tr>";
	
		
		
							}
	  
	  
	  $body=  $head . $tableee . $nilai_tab ;
	  

  

   
  
 $foot=" 
  <p class=MsoNormal style='margin-top:6.0pt;text-indent:0cm'><span style='font-size:18.0pt;line-height:150%'>Hasil Rapat:</span></p>
  <span style='font-size:12.0pt'> " .  $hasil_rapat ." </p>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:12.0pt;
  line-height:115%'>&nbsp;</span></p>
  <p class=MsoNormal style='line-height:115%'><span style='font-size:12.0pt;
  line-height:115%'>&nbsp;</span></p>
  <p class=MsoNormal style='text-indent:35.45pt;line-height:normal;margin-left:342.0pt;text-indent:-62.55pt;'><span
  style='font-size:12.0pt'>                                                                                                         
  Jakarta,  " .  TanggalIndo($tanggal,0) . "</span></p>
  <p class=MsoNormal style='line-height:normal;margin-left:342.0pt;text-indent:-62.55pt;'><span style='font-size:12.0pt'>                                                                                                   
                                                      Ketua Tim </span></p>
  <p class=MsoNormal style='line-height:normal'><span style='font-size:12.0pt'>&nbsp;</span></p>
  <p class=MsoNormal style='line-height:normal'><b><span style='font-size:12.0pt'>&nbsp;</span></b></p>
  <p class=MsoNormal style='line-height:normal'><b><span style='font-size:12.0pt'>&nbsp;</span></b></p>
  <p class=MsoNormal style='margin-left:342.0pt;text-indent:-62.55pt;
  line-height:90%'><b><span style='font-size:12.0pt;line-height:90%'>                      </span></b><b><u><span
  style='text-transform:uppercase'> " .  $nama . "</span></u></b></p>
  <p class=MsoNormal style='margin-left:261.0pt;text-indent:-62.55pt;
  line-height:90%'><b><u><span style='text-decoration:none'>&nbsp;</span></u></b></p>  </td>
 </tr>
</table>

<p class=MsoNormal align=left style='text-align:left;text-indent:0cm;
line-height:normal'>&nbsp;</p>

</div>

</body>

</html>";

echo $body . $foot ;


if ($broadcast=="yes"){

	$message=$body . $foot ;
	$formEmail = "z2ex@bki.co.id" ;
	$subject="Notulen rapat  ".   $rules . '     ' . $tahun . "   " .  TanggalIndo($tanggal,1) ;

if ($projectType==0){	
	$toemailbyiduser= $rms->get_AllteamRms($code);
}else {
	$toemailbyiduser= $obj->getTeamMember($code);
}		

if (is_null($fileLampiran)){
	$fileLampiran='';
}
	$obj->sendEmail($formEmail,$toemailbyiduser,$message,$subject,$externalEmail,$fileLampiran);	

}



	  ?>
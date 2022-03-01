<?php
include("../sis32/db_connect.php");
include "../functions.php";
include "../class/init3.php";
include "../modern.php" ;
date_default_timezone_set('Asia/Jakarta');
$C_client = new client();
$tanggal=date("Y-m-d H:i:s"); 
//$serverLink="https://10.0.1.219:8000/c_ogs/" ;
$serverLink="https://armada.bki.co.id/Zee-client/" ;
$arrayalogsync_s=array("","New drawing ","New rev. drawing ","New reply Com. " );
$strNewDrawing='';
$strNewRevision='';
$strNewComment='';
$strNewUploadStamp='';
$kondisiUpdate=0; //prevention double notification
//synk gamnbar upload
$listgambaruploadtemp=$C_client->get_proj_gambar_tempsynk();
	foreach($listgambaruploadtemp as $isi){
		if($C_client->PindahFile($isi['Almat'])){
			$strNewDrawing='New Drawing, ';
			$kondisiUpdate=1;
			$drawing->insert_data_gambar($isi[kontrak_id],$isi[judul], $isi[tipe], $isi[tanggal] ,"../" . $isi[Almat],$isi[no_gamb],$isi[client_id],$isi[rev]);//insert data
			$thelast = $drawing->lastInsertId();
			$drawing->insert_data_sub_gambar($thelast,$isi[kontrak_id],$isi[tanggal], $isi[rev] , "../" .  $isi[Almat]); //insert revisi
			$C_client->Delete_proj_gambar_temp($isi['id']);	//del didatabase client
			$textc = "<strong>done</strong> " . $isi[judul] ;
			$drawing->insert_logSynch(1,$isi[kontrak_id], $textc, $tanggal) ;

		}else{
			$textc = "<strong>FAIL</strong> " . $isi[judul] ;
			$drawing->insert_logSynch(1,$isi[kontrak_id], $textc, $tanggal) ;//writereport
		}
	}
	
	
//synk revisi upload
$listGambarRevisi=$C_client->get_subproj_gambar_tempsynk();
	foreach ($listGambarRevisi as $iso){
		if($C_client->PindahFile($iso['alamat'])){
			$strNewRevision='New Revision Drawing, ';
			$kondisiUpdate=1;
			$drawing->insert_data_sub_gambar($iso[id_project_gamb],$iso[id_kontrak],$iso[tanggal], $iso[revisi] , "../" .  $iso[alamat]); //insert revisi
			//update revisi
			$drawing->updateGambarRev($iso[id_project_gamb], $iso[revisi] );

			$C_client->Delete_id_revisi_drawsynk($iso['id']);//del didatabase client
			$textc = "<strong>Done update draw. rev. </strong> " . $iso[judul] ;
			$drawing->insert_logSynch(2,$iso[id_kontrak], $textc, $tanggal) ;
		}else{
			$textc = "<strong>FAIL update draw. rev. </strong> " . $iso[judul] ;
			$drawing->insert_logSynch(2,$iso[id_kontrak], $textc, $tanggal) ;//writereport
		}	
		
	}

//synk balasan commnet & attachment
$listReplayComment=$C_client->get_replay(); 
	foreach($listReplayComment as $iss){
		if ($iss['file']=="none"){ //jika ga da file
			$linkAttachment="";
		}else{
			$linkAttachment="<br><a href='$serverLink" . $iss['file'] . "' target='_blank'>Attachment</a> ";	
		}
			$comment->insert_subreplay_comment($iss[id_comment], $iss[replay] . $linkAttachment ,$iss[tanggal] , "owner", $iss[post_by],$iss[id_kont] );
			$C_client->delet_replay_id($iss['id']);//del didatabase client
			//update Log Commnet
			$comment->insert_comment_log('Synch. balasan komen baru : <span class=error > '. $iss[replay] . '</span> -.. dari ' . $iss[oleh] , $iss[id_comment], $iss[id_kont], $tanggal ,1);

			//revisi sysn balasan comment
			$detailComments=$comment->get_comment_id($iss[id_comment],$iss[id_kont]);

			foreach ($detailComments as $detailComment) {
				$id_namacomment=$detailComment['nomer_comment'];
			}
			//end revisi sysn balasan comment

			$textc = "<strong>done Sync com. ID </strong> " . $id_namacomment ;
			$drawing->insert_logSynch(3,$iss[id_kont], $textc, $tanggal) ;
			$strNewComment='New Comment ';
			$kondisiUpdate=1;
		//report
	}

//Sync drawing stamp need to be moderation
	// $status_uploadStamp =$drawing->get_CountUploadStampbyNotYetapproved();
	// if($status_uploadStamp==true){
	// 	$strNewUploadStamp=' ' ;
	// 	$kondisiUpdate=1;
	// }



if ($kondisiUpdate==1) {

		//create Notif	
		//$tanggal="2018-10-10 07:30:10"; //buat test sync
		$listIdProjects=$drawing->getSynkKontrak($tanggal);
		//print_r($listIdProjects);
		foreach ($listIdProjects as $listIdProject ) {
			$listUpdateDrawings=$drawing->getListSynkKontrak($tanggal,$listIdProject['id_kon']);
			$n=0;

			//echo "error2" ;
			$listDrawingSysnk="";
			foreach ($listUpdateDrawings as $listUpdateDrawing) {
				$listDrawingSysnk= $listDrawingSysnk . "<br>" . $arrayalogsync_s[$listUpdateDrawing[activity]] . "=> " . $listUpdateDrawing['textc'] . "</br>";
				$n++;
			}

			//sysnc upload stamp
			//kelemahan akan selalu nuggu data sync comment atau gambar dari client baru ter eksekusi per kontraknya dia
			//if($status_uploadStamp==true){
				
				//get Tipe Gambar
				$tipe_gambars=$drawing->get_tipe_gambar();
				$tipegambbararr=array();
				foreach ($tipe_gambars as $tipe_gambar) {
					if ($tipegambbararr[id] != 15) {
							$id= $tipe_gambar['id'];
							$tipegambbararr[$id]=$tipe_gambar[nama];
					}
				}

				$lisdrawingsTamps=$drawing->get_UploadStampbyNotYetapproved($listIdProject['id_kon'],$user="all");
					foreach ($lisdrawingsTamps as $lisdrawingsTamp) {
						$Strtipegamb=$tipegambbararr[$lisdrawingsTamp[tipe]] ;
						$listDrawingSysnk= $listDrawingSysnk . "<br>Upload Stamp"  . "=> " . $lisdrawingsTamp['gambar'] . " need moderation [ $Strtipegamb ]</br>";

						$n++;
						}	

			//}

			//sync comment need moderation 
			//kelemahan akan selalu nuggu data sync comment atau gambar dari client baru ter eksekusi per kontraknya dia
			$listStrtCommentmoderation= $comment->get_db_comment_moderation($listIdProject['id_kon']);

					foreach ($listStrtCommentmoderation as $listStrtCommentmoderatio) {
						
						$listDrawingSysnk= $listDrawingSysnk . "<br>New Comment"  . "=> " . $listStrtCommentmoderatio['nomer_comment'] . " need moderation </br>";

						$n++;
						}

			//sync and generate notification for technical query
			$listTechQuery = $C_client->getTechnicalQueryUnanswered($listIdProject['id_kon']);
			foreach($listTechQuery as $ltq)
			{
				$listDrawingSysnk = $listDrawingSysnk . "<br>Unanswered Technical Query=> ".$ltq['subject']."<br>";
				$n++;
			}				


			if ($n!=0) {//prevent send email bila tidak ada sinkronisasi
				//create notif
				$relatedss=$obj->get_wokspaceByid($listIdProject['id_kon']);	
				foreach($relatedss as $relateds ){
						$related=$relateds['project'];
						$listtemamembers=$relateds['team'];
						//echo "error5" ;	
				}

				if (substr($listtemamembers, 0, 1)==","){
					//echo $listtemamembers;
					$listtemamembers= substr($listtemamembers .",", 1,-1);
				}
					//echo $listtemamembers;
				$listtemamembers=$listtemamembers . ",36" ;
				//$listtemamembers=  "1,36" ;
				$ip_address = $_SERVER['REMOTE_ADDR'];
				$message = "<h2>Dear Team</h2>

						<span> 
						There are updates on the project you are involved in $related, please find the updates below.
						</span><p></p>

						$listDrawingSysnk

						<p>
						</p>

						<p>Regards</p>
						Zee System
						$ip_address <p></p>
						";
				//echo $message ;		
						//echo "error7" ;	
				$obj->SendNotifEmailforEnginner(0,$listtemamembers,$message,"Notif Sync. ". $strNewDrawing . $strNewRevision .$strNewComment . $strNewUploadStamp . ' [' . $related . ']');

			
			}
			

		}
	
}


//$drawing->Fixingdatabase();



	
?>
<style type="text/css">
			/* Customizable font and colors */
			html {
				background: #000000;
			}
			#clocktext {
				font-family: sans-serif;
				font-weight: bold;
				color: #FFFFFF;
			}
		</style>
		</style>
	<body style="display:table; width:100%; height:100%; margin:0; padding:0">
		<div style="display:table-cell; width:100%; height:100%; text-align:center; vertical-align:middle">
			<span id="clocktext" style="font-size:24pt; font-kerning:none"></span>
			<br>
			<span style="color:#FFFFFF">Last Synch : <?php echo $tanggal ?></span>
		</div>
		<script type="text/javascript">
			"use strict";
			
			var textElem = document.getElementById("clocktext");
			var textNode = document.createTextNode("");
			textElem.appendChild(textNode);
			var curFontSize = 24;  // Do not change
			
			function updateClock() {
				var d = new Date();
				var s = "";
				s += (10 > d.getHours  () ? "0" : "") + d.getHours  () + ":";
				s += (10 > d.getMinutes() ? "0" : "") + d.getMinutes() + ":";
				s += (10 > d.getSeconds() ? "0" : "") + d.getSeconds();
				textNode.data = s;
				synch(s);
				setTimeout(updateClock, 1000 );
			}
			
			function updateTextSize() {
				var targetWidth = 0.9;  // Proportion of full screen width
				for (var i = 0; 3 > i; i++) {  // Iterate for better better convergence
					var newFontSize = textElem.parentNode.offsetWidth * targetWidth / textElem.offsetWidth * curFontSize;
					textElem.style.fontSize = newFontSize.toFixed(3) + "pt";
					curFontSize = newFontSize;
				}
			}
			
			function synch(strclock){
				
				if ((strclock=="06:00:00")||(strclock=="09:00:00")||(strclock=="12:15:00")||(strclock=="14:00:00")||(strclock=="15:30:00")||(strclock=="17:00:00")||(strclock=="20:00:00")||(strclock=="23:00:00")) {
					location.reload(); 
				}
				
			} 
			
			updateClock();
			updateTextSize();
			window.addEventListener("resize", updateTextSize);
		</script>
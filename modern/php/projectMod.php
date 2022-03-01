<?php
$pagenum_id=1;
$Users->cekSecuritypeage($user_id,$pagenum_id);

echo set_java_script_plugin_load ("profile");
   			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
   			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
   			echo set_java_script_plugin_load ("button");
   			echo set_java_script_plugin_load ("table");
   			echo set_java_script_plugin_load ("getProjectdkk");
   			echo set_java_script_plugin_load ("summer");
   			echo set_java_script_plugin_load ("galery");
   			echo set_java_script_plugin_load ("calender"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
   			echo set_java_script_plugin_load ("idle");
            echo set_java_script_plugin_load ("export"); //export xls pdf table

            $projectID=$_GET['idproj'];	
            
   $salting = $Users->get_previl($_SESSION['user_id']);  // kalau dipkai iset bakal error securitynya isset adalah kondisi ada tidak variable

   
   //$C_client = new client();
   
   if (($obj->cekAnggotaExist($projectID,$user_id)==false) && ($salting < 6 )){
   	echo "<script>alert('yo have no authority'); window.history.back();</script>";
      die;
   }
   
   $statu_s=array("Open","Close","Info");
   $arrayalogsync_s=array("","New drawing ","New rev. drawing ","New reply Com. " );
   
   $nameRelated= $obj->get_wokspaceByid($projectID);
   
   $costdeliver=floatval($kontrak->sumCostPro($projectID,1));
   $Incomedeliver=floatval($kontrak->sumCostPro($projectID,2));
   $strJsonMap2= "['Cost',     $costdeliver]," . "['Income',     $Incomedeliver]";
   $sIncomedeliver= "Rp. " . number_format($Incomedeliver);
   $listcoss=$kontrak->getCostprojectTheyear($projectID,date("Y"));
   
   //treeview initialization
   $treeMenu = $shipData->getMenuAll();
   $childArray = array();
   foreach($treeMenu as $menu)
   {
   	$node = array("title"=>$menu['title'], "key"=>$menu['key_id'], "isFolder"=>true, "family"=>$menu['family'], "tooltip"=>$dat['title']);
   	array_push($childArray, $node);
   }
   $checklists = $shipData->getChecklist($projectID);
   
   if($checklists['row'] != 0)
   {
   	foreach($checklists['content'] as $checklist)
   	{
   		$tmpArr = explode("#", $checklist['checklist']);
   		if($tmpArr[0] != "---")
   		{
   			$children = array();
   			$childId = $checklist['parent'];
   			for($k=0; $k<count($tmpArr); $k++)
   			{
   				$menuChild = $shipData->getChildMenu('id', $tmpArr[$k], $childId);
   				foreach($menuChild as $dat)
   				{
   					$node = array("title"=>$dat['title'], "key"=>$dat['key_id'], "isFolder"=>false, "family"=>$dat['family'], "tooltip"=>$dat['title']);
   				}
   				array_push($children, $node);
   			}
   			$index = array_search($childId, array_column($childArray, 'key'));
   			$childArray[$index]['children'] = $children;
   		}
   	}
   }
   
   $childData = json_encode($childArray);
   
   //graf pencapain
   
   $mulai = $month = strtotime("01-01-" . date("Y"));
   $akhir = strtotime("31-12-" . date("Y") );
   $jumlahakumalasiBudget=0;
   while($month < $akhir)
   {
        //echo date('F Y', $month), PHP_EOL;
    $snamabulan= date('M y', $month);
    $jumlahCostPerbulan=0 ;
    $jumlahInvestPerbulan=0;
    $nextmonth=strtotime("+1 month", $month);
   	 //$nextmonth=strtotime("01" .  $nextmonth);
    
    foreach( $listcoss as  $listcost){
      
      
      if ((strtotime($listcost['realisation'])>= strtotime("01" . $snamabulan))&& (strtotime($listcost['realisation'])< strtotime("01" . date('M y',$nextmonth)) )) {
        
        if ($listcost['tipeKegiatan']==1){
           $jumlahCostPerbulan=$jumlahCostPerbulan + $listcost['total'];
        }else{
           $jumlahInvestPerbulan=$jumlahInvestPerbulan + $listcost['total'];
        }
     }
     
  }
  
  
  $sAcumulasi= $sAcumulasi . "['$snamabulan',  $jumlahCostPerbulan , $jumlahInvestPerbulan ,  ]," ; 
  
  $month = $nextmonth ;
}	

$listpermision= $kontrak->get_proj_teambyID($projectID,$user_id);

   if ($salting==9){ // special super admin.
   	$listpermision="1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30";

   }

//echo $listpermision ;
   
   $permisionPieace=explode(",",$listpermision);
   
   foreach($nameRelated as $namedsd){
   	$nameRela=$namedsd['project'];
   	$description = 	$namedsd['description'];
   	$leader=$namedsd['lead'];
   	$starting=$namedsd['starting']; 	 	
   	$due=$namedsd['due'];
   	$target=$namedsd['target'];
   	$purpose ="Rp. " . number_format($target) ;
      
   	$contract=$namedsd['id_kontrak'];
   	$vesell=$namedsd['vessel'];
   	$lokasi=$namedsd['lokasi'];
   	$builder=$namedsd['builder'];
   	$submited=$namedsd['submited'];
   	$class=$namedsd['class_id'];
   	$kontractlink=$namedsd['kontractlink'];
      $sistercontract=$namedsd['sister'];
      
   	//generaldataInput
      $classnot=$namedsd['notation'];
      $ofregnum=$namedsd['offregnum'];
      $portre=$namedsd['port'];
      $deliverydate=$namedsd['deliverydate'];
      $ibc=$namedsd['ibcigc'];
      $Ddwt=$namedsd['desaigndwt'];
      $depth=$namedsd['moldeddepth'];
      $callsign=$namedsd['callsign'];
      $datereg=$namedsd['datereg'];
      $solas=$namedsd['solas'];
      $ism=$namedsd['ism'];
      $lpp=$namedsd['lpp'];
      $bulb=$namedsd['blublengthfromfp'];
      $flag=$namedsd['flag'];
      $kellaying=$namedsd['keellaying'];
      $marpolkat=$namedsd['marpol'];
      $breadt=$namedsd['moldedbreadth'];
      $loadinginst=$namedsd['loadinginstr'];
      $trimbook=$namedsd['trimstabilitibook'];
      
      if ($loadinginst==1) {
       $strloading="<option value='$loadinginst' >Yes</option>";
    }
    else{
       $strloading="<option value='$loadinginst' >No</option>";
    }
    
    if ($trimbook==1) {
       $strtrimbook="<option value='$trimbook' >Yes</option>";
    }else{
       $strtrimbook="<option value='$trimbook' >No</option>";
    }
    
 }


 $arrSisters= explode(',', $sistercontract);
 foreach ($arrSisters as $arrSister) {
   $strCombosister=$strCombosister."<option value='$arrSister'>$arrSister</option>";
}





if ($target==0) {
  $target=1 ;
}

$percent= $Incomedeliver / $target * 100 ;

$listUsers=$Users->get_users();

$progressoverall=$obj->getProgresstaskbyProject($projectID);
$obj->updateProgressProject($projectID,$progressoverall);


$listtemamembers=$obj->getTeamMember($projectID);

if (substr($listtemamembers, -1, 1)==","){
  $listtemamembers= substr($listtemamembers, 0,-1);
}

$TeamMembers = explode(",", $listtemamembers);
$taskundone=$obj->gettaskbyProjectUndone($projectID,20);

//survey task
$svyOption="<option value=0>-- Select Survey Item --</option>";
$surveyTask = $obj->getSurveyTaskbyIdproject($projectID);
foreach($surveyTask as $st)
{
  $svyOption = $svyOption."<option value=$st[object_id]>$st[name]</option>";
}

   //calender

$listEventTasks=$obj->getProjectTaskbyIdproject($projectID);
foreach($listEventTasks as $listEventTask){
  
   	$y=date("Y",strtotime($listEventTask['due_date'])); // this month
   	$m=date("m",strtotime($listEventTask['due_date'])); // this month
   	$d=date("d",strtotime($listEventTask['due_date'])); // this month
   	$m=$m -1 ; //javascript bulan itu 0 - 11
   	
   	$nama=substr($listEventTask['nama'], 0, 6);
   	
   	if($listEventTask['percent_completed']==100){
        $labelWarna="label-green";
     }elseif(($listEventTask['percent_completed']!=100) and ($listEventTask['due_date']<  date("Y-m-d")) ){
        $labelWarna="label-orange";
     }else{
        $labelWarna="label-default";
     }
     $stringevent= $stringevent. "{
        title: '$nama : $listEventTask[name]',
        start: new Date($y, $m, $d),
        className: '$labelWarna'
     },";
     
  }
  
  $listEventTasks=$rms->GetMeetingMontCalender(date("Y-m-d"),$projectID);
  foreach($listEventTasks as $listEventTask){
     
   /* 	$y=date("Y",strtotime($listEventTask['tanggal'])); // this month
   	$m=date("m",strtotime($listEventTask['tanggal'])); // this month
   	$d=date("d",strtotime($listEventTask['tanggal'])); // this month */
   	
   	
   	$pieces=explode(" - ",$listEventTask['waktu']);
   	
   	$start=date("Y-m-d ", strtotime($listEventTask['tanggal'])) . $pieces[0] . ":00";
   	$end=date("Y-m-d ", strtotime($listEventTask['tanggal'])) . $pieces[1] . ":00";
   	
   	
   	$m=$m -1 ; //javascript bulan itu 0 - 11
   	if(($listEventTask['project']==0)&& ($listEventTask['cek_po']==0)) {
        $title="Meeting " .$listEventTask['agenda'] ;
        $title=substr($title,0,100) ;		
        $labelWarna="label-yellow";
     }elseif($listEventTask['project']==0){
        $title="Meeting " .$listEventTask['Rules'] ;
        $title=substr($title,0,100) ;		
        $labelWarna="label-green";		
     }else{
        $labelWarna="label-default";
        $title="Meeting " .$listEventTask['namproject'] ;
        $title=substr($title,0,100) ;	
     }
     $stringevent= $stringevent. "{
        allDay: '',
        title: '$title',
        start: '$start',
        className: '$labelWarna'
     },";
     
  }
  
  $stringevent= substr($stringevent, 0, -1);		
  
  
  $list_jabatan_projs=$kontrak->get_Position_proj();
  $listjabatanarr=array();
  $listjabatanar=array();
  $x=0;
  foreach($list_jabatan_projs as $list_jabatan_proj){
     $listjabatanarr[$x]=$list_jabatan_proj['nama'];
     $listjabatanar[$x]=$list_jabatan_proj['id'];
     $x++;	
  }
  
  
   //drawing
  
  $tipe_gambars=$drawing->get_tipe_gambar();
  $strOptionRadioButtontipegambar='';
   //$strOptionCombbotipegambar='';
  foreach ($tipe_gambars as $tipe_gambar) {
     if ($tipe_gambar['id'] != 15) {
        $strtipegmabr= $strtipegmabr .  "<option value='$tipe_gambar[id]'> $tipe_gambar[nama]</option>" ;
        $strOptionRadioButtontipegambar=$strOptionRadioButtontipegambar . "<label><input name='typeeditdraw' type='radio' value='$tipe_gambar[id]'>$tipe_gambar[nama] &nbsp;</option></label>";
     }
   	//$strOptionCombbotipegambar .="<option value='$tipe_gambar[id]'> $tipe_gambar[nama]</option>";
  }
  
  $EngginerFild_ew=$drawing->get_tipe_gambar_field();
  foreach ($EngginerFild_ew as $value => $nilai) {
     $strCombofieldDraw .= "<option value='$value'>$nilai</option>" ;
  }
  
  
   //comenting
  
  $proj_id=$projectID;
   		// get jabatan
  
  $jabatans=$Users->Get_team_by_id($user_id ,$proj_id);
  foreach ($jabatans as $jabatan ) {
    $jabatanx=$jabatan['proj_jabatan'];
 } 
   		//get kuasa 
 $kuasas=$Users->Get_kuasa_by_jabatn($jabatanx);
 foreach ($kuasas as $kuasa ) {
    $kuasax=$kuasa['kuasa_gambar'];
 } 
 $pizza  = $kuasax;
 
   			if ($salting == 9){ // overaide if super admin
               $pizza = "1,2,3,4,5,6,7" ;
            }
   //1,2,3,4
            
            $pieces = explode(",", $pizza);
            
   		//get gambar
            
            foreach ($pieces as $piece){
               
               $gamb=$drawing->get_tipe_gambar_id($piece);
               foreach ($gamb as $gam ) {
                $drawing_list= $drawing_list . "<option value='" . $gam['id'] . "'> " . $gam['nama']. "</option>"  ;
             }
             
          }
          
   //--> reporting
          
          $startings=date_create($starting);
          $dues=date_create($due);
          $diff=date_diff($startings,$dues);
          
          $jumlahDayReport= $diff->days;	
          for( $x= 1 ; $x <= $jumlahDayReport ; $x++ ) {
            $selectoptionDayliReport .= "<option value='$x'>Day $x </option>" ;
         } 
         
   //-> weekly
   $sisaSelisihweek_hari= $jumlahDayReport % 7 ; //selisih hari minggu 
   $jumlah_minggu= ($jumlahDayReport - $sisaSelisihweek_hari) / 7 ;
   
   if ($sisaSelisihweek_hari > 0 ){// berati ada minggu yang tidak complate 7 hari
   	$jumlah_minggu =$jumlah_minggu +1 ;
   }
   
   for( $x= 1 ; $x <= $jumlah_minggu ; $x++ ) {
      $selectoptionWeeklyReport .= "<option value='$x'>Week $x </option>" ;
   } 
   
   //-> Moonthly
   
   $sisaSelisihbulan_hari= $jumlahDayReport % 30 ; //selisih hari minggu 
   $jumlah_bulan= ($jumlahDayReport - $sisaSelisihbulan_hari) / 30 ;
   
   if ($sisaSelisihbulan_hari > 0 ){// berati ada bulan yang tidak complate 30 hari
   	$jumlah_bulan =$jumlah_bulan +1 ;
   }
   
   for( $x= 1 ; $x <= $jumlah_bulan ; $x++ ) {
      $selectoptionMonthlyReport .= "<option value='$x'>Month $x </option>" ;
   } 
   
   
   $listRules= $obj->GetRulesApplicable($proj_id);     
   
   $strlistrules= "<table class='table table-striped table-bordered table-hover' id='sample_16'>
   <thead>
   <tr>
   <th>No</th>
   <th>Technical Paper</th>
   </tr>
   </thead>
   <tbody>";
   $n=1;
   foreach ($listRules as $listRule) {
      
    
     $strlistrules=$strlistrules. "<tr >
     <td >$n</td>
     <td ><a href='#' onclick='window.open(	&#34;http://rnd.bki.co.id/rms/view_rule_telik.php?module=viewrules&id=$listRule[idpublicRules]&#34;); ' >". $listRule['rules_name'] . "</a></td>
     
     
     </tr>";
     
     $n++;
  }							
  
  $strlistrules=$strlistrules. "</tbody></table><script> generatedTable(16);</script>";
  ;
  
  $listTypeaaprovals= $drawing->GetTipeapprovalDrawing();					

  
      //importandate
  $importandDateArr= array("","kick-off","keel-laying","launching","seatrial","final");

  $strdateKickoff=date('m/d/Y',strtotime($obj->GetImportanDatebyIdkon_itemValue($projectID,$importandDateArr[1])));
  $strdatekeel_laying=date('m/d/Y',strtotime($obj->GetImportanDatebyIdkon_itemValue($projectID,$importandDateArr[2])));
  $strdatelaunching=date('m/d/Y',strtotime($obj->GetImportanDatebyIdkon_itemValue($projectID,$importandDateArr[3])));
  $strdateseatrial=date('m/d/Y',strtotime($obj->GetImportanDatebyIdkon_itemValue($projectID,$importandDateArr[4])));
  $strdatefinal=date('m/d/Y',strtotime($obj->GetImportanDatebyIdkon_itemValue($projectID,$importandDateArr[5])));
  
  $listImportandsDates = $obj->GetImportanDatebyIdkon($projectID);
  foreach ($listImportandsDates as $listImportandsDate) {

    $tanggal = date('d/M/Y',strtotime($listImportandsDate['tanggal']));
    $item =strtoupper($listImportandsDate['item']);

    $todays_date = date("Y-m-d");
    $today = strtotime($todays_date);

    $expiration_date = strtotime($listImportandsDate['tanggal']);
    
    if($expiration_date > $today) {
     $strStyle = "point";
  } else {
     $strStyle= "pointdone";
  }
  
  $strtimelines .= "      <li>
  <p class='diplome'>$item</p>
  <span class='$strStyle'></span>
  <p class='description'>
  $tanggal
  </p>
  </li>";

}


//get Project query

$resultsProjectQuerys= $obj->Getprojectquery($proj_id);

foreach ($resultsProjectQuerys as $resultsProjectQuery) {
   $vesselname=$resultsProjectQuery['vesselname'];
   $bkiid=$resultsProjectQuery['bkiid'];
   $bkidesaindid=$resultsProjectQuery['bkidesaindid'];
   $imo=$resultsProjectQuery['imo'];
   $operationstat=$resultsProjectQuery['operationstat'];
   $flag=$resultsProjectQuery['flag'];
   $port=$resultsProjectQuery['port'];
   $owner=$resultsProjectQuery['owner'];
   $manager=$resultsProjectQuery['manager'];
   $rulesset=$resultsProjectQuery['rulesset'];
   $ruleedision=$resultsProjectQuery['ruleedision'];
   $classnotation=$resultsProjectQuery['classnotation'];
   $type=$resultsProjectQuery['type'];
   $builder=$resultsProjectQuery['builder'];
   $hullyard=$resultsProjectQuery['hullyard'];
   $outfittingyard=$resultsProjectQuery['outfittingyard'];
   $keellaid=$resultsProjectQuery['keellaid'];
   $launchdate=$resultsProjectQuery['launchdate'];
   $dateofbuild=$resultsProjectQuery['dateofbuild'];
   $deliverydate=$resultsProjectQuery['deliverydate'];
   $loa=$resultsProjectQuery['loa'];
   $lbp=$resultsProjectQuery['lbp'];
   $lload=$resultsProjectQuery['lload'];
   $bext=$resultsProjectQuery['bext'];
   $b=$resultsProjectQuery['b'];
   $d=$resultsProjectQuery['d'];
   $draught=$resultsProjectQuery['draught'];
   $freeboard=$resultsProjectQuery['freeboard'];

}

$notationArr = explode(";", $classnotation);
if($notationArr[0] == "")
{
   $notationMenu = "<input id='latest-id' type='hidden' value=1>
   <div class='col-sm-2' id='sub-div-1'>
   <div class='input-group'>
   <input type='text' placeholder='Class notation' id='classnotation-1' class='form-control' name='notation-field' readonly>
   <span class='input-group-btn'>
   <button type='button' class='btn btn-bricky' onclick='deleteNotation(&#39;sub-div-1&#39;);'>
   <i class='fa fa-times fa fa-white'></i>
   </button>
   </span>
   </div>
   </div>";
}else
{
   $n = 1;
   $notationField = "";
   $empty = 0;
   foreach($notationArr as $dat)
   {
      if($dat == "")
      {
         $empty++;
      }
      $notationField = $notationField."<div class='col-sm-2' id='sub-div-$n'>
      <div class='input-group'>
      <input type='text' placeholder='Class notation' id='classnotation-1' class='form-control' name='notation-field' value='$dat' readonly>
      <span class='input-group-btn'>
      <button type='button' class='btn btn-bricky' onclick='deleteNotation(&#39;sub-div-$n&#39;);'>
      <i class='fa fa-times fa fa-white'></i>
      </button>
      </span>
      </div>
      </div>";
      $n++;
   }

   if($empty == 0)
   {
      $notationMenu = "<input id='latest-id' type='hidden' value=$n>".$notationField."<div class='col-sm-2' id='sub-div-$n'>
      <div class='input-group'>
      <input type='text' placeholder='Class notation' id='classnotation-1' class='form-control' name='notation-field' readonly>
      <span class='input-group-btn'>
      <button type='button' class='btn btn-bricky' onclick='deleteNotation(&#39;sub-div-$n&#39;);'>
      <i class='fa fa-times fa fa-white'></i>
      </button>
      </span>
      </div>
      </div>";      
   }else
   {
      $n--;
      $notationMenu = "<input id='latest-id' type='hidden' value=$n>".$notationField;
   }
}

$dates = $obj->GetImportanDatebyIdkon($proj_id);
foreach($dates as $dt)
{
   switch($dt['item'])
   {
      case "keel-laying":
      $keellaid=$dt['tanggal'];
      break;
      case "launching":
      $launchdate=$dt['tanggal'];
      break;
      case "seatrial":
      $dateofbuild=$dt['tanggal'];
      break;
      case "final":
      $deliverydate=$dt['tanggal'];
      break;

   }
}  


$obj->Updatelatetask($proj_id); 


?>
<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
   .bintang {
      position: relative;
      display: inline-block;
      border: none;
   }
   .bintang input {
      border: 0;
      width: 1px;
      height: 1px;
      overflow: hidden;
      clip: rect(1px 1px 1px 1px);
      clip: rect(1px, 1px, 1px, 1px);
      opacity: 0;
   }
   .bintang label {
      position: relative;
      float: right;
      color: #C8C8C8;
   }
   .bintang label:before {
      margin: 5px;
      content: "\f005";
      font-family: FontAwesome;
      display: inline-block;
      font-size: 1.5em;
      color: #ccc;
      -webkit-user-select: none;
      -moz-user-select: none;
      user-select: none;
   }
   .bintang input:checked ~ label:before {
      color: #FFC107;
   }
</style>
<script src="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="js/ogs.js" type="text/javascript"></script>
<script src="js/kontrak-po.js" type="text/javascript"></script>			
<script src="assets/plugins/dynatree/src/jquery.dynatree.js"></script>
<script src="js/drawMenu.js"></script>
<link rel="stylesheet" type="text/css" href="../css/taginput.css">
<link href="assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.css" rel="stylesheet"/>
<link rel="stylesheet" href="assets/plugins/dynatree/src/skin-vista/ui.dynatree.css">
<div class="page-header">
   <h1>Project <small><?php echo $nameRela . " [$contract]" ; ?></small></h1>
</div>
<!-- end: PAGE TITLE & BREADCRUMB -->
<!-- end: PAGE HEADER -->
<!-- start: PAGE CONTENT -->
<div class="row">
   <input type="hidden" id="project-id" value="<?php echo $projectID;?>">
   <input type="hidden" id="user-id" value="<?php echo $user_id;?>">
   <div class="col-sm-12">
      <div class="tabbable">
         <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
            <li class="active" id="taboverview" >
               <a data-toggle="tab" href="#panel_overview" onclick="location.reload();">
                  Overview 
               </a>
            </li>
            <li>
               <a data-toggle="tab" href="#taskpanel" onclick="refreshtask(<?php echo $projectID ;?>,0);">
                  Task
               </a>
            </li>
            <li id="tabnotes">
               <a data-toggle="tab" href="#notes" onclick="refreshNoted(<?php echo $projectID ;?>);">
                  Notes
               </a>
            </li>
            <li id="tabdocument">
               <a data-toggle="tab" href="#documenttab" onclick="refreshDocument(<?php echo $projectID ;?>);">
                  Document
               </a>
            </li>
            <li >
               <a data-toggle="tab" href="#technical" onclick="refrestechnical(<?php echo $projectID ;?>);">
                  Technical Answer
               </a>
            </li>
            <?php 
            $str123Meeting="<li>
            <a data-toggle='tab' href='#meeting' onclick='refreshMeeting($projectID);'>
            Meeting
            </a>
            </li>";	
            if (in_array(16, $permisionPieace)) {echo $str123Meeting;} 	
            $strInputData="<li>
            <a data-toggle='tab' id='datainputtt' class='datainputtt' href='#datainput'>
            Data Input
            </a>
            </li>";
            if (in_array(23, $permisionPieace)) {echo $strInputData;} 
            $strSurvey="<li id='tabsurvey'>
            <a data-toggle='tab' href='#survey' onclick='getsurveReport($projectID);' >
            Survey
            </a>
            </li>";
            if (in_array(21, $permisionPieace)) {echo $strSurvey;} 
               //mubadzir, di enginering ada, di surveyor ada
               // $strComment="<li id='tabComment'>
               // 	<a data-toggle='tab' href='#comment' onclick='SurveComment($projectID,1);' >
               // 		Comment
               // 	</a></li>	";
            
            if (in_array(22, $permisionPieace)) {echo $strComment;} 
            $str12admin="<li>
            <a data-toggle='tab' href='#administrative'>
            Administrative
            </a>
            </li>";
            if (in_array(15, $permisionPieace)) {echo $str12admin;} 
               //dipindahke menu administratif 
               // $str122admin="<li>
               // 	<a data-toggle='tab' href='#requirement' onclick='refreshRules($projectID);'>
               // 		Requirement
               // 	</a>
               // </li>";									
            if (in_array(26, $permisionPieace)) {echo $str122admin;} 
            $str12enginner="									<li>
            <a data-toggle='tab' href='#motong' onclick='getInsertdrawing($projectID);' >
            Engineering
            </a>
            </li>";	
            if (in_array(17, $permisionPieace)) {echo $str12enginner;} 		
            $str123manager="									<li>
            <a data-toggle='tab' href='#managerrr' onclick='refreshmoderation($projectID);' >
            Manage
            </a>
            </li>";	
            if (in_array(18, $permisionPieace)) {echo $str123manager;} 		
            $st123Finance="<li>
            <a data-toggle='tab' href='#money'  onclick='refreshcost($projectID);' >
            Finance
            </a>
            </li>";
            if (in_array(19, $permisionPieace)) {echo $st123Finance;} 	
            $strReport="<li>
            <a data-toggle='tab' href='#reportt'  onclick='refreshDailyreport($projectID);'>
            Report
            </a>
            </li>";	
            if (in_array(20, $permisionPieace)) {echo $strReport;}
            
            $strMatkom="<li>
            <a data-toggle='tab' href='#indukmatkomtab'  onclick='RefresMatkommaCombo($projectID);'>
            Material Comp.
            </a>
            </li>";  
            if (in_array(27, $permisionPieace)) {echo $strMatkom;}              

            
            ?>
         </ul>
         <div class="tab-content">
            <div id="panel_overview" class="tab-pane in active">
               <div class="row">
                  <div class="col-sm-12">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <i class="clip-stats"></i>
                           Timeline
                           <div class="panel-tools">
                              <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                              </a>
                              <a class="btn btn-xs btn-link panel-refresh" href="#">
                                 <i class="fa fa-refresh"></i>
                              </a>
                              <a class="btn btn-xs btn-link panel-close" href="#">
                                 <i class="fa fa-times"></i>
                              </a>
                           </div>
                        </div>
                        <style type="text/css">
                           
                           /* ---- Timeline ---- */
                           .timeliness ol {
                              position: relative;
                              display: block;
                              margin: 100px;
                              height: 4px;
                              background: #31708F;
                           }
                           .timeliness ol::before,
                           .timeliness ol::after {
                              content: "";
                              position: absolute;
                              top: -8px;
                              display: block;
                              width: 0;
                              height: 0;
                              border-radius: 10px;
                              border: 10px solid #31708F;
                           }
                           .timeliness ol::before {
                              left: -5px;
                           }
                           .timeliness ol::after {
                              right: -10px;
                              border: 10px solid transparent;
                              border-right: 0;
                              border-left: 20px solid #31708F;
                              border-radius: 3px;
                           }

                           /* ---- Timeline elements ---- */
                           .timeliness li {
                              position: relative;
                              display: inline-block;
                              float: left;
                              width: 150px;
                              font: bold 14px arial;
                              height: 50px;
                           }
                           .timeliness li .diplome {
                            position: absolute;
                            top: -47px;
                            left: 36%;
                            color: #000000;
                         }
                         .timeliness li .point {
                           content: "";
                           top: -4px;
                           left: 43%;
                           display: block;
                           width: 12px;
                           height:12px;
                           border: 1px solid #31708F;
                           border-radius: 10px;
                           background: #fff;
                           position: absolute;
                        }

                        .timeliness li .pointdone {
                           content: "";
                           top: -4px;
                           left: 43%;
                           display: block;
                           width: 12px;
                           height:12px;
                           border: 6px solid #31708F;
                           border-radius: 10px;
                           background: #fff;
                           position: absolute;
                        }
                        .timeliness li .description {
                         display: none;
                         background-color: #f4f4f4;
                         padding: 10px;
                         margin-top: 20px;
                         position: relative;
                         font-weight: normal;
                         z-index: 1;
                      }
                      .timeliness .description::before {
                         content: '';
                         width: 0; 
                         height: 0; 
                         border-left: 5px solid transparent;
                         border-right: 5px solid transparent;
                         border-bottom: 5px solid #f4f4f4;
                         position: absolute;
                         top: -5px;
                         left: 43%;
                      }

                      /* ---- Hover effects ---- */
                      .timeliness li:hover {
                        cursor: pointer;
                        color: #48A4D2;
                     }
                     .timeliness li:hover .description {
                      display: block;
                   }

                   @media screen and (max-width: 600px) {
                      .timeliness {
                       visibility: hidden;
                       clear: both;
                       display: none;
                    }
                 }

              </style>
              <div class="panel-body">
               <div class="timeliness">
                  <ol>
                    <?php echo $strtimelines ;?>
                    
                 </ol>
              </div>
           </div>
        </div>
        
     </div>
  </div>

  <div class="row">
   <div class="col-sm-7">
      <div class="panel panel-default">
         <div class="panel-heading">
            <i class="clip-stats"></i>
            Activity
            <div class="panel-tools">
               <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
               </a>
               <a class="btn btn-xs btn-link panel-refresh" href="#">
                  <i class="fa fa-refresh"></i>
               </a>
               <a class="btn btn-xs btn-link panel-close" href="#">
                  <i class="fa fa-times"></i>
               </a>
            </div>
         </div>
         <link href="../css/timeline.css" rel="stylesheet" type="text/css" />
         <?php
         $waktusekarang= date("Y-m-d H:i:s");
         $timelines=$obj->getActivity($waktusekarang,10,$projectID);
         
         echo " <div style='overflow-y:scroll; height:632px; margin-top:3px; '> <input type='hidden' id='updatee' name='updatee' class='updatee' value=$idlast /> 
         <ol  id='update' class='timeline' style='width: 600px;'>	";
         foreach ($timelines as $timeline) {
            
                           	//kegiatan
           if ($timeline['trashed_on']!="0000-00-00 00:00:00"){
              
              $stringkegiatan = " has send to trash ";
              
           }elseif($timeline['updated_on']!=$timeline['created_on']){
              
              $stringkegiatan = " has edited the ";
              
           }else {
              
              $stringkegiatan = " has added the ";
              
           }
           
                           	//object
           
           if ($timeline['object_type_id']== 14 ){
              
              $lisindukComents=$obj->getObjtcommenbyid($timeline['id']);
              
              foreach($lisindukComents as $lisindukComent){
                 $namakegiatan=Maxcaracter($lisindukComent['name']);
                 $objekdanLink= "href='panel.php?module=projectDetail&id=$lisindukComent[rel_object_id]'><strong> $namakegiatan</strong>";
                 
              }
              
              
              
           }else{
              $namakegiatan=Maxcaracter($timeline['name']);
              $objekdanLink= "href='panel.php?module=projectDetail&id=$timeline[id]'><strong> $namakegiatan</strong>";
           }
           
           
           
           $sesuaiformat=$Activity->format_tanggal($timeline['updated_on']);
           
           echo "
           <div title='$timeline[nick]' class='friends_area' ><img src='../$timeline[path]' height='65' style='float:left;' alt=''> 
           <label style='float:left' class='name'>
           <b>$timeline[nick] </b>
           <br> 
           <span class='aktifitas'>$timeline[jeneng] $stringkegiatan $timeline[nama] </span> 
           <br>
           <span style='padding: 4px 10 30px 18px; width:30; height:30' 	class='db-ico ico-$timeline[handler_class]'> </span>
           <a class='terusan-$timeline[handler_class]' style='font-weight:bold;' $objekdanLink </a>
           </br>
           <span class='tanggalfeed'>$sesuaiformat </span>
           </br>
           
           </label>
           </div>";
           
           $last_id= $timeline['updated_on'];
           
        }
        
        echo "</ol>	<div id='more' style='margin-top: 20px;'> <a  id='$last_id' class='load_more' href='#' onClick='GetmoreActivity($projectID,&#34;$last_id&#34;);'>more</a> </div></div>";
        
        
        ?>
     </div>
     <?php
     if (in_array(14, $permisionPieace)) {
      $str123task="<div id='latetask' class='latetask'>
      <table class='table table-condensed table-hover' id='sample-table-3'>
      <thead>
      <tr>
      <th>Time</th>
      <th> Task </th>
      </tr>
      </thead>
      <tbody>" ;
      foreach ($taskundone as $taskundon){
       $dayLates=styleTaskObj($taskundon['due_date']);
       $str123task=$str123task. "<tr>
       
       <td>
       $dayLates
       </td>
       
       <td ><a href='panel.php?module=projectDetail&id=$taskundon[object_id]'><strong>$taskundon[nama]: </strong> $taskundon[name]</a></td>
       </tr>";
       
    }
    
    $str123task=$str123task."		
    </tbody>
    </table>
    </div>
    <hr>
    </hr>
    <div class='col-sm-3'>
    <span class='input-icon input-icon-right'>
    <input placeholder='Add task' id='ExpresstaskName' class='form-control' type='text'>
    <i class='fa fa-rocket'></i> </span>
    </div>
    <div class='col-sm-3'>
    <span class='input-icon input-icon-right'>
    <input placeholder='Due date:' id='Expressdue' type='text' data-date-format='dd-mm-yyyy' data-date-viewmode='years' class='form-control date-picker' class='form-control' >
    <i class='fa clip-calendar-3'></i> </span>
    </div>									
    <div class='col-sm-3'>
    <select  class='form-control tooltips' data-original-title='Set Assigment to' data-rel='tooltip'  title='' data-placement='top' name='asigment' id='ExpresAssigmentto' >";
    foreach ($TeamMembers as $piece){
      
      $biodata_users= $Users->getUser_biodata($piece);
      $nama_uservs=$Users->get_users_with_title($piece);
      
      $str123task=$str123task. "<option value='$piece'>$nama_uservs</option>"   ;
   }
   $str123task=$str123task."
   </select>		
   </div>
   <div class='col-sm-3'>
   <button type='button' class='btn btn-primary' onClick='addexpressTaskobj($projectID );'>
   Add Task
   </button>
   </div>";										
   
   echo C_dashboardLeft("Late and upcoming tasks ","clip-stats",$str123task);
}

echo C_dashboardLeft("Calendar","clip-calendar","<div id='calendar'></div>");
$listLogsSynch=$drawing->get_logSynchidKon($projectID);

if (in_array(11, $permisionPieace)) {
   $strLog="<div id='logCommnet' class='latetask' style='overflow-y:scroll; height:252px; margin-top:3px; '>
   <table class='table table-condensed table-hover' id='sample-table-3'>
   <thead>
   <tr><th>Date</th>
   <th>Activity</th>
   <th>Mark</th>
   </tr>
   </thead>
   <tbody>";
   foreach($listLogsSynch as $listLogsSync){
      $tanggal=FormatTanggaljam($listLogsSync['tanggal']);
      $marking=substr($listLogsSync['textc'], 0, 50); 
      $activitas=$arrayalogsync_s[$listLogsSync['activity']];
      $strLog=$strLog . "<tr><td>$tanggal</td><td>$activitas</td><td>$marking</td></tr>";
   } 
   $strLog=$strLog . "</tbody></table></div>"; 
   
   echo C_dashboardLeft("Sync Log","clip-stats",$strLog);
}
if (in_array(12, $permisionPieace)) {
   $strallDrawingtypejson="['Total', " . $drawing->GetCountAllDraw($projectID) . "]," ;
   
   foreach ($EngginerFild_ew as $value => $nilai) {
                        //$strCombofieldDraw .= "<option value='$value'>$nilai</option>" ;
      $strallDrawingtypejson=$strallDrawingtypejson . "['$nilai', " . $drawing->GetCountDrawEngfield($projectID,$value) . "]," ;
   }
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['uncategory', " . $drawing->GetCountDrawEngfield($projectID,0) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Stability', " . $drawing->GetCountDrawEngfield($projectID,1) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Loadline', " . $drawing->GetCountDrawEngfield($projectID,2) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Mechanical', " . $drawing->GetCountDrawEngfield($projectID,3) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Electrical', " . $drawing->GetCountDrawEngfield($projectID,4) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Safety', " . $drawing->GetCountDrawEngfield($projectID,5) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Hull & Str.', " . $drawing->GetCountDrawEngfield($projectID,6) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Tonnage', " . $drawing->GetCountDrawEngfield($projectID,7) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Instrumentation', " . $drawing->GetCountDrawEngfield($projectID,8) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Materials', " . $drawing->GetCountDrawEngfield($projectID,9) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Navigation', " . $drawing->GetCountDrawEngfield($projectID,10) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Process', " . $drawing->GetCountDrawEngfield($projectID,11) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Piping', " . $drawing->GetCountDrawEngfield($projectID,12) . "]," ;
                        // $strallDrawingtypejson=$strallDrawingtypejson . "['Telecommunications', " . $drawing->GetCountDrawEngfield($projectID,13) . "]," ;
   
   
   
   
   echo C_dashboardLeft("Drawing Engineering field","clip-stats","<div id='chart_div6' style='width: 100%; height:300px;'></div>");
}
if (in_array(13, $permisionPieace)) {
   $strLogCommnet="<div id='logCommnet' class='latetask' style='overflow-y:scroll; height:252px; margin-top:3px; '>
   <table class='table table-condensed table-hover' id='sample-table-3'>
   <thead>
   <tr><th>ID</th>
   <th>Date</th>
   <th>Comment</th>
   <th>Status</th></tr>
   </thead>
   <tbody>";
   $listLogCommnet=$comment->get_db_comment($projectID);			
   foreach ($listLogCommnet as $listLogCommne){
      $tanggal=FormatTanggal($listLogCommne['tanggal']);
      $status= $statu_s[$listLogCommne['status']];
      $strLogCommnet=$strLogCommnet . "<tr><td><strong> $listLogCommne[nomer_comment] </strong></td>
      <td>$tanggal</td>
      <td width='60%'>$listLogCommne[comment]</td>
      <td><strong>$status</strong></td> </tr>" ;
   }
   $strLogCommnet=$strLogCommnet . "</tbody></table></div>"; 
   echo C_dashboardLeft("Comment Log","clip-comment",$strLogCommnet);
}

if (in_array(24, $permisionPieace)) {
   $strSurveyjson ="['regular', " . $comment->GetCountRegularSurvey($projectID) . "]," ;	
   $strSurveyjson=$strSurveyjson . "['patrol', " . $comment->GetCountPatrolSurvey($projectID) . "]," ;	
   
   echo C_dasboardRight("Visit Survey","<div id='chart_div18' style='width: 100%; height:250px;'></div>");}
   ?>
</div>
<div class="col-sm-5">
   <?php 
   if (in_array(1, $permisionPieace)) {
      $strTujuan= $description ."<hr></hr><center><strong>" .$purpose . ",- ==> </strong> $sIncomedeliver <hr><h3>";
      $strTujuan=$strTujuan.  round ($percent,1) . "%</h3></center>" ;
      echo C_dasboardRight("Project Description / objective",$strTujuan );
   }
   if (in_array(3, $permisionPieace)) {
      echo C_dasboardRight("Cost vs Income","<div id='piechart2' style='width: 100%; height:140px; '></div>" );
   }
   if (in_array(4, $permisionPieace)) {
      echo C_dasboardRight("Distribution Cost income","	<div id='chart_div3' style='width: 100%; height:250px; '></div>" );
   }
   
   if (in_array(5, $permisionPieace)) {
                        //note dashboard
     $messaLists=$obj->GetObjectbyproject($projectID,'3',5);
     foreach($messaLists as $messaList ){
       $namaProjekPende=cutStringcumbbread($messaList[project]);
       $strnote= $strnote . "					
       <li id='message' class='message-row ico-message '>
       <span ><span class='member-path' title='$messaList[project]'><span class='member-path og-wsname-color-22'><a href='#' >$namaProjekPende</a></span></span></span>
       <a href='panel.php?module=projectDetail&id=$messaList[id]' target='overview-panel'><span class='message-title'>$messaList[name]</span></a>
       
       </li>";
    }
    $strnote= $strnote . "<p></p><p></p><li class='view-all'>
    <a data-toggle='tab' href='#notes' onClick='changeclassactiveTab(&#34;tabnotes&#34;);'>
    See all notifications <i class='fa fa-arrow-circle-o-right'></i>
    </a>
    </li>";
    
    echo C_dasboardRight("Notes",$strnote );
 }
 if (in_array(6, $permisionPieace)) {
   $DocumentLists=$obj->GetObjectbyproject($projectID,'6',5);
   foreach($DocumentLists as $DocumentList){
     $namaProjekPende=cutStringcumbbread($DocumentList['project']);
     $strdocumen=$strdocumen .  "
     <li id='message' class='message-row ' style='background: transparent url(assets/images/filetypes/16/$DocumentList[icon]) no-repeat !important ; background-size: 10px 10px; ' >
     <span ><span class='member-path' title='$DocumentList[project]'><span class='member-path og-wsname-color-22'><a href='#' >$namaProjekPende</a></span></span></span>
     <a href='panel.php?module=projectDetail&id=$DocumentList[id]' target='overview-panel'><span class='message-title'>$DocumentList[name]</span></a>
     </li>";
  }
  
  $strdocumen=$strdocumen."<p></p><p></p><li class='iew-all'>
  <a data-toggle='tab' href='#documenttab' onClick='changeclassactiveTab(&#34;tabdocument&#34;);'>
  See all notifications <i class='fa fa-arrow-circle-o-right'></i>
  </a></li>";
  
  echo C_dasboardRight("Documents",$strdocumen );
}
//bls comment dari engnginer owner sementara permision 6 semua team bisa lihat
if (in_array(6, $permisionPieace)) {
   $strLogCommnet="<div id='logCommnet' class='latetask' style='overflow-y:scroll; height:352px; margin-top:3px; '>
   <table class='table table-condensed table-hover' id='sample-table-3'>
   <thead>
   <tr><th>ID</th>
   <th>by</th>
   <th>Comment</th>
   <th>Date</th>
   </tr>
   </thead>
   <tbody>";
   $listLogCommnet=$comment->get_timelines_comment($projectID);       
   foreach ($listLogCommnet as $listLogCommne){
      $tanggal=FormatTanggaljam($listLogCommne['tanggal']);
      $nama = $listLogCommne['oleh'] ;
      $status= getInitials($nama);
      $strLogCommnet=$strLogCommnet . "<tr><td><strong> <a  href='#timelinecommnet' data-toggle='modal' onClick='viewcomment($listLogCommne[id_kont],$listLogCommne[idcomment]);'>$listLogCommne[nomer_comment]</a> </strong></td>
      <td title='$nama'><strong>$status</strong></td>
      <td width='60%'>$listLogCommne[replay]</td>
      <td>$tanggal</td>
       </tr>" ;
   }
   $strLogCommnet=$strLogCommnet . "</tbody></table></div>"; 
   echo C_dasboardRight("Timeline Comment conversation",$strLogCommnet);
}



if (in_array(7, $permisionPieace)) {
   $strpeople="<div id='teammebertabulation' style='overflow-y:scroll; height:552px; margin-top:3px; '><select id='teamtabulasi' class='form-control' >";
   foreach($listUsers as $listUser){
    $strpeople=$strpeople. "<option value='$listUser[id_user]'>$listUser[nama]</option>"   ;
 } 
 $strpeople=$strpeople."</select><br><p>
 <a class='btn btn-blue'  onclick='Addmembersuser($projectID);'><i class='fa fa-plus'></i>Add</a>
 <br><hr>							
 <div id='teamlist' class='teamlist'><table class='table table-striped table-hover' id='sample-table-1'>
 <tbody>";
 
 $listTeamOgs=$Users->getOgsteam($projectID);			
 foreach ($listTeamOgs as $piece){
  
  $nama_userv=$piece['nama'];
  $displayPictures="../" . $piece['path'];
  $emailUserv=$piece['email'];
  $posisii=$piece['posisi'];
  $idUser=$piece['id_user'];
  
  $strpeople=$strpeople. "	<tr>
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
  
  $x=0;
  foreach ($listjabatanarr as $listjabatanaro){
     $idjabatan=	$listjabatanar[$x];
     $strpeople=$strpeople. "<li role='presentation'>
     <a role='menuitem' tabindex='-1'  onclick='updatePosuser($idjabatan,$idUser,$projectID);'>
     <i class='fa fa-share'></i> set $listjabatanaro
     </a>
     </li>";
     
     $x++;
  }
  
  $strpeople=$strpeople. "<li role='presentation'>
  <a role='menuitem' tabindex='-1'  onclick='Delmembersuser($idUser,$projectID);'>
  <i class='fa fa-share'></i> Dell user
  </a>
  </li>";
  
  
  $strpeople=$strpeople. 		"		
  </ul>
  </div>
  </div></td>
  </tr>";
  
}
$strpeople=$strpeople. "</tbody></table></div></div>"; 

echo C_dasboardRight("People",$strpeople );	
}

if (in_array(8, $permisionPieace)) {
   $strDrawing="<div id='chart_div5' style='width: 100%; height:250px;'></div>" ;
   $strDrawingjson=$strDrawingjson . "['Total', " . $drawing->GetCountAllDraw($projectID) . "]," ;
   $strDrawingjson=$strDrawingjson . "['Revisi', " . ($drawing->GetCountAllDraw($projectID) - $drawing->GetCountunixDrawing($projectID)) . "]," ;
   $strDrawingjson=$strDrawingjson . "['Doc.by title', " . $drawing->GetCountunixDrawing($projectID) . "]," ;
   $strDrawingjson=$strDrawingjson . "['Doc. review', " . $drawing->GetCountDrawDone($projectID) . "]," ;
   
   
   foreach ($tipe_gambars as $tipe_gambar) {
      if ($tipe_gambar['id'] != 15) {
         $strDrawingjson=$strDrawingjson . "['$tipe_gambar[nama]', " . $drawing->GetCountDrawtipedata($projectID,$tipe_gambar['id']) . "]," ;
      }
   }	
   
                        // $strDrawingjson=$strDrawingjson . "['Struture', " . $drawing->GetCountDrawtipedata($projectID,1) . "]," ;
                        // $strDrawingjson=$strDrawingjson . "['Electrical', " . $drawing->GetCountDrawtipedata($projectID,2) . "]," ;
                        // $strDrawingjson=$strDrawingjson . "['Machinery', " . $drawing->GetCountDrawtipedata($projectID,3) . "]," ;
                        // $strDrawingjson=$strDrawingjson . "['Stability', " . $drawing->GetCountDrawtipedata($projectID,4) . "]," ;
   
   
   
   $strDrawingjson=$strDrawingjson . "['Drawing', " . $drawing->GetCountdrawApproval($projectID) . "]," ;							
   
   echo C_dasboardRight("Drawing per title",$strDrawing );
}
if (in_array(9, $permisionPieace)) {
   $strCommentjson="['Total', " . $comment->GetCountAllComment($projectID) . "]," ;
   $strCommentjson=$strCommentjson . "['Publish', " . $comment->GetCountPublishComment($projectID) . "]," ;
   $strCommentjson=$strCommentjson . "['Closed', " . $comment->GetCountCloseComment($projectID) . "]," ;
   $strCommentjson=$strCommentjson . "['Unfollowup', " . $comment->get_countUnfollowupComment($projectID) . "]," ;
   $strCommentjson=$strCommentjson . "['Info', " . $comment->GetCountInfoComment($projectID) . "]," ;
   
   
   
   foreach ($tipe_gambars as $tipe_gambar) {
      
      $strCommentjson=$strCommentjson . "['$tipe_gambar[nama]', " . $comment->GetCountCommentTipe($projectID,$tipe_gambar['id']) . "]," ;
      
   }	
   
   
                        // $strCommentjson=$strCommentjson . "['Structure', " . $comment->GetCountCommentTipe($projectID,1) . "]," ;
                        // $strCommentjson=$strCommentjson . "['Machinery', " . $comment->GetCountCommentTipe($projectID,2) . "]," ;				
                        // $strCommentjson=$strCommentjson . "['Electrical', " . $comment->GetCountCommentTipe($projectID,3) . "]," ;
                        // $strCommentjson=$strCommentjson . "['Stability', " . $comment->GetCountCommentTipe($projectID,4) . "]," ;
   
   
   $strCommentjson=$strCommentjson . "['Survey', " . $comment->GetCountCommentTipe($projectID,15) . "]," ;
   
   echo C_dasboardRight("Comment","<div id='chart_div7' style='width: 100%; height:250px;'></div>");	
}
if (in_array(10, $permisionPieace)) 
{
                        	// $strTechnicaljson ="['Total', " . $C_client->GetCountAllTechnical($projectID) . "]," ;	
                        	// $strTechnicaljson=$strTechnicaljson . "['Done', " . $C_client->GetCountAnswerTechnical($projectID) . "]," ;	
   
  $strnewStile="
  <center><h2> <div class='technicalask'>Loading..</div> </h2></center>" ;
  
  echo C_dasboardRight("Technical Query",$strnewStile);
}									
?>
</div>
</div>
<hr>
</hr>					
<div class="row">
   <div class="col-sm-12">
      <label>
         <h4>
            Documentation 
            <h4>
            </label>
         </div>
         <div class="refreshgalery" id="refreshgalery">
            <?php
            $PictureLists=$Activity->getdocGaleryAsociated($projectID,3);
            
            foreach ($PictureLists as $PictureList) {
               
               $thumbnail=basename($PictureList[path]);
               
               echo "<div class='col-md-3 col-sm-4 gallery-img'>
               <div class='wrap-image'>
               <a class='group1' href='$PictureList[path]' title='$PictureList[nama]'>
               <img src='data/Thumbdata/$thumbnail'  alt='' class='img-responsive'>
               </a>
               <div class='chkbox'></div>
               <div class='tools tools-bottom'>
               <a href='#'>
               <i class='clip-link-4'></i>
               </a>
               <a href='#'>
               <i class='clip-pencil-3 '></i>
               </a>
               <a  onClick='Delgalery($PictureList[id]);'>
               <i class='clip-close-2'></i>
               </a>
               </div>
               </div>
               </div>" ;
               
            }
            
            
            
            
            
            
            
            ?>
         </div>
      </div>
      <!-- end: PAGE CONTENT-->
   </div>
   <div id="taskpanel" class="tab-pane">
      <form action="#" role="form" id="form">
         <h3>Progress.. </h3>
         <div class="progress progress-striped active progress-sm content">
            <div style="width: <?php echo $progressoverall ;?>%;" aria-valuemax="100" aria-valuemin="0" role="progressbar" class="progress-bar progress-bar-success step-bar">
               <span class="sr-only"> 0% Complete (success)</span>
            </div>
         </div>
         <div id="inputTask" class="inputTask" >
            <form >
               <div class="row">
                  <div class="col-sm-12">
                     <div class="form-group">
                        <label class="control-label">
                           Title <span class="symbol required"></span>
                        </label>
                        <input class="form-control tooltips" type="text" data-original-title="Please write the caption Here" data-rel="tooltip"  title="" data-placement="top" name="tasktitle" id="tasktitle">
                     </div>
                  </div>
                  <div class="col-sm-3">
                     <span class="input-icon input-icon-right">
                        <input placeholder="Start" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="starttask" class="form-control" type="text">
                        <i class="fa fa-rocket"></i> </span>
                     </div>
                     <div class="col-sm-3">
                        <span class="input-icon input-icon-right">
                           <input placeholder="Due"  type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="endtask" class="form-control" type="text">
                           <i class="fa fa-quote-right"></i> </span>
                        </div>
                        <div class="col-sm-3">
                           <span class="input-icon input-icon-right">
                              <select  class="form-control tooltips" data-original-title="Set Assigment to" data-rel="tooltip"  title="" data-placement="top" name="asigment" id="asigmentto" >
                                 <option></option>
                                 <?php 
                                 foreach ($TeamMembers as $piece){
                                    
                                    $biodata_users= $Users->getUser_biodata($piece);
                                    $nama_uservs=$Users->get_users_with_title($piece);
                                    
                                    echo "<option value='$piece'>$nama_uservs</option>"   ;
                                 }
                                 
                                 
                                 ?>
                              </select>
                              <i class="fa fa-hand-o-left"></i> </span>
                           </div>											
                        </div>
                        <p>
                        </p>
                        <div class="row">
                           <div class="col-sm-12">
                              <div class="form-group">
                                 <label class="control-label">
                                    Description
                                 </label>
                                 <textarea class="ckeditor form-control" cols="10" rows="10" id="describtask" ></textarea>
                              </div>
                           </div>
                        </div>
                        <p>
                        </p>
                        <input value="Submit" class="btn btn-bricky" type="button" onClick="addTaskobj(<?php echo $projectID ;?>);";> &nbsp; <a href='#responsive' data-toggle='modal' >Add subscriber</a> 
                     </form>	
                  </div>
                  <p>
                  </p>
                  <a class="btn btn-blue" onClick="slideAddTask();" ><i  id="tomboltask" class="fa fa-plus" ></i>
                  Create Task</a>
                  <a class="btn btn-green" onClick="#" href="./panel.php?module=taskschedule&idproj=<?php echo $projectID ;?>" target="_blank" ><i  id="tomboltask" class="fa fa-user" ></i>
                  View task Schedule</a>
                  <p>
                  </p>
               </form>
               <form id="form1" name="form1" method="post" action="">
                
                <label></label><label>
                   <input name="refreshtaskRadio" type="radio" onclick="refreshtaskByradiobutton(<?php echo $projectID ;?>);" value="0"  />
                View All</label>
                <label>
                   <input name="refreshtaskRadio" type="radio" onclick="refreshtaskByradiobutton(<?php echo $projectID ;?>);" value="1" />
                Drawing</label>
                <label>
                   <input name="refreshtaskRadio" type="radio" value="2" onclick="refreshtaskByradiobutton(<?php echo $projectID ;?>);" />
                Important dates</label>
                <label>
                   <input name="refreshtaskRadio" type="radio" value="3" onclick="refreshtaskByradiobutton(<?php echo $projectID ;?>);" />
                Doc. Request</label>                                    
                 <label>
                   <input name="refreshtaskRadio" type="radio" value="4" checked="checked" onclick="refreshtaskByradiobutton(<?php echo $projectID ;?>);" />
                Undone Task</label>        

             </form>
             <hr></hr>              
             <div id="listTasklist" class="listTasklist">
             </div>
          </div>
          <div id="datainput" class="tab-pane">
            <div class = "row">
               <div class="col-md-3">
                  <!-- start: DEFAULT TREE PANEL -->
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="fa fa-sitemap"></i>
                        Menu
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                              <i class="fa fa-wrench"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-expand" href="#">
                              <i class="fa fa-resize-full"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class = "panel-menu">
                        <div id="tree-parent" class="panel-body">
                           <div id="tree">
                           </div>
                        </div>
                        <!--input type="hidden" id="child-input" value=<?php echo $childData;?>-->
                     </div>
                  </div>
                  <!-- end: DEFAULT TREE PANEL -->
               </div>
               <div class="col-md-9">
                  <!-- start: DEFAULT TREE PANEL -->
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="fa fa-sitemap"></i>
                        <div id="heading-title">
                           Input
                        </div>
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-config" href="#panel-config" data-toggle="modal">
                              <i class="fa fa-wrench"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-expand" href="#">
                              <i class="fa fa-resize-full"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body" style='overflow-y:scroll; height:1100px; margin-top:3px;'>
                        <div id="panel-input" class="panel-input">
                        </div>
                     </div>
                  </div>
                  <!-- end: DEFAULT TREE PANEL -->
               </div>
            </div>
         </div>
         <div id="documenttab" class="tab-pane">
            <form class="form-horizontal" id="fileuploadssss" action="#">
               <div class="form-group">
                  <div class="col-sm-4">
                     <label>
                        Select file upload
                     </label>
                     <div class="fileupload fileupload-new" data-provides="fileupload">
                        <div class="input-group">
                           <div class="form-control uneditable-input">
                              <i class="fa fa-file fileupload-exists"></i>
                              <span class="fileupload-preview"></span>
                           </div>
                           <div class="input-group-btn">
                              <div class="btn btn-light-grey btn-file">
                                 <span class="fileupload-new"><i class="fa fa-folder-open-o"></i> Select file</span>
                                 <span class="fileupload-exists"><i class="fa fa-folder-open-o"></i> Change</span>
                                 <input type="file" class="file-input" name="item_file[]" multiple=""  >
                              </div>
                              <a href="#" class="btn btn-light-grey fileupload-exists" data-dismiss="fileupload">
                                 <i class="fa fa-times"></i> Remove
                              </a>
                           </div>
                        </div>
                        <button class="btn btn-purple"  type="submit" >
                           Start upload  <i class="fa fa-arrow-circle-right"></i>
                        </button> &nbsp; <a href='#responsive' data-toggle='modal' >Add subscriber</a> 
                     </div>
                     <input type="hidden" name="modul" id="modul" value="documentproj" readonly="readonly" />
                     <input type="hidden" name="act" id="act" value="upload" readonly="readonly" />
                     <input type="hidden" name="idKegiatans" id="idKegiatans" value="<?php echo $projectID ; ?>" />
                     <input type="hidden" name="subscr" id="subscr"  />
                     <p></p>
                  </div>
               </div>
               <div class="btn-group">
                  <button data-toggle="dropdown" class="btn btn-purple dropdown-toggle ">
                     Create document <span class="caret"></span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                     <li>
                        <a href="#" onClick="slideAddDocument();">
                           Document
                        </a>
                     </li>
                     <li class="divider"></li>
                     <li>
                        <a href="#"  onClick="slideAddSlime();" >
                           Presentation
                        </a>
                     </li>
                  </ul>
               </div>
                  <!--<a class="btn btn-orange" href="#"><i class="fa clip-refresh "></i>
                     Update</a>
                     <a class="btn btn-purple" onClick="makearship();">
                     Compress <i class="fa clip-database"></i>
                     </a>
                     <a class="btn btn-green">
                     Archive <i class="fa clip-archive "></i>
                     </a>
                     <a class="btn btn-red">
                     Move to trash <i class="fa 	clip-file-remove"></i>
                     </a>
                  -->
                  <div class="btn-group">
                     <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
                        Mark as <span class="caret"></span>
                     </a>
                     <ul class="dropdown-menu" role="menu">
                        <li role="presentation">
                           <a href="#" tabindex="-1" role="menuitem">
                              unread 
                           </a>
                        </li>
                        <li role="presentation">
                           <a href="javascript:void(0)" onClick="downloadAszip();" tabindex="-1" role="menuitem">
                              download as zip
                           </a>
                        </li>
                     </ul>
                  </div>
               </form>
               <p>
               </p>
               <div id="inputDocument" class="inputDocument">
                  <form >
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group">
                              <label class="control-label">
                                 FileName <span class="symbol required"></span>
                              </label>
                              <input class="form-control tooltips" type="text" data-original-title="Please write the caption Here" data-rel="tooltip"  title="" data-placement="top" name="captionmessage" id="WordFilename" value="untitled">
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group">
                              <label class="control-label">
                                 Text
                              </label>
                              <textarea class="ckeditor form-control" cols="10" rows="10" id="dataFileDoc" ></textarea>
                           </div>
                        </div>
                     </div>
                     <p>
                     </p>
                     <input value="Save" class="btn btn-bricky" type="button" onClick="WDoc();"> &nbsp; <a href='#responsive' data-toggle='modal' >Add subscriber</a> 
                  </form>
                  <p></p>
               </div>
               <div id="macamMacam" class="macamMacam">
               </div>
               <div id="inputSlideshow" class="inputSlideshow">
                  <form >
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group">
                              <iframe src="../plugin/slimey_0.2/slimey.html" width="100%" height="700px" ></iframe> 
                           </div>
                        </div>
                     </div>
                     <p>
                     </p>
                     <input value="Save" class="btn btn-bricky" type="button" onClick="alert('as');";> &nbsp; <a href='#responsive' data-toggle='modal' >Add subscriber</a> 
                  </form>
                  <p></p>
               </div>
               <div id="document" class="document">
               </div>
            </div>
            <div id="comment" class="tab-pane">
               <div id="surveycommentasdasd"  class="surveycommentasdasd" >
               </div>
            </div>

            <div id="technical" class="tab-pane" >
               <div class="row">
                  <div class="col-md-12">
                     <div class="panel panel-default">
                        <div class="panel-heading">
                           <i class="clip-stats"></i>
                           List Technical Ask
                           <div class="panel-tools">
                              <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                              </a>
                              <a class="btn btn-xs btn-link panel-refresh" href="#">
                                 <i class="fa fa-refresh"></i>
                              </a>
                              <a class="btn btn-xs btn-link panel-close" href="#">
                                 <i class="fa fa-times"></i>
                              </a>
                           </div>
                        </div>
                        <div class="panel-body">
                           <div id="isitechnical" class="isitechnical">Loading </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>

            
            <div id="notes" class="tab-pane">
               <div id="inputnotes" class="inputnotes">
                  <form >
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group">
                              <label class="control-label">
                                 Title <span class="symbol required"></span>
                              </label>
                              <input class="form-control tooltips" type="text" data-original-title="Please write the caption Here" data-rel="tooltip"  title="" data-placement="top" name="captionmessage" id="captionmessage">
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm-12">
                           <div class="form-group">
                              <label class="control-label">
                                 Text
                              </label>
                              <textarea class="ckeditor form-control" cols="10" rows="10" id="pesan" ></textarea>
                           </div>
                        </div>
                     </div>
                     <p>
                     </p>
                     <input value="Submit" class="btn btn-bricky" type="button" onClick="Addnotes_obj();";> &nbsp; <a href='#responsive' data-toggle='modal' >Add subscriber</a> 
                  </form>
               </div>
               <p>
               </p>
               <hr>
            </hr>
            <form class="form-horizontal" id="galeryss" action="#">
               <a class="btn btn-blue"  onclick="slideAddnoted();" ><i id="tombolnotes" class="fa fa-plus " ></i>
               Create notes</a>
            </form>
            <p>
            </p>
            <div id="noteslist" class="noteslist">
            </div>
         </div>
         <div id="administrative" class="tab-pane">
            <div class="tabbable">
               <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                  <li class="active" id="taboverview" >
                     <a data-toggle="tab" href="#administrativee" onclick="">
                        Administrative
                     </a>
                  </li>
                  <li>
                     <a data-toggle="tab" href="#teamsetup" onclick="refreshteam(<?php echo $projectID ;?>);">
                        Team SetUp
                     </a>
                  </li>
                  <li>
                     <a data-toggle="tab" href="#importandates" onclick="RefresTaskImportanddate(<?php echo $projectID ;?>);">
                        Important dates
                     </a>
                  </li>
                  <li>
                     <a data-toggle="tab" href="#requirementt" onclick="refreshRules(<?php echo $projectID ;?>);">
                        Requirement 
                     </a>
                  </li>
                  <li>
                     <a data-toggle="tab" href="#clientproject" onclick="grefreshClientproject(<?php echo $projectID ;?>);">
                        Client
                     </a>
                  </li>
                  <li>
                     <a data-toggle="tab" href="#itpsurvey" onclick="refreshSurveyTask(<?php echo $projectID; ?>);">
                        Survey Item
                     </a>
                  </li>         
               </ul>
               <div class="tab-content">
                  <div id="administrativee" class="tab-pane in active">
                     <div class="row">
                        <div class="col-md-12">
                           <form role="form" class="form-horizontal">
                              <div class="form-group">
                                 <label class="col-sm-2 control-label" for="form-field-1">
                                    Project Name
                                 </label>
                                 <div class="col-sm-9">
                                    <input type="text" placeholder="Text Field" id="projectname" class="form-control" value="<?php echo  $nameRela; ?>">
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-2 control-label" for="form-field-2">
                                    Project Value
                                 </label>
                                 <div class="col-sm-9">
                                    <input type="number" placeholder="Text Field" id="target" class="form-control"  value="<?php echo  $target; ?>" >
                                 </div>
                              </div>
                              <div class="form-group">
                                 <label class="col-sm-2 control-label" for="form-field-3" >
                                    Contract No
                                 </label>
                                 <div class="col-sm-9">
                                    <input type="text" placeholder="Text Field" id="contract" class="form-control"  value="<?php echo  $contract; ?>" >
                                 </div>
                              </div>
<!-- 						<div class="form-group">
						   <label class="col-sm-2 control-label" for="form-field-3" >
						   Vessel
						   </label>
						   <div class="col-sm-9">
							  <select name="select" id="tipeproject" class="form-control">
							  <?php 
								 //$tipe_objeks=$tipe_objeck->get_tipe_objek();
								 
								 //$str="";
								//foreach ($tipe_objeks as $tipe_objek) {
								// $str= $str . "<option value='". $tipe_objek['id'] . "'>" . $tipe_objek['deskrip'] . "</option>" ;  
								 
								 //if ($vesell==$tipe_objek['id']){
								//	$strAwal="<option value='". $tipe_objek['id'] . "'>" . $tipe_objek['deskrip'] . "</option>" ;
								// }
								 
								// }
								// echo $strAwal . $str ;
								 ?>
							  </select>
						   </div>
						</div> -->
						<div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-4" >
                        Team
                     </label>
                     <div class="col-sm-9">
                        <select multiple="multiple" id="team" class="form-control search-select" name="sapi[]" disabled>
                           <?php 
                           $listtemamembers=$obj->getTeamMember($projectID);
                           foreach($listUsers as $listUser){
                              $arrasu=$arrasu . "," . $listUser['id_user'] ;
                           }
                           $listtemamembers=substr(trim($listtemamembers), 1 );
                           
								 //echo "ssssapi" . $listtemamembers ;
                           $piecesss = explode(",", $listtemamembers);
                           foreach($piecesss as $piece){
                              
                              $biodata_users= $Users->getUser_biodata($piece);
                              $nama_uservs=$Users->get_users_with_title($piece);
                              
                              $isicombo=$isicombo."<option value='$piece' selected>$nama_uservs</option>"   ;
                              
                           }
                           
                           $arrasu=substr($arrasu, 1 );
                           
                           $pieces2=explode(",",$arrasu);
								 //echo $listtemamembers . " sapi ". $arrasubscriber;
                           $results = array_diff( $pieces2,$piecesss);
                           
                           
                           foreach ($results as $result){
                              
                              $biodata_users= $Users->getUser_biodata($result);
                              $nama_uservs=$Users->get_users_with_title($result);
                              
                              echo "<option value='$result'>$nama_uservs</option>"   ;
                           }
                           echo $isicombo ;
                           
                           ?>
                        </select>
                     </div>
                  </div>
<!-- 						<div class="form-group">
						   <label class="col-sm-2 control-label" for="form-field-5" >
						   Class
						   </label>
						   <div class="col-sm-9"> -->
                        <input type="hidden" placeholder="Text Field" id="classid" class="form-control"  value="<?php echo $class ;?>" >
<!-- 						   </div>
</div> -->
<div class="form-group">
   <label class="col-sm-2 control-label" for="form-field-6">
      Start
   </label>
   <div class="col-sm-9">
      <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
      <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="start"  value="<?php echo  $starting; ?>">
   </div>
</div>
<div class="form-group">
   <label class="col-sm-2 control-label" for="form-field-7">
      due
   </label>
   <div class="col-sm-9">
      <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
      <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="due"  value="<?php echo  $due ; ?>">
   </div>
</div>
<!-- 						<div class="form-group">
						   <label class="col-sm-2 control-label" >
						   Location
						   </label>
						   <div class="col-sm-9">	 -->
                        <input type="hidden" placeholder="Text Field" id="locationproj" class="form-control" value="<?php echo $lokasi ;?>">
<!-- 						   </div>
</div> -->
<!-- 						<div class="form-group">
						   <label class="col-sm-2 control-label" >
						   builder
						   </label>
						   <div class="col-sm-9">	 -->
                        <input type="hidden" placeholder="Text Field" id="builderproj" class="form-control"  value="<?php echo $builder ;?>" >
<!-- 						   </div>
</div> -->
<div class="form-group">
   <label class="col-sm-2 control-label" >
      Applicant
   </label>
   <div class="col-sm-9">	
      <input type="text" placeholder="Text Field" id="submiterpro" class="form-control"  value="<?php echo $submited ;?>">
   </div>
</div>

<div class="form-group">
   <label class="col-sm-2 control-label" for="form-field-3" >
      Sister Contract number 
   </label>
   <div class="col-sm-9">
    <input type="text" placeholder="ex:1801020318,1801020317" id="sistercontract" class="form-control"  value="<?php echo  $sistercontract; ?>" >
 </div>
</div>


<div class="form-group">
   <label class="col-sm-2 control-label" for="form-field-8">
      Description
   </label>
   <div class="col-sm-9">
      <textarea placeholder="workplace Description" id="form-field-22" class="form-control"><?php echo  $description; ?></textarea>
   </div>
</div>
<div class="form-group">
   <label class="col-sm-2 control-label" for="form-field-8">
      Contract Evidence
   </label>
   <div class="col-sm-9">
      <input type="text" placeholder="place url here" id="kontractlink" class="form-control"  value="<?php echo $kontractlink ;?>">
   </div>
</div>
<div class="form-group">
   <label class="col-sm-2 control-label" for="form-field-8">
      Done
   </label>
   <div class="btn-group">
      <a href="#" data-toggle="dropdown" class="btn btn-primary dropdown-toggle">
         Project Done <span class="caret"></span>
      </a>
      <ul class="dropdown-menu" role="menu">
         <li role="presentation">
            <a href='#ceklisthproject' data-toggle='modal' tabindex="-1" role="menuitem">
               Done  
            </a>
         </li>
         <li role="presentation">
            <a href="javascript:void(0)" onClick="projectundone(<?php echo  $projectID ;?>);" tabindex="-1" role="menuitem">
               Undone
            </a>
         </li>
      </ul>
   </div>
</div>
<div class="col-sm-2">
   <button type="button" class="btn btn-success btn-squared btn-lg" href='#' onclick='updateProjectt(<?php echo  $projectID ;?>);'>
      Update
   </button>
</div>
<div id="project1" class="project1" ></div>
</form>
</div>
</div>
<hr>
<div class="row">
 <div class="col-md-12">
   <h3> Project Query</h3>
   <form role="form" class="form-horizontal">
      <div class="form-group">
         <label class="col-sm-2 control-label" for="form-field-1">
            IDENTIFICATION
         </label>
      </div>
      <div class="form-group">
         <label class="col-sm-2 control-label">
           
         </label>
         <div class="col-sm-2">
            <input type="text" placeholder="Vessel name" id="vesselname" class="form-control" value="<?php echo $nameRela ;?>">
         </div>
         <div class="col-sm-3">
            <input type="number" placeholder="Register number" id="bkiid" class="form-control" value="<?php echo $bkiid ;?>">
         </div>
         <div class="col-sm-4">
            <input type="text" placeholder="Contract Number" id="bkidesaindid" class="form-control" value="<?php echo  $contract; ?>">
         </div>
      </div>
      <div class="form-group">
         <label class="col-sm-2 control-label">
           
         </label>
         <div class="col-sm-2">
            <input type="text" placeholder="Imo Number" id="imo" class="form-control" value="<?php echo $imo ;?>">
         </div>
         <div class="col-sm-3">
            <input type="text" placeholder="Operational Status ex:Contract new Building" id="operationstat" class="form-control" value="<?php echo $operationstat ;?>">
         </div>
         <div class="col-sm-4">
            <input type="text" placeholder="Flag" id="flag" class="form-control" value="<?php echo $flag ;?>">
         </div>
      </div>
      <div class="form-group">
         <label class="col-sm-2 control-label">
           
         </label>
         <div class="col-sm-2">
            <input type="text" placeholder="Port register" id="port" class="form-control" value="<?php echo $port ;?>">
         </div>
         <div class="col-sm-3">
            <input type="text" placeholder="Owner" id="owner" class="form-control" value="<?php echo $owner ;?>">
         </div>
         <div class="col-sm-4">
            <input type="text" placeholder="manager" id="manager" class="form-control" value="<?php echo $manager ;?>">
         </div>
      </div>


      <div class="form-group">
         <label class="col-sm-2 control-label" for="form-field-1">
            CLASSIFICATION
         </label>
      </div>
      <div class="form-group">
         <label class="col-sm-2 control-label">
           
         </label>
         <div class="col-sm-4">
            <input type="text" placeholder="Rules set : ex: BKI " id="rulesset" class="form-control" value="<?php echo $rulesset ;?>">
         </div>
         <div class="col-sm-5">
            <input type="number" placeholder="Rule edition" id="ruleedision" class="form-control" value="<?php echo $ruleedision ;?>">
         </div>
         
      </div>
      <div id= "div-notation" class="form-group">
         <label class="col-sm-2 control-label">
           
         </label>
         <?php echo $notationMenu;?>
      </div>
      <div class="form-group">
         <label class="col-sm-2 control-label">
           
         </label>
         <div class="col-sm-2">
            <input type="text" placeholder="Search notation" id="search-text" class="form-control" onkeyup="suggestNotation(this.value, 'notation', this.id)">
            <div class="suggestField" id="suggestField"></div>
         </div>
      </div>
      <div class="form-group">
         <label class="col-sm-2 control-label">
           
         </label>
         <div class="col-sm-4">
            <input type="text" placeholder="Ship type" id="type" class="form-control" value='<?php echo $type;?>'>
         </div>
      </div>



      <div class="form-group">
         <label class="col-sm-2 control-label" for="form-field-1">
            YARD
         </label>
      </div>
      <div class="form-group">
         <label class="col-sm-2 control-label">
           
         </label>
         <div class="col-sm-2">
            <input type="text" placeholder="Contracted builder ex: PT Citra, BATAM" id="builder" class="form-control" value="<?php echo $builder ;?>">
         </div>
         <div class="col-sm-3">
            <input type="text" placeholder="Hull yard ex: PT Citra, BATAM" id="hullyard" class="form-control" value="<?php echo $hullyard ;?>">
         </div>
         <div class="col-sm-4">
            <input type="text" placeholder="Outfitting yard ex: PT Citra, BATAM" id="outfittingyard" class="form-control" value="<?php echo $outfittingyard ;?>">
         </div>
      </div>
      <div class="form-group">
         <label class="col-sm-2 control-label">
            Keel laid
         </label>
         <div class="col-sm-1">
            <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="keellaid"  value="<?php echo $keellaid ;?>">
         </div>
         <label class="col-sm-1 control-label">
            Launch date
         </label>                                
         <div class="col-sm-1">
            <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="launchdate"  value="<?php echo $launchdate ;?>">
         </div>
         <label class="col-sm-1 control-label">
            Date of build
         </label>                                
         <div class="col-sm-1">
            <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="dateofbuild"  value="<?php echo $dateofbuild ;?>">                                 
            
         </div>
         <label class="col-sm-1 control-label">
            Delivery date
         </label> 
         <div class="col-sm-1">
           
           <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="deliverydate"  value="<?php echo $deliverydate ;?>">
        </div>
     </div>

     <div class="form-group">
      <label class="col-sm-2 control-label" for="form-field-1">
         DIMENSIONS
      </label>
   </div>
   <div class="form-group">
      <label class="col-sm-2 control-label">
        
      </label>
      <div class="col-sm-1">
         <input type="number" placeholder="Loa" id="loa" class="form-control" value="<?php echo $loa ;?>">
      </div>
      <div class="col-sm-1">
         <input type="number" placeholder="Lbp" id="lbp" class="form-control" value="<?php echo $lbp ;?>">
      </div>
      <div class="col-sm-1">
         <input type="number" placeholder="Lload" id="lload" class="form-control" value="<?php echo $lload ;?>">
      </div>
      <div class="col-sm-1">
         <input type="number" placeholder="Bext" id="bext" class="form-control" value="<?php echo $bext ;?>">
      </div>
   </div>

   <div class="form-group">
      <label class="col-sm-2 control-label">
        
      </label>
      <div class="col-sm-1">
         <input type="number" placeholder="B" id="b" class="form-control" value="<?php echo $b ;?>">
      </div>
      <div class="col-sm-1">
         <input type="number" placeholder="D" id="d" class="form-control" value="<?php echo $d ;?>">
      </div>
      <div class="col-sm-1">
         <input type="number" placeholder="Draught" id="draught" class="form-control" value="<?php echo $draught ;?>">
      </div>
      <div class="col-sm-1">
         <input type="text" placeholder="Freeboard" id="freeboard" class="form-control" value="<?php echo $freeboard ;?>">
      </div>
   </div>

   <div class="form-group">
      <label class="col-sm-2 control-label">                
      </label>
      <div class="col-sm-4">
         <button type="button" class="btn btn-primary btn-squared btn-sm" href='#' onclick='updateProjectquery(<?php echo  $projectID ;?>);'>
            Update
         </button>
      </div>
   </div>

   <div id="project1" class="project1" ></div>
</form>
</div>
</div>
</div>
<div id="teamsetup" class="tab-pane">
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               Project Team 
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">
              <select id='teamtabulasiadms' class='form-control' >
                <?php
                foreach($listUsers as $listUser){
                   echo "<option value='$listUser[id_user]'>$listUser[nama]</option>";
                } ?>
             </select><br><p>
               <a class='btn btn-blue'  onclick='AddmembersuserAdminst(<?php echo $projectID ;?>);'><i class='fa fa-plus'></i>Add</a>
               <br><hr>										
               <div id='classteam' class="classteam">
                 Loading..
              </div>
           </div>
        </div>
     </div>
     <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <i class="clip-stats"></i>
            Previlage
            <div class="panel-tools">
               <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
               </a>
               <a class="btn btn-xs btn-link panel-refresh" href="#">
                  <i class="fa fa-refresh"></i>
               </a>
               <a class="btn btn-xs btn-link panel-close" href="#">
                  <i class="fa fa-times"></i>
               </a>
            </div>
         </div>
         <div class="panel-body">								
            <h3>Set permission</h3>
            <select  class="form-control tooltips" data-original-title="Set Permission to" data-rel="tooltip"  title="" data-placement="top" name="userpermision" id="userpermision" onchange="LoadPermision(<?php echo  $projectID ;?> );">		
               <?php 
               foreach ($TeamMembers as $piece){
                  
                  $biodata_users= $Users->getUser_biodata($piece);
                  $nama_uservs=$Users->get_users_with_title($piece);
                  
                  echo "<option value='$piece'>$nama_uservs</option>"   ;
               }
               ?>
            </select>
            <div id="permissionTeam" class="permissionTeam"></div>
            <hr>
            <button type="button" class="btn btn-danger btn-squared btn-lg" href='#' onclick='Updatepermission(<?php echo  $projectID ;?>);'>Apply</button>
         </hr>	
      </div>
   </div>
</div>
</div>
</div>
<div id="clientproject" class="tab-pane">
   <div class="row">

      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               Client Conected with this project
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">                        
               <div id="clientuser" class="clientuser"></div>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="importandates" class="tab-pane">
   <div class="row">
      <div class="col-md-5">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               Estimated Important dates
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">								
               <div id="importantdate" class="importantdate">
                  <form role="form" class="form-horizontal">
                     <div class="form-group">
                        <label class="col-sm-5 control-label" for="form-field-1">
                           Est. Date of Kick-off meeting :                                 
                        </label>
                        <div class="col-sm-5">
                           <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span> 
                           <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="datekickoff" value="<?php echo $strdateKickoff;?>">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-5 control-label" for="form-field-1">
                           Est. Date of Keel laying :                                 
                        </label>
                        <div class="col-sm-5">
                           <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span> 
                           <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="datelaying"value="<?php echo $strdatekeel_laying;?>">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-5 control-label" for="form-field-1">
                           Est. Date of Launching  :                                 
                        </label>
                        <div class="col-sm-5">
                           <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span> 
                           <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="datelaunching"value="<?php echo $strdatelaunching;?>">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-5 control-label" for="form-field-1">
                           Est. Date of Sea Trial  :                                 
                        </label>
                        <div class="col-sm-5">
                           <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span> 
                           <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="dateseatrial"value="<?php echo $strdateseatrial;?>">
                        </div>
                     </div>
                     <div class="form-group">
                        <label class="col-sm-5 control-label" for="form-field-1">
                           Est. Project Completion  :                                 
                        </label>
                        <div class="col-sm-5">
                           <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span> 
                           <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="datefinal"value="<?php echo $strdatefinal;?>">

                           <label>
                           </label>
                           <p>
                              <a class="btn btn-green"  onclick="updateImportanddate(<?php echo $projectID;?>);"><i class="fa fa-plus"></i>
                              Update Impportant Dates</a>      
                           </p>
                        </div>
                        <div class="updateinfodiv"></div>
                     </div>                                      
                  </form>
               </div>
            </div>
         </div>
      </div>
      <div class="col-md-7">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               Task Turunan
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">        
               <form role="form" class="form-horizontal">
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Task Name :                                 
                     </label>
                     <div class="col-sm-9">
                        <input type="text" placeholder="Task Title" id="tasktitleturunan" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Type :
                     </label>
                     <div class="col-sm-9">
                        <select id="importantdateselect" class="form-control" >
                           <option value="1">Kick-Off</option>
                           <option value="2">Keel_laying</option>
                           <option value="3">launching</option>
                           <option value="4">SeaTrial</option>
                           <option value="5">Final</option>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Description :
                     </label>
                     <div class="col-sm-9">
                        <textarea class="form-control" placeholder="Task Description" id='Descriptionturunan'></textarea>
                        <label>
                        </label>
                        <p>
                           <a class="btn btn-blue"  onclick="AddTaskTurunanImportandate(<?php echo $projectID;?>);"><i class="fa fa-plus"></i>
                           Add Task</a>      
                        </p>
                     </div>
                  </div>
               </form>

               <hr>
            </hr>     
            <label>
            </label>
            <p>
               <a class="btn btn-yellow"  onclick="updateTaskCurrentDate(<?php echo $projectID;?>);"><i class="fa fa-plus"></i>
               Update Task Current Dates</a>      
            </p>
            <hr>
         </hr>           
         <div class="listTaskImportanddate">
            Loading...
         </div>
      </div>
   </div>
</div>
</div>
</div>

<div id="requirementt" class="tab-pane">
   <div class="tabbable">
      <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
         <li class="active" id="taboverview" >
            <a data-toggle="tab" href="#rulesapp" onclick="refreshRules(<?php echo $projectID ;?>);">
               Rules Applicable
            </a>
         </li>
         <li>
            <a data-toggle="tab" href="#docreqqq" onclick="RefresDocumenRequest(<?php echo $projectID ;?>);">
               Document Request
            </a>
         </li>
      </ul>
      <div class="tab-content">
         <div id="rulesapp" class="tab-pane in active">
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="clip-stats"></i>
                        List Rules BKI
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">
                        <div class="rulesbki" id="rulesbki">
                           Loading..
                        </div>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="clip-stats"></i>
                        List Applicable Rules
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">
                        <div class="listrulesapplicable" id="listrulesapplicable">
                        </div>
                        Loading
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div id="docreqqq" class="tab-pane">
            <div class="row">
               <div class="col-md-5">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="clip-stats"></i>
                        Add Document Request
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">                        
                        <form role="form" class="form-horizontal">
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                                 Document Title :                                 
                              </label>
                              <div class="col-sm-9">
                                 <input type="text" placeholder="Document Title" id="Documenttitle" class="form-control">
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                                 due date :                                 
                              </label>
                              <div class="col-sm-9">
                                 <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span> 
                                 <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="duedocrequest">
                              </div>
                           </div>                                      
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                                 Description :
                              </label>
                              <div class="col-sm-9">
                                 <textarea class="form-control" placeholder="Task Description" id="deskripdocrequest"></textarea>
                                 <label>
                                 </label>
                                 <p>
                                    <a class="btn btn-green"  onclick="AddTaskDocumentRequest(<?php echo $projectID;?>);"><i class="fa fa-plus"></i>
                                    Add Task</a>      
                                 </p>
                              </div>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="col-md-7">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="clip-stats"></i>
                        List Task 
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">
                        <div class="docrequestclasslist">
                           Loading...
                        </div>                   
                        
                     </div>
                  </div>
               </div>
            </div>
         </div>
         
      </div>
   </div>
</div>
<div id="itpsurvey" class="tab-pane">
   <div class="row">

      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               Survey Item
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">
              <form role='form' id='itp-form'  name='itp-form' class='form-horizontal'>
                  <div class='form-group'>
                    <label class='col-sm-2 control-label' for='form-field-1'>
                      ITP Number:
                    </label>
                    <div class='col-sm-9'>
                       <input type="text" name='itp-num' class='col-sm-2 form-control' id='itp-num'>
                    </div>
                 </div>
                 <div class='form-group'>
                    <label class='col-sm-2 control-label' for='form-field-1'>
                      Item:
                    </label>
                    <div class='col-sm-9'>
                       <input type="text" name='itp-item' class='col-sm-2 form-control' id='itp-item'>
                    </div>
                 </div>
                 <div class="form-group">
                    <label class="col-sm-2 control-label" for="form-field-1">
                       Due date:                                 
                    </label>
                    <div class="col-sm-9">
                       <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span> 
                       <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="due-survey">
                    </div>
                 </div>
                 <div class='form-group'>
                    <label class='col-sm-2 control-label' for='form-field-1'>
                      Description:
                    </label>
                    <div class='col-sm-9'>
                       <textarea name='itp-desc' class='col-sm-2 form-control' id='itp-desc'></textarea>
                    </div>
                 </div>  
                 <div class='form-group'>
                    <label class='col-sm-2 control-label' for='form-field-1'>
                    
                    </label>
                    <div class='col-sm-9'>
                      <button type='button' class='btn btn-green' onclick='addSurveyItem(<?php echo $projectID;?>)'>
                        Add item
                      </button>
                    </div>
                 </div>
                 <p>
                 <hr>
                 </hr>
              </form>
              <div id="itp-table" class="itp-table"></div>
            </div>
         </div>
      </div>
   </div>
</div>		 
</div>
</div>
</div>
<div id="meeting" class="tab-pane">
   <div class="row">
      <div class="col-md-12">
         <form role="form" class="form-horizontal">
            <div class="form-group">
               <label class="col-sm-2 control-label" for="form-field-1">
                  Subject :
               </label>
               <div class="col-sm-9">
                  <input type="text" placeholder="Summary " id="form-field-1" class="form-control">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label" for="form-field-1">
                  Schedule :
               </label>
               <div class="col-sm-9">
                  <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>
                  <input type="text" id="schedule" class="form-control date-time-range">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label" for="form-field-1">
                  Location :
               </label>
               <div class="col-sm-9">
                  <input type="text" id="location" class="form-control">
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label" for="form-field-1">
                  External Email :
               </label>
               <div class="col-sm-9">
                  <div id="tags">
                     <input type="text" value="">
                  </div>
               </div>
            </div>
            <div class="form-group">
               <label class="col-sm-2 control-label" for="form-field-1">
                  Description :
               </label>
               <div class="col-sm-9">
                  <textarea placeholder="Description of training here" id="pesanndee" name="pesanndee" class="ckeditor form-control"></textarea>
                  <label>
                  </label>
                  <p>
                     <a class="btn btn-blue"  onclick="addmeeting(<?php echo $projectID ;?>);"><i class="fa fa-plus"></i>
                     Submit Entry</a>
                  </p>
               </div>
            </div>
         </form>
      </div>
      <div class="col-md-12">
         <!-- start: DYNAMIC TABLE PANEL -->
         <div class="panel panel-default">
            <?php echo writePanel("List Meeting"); ?>
            <div class="panel-body">
               <div id="mett" class="mett">
               </div>
            </div>
         </div>
         <!-- end: DYNAMIC TABLE PANEL -->
      </div>
   </div>
</div>

<div id="survey" class="tab-pane">
   <div class="tabbable">
      <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
         <li class="active" id="taboverview" >
            <a data-toggle="tab" href="#inputsurve" onclick="getsurveReport(<?php echo $projectID ;?>);">
               Survey
            </a>
         </li>
         <li>
            <a data-toggle="tab" href="#survedraw" onclick="getsurvedrawing(<?php echo $projectID ;?>);">
               Drawing List
            </a>
         </li>
         <li>
            <a data-toggle="tab" href="#survecommneting" onclick="SurveComment(<?php echo $projectID ."," . "0";?>);">
               Commenting
            </a>
         </li>
         <li>
            <a data-toggle="tab" href="#survedonloaddraw" onclick="refreshDrawingdownloadSurvey(<?php echo $projectID ;?>);">
               Download Drawing
            </a>
         </li>
         <li>
            <a data-toggle='tab' href='#datainput' onclick="$('#datainputtt').tab('show');">
               Data Input
            </a>
         </li>
      </ul>
      <div class="tab-content">
         <div id="inputsurve" class="tab-pane in active">
            <div class="row">
               <div class="col-md-8">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="clip-stats"></i>
                        Input Survey
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">
                        <form role="form" class="form-horizontal" id="addreportsurvey"  name="addreportsurvey">
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                              Date :											</label>
                              <div class="col-sm-9">
                                 <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
                                 <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="tanggal" name="tanggal" required >
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                                 Type :
                              </label>
                              <div class="col-sm-9">
                                 <select id="form-field-select-1survey" class="form-control" name="form-field-select-1survey" >
                                    <option value="1">Regular</option>
                                    <option value="2">Patrol</option>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                                 Survey Item :
                              </label>
                              <div class="col-sm-9">
                                 <select id="form-field-select-1survey" class="form-control search-select" name="form-field-select-itemsurvey" >
                                    <?php echo $svyOption; ?>
                                 </select>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                                 Progress (%) :
                              </label>
                              <div class="col-sm-9">
                                 <input type="number"  id="progresssurvey" name="progresssurvey"  class="form-control" required>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                                 Location :
                              </label>
                              <div class="col-sm-9">
                                 <input type="text"  id="locationsurvey" name="locationsurvey"  class="form-control" required>
                              </div>
                           </div>

                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                                 Scope of Survey :
                              </label>
                              <div class="col-sm-9">
                                 <textarea placeholder="Report narrative" id="narasisurvey" name="narasisurvey" class="ckeditor form-control"></textarea>
                              </div>
                           </div>
                           <hr>
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                                 Comment / Recomendation 
                              </label>
                              <div class="col-sm-9">
                                 <a class="btn btn-primary"  onClick="add_more();"><i class="glyphicon glyphicon-log-in"></i>Add Recommendation</a>
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                              </label>
                              <input type="hidden" name="nomercomentsurvey" id="nomercomentsurvey" value=0 readonly="readonly" />
                              <input type="hidden" name="modul" id="modul" value="survey" readonly="readonly" />
                              <input type="hidden" name="act" id="act" value="addreport" readonly="readonly" />
                              <input type="hidden" name="id_kon" id="id_kon" value="<?php echo $projectID ;?>" readonly="readonly" />
                              <div class="col-sm-9" id="commentarr">
                              </div>
                           </div>
                           <div class="form-group">
                              <label class="col-sm-2 control-label" for="form-field-1">
                                 Attachment	
                              </label>
                              <div class="col-sm-9">
                                 <input type="file" name="uploadAttacmentReport"  class="form-control"/>
                              </div>
                           </div>
                           <button class="btn btn-purple"  type="submit" >
                              Start upload  <i class="fa fa-arrow-circle-right"></i>
                           </button>
                           <button class="btn btn-green" class="btn btn-green" onclick="this.form.reset();">
                              Reset <i class="fa clip-archive "></i>
                           </button>
                        </form>
                     </div>
                  </div>
               </div>
               <div class="col-md-4">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="clip-stats"></i>
                        Applicable Rules
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">								
                        <?php 
                        $strrulesapplicab= Renametablenumber($strlistrules,17,16);
                        echo $strrulesapplicab ?>
                     </div>
                  </div>
               </div>
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="clip-stats"></i>
                        List Survey
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">
                        <div id="listsyrveyreport" class="listsyrveyreport">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div id="survedraw" class="tab-pane">
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="clip-stats"></i>
                        List Drawing
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">
                        <div id="surveygambar" class="surveygambar">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div id="survecommneting" class="tab-pane">
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="clip-stats"></i>
                        List Comment
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">
                        <div id="surveycommentasdasd" class="surveycommentasdasd">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <div id="survedonloaddraw" class="tab-pane">
            <div class="row">
               <div class="col-md-12">
                  <div class="panel panel-default">
                     <div class="panel-heading">
                        <i class="clip-stats"></i>
                        List Download Drawing
                        <div class="panel-tools">
                           <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                           </a>
                           <a class="btn btn-xs btn-link panel-refresh" href="#">
                              <i class="fa fa-refresh"></i>
                           </a>
                           <a class="btn btn-xs btn-link panel-close" href="#">
                              <i class="fa fa-times"></i>
                           </a>
                        </div>
                     </div>
                     <div class="panel-body">
                        <div id="donloaddrawingsurvey" class="donloaddrawingsurvey">
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="motong" class="tab-pane">
   <div class="tabbable">
      <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
         <li class="active" id="taboverview" >
            <a data-toggle="tab" href="#inputDrwaing" onclick="getInsertdrawing(<?php echo $projectID ;?>);">
               Input Drawing
            </a>
         </li>
         <li>
            <a data-toggle="tab" href="#downloadreq" onclick="refreshrequestdownload(<?php echo $projectID ;?>);">
               Download Request
            </a>
         </li>
         <li>
            <a data-toggle="tab" href="#commneting" onclick="refreshcommentlist(<?php echo $projectID ;?>);">
               Commenting
            </a>
         </li>
         <li>
            <a data-toggle="tab" href="#uploadstamp" onclick="refreshstamp(<?php echo $projectID ;?>);">
               Stamp Process
            </a>
         </li>
                     <!-- 									<li>
                        <a data-toggle="tab" href="#inputparam"  onclick="RefreshGeneraldata(<?php echo $projectID ;?>);" >
                        	Input param
                        </a>
                     </li> -->


                     <li>
                        <a data-toggle="tab" href="#commentsister" >
                           Sistership Comment
                        </a>
                     </li>

                     <li>
                        <a data-toggle="tab" href="#IPGM" >
                           IPGM
                        </a>
                     </li>   


                     <li>
                        <a  data-toggle='tab' href='#datainput' onclick="$('#datainputtt').tab('show');">
                           Data Input
                        </a>
                     </li>
                     <li>
                        <a data-toggle="tab" href="#approvallettertab" onclick="refreshMail(<?php echo $projectID ;?>);">
                           Approval Letter
                        </a>
                     </li>
                     <?php 
                     $strEnglog="<li>
                     <a data-toggle='tab' href='#enginerlog' onclick='refreslog($projectID );'>
                     Engineering log
                     </a>
                     </li>";	
                     if (in_array(25, $permisionPieace)) {echo $strEnglog;} 
                     ?>
                  </ul>
                  <div class="tab-content">
                     <div id="inputDrwaing" class="tab-pane in active">
                        <div class="row">
                           <div class="col-md-12">
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <i class="clip-stats"></i>
                                    List Drawing
                                    <div class="panel-tools">
                                       <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                       </a>
                                       <a class="btn btn-xs btn-link panel-refresh" href="#">
                                          <i class="fa fa-refresh"></i>
                                       </a>
                                       <a class="btn btn-xs btn-link panel-close" href="#">
                                          <i class="fa fa-times"></i>
                                       </a>
                                    </div>
                                 </div>
                                 <div class="panel-body">
                                    <form role="form" id="uploadgambar"  name="uploadgambar" class="form-horizontal">
                                       <div class="form-group">
                                          <label class="col-sm-2 control-label" for="form-field-1">
                                             Existing drawing
                                          </label>
                                          <div class="col-sm-9">
                                             <input type="checkbox" id="checkbox"name="checkbox" value="checkbox" onchange="terms();" />
                                             Check if Exist
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-sm-2 control-label" for="form-field-1">
                                             Title
                                          </label>
                                          <div class="col-sm-9">
                                             <input type="text" id="textfield" name="textfield"  class="form-control" value=" " />
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-sm-2 control-label" for="form-field-1">
                                             Drawing Number
                                          </label>
                                          <div class="col-sm-9">
                                             <input type="text" name="textfield2" id="textfield2" class="form-control" />
                                             <input type="text" name="textfield3" id="textfield3"style="display:none" class="country" onkeyup="suggestogs(this.value,<?php echo $projectID ;?>);" onblur="fill();"  autocomplete="off"/>
                                             <div class="suggestionsBox" id="suggestions" style="display: none;">
                                                <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
                                             </div>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-sm-2 control-label" for="form-field-2">
                                             Type
                                          </label>
                                          <div class="col-sm-9">
                                             <select name="select" id="tipe" class="form-control">
                                                <?php echo $strtipegmabr ;?>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-sm-2 control-label" for="form-field-3" >
                                             Revisi
                                          </label>
                                          <div class="col-sm-9">
                                             <select name="select2"  class="form-control" required>
                                                <option> </option>
                                                <option value="0">0</option>
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>
                                                <option value="5">5</option>
                                                <option value="6">6</option>
                                                <option value="7">7</option>
                                                <option value="8">8</option>
                                                <option value="9">9</option>
                                                <option value="A">A</option>
                                                <option value="B">B</option>
                                                <option value="C">C</option>
                                                <option value="D">D</option>
                                                <option value="E">E</option>
                                                <option value="F">F</option>
                                                <option value="G">G</option>
                                                <option value="H">H</option>
                                                <option value="I">I</option>
                                                <option value="J">J</option>
                                             </select>
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-sm-2 control-label" for="form-field-4" >
                                             Not E-Drawing
                                          </label>
                                          <div class="col-sm-9">
                                             <input type="checkbox" id= "checkbox2" name="checkbox2" value="checkbox" onclick="no_edraw();"  />
                                             Check if not E-drawing
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-sm-2 control-label" for="form-field-5" >
                                             File, PDF
                                          </label>
                                          <div class="col-sm-9">
                                             <input type="file" name="upload"  class="form-control"/>
                                             <input id="exist" name="exist" type="hidden" value="0"  />
                                             <input id="no_edrawing" name="no_edrawing" type="hidden" value="0" />
                                             <input type="hidden" name="modul" id="modul" value="drawing" readonly="readonly" />
                                             <input type="hidden" name="act" id="act" value="uploadsebiji" readonly="readonly" />
                                             <input type="hidden" name="idkontrak" id="idkontrak" value="<?php echo $projectID ;?>" readonly="readonly" />
                                          </div>
                                       </div>
                                       <div class="form-group">
                                          <label class="col-sm-2 control-label" for="form-field-6">
                                          </label>
                                          <div class="col-sm-9">
                                             <span class="col-sm-9"> </span>	
                                             <div id="rev" class="rev" ></div>
                                          </div>
                                       </div>
                                       <button data-style="expand-right" class="btn btn-teal ladda-button"  type="submit" >
                                          <span class="ladda-label"> Start upload </span>
                                          <i class="fa fa-arrow-circle-right"></i>
                                          <span class="ladda-spinner"></span>
                                          <span class="ladda-spinner"></span>
                                          <div style="width: 0px;" class="ladda-progress"></div>
                                       </button>
                                    </form>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="row">
                           <div class="col-md-12">
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <i class="clip-stats"></i>
                                    List Drawing
                                    <div class="panel-tools">
                                       <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                       </a>
                                       <a class="btn btn-xs btn-link panel-refresh" href="#">
                                          <i class="fa fa-refresh"></i>
                                       </a>
                                       <a class="btn btn-xs btn-link panel-close" href="#">
                                          <i class="fa fa-times"></i>
                                       </a>
                                    </div>
                                 </div>
                                 <div class="panel-body">
                                    <div id="listgambar" class="listgambar">
                                       <div id="isiinputdrawing" class="isiinputdrawing">Loading </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div id="commneting" class="tab-pane" >
                        <div class="row">
                           <div class="col-md-8">
                              <div class="panel panel-default">
                                 <div class="panel-heading">
                                    <i class="clip-stats"></i>
                                    Input Comment 
                                    <div class="panel-tools">
                                       <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                       </a>
                                       <a class="btn btn-xs btn-link panel-refresh" href="#">
                                          <i class="fa fa-refresh"></i>
                                       </a>
                                       <a class="btn btn-xs btn-link panel-close" href="#">
                                          <i class="fa fa-times"></i>
                                       </a>
                                    </div>
                                 </div>
                                 <div class="panel-body">
                                    <form role="form" class="form-horizontal">
                                       <div class="form-group">
                                          <label class="col-sm-2 control-label" for="form-field-1">
                                             Type
                                          </label>
                                          <div class="col-sm-9">
                                             <select name="select" class="col-sm-2 form-control" id="select" onchange="reset_change_tipe();"><?php echo $drawing_list ; ?>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="form-group">
                                       <label class="col-sm-2 control-label" for="form-field-1">
                                          Drawing no / Title
                                       </label>
                                       <div class="col-sm-9">
                                          <input type="text" name="textfield3" id="textfield3" class="countryy" onkeyup="suggestgambarcomment(this.value,<?php echo $projectID . ", " . intval(2);?>);" onblur="fill();"  autocomplete="off" />
                                          <div class="suggestionscomment" id="suggestionscomment" style="display: none;"></div>
                                          <div class="suggestionsListcomment" id="suggestionsListcomment"></div>
                                          <div id="append" name="append"></div>
                                       </div>
                                    </div>
<!--                                        <div class="form-group">
                                          <label class="col-sm-2 control-label" for="form-field-1">
                                          Type Info
                                          </label>
                                          <div class="col-sm-9"> -->
                                             <input type="hidden" id="commentcekbook" name="commentcekbook" > 
<!--                                           </div>
</div> -->

<div class="form-group">
   <label class="col-sm-2 control-label" for="form-field-1">
      Type Comment
   </label>
   <div class="col-sm-9">
      <select name="typekategory" id="typekategory"  class="form-control" required>
         <option value="0">To be dealt with</option>
         <option value="1">Accepted</option>
         <option value="2">To be re-submited</option>
         <option value="3">Note</option>
      </select>
   </div>
</div>

<div class="form-group">
   <label class="col-sm-2 control-label" for="form-field-1">
      Comment <br>
      [for inserting newline please used  &lt;br&gt;]
   </label>
   <div class="col-sm-9">
      <textarea name="textarea" cols="70" rows="15" id="coment"></textarea>
      <input name="objek_array" type="hidden" id="objek_array" />
      <input name="update_obj" id="update_obj" type="hidden" value="" />
   </div>
</div>
<p><a class="btn btn-blue" onclick="fung_add_comment(<?php echo intval ($_GET['idproj']);?>);"><i class="fa fa-plus"></i>Submit Entry</a>
</form>
</div>
</div>
</div>
<div class="col-md-4">
   <div class="panel panel-default">
      <div class="panel-heading">
         <i class="clip-stats"></i>
         Task Drawing
         <div class="panel-tools">
            <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
            </a>
            <a class="btn btn-xs btn-link panel-refresh" href="#">
               <i class="fa fa-refresh"></i>
            </a>
            <a class="btn btn-xs btn-link panel-close" href="#">
               <i class="fa fa-times"></i>
            </a>
         </div>
      </div>
      <div class="panel-body">                        
         <div id="lisdrawingTaskuser" class="lisdrawingTaskuser"></div>
      </div>
   </div>
</div>    
<div class="col-md-4">
   <div class="panel panel-default">
      <div class="panel-heading">
         <i class="clip-stats"></i>
         Applicable Rules
         <div class="panel-tools">
            <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
            </a>
            <a class="btn btn-xs btn-link panel-refresh" href="#">
               <i class="fa fa-refresh"></i>
            </a>
            <a class="btn btn-xs btn-link panel-close" href="#">
               <i class="fa fa-times"></i>
            </a>
         </div>
      </div>
      <div class="panel-body">								
         <?php echo $strlistrules ?>
      </div>
   </div>
</div>

</div>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <i class="clip-stats"></i>
            List Comment
            <div class="panel-tools">
               <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
               </a>
               <a class="btn btn-xs btn-link panel-refresh" href="#">
                  <i class="fa fa-refresh"></i>
               </a>
               <a class="btn btn-xs btn-link panel-close" href="#">
                  <i class="fa fa-times"></i>
               </a>
            </div>
         </div>
         <div class="panel-body">
            <button type="button" class="btn btn-success btn-squared btn-md" href='#' onclick='openSummary(<?php echo  $projectID ;?>);'>
               Summary Comment
            </button>
            <hr>
            <div id="isicommneting" class="isicommneting">Loading </div>
         </div>
      </div>
   </div>
</div>
</div>



<div id="commentsister" class="tab-pane" >
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               view comment sister ships
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <form role="form" id="uploadmatkom"  name="uploadmatkom" class="form-horizontal">
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Contract number
                     </label>
                     <div class="col-sm-9">
                        <select id="contractsisternum" class="form-control" onchange="getCommentsister();" >
                           <option value='' ></option>
                           <?php echo $strCombosister ;?>
                        </select>
                     </div>
                  </div>
               </form>
               <br>
               <br>
               <hr>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               List of Comment
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <div id="listcommentsister" class="listcommentsister"> loading... </div>
            </div>
         </div>
      </div>
   </div>
</div>



<div id="IPGM" class="tab-pane" >
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               Instruksi Pemasangan Garis Muat
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">

               <div class="col-md-12">
                  <iframe src="https://armada.bki.co.id/modul/mod_drawing/freeboard_mobile.php?noapl=<?php echo $contract?>" width="100%" height="700px"></iframe> 
               </div>

               <br>
               <br>
               <hr>
            </div>
         </div>
      </div>
   </div>
</div>

<div id="approvallettertab" class="tab-pane" >
   <div class="row">
      <div class="col-md-4">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               Letter
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <div class="list-mail" id="list-mail"></div>
            </div>
         </div>
      </div>
      <div class="col-md-8">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               Page Letter
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">                        
               <div id="mail-panel">
                  <input id='mail-id' type= 'hidden'>
                  <iframe id='mail-content' width='100%' height='700px'></iframe>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>



<div id="enginerlog" class="tab-pane" >
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               List Log 
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <div id="englogg" class="englogg">loading </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="downloadreq" class="tab-pane" >
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               List Drawing
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1">
                     Type
                  </label>
                  <div class="col-sm-5">
                     <select name="tipegambar" class="col-sm-2 form-control" id="changegambarload" onchange="changegambarload(<?php echo $projectID;?>);">
                        <option value='0'></option>
                        <?php echo $drawing_list ; ?>
                     </select>
                  </div>
               </div>
               <br>
               <br>
               <hr>
               <div id="listdrawing" class="listdrawing">Loading </div>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               List download request
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <div id="ididownloadrequest" class="ididownloadrequest"> Loading </div>
            </div>
         </div>
      </div>
   </div>
</div>
<div id="uploadstamp"  class="tab-pane" >
   <div class="row">
      <div class="col-md-8">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               Upload Stamp
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <form role="form" id="uploadStamp"  name="uploadStamp" class="form-horizontal">
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Type
                     </label>
                     <div class="col-sm-5">
                        <select name="tipegambarstamp" class="col-sm-2 form-control" id="tipegambarstamp">
                           <option value='0'></option>
                           <?php echo $drawing_list ; ?>
                        </select>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Drawing No. / Title
                     </label>
                     <div class="col-sm-9">
                        <input type="text" id="textfielddrawingnumber" name="textfielddrawingnumber" class="countryyrrttt form-control" autocomplete=off onkeyup="suggestgambar(this.value,<?php echo $projectID;?>);">
                        <div class="suggestionsListgambar" id="suggestionsListgambar"></div>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Title
                     </label>
                     <div class="col-sm-9">
                        <input type="text" id="judulstamp" name="judulstamp" class="form-control" readonly>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Revisi
                     </label>
                     <div class="col-sm-3">
                        <input type="text" id="revgam" name="revgam" class="form-control" readonly>
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        File
                     </label>
                     <div class="col-sm-9">
                        <input type="file" name="upload" class="form-control">
                        <input id="no_edrawinggg" name="no_edrawinggg" type="hidden" value="0" />
                        <input type="hidden" name="idkontrak" id="idkontrak" value="<?php echo $projectID ;?>" readonly="readonly">
                        <input type="hidden" name="act" id="act" value="add" readonly="readonly">
                        <input type="hidden" name="modul" id="modul" value="uploadstamp" readonly="readonly">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Status
                     </label>
                     <div class="col-sm-9">
                        <select name="tipeApprovaldrawing" class="col-sm-2 form-control" id="tipeApprovaldrawing">
                           <?php 
                           foreach ($listTypeaaprovals as $listTypeaaproval) {
                             echo "<option value='$listTypeaaproval[id_status]'>[$listTypeaaproval[code]] $listTypeaaproval[desck]</option>";
                          }
                          
                          ?>
                       </select>
                    </div>
                 </div>
                 <button data-style="expand-right" class="btn btn-teal ladda-button" type="submit">
                  <span class="ladda-label"> Start upload </span>
                  <i class="fa fa-arrow-circle-right"></i>
                  <span class="ladda-spinner"></span>
                  <span class="ladda-spinner"></span>
                  <div style="width: 0px;" class="ladda-progress"></div>
                  <span class="ladda-spinner"></span>
               </button>
            </form>
            <br>
            <br>
            <hr>
         </div>
      </div>
   </div>

   <div class="col-md-4">
      <div class="panel panel-default">
         <div class="panel-heading">
            <i class="clip-stats"></i>
            Task Drawing
            <div class="panel-tools">
               <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
               </a>
               <a class="btn btn-xs btn-link panel-refresh" href="#">
                  <i class="fa fa-refresh"></i>
               </a>
               <a class="btn btn-xs btn-link panel-close" href="#">
                  <i class="fa fa-times"></i>
               </a>
            </div>
         </div>
         <div class="panel-body">                        
            <div id="lisdrawingTaskuseruplodstamp" class="lisdrawingTaskuseruplodstamp"></div>
         </div>
      </div>
   </div> 

</div>
<div class="row">
   <div class="col-md-12">
      <div class="panel panel-default">
         <div class="panel-heading">
            <i class="clip-stats"></i>
            List upload Stamp
            <div class="panel-tools">
               <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
               </a>
               <a class="btn btn-xs btn-link panel-refresh" href="#">
                  <i class="fa fa-refresh"></i>
               </a>
               <a class="btn btn-xs btn-link panel-close" href="#">
                  <i class="fa fa-times"></i>
               </a>
            </div>
         </div>
         <div class="panel-body">
            <div id="isiuploadstamp" class="isiuploadstamp"> loading </div>
         </div>
      </div>
   </div>
</div>
</div>
<div id="inputparam"  class="tab-pane" >
   <div class="row">
      <div class="col-md-12">
         <div class="panel panel-default">
            <div class="panel-heading">
               <i class="clip-stats"></i>
               Input parameter
               <div class="panel-tools">
                  <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                  </a>
                  <a class="btn btn-xs btn-link panel-refresh" href="#">
                     <i class="fa fa-refresh"></i>
                  </a>
                  <a class="btn btn-xs btn-link panel-close" href="#">
                     <i class="fa fa-times"></i>
                  </a>
               </div>
            </div>
            <div class="panel-body">
               <form role="form" class="form-horizontal">
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Designation
                     </label>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Class notation
                     </label>
                     <div class="col-sm-9">
                        <input type="text"  id="param_notation" value="<?php echo $classnot;?>" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label">
                        Official Register Number
                     </label>
                     <div class="col-sm-2">
                        <input type="text"  id="param_ofreg" value="<?php echo $ofregnum;?>" class="form-control">
                     </div>
                     <label class="col-sm-2 control-label">
                        Call sign
                     </label>											
                     <div class="col-sm-2">
                        <input type="text"  id="param_callsign" value="<?php echo $callsign;?>" class="form-control">
                     </div>
                     <label class="col-sm-2 control-label">
                        Flag name
                     </label>											
                     <div class="col-sm-2">
                        <input type="text"  id="param_flagname" value="<?php echo $flag;?>" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label">
                        Port of registration
                     </label>
                     <div class="col-sm-2">
                        <input type="text"  id="param_port" value="<?php echo $portre;?>" class="form-control">
                     </div>
                     <label class="col-sm-2 control-label">
                        Date of Registration
                     </label>											
                     <div class="col-sm-2">
                        <input type="text" value="<?php echo $datereg;?>" data-date-format="dd-mm-yyyy" id="param_datereg" data-date-viewmode="years" class="form-control date-picker">
                     </div>
                     <label class="col-sm-2 control-label">
                        Keel laying date
                     </label>											
                     <div class="col-sm-2">
                        <input type="text" value="<?php echo $kellaying;?>" data-date-format="dd-mm-yyyy" id="param_kelllaying" data-date-viewmode="years" class="form-control date-picker">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label">
                        Delivery Date
                     </label>
                     <div class="col-sm-2">
                        <input type="text" value="<?php echo $deliverydate;?>" data-date-format="dd-mm-yyyy" id="param_delivery" data-date-viewmode="years" class="form-control date-picker">
                     </div>
                     <label class="col-sm-2 control-label">
                        Solas Category
                     </label>											
                     <div class="col-sm-2">
                        <input type="text"  value="<?php echo $solas;?>" id="param_solas" class="form-control">
                     </div>
                     <label class="col-sm-2 control-label">
                        Marpol Category
                     </label>											
                     <div class="col-sm-2">
                        <input type="text" value="<?php echo $marpolkat;?>" id="param_marpol" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label">
                        IBC IGC Category
                     </label>
                     <div class="col-sm-2">
                        <input type="text" value="<?php echo $ibc;?>" id="param_ibc" class="form-control">
                     </div>
                     <label class="col-sm-2 control-label">
                        ISM Category
                     </label>											
                     <div class="col-sm-2">
                        <input type="text"  value="<?php echo $ism;?>" id="param_ism" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Principal characteristics
                     </label>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label">
                        Design Deadweight(ton)
                     </label>
                     <div class="col-sm-2">
                        <input type="text"   value="<?php echo $Ddwt;?>" id="param_Ddwt" class="form-control">
                     </div>
                     <label class="col-sm-2 control-label">
                        LPP(M)
                     </label>											
                     <div class="col-sm-2">
                        <input type="text"   value="<?php echo $lpp;?>" id="param_lpp" class="form-control">
                     </div>
                     <label class="col-sm-2 control-label">
                        Moulded breadth(M)
                     </label>											
                     <div class="col-sm-2">
                        <input type="text"  value="<?php echo $breadt;?>" id="param_b" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label">
                        Moulded depth(M)
                     </label>
                     <div class="col-sm-2">
                        <input type="text"  value="<?php echo $depth;?>" id="param_depth" class="form-control">
                     </div>
                     <label class="col-sm-2 control-label">
                        Bulb length from FP(M)
                     </label>											
                     <div class="col-sm-2">
                        <input type="text" value="<?php echo $bulb;?>" id="param_fp" class="form-control">
                     </div>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label" for="form-field-1">
                        Loading Application and Manual/reference
                     </label>
                  </div>
                  <div class="form-group">
                     <label class="col-sm-2 control-label">
                        Loading Instrument
                     </label>
                     <div class="col-sm-2">
                        <select id="param_loading" class="form-control">
                           <?php echo $strloading ;?>
                           <option value="0">No</option>
                           <option value="1">yes</option>
                        </select>
                     </div>
                     <label class="col-sm-2 control-label">
                        Trim and stabilty Booklet
                     </label>											
                     <div class="col-sm-2">
                        <select id="param_stability" class="form-control">
                           <?php echo $strtrimbook ;?>
                           <option value="0">No</option>
                           <option value="1">Yes</option>
                        </select>
                     </div>
                  </div>
                  <button type="button" class="btn btn-green" onclick="updateproject(<?php echo $projectID;?>);">
                     Update
                  </button>										
               </form>
               <div id="updateprojectt" class="updateprojectt" ></div>
               <hr>
               <h4><a  onclick="RefreshPerjenis(<?php echo $projectID;?>,1,'previousname');">Previous Name</a>  </h4>
               <div class="form-group">
                  <label class="col-sm-2 control-label">
                     <button type="button" class="btn btn-success" onClick="addtype1(<?php echo $projectID;?>);">
                        add
                     </button>  &nbsp; 
                  </label>
                  <div class="col-sm-3">
                     <input type="text" placeholder="Previous Name" id="prevname_param1" class="form-control">
                  </div>
                  <div class="col-sm-2">
                     <input type="text" placeholder="From date" id="prevname_param2" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker">
                  </div>
                  <div class="col-sm-2">
                     <input type="text" placeholder="To date" id="prevname_param3" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker">
                  </div>
               </div>
               <div id="previousname" class="previousname"></div>
               <P>
                  <br>
                  <hr>
                  <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,2,'previousflag');">Previous Flag </a></h4>
                  <div class="form-group">
                     <label class="col-sm-2 control-label">
                        <button type="button" class="btn btn-success" onClick="addtype2(<?php echo $projectID;?>);">
                           add
                        </button>  &nbsp; 
                     </label>
                     <div class="col-sm-2">
                        <input type="text" placeholder="Previous Flag" id="prevflag_param1" class="form-control">
                     </div>
                     <div class="col-sm-2">
                        <input placeholder="From date" id="prevflag_param2" type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker">
                     </div>
                     <div class="col-sm-2">
                        <input type="text" placeholder="To Date" id="prevflag_param3" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker">
                     </div>
                     <div class="col-sm-2">
                        <input type="text" placeholder="Port Name" id="prevflag_param4" class="form-control">
                     </div>
                  </div>
                  <br>
                  <p><br>
                     <div id="previousflag" class="previousflag"></div>
                     <P>
                        <br>
                        <hr>
                        <h4><a  onclick="RefreshPerjenis(<?php echo $projectID;?>,3,'stateinformation');">State Information</a> </h4>
                        <div class="form-group">
                           <label class="col-sm-2 control-label">
                              <button type="button" class="btn btn-success" onClick="addtype3(<?php echo $projectID;?>);">
                                 add
                              </button>  &nbsp; 
                           </label>
                           <div class="col-sm-3">
                              <input type="text" placeholder="State Information ex:`class state`" id="state_param1" class="form-control">
                           </div>
                           <div class="col-sm-3">
                              <input type="text" placeholder="Condition ex:`classed`" id="state_param2" class="form-control">
                           </div>
                           <div class="col-sm-2">
                              <input type="text" placeholder="date" id="state_param3" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker">
                           </div>
                        </div>
                        <br>
                        <p><br>
                           <div id="stateinformation" class="stateinformation"></div>
                           <P>
                              <br>
                              <hr>
                              <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,4,'anchoeequipment');">Anchor Equipment</a> </h4>
                              <div class="form-group">
                                 <label class="col-sm-2 control-label">
                                    <button type="button" class="btn btn-success" onClick="addtype4(<?php echo $projectID;?>);">
                                       add
                                    </button>  &nbsp; 
                                 </label>
                                 <div class="col-sm-2">
                                    <input type="text" placeholder="Item ex:`equipment numeral`" id="anchor_param1" class="form-control">
                                 </div>
                                 <div class="col-sm-2">
                                    <input type="text" placeholder="type ex:`U-49`" id="anchor_param2" class="form-control">
                                 </div>
                              </div>
                              <br>
                              <p><br>
                                 <div id="anchoeequipment" class="anchoeequipment"></div>
                                 <P>			<br>
                                    <hr>
                                    <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,5,'otherinfo');"> Other Info</a> </h4>
                                    <div class="form-group">
                                       <label class="col-sm-2 control-label">
                                          <button type="button" class="btn btn-success" onClick="addtype5(<?php echo $projectID;?>);">
                                             add
                                          </button>  &nbsp; 
                                       </label>
                                       <div class="col-sm-2">
                                          <input type="text" placeholder="Item" id="other_param1" class="form-control">
                                       </div>
                                       <div class="col-sm-2">
                                          <input type="text" placeholder="Status" id="other_param2" class="form-control">
                                       </div>
                                    </div>
                                    <br>
                                    <p><br>
                                       <div id="otherinfo" class="otherinfo"></div>
                                       <P>			<br>
                                          <hr>
                                          <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,6,'tonagee');"> Tonnage </a></h4>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label">
                                                <button type="button" class="btn btn-success" onClick="addtype6(<?php echo $projectID;?>);">
                                                   add
                                                </button>  &nbsp; 
                                             </label>
                                             <div class="col-sm-2">
                                                <input type="text" placeholder="Regulation" id="tonnage_param1" class="form-control">
                                             </div>
                                             <div class="col-sm-2">
                                                <input type="text" placeholder="Gross Tonnage" id="tonnage_param2" class="form-control">
                                             </div>
                                             <div class="col-sm-2">
                                                <input type="text" placeholder="Net Tonnage" id="tonnage_param3" class="form-control">
                                             </div>
                                          </div>
                                          <br>
                                          <p><br>
                                             <div id="tonagee" class="tonagee"></div>
                                             <P>			
                                                <br>
                                                <hr>
                                                <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,7,'builder');">Builder</a> </h4>
                                                <div class="form-group">
                                                   <label class="col-sm-2 control-label">
                                                      <button type="button" class="btn btn-success" onClick="addtype7(<?php echo $projectID;?>);">
                                                         add
                                                      </button>  &nbsp; 
                                                   </label>
                                                   <div class="col-sm-2">
                                                      <input type="text" placeholder="Builder" id="builder_param1" class="form-control">
                                                   </div>
                                                   <div class="col-sm-2">
                                                      <input type="text" placeholder="Builder Bulding ID" id="builder_param2" class="form-control">
                                                   </div>
                                                   <div class="col-sm-2">
                                                      <input type="text" placeholder="Building role" id="builder_param3" class="form-control">
                                                   </div>
                                                   <div class="col-sm-2">
                                                      <input type="text" placeholder="Project description" id="builder_param4" class="form-control">
                                                   </div>
                                                   <div class="col-sm-2">
                                                      <input type="text" placeholder="Contracttual Responsibility" id="builder_param5" class="form-control">
                                                   </div>
                                                </div>
                                                <br>
                                                <p><br>
                                                   <div class="form-group">
                                                      <label class="col-sm-2 control-label">
                                                      </label>
                                                      <div class="col-sm-2">
                                                         <input type="text" placeholder="Contracttual date" id="builder_param6" class="form-control">
                                                      </div>
                                                   </div>
                                                   <div id="builder" class="builder"></div>
                                                   <P>			
                                                      <br>
                                                      <hr>
                                                      <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,8,'iacsunified');">IACS unified Requirements Information </a></h4>
                                                      <div class="form-group">
                                                         <label class="col-sm-2 control-label">
                                                            <button type="button" class="btn btn-success" onClick="addtype8(<?php echo $projectID;?>);">
                                                               add
                                                            </button>  &nbsp; 
                                                         </label>
                                                         <div class="col-sm-2">
                                                            <input type="text" placeholder="IACS UR" id="iacs_param1" class="form-control">
                                                         </div>
                                                      </div>
                                                      <div id="iacsunified" class="iacsunified"></div>
                                                      <P>			
                                                         <br>
                                                         <hr>
                                                         <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,9,'imorequirement');">IMO Requirement Information</a> </h4>
                                                         <div class="form-group">
                                                            <label class="col-sm-2 control-label">
                                                               <button type="button" class="btn btn-success" onClick="addtype9(<?php echo $projectID;?>);">
                                                                  add
                                                               </button>  &nbsp; 
                                                            </label>
                                                            <div class="col-sm-2">
                                                               <input type="text" placeholder="IMO Requirement" id="imo_param1" class="form-control">
                                                            </div>
                                                         </div>
                                                         <div id="imorequirement" class="imorequirement"></div>
                                                         <P>			
                                                            <br>
                                                            <hr>
                                                            <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,10,'freeboardassigment');">Freeboard Assignments</a> </h4>
                                                            <div class="form-group">
                                                               <label class="col-sm-2 control-label">
                                                                  <button type="button" class="btn btn-success" onClick="addtype10(<?php echo $projectID;?>);">
                                                                     add
                                                                  </button>  &nbsp; 
                                                               </label>
                                                               <div class="col-sm-2">
                                                                  <input type="text" placeholder="Freeboard" id="freeoard_param1" class="form-control">
                                                               </div>
                                                               <div class="col-sm-2">
                                                                  <input type="text" placeholder="Displacement" id="freeoard_param2" class="form-control">
                                                               </div>
                                                               <div class="col-sm-2">
                                                                  <input type="text" placeholder="Deadweight" id="freeoard_param3" class="form-control">
                                                               </div>
                                                               <div class="col-sm-2">
                                                                  <input type="text" placeholder="Calculated" id="freeoard_param4" class="form-control">
                                                               </div>
                                                               <div class="col-sm-2">
                                                                  <input type="text" placeholder="State" id="freeoard_param5" class="form-control">
                                                               </div>
                                                            </div>
                                                            <div id="freeboardassigment" class="freeboardassigment"></div>
                                                            <P>			
                                                               <br>
                                                               <hr>
                                                               <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,11,'material');">Material</a> </h4>
                                                               <div class="form-group">
                                                                  <label class="col-sm-2 control-label">
                                                                     <button type="button" class="btn btn-success" onClick="addtype11(<?php echo $projectID;?>);">
                                                                        add
                                                                     </button>  &nbsp; 
                                                                  </label>
                                                                  <div class="col-sm-3">
                                                                     <input type="text" placeholder="Type" id="material_param1" class="form-control">
                                                                  </div>
                                                                  <div class="col-sm-2">
                                                                     <input type="text" placeholder="Primary(yes/no)" id="material_param2" class="form-control">
                                                                  </div>
                                                                  <div class="col-sm-5">
                                                                     <input type="text" placeholder="location" id="material_param3" class="form-control">
                                                                  </div>
                                                               </div>
                                                               <div id="material" class="material"></div>
                                                               <P>			
                                                                  <br>
                                                                  <hr>
                                                                  <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,12,'styfennersystem');">Stiffener System</a> </h4>
                                                                  <div class="form-group">
                                                                     <label class="col-sm-2 control-label">
                                                                        <button type="button" class="btn btn-success" onClick="addtype12(<?php echo $projectID;?>);">
                                                                           add
                                                                        </button>  &nbsp; 
                                                                     </label>
                                                                     <div class="col-sm-3">
                                                                        <input type="text" placeholder="Location ex: `on deck`" id="stifener_param1" class="form-control">
                                                                     </div>
                                                                     <div class="col-sm-3">
                                                                        <input type="text" placeholder="type ex: `longitudinal`" id="stifener_param2" class="form-control">
                                                                     </div>
                                                                  </div>
                                                                  <div id="styfennersystem" class="styfennersystem"></div>
                                                                  <P>			
                                                                     <br>
                                                                     <hr>
                                                                     <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,13,'bulkheadsystem');">Bulkhead</a> </h4>
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label">
                                                                           <button type="button" class="btn btn-success" onClick="addtype13(<?php echo $projectID;?>);">
                                                                              add
                                                                           </button>  &nbsp; 
                                                                        </label>
                                                                        <div class="col-sm-3">
                                                                           <input type="text" placeholder="Type ex:`water tight`" id="bulkhead_param1" class="form-control">
                                                                        </div>
                                                                        <div class="col-sm-2">
                                                                           <input type="text" placeholder="Number" id="bulkhead_param2" class="form-control">
                                                                        </div>
                                                                     </div>
                                                                     <div id="bulkheadsystem" class="bulkheadsystem"></div>
                                                                     <P>			
                                                                        <br>
                                                                        <hr>
                                                                        <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,14,'tanki');">Tank</a> </h4>
                                                                        <div class="form-group">
                                                                           <label class="col-sm-2 control-label">
                                                                              <button type="button" class="btn btn-success" onClick="addtype14(<?php echo $projectID;?>);">
                                                                                 add
                                                                              </button>  &nbsp; 
                                                                           </label>
                                                                           <div class="col-sm-3">
                                                                              <input type="text" placeholder="Type ex:`cargo oil`" id="tank_param1" class="form-control">
                                                                           </div>
                                                                           <div class="col-sm-2">
                                                                              <input type="text" placeholder="Number" id="tank_param2" class="form-control">
                                                                           </div>
                                                                        </div>
                                                                        <div id="tanki" class="tanki"></div>
                                                                        <P>			
                                                                           <br>
                                                                           <hr>
                                                                           <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,15,'maipropulsion');">Main propulsion</a></h4>
                                                                           <div class="form-group">
                                                                              <label class="col-sm-2 control-label">
                                                                                 <button type="button" class="btn btn-success" onClick="addtype15(<?php echo $projectID;?>);">
                                                                                    add
                                                                                 </button>  &nbsp; 
                                                                              </label>
                                                                              <div class="col-sm-2">
                                                                                 <input type="text" placeholder="manufacture" id="mainprop_param1" class="form-control">
                                                                              </div>
                                                                              <div class="col-sm-2">
                                                                                 <input type="text" placeholder="Type ex:`diesel engine`" id="mainprop_param2" class="form-control">
                                                                              </div>
                                                                              <div class="col-sm-1">
                                                                                 <input type="text" placeholder="Rating(KW)" id="mainprop_param3" class="form-control">
                                                                              </div>
                                                                              <div class="col-sm-1">
                                                                                 <input type="text" placeholder="Model" id="mainprop_param4" class="form-control">
                                                                              </div>
                                                                              <div class="col-sm-4">
                                                                                 <input type="text" placeholder="Detail spec" id="mainprop_param5" class="form-control">
                                                                              </div>
                                                                           </div>
                                                                           <div id="maipropulsion" class="maipropulsion"></div>
                                                                           <P>			
                                                                              <br>
                                                                              <hr>
                                                                              <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,16,'propulsor');">Propulsor</a></h4>
                                                                              <div class="form-group">
                                                                                 <label class="col-sm-2 control-label">
                                                                                    <button type="button" class="btn btn-success" onClick="addtype16(<?php echo $projectID;?>);">
                                                                                       add
                                                                                    </button>  &nbsp; 
                                                                                 </label>
                                                                                 <div class="col-sm-2">
                                                                                    <input type="text" placeholder="Item" id="propulsor_param1" class="form-control">
                                                                                 </div>
                                                                                 <div class="col-sm-2">
                                                                                    <input type="text" placeholder="Type ex:`propeller`" id="propulsor_param2" class="form-control">
                                                                                 </div>
                                                                                 <div class="col-sm-4">
                                                                                    <input type="text" placeholder="Detail spec" id="propulsor_param3" class="form-control">
                                                                                 </div>
                                                                              </div>
                                                                              <div id="propulsor" class="propulsor"></div>
                                                                              <P>			
                                                                                 <br>
                                                                                 <hr>
                                                                                 <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,17,'shafting');">Shafting</a></h4>
                                                                                 <div class="form-group">
                                                                                    <label class="col-sm-2 control-label">
                                                                                       <button type="button" class="btn btn-success" onClick="addtype17(<?php echo $projectID;?>);">
                                                                                          add
                                                                                       </button>  &nbsp; 
                                                                                    </label>
                                                                                    <div class="col-sm-2">
                                                                                       <input type="text" placeholder="Item" id="shafting_param1" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-sm-2">
                                                                                       <input type="text" placeholder="Material" id="shafting_param2" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-sm-2">
                                                                                       <input type="text" placeholder="Lubrication" id="shafting_param3" class="form-control">
                                                                                    </div>
                                                                                    <div class="col-sm-3">
                                                                                       <input type="text" placeholder="Detail and acccesoris" id="shafting_param4" class="form-control">
                                                                                    </div>
                                                                                 </div>
                                                                                 <div id="shafting" class="shafting"></div>
                                                                                 <P>			
                                                                                    <br>
                                                                                    <hr>
                                                                                    <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,18,'pipingsystem');">System Piping System </a></h4>
                                                                                    <div class="form-group">
                                                                                       <label class="col-sm-2 control-label">
                                                                                          <button type="button" class="btn btn-success" onClick="addtype18(<?php echo $projectID;?>);">
                                                                                             add
                                                                                          </button>  &nbsp; 
                                                                                       </label>
                                                                                       <div class="col-sm-3">
                                                                                          <input type="text" placeholder="Item ex:`aux waste boiler`" id="piping_param1" class="form-control">
                                                                                       </div>
                                                                                    </div>
                                                                                    <div id="pipingsystem" class="pipingsystem"></div>
                                                                                    <P>			
                                                                                       <br>
                                                                                       <hr>
                                                                                       <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,19,'mainpower');">Main Power Distribution System</a></h4>
                                                                                       <div class="form-group">
                                                                                          <label class="col-sm-2 control-label">
                                                                                             <button type="button" class="btn btn-success" onClick="addtype19(<?php echo $projectID;?>);">
                                                                                                add
                                                                                             </button>  &nbsp; 
                                                                                          </label>
                                                                                          <div class="col-sm-3">
                                                                                             <input type="text" placeholder="Item name ex: `aux gen no.1`" id="powerdist_param1" class="form-control">
                                                                                          </div>
                                                                                          <div class="col-sm-2">
                                                                                             <input type="text" placeholder="Rated Power(KW)" id="powerdist_param2" class="form-control">
                                                                                          </div>
                                                                                       </div>
                                                                                       <div id="mainpower" class="mainpower"></div>
                                                                                       <P>			
                                                                                          <br>
                                                                                          <hr>
                                                                                          <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,20,'capacitytank');">Capacity</a></h4>
                                                                                          <div class="form-group">
                                                                                             <label class="col-sm-2 control-label">
                                                                                                <button type="button" class="btn btn-success" onClick="addtype20(<?php echo $projectID;?>);">
                                                                                                   add
                                                                                                </button>  &nbsp; 
                                                                                             </label>
                                                                                             <div class="col-sm-3">
                                                                                                <input type="text" placeholder="Compartement capacity" id="capacity_param1" class="form-control">
                                                                                             </div>
                                                                                             <div class="col-sm-3">
                                                                                                <input type="text" placeholder="Volume 100% Full(CuM)" id="capacity_param2" class="form-control">
                                                                                             </div>
                                                                                             <div class="col-sm-3">
                                                                                                <input type="text" placeholder="Weight 100% Full(ton)" id="capacity_param3" class="form-control">
                                                                                             </div>
                                                                                          </div>
                                                                                          <div id="capacitytank" class="capacitytank"></div>
                                                                                          <P>			
                                                                                             <br>
                                                                                             <hr>
                                                                                             <h4><a onclick="RefreshPerjenis(<?php echo $projectID;?>,21,'liftingequipment');">Lifting Equipment</a></h4>
                                                                                             <div class="form-group">
                                                                                                <label class="col-sm-2 control-label">
                                                                                                   <button type="button" class="btn btn-success" onClick="addtype21(<?php echo $projectID;?>);">
                                                                                                      add
                                                                                                   </button>  &nbsp; 
                                                                                                </label>
                                                                                                <div class="col-sm-2">
                                                                                                   <input type="text" placeholder="Item" id="liftingeq_param1" class="form-control">
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                   <input type="text" placeholder="Model No" id="liftingeq_param2" class="form-control">
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                   <input type="text" placeholder="Manufacture" id="liftingeq_param3" class="form-control">
                                                                                                </div>
                                                                                                <div class="col-sm-2">
                                                                                                   <input type="text" placeholder="Manufacture number" id="liftingeq_param4" class="form-control">
                                                                                                </div>
                                                                                                <div class="col-sm-1">
                                                                                                   <input type="text" placeholder="SWL" id="liftingeq_param5" class="form-control">
                                                                                                </div>
                                                                                             </div>
                                                                                             <div id="liftingequipment" class="liftingequipment"></div>
                                                                                          </div>
                                                                                       </div>
                                                                                    </div>
                                                                                 </div>
                                                                              </div>
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                     <div id="managerrr" class="tab-pane">
                                                                        <div class="tabbable">
                                                                           <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                                                                              <li class="active" id="taboverview" >
                                                                                 <a data-toggle="tab" href="#managernm" onclick="refreshmoderation(<?php echo $projectID;?>);">
                                                                                    Moderation
                                                                                 </a>
                                                                              </li>
                                                                              <li>
                                                                                 <a data-toggle="tab" href="#drawmanagemt" onclick="RefresDrawingTask(<?php echo $projectID;?>);">
                                                                                    Drawing Task Management
                                                                                 </a>
                                                                              </li>
                                                                              <li>
                                                                                 <a data-toggle="tab" href="#engperformance" onclick="reFreshDashboarPerformance(<?php echo $projectID;?>);">
                                                                                    Performance
                                                                                 </a>
                                                                              </li>
                                                                              <li>
                                                                                 <a data-toggle="tab" href="#docrequestmanager" onclick="RefresDocumenRequestManager(<?php echo $projectID;?>);">
                                                                                    Document Request
                                                                                 </a>
                                                                              </li>                    
                                                                           </ul>
                                                                           <div class="tab-content">
                                                                              <div id="managernm" class="tab-pane in active">
                                                                                 <div class="row">
                                                                                  
                                                                                    <div class="col-md-12">
                                                                                       <hr>
                                                                                    </hr>
                                                                                    <center><h2> Comment Moderation</h2></center>
                                                                                    <div class="panel panel-default">
                                                                                       <div class="panel-heading">
                                                                                          <i class="clip-stats"></i>
                                                                                          List Comment moderation
                                                                                          <div class="panel-tools">
                                                                                             <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                                             </a>
                                                                                             <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                                                <i class="fa fa-refresh"></i>
                                                                                             </a>
                                                                                             <a class="btn btn-xs btn-link panel-close" href="#">
                                                                                                <i class="fa fa-times"></i>
                                                                                             </a>
                                                                                          </div>
                                                                                       </div>
                                                                                       <div class="panel-body">
                                                                                          <div id="moderation" class="moderation">Loading...</div>
                                                                                       </div>
                                                                                    </div>
                                                                                 </div>
                                                                              </div>
                                                                              <div class="row">
                                                                                 <div class="col-md-12">
                                                                                    <hr>
                                                                                 </hr>
                                                                                 <center><h2> Stamp Moderation</h2></center>

                                                                                 <hr>
                                                                              </hr>
                                                                              
                                                                              <div class="panel panel-default">
                                                                                 <div class="panel-heading">
                                                                                    <i class="clip-stats"></i>
                                                                                    List Stamp moderation
                                                                                    <div class="panel-tools">
                                                                                       <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                                       </a>
                                                                                       <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                                          <i class="fa fa-refresh"></i>
                                                                                       </a>
                                                                                       <a class="btn btn-xs btn-link panel-close" href="#">
                                                                                          <i class="fa fa-times"></i>
                                                                                       </a>
                                                                                    </div>
                                                                                 </div>
                                                                                 <div class="panel-body">
                                                                                   <form id="form1" name="form1" method="post" action="">
                                                                                     
                                                                                     <label></label><label>
                                                                                        <input name="refreshStampRadio" type="radio" onclick="refreshstampmoderation(<?php echo $projectID ;?>);" value="0" checked="checked" />
                                                                                     View All</label>
                                                                                     <label>
                                                                                        <input name="refreshStampRadio" type="radio" onclick="refreshstampmoderation(<?php echo $projectID ;?>);" value="1" />
                                                                                     Structure</label>
                                                                                     <label>
                                                                                        <input name="refreshStampRadio" type="radio" value="3" onclick="refreshstampmoderation(<?php echo $projectID ;?>);" />
                                                                                     Machinery</label>
                                                                                     <label>
                                                                                        <input name="refreshStampRadio" type="radio" value="2" onclick="refreshstampmoderation(<?php echo $projectID ;?>);" />
                                                                                     Electrical</label>
                                                                                     <label>
                                                                                        <input name="refreshStampRadio" type="radio" value="7" onclick="refreshstampmoderation(<?php echo $projectID ;?>);" />
                                                                                     Multy</label>
                                                                                     <label>
                                                                                        <input name="refreshStampRadio" type="radio" value="4" onclick="refreshstampmoderation(<?php echo $projectID ;?>);" />
                                                                                     Stability</label>
                                                                                     <label>
                                                                                        <input name="refreshStampRadio" type="radio" value="5" onclick="refreshstampmoderation(<?php echo $projectID ;?>);" />
                                                                                     Statutoria</label>
                                                                                     <label>
                                                                                        <input name="refreshStampRadio" type="radio" value="6" onclick="refreshstampmoderation(<?php echo $projectID ;?>);" />
                                                                                     Matkom</label>
                                                                                  </form>
                                                                                  <hr></hr>

                                                                                  <div id="moderationstamp" class="moderationstamp">Loading....</div>
                                                                               </div>
                                                                            </div>
                                                                         </div>
                                                                      </div>
                                                                      <div class="row">
                                                                        <div class="col-md-12">
                                                                           <div class="panel panel-default">
                                                                              <div class="panel-heading">
                                                                                 <i class="clip-stats"></i>
                                                                                 List Download Drawing moderation
                                                                                 <div class="panel-tools">
                                                                                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                                    </a>
                                                                                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                                       <i class="fa fa-refresh"></i>
                                                                                    </a>
                                                                                    <a class="btn btn-xs btn-link panel-close" href="#">
                                                                                       <i class="fa fa-times"></i>
                                                                                    </a>
                                                                                 </div>
                                                                              </div>
                                                                              <div class="panel-body">
                                                                                 <div id="moderationdrawing" class="moderationdrawing">Loading...</div>
                                                                              </div>
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                  </div>
                                                                  <div id="drawmanagemt" class="tab-pane">
                                                                     <div class="row">
                                                                        <div class="col-md-12">
                                                                           <div class="panel panel-default">
                                                                              <div class="panel-heading">
                                                                                 <i class="clip-stats"></i>
                                                                                 Drawing management
                                                                                 <div class="panel-tools">
                                                                                    <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                                    </a>
                                                                                    <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                                       <i class="fa fa-refresh"></i>
                                                                                    </a>
                                                                                    <a class="btn btn-xs btn-link panel-close" href="#">
                                                                                       <i class="fa fa-times"></i>
                                                                                    </a>
                                                                                 </div>
                                                                              </div>
                                                                              <div class="panel-body">		


                                                                                 <center> <h2> Drawing Task Management </h2></center>
                                                                                 <div class="col-sm-3">
                                                                                    <div class="core-box">
                                                                                       <div class="heading">
                                                                                          <i class="circle-icon circle-teal">
                                                                                             <p id="documentsubmitedcount">NN</p>
                                                                                          </i>
                                                                                          <h2>Submitted</h2>
                                                                                       </div>

                                                                                    </div>
                                                                                 </div>
                                                                                 <div class="col-sm-3">
                                                                                    <div class="core-box">
                                                                                       <div class="heading">
                                                                                          <i class="circle-icon circle-teal">
                                                                                             <p id="documentsubmitedcountTask">NN</p>
                                                                                          </i>
                                                                                          <h2>Task</h2>
                                                                                       </div>

                                                                                    </div>
                                                                                 </div>
                                                                                 <div class="col-sm-2">
                                                                                  <div class="core-box">
                                                                                    <div class="heading">
                                                                                       <i class="circle-icon circle-green">
                                                                                          <p id="countacompolishtask">NN</p>
                                                                                       </i>
                                                                                       <h2>Accomplished </h2>
                                                                                    </div>

                                                                                 </div>
                                                                              </div>
                                                                              <div class="col-sm-2">
                                                                               <div class="core-box">
                                                                                 <div class="heading">
                                                                                    <i class="circle-icon circle-bricky">
                                                                                       <p id="latetaskkkk">NN</p>
                                                                                    </i>
                                                                                    <h2>Task Late </h2>
                                                                                 </div>

                                                                              </div>
                                                                           </div>
                                                                           <div class="col-sm-2">
                                                                            <div class="core-box">
                                                                              <div class="heading">
                                                                                 <i class="circle-icon circle-green">
                                                                                    <p id="countamatkom">NN</p>
                                                                                 </i>
                                                                                 <h2>Matkom </h2>
                                                                              </div>

                                                                           </div>
                                                                        </div>         
                                                                        <p>
                                                                        </p>
                                                                        <hr>                        

                                                                        <form id="form1" name="form1" method="post" action="">
                                                                         
                                                                         <label></label><label>
                                                                            <input name="refreshdrawingmanagement" type="radio" onclick="RefresDrawingTask(<?php echo $projectID ;?>);" value="0" checked="checked" />
                                                                         View All</label>
                                                                         <label>
                                                                            <input name="refreshdrawingmanagement" type="radio" onclick="RefresDrawingTask(<?php echo $projectID ;?>);" value="1" />
                                                                         Structure</label>
                                                                         <label>
                                                                            <input name="refreshdrawingmanagement" type="radio" value="3" onclick="RefresDrawingTask(<?php echo $projectID ;?>);" />
                                                                         Machinery</label>
                                                                         <label>
                                                                            <input name="refreshdrawingmanagement" type="radio" value="2" onclick="RefresDrawingTask(<?php echo $projectID ;?>);" />
                                                                         Electrical</label>
                                                                         <label>
                                                                            <input name="refreshdrawingmanagement" type="radio" value="7" onclick="RefresDrawingTask(<?php echo $projectID ;?>);" />
                                                                         Multy</label>
                                                                         <label>
                                                                            <input name="refreshdrawingmanagement" type="radio" value="4" onclick="RefresDrawingTask(<?php echo $projectID ;?>);" />
                                                                         Stability</label>
                                                                         <label>
                                                                            <input name="refreshdrawingmanagement" type="radio" value="5" onclick="RefresDrawingTask(<?php echo $projectID ;?>);" />
                                                                         Statutoria</label>
                                                                         <label>
                                                                            <input name="refreshdrawingmanagement" type="radio" value="6" onclick="RefresDrawingTask(<?php echo $projectID ;?>);" />
                                                                         Matkom</label>
                                                                      </form>
                                                                      <hr></hr>

                                                                      <div class="drawingtaskList">
                                                                        Loading..
                                                                     </div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                      <div id="engperformance" class="tab-pane">
                                                         <div class="row">
                                                            <div class="col-md-12">
                                                               <div class="panel panel-default">
                                                                  <div class="panel-heading">
                                                                     <i class="clip-stats"></i>
                                                                     Performance
                                                                     <div class="panel-tools">
                                                                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                        </a>
                                                                        <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                           <i class="fa fa-refresh"></i>
                                                                        </a>
                                                                        <a class="btn btn-xs btn-link panel-close" href="#">
                                                                           <i class="fa fa-times"></i>
                                                                        </a>
                                                                     </div>
                                                                  </div>
                                                                  <div class="panel-body">	
                                                                     <div class="hasildatadashboard">
                                                                     </div>

                                                                     <h4> Individual Performance </h4>
                                                                     <hr>
                                                                     <select class="form-control" id="sel-member" onchange="getIndividualPerformance(<?php echo $projectID;?>);">
                                                                        <?php
                                                                        foreach($listTeamOgs as $dat)
                                                                        {
                                                                           echo "<option value=$dat[id_user]>$dat[nama]</>";
                                                                        }
                                                                        ?>
                                                                     </select>
                                                                     <br>
                                                                     <div class="row">
                                                                        <div class="col-sm-4">
                                                                           <div class="core-box">
                                                                              <div class="heading">
                                                                                 <i class="circle-icon circle-green">
                                                                                    <p id="indicator-task">NN</p>
                                                                                 </i>
                                                                                 <h2>Drawing Task</h2>
                                                                              </div>

                                                                           </div>
                                                                        </div>
                                                                        <div class="col-sm-4">
                                                                         <div class="core-box">
                                                                           <div class="heading">
                                                                              <i class="circle-icon circle-teal">
                                                                                 <p id="indicator-review">NN</p>
                                                                              </i>
                                                                              <h2>Drawing Reviewed</h2>
                                                                           </div>

                                                                        </div>
                                                                     </div>
                                                                     <div class="col-sm-4">
                                                                        <div class="core-box">
                                                                           <div class="heading">
                                                                              <i class="circle-icon circle-green">
                                                                                 <p id="indicator-create">NN</p>
                                                                              </i>
                                                                              <h2>Comment Created</h2>
                                                                           </div>

                                                                        </div>
                                                                     </div>
                                                                     <div class="col-sm-2"></div>
                                                                     <div class="col-sm-4">
                                                                        <div class="core-box">
                                                                           <div class="heading">
                                                                              <i class="circle-icon circle-teal">
                                                                                 <p id="indicator-open">NN</p>
                                                                              </i>
                                                                              <h2>Open Comment</h2>
                                                                           </div>

                                                                        </div>
                                                                     </div>   

                                                                     <div class="col-sm-4">
                                                                        <div class="core-box">
                                                                           <div class="heading">
                                                                              <i class="circle-icon circle-bricky">
                                                                                 <p id="indicator-late">NN</p>
                                                                              </i>
                                                                              <h2>Late Task</h2>
                                                                           </div>

                                                                        </div>
                                                                     </div>
                                                                     <div class="col-sm-2"></div>
                                                                  </div>
                                                                  <div class="div-individual"></div>
                                                                  
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>

                                                   <div id="docrequestmanager" class="tab-pane">
                                                      <div class="row">
                                                         <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                               <div class="panel-heading">
                                                                  <i class="clip-stats"></i>
                                                                  List Document Request.
                                                                  <div class="panel-tools">
                                                                     <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                        <i class="fa fa-refresh"></i>
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-close" href="#">
                                                                        <i class="fa fa-times"></i>
                                                                     </a>
                                                                  </div>
                                                               </div>
                                                               <div class="panel-body">
                                                                  <div id="listdocrequestmanager" class="listdocrequestmanager">Loading...</div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>





                                                </div>
                                             </div>
                                          </div>
                                          <div id="reportt" class="tab-pane">
                                             <div class="tabbable">
                                                <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                                                   <li class="active" id="taboverview" >
                                                      <a data-toggle="tab" href="#dailyReport"  onclick="refreshDailyreport(<?php echo $projectID;?>);">
                                                         Daily Report
                                                      </a>
                                                   </li>
                                                   <li>
                                                      <a data-toggle="tab" href="#weeklyReport" onclick="refreshWeeklyreport(<?php echo $projectID;?>);">
                                                         Weekly  Report
                                                      </a>
                                                   </li>
                                                   <li>
                                                      <a data-toggle="tab" href="#moonthlyReport" onclick="refreshMonthlyreport(<?php echo $projectID;?>);"> 
                                                         Monthly Report
                                                      </a>
                                                   </li>
                                                </ul>
                                                <div class="tab-content">
                                                   <div id="dailyReport" class="tab-pane in active">
                                                      <div class="row">
                                                         <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                               <div class="panel-heading">
                                                                  <i class="clip-stats"></i>
                                                                  Daily Report
                                                                  <div class="panel-tools">
                                                                     <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                        <i class="fa fa-refresh"></i>
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-close" href="#">
                                                                        <i class="fa fa-times"></i>
                                                                     </a>
                                                                  </div>
                                                               </div>
                                                               <div class="panel-body">
                                                                  <form role="form" class="form-horizontal" id="addDayliReport"  name="addDayliReport">
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                        Subject :											</label>
                                                                        <div class="col-sm-9">
                                                                           <input type="text"  id="SubjectDailyReport"  name="SubjectDailyReport" class="form-control" required="">
                                                                           <input id="id_kon" name="id_kon" type="hidden" value="<?php echo $projectID ; ?>">
                                                                           <input id="modul" name="modul" type="hidden" value="generateReport">
                                                                           <input id="act" name="act" type="hidden" value="addDailyReport">
                                                                        </div>
                                                                     </div>
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                           Days :											
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                           <select id="form-field-select-1" class="form-control" name="reportat" required>
                                                                              <?php  echo $selectoptionDayliReport ?>
                                                                           </select>
                                                                        </div>
                                                                     </div>
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                           Attachment [*.PDF]	 
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                           <input type="file" name="uploadAttacmentDayliReport"  class="form-control" required/>
                                                                           <label>
                                                                           </label>
                                                                           <p>
                                                                              <button class="btn btn-purple"  type="submit" >
                                                                                 Start upload  <i class="fa fa-arrow-circle-right"></i>
                                                                              </button>
                                                                              <button class="btn btn-green" class="btn btn-green" onclick="this.form.reset();">
                                                                                 Reset <i class="fa clip-archive "></i>
                                                                              </button>	
                                                                           </p>
                                                                        </div>
                                                                     </div>
                                                                  </form>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                               <div class="panel-heading">
                                                                  <i class="clip-stats"></i>
                                                                  List Daily Report
                                                                  <div class="panel-tools">
                                                                     <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                        <i class="fa fa-refresh"></i>
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-close" href="#">
                                                                        <i class="fa fa-times"></i>
                                                                     </a>
                                                                  </div>
                                                               </div>
                                                               <div class="panel-body">
                                                                  <div id="listdailyreport" class="listdailyreport"></div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div id="weeklyReport" class="tab-pane">
                                                      <div class="row">
                                                         <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                               <div class="panel-heading">
                                                                  <i class="clip-stats"></i>
                                                                  Weekly Report
                                                                  <div class="panel-tools">
                                                                     <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                        <i class="fa fa-refresh"></i>
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-close" href="#">
                                                                        <i class="fa fa-times"></i>
                                                                     </a>
                                                                  </div>
                                                               </div>
                                                               <div class="panel-body">
                                                                  <form role="form" class="form-horizontal" id="addWeeklyReport"  name="addWeeklyReport">
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                        Subject :											</label>
                                                                        <div class="col-sm-9">
                                                                           <input type="text"  id="SubjectWeeklyReport" name="SubjectWeeklyReport" class="form-control" required>
                                                                           <input id="id_kon" name="id_kon" type="hidden" value="<?php echo $projectID ; ?>">
                                                                           <input id="modul" name="modul" type="hidden" value="generateReport">
                                                                           <input id="act" name="act" type="hidden" value="addWeeklyReport">
                                                                        </div>
                                                                     </div>
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                           Weeks :											
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                           <select id="weeklyNumberdata" name="weeklyNumberdata" class="form-control" onchange="getDrawingData(<?php echo $projectID ?>);" required >
                                                                              <option></option>
                                                                              <?php  echo $selectoptionWeeklyReport ?>
                                                                           </select>
                                                                        </div>
                                                                     </div>
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                           Description :
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                           <div class="infoDrawingWeek" id="infoDrawingWeek" >
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                           Attachment [*.PDF]	
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                           <input type="file" name="uploadAttacmentwekkly"  class="form-control" required />
                                                                           <label>
                                                                           </label>
                                                                           <p>
                                                                              <button class="btn btn-purple"  type="submit" >
                                                                                 Start upload  <i class="fa fa-arrow-circle-right"></i>
                                                                              </button>
                                                                              <button class="btn btn-green" class="btn btn-green" onclick="this.form.reset();">
                                                                                 Reset <i class="fa clip-archive "></i>
                                                                              </button>	
                                                                           </p>
                                                                        </div>
                                                                     </div>
                                                                  </form>
                                                               </div>
                                                            </div>
                                                         </div>
                                                         <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                               <div class="panel-heading">
                                                                  <i class="clip-stats"></i>
                                                                  List Weekly Report
                                                                  <div class="panel-tools">
                                                                     <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                        <i class="fa fa-refresh"></i>
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-close" href="#">
                                                                        <i class="fa fa-times"></i>
                                                                     </a>
                                                                  </div>
                                                               </div>
                                                               <div class="panel-body">
                                                                  <div id="listweeklyreport" class="listweeklyreport"></div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                   <div id="moonthlyReport" class="tab-pane">
                                                      <div class="row">
                                                         <div class="col-md-12">
                                                            <div class="panel panel-default">
                                                               <div class="panel-heading">
                                                                  <i class="clip-stats"></i>
                                                                  Monthly Report
                                                                  <div class="panel-tools">
                                                                     <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                        <i class="fa fa-refresh"></i>
                                                                     </a>
                                                                     <a class="btn btn-xs btn-link panel-close" href="#">
                                                                        <i class="fa fa-times"></i>
                                                                     </a>
                                                                  </div>
                                                               </div>
                                                               <div class="panel-body">
                                                                  <form role="form" class="form-horizontal" name="addMontlyReport" id="addMontlyReport">
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                        Subject :											</label>
                                                                        <div class="col-sm-9">
                                                                           <input type="text"  id="SubjectMonthlyReport" name="SubjectMonthlyReport" class="form-control" required>
                                                                           <input id="id_kon" name="id_kon" type="hidden" value="<?php echo $projectID ; ?>">
                                                                           <input id="modul" name="modul" type="hidden" value="generateReport">
                                                                           <input id="act" name="act" type="hidden" value="addMonthlyReport">
                                                                        </div>
                                                                     </div>
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                           Month :											
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                           <select id="monthlyadd" class="form-control" name="monthlyadd"  onchange="getDrawingDataMonth(<?php echo $projectID ?>);" required>
                                                                              <option></option>
                                                                              <?php  echo $selectoptionMonthlyReport ?>
                                                                           </select>
                                                                        </div>
                                                                     </div>
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                           Description :
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                           <div class="infoDrawingmonth" id="infoDrawingmonth" >
                                                                           </div>
                                                                        </div>
                                                                     </div>
                                                                     <div class="form-group">
                                                                        <label class="col-sm-2 control-label" for="form-field-1">
                                                                           Attachment	[*.PDF]
                                                                        </label>
                                                                        <div class="col-sm-9">
                                                                           <input type="file" name="uploadAttacmentmontlyReport"  class="form-control" required/>
                                                                           <label>
                                                                           </label>
                                                                           <p>
                                                                              <button class="btn btn-purple"  type="submit" >
                                                                                 Start upload  <i class="fa fa-arrow-circle-right"></i>
                                                                              </button>
                                                                              <button class="btn btn-green" class="btn btn-green" onclick="this.form.reset();">
                                                                                 Reset <i class="fa clip-archive "></i>
                                                                              </button>	
                                                                           </div>
                                                                        </div>
                                                                     </form>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                            <div class="col-md-12">
                                                               <div class="panel panel-default">
                                                                  <div class="panel-heading">
                                                                     <i class="clip-stats"></i>
                                                                     List Monthly Report
                                                                     <div class="panel-tools">
                                                                        <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                                                        </a>
                                                                        <a class="btn btn-xs btn-link panel-refresh" href="#">
                                                                           <i class="fa fa-refresh"></i>
                                                                        </a>
                                                                        <a class="btn btn-xs btn-link panel-close" href="#">
                                                                           <i class="fa fa-times"></i>
                                                                        </a>
                                                                     </div>
                                                                  </div>
                                                                  <div class="panel-body">
                                                                     <div id="listMontlyreport" class="listMontlyreport"></div>
                                                                  </div>
                                                               </div>
                                                            </div>
                                                         </div>
                                                      </div>
                                                   </div>
                                                </div>
               <!-- <a class="btn btn-green" onclick="GenerateReport(<?php echo $projectID;?>)">
                  Generated Report <i class="fa clip-archive "></i>
                  </a>
                  
                  <div id="isireport" class="isireport" >
                  </div> -->
               </div>


               <div id="indukmatkomtab" class="tab-pane" >

                  <div class="tabbable">
                     <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                        <li class="active" id="taboverview" >
                           <a data-toggle="tab" href="#matkomEnginner" onclick="RefresMatkommaCombo(<?php echo $projectID ;?>);">
                              Upload Certificate
                           </a>
                        </li>
                        <?php
                        $strsertipikat="<li>
                        <a data-toggle='tab' href='#sertifikatreq'  onclick='RefresMatkommasterlist($projectID);'>
                        Certificate
                        </a>
                        </li>";  
                        if (in_array(28, $permisionPieace)) {echo $strsertipikat;}   

                        ?>
                     </ul>
                     <div class="tab-content">
                        
                        <div id="matkomEnginner" class="tab-pane active" >
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <i class="clip-stats"></i>
                                       Upload Material Certificate
                                       <div class="panel-tools">
                                          <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                          </a>
                                          <a class="btn btn-xs btn-link panel-refresh" href="#">
                                             <i class="fa fa-refresh"></i>
                                          </a>
                                          <a class="btn btn-xs btn-link panel-close" href="#">
                                             <i class="fa fa-times"></i>
                                          </a>
                                       </div>
                                    </div>
                                    <div class="panel-body">
                                       <form role="form" id="uploadmatkom"  name="uploadmatkom" class="form-horizontal">
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                List Material
                                             </label>
                                             <div class="col-sm-7"> 
                                                <div class="materilacombo">
                                                   Loading....
                                                </div>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Detail
                                             </label>
                                             <div class="col-sm-7">
                                                <div class="detaimaterilkombo">
                                                   <textarea placeholder="write comment here" id="upcomentt" class="form-control" readonly rows="10"> Detail goes here..</textarea>
                                                </div>
                                                
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Certificated Number
                                             </label>
                                             <div class="col-sm-7">
                                                <input type="text" id="cernumber" name="cernumber" class="form-control" >
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Deskription
                                             </label>
                                             <div class="col-sm-7">
                                              
                                                <textarea placeholder="write comment here" id="describtion" name="describtion" class="form-control"  rows="10"></textarea>

                                                
                                             </div>
                                          </div>                                   
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                File [*.PDF]
                                             </label>
                                             <div class="col-sm-7">
                                                <input type="file" name="upload" class="form-control" required>
                                                <input type="hidden" name="idkontrak" id="idkontrak" value="<?php echo $projectID ;?>" readonly="readonly">
                                                <input type="hidden" name="act" id="act" value="addCertificated" readonly="readonly">
                                                <input type="hidden" name="modul" id="modul" value="administratif" readonly="readonly">
                                             </div>
                                          </div>

                                          <button data-style="expand-right" class="btn btn-teal ladda-button" type="submit">
                                             <span class="ladda-label"> Start upload </span>
                                             <i class="fa fa-arrow-circle-right"></i>
                                             <span class="ladda-spinner"></span>
                                             <span class="ladda-spinner"></span>
                                             <div style="width: 0px;" class="ladda-progress"></div>
                                             <span class="ladda-spinner"></span>
                                          </button>
                                       </form>
                                       <br>
                                       <br>
                                       <hr>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <i class="clip-stats"></i>
                                       List Material komponen
                                       <div class="panel-tools">
                                          <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                          </a>
                                          <a class="btn btn-xs btn-link panel-refresh" href="#">
                                             <i class="fa fa-refresh"></i>
                                          </a>
                                          <a class="btn btn-xs btn-link panel-close" href="#">
                                             <i class="fa fa-times"></i>
                                          </a>
                                       </div>
                                    </div>
                                    <div class="panel-body">
                                       <div id="listmastermaterialengineer" class="listmastermaterialengineer"> loading... </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div id="sertifikatreq" class="tab-pane">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <i class="clip-stats"></i>
                                       Add List Material component
                                       <div class="panel-tools">
                                          <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                          </a>
                                          <a class="btn btn-xs btn-link panel-refresh" href="#">
                                             <i class="fa fa-refresh"></i>
                                          </a>
                                          <a class="btn btn-xs btn-link panel-close" href="#">
                                             <i class="fa fa-times"></i>
                                          </a>
                                       </div>
                                    </div>
                                    <div class="panel-body">                        
                                       <form role="form" class="form-horizontal">
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Material name :                                 
                                             </label>
                                             <div class="col-sm-9">
                                                <input type="text" placeholder="Name of Material" id="matkomname" class="form-control">
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Type :
                                             </label>
                                             <div class="col-sm-9">
                                                <select id="typecertmatkom" class="form-control" >
                                                   <option value="2">type test</option>
                                                   <option value="3">mass</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Organization issued :
                                             </label>
                                             <div class="col-sm-9">
                                                <input type="text" placeholder="Name of Material" id="isseudmatkomby" class="form-control">
                                             </div>
                                          </div> 
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Rules Aplicable :
                                             </label>
                                             <div class="col-sm-9">
                                                <textarea class="form-control" placeholder="Aplicable rules. Ex :  Rules BKI Seagoing Ship Pt.1 Vol IX Section 5.A " id='rulesaplicablematkom' ></textarea>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Certifcated level :
                                             </label>
                                             <div class="col-sm-9">
                                                <select id="cerlevelmatkom" class="form-control" >
                                                   <option value="2">type test</option>
                                                   <option value="3">mass</option>
                                                </select>
                                             </div>
                                          </div>                                                                                                                   
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Description :
                                             </label>
                                             <div class="col-sm-9">
                                                <textarea class="form-control" placeholder="Material Description" id='descrmatkom'></textarea>
                                                <label>
                                                </label>
                                                <p>
                                                   <a class="btn btn-blue"  onclick="AddMatkommasterlist(<?php echo $projectID;?>);"><i class="fa fa-plus"></i>
                                                   Submit Entry</a> <button type="button" class="btn btn-green" onclick="clearFrom();">
                                                      Reset
                                                   </button>      
                                                </p>
                                             </div>
                                          </div>
                                       </form>
                                    </div>
                                 </div>
                              </div>
                              <div class="col-md-12">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <i class="clip-stats"></i>
                                       List Master Material
                                       <div class="panel-tools">
                                          <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                          </a>
                                          <a class="btn btn-xs btn-link panel-refresh" href="#">
                                             <i class="fa fa-refresh"></i>
                                          </a>
                                          <a class="btn btn-xs btn-link panel-close" href="#">
                                             <i class="fa fa-times"></i>
                                          </a>
                                       </div>
                                    </div>
                                    <div class="panel-body">
                                       <div class="listmastermaterial" id="listmastermaterial">
                                          Loading....
                                       </div>
                                       
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>





               </div>






               <div id="money" class="tab-pane">
                  <div class="tabbable">
                     <ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
                        <li class="active" id="taboverview" >
                           <a data-toggle="tab" href="#inputCost" >
                              Cost / income
                           </a>
                        </li>
                     </ul>
                     <div class="tab-content">
                        <div id="inputCost" class="tab-pane in active">
                           <div class="row">
                              <div class="col-md-12">
                                 <div class="panel panel-default">
                                    <div class="panel-heading">
                                       <i class="clip-stats"></i>
                                       Input Cost / income
                                       <div class="panel-tools">
                                          <a class="btn btn-xs btn-link panel-collapse collapses" href="#">
                                          </a>
                                          <a class="btn btn-xs btn-link panel-refresh" href="#">
                                             <i class="fa fa-refresh"></i>
                                          </a>
                                          <a class="btn btn-xs btn-link panel-close" href="#">
                                             <i class="fa fa-times"></i>
                                          </a>
                                       </div>
                                    </div>
                                    <div class="panel-body">
                                       <form id="finance-add" name="finance-add" role="form" class="form-horizontal">
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                             Subject :											</label>
                                             <div class="col-sm-9">
                                                <input type="text" placeholder="Name of Cost" id="nameCost" name="nameCost" class="form-control" required>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                             Cost :	</label>
                                             <div class="col-sm-9">
                                                <label class="radio-inline">
                                                   <input type="radio" value="1" name="optionsRadios" class="grey" checked>
                                                   Cost
                                                </label>
                                                <label class="radio-inline">
                                                   <input type="radio" value="2" name="optionsRadios" class="grey">
                                                   Income
                                                </label>											
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Amount :
                                             </label>
                                             <div class="col-sm-9">
                                                <input type="number" placeholder="Total Amount" id="jmlcostrupiah" name="jmlcostrupiah" class="form-control currency" value="0" onkeyup="calcTotaldana();">
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Amount foreign exchange :
                                             </label>
                                             <div class="col-sm-9">
                                                <input type="text" placeholder="Total Amount" id="jmlcost" name="jmlcost" class="form-control currency"  value="0" onkeyup="calcTotaldana();" >
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Currency :
                                             </label>
                                             <div class="col-sm-9">
                                                <select id="form-field-select-1" name="currency" class="form-control" >
                                                   <option value="2">US Dollar</option>
                                                   <option value="3">SING Dollar</option>
                                                   <option value="4">Poundsterling</option>
                                                   <option value="5">Euro</option>
                                                </select>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Kurs :
                                             </label>
                                             <div class="col-sm-9">
                                                <input type="number" placeholder="Kurs prediction" id="invet_kurs" name="invet_kurs" onkeyup="calcTotaldana();" class="form-control currency">
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Total in IDR :
                                             </label>
                                             <div class="col-sm-9">
                                                <input type="number"  id="totalcost" name="totalcost" class="form-control currency" readonly>
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                             Date :											</label>
                                             <div class="col-sm-9">
                                                <span class="col-sm-9-addon"> <i class="fa fa-calendar"></i> </span>	
                                                <input type="text" data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker" id="realization" name="realization">
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-1">
                                                Description :
                                             </label>
                                             <div class="col-sm-9">
                                                <textarea placeholder="Cost Description" id="form-field-224333" name="form-field-224333" class="ckeditor form-control"></textarea>
                                                
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-5" >
                                                Attachment (PDF) :
                                             </label>
                                             <div class="col-sm-9">
                                                <input type="file" name="upload"  class="form-control"/>
                                                <input type="hidden" name="modul" id="modul" value="cost" readonly="readonly" />
                                                <input type="hidden" name="act" id="act" value="add" readonly="readonly" />
                                                <input type="hidden" name="code" id="code" value="<?php echo $projectID ;?>" readonly="readonly" />
                                             </div>
                                          </div>
                                          <div class="form-group">
                                             <label class="col-sm-2 control-label" for="form-field-5" >
                                             </label>
                                             <div class="col-sm-9">
                                                <p>
                                                   <button class="btn btn-blue"  type="submit"><i class="fa fa-plus"></i>
                                                   Submit Entry</a> <button type="button" class="btn btn-green" onclick="clearFrom();">
                                                      Reset
                                                   </button>		
                                                </p>
                                             </div>
                                          </div>
                                          
                                       </form>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <div id="listpengeluaran" class="listpengeluaran">uang</div>
                        </div>
                     </div>
                  </div>
               </div>
               <input type="hidden" name="idProject" id="idProject" value="<?php echo $projectID ; ?>" readonly="readonly" />
            </div>
         </div>
      </div>
   </div>
   <!-- end: PAGE CONTENT-->
   <!-- start: BOOTSTRAP EXTENDED MODALS -->
   <div id="responsive" class="modal fade" tabindex="-1" data-width="560" style="display: none;">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
         </button>
         <h4 class="modal-title">Add Subscriber</h4>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-md-12">
               <h4>Select Participant</h4>
               <p>
                  <select multiple="multiple" id="subscriber" class="form-control search-select" name="sapi[]">
                     <?php 
                     foreach ($TeamMembers as $piece){
                        
                        $biodata_users= $Users->getUser_biodata($piece);
                        $nama_uservs=$Users->get_users_with_title($piece);
                        
                        echo "<option value='$piece'>$nama_uservs</option>"   ;
                     }
                     
                     
                     ?>
                  </select>
               </p>
               <input name="listsubscriber" id="listsubscriber" type="hidden"  />
            </div>
         </div>
      </div>
      <div class="modal-footer">
         <button type="button" data-dismiss="modal" class="btn btn-light-grey">
            Close
         </button>
         <button type="button" class="btn btn-blue" data-dismiss="modal" onClick="saveSubscribertemp();">
            Save changes
         </button>
      </div>
   </div>

   <div id="responsiveAsigmentTask" class="modal fade" tabindex="-1" data-width="560" style="display: none;">
      <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
            &times;
         </button>
         <h4 class="modal-title">Asigmnent tast To </h4>
      </div>
      <div class="modal-body">
         <div class="row">
            <div class="col-md-12">
               <h4>Asigmnent Task to :</h4>
               <p>
                  <select name="mm" id="listIdtaskuser" class="form-control">
                     <?php 
                     foreach ($TeamMembers as $piece){
                        
                        $biodata_users= $Users->getUser_biodata($piece);
                        $nama_uservs=$Users->get_users_with_title($piece);
                        
                        echo "<option value='$piece'>$nama_uservs</option>"   ;
                     }
                     
                     
                     ?>
                  </select>
               </p>
               <p>
                 <h4>Due date :</h4>
                 
                 <input type="text" id='duedatedrawingTask' data-date-format="dd-mm-yyyy" data-date-viewmode="years" class="form-control date-picker">
              </p>
              
              <h4>Message :</h4>
              <textarea placeholder="write message here" id="mesagedrawingtask" class="form-control"></textarea>
              

              <input name="setIdsubIdgambara" id="setIdsubIdgambara" type="hidden"  />
              <input  id="setDrawingid" type="hidden"  />
              <input id="setnodrawing" type="hidden"  />
              <input id="revisinumber" type="hidden"  />
           </div>
        </div>
     </div>
     <div class="modal-footer">
      <button type="button" data-dismiss="modal" class="btn btn-light-grey">
         Close
      </button>
      <button type="button" class="btn btn-blue" data-dismiss="modal" onClick="AddTaskDrawing(<?php echo $projectID ;?>);">
         Save changes
      </button>
   </div>
</div>

<div id="editdrawproperty" class="modal fade" tabindex="-1" data-width="700" style="display: none;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         &times;
      </button>
      <h4 class="modal-title">Edit Drawing</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <form name="teenageMutant">
            <div class="col-md-12">
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1">
                     Drawing Number 
                  </label>
                  <div class="col-sm-9">
                     <input type="text" name="drawnumberedit" class="form-control" id="drawnumberedit" />
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1">
                     Title : 
                  </label>
                  <div class="col-sm-9">
                     <input type="text" name="titledrawedit"  id="titledrawedit" class="form-control" />
                     <input type="hidden" name="iddrawedit" id="iddrawedit"  />
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1">
                     Type : 
                  </label>
                  <div class="col-sm-9">
                     <?php 
                     echo $strOptionRadioButtontipegambar ;
                     ?>
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" data-dismiss="modal" class="btn btn-light-grey">
         Close
      </button>
      <button type="button" class="btn btn-blue" data-dismiss="modal" onClick="savechangedrwaproperty(<?php echo $projectID ;?>);">
         Save changes
      </button>
   </div>
</div>
<div id="editPropertyDrawing" class="modal fade" tabindex="-1" data-width="720" style="display: none;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         &times;
      </button>
      <h4 class="modal-title">Edit Property</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <form name="teenageMutanttt">
            <div class="col-md-12">
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1">
                     Drawing Number 
                  </label>
                  <div class="col-sm-9">
                     <input type="text" name="prop_drawnumberedit"  id="prop_drawnumberedit" class="form-control" readonly />
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1">
                     Title : 
                  </label>
                  <div class="col-sm-9">
                     <input type="text" name="prop_titledrawedit"  id="prop_titledrawedit" class="form-control" readonly />
                     <input type="hidden" name="idPropdraw" id="idPropdraw"  />
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1">
                     Type : 
                  </label>
                  <div class="col-sm-9">
                     <label><input name="prop_typeeditdraw" type="radio" value="0">Drawing</label><label><input name="prop_typeeditdraw" type="radio" value="1">Calculation</label><label><input name="prop_typeeditdraw" type="radio" value="2">Report</label><label><input name="prop_typeeditdraw" type="radio" value="3">Misc</label><label><input name="prop_typeeditdraw" type="radio" value="4">Document for information</label>
                  </div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <label class="col-sm-2 control-label" for="form-field-1">
                     Engineering Field : 
                  </label>
                  <div class="col-sm-5">
                     <select  class="form-control tooltips" data-original-title="Engineering Field" class="form-control" data-rel="tooltip"  title="" data-placement="top" name="asigment" id="enginnerfiled" >	
                        <?php 
                        echo $strCombofieldDraw ; 
                        ?>	
                     </select>		
                  </div>
               </div>
            </div>
         </form>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" data-dismiss="modal" class="btn btn-light-grey">
         Close
      </button>
      <button type="button" class="btn btn-blue" data-dismiss="modal" onClick="savechangedrwaEngfield(<?php echo $projectID ;?>);">
         Save changes
      </button>
   </div>
</div>
<div id="ceklisthproject" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         &times;
      </button>
      <h4 class="modal-title">Review Project</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="panel-group accordion-custom accordion-teal" id="accordion">
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">
                     <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion" href="#collapseOne">
                        <i class="icon-arrow"></i>
                        Collapsible Group Item #1 
                     </a>
                  </h4>
               </div>
               <div id="collapseOne" class="panel-collapse collapse in">
                  <div class="panel-body">
                     Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                     <div class="checkbox">
                        <label>
                           <input type="checkbox" name="projectchecklist[]" value="" class="grey">
                           Already check and confirm
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">
                     <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                        <i class="icon-arrow"></i>
                        Collapsible Group Item #2 
                     </a>
                  </h4>
               </div>
               <div id="collapseTwo" class="panel-collapse collapse">
                  <div class="panel-body">
                     Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                     <div class="checkbox">
                        <label>
                           <input type="checkbox"  name="projectchecklist[]" value="" class="grey">
                           Already check and confirm
                        </label>
                     </div>
                  </div>
               </div>
            </div>
            <div class="panel panel-default">
               <div class="panel-heading">
                  <h4 class="panel-title">
                     <a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
                        <i class="icon-arrow"></i>
                        Collapsible Group Item #3
                     </a>
                  </h4>
               </div>
               <div id="collapseThree" class="panel-collapse collapse">
                  <div class="panel-body">
                     Anim pariatur cliche reprehenderit, enim eiusmod high life accusamus terry richardson ad squid. 3 wolf moon officia aute, non cupidatat skateboard dolor brunch. Food truck quinoa nesciunt laborum eiusmod. Brunch 3 wolf moon tempor, sunt aliqua put a bird on it squid single-origin coffee nulla assumenda shoreditch et. Nihil anim keffiyeh helvetica, craft beer labore wes anderson cred nesciunt sapiente ea proident. Ad vegan excepteur butcher vice lomo. Leggings occaecat craft beer farm-to-table, raw denim aesthetic synth nesciunt you probably haven't heard of them accusamus labore sustainable VHS.
                     <div class="checkbox">
                        <label>
                           <input type="checkbox" name="projectchecklist[]" value="" class="grey">
                           Already check and confirm
                        </label>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" data-dismiss="modal" class="btn btn-light-grey">
         Close
      </button>
      <button type="button" class="btn btn-blue" data-dismiss="modal" onClick="projectdone(<?php echo $projectID ;?>);">
         Save changes
      </button>
   </div>
</div>
<div id="editComent" class="modal fade" tabindex="-1" data-width="560" style="display: none;">
   <div class="modal-header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
         &times;
      </button>
      <h4 class="modal-title">Edit Comment</h4>
   </div>
   <div class="modal-body">
      <div class="row">
         <div class="col-md-12">
            <div class="form-group">
               <label class="col-sm-2 control-label" for="form-field-1">
                  Comment Number 
               </label>
               <div class="col-sm-9">
                  <input type="text" name="comnumber"  id="comnumber" disabled="disabled"/>
               </div>
            </div>
            <hr>
            <div class="form-group">
               <label class="col-sm-2 control-label" for="form-field-1">
                  Type info 
               </label>
               <div class="col-sm-9">
                  <select name="editCommenttype" id="editCommenttype"  class="form-control" required>
                     <option value="0">To be dealt with</option>
                     <option value="1">Accepted</option>
                     <option value="2">To be re-submited</option>
                     <option value="3">Note</option>
                  </select>
               </div>
            </div>
            <hr>
            <hr>
            <div class="form-group">
               <label class="col-sm-2 control-label" for="form-field-1">
                  Comment : 
               </label>
               <div class="col-sm-9">
                  <textarea placeholder="write comment here" id="upcoment" class="form-control"></textarea>
               </div>
            </div>
         </div>
      </div>
   </div>
   <div class="modal-footer">
      <button type="button" data-dismiss="modal" class="btn btn-light-grey">
         Close
      </button>
      <button type="button" class="btn btn-blue" data-dismiss="modal" onClick="fung_update_commnet(<?php echo $projectID ;?>);">
         Save changes
      </button>
   </div>
</div>
<div id="timelinecommnet" class="modal fade" tabindex="-1" data-width="760" style="display: none;">
         <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
               &times;
            </button>
            <h4 class="modal-title">Detail Comment</h4>
         </div>
         <div class="modal-body">
            <div class="row">
                   <div class="detailviewcomment" id="detailviewcomment" style="margin-left: 10px;margin-left: 30px;margin-right: 10px;">
                            <table style="width:100%">
                               <h3>STT-7 <strong>Open</strong></h3>
                              <tr>
                                <td>Issued by</td>
                                <td>Smith</td>
                              </tr>
                              <tr>
                                <td>Discipline</td>
                                <td>Jackson</td>
                              </tr>
                              <tr>
                                <td>Released date</td>
                                <td>Doe</td>
                              </tr>
                              <tr>
                                <td>Approval id</td>
                                <td>Doe</td>
                              </tr>
                              <tr>
                                <td>Document</td>
                                <td>Doe</td>
                              </tr>
                              <tr>
                                <td>Comment</td>
                                <td>View Commnet</td>
                              </tr>
                              <tr>
                                <td>Comment type</td>
                                <td>View Commnet</td>
                              </tr>
                              <tr>
                                <td>Reply</td>
                                <td>View Commnet</td>
                              </tr>
                            </table>
                       </div>
            </div>
         </div>
         <div class="modal-footer">
            <button type="button" data-dismiss="modal" class="btn btn-light-grey">
               Close
            </button>
         </div>
      </div>
<script>
   jQuery(document).ready(function() {
      Main.init();
      TableData.init();
      PagesGallery.init();
      Index.init();
   			//getChildData();
   			//var childStr = document.getElementById("child-input").value;
   			var childStr = '<?php echo $childData;?>';
            var childArray = childStr.split("+").join(" "); 
            var childData = JSON.parse(childArray);	
            var projId = document.getElementById("project-id").value
            UIButtons.init();
            UITreeview.init(childData, projId);
            
            
            $('.date-time-range').daterangepicker({
              timePicker: true,
              timePickerIncrement: 15,
              format: 'MM/DD/YYYY h:mm A'
           });
            
            $('.color-palette').colorPalette()
            .on('selectColor', function (e) {
              $('#selected-color1').val(e.color);
           });	
            
   			//Program a custom submit function for the form
          $("form#fileuploadssss").submit(function(event){
            
   			  //disable the default form submission
             event.preventDefault();
             var listsubcriber=document.getElementById('listsubscriber').value;
             
             document.getElementById('subscr').value=listsubcriber;
   			  //grab all form data  
             var formData = new FormData($(this)[0]);
             
             document.getElementById('listsubscriber').value='';
             
             $.ajax({
              url: 'process.php',
              type: 'POST',
              data: formData,
              async: false,
              cache: false,
              contentType: false,
              processData: false,
              success: function (html) {
                $('.document').html(html);
                $(".document").hide();
                $(".document").fadeIn(400);}
             });
             
             return false;
          });
          
          
   		//Program a custom submit function for the form
   		$("form#uploadgambar").submit(function(event){
            
   		  //disable the default form submission
   		  event.preventDefault();
   		  var sapii=document.getElementById('textfield').value;
           
   		  //grab all form data  
   		  var formData = new FormData($(this)[0]);
           
   		  $.ajax({
            url: 'process-ogs.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (html) {
              $('.isiinputdrawing').html(html);
              $(".isiinputdrawing").hide();
              $(".isiinputdrawing").fadeIn(400);}
           });
           
   		  return false;
   		});				
   		
   		//Program a custom submit function for the form
   		$("form#uploadStamp").submit(function(event){
            
   		  //disable the default form submission
   		  event.preventDefault();
   		  var sapii=document.getElementById('textfield').value;
           
   		  //grab all form data  
   		  var formData = new FormData($(this)[0]);
           
   		  $.ajax({
            url: 'process-ogs.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (html) {
             $('.isiuploadstamp').html(html);
             $(".isiuploadstamp").hide();
             $(".isiuploadstamp").fadeIn(400);}
          });
           
   		  return false;
   		});	


         $("form#uploadmatkom").submit(function(event){
           
           //disable the default form submission
           event.preventDefault();
           var sapii=document.getElementById('textfield').value;
           
           //grab all form data  
           var formData = new FormData($(this)[0]);
           formData.set('idmaterila', sapii);
           $.ajax({
            url: 'process-ogs.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (html) {
               $('.listmastermaterialengineer').html(html);
               $(".listmastermaterialengineer").hide();
               $(".listmastermaterialengineer").fadeIn(400);}
            });
           
           return false;
        });      
         
         $("form#addreportsurvey").submit(function(event){
            
   		  //disable the default form submission
   		  event.preventDefault();
   		  //var sapii=document.getElementById('textfield').value;
   		  var test = CKEDITOR.instances['narasisurvey'].getData();
   		  //grab all form data  
   		  var formData = new FormData($(this)[0]);
   		  formData.set('narasisurvey', test);
   		  $.ajax({
            url: 'process-ogs.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (html) {
             $('.listsyrveyreport').html(html);
             $(".listsyrveyreport").hide();
             $(".listsyrveyreport").fadeIn(400);}
             
          });
           
   		  return false;
   		});	
         
         $("form#addDayliReport").submit(function(event){
            
   		  //disable the default form submission
   		  event.preventDefault();
   		  //var sapii=document.getElementById('textfield').value;
   		  
   		  //grab all form data  
   		  var formData = new FormData($(this)[0]);
   		  
   		  $.ajax({
            url: 'process-ogs.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (html) {
             $('.listdailyreport').html(html);
             $(".listdailyreport").hide();
             $(".listdailyreport").fadeIn(400);}
             
          });
           
   		  return false;
   		});		
         
         $("form#addWeeklyReport").submit(function(event){
            
   		  //disable the default form submission
   		  event.preventDefault();
   		  var test = CKEDITOR.instances['inforeport'].getData();
   		  
   		  //grab all form data  
   		  var formData = new FormData($(this)[0]);
         formData.set('inforeport', test);
         $.ajax({
            url: 'process-ogs.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (html) {
             $('.listweeklyreport').html(html);
             $(".listweeklyreport").hide();
             $(".listweeklyreport").fadeIn(400);}
             
          });
         
         return false;
      });						
         
         
         $("form#addMontlyReport").submit(function(event){
            
   		  //disable the default form submission
   		  event.preventDefault();
   		  var test = CKEDITOR.instances['inforeport'].getData();
   		  
   		  //grab all form data  
   		  var formData = new FormData($(this)[0]);
         formData.set('inforeport', test);
         $.ajax({
            url: 'process-ogs.php',
            type: 'POST',
            data: formData,
            async: false,
            cache: false,
            contentType: false,
            processData: false,
            success: function (html) {
             $('.listMontlyreport').html(html);
             $(".listMontlyreport").hide();
             $(".listMontlyreport").fadeIn(400);}
             
          });
         
         return false;
      });	
      
      $("form#finance-add").submit(function(event){
            
            //disable the default form submission
            event.preventDefault();
            var desc = CKEDITOR.instances['form-field-224333'].getData();

            //grab all form data  
            var formData = new FormData($(this)[0]);
            var commandStr = formData.get('act') +"#" + formData.get('nameCost') +"#" + formData.get('jmlcost') +"#" + formData.get('currency') +"#" + formData.get('invet_kurs') +"#" + formData.get('jmlcostrupiah') +"#" + formData.get('optionsRadios') +"#" + formData.get('code') +"#" + formData.get('totalcost') +"#" + formData.get('realization') +"#";
            formData.append('stringCommand', commandStr);
            formData.set("richtext1", desc);

            for (var pair of formData.entries()) {
               console.log(pair[0]+ ', ' + pair[1]); 
            }
   
            $.ajax({
               url: 'process-ogs.php',
               type: 'POST',
               data: formData,
               async: false,
               cache: false,
               contentType: false,
               processData: false,
               success: function (html) {
                  console.log(html);
                  $('.listpengeluaran').html(html);
                  $(".listpengeluaran").hide();
                  $(".listpengeluaran").fadeIn(400);}
            });
            
               return false;
           });
         
         CKEDITOR.disableAutoInline = true;
         $('textarea.ckeditor').ckeditor();
         
         $( "#inputnotes" ).hide();
         
         $( "#inputTask" ).hide();
         
         $( "#inputDocument" ).hide();
         $( "#inputSlideshow" ).hide(); 
         
         
         
         
         $(".search-select").select2({
          placeholder: "Select a Participant",
          allowClear: true
       });
         

         

         $('.date-picker').datepicker({
    //comment the beforeShow handler if you want to see the ugly overlay
    beforeShow: function() {
       setTimeout(function(){
         $('.ui-datepicker').css('z-index', 99999999999999);
      }, 0);
    }
 });

         
         
         
      });



function slideAddnoted(){
   
   if ( $( "#inputnotes:first" ).is( ":hidden" ) ) {
      
      $("#tombolnotes").toggleClass('fa-minus fa-plus');
      $( "#inputnotes" ).slideDown( "slow" );
      CKEDITOR.disableAutoInline = true;
      $('textarea.ckeditor').ckeditor();
      
   } else {
    $('#inputnotes').slideUp('slow');
    
    $("#tombolnotes").toggleClass('fa-plus fa-minus');
 }
 
 
}
function slideAddDocument(){
   
   if ( $( "#inputDocument:first" ).is( ":hidden" ) ) {
      
      
      $( "#inputDocument" ).slideDown( "slow" );
      CKEDITOR.disableAutoInline = true;
      $('textarea.ckeditor').ckeditor();
      
      if ( $( "#inputSlideshow:first" ).is( ":hidden" ) ) {
         
      }else{
         slideAddSlime();
      }
      
      
   } else {
    $('#inputDocument').slideUp('slow');
    
 }
}


function slideAddSlime(){
   
   if ( $( "#inputSlideshow:first" ).is( ":hidden" ) ) {
      
      
      $( "#inputSlideshow" ).slideDown( "slow" );
      
      
      if ( $( "#inputDocument:first" ).is( ":hidden" ) ) {
         
      }else{
         slideAddDocument();
      }
      
      
   } else {
    $('#inputSlideshow').slideUp('slow');
    
 }
}



function slideAddTask(){
   
   if ( $( "#inputTask:first" ).is( ":hidden" ) ) {
      
      $("#tomboltask").toggleClass('fa-minus fa-plus');
      $( "#inputTask" ).slideDown( "slow" );
      CKEDITOR.disableAutoInline = true;
      $('textarea.ckeditor').ckeditor();
      
   } else {
    $('#inputTask').slideUp('slow');
    
    $("#tomboltask").toggleClass('fa-plus fa-minus');
 }
 
 
}







function tesmotong(nameClass,modul){
   
   $.get("php2/input_drawing.php", {modul:modul} , function(html) {
    $('.' + nameClass ).html(html);
    $("." + nameClass).hide();
    $("." + nameClass).fadeIn(400);});
   
}
</script>
<script type="text/javascript">
   //put array into javascript variable
   var Index = function () {
   // function to initiate Chart 1
   
   // function to initiate Full Calendar
   var runFullCalendar = function () {
       //calendar
       /* initialize the calendar
       -----------------------------------------------------------------*/
       var $modal = $('#event-management');
       $('#event-categories div.event-category').each(function () {
           // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
           // it doesn't need to have a start or end
           var eventObject = {
               title: $.trim($(this).text()) // use the element's text as the event title
            };
           // store the Event Object in the DOM element so we can get to it later
           $(this).data('eventObject', eventObject);
           // make the event draggable using jQuery UI
           $(this).draggable({
            zIndex: 999,
               revert: true, // will cause the event to go back to its
               revertDuration: 50 //  original position after the drag
            });
        });
       /* initialize the calendar
       -----------------------------------------------------------------*/
       var date = new Date();
       var d = date.getDate();
       var m = date.getMonth();
       var y = date.getFullYear();
       var form = '';
       var calendar = $('#calendar').fullCalendar({
          buttonText: {
            prev: '<i class="fa fa-chevron-left"></i>',
            next: '<i class="fa fa-chevron-right"></i>'
         },
         header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
         },
         events: [<?php echo $stringevent;?>]
         ,
         editable: true,
           droppable: true, // this allows things to be dropped onto the calendar !!!
           drop: function (date, allDay) { // this function is called when something is dropped
               // retrieve the dropped element's stored Event Object
               var originalEventObject = $(this).data('eventObject');
               var $categoryClass = $(this).attr('data-class');
               // we need to copy it, so that multiple events don't have a reference to the same object
               var copiedEventObject = $.extend({}, originalEventObject);
               // assign it the date that was reported
               copiedEventObject.start = date;
               copiedEventObject.allDay = allDay;
               if ($categoryClass)
                 copiedEventObject['className'] = [$categoryClass];
               // render the event on the calendar
               // the last `true` argument determines if the event "sticks" (http://arshaw.com/fullcalendar/docs/event_rendering/renderEvent/)
               $('#calendar').fullCalendar('renderEvent', copiedEventObject, true);
               // is the "remove after drop" checkbox checked?
               if ($('#drop-remove').is(':checked')) {
                   // if so, remove the element from the "Draggable Events" list
                   $(this).remove();
                }
             },
             selectable: false,
             selectHelper: true,
             select: function (start, end, allDay) {
               $modal.modal({
                 backdrop: 'static'
              });
               form = $("<form></form>");
               form.append("<div class='row'></div>");
               form.find(".row").append("<div class='col-md-6'><div class='form-group'><label class='control-label'>New Event Name</label><input class='form-control' placeholder='Insert Event Name' type=text name='title'/></div></div>").append("<div class='col-md-6'><div class='form-group'><label class='control-label'>Category</label><select class='form-control' name='category'></select></div></div>").find("select[name='category']").append("<option value='label-default'>Work</option>").append("<option value='label-green'>Home</option>").append("<option value='label-purple'>Holidays</option>").append("<option value='label-orange'>Party</option>").append("<option value='label-yellow'>Birthday</option>").append("<option value='label-teal'>Generic</option>").append("<option value='label-beige'>To Do</option>");
               $modal.find('.remove-event').hide().end().find('.save-event').show().end().find('.modal-body').empty().prepend(form).end().find('.save-event').unbind('click').click(function () {
                 form.submit();
              });
               $modal.find('form').on('submit', function () {
                 title = form.find("input[name='title']").val();
                 $categoryClass = form.find("select[name='category'] option:checked").val();
                 if (title !== null) {
                   calendar.fullCalendar('renderEvent', {
                    title: title,
                    start: start,
                    end: end,
                    allDay: allDay,
                    className: $categoryClass
                           }, true // make the event "stick"
                           );
                }
                $modal.modal('hide');
                return false;
             });
               calendar.fullCalendar('unselect');
            },
            
         });
    };
    return {
     init: function () {
      
       runFullCalendar();
    }
 };
}();

   //inputcomment
   
   function appendcommentdrawa(thisValue,nilaii)
   {
    var cb = document.createElement( "input" );
    cb.type = "checkbox";
    cb.id = "id";
    cb.value = nilaii ;
    cb.className ="fancy-checkbox";
    cb.checked = true;
    cb.onclick = function (e)
    {
   testingvalue(); //update object array
   this.parentElement.removeChild(this);
   
   link.parentNode.removeChild(link);
   return true;
}



var link=document.createElement("a");
link.appendChild(document.createTextNode(thisValue ));
link.href = 'enginerrview.php?module=read&kon=<?php echo $projectID ;?>&gam=' + nilaii;
link.target='_blank';

var newP = document.createElement("p");
document.getElementById( 'append' ).appendChild( newP );
document.getElementById( 'append' ).appendChild( link );
document.getElementById( 'append' ).appendChild( cb );
var datass = document.getElementById("objek_array").value;

if (datass.length > 0 ) {
   document.getElementById('objek_array').value=document.getElementById("objek_array").value + ',' + nilaii;
}else {
   document.getElementById('objek_array').value=document.getElementById("objek_array").value + nilaii;
}
}   
</script>		
<script src="../js/taginput.js"></script>
<style>
   .message-row {
      padding: 2px 0 2px 22px;
      background-position: 0 center !important;
   }
   .widget li, .widget dt {
      margin-left: 10px;
   }
   .ico-projectmessage, .ico-message {
      background: transparent url(assets/images/message.png) no-repeat !important;
   }
   .ico-projectmessage, .ico-pdf {
      background: transparent url(assets/images/application-pdf.png) no-repeat !important;
   }
   ol, ul ,li{
      list-style: none;
   }
   ul {
      padding-left: 20px;
      list-style: square;
   }
   span.member-path {
      font-size: 10px;
      margin: 0 2px;
      padding: 1px 2px;
      white-space: nowrap;
      border-radius: 3px;
   }
   .og-wsname-color-22, .og-wsname-color-22 a {
      color: #636330;
      background-color: #E8E8C0;
      border-color: #636330;
   }
   .ico-read {
      background: transparent url("assets/images/read.png") no-repeat scroll 0px 5px;
      cursor: pointer;
   }
   .ico-unread {
      background: transparent url("assets/images/unread.png") no-repeat scroll 0px 5px;
      cursor: pointer;
   }
   #result {
      height:20px;
      font-size:16px;
      font-family:Arial, Helvetica, sans-serif;
      color:#333;
      padding:5px;
      margin-bottom:10px;
      background-color:#FFFF99;
   }
   .suggestionsListcomment {
      position:relative;
      left: 0px;
      width: 170px;
      padding:0px;
      width: 500px;
      background-color: #999999;
   }
   .suggestionsListgambar {
      position:relative;
      left: 0px;
      width: 400px;
      padding:0px;
      background-color: #999999;
   }
   .suggestionsListcomment {
      margin: 0px;
      padding: 0px;
   }
   .suggestionsListgambar {
      margin: 0px;
      padding: 0px;
   }
   .suggestionsListcomment ul li {
      list-style:none;
      margin: 0px;
      padding: 6px;
      border-bottom:1px dotted #666;
      cursor: pointer;
   }
   .suggestionsListgambar ul li {
      list-style:none;
      margin: 0px;
      padding: 6px;
      border-bottom:1px dotted #666;
      cursor: pointer;
   }
   .suggestionsListcomment ul li:hover {
      background-color: #FC3;
      color:#000;
   }
   .suggestionsListgambar ul li:hover {
      background-color: #FC3;
      color:#000;
   }

   .suggestField {
      position:relative;
      left: 0px;
      padding:0px;
      margin:0px;
      background-color: #999999;
   }

   .suggestField ul li:hover {
      background-color: #FC3;
      color:#000;
   }

   .suggestField ul li {
      list-style:none;
      margin: 0px;
      padding: 6px;
      border-bottom:1px dotted #666;
      cursor: pointer;
   }

</style>


<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
   google.charts.load('current', {'packages':['corechart','gauge']});
   <?php
   if (in_array(4, $permisionPieace)) { 
      $strcostincomeBulan="google.charts.setOnLoadCallback(drawVisualization);
      function drawVisualization() {
             // Some raw data (not necessarily accurate)
        var data = google.visualization.arrayToDataTable([
        ['month','Cost', 'income'],
        $sAcumulasi
        ]);
        var options = {
           title : ' ',
           vAxis: {title: ''},
           hAxis: {title: 'Month'},
           seriesType: 'bars',
           series: {5: {type: 'line'}}
        };
        
        var chart = new google.visualization.ComboChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
     }";
     echo $strcostincomeBulan ;	  
  }	  
  
  
  if (in_array(4, $permisionPieace)) {
   $str123CostIncome="  
   google.setOnLoadCallback(drawChart2);
   function drawChart2() {
     var datas = google.visualization.arrayToDataTable([
     ['Cost', 'Income'],
     $strJsonMap2
     ]);
     var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
     chart.draw(datas);
  }";
  echo $str123CostIncome;
}	
if (in_array(8, $permisionPieace)) {
   echo C_chartGoogle("chart_div5",$strDrawingjson,"drawChartunixdraw");
}
if (in_array(12, $permisionPieace)) {
   echo C_chartGoogle("chart_div6",$strallDrawingtypejson,"drawChartAlldraw");
}
if (in_array(9, $permisionPieace)) {
   echo C_chartGoogle("chart_div7",$strCommentjson,"drawChartAllcomment");
}
if (in_array(10, $permisionPieace)) {
      	//echo C_chartGoogle("chart_div8",$strTechnicaljson,"drawChartAlltechnical");
  echo "refreshTechnicalAskDashboar($projectID);";
  
      	//refreshTechnicalAskDashboar($projectID);
}
if (in_array(24,$permisionPieace)){
   
   echo C_chartGoogle("chart_div18",$strSurveyjson,"drawChartAllSurvey");
}
?>

</script>

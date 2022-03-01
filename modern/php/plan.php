<?php
$pagenum_id=14;
$Users->cekSecuritypeage($user_id,$pagenum_id);
			echo set_java_script_plugin_load ("table"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("modal"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
			echo set_java_script_plugin_load ("form"); //JAVASCRIPTS REQUIRED FOR THIS PAGE ONLY
		
			
			
			$listUsers=$Users->get_Active_users();
			
			$idactive = $kpi->GetActivePlanPeriode();
			$idperiode=$idactive;
			$activeplns = $kpi->GetPlanperiode($idactive);
			$listTrainings= $kpi->getBudgetOf($idperiode);
			$listInvests = $kpi->getInvestation($idperiode);
			foreach($activeplns as $activepln){
				$start=$activepln['start'];
				$end=$activepln['end'];
			}
			
			$CurrentRealization=$kpi->GetCurrentRealization($start,$end);
			$sumbudgeting=$kpi->GetTotalPlanBudget($idactive);
			$percent= $CurrentRealization / $sumbudgeting * 100 ;
			
			
			$periode = $idactive ;
			$listTriyan=$kpi->GetPlanPerPerson(36,$periode);
			$stringPlanPeople = "<table class='table table-hover' id='sample-table-1'>
										<thead>
											<tr> 
												<th class='center'>#</th>
												<th class='hidden-xs'>Event</th>
												<th >Type</th>
												
												<th >Rp.</th>
												<th class='center hidden-xs' >Status</th>
											</tr>
										</thead><tbody>";
									$n=1;
									foreach($listTriyan as $listTriya){
									$nameEvent=$namakegiatan[$listTriya['typeOfevent']];
									$tanggalPlan= date("d M Y",strtotime($listTriya['tanggalStart']));
									 if ($listTriya['status']==1){
										$status	="DN" ;
									 }else{
										$status	="NY" ;
									 }
									 $money=$kpi->custom_number_format($listTriya['total']);
								
											$stringPlanPeople= $stringPlanPeople . "<tr>
												<td class='center'>$n</td>
												<td class='hidden-xs'>$listTriya[training]</td>
												<td>$nameEvent</td>
												
												<td >$money</td>
												<td class='center hidden-xs'>$status</td>
												
											</tr>"   ;
									$n++;		
									} 	
			$stringPlanPeople = $stringPlanPeople .  "</tbody></table>";

//plan per event
$head="<table class='table table-condensed table-hover' id='sample-table-3'><thead><tr><th>#</th>";

for ($x = 1; $x <= 9; $x++) {
    $head=$head .  "<th>" . $namakegiatan[$x] .  "</th>";
	//gae mapptree
	$listtreInduk=$listtreInduk   . "['" . $namakegiatan[$x] . "','Global". "',0"  . ",0]," . "\n" ;
} 
$head=$head . "</tr></thead><tbody>";
//echo $head;
$listKpis=$kpi->getBudgetOf($idperiode,"jenis");
foreach($listUsers as $listUser){
	$idusernya=$listUser['id_user'];
	//$alluserArray[$idusernya]=$listUser['nama'];
	$head=$head . "<tr>";
		
		$head=$head . "<td>".$listUser['nama'] . "</td>";	
		for ($x = 1; $x <= 9; $x++) {
			$n=0;
			$r=0;
			foreach ($listKpis as $listKpi){
			
				$pos = strpos($listKpi['peserta'], "," . $idusernya);
				if (($pos!==false)&& ($x==$listKpi['jenis'])){
					$n= $n+1;
					if ($listKpi['realisasiStart']!="0000-00-00 00:00:00"){
					$r=$r +1 ;	
					}
				}
			
			}
		$head=$head . "<td class='center'>".$n . " / " . $r. "</td>";	
		
		} 
										
	$head=$head . "</tr>"   ;
	
}
$stringPeople=$head . "</tbody></table>";	

//######################RealizationPlan

	$sRealizationPlan= "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
											
												<th > Title</th>
												<th > Event</th>
												<th title='realization'> Reali.</th>
												<th > People</th>
												<th > Anggaran</th>


											</tr>
										</thead>
										<tbody>"; 
										
										foreach($listTrainings as $listTraining ){
											if 	 ($listTraining['realisasiStart']!="0000-00-00 00:00:00"){
												$peserta= Extractusername($alluserArray,$listTraining[peserta]);
												$titlePeserta=$peserta;
												if (strlen($peserta)>50){
												
												$peserta=substr($peserta,0,50) . ".." ;
												}									

												$tanggalPlan= date("d M Y",strtotime($listTraining['realisasiStart']));
												$nameEvent=$namakegiatan[$listTraining['typeOfevent']];
												$anggaran = "Rp " . number_format($listTraining['total'],2,',','.');
												$sRealizationPlanisi= $sRealizationPlanisi . " <tr>

														<td >$listTraining[training]</td>
														<td>$nameEvent</td>
														<td>$tanggalPlan</td>
														<td title='$titlePeserta'>$peserta</td>
														<td>$anggaran</td>
														
													</tr>";
											}else {
												$peserta= Extractusername($alluserArray,$listTraining[peserta]);
												$titlePeserta=$peserta;
												if (strlen($peserta)>50){
												
												$peserta=substr($peserta,0,50) . ".." ;
												}									
												$label= labelStyle($listTraining['status'],$listTraining['tanggalStart']);
												$tanggalPlan= date("d M Y",strtotime($listTraining['tanggalStart']));
												$nameEvent=$namakegiatan[$listTraining['typeOfevent']];
												$anggaran = "Rp " . number_format($listTraining['total'],2,',','.');
												$sunRealizationPlanisi= $sunRealizationPlanisi . " <tr>

														<td >$listTraining[training]</td>
														<td>$nameEvent</td>
														<td>$tanggalPlan $label </td>
														<td title='$titlePeserta'>$peserta</td>
														<td>$anggaran</td>
														
													</tr>";												
												
												
											}
										//insert function world
										
										
										$listWorld= $listWorld . "['" . $listTraining['negara']  . "$listTraining[lokasi]'," ;
										$listWorld = $listWorld . "'" . $titlePeserta . " : " . $anggaran . " / " . $listTraining['training'] ."']," . "\n" ;
										
										//['China',     'Asia',               36,                              4],
										
										$listtreMapTraining=$listtreMapTraining   . "['" . $listTraining['training'] . " $anggaran ','" . $nameEvent . "'," . $listTraining['total'] . ",0]," . "\n" ;
										
										}
										
										
								foreach($listInvests  as $listInvest ){
											if 	 ($listInvest['realization']!="0000-00-00 00:00:00"){
												if($listInvest['type']==1){ 
													$nameEvent="Barang" ;
												}else{
													$nameEvent="Jasa" ;
												}
												$peserta= Extractusername($alluserArray,$listInvest['oleh']);
												$anggaran = "Rp " . number_format($listInvest['total'],2,',','.');
											
												$sRealizationInvestisi= $sRealizationInvestisi . " <tr>

														<td >$listInvest[item]</td>
														<td>$nameEvent</td>
														<td> - </td>
														<td>$peserta</td>
														<td>$anggaran</td>
														
													</tr>";										
											}else{
												if($listInvest['type']==1){ 
													$nameEvent="Barang" ;
												}else{
													$nameEvent="Jasa" ;
												}
												$peserta= Extractusername($alluserArray,"," . $listInvest['oleh']);
												$anggaran = "Rp " . number_format($listInvest['total'],2,',','.');
											
												$sunRealizationInvestisi= $sunRealizationInvestisi . " <tr>

														<td >$listInvest[item]</td>
														<td>$nameEvent</td>
														<td> - </td>
														<td>$peserta</td>
														<td>$anggaran</td>
														
													</tr>";																					
											}
								
								$listtreMapInvest=$listtreMapInvest   . "['" . $listInvest['item'] . " $anggaran ','" . "Invest" . "'," . $listInvest['total'] . ",0]," . "\n" ;
													
								}

								
							$sRealizationPlans= $sRealizationPlan . $sRealizationPlanisi . $sRealizationInvestisi . "</tr></tbody></table>";	
							$sunRealizationPlan= $sRealizationPlan . $sunRealizationPlanisi . $sunRealizationInvestisi . "</tr></tbody></table>";


//Costyang telah terbit..

$listcosts=$kpi->getCost($periode,"idKegiatan");
$listcostInvest=$kpi->getCostInvest($periode,"idKegiatan");

			$stringCostTraining = "<table class='table table-hover' id='sample-table-1'>
										<thead>
											<tr>
												
												<th class='hidden-xs'>Title</th>
												<th >Type</th>
												<th title='assosiated'>Assos.</th>
												<th class='center'>Rp.</th>
												
											</tr>
										</thead><tbody>";
									$n=1;
									foreach($listcosts as $listTriya){
									$nameEvent=$namakegiatan[$listTriya['typeOfevent']];
									

									 $money=$kpi->custom_number_format($listTriya['total']);
								
											$stringCostTraining= $stringCostTraining . "<tr>
												
												<td>$listTriya[nam]</td>
												<td  class='hidden-xs' >$nameEvent</td>
												<td class='hidden-xs'>$listTriya[training]</td>
												<td title='usulan $listTriya[training] : $listTriya[usulan]' class='center'>$money</td>

												
											</tr>"   ;
									$n++;		
									}

									foreach($listcostInvest as $listTriya){
									
									if ($listTriya['tipeKegiatan']==1){
										$nameEvent="barang";
									}else{
										$nameEvent="jasa";
									}
									

									 $money=$kpi->custom_number_format($listTriya['total']);
								
											$stringCostTraining= $stringCostTraining . "<tr>
												
												<td>$listTriya[nam]</td>
												<td  class='hidden-xs' >$nameEvent</td>
												<td class='hidden-xs'>$listTriya[item]</td>
												<td  title='usulan $listTriya[item] : $listTriya[usulan]' class='center'>$money</td>

												
											</tr>"   ;
									$n++;		
									}

			$stringCostTraining = $stringCostTraining .  "</tbody></table>";
							


//graf pencapain

$mulai = $month = strtotime($start);
$akhir = strtotime($end );
$jumlahakumalasiBudget=0;
while($month < $akhir)
{
     //echo date('F Y', $month), PHP_EOL;
     $snamabulan= date('M y', $month);
	 
	 
	 
	 $jumlahCostPerbulan=0 ;
	 $jumlahInvestPerbulan=0;
	 $nextmonth=strtotime("+1 month", $month);
	 //$nextmonth=strtotime("01" .  $nextmonth);
	 
	 foreach( $listcosts as  $listcost){
		 
		 
		 if ((strtotime($listcost['realisation'])>= strtotime("01" . $snamabulan))&& (strtotime($listcost['realisation'])< strtotime("01" . date('M y',$nextmonth)) )) {
			 
			 $jumlahCostPerbulan=$jumlahCostPerbulan + $listcost['total'];
			 
		 }
		 
	 }

	 foreach( $listcostInvest as $listcostInves){
		 
		 if ((strtotime($listcostInves['realisation'])>= strtotime("01" . $snamabulan))&& (strtotime($listcostInves['realisation'])< strtotime("01" . date('M y',$nextmonth)) )) {
			 
			 $jumlahInvestPerbulan=$jumlahInvestPerbulan + $listcostInves['total'];
			 
		 }
		 
	 }	

	$jumlahcostInvest=	$jumlahCostPerbulan + $jumlahInvestPerbulan ;
	 
	 $jumlahakumalasiBudget=$jumlahakumalasiBudget + $jumlahcostInvest ;
	 
	 $sAcumulasi= $sAcumulasi . "['$snamabulan',  $jumlahCostPerbulan , $jumlahInvestPerbulan , $jumlahcostInvest, $jumlahakumalasiBudget ,  ]," ; 

	 
	 
	 $month = $nextmonth ;
}


							
?>
		


					<script src='js/plan.js'></script>
					<script type="text/javascript" src="https://www.google.com/jsapi"></script>

					<script type="text/javascript">
      google.load("visualization", "1", {packages:["treemap"]});
      google.setOnLoadCallback(drawChart);
      function drawChart() {
        var data = google.visualization.arrayToDataTable([
          ['Location', 'Parent', 'Market trade volume (size)', 'Market increase/decrease (color)'],
          ['Global',    null,                 0,                               0],
          ['Invest',    'Global',             0,                               0],
		  <?php echo $listtreInduk ;?>
		  <?php echo $listtreMapTraining ;
		  echo $listtreMapInvest ;
		  ?>
        ]);

        tree = new google.visualization.TreeMap(document.getElementById('chart_div'));

        tree.draw(data, {
          minColor: '#f00',
          midColor: '#ddd',
          maxColor: '#0d0',
          headerHeight: 15,
          fontColor: 'black',
          showScale: true
        });

		
	
      }
	  
	  	
		google.load('visualization', '1', { 'packages': ['map'] });
    google.setOnLoadCallback(drawMap2);

    function drawMap2() {
      var data = google.visualization.arrayToDataTable([
        ['Country', 'Description'],
		<?php echo $listWorld ; ?>
      ]);

    var options = { showTip: true };

    var map = new google.visualization.Map(document.getElementById('chart_div2'));

    map.draw(data, options);
  };

		
google.load("visualization", "1", {packages:["corechart"]});
      google.setOnLoadCallback(drawChart3);
      function drawChart3() {
        var data = google.visualization.arrayToDataTable([
          ['Month', 'Plan' , 'Invest', 'Monthly', 'Sum'   ],
<?php echo  $sAcumulasi ; ?>
        ]);

        var options = {
          title: 'Cost Deliver',
          hAxis: {title: 'Month',  titleTextStyle: {color: '#333'}},
          vAxis: {minValue: 0}
        };

        var chart = new google.visualization.AreaChart(document.getElementById('chart_div3'));
        chart.draw(data, options);
      }
		
		
		
		
		
		
    </script>


					<div class="page-header">
								<h1>Plan & Budgeting <small>Create Plan over years</small></h1>
							</div>
							<!-- end: PAGE TITLE & BREADCRUMB -->
						</div>
					</div>
			<!-- end: PAGE HEADER -->
					<!-- start: PAGE CONTENT -->
					
					<div class="row">
						
						<div class="col-sm-12">
							<div class="tabbable">
								<ul class="nav nav-tabs tab-padding tab-space-3 tab-blue" id="myTab4">
									<li class="active" id="taboverview" >
										<a data-toggle="tab" href="#panel_overview">
											Dashboard
										</a>
									</li>
									<li  id="tabnEvent" >
										<a data-toggle="tab" href="#evenplan">
											Event Plan
										</a>
									</li>
									<li  id="tabnotes">
										<a data-toggle="tab" href="#invest">
											Invest Plan
										</a>
									</li>
																	
									
								</ul>
								<div class="tab-content">
									<div id="evenplan" class="tab-pane">
										<div class="row">	
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Insert Plan"); ?>
								<div class="panel-body">
								
										<form role="form" class="form-horizontal">
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Event Name :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Name of Event" id="form-field-1" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Type of Event :
											</label>
											<div class="col-sm-9">
												<select id="form-field-select-3" class="form-control" >
										
											<option value="1">Training</option>
											<option value="2">Schooling</option>
											<option value="3">Sidang</option>
											<option value="4">Meeting</option>
											<option value="5">Committee</option>
											<option value="6">Attendance</option>
											<option value="7">Presentation</option>
											<option value="8">Project or Research</option>
											<option value="9">launcing</option>
											<option value="10">Other</option>

										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Type of topic :
											</label>
											<div class="col-sm-9">
												<select id="form-field-select-14" class="form-control" >
										
											<option value="1">Structure</option>
											<option value="2">Stability</option>
											<option value="3">Machinery</option>
											<option value="4">Offshore</option>
											<option value="5">Other</option>

										</select>
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
												Participant :
											</label>
											<div class="col-sm-9">
											<select multiple="multiple" id="form-field-select-4" class="form-control search-select" name="sapi[]">
											<?php foreach($listUsers as $listUser){
											
											echo "<option value='$listUser[id_user]'>$listUser[nama]</option>"   ;
											
											} 
											echo "<option value='0'>ALL RND Member</option>";
											?>
											
										</select>
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Location :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Place that event held" id="location" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Country :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Country that event held" id="country" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Amount :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Total Amount" id="amount" class="form-control currency">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Currency :
											</label>
											<div class="col-sm-9">
												<select id="form-field-select-2" class="form-control" >
										
											<option value="1">Rupiah</option>
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
												<input type="text" placeholder="Kurs prediction" id="kurs" class="form-control currency">
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
										<a class="btn btn-blue"  onclick="addAplan();"><i class="fa fa-plus"></i>
											Submit Entry</a>
											</p>
											</div>
											
										</div>
										
										
										
									</form>	
											
									</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>				
							
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Plan"); ?>
								<div class="panel-body">
								<div id="training" class="training">
								<?php 	echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											<tr>
												<th > ID</th>
												<th > Title</th>
												<th > Event</th>
												<th > Plan</th>
												<th > Participant</th>
												<th > Status</th>
												<th > Anggaran</th>
												<th class='center' width='100px'> Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										
										
										$n=1;
										foreach($listTrainings as $listTraining ){
										
										$peserta= Extractusername($alluserArray,$listTraining[peserta]);
										$titlePeserta=$peserta;
										if (strlen($peserta)>50){
										
										$peserta=substr($peserta,0,50) . ".." ;
										}									
										 
										$label= labelStyle($listTraining['status'],$listTraining['tanggalStart']);
										$tanggalPlan= date("d M Y",strtotime($listTraining['tanggalStart']));
										$nameEvent=$namakegiatan[$listTraining['typeOfevent']];
										$anggaran = "Rp " . number_format($listTraining['total'],2,',','.');
										echo " <tr>
												<td>$n</td>
												<td title='$listTraining[description]' > <a href='panel.php?module=dEvent&id=$listTraining[id]' >  $listTraining[training]</a></td>
												<td>$nameEvent</td>
												<td>$tanggalPlan</td>
												<td title='$titlePeserta'>$peserta</td>
												<td title='held at : $listTraining[realisasiStart]'>$label</td>
												
												<td>$anggaran</td>
												<td class='center'>
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
												
													<a  onclick='dellPlan($listTraining[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
										}
							echo "	</tr>
										</tbody>
									</table>";		
									?>
								</div>
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					
					
					</div>
					</div>
									<div id="invest" class="tab-pane ">
										<div class="row">	
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("Insert Invest"); ?>
								<div class="panel-body">
								
										<form role="form" class="form-horizontal">
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Item :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Name of Event" id="invet_itemname" class="form-control">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Type  :
											</label>
											<div class="col-sm-9">
												<select id="invet_type" class="form-control" >
										
											<option value="1">Barang</option>
											<option value="2">Jasa</option>


										</select>
											</div>
										</div>
										
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Amount :
											</label>
											<div class="col-sm-9">
												<input type="text" placeholder="Total Amount" id="invet_amount" class="form-control currency">
											</div>
										</div>
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Currency :
											</label>
											<div class="col-sm-9">
												<select id="invet_curency" class="form-control" >
										
											<option value="1">Rupiah</option>
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
												<input type="text" placeholder="Kurs prediction" id="invet_kurs" class="form-control currency">
											</div>
										</div>											
										<div class="form-group">
											<label class="col-sm-2 control-label" for="form-field-1">
												Description :
											</label>
										  <div class="col-sm-9">
												<textarea placeholder="Description of training here" id="pesanndede" name="pesanndede" class="ckeditor form-control"></textarea>
											    <label>
											   
											    </label>
												<p>
										<a class="btn btn-blue"  onclick="addInvest();"><i class="fa fa-plus"></i>
											Submit Entry</a>
											</p>
											</div>
											
										</div>
										
										
										
									</form>	
											
									</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>				
							
							
							<div class="col-md-12">	
							<!-- start: DYNAMIC TABLE PANEL -->
							<div class="panel panel-default">
								<?php echo writePanel("List Investasi"); ?>
								<div class="panel-body">
								<div id="investasi" class="investasi">
								<?php 	echo "
									<table class='table table-striped table-bordered table-hover table-full-width' id='sample_2'>
										<thead>
											<tr>
												<th > ID</th>
												<th > Item</th>
												<th > Type </th>
												<th > anggaran</th>
												<th > Status</th>
												<th > By</th>
												<th width='100px' class='center' > Action</th>

											</tr>
										</thead>
										<tbody>"; 
										
										$idperiode=$kpi->GetActivePlanPeriode();
										$listTrainings= $kpi->getInvestation($idperiode);
										
										$n=1;
										foreach($listTrainings as $listTraining ){
										
										$peserta= $alluserArray[$listTraining['oleh']];;
										$titlePeserta=$peserta;
										if (strlen($peserta)>50){
										
										$peserta=substr($peserta,0,50) . ".." ;
										}									
										 
										$label= labelStyle($listTraining['status'],$listTraining['tanggalStart']);
										$tanggalPlan= date("d M Y",strtotime($listTraining['tanggalStart']));
										
										if ($listTraining['type']==1) {
											$nameEvent= "Barang" ;
										}else {
											$nameEvent= "Jasa" ;
										}
										if ($listTraining['realization']!="0000-00-00") {
											$status= "Complete" ;
										}else {
											$status= "Not yet" ;
										}
										
										echo " <tr>
												<td>$n</td>
												<td title='$listTraining[description]' >   $listTraining[item]</td>
												<td>$nameEvent</td>
												<td>$listTraining[total]</td>
												<td >$status</td>
												<td >$peserta</td>
												<td class='center'>
												<div class='visible-md visible-lg hidden-sm hidden-xs'>
													<a  onclick='dellInvest($listTraining[id]);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Remove'><i class='fa fa-times fa fa-white'></i></a>
												</div>
												
												
												
												</td>
												
											</tr>";
										
										$n++;
										}
									echo "</tr>
										</tbody>
									</table>";		
									?>
								</div>
								</div>
							</div>
							<!-- end: DYNAMIC TABLE PANEL -->
						</div>
					
					
					</div>
					</div>					
									<div id ="panel_overview" class="tab-pane in active" >
<div class="row">


<div class="col-sm-12">
<h2  align="center">Plan <?php echo date("d M Y",strtotime($start)) . " to " . date("d M Y",strtotime($end)) ?></h2>
							<!-- start: TEXT FIELDS PANEL -->
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="fa fa-external-link-square"></i>
									Map of budgeting
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
								<div class="panel-body">
									<div id="chart_div" style="width: 100%; height: 500px;"></div>

								</div>
							</div>
							<!-- end: TEXT FIELDS PANEL -->
						</div>
						
						<div class="col-sm-7">
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-stats"></i>
									Plan Accros world
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
								
								<div id="chart_div2" style="width: 100%; height: 500px;"></div>						
							
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-stats"></i>
									Map Realization
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
								<div id="latetask" class="latetask">
									<div id="chart_div3" style="width: 100%; height: 300px;"></div>
									</div>
										
									
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-calendar"></i>
									People vs Realization
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
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
								<div class="panel-body">
									<?php echo $stringPeople ;?>
								</div>
							</div>
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-calendar"></i>
									Realization
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
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
								<div class="panel-body">
									<?php echo $sRealizationPlans ; ?>
								</div>
							</div>	
							<div class="panel panel-default">
								<div class="panel-heading">
									<i class="clip-calendar"></i>
									Unrealization
									<div class="panel-tools">
										<a class="btn btn-xs btn-link panel-collapse collapses" href="#">
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
								<div class="panel-body">
									<?php echo $sunRealizationPlan ; ?>
								</div>
							</div>								
						</div>
						

						<div class="col-sm-5">
							<div class="row">
								<div class="col-sm-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="clip-pie"></i>
											Total Budget
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
											<div >
											<h2 style="text-align:center;color:green" ><?php echo thousandsCurrencyFormat($sumbudgeting) ; ?></h2>
											</div>
											
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="clip-bars"></i>
											Realization Plan
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
											<h2 style="text-align:center;color:yellow" ><?php echo thousandsCurrencyFormat($CurrentRealization) ; ?></h2><h3 style="text-align:center;color:blue" ><?php echo round ($percent,1) . "%"  ; ?></h3>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-sm-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="clip-bars"></i>
											People Plan
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
										<select id="team" class="form-control" onChange="peoplechange(this);">
										
											<?php foreach($listUsers as $listUser){
											
											echo "<option value='$listUser[id_user]'>$listUser[nama]</option>"   ;
											
											} ?>
										</select>
										<hr>
										<div id="peopleplan" class="peopleplan">
										<?php echo $stringPlanPeople; ?>
										</div>
										</div>
									</div>
								</div>
							</div>
							
							<div class="row">
								<div class="col-sm-12">
									<div class="panel panel-default">
										<div class="panel-heading">
											<i class="clip-bars"></i>
											Cost 
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
								
											<?php echo $stringCostTraining ; ?>
							
										</div>
																	
									</div>
								</div>
							</div>
						</div>
						</div>									
									</div>
					
					
					
					</div>
					</div>
					</div>
					
					</div>
					<!-- end: PAGE CONTENT-->
				</div>
			</div>
			
			<!-- start: BOOTSTRAP EXTENDED MODALS -->
		
			<!-- end: PAGE -->
	<script>
			jQuery(document).ready(function() {

				Main.init();
				
				TableData.init();
				CKEDITOR.disableAutoInline = true;
				$('textarea.ckeditor').ckeditor();

        $(".search-select").select2({
            placeholder: "Select a Participant",
            allowClear: true
        });

		    //function to initiate daterangepicker
  
        $('.date-range').daterangepicker();
        $('.date-time-range').daterangepicker({
            timePicker: true,
            timePickerIncrement: 15,
            format: 'MM/DD/YYYY h:mm A'
        });

		
				
			});
		</script>					
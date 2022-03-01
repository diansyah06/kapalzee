<?php
if 	($salting  > 4 ) {


	//Load categori.........
	if ($load_kategori = $mysqli->prepare("SELECT id_user, nama FROM og_user where previl != 9 and  previl < ?   ")) {   
	   // Execute the prepared query.
	   		$load_kategori->bind_param('i', $salting ); 
		   $load_kategori->execute();
		   $load_kategori->bind_result($id_userr,$nama );  
		   $kategoris=array();
		   while($load_kategori->fetch()){ $kategoris[]= "<option value='$id_userr' >$nama</option> "; }	
	}
}else {die;}

?>
<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();
            setDatePicker('date-picker');
			setDatePicker('date-picker2');
			setDatePicker('date-picker3');
            $('.datatable').dataTable();
			setSidebarHeight();
			
			
		$(".select3").change(function()
		{


			var name_element = document.getElementById('select');
			var user = name_element.value;
			
			var name_element = document.getElementById('select3');
			var bullannn = name_element.value;
		
			var name_element = document.getElementById('select4');
			var tahuuun = name_element.value;
			
			load_datass(bullannn,tahuuun,user) ;

		
	});
	
			$(".select").change(function()
		{


			var name_element = document.getElementById('select');
			var user = name_element.value;
			
			var name_element = document.getElementById('select3');
			var bullannn = name_element.value;
		
			var name_element = document.getElementById('select4');
			var tahuuun = name_element.value;
			
			load_datass(bullannn,tahuuun,user) ;

		
	});
			
		$(".select4").change(function()
		{


			var name_element = document.getElementById('select');
			var user = name_element.value;
			
			var name_element = document.getElementById('select3');
			var bullannn = name_element.value;
		
			var name_element = document.getElementById('select4');
			var tahuuun = name_element.value;
			
			load_datass(bullannn,tahuuun,user) ;

		
	});
			
			$( "#dialog" ).dialog({autoOpen: false});


        });
</script>

<script type="text/javascript" src="js/cek_po.js"></script>
<script type="text/javascript" src="js/rms_people_kpi.js"></script>
<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="js/jquery-ui/jquery.ui.datepicker.min.js" type="text/javascript"></script>

  <!-- jQuery dialog related-->
  <script src="js/jquery-ui/external/jquery.bgiframe-2.1.2.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.mouse.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.draggable.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.position.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.resizable.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.ui.dialog.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.core.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.blind.min.js" type="text/javascript"></script>
    <script src="js/jquery-ui/jquery.effects.explode.min.js" type="text/javascript"></script>
 <link href="css/fancy-button/fancy-button.css" rel="stylesheet" type="text/css" />


<div class="box round first">
                <h2>
                    Journy Of live </h2>
					
					<form id="form2" name="form2" method="post" action="">
                  <table class="form" >
                    <tr>
                      <td><label>User</label></td>
                      <td><label>
                        <select name="select" id="select" class="select">
						<option> </option>
						 <?php foreach ($kategoris as $isi) { echo $isi ;} ?>
                        </select>
                      </label></td>
                    </tr>
                    <tr>
                      <td><label>Bulan</label></td>
                      <td><label>
                        <select name="select3" class="select3" id="select3" >
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
                          <option value="10">10</option>
                          <option value="11">11</option>
                          <option value="12">12</option>
                        </select>
                      </label></td>
                    </tr>
                    <tr>
                      <td><label>Tahun</label></td>
                      <td><select name="select4" id="select4"  class="select4">
                        <option value="2013">2013</option>
                        <option value="2014">2014</option>
                        <option value="2015">2015</option>
                        <option value="2016">2016</option>
                                            </select></td>
                    </tr>
                  </table>
   </form>
   <hr />
					

 <div class="deskripsi">
				<a href="people/ex_down.php?bul=<?php echo date("m") ; ?> &amp;yr=<?php echo date("Y") ; ?> ">download</a>
	<?php			
	$user_id = $_SESSION['user_id'];
	$year= date("Y");
	$month= date("m");
	
	
	
	$PreviousMonth = mktime(0, 0, 0, $month - 1, 1, $year);
	$CurrentMonth = mktime(0, 0, 0, $month, 1, $year);
	$NextMonth = mktime(0, 0, 0, $month + 1, 1, $year);
	
	$awal=date('Y-m-d', $CurrentMonth);
	$akhir=date('Y-m-d', $NextMonth);
	
				$kpiss=$kpi->get_kpi_user($user_id,$awal,$akhir);
	
	
	   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Nama Kegiatan</th>
											<th>Jenis</th>
											<th>Group</th>
											<th>Start</th>
											<th>Finish</th>
											<th>Surat</th>
											<th>Action</th>
											
											
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($kpiss as $kpis) {
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td title='$kpis[keterangan]'>" . $kpis['name'].  " </a></td>
									<td >". $kpis['jenis']. "</td>
									<td>" . $kpis['Grup'] . "</td>
									<td>" . $kpis['star'] ."</td>
									<td>". $kpis['finish'] ."</td>
									<td>". $kpis['surat']. "</td>
									<td><a href=# onclick='delt($kpis[id_diar]);'>Delete </a>". " |  ". "<a href='#'  onclick=". "show_update(" . $kpis[id_diar] ."); > Close </a> </td>
									
									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table><hr>";
	
	
			 
	 ?>
				</div>
</div>



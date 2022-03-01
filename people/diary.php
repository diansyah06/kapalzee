<?php
$judul=$_POST['textfield'];
$jenis=$_POST['select'];
$group=$_POST['select2'];
$star=$_POST['date-picker'];
$star = date("Y-m-d", strtotime($star));
$finish=$_POST['date-picker2'];
if(isset($finish) & ($finish != "" )){
$finish = date("Y-m-d", strtotime($finish));
}else {$finish= "0000-00-00";}
$surat=$_POST['textfield4'];
$keterangan=$_POST['textarea'];

if(isset($judul)){
$user_id = $_SESSION['user_id'];


$kpi->Create_kpi($judul, $jenis, $group, $star, $finish, $surat, $keterangan, $user_id);

}
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


			
			var name_element = document.getElementById('select3');
			var bullannn = name_element.value;
		
			var name_element = document.getElementById('select4');
			var tahuuun = name_element.value;
			
			load_data(bullannn,tahuuun) ;

		
	});
			
		$(".select4").change(function()
		{


			
			var name_element = document.getElementById('select3');
			var bullannn = name_element.value;
		
			var name_element = document.getElementById('select4');
			var tahuuun = name_element.value;
			
			load_data(bullannn,tahuuun) ;

		
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
                <div class="block">
                    <!-- paragraphs -->
                    <p class="start">
                      This page contain the log of your live and job, fill free to fill. </p>
                    <p>&nbsp;</p>
<form id="form1" name="form1" method="post" action="">

  <table  class="form">
    <tr>
      <td><label>Nama kegiatan </label></td>
      <td><label>
        <input type="text" name="textfield" class="medium" id="textfield"  required/>
      </label></td>
    </tr>
    <tr>
      <td><label>Jenis Kegiatan</label> </td>
      <td><label>
        <select name="select" id="select">
          <option value="1">PENGEMBANGAN RULES</option>
          <option value="2">PENELITIAN</option>
          <option value="3">SEMINAR</option>
          <option value="4">PRESENTASI</option>
          <option value="5">KAJIAN ATURAN NASIONAL DAN INTERNATIONAL</option>
          <option value="6">TRAINING DN</option>
          <option value="7">TRAINING LN</option>
          <option value="8">SUPPORTING DIV TERKAIT</option>
          <option value="9">LAIN-LAIN</option>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><label>Group/individual</label></td>
      <td><label>
      <select name="select2" id="select2">
        <option value="1">WORKING GROUP INTERNAL</option>
        <option value="2">WORKING GROUP EKSTERNAL</option>
        <option value="3">INDIVIDUAL</option>
                  </select>
      </label></td>
    </tr>
    <tr>
      <td><label>Start</label></td>
      <td><label>
        <input type="text" name="date-picker" id="date-picker" value="<?php echo date('m/d/Y') ; ?> "  required/>
      </label></td>
    </tr>
    <tr>
      <td><label>selesai</label></td>
      <td><label>
        <input type="text" name="date-picker2" id="date-picker2" />
      </label></td>
    </tr>
    <tr>
      <td><label>Lampiran no surat tugas /tanggal</label> </td>
      <td><label>
        <input type="text" name="textfield4"  class="medium" id="textfield4"  />
      </label></td>
    </tr>
    <tr>
      <td><label>keterangan</label></td>
      <td><label>
        <textarea name="textarea" rows="15" cols="55"  id="textarea" ></textarea>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="submit" name="Submit" value="Submit" />
      </label></td>
    </tr>
  </table>
</form>

                     <label>
                   
                     </label>
   </div>
 </div>
 
 <div class="box round">
                <h2>
                    List Of kegiatan </h2>
					
					
                <form id="form2" name="form2" method="post" action="">
                  <table class="form" >
                    <tr>
                      <td><label>Bulan</label></td>
                      <td><label>
                        <select name="select3" class="select3" id="select3" >
						  <option value="<?php printf("%2s", (date('m') )); ?>"><?php printf("%2s", (date('m') )); ?></option>
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
					    <option value="<?php echo date("Y"); ?>"><?php echo date("Y"); ?></option>
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
				
<div id="dialog" title="Close Pekerjaan"  class="ui-widget">
                                    <p>
                                       <form id="form1" name="form1" method="post" action="">
  <table id="form" >
   <tr>
      <td>Tanggal Selesai </td>
      <td width="392"><label>
      <input type="text"  name="date-picker3" id="date-picker3" />
      </label></td>
    </tr>
  
    <tr>
      <td>&nbsp;</td>
      <td width="392"><label><input name="id_diar"  id="id_diar"type="hidden" value="" /></label></td>
    </tr>
    <tr>
      <td></td>
      <td><input name="ssds" type="button"  value="Close" onclick="close_pro();"/></td>
    </tr>
  </table>
</form></p>
                                </div>
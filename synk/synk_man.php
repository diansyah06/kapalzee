<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();
			$('.datatable').dataTable();
			$('.datatableee').dataTable();
			$('.datatableggg').dataTable();
			

          
			setSidebarHeight();
			
			$( "#dialog" ).dialog({autoOpen: false});


        });
</script>


<script src="js/sync_js.js" type="text/javascript"></script>
<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>

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
                    Sync Rules with TelikSandi</h2>
   <div class="block">
                    <!-- paragraphs -->
                    <p class="start">&nbsp;</p>
                    <form id="form1" name="form1" method="post">
                       <table class="form">
                         <tr>
                           <td width="58" >&nbsp;</td>
                           <td width="219">&nbsp;</td>
                         </tr>
                         <tr>
                           <td><label>Last Sync </label></td>
                           <td><label> <?php if (file_exists("./synk/t.txt")) { $file=fopen("./synk/t.txt","r"); echo fgets($file) ;  }?> </label></td>
                         </tr>
                         <tr>
                           <td><label>Sync Now </label></td>
                           <td><button class="btn-icon btn-grey btn-refresh" onclick="Sync_teliksandi();"><span></span>Refresh</button></td>
                         </tr>
                         <tr>
                           <td>&nbsp;</td>
                           <td>&nbsp;</td>
                         </tr>
                       </table>
     </form>
                     <label>
                   
                     </label>
   </div>
 </div>
 
 <div class="box round">
                <h2>
                    List Of Word </h2>
   <div class="deskripsi">
				
				<p>
				</p>
			<script>

function openWin5()
{
myWindow=window.open('synk/view_on_net.php','','width=1200,height=900');
myWindow.focus();
}
</script>
			
			<a href="#" onclick="openWin5();">View Distibution Rules on inet</a><p>
	           <h2>
          			List Of All Coregenda </h2>
                <div class="block">
				
				
				<div id="allcorigenda" class="allcorigenda">
				<?php  echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Date</th>
											<th>Description</th>
											<th>File Eng</th>
											<th>File Ina</th>
											<th>Rules Name</th>
											<th>Tipe</th>
											<th>Action</th></tr>
									</thead>
									<tbody>";
											
						$get_koris=$rms->get_corigenda_listall();
						$tipe_cor=array("", "Corigenda","amandement");
						$no=1;
						
	foreach ($get_koris as $get_kori) {
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									
									<td>". $get_kori['tanggal'] ."</a></td>
									<td><a href='panel.php?module=viewrules&id=$get_kori[id_rule_link]'>" . $get_kori['Description'] . "</a></td>
									<td>". $get_kori['File']. "</a></td>
									<td>" . $get_kori['File2'] . "</td>
									<td>". $get_kori['nama']. "</td>
									<td>". $tipe_cor[$get_kori['tipe_amande']]."</td>
									<td><a href=# onclick='add_corigenda_to(". $get_kori['id'].");'>Add to</td>
									
									</tr>";

	
	$no++ ;
	}					
											
						
						
						
						
						echo "</tbody></table><hr>";
									
									?>
				
				</div>
				</div>		
<h2>List Of Rules publish </h2>	
<form id="form1" name="form1" method="post" action="">
  <label>
  <input type="checkbox" name="checkbox" id="cekall" value="all" onclick="load_rulepubaaaa();" />
  <span class="meraha">See Everything</span></label>
  <label></label><label>
  <input name="radiobutton" type="radio" onclick="load_rulepubaaaa();" value="0" checked="checked" />
  View All</label>
  <label>
  <input name="radiobutton" type="radio" onclick="load_rulepubaaaa();" value="1" />
  Rules</label>
  <label>
  <input name="radiobutton" type="radio" value="2" onclick="load_rulepubaaaa();" />
  Guidelines</label>
  <label>
  <input name="radiobutton" type="radio" value="3" onclick="load_rulepubaaaa();" />
  Guidance</label>
  <label>
  <input name="radiobutton" type="radio" value="4" onclick="load_rulepubaaaa();" />
  Reference Noted</label>
</form>

<p></p>
<div id="ruless" class="rulesspub" >

<?php



echo " <p> <table class='data display datatableggg' id='example' ><thead><tr><th>No </th><th>ID </th><th>Rules ID</th><th>Technical Papaer </th><th>Year </th><th>Part</th><th>Vol </th><th>Type </th><th>Link </th><th>Status</th><th>Action</th></tr></thead><tbody>";

$rulepubss=$rms->list_rules_pub("0","no");


$no=1;
	foreach ($rulepubss as $rulepubs) {
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									
									<td><a href='panel.php?module=viewrules&id=$rulepubs[id]'>". $rulepubs['id'] ."</a></td>
									<td><a href='panel.php?module=viewrules&id=$rulepubs[id]'>" . $rulepubs['id_rules'] . "</a></td>
									<td><a href='panel.php?module=viewrules&id=$rulepubs[id]'  target='_blank' >". $rulepubs['nama']. "</a></td>
									<td>" . $rulepubs['tahun'] . "</td>
									<td>". $rulepubs['part']. "</td>
									<td>". $rulepubs['vol']. "</td>
									<td>". $JenisTechnical_paper[$rulepubs['tipe']]."</td>
									<td>". $rulepubs['link']."</td>
									<td>". $Statuss[$rulepubs['status']]."</td>
									<td><a href=# onclick='add_rules_to(". $rulepubs['id'].");'>Add to  </a> </td>
									
									</tr>";

	
	$no++ ;
	}

 echo "</tbody></table><hr></div>" ;
 echo "<div id='ruless_dist' class='ruless_dist' ><h2>Distribution List </h2><p>";
 //distributiun list
 
			 echo " <p> <table class='data display datatableee' id='example' ><thead><tr>
			 <th>No </th>
			 <th>ID </th>
			 <th>ID pub</th>
			 <th>Technical Paper </th>
			 <th>Year </th>
			 <th>Part</th>
			 <th>Vol </th>
			 <th>Type </th>
			 <th>Update Type </th>
			 <th>Action</th>
			 </tr></thead><tbody>";
 $no=1;
$tipe_cor=array("normal", "Corigenda","amandement");
 $ruledistributs=$synk->get_Rules_distribution();
 
 foreach ($ruledistributs as $ruledistribut) {
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									
									<td>". $ruledistribut['id'] ."</td>
									<td><a href='panel.php?module=viewrules&id=$ruledistribut[id_relation]'>" . $ruledistribut['id_relation'] . "</a></td>
									<td><a href='rms/$ruledistribut[path]'  target='_blank' >". $ruledistribut['rules']. "</a></td>
									<td>" . $ruledistribut['tahun'] . "</td>
									<td>". $ruledistribut['part']. "</td>
									<td>". $ruledistribut['volume']. "</td>
									<td>". $JenisTechnical_paper[$ruledistribut['tipe_rules']]."</td>
									<td>". $tipe_cor[$ruledistribut['jenis_update']]."</td>
									<td><a href=# onclick='dell_ditributiion_list(". $ruledistribut['id'].");'>Dell  |</a> <a href=# onclick='show_update_name(\""  . $ruledistribut['rules']. "\",". $ruledistribut['id']. ");'>Change name </a></td>
									
									</tr>";

	
	$no++ ;
	}

 echo "</tbody></table><hr>" ;
 
 
?>




	 </div>
	 View<a href="./rules_bki.xml" target="_blank"> Xml
</a>	 </div>
				
				<table class="form">
                  <tr>
                    <td><label>Create XML </label></td>
                    <td><button class="btn-icon btn-grey btn-refresh" onclick="createxml();"><span></span>Create</button></td>
					 <td><button class="btn-icon btn-grey btn-refresh" onclick="createhash(<?php echo rand(0000,9999); ?>);"><span></span>Create hash</button></td>
                  </tr>
                </table>
 </div>
 
 <div class="hash">
 </div>
  
				

<div id="dialog" title="Change Name of Rules"  class="ui-widget">
                                    <p>
  <form id="form1" name="form1" method="post" action="">
  <table id="form" >
   <tr>
      <td>New Name Of Rules </td>
      <td width="392"><label>
      <input name="namarules" type="text" id="namarules" class="medium" />
      </label></td>
    </tr>
  
    <tr>
      <td>&nbsp;</td>
      <td width="392"><label><input name="id_diar"  id="id_diar"type="hidden" value=""  /></label></td>
    </tr>
    <tr>
      <td></td>
      <td><input name="ssds" type="button"  value="Close" onclick="update_name_ditributiion_list();"/></td>
    </tr>
  </table>
</form></p>
 </div>
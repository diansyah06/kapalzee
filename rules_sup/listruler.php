
<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
		
function load_managing_arsip(){
	
	
var modul= "load_managing_arsip";
	
$.post("rules_sup/sup_proc.php", { modul: modul } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});	
	



}


function load_managing_waiting(){
	
	
	
var modul= "project_inprogress";
	
$.post("rules_sup/sup_proc.php", { modul: modul } , function(html) {
			$('.ruless').html(html);
			$(".ruless").hide();
			$(".ruless").fadeIn(400);});	



}
		
		
		
</script>

<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>

 <div class="box round first">
                <h2>
                    Description</h2>
                <div class="block">
                    <!-- paragraphs -->
                    <p class="start">
                        <img src="img/horizontal.jpg" alt="Ginger" class="right" />This page will show you the list all project . The list of your project will shown in [Project List] box below. You can change the number of viewed project per page by clicking the button &quot;show&quot;. </p>
                    <p>If you find it difficult to search the name of project you need one-by-one, you can also look after it by typing the name of your project in the &quot;search&quot; box. </p>
                    <p>If you have new project, please start with create new task in this program through clicking the &quot;+Create New Technical Paper Button&quot;. </p>
                    <p>After your new project shown in the [Project List], you can started to fill in your database project by clicking at the number in the column named [Unique Code] or the name of your project in the column named [Technical Paper Name] </p>
                    <p>CONGRATULATIONS! and LET'S GET STARTED !!</p>
                    <p></p>
   </div>
 </div>
 
  <div class="box round">
                <h2>
                    Project list</h2>
                <div class="block">
				<button class="btn btn-green" onclick="location.href='panel.php?module=crules'">+ Create New Technical Paper</button>
								</p>
								<form id="form1" name="form1" method="post" action="">
  <label>
  <input name="radiobutton" type="radio" value="radiobutton"  onclick="load_managing_arsip();"/>
  Arsip</label>
  <label>
  <input name="radiobutton" type="radio" value="radiobutton" checked="checked" onclick="load_managing_waiting();"  />
  Project In Progress</label>
</form>
<hr />  <div class="ruless">
<?php 


				$user_id = $_SESSION['user_id'];
				$previl = cekprevil($mysqli) ;
				
				$user_id = 12 ;
				

				$statement = "SELECT  og_user.nama, rm_paper.Nama, rm_cekpoint.id_cek, rm_cekpoint.tahun, rm_cekpoint.user, rm_cekpoint.duedate , rm_ruleslist.Rules, rm_ruleslist.tipe, rm_ruleslist.Part , rm_ruleslist.volume, rm_cekpoint.preparation, rm_cekpoint.teamup, rm_cekpoint.ref, rm_cekpoint.wg, rm_cekpoint.konsenering, rm_cekpoint.cetak, rm_cekpoint.karakter, rm_cekpoint.adminis, rm_cekpoint.komite, rm_cekpoint.scope, rm_cekpoint.master, rm_cekpoint.publikasi, rm_cekpoint.close 	  FROM rm_cekpoint LEFT JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules 
LEFT JOIN rm_paper ON rm_ruleslist.tipe=rm_paper.id_paper
LEFT JOIN og_user ON rm_cekpoint.user=og_user.id_user where rm_cekpoint.closeby=0 order by rm_cekpoint.id_cek desc 

" ;
				
	
				
				
						   if ($load_stmt = $mysqli->prepare($statement)) {   	
							// Execute the prepared query.
						   $load_stmt->execute();
						   $load_stmt->bind_result($leader, $tipee, $id_cek, $tahun , $user , $duedate , $namarules, $tipe ,$partt ,$volumee,$cek1,$cek2,$cek3,$cek4,$cek5,$cek6,$cek7,$cek8,$cek9,$cek10,$cek11,$cek12,$cek13  );
						   
						   
						   
						   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Unique Code</th>
											<th>Type</th>
											<th>Technical Paper Name</th>
											<th>Part</th>
											<th>Vol</th>
											<th>Status</th>
											<th>Due</th>
											<th>Leader</th>
										</tr>
									</thead>
									<tbody>";
				   $no=1;
					while($load_stmt->fetch()){
					$nilaicek=array($cek1,$cek2,$cek3,$cek4,$cek5,$cek6,$cek7,$cek8,$cek9,$cek10,$cek11,$cek12,$cek13);
					
					$n=0;
					
					 foreach ($nilaicek as $isi) { if ($isi!="0000-00-00"){ $n=$n+1;} ;} 
					 $n=$n/13 * 100 ;
					 $n=number_format($n,0);
						 $tipe = $tipe - 1 ;
						 $part = $part -1 ;
						 $id_cek= sprintf ("%04d\n",   $id_cek);
						 echo "<tr class='odd gradeX'>
						 <td >$no</td>
									<td >$id_cek</td>
									<td >$tipee</td>
									<td >$namarules $tahun </td>
									<td>$partt</td>
									<td>$volumee</td>
									<td>$n %</td>
									<td>$duedate</td>
									<td>$leader</td></tr>";
									
									$no++ ;
							}
							echo "</tbody>
								</table>";
				
								
					}
				//End Load Part.........



?>
</div>
<script language="javascript">
function fung_hap(){
var r=confirm("Are you sure want to delete this project, it's will erase all data in this project ");
			if (r==true)
			  {
			  
			  
			alert('hapus');
			return true;
			  
			  }
			else
			  {
			  alert('ga hapus');
			 return false;
			  } 
	}
</script>
				</div>
				</div>
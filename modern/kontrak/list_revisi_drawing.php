
<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
</script>

<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="js/kontrak-po.js" type="text/javascript"></script>
<div class="box round first">
                <h2>
                    list drawing Revision</h2>
  <div class="block">
				 <p class="start">
                        Lorem Ipsum is simply dummy
                        text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                        standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only
                        five centuries, but also the leap into electronic typesetting, remaining essentially
                        unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
                        Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                        PageMaker including versions of Lorem Ipsum.</p> <hr />
						
		<div id="deskripsi" class="deskripsi" >				
	<?php					
						
	$proj_id=intval($_GET['id']);
	$draw_id=intval($_GET['draw']);
	$get_draws=$drawing->get_proj_gambar_id($draw_id);
	
	$get_hist_draws=$drawing->get_histori_gambar($draw_id,$proj_id) ;
	
	
	   echo "<table class='data display datatable' id='example'>
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
	
	
	$no=1;
	foreach ($get_draws as $get_draw) {
	$nama_gam=$get_draw['judul'] ;
	$no_gam=$get_draw['no_gambar'] ;
	}
	foreach ($get_hist_draws as $get_hist_draw) {
	$z=$get_draw['tipe'];
	if ($get_hist_draw['alamat']=="none"){ $edraw="No avaible" ; }else { $edraw="Avaible" ; }
	
	$perant=$proj_id . "," . $get_hist_draw['id']. "," . $draw_id  ;
	
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td > " . $no_gam. "</td>
									<td >". $nama_gam . " </a></td>
									<td >".  $get_hist_draw['revisi']. "</td>
									<td>" . $get_hist_draw['tanggal'] . "</td>
									<td>" . $edraw . "</td>
									<td>" . "<a href='kontrak/read.php?module=re&kon=$proj_id&gam=$get_hist_draw[id]'" .  "target='_blank'>" . " Open</a> " ."</td>
									<td> <a href='#'  onclick=". "fung_del_gambar_rev(" . $perant ."); > Delete </a> "  . "</td>									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table>";

	
			 
	?>	
						
						
						</div>
						 </div>
</div>
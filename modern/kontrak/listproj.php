<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
</script>

<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>

 <div class="box round first">
                <h2>
                    Description</h2>
                <div class="block">
                    <!-- paragraphs -->
                    <p class="start">
                        <img src="img/Crystal_Project_package_graphics.png" alt="Ginger" class="right" />Lorem Ipsum is simply dummy
                        text of the printing and typesetting industry. Lorem Ipsum has been the industry's
                        standard dummy text ever since the 1500s, when an unknown printer took a galley
                        of type and scrambled it to make a type specimen book. It has survived not only
                        five centuries, but also the leap into electronic typesetting, remaining essentially
                        unchanged. It was popularised in the 1960s with the release of Letraset sheets containing
                        Lorem Ipsum passages, and more recently with desktop publishing software like Aldus
                        PageMaker including versions of Lorem Ipsum.</p>
                    <p>
                        It is a long established fact that a reader will be distracted by the readable content
                        of a page when looking at its layout. The point of using Lorem Ipsum is that it
                        has a more-or-less normal distribution of letters, as opposed to using 'Content
                        here, content here', making it look like readable English. Many desktop publishing
                        packages and web page editors now use Lorem Ipsum as their default model text, and
                        a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various
                        versions have evolved over the years, sometimes by accident, sometimes on purpose
                        (injected humour and the like).</p>
					 <p>
                        It is a long established fact that a reader will be distracted by the readable content
                        of a page when looking at its layout. The point of using Lorem Ipsum is that it
                        has a more-or-less normal distribution of letters, as opposed to using 'Content
                        here, content here', making it look like readable English. Many desktop publishing
                        packages and web page editors now use Lorem Ipsum as their default model text, and
                        a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various
                        versions have evolved over the years, sometimes by accident, sometimes on purpose
                        (injected humour and the like).</p>
					<p>
                        It is a long established fact that a reader will be distracted by the readable content
                        of a page when looking at its layout. The point of using Lorem Ipsum is that it
                        has a more-or-less normal distribution of letters, as opposed to using 'Content
                        here, content here', making it look like readable English. Many desktop publishing
                        packages and web page editors now use Lorem Ipsum as their default model text, and
                        a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various
                        versions have evolved over the years, sometimes by accident, sometimes on purpose
                        (injected humour and the like).</p>
                    
					</div>
 </div>
 
  <div class="box round">
                <h2>
                    Project list</h2>
                <div class="block">
				<button class="btn btn-green" onclick="location.href='panel.php?module=kontrak'">+ Create New Technical Paper</button>
								</p>
<?php 


				$user_id = $_SESSION['user_id'];
				$previl = cekprevil($mysqli) ;
				

				

	
	$kontraks=$kontrak->get_kontrak();
	
	
	   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Id Kontrak</th>
											<th>Nama </th>
											<th>Location</th>
											<th>Status</th>
											<th>Start Date</th>
											<th>Due Date</th>
											<th>Finish</th>
											<th>Link</th>
											
										</tr>
									</thead>
									<tbody>";
	
	
	$no=1;
	foreach ($kontraks as $kontrak) {
	 echo 							"<tr class='odd gradeX'>
									<td >$no</td>
									<td ><a href='panel.php?module=ed_cek&point=2&id=". $kontrak['id']. "'>". $kontrak['id_kontrak'].  " </a></td>
									<td ><a href='panel.php?module=ed_cek&point=2&id=". $kontrak['id']. "'>". $kontrak['nama']. "</td>
									<td>" . $kontrak['lokasi'] . "</td>
									<td>" . $kontrak['status'] ."</td>
									<td>". $kontrak['dates'] ."</td>
									<td>". $kontrak['due_date']. "</td>
									<td>". $kontrak['finish']. "</td>
									<td>" . $kontrak['linker'] . "</td>
									
									</tr>";
	
	
	
	
	
	$no++ ;
	}
	echo "</tbody></table><hr>";
	
	
			 
	?>
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
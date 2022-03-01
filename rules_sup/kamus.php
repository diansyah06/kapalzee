<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();


        });
</script>

<script type="text/javascript" src="js/cek_po.js"></script>
<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>

 <div class="box round first">
                <h2>
                    Description Of kamus </h2>
   <div class="block">
                    <!-- paragraphs -->
                    <p class="start">
                        <img src="img/Crystal_Project_package_graphics.png" alt="Ginger" class="right" />This page contain the dictionary of terms and definition used in the Rules/Guides. You can search the unindentified terms mentioned in the references in &quot;search&quot; filling box at [List Of Word]. <br />
                      You can also choose the number of viewed terms in &quot;Show&quot; button (that's not too amusing right?). </p>
                    <p>If you can't find any in the [List of Word], you can add one at [Desrciption of Kamus] by filling the name of terms in Indonesian version and the similiar name of the terms in English. Add the terms at &quot;Indonesia&quot; and &quot;English&quot; box. Don't forget to click the [+Add word] button to input this information in RMS. </p>
                    <p>&nbsp;</p>
                     <form id="form1" name="form1" method="post" action="">
                       <table class="form">
                         <tr>
                           <td width="58" >&nbsp;</td>
                           <td width="219">&nbsp;</td>
                         </tr>
                         <tr>
                           <td><label>Indonesia</label></td>
                           <td><label>
                             <input type="text" id="indonesia" name="textfield"  class="medium"/>
                           </label></td>
                         </tr>
                         <tr>
                           <td><label>English</label></td>
                           <td><input type="text" id="english" name="textfield2"  class="medium"/></td>
                         </tr>
                         <tr>
                           <td>&nbsp;</td>
                           <td><div class="btn btn-green" onclick='fung_add_kamus();'>+ Add word</div></td>
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
				
<?php 


				$user_id = $_SESSION['user_id'];
				
					$statement = "SELECT  rm_kamus.id, rm_kamus.indonesia, rm_kamus.english, rm_kamus.user , rm_kamus.tanggal , og_user.nama  FROM rm_kamus JOIN og_user ON rm_kamus.user=og_user.id_user Order by english ASC" ;
					
						   if ($load_stmt = $mysqli->prepare($statement)) {   	
							// Execute the prepared query.
						   $load_stmt->execute();
						   $load_stmt->bind_result($id_kamus, $indonesia , $english , $id_user , $tanggal , $user  );
						   $no=1;
						   
						   echo "<table class='data display datatable' id='example'>
									<thead>
										<tr>
											<th>No</th>
											<th>Indonesia </th>
											<th>English</th>
											<th>User</th>
											<th>Date Input</th>
											<th> Status</th>
										</tr>
									</thead>
									<tbody>";
				
					while($load_stmt->fetch()){
						
						if ($id_user == $user_id ){
						$kond="<a href='#' onclick='fung_del_kamus($id_kamus);'>Hapus</a>" ;}else {$kond="" ;}
						
						 echo "<tr class='odd gradeX'>
									<td >$no</td>
									<td >$indonesia</td>
									<td >$english</td>
									<td>$user</td>
									<td>$tanggal</td>
									<td>" . $kond ." </td></tr>";
									
									$no++ ;
							}
							echo "</tbody>
								</table>";
				
								
					}
				//End Load Part.........



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
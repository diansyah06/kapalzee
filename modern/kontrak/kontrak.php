
<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();
 setDatePicker('date-picker');

        });
</script>

<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="js/kontrak-po.js" type="text/javascript"></script>
<script src="js/jquery-ui/jquery.ui.datepicker.min.js" type="text/javascript"></script>
<div class="box round first">
                <h2>
                    Create New Preject Kontrak</h2>
  <div class="block">
				 <p>This is  a filling form to create your project. you project will be display on the list bellow, you can also check another project by type contract id, name and status at list's search box.</p>
				 <ul>
				   <li>	Number contrack : contact number state from survey division for each project</li>
                   <li>Class number : Number of vessel/unit classed in Bki register</li>
                   <li>Name : Name of Unit /vessel</li>
                   <li>Type : Type of unit as BKI Definition</li>
                   <li>Project location : place where unit/vessel constructed</li>
                   <li>Submited : person who submit the aplican</li>
    </ul>
				 <hr />
<form id="form1" name="form1" method="post" action="">
  <table class="form" >
    <tr>
      <td><label>Number Of Contrack</label></td>
      <td><label>
        <input name="textfield" type="text" class="medium" id="kontrak"/>
      </label></td>
    </tr>
    <tr>
      <td><label>Class Number</label></td>
      <td><label>
        <input type="text" name="textfield2" class="medium" id="class"/>
      </label></td>
    </tr>
    <tr>
      <td><label>Name</label></td>
      <td><label>
        <input type="text" name="textfield3"class="medium" id="name"/>
      </label></td>
    </tr>
    <tr>
      <td><label>Tipe</label></td>
      <td><label>
        <select name="select" id="tipe">
		<?php 
		$tipe_objeks=$tipe_objeck->get_tipe_objek();
		foreach ($tipe_objeks as $tipe_objek) {
		echo "<option value='". $tipe_objek['id'] . "'>" . $tipe_objek['deskrip'] . "</option>" ;  }?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><label>Project Location</label></td>
      <td><label>
        <input type="text" name="textfield4" class="medium"  id="lokasi"/>
      </label></td>
    </tr>
    <tr>
      <td><label>Builder</label></td>
      <td><label>
        <input type="text" name="textfield5" class="medium" id="pembuat"/>
      </label></td>
    </tr>
    <tr>
      <td><label>submited</label></td>
      <td><label>
        <input type="text" name="textfield6" class="medium" id="pengirim"/>
      </label></td>
    </tr>
    <tr>
      <td><label>Due Date</label></td>
      <td><label>
        <input type="text" name="textfield7" id="date-picker" value="<?php echo date('m/d/Y') ; ?>" />
      </label></td>
    </tr>
    <tr>
      <td><br /></td>
      <td><label>
        <input type="button" name="Button" value="Button" onclick="fung_add_kontrak();" />
      </label></td>
    </tr>
  </table>
</form>

</div>
</div>

					<div class="box round">
                      <form id="form2" name="form2" method="post" action="">
                        <label>
                        <input name="radiobutton" type="radio" value="radiobutton" onclick="fung_load_planb();" />
                        Arsip Plan</label>
                                            <label>
                                            <input name="radiobutton" type="radio" value="radiobutton" checked="checked"  onclick="window.location.reload();"/>
                                            Current Plan</label>
                      </form>
					
                <div id="deskripsi" class="deskripsi" >
				 <p >
				 
	<?php
	
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
									<td ><a href='panel.php?module=ed_kon&point=2&id=". $kontrak['id']. "'>". $kontrak['id_kontrak'].  " </a></td>
									<td >". $kontrak['nama']. "</td>
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
	
				</div>
</div>			 
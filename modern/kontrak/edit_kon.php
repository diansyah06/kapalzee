<?php

$id_kon=intval($_GET[id]);



$kont_ge=$kontrak->get_kontrak_id($id_kon);
	foreach ($kont_ge as $kont_g) {
		
		
$Number_kon=$kont_g['id_kontrak'];
$class_num=$kont_g['class_id'];
$name=$kont_g['nama'];
$tipe=$kont_g['tipe_kon'];
$proj_lok=$kont_g['lokasi'];
$builder=$kont_g['builder'];
$submited=$kont_g['submited'];
$due_date=$kont_g['due_date'];
		
	}

?>
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
                    Edit Project</h2>
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
<form id="form1" name="form1" method="post" action="">
  <table class="form" >
    <tr>
      <td><label>Number Of Contrack</label></td>
      <td><label>
        <input name="textfield" type="text" class="medium" id="kontrak" value="<?php echo $Number_kon;?>"/>
      </label></td>
    </tr>
    <tr>
      <td><label>Class Number</label></td>
      <td><label>
        <input type="text" name="textfield2" class="medium" id="class" value="<?php echo $class_num;?>"/>
      </label></td>
    </tr>
    <tr>
      <td><label>Name</label></td>
      <td><label>
        <input type="text" name="textfield3"class="medium" id="name" value="<?php echo $name;?>"/>
      </label></td>
    </tr>
    <tr>
      <td><label>Tipe</label></td>
      <td><label>
        <select name="select" id="tipe">
		<?php 
		$tipe_objeks=$tipe_objeck->get_tipe_objek();
		
		echo "<option value='". $tipe . "'>" .  "</option>" ;  
		foreach ($tipe_objeks as $tipe_objek) {
		echo "<option value='". $tipe_objek['id'] . "'>" . $tipe_objek['deskrip'] . "</option>" ;  }?>
        </select>
      </label></td>
    </tr>
    <tr>
      <td><label>Project Location</label></td>
      <td><label>
        <input type="text" name="textfield4" class="medium"  id="lokasi" value="<?php echo $proj_lok;?>"/>
      </label></td>
    </tr>
    <tr>
      <td><label>Builder</label></td>
      <td><label>
        <input type="text" name="textfield5" class="medium" id="pembuat" value="<?php echo $builder;?>"/>
      </label></td>
    </tr>
    <tr>
      <td><label>submited</label></td>
      <td><label>
        <input type="text" name="textfield6" class="medium" id="pengirim" value="<?php echo $submited;?>"/>
      </label></td>
    </tr>
    <tr>
      <td><label>Due Date</label></td>
      <td><label>
        <input type="text" name="textfield7" id="date-picker" value="<?php echo $due_date;?>" />
      </label></td>
    </tr>
    <tr>
      <td><br /></td>
      <td><label>
        <input type="button" name="Button" value="Button" onclick="fung_edit_kontrak(<?php echo $id_kon ; ?>);" />
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
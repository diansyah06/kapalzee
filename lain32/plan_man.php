<script type="text/javascript">

        $(document).ready(function () {
            setupLeftMenu();

            $('.datatable').dataTable();
			setSidebarHeight();
 setDatePicker('date-picker');

        });
</script>

<script src="js/table/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="js/plan_man.js" type="text/javascript"></script>
<script src="js/jquery-ui/jquery.ui.datepicker.min.js" type="text/javascript"></script>
<div class="box round first">
                <h2>
                    Plan Manager</h2>
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
      <td><label>Task Name</label> </td>
      <td><label>
        <input type="text" name="textfield" id="textfield" class="medium" />
      </label></td>
    </tr>
    <tr>
      <td><label>objective</label></td>
      <td><label>
        <input type="text" name="textfield2" id="textfield2"  class="medium" />
      </label></td>
    </tr>
    <tr>
      <td><label>due date</label></td>
      <td><label>
        <input type="text" name="textfield3" id="date-picker" value="<?php echo date('m/d/Y') ; ?>" />
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><label>
        <input type="button" name="button" value="Submit" onclick="fung_add_plan();"/>
      </label></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
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


//load user 
$kondisi_status=array("Not Yet","Done","Undone");
if ($load_stmt = $mysqli->prepare("SELECT  	id_user,nama FROM og_user ")) {   
	   // Execute the prepared query.
		   $load_stmt->execute();
		   $load_stmt->bind_result( $id_users,$nama_userrrrr );
		   $no=1;
		   $user_array=array();
		   // fetch result.
		   while($load_stmt->fetch()){$user_array[$id_users]=$nama_userrrrr;
		   
		   }
}


//end load user

                    
echo " <p> <table class='data display datatable' id='fdg' >
<thead>
<tr><th>No </th>
<th>Task </th>
<th>Create at </th>
<th>year</th>
<th>due</th>
<th>status</th>
<th>link</th>
<th>Create by </th>
<th>lock By</th>
<th>Objective</th>
<th>Action</th>
</tr></thead><tbody>";


	if ($load_stmt = $mysqli->prepare("SELECT  	id, task, create_at, year, due, status, link, alasan, create_by, lock_by, objective FROM rm_plan where status = 0 ")) {   
	   // Execute the prepared query.
		   $load_stmt->execute();
		   $load_stmt->bind_result( $id, $task, $create_at, $year, $due, $status, $link,  $alasan, $create_by, $lock_by, $objective);
		   $no=1;
		   // fetch result.
		   while($load_stmt->fetch()){
	     
				echo "<tr class='odd gradeX'>
				<td>$no</td>
				<td>$task</td>
				<td>$create_at</td>
				<td>$year</td>
				<td>$due</td>
				<td>$kondisi_status[$status]</td>
				<td>$link</td>
				<td> $user_array[$create_by]</td>
									<td>$user_array[$lock_by]</td>
									<td>$objective</td><td><a href=# onclick='fung_lock_plan($id);'>L</a> <a href=# onclick='savelink($id);'>F</a> <a href=# onclick='saveReason($id);'>R</a> <a href=# onclick='fung_dell_plan($id);'>D</a></td></tr>";
				
				$no++ ;
		
			}
		}



 echo "</tbody></table><hr>" ;					
					
					
					
					
					
					
?>

				</div>
</div>
<?php
include("../sis32/db_connect.php");
include "../functions.php";
sec_session_start();

$user_id = $_SESSION['user_id'];
$salting=$_SESSION['salt'];
$modul = $_POST['modul'] ;
$act = $_POST['act'] ;
$objective = $_POST['objective'] ;
$task = $_POST['task'] ;
$due = $_POST['due'] ;
$due = date("Y-m-d", strtotime($due));
$tanggal_saiki = date("Y-m-d");



if ($modul=='plan' AND $act=='add')   {

if ($salting > 4 ){ 
$alasan="";

$tahun=date("Y", strtotime($due));

		if ($insert_stmt = $mysqli->prepare("INSERT INTO rm_plan (task, create_at, year, due, alasan, create_by,  objective  ) VALUES (?, ?, ?, ?, ?, ?, ?)")) { 
		   $insert_stmt->bind_param('ssissss', $task ,$tanggal_saiki, $tahun ,$due,$alasan,$user_id,$objective   ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
		}


}

}


if ($modul=='plan' AND $act=='dell')   {
$id_data = $_POST['id'] ;
if ($salting > 4 ){ 
//cek suda di lock belum
if ($load_deskr = $mysqli->prepare("SELECT lock_by FROM rm_plan  where id  = ? LIMIT 1")) {   
				   // Execute the prepared query.
				       $load_deskr->bind_param('i',$id_data ); // Bind "$id_rules" to parameter.
					   $load_deskr->execute();
					    $load_deskr->store_result();
					   $load_deskr->bind_result($lock_byy );

					   while($load_deskr->fetch()){
					   }
			if ($lock_byy==0){$kon_lock=true;}

} 

		if ($kon_lock){

		if ($delet_stmt = $mysqli->prepare("DELETE FROM  rm_plan  where id =?  LIMIT 1")) {   
				 $delet_stmt->bind_param('i', $id_data  ); 
			   // Execute the prepared query.
				 $delet_stmt->execute();

		}
			}else{
			// jikaaa di atas manager bisa hapusss		
				if ($salting > 5){
		
					if ($delet_stmt = $mysqli->prepare("DELETE FROM  rm_plan  where id =?  LIMIT 1")) {   
				 	$delet_stmt->bind_param('i', $id_data  ); 
			   		// Execute the prepared query.
				 	$delet_stmt->execute();

				}
				
				
				
				}
		}		

}

}


if ($modul=='plan' AND $act=='lock')   {

$id_data = $_POST['id'] ;

if ($salting > 5 ){ 


if ($insert_stmt = $mysqli->prepare("UPDATE rm_plan SET lock_by= ? where id= ?")) {    
		   $insert_stmt->bind_param('ii',$user_id, $id_data  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}





}

}


if ($modul=='plan' AND $act=='reason')   {
$id_data = $_POST['id'] ;
$reason = $_POST['reason'] ;
if ($salting > 4 ){ 

$status =2;
if ($insert_stmt = $mysqli->prepare("UPDATE rm_plan SET alasan= ? , status = ? where id= ?")) {    
		   $insert_stmt->bind_param('sii',$reason,$status , $id_data  ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}


}
}



if ($modul=='plan' AND $act=='link')   {
$id_data = $_POST['id'] ;
$reason = $_POST['reason'] ;
if ($salting > 4 ){ 

$status=1;
echo "sapi";
if ($insert_stmt = $mysqli->prepare("UPDATE rm_plan SET link= ? , status= ? where id= ?")) {    
		   $insert_stmt->bind_param('sii',$reason ,$status, $id_data ); 
		   // Execute the prepared query.
		   $insert_stmt->execute();
	}


}
}


//kirim nilai balik
$kondisi_status=array("Not Yet","Done","Undone");
//load user 

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
$statement="SELECT id, task, create_at, year, due, status, link, alasan, create_by, lock_by, objective FROM rm_plan where status = 0 ";

if ($modul=='plan' AND $act=='planb')   {
$statement="SELECT id, task, create_at, year, due, status, link, alasan, create_by, lock_by, objective FROM rm_plan where status != 0 ";

}


	if ($load_stmt = $mysqli->prepare($statement)) {   
	   // Execute the prepared query.
		   $load_stmt->execute();
		   $load_stmt->bind_result( $id, $task, $create_at, $year, $due, $status, $link,  $alasan, $create_by, $lock_by, $objective);
		   $no=1;
		   // fetch result.
		   while($load_stmt->fetch()){
	     
				echo "<tr class='odd gradeX'>
				<td>$no</td>
				<td title='$alasan'>$task</td>
				<td title='$alasan'>$create_at</td>
				<td title='$alasan'>$year</td>
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




echo "<script type='text/javascript'>

        $(document).ready(function () {
            
			setupLeftMenu();
            $('.datatable').dataTable();
			setSidebarHeight();
			

        });
</script>" ;







?>
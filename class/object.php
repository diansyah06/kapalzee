<?php
class obj{
 
		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
			
		}
		
		public function lastInsertId(){
			return $this->db->lastInsertId();
		}
		
		public function InsertObject($object_type_id, $name, $created_on, $created_by_id){
		
		$query 	= $this->db->prepare("INSERT INTO `rm_objects` (object_type_id, name, created_on, created_by_id, updated_on, updated_by_id ) VALUES (?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $object_type_id);
		$query->bindValue(2, $name);
		$query->bindValue(3, $created_on);
		$query->bindValue(4, $created_by_id);
		$query->bindValue(5, $created_on);
		$query->bindValue(6, $created_by_id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}
		
		public function updateObject($updated_on, $updated_by_id,$id){
		
		$query 	= $this->db->prepare("UPDATE rm_objects SET updated_on = ? , updated_by_id = ? where id= ?  ");
		 
			$query->bindValue(1, $updated_on);
			$query->bindValue(2, $updated_by_id);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}
		
		public function updateObjectNama($nama,$id){
		
		$query 	= $this->db->prepare("UPDATE rm_objects SET name = ?  where id= ?  ");
		 
			$query->bindValue(1, $nama);

			$query->bindValue(2, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}
		
		public function movetrashObject($trashed_by_id,$id){
		$trashed_on = date("Y-m-d H:i:s");		
		$query 	= $this->db->prepare("UPDATE rm_objects SET trashed_on = ? , trashed_by_id  = ? where id= ?  ");
		 
			$query->bindValue(1, $trashed_on);
			$query->bindValue(2, $trashed_by_id);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}
		
		public function Cektrash($id){
		$query = $this->db->prepare("SELECT * from rm_objects where id= ? limit 1");
		$query->bindValue(1, $id);
				 $query->bindColumn('trashed_on', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			
			if ($hak=="0000-00-00 00:00:00"){
				return true ;
			
			}else {
				return false ;
			
			}
		
		
		
		
		
		}
		
		public function arsipObject($archived_on,$archived_by_id,$id){
		
		$query 	= $this->db->prepare("UPDATE rm_objects SET archived_on  = ? , archived_by_id  = ? where id= ?  ");
		 
			$query->bindValue(1, $archived_on);
			$query->bindValue(2, $archived_by_id);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}
		
		public function InsertobjectCorelation($objectId,$correlation){
		
		
		$query 	= $this->db->prepare("INSERT INTO `rm_object_corelation` (objectid, relatedobjectid ) VALUES (?,?) ");
	 
		$query->bindValue(1, $objectId);
		$query->bindValue(2, $correlation);
		

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		
		}
		
		public function GetCorelationname($objectIda){
		
		$query = $this->db->prepare("SELECT rm_workspaces.id_kontrak,  rm_workspaces.project,rm_workspaces.object_id ,rm_object_corelation.relatedobjectid from rm_object_corelation LEFT JOIN rm_workspaces ON rm_workspaces.object_id=rm_object_corelation.relatedobjectid
where rm_object_corelation.objectid = :proje limit 1");
			#bind Value 
			
			$query->bindParam(':proje', $objectIda, PDO::PARAM_INT);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		
		}
		
		public function insertFilerevision($object_id, $file_id, $file_type_id, $repository_id,  $revision_number, $comment, $type_string, $filesize, $hash){
		
		$query 	= $this->db->prepare("INSERT INTO `rm_project_file_revisions` (object_id, file_id, file_type_id, repository_id,  revision_number, comment, type_string, filesize, hash ) VALUES (?,?,?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $object_id);
		$query->bindValue(2, $file_id);
		$query->bindValue(3, $file_type_id);
		$query->bindValue(4, $repository_id);
		$query->bindValue(5, $revision_number);
		$query->bindValue(6, $comment);
		$query->bindValue(7, $type_string);
		$query->bindValue(8, $filesize);
		$query->bindValue(9, $hash);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

		
		}
		
		public function updateComentfilere($commentsss,$objectidhh){
		
		
$query 	= $this->db->prepare("UPDATE `ogs`.`rm_project_file_revisions` SET `comment` = :com WHERE `rm_project_file_revisions`.`object_id` =:proje LIMIT 1 ;");
		 
		
			
			$query->bindParam(':com', $commentsss, PDO::PARAM_STR);
		
			$query->bindParam(':proje', $objectidhh, PDO::PARAM_INT);
		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	 
			
			
		
		}
		
		public function Getfilerevison($object_id){
		
					#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT rm_objects.updated_on 	,rm_objects.updated_by_id,og_user.nama,rm_objects.id, rm_project_file_revisions.revision_number, rm_project_file_revisions.comment, rm_project_file_revisions.type_string ,	rm_project_file_revisions.filesize,rm_project_file_revisions.repository_id  from rm_project_file_revisions 
LEFT JOIN  rm_objects ON rm_objects.id=  rm_project_file_revisions.object_id
LEFT JOIN og_user ON rm_objects.updated_by_id = og_user.id_user

where rm_project_file_revisions.file_id= ? and trashed_on='0000-00-00 00:00:00' order by rm_project_file_revisions.revision_number asc");
			#bind Value 
			$query->bindValue(1, $object_id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		
		}
		
		public function getNumberfilelastrevision($file_id){
		
		$query = $this->db->prepare("SELECT * from rm_project_file_revisions where rm_project_file_revisions.file_id = ? order by rm_project_file_revisions.revision_number desc limit 1");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $file_id);
				 $query->bindColumn('revision_number', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;

		}
		
		public function getNumberfilelastrevisionWithName($file_id){
				
		#preparing a statement that will select all the registered users, with the most recent ones first.
		$query = $this->db->prepare("SELECT rm_project_file_revisions.repository_id ,rm_project_file_revisions.type_string 	,rm_project_file_revisions.filesize , rm_objects.name from rm_project_file_revisions 
		LEFT JOIN  rm_objects ON rm_project_file_revisions.file_id=  rm_objects.id
		where rm_project_file_revisions.file_id = ? order by rm_project_file_revisions.revision_number desc limit 1");
			#bind Value 
			$query->bindValue(1, $file_id);
			 $query->bindColumn('repository_id', $hak);
			 $query->bindColumn('name', $hok);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $hak . "#" . $hok ;
		
		}
		
		public function getfilelastrevision($file_id){
		
		$query = $this->db->prepare("SELECT * from rm_project_file_revisions where rm_project_file_revisions.file_id = ? order by rm_project_file_revisions.revision_number desc limit 1");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $file_id);
				 $query->bindColumn('repository_id', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;

		}
		
		public function getfilelastrevisionMime($file_id){
		
		$query = $this->db->prepare("SELECT * from rm_project_file_revisions where rm_project_file_revisions.file_id = ? order by rm_project_file_revisions.revision_number desc limit 1");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $file_id);
				 $query->bindColumn('type_string', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;

		}
		
		public function dellProject($objectid,$userid){
		
		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_workspaces` WHERE `rm_workspaces`.`object_id` = ? limit 1");
		$query->bindValue(1, $objectid);

		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

		}
		
		public function tblinsertWorkspace($object_id,$status,$project,$team,$starting,$due,$progress,$id_kontrak,$class_id,$vessel,$lokasi,$builder,$submited,$linker,$finish,$sister=''){
		
		$target=1;
		$query 	= $this->db->prepare("INSERT INTO `rm_workspaces` (object_id,status, project, `team`, `starting`, `due`, `progress`, id_kontrak, class_id ,vessel ,lokasi,builder,`submited`,`linker`,finish,target,sister) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $object_id);
		$query->bindValue(2, $status);
		$query->bindValue(3, $project);
		$query->bindValue(4, $team);
		$query->bindValue(5, $starting);
		$query->bindValue(6, $due);
		$query->bindValue(7, $progress);
		$query->bindValue(8, $id_kontrak);
		$query->bindValue(9, $class_id);
		$query->bindValue(10, $vessel);
		$query->bindValue(11, $lokasi);
		$query->bindValue(12, $builder);
		$query->bindValue(13, $submited);
		$query->bindValue(14, $linker);
		$query->bindValue(15, $finish);
		$query->bindValue(16, $target);
		$query->bindValue(17, $sister);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

		}
		
		public function tblupdateworkspace($object_id, $nama, $target, $id_kontrak, $team, $starting, $due,$class_id, $description, $vessel,$lokasi ,$builder,$submited,$kontractlink,$sistercontract=''){
		
		$query 	= $this->db->prepare("UPDATE rm_workspaces SET project  = ? , target  = ? ,id_kontrak = ?, `starting` = ?, `due` =?, class_id = ?, description = ?, vessel = ?,lokasi =?,builder=?,submited=?,kontractlink=?,sister=?  where object_id= ?  ");
		
		$query->bindValue(1, $nama);
		$query->bindValue(2, $target);
		$query->bindValue(3, $id_kontrak);

		$query->bindValue(4, $starting);
		$query->bindValue(5, $due);
		$query->bindValue(6, $class_id);
		$query->bindValue(7, $description);
		$query->bindValue(8, $vessel);
		$query->bindValue(9, $lokasi);
		$query->bindValue(10, $builder);
		$query->bindValue(11, $submited);
		$query->bindValue(12, $kontractlink);
		$query->bindValue(13, $sistercontract);
		
		
		$query->bindValue(14, $object_id);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}		
		
		public function tblupdateworkspaceTeam($object_id, $team){
		
		$query 	= $this->db->prepare("UPDATE rm_workspaces SET team  = ?  where object_id= ?  ");
		
		$query->bindValue(1, $team);

		$query->bindValue(2, $object_id);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}		
		public function tblupdateworkspacestatus($object_id, $status, $reason){
		
		$query 	= $this->db->prepare("UPDATE rm_workspaces SET status  = ? , reason  = ?   where object_id= ?  ");
		
		$query->bindValue(1, $status);
		$query->bindValue(2, $reason);

		$query->bindValue(3, $object_id);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}		
		
		public function updateWorspacedatainputsurveyor($offregnum, $callsign, $flag, $port, $datereg, $keellaying, $deliverydate,$solas, $marpol, $ibcigc,$ism ,$notation,$desaigndwt,$lpp, $moldedbreadth, $moldeddepth, $blublengthfromfp, $loadinginstr, $trimstabilitibook, $object_id ){
		
		$query 	= $this->db->prepare("UPDATE rm_workspaces SET offregnum  = ? , callsign  = ? ,flag = ?, port= ?, `datereg` = ?, `keellaying` =?, deliverydate = ?, solas = ?, marpol = ?,ibcigc =?,ism=?,
		notation=?,desaigndwt=?,lpp=?,moldedbreadth=?,moldeddepth=?,blublengthfromfp=?,loadinginstr=?,trimstabilitibook=?  where object_id= ?  ");
		
		$query->bindValue(1, $offregnum);
		$query->bindValue(2, $callsign);
		$query->bindValue(3, $flag);
		$query->bindValue(4, $port);
		$query->bindValue(5, $datereg);
		$query->bindValue(6, $keellaying);
		$query->bindValue(7, $deliverydate);
		$query->bindValue(8, $solas);
		$query->bindValue(9, $marpol);
		$query->bindValue(10, $ibcigc);
		$query->bindValue(11, $ism);
		$query->bindValue(12, $notation);
		$query->bindValue(13, $desaigndwt);
		$query->bindValue(14, $lpp);
		$query->bindValue(15, $moldedbreadth);
		$query->bindValue(16, $moldeddepth);
		$query->bindValue(17, $blublengthfromfp);
		$query->bindValue(18, $loadinginstr);
		$query->bindValue(19, $trimstabilitibook);
		
		
		$query->bindValue(20, $object_id);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}
		
		
		public function get_wokspaceUndone($status) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_workspaces where status= ?");
			#bind Value 
			$query->bindValue(1, $status);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
			
		}
		
		public function searchWorkspace($stringsearch){
		
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_workspaces where project like ? limit 10");
			#bind Value 
				$query->bindValue(1, $stringsearch);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		
		public function get_wokspaceByid($objectid){
		
		$query = $this->db->prepare("SELECT * from rm_workspaces where object_id = ? limit 1");
			#bind Value 
			$query->bindValue(1, $objectid);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		} 
		
		public function addSubcriber($objectid,$userid){
		
		
		$query 	= $this->db->prepare("INSERT INTO `rm_object_subscriptions` (object_id, contact_id ) VALUES (?,?) ");
	 
		$query->bindValue(1, $objectid);
		$query->bindValue(2, $userid);


		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}
		
		public function dellSubscriberbyobjt($objectid){
		
		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_object_subscriptions` WHERE `rm_object_subscriptions`.`object_id` = :proje");
		//$query->bindValue(1, $objectid);
		$query->bindParam(':proje', $objectid, PDO::PARAM_INT);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
		
		
		}
		
		
		public function dellSubcriber($objectid,$userid){
		
		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_object_subscriptions` WHERE `rm_object_subscriptions`.`object_id` = ? and contact_id= ? ");
		$query->bindValue(1, $objectid);
		$query->bindValue(2, $userid);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

		}
		
		public function getSubcriber($objectid){
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT rm_object_subscriptions.object_id , rm_object_subscriptions.contact_id,og_user.nama  from rm_object_subscriptions 
			LEFT JOIN og_user ON og_user.id_user  = rm_object_subscriptions.contact_id 
			where rm_object_subscriptions.object_id = ?");
			#bind Value 
			$query->bindValue(1, $objectid);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		
		}
		
		public function getTeamMember($idproj){
		
		$projeData= $this->get_wokspaceByid($idproj);
		
		foreach ($projeData as $projeDat){
		
			$team= $projeDat['team'];
			//$lead= $projeDat['lead'];
		
		}
		$team=$team  ; //. "," . $lead;
		
		//$team=substr($team, 1); // hilangkan , dalam huruf pertama
		return $team ;

		}
		public function cekAnggotaExist($idproj,$iduser){
		$projeData= $this->get_wokspaceByid($idproj);
		
		foreach ($projeData as $projeDat){
		
			$team= $projeDat['team'];
		}
			$team=substr($team, 1); // hilangkan , dalam huruf pertama
			
			$pieces = explode(",", $team);
			
			foreach($pieces as $piece){
			
			if($piece==$iduser){
			
			return true;
			break;
			}
			
			
			}
		
		return false ;
		
		
		}
		
		public function insertRead($rel_object_id, $contact_id,$is_read){
		
		$created_on = date("Y-m-d H:i:s");		
		$query 	= $this->db->prepare("INSERT INTO `rm_read_objects` (rel_object_id, contact_id, is_read, created_on ) VALUES (?,?,?,?) ");
	 
		$query->bindValue(1, $rel_object_id);
		$query->bindValue(2, $contact_id);
		$query->bindValue(3, $is_read);
		$query->bindValue(4, $created_on);


		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}
		
		public function getObjectread($rel_object_id,$contact_id){
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_read_objects where rel_object_id= ? and contact_id =? ");
			#bind Value 
			$query->bindValue(1, $rel_object_id);
			$query->bindValue(2, $contact_id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 $jml = $query->rowCount();
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $jml ;	

		}
		
		public function updateRead($is_read,$rel_object_id,$contact_id){
		
		$query 	= $this->db->prepare("UPDATE rm_read_objects SET is_read  = ?  where  	rel_object_id =? and 	contact_id = ?   ");
		 
			$query->bindValue(1, $is_read);
			$query->bindValue(2, $rel_object_id);
			$query->bindValue(3, $contact_id);

			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
				
		}

		public function updateReadMasif($is_read,$rel_object_id){
		
		$query 	= $this->db->prepare("UPDATE rm_read_objects SET is_read  = ?  where  	rel_object_id =?   ");
		 
			$query->bindValue(1, $is_read);
			$query->bindValue(2, $rel_object_id);


			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
				
		}		
		
		public function markreadUnread($rel_object_id,$contact_id,$status){
		
			$jml=$this->getObjectread($rel_object_id,$contact_id);
			
			if ($jml > 0) {
			
			$this->updateRead($status,$rel_object_id,$contact_id);
			
			} else {
			
			$this->insertRead($rel_object_id, $contact_id,$status);

			}

		}
		
		public function insertMessage($object_id, $text, $type_content){
		
		
		$query 	= $this->db->prepare("INSERT INTO `rm_project_messages` (object_id, text, type_content) VALUES (?,?,?) ");
	 
		$query->bindValue(1, $object_id);
		$query->bindValue(2, $text);
		$query->bindValue(3, $type_content);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}
		
		public function updateMessage($object_id, $text){
		
		$query 	= $this->db->prepare("UPDATE rm_project_messages SET text = ? where object_id= ?  ");
		 
			$query->bindValue(1, $text);

			$query->bindValue(2, $object_id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		
		}
		public function  getMessagebyobj($objectid){
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_project_messages where object_id= ? ");
			#bind Value 
			$query->bindValue(1, $objectid);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		}
		
		
		public function writeMessage($created_by_id,$name,$object_type_id,$text,$type_content,$correlation,$subscribers){
		
		$created_on = date("Y-m-d H:i:s");
		
		//inser tbl obj
		$this->InsertObject($object_type_id, $name, $created_on, $created_by_id);
		$objectNumber=$this->lastInsertId();
		
		//insert tbl message
		$this->insertMessage($objectNumber, $text, $type_content);
		//insert tbl corelation
		$this->InsertobjectCorelation($objectNumber,$correlation);
		
		//insertlogsAplikasi
		$this->WriteLogAplicationLogs($created_by_id,$objectNumber,$name,$created_by_id,"add",0,0,$text);
		
		$subscribers=substr($subscribers, 1); // hilangkan , dalam huruf pertama
		$pieces = explode(",", $subscribers);
		$pieces = array_unique($pieces);
		//insert tbl subscriber
		
		foreach($pieces as $piece) {
			
			$this->addSubcriber($objectNumber,$piece);
			//set blum di baca
			$this->insertRead($objectNumber, $piece,0);
			
		
		}
		//sent notification
		
		//#############notification do######################
		$subscriblist=$this->getSubcriber($objectNumber);
		
		foreach ($subscriblist as $subscriblis){
		
		//notification insert
		if ($subscriblis['contact_id']!=$created_by_id){
		$this->InsertNotftable($subscriblis['contact_id'], $objectNumber, 0, $created_on, "panel.php?module=projectDetail&id=".$objectNumber , 4 ,"add")	;	
		
		//send notification email
		$toemailbyiduser=$toemailbyiduser . "," . $subscriblis['contact_id'];
		}
		}
		
		$objectname= $this->Get_objectName_id($objectNumber);
		
		$AndDo=" Just Write the note " ;
		
		if ($toemailbyiduser!=""){
		$this->PreapareSendEmailNotif($objectNumber, $AndDo,$created_by_id,$objectname,$toemailbyiduser,$text);
		//###############3 notification END #####################		
		}
		
		
		
		
		
		}
		
		public function getTipeFilebyExt($ext){
		
		
		$query = $this->db->prepare("SELECT * from rm_file_types where extension= ? limit 1 ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $ext);
				 $query->bindColumn('id', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;
		}
		
		

		
		public function GetObjectbyproject($projectid,$objetipe,$limit,$tipe=0){
		
		if ($objetipe==6){
		//$tambahan=" and rm_project_file_revisions.revision_number=1";
		}else{
		$tambahan=" ";
		}

		if ($tipe==1){
			$strTambahan= " and rm_objects.name like '[DT%' ";
		}elseif ($tipe==2) {
			$strTambahan= " and rm_objects.name like '[IMDATE%' ";
		}elseif ($tipe==3) {
			$strTambahan= " and rm_objects.name like '[DRS%' ";
		}elseif ($tipe==4) {// yang belum selesai
			$strTambahan= " and rm_project_tasks.percent_completed !=100";
		}
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT  distinct rm_objects.id, rm_objects.object_type_id, rm_objects.created_by_id, rm_objects.updated_on ,
			rm_objects.updated_by_id , og_user.nama , rm_objects.name, rm_objects.created_on , rm_project_messages.text, rm_read_objects.is_read , rm_object_corelation.relatedobjectid  
			, rm_workspaces.project,rm_project_file_revisions.file_type_id ,rm_project_file_revisions.filesize,rm_file_types.icon, rm_project_tasks.assigned_to_contact_id,rm_project_tasks.start_date, rm_project_tasks.due_date,rm_project_tasks.percent_completed, rm_project_tasks.assigned_by_id FROM 
				rm_objects LEFT JOIN rm_project_messages ON rm_objects.id =rm_project_messages.object_id
				LEFT JOIN rm_read_objects ON rm_objects.id=rm_read_objects.rel_object_id
				LEFT JOIN rm_object_corelation ON rm_objects.id=rm_object_corelation.objectid
				LEFT JOIN og_user ON rm_objects.updated_by_id = og_user.id_user 
				LEFT JOIN rm_workspaces on rm_workspaces.object_id =rm_object_corelation.relatedobjectid
				LEFT JOIN rm_project_file_revisions ON rm_project_file_revisions.file_id =rm_objects.id
				LEFT JOIN rm_project_tasks ON rm_project_tasks.object_id =rm_objects.id
				LEFT JOIN rm_file_types on rm_project_file_revisions.file_type_id = rm_file_types.id
				where rm_object_corelation.`relatedobjectid`=:proje  and rm_objects.object_type_id = :objetipe and trashed_on='0000-00-00 00:00:00' $strTambahan group by rm_objects.id ". $tambahan  . " order by rm_objects.id desc limit :lim  ");
			#bind Value 
			// bug dalam limit
			$query->bindParam(':proje', $projectid, PDO::PARAM_INT);
			$query->bindParam(':lim', $limit, PDO::PARAM_INT);
			$query->bindParam(':objetipe', $objetipe, PDO::PARAM_INT);

			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();		
		
		}
		
		public function uploadFileobj($filename,$created_by_id,$tipeFileid,$path,$mimefile,$filesize,$subscribers,$correlation){
		
		
		$created_on = date("Y-m-d H:i:s");
		
		$this->InsertObject(6, $filename, $created_on, $created_by_id);//fileupload
		$lastid= $this->lastInsertId();
				//insert tbl corelation
		$this->InsertobjectCorelation($lastid,$correlation);

		$this->InsertObject(17, "", $created_on, $created_by_id); //revisi I
		$lastid2= $this->lastInsertId();
		$this->InsertobjectCorelation($lastid2,$correlation);
		$this->insertFilerevision($lastid2, $lastid, $tipeFileid, $path,  1, "-- Initial version --", $mimefile, $filesize, "");
		
		//insertlogsAplikasi
		$this->WriteLogAplicationLogs($created_by_id,$lastid,$filename,$created_by_id,"upload",0,0,$mimefile);
		
		
		$subscribers=substr($subscribers, 1); // hilangkan , dalam huruf pertama
		$pieces = explode(",", $subscribers);
		$pieces = array_unique($pieces);
		//insert tbl subscriber
		
		foreach($pieces as $piece) {
			
			$this->addSubcriber($lastid,$piece);
			//set blum di baca
			$this->insertRead($lastid, $piece,0);
			
		
		}
		
				//sent notification
		
		//#############notification do######################
		$subscriblist=$this->getSubcriber($lastid);
		
		foreach ($subscriblist as $subscriblis){
		
		//notification insert
		if ($subscriblis['contact_id']!=$created_by_id){
		$this->InsertNotftable($subscriblis['contact_id'], $lastid, 0, $created_on, "panel.php?module=projectDetail&id=".$lastid , 6 ,"add")	;	
		
		//send notification email
		$toemailbyiduser=$toemailbyiduser . "," . $subscriblis['contact_id'];
		}
		}
		
		$objectname= $this->Get_objectName_id($lastid);
		
		$AndDo=" JustUpload The new file " ;
		
		if ($toemailbyiduser!=""){
		$this->PreapareSendEmailNotif($lastid, $AndDo,$created_by_id,$objectname,$toemailbyiduser," ");
		//###############3 notification END #####################		
		}
		
		}
		
		public function aplicationReadlog($created_by_id,$rel_object_id,$action){
		
		$created_on = date("Y-m-d H:i:s");
		
		$query 	= $this->db->prepare("INSERT INTO `rm_application_read_logs` (taken_by_id, rel_object_id, created_on, created_by_id, action ) VALUES (?,?,?,?,?) ");
	 
		$query->bindValue(1, $created_by_id);
		$query->bindValue(2, $rel_object_id);
		$query->bindValue(3, $created_on);
		$query->bindValue(4, $created_by_id);
		$query->bindValue(5, $action);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		
		
		}
		
		public function GetaplicationReadlog($objectid){
		
		$query = $this->db->prepare("SELECT rm_application_read_logs.created_by_id,rm_application_read_logs.created_on, rm_application_read_logs.action, og_user.nama
				FROM rm_application_read_logs
				LEFT JOIN og_user ON rm_application_read_logs.created_by_id = og_user.id_user
				WHERE rm_application_read_logs.rel_object_id =? order by rm_application_read_logs.created_on desc ");
			#bind Value 
			$query->bindValue(1, $objectid);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		
		}
		
		
		function getTipeObject($objectid){
		
		/* $query = $this->db->prepare("SELECT rm_objects.object_type_id, rm_objects.name ,rm_objects.created_on ,rm_objects.created_by_id 	
		,rm_objects.updated_on 	,rm_objects.updated_by_id,  rm_object_types.name, rm_object_types.handler_class from rm_objects 
		LEFT JOIN rm_object_types ON rm_objects.object_type_id = rm_object_types .id where rm_objects.id = ? limit 1");
 */
		$query = $this->db->prepare("SELECT rm_object_types.handler_class from rm_objects 
		LEFT JOIN rm_object_types ON rm_objects.object_type_id = rm_object_types .id where rm_objects.id = ? limit 1");
			#bind Value 
			 $query->bindValue(1, $objectid);
			 $query->bindColumn('handler_class', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;

		}
		
		public function insertablecomment($object_id,$rel_object_id,$text){

		$query 	= $this->db->prepare("INSERT INTO `rm_comments` (	object_id, rel_object_id, text, author_name, author_email, author_homepage ) VALUES (?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $object_id);
		$query->bindValue(2, $rel_object_id);
		$query->bindValue(3, $text);
		$query->bindValue(4,"");
		$query->bindValue(5, "");
		$query->bindValue(6, "");
		

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		

		}
		
		public function insertComent($rel_object_id,$text,$created_by_id){
		
		//inserobject
		$created_on = date("Y-m-d H:i:s");
		$name=substr($text, 0, 200); 
		
		//inser tbl obj
		$this->InsertObject(14, $name, $created_on, $created_by_id);
		$objectNumber=$this->lastInsertId();
		
		//insertcomment
		
		$this->insertablecomment($objectNumber,$rel_object_id,$text);
		
		$listcorela=$this->GetCorelationname($rel_object_id);
		
		foreach($listcorela as $listcorel){
		$correlation=$listcorel['relatedobjectid'];
		}
		
		$this->InsertobjectCorelation($objectNumber,$correlation);
		//insertlogsAplikasi
		$this->WriteLogAplicationLogs($created_by_id,$rel_object_id,$name,$created_by_id,"comment",0,0,$text);

/* 		$subscriblist=$this->getSubcriber($rel_object_id);
		
		foreach ($subscriblist as $subscriblis){
		
		//notification insert
		if ($subscriblis['contact_id']!=$created_by_id){
		$this->InsertNotftable($subscriblis['contact_id'], $rel_object_id, 0, $created_on, "panel.php?module=projectDetail&id=" . $rel_object_id , 3 ,"add")	;	
		$toemailbyiduser=$toemailbyiduser . "," . $subscriblis['contact_id'] ;
		}

		}
		//send notification email
		
		$objectname= $this->Get_objectName_id($rel_object_id);
		
		$AndDo=" Just insert the Comment " ;
		
		if ($toemailbyiduser!=""){
		$this->PreapareSendEmailNotif($rel_object_id, $AndDo,$created_by_id,$objectname,$toemailbyiduser,$text);
		} */
		
		}
		
		public function sendNotificationAndEmail($rel_object_id,$created_by_id,$tipenotification,$text){
		
		if($tipenotification=="comment"){
			$link="panel.php?module=projectDetail&id=" . $rel_object_id;
			$AndDo=" Just insert the Comment " ;
			$numberIcon=3;
		}elseif($tipenotification=="file"){
			$link="panel.php?module=projectDetail&id=" . $rel_object_id;
			$AndDo=" Just Update File refision " ;
			$numberIcon=6;		
		}
		
		
		$created_on = date("Y-m-d H:i:s");
		$subscriblist=$this->getSubcriber($rel_object_id);
		
		foreach ($subscriblist as $subscriblis){
		
		//notification insert
		if ($subscriblis['contact_id']!=$created_by_id){
		$this->InsertNotftable($subscriblis['contact_id'], $rel_object_id, 0, $created_on, $link , $numberIcon ,"add")	;	
		$toemailbyiduser=$toemailbyiduser . "," . $subscriblis['contact_id'] ;
		}

		}
		//send notification email
		
		$objectname= $this->Get_objectName_id($rel_object_id);
		
		
		
		if ($toemailbyiduser!=""){
		$this->PreapareSendEmailNotif($rel_object_id, $AndDo,$created_by_id,$objectname,$toemailbyiduser,$text);
		}		
		
		
	}
		
		public function getcommentbyobj($rel_object_id){
		
		$query = $this->db->prepare("SELECT rm_objects.object_type_id, rm_objects.name ,rm_objects.created_on ,rm_objects.created_by_id 	,rm_objects.updated_on 	,rm_objects.updated_by_id,rm_comments.object_id ,  rm_comments.text ,og_user.nama,rm_biodata.path	from rm_objects 
				LEFT JOIN  rm_comments ON rm_objects.id=  rm_comments.object_id
				LEFT JOIN og_user ON rm_objects.created_by_id = og_user.id_user
				LEFT JOIN rm_biodata ON rm_objects.created_by_id = rm_biodata.id_user    	

				where rm_comments.rel_object_id = ? and rm_comments.object_id !=''  order by rm_objects.id asc ");
			#bind Value 
			$query->bindValue(1, $rel_object_id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		} 
		
		public function GetmessageByid($idobject){
		
		$query = $this->db->prepare("SELECT rm_objects.object_type_id, rm_objects.name ,rm_objects.created_on ,rm_objects.created_by_id 	,rm_objects.updated_on 	,rm_objects.updated_by_id,rm_project_tasks.text as task ,rm_project_tasks.due_date ,  rm_project_messages.text, og_user.nama	from rm_objects 
				LEFT JOIN  rm_project_messages ON rm_objects.id=  rm_project_messages.object_id 
				LEFT JOIN  rm_project_tasks ON rm_objects.id=  rm_project_tasks.object_id 
				LEFT JOIN og_user ON rm_objects.created_by_id = og_user.id_user  

				where rm_objects.id = ? limit 1");
			#bind Value 
			$query->bindValue(1, $idobject);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		}
		

		
		
		
		function updateDatabasereaddetail($objectid,$userid){
		

		//read set true
		$this->updateRead(1,$objectid,$userid);
		
		
		//aplication readlog
		$this->aplicationReadlog($userid,$objectid,"read");
		
		
		
		
		}
		
		function updateDatabasedownloaddetail($objectid,$userid){
				
		//aplication readlog
		$this->aplicationReadlog($userid,$objectid,"download");
		
		
		
		
		}
		
		
		

		public function updateFileDatabase($idobject,$created_by_id,$tipeFileid,$path,$revison,$ccomment,$mimefile,$filesize,$correlation){
		
		$created_on = date("Y-m-d H:i:s");
		//update file
		//updateobject
		$this->updateObject($created_on, $created_by_id,$idobject);
		//create object
		$this->InsertObject(17, "", $created_on, $created_by_id); //revisi I
		$lastid2= $this->lastInsertId();
		$this->InsertobjectCorelation($lastid2,$correlation);
		$this->insertFilerevision($lastid2, $idobject, $tipeFileid, $path,  $revison, $ccomment, $mimefile, $filesize, "");
		//set read become unread
		$this->updateReadMasif(0,$idobject);
		
		//insertlogsAplikasi
		$this->WriteLogAplicationLogs($created_by_id,$idobject,"revision " . $revison,$created_by_id,"upload",0,0,$mimefile);		
		
		//send notification

/* //#############notification do######################
		$subscriblist=$this->getSubcriber($idobject);
		
		foreach ($subscriblist as $subscriblis){
		
		if ($subscriblis['contact_id']!=$created_by_id){
		//notification insert
		$this->InsertNotftable($subscriblis['contact_id'], $idobject, 0, $created_on, "panel.php?module=projectDetail&id=" . $idobject , 6 ,"add")	;	
		$toemailbyiduser=$toemailbyiduser . "," . $subscriblis['contact_id'] ;
		//send notification email
		}
		}
		
		$objectname= $this->Get_objectName_id($idobject);
		
		$AndDo=" Just Update File refision " ;
		if ($toemailbyiduser!=""){
		$this->PreapareSendEmailNotif($idobject, $AndDo,$created_by_id,$objectname,$toemailbyiduser,$ccomment);
		//###############3 notification END #####################		
		} */
		
		

		}
		
		public function updateNotes($idobject,$created_by_id,$text,$caption){
		
		$created_on = date("Y-m-d H:i:s");
		$this->updateObject($created_on, $created_by_id,$idobject);
		$this->updateObjectNama($caption,$idobject);
		$this->updateMessage($idobject, $text);
		$this->updateReadMasif(0,$idobject);

		 //insertlogsAplikasi
		$this->WriteLogAplicationLogs($created_by_id,$idobject,$caption,$created_by_id,"edit",0,0,$text);
		
		//send notification

//#############notification do######################
		$subscriblist=$this->getSubcriber($idobject);
		
		foreach ($subscriblist as $subscriblis){
		
		if ($subscriblis['contact_id']!=$created_by_id){
		//notification insert
		$this->InsertNotftable($subscriblis['contact_id'], $idobject, 0, $created_on, "panel.php?module=projectDetail&id=" . $idobject , 6 ,"add")	;	
		$toemailbyiduser=$toemailbyiduser . "," . $subscriblis['contact_id'] ;
		//send notification email
		}
		}
		
		$objectname= $this->Get_objectName_id($idobject);
		
		$AndDo=" Just Update Noted " ;
		if ($toemailbyiduser!=""){
		$this->PreapareSendEmailNotif($idobject, $AndDo,$created_by_id,$objectname,$toemailbyiduser,$text);
		//###############3 notification END #####################				
		}
		
		
		
		
		}
		
		public function sumCostProject($idProj,$kurs){
		
		$query = $this->db->prepare("SELECT  SUM(`cost`) AS total  FROM `rm_cost` WHERE `currency`=? and tipeKegiatan=3 and idKegiatan=? and  realisation !='0000-00-00'");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $kurs);
				$query->bindValue(2, $idProj);
				 $query->bindColumn('total', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;
		
		}
		
		public function insertTbltask_obj($object_id, $parent_id, $text, $due_date, $start_date, $assigned_to_contact_id, $assigned_on, $assigned_by_id,$type_content ){
		
		
		$query 	= $this->db->prepare("INSERT INTO `rm_project_tasks` (object_id, parent_id, text, due_date, start_date, assigned_to_contact_id, assigned_on, assigned_by_id,type_content ) VALUES (?,?,?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $object_id);
		$query->bindValue(2, $parent_id);
		$query->bindValue(3, $text);
		$query->bindValue(4, $due_date);
		$query->bindValue(5, $start_date);
		$query->bindValue(6, $assigned_to_contact_id);
		$query->bindValue(7, $assigned_on);
		$query->bindValue(8, $assigned_by_id);
		$query->bindValue(9, $type_content);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

		}
		
		public function updateTabletaskAssigned_obj($assigned_to_contact_id,$assigned_on,$assigned_by_id,$object_id){
		
		$query 	= $this->db->prepare("UPDATE rm_project_tasks SET assigned_to_contact_id  = ? , assigned_on  = ? , assigned_by_id =?	where object_id = ?  ");
		 
			$query->bindValue(1, $assigned_to_contact_id);
			$query->bindValue(2, $assigned_on);
			$query->bindValue(3, $assigned_by_id);
			$query->bindValue(4, $object_id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		
		
		}
		
		public function updatetabletaskProgresstbl($completed_by_id,$percent_completed,$object_id){
		
		if ($percent_completed>=100){
		$completed_on = date("Y-m-d H:i:s");
		$completed_by_id=$completed_by_id;
		
		$this->UpdateTaskDone($completed_on,$object_id);
		
		}else{
		$completed_on = date("0000-00-00 00:00:00");
		$completed_by_id=0;
		
		$this->UpdateTaskDone($completed_on,$object_id);
		}
		
		$query 	= $this->db->prepare("UPDATE rm_project_tasks SET completed_on  = ? , completed_by_id  = ? , percent_completed  =?	where object_id = ?  ");
		 
			$query->bindValue(1, $completed_on);
			$query->bindValue(2, $completed_by_id);
			$query->bindValue(3, $percent_completed);
			$query->bindValue(4, $object_id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		
		
		}
		
		public function updateprogressTaskobj($completed_by_id,$percent_completed,$object_id){
		
		
		$this->updatetabletaskProgresstbl($completed_by_id,$percent_completed,$object_id);
		//insertlogsAplikasi
		$this->WriteLogAplicationLogs($completed_by_id,$object_id,"progress set to ",$completed_by_id,"edit",0,0,$percent_completed);		
		
		//sent notification
		
		//#############notification do######################
		$subscriblist=$this->getSubcriber($objectNumber);
		
		foreach ($subscriblist as $subscriblis){
		
		//notification insert
		if ($subscriblis['contact_id']!=$created_by_id){
		$this->InsertNotftable($subscriblis['contact_id'], $objectNumber, 0, $created_on, "panel.php?module=projectDetail&id=".$object_id , 5 ,"update")	;	
		
		//send notification email
		$toemailbyiduser=$toemailbyiduser . "," . $subscriblis['contact_id'];
		}
		}
		
		$objectname= $this->Get_objectName_id($object_id);
		
		$AndDo=" Just Finish the task " ;
		
		if ($toemailbyiduser!=""){
		$this->PreapareSendEmailNotif($objectNumber, $AndDo,$created_by_id,$objectname,$toemailbyiduser," ");
		//###############3 notification END #####################
		}
		}
		
		public function getProgresstaskbyProject($id_project){
		
		$jml=$this->getJmltaskbyProject($id_project);
		$query = $this->db->prepare("SELECT SUM(rm_project_tasks.percent_completed) AS total  FROM `rm_project_tasks` 
LEFT JOIN rm_object_corelation on rm_project_tasks.`object_id`= rm_object_corelation.`objectid`  
LEFT JOIN rm_objects on rm_project_tasks.`object_id`= rm_objects.id  

where rm_object_corelation.`relatedobjectid`=? and rm_objects.trashed_on='0000-00-00 00:00:00'");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_project);
				 $query->bindColumn('total', $hak);
			try{
				$query->execute();
				
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			
			if ($jml==0){$jml=1;}
			$progress=  $hak/ $jml ;
			
		
		return $progress ;

		}
		
		public function getJmltaskbyProject($id_project){
		
		
		$query = $this->db->prepare("SELECT rm_project_tasks.percent_completed FROM `rm_project_tasks` 
LEFT JOIN rm_object_corelation on rm_project_tasks.`object_id`= rm_object_corelation.`objectid`  
LEFT JOIN rm_objects on rm_project_tasks.`object_id`= rm_objects.id  

where rm_object_corelation.`relatedobjectid`=? and rm_objects.trashed_on='0000-00-00 00:00:00'");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_project);
				 $query->bindColumn('percent_completed', $hak);
			try{
				$query->execute();
				$jml=$query->rowCount();
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		return $jml ;

		}
		
		public function gettaskbyProjectUndone($id_project,$limit){
		
		
		$query = $this->db->prepare("SELECT rm_project_tasks.object_id, rm_project_tasks.percent_completed,rm_objects.name, rm_project_tasks.due_date , og_user.nama  FROM `rm_project_tasks` 
LEFT JOIN rm_object_corelation on rm_project_tasks.`object_id`= rm_object_corelation.`objectid`  
LEFT JOIN rm_objects on rm_project_tasks.`object_id`= rm_objects.id  
LEFT JOIN og_user ON rm_project_tasks.assigned_to_contact_id  = og_user.id_user

where rm_object_corelation.`relatedobjectid`=:proje and rm_objects.trashed_on='0000-00-00 00:00:00' and rm_project_tasks.percent_completed != 100 
order by rm_project_tasks.due_date asc limit :lim");
			#bind Value 
			#bind Value 
			$query->bindParam(':proje', $id_project, PDO::PARAM_INT);
			$query->bindParam(':lim', $limit, PDO::PARAM_INT);

			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		return $query->fetchAll();

		}
		public function getProjectTaskbyIdproject($id_project){
		
		$query = $this->db->prepare("SELECT rm_project_tasks.object_id, rm_project_tasks.percent_completed,rm_objects.name, rm_project_tasks.due_date , og_user.nama  FROM `rm_project_tasks` 
LEFT JOIN rm_object_corelation on rm_project_tasks.`object_id`= rm_object_corelation.`objectid`  
LEFT JOIN rm_objects on rm_project_tasks.`object_id`= rm_objects.id  
LEFT JOIN og_user ON rm_project_tasks.assigned_to_contact_id  = og_user.id_user

where rm_object_corelation.`relatedobjectid`=:proje
order by rm_project_tasks.due_date asc ");
			#bind Value 
			#bind Value 
			$query->bindParam(':proje', $id_project, PDO::PARAM_INT);


			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		return $query->fetchAll();

		}
		
		public function getTaskByMonthbyuser($idUser){
		
			$delidate = date("Y-m"); // this month
			$delidate =$delidate."-01";
			$delidates = date("Y") . "-" .  sprintf("%02s", date("m"))  ."-28";
			$monthlynext = strtotime("+1 month".$delidate);
			$monthlylast = strtotime("-1 month".$delidates);
			$monthlynext = date("Y-m-d", $monthlynext);
			$monthlylast = date("Y-m-d", $monthlylast);
			
			
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_task` WHERE `due` > ? and `due` < ?  and `userId`=? ");
			#bind Value 
			$query->bindValue(3, $idUser);
			$query->bindValue(1, $monthlylast);
			$query->bindValue(2, $monthlynext);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		
		}
		
		
		function addTaskobj($object_type_id,$name,$created_by_id,$correlation,$parent_id,$text,$due_date,$start_date,$assigned_to_contact_id,$subscribers){
		
		
			$created_on = date("Y-m-d H:i:s");
			
			//inser tbl obj
			$this->InsertObject($object_type_id, $name, $created_on, $created_by_id);
			$objectNumber=$this->lastInsertId();
			
			//insert tbl task
			$this->insertTbltask_obj($objectNumber, $parent_id, $text, $due_date, $start_date, $assigned_to_contact_id, $created_on, $created_by_id,"html" );
			//insert tbl corelation
			$this->InsertobjectCorelation($objectNumber,$correlation);
			
			$subscribers=substr($subscribers, 1); // hilangkan , dalam huruf pertama
			$pieces = explode(",", $subscribers);
			$pieces = array_unique($pieces);	
			
			$listtemamembers=$this->getTeamMember($correlation);
			$TeamMembers = explode(",", $listtemamembers);	
			$TeamMembers = array_unique($TeamMembers);		
			//
			//set blum di baca
			foreach($TeamMembers as $TeamMember) {
				
				$this->insertRead($objectNumber, $TeamMember,0);
				
			}
			
				//insert tbl subscriber
			foreach($pieces as $piece) {
				
				$this->addSubcriber($objectNumber,$piece);

			}
			
			//insertlogsAplikasi
			$this->WriteLogAplicationLogs($created_by_id,$objectNumber,$name,$created_by_id,"add",0,0,$assigned_to_contact_id);
			
			//task in personal
			
			$this->InsertTask($name, $assigned_to_contact_id, $due_date,'0000-00-00 00:00:00', 3 ,$objectNumber,0,$text,$created_by_id);

			
			//#############notification do######################
			$subscriblist=$this->getSubcriber($objectNumber);
			
			foreach ($subscriblist as $subscriblis){
			
			//notification insert
			if ($subscriblis['contact_id']!=$created_by_id){
			$this->InsertNotftable($subscriblis['contact_id'], $objectNumber, 0, $created_on, "panel.php?module=projectDetail&id=" . $objectNumber , 5 ,"add")	;	
			$toemailbyiduser = $toemailbyiduser . "," .  $subscriblis['contact_id'] ;
			//send notification email
			}
			}
			
			$objectname= $this->Get_objectName_id($idobject);
			
			$AndDo=" The new Task has been created " ;
			$ccomment = "the Task assigment to " .  $this->Get_nama_id($assigned_to_contact_id) . " by " .   $this->Get_nama_id($created_by_id);
			
			if ($toemailbyiduser!=""){
			$this->PreapareSendEmailNotif($objectNumber, $AndDo,$created_by_id,$objectname,$toemailbyiduser,$ccomment);
			//###############3 notification END #####################
			}
		
		return $objectNumber;
		}
		public function get_projectTaskbyid($object_id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_project_tasks where object_id= ?");
			#bind Value 
			$query->bindValue(1, $object_id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
			
		}
		
		public function Get_projectbymember($idUser){
		
		$idUser="%,". $idUser ."%";
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_workspaces` WHERE `team` like ?  ");
			#bind Value 
			$query->bindValue(1, $idUser);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		
		}
		
		
		public function InsertTask($pekerjaan, $userId, $due, $finish, $tipeKegiatan ,$idKegiatan,	$shared,$desck,$oleh){
	
		$query 	= $this->db->prepare("INSERT INTO `rm_task` (pekerjaan,userId,due,finish,tipeKegiatan, idKegiatan, shared,desck,oleh  ) VALUES (?, ?, ?, ?, ?, ?, ?,?,?) ");
	 
		$query->bindValue(1, $pekerjaan);
		$query->bindValue(2, $userId);
		$query->bindValue(3, $due);
		$query->bindValue(4, $finish);
		$query->bindValue(5, $tipeKegiatan);
		$query->bindValue(6, $idKegiatan);
		$query->bindValue(7, $shared);
		$query->bindValue(8, $desck);
		$query->bindValue(9, $oleh);


		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}

		
	}
	
	public function UpdateTaskDone($realization,$idkegiatan){
	
		$query 	= $this->db->prepare("UPDATE rm_task SET finish=? where  tipeKegiatan= 3 and idKegiatan = ?  ");
	 
		$query->bindValue(1, $realization);
		$query->bindValue(2, $idkegiatan);
		
 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function InsertNotftable($userId, $objectid, $is_read, $created_on, $link,$tipe ,$action){
	
		$query 	= $this->db->prepare("INSERT INTO `rm_notification` (userId, objectid, is_read, created_on, link,tipe ,action ) VALUES (?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $userId);
		$query->bindValue(2, $objectid);
		$query->bindValue(3, $is_read);
		$query->bindValue(4, $created_on);
		$query->bindValue(5, $link);
		$query->bindValue(6, $tipe );
		$query->bindValue(7, $action );

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	
	}
	
	public function updateNotftable($is_read, $userId,$objectid){
	
	
	$query 	= $this->db->prepare("UPDATE rm_notification SET is_read=? where  userId = ? and objectid = ?  limit 1 ");
	 
		$query->bindValue(1, $is_read);
		$query->bindValue(2, $userId);
		$query->bindValue(3, $objectid);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	
	
	
	}
	
	public function getNotifiObj($userId){
	
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT rm_notification.link ,  rm_notification.action,rm_notification.created_on,rm_notification_type.nama,rm_notification_type.class from   rm_notification

				LEFT JOIN rm_notification_type on rm_notification_type.id = rm_notification.tipe
				 where rm_notification.userId= ? and rm_notification.is_read= 0  order by rm_notification.created_on desc ");
			#bind Value 
		$query->bindValue(1, $userId);

		
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
			
	}
	public function getNotifiObjJml($userId){
	
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from  rm_notification where userId= ?  and is_read= 0 ");
			#bind Value 
		$query->bindValue(1, $userId);
		
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			$jml = $query->rowCount();
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $jml ;
			
	}
	
	public function getActivity($startidmax,$lim,$idproject){
	
			$query = $this->db->prepare("SELECT  rm_object_corelation.relatedobjectid , rm_objects.object_type_id,rm_objects.created_on, rm_objects.updated_on, 
			rm_objects.name, rm_objects.`trashed_on`,rm_objects.`trashed_by_id` ,rm_objects.updated_by_id ,og_user.nick,og_user.nama as jeneng,
			rm_objects.id,rm_object_types.handler_class,rm_biodata.path,rm_object_types.name as nama, rm_comments.rel_object_id from rm_objects
			LEFT JOIN og_user ON rm_objects.updated_by_id = og_user.id_user
			LEFT JOIN rm_comments ON rm_comments.object_id=  rm_objects.id
			LEFT JOIN rm_biodata ON rm_objects.updated_by_id =  rm_biodata.`id_user`
			LEFT JOIN rm_object_types ON rm_objects.object_type_id = rm_object_types.id 

			LEFT JOIN rm_object_corelation ON rm_object_corelation.objectid = rm_objects.id where

			rm_objects.object_type_id != 17  and  rm_objects.updated_on < :startid and  rm_object_corelation.relatedobjectid = :idproje
			order by rm_objects.updated_on desc limit :lim ");		
			#bind Value 
			
			$query->bindParam(':startid', $startidmax);
			$query->bindParam(':lim', $lim, PDO::PARAM_INT);
			$query->bindParam(':idproje', $idproject, PDO::PARAM_INT);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
	
	}
	
	public function getNumActivity($startidmax,$lim){
	
			$query = $this->db->prepare("SELECT  rm_objects.object_type_id,rm_objects.created_on, rm_objects.updated_on, 
			rm_objects.name, rm_objects.`trashed_on`,rm_objects.`trashed_by_id` ,rm_objects.updated_by_id ,og_user.nick,og_user.nama as jeneng,
			rm_objects.id,rm_object_types.handler_class,rm_biodata.path,rm_object_types.name as nama, rm_comments.rel_object_id from rm_objects
			LEFT JOIN og_user ON rm_objects.updated_by_id = og_user.id_user
			LEFT JOIN rm_comments ON rm_comments.object_id=  rm_objects.id
			LEFT JOIN rm_biodata ON rm_objects.updated_by_id =  rm_biodata.`id_user`
			LEFT JOIN rm_object_types ON rm_objects.object_type_id = rm_object_types.id where  rm_objects.object_type_id != 17 and  rm_objects.updated_on < :startid
			order by rm_objects.updated_on desc limit :lim ");		
			#bind Value 
			
			$query->bindParam(':startid', $startidmax);
			$query->bindParam(':lim', $lim, PDO::PARAM_INT);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 $jml = $query->rowCount();
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $jml ;	
		
	
	}
	
	public function getObjtcommenbyid($idcomment){
	
	$query = $this->db->prepare("SELECT rm_comments.object_id ,rm_comments.rel_object_id,rm_objects.name,rm_objects.object_type_id from rm_comments 

				LEFT JOIN rm_objects ON rm_comments.object_id = rm_objects.id

				where rm_comments.object_id = ? limit 1");
			#bind Value 
			#bind Value 
			$query->bindValue(1, $idcomment);

		
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

	}
	
	
	public function PreapareSendEmailNotif($objectid, $AndDo,$iduser,$objectname,$toemailbyiduser,$message){
	
	//email from
	$formEmail=$this->Get_email_id($iduser);
	
	//nama pengirim
	
	$namaUser=$this->Get_nama_id($iduser);
	
	//$objectrelated
	
	$relatedss=$this->GetCorelationname($objectid);
	
	foreach($relatedss as $relateds ){
	$related=$relateds['project'];
	}
	
	
	
	
	
	$subject=  $namaUser. $AndDo .  $objectname ;
	
	$emaillist=$this->getEmailbylistid($toemailbyiduser);
	
			foreach ($emaillist as $emaillis){
			
			$peopleinvolve=$peopleinvolve . " ," . $emaillis['nama'];
			
			}
			

			
			$peopleinvolve=$peopleinvolve .", " .$this->Get_nama_id($iduser);
	
	$header="<table width='736' border='1' >
  <tr>
    <th width='82' height='83' scope='col'><img alt='' src='data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAAAmCAYAAAB0xJ2ZAAAABGdBTUEAALGOfPtRkwAAACBjSFJNAAB6JQAAgIMAAPn/AACA6QAAdTAAAOpgAAA6mAAAF2+SX8VGAAAACXBIWXMAAAsSAAALEgHS3X78AAAJ0klEQVRoQ+VaDawdRRUetVRERPxBDWhQ4h/+ICYoCIoSBRX8i9hggqZRiCi0DbXtuzu79959t6/te6XU0j6ooKiYoIYGYqAoRWKiIAgIWIEaFEURbCsIFJTyivWs33dm9r7Ze/e+3UdrYvEk5+3Onpkzc745c+bM3Gf2eErk82Y8y0xTxo3Jnuu//p9RLCeZtuwww7IVQIyaefJKL3mWUJrtY1pyjLHSxIyfh+ft4Ftg+AqUl8Dot6qsA08YBbflftOQk33rPZDSbCYMfh94GYz5IYx73CyHYSu9gcOel3hug2P5jYmzbSbxshScoP0eR1aOx8DHzWJZC2PG8P4FE8lCgHExjPw2+G9mBMZxtmls7J8EIS+Tm2CClchFXvOzhCzW97DMBiA3mhYMpAfwmRseMgFZCray0gzJZ8wCeZfXEpCVe6DsHrjaTVhLDTNXnu8l9ShF5I0lNams8Rxjxl7mpfUolQPR9xrlEVlVe/1aeT/AGMf4H1GvoOtbcC8I8I79OrJpZkf+Ct3v8K09ca2Q6VLngGM510vq0brseWjzmK5RzsYK1fEDL61HTXmnWYZ2nC0+OZamfNZLq4leYWUBJvEOs5j99/Pe0DmD40tkk1kdTnJYkQjGcq+X1CMHwB8VROqgOybyBMqv8jWqycphuobZNl+7sVzhpfWJu0Uz+5kCGdpFpmeQ3ZIIgmNYyQGw0UvqUS8AdDl9l6N8jWqy8jbM+ASAm0C7CSyDHXhe7KXTozTbF7quV2/sXQ5kAtySnVimb3QNQuEgAMaxpmloGZUBoEFJjvA1qok6GtmLlc+EAauy/U2UvcRLp0+L5EUAc+Og5eDAwY6iFAoIQIL9lDSE5GIxEo22/ALuuQ2o3oX3b8GwD6s8p+kAEMly05H1kK3HANYj+G3A+4Uw/LV4XgYd6/BtGeqVROspaBRgjWaHKKfZ3vqNXpXKdp3x0EayfoOXpfLqfgCs/Bz8QQgf0rWoAQlMA4kcy7Gcr52Q6gIQi9X2jNacGermeyQfA7hv6Mr4pDyRU3zLcpor+2FCzgD/GHW3QMdOPHfCve9F/2MYz77Q/Q3VGdqYs/OCM4oA0FALZRbbii6HEmYdDj6Sb+pA3DY4NQANma8dqn4w6zJ3H/Le1JS3q4xtqUODmHxfZWW0CLrb6JP1CFaeBJHziYqx5Vm5wY2lhB3IlxcBIHMgbESlrEQgiCIV50GFHVFmkZ+TygDI3XgIwbAtT6s+ylU3jI/kRJWTegFgf1a+66VF4tLkvs/+WXcQs79wzGXyGFtin4ANaHQTRlk5C3wcBrtQy6FXcCnwQDJLl8Dv+wHAemSkbcujbml5Gb2ngYNLSGUAxNklXlqkGG5NHYMMq8vsy8rD/QBwsAkyw/nyUt+lo0QOBvKPdl2KChIRDOgI8MYCAFyLkRyJ7ze62fTfnWt/zWucpLoAxPJxAHpf15t2B/d94MxGcqrvskiRjPjBOdZ1lEUY2E1dAMgWLh/jSBp+G9YgtcprKlIVAGk2A3WWan80fldnP+RCgQPgQLpJQg8lcrQaktd3y+BSvN9WMJYczhK9pil/R52ZXlORpgIgy56D8axVt8/lu5MLBXVv3QUO0M57iYlKDEPyZaBG8xwuv610y8VYLpGc4zUVaSoA0uxwtyzB7INekG+VYUx6plwouD3+Zu24jLi3MnCEAFj5Fdps6gOAZRqVl9mmJU+i/lu8tkmaCgBejHBc/JbIg3D/ddBxFvq8DPVvUxl1P9NlUSioEbxOwkyXET0jCQKhA+AOcIkH6D78r25dsks+fuS1TdJUAFyU7QVdv0Pwuxoe1H/MbiNhasrj/f3XYPbX7TT/4NB8s1dfpBYyxA4jv6+vezG2JSu3uuUA7upAKsrzehv18z74dOUPeI2OqoIgdTHzG0QRQNCxTJM5Qfon/MjOmbmVUYS83Q3OsQPgbOj4ZR8A+cVDAzOumZlntrFyp8pyqgKgilw2ete0YgL7s/IAAEDeHDbUtStbITzMq3eUZB+CB0xow1wBj6/cMWIY1AtAngpTD9d+uBRoYATgctpVAEhWLihMThW7eHcNZ/X1MGR7d4AMJjQmwaB5s2NlrlbsGuZZO8O5m8RLlEEAkKysLlxSOP0P4bmPyncHALGcXvC0KnZJ2TzXmNdJ3Gfz2SXzne5KpUQrlNFANVjere2rDkMj8hp4wT/7ALQ+Mdo9HnBabQBcsH8EbYLtPkaywY5pdGhsLxMMoteQhrZzZ4H7uns127oOeo/Da/W+jzpykHiE5V1AIq9zZS9zu0X5YWgQxXKeB66a3ex3fMuA3Dq/Ttc6lXEgIdP4NiJ+ks3yLdx9gJXNKqcXEAgXHJ135BTLQdC7VfWyHnlM6/0EQLyp23by+zQuVpEtWvl1rSBIoLmVp9nLfeMS4g1LR05GpTEo5s9RC8FfMSlSYXZWIJRbOPqmciy84lg1vIkd4EvYv3tpEQwdQZ0k5Oy9mndYJDz5N9YhKHWJt1Qa1CqY8Y3gRrCrQDy72+xTGMQBmOELwCvNbH+1xPW5XJajzie0TGrKoRjkuTDoQP9lkhrY40fkBPDB/st/l+bLCzCe2ysBoPH0viY8ZSxM9KxswAzuwJMZ3c0wfgtm8894vwHIngRGloVl0UYQs/Jp1wYp6PlU6sshMVtL5YvoaAPaXIX3OfhWfrjaVXLGX6fLb6pUON/Z2vIPlA/3rT3F8j0IaPzd4H+bIfmoWcALRTYEWon+5Hwt6l2qAYtbh0XU5z3cEAAaRO4HzjMBwPVo/yT6uBO8CuUT0X7Xfr5Os/0RaGdB/8AfQgrsjH8KHnuc19BDMSJ6rCB8BwPcivc/abBwWdtmGLAGBj+G7ytQfgrPDp5/wfcR1B+coubEEx1/6OStUneXQe7Qlq/DO+ZAx9HQR9BnFJixgTIew8lcpk1sjy0ciqinTtBjvY5ewc3xoykhK0vAt6CTj2CQF6LhJdq4jfQyATD8zwveEjXlD6gHIHhNDnkLafR0r7DpRW2ZDQCuBCjbdIB5kmSxnRZ5M4DwMwimwVzHdQ4+nEDdmbBr8XZqSmI6THfn5UYbCUIKhCMZhYsfCkXbzDCMTjDzkbxHf7BYIK9A3e0w4ss6U1UUIyaM4DQXQ2eMZWHlc3iejn5iPFeAfwqe6G6DodHMC3IuMzRk1mE7AtqSJ8BnI08pv4QpEO/7mLMzqWki2sfySS9BUMsOMcvkVH2GRFS5FusQf6lpYauKZSn0X47+7sf7Fhe5MVBexdN4Dpyzxvcqg+mBZBpML8rzkER/FxhWm/6niSc4Hrvdv7fw6HwaQJoHYBlkV+P9bhcrBrCLTQTyVvAVMPirWOtHwjtf6HuoQcb8BwVdHIgFBDbVAAAAAElFTkSuQmCC' /></th>
    <th width='638' scope='col'><p align='left'>$subject</p>
    <p align='left'>  $objectname </p></th>
  </tr>";
  
  $body="<tr>
    <td colspan='2' height='202' >$message</td>
  </tr>";
  
  $footer=" <tr>
    <td colspan='2'><div style='padding: 14px; clear: both; border-top: 2px solid rgb(129, 130, 131); font-family: Verdana,Arial,sans-serif; font-size: 12px; background-color: rgb(187, 187, 187);'> Workspaces: <span style='border-color: #5229A3; background-color: #5229A3; color: #E0D5F9; 
	padding: 1px 5px; font-size: 90%;'>$related</span>
    <div> Involved people: $peopleinvolve </div></div></div></td>
  </tr>
</table><p>
This is a system notification, do not reply to this email.<br>
<a href='http://z2ex.bki.co.id/n_ogs/' >http://z2ex.bki.co.id/n_ogs/</a>
";

	$bodymessage= $header . $body . $footer ;
	
	
	
	$this->sendEmail($formEmail,$toemailbyiduser,$bodymessage,$subject);
	
	}
	
	
	public function sendEmail($formEmail,$toemailbyiduser,$message,$subject,$external='',$atthment=''){
			
		$piecesExternalEmail= explode(",", $external);
		//$emaillist=explode(",", $toemailbyiduser);
		if ($formEmail!=0){
			$emaillist=$this->getEmailbylistid($toemailbyiduser);
			$nameSender=$this->Get_nama_email($formEmail);

		}else{
			$formEmail="no_reply_Zee@bki.co.id";
			$emaillist=$this->getEmailbylistid($toemailbyiduser);
			$nameSender= "BahteraZee";
		}

		$this->emailHandler($formEmail, $nameSender, $emaillist, $message, $subject, $external, $atthment);
	}

	public function emailHandler($formEmail, $nameSender, $addresses, $message, $subject, $addressesExt=array(), $attachment='')
	{
		date_default_timezone_set('Asia/Jakarta');

		require_once '../class/mailer/PHPMailerAutoload.php';

		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();

		$mail->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = "mail.bki.co.id";
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = 25;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = false;
		//Username to use for SMTP authentication
		$mail->Username = "triyan";
		//Password to use for SMTP authentication
		$mail->Password = "tes123triyan";
		//Set who the message is to be sent from
		$mail->setFrom($formEmail, $nameSender);
		//Set an alternative reply-to address
		//$mail->addReplyTo('replyto@example.com', 'First Last');
		//Set who the message is to be sent to
		if(!empty($addresses))
		{
			foreach ($addresses as $adr){
				$mail->addAddress($adr['email'], $adr['nama']);
			}	
		}

		if(!empty($addressesExt))
		{
			if(is_array($addressesExt))
			{
				foreach ($addressesExt as $axt) { //external email
					$mail->addAddress($axt, $axt);
				}
			}else
			{
				$mail->addAddress($addressesExt, $addressesExt);
			}
		}

		if ($attachment!='') {
			$mail->addAttachment($attachment, 'Lampiran.pdf');
		}
		

		//Set the subject line
		$mail->Subject = $subject ;
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->msgHTML($message);
		//Replace the plain text body with one created manually
		$mail->AltBody = 'OGS';
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail->send()) {
			return "Mailer Error: " . $mail->ErrorInfo;
		} else {
			return "Message sent!";
		}
	}

	
function createEventCalenderEmail($formEmail,$toemailbyiduser,$message,$location,$stardate,$endate,$sumary,$external=""){
			
			$emaillist=$this->getEmailbylistid($toemailbyiduser);
			$nameSender=$this->Get_nama_email($formEmail);
			$piecesExternalEmail= explode(",", $external);

				date_default_timezone_set('Asia/Jakarta');
				
$startDateTime= date('Ymd',strtotime($stardate)).'T'.date('His',strtotime($stardate)) ;
$endDateTime=date('Ymd',strtotime($endate)).'T'.date('His',strtotime($endate)) ;
$location=$location;
$cal_uid = date('Ymd').'T'.date('His')."-".rand()."@bki.co.id";
$descriptioon= htmlentities(($message)) ;
$cname= $sumary;

				foreach ($emaillist as $emaillis){
				
				$peserta=$peserta . "ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;CN='$emaillis[nama]';RSVP=TRUE:mailto:$emaillis[email]". "\r\n";
				

				}


				foreach ($piecesExternalEmail as $piecesExternalEmai){
				
				$peserta=$peserta . "ATTENDEE;ROLE=REQ-PARTICIPANT;PARTSTAT=NEEDS-ACTION;CN='$piecesExternalEmai';RSVP=TRUE:mailto:$piecesExternalEmai" . "\r\n";
				
				}


				

$text="
BEGIN:VCALENDAR
VERSION:2.0
BEGIN:VEVENT
CATEGORIES:MEETING
DTSTART:".$startDateTime."
DTEND:".$endDateTime."
LOCATION:".$location ."

". 
 $peserta . "
ORGANIZER;CN='". $nameSender . "':mailto:". 'Z2ex@bki.co.id' ."
UID:".$cal_uid."
SUMMARY: ".$cname."
DESCRIPTION:".$descriptioon."
CLASS:PUBLIC
END:VEVENT
END:VCALENDAR";
			


				date_default_timezone_set('Asia/Jakarta');

				require_once '../class/mailer/PHPMailerAutoload.php';

				//Create a new PHPMailer instance
				$mail = new PHPMailer;
				//Tell PHPMailer to use SMTP
				$mail->isSMTP();

				$mail->SMTPDebug = 0;
				//Ask for HTML-friendly debug output
				$mail->Debugoutput = 'html';
				//Set the hostname of the mail server
				$mail->Host = "mail.bki.co.id";
				//Set the SMTP port number - likely to be 25, 465 or 587
				$mail->Port = 25;
				//Whether to use SMTP authentication
				$mail->SMTPAuth = false;
				//Username to use for SMTP authentication
				$mail->Username = "triyan";
				//Password to use for SMTP authentication
				$mail->Password = "tes123triyan";
				//Set who the message is to be sent from
				$mail->setFrom('Z2ex@bki.co.id', 'No-reply-Z2ex');

				foreach ($emaillist as $emaillis){
				
				$mail->addAddress($emaillis['email'], $emaillis['nama']);
				
				}

				foreach ($piecesExternalEmail as $piecesExternalEmai) { //external email

					$mail->addAddress($piecesExternalEmai, $piecesExternalEmai);
				}

				//$mail->AddCC($formEmail);

				//Set the subject line
				$mail->Subject = $sumary ;
				$mail->AltBody = $text; // in your case once more the $text string
				$mail->Ical = $text; // ical format, in your case $text string
				$mail->Body= $message ;
				//send the message, check for errors
				//echo $text;
				if (!$mail->send()) {
					echo "Mailer Error: " . $mail->ErrorInfo;
				} else {
					echo "Message sent!";
				}				

}
	
	function getEmailbylistid($listUsers){
	
			$listusers=explode(",", $listUsers);
			
			foreach($listusers as $listuser){
			
			if ($listuser!=""){
			$statment= $statment. " `id_user` =" . $listuser . " or ";
			$usertrakhir=$listuser;
			}
			}
			//terjadi penambahan terkhir tapi tak apa daripada error
			$statment=$statment. " `id_user` =" . $usertrakhir ;
	
	
			$query = $this->db->prepare("SELECT * FROM `og_user` WHERE " . $statment );
			#bind Value 
			
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

	}
	
		public function Get_email_id($id) {
			
			$query = $this->db->prepare("SELECT email FROM `og_user` where id_user = ? limit 1");
				#bind Value 
				$query->bindValue(1, $id);
				
				 $query->bindColumn('email', $hak);

			try{
				$query->execute();
				
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $hak;
		
		}
		
		public function Get_nama_id($id) {
			
			$query = $this->db->prepare("SELECT nama from `og_user` where id_user = ? limit 1");
				#bind Value 
				$query->bindValue(1, $id);
				
				 $query->bindColumn('nama', $hak);

			try{
				$query->execute();
				
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $hak;
		
		}
		
		public function Get_nama_email($email) {
			
			$query = $this->db->prepare("SELECT nama from `og_user` where email = ? limit 1");
				#bind Value 
				$query->bindValue(1, $email);
				
				 $query->bindColumn('nama', $hak);

			try{
				$query->execute();
				
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $hak;
		
		}
		
		public function Get_objectName_id($id) {
			
			$query = $this->db->prepare("SELECT * FROM `rm_objects` where id = ? limit 1");
				#bind Value 
				$query->bindValue(1, $id);
				
				 $query->bindColumn('name', $hak);

			try{
				$query->execute();
				
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $hak;
		
		}
		
		public function updateProgressProject($idproject,$value){
		
			$query 	= $this->db->prepare("UPDATE rm_workspaces SET progress = ? where object_id= ?  ");
		 
			$query->bindValue(1, $value);
			$query->bindValue(2, $idproject);

			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}
		
		public function LoadMessage($iduser){
		date_default_timezone_set('Asia/Jakarta');
		
		$query = $this->db->prepare("select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status, u.path from message2_recips r
inner join message2 m on m.mid=r.mid and m.seq=r.seq
inner join rm_biodata u on u.id_user=m.created_by
where r.uid=:iduser and r.status in ('A', 'N')
and r.seq=(select max(rr.seq) from message2_recips rr where rr.mid=m.mid and rr.status in ('A', 'N'))
and if (m.seq=1 and m.created_by=:iduser, 1=0, 1=1)
order by created_on desc limit 25 ");
			#bind Value 
			
			$query->bindParam(':iduser', $iduser, PDO::PARAM_INT);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		
		public function ShowmessgaeMid($mid,$userid){
		date_default_timezone_set('Asia/Jakarta');
				$query = $this->db->prepare("select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status, u.path from message2_recips r
				inner join message2 m on m.mid=r.mid and m.seq=r.seq
				inner join rm_biodata u on u.id_user=m.created_by
				where r.uid=:iduser and m.mid=:mid and r.status in ('A', 'N') order by m.created_on DESC ");
			#bind Value 
			
			$query->bindParam(':iduser', $userid, PDO::PARAM_INT);
			$query->bindParam(':mid', $mid, PDO::PARAM_INT);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		}
		
		public function updateMessageview($mid, $userid){
		
			$query 	= $this->db->prepare("update message2_recips set status='A' where status='N' and mid=? and uid=?");
		 
			$query->bindValue(1, $mid);
			$query->bindValue(2, $userid);


		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}
		
		public function PostMessage($mid,$body,$uidsss,$currentUser ){
		
		
		$namaPengirim=$this->Get_nama_id($currentUser);
		$subjectMessage= "Pak/ibu " . $namaPengirim . "..";
		$bodymessage ="
		<p>&nbsp;</p>
		<p>$body </p>
		<p>&nbsp;</p>
		<p></p>Regards
		<br>$namaPengirim
		<br>
		Sent Form<a href='http://z2ex.bki.co.id/n_ogs/'> http://z2ex.bki.co.id/n_ogs/ </a>
		</body>";
		
		
			date_default_timezone_set('Asia/Jakarta');
		
			$PDO=$this->db;
			if (!empty($mid)) { 
				/** get the recips first **/
				$sql = "SELECT distinct(uid) as uid FROM message2_recips m where mid=?";
				$stmt = $PDO->prepare($sql);
				$args = array($mid);
				if (!$stmt->execute($args)) {
					die('error');
				}
				$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

				/** get seq # **/
				$sql = "select max(seq)+1 as seq from message2 where mid=?";
				$args = array($mid);
				$stmt = $PDO->prepare($sql);
				$stmt->execute($args);
				$row = $stmt->fetch(PDO::FETCH_ASSOC);
				$seq = $row['seq'];
			}
			else {
				$seq = 1;
				$uids = explode(',', $uidsss);
				$uids[] = $currentUser;
				$uids = array_unique($uids);
				$rows = array();

				foreach ($uids as $uid) {
					$rows[] = array('uid'=>$uid);
					//kirim notification

					if ($uid != $currentUser ){

						//$user_email=$Users->Get_email_id($uid);
						$namaId=$namaId . ", " . $this->Get_nama_id($uid);
						$listId=$listId . "," . $uid ;

					}
					
				}
				
				$isi="<body><p>Dear Pak/Ibu $namaId</p>" . $bodymessage;
				$namaId=substr($namaId,1); // hilangkan , dalam huruf pertama
				$listId=substr($listId,1); // hilangkan , dalam huruf pertama
				$formEmail=$this->Get_email_id($currentUser);
				$subjectMessage= "Pak/ibu " . $namaId . "..";
				$this->sendEmail($formEmail,$listId,$isi,$subjectMessage);

			}

			if (count($rows)) {
				$sql = "insert into message2 (mid, seq, created_on_ip, created_by, body) values (?, ?, ?, ?, ?)";
				$args = array($mid, $seq, '1.2.2.1', $currentUser, $body);
				$stmt = $PDO->prepare($sql);
				$stmt->execute($args);

				if (empty($mid)) {
					$mid = $PDO->lastInsertId();
					$idetifier=true; //mark if send from pop up
				}

				$insertSql = "insert into message2_recips values ";
				$holders = array();
				$params = array();
				foreach ($rows as $row) {
					$holders[] = "(?, ?, ?, ?)";
					$params[] = $mid;
					$params[] = $seq;
					$params[] = $row['uid'];
					$params[] = $row['uid'] == $currentUser ? 'A' : 'N';
				}
				$insertSql .= implode(',', $holders);
				$stmt = $PDO->prepare($insertSql);
				$stmt->execute($params);

			}
			else {
				die('no recips found');
			}

		
		}
		
		public function DeleteMessage($mid,$uid){
		
			$query 	= $this->db->prepare("update message2_recips set status='D' where mid=? and status != 'D' and uid=?");
		 
			$query->bindValue(1, $mid);
			$query->bindValue(2, $uid);

			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}
		
		public function CreateCompression($listfile,$zipname){
		
		if(file_exists("file.zip")==1){
		 unlink("file.zip");  
		 }
		 
		$listfil=explode(",", $listfile); 
		
		foreach ($listfil as $listfi){
			//getlinklastFile
			$namalink=$this->getNumberfilelastrevisionWithName($listfi);
			$pieces = explode("#", $namalink);
			$link=$pieces[0];
			$nama=$pieces[1];
			//rename name
			if (copy($link, $nama)) {
			//copy to 
			}
			
			$lisname=$lisname . "," . $nama ;
		}
		
		$lisname=substr($lisname, 1); // hilangkan , dalam huruf pertama
		
		$files=explode(",", $lisname);
	
		$zip = new ZipArchive;
		$zip->open($zipname, ZipArchive::CREATE);
		foreach ($files as $file) {
		  $zip->addFile($file);
		}
		$zip->close();
		

		//hapus filenya
		foreach ($files as $file) {
		 if(file_exists($file)==1){
		 unlink($file);  
		 }
		}
		

		
				
		}
		
		public function WriteLogAplicationLogs($taken_by_id,$rel_object_id,$object_name,$created_by_id,$action,$is_private,$is_silent,$log_data){
		
		//'upload','open','close','delete','edit','add','trash','untrash','subscribe','unsubscribe','tag','comment','link','unlink','login','logout','untag','archive','unarchive','move','copy','read','download','checkin','checkout'
		
		$created_on = date("Y-m-d H:i:s");
		
		$query 	= $this->db->prepare("INSERT INTO `rm_application_logs` (taken_by_id, rel_object_id, object_name, created_on, created_by_id, action, is_private, is_silent, log_data  ) VALUES (?,?,?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $taken_by_id);
		$query->bindValue(2, $rel_object_id);
		$query->bindValue(3, $object_name);
		$query->bindValue(4, $created_on);
		$query->bindValue(5, $created_by_id);
		$query->bindValue(6, $action);
		$query->bindValue(7, $is_private);
		$query->bindValue(8, $is_silent);
		$query->bindValue(9, $log_data);
		

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		
		}
		
		public function GetLogAplicationLogs($objectid){
		
		$query = $this->db->prepare("SELECT rm_application_logs.created_by_id,rm_application_logs.created_on, rm_application_logs.action,rm_application_logs.log_data, rm_application_logs.object_name, og_user.nama
				FROM rm_application_logs
				LEFT JOIN og_user ON rm_application_logs.created_by_id = og_user.id_user
				WHERE rm_application_logs.rel_object_id =? order by rm_application_logs.created_on desc ");
			#bind Value 
			$query->bindValue(1, $objectid);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		}
		
		public function WriteDoc($filename,$stringWrite){
		
		$file = fopen( $filename,"w");
		fwrite($file,$stringWrite);
		fclose($file);
		}
		
		public function ReadDoc($path){
		
		$myfile = fopen($path, "r") or die("Unable to open file!");
		$StringFile = fread($myfile,filesize($path));
		fclose($myfile);
		
		
		
		return $StringFile;
		}
		
		public function getprojectNameid($id){
			
		
		$query = $this->db->prepare("SELECT * FROM `rm_workspaces`  where object_id=? limit 1");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id);
				 $query->bindColumn('project', $hak);
				 $query->bindColumn('id_kontrak', $hak2);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak  . " [$hak2]" ;


		}
		
				
		public function TrashWorkspace($idkontrak, $iduser){
		
		$query 	= $this->db->prepare("UPDATE rm_workspaces SET trash_date  = ? , trash_byid  = ? ,status = 2  where object_id= ?  ");
		$trashed_on = date("Y-m-d H:i:s");		
		
		$query->bindValue(1, $trashed_on);
		$query->bindValue(2, $iduser);
		$query->bindValue(3, $idkontrak);


		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}


		public function SendNotifEmailforEnginner($formEmail,$toemailbyiduser,$bodymessage,$subject){


			$this->sendEmail($formEmail,$toemailbyiduser,$bodymessage,$subject);
			
			//cek notif

		}


		public function getLogAPP($idkontrak){
		
		$query 	= $this->db->prepare("SELECT * FROM `rm_application_logs`  where rel_object_id=? and action='' and `created_by_id` !=1  ");
		
		$query->bindValue(1, $idkontrak);
			

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}


		public function InsertRegularReport($subject, $tipe, $reportAt, $file,$dataAttachment,$createby,$updateby,$id_kon){

			 $updateat=date("Y-m-d H:i:s");

		
		$query 	= $this->db->prepare("INSERT INTO `og_report_regular` (subject, tipe,  	reportAt,  	file, dataAttachment, createby,updateby,updateat,id_kon ) VALUES (?,?,?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $subject);
		$query->bindValue(2, $tipe);
		$query->bindValue(3, $reportAt);
		$query->bindValue(4, $file);
		$query->bindValue(5, $dataAttachment);
		$query->bindValue(6, $createby);
		$query->bindValue(7, $updateby);
		$query->bindValue(8, $updateat);
		$query->bindValue(9, $id_kon);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}
		
		public function updateRegularReport($subject,$file, $updated_by_id,$id){
		 $updateat=date("Y-m-d H:i:s");
		$query 	= $this->db->prepare("UPDATE og_report_regular SET subject = ? , file = ? , updateby = ?, updateat = ? where id= ?  ");
		 
			$query->bindValue(1, $subject);
			$query->bindValue(2, $file);
			$query->bindValue(3, $updated_by_id);
			$query->bindValue(4, $updateat);
			$query->bindValue(5, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}

		public function GetRegularReport($idkontrak,$tipe){
		
		$query 	= $this->db->prepare("SELECT * FROM `og_report_regular`  where id_kon=? and tipe=? order by createat desc ");
		
		$query->bindValue(1, $idkontrak);
		$query->bindValue(2, $tipe);	

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}


		public function getExistRegularreport($id_kon,$tipe,$reportAt){
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from og_report_regular where id_kon= ? and tipe =? and  reportAt =? ");
			#bind Value 
			$query->bindValue(1, $id_kon);
			$query->bindValue(2, $tipe);
			$query->bindValue(3, $reportAt);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 $jml = $query->rowCount();
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $jml ;	

		}

		public function DellRegularreport($id,$id_kon){
		
		$query 	= $this->db->prepare("DELETE FROM `ogs`.`og_report_regular` WHERE id = ? and id_kon=? limit 1");
		$query->bindValue(1, $id);
		$query->bindValue(2, $id_kon);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

		}

		//rules aplicable
		public function InsertRulesApplicable($idpublicRules, $idRules, $rules_name, $id_kon,$createby,$updateby,$updateat){
		
		$query 	= $this->db->prepare("INSERT INTO `og_listrulessaplicable` (idpublicRules, idRules, rules_name, id_kon, createby, updateby,updateat ) VALUES (?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $idpublicRules);
		$query->bindValue(2, $idRules);
		$query->bindValue(3, $rules_name);
		$query->bindValue(4, $id_kon);
		$query->bindValue(5, $createby);
		$query->bindValue(6, $updateby);
		$query->bindValue(7, $updateat);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}

		public function DellRulesApplicable($id,$id_kon){
		
		$query 	= $this->db->prepare("DELETE FROM `ogs`.`og_listrulessaplicable` WHERE id = ? and id_kon=? limit 1");
		$query->bindValue(1, $id);
		$query->bindValue(2, $id_kon);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

		}

		public function GetRulesApplicable($id_kon){
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from og_listrulessaplicable where id_kon= ? ");
			#bind Value 
			$query->bindValue(1, $id_kon);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 //$jml = $query->rowCount();
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			//return $jml ;	
			return $query->fetchAll();

		}

		public function InsertImportantdate($item, $id_kon, $tanggal, $createby){
				$query 	= $this->db->prepare("INSERT INTO `og_importan_date` (item, id_kon, tanggal, createby, updateat, updateby ) VALUES (?,?,?,?,?,?) ");
	 	$updateon = date("Y-m-d H:i:s");
		$query->bindValue(1, $item);
		$query->bindValue(2, $id_kon);
		$query->bindValue(3, $tanggal);
		$query->bindValue(4, $createby);
		$query->bindValue(5, $updateon);
		$query->bindValue(6, $createby); // create update by selalu sama dengan createby

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}


		public function updateImportanDate($tanggal, $updated_by_id,$id){
		
		$query 	= $this->db->prepare("UPDATE og_importan_date SET tanggal = ? , updateby = ? , updateat =? where id= ?  ");
		 $updateon = date("Y-m-d H:i:s");	

			$query->bindValue(1, $tanggal);
			$query->bindValue(2, $updated_by_id);
			$query->bindValue(3, $updateon);
			$query->bindValue(4, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}

		//getby id_kon & item	
		
		public function GetImportanDatebyIdkon_item($id_kon,$item){
		
		$query = $this->db->prepare("SELECT * from og_importan_date where item = ? and id_kon = ? ");
			#bind Value 
			
			$query->bindValue(1, $item);
			$query->bindValue(2, $id_kon);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}

		public function GetImportanDatebyIdkon($id_kon){
		
		$query = $this->db->prepare("SELECT * from og_importan_date where  id_kon = ? order by tanggal asc ");
			#bind Value 
			

			$query->bindValue(1, $id_kon);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}

		public function GetImportanDatebyIdkon_itemValue($id_kon,$item){
		
		$query = $this->db->prepare("SELECT * from og_importan_date where item = ? and id_kon = ? ");
			#bind Value 
			
			$query->bindValue(1, $item);
			$query->bindValue(2, $id_kon);
			$query->bindColumn('tanggal', $hak);
			
			try{
				$query->execute();
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $hak;
		
		}

		public function isImportanDateExist($id_kon,$item){
		
		$query = $this->db->prepare("SELECT * from og_importan_date where item = ? and id_kon = ? ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $item);
				$query->bindValue(2, $id_kon);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			$jml = $query->rowCount();

			if ($jml > 0 ) {
				return true ;
			}else{
				return false;
			}

		}

		public function updateImportanDatefunc($tanggal,$item, $id_kon,$user_id){

			if( $this->isImportanDateExist($id_kon,$item) == false){ //insert data

				$this->InsertImportantdate($item, $id_kon, $tanggal, $user_id);
			}else{ // update data

				$listdatas= $this->GetImportanDatebyIdkon_item($id_kon,$item);

				foreach ($listdatas as $listdata) {
					$id= $listdata['id'] ;
				}

				$this->updateImportanDate($tanggal, $user_id,$id);
			}

		}



		public function getProjectTaskbyIdprojectBycategory($id_project,$category){
		
		$query = $this->db->prepare("SELECT rm_project_tasks.object_id, rm_project_tasks.percent_completed,rm_objects.name, rm_project_tasks.due_date,rm_project_tasks.start_date , og_user.nama  FROM `rm_project_tasks` 
			LEFT JOIN rm_object_corelation on rm_project_tasks.`object_id`= rm_object_corelation.`objectid`  
			LEFT JOIN rm_objects on rm_project_tasks.`object_id`= rm_objects.id  
			LEFT JOIN og_user ON rm_project_tasks.assigned_to_contact_id  = og_user.id_user

			where rm_object_corelation.`relatedobjectid`=? and  rm_objects.name like  ?
			order by rm_project_tasks.due_date asc ");
			#bind Value 
			#bind Value

			$query->bindValue(1, $id_project);
			$query->bindValue(2, $category);


			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		return $query->fetchAll();

		}


		public function InsertmatkomMaterList($material_name, $id_kon, $tipe , $descript , $status , $createby , $trash,$updateby, $updateat,$issued ,$rules , $certificated_level){
		$query 	= $this->db->prepare("INSERT INTO `og_master_matkom` (material_name, id_kon, tipe , descript , status , createby , trash,updateby, updateat,issued ,rules , certificated_level ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?) ");
	 	$updateon = date("Y-m-d H:i:s");

		$query->bindValue(1, $material_name);
		$query->bindValue(2, $id_kon);
		$query->bindValue(3, $tipe);
		$query->bindValue(4, $descript);
		$query->bindValue(5, $status);
		$query->bindValue(6, $createby); 
		$query->bindValue(7, $trash); 
		$query->bindValue(8, $updateby);
		$query->bindValue(9, $updateat);
		$query->bindValue(10, $issued);
		$query->bindValue(11, $rules); 
		$query->bindValue(12, $certificated_level); 


		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	



		
		}


		public function TrashmatkomMaterList($trash, $updated_by_id,$id){
		
		$query 	= $this->db->prepare("UPDATE og_master_matkom SET trash = ? , updateby = ? , updateat =?  where id= ?   ");
		 $updateon = date("Y-m-d H:i:s");	

			$query->bindValue(1, $trash);
			$query->bindValue(2, $updated_by_id);
			$query->bindValue(3, $updateon);
			$query->bindValue(4, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}



		public function getmatkomMaterLis($id_project){
			
		
		$query = $this->db->prepare("SELECT * FROM `og_master_matkom`  where id_kon=? and trash= 0 ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_project);


			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		return $query->fetchAll();


		}

		public function getmatkomMaterLisJointuploadCert($id_project){
			
		
		$query = $this->db->prepare("SELECT m.id as id_master, m.material_name, m.id_kon, m.tipe, m.`descript`,m.status,m.trash,m.issued,m.rules, m.`certificated_level`,s.id as id_upload,s.id_certificated,s.description,s.file,s.updateby,s.updateat FROM og_master_matkom m LEFT JOIN og_sub_matkom s ON m.id =s.id_matkom WHERE m.id_kon =? and m.trash = 0");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_project);


			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		return $query->fetchAll();


		}

		public function getmatkomMaterLisbyid($id_project, $id ){
			
		
		$query = $this->db->prepare("SELECT * FROM `og_master_matkom`  where id_kon=? and trash= 0 and id= ? limit 1");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_project);
				$query->bindValue(2, $id);


			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		return $query->fetchAll();


		}
		


		public function UpdateStatusmatkomMaterList($status, $updated_by_id,$id){
		
		$query 	= $this->db->prepare("UPDATE og_master_matkom SET status = ? , updateby = ? , updateat =?  where id= ?   ");
		 $updateon = date("Y-m-d H:i:s");	

			$query->bindValue(1, $status);
			$query->bindValue(2, $updated_by_id);
			$query->bindValue(3, $updateon);
			$query->bindValue(4, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}


		public function isUploadCertificatedComponentExist($id_matkom){
		
		$query = $this->db->prepare("SELECT * from og_sub_matkom where id_matkom = ?  ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_matkom);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			$jml = $query->rowCount();

			if ($jml > 0 ) {
				return true ;
			}else{
				return false;
			}

		}

		public function InsertisUploadCertificatedComponent($id_matkom , $id_certificated, $description, $file,$createby,$updateat, $updateby,$id_kon ){
		$query 	= $this->db->prepare("INSERT INTO `og_sub_matkom` (id_matkom, id_certificated, description, file, createby, updateat, updateby,id_kon ) VALUES (?,?,?,?,?,?,?,?) ");
	 	$updateon = date("Y-m-d H:i:s");

		$query->bindValue(1, $id_matkom);
		$query->bindValue(2, $id_certificated);
		$query->bindValue(3, $description);
		$query->bindValue(4, $file);
		$query->bindValue(5, $createby);
		$query->bindValue(6, $updateat); 
		$query->bindValue(7, $updateby); 
		$query->bindValue(8, $id_kon); 



		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}

		public function DeletedUploadCertificatedComponent($id){
		
			$query 	= $this->db->prepare("DELETE FROM `ogs`.`og_sub_matkom` WHERE id = ? limit 1");
			$query->bindValue(1, $id);

			
			
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}




		public function InsertDbCorelationTask( $id_subdrawing, $task_objectid, $start, $due, $taskby ){
		$query 	= $this->db->prepare("INSERT INTO `og_corelationtaskdrawing` (id_subdrawing, task_objectid, start, due, taskby,taskat  ) VALUES (?,?,?,?,?,?) ");
	 	$updateon = date("Y-m-d H:i:s");

		$query->bindValue(1, $id_subdrawing);
		$query->bindValue(2, $task_objectid);
		$query->bindValue(3, $start);
		$query->bindValue(4, $due);
		$query->bindValue(5, $taskby);
		$query->bindValue(6, $updateon); 



		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}


		public function GetdbcoralationTask($id_subdrawing){
		
		$query = $this->db->prepare("SELECT * from og_corelationtaskdrawing where id_subdrawing = ?  limit 1");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_subdrawing);

			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		return $query->fetchAll();

		}

		public function isDbCorelationTasktExist($id_subdrawing){
		
		$query = $this->db->prepare("SELECT * from og_corelationtaskdrawing where id_subdrawing = ?  ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_subdrawing);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			$jml = $query->rowCount();

			if ($jml > 0 ) {
				return true ;
			}else{
				return false;
			}

		}

		public function UpdateDbCorelationTask($start, $due,$taskby,$id){
		
		$query 	= $this->db->prepare("UPDATE og_corelationtaskdrawing SET start = ? , due = ? , taskby =?, taskat =?  where id= ?   ");
		 $updateon = date("Y-m-d H:i:s");	

			$query->bindValue(1, $start);
			$query->bindValue(2, $due);
			$query->bindValue(3, $taskby);
			$query->bindValue(4, $updateon);
			$query->bindValue(5, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}




		public function UpdateTaskProject($text, $due_date,$start_date,$assigned_to_contact_id, $assigned_by_id , $object_id,$subscribers,$correlation){
		
		$query 	= $this->db->prepare("UPDATE rm_project_tasks SET `text` = ? , due_date = ? , start_date =?, assigned_to_contact_id =?,assigned_on =? , assigned_by_id=?     where object_id= ?   ");

		 $updateon = date("Y-m-d H:i:s");	

			$query->bindValue(1, $text);
			$query->bindValue(2, $due_date);
			$query->bindValue(3, $start_date);
			$query->bindValue(4, $assigned_to_contact_id);
			$query->bindValue(5, $updateon);
			$query->bindValue(6, $assigned_by_id);
			$query->bindValue(7, $object_id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}

			$this->dellSubscriberbyobjt($object_id);	

			$subscribers=substr($subscribers, 1); // hilangkan , dalam huruf pertama
			$pieces = explode(",", $subscribers);
			$pieces = array_unique($pieces);	
			
			$listtemamembers=$this->getTeamMember($correlation);
			$TeamMembers = explode(",", $listtemamembers);	
			$TeamMembers = array_unique($TeamMembers);		
			//
			//set blum di baca
			// foreach($TeamMembers as $TeamMember) {
				
			// 	$this->insertRead($object_id, $TeamMember,0);
				
			// }


			
				//insert tbl subscriber
			foreach($pieces as $piece) {
				//echo $piece ;
				$this->addSubcriber($object_id,$piece);

			}

		}




		public function getDrawingTask($id_project,$tipe="0" ){



			if($tipe== "0"){
				$strTipe=" ";
			}else{
				$strTipe=" and m.tipe = " . $tipe ;
			}
			//$strTipe=" and m.tipe = " . "1" ;
		
		$query = $this->db->prepare("SELECT s.tanggal, s.id, s.id_project_gamb,s.id_kontrak, s.revisi, m.no_gambar,m.judul, m.tipe, m.akses, m.forinfo, m.engfield, date_format(t.due_date,'%Y-%m-%d') as due_date, date_format(t.start_date,'%Y-%m-%d') as start_date, t.assigned_to_contact_id, t.percent_completed,t.assigned_by_id,c.task_objectid, st.id as id_stamp, date_format(st.tanggal,'%Y-%m-%d') as dt_enguploadstamp, date_format(st.reviewdate,'%Y-%m-%d') as reviewdate FROM `og_sub_proj_gambar` s left join og_proj_gambar m ON s.id_project_gamb=m.id left join og_corelationtaskdrawing c on s.id=c.id_subdrawing LEFT join rm_project_tasks t on c.task_objectid=t.object_id left join rm_stamp st on st.id_gambar=s.id_project_gamb and st.rev= s.revisi where s.id_kontrak=? ". $strTipe . " order by s.tanggal DESC ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_project);


			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		return $query->fetchAll();


		}


		public function CountDrawingTaskManagement($id_project){


					$query = $this->db->prepare("SELECT s.tanggal, s.id, s.id_project_gamb,s.id_kontrak, s.revisi, m.no_gambar,m.judul, m.tipe, m.akses, m.forinfo, m.engfield, t.due_date, t.start_date, t.assigned_to_contact_id, t.percent_completed,t.assigned_by_id,c.task_objectid FROM `og_sub_proj_gambar` s left join og_proj_gambar m ON s.id_project_gamb=m.id left join og_corelationtaskdrawing c on s.id=c.id_subdrawing LEFT join rm_project_tasks t on c.task_objectid=t.object_id where s.id_kontrak=? " . " order by s.tanggal DESC ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_project);

			try{ 
				$query->execute();
				}
			catch(PDOException $e){
				die($e->getMessage());
				}

				$jmlSubmited = $query->rowCount();

			$query = $this->db->prepare("SELECT s.tanggal, s.id, s.id_project_gamb,s.id_kontrak, s.revisi, m.no_gambar,m.judul, m.tipe, m.akses, m.forinfo, m.engfield, t.due_date, t.start_date, t.assigned_to_contact_id, t.percent_completed,t.assigned_by_id,c.task_objectid FROM `og_sub_proj_gambar` s left join og_proj_gambar m ON s.id_project_gamb=m.id left join og_corelationtaskdrawing c on s.id=c.id_subdrawing LEFT join rm_project_tasks t on c.task_objectid=t.object_id where s.id_kontrak=? and t.percent_completed >= 100 " . " order by s.tanggal DESC ");


				$query->bindValue(1, $id_project);

			try{ 
				$query->execute();
				}
			catch(PDOException $e){
				die($e->getMessage());
				}

				$jmlAcompolize = $query->rowCount();


			$query = $this->db->prepare("SELECT s.tanggal, s.id, s.id_project_gamb,s.id_kontrak, s.revisi, m.no_gambar,m.judul, m.tipe, m.akses, m.forinfo, m.engfield, t.due_date, t.start_date, t.assigned_to_contact_id, t.percent_completed,t.assigned_by_id,c.task_objectid FROM `og_sub_proj_gambar` s left join og_proj_gambar m ON s.id_project_gamb=m.id left join og_corelationtaskdrawing c on s.id=c.id_subdrawing LEFT join rm_project_tasks t on c.task_objectid=t.object_id where s.id_kontrak=? and t.due_date IS NOT NULL " . " order by s.tanggal DESC ");


				$query->bindValue(1, $id_project);

			try{ 
				$query->execute();
				}
			catch(PDOException $e){
				die($e->getMessage());
				}

				$jmlDisetTask = $query->rowCount();



			$query = $this->db->prepare("SELECT s.tanggal, s.id, s.id_project_gamb,s.id_kontrak, s.revisi, m.no_gambar,m.judul, m.tipe, m.akses, m.forinfo, m.engfield, t.due_date, t.start_date, t.assigned_to_contact_id, t.percent_completed,t.assigned_by_id,c.task_objectid FROM `og_sub_proj_gambar` s left join og_proj_gambar m ON s.id_project_gamb=m.id left join og_corelationtaskdrawing c on s.id=c.id_subdrawing LEFT join rm_project_tasks t on c.task_objectid=t.object_id where s.id_kontrak=? and t.due_date <= CURDATE() " . " order by s.tanggal DESC ");


				$query->bindValue(1, $id_project);

			try{ 
				$query->execute();
				}
			catch(PDOException $e){
				die($e->getMessage());
				}

				$jmllate = $query->rowCount();

				return $jmlSubmited . "#" . $jmlAcompolize . "#" . $jmlDisetTask . "#" .  $jmllate ;

		}



		private function CountQuerydata($colom, $table, $kondisi){

		
		$query = $this->db->prepare("SELECT COUNT($colom)as jml FROM $table WHERE $kondisi");


				 $query->bindColumn('jml', $hak);
			try{
				$query->execute();
				$query->fetch(PDO::FETCH_BOUND);


				
			}catch(PDOException $e){
				die($e->getMessage());
			}

			return intval($hak) ;

		}


		private function getCountEveryMonth($Colom_tanggal,$table, $kondisi){


		
		$query = $this->db->prepare("SELECT MONTHNAME($Colom_tanggal) as month, YEAR($Colom_tanggal) as year , COUNT(*) as jml FROM $table WHERE $kondisi  GROUP by YEAR($Colom_tanggal), MONTH($Colom_tanggal) ORDER BY $Colom_tanggal ASC");
			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

			$hasils=$query->fetchAll();
			$penampung= array();
			$z = 0;
			foreach ($hasils as $hasil) {

				$penampung[$z]=  array('month' => $hasil['month'],'year' => $hasil['year'],'jml' => $hasil['jml'] );


				$z++;
			}

			return $penampung ;


		}




		public function GetSDashboardDrawing($id_project){

			//property gambar 

			$a= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and forinfo =0 GROUP BY forinfo");
			$b= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and forinfo =1 GROUP BY forinfo");
			$c= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and forinfo =2 GROUP BY forinfo");
			$d= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and forinfo =3 GROUP BY forinfo");

			$hasil_propertygambar= array('drawing' =>$a ,'calculation'=>$b, 'report'=>$c, 'misc'=> $d );

				//tipe gambar 

			$a= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and tipe =1 GROUP BY tipe");
			$b= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and tipe =2 GROUP BY tipe");
			$c= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and tipe =3 GROUP BY tipe");
			$d= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and tipe =4 GROUP BY tipe");
			$e= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and tipe =5 GROUP BY tipe");
			$f= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and tipe =6 GROUP BY tipe");
			$g= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and tipe =7 GROUP BY tipe");
			$h= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and tipe =0 GROUP BY tipe");


			$hasil_tipegambar = array('structure' => $a,'electrical'=>$b, 'machinery'=>$c,'stability'=>$d,'statutori'=>$e,'matkom'=>$f, 'multi'=>$g,'uncategoried'=>$h );


			$a= $this->CountQuerydata("*", "rm_stamp", "id_kon =$id_project");
			$b= $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project and forinfo =4"); //salah harus e di join, tapi biasane ga ada revisi bila dia bukan docuement wajib
			$c= $this->CountQuerydata("*", "og_sub_proj_gambar", "id_kontrak =$id_project ");

			$d = $c - ($a + $b);

			$hasildrwaingreview= array('reviewed'=>$a, 'not yet'=>$d, 'no need review'=>$b);


			//doc revisi = totalfile_sub_projectgambar - totalgambarmasuk

			$a = $this->CountQuerydata("*", "og_proj_gambar", "id_kontrak =$id_project");
			$b= $c - $a ;

			$hasilgambarrevisi= array('original'=>$a,'revision'=>$b);

			$a=$this->getCountEveryMonth('tanggal','og_proj_gambar', "id_kontrak=$id_project");
			$b=$this->getCountEveryMonth('tanggal','rm_stamp', "id_kon=$id_project");

			$hasilBargambar=array('drawing' => $a,'stamp'=>$b );

				$hasil_compilasi=  array('propertygambar' =>$hasil_propertygambar ,'tipegambar' =>$hasil_tipegambar,'reviewed'=>$hasildrwaingreview,'revisi'=>$hasilgambarrevisi ,'bargambar'=> $hasilBargambar);
				return $hasil_compilasi ;
		}

		public function GetSDashboardComment($id_project){

			//tipe komment
			$a= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and tipe =1 GROUP BY tipe");
			$b= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and tipe =2 GROUP BY tipe");
			$c= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and tipe =3 GROUP BY tipe");
			$d= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and tipe =4 GROUP BY tipe");
			$e= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and tipe =5 GROUP BY tipe");
			$f= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and tipe =6 GROUP BY tipe");
			$g= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and tipe =7 GROUP BY tipe");
			$h= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and tipe =15 GROUP BY tipe");

			$hasil_tipecomment = array('structure' => $a,'electrical'=>$b, 'machinery'=>$c,'stability'=>$d,'statutori'=>$e,'matkom'=>$f, 'multi'=>$g,'survey'=>$h );
			
			//status comment

			$a= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and status =0 GROUP BY status");
			$b= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and status =1 GROUP BY status");
			$c= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and status =2 GROUP BY status");

			$hasil_statuscomment= array('closed'=>$b, 'open' => $a, 'info'=>$c);

			//comment belum respon

				$query = $this->db->prepare("SELECT c.importan,c.gamb_infoRef, c.id, c.nomer_comment, c.comment, c.gambar, c.create_by,c.point, c.tanggal,c.id_kontrak, c.tipe,c.status,c.closedby, c.closedAT,c.reviewby, c.reviewat,rep.oleh , rep.replay FROM `og_comment` c left join (SELECT id_comment, oleh, replay from og_subreplay_comment WHERE id IN (SELECT MAX(id) FROM og_subreplay_comment where `id_kont`=? GROUP BY `id_comment`))as rep on c.id = rep.id_comment where c.id_kontrak=? and c.status=0 order by c.id desc"  );
				
				$query->bindValue(1, $id_project);
				$query->bindValue(2, $id_project);
				try{
					$query->execute();
				}catch(PDOException $e){
					die($e->getMessage());
					
				}
				 
				$get_comments=  $query->fetchAll();

				$jmlClientNotrespon= 0 ;
				$jmlEngNotrespon= 0 ;
				foreach($get_comments as $get_comment)
					{

						if (is_null($get_comment['oleh']))
							{
							$jmlClientNotrespon++;
						}
						  elseif($get_comment['oleh']=="owner")
							{
							
							$jmlEngNotrespon++;
						}

					}
				$hasilComentnotrespon= array('client'=>$jmlClientNotrespon,'eng'=>$jmlEngNotrespon);	


			//bar chart	
			$a=$this->getCountEveryMonth('tanggal','og_comment', "id_kontrak=$id_project");
			$b=$this->getCountEveryMonth('closedAT','og_comment', "id_kontrak=$id_project and status = 1");

			$hasilbarcommentopenclosed= array('create'=>$a,'closed'=>$b);


			$hasil_compilasi=  array('tipecomment' =>$hasil_tipecomment,'statuscoment'=>$hasil_statuscomment,'norespon'=>$hasilComentnotrespon,'barcomentcreate'=>$hasilbarcommentopenclosed);
			return $hasil_compilasi ;
		}

		public function GetSDashboardSurvey($id_project){

			$a= $this->CountQuerydata("*", "og_report", "id_kon =$id_project and tipe =1 GROUP BY tipe");
			$b= $this->CountQuerydata("*", "og_report", "id_kon =$id_project and tipe =2 GROUP BY tipe");
			$hasilSurvey=array('regular' => $a ,'patrol' =>$b );

			$a=$this->getCountEveryMonth('tanggal','og_report', "id_kon=$id_project and tipe =1 "); //regular 
			$b=$this->getCountEveryMonth('tanggal','og_report', "id_kon=$id_project and tipe =2 "); //patrol
			$c=$this->getCountEveryMonth('tanggal','og_comment', "id_kontrak=$id_project and tipe =15 "); //patrol
			$hasilbarsurvey =array('regular' => $a ,'patrol'=>$b,'comment'=>$c );


			$hasil_compilasi=  array('tipesurvey' =>$hasilSurvey,'barsurvey'=>$hasilbarsurvey);
			return $hasil_compilasi ;

		}	

		public function GetDashboardperson($id_project,$id_user){

			//icon number
			$a= $this->CountQuerydata("*", "rm_stamp", "id_kon =$id_project and userid= $id_user"); //reviewed
			$b= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and status =0  and create_by = $id_user GROUP BY status"); //open comment
			$c= $this->CountQuerydata("*", "og_comment", "id_kontrak =$id_project and create_by = $id_user"); //create comment
			$d= $this->CountQuerydata("*", "rm_project_tasks", "assigned_to_contact_id =$id_user and percent_completed !=100 and due_date >= CURDATE() GROUP BY assigned_to_contact_id");//late


			$listTaskall= $this->getDrawingTask($id_project);
			$jmlAssigmnt = 0;
			foreach ($listTaskall as $listTask) {

				if ($listTask['assigned_to_contact_id'] == $id_user){
					$jmlAssigmnt++;
				}
				
			}

			$hasilperformance= array('reviewed'=>$a, 'opencoment'=>$b,'createcomment'=>$c, 'latetask'=>$d,'drawingtask'=>$jmlAssigmnt);

			//barchart

			$a=$this->getCountEveryMonth('tanggal','rm_stamp', "id_kon=$id_project and userid= $id_user");//reviewed
			$b=$this->getCountEveryMonth('tanggal','og_comment', "id_kontrak=$id_project and create_by= $id_user");//jumlah create comment
			$c=$this->getCountEveryMonth('tanggal','og_comment', "id_kontrak=$id_project and create_by= $id_user and status=0 ");//jumlah open  comment


				$query = $this->db->prepare("SELECT MONTHNAME(t.assigned_on) as month, YEAR(t.assigned_on) as year , COUNT(*) as jml FROM `og_sub_proj_gambar` s left join og_proj_gambar m ON s.id_project_gamb=m.id left join og_corelationtaskdrawing c on s.id=c.id_subdrawing LEFT join rm_project_tasks t on c.task_objectid=t.object_id where s.id_kontrak=? and t.assigned_to_contact_id=$id_user GROUP by YEAR(t.assigned_on), MONTH(t.assigned_on) DESC"  );
				
				$query->bindValue(1, $id_project);

				try{
					$query->execute();
				}catch(PDOException $e){
					die($e->getMessage());
					
				}
				 
				$Asigmentuser=  $query->fetchAll();

				$penampung= array();
				$z = 0;
				foreach ($Asigmentuser as $hasil) {

					$penampung[$z]=  array('month' => $hasil['month'],'year' => $hasil['year'],'jml' => $hasil['jml'] );


					$z++;
				}

			$hasilbarchartperson=array('review'=>$a,'comment'=>$b,'opencomment'=>$c,'assign'=>$penampung);
				

			$hasil_compilasi=  array('performance' =>$hasilperformance,'barcomment'=>$hasilbarchartperson);
			return $hasil_compilasi ;

		}
		
				//post data
		public function httpPost($url,$params){
			$postData = '';
			//create name value pairs seperated by &
			foreach($params as $k => $v) 
			{ 
		      $postData .= $k . '='.$v.'&'; 
			}
			$postData = rtrim($postData, '&');
		 
		    $ch = curl_init();  
		 
		    curl_setopt($ch,CURLOPT_URL,$url);
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		    curl_setopt($ch,CURLOPT_HEADER, false); 
		    curl_setopt($ch, CURLOPT_POST, count($params));
		        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
		 
		    $output=curl_exec($ch);
		 
		    curl_close($ch);
		    return $output;
		}

		public function httpGet($url, $params)
		{
			$ch = curl_init();

		    $user_id = $params['user'];
		    $username = $params['name'];
		    $login_string = $params['logstring'];

		    unset($params['user']);
		    unset($params['name']);
		    unset($params['logstring']);

		    $queryString = http_build_query($params);
			$path = $url.'?'.$queryString;

			curl_setopt($ch,CURLOPT_URL,$path);
			curl_setopt($ch, CURLOPT_HTTPHEADER, array("Cookie: user_id=$user_id, username=$username, login_string=$login_string"));
			curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, false);
		    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);

		    $output=curl_exec($ch);
		  	
		    curl_close($ch);
		    return $output;
		}

		public function GetcountMatkom($id_project){


			$a= $this->CountQuerydata("*", "og_master_matkom", "id_kon =$id_project and trash !=1"); //reviewed
			$b= $this->CountQuerydata("*", "og_sub_matkom", "id_kon =$id_project "); //open comment

			$hasil_compilasi=  array('masterlist' =>$a,'certificated'=>$b);
			return $hasil_compilasi ;

		}


	 public function updateNotfAll($is_read, $userId){
	
	
	$query 	= $this->db->prepare("UPDATE rm_notification SET is_read=? where  userId = ? ");
	 
		$query->bindValue(1, $is_read);
		$query->bindValue(2, $userId);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	
	
	
	}
	public function Aprrovekadivprb($user_id,$id){

		$tanggal = date("Y-m-d H:i:s");	
		
		$query 	= $this->db->prepare("UPDATE rm_workspaces SET kadivprb = ? , kadivprbat = ? where object_id= ?  ");
		 
			$query->bindValue(1, $user_id);
			$query->bindValue(2, $tanggal);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

	}

		public function Aprrovekadivsurvey($user_id,$id){

		$tanggal = date("Y-m-d H:i:s");	
		
		$query 	= $this->db->prepare("UPDATE rm_workspaces SET kadivsurvey = ? , kadivsurveyat = ? where object_id= ?  ");
		 
			$query->bindValue(1, $user_id);
			$query->bindValue(2, $tanggal);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

	}

	public function Aprrovekadivkemenko($user_id,$id){

		$tanggal = date("Y-m-d H:i:s");	

		$this->Aprrovekadivprb($user_id,$id); //overwrite prb
		$this->Aprrovekadivsurvey($user_id,$id); //overwrite survey
		
		$query 	= $this->db->prepare("UPDATE rm_workspaces SET kadivkemnko = ? , kadivkemnkoat = ? where object_id= ?  ");
		 
			$query->bindValue(1, $user_id);
			$query->bindValue(2, $tanggal);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

	}

	public function CancelAprrovekadivkemenko($id){

		$tanggal = date("Y-m-d H:i:s");	

		$this->Aprrovekadivprb(0,$id); //overwrite prb
		$this->Aprrovekadivsurvey(0,$id); //overwrite survey
		
	}


	public function GetTaskonProjectAll($idProject){
		

		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT  distinct rm_objects.id, rm_objects.object_type_id, rm_objects.created_by_id, rm_objects.updated_on ,
			rm_objects.updated_by_id , og_user.nama , rm_objects.name, rm_objects.created_on , rm_project_tasks.text, rm_read_objects.is_read , rm_object_corelation.relatedobjectid  
			, rm_workspaces.project,rm_project_file_revisions.file_type_id ,rm_project_file_revisions.filesize,rm_file_types.icon, rm_project_tasks.assigned_to_contact_id,rm_project_tasks.start_date, rm_project_tasks.due_date,rm_project_tasks.percent_completed FROM 
				rm_objects LEFT JOIN rm_project_messages ON rm_objects.id =rm_project_messages.object_id
				LEFT JOIN rm_read_objects ON rm_objects.id=rm_read_objects.rel_object_id
				LEFT JOIN rm_object_corelation ON rm_objects.id=rm_object_corelation.objectid
				LEFT JOIN og_user ON rm_objects.updated_by_id = og_user.id_user 
				LEFT JOIN rm_workspaces on rm_workspaces.object_id =rm_object_corelation.relatedobjectid
				LEFT JOIN rm_project_file_revisions ON rm_project_file_revisions.file_id =rm_objects.id
				LEFT JOIN rm_project_tasks ON rm_project_tasks.object_id =rm_objects.id
				LEFT JOIN rm_file_types on rm_project_file_revisions.file_type_id = rm_file_types.id
				where rm_object_corelation.`relatedobjectid`=:proje  and rm_objects.object_type_id = 5 and trashed_on='0000-00-00 00:00:00'  group by rm_objects.id  
ORDER BY rm_project_tasks.assigned_to_contact_id ASC");
			#bind Value 
			// bug dalam limit
			$query->bindParam(':proje', $idProject, PDO::PARAM_INT);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();		


			}


		public function Insertprojectquery($id_kon,$vesselname,$bkiid,$bkidesaindid,$imo,$operationstat,$flag,$port,$owner,$manager,$rulesset,$ruleedision,$classnotation,$type,$builder,$hullyard,$outfittingyard,$keellaid,$launchdate,$dateofbuild,$deliverydate,$loa,$lbp,$lload,$bext,$b,$d,$draught,$freeboard ){
		$query 	= $this->db->prepare("INSERT INTO `rm_queryproject` (id_kon,vesselname,bkiid,bkidesaindid,imo,operationstat, flag, port,owner, manager,rulesset,ruleedision, classnotation, type,builder,hullyard,outfittingyard, keellaid,launchdate,dateofbuild,deliverydate,loa,lbp,lload,bext,b,d,draught,freeboard ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
	 	$updateon = date("Y-m-d H:i:s");

		$query->bindValue(1, $id_kon);
		$query->bindValue(2, $vesselname);
		$query->bindValue(3, $bkiid);
		$query->bindValue(4, $bkidesaindid);
		$query->bindValue(5, $imo);
		$query->bindValue(6, $operationstat);
		$query->bindValue(7, $flag);
		$query->bindValue(8, $port);
		$query->bindValue(9, $owner);
		$query->bindValue(10, $manager);
		$query->bindValue(11, $rulesset);
		$query->bindValue(12, $ruleedision);
		$query->bindValue(13, $classnotation);
		$query->bindValue(14, $type);
		$query->bindValue(15, $builder);
		$query->bindValue(16, $hullyard);
		$query->bindValue(17, $outfittingyard);
		$query->bindValue(18, $keellaid);
		$query->bindValue(19, $launchdate);
		$query->bindValue(20, $dateofbuild);
		$query->bindValue(21, $deliverydate);
		$query->bindValue(22, $loa);
		$query->bindValue(23, $lbp);
		$query->bindValue(24, $lload);
		$query->bindValue(25, $bext);
		$query->bindValue(26, $b);
		$query->bindValue(27, $d);
		$query->bindValue(28, $draught);
		$query->bindValue(29, $freeboard);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}

		public function Dellprojectquery($id_kon){
		
		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_queryproject` WHERE `rm_queryproject`.`id_kon` = ? limit 1");
		$query->bindValue(1, $id_kon);

		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

		}

		public function Updateprojectquery($id_kon,$vesselname,$bkiid,$bkidesaindid,$imo,$operationstat,$flag,$port,$owner,$manager,$rulesset,$ruleedision,$classnotation,$type,$builder,$hullyard,$outfittingyard,$keellaid,$launchdate,$dateofbuild,$deliverydate,$loa,$lbp,$lload,$bext,$b,$d,$draught,$freeboard){

			$this->Dellprojectquery($id_kon);
			$this->Insertprojectquery($id_kon,$vesselname,$bkiid,$bkidesaindid,$imo,$operationstat,$flag,$port,$owner,$manager,$rulesset,$ruleedision,$classnotation,$type,$builder,$hullyard,$outfittingyard,$keellaid,$launchdate,$dateofbuild,$deliverydate,$loa,$lbp,$lload,$bext,$b,$d,$draught,$freeboard);
		}

		public function Getprojectquery($id_kon){
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT *  from rm_queryproject where id_kon = ? limit 1 ");
			#bind Value 
			$query->bindValue(1, $id_kon);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		
		}
		public function getProjectIdbyNocontract($nocontract){
		
		$query = $this->db->prepare("SELECT * from rm_workspaces where rm_workspaces.id_kontrak = ?  limit 1");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $nocontract);
				 $query->bindColumn('object_id', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;

		}

					#Get  idjabatan
		public function Get_idJabatan($jabatan) {
			
			$query = $this->db->prepare("SELECT id FROM `og_team_jabatan` where nama = ? limit 1");
				#bind Value 
				$query->bindValue(1, $jabatan);
				
				 $query->bindColumn('id', $hak);

			try{
				$query->execute();
				
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $hak;
		
		}



		public function GetObjectTaskundoneByUser($projectid,$userid){
				
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT s.tanggal, s.id, s.id_project_gamb,s.id_kontrak, s.revisi, m.no_gambar,m.judul, m.tipe, m.akses, m.forinfo, m.engfield, t.due_date, t.start_date, t.assigned_to_contact_id, t.percent_completed,t.assigned_by_id,c.task_objectid FROM `og_sub_proj_gambar` s left join og_proj_gambar m ON s.id_project_gamb=m.id left join og_corelationtaskdrawing c on s.id=c.id_subdrawing LEFT join rm_project_tasks t on c.task_objectid=t.object_id where s.id_kontrak=:proje and assigned_to_contact_id = :userid and t.percent_completed !=100 order by s.tanggal DESC");
			#bind Value 
			// bug dalam limit
			$query->bindParam(':proje', $projectid, PDO::PARAM_INT);
			$query->bindParam(':userid', $userid, PDO::PARAM_INT);

			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();		
		
		}

	public function htmlEmail($formEmail, $nameSender, $addresses, $message, $subject, $alternative, $addressesExt=array(), $attachment='')
	{
		date_default_timezone_set('Asia/Jakarta');

		require_once '../class/mailer/PHPMailerAutoload.php';

		//Create a new PHPMailer instance
		$mail = new PHPMailer;
		//Tell PHPMailer to use SMTP
		$mail->isSMTP();

		$mail->SMTPDebug = 0;
		//Ask for HTML-friendly debug output
		$mail->Debugoutput = 'html';
		//Set the hostname of the mail server
		$mail->Host = "mail.bki.co.id";
		//Set the SMTP port number - likely to be 25, 465 or 587
		$mail->Port = 25;
		//Whether to use SMTP authentication
		$mail->SMTPAuth = false;
		//Username to use for SMTP authentication
		$mail->Username = "triyan";
		//Password to use for SMTP authentication
		$mail->Password = "tes123triyan";
		//Set who the message is to be sent from
		$mail->setFrom($formEmail, $nameSender);
		//Set an alternative reply-to address
		//$mail->addReplyTo('replyto@example.com', 'First Last');
		//Set who the message is to be sent to
		if(!empty($addresses))
		{
			foreach ($addresses as $adr){
				$mail->addAddress($adr['email'], $adr['nama']);
			}	
		}

		if(!empty($addressesExt))
		{
			if(is_array($addressesExt))
			{
				foreach ($addressesExt as $axt) { //external email
					$mail->addAddress($axt, $axt);
				}
			}else
			{
				$mail->addAddress($addressesExt, $addressesExt);
			}
		}

		if ($attachment!='') {
			$mail->addAttachment($attachment, 'Lampiran.pdf');
		}
		

		//Set the subject line
		$mail->Subject = $subject ;
		//Read an HTML message body from an external file, convert referenced images to embedded,
		//convert HTML into a basic plain-text alternative body
		$mail->isHTML(true);
		$mail->Body = $message;

		//Replace the plain text body with one created manually
		$mail->AltBody = $alternative;
		//Attach an image file
		//$mail->addAttachment('images/phpmailer_mini.png');

		//send the message, check for errors
		if (!$mail->send()) {
			return "Mailer Error: " . $mail->ErrorInfo;
		} else {
			return "Message sent!";
		}
	}

	public function getNokontrak($projectid){

		$query = $this->db->prepare("SELECT id_kontrak from rm_workspaces where object_id = ? limit 1");
			#bind Value 
			 $query->bindValue(1, $projectid);
			 $query->bindColumn('id_kontrak', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;

		}	


	public function getLateTaskonProject($idkontrak){

			$query = $this->db->prepare("SELECT rm_project_tasks.object_id, rm_project_tasks.percent_completed,rm_objects.name, rm_project_tasks.due_date , og_user.nama  FROM `rm_project_tasks` LEFT JOIN rm_object_corelation on rm_project_tasks.`object_id`= rm_object_corelation.`objectid` LEFT JOIN rm_objects on rm_project_tasks.`object_id`= rm_objects.id LEFT JOIN og_user ON rm_project_tasks.assigned_to_contact_id  = og_user.id_user where rm_object_corelation.`relatedobjectid`=? and rm_objects.trashed_on='0000-00-00 00:00:00' and rm_project_tasks.percent_completed != 100 and rm_project_tasks.due_date < now() ");
			#bind Value 
			$query->bindValue(1, $idkontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 $jml = $query->rowCount();
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $jml ;	

	}


	public function updateworkspaceLatetask($latetask,$idkontrak){
		
		$query 	= $this->db->prepare("UPDATE rm_workspaces SET latetask  = ?  where object_id= ?  ");
		
		$query->bindValue(1, $latetask);
		$query->bindValue(2, $idkontrak);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}

	public function Updatelatetask($idkontrak){

		$jml=$this->getLateTaskonProject($idkontrak);
		$this->updateworkspaceLatetask($jml,$idkontrak);

	}

	public function updateTaskNotif($objectNumber, $created_by_id, $act)
	{
		$created_on = date("Y-m-d H:i:s");
		$subscriblist=$this->getSubcriber($objectNumber);
		
		foreach ($subscriblist as $subscriblis){
		
		//notification insert
		if ($subscriblis['contact_id']!=$created_by_id){
		$this->InsertNotftable($subscriblis['contact_id'], $objectNumber, 0, $created_on, "panel.php?module=projectDetail&id=" . $objectNumber , 5 ,"add")	;	
		$toemailbyiduser = $toemailbyiduser . "," .  $subscriblis['contact_id'] ;
		//send notification email
		}
		}
		
		$objectname= $this->Get_objectName_id($idobject);
		
		$AndDo=" Task has been updated " ;
		$ccomment = "The drawing related to this task has been $act by" . $this->Get_nama_id($created_by_id);
		
		if ($toemailbyiduser!=""){
		$this->PreapareSendEmailNotif($objectNumber, $AndDo,$created_by_id,$objectname,$toemailbyiduser,$ccomment);
		}
	}

	//survey task
	public function getSurveyTaskbyIdproject($id_project){
		
		$query = $this->db->prepare("SELECT og_surveyitem_task.id, rm_project_tasks.object_id, rm_project_tasks.percent_completed,rm_objects.name, rm_project_tasks.due_date , rm_project_tasks.start_date, og_user.nama  FROM og_surveyitem_task 
LEFT JOIN rm_project_tasks on og_surveyitem_task.object_id= rm_project_tasks.object_id  
LEFT JOIN rm_objects on rm_project_tasks.object_id= rm_objects.id  
LEFT JOIN og_user ON rm_project_tasks.assigned_to_contact_id  = og_user.id_user

where og_surveyitem_task.project_id=:proje
order by og_surveyitem_task.id asc ");
			#bind Value 
			#bind Value 
			$query->bindParam(':proje', $id_project, PDO::PARAM_INT);


			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		return $query->fetchAll();

		}


	public function insertCorrelationSurvey($idTask, $idProject)
	{
		$query 	= $this->db->prepare("INSERT INTO `og_surveyitem_task` (object_id, project_id) VALUES (?,?) ");
	 
		$query->bindValue(1, $idTask);
		$query->bindValue(2, $idProject);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function assignStartSurvey($start, $idObject)
	{
		$query 	= $this->db->prepare("UPDATE rm_project_tasks SET start_date = ? WHERE object_id = ?");
	 
		$query->bindValue(1, $start);
		$query->bindValue(2, $idObject);
	 
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
			
		}
	}

	public function updateProgressSurvey($idObject, $progress, $user_id)
	{
		$projectTask = $this->get_projectTaskbyid($idObject);
		foreach($projectTask as $pt)
		{
			$start = $pt['start_date'];
		}

		if($start == "0000-00-00 00:00:00")
		{
			$this->assignStartSurvey(date("Y-m-d H:i:s"), $idObject);
		}

		$this->updateprogressTaskobj($user_id, $progress, $idObject);
	}		



}
?>

<?php
class Activity{

		private $db;
		   
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function Insert_activity($activity, $user_id, $object,$link){
		
		$date_hour= date("Y-m-d H:i:s") ;

		$query 	= $this->db->prepare("INSERT INTO `rm_activity` (date_hour, activity, user_id, object,link  ) VALUES (?, ?, ?, ?,?) ");
	 
		$query->bindValue(1, $date_hour);
		$query->bindValue(2, $activity);
		$query->bindValue(3, $user_id);
		$query->bindValue(4, $object);
		$query->bindValue(5, $link);
		
	 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	
		public function get_activity2($id_Last) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT a.id , a.date_hour , b.name_activity , a.user_id , a.object,u.path , o.nick , b.icon,a.link from rm_activity a inner join  rm_activity_type b on a.activity = b.id_act
			inner join rm_biodata u on u.id_user=a.user_id 
			inner join og_user o on o.id_user=a.user_id 
			where a.id < ? order by a.id DESC LIMIT 15 ");
			#bind Value 
				$query->bindValue(1, $id_Last);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		
		public function get_activity($id_Last) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT a.id , a.date_hour , b.name_activity , a.user_id , a.object,u.path , o.nick , b.icon,a.link from rm_activity a inner join  rm_activity_type b on a.activity = b.id_act
			inner join rm_biodata u on u.id_user=a.user_id 
			inner join og_user o on o.id_user=a.user_id 
			 order by a.id DESC LIMIT 10 ");
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_lastactivity_activity($id_Last) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT a.id , a.date_hour , b.name_activity , a.user_id , a.object,u.path , o.nick , b.icon,a.link from rm_activity a inner join  rm_activity_type b on a.activity = b.id_act
			inner join rm_biodata u on u.id_user=a.user_id 
			inner join og_user o on o.id_user=a.user_id 
			where a.id > ?  order by a.id DESC ");
			 
			$query->bindValue(1, $id_Last);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_last_activity() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT a.activity, a.id , a.date_hour , b.name_activity , a.user_id , a.object,u.path , o.nick , b.icon,a.link from rm_activity a inner join  rm_activity_type b on a.activity = b.id_act
			inner join rm_biodata u on u.id_user=a.user_id 
			inner join og_user o on o.id_user=a.user_id 
			 order by a.id DESC LIMIT 1 ");
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function cek_saveral_change($user_id,$objectt,$activity){
		
			$several_change_dummy=$this->get_last_activity();
			
			foreach ($several_change_dummy as $several_change ){

				$s = $several_change['date_hour'] ;
				$dt = new DateTime($s);

				$date = $dt->format('Y-m-d');
				$date2 = date('Y-m-d');
				
				$time = $dt->format('H:i:s');
				$time_now=date("H:i:s") ;
				$interval = (strtotime($time_now) - strtotime($time)) / 3600;
				$object=$several_change['object'] ;
				$userid=$several_change['user_id'] ;
				$activityy=$several_change['activity'] ;
			}
			
			if  (($userid==$user_id) and ($activityy==$activity) and ($objectt==$object) and ($date==$date2) and ($interval<3) ){
			
			return false	;  //ada kembar sebelumnya 
			} else {
			return true ; //tida ada kembar sebelumnya
			}

		
		} 
		
		public function get_number_activity($id_Last) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT a.id , a.date_hour , b.name_activity , a.user_id , a.object,u.path , o.nick , b.icon,a.link from rm_activity a inner join  rm_activity_type b on a.activity = b.id_act
			inner join rm_biodata u on u.id_user=a.user_id 
			inner join og_user o on o.id_user=a.user_id 
			where a.id < ? order by a.id DESC LIMIT 15");
            
			$query->bindValue(1, $id_Last);
			
			try{
				$query->execute();
				$jml = $query->rowCount();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $jml ;
		}
		
		
		
		
		public function format_tanggal($tanggal) {
		
		
			$tanggalan = date("M j, Y \a\\t\ G:i ", strtotime($tanggal));               // Sat Mar 10 17:16:18 MST 2001
			
			return $tanggalan ;
			
		}
		
			public function getWhiteboard(){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT rm_message.id , rm_message.message, rm_message.dari,  rm_message.tipe, rm_message.tanggal , og_user.nama FROM rm_message JOIN og_user ON og_user .id_user=rm_message.dari where tipe = '2' order by id DESC LIMIT 1");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

	}
	
	
	//insert task
	
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
	
	//get taskByid
	
	public function getTaskbyidUserStatusLimit($idUser,$status,$limit){
	
	if ($status==1){
	 $finish="0000-00-00 00:00:00";
	$statement="SELECT * FROM rm_task  where userId = :user and finish !=:finis  order by id DESC LIMIT :start";
	}else {
	 $finish="0000-00-00 00:00:00";
	$statement="SELECT * FROM rm_task  where userId = :user and finish = :finis  order by id DESC LIMIT :start";
	}

				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare($statement);
					
			$query->bindParam(':user', $idUser, PDO::PARAM_STR);
			$query->bindParam(':finis', $finish, PDO::PARAM_INT);
			$query->bindParam(':start', $limit, PDO::PARAM_INT);
			
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	}
	
	public function getTaskbyidUserUrgent($idUser){
	
			$finish="0000-00-00 00:00:00";
			$dateTimenow=date('Y-m-d H:i:s');
			
			$d1 = new DateTime($dateTimenow);
			// Add 1 day - expect time to remain at 08:00
			date_add($d1,date_interval_create_from_date_string("35 days"));
			
			$d1=date_format($d1,"Y-m-d H:i:s");
			
			

				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_task  where finish = ? and userId= ? and due  <=  ? order by due asc ");
			
			$query->bindValue(1, $finish);
			$query->bindValue(2, $idUser);
			$query->bindValue(3, $d1);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	
	
	
	}
	
	public function getJmlTaskbyidUserUrgent($idUser){
	
			$finish="0000-00-00 00:00:00";
			$dateTimenow=date('Y-m-d H:i:s');
			
			$d1 = new DateTime($dateTimenow);
			// Add 1 day - expect time to remain at 08:00
			date_add($d1,date_interval_create_from_date_string("1 days"));
			
			$d1=date_format($d1,"Y-m-d H:i:s");
			
			

				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_task  where finish = ? and userId= ? and due  <=  ? order by due asc ");
			
			$query->bindValue(1, $finish);
			$query->bindValue(2, $idUser);
			$query->bindValue(3, $d1);
			
			
			
			try{
				$query->execute();
				$jml = $query->rowCount();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $jml ;
	
	
	
	}
	
	public function getTaskbyidUser($idUser,$limit){
	
	

				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT rm_task.id, rm_task.pekerjaan,rm_task.userId,rm_task.due,rm_task.finish,rm_task.tipeKegiatan,rm_task.idKegiatan,rm_task.shared,rm_task.desck,rm_task.oleh, rm_training.training,rm_workspaces.project  FROM rm_task  

LEFT JOIN   rm_training ON  rm_training.id=  rm_task.idKegiatan 

LEFT JOIN   rm_object_corelation ON  rm_object_corelation.objectid=  rm_task.idKegiatan 	
LEFT JOIN    rm_workspaces ON   rm_workspaces.object_id=  rm_object_corelation.relatedobjectid

where userId = :user  order by id DESC LIMIT :start ");
			
			//$query->bindValue(1, $idUser);
			//$query->bindValue(2, $limit);
			$query->bindParam(':user', $idUser, PDO::PARAM_STR);
			$query->bindParam(':start', $limit, PDO::PARAM_INT);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	}
	
	
	//dell task
	
	public function dellTask($id) {
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_task` WHERE `rm_task`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}		
	
	//update task
	
	public function UpdateTaskDone($realization,$id){
	

		$query 	= $this->db->prepare("UPDATE rm_task SET finish=? where id= ? limit 1 ");
	 
		$query->bindValue(1, $realization);
		$query->bindValue(2, $id);
		
 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	//getTaskShared
	
	public function getTaskUndoneShare(){
	

	 $finish="0000-00-00 00:00:00";

				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_task  where finish = ? and shared = 1 order by id DESC ");
			
			$query->bindValue(1, $finish);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	}
	
	
	
	
	//insertDocGalery
	
	public function Insert_docGalery($nama, $tipe, $assosiated,$tipeassosiated,$path){
		

		$query 	= $this->db->prepare("INSERT INTO `rm_galeryupload` (	nama, tipe, assosiated, tipeassosiated, path) VALUES (?, ?, ?, ?,?) ");
	 
		$query->bindValue(1, $nama);
		$query->bindValue(2, $tipe);
		$query->bindValue(3, $assosiated);
		$query->bindValue(4, $tipeassosiated);
		$query->bindValue(5, $path);
		
	 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	//getDocGalery
	
	public function getdocGalery($tipeDoc){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_galeryupload where tipe =? order by id DESC limit 100 ");		
			
			$query->bindValue(1, $tipeDoc);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	}
	
	//getDocGalery by asosiated
		public function getdocGaleryAsociated($assosiated,$tipeassosiated){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_galeryupload where assosiated = ?  and tipeassosiated =?   and tipe=1 order by id DESC" );		

			$query->bindValue(1, $assosiated);
			$query->bindValue(2, $tipeassosiated);
		
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	}
	
	public function getdocAsociated($assosiated){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_galeryupload where assosiated = ?  and tipeassosiated =2   and tipe=2 order by id DESC" );		

			$query->bindValue(1, $assosiated);

		
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	}
	
	//update Doc nama
	public function UpdatedocGalerybyId($nama,$id){
	

		$query 	= $this->db->prepare("UPDATE rm_galeryupload SET nama=? where id= ? limit 1 ");
	 
		$query->bindValue(1, $nama);
		$query->bindValue(2, $id);
		
 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	//dell Doc galery
	public function delldocGalerybyId($id){
	
	$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_galeryupload` WHERE `rm_galeryupload`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	

	}
	
	public function get_docGalerybyId($id) {

		$query = $this->db->prepare("SELECT * FROM `rm_galeryupload` where  id = ? ");
		
		$query->bindValue(1, $id);
		
			$query->bindColumn('path', $hak);
			
			try{
				$query->execute();
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
					
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;
		
		}
	
	
	
	
	
	
		
		
		
		


}
?>
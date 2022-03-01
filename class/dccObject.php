<?php
class dcc{
 
		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function lastInsertId(){
			return $this->db->lastInsertId();
		}
		
		public function InsertComputer($name, $mac, $ip){
		
		$query 	= $this->db->prepare("INSERT INTO `dc_computer` (name, mac, ip  ) VALUES (?,?,?) ");
	 
		$query->bindValue(1, $name);
		$query->bindValue(2, $mac);
		$query->bindValue(3, $ip);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}
		
		public function dellComputer($id_com){
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`dc_computer` WHERE `dc_computer`.`id_com` = ?");
		//$query->bindValue(1, $objectid);
		$query->bindValue(1, $id_com);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
		
		
		}
		
		public function GetComputerbymac($mac){
		
		
		$query = $this->db->prepare("SELECT * from dc_computer where mac = :mac limit 1");
			#bind Value 
			
			$query->bindParam(':mac', $mac, PDO::PARAM_INT);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		
		}
		
		public function getComputer(){
		
			$query = $this->db->prepare("SELECT * from dc_computer ");
			#bind Value 

			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		}
		
		public function InsertSession($iduser, $key, $lasupdate){
		
		
		$query 	= $this->db->prepare("INSERT INTO `dc_session` ( iduser , `key`, lasupdate ) VALUES (?,?,?) ");
		
		$query->bindValue(1, $iduser);
		$query->bindValue(2, $key);
		$query->bindValue(3, $lasupdate);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}
		
		public function cekSessionActive($key){
		
		$query = $this->db->prepare("SELECT * from dc_session where `key` = :key limit 1");
			#bind Value 
			
			$query->bindParam(':key', $key, PDO::PARAM_STR);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			$jml = $query->rowCount();
			
			if ($jml>0 ){
			return true;
			}else{
			return false;
			}

		}
		
		public function updatetimestampSession($id){
			
			$updated_on = date("Y-m-d H:i:s");		
		
			$updated_on=date();
			$query 	= $this->db->prepare("UPDATE dc_session SET lasupdate = ?  where id= ?  ");
		 
			$query->bindValue(1, $updated_on);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		}
		
		public function DeletedSession(){
		
		$sekarang=time();
		
		$valid_attempts = $sekarang - (2 * 60 * 60);
		
		$valid_attemptss=date("Y-m-d H:i:s",$valid_attempts);
		
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`dc_session` WHERE `dc_session`.`lasupdate` < ?");
		//$query->bindValue(1, $objectid);
		$query->bindValue(1, $valid_attemptss);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}

		}
		
		public function getSession(){
			$query = $this->db->prepare("SELECT * from dc_session ");
			#bind Value 

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $query->fetchAll();
		
		}
		
		public function getIDbysession($key){
		
	
			$query = $this->db->prepare("SELECT  iduser FROM `dc_session`  where `key` = ? LIMIT 1 ");
			#bind Value 
				$query->bindValue(1, $key);
				 $query->bindColumn('iduser', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;
		
		}
		
		public function InsertdcclogStamp($iduser, $mac, $status){
		
		$query 	= $this->db->prepare("INSERT INTO `dcc_logstamp` (iduser, mac, status) VALUES (?,?,?) ");
	 
		$query->bindValue(1, $iduser);
		$query->bindValue(2, $mac);
		$query->bindValue(3, $status);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}
		
		public function GetId($username){
		
			$query = $this->db->prepare("SELECT id_user, nick, sandi, garam ,nama ,previl FROM og_user WHERE email = ? or nick = ?  LIMIT 1");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $username);
				$query->bindValue(2, $username);
				 $query->bindColumn('id_user', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;
		
		
		}
		

		
		public function insertDCCuser($nup,$nama,$divisi,$sandi,$garam){
		
		$query 	= $this->db->prepare("INSERT INTO `dc_user` (	nup, nama, divisi,	sandi, garam   ) VALUES (?,?,?,?,?) ");
	 
		$query->bindValue(1, $nup);
		$query->bindValue(2, $nama);
		$query->bindValue(3, $divisi);
		$query->bindValue(4, $sandi);
		$query->bindValue(5, $garam);
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}			
		
		}
		
		public function GetdccUser(){
		
		$query = $this->db->prepare("SELECT * from dc_user  order by id desc ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		
		public function dellDCCuser($id){
		$query 	= $this->db->prepare("DELETE FROM `dc_user` WHERE `id` = ?  LIMIT 1");
		$query->bindValue(1, $id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
		
		
		}
		
		
		public function get_FTPuser($id) {
		
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `dw_ftpdcc`   where related = ? ORDER BY `id` DESC");
			
			$query->bindValue(1, $id);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		

		
		
		
		

		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
}		






?>
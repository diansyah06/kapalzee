<?php
class time_lines
	{
		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function insert_db_timeslines($aktifitas, $link){
			$tanggal = Date("Y-m-d\ H:i:s\ "); 
			$create_by = $_SESSION['user_id'];
			
			$query 	= $this->db->prepare("INSERT INTO `og_time_lines` (tanggal, aktifitas, create_by, link ) VALUES (?, ?,?,?) ");
		 
			$query->bindValue(1, $tanggal);
			$query->bindValue(2, $aktifitas);
			$query->bindValue(3, $create_by);
			$query->bindValue(4, $link);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
	
	}
?>
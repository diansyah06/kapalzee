<?php
class tipe_objek{
	private $db;
			 
			public function __construct($database) {
				$this->db = $database;
	}
	
	public function insert_tipe_objek($nama, $deskrip){
	 
		$query 	= $this->db->prepare("INSERT INTO `og_tipe_object` ( 	Nama, deskrip) VALUES (?, ?) ");
	 
		$query->bindValue(1, $nama);
		$query->bindValue(2, $deskrip);
		
	 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function get_tipe_objek() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_tipe_object` " );
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

	public function delete_tipe_objek($id){

		$query 	= $this->db->prepare("DELETE FROM `og_tipe_object` WHERE id = ?  LIMIT 1");
		$query->bindValue(1, $id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	


	}
		

}

?>
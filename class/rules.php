<?php
class Rule{

private $db;
		 
		public function __construct() {
			$this->db = $this->connectDatabase();
		}
		
		function connectDatabase(){
			$config = array(
			'host'	=> '10.0.1.202',
			'username'	=> 'ServerRulesRMs',
			'password'	=> 'H89jv3TwhVjttBMf6r6m',
			'dbname' => 'rms'
			);
			#connecting to the database by supplying required parameters
			$db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['username'], $config['password']);
			#Setting the error mode of our db object, which is very important for debugging.
			$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $db ;
		}
		
		public function getActiverules() {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT id, id_rules , nama, tahun, tipe, link, status,part, vol FROM rm_rulepub where status =1 ");


			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}	
		public function getActiverulesbyid($id) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT id, id_rules , nama, tahun, tipe, link, status,part, vol FROM rm_rulepub where id =? limit 1");
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
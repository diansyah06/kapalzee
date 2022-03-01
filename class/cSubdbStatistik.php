<?php 
class DSR{//ds_rms
		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function lastInsertId(){
			return $this->db->lastInsertId();
		}
		
		public function getdbExpertlist(){
		
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT db_expert.title,db_expert.tanggal_input, db_expert.id, db_expert.Tipe,db_expert.CP,db_expert.CA,db_expert.SP,db_expert.MS,db_expert.tipe_damage,tipe_damage,db_expert.description ,db_expert.countermesure ,db_expert.bki, db_tipealldamage.nama as damagee, m_specifik.nama as specifik, m_specifik.tipe ,structural_detail_failures.nama as namStruc, general_mesin.nama as namEng , elektrical.nama as namElec , db_exp_picture.path  FROM   db_expert 

				LEFT JOIN db_tipealldamage ON db_tipealldamage.Symbol= db_expert.tipe_damage 
				LEFT JOIN m_specifik ON m_specifik.Symbol =db_expert.MS
				LEFT JOIN structural_detail_failures ON structural_detail_failures.Symbol =db_expert.CA

				LEFT JOIN general_mesin ON general_mesin.Symbol =db_expert.CA
				LEFT JOIN db_exp_picture ON db_exp_picture.id_ds =db_expert.id

				LEFT JOIN elektrical ON elektrical.Symbol =db_expert.CA order by  db_expert.id desc
				
				");
			$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();			
		
		
		}
		
		public function delltblExpertdata($id){
		
		$query 	= $this->db->prepare("DELETE FROM `db_expert` WHERE `id` = ?  ");
		$query->bindValue(1, $id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
		
		
		}
		public function delltblImageExpert($id){
		
		$query 	= $this->db->prepare("DELETE FROM `db_exp_picture` WHERE `id_ds` = ?  ");
		$query->bindValue(1, $id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
		
		}
		
		public function dellDatabaseExpert($id){
		
		$this->delltblExpertdata($id);
		$this->delltblImageExpert($id);
		
		}
		
		public function Get_DamageStat(){
		
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT  db_statistik.id,db_orang.nama_lengkap,  
			db_statistik.reg, db_statistik.namakapl, db_statistik.tipe_kapal, db_statistik.tgl_input,db_statistik.CP,db_statistik.MS,db_statistik.tipe_damage, m_specifik.nama, m_specifik.tipe, db_tipealldamage.nama as tDamage  
			FROM db_statistik
			LEFT JOIN m_specifik ON m_specifik.Symbol  = db_statistik.MS
			LEFT JOIN db_tipealldamage ON db_tipealldamage.Symbol  = db_statistik.tipe_damage

			LEFT JOIN db_orang ON db_statistik.nup  =db_orang.id_user 
			
			order by db_statistik.id  desc ");
			
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		public function deldamagetbl($id){
		
		$query 	= $this->db->prepare("DELETE FROM `db_statistik` WHERE `id` = ?  ");
		$query->bindValue(1, $id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}

		
		}
		
		function createMenuComboBydatabasenameonname($tblname,$namelabel){
		
			$query = $this->db->prepare("SELECT * from $tblname  ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			
			$dataReturn=		"<select id='$tblname' name='$tblname' class='form-control'>
					<option selected='selected' value=''>---$namelabel---</option>";
										
			$isidatabases=$query->fetchAll();
			
			foreach ($isidatabases as $isidatabase){
			
			$dataReturn= $dataReturn . "<option Value='$isidatabase[nama]'>$isidatabase[nama]</option>";

			}
			
			$dataReturn= $dataReturn . "</select>	
										";
										
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return  $dataReturn ;

		}
		
		function createMenuComboBydatabase($tblname,$namelabel){
		
			$query = $this->db->prepare("SELECT * from $tblname  ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			
			$dataReturn=		"<select id='$tblname' name='$tblname' class='form-control'>
										<option selected='selected'></option>";
										
			$isidatabases=$query->fetchAll();
			
			foreach ($isidatabases as $isidatabase){
			
			$dataReturn= $dataReturn . "<option Value='$isidatabase[no]'>$isidatabase[nama]</option>";

			}
			
			$dataReturn= $dataReturn . "</select>	
										";
										
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return  $dataReturn ;

		}
		
		function ReadTable($tableName){
		
					$query = $this->db->prepare($tableName);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
	public function get_nameItembytablesymbol($table, $id){
	
			$query = $this->db->prepare("SELECT  nama FROM $table  where Symbol = ? LIMIT 1 ");
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
		
		return $hak ;
	
	}

	public function inserTableTexpert($tahun,$tipe,$CP, $CA, $SP, $MS, $tipe_damage, $description, $countermesure, $sources, $postby, $bki, $kojen, $kompilasi, $title){
	
			$query 	= $this->db->prepare("INSERT INTO `db_expert` (tahun,tipe,CP, CA, SP, MS, tipe_damage, description, countermesure, sources, postby, bki, kojen, kompilasi, title ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
		 
			$query->bindValue(1, $tahun);
			$query->bindValue(2, $tipe);
			$query->bindValue(3, $CP);
			$query->bindValue(4, $CA);
			$query->bindValue(5, $SP);
			$query->bindValue(6, $MS);
			$query->bindValue(7, $tipe_damage);
			$query->bindValue(8, $description);
			$query->bindValue(9, $countermesure);
			$query->bindValue(10, $sources);
			$query->bindValue(11, $postby);
			$query->bindValue(12, $bki);
			$query->bindValue(13, $kojen);
			$query->bindValue(14, $kompilasi);
			$query->bindValue(15, $title);


			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
	
	
	}

		public function AdddataBaseFotoEP($dsCode,$path){
		
			$query 	= $this->db->prepare("INSERT INTO `db_exp_picture` (id_ds, path  ) VALUES (?, ?) ");
		 
			$query->bindValue(1, $dsCode);
			$query->bindValue(2, $path);

			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}	
		
		
		
		
}


?>
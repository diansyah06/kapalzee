<?php
class kpi{

private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function Create_kpi($name, $jenis, $Group, $star, $finish, $surat, $keterangan, $pelaku){
	
		$bulan = date("m",strtotime($star));
		$tahun = date("Y",strtotime($star));
	 
		$query 	= $this->db->prepare("INSERT INTO `rm_diary` (name, jenis, Grup, star, finish, surat, keterangan,bulan,tahun,pelaku ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?) ");
	 
		$query->bindValue(1, $name);
		$query->bindValue(2, $jenis);
		$query->bindValue(3, $Group);
		$query->bindValue(4, $star);
		$query->bindValue(5, $finish);
		$query->bindValue(6, $surat);
		$query->bindValue(7, $keterangan);
		$query->bindValue(8, $bulan);
		$query->bindValue(9, $tahun);
		$query->bindValue(10, $pelaku);

	 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function close_kpi_id($id_kpi, $tanggal,$userid){
	

	 
		$query 	= $this->db->prepare("UPDATE rm_diary SET finish= ?   where id_diar= ? and pelaku= ? ");
	 
	 
	 
		$query->bindValue(1, $tanggal);
		$query->bindValue(2, $id_kpi);
		$query->bindValue(3, $userid);
 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function delete_kpi($id,$id_user){

		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_diary` WHERE `rm_diary`.`id_diar` = ? and pelaku= ? LIMIT 1");
		$query->bindValue(1, $id);
		$query->bindValue(2, $id_user);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	


	}
	
		public function get_kpi_user($id_user,$awal,$akhir) {
		
				$awl_bulan = date("m",strtotime($awal));
				$awl_tahun = date("Y",strtotime($awal));
				
				$akhir_bulan = date("m",strtotime($akhir));
				$akhir_tahun = date("Y",strtotime($akhir));
				
				if ($awl_bulan==12){
			
				$akhir_bulan=13;
				}
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_diary`  where pelaku = ? and tahun >= ? and tahun <= ? and bulan >= ? and bulan < ? ORDER BY `id_diar` DESC");
			
			
			
			$query->bindValue(1, $id_user);
			$query->bindValue(2, $awl_tahun);
			$query->bindValue(3, $akhir_tahun);
			$query->bindValue(4, $awl_bulan);
			$query->bindValue(5, $akhir_bulan);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		
		public function get_kpi_user_stahun($id_user,$awal,$akhir) {
		
				$awl_bulan = date("m",strtotime($awal));
				$awl_tahun = date("Y",strtotime($awal));
				
				$akhir_bulan = date("m",strtotime($akhir));
				$akhir_tahun = date("Y",strtotime($akhir));
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_diary`  where pelaku = ? and tahun >= ? and tahun <= ? ORDER BY `id_diar` DESC");
			$query->bindValue(1, $id_user);
			$query->bindValue(2, $awl_tahun);
			$query->bindValue(3, $akhir_tahun);

			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function add_email_integeration($id_user,$username,$pass) {
		
		$pass=base64_encode($pass);
		
		$query 	= $this->db->prepare("INSERT INTO `rm_open_email` (id_user, username, pass ) VALUES (?, ?, ?) ");
	 
		$query->bindValue(1, $id_user);
		$query->bindValue(2, $username);
		$query->bindValue(3, $pass);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		


		}
		
		public function get_email_integeration($id_user) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_open_email`  where id_user = ?  ORDER BY `id` DESC Limit 1");

			$query->bindValue(1, $id_user);

			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		public function dell_email_integeration($id_user) {
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_open_email` WHERE `rm_open_email`.`id_user` = ? ");
	 
		$query->bindValue(1, $id_user);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		


		}
	
		
		
		
		public function get_ogs_integeration($id_user) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_open_ogs`  where id_user = ?  ORDER BY `id` DESC limit 1");

			$query->bindValue(1, $id_user);

			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function add_ogs_integeration($id_user,$username,$pass) {
		
		$pass=base64_encode($pass);
		
		$query 	= $this->db->prepare("INSERT INTO `rm_open_ogs` (id_user, username, pass ) VALUES (?, ?, ?) ");
	 
		$query->bindValue(1, $id_user);
		$query->bindValue(2, $username);
		$query->bindValue(3, $pass);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		


		}
		public function dell_ogs_integeration($id_user) {
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_open_ogs` WHERE `rm_open_ogs`.`id_user` = ? ");
	 
		$query->bindValue(1, $id_user);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		


		}
		
		
		//add training
		
		public function InsertTraining($tanggalStart, $tanggalEnd, $training, $jenis, $realisasiStart, $realisasiEnd, $peserta, $post,$description,$lokasi,$status,$unrealisation,$typeOfevent, $typekurs, $perkiraanExchange, $anggaran, $total, $periode,$negara){
		
		$updateon = date("Y-m-d H:i:s");
	 
		$query 	= $this->db->prepare("INSERT INTO `rm_training` (tanggalStart, tanggalEnd, training, jenis, realisasiStart, realisasiEnd, peserta, post, description, lokasi, status, unrealisation,updateby,updateon,typeOfevent,exchange,anggaran,kurs,total, periode,negara) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $tanggalStart);
		$query->bindValue(2, $tanggalEnd);
		$query->bindValue(3, $training);
		$query->bindValue(4, $jenis);
		$query->bindValue(5, $realisasiStart);
		$query->bindValue(6, $realisasiEnd);
		$query->bindValue(7, $peserta);
		$query->bindValue(8, $post);
		$query->bindValue(9, $description);
		$query->bindValue(10, $lokasi);
		$query->bindValue(11, $status);
		$query->bindValue(12, $unrealisation);
		$query->bindValue(13, $post);
		$query->bindValue(14, $updateon);

		$query->bindValue(15, $typeOfevent);

		$query->bindValue(16, $typekurs);
		$query->bindValue(18, $perkiraanExchange);
		$query->bindValue(17, $anggaran);
		$query->bindValue(19, $total);
		$query->bindValue(20, $periode);
		$query->bindValue(21, $negara);		

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function InsertInvest($item,$type ,$anggaran ,$Currency ,$kurs ,$total ,$description ,$periode ,$oleh ,$realization){
		
	 
		$query 	= $this->db->prepare("INSERT INTO `rm_traininginvest` (item,type, anggaran, currency,kurs,total,description,periode,oleh,realization) VALUES (?,?,?,?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $item);
		$query->bindValue(2, $type);
		$query->bindValue(3, $anggaran);
		$query->bindValue(4, $Currency);
		$query->bindValue(5, $kurs);
		$query->bindValue(6, $total);
		$query->bindValue(7, $description);
		$query->bindValue(8, $periode);
		$query->bindValue(9, $oleh);
		$query->bindValue(10, $realization);


		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}			
		
	}
	
	public function DelInvest($id){
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_traininginvest` WHERE `rm_traininginvest`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
		
	}
	
	public function getInvestation($periode){
		
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_traininginvest` where periode=?  ORDER BY `id` DESC ");
			
			$query->bindValue(1, $periode);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();				
		
	}
	
		//dell training
		public function dellTrainingId($id) {
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_training` WHERE `rm_training`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		


		}
		
		//updateTraining
		public function UpdateTrainingByid($tanggalStart, $tanggalEnd, $training, $jenis, $realisasiStart, $realisasiEnd, $peserta, $post,$description,$lokasi,$status,$unrealisation,$id){
	

		$query 	= $this->db->prepare("UPDATE rm_training SET tanggalStart=?, tanggalEnd=? , training=?, jenis=?, realisasiStart=?, realisasiEnd=?, peserta=?, 	post=? , description=? , lokasi=?, status=?, unrealisation=?, where id= ? limit 1 ");
	 
		$query->bindValue(1, $tanggalStart);
		$query->bindValue(2, $tanggalEnd);
		$query->bindValue(3, $training);
		$query->bindValue(4, $jenis);
		$query->bindValue(5, $realisasiStart);
		$query->bindValue(6, $realisasiEnd);
		$query->bindValue(7, $peserta);
		$query->bindValue(8, $post);
		$query->bindValue(9, $description);
		$query->bindValue(10, $lokasi);
		$query->bindValue(11, $status);
		$query->bindValue(12, $unrealisation);
		$query->bindValue(13, $id);
 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
			//updateTraining
		public function UpdateTrainingDescriptByid($description,$id,$user_id){
	

		$query 	= $this->db->prepare("UPDATE rm_training SET description=? where id= ? and post= ? limit 1 ");
	 
		$query->bindValue(1, $description);
		$query->bindValue(2, $id);
		$query->bindValue(3, $user_id);
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
		
		// unrealisation trainig
		public function updateUnrealizationTraining ($idTraining,$unrealisation){
		$getOldvalues = $this->getTrainingbyID($idTraining);
		
		foreach($getOldvalues as $getOldvalue){
		
		$tanggalStart=$getOldvalue['tanggalStart'];
		$tanggalEnd=$getOldvalue['tanggalEnd'];
		$training=$getOldvalue['training'];
		$jenis=$getOldvalue['jenis'];
		$realisasiStart=$getOldvalue['realisasiStart'];
		$realisasiEnd=$getOldvalue['realisasiEnd'];
		$peserta=$getOldvalue['peserta'];
		$post=$getOldvalue['post'];
		$description=$getOldvalue['description'];
		$lokasi=$getOldvalue['lokasi'];
		$status=$getOldvalue['status'];
		//$unrealisation=$getOldvalue['unrealisation'];
		}
		
		$this->UpdateTrainingByid($tanggalStart, $tanggalEnd, $training, $jenis, $realisasiStart, $realisasiEnd, $peserta, $post,$description,$lokasi,$status,$unrealisation,$idTraining);

		
		
		
		}
		//update status training
		public function UpdateStatusTraining($idTraining,$status){
		
		$getOldvalues = $this->getTrainingbyID($idTraining);
		
		foreach($getOldvalues as $getOldvalue){
		
		$tanggalStart=$getOldvalue['tanggalStart'];
		$tanggalEnd=$getOldvalue['tanggalEnd'];
		$training=$getOldvalue['training'];
		$jenis=$getOldvalue['jenis'];
		$realisasiStart=$getOldvalue['realisasiStart'];
		$realisasiEnd=$getOldvalue['realisasiEnd'];
		$peserta=$getOldvalue['peserta'];
		$post=$getOldvalue['post'];
		$description=$getOldvalue['description'];
		$lokasi=$getOldvalue['lokasi'];
		//$status=$getOldvalue['status'];
		$unrealisation=$getOldvalue['unrealisation'];
		}
		
		$this->UpdateTrainingByid($tanggalStart, $tanggalEnd, $training, $jenis, $realisasiStart, $realisasiEnd, $peserta, $post,$description,$lokasi,$status,$unrealisation,$idTraining);

		}
		
		//list training
		public function getTraining() {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_training`   ORDER BY `id` DESC ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function getRealizationEvent($year) {
			
			$tahunLimitbawah=$year -1 ; 
			$tahunLimitbawah=$tahunLimitbawah . "-12-31";
			
			$tahunLimitatas=$year + 1 ;
			$tahunLimitatas=$tahunLimitatas . "-01-01";
			
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_training` where status=1 and realisasiStart !='0000-00-00 00:00:00' and realisasiStart > ?  and realisasiStart < ? ORDER BY `realisasiStart` DESC ");
			
			$query->bindValue(1, $tahunLimitbawah);
			$query->bindValue(2, $tahunLimitatas);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function trainingSugeest($nama){
		
					$query = $this->db->prepare("SELECT * FROM rm_training where training like ? limit 10");
			#bind Value 
				$query->bindValue(1, $nama);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		
		}
		
		public function trainingSugeestPeriode($nama){
		
			$periode=$this->GetActivePlanPeriode();
			
					$query = $this->db->prepare("SELECT * FROM rm_training where training like ?  and periode = ? limit 10");
			#bind Value 
				$query->bindValue(1, $nama);
				$query->bindValue(2, $periode);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		
		}
		
		public function InvestSugeestPeriode($nama){
		
			$periode=$this->GetActivePlanPeriode();
			
					$query = $this->db->prepare("SELECT * FROM rm_traininginvest where item like ?  and periode = ? limit 10");
			#bind Value 
				$query->bindValue(1, $nama);
				$query->bindValue(2, $periode);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		
		}			
		//getTrainingByid
		public function getTrainingbyID($id) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_training` where id= ?   ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		//listTrainingByUser
		public function getTrainingByuser($idUser) {
			$idUser="%," . $idUser ."%" ;
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_training`  where peserta  LIKE ? and  realisasiEnd !='0000-00-00 00:00:00' ORDER BY `id` DESC ");
			$query->bindValue(1, $idUser);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		//insert cost

		
		public function Insertcost($nam, $cost, $currency, $tipeKegiatan, $idKegiatan ,$decription,	$realisation,$periode,$kurs, $total){
		$tanggal = date("Y-m-d H:i:s", strtotime($tanggal));
		if ($realisation!=""){
		$realisation= date("Y-m-d H:i:s", strtotime($realisation));
		}
		$query 	= $this->db->prepare("INSERT INTO `rm_cost` (nam, cost, currency, tipeKegiatan, idKegiatan ,decription,	realisation,periode,kurs,total  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?) ");
	 
		$query->bindValue(1, $nam);
		$query->bindValue(2, $cost);
		$query->bindValue(3, $currency);
		$query->bindValue(4, $tipeKegiatan);
		$query->bindValue(5, $idKegiatan);
		$query->bindValue(6, $decription);
		$query->bindValue(7, $realisation);
		$query->bindValue(8, $periode);
		$query->bindValue(9, $kurs);
		$query->bindValue(10, $total);		

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function InsertcostInvest($nam, $cost, $currency, $tipeKegiatan, $idKegiatan ,$decription,	$realisation,$periode,$kurs, $total){
		$tanggal = date("Y-m-d H:i:s", strtotime($tanggal));
		if ($realisation!=""){
		$realisation= date("Y-m-d H:i:s", strtotime($realisation));
		}
		$query 	= $this->db->prepare("INSERT INTO `rm_costinvest` (nam, cost, currency, tipeKegiatan, idKegiatan ,decription,	realisation,periode,kurs,total  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?) ");
	 
		$query->bindValue(1, $nam);
		$query->bindValue(2, $cost);
		$query->bindValue(3, $currency);
		$query->bindValue(4, $tipeKegiatan);
		$query->bindValue(5, $idKegiatan);
		$query->bindValue(6, $decription);
		$query->bindValue(7, $realisation);
		$query->bindValue(8, $periode);
		$query->bindValue(9, $kurs);
		$query->bindValue(10, $total);		

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	
	//dell cost
	
		public function dellCost($id) {
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_cost` WHERE `rm_cost`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function dellCostInvest($id){
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_costinvest` WHERE `rm_costinvest`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
		
	}	
	
	//update Realization
	
	public function UpdateRealizationCostByidByid($realization,$id){
	

		$query 	= $this->db->prepare("UPDATE rm_cost SET realisation=? where id= ? limit 1 ");
	 
		$query->bindValue(1, $realization);
		$query->bindValue(1, $id);
		
 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	//get cost
	
	public function getCost($periode,$optional = "id") {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT rm_cost.id,rm_cost.nam,rm_cost.cost, rm_cost.currency, rm_cost.tipeKegiatan, rm_cost.idKegiatan,rm_cost.decription,rm_cost.realisation, rm_cost.total,rm_training.training ,rm_training.typeOfevent,rm_training.total as usulan  FROM `rm_cost` 

LEFT JOIN  rm_training ON rm_cost.idKegiatan =  rm_training.id

where  	rm_cost.periode =? ORDER BY rm_cost.". $optional ." DESC");

			$query->bindValue(1, $periode);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

	public function getCostInvest($periode,$optional = "id") {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT rm_costinvest.id ,rm_costinvest.nam,rm_costinvest.cost, rm_costinvest.currency, rm_costinvest.tipeKegiatan, rm_costinvest.idKegiatan,rm_costinvest.decription,rm_costinvest.realisation, rm_costinvest.total,rm_traininginvest.item ,rm_traininginvest.total as usulan  FROM `rm_costinvest` 

LEFT JOIN  rm_traininginvest ON rm_costinvest.idKegiatan =  rm_traininginvest.id

where  	rm_costinvest.periode =? ORDER BY rm_costinvest.". $optional ." DESC");

			$query->bindValue(1, $periode);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}		
		public function getCostbyid($idproject,$typeprject) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_cost` where tipeKegiatan=? and idKegiatan= ?  ORDER BY `id` DESC ");
			$query->bindValue(1, $typeprject);
			$query->bindValue(2, $idproject);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}	
		
	public function getProjectpaper(){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT 'a', training
FROM rm_training
WHERE training LIKE '%a%'
UNION
SELECT 'b', message
FROM rm_message
WHERE message LIKE '%a%'");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	
	
	
	}
	
		public function GetPlanperiode() {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_planperiode`  ORDER BY `id` DESC ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function InsertPlanperiode($start ,$end ,$by ){
		$start = date("Y-m-d H:i:s", strtotime($start));
		$end = date("Y-m-d H:i:s", strtotime($end));
		
		$status=0;
		$query 	= $this->db->prepare("INSERT INTO `rm_planperiode` (start ,	end ,	`by` ,	status  ) VALUES (?, ?, ?, ?) ");
	 
		$query->bindValue(1, $start);
		$query->bindValue(2, $end);
		$query->bindValue(3, $by);
		$query->bindValue(4, $status);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
			
		}
		
		public function setOnplanPeriode($id){
		
		$this->setOffAllplanPeriode();	
		$query 	= $this->db->prepare("UPDATE rm_planperiode SET status=1 where id= ?limit 1 ");

		$query->bindValue(1, $id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
			
			
		}
		
		public function setOffAllplanPeriode(){
			
		$query 	= $this->db->prepare("UPDATE rm_planperiode SET status=0  ");


		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
			
			
		}

		public function DelPlanPeriode($id){
			
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_planperiode` WHERE `rm_planperiode`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
		
		}

		public function GetActivePlanPeriode(){ 
			
		$query = $this->db->prepare("SELECT * from rm_planperiode where status= 1 limit 1 ");
			#bind Value 

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
		
		public function getBudgetOf($periode,$optional = "`id`"){

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_training` where periode=?  ORDER BY " . $optional . " DESC ");
			
			$query->bindValue(1, $periode);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();			
			
		}

		public function GetTrainingCost($start,$end){ 
			
		$query = $this->db->prepare("SELECT SUM(total) AS total FROM rm_cost where realisation >= ? and realisation <= ? ");
			#bind Value 
			
				 $query->bindValue(1, $start);
				 $query->bindValue(2, $end);
				 
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
		
		public function GetInvestCost($start,$end){ 
			
		$query = $this->db->prepare("SELECT SUM(total) AS total FROM rm_costinvest where realisation >= ? and realisation <= ? ");
			#bind Value 
			
				 $query->bindValue(1, $start);
				 $query->bindValue(2, $end);
				 
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
			
		public function GetCurrentRealization($start,$end){
		
		
/* 			$idactive = $this->GetActivePlanPeriode();
			
			$activeplns = $this->GetPlanperiode($idactive);
			
			foreach($activeplns as $activepln){
				$start=$activepln['start'];
				$end=$activepln['end'];
			} */
			
			$nil1=$this->GetTrainingCost($start,$end);
			$nil2=$this->GetInvestCost($start,$end);
			
			
			return $nil1 + $nil2 ;
			
		}
		
		public function SumTrainingCost($periode){
			
		$query = $this->db->prepare("SELECT SUM(total) AS total FROM rm_training where periode = ? ");
			#bind Value 
			
				 $query->bindValue(1, $periode);

				 
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
		public function SumInvestCost($periode){
			
		$query = $this->db->prepare("SELECT SUM(total) AS total FROM rm_traininginvest where periode = ? ");
			#bind Value 
			
				 $query->bindValue(1, $periode);

				 
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

		public function GetTotalPlanBudget($periode){
			
			$nil1=$this->SumTrainingCost($periode);
			$nil2=$this->SumInvestCost($periode);
			
			
			return $nil1 + $nil2 ;	
			
		}
		
		public function GetPlanPerPerson($idUser,$periode){

			$idUser="%," . $idUser ."%" ;
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_training`  where peserta  LIKE ? and  periode = ? ORDER BY `id` DESC ");
			$query->bindValue(1, $idUser);
			$query->bindValue(2, $periode);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
			
		}
		
		public function custom_number_format($num){
		  $x = round($num);
		  $x_number_format = number_format($x);
		  $x_array = explode(',', $x_number_format);
		  $x_parts = array(' K', ' M', ' B', ' T');
		  $x_count_parts = count($x_array) - 1;
		  $x_display = $x;
		  $x_display = $x_array[0] . ((int) $x_array[1][0] !== 0 ? '.' . $x_array[1][0] : '');
		  $x_display .= $x_parts[$x_count_parts - 1];
		  return $x_display;			
		}
		

		public function Insertbank($inputan, $background, $objective, $resource, $mark ,$oleh){

		$query 	= $this->db->prepare("INSERT INTO `rm_bank_research` (inputan, background, objective, resource, mark ,oleh) VALUES (?, ?, ?, ?, ?, ?) ");
	 
		$query->bindValue(1, $inputan);
		$query->bindValue(2, $background);
		$query->bindValue(3, $objective);
		$query->bindValue(4, $resource);
		$query->bindValue(5, $mark);
		$query->bindValue(6, $oleh);


		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function DellbankResearch($id){
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_bank_research` WHERE `rm_bank_research`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
		
	}
	
	public function getbankdata(){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_bank_research  order by id DESC");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	
	
	
	}

	public function InsertPlanResearch($judul, $objective, $type, $dana, $peneliti ,$resource,$software,$periode,$prioritas,$ket,$oleh){

		$query 	= $this->db->prepare("INSERT INTO `rm_planresearch` (judul, objective, type, dana, peneliti ,resource,software,periode,prioritas,ket, oleh) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?) ");
	 
		$query->bindValue(1, $judul);
		$query->bindValue(2, $objective);
		$query->bindValue(3, $type);
		$query->bindValue(4, $dana);
		$query->bindValue(5, $peneliti);
		$query->bindValue(6, $resource);
		$query->bindValue(7, $software);
		$query->bindValue(8, $periode);
		$query->bindValue(9, $prioritas);
		$query->bindValue(10, $ket);
		$query->bindValue(11, $oleh);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function DellPlanResearch($id){
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_planresearch` WHERE `rm_planresearch`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
		
	}
	
	public function getPlanResearch(){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_planresearch  order by id DESC");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	
	
	
	}

	public function InsertResultResearch($judul, $hasil, $type, $peneliti ,$periode,$followup,$ket,$oleh){

		$query 	= $this->db->prepare("INSERT INTO `rm_resultresearch` (judul, hasil, type, peneliti ,periode,followup,ket,oleh) VALUES (?, ?, ?, ?, ?, ?, ?, ?) ");
	 
		$query->bindValue(1, $judul);
		$query->bindValue(2, $hasil);
		$query->bindValue(3, $type);
		$query->bindValue(4, $peneliti);
		$query->bindValue(5, $periode);
		$query->bindValue(6, $followup);
		$query->bindValue(7, $ket);
		$query->bindValue(8, $oleh);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function DellResultResearch($id){
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_resultresearch` WHERE `rm_resultresearch`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
		
	}
	
	public function getResultResearch(){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_resultresearch  order by id DESC");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	
	
	
	}
	
	
	
		public function InsertProposal($judul, $peneliti,$status,$start,$end,$approve,$proposal,$cost,$oleh,$type){
		$update_on= date("Y-m-d H:i:s");
		$query 	= $this->db->prepare("INSERT INTO `rm_proposal` (judul, peneliti,status,start,end,approve,proposal,cost,oleh,type,update_on ,update_by) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?) ");
	 
		$query->bindValue(1, $judul);
		$query->bindValue(2, $peneliti);
		$query->bindValue(3, $status);
		$query->bindValue(4, $start);
		$query->bindValue(5, $end);
		$query->bindValue(6, $approve);
		$query->bindValue(7, $proposal);
		$query->bindValue(8, $cost);
		$query->bindValue(9, $oleh);
		$query->bindValue(10, $type);
		$query->bindValue(11, $update_on);
		$query->bindValue(12, $oleh);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function Dellproposal($id){
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_proposal` WHERE `rm_proposal`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
		
	}
	
	public function getproposal(){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_proposal  order by id DESC");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	
	
	
	}
	
	public function getproposalbyID($id){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM rm_proposal  where id= ? order by id DESC");
			
			$query->bindValue(1, $id);
			
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

	}
	
	public function updateProposalId($judul,$peneliti,$start,$end,$cost,$id, $type){
	

		
		$query 	= $this->db->prepare("UPDATE rm_proposal SET judul = ? ,peneliti =?,start = ?,end = ?,cost =?  ,type =? where id= ? ");
	 
	 
		$query->bindValue(1, $judul);
		$query->bindValue(2, $peneliti);
		$query->bindValue(3, $start);
		$query->bindValue(4, $end);

		$query->bindValue(5, $cost);
		$query->bindValue(6, $type);
		
		$query->bindValue(7, $id);
 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}	

	public function updateProposalStatusId($approve,$status,$id){
	

		
		$query 	= $this->db->prepare("UPDATE rm_proposal SET approve = ? ,status =?   where id= ? ");
	 
	 
		$query->bindValue(1, $approve);
		$query->bindValue(2, $status);

		$query->bindValue(3, $id);
 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}		
	public function updateProposalDescriponlyId($proposal,$id,$userid){
	
		$update_on= date("Y-m-d H:i:s");
		
		$query 	= $this->db->prepare("UPDATE rm_proposal SET proposal = ?  , update_on= ?, update_by = ? where id= ? ");
	 
	
		$query->bindValue(1, $proposal);
		$query->bindValue(2, $update_on);
		$query->bindValue(3, $userid);
		$query->bindValue(4, $id);
 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	
	
		public function InsertCommentProposal($text ,	$oleh ,		$proposal_id){
		$created_on= date("Y-m-d H:i:s");
		
		$query 	= $this->db->prepare("INSERT INTO `rm_commentprop` (text ,	oleh ,	created_on ,	proposal_id  ) VALUES (?, ?, ?, ?) ");
	 
		$query->bindValue(1, $text);
		$query->bindValue(2, $oleh);
		$query->bindValue(3, $created_on);
		$query->bindValue(4, $proposal_id);


		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function DellCommentproposal($id){
		
		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_commentprop` WHERE `rm_commentprop`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
		
	}
	
	public function getCommentproposal($id){
	
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT c.text, c.id , c.created_on  , rm_biodata.path,c.oleh FROM `rm_commentprop` c LEFT JOIN  rm_biodata ON c.oleh =  rm_biodata.id_user
where c.proposal_id =? ORDER BY c.created_on ASC");
			
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
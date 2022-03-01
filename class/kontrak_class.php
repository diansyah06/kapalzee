<?php
class kontrak{

private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
	public function Create_kontrak($noKontrak, $class_id, $lokasi, $builder, $submited, $linker, $dates, $nama, $status, $due_date, $finish, $vessel){
	
		$year_kon= substr($noKontrak, 0, 2);  // ambil dua digit
		$tipe_kon= substr($noKontrak, 2, 2);  // ambil dua digit
		$num_kom= substr($noKontrak, 6, 10);  // ambil dua digit
		$cb_kon= substr($noKontrak, 4, 2);  // ambil dua digit
		
	 
		$query 	= $this->db->prepare("INSERT INTO `og_kon_trak` (id_kontrak, year_kon, tipe_kon, num_kom, cb_kon, class_id, lokasi, builder, submited, linker, dates, nama, status, due_date, finish, vessel) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?) ");
	 
		$query->bindValue(1, $noKontrak);
		$query->bindValue(2, $year_kon);
		$query->bindValue(3, $tipe_kon);
		$query->bindValue(4, $num_kom);
		$query->bindValue(5, $cb_kon);
		$query->bindValue(6, $class_id);
		$query->bindValue(7, $lokasi);
		$query->bindValue(8, $builder);
		$query->bindValue(9, $submited);
		$query->bindValue(10, $linker);
		$query->bindValue(11, $dates);
		$query->bindValue(12, $nama);
		$query->bindValue(13, $status);
		$query->bindValue(14, $due_date);
		$query->bindValue(15, $finish);
		$query->bindValue(16, $vessel);
	 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function edit_kontrak($noKontrak, $class_id, $lokasi, $builder, $submited, $linker, $dates, $nama, $status, $due_date, $finish, $vessel,$id_kon){
	
		$year_kon= substr($noKontrak, 0, 2);  // ambil dua digit
		$tipe_kon= substr($noKontrak, 2, 2);  // ambil dua digit
		$num_kom= substr($noKontrak, 6, 10);  // ambil dua digit
		$cb_kon= substr($noKontrak, 4, 2);  // ambil dua digit
		
	 
		$query 	= $this->db->prepare("UPDATE og_kon_trak SET id_kontrak= ? , year_kon= ? , tipe_kon= ? , num_kom= ? , cb_kon= ? , class_id= ? , lokasi= ? , builder= ? , submited= ? , linker= ? , dates= ? , nama= ? , status= ? , due_date= ? , finish= ? , vessel = ?  where id= ?");
	 
	 
	 
		$query->bindValue(1, $noKontrak);
		$query->bindValue(2, $year_kon);
		$query->bindValue(3, $tipe_kon);
		$query->bindValue(4, $num_kom);
		$query->bindValue(5, $cb_kon);
		$query->bindValue(6, $class_id);
		$query->bindValue(7, $lokasi);
		$query->bindValue(8, $builder);
		$query->bindValue(9, $submited);
		$query->bindValue(10, $linker);
		$query->bindValue(11, $dates);
		$query->bindValue(12, $nama);
		$query->bindValue(13, $status);
		$query->bindValue(14, $due_date);
		$query->bindValue(15, $finish);
		$query->bindValue(16, $vessel);
		$query->bindValue(17, $id_kon);
	 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	
	
	public function update_kontrak_linker($linker, $id_kon){
	
		$query 	= $this->db->prepare("UPDATE og_kon_trak SET  linker= ?   where id= ?");
	 
		$query->bindValue(1, $linker);
		$query->bindValue(2, $id_kon);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}


	public function delete_kontrak($id,$no_kontrak){

		$query 	= $this->db->prepare("DELETE FROM `og_kon_trak` WHERE `og_kon_trak`.`id` = ? and id_kontrak= ? LIMIT 1");
		$query->bindValue(1, $id);
		$query->bindValue(2, $no_kontrak);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	


	}

	public function get_kontrak() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_kon_trak`  ORDER BY `id` DESC");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_kontrak_id($id_proj) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_kon_trak`  where id= ?  ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id_proj);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
	public function get_Position_proj() {
	
	#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_team_jabatan`  ORDER BY `id` DESC");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}


	
	public function Create_proj_team($id_proj, $id_user, $tanggal, $jabatan,$permission){
	
		$query 	= $this->db->prepare("INSERT INTO `og_team` (`id_project`, `id_user`, `dates`, `proj_jabatan`,`permission`) VALUES (?, ?, ?, ?,?) ");

		$query->bindValue(1, $id_proj);
		$query->bindValue(2, $id_user);
		$query->bindValue(3, $tanggal);
		$query->bindValue(4, $jabatan);
		$query->bindValue(5, $permission);
		
	 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}	
	public function updateProjectteam($id_user, $proj_jabatan,$id_project){
	
		$query 	= $this->db->prepare("UPDATE og_team SET proj_jabatan= ? where id_user= ?  and id_project=? ");

		$query->bindValue(1, $proj_jabatan);
		$query->bindValue(2, $id_user);
		$query->bindValue(3, $id_project);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function insert_linker($nama){
	
		$query 	= $this->db->prepare("INSERT INTO `og_kon_linker` (`nama_master`) VALUES (?) ");

		$query->bindValue(1, $nama);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
	public function delete_proj_team($id_user,$id_project){

		$query 	= $this->db->prepare("DELETE FROM `og_team` WHERE `og_team`.`id_user` = ? and id_project= ? LIMIT 1 ");
		$query->bindValue(1, $id_user);
		$query->bindValue(2, $id_project);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	


	}
	
	public function delete_proj_Allteam($id_project){

		$query 	= $this->db->prepare("DELETE FROM `og_team` WHERE id_project= ? ");

		$query->bindValue(1, $id_project);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	


	}
	
	public function get_proj_team($id_project) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_team`  where id_project= ? ORDER BY `id` DESC");
			$query->bindValue(1, $id_project);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		public function lastInsertId(){
		return $this->db->lastInsertId();
		}
		
		public function get_autosugest_gambar($nama_kont) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_kon_trak` where nama like ?  ORDER BY `id` DESC limit 10");
			$query->bindValue(1, $nama_kont);
			
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function Insertcostproject($nam, $cost, $currency, $tipeKegiatan, $idKegiatan ,$decription,	$realisation,$idr,$kurs, $total,$user, $file="none"){
		$tanggal = date("Y-m-d H:i:s", strtotime($tanggal));
		if ($realisation!=""){
		$realisation= date("Y-m-d H:i:s", strtotime($realisation));
		}
		$query 	= $this->db->prepare("INSERT INTO `rm_costproject` (nam, cost, currency, tipeKegiatan, idKegiatan ,decription,	realisation,idr,kurs,total,user,file  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?,?,?,?,?) ");
	 
		$query->bindValue(1, $nam);
		$query->bindValue(2, $cost);
		$query->bindValue(3, $currency);
		$query->bindValue(4, $tipeKegiatan);
		$query->bindValue(5, $idKegiatan);
		$query->bindValue(6, $decription);
		$query->bindValue(7, $realisation);
		$query->bindValue(8, $idr);
		$query->bindValue(9, $kurs);
		$query->bindValue(10, $total);		
		$query->bindValue(11, $user);
		$query->bindValue(12, $file);		

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}
	
		public function getCostprojectbyid($idproject,$typeprject) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_costproject` where tipeKegiatan=? and idKegiatan= ?  ORDER BY `id` DESC ");
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

	public function dellCostproject($id) {
		
		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_costproject` WHERE `rm_costproject`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	
		public function getCostprojectbyidid($idcost) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_costproject` where id= ?  ORDER BY `id` DESC ");
			$query->bindValue(1, $idcost);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function sumCostPro($idProj,$tipeKegiatan){
		
		$query = $this->db->prepare("SELECT  SUM(`total`) AS total  FROM `rm_costproject` WHERE `tipeKegiatan`=? and idKegiatan=? ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $tipeKegiatan);
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
		public function sumCostAllPro($tipeKegiatan,$year){
		
		$query = $this->db->prepare("SELECT  SUM(`total`) AS total  FROM `rm_costproject` WHERE `tipeKegiatan`=? and year(realisation)=? ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $tipeKegiatan);
				$query->bindValue(2, $year);
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

		public function getCostprojectTheyear($idproject,$year) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_costproject` where   idKegiatan= ? and year(realisation)=?  ORDER BY `id` ASC ");

			$query->bindValue(1, $idproject);
			$query->bindValue(2, $year);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}		
		public function getCostAllprojectTheyear($year) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_costproject` where year(realisation)=? ORDER BY idKegiatan, `realisation` ASC ");


			$query->bindValue(1, $year);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function getClientlist() {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_client` ORDER BY `aka` asc ");


			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}			
		public function getClientlistid($id) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_client`  where id_client = ? ORDER BY `id_client` desc ");

			$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}	
		public function insertClient($nick,$sandi ,	$garam ,	$user ,	$aka,$email,$tlp,$company,$hp){
		$tanggal = date("Y-m-d H:i:s");
		$locked=0;

		$query 	= $this->db->prepare("INSERT INTO `rm_client` (nick,sandi,garam,user,locked,aka,tanggal,email,company,office,hp ) VALUES (?, ?, ?, ?, ?, ?, ?,?,?,?,?) ");
	 
		$query->bindValue(1, $nick);
		$query->bindValue(2, $sandi);
		$query->bindValue(3, $garam);
		$query->bindValue(4, $user);
		$query->bindValue(5, $locked);
		$query->bindValue(6, $aka);
		$query->bindValue(7, $tanggal);
		$query->bindValue(8, $email);
		$query->bindValue(9, $company);
		$query->bindValue(10, $tlp);
		$query->bindValue(11, $hp);	

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}
		public function dellClient($id) {
		
		$query 	= $this->db->prepare("DELETE FROM `rm_client` WHERE `rm_client`.`id_client` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
		public function update_passClientuser($id_client, $sandi,$garam){
	
		$query 	= $this->db->prepare("UPDATE rm_client SET  sandi= ? ,garam=?  where id_client= ?");
	 
		$query->bindValue(1, $sandi);
		$query->bindValue(2, $garam);
		$query->bindValue(3, $id_client);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function update_infoClientuser($id_client, $aka,$nick,$email,$kolabolator=0){
	
		$query 	= $this->db->prepare("UPDATE rm_client SET  nick= ? ,aka=? ,email=? ,kolabolator =? where id_client= ?");
	 
		$query->bindValue(1, $nick );
		$query->bindValue(2, $aka);
		$query->bindValue(3, $email);
		$query->bindValue(4, $kolabolator);
		$query->bindValue(5, $id_client);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	public function update_lockClientuser($id_client, $lock){
	
		$query 	= $this->db->prepare("UPDATE rm_client SET  locked= ?  where id_client= ?");
	 
		$query->bindValue(1, $lock);
		$query->bindValue(2, $id_client);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
		public function insertClientassosiated($proj_id,$oleh,$id_client,$builder,$colabortorr){
		$tanggal = date("Y-m-d H:i:s");


		$query 	= $this->db->prepare("INSERT INTO `rm_proj_asosiated` (proj_id,oleh,`date`,id_client,groupteam,colaborator ) VALUES (?, ?, ?, ?,?,?) ");
	 
		$query->bindValue(1, $proj_id);
		$query->bindValue(2, $oleh);
		$query->bindValue(3, $tanggal);
		$query->bindValue(4, $id_client);
		$query->bindValue(5, $builder);
		$query->bindValue(6, $colabortorr);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}
		public function dellClientassosiated($id) {
		
		$query 	= $this->db->prepare("DELETE FROM `rm_proj_asosiated` WHERE `rm_proj_asosiated`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

		public function getClientlistassosiatedid($id) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT p.id ,p.id_client,w.object_id, w.project,w.starting,w.due,w.progress,w.id_kontrak,w.class_id ,p.colaborator , p.groupteam FROM `rm_proj_asosiated` p  left join rm_workspaces w on w.object_id=p.proj_id  where p.id_client = ? order by p.id desc");

			$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
	public function GetjabatanteamUser($idProj, $id_user){
	
		$query = $this->db->prepare("SELECT  proj_jabatan  FROM `og_team` WHERE `id_project`=? and id_user=? limit 1 ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $idProj);
				$query->bindValue(2, $id_user);
				 $query->bindColumn('proj_jabatan', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {
					
					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;
		
	}
			public function get_permisionlist($type) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_menupermission`  where type= ?  ORDER BY `id` ASC ");
			$query->bindValue(1, $type);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
	public function get_proj_teambyID($id_project,$iduser) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_team`  where id_project= ? and id_user = ? limit 1");
			$query->bindValue(1, $id_project);
			$query->bindValue(2, $iduser);
			$query->bindColumn('permission', $hak);
			try{
				$query->execute();
				
					$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {
					
					}
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $hak ;
		}
	public function updateProjectteamPermission($id_user, $proj_jabatan,$id_project,$permission){
	
		$query 	= $this->db->prepare("UPDATE og_team SET proj_jabatan= ?, permission=? where id_user= ?  and id_project=? ");

		$query->bindValue(1, $proj_jabatan);
		$query->bindValue(2, $permission);
		$query->bindValue(3, $id_user);
		$query->bindValue(4, $id_project);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	public function get_proj_PM_project($id_project,$lead=59) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_team`  where id_project= ? and proj_jabatan = ? limit 1");
			$query->bindValue(1, $id_project);
			$query->bindValue(2, $lead);

			 $query->bindColumn('id_user', $hak);
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

	public function getClientOfProject($proj)
	{
		#preparing a statement that will select all the registered users, with the most recent ones first.
		$query = $this->db->prepare("SELECT id_client FROM `rm_proj_asosiated` where proj_id= ?");
		$query->bindValue(1, $proj);
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
		 
		# We use fetchAll() instead of fetch() to get an array of all the selected records.
		return $query->fetchAll();
	}



	public function GetjabatanbyName_a_Like($id_jabatan, $strjabatan){
	
		$query = $this->db->prepare("SELECT  nama  FROM `og_team_jabatan` WHERE `id`=?  limit 1 ");
			#bind Value 
			#bind Value 
				$query->bindValue(1, $id_jabatan);
				 $query->bindColumn('nama', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {
					
					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		

		if ( strstr( $hak, $strjabatan ) ) {
		   return true ;
		} else {
		  return false ;
		}

		
	}
	public function GetuserOnProject( $projid){
			
			$query = $this->db->prepare("SELECT pj.id, pj.proj_id,pj.`groupteam`,pj.`colaborator`,c.aka,c.email,c.company,c.hp, c.id_client FROM `rm_proj_asosiated` pj left join rm_client c on pj.id_client=c.id_client where   pj.`proj_id` =?");
			$query->bindValue(1, $projid);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

			
		}

	public function getMailNumber($idproj, $date, $type=0)
	{
		#preparing a statement that will select all the registered users, with the most recent ones first.
		$query = $this->db->prepare("SELECT mail_number FROM `rm_mail_number` where proj_id= ? and type=? and date(created_at)=?");
		$query->bindValue(1, $idproj);
		$query->bindValue(2, $type);
		$query->bindValue(3, $date);
		$query->bindColumn('mail_number', $num);
		try{
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_BOUND)) {
			
			}
		}catch(PDOException $e){
			die($e->getMessage());
		}

		if(empty($num))
		{
			$out = array('exists'=>false, 'data'=>"");
		}else
		{
			$out = array('exists'=>true, 'data'=>$num);
		}
		
		return $out;
	}

	public function insertMailNumber($projid, $number, $type=0)
	{
		$query 	= $this->db->prepare("INSERT INTO `rm_mail_number` (proj_id, type, mail_number) VALUES (?,?,?) ");
		$query->bindValue(1, $projid);
		$query->bindValue(2, $type);
		$query->bindValue(3, $number);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function getMailById($id)
	{
		$query 	= $this->db->prepare("SELECT * FROM `rm_mail_aggregate` WHERE id = ?");
		$query->bindValue(1, $id);
			
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
		}
		 
		# We use fetchAll() instead of fetch() to get an array of all the selected records.
		return $query->fetchAll();
	}

	public function getMailByDate($proj, $type, $sendDate)
	{
		$query 	= $this->db->prepare("SELECT * FROM `rm_mail_aggregate` WHERE proj_id = ? AND type = ? AND date(created_at) = ? ");
		$query->bindValue(1, $proj);
		$query->bindValue(2, $type);
		$query->bindValue(3, $sendDate);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}

		return $query->fetchAll();
	}

	//this function will insert mail or updating it when the mail for the designated date already exists
	public function insertMail($proj, $type, $mailBody, $number, $fullNumber)
	{
		$query 	= $this->db->prepare("INSERT INTO `rm_mail_aggregate` (proj_id, type, mail_body, mail_number, mail_number_full) VALUES (?,?,?,?,?) ");
		$query->bindValue(1, $proj);
		$query->bindValue(2, $type);
		$query->bindValue(3, $mailBody);
		$query->bindValue(4, $number);
		$query->bindValue(5, $fullNumber);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function updateMail($proj, $type, $mailBody, $number, $fullNumber, $id)
	{
		$query 	= $this->db->prepare("UPDATE `rm_mail_aggregate` SET proj_id=?, type=?, mail_body=?, mail_number=?, mail_number_full=? WHERE id = ?");
		$query->bindValue(1, $proj);
		$query->bindValue(2, $type);
		$query->bindValue(3, $mailBody);
		$query->bindValue(4, $number);
		$query->bindValue(5, $fullNumber);
		$query->bindValue(6, $id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function insertOrUpdateMail($proj, $type, $mailBody, $sendDate, $number, $fullNumber)
	{
		$mails = $this->getMailByDate($proj, $type, $sendDate);

		if(empty($mails))
		{
			$this->insertMail($proj, $type, $mailBody, $number, $fullNumber);
			return "mail inserted";
		}else
		{
			foreach($mails as $m)
			{
				$id = $m['id'];
				$this->updateMail($proj, $type, $mailBody, $number, $fullNumber, $id);
				return "mail id $id updated";
			}
		}
	}


		public function get_proj_PM_projectjabatan($id_project,$id_user) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_team`  where id_project= ? and id_user = ? limit 1");
			$query->bindValue(1, $id_project);
			$query->bindValue(2, $id_user);

			 $query->bindColumn('proj_jabatan', $hak);
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
	
}
?>
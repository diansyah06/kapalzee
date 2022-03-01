<?php
class Users{
 
		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}

		public function lastInsertId(){
			return $this->db->lastInsertId();
		}
 
		#get user kecuali super Administrator
		public function get_users() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_user` where previl != 9 ORDER BY `nama` ASC");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		public function get_Active_users() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_user` where previl != 9  and  noactive = 0 ORDER BY `previl` DESC");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}		
		public function get_users_id($id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_user` where previl != 9  and id_user = ? ORDER BY `previl` DESC");
			$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_users_nup($nup) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_user` where previl != 9  and  id_pegawai = ? ORDER BY `previl` DESC");
			$query->bindValue(1, $nup);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_users_with_title($id) {
		
		$nama_ketu= $this->get_users_id($id);

			foreach ($nama_ketu as $nama_ket) {

			$nama_nya= $nama_ket['nama'];

			}
		
		$query = $this->db->prepare("SELECT * FROM `rm_biodata` where  id_user = ? ");
		
		$query->bindValue(1, $id);
		
			$query->bindColumn('dpn', $hak);
			$query->bindColumn('blk', $hak2);
			try{
				$query->execute();
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
					
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak . " " .  $nama_nya . " " . $hak2;
		
		}
		
		public function getUser_biodata($id_user){
		
		$query = $this->db->prepare("SELECT og_user.nama,og_user.nick, og_user.id_pegawai,og_user.email , rm_biodata.jabatan ,	rm_biodata.alamat 	, 	rm_biodata.ym ,	rm_biodata.fb 	,rm_biodata.handphone ,	rm_biodata.tujuan ,	rm_biodata.edukasi ,rm_biodata.pekerjaan ,	rm_biodata.path ,	rm_biodata.dpn , 	rm_biodata.blk 
		FROM `rm_biodata` LEFT JOIN og_user ON rm_biodata.id_user = og_user.id_user    where rm_biodata.id_user = ? limit 1 ");
				#bind Value 
				$query->bindValue(1, $id_user);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		}
		
		
		public function get_jabatan() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_team_jabatan`  ");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		#get user by previlage
		public function get_users_by_previl($previl) {
		 
			
			$query = $this->db->prepare("SELECT * FROM `og_user` where previl != 9 and previl = ? ORDER BY `previl` DESC");
				#bind Value 
				$query->bindValue(1, $previl);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		#update passwords
		public function Update_passwords($id , $previl , $hash_password) {
		 
		 if ($id!=1){
			
					$query = $this->db->prepare("UPDATE `og_user` SET `sandi` = ? WHERE `id_user` = ?");
					
					$query->bindValue(1, $hash_password);
					$query->bindValue(2, $id);	
					$query->execute();
					return true ; #Suksess

				try{
					$query->execute();
				}catch(PDOException $e){
					die($e->getMessage());
					
				}
				 
			
				
			}else {
					#cek previlage super
				if  ($previl==9){ 
						$query = $this->db->prepare("UPDATE `users` SET `confirmed` = ? WHERE `email` = ?");
						
						$query->bindValue(1, $hash_password);
						$query->bindValue(2, $id);	
						$query->execute();

					try{
						$query->execute();
						return true ; #Suksess
					}catch(PDOException $e){
						die($e->getMessage());
						
					}
				
				
				
				}else {
				return false ; #hanya super yang bisa mengganti super password
				}
			
			
			
			}
		}


		#Get  previlage
		public function Get_previlage($id) {
			
			$query = $this->db->prepare("SELECT previl FROM `og_user` where id_user = ? limit 1");
				#bind Value 
				$query->bindValue(1, $id);
				
				 $query->bindColumn('previl', $hak);

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
		#Get  previlage
		public function Get_previlagebynick($nick) {
			
			$query = $this->db->prepare("SELECT previl FROM `og_user` where nick = ? or email = ?  limit 1");
				#bind Value 
				$query->bindValue(1, $nick);
				$query->bindValue(2, $nick);
				
				 $query->bindColumn('previl', $hak);

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
		
				#Get  email
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
		
		public function cek_super_user($id_user){
			
			$prev=$this->Get_previlage($id_user);
			
			if ($prev==9){
			
				return true;
			}else 
			{
				return false;
				}
		}
		
		public function cek_vp_user($id_user){
			
			$prev=$this->Get_previlage($id_user);
			
			if ($prev==6){
			
				return true;
			}else 
			{
				return false;
				}
		}
		
		public function cek_man_user($id_user){
			
			$prev=$this->Get_previlage($id_user);
			
			if ($prev >= 5){
			
				return true;
			}else 
			{
				return false;
				}
		}
		
		
		
		
		
		public function Get_kuasa_by_jabatn($id_jabatan) {
			
			$query = $this->db->prepare("SELECT * FROM `og_kuasa` where id_jabatan = ? limit 1");
				#bind Value 
				$query->bindValue(1, $id_jabatan);

			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		
		
		public function Get_akses_kont_id($id,$id_kon) {
			
			$query = $this->db->prepare("SELECT * FROM `og_team` where id_user = ?  and id_project = ? limit 1");
				#bind Value 
				$query->bindValue(1, $id);
				$query->bindValue(2, $id_kon);

			try{
				$query->execute();
				$count = $query->rowCount();
				
				if ($count > 0) {
					return true ;} 
				else {
					return false;}
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		}
		
		public function Get_team_by_id($id_user,$id_proj) {
			
			$query = $this->db->prepare("SELECT * FROM `og_team` where id_user = ? and id_project = ? limit 1");
				#bind Value 
				$query->bindValue(1, $id_user);
				$query->bindValue(2, $id_proj);

			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		
		public function cek_team_by_id($id_user,$id_proj) {
			
			$query = $this->db->prepare("SELECT * FROM `og_team` where id_user = ? and id_project = ? limit 1");
				#bind Value 
				$query->bindValue(1, $id_user);
				$query->bindValue(2, $id_proj);

			try{
				$query->execute();
				$count = $query->rowCount();
				
				if ($count > 0) {
					return true ;} 
				else {
					return false;}
					
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		}
		
		
		public function hak_akses_page($user_id,$id_kont) {

			if ($this->cek_super_user($user_id)) { //cek super
				return true;
			} 
			else {
				if ($this->cek_vp_user($user_id)) { //cek vp
					return true;
				
				} 
				else {
						if ($this->cek_man_user($user_id)) { // cek manager
							return true;
						
						}else {
						
							if ($this->cek_team_by_id($user_id,$id_kont)){ //cek page allow to user
								return true;
							
							}else {
								return false;
							
							}		
						}
					}
				}
		}
		
		public function hak_akses_page_manager($user_id,$id_kont) {

			if ($this->cek_super_user($user_id)) { //cek super
				return true;
			} 
			else {
				if ($this->cek_vp_user($user_id)) { //cek vp
					return true;
				
				} 
				else {
						if ($this->cek_man_user($user_id)) { // cek manager
							return true;
						
						}else {
							return false;
							
						}
					}
				}
		}
		
		public function Insert_lost_password($id_user,$time,$random_num){

		$query 	= $this->db->prepare("INSERT INTO `lost_password` (id_user, time, random_num) VALUES (?,?,?) ");
	 
		$query->bindValue(1, $id_user);
		$query->bindValue(2, $time);
		$query->bindValue(3, $random_num);
		

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}
		
		
		public function find_hash_code($hash_code) {
		
		   $now = time();
			// All login attempts are counted from the past 2 hours. 
			$valid_attempts = $now - (2 * 60 * 60); 
			
			$query = $this->db->prepare("SELECT id FROM `lost_password` where  random_num = ? and time>? order by id DESC limit 1");
				#bind Value 
			
				$query->bindValue(1, $hash_code);
				$query->bindValue(2, $valid_attempts);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			$jml = $query->rowCount();
			
				if($jml == 1) { 
				
					return true;
		
				}else{
				
					return false;
				
				}
		
		}
		
		 public function get_id_user_hash($random_num) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `lost_password` where random_num = ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $random_num);
			
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
		
		public function delete_token($random_num){

		$query 	= $this->db->prepare("DELETE FROM `lost_password` WHERE `lost_password`.`random_num` = ?  LIMIT 1");
		$query->bindValue(1, $random_num);
	
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}
	
	public function delete_token_expired(){
	$now = time();
	$valid_attempts = $now - (2 * 60 * 60); 
	
		$query 	= $this->db->prepare("DELETE FROM `lost_password` WHERE `lost_password`.`time` < ?  LIMIT 1");
		$query->bindValue(1, $valid_attempts);
	
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}
	
	public function unlockUser($id) {
	
	$query = $this->db->prepare("UPDATE `og_user` SET `locked` = 0 WHERE `id_user` = ?");
					
					$query->bindValue(1, $id);

					$query->execute();
					$this->DelTimeStamp($id);

				try{
					$query->execute();
				}catch(PDOException $e){
					die($e->getMessage());
					
				}
	
	}

	
	public function DelTimeStamp($id) {
	
   $now = time();
   // All login attempts are counted from the past 2 hours. 
   $valid_attempts = $now - (2 * 60 * 60); 
	
		
		$query 	= $this->db->prepare("DELETE FROM `login_attempts` WHERE `time` > ?  and user_id = ?  ");
		$query->bindValue(1, $valid_attempts);
		$query->bindValue(2, $id);
	
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	
	
	
	}
	
	public function lastLogin($iduser){
	
	$query = $this->db->prepare("SELECT * FROM `login_attempts` where user_id = ?  order by `time` desc limit 1");
		
		$query->bindValue(1, $iduser);
		
			$query->bindColumn('time', $hak);

			try{
				$query->execute();
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
					
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			
			
		$tanggal=date("d M Y",$hak);
		
		return  $tanggal;
	
	
	}
	public function cekpagePrevilage($iduser,$pagenum){
	
				$query = $this->db->prepare("SELECT id FROM `rm_pagepermis` where  id_user = ? and pagenum 	= ? order by id DESC limit 1");
				#bind Value 
			
				$query->bindValue(1, $iduser);
				$query->bindValue(2, $pagenum);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			$jml = $query->rowCount();
			
				if($jml == 1) { 
				
					return true;
		
				}else{
				
					return false;
				
				}
	
	}
	
	public function cekSecuritypeage($iduser,$pagenum){
	
	$previlage = $this->Get_previlage($iduser);
	
		if ($previlage < 4 ){
			if ($this->cekpagePrevilage($iduser,$pagenum)== true){
			
			
			}else {
			
			 echo "<script type='text/javascript'>
				<!--
				window.location = 'panel.php?module=home'
				//-->
				</script>"; 
 
			 die;
			
			}
	}
	
	}
	
	public function getOgsteam($idproject){
		
		$query = $this->db->prepare("SELECT og_user.tlp, og_user.id_user, og_user.nama,og_user.nick, og_user.id_pegawai,og_user.email ,rm_biodata.path,og_team_jabatan.nama as posisi from og_user left join og_team on og_user.id_user=og_team.id_user left join og_team_jabatan ON og_team.proj_jabatan=og_team_jabatan.id left join rm_biodata ON rm_biodata.id_user=og_user.id_user 

where og_team.id_project=?");
				#bind Value 
				$query->bindValue(1, $idproject);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();		
		
	}
	
	//function to update biodata in database
	//made by rizky
	//Update:
	//1. 01/29/2018 --> initial (rizky)
	public function updateBiodata($id, $position, $email, $phone, $address, $othermail, $facebook, $path)
	{
		$query = $this->db->prepare("UPDATE rm_biodata SET jabatan = ?, email = ?, handphone = ?, alamat = ?,
									 ym = ?, fb = ?, path = ? WHERE id_user = ?");
		$query->bindValue(1, $position);
		$query->bindValue(2, $email);
		$query->bindValue(3, $phone);
		$query->bindValue(4, $address);
		$query->bindValue(5, $othermail);
		$query->bindValue(6, $facebook);
		$query->bindValue(7, $path);
		$query->bindValue(8, $id);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
			
		}
		
	}
	
	//function to update individual entry of user data in database
	//made by rizky
	//Update
	//1. 01/29/2018 --> initial (rizky)
	public function updateDataSingle($db, $field, $value, $id)
	{
		$query = $this->db->prepare("UPDATE $db SET $field = ? WHERE id_user = ?");
		$query->bindValue(1, $value);
		$query->bindValue(2, $id);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
			
		}
	}



	//function to insert new user
	//made by rizky
	//Update:
	//1. 03/18/2019 --> initial (rizky)
	public function insertUser($nick, $email, $pass, $salt, $name, $nup, $div, $phone, $create)
	{
		$query = $this->db->prepare( "INSERT INTO og_user (nick, email, sandi, garam, nama, id_pegawai, divisi, tlp, dibuat,previl,noactive ) VALUES (?, ?, ?, ?, ? , ?, ?, ?,?,4,1)");
		$query->bindValue(1, $nick);
		$query->bindValue(2, $email);
		$query->bindValue(3, $pass);
		$query->bindValue(4, $salt);
		$query->bindValue(5, $name);
		$query->bindValue(6, $nup);
		$query->bindValue(7, $div);
		$query->bindValue(8, $phone);
		$query->bindValue(9, $create);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
			
		}
	}
	
	//function to make random activation string
	//made by rizky
	//Update:
	//1. 03/19/2019 --> initial (rizky)
	public function generateRandomString($length = 30) {
	    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    return $randomString;
	}

	//function to store activation key
	//made by rizky
	//Update:
	//1. 03/19/2019 --> initial (rizky)
	public function storeKey($nup, $key)
	{
		$query = $this->db->prepare("INSERT INTO og_activation (nup, act_key) VALUES (?,?)");
		$query->bindValue(1, $nup);
		$query->bindValue(2, $key);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
			
		}
	}

	//function to autodel activation key
	//made by rizky
	//Update:
	//1. 03/19/2019 --> initial (rizky)
	public function keyAutodel(){
		#preparing a statement that will select all the registered users, with the most recent ones first.
		$query = $this->db->prepare("DELETE FROM og_activation WHERE created < DATE_SUB(NOW(), INTERVAL 1 HOUR)");
		try{
			$query->execute();
		}catch(PDOException $e){
		die($e->getMessage());
		}
	} 

	//function to delete activation key
	//made by rizky
	//Update:
	//1. 03/19/2019 --> initial (rizky)
	public function keyDel($key){
		#preparing a statement that will select all the registered users, with the most recent ones first.
		$query = $this->db->prepare("DELETE FROM og_activation WHERE act_key = ?");
		$query->bindValue(1, $key);
		try{
			$query->execute();
		}catch(PDOException $e){
		die($e->getMessage());
		}
	}

	//function to auto delete user
	//made by rizky
	//Update:
	//1. 03/19/2019 --> initial (rizky)
	public function userAutodel(){
		#preparing a statement that will select all the registered users, with the most recent ones first.
		$query = $this->db->prepare("DELETE FROM og_user WHERE noactive = 1 AND dibuat < DATE_SUB(NOW(), INTERVAL 1 DAY)");
		$query->bindValue(1,$tanggal);
		try{
			$query->execute();
		}catch(PDOException $e){
		die($e->getMessage());
		}
	}

	//function to get nup from activation key
	//made by rizky
	//Update:
	//1. 03/21/2019 --> initial (rizky)
	public function keyGetNup($key) {
		$query = $this->db->prepare("SELECT nup FROM og_activation where act_key = ?");
		#bind Value 
		$query->bindValue(1, $key);
		$query->bindColumn('nup', $hak);

		try{
			$query->execute();
			while ($row = $query->fetch(PDO::FETCH_BOUND)) {}
		}catch(PDOException $e){
			die($e->getMessage());	
		}
		 
		# We use fetchAll() instead of fetch() to get an array of all the selected records.
		return $hak;
	}

	//function to activate user
	//made by rizky
	//Update:
	//1. 03/21/2019 --> initial (rizky)
	public function userActivate($nup){
		#preparing a statement that will select all the registered users, with the most recent ones first.
		$query = $this->db->prepare("UPDATE og_user SET noactive = 0 WHERE id_pegawai = ?");
		$query->bindValue(1, $nup);
		try{
			$query->execute();
		}catch(PDOException $e){
		die($e->getMessage());
		}
	}

	//function to insert bio
	//made by rizky
	//Update:
	//1. 03/21/2019 --> initial (rizky)
	public function insertBio($id_user)
	{
		$path ="img/user/none.jpg";
		$query = $this->db->prepare( "INSERT INTO rm_biodata (id_user, path  ) VALUES (?,?)");
		$query->bindValue(1, $id_user);
		$query->bindValue(2, $path);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
			
		}
	} 
  
	public function get_previl($id_user) {
		//echo $id_user;
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT previl FROM `og_user` where id_user = ? limit 1");
			$query->bindValue(1, $id_user);
			$query->bindColumn('previl', $hak);
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


		public function editUser($newphone, $newemail, $nup)
	{
		$query = $this->db->prepare("UPDATE og_user SET tlp = ?, email = ? WHERE id_pegawai = ?");
		$query->bindValue(1, $newphone);
		$query->bindValue(2, $newemail);
		$query->bindValue(3, $nup);

		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
			
		}
		
	}

	public function deleteUser($nup){
		#preparing a statement that will select all the registered users, with the most recent ones first.
		$query = $this->db->prepare("DELETE FROM og_user WHERE id_pegawai = ? limit 1 ");
		$query->bindValue(1, $nup);
		try{
			$query->execute();
		}catch(PDOException $e){
		die($e->getMessage());
		}
	}


	public function unlockUserbynup($id) {
	
	$user = $this->get_users_nup($id);
	foreach($user as $us)
	{
		$id_user = $us['id_user'];
	}

	$query = $this->db->prepare("UPDATE `og_user` SET `locked` = 0 WHERE `id_pegawai` = ?");
					
					$query->bindValue(1, $id);

					$query->execute();
					$this->DelTimeStamp($id_user);

				try{
					$query->execute();
				}catch(PDOException $e){
					die($e->getMessage());
					
				}
	
	}

	public function lockUserbynup($id) {
	
	$query = $this->db->prepare("UPDATE `og_user` SET `locked` = 1 WHERE `id_pegawai` = ?");
					
					$query->bindValue(1, $id);

					$query->execute();
					//$this->DelTimeStamp($id);

				try{
					$query->execute();
				}catch(PDOException $e){
					die($e->getMessage());
					
				}
	
	}


	public function Update_passwordsbyNup($hash_password,$garam,$nup) {
			
					$query = $this->db->prepare("UPDATE `og_user` SET `sandi` = ? , garam = ? WHERE `id_pegawai` = ?");
					
					$query->bindValue(1, $hash_password);
					$query->bindValue(2, $garam);	
					$query->bindValue(3, $nup);	

				try{
					$query->execute();
				}catch(PDOException $e){
					die($e->getMessage());
					
				}
			
		}

	public function ogs_Insert($nup, $nama, $email, $phone, $phone2, $addpass, $garam, $jabatan, $status,$div){

		$tanggal=date("d-M-Y");

		$query = $this->db->prepare( "INSERT INTO og_user (nick, email, sandi, garam, nama, id_pegawai, divisi, tlp, dibuat,previl,noactive ) VALUES (?, ?, ?, ?, ? , ?, ?, ?,?,2,1)");
		$query->bindValue(1, $nup);
		$query->bindValue(2, $email);
		$query->bindValue(3, $addpass);
		$query->bindValue(4, $garam);
		$query->bindValue(5, $nama);
		$query->bindValue(6, $nup);
		$query->bindValue(7, $div);
		$query->bindValue(8, $phone);
		$query->bindValue(9, $tanggal);
		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
			
		}

	}

	public function get_users_nupHak($nup) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_user` where previl != 9  and  id_pegawai = ? ORDER BY `previl` DESC");
			$query->bindValue(1, $nup);
			$query->bindColumn('id_pegawai', $hak);

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
			curl_setopt($ch, CURLOPT_POST, count($postData));
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);    
 
			$output=curl_exec($ch);
 
			curl_close($ch);
	return $output;
	}
	

	public function ogs_strucInsert($id_user, $jabatan){

		$query = $this->db->prepare( "INSERT INTO og_userstructural (id_user, jabatan) VALUES (?, ?)");
		$query->bindValue(1, $id_user);
		$query->bindValue(2, $jabatan);

		
		try{
			$query->execute();
		}catch(PDOException $e){
			die($e->getMessage());
			
		}

	}

	public function Getogs_struc() {
			
			$query = $this->db->prepare("SELECT * FROM `og_userstructural` ");

			try{
				$query->execute();
				
				
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}


	public function delete_ogs_struc($id){

		$query 	= $this->db->prepare("DELETE FROM `og_userstructural` WHERE `og_userstructural`.`id` = ?  LIMIT 1");
		$query->bindValue(1, $id);
	
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}


		public function Get_strukturan_iduser($id_user) {
			
			$query = $this->db->prepare("SELECT jabatan FROM `og_userstructural` where id_user = ? limit 1");
				#bind Value 
				$query->bindValue(1, $id_user);
				
				 $query->bindColumn('jabatan', $hak);

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


			public function Setprevilage($id,$posisi) {

				if ($posisi=="SM") {
					$valueprevil=5 ;
				}elseif ($posisi=="kadiv") {
					$valueprevil=6 ;
				}elseif ($posisi=="surveyor") {
					$valueprevil=4 ;
				}elseif ($posisi=="manager") {
					$valueprevil=3 ;
					
				}else{
					$valueprevil=2 ;
				}


	
				$query = $this->db->prepare("UPDATE `og_user` SET `previl` = ? WHERE `id_user` = ?");
					
					$query->bindValue(1, $valueprevil);
					$query->bindValue(2, $id);

				try{
					$query->execute();
				}catch(PDOException $e){
					die($e->getMessage());
					
				}
	
	}

	public function getUserFromProject($pos, $project)
	{
		$query = $this->db->prepare("SELECT id_user FROM og_team WHERE id_project = ? AND proj_jabatan = ?");
		$query->bindValue(1, $project);
		$query->bindValue(2, $pos);
		
		try{
			$query->execute();
			
			
		}catch(PDOException $e){
			die($e->getMessage());	
		}
		 
		# We use fetchAll() instead of fetch() to get an array of all the selected records.
		$data = $query->fetchAll();

		$users = array();
		foreach($data as $dat)
		{
			array_push($users, $dat['id_user']);
		}

		return $users;
	}


 	
  

		
}




?>
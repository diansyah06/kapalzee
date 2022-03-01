<?php
class rms{
 
		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function lastInsertId(){
			return $this->db->lastInsertId();
		}
		
		public function get_Teknikal_paper() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_paper  ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		
		public function get_cek_point_id($id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_cekpoint where id_cek= ? limit 1");
			#bind Value 
				$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_rule_guard($id_user) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT id_user from rm_rule_guard where id_user= ? limit 1 ");
			#bind Value 
				$query->bindValue(1, $id_user);
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
		
		public function Insert_guardian($id_user){

		$query 	= $this->db->prepare("INSERT INTO `rm_rule_guard` (id_user ) VALUES (?) ");
	 
		$query->bindValue(1, $id_user);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}
		
		public function delete_guardian($id){

		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_rule_guard` WHERE `rm_rule_guard`.`id` = ?  LIMIT 1");
		$query->bindValue(1, $id);
	
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}
		
		public function get_guardian_list() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_rule_guard  ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		public function Insert_corigenda($id_rule_link, $thn, $tanggal, $Description, $File, $oleh, $File2,$tipe){

		$query 	= $this->db->prepare("INSERT INTO `rm_corigenda` (id_rule_link, thn, tanggal, Description, File, oleh, File2,tipe_amande ) VALUES (?, ?, ?, ?, ?, ?, ?,?) ");
	 
		$query->bindValue(1, $id_rule_link);
		$query->bindValue(2, $thn);
		$query->bindValue(3, $tanggal);
		$query->bindValue(4, $Description);
		$query->bindValue(5, $File);
		$query->bindValue(6, $oleh);
		$query->bindValue(7, $File2);
		$query->bindValue(8, $tipe);
	 
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}
	
		public function delete_corigenda($id,$id_rule_link){

		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_corigenda` WHERE `rm_corigenda`.`id` = ? and id_rule_link= ? LIMIT 1");
		$query->bindValue(1, $id);
		$query->bindValue(2, $id_rule_link);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}
	

	
		public function get_corigenda_list($id_rule_link) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_corigenda where id_rule_link= ? ");
			#bind Value 
				$query->bindValue(1, $id_rule_link);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_corigenda_listall() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT  rm_corigenda.id,rm_corigenda.id_rule_link, rm_corigenda.thn, rm_corigenda.tanggal, rm_corigenda.Description, rm_corigenda.File, rm_corigenda.oleh, rm_corigenda.File2, rm_corigenda.tipe_amande, rm_rulepub.id_rules, rm_rulepub.nama, rm_rulepub.tahun, rm_rulepub.tipe 	,rm_rulepub.part, rm_rulepub.vol, rm_rulepub.link, rm_rulepub.status FROM  rm_corigenda JOIN rm_rulepub on rm_corigenda.id_rule_link=rm_rulepub.id order by  rm_corigenda.id desc ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			return $query->fetchAll();
			}
			public function get_corigenda_listallsatu($id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT  rm_corigenda.id,rm_corigenda.id_rule_link, rm_corigenda.thn, rm_corigenda.tanggal, rm_corigenda.Description, rm_corigenda.File, rm_corigenda.oleh, rm_corigenda.File2, rm_corigenda.tipe_amande, rm_rulepub.id_rules, rm_rulepub.nama, rm_rulepub.tahun, rm_rulepub.tipe 	,rm_rulepub.part, rm_rulepub.vol, rm_rulepub.link, rm_rulepub.status FROM  rm_corigenda JOIN rm_rulepub on rm_corigenda.id_rule_link=rm_rulepub.id where rm_corigenda.id=? limit 1");
			
			$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_corigenda($id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_corigenda where id= ? ");
			#bind Value 
				$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function Get_random_name() {
		
			$random_digit=rand(0000,9999);
			$namabaru = $random_digit. "_" .  "Corigenda" . "_" . date("Y-m-d") . ".pdf" ;
			
			return $namabaru;

		}
		

		public function Upload_file($alamat,$nama_file,$temp_filee) {
		
		
		if (is_uploaded_file($temp_filee)) { 
                move_uploaded_file($temp_filee, $alamat . $nama_file);
                return true;
            } else {
                return false;
        }
		
		
		}
		
		
		public function insert_rule_list($Rules,$Tipe,$Part,$volume) {
		
			$query 	= $this->db->prepare("INSERT INTO `rm_ruleslist` (Rules, Tipe, Part, volume ) VALUES (?, ?, ?, ?) ");
		 
			$query->bindValue(1, $Rules);
			$query->bindValue(2, $Tipe);
			$query->bindValue(3, $Part);
			$query->bindValue(4, $volume);

			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}
		
		public function Cek_free_slot_rule_list($Tipe,$Part,$volume) {
		
			$query = $this->db->prepare("SELECT * from rm_ruleslist where Tipe= ?  and Part = ? and volume = ? ");
			#bind Value 
				$query->bindValue(1, $Tipe);
				$query->bindValue(2, $Part);
				$query->bindValue(3, $volume);
			
			try{
				$query->execute();
				$count = $query->rowCount();
				
				if ($count > 0) {
					return false ;} 
				else {
					return true;}
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		}	
			
			public function get_rule_list_by_partvol($Tipe,$Part,$volume) {
		
			$query = $this->db->prepare("SELECT * from rm_ruleslist where Tipe= ?  and Part = ? and volume = ? limit 1");
			#bind Value 
				$query->bindValue(1, $Tipe);
				$query->bindValue(2, $Part);
				$query->bindValue(3, $volume);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		
		public function insert_rules_publish($id_rules,$nama,$tahun,$tipe,$part,$vol,$link,$status) {
		
			$query 	= $this->db->prepare("INSERT INTO `rm_rulepub` (id_rules, nama, tahun, tipe, part, vol, link, status ) VALUES (?, ?, ?, ?,?,?,?,?) ");
		 
			$query->bindValue(1, $id_rules);
			$query->bindValue(2, $nama);
			$query->bindValue(3, $tahun);
			$query->bindValue(4, $tipe);
			$query->bindValue(5, $part);
			$query->bindValue(6, $vol);
			$query->bindValue(7, $link);
			$query->bindValue(8, $status);

			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}
		
		public function suggest_rule_pub($nama) {
		
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT id, id_rules , nama, tahun, tipe, link ,status,part, vol FROM rm_rulepub where status = 1 and nama like ? limit 10");
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
		
		public function get_rules_publish($id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_rulepub where id= ? limit 1");
			#bind Value 
				$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
			
		}

		public function update_status_rules_publish($status, $id ){
	 
			$query 	= $this->db->prepare("UPDATE rm_rulepub SET status= ? where id= ?  ");
		 
			
			$query->bindValue(1, $status);
			$query->bindValue(2, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function update_rules_desk_cekpoint($id_cek,$point,$desk){
	 
			$query 	= $this->db->prepare("UPDATE rm_cek_desk SET desk=? where id_cek= ?  and  point = ?");
		 
			$query->bindValue(1, $desk);
			$query->bindValue(2, $id_cek);
			$query->bindValue(3, $point);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function get_rules_desk_cekpoint($id_cek,$point) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_cek_desk where id_cek= ? and  point = ? limit 1");
			#bind Value 
				$query->bindValue(1, $id_cek);
				$query->bindValue(2, $point);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
			
		}
		
		public function generate_path_rules_publish($master, $part , $volume ,$tipe ,$Rules_nama ,$tahun) {
		
			$JenisTechnical_paper=array("Error","Rules", "Guidelines", "Guidance", "Reference Note");
		 
			$part_arrays=array("Part 0. General","Part 1. Seagoing Ship","Part 2. Inland Waterway","Part 3. Special Ships","Part 4. Special Equipment and Systems","Part 5. Offshore Technology","Part 6. Statutory","Part 7. Class Notation");
			
			$nama_vol=array("( Vol 0 )","( Vol I )","( Vol II )","( Vol III )","( Vol IV )","( Vol V )","( Vol VI )","( Vol VII )","( Vol VIII )","( Vol IX )","( Vol X )","( Vol XI )","( Vol XII )","( Vol XIII )","( Vol XIV )","( Vol XV )","( Vol XVI )","( Vol XVII )","( Vol XVIII )","( Vol XIX )","( Vol XX )","( Vol XI )","( Vol XXII )","( Vol XXIII )","( Vol XXIV )","( Vol XXV )","( Vol XXVI )","( Vol XXVII )","( Vol XXVIII )","( Vol XXIX )","( Vol XXX )","( Vol XXXI )","( Vol XXXII )","( Vol XXXIII )","( Vol XXXIV )","( Vol XXXV )","( Vol XXXVI )","( Vol XXXVII )","( Vol XXXVIII )","( Vol XXXIX )","( Vol XL )","( Vol XLI )","( Vol XLII )","( Vol XLIII )","( Vol XLIV )","( Vol XLV )");		  

			$nama_vol_G=array("( Vol 0 )","( Vol A )","( Vol B )","( Vol C )","( Vol D )","( Vol E )","( Vol F )","( Vol G )","( Vol H )","( Vol I )","( Vol J )","( Vol K )","( Vol L )","( Vol M )","( Vol N )","( Vol O )","( Vol P )","( Vol Q )","( Vol R )","( Vol S )","( Vol T )","( Vol U )","( Vol V )","( Vol W )","( Vol X )","( Vol Y )","( Vol Z )","( Vol AA )","( Vol AB )","( Vol AC )","( Vol AD )","( Vol AF )","( Vol AG )","( Vol AH )","( Vol AI )","( Vol AJ )","( Vol AK )","( Vol AL )","( Vol AM )","( Vol AN )","( Vol AO )","( Vol AP )","( Vol AQ )","( Vol AR )","( Vol AS )","( Vol AT )");	
			
			if (strlen($Rules_nama)> 65 ){ $Rules_nama=substr($Rules_nama, 0, 65) . "..." ;} // 
			
			if ($tipe==1) {
			
				$alamat=$master . $JenisTechnical_paper[$tipe] . "/" . $part_arrays[$part] . "/" . $nama_vol[$volume] . " " . $Rules_nama . "/" .$tahun . "/" ;
			} elseif ($tipe==2) {
				$alamat=$master . $JenisTechnical_paper[$tipe] . "/" . $part_arrays[$part] . "/" . "( Vol " . $volume . " )"  . " " . $Rules_nama . "/" . "/" .$tahun . "/" ;
			} 
			elseif ($tipe==3) {
				$alamat=$master . $JenisTechnical_paper[$tipe] . "/" . $part_arrays[$part] . "/" . $nama_vol_G[$volume] . " " . $Rules_nama  . "/" .$tahun . "/";
			} 
			elseif ($tipe==4) {
			
				$alamat=$master . $JenisTechnical_paper[$tipe] . "/" . $part_arrays[$part] . "/" . $Rules_nama  . "/" .$tahun . "/";
			} else {
				$alamat=$master . $JenisTechnical_paper[$tipe] . "/" . $part_arrays[$part] . "/" . $Rules_nama . "/" .$tahun . "/" ;
			}

			return $alamat;
			
		}
		
		public function Cek_avaibility_path($alamat) {
		

			$pieces = explode("/", $alamat);
			$jml = count($pieces) ;
			$jml=$jml-1;
			
			$no=1;
			for ($i=1; $i<=$jml; $i++)
			{

					$kata=$kata . $pieces[$i] . "/";
					if(!is_dir($kata)){mkdir($kata , 0700); }


			}

		
		}
		
		public function delete_pdf_publish($id_rules_pub){

		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_upload_tanpa_rms` WHERE `rm_upload_tanpa_rms`.`id_rules_pub` = ? and tipe= 1 ");
		$query->bindValue(1, $id_rules_pub);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}
	
		public function insert_pdf_publish($id_rules_pub,$tipe,$nama,$path,$tanggal) {
		
			$query 	= $this->db->prepare("INSERT INTO `rm_upload_tanpa_rms` (id_rules_pub, tipe, nama, path, tanggal ) VALUES (?, ?, ?, ?,?) ");
		 
			$query->bindValue(1, $id_rules_pub);
			$query->bindValue(2, $tipe);
			$query->bindValue(3, $nama);
			$query->bindValue(4, $path);
			$query->bindValue(5, $tanggal);


			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}
		
		public function Generate_rules_filename($rules,$tahun,$part,$volume) {
		
			$random_digit=rand(0000,9999);
			$namabaru =  $random_digit. "_" .  $rules . "_" . $tahun . "-" .$part . "_" . $volume . ".pdf" ;
			
			return $namabaru;

		}
		
		
		public function list_rules_pub($Load_tipe,$Load_all) {
		if ($Load_tipe==0){
			if ($Load_all=="alll"){ $statement1="SELECT id, id_rules , nama, tahun, tipe, link, status,part, vol FROM rm_rulepub  ORDER BY `nama` ASC" ;}
				else { $statement1="SELECT id, id_rules , nama, tahun, tipe, link, status,part, vol FROM rm_rulepub where status = 1";
					} //apakah hanya menampilkan rules yang berlaku?
					
							$query 	= $this->db->prepare($statement1);
					
		}else {
			if ($Load_all=="alll"){ $statement1="SELECT id, id_rules , nama, tahun, tipe, link, status,part, vol FROM rm_rulepub where tipe= ?" ;}
				else { $statement1="SELECT id, id_rules , nama, tahun, tipe, link, status,part, vol FROM rm_rulepub where status = 1 and tipe= ?";
				} //apakah hanya menampilkan rules yang berlaku?
						
							$query 	= $this->db->prepare($statement1);
							$query->bindValue(1, $Load_tipe);					
		
		}
		
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		return $query->fetchAll();
		
		}
		
		public function get_file_pub_rms($id_cek) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT  name , path  FROM rm_uploadpub  where id_cek = ?");
			#bind Value 
				$query->bindValue(1, $id_cek);
				
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
			
		}
		
		public function get_file_pub_tanpa_rms($id_pub) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT  nama , path  FROM  rm_upload_tanpa_rms  where id_rules_pub = ? and tipe=1 ");
			#bind Value 
				$query->bindValue(1, $id_pub);
				
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
			
		}
		
		public function insert_recom_consenering($tanggal,$isi,$sumber,$id_rules,$id_rules_pub) {
		
			$query 	= $this->db->prepare("INSERT INTO `rm_rekomendasi` (tanggal,isi,sumber,id_rules_sumber,id_rules_pub  ) VALUES (?, ?, ?, ?,?) ");
		 
			$query->bindValue(1, $tanggal);
			$query->bindValue(2, $isi);
			$query->bindValue(3, $sumber);
			$query->bindValue(4, $id_rules);
			$query->bindValue(5, $id_rules_pub);


			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}
		
		public function get_recom_consenering_idpub($id_rules_pub) {
		
			$query 	= $this->db->prepare("SELECT * from `rm_rekomendasi` where id_rules_pub= ? ");
		 
			$query->bindValue(1, $id_rules_pub);


			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
						# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		
		 public function get_recom_consenering_idrul($id_rules) {
		
			$query 	= $this->db->prepare("SELECT * from `rm_rekomendasi` where  	id_rules_sumber = ? ");
		 
			$query->bindValue(1, $id_rules);


			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
						# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		public function delete_recom_consenering_id($id){

		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_rekomendasi` WHERE `rm_rekomendasi`.`id_re` = ? limit 1 ");
		$query->bindValue(1, $id);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}
	
	public function obsolete_rule_pub_before($id_rules){
	
	//select rule pub white aktif dan id sama
	
	$query = $this->db->prepare("SELECT id from rm_rulepub where id_rules= ? and status=1 limit 1 ");
			#bind Value 
				$query->bindValue(1, $id_rules);
				 $query->bindColumn('id', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			 $jml = $query->rowCount();
		
		//jika numrow > 1 then
			if($jml == 1) { 
			
			//update rule pub , flag true
			
			$this->update_status_rules_publish(3, $hak );
				return true;
	
			}else{
			
				return false;
			
			}
	

	}
	
	public function get_name_rule_pub_id($id){
	
			$query = $this->db->prepare("SELECT  nama FROM rm_rulepub  where id = ? LIMIT 1 ");
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
	
	
	
	public function insert_minute_meeting($tanggal,$agenda,$waktu,$hasil_rapat,$cek_po,$kehadiran,$tempat,$project,$external_email ='') {
		
			$query 	= $this->db->prepare("INSERT INTO `rm_meeting` (tanggal, agenda, waktu, hasil_rapat, cek_po, kehadiran, tempat,project,externalEmail  ) VALUES (?, ?, ?, ?,?,?,?,?,?) ");
		 
			$query->bindValue(1, $tanggal);
			$query->bindValue(2, $agenda);
			$query->bindValue(3, $waktu);
			$query->bindValue(4, $hasil_rapat);
			$query->bindValue(5, $cek_po);
			$query->bindValue(6, $kehadiran);
			$query->bindValue(7, $tempat);
			$query->bindValue(8, $project);
			$query->bindValue(9, $external_email);

			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}
		
		
		public function delete_minute_meeting($id_minutes){

		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_meeting` WHERE `rm_meeting`.`id` = ?  ");
		$query->bindValue(1, $id_minutes);
	
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}
	
			public function get_minute_meeting($cek_po,$project) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_meeting where cek_po= ?  and project = ? order by id desc ");
			#bind Value 
				$query->bindValue(1, $cek_po);
				$query->bindValue(2, $project);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_minute_meeting_id($cek_po,$id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_meeting where cek_po= ?  and id = ?");
			#bind Value 
				$query->bindValue(1, $cek_po);
				$query->bindValue(2, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		public function Parse_name_member_meeting($list_memeber) {
		
		$a = explode(",", $list_memeber);
		$list_mem= "" ;
		foreach ($a as $s) {
		
		$get_username= $this->get_users_with_title($s);
		
		$list_mem=  $list_mem . "<li>" . $get_username . "</li>"  ; 
		
		
		}
		
		return $list_mem ;
		}
		
		
		public function update_minute_meeting($status, $id ){
	 
			$query 	= $this->db->prepare("UPDATE rm_meeting SET hasil_rapat= ? where id= ?  ");
		 
			
			$query->bindValue(1, $status);
			$query->bindValue(2, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function update_FileMOM($file, $id ){
	 
			$query 	= $this->db->prepare("UPDATE rm_meeting SET file= ? where id= ?  ");
		 
			
			$query->bindValue(1, $file);
			$query->bindValue(2, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}					
		
		public function update_person_meeting($kehadiran, $id_minutes ){
	 
			$query 	= $this->db->prepare("UPDATE rm_meeting SET kehadiran= ? where id= ?  ");
		 
			
			$query->bindValue(1, $kehadiran);
			$query->bindValue(2, $id_minutes);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		
		public function insert_log_rules( $section, $sub_sec, $origin , $changes, $objek , $argumen,$tanggal,$code, $id_mom ) {
		
			$query 	= $this->db->prepare("INSERT INTO rm_cek_log (section,  sub_section, origin, changes, objek, argument,date,id_cek,id_mom ) VALUES (?, ?, ?, ?, ?, ?,?,?,? )");
		 
			$query->bindValue(1, $section);
			$query->bindValue(2, $sub_sec);
			$query->bindValue(3, $origin);
			$query->bindValue(4, $changes);
			$query->bindValue(5, $objek);
			$query->bindValue(6, $argumen);
			$query->bindValue(7, $tanggal);
			$query->bindValue(8, $code);
			$query->bindValue(9, $id_mom);


			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}
		
		
		public function delete_log_rules($id_log,$id_cek){

		$query 	= $this->db->prepare("DELETE FROM  rm_cek_log  where id =?  and id_cek = ?  LIMIT 1");
		$query->bindValue(1, $id_log);
		$query->bindValue(2, $id_cek);
	
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}
	
	public function get_cek_log($cek_log) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_cek_log where id_cek= ? ");
			#bind Value 
				$query->bindValue(1, $cek_log);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
	public function get_cek_log2($cek_log,$id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_cek_log where id_cek= ? and id_mom=? ");
			#bind Value 
				$query->bindValue(1, $cek_log);
				$query->bindValue(2, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		public function get_cek_log2_jml($cek_log,$id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_cek_log where id_cek= ? and id_mom=? ");
			#bind Value 
				$query->bindValue(1, $cek_log);
				$query->bindValue(2, $id);
			try{
				$query->execute();
				$count = $query->rowCount();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $count ;
		}
		
		public function get_ruleslist_name($id_rules) {

		$query = $this->db->prepare("SELECT Rules from rm_ruleslist where id_rules= ? limit 1 ");
			#bind Value 
				$query->bindValue(1, $id_rules);
				 $query->bindColumn('Rules', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;
		
		}
		
		public function get_LeaderOnprojectRules($idcekPo) {

		$query = $this->db->prepare("SELECT user from  rm_cekpoint where id_cek= ? limit 1 ");
			#bind Value 
				$query->bindValue(1, $idcekPo);
				 $query->bindColumn('user', $hak);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
		return $hak ;
		
		}
		//Tambahan dari class user 
		
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
		
		
		public function getProgressYears() {
			
			$tahun=date("Y"); 
		    #preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT  og_user.nama, rm_paper.Nama, rm_cekpoint.id_cek, rm_cekpoint.tahun, rm_cekpoint.user, rm_cekpoint.duedate , rm_ruleslist.Rules, rm_ruleslist.tipe, rm_ruleslist.Part , rm_ruleslist.volume, rm_cekpoint.preparation, rm_cekpoint.teamup, rm_cekpoint.ref, rm_cekpoint.wg, rm_cekpoint.konsenering, rm_cekpoint.cetak, rm_cekpoint.karakter, rm_cekpoint.adminis, rm_cekpoint.komite, rm_cekpoint.scope, rm_cekpoint.master, rm_cekpoint.publikasi, rm_cekpoint.close 	  FROM rm_cekpoint LEFT JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules 
LEFT JOIN rm_paper ON rm_ruleslist.tipe=rm_paper.id_paper
LEFT JOIN og_user ON rm_cekpoint.user=og_user.id_user where rm_cekpoint.closeby=0  order by rm_cekpoint.id_cek desc ");
			//$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		
		public function GetNumProjectOngoing(){
		
		 #preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT  og_user.nama, rm_paper.Nama, rm_cekpoint.id_cek, rm_cekpoint.tahun, rm_cekpoint.user, rm_cekpoint.duedate , rm_ruleslist.Rules, rm_ruleslist.tipe, rm_ruleslist.Part , rm_ruleslist.volume, rm_cekpoint.preparation, rm_cekpoint.teamup, rm_cekpoint.ref, rm_cekpoint.wg, rm_cekpoint.konsenering, rm_cekpoint.cetak, rm_cekpoint.karakter, rm_cekpoint.adminis, rm_cekpoint.komite, rm_cekpoint.scope, rm_cekpoint.master, rm_cekpoint.publikasi, rm_cekpoint.close 	  FROM rm_cekpoint LEFT JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules 
LEFT JOIN rm_paper ON rm_ruleslist.tipe=rm_paper.id_paper
LEFT JOIN og_user ON rm_cekpoint.user=og_user.id_user where rm_cekpoint.closeby=0 order by rm_cekpoint.id_cek desc ");
			//$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			 $jml = $query->rowCount();
			 
			 return $jml  ;

		
		}
		
		public function GetNumProjectDone(){
		
		 #preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT  og_user.nama, rm_paper.Nama, rm_cekpoint.id_cek, rm_cekpoint.tahun, rm_cekpoint.user, rm_cekpoint.duedate , rm_ruleslist.Rules, rm_ruleslist.tipe, rm_ruleslist.Part , rm_ruleslist.volume, rm_cekpoint.preparation, rm_cekpoint.teamup, rm_cekpoint.ref, rm_cekpoint.wg, rm_cekpoint.konsenering, rm_cekpoint.cetak, rm_cekpoint.karakter, rm_cekpoint.adminis, rm_cekpoint.komite, rm_cekpoint.scope, rm_cekpoint.master, rm_cekpoint.publikasi, rm_cekpoint.close 	  FROM rm_cekpoint LEFT JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules 
LEFT JOIN rm_paper ON rm_ruleslist.tipe=rm_paper.id_paper
LEFT JOIN og_user ON rm_cekpoint.user=og_user.id_user where rm_cekpoint.closeby=1 order by rm_cekpoint.id_cek desc ");
			//$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			 $jml = $query->rowCount();
			 
			 return $jml  ;

		
		}
		
		public function getNumProjectStack(){
		$query = $this->db->prepare("SELECT * FROM `rm_cekpoint` WHERE `duedate` <  DATE(NOW()) and `close` = 0");
			//$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			 $jml = $query->rowCount();
			 
			 return $jml  ;	
			
			
		} 
		
		public function GetTableLiscrossRef(){
		
					$query = $this->db->prepare("SELECT  rm_ruleschar.tahun as iacsTahun, rm_ruleschar.nama ,  rm_ruleschar.id_rules, rm_ruleschar.desk, rm_cekpoint.id_cek,rm_cekpoint.tahun,rm_ruleslist.Rules

FROM rm_ruleschar 
LEFT JOIN rm_cekpoint ON rm_cekpoint.id_cek=rm_ruleschar.id_cekpoint
LEFT JOIN rm_ruleslist ON rm_ruleslist.id_rules=rm_cekpoint.rules

where rm_ruleschar.gol=2 order by rm_ruleslist.Rules ASC");
			//$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		

		
	
		public function createNamaSymbol($part, $volume , $tipe ){
		


			$nama_vol=array("0","I","II","III","IV","V","VI","VII","VIII","IX","X","XI","XII","XIII","XIV","XV","XVI","XVII","XVIII","XIX","XX","XI","XXII","XXIII","XXIV","XXV","XXVI","XXVII","XXVIII","XXIX","XXX","XXXI","XXXII","XXXIII","XXXIV","XXXV","XXXVI","XXXVII","XXXVIII","XXXIX","XL","XLI","XLII","XLIII","XLIV","XLV");		  

			$nama_vol_G=array("0","A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","AA","AB","AC","AD","AF","AG","AH","AI","AJ","AK","AL","AM","AN","AO","AP","AQ","AR","AS","AT");
		
			if ($tipe==1){
				return "(" . $part . "-". $nama_vol[$volume] . ")";
			}elseif($tipe==2){
				return "(" . $part . "-". $volume . ")" ;
			}elseif($tipe==3){
				return "(" . $part . "-". $nama_vol_G[$volume] . ")";
			}elseif($tipe==4){
				return "(" . $part . "-". $volume . ")" ;
			}

		}
		
		
		public function get_AllteamRms($id_cekpo) {
			
			
			$query = $this->db->prepare("SELECT  user,sekertaris 	 FROM rm_cekpoint  where id_cek = ? LIMIT 1 ");
			#bind Value 
				$query->bindValue(1, $id_cekpo);
				 $query->bindColumn('user', $hak);
				 $query->bindColumn('sekertaris', $hak2);
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		
			
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT user from rm_team  where  	id_cek = ? ");
			#bind Value 
				$query->bindValue(1, $id_cekpo);
				$query->bindColumn('user', $hak3);
			try{
				$query->execute();
					
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {
					$gabungan =$gabungan	. 	"," . $hak3 ;
					}				
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			
			
			return  $hak . "," . $hak2 . $gabungan;
		
		
		
		}
		
		
		public function Insert_MeetingInvitation($subject, $agenda, $peserta, $postby, $grouptipe, $groupid, $updateon, $plan,$location ){

		$query 	= $this->db->prepare("INSERT INTO `rm_invitation` (subject, agenda, peserta, postby, grouptipe, groupid, updateon, plan ,location   ) VALUES (?,?,?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $subject);
		$query->bindValue(2, $agenda);
		$query->bindValue(3, $peserta);
		$query->bindValue(4, $postby);
		$query->bindValue(5, $grouptipe);
		$query->bindValue(6, $groupid);
		$query->bindValue(7, $updateon);
		$query->bindValue(8, $plan);
		$query->bindValue(9, $location );

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}
		
		public function delete_MeetingInvitation($id){

		$query 	= $this->db->prepare("DELETE FROM `ogs`.`rm_invitation` WHERE `rm_invitation`.`id` = ?  LIMIT 1");
		$query->bindValue(1, $id);
	
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}
		
		public function get_MeetingInvitation() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_invitation  ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

 		public function get_MeetingInvitationbyId($id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_invitation  where id = ?");
			$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function GetMeetingMontCalender($month,$projectid=0){
			
			$month=date("Y", strtotime($month));
				$strFilter='';
			if ($projectid!=0) {
				$strFilter=" And w.object_id = " . intval($projectid) ;
			}
			
 			
			$query = $this->db->prepare("SELECT m.tanggal,m.agenda , m.waktu, m.cek_po, m.project, r.Rules , w.project as namproject FROM rm_meeting m LEFT JOIN rm_cekpoint cp ON cp.id_cek=m.cek_po LEFT JOIN rm_ruleslist r ON cp.rules=r.id_rules LEFT JOIN rm_workspaces w ON m.cek_po=w.object_id WHERE DATE_FORMAT(`tanggal`,'%Y') =? $strFilter "); 
			//$query = $this->db->prepare("SELECT m.tempat, m.tanggal,m.agenda , m.waktu, m.cek_po, m.project, r.Rules , w.project as namproject FROM rm_meeting m LEFT JOIN rm_cekpoint cp ON cp.id_cek=m.cek_po LEFT JOIN rm_ruleslist r ON cp.rules=r.id_rules LEFT JOIN rm_workspaces w ON m.project=w.object_id ");
			 $query->bindValue(1, $month); 
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();			
		}
		
		public function QueryDevelopingrules(){
			
			$query = $this->db->prepare("SELECT c.publikasi ,r.tipe FROM `rm_cekpoint` c left join rm_ruleslist r ON c.rules=r.id_rules where c.publikasi!='0000-00-00' and c.close=1 ORDER BY `c`.`publikasi` asc ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();					
			
		}
		
		public function GetKpiyear($year){
		
			$query = $this->db->prepare("SELECT c.publikasi FROM `rm_cekpoint` c left join rm_ruleslist r ON c.rules=r.id_rules where year(c.publikasi)=?");
			$query->bindValue(1, $year);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			
		$jml = $query->rowCount();			
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $jml ;					
			
		}
		
		public function conectRmsExternal(){
			
			define("HOSTt", "10.0.1.203"); // The host you want to connect to.
			define("USERt", "masukkk"); // The database username.
			define("PASSWORDt", "3twhvjttbm"); // The database password. 
			define("DATABASEt", "masukan"); // The database name.
			 
			/*$mysqlii = new mysqli(HOSTt, USERt, PASSWORDt, DATABASEt);
			*/
			$link = mysql_connect(HOSTt, USERt, PASSWORDt);

			if (!$link) {
				die('Could not connect: ' . mysql_error());
			}


			if (!mysql_select_db('masukan', $link)) {
				echo 'Could not select database';
				exit;
			}

			$sql    = 'SELECT * FROM masukan_inet  order by id desc';
			$result = mysql_query($sql, $link);

			if (!$result) {
				echo "DB Error, could not query the database\n";
				echo 'MySQL Error: ' . mysql_error();
				exit;
			}
			return $link ;
		}
		
		public function GetKunjunganRules(){
			
			$link=$this->conectRmsExternal();
			
			$sql    = 'SELECT DISTINCT mac FROM `absen` ';
			$result = mysql_query($sql, $link);
			$num_rows_unik= mysql_num_rows($result);
			return $num_rows_unik ;
			
		}
		
		
 
 
 
 
 }
 ?>
<?php
class drawing{
private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function get_tipe_gambar() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_tipe_gambar`  ORDER BY `id` DESC");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_tipe_gambar_id($id_tipe_gam) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_tipe_gambar`  where id= ? ORDER BY `id` DESC");
			$query->bindValue(1, $id_tipe_gam);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function insert_data_gambar($proj_id, $judul, $tipe_gambar, $tanggal , $path,$no_gambar,$clientid=0,$rev=0) {
		
		$updatetime = date("Y-m-d H:i:s"); 
		
		$query 	= $this->db->prepare("INSERT INTO `og_proj_gambar` (id_kontrak, judul, tipe, tanggal, path,no_gambar,client_id,updateat,rev ) VALUES (?, ?, ?, ?, ?,?,?,?,?) ");

		$query->bindValue(1, $proj_id);
		$query->bindValue(2, $judul);
		$query->bindValue(3, $tipe_gambar);
		$query->bindValue(4, $tanggal);
		$query->bindValue(5, $path);
		$query->bindValue(6, $no_gambar);
		$query->bindValue(7, $clientid);
		$query->bindValue(8, $updatetime);
		$query->bindValue(9, $rev);

		try{
			$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
		}	
		
		}
		
public function updateGambarRev($idGam, $rev ){
	 		
	 		$updatetime = date("Y-m-d H:i:s"); 

			$query 	= $this->db->prepare("UPDATE og_proj_gambar SET updateat = ? ,rev = ?  where id= ? ");
		 
			$query->bindValue(1, $updatetime);
			$query->bindValue(2, $rev);
			$query->bindValue(3, $idGam);
		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}		
		public function get_proj_gambar($id_projt) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT g.updateat,g.rev,g.forinfo, g.engfield, g.id,g.id_kontrak,g.no_gambar,g.judul,g.tipe,g.tanggal ,s.review, s.status,s.userid,s.reviewdate,s.drawingstatus,sg.tanggal as tglrev, s.id as id_stamp FROM `og_proj_gambar` g left join rm_stamp s on g.id = s.id_gambar and g.rev = s.rev left join og_sub_proj_gambar sg on sg.id_project_gamb=g.id and g.rev=sg.revisi where g.id_kontrak= ? ORDER BY g.updateat DESC ");
			$query->bindValue(1, $id_projt);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_proj_gambar_id($id_gam) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_proj_gambar` where id= ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id_gam);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_status_proj_gambar_id($id_gam) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT akses FROM `og_proj_gambar` where id= ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id_gam);
			
			$query->bindColumn('akses', $hak);
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
	
		//cek double drawing
		public function cek_double_drawing($no_drawing,$id_kon) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_proj_gambar` where no_gambar= ? and id_kontrak =? ORDER BY `id` DESC");
			$query->bindValue(1, $no_drawing);
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
		
		//insert sub gambar
		public function insert_data_sub_gambar($id_project_gamb, $id_kontrak, $tanggal, $revisi , $alamat) {
		
			$query 	= $this->db->prepare("INSERT INTO `og_sub_proj_gambar` (id_project_gamb, id_kontrak, tanggal, revisi, alamat) VALUES (?, ?, ?, ?, ?) ");

			$query->bindValue(1, $id_project_gamb);
			$query->bindValue(2, $id_kontrak);
			$query->bindValue(3, $tanggal);
			$query->bindValue(4, $revisi);
			$query->bindValue(5, $alamat);
			
			try{
				$query->execute();

				}catch(PDOException $e){
					die($e->getMessage());
			}	
		 
		}
		//get historical
		public function get_histori_gambar($id_gambar,$id_kon) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT h.id, h.id_project_gamb,h.id_kontrak,h.tanggal,h.revisi,h.alamat,o.no_gambar,o.judul FROM `og_sub_proj_gambar` h left join og_proj_gambar o on o.id= h.id_project_gamb where h.id_project_gamb = ? and h.id_kontrak = ? ORDER BY h.id DESC ");
			$query->bindValue(1, $id_gambar);
			$query->bindValue(2, $id_kon);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_histori_gambar_id($id_gambar,$id_kon) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_sub_proj_gambar` where id = ? and id_kontrak = ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id_gambar);
			$query->bindValue(2, $id_kon);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_histori_gambar_on_id($id_gambar) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_sub_proj_gambar` where id_project_gamb = ?  ORDER BY `id` DESC");
			$query->bindValue(1, $id_gambar);
			
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
		
		public function get_autosugest_gambar($no_gambar,$id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_proj_gambar` where no_gambar like ? and id_kontrak= ? ORDER BY `id` DESC limit 10");
			$query->bindValue(1, $no_gambar);
			$query->bindValue(2, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_autosugest_gambar_tipe($no_gambar,$id_kontrak,$tipe) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_proj_gambar` where (no_gambar like ? or judul like ?)  and id_kontrak= ?  and tipe= ? and forinfo !=4 ORDER BY `id` DESC limit 10");
			$query->bindValue(1, $no_gambar);
			$query->bindValue(2, $no_gambar);
			$query->bindValue(3, $id_kontrak);
			$query->bindValue(4, $tipe);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}		
		
		public function get_gambarby_tipe($id_kontrak,$tipe) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_proj_gambar` where  id_kontrak= ?  and tipe= ? ORDER BY `updateat` DESC ");

			$query->bindValue(1, $id_kontrak);
			$query->bindValue(2, $tipe);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		//get_id from nama
		public function get_id_from_no_gambar($no_gambar,$id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_proj_gambar` where no_gambar = ?  and id_kontrak= ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $no_gambar);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_no_gambar_from_id($no_id,$id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_proj_gambar` where id = ?  and id_kontrak= ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $no_id);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		
		public function get_gamb_id_terakir($no_id , $id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT og_sub_proj_gambar.id, og_sub_proj_gambar.revisi,og_sub_proj_gambar.alamat,rm_stamp.status,rm_stamp.review,rm_stamp.file FROM `og_sub_proj_gambar` left join rm_stamp on og_sub_proj_gambar.id_project_gamb =rm_stamp.id_gambar and og_sub_proj_gambar.revisi=rm_stamp.rev where og_sub_proj_gambar.id_project_gamb = ? and og_sub_proj_gambar.id_kontrak= ? ORDER BY og_sub_proj_gambar.`id` DESC limit 1");
			$query->bindValue(1, $no_id);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		public function update_gambar_property($no_gamb, $judul , $tipe,$id,$idkon ){
	 
			$query 	= $this->db->prepare("UPDATE og_proj_gambar SET no_gambar = ? ,judul = ?,tipe = ?  where id= ? and id_kontrak=?");
		 
			$query->bindValue(1, $no_gamb);
			$query->bindValue(2, $judul);
			$query->bindValue(3, $tipe);
			$query->bindValue(4, $id);
			$query->bindValue(5, $idkon);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		public function update_gambar_propertyEngfield($forinfo, $engfield ,$id,$idkon ){
	 
			$query 	= $this->db->prepare("UPDATE og_proj_gambar SET forinfo = ? ,engfield = ? where id= ? and id_kontrak=?");
		 
			$query->bindValue(1, $forinfo);
			$query->bindValue(2, $engfield);
			$query->bindValue(3, $id);
			$query->bindValue(4, $idkon);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}			
		
		public function get_gamb_by_id($no_id , $id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_sub_proj_gambar` where id = ?  and  id_kontrak= ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $no_id);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		
		public function Delete_All_revisi_draw($no_id_gam  , $id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("DELETE FROM   og_sub_proj_gambar  where id_project_gamb =?  and  id_kontrak= ? ");
			$query->bindValue(1, $no_id_gam);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			
		}
		
		public function Delete_id_revisi_draw($no_id  , $id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("DELETE FROM   og_sub_proj_gambar  where id =?  and  id_kontrak= ? LIMIT 1");
			$query->bindValue(1, $no_id);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		}
		
		public function delete_gam($no_id ,$id_kontrak) {
		
		$query = $this->db->prepare("DELETE FROM `og_proj_gambar` where id = ?  and id_kontrak= ?  limit 1");
			$query->bindValue(1, $no_id);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

		}
		
		
		
		
		
		public function cek_waktu_kurang1jam($tang1,$tang2){

		$time1=date("H:i ", strtotime($tang1));

		$time2=date("H:i ", strtotime($tang2));

		$tang1=date("Y-m-d", strtotime($tang1));

		$tang2=date("Y-m-d", strtotime($tang2));

		if ($tang1==$tang2){

				$time1=$this->time_to_decimal($time1);
				$time2=$this->time_to_decimal($time2);
				
				if (($time2-$time1)<60) {
					
					return true ;
					
					}else {
					
						return false ;
					
					}

			}else {
			return false ;
			}
		}

		function time_to_decimal($time) {
			$timeArr = explode(':', $time);
			$decTime = ($timeArr[0]*60) + ($timeArr[1]) + ($timeArr[2]/60);
		 
			return $decTime;
		}
		
		//insert data gambar temp1
		
		public function insert_data_gambar_temp1($nama_file, $Almat, $no_gamb, $judul , $tipe,$kontrak_id,$doc_tipe,$tanggal) {
		
		$query 	= $this->db->prepare("INSERT INTO `og_proj_gambar_temp1` (nama_file, Almat, no_gamb, judul, tipe,kontrak_id,doc_tipe, tanggal ) VALUES (?, ?, ?, ?, ?,?,?,?) ");

		$query->bindValue(1, $nama_file);
		$query->bindValue(2, $Almat);
		$query->bindValue(3, $no_gamb);
		$query->bindValue(4, $judul);
		$query->bindValue(5, $tipe);
		$query->bindValue(6, $kontrak_id);
		$query->bindValue(7, $doc_tipe);
		$query->bindValue(8, $tanggal);
		
		try{
			$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
		}	
		
		}
		
		public function get_proj_gambar_temp($sta, $ak) {

		$statement="SELECT * FROM `og_proj_gambar_temp1`  ORDER BY `id` DESC Limit ". $sta . "," . $ak  ; 
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare($statement);
			

			
			
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function update_proj_gambar_temp($no_gamb, $judul , $tipe,$doc_tipe,$id ){
	 
			$query 	= $this->db->prepare("UPDATE og_proj_gambar_temp1 SET no_gamb = ? ,judul = ?,tipe = ?,doc_tipe = ?  where id= ?");
		 
			$query->bindValue(1, $no_gamb);
			$query->bindValue(2, $judul);
			$query->bindValue(3, $tipe);
			$query->bindValue(4, $doc_tipe);
			$query->bindValue(5, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		
		public function Delete_proj_gambar_temp($id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("DELETE FROM   og_proj_gambar_temp1  where id= ? limit 1");
			$query->bindValue(1, $id);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			
		}
		
		public function get_proj_gambar_temp_almat($id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT Almat FROM `og_proj_gambar_temp1` where id= ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id);
			
			$query->bindColumn('Almat', $hak);
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
		
		public function insert_requestdownload($userid, $id_kon, $id_drawing ,$nomerdrawing) {
		
		$tanggal = date("Y-m-d H:i:s");
		
		$query 	= $this->db->prepare("INSERT INTO `rm_requesdownload` (userid, tanggal, id_kon, id_drawing,drawingno,aprroveby,approvedate,status) VALUES (?,?, ?, ?, ?,?,?,?) ");

		$query->bindValue(1, $userid);
		$query->bindValue(2, $tanggal);
		$query->bindValue(3, $id_kon);
		$query->bindValue(4, $id_drawing);
		$query->bindValue(5, $nomerdrawing);
		$query->bindValue(6, $userid);
		$query->bindValue(7, $tanggal);
		$query->bindValue(8, 1);


		
		try{
			$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
		}	
		
		}
		
		public function moderationDownloadDrawing($aprroveby, $status ,$id ){
	  	$approvedate = date("Y-m-d H:i:s");
			$query 	= $this->db->prepare("UPDATE rm_requesdownload SET aprroveby = ? , 	approvedate = ?,status = ?  where id= ?");
		 
			$query->bindValue(1, $aprroveby);
			$query->bindValue(2, $approvedate);
			$query->bindValue(3, $status);
			$query->bindValue(4, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}		
		
		public function DownloadDrawingRequest($useragent, $ip ,$id ){
	  	$downloadtime = date("Y-m-d H:i:s");
			$query 	= $this->db->prepare("UPDATE rm_requesdownload SET downloadtime = ? , 	ip = ?, 	useragent = ?,download= download +1 where id= ?");
		 
			$query->bindValue(1, $downloadtime);
			$query->bindValue(2, $ip);
			$query->bindValue(3, $useragent);
			$query->bindValue(4, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function get_DownloadDrawing($id_kon,$user="no") {
			
			if($user=="no"){
				$strUser=" ";
			}else{
				$strUser=" and userid= " . $user ;
			}
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT rd.*, pg.judul FROM `rm_requesdownload` rd LEFT JOIN `og_proj_gambar` pg ON rd.id_drawing = pg.id where id_kon= ? ". $strUser ." ORDER BY `id` DESC ");
			
			$query->bindValue(1, $id_kon);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}		
		public function get_DownloadDrawingId($id) {
			
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_requesdownload` where id= ? ORDER BY `id` DESC limit 1 " );
			
			$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		function encrypt_file($source,$destination,$passphrase,$stream=NULL) {
			// $source can be a local file...
			if($stream) {
				$contents = $source;
			// OR $source can be a stream if the third argument ($stream flag) exists.
			}else{
				$handle = fopen($source, "rb");
				$contents = fread($handle, filesize($source));
				fclose($handle);
			}
		 
			$iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
			$key = substr(md5("\x2D\xFC\xD8".$passphrase, true) . md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
			$opts = array('iv'=>$iv, 'key'=>$key);
			$fp = fopen($destination, 'wb') or die("Could not open file for writing.");
			stream_filter_append($fp, 'mcrypt.tripledes', STREAM_FILTER_WRITE, $opts);
			fwrite($fp, $contents) or die("Could not write to file.");
			fclose($fp);
		 
		}

		function decrypt_file($file) {
		 $passphrase="H89jv3Twhv";
		 
			$iv = substr(md5("\x1B\x3C\x58".$passphrase, true), 0, 8);
			$key = substr(md5("\x2D\xFC\xD8".$passphrase, true) .
			md5("\x2D\xFC\xD9".$passphrase, true), 0, 24);
			$opts = array('iv'=>$iv, 'key'=>$key);
			$fp = fopen($file, 'rb');
			stream_filter_append($fp, 'mdecrypt.tripledes', STREAM_FILTER_READ, $opts);
		 
			return $fp;
		}

		public function uploadfilePDF($file,$namabaru,$folderpath,$encrip="yes"){
			
			$passwords="H89jv3Twhv";
			
			if ($encrip=="yes"){
				$Orinamabaru= $namabaru ;
				$namDowngrade= "down_". $Orinamabaru;
				$namabaru="raw_" . $namabaru ;
			}	
				$upload = new Upload();
				//upload->SetMaximumFileSize(1048576);
				$upload->SetFileName($namabaru);
				$upload->SetTempName($file);
				$upload->SetUploadDirectory($folderpath); //Upload directory, this should be writable
				$upload->SetValidExtensions(array('pdf')); //Extensions that are allowed if none are set all extensions will be allowed.
				 
						if ($upload->UploadFile()==true){

							//realpath

							// $output_including_status=shell_exec( "gswin64c -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dQUIET -dBATCH -sOutputFile=".$folderpath.$namDowngrade." ".$folderpath.$namabaru.""); 
							
							$output_including_status=shell_exec( "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dAutoRotatePages=/None -dQUIET -dBATCH -sOutputFile=".$folderpath.$namDowngrade." ".$folderpath.$namabaru."");
							
							//$output_including_status = shell_exec("command 2>&1; echo $?");
							echo "Warning : " .$output_including_status ;

							if ($encrip=="yes"){//set encript
								$this->encrypt_file($folderpath.$namDowngrade ,$folderpath.$Orinamabaru,$passwords);
								$this->dellFilegambar($folderpath.$namabaru);
								$this->dellFilegambar($folderpath.$namDowngrade);
							}
							return true;
						}else {
							return false;	
						}
						
		}
		public function dellFilegambar($alamat){
				if (file_exists($alamat)) {
					unlink($alamat);
				}
		}

		public function xor_this($string) {

		// Let's define our key here
		 $key = ('magic_key');

		 // Our plaintext/ciphertext
		 $text =$string;

		 // Our output text
		 $outText = '';

		 // Iterate through each character
		 for($i=0;$i<strlen($text);)
		 {
			 for($j=0;($j<strlen($key) && $i<strlen($text));$j++,$i++)
			 {
				 $outText .= $text{$i} ^ $key{$j};
				 //echo 'i='.$i.', '.'j='.$j.', '.$outText{$i}.'<br />'; //for debugging
			 }
		 }  
		 return $outText;
		}

		public function InsertUploadStamp($id_gambar, $userid, $gambar,$idkon,$nodrawing,$file,$rev='',$tipeApprovaldrawing=0){
		
		$tanggal = date("Y-m-d H:i:s");
		
		$query 	= $this->db->prepare("INSERT INTO `rm_stamp` (id_gambar, tanggal, userid,  	gambar,id_kon ,file, nodrawing,rev,drawingstatus) VALUES (?, ?, ?, ?,?,?,?,?,?) ");

		$query->bindValue(1, $id_gambar);
		$query->bindValue(2, $tanggal);
		$query->bindValue(3, $userid);
		$query->bindValue(4, $gambar);
		$query->bindValue(5, $idkon);
		$query->bindValue(6, $file);
		$query->bindValue(7, $nodrawing);
		$query->bindValue(8, $rev);
		$query->bindValue(9, $tipeApprovaldrawing);


		try{
			$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
		}	
		}

		public function DeletedUploadStamp($no_id  , $id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("DELETE FROM   rm_stamp  where id =?  and  id_kon= ? LIMIT 1");
			$query->bindValue(1, $no_id);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		}
		public function UpdateUploadStamp($user_id, $status ,$id ){
	  	$reviewdate = date("Y-m-d H:i:s");
			$query 	= $this->db->prepare("UPDATE rm_stamp SET review = ? , 	status = ?, reviewdate 	 = ? where id= ?");
		 
			$query->bindValue(1, $user_id);
			$query->bindValue(2, $status);
			$query->bindValue(3, $reviewdate);
			$query->bindValue(4, $id);

			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function get_UploadStamp($idkon,$user="all",$tipe=0) {
			
			if($user=="all"){
				$struser=" ";
			}else{
				$struser=" and s.userid = " . $user ;
			}

			if($tipe== 0){
				$strTipe=" ";
			}else{
				$strTipe=" and G.tipe = " . $tipe ;
			}
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT s.id,s.id_gambar,s.nodrawing,s.gambar,s.tanggal,s.review,s.reviewdate,s.drawingstatus,s.rev,G.tipe FROM `rm_stamp` s left join og_proj_gambar G on G.id=s.id_gambar   where s.id_kon= ?  " . $struser . $strTipe . " ORDER BY s.`id` DESC  " );
			
			$query->bindValue(1, $idkon);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function get_UploadStampbyNotYetapproved($idkon,$user="all") {
			
			if($user=="all"){
				$struser=" ";
			}else{
				$struser=" and s.userid = " . $user ;
			}
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT s.id_kon,s.id,s.nodrawing,s.gambar,s.tanggal,s.review,s.reviewdate,s.drawingstatus,G.tipe FROM `rm_stamp` s left join og_proj_gambar G on G.id=s.id_gambar   where s.id_kon= ?  and s.status=0 " . $struser . " ORDER BY s.`id` DESC  " );
			
			$query->bindValue(1, $idkon);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function get_kontrakUploadStampbyNotYetapproved() {
			

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT DISTINCT id_kon FROM `rm_stamp` where status =0" );
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}							

		public function get_CountUploadStampbyNotYetapproved() {
					 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT s.id_kon,s.id,s.nodrawing,s.gambar,s.tanggal,s.review,s.reviewdate,s.drawingstatus,G.tipe FROM `rm_stamp` s left join og_proj_gambar G on G.id=s.id_gambar   where  s.status=0 "  . " ORDER BY s.`id` DESC  " );
			
			
			try{
				$query->execute();
				$count = $query->rowCount();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			if ($count >0 ){
				return true;
			}else{
				return false;
			}
		}		
		public function get_UploadStampByid($id,$idkon) {
			
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_stamp` where id= ? and id_kon=? ORDER BY `id` DESC  limit 1" );
			
			$query->bindValue(1, $id);
			$query->bindValue(2, $idkon);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function get_UploadStampByidnolimit($id,$idkon) {
			
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_stamp` where id_gambar= ? and id_kon=? ORDER BY `id` DESC " );
			
			$query->bindValue(1, $id);
			$query->bindValue(2, $idkon);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}				

		public function CekExistDrawing($idkon,$id_gambar,$rev='') {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_stamp` where id_kon= ?  and  id_gambar =? and rev =? ORDER BY `id` DESC ");
			$query->bindValue(1, $idkon);
			$query->bindValue(2, $id_gambar);
			$query->bindValue(3, $rev);
			
			try{
				$query->execute();
				
				$count = $query->rowCount();
			
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			if ($count >0 ){
				return true;
			}else{
				return false;
			}
		}		
		
		public function CekAlreadyReview($id_gambar) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT review FROM `rm_stamp` where id =? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id_gambar);

			$query->bindColumn('review', $hak);
			try{
				$query->execute();
				
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			if ($hak!=0){
				return true;
			}else{
				return false;
			}
		}
		
		
		public function insert_generaldata($type, $param1, $param2, $param3, $param4,$param5,$param6,$param7,$param8,$id_kon) {
		
		$createdate=date("Y-m-d H:i:s"); 
		$query 	= $this->db->prepare("INSERT INTO `og_generalinput` (type, param1, param2, param3, param4,param5,param6,param7,param8,id_kon,  createdate 	) VALUES (?, ?, ?, ?, ?,?,?,?,?,?,?) ");

		$query->bindValue(1, $type);
		$query->bindValue(2, $param1);
		$query->bindValue(3, $param2);
		$query->bindValue(4, $param3);
		$query->bindValue(5, $param4);
		$query->bindValue(6, $param5);
		$query->bindValue(7, $param6);
		$query->bindValue(8, $param7);
		$query->bindValue(9, $param8);
		$query->bindValue(10, $id_kon);
		$query->bindValue(11, $createdate);
		try{
			$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
		}	
		
		}
		
		public function Delete_generalData($no_id  , $id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("DELETE FROM   og_generalinput  where id =?  and  id_kon= ? LIMIT 1");
			$query->bindValue(1, $no_id);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		}
		
		public function get_Generaldata($id_projt,$type="all") {
			
			if ($type!="all"){
				$strtambahan=" and type=" . $type ; 
			}
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_generalinput` where id_kon= ? " . $strtambahan . " ORDER BY `type` asc ,`id` asc");
			$query->bindValue(1, $id_projt);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function insert_logSynch($activity,$id_kon, $textc, $synktime) {
		
		$query 	= $this->db->prepare("INSERT INTO `og_logsynch` (activity,id_kon, textc, synktime  ) VALUES (?, ?, ?, ?) ");

		$query->bindValue(1, $activity);
		$query->bindValue(2, $id_kon);
		$query->bindValue(3, $textc);
		$query->bindValue(4, $synktime);

		try{
			$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
		}	
		
		}
		public function get_logSynchidKon($idkon) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_logsynch` where id_kon= ? ORDER BY `id` DESC");
			$query->bindValue(1, $idkon);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}		
		
		private function getCountDraw($table,$filter){
			
			$query = $this->db->prepare("SELECT * FROM ". $table. " where " . $filter );
	
			try{
				$query->execute();
				$count = $query->rowCount();
				return $count ;
				
			}catch(PDOException $e){
				die($e->getMessage());
			}			
		}
		public function GetCountAllDraw($idkontrak){
			$table="og_sub_proj_gambar" ;
			$filter= "id_kontrak=" . $idkontrak ;
			$jml=$this->getCountDraw($table,$filter);
			return $jml;
		}
		public function GetCountDrawtipedata($idkontrak,$tipe){
			$table="og_proj_gambar" ;
			$filter= "id_kontrak=" . $idkontrak . " and tipe=" . $tipe ;
			$jml=$this->getCountDraw($table,$filter);
			return $jml;
		}
		public function GetCountunixDrawing($idkontrak){
			$table="og_proj_gambar" ;
			$filter= "id_kontrak=" . $idkontrak  ;
			$jml = $this->getCountDraw($table,$filter);
			return $jml;
		}
		public function GetCountDrawDone($idkontrak){
			$table="rm_stamp" ;
			$filter= "id_kon=" . $idkontrak . " group by id_gambar" ;
			$jml=$this->getCountDraw($table,$filter);
			return $jml;
		}		
		public function GetCountdrawApproval($idkontrak){
			$table="og_proj_gambar" ;
			$filter= "id_kontrak=" . $idkontrak . " and forinfo=0 "  ;
			$jml = $this->getCountDraw($table,$filter);
			return $jml;
		}
		public function GetCountDrawEngfield($idkontrak,$tipe){
			$table=" og_sub_proj_gambar s left join og_proj_gambar g on s.`id_project_gamb`=g.id" ;
			$filter= "s.id_kontrak=" . $idkontrak . " and g.engfield=" . $tipe ;
			$jml=$this->getCountDraw($table,$filter);
			return $jml;
		}

		public function getSynkKontrak($tanggal) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT COUNT(id), id_kon FROM og_logsynch where synktime =? GROUP BY id_kon ");
			$query->bindValue(1, $tanggal);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function getListSynkKontrak($tanggal,$idkon) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_logsynch` where id_kon = ? and synktime = ? ");
			$query->bindValue(1, $idkon);
			$query->bindValue(2, $tanggal);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function GetDrawingListAlldata($tanggal,$idkon) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT g.forinfo, g.engfield, g.id,g.id_kontrak,g.no_gambar,g.judul,g.tipe,g.tanggal as submit_gambar ,s.review, s.status,s.userid,s.reviewdate,s.id as id_stamp, gr.rev, s.tanggal as upload_stamp, g.updateat FROM `og_proj_gambar` g  left join rm_stamp s on g.id = s.id_gambar left join (SELECT id, `id_project_gamb`, `revisi` as rev FROM og_sub_proj_gambar WHERE id IN (SELECT MAX(id) FROM og_sub_proj_gambar where `id_kontrak`=? GROUP BY `id_project_gamb`)) as gr on g.id=gr.id_project_gamb  where  g.id_kontrak= ? and g.updateat <= ?   ORDER BY  g.updateat  DESC");
			$query->bindValue(1, $idkon);
			$query->bindValue(2, $idkon);
			$query->bindValue(3, $tanggal);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function get_tipe_gambar_field() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_tipe_drawing_field`  ORDER BY `id` DESC");
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}


			$hasils =$query->fetchAll();
			$EngFiledarr=array();
			$EngFiledarr[0]="uncategory";
			foreach ($hasils as $hasil) {
				$EngFiledarr[$hasil['id']]=$hasil['engField'] ;
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $EngFiledarr;
		}

		public function GetTipeapprovalDrawing() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_tipeaprrovaldrawing` ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function get_lastdrawingByidgambar($id_gambar) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_sub_proj_gambar` where id_project_gamb = ?  ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id_gambar);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}


		public function Fixingdatabase() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM og_subgambar_comment where id_subGam = 0 ");
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

			$results = $query->fetchAll();

			foreach ($results as $result) {

				$jml = $this->getCountDraw("og_sub_proj_gambar","id_project_gamb = " . $result['id_gamb']);

				if ($jml == 1 ){

					$resluts2 = $this->get_lastdrawingByidgambar($result['id_gamb']);

					$id_sub= 0 ;
					foreach ($resluts2 as $reslut2) {

						$id_sub= $reslut2['id'];
						
					}


							$query 	= $this->db->prepare("UPDATE og_subgambar_comment SET id_subGam = $id_sub  where id= $result[id] ");
		 
							$query->bindValue(1, $updatetime);
							$query->bindValue(2, $rev);
							$query->bindValue(3, $idGam);
						 
							try{
								$query->execute();

							}catch(PDOException $e){
								die($e->getMessage());
							}





				}
				
			}

			echo "oke" ;
		}


		public function Delete_All_stampdraw($no_id_gam  , $id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("DELETE FROM   rm_stamp  where id_gambar =?  and  id_kon= ? ");
			$query->bindValue(1, $no_id_gam);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			
		}

		public function GetAlldrawingandComment($idkontract){

			$query = $this->db->prepare("SELECT g.id, g.no_gambar, g.judul ,g.tanggal,s.revisi, s.id as idstamp,c.id as idcomment, c.nomer_comment, c.comment , c.reviewat, st.reviewdate as drawingreviewdate,st.drawingstatus, c.status as commentstatus FROM `og_sub_proj_gambar` s left join og_proj_gambar g on s.id_project_gamb = g.id left join rm_stamp st on (s.id_project_gamb = st.id_gambar and s.revisi = st.rev) left join og_subgambar_comment sb on s.id=sb.id_subGam left join og_comment c on sb.id_comment= c.id  where s.id_kontrak =? order by g.judul, s.id, c.id");
			$query->bindValue(1, $idkontract);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			return $query->fetchAll();


		}

		public function allDrawingAndCommentGrouped($idkontract, $type, $date){

			$query = $this->db->prepare("SELECT g.no_gambar, g.judul ,g.tanggal,s.revisi, s.id as idstamp,c.id as idcomment, c.nomer_comment, c.comment, c.tipe as commenttype, c.reviewat, c.commentcategory, st.reviewdate as drawingreviewdate,st.drawingstatus, c.status as commentstatus FROM `og_sub_proj_gambar` s left join og_proj_gambar g on s.id_project_gamb = g.id left join rm_stamp st on (s.id_project_gamb = st.id_gambar and s.revisi = st.rev) left join og_subgambar_comment sb on s.id=sb.id_subGam left join og_comment c on sb.id_comment= c.id  where s.id_kontrak =? and g.tipe=? and date(st.reviewdate)=? order by g.judul, s.id, c.id");
			$query->bindValue(1, $idkontract);
			$query->bindValue(2, $type);
			$query->bindValue(3, $date);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			return $query->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

		}



			public function GetDrawingSubFromIdStamp($idStamp){

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT sb.id FROM `rm_stamp`s left join og_sub_proj_gambar sb on (s.id_gambar=sb.id_project_gamb and s.rev=sb.revisi) where s.id = ?  ORDER BY s.`id` DESC limit 1");

			$query->bindValue(1, $idStamp);
			
			$query->bindColumn('id', $hak);
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

		public function updateStampPath($path, $idstamp)
		{
			$query 	= $this->db->prepare("UPDATE rm_stamp SET file = ? WHERE id= ?");
		 
			$query->bindValue(1, $path);
			$query->bindValue(2, $idstamp);

			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}


		public function Get_listTaskDrawing($id_subdrawing) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_corelationtaskdrawing` c left join rm_project_tasks t on c.`task_objectid`=t.object_id where c.id_subdrawing=?");
			$query->bindValue(1, $id_subdrawing);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}	


public function updateProgressTaskDrawing($completed_by_id,$percent_completed,$object_id){
		
		if ($percent_completed>=100){

			$percent_completed= 100 ;
			$completed_on= date("Y-m-d H:i:s");
			$completed_by_id =$completed_by_id ;

		}else{
			$completed_on = date("0000-00-00 00:00:00");
			$completed_by_id=$completed_by_id;
			$percent_completed =intval($percent_completed);

		}
				

		$query 	= $this->db->prepare("UPDATE rm_project_tasks SET completed_on  = ? , completed_by_id  = ? , percent_completed  =?	where object_id = ?  ");
		 
			$query->bindValue(1, $completed_on);
			$query->bindValue(2, $completed_by_id);
			$query->bindValue(3, $percent_completed);
			$query->bindValue(4, $object_id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		
		
		}
		

	public function GetIDDrawingSubFromIdgambardanrev($idGambar,$rev){

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT s.id FROM `og_sub_proj_gambar` s  left join og_proj_gambar d on s.id_project_gamb = d.id where s.id_project_gamb=? and s.revisi=?  ORDER BY s.`id` DESC limit 1");

			$query->bindValue(1, $idGambar);
			$query->bindValue(2, $rev);
			
			$query->bindColumn('id', $hak);
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


		public function UpdateTaskkprojectUSer($idGambar,$rev,$percent_completed,$completed_by_id){

			$id_subdrawing= $this->GetIDDrawingSubFromIdgambardanrev($idGambar,$rev);

			$lstSubdrawingTasks= $this->Get_listTaskDrawing($id_subdrawing);

			foreach ($lstSubdrawingTasks as $lstSubdrawingTask) {
				

				$object_id= $lstSubdrawingTask['task_objectid'];

				$this->updateProgressTaskDrawing($completed_by_id,$percent_completed,$object_id);

			}



		}

		public function getMailByProjectId($projid)
		{
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_mail_aggregate` where proj_id = ?");
			$query->bindValue(1, $projid);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function getUploadStampArray($id, $idkon)
		{
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_stamp` where id= ? and id_kon=? ORDER BY `id` DESC limit 1");
			
			$query->bindValue(1, $id);
			$query->bindValue(2, $idkon);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			$result = $query->fetchAll(PDO::FETCH_ASSOC);
			return $result[0];
		}

		public function updateTextTask($idGambar,$rev, $act){

			$id_subdrawing= $this->GetIDDrawingSubFromIdgambardanrev($idGambar,$rev);

			$lstSubdrawingTasks= $this->Get_listTaskDrawing($id_subdrawing);

			$objectIdArr = array();

			foreach ($lstSubdrawingTasks as $lstSubdrawingTask) {
				
				$object_id= $lstSubdrawingTask['task_objectid'];

				if($act == "reject")
				{
					$text = str_replace("--[The corresponding stamped drawing has been submitted]--<br><br>", "", $lstSubdrawingTask['text']);
					$text = "--[The stamped drawing has been rejected]--<br><br>".$text;
					$this->updateTextTaskDrawing($text, $object_id);	
				}else if($act =="submit")
				{
					$text = str_replace("--[The stamped drawing has been rejected]--<br><br>", "", $lstSubdrawingTask['text']);
					$text = "--[The corresponding stamped drawing has been submitted]--<br><br>".$text;
					$this->updateTextTaskDrawing($text, $object_id);
				}
				
				array_push($objectIdArr, $object_id);
			}

			return $objectIdArr;

		}

		public function updateTextTaskDrawing($text, $object_id)
		{		

			$query 	= $this->db->prepare("UPDATE rm_project_tasks SET text  = ? where object_id = ?");
		 
			$query->bindValue(1, $text);
			$query->bindValue(2, $object_id);
			
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}

		public function Checkid_subGambar($idgambar,$revisi,$id_kontrak, $idsubgambar){

			// #preparing a statement that will select all the registered users, with the most recent ones first.
			// $query = $this->db->prepare("SELECT id as id_sub FROM `og_sub_proj_gambar` where id_project_gamb =? and id_kontrak=? and revisi= ? limit 1 ");

			// $query->bindValue(1, $idgambar);
			// $query->bindValue(2, $id_kontrak);
			// $query->bindValue(3, $revisi);			

			// $query->bindColumn('id_sub', $hak);
			// try{
			// 	$query->execute();
				
			// 	while ($row = $query->fetch(PDO::FETCH_BOUND)) {

			// 		}
			// }catch(PDOException $e){
			// 	die($e->getMessage());	
			// }

			$hak = $this->GetIDDrawingSubFromIdgambardanrev($idgambar,$revisi);

			if ($hak == $idsubgambar ) {
				return true ;
				# code...
			}else {
				return false ;
			}

		}

		public function CekHUmanErrorByfilename($filename,$idgambar,$revisi,$id_kontrak){



			if (strpos($filename, '###') !== false) {

			    $namafilearray = explode("###", $filename); 
			    $id_subdrawing= $namafilearray[1] ; 
			    $this->Checkid_subGambar($idgambar,$revisi,$id_kontrak, $id_subdrawing);

			    //echo $namafilearray[1];
			    return true ;
			}else{
				//echo "ga ada file" ;
				return false ;
			}

		}



}
?>
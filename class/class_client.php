<?php
class client{

private $db;
const HOST = '10.0.1.53';
const USERNAME = 'zee-client';
const PASS = '!!mattel#$%2904';
const DBNAME = 'dbbkiweb';

		 
		public function __construct() {
			if (self::CheckConectionPDO()==true){
				$this->db = $this->connectDatabase();
			}else{
				echo "Error !: can't connect database client" ;
				die;
			}
		}
		
		function connectDatabase(){
			 try {
			    $db = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::DBNAME, self::USERNAME, self::PASS);
			} catch (PDOException $e) {
			    print "Error!: can't connect database" . $e->getMessage() . "<br/>";
			}
			 return $db ;
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
		public function insertClient($nick,$sandi ,	$garam ,	$user ,	$aka,$email,$id){
		$tanggal = date("Y-m-d H:i:s");
		$locked=0;


		$query 	= $this->db->prepare("INSERT INTO `rm_client` (nick,sandi,garam,user,locked,aka,tanggal,email,id_client,kolabolator ) VALUES (?,?, ?, ?, ?, ?, ?, ?,?,?) ");

	 
		$query->bindValue(1, $nick);
		$query->bindValue(2, $sandi);
		$query->bindValue(3, $garam);
		$query->bindValue(4, $user);
		$query->bindValue(5, $locked);
		$query->bindValue(6, $aka);
		$query->bindValue(7, $tanggal);
		$query->bindValue(8, $email);
		$query->bindValue(9, $id);
		$query->bindValue(10, 0);
	

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

		//dell log client
		$this->dell_loginattemp($id_client);	
	}

	public function Getfaq(){
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_faq` ORDER BY `id` desc ");


			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();	
	}
	
	public function insertFaq($subject,$description,$oleh){

		$tanggal = date("Y-m-d H:i:s");
		$query 	= $this->db->prepare("INSERT INTO `rm_faq` (subject,description,createon,oleh ) VALUES (?,?, ?, ?) ");
	 
		$query->bindValue(1, $subject);
		$query->bindValue(2, $description);
		$query->bindValue(3, $tanggal);
		$query->bindValue(4, $oleh);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}
	public function dellfaq($id) {
		
		$query 	= $this->db->prepare("DELETE FROM `rm_faq` WHERE `rm_faq`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function GetTechnicalAsk($id_kon){
				#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `rm_technicalquery` left join rm_client on rm_technicalquery.askby=rm_client.id_client where id_kon= ? ORDER BY `id` desc");
			$query->bindValue(1, $id_kon);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();	
	}
	public function dellTechnical($id) {
		
		$query 	= $this->db->prepare("DELETE FROM `rm_technicalquery` WHERE `rm_technicalquery`.`id` = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}
	public function Answertechnical($id, $answer,$user_id){
	$tanggal = date("Y-m-d H:i:s");
		$query 	= $this->db->prepare("UPDATE rm_technicalquery SET  answer= ?,answeron=?,answerby=?  where id= ?");
	 
		$query->bindValue(1, $answer);
		$query->bindValue(2, $tanggal);
		$query->bindValue(3, $user_id);
		$query->bindValue(4, $id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
	}

	public function getQuestion($id)
	{
		$query = $this->db->prepare("SELECT subject FROM rm_technicalquery where id = ?");
			$query->bindValue(1, $id);	
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
	}

		public function get_proj_gambar_tempsynk() {

		$statement="SELECT * FROM `og_proj_gambar_temp1` where  synch = 1 ORDER BY `id` DESC "  ; 
		 
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

		public function getJumlahDrawingtemp() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_proj_gambar_temp1` where  synch = 1 ORDER BY `id` DESC ");

			try{
				$query->execute();
				
				$count = $query->rowCount();
			
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 return $count ; 
		}
		
		public function PindahFile($alamatServer){
			$servername="https://armada.bki.co.id/Zee-client/";
			$fullpath =$servername . $alamatServer ;
			$alamatlocal="../" . $alamatServer;

			$namaFolder=dirname($alamatlocal);
			//echo dirname($alamatlocal) . PHP_EOL ;

			if(!is_dir($namaFolder)){
				echo $namaFolder ;
				if (!mkdir($namaFolder,0775,true)){
					echo "fail to create folder";
				}
			}


			$arrContextOptions=array(
			    "ssl"=>array(
			        "verify_peer"=>false,
			        "verify_peer_name"=>false,
			    ),
			);  

			$strFile=file_get_contents($fullpath, false, stream_context_create($arrContextOptions));
			file_put_contents($alamatlocal, $strFile);
			
			if  (file_exists($alamatlocal)&&(filesize($alamatlocal)>0)){
				return true ;
			}else{
				return false ;
			}
			
		}
		
		public function get_subproj_gambar_tempsynk() {

		$statement="SELECT * FROM `og_sub_proj_gambar` ORDER BY `id` ASC "  ; 
		 
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

		public function Delete_id_revisi_drawsynk($id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("DELETE FROM   og_sub_proj_gambar  where id =?  LIMIT 1");
			$query->bindValue(1, $id);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		}

		public function get_replay() {
	
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_subreplay_comment`ORDER BY `id` DESC ");
	
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}	
		public function delet_replay_id($id_comment){
	 
			$query 	= $this->db->prepare("DELETE FROM og_subreplay_comment WHERE id=?  ");
		 
			$query->bindValue(1, $id_comment);


			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}		
		private function getCountTechnical($table,$filter){
			
			$query = $this->db->prepare("SELECT * FROM ". $table. " where " . $filter );
	
			try{
				$query->execute();
				$count = $query->rowCount();
				return $count ;
				
			}catch(PDOException $e){
				die($e->getMessage());
			}			
		}			
		public function GetCountAllTechnical($idkontrak){
			$table="rm_technicalquery" ;
			$filter= "id_kon=" . $idkontrak ;
			$jml=$this->getCountTechnical($table,$filter);
			return $jml;
		}		
		public function GetCountAnswerTechnical($idkontrak){
			$table="rm_technicalquery" ;
			$filter= "id_kon=" . $idkontrak . " and answerby !=0 " ;
			$jml=$this->getCountTechnical($table,$filter);
			return $jml;
		}

		public function GetActivityClient($idClient){

			$table="rm_activity" ;
			$filter= "client_id=" . $idClient ;
			
			$query = $this->db->prepare("SELECT * FROM ". $table. " where " . $filter );
	
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function insertLogSyncClient($activity,$id_kon,$textc){

		$query 	= $this->db->prepare("INSERT INTO `og_logsyncclient` (`activity`, `id_kon`, `textc` ) VALUES (?,?, ?) ");
	 
		$query->bindValue(1, $activity);
		$query->bindValue(2, $id_kon);
		$query->bindValue(3, $textc);
	
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}

		public function GetLogSyncClient($id_kon) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_logsyncclient` where id_kon=? ORDER BY `id` desc ");

			$query->bindValue(1, $id_kon);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		private function CheckConectionPDO(){
			try{
			    $dbh = new pdo('mysql:host=' . self::HOST . ';dbname=' . self::DBNAME, self::USERNAME, self::PASS,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
			    //die(json_encode(array('outcome' => true)));
			    return true ;
			}
			catch(PDOException $ex){
			    //die(json_encode(array('outcome' => false, 'message' => 'Unable to connect')));
			    return false ;
			
			}

		}			


		

		//--------------Notification--------------------
		
		public function insertNotification($proj, $item, $desc, $link, $type)
		{
			$query 	= $this->db->prepare("INSERT INTO `rm_project_notifall` (`id_kon`, `Item`, `Description`, `link`, `type` ) VALUES (?,?,?,?,?)");
	 
			$query->bindValue(1, $proj);
			$query->bindValue(2, $item);
			$query->bindValue(3, $desc);
			$query->bindValue(4, $link);
			$query->bindValue(5, $type);
		
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function getNotificationByProj($proj, $type)
		{	
			$query = $this->db->prepare("SELECT a.*, b.mail, b.mread FROM rm_project_notifall a LEFT JOIN rm_notif b ON a.id = b.id_projectnotif where a.id_kon=? and a.type=?");
			$query->bindValue(1, $proj);
			$query->bindValue(2, $type);	
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function getSettingByIdClient($setting, $client)
		{	
			if($setting == "notif")
			{
				$query = $this->db->prepare("SELECT * FROM `rm_notif_setting` where notif_email=1 and client_id=?");
				$query->bindValue(1, $client);	
			}else if($setting == "digest")
			{
				$query = $this->db->prepare("SELECT * FROM `rm_notif_setting` where notif_email=1 and digest=1 and client_id=?");
				$query->bindValue(1, $client);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function insertStatusNotif($clientId, $link, $field, $idNotif)
		{
			$query 	= $this->db->prepare("INSERT INTO rm_notif (client_id, $field, link, id_projectnotif) VALUES (?,?,?,?)");
	 
			$query->bindValue(1, $clientId);
			$query->bindValue(2, 1);
			$query->bindValue(3, $link);
			$query->bindValue(4, $idNotif);

			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function setNotifEmail($users, $additional, $id_kon, $type)
		{
			$addr = array();
			foreach($users as $usr)
			{
				$idClient = $usr['id_client'];
				$setting = $this->getSettingByIdClient("notif", $idClient);
				if(!empty($setting))
				{
					foreach($setting as $st)
					{
						$address = $st['email_address'];

						if($st['type'] == $type)
						{
							$allNotif = $this->getNotificationByProj($id_kon, $type);
							$mailBody = "<p>You have unread notifications:</p>
										<ol>
										";
							$notifArr = array();

							foreach($allNotif as $an)
							{
								$mail = $an['mail'];
								$mread = $an['mread'];
								if($mail != 1 && $mread != 1)
								{
									$mailBody = $mailBody."
															<li>
																$an[Item] $additional
																<br>
																$an[link]
															</li>
															<p>To get the details, please access Armada-Zee</p>
															";
									array_push($notifArr, array('id'=>$an['id'], 'link'=>$an['link']));
								}
							}
							$mailBody = $mailBody."</ol>";
							array_push($addr, $address);
						}
					}
				}
			}

			return array('address'=>$addr, 'body'=>$mailBody, 'notif'=>$notifArr);
		}

		public function setStatus($users, $proj, $field, $allNotif, $type)
		{
			foreach($users as $usr)
			{
				$idClient = $usr['id_client'];
				$setting = $this->getSettingByIdClient("notif", $idClient);
				if(!empty($setting))
				{
					foreach($setting as $st)
					{
						if($st['type'] == $type)
						{
							foreach($allNotif as $an)
							{
								$link = $an['link'];
								$idNotif = $an['id'];
								$this->insertStatusNotif($idClient, $link, $field, $idNotif);
							}
						}
					}
				}	
			}
		}


	public function dell_loginattemp($id) {
		
		$query 	= $this->db->prepare("DELETE FROM `login_attempts` WHERE user_id = ? ");
	 
		$query->bindValue(1, $id);

		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}
	}

	public function notificationProcess($id_kon, $item, $desc, $link, $type, $kontrak, $obj)
	{
		try
		{
			$this->insertNotification($id_kon, $item, $desc, $link, $type);
			$users = $kontrak->getClientOfProject($id_kon);
			$res = $this->setNotifEmail($users, "", $id_kon, $type);

			if(!empty($res['address']))
			{
				$result = $obj->emailHandler("no-reply-zee@bki.co.id","Bahtera Zee", array(), $res['body'], "Zee Notification", $res['address']);
			}else
			{
				$result = "No email sent";
			}

			if($result == "Message sent!")
			{
				$this->setStatus($users, $id_kon, "mail", $res['notif'], $type);
			}
		}catch(\Exeption $e)
		{
			$result = $e->getMessage();
		}
		
		return $result;
	}

	public function getTechnicalQueryUnanswered($idkontrak) {

		$statement="SELECT * FROM `rm_technicalquery` where id_kon=? AND answer='Not yet' ORDER BY `id` DESC "  ; 
		 
		#preparing a statement that will select all the registered users, with the most recent ones first.
		$query = $this->db->prepare($statement);
		
		$query->bindValue(1, $idkontrak);
		
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
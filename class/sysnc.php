<?php
class synk{


		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function lastInsertId(){
			return $this->db->lastInsertId();
		}
		
		public function get_Rules_distribution() {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * from rm_rules_distribution  order by id desc ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function insert_Rules_distribution($jenis_update,$rules,$tipe_rules,$part,$volume,$tahun,$path,$id_relation,$idrules) {
		 
			$tanggal_pub=date("Y-m-d H:i:s");
			
			$a=substr($path, 0, 2);
			if ($a == "./"){
				$path= "." . $path ;
			}else{
				$path = "../" . $path;
			}
			
			$query 	= $this->db->prepare("INSERT INTO `rm_rules_distribution` (jenis_update,rules, tipe_rules, part, volume, tahun, path, id_relation,tanggal_pub,id_rules   ) VALUES (?, ?, ?, ?,?,?,?,?,?,?) ");
		 
			$query->bindValue(1, $jenis_update);
			$query->bindValue(2, $rules);
			$query->bindValue(3, $tipe_rules);
			$query->bindValue(4, $part);
			$query->bindValue(5, $volume);
			$query->bindValue(6, $tahun);
			$query->bindValue(7, $path);
			$query->bindValue(8, $id_relation);
			$query->bindValue(9, $tanggal_pub);
			$query->bindValue(10, $idrules);


			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		
		}
		
		public function delete_Rules_distribution($id_rules_pub){

		$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_rules_distribution` WHERE `rm_rules_distribution`.`id` = ? limit 1");
		$query->bindValue(1, $id_rules_pub);
		
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	

	}
	
		public function Update_name_Rules_distribution($rules, $id ){
	 
			$query 	= $this->db->prepare("UPDATE rm_rules_distribution SET rules= ? where id= ?  ");
		 
			
			$query->bindValue(1, $rules);
			$query->bindValue(2, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function CreateXML(){
			$part_arrays=array("Part 0. General","Part 1. Seagoing Ship","Part 2. Inland Waterway","Part 3. Special Ships","Part 4. Special Equipment and Systems","Part 5. Offshore Technology","Part 6. Statutory","Part 7. Class Notation");
			
			$nama_vol=array("( Vol 0 )","( Vol I )","( Vol II )","( Vol III )","( Vol IV )","( Vol V )","( Vol VI )","( Vol VII )","( Vol VIII )","( Vol IX )","( Vol X )","( Vol XI )","( Vol XII )","( Vol XIII )","( Vol XIV )","( Vol XV )","( Vol XVI )","( Vol XVII )","( Vol XVIII )","( Vol XIX )","( Vol XX )","( Vol XI )","( Vol XXII )","( Vol XXIII )","( Vol XXIV )","( Vol XXV )","( Vol XXVI )","( Vol XXVII )","( Vol XXVIII )","( Vol XXIX )","( Vol XXX )","( Vol XXXI )","( Vol XXXII )","( Vol XXXIII )","( Vol XXXIV )","( Vol XXXV )","( Vol XXXVI )","( Vol XXXVII )","( Vol XXXVIII )","( Vol XXXIX )","( Vol XL )","( Vol XLI )","( Vol XLII )","( Vol XLIII )","( Vol XLIV )","( Vol XLV )");		  


			$nama_vol_G=array("( Vol 0 )","( Vol A )","( Vol B )","( Vol C )","( Vol D )","( Vol E )","( Vol F )","( Vol G )","( Vol H )","( Vol I )","( Vol J )","( Vol K )","( Vol L )","( Vol M )","( Vol N )","( Vol O )","( Vol P )","( Vol Q )","( Vol R )","( Vol S )","( Vol T )","( Vol U )","( Vol V )","( Vol W )","( Vol X )","( Vol Y )","( Vol Z )","( Vol AA )","( Vol AB )","( Vol AC )","( Vol AD )","( Vol AF )","( Vol AG )","( Vol AH )","( Vol AI )","( Vol AJ )","( Vol AK )","( Vol AL )","( Vol AM )","( Vol AN )","( Vol AO )","( Vol AP )","( Vol AQ )","( Vol AR )","( Vol AS )","( Vol AT )");		

			  $doc = new DOMDocument();
			  $doc->formatOutput = true;
  
			  $r = $doc->createElement( "Rules" );
			  $doc->appendChild( $r );
		
			for ($i=0; $i<=7; $i++){
			
				$b = $doc->createElement( "Part_" . $i );
				$b->setAttribute("name", $part_arrays[$i]);
				
				$rulesditrubts = $this->query_for_xml(0, $i);
				
				foreach ($rulesditrubts as $rulesditrubt) { 
				
				if  ($rulesditrubt['tipe_rules']==1 ){$nama= $nama_vol[$rulesditrubt['volume']] ;}elseif ($rulesditrubt['tipe_rules']==3 ) {$nama= $nama_vol_G[$rulesditrubt['volume']] ;}else {$nama= "( Vol " . $rulesditrubt['volume'] . " )"  ;}
				
				if ($rulesditrubt['jenis_update']==0){$nama=$nama . "," . $rulesditrubt['tahun']. " " .$rulesditrubt['rules'] . "," .$rulesditrubt['tahun'] ;}elseif ($rulesditrubt['jenis_update']==1) {$nama=$nama . "," . $rulesditrubt['tahun']. " Corigenda " . $rulesditrubt['rules'] . ",". $this->extract_month($rulesditrubt['tanggal_pub']) . " " . $rulesditrubt['tahun'] ;} elseif($rulesditrubt['jenis_update']==2){$nama=$nama  . ","  . $rulesditrubt['tahun']. " Amendment " . $rulesditrubt['rules'] . "," . $this->extract_month($rulesditrubt['tanggal_pub']) . " " .$rulesditrubt['tahun'] ;}
				
				if (strlen($nama) >= 100 ){$nama=substr($nama, 0, 100) . "..."; }
				
			
				$c= $doc->createElement( "data" );
				$c->setAttribute("name",$nama);
				$c->setAttribute("vol", $rulesditrubt['volume']);
				$c->setAttribute("tipe", $rulesditrubt['tipe_rules']);
				$c->setAttribute("idp", $rulesditrubt['id_relation']);
				$c->setAttribute("id", $rulesditrubt['id_rules']);
				$c->setAttribute("tahun", $rulesditrubt['tahun']);
				$c->setAttribute("jeni_u", $rulesditrubt['jenis_update']);
				$c->setAttribute("path", $rulesditrubt['path']);
				    
					$crc=md5_file($rulesditrubt['path']);
				$c->setAttribute("crc", $crc);
			
				$c->appendChild($doc->createTextNode( preg_replace("/&#?[a-z0-9]+;/i","",$nama). ".pdf"));
				
				$b->appendChild( $c );
				
				}
			
				
			    $r->appendChild( $b );
			
			}
			  $doc->saveXML();
			  $doc->save("../rules_bki.xml");
	
		}
		
		public function query_for_xml($normal, $part){
		

		if ($normal==0 ) {
		$statement="SELECT * FROM `rm_rules_distribution` where part=? order by `tipe_rules`,`volume`,`jenis_update`";
			//$statement="SELECT * from rm_rules_distribution where part =?  order by tahun desc ";
		}else {
			//$statement="SELECT * from rm_rules_distribution where part =?  order by tahun desc ";
		$statement="SELECT * FROM `rm_rules_distribution` where part=? order by `tipe_rules`,`volume`,`jenis_update`";	
		}
		
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare($statement);
			
			$query->bindValue(1, $part);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		
		}
		
		public function update_find_rules_ditribution($id_rules_dist) {
		 
		 //get_id_rules
		 #preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT id_relation from rm_rules_distribution where id= ? limit 1  ");

				#bind Value 
				$query->bindValue(1, $id_rules_dist);
				
				 $query->bindColumn('id_relation', $id_rule_pub);

			try{
				$query->execute();
				
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 

			
		//get-id-rules
		
			$query = $this->db->prepare("SELECT id_rules from rm_rulepub where id= ? limit 1  ");

				#bind Value 
				$query->bindValue(1, $id_rule_pub);
				
				 $query->bindColumn('id_rules', $id_rule);

			try{
				$query->execute();
				
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
	
		

		 //update id
		 
		 		
	 
			$query 	= $this->db->prepare("UPDATE rm_rules_distribution SET id_rules= ? where id= ?  ");
		 
			
			$query->bindValue(1, $id_rule);
			$query->bindValue(2, $id_rules_dist);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	

		 

		
		}
		
		public function delete_rule_dist_before($id_rules){
	
	//select distributin dengan id sama dan bukan amandement
	
	$query = $this->db->prepare("SELECT  * from rm_rules_distribution where id_rules= ? and jenis_update=0 limit 1 ");
			#bind Value 
				$query->bindValue(1, $id_rules);
				
			try{
				$query->execute();
				$jml = $query->rowCount();
					
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			
		//jika numrow > 1 then
			if($jml > 0) { 
			
			//delete rule dist , flag true
			
					$query 	= $this->db->prepare("DELETE FROM `rms`.`rm_rules_distribution` WHERE `rm_rules_distribution`.`id_rules` = ? and `rm_rules_distribution`.`jenis_update`=0 ");
					$query->bindValue(1, $id_rules);

					
					try{
						$query->execute();

					}catch(PDOException $e){
						die($e->getMessage());
					}	
		
				return true;
	
			}else{
			
				return false;
			
			}
	

	}
	
	public function extract_month($tanggalan) {
	
		$month = date("M",strtotime($tanggalan));
		return $month ;
	}
		
		
		








}
?>
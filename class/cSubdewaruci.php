<?php 
class DWR{//DCC_rms
		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function lastInsertId(){
			return $this->db->lastInsertId();
		}
		
		public function insertKontrak($nokontrak,$tglKOntrak,$reg,$nama){
		
		$query 	= $this->db->prepare("INSERT INTO `dw_kontrak` (	nokontrak,  tglKOntrak 	, reg,nama ) VALUES (?,?,?,?) ");
	 
		$query->bindValue(1, $nokontrak);
		$query->bindValue(2, $tglKOntrak);
		$query->bindValue(3, $reg);
		$query->bindValue(4, $nama);
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}			
		
		}
		
		public function dellkontrak($id){
		$query 	= $this->db->prepare("DELETE FROM `dw_kontrak` WHERE `id_kon` = ?  LIMIT 1");
		$query->bindValue(1, $id);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}
		
		public function GetKontrak(){
			$kontrak="'%" . $kontrak . "%'" ;
			
			$query = $this->db->prepare("SELECT * from dw_kontrak where  nokontrak like  $kontrak order by id_kon desc limit 25");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}
		
		public function cekKontrakexist($kontrak){
				$query = $this->db->prepare("SELECT * from dw_kontrak where `nokontrak` = :key limit 1");
			#bind Value 
			
			$query->bindParam(':key', $kontrak, PDO::PARAM_STR);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			$jml = $query->rowCount();
			
			if ($jml>0 ){
			return true;
			}else{
			return false;
			}
		
		}

		public function insertRegister($reg,$namaKpl,$LBP, $T,$GT, $tahun_bangun){
		
		$query 	= $this->db->prepare("INSERT INTO `dw_register` (	reg,namaKpl,LBP, T,GT, tahun_bangun  ) VALUES (?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $reg);
		$query->bindValue(2, $namaKpl);
		$query->bindValue(3, $LBP);
		$query->bindValue(4, $T);
		$query->bindValue(5, $GT);
		$query->bindValue(6, $tahun_bangun);
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		}
		
		public function  getRgister(){
					$query = $this->db->prepare("SELECT * from dw_register  order by id desc ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		}

		public function dellRegister(){
		
		}
		
		public function gettypeDraw(){
		
		$query = $this->db->prepare("SELECT * from dw_typedraw  ");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		
		} 

		public function insertKontrakgambar($nokontrak,$namagambar,$typedraw){
		
		$query 	= $this->db->prepare("INSERT INTO `dw_kontrak_gambar` (		nokontrak, namagambar,typedraw   ) VALUES (?,?,?) ");
	 
		$query->bindValue(1, $nokontrak);
		$query->bindValue(2, $namagambar);
		$query->bindValue(3, $typedraw);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}		
		}
		
		public function getkontrakgambarbycontract($nokontrak){
		$query = $this->db->prepare("SELECT * from dw_kontrak_gambar where nokontrak = ?  ");

		$query->bindValue(1, $nokontrak);
		
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();		
		
		}
		public function getkontrakgambartype($nokontrak,$tipegambar){
		//select rule pub white aktif dan id sama
			$query = $this->db->prepare("SELECT * from dw_kontrak_gambar where nokontrak = ? and typedraw = ?  ");
			#bind Value 
				$query->bindValue(1, $nokontrak);
				$query->bindValue(2, $tipegambar);

				$query->bindColumn('id_gam', $hak);	
				
			try{
				$query->execute();
			 $jml = $query->rowCount();
			 
			 		while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			 
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

			if ($jml== 0 ) {
			
				$this->insertKontrakgambar($nokontrak,"untitled",$tipegambar);
				$hak=$this->lastInsertId();
				return $hak ;
			}else{
			
				return $hak ;
			}
					
		
		
		
		}
			
		public function dellKontrakgambar(){
		
		}

		public function editKontrakgambar(){
		
		}
		
		public function insertRevtblGambar($id_gam,$rev,$file,$userId ){
		
		
		$query 	= $this->db->prepare("INSERT INTO `dw_revisigamb` (id_gam,rev,file,userId) VALUES (?,?,?,?) ");
	 
		$query->bindValue(1, $id_gam);
		$query->bindValue(2, $rev);
		$query->bindValue(3, $file);
		$query->bindValue(4, $userId);
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}	
		
		}
		
		public function getRevisibyIDgambar($id_gam){
		
		$query = $this->db->prepare("SELECT * from dw_revisigamb where id_gam = ?  ");

		$query->bindValue(1, $id_gam);
		
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();	
		
		}

		public function getCountRevGambar($id_gam){
		
		//select rule pub white aktif dan id sama
			$query = $this->db->prepare("SELECT rev from dw_revisigamb where id_gam = ?  ");
			#bind Value 
				$query->bindValue(1, $id_gam);
				 
			try{
				$query->execute();
			 $jml = $query->rowCount();
				
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

			return $jml ;
		}

		public function insertRevGambar($nokontrak,$file, $userId,$tipegambar ){
		
		$id_gam= $this->getkontrakgambartype($nokontrak,$tipegambar);
		
		$jml=$this->getCountRevGambar($id_gam);
		$rev = $jml + 1;
		$this->insertRevtblGambar($id_gam,$rev,$file, $userId );
		
		}

		public function InsertMod_eNg($idcontract, $idgambar, $lpp, $b, $t, $bhp, $ds,$prop25,$prop35,$prop60){
		
		$query 	= $this->db->prepare("INSERT INTO `dw_mod_e` (idcontract, idgambar, lpp, b, t, bhp, ds,prop25,prop35,prop60 ) VALUES (?,?,?,?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $idcontract);
		$query->bindValue(2, $idgambar);
		$query->bindValue(3, $lpp);
		$query->bindValue(4, $b);
		$query->bindValue(5, $t);
		$query->bindValue(6, $bhp);
		$query->bindValue(7, $ds);
		$query->bindValue(8, $prop25);
		$query->bindValue(9, $prop35);
		$query->bindValue(10, $prop60);		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}			

		}

		public function insertModlodlines($idcontract, $idgambar,$H, $code ,$L ,$T,$TF,$F,	$S,	$W,	$WNA,$LTF,$LF ,$LT ,$LS ,$LW ,$LWNA ,$typeloadline, $pf,$LPP ,	$LWL ,$B ,	$H , $Cb ){
		
		$query 	= $this->db->prepare("INSERT INTO `dw_mod_loadli` (idcontract, idgambar, H, kode ,L ,T,	TF,	F,	S,	W,	WNA, LTF, LF , LT ,LS ,LW ,LWNA ,typeloadline, pf ,LPP  ,B  , Cb,`elwel`  ) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,? ,?) ");
	 
		$query->bindValue(1, $idcontract);
		$query->bindValue(2, $idgambar);
		$query->bindValue(3, $H);
		$query->bindValue(4, $code);
		$query->bindValue(5, $L);
		$query->bindValue(6, $T);
		$query->bindValue(7, $TF);
		$query->bindValue(8, $F);
		$query->bindValue(9, $S);
		$query->bindValue(10, $W);
		$query->bindValue(11, $WNA);
		$query->bindValue(12, $LTF);
		$query->bindValue(13, $LF);
		$query->bindValue(14, $LT);
		$query->bindValue(15, $LS);
		$query->bindValue(16, $LW);
		$query->bindValue(17, $LWNA);
		$query->bindValue(18, $typeloadline);
		$query->bindValue(19, $pf);
		
		$query->bindValue(20, $LPP);
		$query->bindValue(21, $LWL);
		$query->bindValue(22, $B);
		$query->bindValue(23, $Cb);
		
 	 	 	 	 
		
		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}			
		
		
		
		}
		
		public function InsertMod_Sc($idcontract, $idgambar, $lpp, $lwl, $B, $H, $T, $Cb, $vo){
		
		$query 	= $this->db->prepare("INSERT INTO `dw_mod_sc` (idcontract, idgambar, lpp, lwl, `be`, ha, te, cb, vo  ) VALUES (?,?,?,?,?,?,?,?,?) ");
	 
		$query->bindValue(1, $idcontract);
		$query->bindValue(2, $idgambar);
		$query->bindValue(3, $lpp);
		$query->bindValue(4, $lwl);
		$query->bindValue(5, $B);
		$query->bindValue(6, $H);
		$query->bindValue(7, $T);
		$query->bindValue(8, $Cb);
		$query->bindValue(9, $vo);

		try{
			$query->execute();

		}catch(PDOException $e){
			die($e->getMessage());
		}			

		}

		public function getLastupdate(){
		
		$query = $this->db->prepare("SELECT * from dw_update order by id desc limit 1");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		}

		public function getmoduleEngine($nokontrak,$idgam){
		$query = $this->db->prepare("SELECT * from dw_mod_e where idcontract = ? and idgambar =? limit 1 ");

		$query->bindValue(1, $nokontrak);
		$query->bindValue(2, $idgam);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();		
		
		}

		public function getmoduleStructure($nokontrak,$idgam){
		$query = $this->db->prepare("SELECT * from dw_mod_sc where idcontract = ? and idgambar =? limit 1 ");

		$query->bindValue(1, $nokontrak);
		$query->bindValue(2, $idgam);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();		
		
		}				
		

		public function getmoduleloadline($nokontrak,$idgam){
		$query = $this->db->prepare("SELECT * from dw_mod_loadli where idcontract = ? and idgambar =? limit 1 ");

		$query->bindValue(1, $nokontrak);
		$query->bindValue(2, $idgam);
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
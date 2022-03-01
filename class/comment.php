<?php
class comment
	{
		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}

		public function insert_db_comment($nomer_comment, $comment, $gambar ,$create_by , $point, $tanggal, $id_kon,$tipe ,$status,$gamb_infoRef='',$typekategory=0){
	 
			$query 	= $this->db->prepare("INSERT INTO `og_comment` (nomer_comment, comment,gambar, create_by, point, tanggal, id_kontrak,tipe,  status,gamb_infoRef, commentcategory ) VALUES (?, ?,?,?,?,?,?,?,?,?,?) ");
		 
			$query->bindValue(1, $nomer_comment);
			$query->bindValue(2, $comment);
			$query->bindValue(3, $gambar);
			$query->bindValue(4, $create_by);
			$query->bindValue(5, $point);
			$query->bindValue(6, $tanggal);
			$query->bindValue(7, $id_kon);
			$query->bindValue(8, $tipe);
			$query->bindValue(9, $status);
			$query->bindValue(10, $gamb_infoRef);
			$query->bindValue(11, $typekategory);
			
			
			//$query->bindValue(10, $forinfo);
		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		
		
		
		public function update_db_comment($comment, $tanggal, $id,$commentcategory, $status ){
	 
			$query 	= $this->db->prepare("UPDATE og_comment SET comment = ? ,tanggal = ?, commentcategory=?, status=?  where id= ?");
		 
			$query->bindValue(1, $comment);
			$query->bindValue(2, $tanggal);
			$query->bindValue(3, $commentcategory);
			$query->bindValue(4, $status);
			$query->bindValue(5, $id);
		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function delete_db_comment($id, $id_kont ){
			$query 	= $this->db->prepare("DELETE  FROM og_comment WHERE id= ? and id_kontrak = ? LIMIT 1");
		 
			$query->bindValue(1, $id);
			$query->bindValue(2, $id_kont);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
				public function delete_db_commentbyReport($report, $id_kont ){
			$query 	= $this->db->prepare("DELETE  FROM og_comment WHERE gambar= ? and id_kontrak = ? ");
		 
			$query->bindValue(1, $report);
			$query->bindValue(2, $id_kont);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		public function update_db_comment_pointByreport($report, $id_kont ){
	 
			$query 	= $this->db->prepare("UPDATE og_comment SET point=3  where id_kontrak = ?  and gambar= ? ");
		 
			$query->bindValue(1, $id_kont);
			$query->bindValue(2, $report);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function update_db_comment_stat($point, $status, $id ){
	 
			$query 	= $this->db->prepare("UPDATE og_comment SET point=? , status=? where id= ?  ");
		 
			$query->bindValue(1, $point);
			$query->bindValue(2, $status);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}


		public function update_db_comment_Point($point, $id ){
	 
			$query 	= $this->db->prepare("UPDATE og_comment SET point=?  where id= ?  ");
		 
			$query->bindValue(1, $point);
			$query->bindValue(2, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function update_db_comment_statClosed($closedby, $closedAT, $id ){
	 
			$query 	= $this->db->prepare("UPDATE og_comment SET closedby=? , closedAT=? where id= ?  ");
		 
			$query->bindValue(1, $closedby);
			$query->bindValue(2, $closedAT);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}


		public function review_db_comment($reviewby, $reviewat, $id ){
	 
			$query 	= $this->db->prepare("UPDATE og_comment SET reviewby=? , reviewat=? where id= ?  ");
		 
			$query->bindValue(1, $reviewby);
			$query->bindValue(2, $reviewat);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function get_db_comment($id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT c.commentcategory, c.importan,c.gamb_infoRef, c.id, c.nomer_comment, c.comment, c.gambar, c.create_by,c.point, c.tanggal,c.id_kontrak, c.tipe,c.status,c.closedby, c.closedAT,c.reviewby, c.reviewat,rep.oleh , rep.replay FROM `og_comment` c left join 
(SELECT id_comment, oleh, replay from og_subreplay_comment WHERE id IN (SELECT MAX(id) FROM og_subreplay_comment where `id_kont`=? GROUP BY `id_comment`))as rep on c.id = rep.id_comment where c.id_kontrak=? order by c.id desc"  );
			$query->bindValue(1, $id_kontrak);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function get_db_commentRange($id_kontrak,$tanggal) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT c.gamb_infoRef, c.id, c.nomer_comment, c.comment, c.gambar, c.create_by,c.point, c.tanggal,c.id_kontrak, c.tipe,c.status,c.closedby, c.closedAT,c.reviewby, c.reviewat,rep.oleh , rep.replay FROM `og_comment` c left join 
(SELECT id_comment, oleh, replay from og_subreplay_comment WHERE id IN (SELECT MAX(id) FROM og_subreplay_comment where `id_kont`=? GROUP BY `id_comment`))as rep on c.id = rep.id_comment where c.id_kontrak=? and c.tanggal <= ?  order by c.tanggal DESC"  );
			$query->bindValue(1, $id_kontrak);
			$query->bindValue(2, $id_kontrak);
			$query->bindValue(3, $tanggal);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_db_comment_moderation($id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_comment` where id_kontrak = ? and point = 2 ORDER BY `id` DESC");
			$query->bindValue(1, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function setUnset_importanComment($id_comment,$value) {
		 	
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("UPDATE `og_comment` SET `importan` = ? WHERE `og_comment`.`id` = ? ");
			$query->bindValue(1, $value);
			$query->bindValue(2, $id_comment);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return true ;
		}
		
		public function get_db_comment_id($id_come) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_comment` where id = ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id_come);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_db_comment_last($id_kontrak,$tipe) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_comment` where id_kontrak = ? and tipe = ? ORDER BY `id` DESC limit 1");
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
		
		public function get_comment_status($id_coment) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_comment` where id = ? and (point = 1 or point = 0) ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id_coment);
			
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
	
		public function insert_subgam_comment($id_gamb, $id_kon, $id_comment,$id_subGam=0){
	 
			$query 	= $this->db->prepare("INSERT INTO `og_subgambar_comment` (id_gamb, id_kon,  id_comment, id_subGam ) VALUES (?, ?,?,?) ");
		 
			$query->bindValue(1, $id_gamb);
			$query->bindValue(2, $id_kon);
			$query->bindValue(3, $id_comment);
			$query->bindValue(4, $id_subGam);
		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function delet_replay_id($id_comment,$id_kont){
	 
			$query 	= $this->db->prepare("DELETE FROM og_subreplay_comment WHERE id=? and id_kont=? ");
		 
			$query->bindValue(1, $id_comment);
			$query->bindValue(2, $id_kont);
			

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function insert_subreplay_comment($id_comment, $replay, $tanggal , $oleh, $post_by,$id_kont,$file="none"){
	 
			$query 	= $this->db->prepare("INSERT INTO `og_subreplay_comment` (id_comment, replay, tanggal, oleh, post_by , 	id_kont,file  ) VALUES (?, ?,?,?,?,?,?) ");
		 
			$query->bindValue(1, $id_comment);
			$query->bindValue(2, $replay);
			$query->bindValue(3, $tanggal);
			$query->bindValue(4, $oleh);
			$query->bindValue(5, $post_by);
			$query->bindValue(6, $id_kont);
			$query->bindValue(7, $file);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function insert_comment_his($id_comment, $comment, $oleh, $tanggal ,$id_kont){
	 
			$query 	= $this->db->prepare("INSERT INTO `og_comment_hist` (id_komen, comment, create_by, tanggal, id_kontrak ) VALUES (?, ?,?,?,?) ");
		 
			$query->bindValue(1, $id_comment);
			$query->bindValue(2, $comment);
			$query->bindValue(3, $oleh);
			$query->bindValue(4, $tanggal);
			$query->bindValue(5, $id_kont);
		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function insert_comment_log($aktifitas, $id_kome, $id_kont, $tanggal ,$oleh){
	 
			$query 	= $this->db->prepare("INSERT INTO `og_comment_log` (aktifitas, id_kome, id_kont, tanggal, oleh  ) VALUES (?, ?,?,?,?) ");
		 
			$query->bindValue(1, $aktifitas);
			$query->bindValue(2, $id_kome);
			$query->bindValue(3, $id_kont);
			$query->bindValue(4, $tanggal);
			$query->bindValue(5, $oleh);
		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function get_comment_log($id_komen,$id_kontrak) {
		
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_comment_log` JOIN og_user on og_user.id_user=og_comment_log.oleh where og_comment_log.id_kome=? and og_comment_log.id_kont = ? ORDER BY og_comment_log.id_log DESC ");
			$query->bindValue(1, $id_komen);
			$query->bindValue(2, $id_kontrak);
			
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
		
		
		public function get_comment_his($id_komen,$id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_comment_hist` where id_komen=? and id_kontrak = ? ORDER BY `id_komen` DESC ");
			$query->bindValue(1, $id_komen);
			$query->bindValue(2, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
	
	
		public function get_comment_id($id_komen,$id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_comment` where id=? and id_kontrak = ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $id_komen);
			$query->bindValue(2, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_gambar_idcom($id_komen,$id_kontrak) {
	
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT og_subgambar_comment.*, og_proj_gambar.* FROM `og_subgambar_comment` join og_proj_gambar on og_subgambar_comment.id_gamb=og_proj_gambar.id where og_subgambar_comment.id_comment=? and og_subgambar_comment.id_kon = ?");
			$query->bindValue(1, $id_komen);
			$query->bindValue(2, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function del_gambar_idcom($id_komen,$id_kontrak) {

			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("DELETE FROM og_subgambar_comment WHERE id_comment= ? and id_kon = ?  ");
			$query->bindValue(1, $id_komen);
			$query->bindValue(2, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			
		}
		
		
		public function get_replay_idcom($id_komen,$id_kontrak) {
	
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_subreplay_comment` where id_comment=? and id_kont = ? ORDER BY `id` DESC ");
			$query->bindValue(1, $id_komen);
			$query->bindValue(2, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
		public function get_replay_id($id,$id_kontrak) {
	
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_subreplay_comment` where id=? and id_kont = ? ORDER BY `id` DESC  limit 1");
			$query->bindValue(1, $id);
			$query->bindValue(2, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
		
	private function getCountComment($table,$filter){
			
			$query = $this->db->prepare("SELECT * FROM ". $table. " where " . $filter );
	
			try{
				$query->execute();
				$count = $query->rowCount();
				return $count ;
				
			}catch(PDOException $e){
				die($e->getMessage());
			}			
		}	
		
		public function GetCountAllComment($idkontrak){
			$table="og_comment" ;
			$filter= "id_kontrak=" . $idkontrak . " and point !=0 " ;
			$jml=$this->getCountComment($table,$filter);
			return $jml;
		}		
		
		public function GetCountCommentTipe($idkontrak,$tipe){
			$table="og_comment" ;
			$filter= "id_kontrak=" . $idkontrak . " and point !=0 and tipe= " . $tipe ;
			$jml=$this->getCountComment($table,$filter);
			return $jml;
		}		
		public function GetCountCloseComment($idkontrak){
			$table="og_comment" ;
			$filter= "id_kontrak=" . $idkontrak . " and point !=0 and status=1" ;
			$jml=$this->getCountComment($table,$filter);
			return $jml;
		}

		public function GetCountPublishComment($idkontrak){
			$table="og_comment" ;
			$filter= "id_kontrak=" . $idkontrak . " and point =3 " ;
			$jml=$this->getCountComment($table,$filter);
			return $jml;
		}
		public function GetCountInfoComment($idkontrak){
			$table="og_comment" ;
			$filter= "id_kontrak=" . $idkontrak . " and point !=0 and status=2" ;
			$jml=$this->getCountComment($table,$filter);
			return $jml;
		}									
		public function insert_db_report($tanggal, $tipe,$narasi, $comment, $createby, $file,$id_kon,$location=''){
			
			$numberreport=$this->genreatedReportnum($id_kon);
			$query 	= $this->db->prepare("INSERT INTO `og_report` (tanggal, tipe,narasi, comment, createby, file,id_kon,noreport,location ) VALUES (?, ?,?,?,?,?,?,?,?) ");
		 
			$query->bindValue(1, $tanggal);
			$query->bindValue(2, $tipe);
			$query->bindValue(3, $narasi);
			$query->bindValue(4, $comment);
			$query->bindValue(5, $createby);
			$query->bindValue(6, $file);
			$query->bindValue(7, $id_kon);
			$query->bindValue(8, $numberreport);
			$query->bindValue(9, $location);
		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}		
		
		public function get_db_report($id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_report` where id_kon = ? ORDER BY `id` DESC");
			$query->bindValue(1, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}		
		public function get_db_reportbyID($id_kontrak,$id) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_report` where id_kon = ? and id= ? limit 1");
			$query->bindValue(1, $id_kontrak);
			$query->bindValue(2, $id);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}		
		public function delete_db_report($id, $id_kont ){
			$query 	= $this->db->prepare("DELETE  FROM og_report WHERE id= ? and id_kon = ? LIMIT 1");
		 
			$query->bindValue(1, $id);
			$query->bindValue(2, $id_kont);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function publish_db_report($publishdate, $publishby, $id ){
	 
			$query 	= $this->db->prepare("UPDATE og_report SET  publishdate  = ? ,publishby = ?  where id= ?");
		 
			$query->bindValue(1, $publishdate);
			$query->bindValue(2, $publishby);
			$query->bindValue(3, $id);

		 
			try{
				$query->execute();

			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}

		public function genreatedReportnum($idkon) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT noreport FROM `og_report` where id_kon = ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $idkon);
			$query->bindColumn('noreport', $hak);
			
			try{
				$query->execute();
				$count = $query->rowCount();
				
				if ($count == 0 ){

				$number= 1 . "-" . $idkon . "-" . date("Ymd");
				return $number;
				}else {
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {
					}
					$number= ($hak + 1 ) . "-" . $idkon . "-" . date("Ymd");
					return $number;
					}
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		}

		public function get_comment_byname($nomer_comment,$id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_comment` where nomer_comment=? and id_kontrak = ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $nomer_comment);
			$query->bindValue(2, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}
public function GetCountRegularSurvey($idkontrak){
	$table="og_report";
	$filter= "tipe = 1 and id_kon = " . $idkontrak . " ";  
	$jml=$this->getCountComment($table,$filter);
	return $jml ;
}
public function GetCountPatrolSurvey($idkontrak){
	$table="og_report";
	$filter= "tipe = 2 and id_kon = " . $idkontrak . " ";  
	$jml=$this->getCountComment($table,$filter);
	return $jml ;
} 		
		
		

		public function get_SurveyNarasi($id_kon,$createby,$commentNum) {
		 	
		 	$commentNum="%" .$commentNum . ",%" ;
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_report` WHERE `id_kon`=? and createby=? and `comment` like ? limit 1");
			$query->bindValue(1, $id_kon);
			$query->bindValue(2, $createby);
			$query->bindValue(3, $commentNum);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}


		public function GetCountCommentPerdrawing($id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT * FROM `og_proj_gambar` left join (SELECT id_gamb, COUNT(*) as jumlah FROM og_subgambar_comment where id_kon=? GROUP BY id_gamb )as gam on og_proj_gambar.`id` = gam.id_gamb WHERE `id_kontrak`=?");
			$query->bindValue(1, $id_kontrak);
			$query->bindValue(2, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function GetCommentonDrawing($id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT og_subgambar_comment.id_gamb,og_subgambar_comment.id_comment, og_subgambar_comment.id_kon , og_proj_gambar.no_gambar, og_proj_gambar.judul,og_comment.nomer_comment FROM `og_subgambar_comment` left join og_proj_gambar on og_proj_gambar.id = og_subgambar_comment.id_gamb  left join  og_comment on og_subgambar_comment.id_comment=og_comment.id where id_kon=? ORDER BY `id_gamb` ASC ");
			$query->bindValue(1, $id_kontrak);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function get_countUnfollowupComment($id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT c.id, c.nomer_comment, c.comment, c.gambar, c.create_by,c.point, c.tanggal,c.id_kontrak, c.tipe,c.status,c.closedby, c.closedAT,c.reviewby, c.reviewat,rep.oleh , rep.replay FROM `og_comment` c left join 
(SELECT id_comment, oleh, replay from og_subreplay_comment WHERE id IN (SELECT MAX(id) FROM og_subreplay_comment where `id_kont`=? GROUP BY `id_comment`))as rep on c.id = rep.id_comment where c.id_kontrak=? and rep.oleh is NULL and c.point=3 and c.status !=2 order by c.id desc"  );
			$query->bindValue(1, $id_kontrak);
			$query->bindValue(2, $id_kontrak);
			try{
				$query->execute();
				$count = $query->rowCount();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			//return $query->fetchAll();
			return $count ; 
		}


		public function GetCommentonDrawingid($id_kontrak,$idGam) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT sb.id_subGam,sb.id_gamb,sb.id_comment, sb.id_kon ,com.nomer_comment,sg.revisi,com.status,com.point,com.create_by,com.tanggal  
				FROM `og_subgambar_comment` sb 
				left join og_sub_proj_gambar sg on sg.id_project_gamb = sb.id_gamb and sg.id = sb.id_subGam
				left join  og_comment com on sb.id_comment=com.id 
				where id_kon=? and sb.id_gamb =? ORDER BY com.tanggal ASC");
			$query->bindValue(1, $id_kontrak);
			$query->bindValue(2, $idGam);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}



		public function CekUserCreate($idcomment) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT create_by FROM `og_comment` where id = ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $idcomment);
			$query->bindColumn('create_by', $hak);
			
			try{
				$query->execute();					

				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

			return $hak ;
		}


		public function CekposisiComment($idcomment) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT point FROM `og_comment` where id = ? ORDER BY `id` DESC limit 1");
			$query->bindValue(1, $idcomment);
			$query->bindColumn('create_by', $hak);
			
			try{
				$query->execute();					

				while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}
			}catch(PDOException $e){
				die($e->getMessage());
				
			}

			return $hak ;
		}

		public function CekUserCreateCommentsurvey($report, $id_kont ){
			$query 	= $this->db->prepare("SELECT create_by FROM og_comment WHERE gambar= ? and id_kontrak = ? limit 1 ");
		 
			$query->bindValue(1, $report);
			$query->bindValue(2, $id_kont);
			$query->bindColumn('create_by', $hak);
		 
			try{
				$query->execute();
					while ($row = $query->fetch(PDO::FETCH_BOUND)) {

					}

			}catch(PDOException $e){
				die($e->getMessage());
			}
			return $hak ;	
		}


		public function Get_allCommentfromIdsubdrawing($id_subGam, $id_kont ){
			$query 	= $this->db->prepare("SELECT * FROM  og_subgambar_comment s left join og_comment c on s.id_comment=c.id WHERE s.id_subGam= ? and s.id_kon = ?");
		 
			$query->bindValue(1, $id_subGam);
			$query->bindValue(2, $id_kont);
			$query->bindColumn('create_by', $hak);
		 
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}					

		public function get_timelines_comment($id_kontrak) {
		 
			#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("SELECT s.id,s.id_comment,s.replay,s.tanggal,s.oleh, s.file,s.id_kont, c.id as idcomment,  c.nomer_comment FROM `og_subreplay_comment` s left join og_comment c on s.id_comment=c.id WHERE s.`id_kont` =? ORDER by s.id DESC"  );
			$query->bindValue(1, $id_kontrak);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();
		}

		public function insertLinkReport($link, $idReport)
		{
			$query 	= $this->db->prepare("UPDATE og_report SET object_link = ? WHERE id = ?");
		 
			$query->bindValue(1, $link);
			$query->bindValue(2, $idReport);
		 
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
		}
	
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		
		

	}
?>
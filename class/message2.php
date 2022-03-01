<?php
//CONFIG

require("../newsmtp/smtp.php");
require("../newsmtp/sasl.php");
class pesan{
 
		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function lastInsertId(){
			return $this->db->lastInsertId();
		}
		
		public function GetUnreadMessage($id_user){
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status, u.path from message2_recips r
										inner join message2 m on m.mid=r.mid and m.seq=r.seq
										inner join rm_biodata u on u.id_user=m.created_by
										where r.uid=? and r.status in ('A', 'N') and r.status != 'A'  
										and r.seq=(select max(rr.seq) from message2_recips rr where rr.mid=m.mid and rr.status in ('N'))
										and if (m.seq=1 and m.created_by=?, 1=0, 1=1)
										order by created_on desc ");
			#bind Value 
				$query->bindValue(1, $id_user);
				$query->bindValue(2, $id_user);
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			 
			 $jml = $query->rowCount();
			 
			 return $jml  ;

		}
		
		public function ReadMessage($userid){
		
		
		
		}
		
		public function GetMessagebyId($userid, $start){
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status, u.path from message2_recips r
										inner join message2 m on m.mid=r.mid and m.seq=r.seq
										inner join rm_biodata u on u.id_user=m.created_by
										where r.uid=? and r.status in ('A', 'N')
										and r.seq=(select max(rr.seq) from message2_recips rr where rr.mid=m.mid and rr.status in ('A', 'N'))
										and if (m.seq=1 and m.created_by=?, 1=0, 1=1)
										order by created_on desc limit ? , 5 ");
			#bind Value 
				$query->bindValue(1, $userid);
				$query->bindValue(2, $userid);
				$query->bindValue(3, $start);
				
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		}
		
		public function GetMessagebyIdUnread($userid){
		
		#preparing a statement that will select all the registered users, with the most recent ones first.
			$query = $this->db->prepare("select m.mid, m.seq, m.created_on, m.created_by, m.body, r.status, u.path, g.nama  from message2_recips r
										inner join message2 m on m.mid=r.mid and m.seq=r.seq
										inner join rm_biodata u on u.id_user=m.created_by
										inner join og_user g on g.id_user=m.created_by
										where r.uid=? and r.status in ('A', 'N') and r.status != 'A'  
										and r.seq=(select max(rr.seq) from message2_recips rr where rr.mid=m.mid and rr.status in ('A', 'N'))
										and if (m.seq=1 and m.created_by=?, 1=0, 1=1)
										order by created_on desc ");
			#bind Value 
				$query->bindValue(1, $userid);
				$query->bindValue(2, $userid);

				
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
				
			}
			# We use fetchAll() instead of fetch() to get an array of all the selected records.
			return $query->fetchAll();

		}
		
		
		
		public function SendMessage(){
		
		
		
		
		
		}
		
		Public function SendEmail($user_email,$nama_user,$body){
		
			$smtp=new smtp_class;
			
			$to= $user_email  ;
					
			$from="RMS@klasifikasiindonesia.com";
					
			$subject = "user id " . $nama_user. " Sent you message on RMS System";
					
			$body1="Hi

	You have new message from " . $nama_user . " and the message is :

	"  ;
					
					$message = $body1 . $body.  "

	---for detail info you can also view on RMS---. 
	Sent From RMS BKI [ http://10.0.1.202/rms/ ] 
					";
			include('../newsmtp/smtpwork.php');
		
		
		
		
		}
		
		
		

}

?>
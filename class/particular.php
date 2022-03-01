<?php
	class shipParticular
	{
		private $db;
		 
		public function __construct($database) {
			$this->db = $database;
		}
		
		public function lastInsertId(){
			return $this->db->lastInsertId();
		}

		//menu-related functions
		public function getMenuAll()
		{
			$query = $this->db->prepare("SELECT * FROM og_menu_main");
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			
			return $query->fetchAll();
		}
		
		public function getMenu($code)
		{
			$query = $this->db->prepare("SELECT * FROM og_menu_main WHERE key_id=?");
			$query->bindValue(1, $code);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			
			return $query->fetchAll();
		}
		
		public function getChildMenu($by, $id, $parent=null)
		{
			if($by == "parent")
			{
				$query = $this->db->prepare("SELECT * FROM og_menu_child WHERE parent = ?");
				$query->bindValue(1, $id);
			}else if($by == "id")
			{
				$query = $this->db->prepare("SELECT * FROM og_menu_child WHERE key_id = ? AND parent = ?");
				$query->bindValue(1, $id);
				$query->bindValue(2, $parent);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			
			return $query->fetchAll();
		}
		
		public function getMenuByFamily(array $family)
		{
			$where = "";
			for($i=0; $i<count($family); $i++)
			{
				$where = $where."family=? ^";
			}
			
			$where = substr($where, 0, -1);
			$where = str_replace("^", "or ", $where);
			$statement = "SELECT * FROM og_menu_main WHERE $where";
			$query = $this->db->prepare($statement);
			
			for($i=1; $i<=count($family); $i++)
			{
				$query->bindValue($i, $family[$i-1]);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());	
			}
			
			return $query->fetchAll();
		}
		
		public function getParent($id)
		{
			$query = $this->db->prepare("SELECT parent FROM og_menu_child WHERE key_id = ?");
			$query->bindValue(1, $id);
			$query->bindColumn('parent', $hak);
			
			try{
				$query->execute();
				while ($row = $query->fetch(PDO::FETCH_BOUND)){}
				
			}catch(PDOException $e){
				die($e->getMessage());	
			}
		
			return $hak ;
		}
		
		public function getChecklist($projId, $parent=null)
		{
			if($parent !== null)
			{
				$query = $this->db->prepare("SELECT * FROM og_menu_checklist WHERE proj_id = ? AND parent = ?");
				$query->bindValue(1, $projId);
				$query->bindValue(2, $parent);
			}else
			{
				$query = $this->db->prepare("SELECT * FROM og_menu_checklist WHERE proj_id = ?");
				$query->bindValue(1, $projId);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			
			$count = $query->rowCount();
			$content = $query->fetchAll();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
		}
		
		public function insertChecklist($projId, $checklist, $parent, $uId)
		{
			$current = date("Y-m-d H:i:s");
			$query = $this->db->prepare("INSERT INTO og_menu_checklist(proj_id, checklist, parent, updateby, updateon) VALUES(?,?,?,?,?)");
			$query->bindValue(1, $projId);
			$query->bindValue(2, $checklist);
			$query->bindValue(3, $parent);
			$query->bindValue(4, $uId);
			$query->bindValue(5, $current);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());	
			}
		}
		
		public function updateChecklist($projId, $checklist, $parent, $uId)
		{
			$current = date("Y-m-d H:i:s");
			$query = $this->db->prepare("UPDATE og_menu_checklist SET checklist = ?, updateby = ?, updateon = ? WHERE proj_id = ? AND parent = ?");
			$query->bindValue(1, $checklist);
			$query->bindValue(2, $uId);
			$query->bindValue(3, $current);
			$query->bindValue(4, $projId);
			$query->bindValue(5, $parent);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());	
			}
		}
		
		//data handling functions

		public function JSONDataInsertOrUpdate($projId, $uId, $data, $type, $parent, $datId=null)
		{
			
			if($datId === null)
			{
				$current = date("Y-m-d H:i:s");
				$query = $this->db->prepare("INSERT INTO og_data(type, parent, proj_id, data, update_by, created_on) VALUES (?,?,?,?,?,?)");
				$query->bindValue(1, $type);
				$query->bindValue(2, $parent);
				$query->bindValue(3, $projId);
				$query->bindValue(4, $data);
				$query->bindValue(5, $uId);
				$query->bindValue(6, $current);
			}else
			{
				$query = $this->db->prepare("UPDATE og_data SET type=?, parent=?, proj_id=?, data=?, update_by=? WHERE id=?");
				$query->bindValue(1, $type);
				$query->bindValue(2, $parent);
				$query->bindValue(3, $projId);
				$query->bindValue(4, $data);
				$query->bindValue(5, $uId);
				$query->bindValue(6, $datId);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}

		public function JSONDataDelete($datId)
		{
			$query = $this->db->prepare("DELETE FROM og_data WHERE id=?");
			$query->bindValue(1, $datId);

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}

		public function JSONDataGet($projId, $type)
		{
			$query = $this->db->prepare("SELECT * FROM og_data WHERE proj_id = ? AND type = ?");
			$query->bindValue(1, $projId);
			$query->bindValue(2, $type);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
		}

		public function JSONDataGetById($id)
		{
			$query = $this->db->prepare("SELECT * FROM og_data WHERE id = ?");
			$query->bindValue(1, $id);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
		}

		public function zNumTranslate($znum)
		{
			$query = $this->db->prepare("SELECT * FROM og_znumber");

			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}

			$eqpData = $query->fetchAll(PDO::FETCH_ASSOC);
			$count = $query->rowCount();

			for($i=0; $i<$count; $i++)
			{
				if($znum > $eqpData[$i]['znumber'] && $znum <= $eqpData[$i+1]['znumber'])
				{
					$out = $eqpData[$i];
					return json_encode($out);
				}else if($znum >= 16000)
				{
					$out = $eqpData[$count-1];
					return json_encode($out);
				}
			}
		}

		public function insertGeneralData($projId, $uId, $place, $start, $end, $name, $prevName, $type, $flag, $callSign, $port, $dateContract, $builder, $dateKeel, $hullNumber, $dateLaunch, $dateComplete, $classPrev, $charPrev, $classOther, $charOther, $material, $stat)
		{
			$current = date("Y-m-d H:i:s");
			$query = $this->db->prepare("INSERT INTO og_data_general 
										 (proj_id, updateby, place_survey, date_survey_start, date_survey_end, name, prev_name, type_ship, flag, call_sign, 
										  port_registry, contract, builder, keel_laying, hull_number, launching, completion, class_prev, 
										  char_prev, class_other, char_other, material, ship_status, updateon)
										 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
										");
			$query->bindValue(1, $projId);
			$query->bindValue(2, $uId);
			$query->bindValue(3, $place);
			$query->bindValue(4, $start);
			$query->bindValue(5, $end);
			$query->bindValue(6, $name);
			$query->bindValue(7, $prevName);
			$query->bindValue(8, $type);
			$query->bindValue(9, $flag);
			$query->bindValue(10, $callSign);
			$query->bindValue(11, $port);
			$query->bindValue(12, $dateContract);
			$query->bindValue(13, $builder);
			$query->bindValue(14, $dateKeel);
			$query->bindValue(15, $hullNumber);
			$query->bindValue(16, $dateLaunch);
			$query->bindValue(17, $dateComplete);
			$query->bindValue(18, $classPrev);
			$query->bindValue(19, $charPrev);
			$query->bindValue(20, $classOther);
			$query->bindValue(21, $charOther);
			$query->bindValue(22, $material);
			$query->bindValue(23, $stat);
			$query->bindValue(24, $current);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function getGeneralData($projId)
		{
			$query = $this->db->prepare("SELECT * FROM og_data_general WHERE proj_id = ?");
			$query->bindValue(1, $projId);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
		}
		
		public function updateGeneralData($projId, $uId, $place, $start, $end, $name, $prevName, $type, $flag, $callSign, $port, $dateContract, $builder, $dateKeel, $hullNumber, $dateLaunch, $dateComplete, $classPrev, $charPrev, $classOther, $charOther, $material, $stat)
		{
			$current = date("Y-m-d H:i:s");
			$query = $this->db->prepare("UPDATE og_data_general 
										 SET updateby = ?, place_survey = ?, date_survey_start = ?, date_survey_end = ?, name = ?, prev_name = ?, 
											 type_ship = ?, flag = ?, call_sign = ?, port_registry = ?, contract = ?, builder = ?, keel_laying = ?, 
											 hull_number = ?, launching = ?, completion = ?, class_prev = ?, char_prev = ?, class_other = ?, 
											 char_other = ?, material = ?, ship_status = ?, updateon = ?
										 WHERE proj_id = ?
										");
			$query->bindValue(1, $uId);
			$query->bindValue(2, $place);
			$query->bindValue(3, $start);
			$query->bindValue(4, $end);
			$query->bindValue(5, $name);
			$query->bindValue(6, $prevName);
			$query->bindValue(7, $type);
			$query->bindValue(8, $flag);
			$query->bindValue(9, $callSign);
			$query->bindValue(10, $port);
			$query->bindValue(11, $dateContract);
			$query->bindValue(12, $builder);
			$query->bindValue(13, $dateKeel);
			$query->bindValue(14, $hullNumber);
			$query->bindValue(15, $dateLaunch);
			$query->bindValue(16, $dateComplete);
			$query->bindValue(17, $classPrev);
			$query->bindValue(18, $charPrev);
			$query->bindValue(19, $classOther);
			$query->bindValue(20, $charOther);
			$query->bindValue(21, $material);
			$query->bindValue(22, $stat);
			$query->bindValue(23, $current);
			$query->bindValue(24, $projId);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
		}
		
		public function insertHullData($projId, $loa, $lpp, $lf, $bmld, $hmld, $draft, $freeboard, $gt, $nett, $dwt, $displacement, $userId)
		{
			$current = date("Y-m-d H:i:s");
			$query = $this->db->prepare("INSERT INTO og_data_particular
										 (proj_id, loa, lpp, lf, bmld, hmld, draft,
										  freeboard, gt, nett, dead_weight, displacement, updateby, updateon)
										 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			$query->bindValue(1, $projId);
			$query->bindValue(2, $loa);
			$query->bindValue(3, $lpp);
			$query->bindValue(4, $lf);
			$query->bindValue(5, $bmld);
			$query->bindValue(6, $hmld);
			$query->bindValue(7, $draft);
			$query->bindValue(8, $freeboard);
			$query->bindValue(9, $gt);
			$query->bindValue(10, $nett);
			$query->bindValue(11, $dwt);
			$query->bindValue(12, $displacement);
			$query->bindValue(13, $userId);
			$query->bindValue(14, $current);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function getHullData($projId)
		{
			$query = $this->db->prepare("SELECT * FROM og_data_particular WHERE proj_id = ?");
			$query->bindValue(1, $projId);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
		}
		
		public function updateHullData($projId, $loa, $lpp, $lf, $bmld, $hmld, $draft, $freeboard, $gt, $nett, $dwt, $displacement, $uId)
		{
			$current = date("Y-m-d H:i:s");
			$query = $this->db->prepare("UPDATE og_data_particular
										 SET loa = ?, lpp = ?, lf = ?, bmld = ?, 
											 hmld = ?, draft = ?, freeboard = ?, gt = ?, 
											 nett = ?, dead_weight = ?, displacement = ?,
											 updateby = ?, updateon = ?
										 WHERE proj_id = ? ");
			$query->bindValue(1, $loa);
			$query->bindValue(2, $lpp);
			$query->bindValue(3, $lf);
			$query->bindValue(4, $bmld);
			$query->bindValue(5, $hmld);
			$query->bindValue(6, $draft);
			$query->bindValue(7, $freeboard);
			$query->bindValue(8, $gt);
			$query->bindValue(9, $nett);
			$query->bindValue(10, $dwt);
			$query->bindValue(11, $displacement);
			$query->bindValue(12, $uId);
			$query->bindValue(13, $current);
			$query->bindValue(14, $projId);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function insertCapacity($projId, $type, $capacity, $uId)
		{
			$current = date("Y-m-d H:i:s");
			$query = $this->db->prepare("INSERT INTO og_data_capacity (proj_id, type, capacity, updateby, updateon) VALUES (?,?,?,?,?)");
			
			$query->bindValue(1, $projId);
			$query->bindValue(2, $type);
			$query->bindValue(3, $capacity);
			$query->bindValue(4, $uId);
			$query->bindValue(5, $current);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function getCapacity($projId)
		{
			$query = $this->db->prepare("SELECT * FROM og_data_capacity WHERE proj_id = ? ORDER BY id ASC");
			$query->bindValue(1, $projId);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
			
		}
		
		public function updateCapacity($id, $type, $capacity, $uId)
		{
			$current = date("Y-m-d H:i:s");
			$query = $this->db->prepare("UPDATE og_data_capacity SET type = ?, capacity = ?, updateby = ?, updateon = ? WHERE id = ?");
			
			$query->bindValue(1, $type);
			$query->bindValue(2, $capacity);
			$query->bindValue(3, $uId);
			$query->bindValue(4, $current);
			$query->bindValue(5, $id);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function deleteCapacity($id)
		{
			$query = $this->db->prepare("DELETE FROM og_data_capacity WHERE id = ?");
			
			$query->bindValue(1, $id);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function getEquipment($projId)
		{
			$query = $this->db->prepare("SELECT * FROM og_data_eqp WHERE proj_id = ? ORDER BY id ASC");
			$query->bindValue(1, $projId);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
			
		}
		
		public function insertEquipment(array $data)
		{
			$current = date("Y-m-d H:i:s");
			array_push($data, $current);
			$query = $this->db->prepare("INSERT INTO og_data_eqp
										 (num, length, characteristic, dimension, opt, manuf, certificate,
										  sub, proj_id, updateby, updateon)
										 VALUES (?,?,?,?,?,?,?,?,?,?,?)");
			
			for($i=0; $i<count($data); $i++)
			{
				echo $i;
				$query->bindValue($i+1, $data[$i]);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function updateEquipment(array $data, $projId, $sub)
		{
			$current = date("Y-m-d H:i:s");
			array_push($data, $current, $projId, $sub);
			$query = $this->db->prepare("UPDATE og_data_eqp
										 SET num = ?, length = ?, characteristic = ?, dimension = ?, opt = ?, manuf = ?, 
											 certificate = ?, updateby = ?, updateon = ?
										 WHERE proj_id = ? AND sub = ?");
			for($i=0; $i<count($data); $i++)
			{
				$query->bindValue($i+1, $data[$i]);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function getRudder($projId)
		{
			$query = $this->db->prepare("SELECT * FROM og_data_rudder WHERE proj_id = ? ORDER BY id ASC");
			$query->bindValue(1, $projId);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
			
		}
		
		public function insertRudder(array $data)
		{
			$current = date("Y-m-d H:i:s");
			array_push($data, $current);
			$query = $this->db->prepare("INSERT INTO og_data_rudder
										 (qty, size, material, thickness, certificate, flange,
										  sub, proj_id, updateby, updateon)
										 VALUES (?,?,?,?,?,?,?,?,?,?)");
			
			for($i=0; $i<count($data); $i++)
			{
				$query->bindValue($i+1, $data[$i]);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function updateRudder(array $data, $projId, $sub)
		{
			$current = date("Y-m-d H:i:s");
			array_push($data, $current, $projId, $sub);
			$query = $this->db->prepare("UPDATE og_data_rudder
										 SET qty = ?, size = ?, material = ?, thickness = ?, certificate = ?, flange = ?, 
											 updateby = ?, updateon = ?
										 WHERE proj_id = ? AND sub = ?");
			for($i=0; $i<count($data); $i++)
			{
				$query->bindValue($i+1, $data[$i]);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function getCargo($projId)
		{
			$query = $this->db->prepare("SELECT * FROM og_data_cargo WHERE proj_id = ? ORDER BY id ASC");
			$query->bindValue(1, $projId);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
			
		}
		
		public function insertCargo(array $data)
		{
			$current = date("Y-m-d H:i:s");
			array_push($data, $current);
			$query = $this->db->prepare("INSERT INTO og_data_cargo
										 (qty, dimension, manufacturer, certificate,
										  sub, proj_id, updateby, updateon)
										 VALUES (?,?,?,?,?,?,?,?)");
			
			for($i=0; $i<count($data); $i++)
			{
				$query->bindValue($i+1, $data[$i]);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function updateCargo(array $data, $projId, $sub)
		{
			$current = date("Y-m-d H:i:s");
			array_push($data, $current, $projId, $sub);
			$query = $this->db->prepare("UPDATE og_data_cargo
										 SET qty = ?, dimension = ?, manufacturer = ?, certificate = ?, 
											 updateby = ?, updateon = ?
										 WHERE proj_id = ? AND sub = ?");
			for($i=0; $i<count($data); $i++)
			{
				$query->bindValue($i+1, $data[$i]);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function getMainEngine($projId)
		{
			$query = $this->db->prepare("SELECT * FROM og_data_meg WHERE proj_id = ? ORDER BY id ASC");
			$query->bindValue(1, $projId);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}	
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
			
		}
		
		public function insertMainEngine(array $data)
		{
			$current = date("Y-m-d H:i:s");
			array_push($data, $current);
			$query = $this->db->prepare("INSERT INTO og_data_meg
										 (brand, type, qty, power, revolution, cylinder, bore, stroke, year,
										  serial, certificate, manufacturer, start, accessories, proj_id, updateby, updateon)
										 VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
			
			for($i=0; $i<count($data); $i++)
			{
				$query->bindValue($i+1, $data[$i]);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function updateMainEngine(array $data, $projId)
		{
			$current = date("Y-m-d H:i:s");
			array_push($data, $current, $projId);
			$query = $this->db->prepare("UPDATE og_data_meg
										 SET brand=?, type=?, qty=?, power=?, revolution=?, cylinder=?, 
										 bore=?, stroke=?, year=?, serial=?, certificate=?, manufacturer=?, 
										 start=?, accessories=?, updateby=?, updateon=?
										 WHERE proj_id = ?");
			for($i=0; $i<count($data); $i++)
			{
				$query->bindValue($i+1, $data[$i]);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function getMachineryData($by, $projId, $classifier, $parent=null)
		{	
			if($by == "type")
			{
				$query = $this->db->prepare("SELECT * FROM og_data_machinery WHERE proj_id = ? AND type = ? AND parent = ?");
				$query->bindValue(1, $projId);
				$query->bindValue(2, $classifier);
				$query->bindValue(3, $parent);
			}else if($by == "id")
			{
				$query = $this->db->prepare("SELECT * FROM og_data_machinery WHERE proj_id = ? AND id = ?");
				$query->bindValue(1, $projId);
				$query->bindValue(2, $classifier);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
		}
		
		public function insertData($code, array $data)
		{
			$table = "og_data_".$code;
			$columnName = $this->getColumnName($table);
			$columns = array();
			foreach($columnName as $name)
			{
				$columns[] = $name['Field'];
			}
			
			$columnStr = "(";
			$valueStr = "(";
			for($i=1; $i<count($columns); $i++)
			{
				$columnStr = $columnStr.$columns[$i].",";
				$valueStr = $valueStr."?,";
			}
			$columnStr = substr_replace($columnStr, ")", -1);
			$valueStr = substr_replace($valueStr, ")", -1);
			
			$statement = "INSERT INTO ".$table." ".$columnStr." VALUES ".$valueStr;
			
			$query = $this->db->prepare($statement);
			
			for($i=1; $i<=count($columns)-1; $i++)
			{
				$query->bindValue($i, $data[$i-1]);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function getData($parent, $by, $id, $type=null)
		{
			$table = "og_data_".$parent;
			switch($by)
			{
				case "project":
					$query = $this->db->prepare("SELECT * FROM ".$table." WHERE proj_id = ? AND type = ?");
					$query->bindValue(1, $id);
					$query->bindValue(2, $type);
					break;
					
				case "id":
					$query = $this->db->prepare("SELECT * FROM ".$table." WHERE id = ?");
					$query->bindValue(1, $id);
					break;
					
				case "alltype":
					$query = $this->db->prepare("SELECT * FROM ".$table." WHERE proj_id = ?");
					$query->bindValue(1, $id);
					break;
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			
			$content = $query->fetchAll();
			$count = $query->rowCount();
			
			$data = array("row"=>$count, "content"=>$content);
			
			return $data;
		}
		
		public function updateData($code, array $data, $id)
		{
			$table = "og_data_".$code;
			$columnName = $this->getColumnName($table);
			$columns = array();
			foreach($columnName as $name)
			{
				$columns[] = $name['Field'];
			}
			
			$valueStr = "";
			for($i=1; $i<count($columns); $i++)
			{
				$columnStr = $columns[$i];
				$valueStr = $valueStr."$columnStr = ?,";
			}
			$valueStr = substr($valueStr, 0, -1);
			
			$statement = "UPDATE ".$table." SET ".$valueStr." WHERE id = ?";
			
			$query = $this->db->prepare($statement);
			
			for($i=1; $i<=count($columns)-1; $i++)
			{
				$query->bindValue($i, $data[$i-1]);
			}
			$query->bindValue($i, $id);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		public function deleteData($id, $parent)
		{
			$table = "og_data_$parent";
			$statement = "DELETE FROM $table WHERE id=?";
			
			$query = $this->db->prepare($statement);
			$query->bindValue(1, $id);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
		}
		
		//miscellanous
		public function getColumnName($databaseName)
		{
			$statement = "DESCRIBE ".$databaseName;
			$query = $this->db->prepare($statement);
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			
			return $query->fetchAll();
		}
		
		public function getLastUser($projId, $databaseName, $parent=null)
		{
			if($parent !== null)
			{
				$statement = "SELECT updateon, updateby FROM ".$databaseName." WHERE proj_id = ? AND parent = ? ORDER BY updateon LIMIT 1";
				$query = $this->db->prepare($statement);
				$query->bindValue(1, $projId);
				$query->bindValue(2, $parent);
			}else
			{
				$statement = "SELECT updateon, updateby FROM ".$databaseName." WHERE proj_id = ? ORDER BY updateon LIMIT 1";
				$query = $this->db->prepare($statement);
				$query->bindValue(1, $projId);
			}
			
			try{
				$query->execute();
			}catch(PDOException $e){
				die($e->getMessage());
			}
			
			$results = $query->fetchAll();
			$data = array();
			foreach($results as $result)
			{
				$data['updateon'] = $result['updateon'];
				$data['updateby'] = $result['updateby'];
			}
			
			return $data;
		}
		
		public function getIdByTypeProject($parent, $type, $projId)
		{
			$table = "og_data_$parent";
			$statement = "SELECT id FROM $table WHERE type=? AND proj_id = ?";
			$query = $this->db->prepare($statement);
			$query->bindValue(1, $type);
			$query->bindValue(2, $projId);
			$query->bindColumn('id', $hak);
			try{
				$query->execute();
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {}
			}catch(PDOException $e){
				die($e->getMessage());
			}
			return $hak ;
		}
		
		public function packData($tableId, $projId, $type, $limit)
		{
			$data = $this->getData($tableId, "project", $projectId, $type);
			$columnName = $this->getColumnName($table);
			$col = array();
			foreach($columnName as $column)
			{
				$col[] = $column['Field'];
			}
			
			$packet = array();
			$i = 0;
			foreach($data['content'] as $dat)
			{
				for($j=1; $j<count($col)-$limit; $j++)
				{
					$packet['content'][$i][] = $dat[$col[$j]];
				}
				$i++;
			}
			$packet['row'] = $data['row'];
			
			return $packet;
		}
		
		public function getName($key)
		{
			$query = $this->db->prepare("SELECT title FROM og_menu_main WHERE key_id = ?");
			$query->bindValue(1, $key);
			$query->bindColumn('title', $hak);
			try{
				$query->execute();
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {}
			}catch(PDOException $e){
				die($e->getMessage());
			}
			return $hak ;
		}
		
		public function getChildName($key)
		{
			$query = $this->db->prepare("SELECT title FROM og_menu_child WHERE key_id = ?");
			$query->bindValue(1, $key);
			$query->bindColumn('title', $hak);
			try{
				$query->execute();
				while ($row = $query->fetch(PDO::FETCH_BOUND)) {}
			}catch(PDOException $e){
				die($e->getMessage());
			}
			return $hak ;
		}
	}
	
?>
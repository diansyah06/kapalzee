<?php
	include("../sis32/db_connect.php");
	include "../functions.php";
	sec_session_start();
	//get var from post
	include "../class/init3.php";
	include "../modern.php" ;
	date_default_timezone_set('Asia/Jakarta');

	cekLoginStatus ($mysqli) ;

	//get profile user login
	$user_id = $_SESSION['user_id'];
	$nama_user=$Users->get_users_with_title($user_id); //nama 
	$biodata_users= $Users->getUser_biodata($user_id);
	$salting = $_SESSION['salt'];

	foreach ($biodata_users as $biodata_user) { 
		$displayPicture = "../" . $biodata_user['path'] ; //wajah
		$jabatanUser = $biodata_user['jabatan'] ; 
		$emailUser = $biodata_user['email'] ;
		$hpUer = $biodata_user['handphone'] ;
	}
	//getalluser
	$listUsers=$Users->get_users();

	$alluserArray=array(); // store alluseronarray
		foreach($listUsers as $listUser){
		$idusernya=$listUser['id_user'];
		$alluserArray[$idusernya]=$listUser['nama'];
	}
	
	$modul = $_POST['modul'];
	
	switch($modul)
	{
		case "updateField":
			updateField($shipData, $rms, $obj, $user_id);
			break;
		
		case "updateMenu":
			updateMenu($shipData, $obj, $user_id);
			break;
			
		case "updateTable":
			updateTable($shipData, $rms, $obj, $user_id);
			break;
		
		case "updateInput":
			updateInput($shipData);
			break;
	}
	
	//-----Main Functions-----
	function updateField($shipData, $rms, $obj, $user_id)
	{
		$code = $_POST['id'];
		$id = '"'.$_POST['id'].'"';
		$projId = $_POST['projId'];
		$group = $_POST['family'];
		$parent = $_POST['parentKey'];
		$change = true;
		
		if($group != "-")
		{
			$badge = $group;
		}else
		{
			$badge = $code;
		}
		
		switch($badge)
		{
			case "cpc":
				$datId = $_POST['dataId'];
				$act = $_POST['act'];
				menuCapacity($id, $projId, $shipData, $datId, $act, $rms, $group, $obj, $user_id);
				break;
			
			case "blh":
				menuBulkhead($id, $projId, $shipData, $rms, $group);
				break;
			case "tbl":
			case "lbl":
				$dataId = $_POST['dataId'];
				$act = $_POST['act'];
				menuTypeBulk($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id);
				break;
			case "dck":
				menuDeck($id, $projId, $shipData, $rms, $group);
				break;
			case "dec":
			case "spc":
				$dataId = $_POST['dataId'];
				$act = $_POST['act'];
				menuTypeDeck($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id);
				break;
			case "eqp":
				menuEquipment($id, $projId, $shipData, $rms, $group);
				break;
			case "rdc":
				menuRudder($id, $projId, $shipData, $rms, $group);
				break;
			case "cgh":
				menuCargo($id, $projId, $shipData, $rms, $group);
				break;
			case "meg":
				menuMainEngine($id, $projId, $shipData, $rms, $group);
				break;
			
			case "trs":
				menuTransmission($id, $projId, $shipData, $rms, $group);
				break;
			case "ims": case "rvg": case "tfb": case "fgf": case "cob":
				$dataId = $_POST['dataId'];
				$act = $_POST['act'];
				menuTypeTransmission($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id);
				break;
			case "prs":
				menuPropShaft($id, $projId, $shipData, $rms, $group);
				break;
			case "prp":
				menuProp($id, $projId, $shipData, $rms, $group);
				break;
			case "aeg":
				menuAuxEngine($id, $projId, $shipData, $rms, $group);
				break;
			case "axu": case "grt": case "egn": case "sfo": case "cpd": case "cpb":
				$dataId = $_POST['dataId'];
				$act = $_POST['act'];
				menuTypeAuxEngine($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id);
				break;
			case "eln":
				menuElectrical($id, $projId, $shipData, $rms, $group);
				break;
			case "msb": case "esb": case "ecb":
				$dataId = $_POST['dataId'];
				$act = $_POST['act'];
				menuTypeElectrical($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id);
				break;
			case "frf":
				menuFirefight($id, $projId, $shipData, $rms, $group);
				break;
			case "xfx": case "pfx": case "fsz":
				$dataId = $_POST['dataId'];
				$act = $_POST['act'];
				menuTypeFirefight($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id);
				break;
			case "smy":
				menuSummary($projId, $shipData, $rms);
				$change = false;
				break;
			default:
				echo $code;
				break;
		}
		
		if($change)
		{
			echo "	<script>
					document.getElementById('heading-title').textContent = 'Input';
				</script>";
		}
	}
	
	function updateMenu($shipData, $obj, $user_id)
	{
		$stringCommand = $_POST['stringCommand'];
		$family = $_POST['family'];
		$pieces = explode("~", $stringCommand);
		$id = $pieces[0];
		$projId = $pieces[3];
		
		if($family != "-")
		{
			$badge = $family;
		}else
		{
			$badge = $id;
		}
		
		switch($badge)
		{
			case "gen":
				$childData = generalInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "cpc":
				$childData = capacityInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "tnk":
				$childData = tankInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "blh":
				$childData = bulkInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "dck":
				$childData = deckInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "crh": case "crt": case "blt": case "fpt": case "apt": case "spt": 
			case "vot": case "fwt": case "fot": case "lot": case "sdt": case "cfd": 
			case "ott": case "tbl": case "lbl": case "dec": case "spc":
				$childData = typeInput($stringCommand, $shipData, $obj);
				break;
			case "eqp":
				$childData = equipmentInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "rdc":
				$childData = rudderInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "cgh":
				$childData = cargoInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "meg":
				$childData = mainEngineInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "mac":
				$childData = machineryInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "trs":
				$childData = transmissionInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "pmp":
				$childData = typeInput($stringCommand, $shipData);
				break;
			case "ims": case "rvg": case "tfb": case "fgf": case "cob":
				$childData = typeInput($stringCommand, $shipData);
				break;
			case "prs":
				$childData = propShaftInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "prp":
				$childData = propInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "aeg":
				$childData = auxEngineInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "axu": case "grt": case "egn": case "sfo": case "cpd": case "cpb":
				$childData = typeInput($stringCommand, $shipData);
				break;
			case "eln":
				$childData = electricalInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "msb": case "esb": case "ecb":
				$childData = typeInput($stringCommand, $shipData);
				break;
			case "frf":
				$childData = firefightInput($stringCommand, $shipData, $obj, $user_id);
				break;
			case "xfx": case "pfx": case "fsz":
				$childData = typeInput($stringCommand, $shipData);
				break;
		}
		
		$parent = '"'.$shipData->getParent($id).'"';
		
		echo "
				<div class='panel-body'>
					<div id='tree'>
					</div>
					<input type='hidden' id='child-input' value=$childData>
				</div>
				
				<script>
					function updateTree()
					{
						var childStr = document.getElementById('child-input').value;
						var childArray = childStr.split('+').join(' '); 
						var childData = JSON.parse(childArray);
						var parent = $parent;
						$('#tree').dynatree({
							onActivate: function (node) {
								// A DynaTreeNode object is passed to the activation handler
								// Note: we also get this event, if persistence is on, and the page is reloaded.
								//alert('You activated' + node.data.value);
								sendCode(node.data.key, $projId, node.data.family, node);
							},
							children: childData
						});
						
					}
					
					jQuery(document).ready(function()
					{
						updateTree();
					});
				</script>
				";
	}
	
	function updateTable($shipData, $rms, $obj, $user_id)
	{
		$stringCommand = $_POST['stringCommand'];
		$parent = $_POST['parentId'];
		$dataId = $_POST['dataId'];
		$group = $_POST['family'];
		$family = '"'.$group.'"';
		
		if($group != "-")
		{
			$badge = $group;
		}else
		{
			$badge = $parent;
		}
		
		$pieces = explode("~", $stringCommand);
		$id = $pieces[0];
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$dataStr = $pieces[4];
		$childId = '"'.$id.'"';
		
		$tableStat = true;
		
		switch($badge)
		{
			case "tnk":
				//input to database
				$dataArr = explode("#", $dataStr);
				$time = date("Y-m-d H:i:s");
				array_push($dataArr, $id, $projId, $uId, $time);
				
				$dataBulk = $shipData->getData($parent, "id", $dataId);
				if($dataBulk['row'] == 0)
				{
					$shipData->insertData($parent, $dataArr);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$dataStr);
				}else
				{
					$shipData->updateData($parent, $dataArr, $dataId);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$dataId."#".$dataStr);
				}
				
				$childMenu = $shipData->getChildMenu("id", $id, $parent);
				foreach($childMenu as $menu)
				{
					$opt = explode("-", $menu['menu']);
				}
			
				//update table view
				$headers = array("Name", "Frame No.", "Corrosion Protection", "Coating Extent", "Cargo Heating", "Common Plane");
				
				$tableHead = "";
				for($i=0; $i<count($opt); $i++)
				{
					$head = $headers[$opt[$i]];
					$tableHead = $tableHead."<th>$head</th>";
				}
				
				$tankData = $shipData->getData("tnk", "project", $projId, $id);
				$rowStr = "";
				foreach($tankData['content'] as $dat)
				{
					$name = $dat['tank_name'];
					$frame = "$dat[frame_start] ~ $dat[frame_end]";
					$charArray = explode("+", $dat['characteristic']);
					$userArray = $rms->get_users_id($dat['updateby']);
					foreach($userArray as $arr)
					{
						$usrName = $arr['nama'];
					}
					
					$rowStr = $rowStr. "	<tr>
									<td><a onclick='sendUpdate($childId, $projId, $dat[id], $family);'>$name</a></td>
									<td>$frame</td>
							  ";
					
					for($k=0; $k<count($charArray); $k++)
					{
						if($charArray[$k] != "-")
						{
							$content = str_replace("@", " + ", $charArray[$k]);
							$rowStr = $rowStr."<td>$content</td>";
						}
					}
					
					$rowStr = $rowStr."		<td>$usrName</td>
											<td><a  onclick='deleteDat($dat[id], $projId, $childId, $family)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Cancel Event'><i class='fa fa-times fa fa-white'></i></a></td>
										</tr>";
				}
				break;
				
			case "blh":
				//input to database
				$dataArr = explode("#", $dataStr);
				$time = date("Y-m-d H:i:s");
				array_push($dataArr, $id, $projId, $uId, $time);
				
				$dataBulk = $shipData->getData($parent, "id", $dataId);
				if($dataBulk['row'] == 0)
				{
					$shipData->insertData($parent, $dataArr);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$dataStr);
				}else
				{
					$shipData->updateData($parent, $dataArr, $dataId);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$dataId."#".$dataStr);
				}
				
				$childMenu = $shipData->getChildMenu("id", $id, $parent);
				foreach($childMenu as $menu)
				{
					$opt = str_split($menu['menu']);
				}
				
				//update table view
				$headers = array("Number", "Frame No.", "Frame No.", "Location");
				
				$tableHead = "";
				for($i=0; $i<count($opt); $i++)
				{
					$head = $headers[$opt[$i]];
					$tableHead = $tableHead."<th>$head</th>";
				}
				
				$blhData = $shipData->getData("blh", "project", $projId, $id);
				$rowStr = "";
				foreach($blhData['content'] as $dat)
				{
					$number = $dat['bulkhead_num'];
					$userArray = $rms->get_users_id($dat['updateby']);
					foreach($userArray as $arr)
					{
						$usrName = $arr['nama'];
					}
					
					if($dat['frame_end'] == 0)
					{
						$frame = $dat['frame_start'];
						$rowStr = $rowStr. "	<tr>
									<td><a onclick='sendUpdate($childId, $projId, $dat[id], $family);'>$number</a></td>
									<td>$frame</td>
							  ";
					}else
					{
						$frame = "$dat[frame_start] ~ $dat[frame_end]";
						$rowStr = $rowStr. "	<tr>
									<td><a onclick='sendUpdate($childId, $projId, $dat[id], $family);'>$number</a></td>
									<td>$frame</td>
									<td>$dat[bulkhead_loc]</td>
							  ";
					}
					
					$rowStr = $rowStr."		<td>$usrName</td>
											<td><a  onclick='deleteDat($dat[id], $projId, $childId, $family)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Cancel Event'><i class='fa fa-times fa fa-white'></i></a></td>
										</tr>";
				}
				break;
			
			case "dck":
				//input to database
				$dataArr = explode("#", $dataStr);
				$time = date("Y-m-d H:i:s");
				array_push($dataArr, $id, $projId, $uId, $time);
				
				$dataBulk = $shipData->getData($parent, "id", $dataId);
				if($dataBulk['row'] == 0)
				{
					$shipData->insertData($parent, $dataArr);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$dataStr);
				}else
				{
					$shipData->updateData($parent, $dataArr, $dataId);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$dataId."#".$dataStr);
				}
				
				$childMenu = $shipData->getChildMenu("id", $id, $parent);
				foreach($childMenu as $menu)
				{
					$opt = str_split($menu['menu']);
				}
				
				//update table view
				$option = array("dec"=>array("--Deck Type--", "Strength Deck", "Second Deck", "Third Deck", "Fourth Deck", "Fifth Deck", "Sixth Deck"),
								"spc"=>array("--Deck Type--", "Fore Castle Deck", "Poop Deck", "Boat Deck", "Bridge Deck", "Wheel House Deck", "Top Deck"));

				$tableHead = "<th>Deck Name</th>
							  <th>Frame Number</th>";
				$deckData = $shipData->getData("dck", "project", $projId, $id);
				$rowStr = "";
				foreach($deckData['content'] as $dat)
				{
					$deckNum = $dat['decks'];
					$deckName = $option[$id][$deckNum];
					$frame = $dat['frame_num'];
					$userArray = $rms->get_users_id($dat['updateby']);
					foreach($userArray as $arr)
					{
						$usrName = $arr['nama'];
					}
					$rowStr = $rowStr. "	
									<tr>
										<td><a onclick='sendUpdate($childId, $projId, $dat[id], $family);'>$deckName</a></td>
										<td>$frame</td>
										<td>$usrName</td>
										<td><a  onclick='deleteDat($dat[id], $projId, $childId, $family)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Cancel Event'><i class='fa fa-times fa fa-white'></i></a></td>
									</tr>";
				}
				break;
			
			case "pmp":
				$headers = array("Qty", "Brand", "Year", "Certificate", "Type", "Type", "Delivery Head", "Capacity", "Power",
								 "Area", "Working Pressure", "Propeller size", "Blade Num", "Dimension", "Prime Mover",
								 "Prime Mover Type", "Serial Number");
				//preparing data
				$childMenu = $shipData->getChildMenu("id", $id, $parent);
				foreach($childMenu as $menu)
				{
					$opt = explode("-", $menu['menu']);
				}
				
				$temp = explode("#", $dataStr);
				$commonDat = array($temp[0], $temp[1], $temp[2], $temp[3]);
				$charDat = explode("+", $temp[4]);
				$temp = array_merge($commonDat, $charDat);
				$container = array_fill(0, 21, "-");
				$dataArr = array();
				
				for($i=0; $i<count($opt); $i++)
				{
					$container[$opt[$i]] = $temp[$i];
				}
				
				for($i=0; $i<=3; $i++)
				{
					$dataArr[$i] = $container[$i];
				}
				$dataArr[4] = implode("+", array_slice($container,4));
				
				$time = date("Y-m-d H:i:s");
				array_push($dataArr, $id, $parent, $projId, $uId, $time);
				
				//inserting data to database
				$dataBulk = $shipData->getMachineryData("id", $projId, $dataId);
				if($dataBulk['row'] == 0)
				{
					$shipData->insertData("machinery", $dataArr);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,implode("#", $dataArr));
				}else
				{
					$shipData->updateData("machinery", $dataArr, $dataId);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$dataId."#".implode("#", $dataArr));
				}
				
				//arranging table view
				$tableHead = "";
				for($i=0; $i<count($opt); $i++)
				{
					$head = $headers[$opt[$i]];
					$tableHead = $tableHead."<th>$head</th>";
				}
				
				$itemData = $shipData->getMachineryData("type", $projId, $id, $parent);
				
				$contentArr = array();
				$temp = array();
				$nameArr = array();
				$rowStr = "";
				foreach($itemData['content'] as $dat)
				{
					$temp[0] = $dat['qty'];
					$temp[1] = $dat['brand'];
					$temp[2] = $dat['year'];
					$temp[3] = $dat['certificate'];
					
					$userArray = $rms->get_users_id($dat['updateby']);
					foreach($userArray as $arr)
					{
						$usrName = $arr['nama'];
					}
					
					$pieces = explode("+", $dat['characteristic']);
					$contentArr = array_merge($temp, $pieces);
				
					$rowStr = $rowStr."<tr>";
					for($k=0; $k<count($opt); $k++)
					{
						$content = $contentArr[$opt[$k]];
						$rowStr = $rowStr."<td>$content</td>";
					}
					$updateBy = $usrName;
					$rowStr = $rowStr."
										<td>$updateBy</td>
										<td>
											<a  onclick='sendUpdate($childId, $projId, $dat[id], $family);' class='btn btn-xs btn-primary tooltips' data-placement='top' data-original-title='Edit Data'><i class='fa fa-pencil fa fa-white'></i></a>
											<a  onclick='deleteDat($dat[id], $projId, $childId, $family);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Delete Data'><i class='fa fa-times fa fa-white'></i></a>
										</td>
									</tr>
					";
				}
				break;
			case "trs":
				$name = array('ME'=>'Main engine foundation fit bolt', 
					  'GB'=>'Gear box foundation fit bolt',
					  'PI'=>'Propeller shaft coupling with intermediate shaft coupling',
					  'IG'=>'Intermediate shaft coupling with gear box shaft coupling',
					  'PG'=>'Propeller shaft coupling with gear box shaft coupling',
					  'II'=>'Intermediate shaft coupling with Intermediate shaft coupling'
					 );
				//preparing data
				$childMenu = $shipData->getChildMenu("id", $id, $parent);
				foreach($childMenu as $menu)
				{
					$opt = explode("-", $menu['menu']);
				}
				
				if(!in_array(13, $opt) && !in_array(14,$opt))
				{
					$tableStat = false;
				}
				
				$temp = explode("#", $dataStr);
				$dataArr = array($temp[1], $temp[5]);
				$char = implode("+", $temp);
				$time = date("Y-m-d H:i:s");
				array_push($dataArr, $char, $id, $parent, $projId, $uId, $time);
				
				//inserting data to database
				$dataBulk = $shipData->getData($parent, "id", $dataId);
				if($dataBulk['row'] == 0)
				{
					$shipData->insertData("trs", $dataArr);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,implode("#", $dataArr));
				}else
				{
					$shipData->updateData("trs", $dataArr, $dataId);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$dataId."#".implode("#", $dataArr));
				}
				
				//arranging table view
				$trsData = $shipData->getData("trs", "project", $projId, $id);
				$rowStr = "";
				$tableHead = "	<th>Type</th>
								<th>Qty</th>
								<th>Dimension</th>
								<th>Certificate No.</th>";
				
				foreach($trsData['content'] as $dat)
				{
					$userArray = $rms->get_users_id($dat['updateby']);
					foreach($userArray as $arr)
					{
						$usrName = $arr['nama'];
					}
					
					$charStr = $dat['characteristic'];
					$char = explode("+", $charStr);
					$tmpArr = array();
					$l = 0;
					for($t=0; $t<=count($char); $t++)
					{
						if($char[$t] != "-")
						{
							$tmpArr[$l] = $char[$t];
							$l++;
						}
					}
					
					$typeName = $name[$tmpArr[3]];
					
					$rowStr = $rowStr." <tr>
											<td><a onclick='sendUpdate($childId, $projId, $dat[id], $family);'>$typeName</a></td>
											<td>$tmpArr[1]</td>
											<td>$tmpArr[0]</td>
											<td>$tmpArr[2]</td>
											<td>$usrName</td>
											<td><a  onclick='deleteDat($dat[id], $projId, $childId, $family)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Cancel Event'><i class='fa fa-times fa fa-white'></i></a></td>
										</tr>";
				}
				break;
			case "aeg":
				$time = date("Y-m-d H:i:s");
				$childMenu = $shipData->getChildMenu("id", $id, $parent);
				foreach($childMenu as $menu)
				{
					$opt = explode("-", $menu['menu']);
				}
				$container = array_fill(10,6,"-");
				
				$atTemp = explode("@", $dataStr);
				if(count($atTemp)>1)
				{
					$dataArr = explode("#", $atTemp[0]);
					$temp = explode("#", $atTemp[1]);
					
					$start = array_search("9", $opt);
					$j = 0;
					for($i=$start+1; $i<count($opt); $i++)
					{
						$container[$opt[$i]] = $temp[$j];
						$j++;
					}
					
					$additional = implode("+", $container);
					array_push($dataArr, $additional, $id, $projId, $uId, $time);
				}else
				{
					$dataArr = explode("#", $atTemp[0]);
					array_push($dataArr, "-", $id, $projId, $uId, $time);
				}
				
				//inserting data to database
				$dataBulk = $shipData->getData($parent, "id", $dataId);
				if($dataBulk['row'] == 0)
				{
					$shipData->insertData("aeg", $dataArr);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,implode("#", $dataArr));
				}else
				{
					$shipData->updateData("aeg", $dataArr, $dataId);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$dataId."#".implode("#", $dataArr));
				}
				
				//arranging table view
				$tableHead = "			
								<th>Brand</th>
								<th>Type</th>
								<th>Quantity</th>
								<th>Manufacturer</th>
							 ";
				
				$datQuery = $shipData->getData("aeg", "project", $projId, $id);	
				$columnName = $shipData->getColumnName("og_data_aeg");
				$columns = array();
				$char = array();
				$rowStr = "";
				foreach($columnName as $name)
				{
					$columns[] = $name['Field'];
				}
				
				foreach($datQuery['content'] as $dat)
				{
					for($i=1; $i<=6; $i++)
					{
						$char[] = $dat[$columns[$i]];
					}
					
					$userArray = $rms->get_users_id($dat['updateby']);
					foreach($userArray as $arr)
					{
						$usrName = $arr['nama'];
					}
					
					$rowStr = $rowStr."<tr>
											<td>$char[0]</td>
											<td>$char[1]</td>
											<td>$char[2]</td>
											<td>$char[5]</td>
											<td>$usrName</td>
											<td>
												<a  onclick='sendUpdate($childId, $projId, $dat[id], $family);' class='btn btn-xs btn-primary tooltips' data-placement='top' data-original-title='Edit Data'><i class='fa fa-pencil fa fa-white'></i></a>
												<a  onclick='deleteDat($dat[id], $projId, $childId, $family);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Delete Data'><i class='fa fa-times fa fa-white'></i></a>
											</td>
									   </tr>
										";
					$char = array();
				}
				
				break;
			
			case "eln":
				$time = date("Y-m-d H:i:s");
				$dataArr = explode("#", $dataStr);
				array_push($dataArr, $id, $projId, $uId, $time);
				
				//inserting data to database
				$dataBulk = $shipData->getData($parent, "id", $dataId);
				
				if($dataBulk['row'] == 0)
				{
					$shipData->insertData("eln", $dataArr);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$dataStr);
				}else
				{
					$shipData->updateData("eln", $dataArr, $dataId);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$dataId."#".$dataStr);
				}
				
				if($id == "ecb")
				{
					//arranging table view
					$tableHead = "			
									<th>Brand</th>
									<th>Certificate</th>
									<th>Diameter</th>
								 ";
					$childMenu = $shipData->getChildMenu("id", $id, $parent);
					foreach($childMenu as $menu)
					{
						$opt = explode("-", $menu['menu']);
					}
					$datQuery = $shipData->getData("eln", "project", $projId, $id);	
					$columnName = $shipData->getColumnName("og_data_eln");
					$columns = array();
					$char = array();
					$rowStr = "";
					foreach($columnName as $name)
					{
						$columns[] = $name['Field'];
					}
					
					foreach($datQuery['content'] as $dat)
					{
						for($i=0; $i<count($opt); $i++)
						{
							$char[] = $dat[$columns[$opt[$i]]];
						}
						
						$userArray = $rms->get_users_id($dat['updateby']);
						foreach($userArray as $arr)
						{
							$usrName = $arr['nama'];
						}
						
						$rowStr = $rowStr."<tr>
												<td>$char[0]</td>
												<td>$char[1]</td>
												<td>$char[2]</td>
												<td>$usrName</td>
												<td>
													<a  onclick='sendUpdate($childId, $projId, $dat[id], $family);' class='btn btn-xs btn-primary tooltips' data-placement='top' data-original-title='Edit Data'><i class='fa fa-pencil fa fa-white'></i></a>
													<a  onclick='deleteDat($dat[id], $projId, $childId, $family);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Delete Data'><i class='fa fa-times fa fa-white'></i></a>
												</td>
										   </tr>
											";
						$char = array();
					}
				}else
				{
					$tableStat = false;
				}
				break;
				
			case "frf":
				$time = date("Y-m-d H:i:s");
				$dataArr = explode("#", $dataStr);
				array_push($dataArr, $id, $projId, $uId, $time);
				
				//inserting data to database
				$dataBulk = $shipData->getData($parent, "id", $dataId);
				
				if($dataBulk['row'] == 0)
				{
					$shipData->insertData("frf", $dataArr);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$dataStr);
				}else
				{
					$shipData->updateData("frf", $dataArr, $dataId);
					$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$dataId."#".$dataStr);
				}
				
				//arranging table view
				$childMenu = $shipData->getChildMenu("id", $id, $parent);
				foreach($childMenu as $menu)
				{
					$opt = explode("-", $menu['menu']);
				}
				$head = array("","Type", "Type", "Type", "Vol", "-", "Qty", "Certificate");
				$tableHead = "";
				for($i=0; $i<count($opt); $i++)
				{
					if($head[$opt[$i]] != "-")
					{
						$tableHead = $tableHead."<th>".$head[$opt[$i]]."</th>";
					}				
				}
				
				$datQuery = $shipData->getData("frf", "project", $projId, $id);	
				$columnName = $shipData->getColumnName("og_data_frf");
				$columns = array();
				$char = array();
				$rowStr = "";
				foreach($columnName as $name)
				{
					$columns[] = $name['Field'];
				}
				
				$typeFire = array(	'CO2'=>'CO2 Extinguisher',
									'HAL'=>'Halon Extinguisher',
									'FOA'=>'Foam Extinguisher',
									'DCF'=>'Deck Foam Extinguisher',
									'DCP'=>'Dry-Chemical Powder Extinguisher',
									'HEF'=>'High Expansion Foam Extinguisher',
									'PWS'=>'Pressure Water Spraying Extinguisher',
									'FHN'=>'Fire Hose and Nozzle');
				
				foreach($datQuery['content'] as $dat)
				{
					$rowStr = $rowStr."<tr>";
					for($i=1; $i<count($columns)-4; $i++)
					{
						$content = $dat[$columns[$i]];
						if($columns[$i]=='type_frf')
						{
							$content = $typeFire[$content];
						}
						if($content != "-")
						{
							$rowStr = $rowStr."<td>".$content."</td>";
						}
					}
					
					$userArray = $rms->get_users_id($dat['updateby']);
					foreach($userArray as $arr)
					{
						$usrName = $arr['nama'];
					}
					
					$rowStr = $rowStr."
											<td>$usrName</td>
											<td>
												<a  onclick='sendUpdate($childId, $projId, $dat[id], $family);' class='btn btn-xs btn-primary tooltips' data-placement='top' data-original-title='Edit Data'><i class='fa fa-pencil fa fa-white'></i></a>
												<a  onclick='deleteDat($dat[id], $projId, $childId, $family);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Delete Data'><i class='fa fa-times fa fa-white'></i></a>
											</td>
									   </tr>
										";
				}
				break;
		}
		
		//updating table view
		if($tableStat){
			echo "	<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
						<thead>
							<tr>
								$tableHead
								<th>Update by</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							$rowStr
						</tbody>
					</table>
				";
		}
		
	}
	
	//-----Specific Functions-----
	function menuGeneral($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$genArray = $shipData->getGeneralData($projId);
		
		if($genArray['row'] == 0)
		{
			$nbStat = "checked";
			$steelStat = "checked";
		}else
		{
			foreach($genArray['content'] as $dat)
			{
				$place = "value = '$dat[place_survey]'";
				
				$start = date("m/d/Y g:i A", strtotime($dat['date_survey_start']));
				$end = date("m/d/Y g:i A", strtotime($dat['date_survey_end']));
				$dateSurvey = "value = '$start - $end'";
				
				$name = "value = '$dat[name]'";
				$prevName = "value = '$dat[prev_name]'";
				$type = "value = '$dat[type_ship]'";
				$flag = "value = '$dat[flag]'";
				$callSign = "value = '$dat[call_sign]'";
				$port = "value = '$dat[port_registry]'";
				
				$contract = date("m/d/Y", strtotime($dat['contract']));
				$dateContract = "value = '$contract'";
				
				$builder = "value = '$dat[builder]'";
				$hullNumber = "value = '$dat[hull_number]'";
				
				$keel = date("m/d/Y", strtotime($dat['keel_laying']));
				$dateKeel = "value = '$keel'";
				
				$launch = date("m/d/Y", strtotime($dat['launching']));
				$dateLaunch = "value = '$launch'";
				
				$complete = date("m/d/Y", strtotime($dat['completion']));
				$dateComplete = "value = '$complete'";
				
				$classPrev = "value = '$dat[class_prev]'";
				$charPrev = "value = '$dat[char_prev]'";
				$classOther = "value = '$dat[class_other]'";
				$charOther = "value = '$dat[char_other]'";
				
				$status = $dat['ship_status'];
				$material = $dat['material'];
				
				$uId = $dat['updateby'];
				$userArray = $rms->get_users_id($uId);
				foreach($userArray as $arr)
				{
					$usrname = $arr['nama'];
				}
				$time = date("d/m/Y H:i:s", strtotime($dat['updateon']));
				
				if($status == '1')
				{
					$nbStat = "checked";
					$exStat = "";
				}else
				{
					$nbStat = "";
					$exStat = "checked";
				}
				
				switch($material)
				{
					case "1":
						$steelStat = "checked";
						$alumStat = "";
						$woodStat = "";
						$fiberStat = "";
						break;
					case "2":
						$steelStat = "";
						$alumStat = "checked";
						$woodStat = "";
						$fiberStat = "";
						break;
					case "3":
						$steelStat = "";
						$alumStat = "";
						$woodStat = "checked";
						$fiberStat = "";
						break;
					case "4":
						$steelStat = "";
						$alumStat = "";
						$woodStat = "";
						$fiberStat = "checked";
						break;
				}
				
			}
		}
		$partArray = $shipData->getHullData($projId);
		if($partArray['row'] != 0)
		{
			foreach($partArray['content'] as $data)
			{
				$loa = "value = $data[loa]";
				$lpp = "value = $data[lpp]";
				$lf = "value = $data[lf]";
				$bmld = "value = $data[bmld]";
				$hmld = "value = $data[hmld]";
				$draft = "value = $data[draft]";
				$freeboard = "value = $data[freeboard]";
				$gt = "value = $data[gt]";
				$nett = "value = $data[nett]";
				$dwt = "value = $data[dead_weight]";
				$displ = "value = $data[displacement]";
			}
		}
		
		if($genArray['row']==0 && $partArray['row']==0)
		{
			$updateStr = "";
			$button = "Submit";
		}else
		{
			$updateStr = "<p>Last update at $time by $usrname<p>";
			$button = "Update";
		}
		
		echo "
			$updateStr
			<h3>General Information</h3>
			<form role='form' class='form-horizontal'>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Ship Status :	
				</label>
				<div class='col-sm-10'>
				<label class='radio-inline'>
					<input type='radio' value='1' name='statusRadios' class='grey' $nbStat>
					New Building
				</label>
				<label class='radio-inline'>
					<input type='radio' value='2' name='statusRadios' class='grey' $exStat>
					Existing
				</label>											
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Place of Survey :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Place of Survey' class='form-control' $place>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Survey Date :
				</label>
				<div class='col-sm-10'>
				<span class='col-sm-9-addon'> <i class='fa fa-calendar'></i> </span>
				<input type='text' name='input-field' placeholder='Date of Survey' class='form-control date-time-range' $dateSurvey>
			</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Name :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Name of Ship' class='form-control' $name>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Previous Name :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Previous Name of Ship' class='form-control' $prevName>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Type of Ship :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Type of Ship' class='form-control' $type>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Hull Material :	
				</label>
				<div class='col-sm-10'>
				<label class='radio-inline'>
					<input type='radio' value='1' name='materialRadios' class='grey' $steelStat>
					Steel
				</label>
				<label class='radio-inline'>
					<input type='radio' value='2' name='materialRadios' class='grey' $alumStat>
					Aluminium
				</label>
				<label class='radio-inline'>
					<input type='radio' value='3' name='materialRadios' class='grey' $woodStat>
					Wood
				</label>
				<label class='radio-inline'>
					<input type='radio' value='4' name='materialRadios' class='grey' $fiberStat>
					FRP
				</label>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Flag :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Flag of Ship' class='form-control' $flag>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Call Sign :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Call Sign of Ship' class='form-control' $callSign>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Port of Registry :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Port of Registry' class='form-control' $port>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Contract :											
				</label>
				<div class='col-sm-10'>
				<span class='col-sm-9-addon'> <i class='fa fa-calendar'></i> </span>	
					<input type='text' name='input-field' placeholder='Date of Contract' data-date-format='dd-mm-yyyy' data-date-viewmode='years' class='form-control date-picker' $dateContract>	
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Builder Yard :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Name of Builder Yard' class='form-control' $builder>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Keel Laying :											
				</label>
				<div class='col-sm-10'>
				<span class='col-sm-9-addon'> <i class='fa fa-calendar'></i> </span>	
					<input type='text' name='input-field' placeholder='Date of Keel Laying' data-date-format='dd-mm-yyyy' data-date-viewmode='years' class='form-control date-picker' $dateKeel>	
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Hull Number :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Hull Number' class='form-control' $hullNumber>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Launching :											
				</label>
				<div class='col-sm-10'>
				<span class='col-sm-9-addon'> <i class='fa fa-calendar'></i> </span>	
					<input type='text' name='input-field' placeholder='Date of Launching' data-date-format='dd-mm-yyyy' data-date-viewmode='years' class='form-control date-picker' $dateLaunch>
					
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Completion :											
				</label>
				<div class='col-sm-10'>
				<span class='col-sm-9-addon'> <i class='fa fa-calendar'></i> </span>	
					<input type='text' name='input-field' placeholder='Date of Completion' data-date-format='dd-mm-yyyy' data-date-viewmode='years' class='form-control date-picker' $dateComplete>	
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Previous Class :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Previous class of the ship' class='form-control' $classPrev>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Character and Notation :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Previous Class Character and Notation' class='form-control' $charPrev>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Other Class :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Other class of the ship(in case of dual class)' class='form-control' $classOther>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Character and Notation :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field' placeholder='Other Class Character and Notation' class='form-control' $charOther>
				</div>
			</div>
			</form>
			
			<h3>Hull Particular</h3>
			
			<form role='form' class='form-horizontal'>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					LOA :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='in meter' class='form-control' $loa>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					LPP :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='in meter' class='form-control' $lpp>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Lf :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='in meter' class='form-control' $lf>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Bmld :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='in meter' class='form-control' $bmld>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Hmld :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='in meter' class='form-control' $hmld>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					T :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='in meter' class='form-control' $draft>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Freeboard :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='summer freeboard (in mm)' class='form-control' $freeboard>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					GT :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='Gross Tonnage (in m3/RT)' class='form-control' $gt>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Nett :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='Nett Tonnage (in m3/RT)' class='form-control' $nett>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Dead Weight :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='Deadweight corresponding to assigned summer freeboard draught' class='form-control' $dwt>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
					Displacement :
				</label>
				<div class='col-sm-10'>
					<input type='text' name='input-field2' placeholder='Displacement corresponding to assigned summer freeboard draught' class='form-control' $displ>
				</div>
			</div>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			
			<script>
				jQuery(document).ready(function() {
					$('.date-range').daterangepicker();
					$('.date-time-range').daterangepicker({
						timePicker: true,
						timePickerIncrement: 15,
						format: 'MM/DD/YYYY h:mm A'
					});
					
					$('.date-picker').datepicker({
						autoclose: true
					});
					
					$('.time-picker').timepicker();
				});
			</script>
		";
	}
	
	function menuCapacity($id, $projId, $shipData, $datId, $act, $rms, $group, $obj, $user_id)
	{
		$family = '"'.$group.'"';
		if($act == "del")
		{
			$shipData->deleteCapacity($datId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Delete data $id",$user_id,"",0,0,$datId);
		}
		
		$capArray = $shipData->getCapacity($projId);
		$count = $capArray['row'];
		
		if($count == 0)
		{
			echo"
					<a class='btn btn-blue' onClick='addItem();' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						Add Item
					</a>
				<input id='latest' type='hidden' value=1>
				<table class='table table-hover' id='option-table'>
					<thead>
						<tr>
							<th>Item</th>
							<th>Capacity</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						<div id='capacity-field'>
						<tr id = 'row-data'>
							<td>
								<select id='cap-type-1' name='select-field' class='form-control'>
									<option value='1'>General cargo - bale (m3)</option>
									<option value='2'>General cargo - grain (m3)</option>
									<option value='3'>Cargo tank - oil (m3)</option>
									<option value='4'>Cargo tank - other (m3)</option>
									<option value='5'>Fuel oil tank (m3)</option>
									<option value='6'>Lubricating oil tank (m3)</option>
									<option value='7'>Fresh water tank (m3)</option>
									<option value='8'>Cargo oil / ballast water tank (m3)</option>
									<option value='9'>Ballast tank (m3)</option>
									<option value='10'>Lubricating oil tank (m3)</option>
									<option value='11'>Container - dry (TEU)</option>
									<option value='12'>Container - dry (FEU)</option>
									<option value='13'>Container - refrigerated (TEU)</option>
									<option value='14'>Container - refrigerated (FEU)</option>
									<option value='15'>Vehicle (type x number)</option>
								</select>
							</td>
							<td>
								<input id='cap-1' type='text' name='input-field'>
								<input type='hidden' name='id-field'>
							</td>
							<td><a class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Delete Data'><i class='fa fa-times fa fa-white'></i></a></td>
						</tr>
						</div>";
			$button = "Submit";
		}else
		{
			$userLog = $shipData->getLastUser($projId, "og_data_capacity");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			
			echo "
				<p>Last update at $time by $name</p>
				<a class='btn btn-blue' onClick='addItem();' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						Add Item
					</a>
				<table class='table table-hover' id='option-table'>
					<thead>
						<tr>
							<th>Item</th>
							<th>Capacity</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
			";
			
			$option = "[";
			foreach($capArray['content'] as $dat)
			{
				echo"
						<div id='capacity-field'>
						<tr id = 'row-data'>
							<td>
								<select name='select-field' class='form-control'>
									<option value='1'>General cargo - bale (m3)</option>
									<option value='2'>General cargo - grain (m3)</option>
									<option value='3'>Cargo tank - oil (m3)</option>
									<option value='4'>Cargo tank - other (m3)</option>
									<option value='5'>Fuel oil tank (m3)</option>
									<option value='6'>Lubricating oil tank (m3)</option>
									<option value='7'>Fresh water tank (m3)</option>
									<option value='8'>Cargo oil / ballast water tank (m3)</option>
									<option value='9'>Ballast tank (m3)</option>
									<option value='10'>Lubricating oil tank (m3)</option>
									<option value='11'>Container - dry (TEU)</option>
									<option value='12'>Container - dry (FEU)</option>
									<option value='13'>Container - refrigerated (TEU)</option>
									<option value='14'>Container - refrigerated (FEU)</option>
									<option value='15'>Vehicle (type x number)</option>
								</select>
							</td>
							<td>
								<input type='text' name='input-field' value=$dat[capacity]>
								<input type='hidden' name='id-field' value=$dat[id]>
							</td>
							<td><a  onclick='deleteDat($dat[id], $projId, $id, $family)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Cancel Event'><i class='fa fa-times fa fa-white'></i></a></td>
						</tr>
						</div>";
				
				$option = $option.$dat['type'].",";
			}
			$option = substr_replace($option, "]", -1);
			
			echo "
					<script>
						var opt = $option;
						var sel = document.getElementsByName('select-field');
						for(i=0; i<sel.length; i++)
						{
							sel[i].value = opt[i];
						}
					</script>
			";
			$button = "Update";
		}
		
			echo "
					</tbody>
				</table>
				
				<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
		";
	}
	
	function menuTank($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$menuData = $shipData->getChecklist($projId, "tnk");
		$count = $menuData['row'];
		
		echo "
				<p id='user-log'></p>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Tank</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Cargo Hold</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='crh' class='flat-grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Cargo Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='crt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Ballast Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='blt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Fore Peak Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='fpt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>After Peak Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='apt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Slop Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='spt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Void Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='vot' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Fresh Water Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='fwt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Fuel Oil Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='fot' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Lubricating Oil Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='lot' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Sludge Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='sdt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Cofferdam</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='cfd' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Other Tank</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='tank-field' value='ott' class='grey'>
									</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			";
		if($count == 0)
		{
			$button = "Submit";
		}else
		{
			foreach($menuData['content'] as $dat)
			{
				$tankStr = $dat['checklist'];
			}			
			$tankArr = explode("#", $tankStr);
			
			$checkbox = "[";
			
			for($l=0; $l<count($tankArr); $l++)
			{
				$checkbox = $checkbox."'".$tankArr[$l]."'".",";
			}
			$checkbox = substr_replace($checkbox, "]", -1);
			$button = "Update";
			
			$userLog = $shipData->getLastUser($projId, "og_menu_checklist", "tnk");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			
			$userStr = "'Last update at $time by $name'";
			
			echo "
				<script>
					var checkbox = $checkbox;
					var checkField = document.getElementsByName('tank-field');
					for(i=0; i<checkField.length; i++)
					{
						for(l=0; l<checkbox.length; l++)
						{
							if(checkField[i].value == checkbox[l])
							{
								checkField[i].checked = true;
							}
						}
					}
					var userLog = document.getElementById('user-log');
					userLog.innerHTML = $userStr;
				</script>
			";
		}			
			echo "	
				<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
					<i  id='tomboltask' class='fa fa-plus' ></i>
					$button
				</a>
			";
	}
	
	function menuTypeTank($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id)
	{
		$family = '"'.$group.'"';
		if($act == "del")
		{
			$shipData->deleteData($dataId, $parent);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Delete data $id",$user_id,"",0,0,"$dataId#$parent");
		}
		
		$forms = array(
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Name :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Tank Name' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Frame No :
					</label>
					<div class='col-sm-4'>
						<input type='number' name='input-field' placeholder='Start' class='form-control'>
					</div>
					<label class='col-sm-2'>
						to
					</label>
					<div class='col-sm-4'>
						<input type='number' name='input-field' placeholder='End' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Protection :
					</label>
					<div class='col-sm-10'>
						<label class='checkbox-inline'>
							<input type='checkbox' value='HC' name='cp-field' class='grey'>
							Hard Coating
						</label>
						<label class='checkbox-inline'>
							<input type='checkbox' value='SC' name='cp-field' class='grey'>
							Soft Coating
						</label>
						<label class='checkbox-inline'>
							<input type='checkbox' value='A' name='cp-field' class='grey'>
							Anode
						</label>
						<label class='checkbox-inline'>
							<input type='checkbox' value='NP' name='cp-field' class='grey'>
							No Protection
						</label>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Type of corrosion protection
						</span>
					</div>
				</div>
				",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Coating :
					</label>
					<div class='col-sm-10'>
						<select id='coat-field' class='form-control'>
							<option value='-'>--Coating Extent--</option>
							<option value='U'>Upper Part</option>
							<option value='M'>Middle Part</option>
							<option value='L'>Lower Part</option>
							<option value='C'>Complete</option>
						</select>
					</div>
				</div>
				",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Cargo Heating :
					</label>
					<div class='col-sm-10'>
						<label class='radio-inline'>
							<input type='radio' value='A' name='ch-field' class='grey'>
							Applicable
						</label>
						<label class='radio-inline'>
							<input type='radio' value='N/A' name='ch-field' class='grey'>
							Not Applicable
						</label>
					</div>
				</div>
				",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Common Plane :
					</label>
					<div class='col-sm-10'>
						<label class='radio-inline'>
							<input type='radio' value='A' name='plane-field' class='grey'>
							Applicable
						</label>
						<label class='radio-inline'>
							<input type='radio' value='N/A' name='plane-field' class='grey'>
							Not Applicable
						</label>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Common plane boundary with cargo tank equipped with any means of heating
						</span>
					</div>
				</div>"
				);
		$headers = array("Name", "Frame No.", "Corrosion Protection", "Coating Extent", "Cargo Heating", "Common Plane");
		$columns = $shipData->getColumnName("og_menu_child");
		
		//arranging the menu
		echo "<form role='form' class='form-horizontal'>";
		$childMenu = $shipData->getChildMenu("id", $code, $parent);
		foreach($childMenu as $menu)
		{
			$opt = explode("-", $menu['menu']);
		}
		$fields = "";
		for($i=0; $i<count($opt); $i++)
		{
			$fields = $fields.$forms[$opt[$i]]; 
		}
		
		$script = "";
		$button = "Submit";
		
		if($dataId !== null && $act != "del")
		{
			$button = "Update";
			$table = "og_data_$parent";
			$columns = $shipData->getColumnName($table);
			$colArr = array();
			foreach($columns as $column)
			{
				$colArr[] = $column['Field'];
			}
			
			$dataQuery = $shipData->getData($parent, "id", $dataId);
			
			$dataArr = array();
			for($k=0; $k<count($colArr); $k++)
			{
				$dataArr[$k] = $dataQuery['content'][0][$k];
			}
			
			$char = explode("+", $dataArr[4]);
			for($i=0; $i<count($char); $i++)
			{
				$char[$i] = "'".$char[$i]."'";
			}
			$common = array($dataArr[1], $dataArr[2], $dataArr[3]);
			for($i=0; $i<count($common); $i++)
			{
				$common[$i] = "'".$common[$i]."'";
			}
			
			$charStr = phpToJSArray($char);
			$commonStr = phpToJSArray($common);
			
			$script = "	<script>
							var common = $commonStr;
							var char = $charStr;
							var commonInput = document.getElementsByName('input-field');
							for(i=0; i<commonInput.length; i++)
							{
								commonInput[i].value = common[i];
							}
							
							if(char[0] != '-')
							{
								var corr = char[0].split('@');
								var corrInput = document.getElementsByName('cp-field');
								for(i=0; i<corrInput.length; i++)
								{
									for(j=0; j<corr.length; j++)
									{
										if(corrInput[i].value == corr[j])
										{
											corrInput[i].checked = true;
										}
									}
								}
							}
							
							if(char[1] != '-')
							{
								document.getElementById('coat-field').value = char[1];
							}
							
							if(char[2] != '-')
							{
								var heatInput = document.getElementsByName('ch-field');
								for(i=0; i<heatInput.length; i++)
								{
									if(heatInput[i].value == char[2])
									{
										heatInput[i].checked = true;
									}
								}
							}
							
							if(char[3] != '-')
							{
								var planeInput = document.getElementsByName('plane-field');
								for(i=0; i<planeInput.length; i++)
								{
									if(planeInput[i].value == char[3])
									{
										planeInput[i].checked = true;
									}
								}
							}
						</script>";
			
			
		}
		
		echo $fields;
		echo "<input id='parent-field' type='hidden' value=$parent></input>
			  <input id='dataid-field' type='hidden' value=$dataId></input>
			  <div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			";
		echo $script;
		
		//arranging table view
		echo "  <hr>
				<div class='panel-table'>
					<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
						<thead>
							<tr>
			";
		
		for($i=0; $i<count($opt); $i++)
		{
			$head = $headers[$opt[$i]];
			echo "<th>$head</th>";
		}
		echo "			<th>Update by</th>
						<th>Action</th>
					</tr>
				</thead>
			<tbody>
			";
		
		$tankData = $shipData->getData("tnk", "project", $projId, $code);
		$rowStr = "";
		foreach($tankData['content'] as $dat)
		{
			$name = $dat['tank_name'];
			$frame = "$dat[frame_start] ~ $dat[frame_end]";
			$charArray = explode("+", $dat['characteristic']);
			$userArray = $rms->get_users_id($dat['updateby']);
			foreach($userArray as $arr)
			{
				$usrName = $arr['nama'];
			}
			
			$rowStr = $rowStr. "	<tr>
							<td><a onclick='sendUpdate($id, $projId, $dat[id], $family);'>$name</a></td>
							<td>$frame</td>
					  ";
			
			for($k=0; $k<count($charArray); $k++)
			{
				if($charArray[$k] != "-")
				{
					$content = str_replace("@", " + ", $charArray[$k]);
					$rowStr = $rowStr."<td>$content</td>";
				}
			}
			
			$rowStr = $rowStr."		<td>$usrName</td>
									<td><a  onclick='deleteDat($dat[id], $projId, $id, $family)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Cancel Event'><i class='fa fa-times fa fa-white'></i></a></td>
								</tr>";
		}
		echo $rowStr;
		echo "				
						</tbody>
					</table>
				</div>";
	}
	
	function menuBulkhead($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$menuData = $shipData->getChecklist($projId, "blh");
		$count = $menuData['row'];
		
		echo "
				<p id='user-log'></p>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Bulkhead</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Transverse Bulkhead</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='bulk-field' value='tbl' class='flat-grey' checked onclick='return false'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Longitudinal Bulkhead</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='bulk-field' value='lbl' class='grey'>
									</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<style>
					input[type='checkbox'][readonly]
					{
						pointer-events: none;
					}
				</style>
			";
		if($count == 0)
		{
			$button = "Submit";
		}else
		{
			foreach($menuData['content'] as $dat)
			{
				$bulkStr = $dat['checklist'];
			}			
			$bulkArr = explode("#", $bulkStr);
			
			$checkbox = "[";
			
			for($l=0; $l<count($bulkArr); $l++)
			{
				$checkbox = $checkbox."'".$bulkArr[$l]."'".",";
			}
			$checkbox = substr_replace($checkbox, "]", -1);
			$button = "Update";
			
			$userLog = $shipData->getLastUser($projId, "og_menu_checklist", "blh");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			
			$userStr = "'Last update at $time by $name'";
			
			echo "
				<script>
					var checkbox = $checkbox;
					var checkField = document.getElementsByName('bulk-field');
					for(i=0; i<checkField.length; i++)
					{
						for(l=0; l<checkbox.length; l++)
						{
							if(checkField[i].value == checkbox[l])
							{
								checkField[i].checked = true;
							}
						}
					}
					var userLog = document.getElementById('user-log');
					userLog.innerHTML = $userStr;
				</script>
			";
		}			
			echo "	
				<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
					<i  id='tomboltask' class='fa fa-plus' ></i>
					$button
				</a>
			";
	}
	
	function menuTypeBulk($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id)
	{
		$family = '"'.$group.'"';
		if($act == "del")
		{
			$shipData->deleteData($dataId, $parent);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Delete data $id",$user_id,"",0,0,"$dataId#$parent");
		}
		
		$forms = array(
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Number :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Bulkhead Number, roman numerals only' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Frame No :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Frame Number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Frame No :
					</label>
					<div class='col-sm-4'>
						<input type='number' name='input-field' placeholder='Start' class='form-control'>
					</div>
					<label class='col-sm-2'>
						to
					</label>
					<div class='col-sm-4'>
						<input type='number' name='input-field' placeholder='End' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Location :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Location of bulkhead, distance from P/C/S. Ex: 6800mm from C' class='form-control'>
					</div>
				</div>"
				);
		$headers = array("Number", "Frame No.", "Frame No.", "Location");
		$columns = $shipData->getColumnName("og_menu_child");
		
		//arranging the menu
		echo "<form role='form' class='form-horizontal'>";
		$childMenu = $shipData->getChildMenu("id", $code, $parent);
		foreach($childMenu as $menu)
		{
			$opt = str_split($menu['menu']);
		}
		$fields = "";
		for($i=0; $i<count($opt); $i++)
		{
			$fields = $fields.$forms[$opt[$i]]; 
		}
		
		$script = "";
		$button = "Submit";
		
		if($dataId !== null && $act != "del")
		{
			$button = "Update";
			$table = "og_data_$parent";
			$columns = $shipData->getColumnName($table);
			$colArr = array();
			foreach($columns as $column)
			{
				$colArr[] = $column['Field'];
			}
			
			$dataQuery = $shipData->getData($parent, "id", $dataId);
			
			$dataArr = array();
			for($k=0; $k<count($colArr); $k++)
			{
				$dataArr[$k] = "'".$dataQuery['content'][0][$k]."'";
			}
			
			$common = array($dataArr[1],$dataArr[2],$dataArr[3],$dataArr[4]);
			$commonStr = phpToJSArray($common);
			
			$script = "	<script>
							var common = $commonStr;
							var commonInput = document.getElementsByName('input-field');
							for(i=0; i<commonInput.length; i++)
							{
								commonInput[i].value = common[i];
							}
						</script>";
		}
		
		echo $fields;
		echo "<input id='parent-field' type='hidden' value=$parent></input>
			  <input id='dataid-field' type='hidden' value=$dataId></input>
			  <div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			";
		echo $script;
		
		//arranging table view
		echo "  <hr>
				<div class='panel-table'>
					<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
						<thead>
							<tr>
			";
		
		for($i=0; $i<count($opt); $i++)
		{
			$head = $headers[$opt[$i]];
			echo "<th>$head</th>";
		}
		echo "			<th>Update by</th>
						<th>Action</th>
					</tr>
				</thead>
			<tbody>
			";
		
		$blhData = $shipData->getData("blh", "project", $projId, $code);
		$rowStr = "";
		foreach($blhData['content'] as $dat)
		{
			$number = $dat['bulkhead_num'];
			$userArray = $rms->get_users_id($dat['updateby']);
			foreach($userArray as $arr)
			{
				$usrName = $arr['nama'];
			}
			
			if($dat['frame_end'] == 0)
			{
				$frame = $dat["frame_start"];
				$rowStr = $rowStr. "	<tr>
							<td><a onclick='sendUpdate($id, $projId, $dat[id], $family);'>$number</a></td>
							<td>$frame</td>
					  ";
			}else
			{
				$frame = "$dat[frame_start] ~ $dat[frame_end]";
				$rowStr = $rowStr. "	<tr>
							<td><a onclick='sendUpdate($id, $projId, $dat[id], $family);'>$number</a></td>
							<td>$frame</td>
							<td>$dat[bulkhead_loc]</td>
					  ";
			}
			
			$rowStr = $rowStr."		<td>$usrName</td>
									<td><a  onclick='deleteDat($dat[id], $projId, $id, $family)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Cancel Event'><i class='fa fa-times fa fa-white'></i></a></td>
								</tr>";
		}
		echo $rowStr;
		echo "				
						</tbody>
					</table>
				</div>";
	}
	
	function menuDeck($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$menuData = $shipData->getChecklist($projId, "dck");
		$count = $menuData['row'];
		
		echo "
				<p id='user-log'></p>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Deck</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Decks</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='deck-field' value='dec' class='flat-grey' checked onclick='return false'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Superstructures and Other Decks</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='deck-field' value='spc' class='grey'>
									</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
				<style>
					input[type='checkbox'][readonly]
					{
						pointer-events: none;
					}
				</style>
			";
		if($count == 0)
		{
			$button = "Submit";
		}else
		{
			foreach($menuData['content'] as $dat)
			{
				$deckStr = $dat['checklist'];
			}			
			$deckArr = explode("#", $deckStr);
			
			$checkbox = "[";
			
			for($l=0; $l<count($deckArr); $l++)
			{
				$checkbox = $checkbox."'".$deckArr[$l]."'".",";
			}
			$checkbox = substr_replace($checkbox, "]", -1);
			$button = "Update";
			
			$userLog = $shipData->getLastUser($projId, "og_menu_checklist", "dck");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			
			$userStr = "'Last update at $time by $name'";
			
			echo "
				<script>
					var checkbox = $checkbox;
					var checkField = document.getElementsByName('deck-field');
					for(i=0; i<checkField.length; i++)
					{
						for(l=0; l<checkbox.length; l++)
						{
							if(checkField[i].value == checkbox[l])
							{
								checkField[i].checked = true;
							}
						}
					}
					var userLog = document.getElementById('user-log');
					userLog.innerHTML = $userStr;
				</script>
			";
		}			
			echo "	
				<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
					<i  id='tomboltask' class='fa fa-plus' ></i>
					$button
				</a>
			";
	}
	
	function menuTypeDeck($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id)
	{
		$family = '"'.$group.'"';
		if($act == "del")
		{
			$shipData->deleteData($dataId, $parent);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Delete data $id",$user_id,"",0,0,"$dataId#$parent");
		}
		
		$option = array("dec"=>array("--Deck Type--", "Strength Deck", "Second Deck", "Third Deck", "Fourth Deck", "Fifth Deck", "Sixth Deck"),
						"spc"=>array("--Deck Type--", "Fore Castle Deck", "Poop Deck", "Boat Deck", "Bridge Deck", "Wheel House Deck", "Top Deck"));
		
		$optionSel = "";
		
		$typeOption=$option[$code];
		
		$max = count($typeOption);
		for($i=0; $i<$max; $i++)
		{
			$optionSel = $optionSel."<option value=$i>$typeOption[$i]</option>";
		}
		
		$fields = "
				<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Deck Type :
					</label>
					<div class='col-sm-10'>
						<select name='input-field' class='form-control'>
							$optionSel
						</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Frame Number :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Frame Number' class='form-control'>
					</div>
				</div>
				";
		
		$script = "";
		$button = "Submit";
		
		if($dataId !== null && $act != "del")
		{
			$button = "Update";
			$table = "og_data_$parent";
			$columns = $shipData->getColumnName($table);
			$colArr = array();
			foreach($columns as $column)
			{
				$colArr[] = $column['Field'];
			}
			
			$dataQuery = $shipData->getData($parent, "id", $dataId);
			
			$dataArr = array();
			for($k=0; $k<count($colArr); $k++)
			{
				$dataArr[$k] = "'".$dataQuery['content'][0][$k]."'";
			}
			
			$common = array($dataArr[1],$dataArr[2]);
			$commonStr = phpToJSArray($common);
			
			$script = "	<script>
							var common = $commonStr;
							var commonInput = document.getElementsByName('input-field');
							for(i=0; i<commonInput.length; i++)
							{
								commonInput[i].value = common[i];
							}
						</script>";
		}
		
		echo $fields;
		echo "<input id='parent-field' type='hidden' value=$parent></input>
			  <input id='dataid-field' type='hidden' value=$dataId></input>
			  <div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			";
		echo $script;
		
		//arranging table view
		echo "  <hr>
				<div class='panel-table'>
					<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
						<thead>
							<tr>
								<th>Deck Name</th>
								<th>Frame Number</th>
								<th>Update by</th>
								<th>Action</th>
							<tr>
						<thead>
						<tbody>
			";
			
		$deckData = $shipData->getData("dck", "project", $projId, $code);
		$rowStr = "";
		foreach($deckData['content'] as $dat)
		{
			$deckNum = $dat['decks'];
			$deckName = $option[$code][$deckNum];
			$frame = $dat['frame_num'];
			$userArray = $rms->get_users_id($dat['updateby']);
			foreach($userArray as $arr)
			{
				$usrName = $arr['nama'];
			}
			$rowStr = $rowStr. "	
							<tr>
								<td><a onclick='sendUpdate($id, $projId, $dat[id], $family);'>$deckName</a></td>
								<td>$frame</td>
								<td>$usrName</td>
								<td><a  onclick='deleteDat($dat[id], $projId, $id, $family)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Cancel Event'><i class='fa fa-times fa fa-white'></i></a></td>
							</tr>";
		}
		echo $rowStr;
		echo "				
						</tbody>
					</table>
				</div>";
	}
	
	function menuEquipment($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$equipQuery = $shipData->getEquipment($projId);
		
		if($equipQuery['row'] == 0)
		{
			$stud = "checked";
			$chain = "checked";
			$updateStr = "";
			$button = "Submit";
			$script="";
		}else
		{
			$n = 0;
			$userLog = $shipData->getLastUser($projId, "og_data_eqp");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			$updateStr = "<p>Last update at $time by $name<p>";
			$button = "Update";
			
			foreach($equipQuery['content'] as $dat)
			{
				$equipData[$n][0] = '"'.$dat['num'].'"';
				$equipData[$n][1] = '"'.$dat['length'].'"';
				$equipData[$n][2] = '"'.$dat['characteristic'].'"';
				$equipData[$n][3] = '"'.$dat['dimension'].'"';
				$equipData[$n][4] = '"'.$dat['opt'].'"';
				$equipData[$n][5] = '"'.$dat['manuf'].'"';
				$equipData[$n][6] = '"'.$dat['certificate'].'"';
				$n++;
			}
			
			$equipData1 = phpToJSArray($equipData[0]);
			$equipData2 = phpToJSArray($equipData[1]);
			$equipData3 = phpToJSArray($equipData[2]);
			$equipData4 = phpToJSArray($equipData[3]);
			$equipData5 = phpToJSArray($equipData[4]);
			$equipData6 = phpToJSArray($equipData[5]);
			
			$script = "
						<script>
							var equipData = [$equipData1, $equipData2, $equipData3, $equipData4, $equipData5, $equipData6];
							var opt3 = equipData[2][4];
							var opt4 = equipData[3][4];
							
							for(i=1; i<=6; i++)
							{
								var name = 'input-field'+i;
								var elem = document.getElementsByName(name);
								var n = 0;
								var flag = false;
								for(j=0; j<elem.length; j++)
								{
									if(elem[j].id == 'radio-field')
									{
										flag = true;
										if(elem[j].value == opt3 || elem[j].value == opt4)
										{
											elem[j].checked = true;
										}
									}else
									{
										if(flag)
										{
											n++;
											flag = false;
										}
										elem[j].value = equipData[i-1][n];
										n++;
									}
								}
								
							}
						</script>
			";
			
		}
		
		echo "
			$updateStr
			<h4>Bower Anchors</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field1' placeholder='Quantity of anchor' class='form-control'>
						<input type='hidden' name='input-field1' value='0'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Type of anchor' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Weight :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field1' placeholder='Weight of anchor (in kg)' class='form-control'>
						<input type='hidden' name='input-field1' value='0'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Manufacturer' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<h4>Stream Anchors</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field2' placeholder='Quantity of anchor' class='form-control'>
						<input type='hidden' name='input-field2' value='0'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Type of anchor' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Weight :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field2' placeholder='Weight of anchor (in kg)' class='form-control'>
						<input type='hidden' name='input-field2' value='0'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Manufacturer' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<h4>Bower Anchor Chain Cables</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Length :	
					</label>
					<div class='col-sm-10'>
						<input type='hidden' name='input-field3' value='0'>
						<input type='number'  name='input-field3' placeholder='Total length of chain cable (in m)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Grade :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Grade of chain cable, eg: K3' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Diameter :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field3' placeholder='Diameter of chain cable (in mm)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Stud :	
					</label>
					<div class='col-sm-10'>
						<label class='radio-inline'>
							<input type='radio' id='radio-field' value='with' name='input-field3' class='grey' checked>
							With Stud
						</label>
						<label class='radio-inline'>
							<input type='radio' id='radio-field' value='without' name='input-field3' class='grey'>
							Without Stud
						</label>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Manufacturer of chain cable' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<h4>Stream Anchor Chain Cables</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Length :	
					</label>
					<div class='col-sm-10'>
						<input type='hidden' name='input-field4' value='0'>
						<input type='number'  name='input-field4' placeholder='Length of chain cable (in m)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Grade :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field4' placeholder='Grade of chain cable, eg : K3' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Diameter :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field4' placeholder='Diameter of chain cable (in mm)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :	
					</label>
					<div class='col-sm-10'>
						<label class='radio-inline'>
							<input id='radio-field' type='radio' value='chain' name='input-field4' class='grey' checked>
							Chain Cable
						</label>
						<label class='radio-inline'>
							<input id='radio-field' type='radio' value='wire' name='input-field4' class='grey'>
							Steel Wire Rope
						</label>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field4' placeholder='Manufacturer of chain cable' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field4' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<h4>Tow Line</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Qty :
					</label>
					<div class='col-sm-4'>
						<input type='number' name='input-field5' placeholder='Quantity' class='form-control'>
					</div>
					<label class='col-sm-2'>
						x Total Length
					</label>
					<div class='col-sm-4'>
						<input type='number' name='input-field5' placeholder='in m' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Material :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field5' placeholder='Material' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Diameter :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field5' placeholder='Diameter of tow line (in mm)' class='form-control'>
						<input type='hidden' name='input-field5' value='0'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field5' placeholder='Manufacturer of tow line' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field5' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<h4>Mooring Line</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Qty :
					</label>
					<div class='col-sm-4'>
						<input type='number' name='input-field6' placeholder='Quantity' class='form-control'>
					</div>
					<label class='col-sm-2'>
						x Total Length
					</label>
					<div class='col-sm-4'>
						<input type='number' name='input-field6' placeholder='in m' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Material :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field6' placeholder='Material of mooring line' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Diameter :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field6' placeholder='Diameter of mooring line (in mm)' class='form-control'>
						<input type='hidden' name='input-field6' value='0'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field6' placeholder='Manufacturer of mooring line' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field6' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<form role='form' class='form-horizontal'>
			<div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			
			$script
		";
	}
	
	function menuRudder($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$rudderQuery = $shipData->getRudder($projId);
		
		if($rudderQuery['row'] == 0)
		{
			$updateStr = "";
			$button = "Submit";
			$script="";
		}else
		{
			$n = 0;
			$userLog = $shipData->getLastUser($projId, "og_data_rudder");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			$updateStr = "<p>Last update at $time by $name<p>";
			$button = "Update";
			
			foreach($rudderQuery['content'] as $dat)
			{
				$rudderData[$n][0] = '"'.$dat['qty'].'"';
				$rudderData[$n][1] = '"'.$dat['size'].'"';
				$rudderData[$n][2] = '"'.$dat['material'].'"';
				$rudderData[$n][3] = '"'.$dat['thickness'].'"';
				$rudderData[$n][4] = '"'.$dat['certificate'].'"';
				$rudderData[$n][5] = '"'.$dat['flange'].'"';
				$n++;
			}
			
			$jsArray = "[";
			for($i=0; $i<=8; $i++)
			{
				$jsArrayMember = phpToJSArray($rudderData[$i]);
				$jsArray = $jsArray.$jsArrayMember.",";
			}
			
			$jsArray = substr_replace($jsArray, "]", -1);
			
			$script = "
						<script>
							var rudderData = $jsArray ;
							
							for(i=1; i<=9; i++)
							{
								var name = 'input-field'+i;
								var elem = document.getElementsByName(name);
								var n = 0;
								var flag = false;
								for(j=0; j<elem.length; j++)
								{
									elem[j].value = rudderData[i-1][j];
								}
								
							}
						</script>
			";
			
		}
		
		echo "
			$updateStr
			<h4>Rudder Blade</h4>
			<form id='rudder' role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field1' placeholder='Quantity of rudder blade' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Size :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Size (length x width in mm)' class='form-control'>
						<input type='hidden' name='input-field1' value='-'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Thickness :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field1' placeholder='Plate thickness' class='form-control'>
						<input type='hidden' name='input-field1' value='-'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Coupling Flange :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Size of coupling flange in mm' class='form-control'>
					</div>
				</div>
			
			
			<h4>Rudder Stock</h4>
			
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field2' placeholder='Quantity of rudder stock' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Size :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Size of rudder stock (length x diameter in mm)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Material :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Material' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Thickness :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Sleeve thickness' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Certificate number' class='form-control'>
						<input type='hidden' name='input-field2' value='-'>
					</div>
				</div>
			
			
			<h4>Rudder Pintle</h4>
			
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field3' placeholder='Quantity of rudder pintle' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Size :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Size of rudder pintle (length x diameter in mm)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Material :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Material' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Thickness :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Sleeve thickness' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Certificate number' class='form-control'>
						<input type='hidden' name='input-field3' value='-'>
					</div>
				</div>
			
			
			<h4>Rudder Fit Bolts</h4>
			
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field4' placeholder='Quantity of rudder stock' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Size :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field4' placeholder='Size of rudder stock (length x diameter in mm)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Material :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field4' placeholder='Weight of anchor (in kg)' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field4' placeholder='Certificate number' class='form-control'>
						<input type='hidden' name='input-field4' value='-'>
						<input type='hidden' name='input-field4' value='-'>
					</div>
				</div>
			
			
			<h4>Bearing</h4>
			<table class='table table-hover table-bordered' id='sample-table-1'>
				<thead>
					<tr>
						<th>Bearing</th>
						<th>Size</th>
						<th>Material</th>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td>Carrier bearing</td>
						<td>
							<input type='hidden' name='input-field5' value = '-'>
							<input type='text' name='input-field5' placeholder='Length x dia (in mm)'>
						</td>
						<td>
							<input type='text' name='input-field5' placeholder='material'>
							<input type='hidden' name='input-field5' value = '-'>
							<input type='hidden' name='input-field5' value = '-'>
							<input type='hidden' name='input-field5' value = '-'>
						</td>
					</tr>
					<tr>
						<td>Neck Bearing</td>
						<td>
							<input type='hidden' name='input-field6' value = '-'>
							<input type='text' name='input-field6' placeholder='Length x dia (in mm)'>
						</td>
						<td>
							<input type='text' name='input-field6' placeholder='material'>
							<input type='hidden' name='input-field6' value = '-'>
							<input type='hidden' name='input-field6' value = '-'>
							<input type='hidden' name='input-field6' value = '-'>
						</td>
					</tr>
					<tr>
						<td>Upper Pintle Bearing</td>
						<td>
							<input type='hidden' name='input-field7' value = '-'>
							<input type='text' name='input-field7' placeholder='Length x dia (in mm)'>
						</td>
						<td>
							<input type='text' name='input-field7' placeholder='material'>
							<input type='hidden' name='input-field7' value = '-'>
							<input type='hidden' name='input-field7' value = '-'>
							<input type='hidden' name='input-field7' value = '-'>
						</td>
					</tr>
					<tr>
						<td>Lower Pintle Bearing</td>
						<td>
							<input type='hidden' name='input-field8' value = '-'>
							<input type='text' name='input-field8' placeholder='Length x dia (in mm)'>
						</td>
						<td>
							<input type='text' name='input-field8' placeholder='material'>
							<input type='hidden' name='input-field8' value = '-'>
							<input type='hidden' name='input-field8' value = '-'>
							<input type='hidden' name='input-field8' value = '-'>
						</td>
					</tr>
					<tr>
						<td>Bottom Pintle Bearing</td>
						<td>
							<input type='hidden' name='input-field9' value = '-'>
							<input type='text' name='input-field9' placeholder='Length x dia (in mm)'>
						</td>
						<td>
							<input type='text' name='input-field9' placeholder='material'>
							<input type='hidden' name='input-field9' value = '-'>
							<input type='hidden' name='input-field9' value = '-'>
							<input type='hidden' name='input-field9' value = '-'>
						</td>
					</tr>
				</tbody>
			</table>

			
			
			<div class='form-group'>
				
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			
			$script
		";
	}
	
	function menuCargo($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$cargoQuery = $shipData->getCargo($projId);
		
		if($cargoQuery['row'] == 0)
		{
			$updateStr = "";
			$button = "Submit";
			$script="";
		}else
		{
			$n = 0;
			$userLog = $shipData->getLastUser($projId, "og_data_cargo");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			$updateStr = "<p>Last update at $time by $name<p>";
			$button = "Update";
			
			foreach($cargoQuery['content'] as $dat)
			{
				$cargoData[$n][0] = '"'.$dat['qty'].'"';
				$cargoData[$n][1] = '"'.$dat['dimension'].'"';
				$cargoData[$n][2] = '"'.$dat['manufacturer'].'"';
				$cargoData[$n][3] = '"'.$dat['certificate'].'"';
				$n++;
			}
			
			$jsArray = "[";
			for($i=0; $i<=2; $i++)
			{
				$jsArrayMember = phpToJSArray($cargoData[$i]);
				$jsArray = $jsArray.$jsArrayMember.",";
			}
			
			$jsArray = substr_replace($jsArray, "]", -1);
			
			$script = "
						<script>
							var cargoData = $jsArray ;
							
							for(i=1; i<=3; i++)
							{
								var name = 'input-field'+i;
								var elem = document.getElementsByName(name);
								var n = 0;
								var flag = false;
								for(j=0; j<elem.length; j++)
								{
									elem[j].value = cargoData[i-1][j];
								}
								
							}
						</script>
			";
			
		}
		
		echo "
			$updateStr
			<h4>Mast</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field1' placeholder='Quantity of mast' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Size :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Size' class='form-control'>
						<input type='hidden' name='input-field1' value='-'>
						<input type='hidden' name='input-field1' value='-'>
					</div>
				</div>
			</form>
			
			<h4>Derrick Boom</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field2' placeholder='Quantity of derrick boom' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						SWL :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='in tonne' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Manufacturer' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No. :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<h4>Crane</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field3' placeholder='Quantity of crane' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						SWL :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='in tonne' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Manufacturer' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No. :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<form role='form' class='form-horizontal'>
			<div class='form-group'>
			<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			
			$script
		";
	}
	
	function menuMainEngine($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$engineQuery = $shipData->getMainEngine($projId);
		
		if($engineQuery['row'] == 0)
		{
			$updateStr = "";
			$button = "Submit";
			$script="";
			$k = 0;
		}else
		{
			$n = 0;
			$userLog = $shipData->getLastUser($projId, "og_data_meg");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			$updateStr = "<p>Last update at $time by $name<p>";
			$button = "Update";
			
			$engineData = array();
			foreach($engineQuery['content'] as $dat)
			{
				$engineData[0] = '"'.$dat['brand'].'"'; 
				$engineData[1] = '"'.$dat['type'].'"';
				$engineData[2] = '"'.$dat['qty'].'"';
				$engineData[3] = '"'.$dat['power'].'"';
				$engineData[4] = '"'.$dat['revolution'].'"'; 
				$engineData[5] = '"'.$dat['cylinder'].'"';
				$engineData[6] = '"'.$dat['bore'].'"';
				$engineData[7] = '"'.$dat['stroke'].'"';
				$engineData[8] = '"'.$dat['year'].'"'; 
				$engineData[9] = '"'.$dat['serial'].'"';
				$engineData[10] = '"'.$dat['certificate'].'"';
				$engineData[11] = '"'.$dat['manufacturer'].'"';
				$engineData[12] = '"'.$dat['start'].'"'; 
				$engineData[13] = $dat['accessories'];
			}
			
			$temp = explode("@", array_pop($engineData));
			$accData=array();
			for($i=0; $i<count($temp); $i++)
			{
				$accData[] = '"'.$temp[$i].'"';
			}
			$k = count($temp) - 1;
			
			$start = array_pop($engineData);
			$engineDataJs = phpToJSArray($engineData);
			$accDataJs = phpToJSArray($accData);
			
			$script = "
						<script>
							var startMethod = $start;
							var engineData = $engineDataJs;
							var accData = $accDataJs;
							
							var input = document.getElementsByName('input-field');
							var radio = document.getElementsByName('radio-field');
							var sel = document.getElementsByName('select-field');
							var type = document.getElementsByName('type-field');
							var num = document.getElementsByName('num-field');
							
							for(i=0; i<input.length; i++)
							{
								input[i].value = engineData[i];
							}
							
							for(i=0; i<radio.length; i++)
							{
								if(radio[i].value == startMethod)
								{
									radio[i].checked = true;
								}
							}
							
							for(i=0; i<sel.length; i++)
							{
								temp = accData[i].split('+');
								sel[i].value = temp[0];
								type[i].value = temp[1];
								num[i].value = temp[2];
							}
							
						</script>
			";
			
		}
		
		$table = "";
		for($j=0; $j<=$k; $j++)
		{
			$table = $table."
						<tr id = 'row-data'>
							<td>
								<select name='select-field' class='form-control'>
									<option value='1'>Turbocharger</option>
									<option value='2'>Intercooler</option>
									<option value='3'>Aux Blower</option>
									<option value='4'>Attached Pumps</option>
									<option value='5'>Attached Coolers</option>
									<option value='6'>Attached Heaters</option>
									<option value='7'>Flexible Coupling</option>
									<option value='8'>Clutch</option>
								</select>
							</td>
							<td>
								<input type='text' name='type-field'>
								<input type='hidden' id='id-field'>
							</td>
							<td>
								<input type='number' name='num-field'>
							</td>
							<td>
								<a class='btn btn-xs btn-bricky tooltips' onclick='deleteOpt(this);' data-placement='top' data-original-title='Delete Data'><i class='fa fa-times fa fa-white'></i></a>
								<a class='btn btn-xs btn-blue tooltips' onclick='addItem2();' data-placement='top' data-original-title='Add Item'><i class='fa fa-plus fa fa-white'></i></a>
							</td>
						</tr>
						";
		}
		
		echo "
			$updateStr
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Brand :	
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Brand of main engine' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Type of main engine' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field' placeholder='Quantity of main engine' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Power :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Power of main engine (can be in HP or kW) eg: 4050kW' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Revolution :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Revolution of main engine in rpm' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Cyllinder Qty :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Quantity of cylinder' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Bore x stroke :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='eg: 300 x 400' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Stroke :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Number of stroke' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Year :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Year of built' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Serial No. :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Serial number' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No. :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Manufacturer' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Starting Method :	
					</label>
					<div class='col-sm-10'>
					<label class='radio-inline'>
						<input type='radio' value='air' name='radio-field' class='grey' checked>
						Air
					</label>
					<label class='radio-inline'>
						<input type='radio' value='batt' name='radio-field' class='grey'>
						Battery
					</label>											
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Accessories :	
					</label>
					<div class='col-sm-10'>
						<table class='table table-hover' id='option-table'>
							<thead>
								<tr>
									<th>Item</th>
									<th>Type/Purpose</th>
									<th>Quantity</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								$table
							</tbody>
						</table>
					</div>
				</div>
			</form>
			
			<form role='form' class='form-horizontal'>
			<div class='form-group'>
			<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			
			$script
		";
	}
	
	function menuMachinery($id, $code, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$menuData = $shipData->getChecklist($projId, $code);
		$count = $menuData['row'];
		
		$items = $shipData->getMenu($code);
		foreach($items as $dat)
		{
			$menuStr = $dat['menu'];
		}
		$menuArr = explode("+", $menuStr);
		
		$rows = "";
		for($i=0; $i<count($menuArr); $i++)
		{
			$childNames = $shipData->getChildMenu("id", $menuArr[$i], $code);
			$childIdentifier = $menuArr[$i];
			foreach($childNames as $dat)
			{
				$name = str_replace("+", " ", $dat['title']);
			}
			$rows = $rows. "<tr>
							<td>$name</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='item-field' value=$childIdentifier class='flat-grey'>
									</label>
								</div>
							</td>
						</tr>";
		}
		
		echo "
				<p id='user-log'></p>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Item</th>
							<th>Action</th>
						</tr>
					</thead>
					<tbody>
						$rows
					</tbody>
				</table>
				<input type='hidden' id='parent-field' value=$code>
			";
		if($count == 0)
		{
			$button = "Submit";
		}else
		{
			foreach($menuData['content'] as $dat)
			{
				$dataStr = $dat['checklist'];
			}			
			$dataArr = explode("#", $dataStr);
			for($k=0; $k<count($dataArr); $k++)
			{
				$dataArr[$k] = "'".$dataArr[$k]."'";
			}
			
			$checkbox = phpToJSArray($dataArr);
			$button = "Update";
			
			$userLog = $shipData->getLastUser($projId, "og_menu_checklist", $code);
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			
			$userStr = "'Last update at $time by $name'";
			
			echo "
				<script>
					var checkbox = $checkbox;
					var checkField = document.getElementsByName('item-field');
					for(i=0; i<checkField.length; i++)
					{
						for(l=0; l<checkbox.length; l++)
						{
							if(checkField[i].value == checkbox[l])
							{
								checkField[i].checked = true;
							}
						}
					}
					var userLog = document.getElementById('user-log');
					userLog.innerHTML = $userStr;
				</script>
			";
		}			
			echo "	
				<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
					<i  id='tomboltask' class='fa fa-plus' ></i>
					$button
				</a>
			";
	}
	
	function menuTypeMachinery($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id)
	{
		$family = '"'.$group.'"';
		
		if($act == "del")
		{
			$shipData->deleteData($dataId, "machinery");
			$obj->WriteLogAplicationLogs($user_id,$projId,"Delete data $id",$user_id,"",0,0,"$dataId#$parent");
		}
		
		$forms = array(
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Qty :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='common-field' placeholder='Quantity' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Brand :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='common-field' placeholder='Brand' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Year :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='common-field' placeholder='Year of Built' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='common-field' placeholder='Certificate Number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Type' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<select id='char-field' class='form-control'>
							<option value='-'>--Heater Type--</option>
							<option value='EH'>Electric Heater</option>
							<option value='SH'>Steam Heater</option>
							<option value='TH'>Thermal Oil Heater</option>
						</select>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Head :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Delivery Head (in m)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Capacity :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Capacity' class='form-control'>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Input for capacity, volume, max torque, pulling capacity
						</span>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Power :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Electromotor Power (in kW)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Area :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Heating Surface Area' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Pressure :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Working Pressure' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Propeller :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Propeller size' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Blade :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Blade number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Dimension :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Dimension' class='form-control'>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Input for rudder stock diameter, dia x pitch
						</span>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Prime Mover :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Power and/or revolution of prime mover' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Prime Mover Type :
					</label>
					<div class='col-sm-10'>
						<select id='char-field' class='form-control'>
							<option value='-'>--Prime Mover Type--</option>
							<option value='HD'>Hydraulic</option>
							<option value='ME'>Mechanical</option>
						</select>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Input for prime mover type or emergency steering system
						</span>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Serial No. :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Serial number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Location :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Location of equipment' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Protection :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Heat protection' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Level Gauge :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Level gauge' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Setting Pressure :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='char-field' placeholder='Setting pressure' class='form-control'>
					</div>
				</div>"
				);
		$headers = array("Qty", "Brand", "Year", "Certificate", "Type", "Type", "Delivery Head", "Capacity", "Power",
						 "Area", "Working Pressure", "Propeller size", "Blade Num", "Dimension", "Prime Mover",
						 "Prime Mover Type", "Serial Number", "Location", "Heat Protection", "Level Gauge", "Setting Pressure");
		
		//arranging the menu
		echo "";
		if($parent=="root")
		{
			$parent = $code;
		}
		$childMenu = $shipData->getChildMenu("id", $code, $parent);
		foreach($childMenu as $menu)
		{
			$opt = explode("-", $menu['menu']); 
		}
		$fields = "";
		for($i=0; $i<count($opt); $i++)
		{
			$fields = $fields.$forms[$opt[$i]]; 
		}
		
		$script = "";
		$button = "Submit";
		
		if($dataId !== null && $act != "del")
		{
			$button = "Update";
			$table = "og_data_machinery";
			$columns = $shipData->getColumnName($table);
			$colArr = array();
			foreach($columns as $column)
			{
				$colArr[] = $column['Field'];
			}
			
			$dataQuery = $shipData->getMachineryData("id", $projId, $dataId);
		
			$dataArr = array();
			for($k=0; $k<count($colArr); $k++)
			{
				$dataArr[$k] = $dataQuery['content'][0][$k];
			}
			
			$temp1 = array($dataArr[1], $dataArr[2], $dataArr[3], $dataArr[4]);
			$temp2 = explode("+", $dataArr[5]);
			$temp3 = array_merge($temp1, $temp2);
			
			for($i=0; $i<count($opt); $i++)
			{
				$box[$i] = "'".$temp3[$opt[$i]]."'";
			}
			
			$common = array($box[0], $box[1], $box[2], $box[3]);
			$char = array_slice($box, 4);
			
			$charStr = phpToJSArray($char);
			$commonStr = phpToJSArray($common);
			
			$script = "	<script>
							var common = $commonStr;
							var chara = $charStr;
							var commonInput = document.getElementsByName('common-field');
							var charaInput = document.getElementsByName('char-field');
							
							for(i=0; i<commonInput.length; i++)
							{
								commonInput[i].value = common[i];
							}
							
							for(i=0; i<charaInput.length; i++)
							{
								charaInput[i].value = chara[i];
							}
							
						</script>";
		}
		
		echo "	<form role='form' class='form-horizontal'>
					$fields
					<input id='parent-field' type='hidden' value=$parent></input>
					<input id='dataid-field' type='hidden' value=$dataId></input>
					<div class='form-group'>
						<label class='col-sm-2 control-label' for='form-field-1'>
						</label>
						<div class='col-sm-10'>
							<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
								<i  id='tomboltask' class='fa fa-plus' ></i>
								$button
							</a>
						</div>
					</div>
				</form>
				$script
			";
		
		//arranging table view
		$tableHead = "";
		for($i=0; $i<count($opt); $i++)
		{
			$head = $headers[$opt[$i]];
			$tableHead = $tableHead."<th>$head</th>";
		}
		$tableHead = $tableHead."			
						<th>Update by</th>
						<th>Action</th>
					 ";
		
		$itemData = $shipData->getMachineryData("type", $projId, $code, $parent);
		$dataArr = array();
		$temp = array();
		$nameArr = array();
		$rowStr = "";
		foreach($itemData['content'] as $dat)
		{
			$temp[0] = $dat['qty'];
			$temp[1] = $dat['brand'];
			$temp[2] = $dat['year'];
			$temp[3] = $dat['certificate'];
			
			$userArray = $rms->get_users_id($dat['updateby']);
			foreach($userArray as $arr)
			{
				$usrName = $arr['nama'];
			}
			
			$pieces = explode("+", $dat['characteristic']);
			$dataArr = array_merge($temp, $pieces);
			
			$rowStr = $rowStr."<tr>";
			for($k=0; $k<count($opt); $k++)
			{
				$content = $dataArr[$opt[$k]];
				$rowStr = $rowStr."<td>$content</td>";
			}
			$updateBy = $usrName;
			
			$rowStr = $rowStr."
								<td>$updateBy</td>
								<td>
									<a  onclick='sendUpdate($id, $projId, $dat[id], $family);' class='btn btn-xs btn-primary tooltips' data-placement='top' data-original-title='Edit Data'><i class='fa fa-pencil fa fa-white'></i></a>
									<a  onclick='deleteDat($dat[id], $projId, $id, $family);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Delete Data'><i class='fa fa-times fa fa-white'></i></a>
								</td>
							</tr>
			";
		}
		echo "  <hr>
				<div class='panel-table'>
					<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
						<thead>
							<tr>
								$tableHead
							</tr>
						</thead>
						<tbody>
							$rowStr
						</tbody>
					</table>
				</div>
			";
	}
	
	function menuTransmission($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$menuData = $shipData->getChecklist($projId, "trs");
		$count = $menuData['row'];
		
		echo "
				<p id='user-log'></p>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Transmission System</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Intermediate Shaft</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='transm-field' value='ims' class='flat-grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Reduction and Reversible Gear</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='transm-field' value='rvg' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Thrust Shaft Bearing</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='transm-field' value='tfb' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Fit Bolts</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='transm-field' value='fgf' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Coupling Fit Bolts</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='transm-field' value='cob' class='grey'>
									</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			";
		if($count == 0)
		{
			$button = "Submit";
		}else
		{
			foreach($menuData['content'] as $dat)
			{
				$trmStr = $dat['checklist'];
			}			
			$trmArr = explode("#", $trmStr);
			
			$checkbox = "[";
			
			for($l=0; $l<count($trmArr); $l++)
			{
				$checkbox = $checkbox."'".$trmArr[$l]."'".",";
			}
			$checkbox = substr_replace($checkbox, "]", -1);
			$button = "Update";
			
			$userLog = $shipData->getLastUser($projId, "og_menu_checklist", "trs");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			
			$userStr = "'Last update at $time by $name'";
			
			echo "
				<script>
					var checkbox = $checkbox;
					var checkField = document.getElementsByName('transm-field');
					for(i=0; i<checkField.length; i++)
					{
						for(l=0; l<checkbox.length; l++)
						{
							if(checkField[i].value == checkbox[l])
							{
								checkField[i].checked = true;
							}
						}
					}
					var userLog = document.getElementById('user-log');
					userLog.innerHTML = $userStr;
				</script>
			";
		}			
			echo "	
				<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
					<i  id='tomboltask' class='fa fa-plus' ></i>
					$button
				</a>
			";
	}
	
	function menuTypeTransmission($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id)
	{
		$family = '"'.$group.'"';
		if($act == "del")
		{
			$shipData->deleteData($dataId, $parent);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Delete data $id",$user_id,"",0,0,"$dataId#$parent");
		}
		
		
		$forms = array( "",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Dimension :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Dimension' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Qty :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Quantity' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Bearing qty :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Quantity of bearing' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Material :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Material' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='The name of manufacturer' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Certificate Number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Year :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Year of production' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Brand :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Brand name' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Type' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Power :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Effective Power' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Revolution :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Revolution in RPM' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Reduction Ratio :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Reduction ratio' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Bolt Type :
					</label>
					<div class='col-sm-10'>
						<select name='input-field' class='form-control'>
							<option value='-'>--Bolt Type--</option>
							<option value='ME'>Main engine foundation fit bolt</option>
							<option value='GB'>Gear box foundation fit bolt</option>
						</select>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Bolt Type :
					</label>
					<div class='col-sm-10'>
						<select name='input-field' class='form-control'>
							<option value='-'>--Bolt Type--</option>
							<option value='PI'>Propeller shaft coupling with intermediate shaft coupling</option>
							<option value='IG'>Intermediate shaft coupling with gear box shaft coupling</option>
							<option value='PG'>Propeller shaft coupling with gear box shaft coupling</option>
							<option value='II'>Intermediate shaft coupling with Intermediate shaft coupling</option>
						</select>
					</div>
				</div>"
				);
		$name = array('ME'=>'Main engine foundation fit bolt', 
					  'GB'=>'Gear box foundation fit bolt',
					  'PI'=>'Propeller shaft coupling with intermediate shaft coupling',
					  'IG'=>'Intermediate shaft coupling with gear box shaft coupling',
					  'PG'=>'Propeller shaft coupling with gear box shaft coupling',
					  'II'=>'Intermediate shaft coupling with Intermediate shaft coupling'
					 );
		$columns = $shipData->getColumnName("og_menu_child");
		
		//arranging the menu
		echo "<form role='form' class='form-horizontal'>";
		$childMenu = $shipData->getChildMenu("id", $code, $parent);
		foreach($childMenu as $menu)
		{
			$opt = explode("-", $menu['menu']);
		}
		
		$dropdown = in_array(13, $opt) || in_array(14, $opt);
		
		$fields = "";
		for($i=0; $i<count($opt); $i++)
		{
			$fields = $fields.$forms[$opt[$i]]; 
		}
		
		$script = "";
		$button = "Submit";
		
		if($dropdown)
		{
			if($dataId !== null && $act != "del")
			{
				$updateStat = true;
			}else
			{
				$updateStat = false;
			}				
			
		}else
		{
			$dat = $shipData->getData($parent, "project", $projId, $code);
			if($dat['row'] > 0)
			{
				$updateStat = true;
				$dataId = $dat['content'][0]['id'];
			}else
			{
				$updateStat = false;
			}
		}
		
		if($updateStat)
		{
			$button = "Update";
			$table = "og_data_$parent";
			$columns = $shipData->getColumnName($table);
			$colArr = array();
			foreach($columns as $column)
			{
				$colArr[] = $column['Field'];
			}
			
			$dataQuery = $shipData->getData($parent, "id", $dataId);
			$charStr = $dataQuery['content'][0]['characteristic'];
			$char = explode("+", $charStr);
			$dataArr = array();
			
			$l= 0;
			for($k=0; $k<count($char); $k++)
			{
				if($char[$k] != "-")
				{
					$dataArr[$l] = "'".$char[$k]."'";
					$l++;
				}
			}
			$commonStr = phpToJSArray($dataArr);
			
			$script = "	<script>
							var common = $commonStr;
							var commonInput = document.getElementsByName('input-field');
							for(i=0; i<commonInput.length; i++)
							{
								commonInput[i].value = common[i];
							}
						</script>";
		}
		
		echo $fields;
		echo "<input id='parent-field' type='hidden' value=$parent></input>
			  <input id='dataid-field' type='hidden' value=$dataId></input>
			  <input id='map-field' type='hidden' value=$menu[menu]></input>
			  <div class='form-group'>
				<label class='col-sm-2 control-label' for='form-field-1'>
				</label>
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			";
		echo $script;
		
		//arranging table view
		if($dropdown)
		{
			echo "  <hr>
					<div class='panel-table'>
						<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
							<thead>
								<tr>
									<th>Type</th>
									<th>Qty</th>
									<th>Dimension</th>
									<th>Certificate No.</th>
									<th>Update by</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
				";
			
			$trsData = $shipData->getData("trs", "project", $projId, $code);
			$rowStr = "";
			foreach($trsData['content'] as $dat)
			{
				$userArray = $rms->get_users_id($dat['updateby']);
				foreach($userArray as $arr)
				{
					$usrName = $arr['nama'];
				}
				
				$charStr = $dat['characteristic'];
				$char = explode("+", $charStr);
				$tmpArr = array();
				$l = 0;
				for($t=0; $t<=count($char); $t++)
				{
					if($char[$t] != "-")
					{
						$tmpArr[$l] = $char[$t];
						$l++;
					}
				}
				$typeName = $name[$tmpArr[3]];
				
				$rowStr = $rowStr." <tr>
										<td><a onclick='sendUpdate($id, $projId, $dat[id], $family);'>$typeName</a></td>
										<td>$tmpArr[1]</td>
										<td>$tmpArr[0]</td>
										<td>$tmpArr[2]</td>
										<td>$usrName</td>
										<td><a  onclick='deleteDat($dat[id], $projId, $id, $family)' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Cancel Event'><i class='fa fa-times fa fa-white'></i></a></td>
									</tr>";
			}
			echo $rowStr;
			echo "				
							</tbody>
						</table>
					</div>";
		}else
		{
			echo "<div class='panel-table'></div>";
		}
	}
	
	function menuPropShaft($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$dataQuery = $shipData->getData("prs", "alltype", $projId);
		
		if($dataQuery['row'] == 0)
		{
			$updateStr = "";
			$button = "Submit";
			$script=" <script>
						var stat = document.getElementsByName('statusRadios');
						stat[0].checked = true;
					  </script>";
		}else
		{
			$idArr = array("snb", "sfk", "psf");
			$userLog = $shipData->getLastUser($projId, "og_data_prs");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			$updateStr = "<p>Last update at $time by $name<p>";
			$button = "Update";
			
			$jsArray = array();
			$char = array();
			
			for($i=0; $i<=2; $i++)
			{
				$datQuery = $shipData->getData("prs", "project", $projId, $idArr[$i]);	
				foreach($datQuery['content'] as $dat)
				{
					$dataBox = explode("+", $dat['characteristic']);
					for($j=0; $j<count($dataBox); $j++)
					{
						$char[$j] = '"'.$dataBox[$j].'"';
					}
					$jsArrayMember = phpToJSArray($char);
				}
				$jsArray[$i] = $jsArrayMember;
			}
			
			$script = "
						<script>
							var data1 = $jsArray[0];
							var data2 = $jsArray[1];
							var data3 = $jsArray[2];
							
							var stat = data3.pop();
							
							var elem = document.getElementsByName('input-field1');
							for(i=0; i<elem.length; i++)
							{
								elem[i].value = data1[i];
							}
							
							elem = document.getElementsByName('input-field2');
							for(i=0; i<elem.length; i++)
							{
								elem[i].value = data2[i];
							}
							
							elem = document.getElementsByName('input-field3');
							for(i=0; i<elem.length; i++)
							{
								elem[i].value = data3[i];
							}
							
							elem = document.getElementsByName('statusRadios')
							for(i=0; i<elem.length; i++)
							{
								if(elem[i].value == stat)
								{
									elem[i].checked = true;
								}
							}
							
						</script>
			";
			
		}
		
		echo "
			$updateStr
			<h3>Stern Tube and Bearings</h3>
			<h4>Stern Tube</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field1' placeholder='Quantity of stern tube' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Lubricating system :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Lubricating system of stern tube' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Inside Diameter :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Stern tube inside diameter' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Length :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Stern tube length' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Sealing device :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Sealing device' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Bearing material :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Bearing material' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Bearing length :	
					</label>
					<div class='col-sm-4'>
						<input type='text'  name='input-field1' placeholder='Fwd' class='form-control'>
					</div>
					<div class='col-sm-4'>
						<input type='text'  name='input-field1' placeholder='Aft' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate number :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field1' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<h4>Shaft Bracket</h4>
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field2' placeholder='Quantity of shaft bracket' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Dimension :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Boss dimension' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Bearing Material :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Bearing material' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Length :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Bearing length' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Sealing Device :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field2' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<h3>Propeller Shaft</h3>
			<form role='form' class='form-horizontal' id='form3'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field3' placeholder='Quantity of propeller shaft' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Type of propeller shaft' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Material :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Material of propeller shaft' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Dimension :	
					</label>
					<div class='col-sm-4'>
						<input type='text'  name='input-field3' placeholder='Diameter' class='form-control'>
					</div>
					<div class='col-sm-4'>
						<input type='text'  name='input-field3' placeholder='Length' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Shaft Sleeve :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Shaft sleeve' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Thickness :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Sleeve thickness' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Pasak :	
					</label>
					<label class='radio-inline'>
						<input type='radio' value='1' name='statusRadios' class='grey'>
						With
					</label>
					<label class='radio-inline'>
						<input type='radio' value='0' name='statusRadios' class='grey'>
						Without
					</label>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Year :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field3' placeholder='Year of built' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Manufacturer' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field3' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<form role='form' class='form-horizontal'>
			<div class='form-group'>
				
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			
			<div id='panel-table' class='panel-table'></div>
			
			$script
		";
	}
	
	function menuProp($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$dataQuery = $shipData->getData("prp", "project", $projId, "prp");
		
		if($dataQuery['row'] == 0)
		{
			$updateStr = "";
			$button = "Submit";
			$script="";
		}else
		{
			$userLog = $shipData->getLastUser($projId, "og_data_prp");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			$updateStr = "<p>Last update at $time by $name<p>";
			$button = "Update";
			
			$jsArray = array();
			$char = array();
			
			$datQuery = $shipData->getData("prp", "project", $projId, "prp");	
			$columnName = $shipData->getColumnName("og_data_prp");
			$columns = array();
			foreach($columnName as $name)
			{
				$columns[] = $name['Field'];
			}
			
			foreach($datQuery['content'] as $dat)
			{
				for($i=1; $i<count($columns)-4; $i++)
				{
					$char[] = '"'.$dat[$columns[$i]].'"';
				}
			}
			$jsArray = phpToJSArray($char);
			
			$script = "
						<script>
							var data = $jsArray;
							var elem = document.getElementsByName('input-field');
							for(i=0; i<elem.length; i++)
							{
								elem[i].value = data[i];
							}
						</script>
			";
			
		}
		
		echo "
			$updateStr
			<form role='form' class='form-horizontal'>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Quantity :	
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Quantity of propeller' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Propeller type' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Blade Qty :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field' placeholder='Quantity of blade' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Rotation :	
					</label>
					<div class='col-sm-10'>
						<select name='input-field' class='form-control'>
							<option value='-'>--Propeller Rotation--</option>
							<option value='L'>Left-handed</option>
							<option value='R'>Right-handed</option>
						</select>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Weight :	
					</label>
					<div class='col-sm-10'>
						<input type='number'  name='input-field' placeholder='Weight in kg' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Material :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Propeller material' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Blade area :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Blade area ratio' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Dimension :	
					</label>
					<div class='col-sm-5'>
						<input type='text'  name='input-field' placeholder='Diameter of propeller' class='form-control'>
					</div>
					<div class='col-sm-5'>
						<input type='text'  name='input-field' placeholder='Propeller pitch' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Manufacturer' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Serial number :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Serial number' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Year :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Year of built' class='form-control'>
					</div>
				</div>
				<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate :	
					</label>
					<div class='col-sm-10'>
						<input type='text'  name='input-field' placeholder='Certificate number' class='form-control'>
					</div>
				</div>
			</form>
			
			<form role='form' class='form-horizontal'>
			<div class='form-group'>
				
				<div class='col-sm-10'>
					<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
						<i  id='tomboltask' class='fa fa-plus' ></i>
						$button
					</a>
				</div>
			</div>
			</form>
			
			<div id='panel-table' class='panel-table'></div>
			
			$script
		";
	}
	
	function menuAuxEngine($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$menuData = $shipData->getChecklist($projId, "aeg");
		$count = $menuData['row'];
		
		echo "
				<p id='user-log'></p>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Auxiliary Engine</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Auxiliary Engine Unit</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='axu' class='flat-grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Generator</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='grt' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Emergency Generating Set</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='egn' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Shaft Generator</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='sfo' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Cargo Pump Diesel Engine</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='cpd' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Cargo Pump Turbine</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='cpb' class='grey'>
									</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			";
		if($count == 0)
		{
			$button = "Submit";
		}else
		{
			foreach($menuData['content'] as $dat)
			{
				$chkStr = $dat['checklist'];
			}			
			$chkArr = explode("#", $chkStr);
			
			$checkbox = "[";
			
			for($l=0; $l<count($chkArr); $l++)
			{
				$checkbox = $checkbox."'".$chkArr[$l]."'".",";
			}
			$checkbox = substr_replace($checkbox, "]", -1);
			$button = "Update";
			
			$userLog = $shipData->getLastUser($projId, "og_menu_checklist", "aeg");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			
			$userStr = "'Last update at $time by $name'";
			
			echo "
				<script>
					var checkbox = $checkbox;
					var checkField = document.getElementsByName('chk-field');
					for(i=0; i<checkField.length; i++)
					{
						for(l=0; l<checkbox.length; l++)
						{
							if(checkField[i].value == checkbox[l])
							{
								checkField[i].checked = true;
							}
						}
					}
					var userLog = document.getElementById('user-log');
					userLog.innerHTML = $userStr;
				</script>
			";
		}			
			echo "	
				<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
					<i  id='tomboltask' class='fa fa-plus' ></i>
					$button
				</a>
			";
	}
	
	function menuTypeAuxEngine($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id)
	{
		$family = '"'.$group.'"';
		
		if($act == "del")
		{
			$shipData->deleteData($dataId, "aeg");
			$obj->WriteLogAplicationLogs($user_id,$projId,"Delete data $id",$user_id,"",0,0,"$dataId#aeg");
		}
		
		$forms = array(
				"",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Brand :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Brand' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Type' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<select name='input-field' class='form-control'>
							<option value='-'>--Type--</option>
							<option value='AC'>Alternating Current (AC)</option>
							<option value='DC'>Direct Current (DC)</option>
						</select>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Qty :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Quantity' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Power :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Power (in hp or kVA)' class='form-control'>
						<span class='help-block'>
							<i class='fa fa-info-circle'></i> 
							Input engine power or electrical power
						</span>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Revolution :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Revolution (in RPM)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Manufacturer :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Manufacturer' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Year :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Year of Built' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Certificate Number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Cylinder :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='additional-field' placeholder='Number of Cylinder' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Serial No :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='additional-field' placeholder='Serial Number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Voltage :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='additional-field' placeholder='Rated Voltage (in V)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Current :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='additional-field' placeholder='Rated Current (in Ampere)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Frequency :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='additional-field' placeholder='Frequency (in Hz)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Engine Power :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='additional-field' placeholder='Engine Power (in HP)' class='form-control'>
					</div>
				</div>"
				);
		
		//arranging the menu
		echo "";
		$childMenu = $shipData->getChildMenu("id", $code, $parent);
		
		foreach($childMenu as $menu)
		{
			$opt = explode("-", $menu['menu']);
		}
		$fields = "";
		for($i=0; $i<count($opt); $i++)
		{
			$fields = $fields.$forms[$opt[$i]]; 
		}
		
		$script = "";
		$button = "Submit";
		
		if($dataId !== null && $act != "del")
		{
			$button = "Update";
			$table = "og_data_aeg";
			$columns = $shipData->getColumnName($table);
			$colArr = array();
			foreach($columns as $column)
			{
				$colArr[] = $column['Field'];
			}
			
			$dataQuery = $shipData->getData("aeg","id", $dataId);
			foreach($dataQuery['content'] as $dat)
			{
				for($k=1; $k<=9; $k++)
				{
					$dataArr[] = $dat[$colArr[$k]];
				}
			}
			
			$temp = array_pop($dataArr);
			$additional = explode("+", $temp);
			
			$common = array();
			$add = array();
			for($i=0; $i<count($dataArr); $i++)
			{
				$common[$i] = "'".$dataArr[$i]."'";
			}
			for($i=0; $i<count($additional); $i++)
			{
				if($additional[$i] != "-")
				{
					$add[$i] = "'".$additional[$i]."'";
				}
			}
			
			$addStr = phpToJSArray($add);
			$commonStr = phpToJSArray($common);
			
			$script = "	<script>
							var common = $commonStr;
							var add = $addStr;
							var commonInput = document.getElementsByName('input-field');
							var addInput = document.getElementsByName('additional-field');
							
							for(i=0; i<commonInput.length; i++)
							{
								commonInput[i].value = common[i];
							}
							
							for(i=0; i<addInput.length; i++)
							{
								addInput[i].value = add[i];
							}
							
						</script>";
		}
		
		echo "	<form role='form' class='form-horizontal'>
					$fields
					<input id='parent-field' type='hidden' value=$parent></input>
					<input id='dataid-field' type='hidden' value=$dataId></input>
					<div class='form-group'>
						<label class='col-sm-2 control-label' for='form-field-1'>
						</label>
						<div class='col-sm-10'>
							<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
								<i  id='tomboltask' class='fa fa-plus' ></i>
								$button
							</a>
						</div>
					</div>
				</form>
				$script
			";
		
		//arranging table view
		$tableHead = "			
						<th>Brand</th>
						<th>Type</th>
						<th>Quantity</th>
						<th>Manufacturer</th>
						<th>Update by</th>
						<th>Action</th>
					 ";
		
		$datQuery = $shipData->getData("aeg", "project", $projId, $code);	
		$columnName = $shipData->getColumnName("og_data_aeg");
		$columns = array();
		$char = array();
		$rowStr = "";
		foreach($columnName as $name)
		{
			$columns[] = $name['Field'];
		}
		
		foreach($datQuery['content'] as $dat)
		{
			for($i=1; $i<=6; $i++)
			{
				$char[] = $dat[$columns[$i]];
			}
			
			$userArray = $rms->get_users_id($dat['updateby']);
			foreach($userArray as $arr)
			{
				$usrName = $arr['nama'];
			}
			
			$rowStr = $rowStr."<tr>
									<td>$char[0]</td>
									<td>$char[1]</td>
									<td>$char[2]</td>
									<td>$char[5]</td>
									<td>$usrName</td>
									<td>
										<a  onclick='sendUpdate($id, $projId, $dat[id], $family);' class='btn btn-xs btn-primary tooltips' data-placement='top' data-original-title='Edit Data'><i class='fa fa-pencil fa fa-white'></i></a>
										<a  onclick='deleteDat($dat[id], $projId, $id, $family);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Delete Data'><i class='fa fa-times fa fa-white'></i></a>
									</td>
							   </tr>
								";
			$char = array();
		}
		
		echo "  <hr>
				<div class='panel-table'>
					<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
						<thead>
							<tr>
								$tableHead
							</tr>
						</thead>
						<tbody>
							$rowStr
						</tbody>
					</table>
				</div>
			";
	}
	
	function menuElectrical($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$menuData = $shipData->getChecklist($projId, "eln");
		$count = $menuData['row'];
		
		echo "
				<p id='user-log'></p>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Electrical Installation</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Main Switchboard</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='msb' class='flat-grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Emergency Switchboard</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='esb' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Electrical Cables</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='ecb' class='grey'>
									</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			";
		if($count == 0)
		{
			$button = "Submit";
		}else
		{
			foreach($menuData['content'] as $dat)
			{
				$chkStr = $dat['checklist'];
			}			
			$chkArr = explode("#", $chkStr);
			
			$checkbox = "[";
			
			for($l=0; $l<count($chkArr); $l++)
			{
				$checkbox = $checkbox."'".$chkArr[$l]."'".",";
			}
			$checkbox = substr_replace($checkbox, "]", -1);
			$button = "Update";
			
			$userLog = $shipData->getLastUser($projId, "og_menu_checklist", "eln");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			
			$userStr = "'Last update at $time by $name'";
			
			echo "
				<script>
					var checkbox = $checkbox;
					var checkField = document.getElementsByName('chk-field');
					for(i=0; i<checkField.length; i++)
					{
						for(l=0; l<checkbox.length; l++)
						{
							if(checkField[i].value == checkbox[l])
							{
								checkField[i].checked = true;
							}
						}
					}
					var userLog = document.getElementById('user-log');
					userLog.innerHTML = $userStr;
				</script>
			";
		}			
			echo "	
				<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
					<i  id='tomboltask' class='fa fa-plus' ></i>
					$button
				</a>
			";
	}
	
	function menuTypeElectrical($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id)
	{
		$family = '"'.$group.'"';
		
		if($act == "del")
		{
			$shipData->deleteData($dataId, "eln");
			$obj->WriteLogAplicationLogs($user_id,$projId,"Delete data $id",$user_id,"",0,0,"$dataId#eln");
		}
		
		$forms = array(
				"",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Brand :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Brand' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<select name='input-field' class='form-control'>
							<option value='-'>--Type--</option>
							<option value='SYC'>Synchronizing</option>
							<option value='IND'>Independent</option>
						</select>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Capacity :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Capacity in or kVA' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Voltage :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Rated Voltage (in V)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Current :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Rated Current (in Ampere)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Frequency :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Frequency (in Hz)' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Year :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Year of Built' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Certificate Number' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Diameter :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Diameter (in mm)' class='form-control'>
					</div>
				</div>"
				);
		
		//arranging the menu
		$childMenu = $shipData->getChildMenu("id", $code, $parent);
		
		foreach($childMenu as $menu)
		{
			$opt = explode("-", $menu['menu']);
			$map = $menu['menu'];
		}
		$fields = "";
		for($i=0; $i<count($opt); $i++)
		{
			$fields = $fields.$forms[$opt[$i]]; 
		}
		
		$script = "";
		$button = "Submit";
		
		$tab = in_array(9, $opt);
		if($tab)
		{
			if($dataId !== null && $act != "del")
			{
				$updateStat = true;
			}else
			{
				$updateStat = false;
			}				
			
		}else
		{
			$dat = $shipData->getData($parent, "project", $projId, $code);
			if($dat['row'] > 0)
			{
				$updateStat = true;
				$dataId = $dat['content'][0]['id'];
			}else
			{
				$updateStat = false;
			}
		}
		
		if($updateStat)
		{
			$button = "Update";
			$table = "og_data_eln";
			$columns = $shipData->getColumnName($table);
			$colArr = array();
			foreach($columns as $column)
			{
				$colArr[] = $column['Field'];
			}
			
			$dataQuery = $shipData->getData("eln","id", $dataId);
			$dataArr = array();
			foreach($dataQuery['content'] as $dat)
			{
				for($k=1; $k<count($colArr); $k++)
				{
					if($dat[$colArr[$k]] != "-")
					{
						$dataArr[] = '"'.$dat[$colArr[$k]].'"';
					}
				}
			}
			
			$jsArray = phpToJSArray($dataArr);
			
			$script = "	<script>
							var input = $jsArray;
							var commonInput = document.getElementsByName('input-field');
							
							for(i=0; i<commonInput.length; i++)
							{
								commonInput[i].value = input[i];
							}
						</script>";
		}
		
		echo "	<form role='form' class='form-horizontal'>
					$fields
					<input id='parent-field' type='hidden' value=$parent></input>
					<input id='dataid-field' type='hidden' value=$dataId></input>
					<input id='map-field' type='hidden' value=$map></input>
					<div class='form-group'>
						<label class='col-sm-2 control-label' for='form-field-1'>
						</label>
						<div class='col-sm-10'>
							<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
								<i  id='tomboltask' class='fa fa-plus' ></i>
								$button
							</a>
						</div>
					</div>
				</form>
				$script
			";
		
		if($tab)
		{
			//arranging table view
			$tableHead = "			
							<th>Brand</th>
							<th>Certificate</th>
							<th>Diameter</th>
							<th>Update By</th>
							<th>Action</th>
						 ";
			
			$datQuery = $shipData->getData("eln", "project", $projId, $code);	
			$columnName = $shipData->getColumnName("og_data_eln");
			$columns = array();
			$char = array();
			$rowStr = "";
			foreach($columnName as $name)
			{
				$columns[] = $name['Field'];
			}
			
			foreach($datQuery['content'] as $dat)
			{
				for($i=0; $i<count($opt); $i++)
				{
					$char[] = $dat[$columns[$opt[$i]]];
				}
				
				$userArray = $rms->get_users_id($dat['updateby']);
				foreach($userArray as $arr)
				{
					$usrName = $arr['nama'];
				}
				
				$rowStr = $rowStr."<tr>
										<td>$char[0]</td>
										<td>$char[1]</td>
										<td>$char[2]</td>
										<td>$usrName</td>
										<td>
											<a  onclick='sendUpdate($id, $projId, $dat[id], $family);' class='btn btn-xs btn-primary tooltips' data-placement='top' data-original-title='Edit Data'><i class='fa fa-pencil fa fa-white'></i></a>
											<a  onclick='deleteDat($dat[id], $projId, $id, $family);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Delete Data'><i class='fa fa-times fa fa-white'></i></a>
										</td>
								   </tr>
									";
				$char = array();
			}
			
			echo "  <hr>
					<div class='panel-table'>
						<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
							<thead>
								<tr>
									$tableHead
								</tr>
							</thead>
							<tbody>
								$rowStr
							</tbody>
						</table>
					</div>
				";
		}else
		{
			echo "<div class='panel-table'></div>";
		}
	}
	
	function menuFirefight($id, $projId, $shipData, $rms, $group)
	{
		$family = '"'.$group.'"';
		$menuData = $shipData->getChecklist($projId, "frf");
		$count = $menuData['row'];
		
		echo "
				<p id='user-log'></p>
				<table class='table table-hover'>
					<thead>
						<tr>
							<th>Fire Fighting Extinguisher</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Fixed Fire Extinguisher</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='xfx' class='flat-grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Portable Fire Extinguisher</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='pfx' class='grey'>
									</label>
								</div>
							</td>
						</tr>
						<tr>
							<td>Fire Hoses and Nozzles</td>
							<td>
								<div class='checkbox-table'>
									<label>
										<input type='checkbox' name='chk-field' value='fsz' class='grey'>
									</label>
								</div>
							</td>
						</tr>
					</tbody>
				</table>
			";
		if($count == 0)
		{
			$button = "Submit";
		}else
		{
			foreach($menuData['content'] as $dat)
			{
				$chkStr = $dat['checklist'];
			}			
			$chkArr = explode("#", $chkStr);
			
			$checkbox = "[";
			
			for($l=0; $l<count($chkArr); $l++)
			{
				$checkbox = $checkbox."'".$chkArr[$l]."'".",";
			}
			$checkbox = substr_replace($checkbox, "]", -1);
			$button = "Update";
			
			$userLog = $shipData->getLastUser($projId, "og_menu_checklist", "frf");
			$userArray = $rms->get_users_id($userLog['updateby']);
			foreach($userArray as $arr)
			{
				$name = $arr['nama'];
			}
			$time = date("d/m/Y H:i:s", strtotime($userLog['updateon']));
			
			$userStr = "'Last update at $time by $name'";
			
			echo "
				<script>
					var checkbox = $checkbox;
					var checkField = document.getElementsByName('chk-field');
					for(i=0; i<checkField.length; i++)
					{
						for(l=0; l<checkbox.length; l++)
						{
							if(checkField[i].value == checkbox[l])
							{
								checkField[i].checked = true;
							}
						}
					}
					var userLog = document.getElementById('user-log');
					userLog.innerHTML = $userStr;
				</script>
			";
		}			
			echo "	
				<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
					<i  id='tomboltask' class='fa fa-plus' ></i>
					$button
				</a>
			";
	}
	
	function menuTypeFirefight($id, $projId, $dataId, $act, $shipData, $code, $parent, $rms, $group, $obj, $user_id)
	{
		$family = '"'.$group.'"';
		
		if($act == "del")
		{
			$shipData->deleteData($dataId, "frf");
			$obj->WriteLogAplicationLogs($user_id,$projId,"Delete data $id",$user_id,"",0,0,"$dataId#frf");
		}
		
		$forms = array(
				"",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<select name='input-field' class='form-control'>
							<option value='-'>--Type--</option>
							<option value='CO2'>CO2 Extinguisher</option>
							<option value='HAL'>Halon Extinguisher</option>
							<option value='FOA'>Foam Extinguisher</option>
							<option value='DCF'>Deck Foam Extinguisher</option>
							<option value='DCP'>Dry-Chemical Powder Extinguisher</option>
							<option value='HEF'>High Expansion Foam Extinguisher</option>
							<option value='PWS'>Pressure Water Spraying Extinguisher</option>
						</select>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<select name='input-field' class='form-control'>
							<option value='-'>--Type--</option>
							<option value='CO2'>CO2 Extinguisher</option>
							<option value='HAL'>Halon Extinguisher</option>
							<option value='FOA'>Foam Extinguisher</option>
							<option value='DCP'>Dry-Chemical Powder Extinguisher</option>
						</select>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Type :
					</label>
					<div class='col-sm-10'>
						<select name='input-field' class='form-control'>
							<option value='-'>--Type--</option>
							<option value='FHN'>Fire Hose and Nozzle</option>
						</select>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Volume :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Volume of bottle/tank (in m3)' class='form-control'>
					</div>
				</div>",
				"<input type='hidden' name='input-field' value='-' class='form-control'>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Qty :
					</label>
					<div class='col-sm-10'>
						<input type='number' name='input-field' placeholder='Quantity' class='form-control'>
					</div>
				</div>",
				"<div class='form-group'>
					<label class='col-sm-2 control-label' for='form-field-1'>
						Certificate No :
					</label>
					<div class='col-sm-10'>
						<input type='text' name='input-field' placeholder='Certificate Number' class='form-control'>
					</div>
				</div>"
				);
		
		//arranging the menu
		$childMenu = $shipData->getChildMenu("id", $code, $parent);
		
		foreach($childMenu as $menu)
		{
			$opt = explode("-", $menu['menu']);
			$map = $menu['menu'];
		}
		$fields = "";
		for($i=0; $i<count($opt); $i++)
		{
			$fields = $fields.$forms[$opt[$i]]; 
		}
		
		$script = "";
		$button = "Submit";
		
		if($dataId !== null && $act != "del")
		{
			$button = "Update";
			$table = "og_data_frf";
			$columns = $shipData->getColumnName($table);
			$colArr = array();
			foreach($columns as $column)
			{
				$colArr[] = $column['Field'];
			}
			
			$dataQuery = $shipData->getData("frf","id", $dataId);
			$dataArr = array();
			foreach($dataQuery['content'] as $dat)
			{
				for($k=1; $k<count($colArr); $k++)
				{
					$dataArr[] = '"'.$dat[$colArr[$k]].'"';
				}
			}
			
			$jsArray = phpToJSArray($dataArr);
			
			$script = "	<script>
							var input = $jsArray;
							var commonInput = document.getElementsByName('input-field');
							
							for(i=0; i<commonInput.length; i++)
							{
								commonInput[i].value = input[i];
							}
						</script>";
		}
		
		echo "	<form role='form' class='form-horizontal'>
					$fields
					<input id='parent-field' type='hidden' value=$parent></input>
					<input id='dataid-field' type='hidden' value=$dataId></input>
					<div class='form-group'>
						<label class='col-sm-2 control-label' for='form-field-1'>
						</label>
						<div class='col-sm-10'>
							<a class='btn btn-blue' onClick='sendMenu($id, $family);' >
								<i  id='tomboltask' class='fa fa-plus' ></i>
								$button
							</a>
						</div>
					</div>
				</form>
				$script
			";
		
		//arranging table view
		$head = array("","Type", "Type", "Type", "Vol", "-", "Qty", "Certificate");
		$tableHead = "";
		for($i=0; $i<count($opt); $i++)
		{
			if($head[$opt[$i]] != "-")
			{
				$tableHead = $tableHead."<th>".$head[$opt[$i]]."</th>";
			}				
		}
		
		$tableHead = $tableHead."<th>Update By</th>
								 <th>Action</th>";
		
		$datQuery = $shipData->getData("frf", "project", $projId, $code);	
		$columnName = $shipData->getColumnName("og_data_frf");
		$columns = array();
		$char = array();
		$rowStr = "";
		foreach($columnName as $name)
		{
			$columns[] = $name['Field'];
		}
		
		$typeFire = array(	'CO2'=>'CO2 Extinguisher',
							'HAL'=>'Halon Extinguisher',
							'FOA'=>'Foam Extinguisher',
							'DCF'=>'Deck Foam Extinguisher',
							'DCP'=>'Dry-Chemical Powder Extinguisher',
							'HEF'=>'High Expansion Foam Extinguisher',
							'PWS'=>'Pressure Water Spraying Extinguisher',
							'FHN'=>'Fire Hose and Nozzle');
		foreach($datQuery['content'] as $dat)
		{
			$rowStr = $rowStr."<tr>";
			for($i=1; $i<count($columns)-4; $i++)
			{
				$content = $dat[$columns[$i]];
				if($columns[$i]=='type_frf')
				{
					$content = $typeFire[$content];
				}
				if($content != "-")
				{
					$rowStr = $rowStr."<td>".$content."</td>";
				}
			}
			
			$userArray = $rms->get_users_id($dat['updateby']);
			foreach($userArray as $arr)
			{
				$usrName = $arr['nama'];
			}
			
			$rowStr = $rowStr."
									<td>$usrName</td>
									<td>
										<a  onclick='sendUpdate($id, $projId, $dat[id], $family);' class='btn btn-xs btn-primary tooltips' data-placement='top' data-original-title='Edit Data'><i class='fa fa-pencil fa fa-white'></i></a>
										<a  onclick='deleteDat($dat[id], $projId, $id, $family);' class='btn btn-xs btn-bricky tooltips' data-placement='top' data-original-title='Delete Data'><i class='fa fa-times fa fa-white'></i></a>
									</td>
							   </tr>
								";
		}
		
		echo "  <hr>
				<div class='panel-table'>
					<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
						<thead>
							<tr>
								$tableHead
							</tr>
						</thead>
						<tbody>
							$rowStr
						</tbody>
					</table>
				</div>
			";
		
	}
	
	function generalInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$id = $pieces[0];
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$genDataStr = $pieces[4];
		$hullDataStr = $pieces[5];
		
		//preparing general data
		$genData = explode("#", $genDataStr);
		$place = $genData[0];
		$dateSurvey = explode("-", $genData[1]);
		$start = date("Y-m-d H:i:s", strtotime($dateSurvey[0]));
		$end = date("Y-m-d H:i:s", strtotime($dateSurvey[1]));
		$name = $genData[2];
		$prevName = $genData[3];
		$type = $genData[4];
		$flag = $genData[5];
		$callSign = $genData[6];
		$port = $genData[7];
		$dateContract = date("Y-m-d", strtotime($genData[8]));
		$builder = $genData[9];
		$dateKeel = date("Y-m-d", strtotime($genData[10]));
		$hullNumber = $genData[11];
		$dateLaunch = date("Y-m-d", strtotime($genData[12]));
		$dateComplete = date("Y-m-d", strtotime($genData[13]));
		$classPrev = $genData[14];
		$charPrev = $genData[15];
		$classOther = $genData[16];
		$charOther = $genData[17];
		$material = $genData[18];
		$stat = $genData[19];
		
		$genArray = $shipData->getGeneralData($projId);
		if($genArray['row'] == 0)
		{
			$shipData->insertGeneralData($projId, $uId, $place, $start, $end, $name, $prevName, $type, $flag, $callSign, $port, $dateContract, $builder, $dateKeel, $hullNumber, $dateLaunch, $dateComplete, $classPrev, $charPrev, $classOther, $charOther, $material, $stat);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$genDataStr);
		}else
		{
			$shipData->updateGeneralData($projId, $uId, $place, $start, $end, $name, $prevName, $type, $flag, $callSign, $port, $dateContract, $builder, $dateKeel, $hullNumber, $dateLaunch, $dateComplete, $classPrev, $charPrev, $classOther, $charOther, $material, $stat);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$genDataStr);
		}
		
		//preparing hull data
		$hullData = explode("#", $hullDataStr);
		$loa = $hullData[0];
		$lpp = $hullData[1];
		$lf = $hullData[2];
		$bmld = $hullData[3];
		$hmld = $hullData[4];
		$draft = $hullData[5];
		$freeboard = $hullData[6];
		$gt = $hullData[7];
		$nett = $hullData[8];
		$dwt = $hullData[9];
		$displacement = $hullData[10];
		
		$partArray = $shipData->getHullData($projId);
		if($partArray['row'] == 0)
		{
			$shipData->insertHullData($projId, $loa, $lpp, $lf, $bmld, $hmld, $draft, $freeboard, $gt, $nett, $dwt, $displacement, $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$hullDataStr);
		}else
		{
			$shipData->updateHullData($projId, $loa, $lpp, $lf, $bmld, $hmld, $draft, $freeboard, $gt, $nett, $dwt, $displacement, $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$hullDataStr);
		}
		
		//preparing menu structure
		$childArray = json_decode($childData,true);
		$childData = json_encode($childArray);
		
		return $childData;
	}
	
	function capacityInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$capDataStr = $pieces[4];
		
		$capArray = $shipData->getCapacity($projId);
		
		$capData = explode("@", $capDataStr);
		for($i=0; $i<count($capData); $i++)
		{
			$caps = explode("#", $capData[$i]);
			$id = $caps[0];
			$type = $caps[1];
			$capacity = $caps[2];
			
			if($capArray["row"] == 0)
			{
				$shipData->insertCapacity($projId, $type, $capacity, $uId);
				$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$capData[$i]);
			}else
			{
				$shipData->updateCapacity($id, $type, $capacity, $uId);
				$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$capData[$i]);
			}
		}
		
		//preparing menu structure
		$childArray = json_decode($childData,true);
		$childData = json_encode($childArray);
		
		return $childData;
	}
	
	function tankInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$dataStr = $pieces[4];

		$tankArr = explode("#", $dataStr);
		
		$checklists = $shipData->getChecklist($projId, "tnk");
		if($checklists['row'] == 0)
		{
			$shipData->insertChecklist($projId, $dataStr, "tnk", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert checklist $id",$user_id,"",0,0,$dataStr);
		}else
		{
			$shipData->updateChecklist($projId, $dataStr, "tnk", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update checklist $id",$user_id,"",0,0,$dataStr);
		}
		
		//preparing menu structure
		if($tankArr[0] != "---")
		{
			$children = array();
			for($k=0; $k<count($tankArr); $k++)
			{
				$menuChild = $shipData->getChildMenu('id', $tankArr[$k], "tnk");
				foreach($menuChild as $dat)
				{
					$node = array("title"=>$dat['title'], "key"=>$dat['key_id'], "isFolder"=>false, "family"=>$dat['family'], "tooltip"=>$dat['title']);
				}
				
				array_push($children, $node);
			}
			$childArray = json_decode($childData,true);
			$index = array_search('tnk', array_column($childArray, 'key'));
			$childArray[$index]['children'] = $children;
			$childData = json_encode($childArray);
		}else
		{
			$childArray = json_decode($childData,true);
			$index = array_search('tnk', array_column($childArray, 'key'));
			if(array_key_exists("children", $childArray[$index]))
			{
				unset($childArray[$index]['children']); 
			}
			$childData = json_encode($childArray);
		}
	
		return $childData;
	}
	
	function bulkInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$dataStr = $pieces[4];
		
		$bulkArr = explode("#", $dataStr);
		
		$checklists = $shipData->getChecklist($projId, "blh");
		if($checklists['row'] == 0)
		{
			$shipData->insertChecklist($projId, $dataStr, "blh", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert checklist $id",$user_id,"",0,0,$dataStr);
		}else
		{
			$shipData->updateChecklist($projId, $dataStr, "blh", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update checklist $id",$user_id,"",0,0,$dataStr);
		}
		
		//preparing menu structure
		if($bulkArr[0] != "---")
		{
			$children = array();
			for($k=0; $k<count($bulkArr); $k++)
			{
				$menuChild = $shipData->getChildMenu('id', $bulkArr[$k], "blh");
				foreach($menuChild as $dat)
				{
					$node = array("title"=>$dat['title'], "key"=>$dat['key_id'], "isFolder"=>false, "family"=>$dat['family'], "tooltip"=>$dat['title']);
				}
				
				array_push($children, $node);
			}
			$childArray = json_decode($childData,true);
			$index = array_search('blh', array_column($childArray, 'key'));
			$childArray[$index]['children'] = $children;
			$childData = json_encode($childArray);
		}else
		{
			$childArray = json_decode($childData,true);
			$index = array_search('blh', array_column($childArray, 'key'));
			if(array_key_exists("children", $childArray[$index]))
			{
				unset($childArray[$index]['children']); 
			}
			$childData = json_encode($childArray);
		}
		
		return $childData;
	}
	
	function deckInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$dataStr = $pieces[4];
		
		$deckArr = explode("#", $dataStr);
		
		$checklists = $shipData->getChecklist($projId, "dck");
		if($checklists['row'] == 0)
		{
			$shipData->insertChecklist($projId, $dataStr, "dck", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert checklist $id",$user_id,"",0,0,$dataStr);
		}else
		{
			$shipData->updateChecklist($projId, $dataStr, "dck", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update checklist $id",$user_id,"",0,0,$dataStr);
		}
		
		//preparing menu structure
		if($deckArr[0] != "---")
		{
			$children = array();
			for($k=0; $k<count($deckArr); $k++)
			{
				$menuChild = $shipData->getChildMenu('id', $deckArr[$k], "dck");
				foreach($menuChild as $dat)
				{
					$node = array("title"=>$dat['title'], "key"=>$dat['key_id'], "isFolder"=>false, "family"=>$dat['family'], "tooltip"=>$dat['title']);
				}
				
				array_push($children, $node);
			}
			$childArray = json_decode($childData,true);
			$index = array_search('dck', array_column($childArray, 'key'));
			$childArray[$index]['children'] = $children;
			$childData = json_encode($childArray);
		}else
		{
			$childArray = json_decode($childData,true);
			$index = array_search('dck', array_column($childArray, 'key'));
			if(array_key_exists("children", $childArray[$index]))
			{
				unset($childArray[$index]['children']); 
			}
			$childData = json_encode($childArray);
		}
		
		return $childData;
	}
	
	function machineryInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$dataStr = $pieces[4];
		$parent = $pieces[5];
		
		$dataArr = explode("#", $dataStr);
		
		$checklists = $shipData->getChecklist($projId, $parent);
		if($checklists['row'] == 0)
		{
			$shipData->insertChecklist($projId, $dataStr, $parent, $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert checklist $id",$user_id,"",0,0,$dataStr);
		}else
		{
			$shipData->updateChecklist($projId, $dataStr, $parent, $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update checklist $id",$user_id,"",0,0,$dataStr);
		}
		
		//preparing menu structure
		if($dataArr[0] != "---")
		{
			$children = array();
			for($k=0; $k<count($dataArr); $k++)
			{
				$menuChild = $shipData->getChildMenu('id', $dataArr[$k], $parent);
				foreach($menuChild as $dat)
				{
					$node = array("title"=>$dat['title'], "key"=>$dat['key_id'], "isFolder"=>false, "family"=>$dat['family'], "tooltip"=>$dat['title']);
				}
				
				array_push($children, $node);
			}
			$childArray = json_decode($childData,true);
			$index = array_search($parent, array_column($childArray, 'key'));
			$childArray[$index]['children'] = $children;
			$childData = json_encode($childArray);
		}else
		{
			$childArray = json_decode($childData,true);
			$index = array_search($parent, array_column($childArray, 'key'));
			if(array_key_exists("children", $childArray[$index]))
			{
				unset($childArray[$index]['children']); 
			}
			$childData = json_encode($childArray);
		}
		
		return $childData;
	}
	
	function transmissionInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$dataStr = $pieces[4];
		
		$deckArr = explode("#", $dataStr);
		
		$checklists = $shipData->getChecklist($projId, "trs");
		if($checklists['row'] == 0)
		{
			$shipData->insertChecklist($projId, $dataStr, "trs", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert checklist $id",$user_id,"",0,0,$dataStr);
		}else
		{
			$shipData->updateChecklist($projId, $dataStr, "trs", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update checklist $id",$user_id,"",0,0,$dataStr);
		}
		
		//preparing menu structure
		if($deckArr[0] != "---")
		{
			$children = array();
			for($k=0; $k<count($deckArr); $k++)
			{
				$menuChild = $shipData->getChildMenu('id', $deckArr[$k], "trs");
				foreach($menuChild as $dat)
				{
					$node = array("title"=>$dat['title'], "key"=>$dat['key_id'], "isFolder"=>false, "family"=>$dat['family'], "tooltip"=>$dat['title']);
				}
				
				array_push($children, $node);
			}
			$childArray = json_decode($childData,true);
			$index = array_search('trs', array_column($childArray, 'key'));
			$childArray[$index]['children'] = $children;
			$childData = json_encode($childArray);
		}else
		{
			$childArray = json_decode($childData,true);
			$index = array_search('trs', array_column($childArray, 'key'));
			if(array_key_exists("children", $childArray[$index]))
			{
				unset($childArray[$index]['children']); 
			}
			$childData = json_encode($childArray);
		}
		
		return $childData;
	}
	
	function auxEngineInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$menuStr = $pieces[4];
		
		$menuArr = explode("#", $menuStr);
		
		$checklists = $shipData->getChecklist($projId, "aeg");
		if($checklists['row'] == 0)
		{
			$shipData->insertChecklist($projId, $menuStr, "aeg", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert checklist $id",$user_id,"",0,0,$menuStr);
		}else
		{
			$shipData->updateChecklist($projId, $menuStr, "aeg", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update checklist $id",$user_id,"",0,0,$menuStr);
		}
		
		//preparing menu structure
		if($menuArr[0] != "---")
		{
			$children = array();
			for($k=0; $k<count($menuArr); $k++)
			{
				$menuChild = $shipData->getChildMenu('id', $menuArr[$k], "aeg");
				foreach($menuChild as $dat)
				{
					$node = array("title"=>$dat['title'], "key"=>$dat['key_id'], "isFolder"=>false, "family"=>$dat['family'], "tooltip"=>$dat['title']);
				}
				
				array_push($children, $node);
			}
			$childArray = json_decode($childData,true);
			$index = array_search('aeg', array_column($childArray, 'key'));
			$childArray[$index]['children'] = $children;
			$childData = json_encode($childArray);
		}else
		{
			$childArray = json_decode($childData,true);
			$index = array_search('aeg', array_column($childArray, 'key'));
			if(array_key_exists("children", $childArray[$index]))
			{
				unset($childArray[$index]['children']); 
			}
			$childData = json_encode($childArray);
		}
		
		return $childData;
	}
	
	function equipmentInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$id = $pieces[0];
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$equipDataStr = $pieces[4];
		
		$equipQuery = $shipData->getEquipment($projId);
		
		$equipArray = explode("@", $equipDataStr);
		for($i=0; $i<count($equipArray); $i++)
		{
			$equipData = explode("#", $equipArray[$i]);
			if($equipQuery['row'] == 0)
			{
				array_push($equipData, $i+1, $projId, $uId);
				$shipData->insertEquipment($equipData); 
				$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$equipArray[$i]);
			}else
			{
				array_push($equipData, $uId);
				$shipData->updateEquipment($equipData, $projId, $i+1);
				$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$equipAray[$i]);
			}
		}			
		//preparing menu structure
		$childArray = json_decode($childData,true);
		$childData = json_encode($childArray);
		
		return $childData;
	}
	
	function rudderInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$id = $pieces[0];
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$rudderDataStr = $pieces[4];
		
		$rudderQuery = $shipData->getRudder($projId);
		
		$rudderArray = explode("@", $rudderDataStr);
		for($i=0; $i<count($rudderArray); $i++)
		{
			$rudderData = explode("#", $rudderArray[$i]);
			if($rudderQuery['row'] == 0)
			{
				array_push($rudderData, $i+1, $projId, $uId);
				$shipData->insertRudder($rudderData); 
				$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$rudderArray[$i]);
			}else
			{
				array_push($rudderData, $uId);
				$shipData->updateRudder($rudderData, $projId, $i+1);
				$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$rudderArray[$i]);
			}
		}			
		//preparing menu structure
		$childArray = json_decode($childData,true);
		$childData = json_encode($childArray);
		
		return $childData;
	}
	
	function cargoInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$id = $pieces[0];
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$cargoDataStr = $pieces[4];
		
		$cargoQuery = $shipData->getCargo($projId);
		
		$cargoArray = explode("@", $cargoDataStr);
		for($i=0; $i<count($cargoArray); $i++)
		{
			$cargoData = explode("#", $cargoArray[$i]);
			if($cargoQuery['row'] == 0)
			{
				array_push($cargoData, $i+1, $projId, $uId);
				$shipData->insertCargo($cargoData); 
				$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$cargoArray[$i]);
			}else
			{
				array_push($cargoData, $uId);
				$shipData->updateCargo($cargoData, $projId, $i+1);
				$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$cargoArray[$i]);
			}
		}			
		//preparing menu structure
		$childArray = json_decode($childData,true);
		$childData = json_encode($childArray);
		
		return $childData;
	}
	
	function mainEngineInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$engineDataStr = $pieces[4];
		
		$engineQuery = $shipData->getMainEngine($projId);
		
		$engineArray = explode("#", $engineDataStr);
		
		if($engineQuery['row'] == 0)
		{
			array_push($engineArray, $projId, $uId);
			$shipData->insertMainEngine($engineArray); 
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,$engineDataStr);
		}else
		{
			array_push($engineArray, $uId);
			$shipData->updateMainEngine($engineArray, $projId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,$engineDataStr);
		}
					
		//preparing menu structure
		$childArray = json_decode($childData,true);
		$childData = json_encode($childArray);
		
		return $childData;
	}
	
	function propShaftInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$id = $pieces[0];
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$dataAll = array($pieces[4], $pieces[5], $pieces[6]);
		$idArr = array("snb", "sfk", "psf");
		
		$datArray = $shipData->getData("prs", "alltype", $projId);
		
		if($datArray['row'] == 0)
		{
			for($i = 0; $i<=2; $i++)
			{
				$temp = explode("#", $dataAll[$i]);
				$qty = $temp[0];
				$char = implode("+", $temp);
				$time = date("Y-m-d H:i:s");
				$arrData = array($qty, $char, $idArr[$i], "prs", $projId, $uId, $time);
				$shipData->insertData("prs", $arrData);
				$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,implode("#", $arrayData));
			}
		}else
		{
			for($i = 0; $i<=2; $i++)
			{
				$temp = explode("#", $dataAll[$i]);
				$qty = $temp[0];
				$char = implode("+", $temp);
				$time = date("Y-m-d H:i:s");
				$arrData = array($qty, $char, $idArr[$i], "prs", $projId, $uId, $time);
				$id = $shipData->getIdByTypeProject("prs", $idArr[$i], $projId);
				$shipData->updateData("prs", $arrData, $id);
				$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,implode("#", $arrayData));
			}
		}
		//preparing menu structure
		$childArray = json_decode($childData,true);
		$childData = json_encode($childArray);
		
		return $childData;
	}
	
	function propInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$id = $pieces[0];
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$dataStr = $pieces[4];
		
		$datArray = $shipData->getData("prp", "project", $projId, "prp");
		
		if($datArray['row'] == 0)
		{
			$arrData = explode("#", $dataStr);
			$time = date("Y-m-d H:i:s");
			array_push($arrData, "prp", $projId, $uId, $time);
			$shipData->insertData("prp", $arrData);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert data $id",$user_id,"",0,0,implode("#", $arrData));
		}else
		{
			$arrData = explode("#", $dataStr);
			$time = date("Y-m-d H:i:s");
			array_push($arrData, "prp", $projId, $uId, $time);
			$id = $shipData->getIdByTypeProject("prp", "prp", $projId);
			$shipData->updateData("prp", $arrData, $id);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update data $id",$user_id,"",0,0,implode("#", $arrData));
		}
		//preparing menu structure
		$childArray = json_decode($childData,true);
		$childData = json_encode($childArray);
		
		return $childData;
	}
	
	function electricalInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$dataStr = $pieces[4];
		
		$deckArr = explode("#", $dataStr);
		
		$checklists = $shipData->getChecklist($projId, "eln");
		if($checklists['row'] == 0)
		{
			$shipData->insertChecklist($projId, $dataStr, "eln", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert checklist $id",$user_id,"",0,0,$dataStr);
		}else
		{
			$shipData->updateChecklist($projId, $dataStr, "eln", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update checklist $id",$user_id,"",0,0,$dataStr);
		}
		
		//preparing menu structure
		if($deckArr[0] != "---")
		{
			$children = array();
			for($k=0; $k<count($deckArr); $k++)
			{
				$menuChild = $shipData->getChildMenu('id', $deckArr[$k], "eln");
				foreach($menuChild as $dat)
				{
					$node = array("title"=>$dat['title'], "key"=>$dat['key_id'], "isFolder"=>false, "family"=>$dat['family'], "tooltip"=>$dat['title']);
				}
				
				array_push($children, $node);
			}
			$childArray = json_decode($childData,true);
			$index = array_search('eln', array_column($childArray, 'key'));
			$childArray[$index]['children'] = $children;
			$childData = json_encode($childArray);
		}else
		{
			$childArray = json_decode($childData,true);
			$index = array_search('eln', array_column($childArray, 'key'));
			if(array_key_exists("children", $childArray[$index]))
			{
				unset($childArray[$index]['children']); 
			}
			$childData = json_encode($childArray);
		}
		
		return $childData;
	}
	
	function firefightInput($stringCommand, $shipData, $obj, $user_id)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		$uId = $pieces[2];
		$projId = $pieces[3];
		$dataStr = $pieces[4];
		
		$deckArr = explode("#", $dataStr);
		
		$checklists = $shipData->getChecklist($projId, "frf");
		if($checklists['row'] == 0)
		{
			$shipData->insertChecklist($projId, $dataStr, "frf", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert checklist $id",$user_id,"",0,0,$dataStr);
		}else
		{
			$shipData->updateChecklist($projId, $dataStr, "frf", $uId);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update checklist $id",$user_id,"",0,0,$dataStr);
		}
		
		//preparing menu structure
		if($deckArr[0] != "---")
		{
			$children = array();
			for($k=0; $k<count($deckArr); $k++)
			{
				$menuChild = $shipData->getChildMenu('id', $deckArr[$k], "frf");
				foreach($menuChild as $dat)
				{
					$node = array("title"=>$dat['title'], "key"=>$dat['key_id'], "isFolder"=>false, "family"=>$dat['family'], "tooltip"=>$dat['title']);
				}
				
				array_push($children, $node);
			}
			$childArray = json_decode($childData,true);
			$index = array_search('frf', array_column($childArray, 'key'));
			$childArray[$index]['children'] = $children;
			$childData = json_encode($childArray);
		}else
		{
			$childArray = json_decode($childData,true);
			$index = array_search('frf', array_column($childArray, 'key'));
			if(array_key_exists("children", $childArray[$index]))
			{
				unset($childArray[$index]['children']); 
			}
			$childData = json_encode($childArray);
		}
		return $childData;
	}
	
	function typeInput($stringCommand)
	{
		$pieces = explode("~", $stringCommand);
		$childData = $pieces[1];
		
		$childArray = json_decode($childData,true);
		$childData = json_encode($childArray);
		
		return $childData;
	}
	
	//miscellanous
	function phpToJSArray(array $input)
	{
		$output = "[";
		for($i=0; $i<count($input); $i++)
		{
			$output = $output.$input[$i].",";
		}	
		$output = substr_replace($output, "]", -1);
		return $output;
	}
	
	//build summary
	function menuSummary($projId, $shipData, $rms)
	{
		include "mapping.php";
		
		foreach($translate as $tr)
		{	
			//check if menu has child (mnu-child)
			if($tr['checklist'])
			{
				//if menu grouped in family
				if($tr['family'])
				{
					$family = explode("+", $tr['id']);
					$menu = $shipData->getMenuByFamily($family);
					foreach($menu as $mn)
					{
						$parent = $mn['key_id'];
						$checklist = $shipData->getChecklist($projId, $parent);
						if($checklist['row']>0)
						{
							$parentName = str_replace("+", " ", $shipData->getName($parent));
							echo "<h3>$parentName</h3>";
							foreach($checklist['content'] as $chk)
							{
								$children = explode("#",$chk['checklist']);
								for($i=0; $i<count($children); $i++)
								{
									$data = $shipData->getData($tr['table'], $tr['search'], $projId, $children[$i]);
									if($data['row'] > 0)
									{
										$childName = str_replace("+", " ", $shipData->getChildName($children[$i]));
										echo "<h4>$childName</h4>";
										
										//get column name
										$tbl = "og_data_$tr[table]";
										$columnName = $shipData->getColumnName($tbl);
										$col = array();
										foreach($columnName as $column)
										{
											$col[] = $column['Field'];
										}
										
										$rowStr = "<tr>";
										//parsing data
										foreach($data['content'] as $dat)
										{
											//preparing variables for table view
											$head = "<tr>";
											$titleStr = $tr['item'];
											$title = explode("-", $titleStr);
											
											//arrange data in array
											$valArray = array();
											$temp = array();
											for($j=1; $j<count($col)-$tr['limit']; $j++)
											{
												$temp[] = $dat[$col[$j]];
											}
											
											$addition = array_pop($temp);
											$add = explode("+", $addition);
											foreach($add as $dat)
											{
												if(strpos($dat,"@"))
												{
													$dat = implode(", ", explode("@", $dat));
												}
											}
											$valArray = array_merge($temp, $add);
											
											//arrange data in rows
											for($i=0; $i<count($title); $i++)
											{
												//only un-empty values are listed
												if($valArray[$i] != "-" && !is_null($valArray[$i]) && $valArray[$i] != "0" && $valArray[$i] != "")
												{
													$head = $head."<th>$title[$i]</th>";	//arrange table head
													if(array_key_exists($title[$i], $tr['map']))
													{
														$value = $tr['map'][$title[$i]][$valArray[$i]];
														if(is_null($value))
														{
															$value = $valArray[$i];
														}
													}else
													{
														$value = $valArray[$i];
													}
													
													$rowStr = $rowStr." <td>$value</td>";
												}
											}
											$head = $head."</tr>";
											$rowStr = $rowStr."</tr>";
										}
										//build table
										echo 	"<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
													<thead>
														$head
													</thead>
													<tbody>
														$rowStr
													</tbody>
												</table>";
										
									}
								}
							}
						}
					}
				}else	//if menu not grouped in family
				{
					$checklist = $shipData->getChecklist($projId, $tr['id']);
					if($checklist['row']>0)
					{
						$parentName = str_replace("+", " ", $shipData->getName($tr['id']));
						echo "<h3>$parentName</h3>";
						foreach($checklist['content'] as $chk)
						{
							$children = explode("#",$chk['checklist']);
							for($i=0; $i<count($children); $i++)
							{
								$data = $shipData->getData($tr['table'], $tr['search'], $projId, $children[$i]);
								if($data['row'] > 0)
								{
									$childName = str_replace("+", " ", $shipData->getChildName($children[$i]));
									echo "<h4>$childName</h4>";
									
									//get column name
									$tbl = "og_data_$tr[table]";
									$columnName = $shipData->getColumnName($tbl);
									$col = array();
									foreach($columnName as $column)
									{
										$col[] = $column['Field'];
									}
									
									if($tr['type'] == "field") 		//field type visualization
									{
										//parsing data
										foreach($data['content'] as $dat)
										{
											//preparing variables for table view
											$head = "<tr>
														<th>Item</th>
														<th>Value</th>
													</tr>";
											$rowStr = "";
											
											$titleStr = $tr['item'];
											$title = explode("-", $titleStr);
											
											//arrange data in array
											$valArray = array();
											$temp = array();
											if($tr['id'] != "trs")
											{
												for($j=1; $j<count($col)-$tr['limit']; $j++)
												{
													$temp[] = $dat[$col[$j]];
												}
											}else
											{
												$temp = explode("+", $dat['characteristic']);
											}
												
											$addition = array_pop($temp);
											$add = explode("+", $addition);
											foreach($add as $dat)
											{
												if(strpos($dat,"@"))
												{
													$dat = implode(", ", explode("@", $dat));
												}
											}
											$valArray = array_merge($temp, $add);
											//arrange data in rows
											for($j=0; $j<count($title); $j++)
											{
												//check if map is needed
												if($valArray[$j] != "-" && !is_null($valArray[$j]) && $valArray[$j] != "0" && $valArray[$j] != "")
												{
													if(array_key_exists($title[$j], $tr['map']))
													{
														$value = $tr['map'][$title[$j]][$valArray[$j]];
														if(is_null($value))
														{
															$value = $valArray[$j];
														}
													}else
													{
														$value = $valArray[$j];
													}
													
													$rowStr = $rowStr." <tr>
																				<td>$title[$j]</td>
																				<td>$value</td>
																			</tr>";
												}
											}
											
											//build table
											echo 	"<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
														<thead>
															$head
														</thead>
														<tbody>
															$rowStr
														</tbody>
													</table>";
											 
										}
									}else if($tr['type'] == "table") 		//table type visualization
									{
										$rowStr = "<tr>";
										//parsing data
										foreach($data['content'] as $dat)
										{
											//preparing variables for table view
											$head = "<tr>";
											$titleStr = $tr['item'];
											$title = explode("-", $titleStr);
											
											//arrange data in array
											$valArray = array();
											$temp = array();
											for($j=1; $j<count($col)-$tr['limit']; $j++)
											{
												$temp[] = $dat[$col[$j]];
											}
											
											$addition = array_pop($temp);
											$add = explode("+", $addition);
											foreach($add as $dat)
											{
												if(strpos($dat,"@"))
												{
													$dat = implode(", ", explode("@", $dat));
												}
											}
											$valArray = array_merge($temp, $add);
											
											//arrange data in rows
											for($i=0; $i<count($title); $i++)
											{
												//only un-empty values are listed
												if($valArray[$i] != "-" && !is_null($valArray[$i]) && $valArray[$i] != "0" && $valArray[$i] != "")
												{
													$head = $head."<th>$title[$i]</th>";	//arrange table head
													if(array_key_exists($title[$i], $tr['map']))
													{
														$value = $tr['map'][$title[$i]][$valArray[$i]];
														if(is_null($value))
														{
															$value = $valArray[$i];
														}
													}else
													{
														$value = $valArray[$i];
													}
													
													$rowStr = $rowStr." <td>$value</td>";
												}
											}
											$head = $head."</tr>";
											$rowStr = $rowStr."</tr>";
										}
										//build table
										echo 	"<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
													<thead>
														$head
													</thead>
													<tbody>
														$rowStr
													</tbody>
												</table>";
									}
									
								} 
							}
						}
					}
				}
			}else	//menu with no child (mnu-no)
			{
				//check if data is separated into more than one tables
				if(is_array($tr['table']))
				{
					$name = str_replace("+", " ", $shipData->getName($tr['id']));
					echo "<h3>$name</h3>";

					foreach($tr['table'] as $subName=>$datTable)
					{
						$data = $shipData->getData($datTable, $tr['search'], $projId);
						
						//get column name
						$tbl = "og_data_$datTable";
						$columnName = $shipData->getColumnName($tbl);
						$col = array();
						foreach($columnName as $column)
						{
							$col[] = $column['Field'];
						}
						
						if($data['row'] > 0)
						{
							echo "<h4>$subName</h4>";
							//parsing data
							foreach($data['content'] as $dat)
							{
								//preparing variables for table view
								$head = "<tr>
											<th>Item</th>
											<th>Value</th>
										</tr>";
								$rowStr = "";
								
								$titleStr = $tr['item'][$subName];
								$title = explode("-", $titleStr);
								
								//arrange data in array
								$valArray = array();
								$upper = $tr['limit'][$subName];
								for($j=2; $j<count($col)-$upper; $j++)
								{
									$valArray[] = $dat[$col[$j]];
								}
								
								//arrange data in rows
								for($i=0; $i<count($title); $i++)
								{
									//check if map is needed
									if($valArray[$i] != "-" && !is_null($valArray[$i]) && $valArray[$i] !="0" && $valArray[$i] != "")
									{
										if(array_key_exists($title[$i], $tr['map']))
										{
											$value = $tr['map'][$title[$i]][$valArray[$i]];
											if(is_null($value))
											{
												$value = $valArray[$i];
											}
										}else
										{
											$value = $valArray[$i];
										}
										
										$rowStr = $rowStr." <tr>
																	<td>$title[$i]</td>
																	<td>$value</td>
																</tr>";
									}
								}
								
								//build table
								echo 	"<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
											<thead>
												$head
											</thead>
											<tbody>
												$rowStr
											</tbody>
										</table>";
								
							}
						}
					}
				}else
				{
					$data = $shipData->getData($tr['table'], $tr['search'], $projId);
					if(($data['row'] > 0 && $data['row'] < 2) || ($tr['id'] == "cpc" && $data['row'] > 0)) //no subname
					{
						$name = str_replace("+", " ", $shipData->getName($tr['id']));
						echo "<h3>$name</h3>";
						
						//get column name
						$tbl = "og_data_$tr[table]";
						$columnName = $shipData->getColumnName($tbl);
						$col = array();
						foreach($columnName as $column)
						{
							$col[] = $column['Field'];
						}
						
						if($tr['type'] == "field") 		//field type visualization
						{
							//parsing data
							foreach($data['content'] as $dat)
							{
								//preparing variables for table view
								$head = "<tr>
											<th>Item</th>
											<th>Value</th>
										</tr>";
								$rowStr = "";
								
								$titleStr = $tr['item'];
								$title = explode("-", $titleStr);
								
								//arrange data in array
								$valArray = array();
								for($j=1; $j<count($col)-$tr['limit']; $j++)
								{
									$valArray[] = $dat[$col[$j]];
								}
								
								//arrange data in rows
								for($i=0; $i<count($title); $i++)
								{
									//check if map is needed
									if($valArray[$i] != "-" && !is_null($valArray[$i]) && $valArray[$i] != "0" && $valArray[$i] != "")
									{
										if(array_key_exists($title[$i], $tr['map']))
										{
											$value = $tr['map'][$title[$i]][$valArray[$i]];
											if(is_null($value))
											{
												$value = $valArray[$i];
											}
										}else
										{
											$value = $valArray[$i];
										}
										
										$rowStr = $rowStr." <tr>
																	<td>$title[$i]</td>
																	<td>$value</td>
																</tr>";
									}
								}
								
								//build table
								echo 	"<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
											<thead>
												$head
											</thead>
											<tbody>
												$rowStr
											</tbody>
										</table>";
								
							}
						}else if($tr['type'] == "table") 		//table type visualization
						{
							$rowStr = "<tr>";
							//parsing data
							foreach($data['content'] as $dat)
							{
								//preparing variables for table view
								$head = "<tr>";
								$titleStr = $tr['item'];
								$title = explode("-", $titleStr);
								
								//arrange data in array
								$valArray = array();
								for($j=1; $j<count($col)-$tr['limit']; $j++)
								{
									$valArray[] = $dat[$col[$j]];
								}
								
								//arrange data in rows
								for($i=0; $i<count($title); $i++)
								{
									//only un-empty values are listed
									if($valArray[$i] != "-" && !is_null($valArray[$i]) && $valArray[$i] != "0" && $valArray[$i] != "")
									{
										$head = $head."<th>$title[$i]</th>";	//arrange table head
										if(array_key_exists($title[$i], $tr['map']))
										{
											$value = $tr['map'][$title[$i]][$valArray[$i]];
											if(is_null($value))
											{
												$value = $valArray[$i];
											}
										}else
										{
											$value = $valArray[$i];
										}
										
										$rowStr = $rowStr." <td>$value</td>";
									}
								}
								$head = $head."</tr>";
								$rowStr = $rowStr."</tr>";
							}
							//build table
							echo 	"<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											$head
										</thead>
										<tbody>
											$rowStr
										</tbody>
									</table>";
						}else 		//mix type visualization
						{
							//parsing data
							foreach($data['content'] as $dat)
							{
								//preparing variables for table view
								$head = "<tr>
											<th>Item</th>
											<th>Value</th>
										</tr>";
								$rowStr = "";
								
								$titleStr = $tr['item'];
								$title = explode("-", $titleStr);
								
								//arrange data in array
								$valArray = array();
								for($j=1; $j<count($col)-$tr['limit']; $j++)
								{
									$valArray[] = $dat[$col[$j]];
								}
								
								$acc = array_pop($valArray);
								//arrange data in rows
								for($i=0; $i<count($title); $i++)
								{
									//check if map is needed
									if($valArray[$i] != "-" && $valArray[$i] != "0" && $valArray[$i] != "")
									{
										if(array_key_exists($title[$i], $tr['map']))
										{
											$value = $tr['map'][$title[$i]][$valArray[$i]];
											if(is_null($value))
											{
												$value = $valArray[$i];
											}
										}else
										{
											$value = $valArray[$i];
										}
										
										$rowStr = $rowStr." <tr>
																	<td>$title[$i]</td>
																	<td>$value</td>
																</tr>";
									}
								}
								
								//accessories' data
								$accData = explode("@", $acc);
								$accTitle = explode("-", $tr['map']['Accessories']['name']);
								$headStr = "";
								$accRow = "";
								for($i=0; $i<count($accTitle); $i++)
								{
									$headStr = $headStr."<th>$accTitle[$i]</th>";
								}
								$accHead = "<tr>
												$headStr
											</tr>";
								for($i=0; $i<count($accData); $i++)
								{
									$detail = explode("+", $accData[$i]);
									for($j=0; $j<count($detail); $j++)
									{
										if(array_key_exists($accTitle[$j],$tr['map']['Accessories']))
										{
											$value = $tr['map']['Accessories'][$accTitle[$j]][$detail[$j]];
										}else
										{
											$value = $detail[$j];
										}
										$accRow = $accRow."<td>$value</td>";
									}
									$accRow = "<tr>".$accRow."</tr>";
								}
								
								//build table
								echo 	"<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
											<thead>
												$head
											</thead>
											<tbody>
												$rowStr
											</tbody>
										</table>";
										
								echo "
										<h4>Accessories</h4>
										<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
											<thead>
												$accHead
											</thead>
											<tbody>
												$accRow
											</tbody>
										</table>
										";
								
							}
						}
					}else if($data['row'] >= 2) //with subname
					{
						$name = str_replace("+", " ", $shipData->getName($tr['id']));
						echo "<h3>$name</h3>";
					
						//get column name
						$tbl = "og_data_$tr[table]";
						$columnName = $shipData->getColumnName($tbl);
						$col = array();
						foreach($columnName as $column)
						{
							$col[] = $column['Field'];
						}
						
						//parsing data
						foreach($data['content'] as $dat)
						{
							//preparing variables for table view
							$head = "<tr>
										<th>Item</th>
										<th>Value</th>
									</tr>";
							$rowStr = "";
							
							//get identifier (token)
							if(!is_null($dat['sub']))
							{
								$token = $dat['sub'];
							}else if(!is_null($dat['type']))
							{
								$token = $dat['type'];
							}
							
							//get subname and title
							$subname = $tr['item'][$token]['name'];
							$titleStr = $tr['item'][$token]['title'];
							$title = explode("-", $titleStr);
							
							echo "<h4>$subname</h4>";
							
							//arrange data in array
							$valArray = array();
							if($tr['id'] == "prs")
							{
								$valArray = explode("+", $dat['characteristic']);
							}else
							{
								$temp = array();
								for($j=1; $j<count($col)-$tr['limit']; $j++)
								{
									$temp[] = $dat[$col[$j]];
								}
								$add = array_pop($temp);
								$additional = explode("+", $add);
								$valArray = array_merge($temp, $additional);
							}
							
							//arrange data in rows
							for($i=0; $i<count($title); $i++)
							{
								//only un-empty value are listed
								if($valArray[$i] != "-" && !is_null($valArray[$i]) && $valArray[$i] != "0" && $valArray[$i] != "")
								{
									if(array_key_exists($title[$i], $tr['map']))
									{
										$value = $tr['map'][$title[$i]][$valArray[$i]];
									}else
									{
										$value = $valArray[$i];
									}
									
									$rowStr = $rowStr." <tr>
																<td>$title[$i]</td>
																<td>$value</td>
															</tr>";
								}
							}
							
							//build table
							echo 	"<table class='table table-striped table-bordered table-hover table-full-width' id='sample_1'>
										<thead>
											$head
										</thead>
										<tbody>
											$rowStr
										</tbody>
									</table>";
							
						}
					}
				}
			}	
		}
		
		echo "	<script>
					document.getElementById('heading-title').textContent = 'Summary';
				</script>";
	}

?>
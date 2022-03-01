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
	
	$classMap = array(
						'gen'=>"GeneralDataFormClass",
						'tnk'=>"TankFormClass",
						'mac'=>"MachineryFormClass",
						'pmp'=>"MachineryFormClass",
						'vts'=>"MachineryFormClass",
						'eqp'=>"EquipmentFormClass"
						);

	$modul = $_POST['modul'];
	
	switch($modul)
	{
		case "getForm":
			getForm($shipData, $obj, $alluserArray, $user_id, $classMap);
			break;
		
		case "updateTree":
			updateTree($shipData, $obj, $user_id);
			break;
			
		case "dataOps":
			dataOps($shipData, $user_id, $classMap);
			break;

		case "znum":
			getDataFromZnum($shipData);
			break;
	}

	function getForm($shipData, $obj, $alluserArray, $user_id, $classMap)
	{
		$code = $_POST['id'];
		$projId = $_POST['projId'];
		$family = $_POST['family'];
		$parent = $_POST['parentKey'];
		$datId = $_POST['datId'];

		//print_r($_POST);

		if($family == "-")
		{
			if($parent == "root")
			{
				$sign = $code;
			}else
			{
				$sign = $parent;
			}
		}else
		{
			$sign = $family;
		}

		if(array_key_exists($sign, $classMap))
		{
			$class = $classMap[$sign];
			$path = "../class/map/$class.php";

			$input = array(
							'helper'=>$shipData,
							'code'=>$code,
							'parent'=>$parent,
							'projId'=>$projId,
							'user'=>$user_id,
							'usersArr'=>$alluserArray,
							'datId'=>$datId,
							'family'=>$family
							);
			include $path;
			$object = new $class($input);
			$htmlStr = $object->showForm();
		}else
		{
			//print_r($_POST);
			$htmlStr = "No such code";
		}

		echo $htmlStr;
	}

	function updateTree($shipData, $obj, $user_id)
	{
		$data = array_values(json_decode($_POST['data'], true))[0];
		$code = $_POST['code'];
		$projId = $_POST['projId'];

		$tmp = explode("@@", $data);

		unset($tmp[0]);
		$dataStr = implode("#", $tmp);

		if(empty($dataStr))
		{
			$dataStr = "---";
		}

		$checklists = $shipData->getChecklist($projId, $code);
		if($checklists['row'] == 0)
		{
			$shipData->insertChecklist($projId, $dataStr, $code, $user_id);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Insert checklist $id",$user_id,"add",0,0,$dataStr);
		}else
		{
			$shipData->updateChecklist($projId, $dataStr, $code, $user_id);
			$obj->WriteLogAplicationLogs($user_id,$projId,"Update checklist $id",$user_id,"edit",0,0,$dataStr);
		}

		$treeMenu = $shipData->getMenuAll();
		$childArray = array();
		foreach($treeMenu as $menu)
		{
			$node = array("title"=>$menu['title'], "key"=>$menu['key_id'], "isFolder"=>true, "family"=>$menu['family'], "tooltip"=>$dat['title']);
			array_push($childArray, $node);
		}
		$checklists = $shipData->getChecklist($projId);

		if($checklists['row'] != 0)
		{
			foreach($checklists['content'] as $checklist)
			{
				$tmpArr = explode("#", $checklist['checklist']);
				if($tmpArr[0] != "---")
				{
					$children = array();
					$childId = $checklist['parent'];
					for($k=0; $k<count($tmpArr); $k++)
					{
						$menuChild = $shipData->getChildMenu('id', $tmpArr[$k], $childId);
						foreach($menuChild as $dat)
						{
							$node = array("title"=>$dat['title'], "key"=>$dat['key_id'], "isFolder"=>false, "family"=>$dat['family'], "tooltip"=>$dat['title']);
						}
						array_push($children, $node);
					}
					$index = array_search($childId, array_column($childArray, 'key'));
					$childArray[$index]['children'] = $children;
				}
			}
		}

		$childData = json_encode($childArray);
		echo $childData;
	}

	function dataOps($shipData, $user_id, $classMap)
	{
		$act = $_POST['act'];
		$dataStr = $_POST['data'];
		$code = $_POST['code'];
		$parent = $_POST['parent'];
		$projId = $_POST['projId'];
		$dataId = $_POST['dataId'];
		$family = $_POST['family'];

		if($act == "del")
		{
			$shipData->JSONDataDelete($dataId);
		}else
		{
			if(empty($dataId))
			{
				$shipData->JSONDataInsertOrUpdate($projId, $user_id, $dataStr, $code, $parent);
			}else
			{
				$shipData->JSONDataInsertOrUpdate($projId, $user_id, $dataStr, $code, $parent, $dataId);
			}
		}

		if($family == "-")
		{
			if($parent == "root")
			{
				$sign = $code;
			}else
			{
				$sign = $parent;
			}
		}else
		{
			$sign = $family;
		}

		if(array_key_exists($sign, $classMap))
		{
			$class = $classMap[$sign];
			$path = "../class/map/$class.php";

			$input = array(
							'helper'=>$shipData,
							'code'=>$code,
							'parent'=>$parent,
							'projId'=>$projId,
							'user'=>$user_id,
							'usersArr'=>$alluserArray,
							'datId'=>$datId,
							'family'=>$family
							);
			include $path;
			$object = new $class($input);
			$htmlStr = $object->showForm();
		}else
		{
			$htmlStr = "No such code";
		}

		echo $htmlStr;

	}

	function getDataFromZnum($shipData)
	{
		$znum = $_POST['znum'];
		$out = $shipData->zNumTranslate($znum);

		echo $out;
	}
?>
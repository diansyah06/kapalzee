<?php
include("../sis32/db_connect.php");
include "../functions.php";
include "../class/init3.php";
include "../modern.php" ;
date_default_timezone_set('Asia/Jakarta');

$client = new client();
$recipientArray = array();
$allProject = $obj->get_wokspaceUndone(0);

if(!empty($allProject))
{
	foreach($allProject as $all)
	{
		$id_kon = $all['object_id'];
		$projectName = $all['project'];
		$users = $kontrak->getClientOfProject($id_kon);
		foreach($users as $usr)
		{
			$idClient = $usr['id_client'];
			$setting = $client->getSettingByIdClient("digest", $idClient);
			if(!empty($setting))
			{
				foreach($setting as $st)
				{
					$address = $st['email_address'];

					if($st['type'] == $type)
					{
						$allNotif = $client->getNotificationByProj($id_kon, $type);
						$mailBody = "<p>You have unread notifications for project $projectName:</p>
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
	}	
}

?>
<?php
include "../functions.php";

require '../class/init2.php';

	
		if(isset($_POST['queryString'])) {
			$queryString = "%" . $_POST['queryString']. "%";
			
			
			if(strlen($queryString) > 0) {
				
				$lis_konts = $kontrak->get_autosugest_gambar($queryString);
				
				
				
				echo '<ul>';
				foreach ($lis_konts as $lis_kont) {
				
				echo '<li onClick="fill(\''.($lis_kont['nama'] . "'" . ',' . "'". $drawings['judul']. '\',' . "'". $lis_kont['id']) . '\');">'.$lis_kont['nama'].'</li>';
				}

				echo '</ul>';
					
				
			} else {
				// do nothing
			}
		} else {
			echo 'There should be no direct access to this script!';
		}
	
?>
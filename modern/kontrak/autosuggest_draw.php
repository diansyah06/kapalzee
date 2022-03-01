<?php
include "../../functions.php";

require '../../class/init4.php';

	if ($_POST['point']==3){
		if(isset($_POST['queryString'])) {
			$queryString = "%" . $_POST['queryString']. "%";
			
			
			if(strlen($queryString) > 0) {
				
				$drawingss = $drawing->get_autosugest_gambar_tipe($queryString,$_POST['code'],$_POST['tipe']);
				
				
				
				echo '<ul>';
				foreach ($drawingss as $drawings) {
					
					$judul = str_replace("'","",$drawings['judul']);
					$judul = str_replace("&#039;","",$judul);
					$judul = str_replace("&#39;","",$judul);

				
				echo '<li onClick="fillopopopo(\''.($drawings['no_gambar'] . "'" . ',' . "'". $judul. '\',' . "'". $drawings['id']. '\',' . "'". $drawings['rev']) . '\');">'.$drawings['no_gambar']. "  : $judul, Rev. ".  $drawings['rev']. '</li>';
				}

				echo '</ul>';
					
				
			} else {
				// do nothing
			}
		}

	}elseif ($_POST['point']==2){
		if(isset($_POST['queryString'])) {
			$queryString = "%" . $_POST['queryString']. "%";
			
			
			if(strlen($queryString) > 0) {
				
				$drawingss = $drawing->get_autosugest_gambar_tipe($queryString,$_POST['code'],$_POST['tipe']);
				
				
				
				echo '<ul>';
				foreach ($drawingss as $drawings) {

					$judul = str_replace("'","",$drawings['judul']);
					$judul = str_replace("&#039;","",$judul);
					$judul = str_replace("&#39;","",$judul);
				
				echo '<li onClick="fillop(\''.($drawings['no_gambar'] . " : $judul, Rev. $drawings[rev]'" . ',' . "'". $judul. '\',' . "'". $drawings['id']) . '\');">'.$drawings['no_gambar']. "  : $judul, Rev. ".  $drawings['rev'].'</li>';
				}

				echo '</ul>';
					
				
			} else {
				// do nothing
			}
		}

	}
	else {
		
		if(isset($_POST['queryString'])) {
			$queryString = "%" . $_POST['queryString']. "%";
			
			
			if(strlen($queryString) > 0) {

				$drawingss = $drawing->get_autosugest_gambar($queryString,$_POST['code']);
				
				
				
				echo '<ul>';
				foreach ($drawingss as $drawings) {

					$judul = str_replace("'","",$drawings['judul']);
					$judul = str_replace("&#039;","",$judul);
					$judul = str_replace("&#39;","",$judul);
				
				echo '<li onClick="fillo(\''.($drawings['no_gambar'] . ", Rev. $drawings[rev]'" . ',' . "'". $judul . '\',' . "'". $drawings['id']) . '\');">'.$drawings['no_gambar']. ", Rev. ".  $drawings['rev'].'</li>';
				}

				echo '</ul>';
					
				
			} else {
				// do nothing
			}
		}
	}
	
	
?>
<?php
include "../functions.php";
require '../class/init3.php';

$module=$_POST['module'];

switch ($module) {
    case "queryprojectdll":
      queryprojectdll($kpi) ;
      break;
	case queryTraining :
      queryTraining($kpi) ;
      break;	
	case queryInvest :
      queryInvest($kpi) ;
      break;
	  
    case "rulepub":
       
        break;
	case "queryproject":
	 queryproject($obj);
		break;
	
	
}		

function queryproject($obj){

if(isset($_POST['queryString'])) {
			$queryString = "%" . $_POST['queryString']. "%";
			
			
			if(strlen($queryString) > 0) {
				
				$rules_rmss = $obj->searchWorkspace($queryString);
				
		
				
				echo '<ul>';
				foreach ($rules_rmss as $rules_rms) {
				
				echo '<li onClick="fill(\''.('3' . "'" . ',' . "'" . $rules_rms['project'] .'\',' . "'". $rules_rms['object_id']) . '\');">'.$rules_rms['project'] .'</li>';
				}

				echo '</ul>';
					
				
			} else {
				// do nothing
			}
		}
		


}

function  queryprojectdll($kpi){

if(isset($_POST['queryString'])) {
			$queryString = "%" . $_POST['queryString']. "%";
			
			
			if(strlen($queryString) > 0) {
				
				$rules_rmss = $kpi->trainingSugeest($queryString);
				
		
				
				
				echo '<ul>';
				foreach ($rules_rmss as $rules_rms) {
				
				echo '<li onClick="fill(\''.('2' . "'" . ',' . "'". $rules_rms['training'] .'\',' . "'". $rules_rms['id']) . '\');">'.$rules_rms['training'] .'</li>';
				}

				echo '</ul>';
					
				
			} else {
				// do nothing
			}
		}
		
}

function  queryTraining($kpi){

if(isset($_POST['queryString'])) {
			$queryString = "%" . $_POST['queryString']. "%";
			
			
			if(strlen($queryString) > 0) {
				
				$rules_rmss = $kpi->trainingSugeestPeriode($queryString);
				
		
				
				
				echo '<ul>';
				foreach ($rules_rmss as $rules_rms) {
				
				echo '<li onClick="fill(\''.($rules_rms['jenis'] . "'" . ',' . "'". $rules_rms['training'] .'\',' . "'". $rules_rms['id']) . '\');">'.$rules_rms['training'] .'</li>';
				}

				echo '</ul>';
					
				
			} else {
				// do nothing
			}
		}
		
}

function  queryInvest($kpi){

if(isset($_POST['queryString'])) {
			$queryString = "%" . $_POST['queryString']. "%";
			
			
			if(strlen($queryString) > 0) {
				
				$rules_rmss = $kpi->InvestSugeestPeriode($queryString);
				
		
				
				
				echo '<ul>';
				foreach ($rules_rmss as $rules_rms) {
				
				echo '<li onClick="fill(\''.($rules_rms['type'] . "'" . ',' . "'". $rules_rms['item'] .'\',' . "'". $rules_rms['id']) . '\');">'.$rules_rms['item'] .'</li>';
				}

				echo '</ul>';
					
				
			} else {
				// do nothing
			}
		}
		
}
		

?>

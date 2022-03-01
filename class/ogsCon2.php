<?php
//CONFIG
require('../nuasop/nusoap.php');
$mynamespace = "http://tempuri.org/";	

class OGS{
  
	const wsdl = "http://192.168.70.213/ogsconnection/ogsconnection.asmx?wsdl";
	
	private $db;
		 
		public function __construct($database) {
			$this->db = $database;
			
		}
		
		
		Public function TesSend() {	
		    $s = new nusoap_client(OGS::wsdl,true);
			
			$theVariable = array('kodetipe'=> 10);

			$result = $s->call('RulesMapping',array('parameters' =>  $theVariable));
			
			$pieces = explode(";", $result['RulesMappingResult']);
	
			//Dump array
			//echo "<pre>" ;
			//print_r  ($pieces)  ;
			//echo "</pre>" ;
		
			return $result['RulesMappingResult'] ;
		}


 
    
	
	
	
	
	


}
?>
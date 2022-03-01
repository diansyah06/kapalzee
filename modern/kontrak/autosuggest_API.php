<?php
include "../../functions.php";

require '../../class/init4.php';


if($_POST['point'] == 'contract')
{	
	$url = "http://api.bki.co.id:82/api-zee/list_drawing.php";
	if(isset($_POST['queryString'])) {

		$queryString = $_POST['queryString'];
		if(strlen($queryString) > 0) {
			
			$params = array('no_kontrak'=>$queryString);
			$res = $obj->httpPost($url, $params);
			if(!empty($res))
			{
				$data = json_decode($res, true);
				echo '<ul>';
				foreach ($data as $dat) {
					echo 	"<li onClick='fillCon(&#39;$dat[NOAPL]&#39;, &#39;$dat[nmhon]&#39;, &#39;$dat[nmobj]&#39;);'>
								Contract: $dat[NOAPL]<br>
								Applicant: $dat[nmhon]<br>
								Ship Type: $dat[tyshp]<br>
								Object Name: $dat[nmobj]
							</li>";
				}
				echo '</ul>';
			}else
			{
				echo '<ul><li>No data</li></ul>';
			}
		} else {
			// do nothing
		}
	}

}else if($_POST['point'] == 'notation')
{
	$url = "http://api.bki.co.id:82/api-zee/list_notasi.php";
	if(isset($_POST['queryString'])) {

		$queryString = $_POST['queryString'];
		if(strlen($queryString) > 0) {
			
			$params = array('notasi'=>$queryString);
			$res = $obj->httpPost($url, $params);
			if(!empty($res))
			{
				$data = json_decode($res, true);
				echo '<ul>';
				foreach ($data as $dat) {
					echo 	"<li onClick='fillNotation(&#39;$dat[abre]&#39;);'>
								Notation code: $dat[konot]<br>
								Name: $dat[abre]
							</li>";
				}
				echo '</ul>';
			}else
			{
				echo '<ul><li>No data</li></ul>';
			}
		} else {
			// do nothing
		}
	}
}

?>
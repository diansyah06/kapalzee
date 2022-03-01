<?php
if(isset($_GET['nama'])){
	$link=$_GET['link'];
	$mime=$_GET['mime'];
	$newname= 'down_' . date('Y-m-d') . ',' . generateRandomString() . "_" . $_GET['nama'] ;
	// header("Content-type: $mime");
	// header("Content-Disposition: attachment; filename=$_GET[nama]");
	// readfile($link);
	//     die;

	if (!file_exists('../download/')) { // cek apabila folder ada 
	    mkdir('../download/', 0777, true);
	}


	if (!copy($link, '../download/' . $newname )) {
    	echo "failed to copy " ;
	}else {
		echo "<script> location.href = '../download/$newname ';  </script>" ;
	}
 
}elseif(isset($_GET[zipname])){
	header("Content-Type: application/zip");
	header("Content-Disposition: attachment; filename=$_GET[zipname]");
	readfile($_GET[zipname]);
die;
}



DellFileKecualiToday();




function DellFileKecualiToday(){
	
	$a= scandir('../download/');

	//print_r($a);

	foreach ($a as $b ) {
		//echo $b . "<br>" ;

		$c= explode(',', $b);

		if (strpos($c[0], 'down_') !== false) {

			$d = str_replace("down_","",$c[0]);
				//echo $d ;
				if (date('Y-m-d') != $d){

					unlink('../download/' . $b); 
				}

		}

	}

}

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}




?>
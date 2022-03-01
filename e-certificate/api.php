<?php
error_reporting(E_ERROR);
//error_reporting(E_ALL);
include "../class/init6.php";
require_once('../class/CERTdigitalsignature.php');
require_once('../class/wraper.php');

date_default_timezone_set('Asia/Jakarta');
$combo = array( 'KLASS' => array("HULL","MACHINERY","ILLC","INDONESIA") ,
	"MATKOM"=> array("TA","QA","SA","WS")
) ;

$configFTP = array(
	'host'	=> '10.0.1.167',
	'username'	=> 'ecertificate',
	'password'	=> '!!certBKI'
);
// echo "<pre>" ; 
// print_r($combo); 
// echo  "</pre>";


$modul = $_POST['modul'];
switch ($modul)
{
	case "loadCombo":
	loadCombo($combo);
	break;

	case "loadCombodepartemen":
	loadCombodepartemen($combo);
	break;	

	case "upload":
	uploadpdf($combo,$configFTP);
	break;

	case "uploadandSign":
	uploadpdfandSign($combo,$configFTP);
	break;


	case "checkfileExist":
	checkfileRemoteExist($configFTP);
	break;

}

function loadCombo($combo){

	$departemen = $_POST['Nama'];
	//echo $departemen ;
	echo "<select id='jenis' name='jenis' class='form-control jenis'>";	
	echo "<option selected='selected' > </option>";
	
	if ($departemen=="KLASS") {
		foreach ($combo['KLASS'] as $comb) {
			echo '<option value="'.$comb.'">'.$comb.'</option> ';
		}
	}elseif ($departemen=="MATKOM") {
		foreach ($combo['MATKOM'] as $comb) {
			echo '<option value="'.$comb.'">'.$comb.'</option> ';
		}
	}

}

function loadCombodepartemen($combo){

	$departemen = $_POST['Nama'];
	//echo $departemen ;
	echo "<select id='departemen' name='departemen' class='form-control departemen'>";	
	echo "<option selected='selected' > </option>";
	
	foreach( $combo as $key => $value ){
		echo $key . "<br>" ;
		echo '<option value="'.$key.'">'.$key.'</option> ';
	}

}

function uploadpdfandSign($combo,$configFTP){

	$ip=trim($_SERVER['REMOTE_ADDR']);

	if ($ip == "10.0.1.122") { //hanya menerima dari api ereporting
		$departemen= $_POST['departemen'];
		$jenis =$_POST['jenis'];
		$idnumber = $_POST['idnumber'];

	//$pathRemote= $departemen . "/" . $jenis . "/" ;

		$pathRemote= ConstructRemotepath($departemen, $idnumber,$jenis);



// Check if we've uploaded a file
		if (!empty($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK) {
    // Be sure we're dealing with an upload
			if (is_uploaded_file($_FILES['upload']['tmp_name']) === false) {
				throw new \Exception('Error on upload: Invalid file definition');
			}


			$allow_ext = array('pdf','PDF');
			$allow_type = array('application/pdf');
			$image_name = $_FILES['upload']['name'];
			$image_name = explode('.',$image_name);
		//$originalFilename = $image_name[0] . ".pdf" ;
			$originalFilename = $jenis . "_full". ".pdf" ;
			$ext = end($image_name);
    //echo "sapip" .  $_FILES['upload']['tmp_name'];
			if(in_array($ext, $allow_ext) && in_array($_FILES["upload"]["type"], $allow_type)){

	           // Rename the uploaded file
				$uploadName = $_FILES['upload']['name'];
				$ext = strtolower(substr($uploadName, strripos($uploadName, '.')+1));
				$filename = round(microtime(true)).mt_rand().'.'.$ext;

				if(move_uploaded_file($_FILES['upload']['tmp_name'],__DIR__.'/datapdf/'.$filename) && is_writable('./datapdf/')){
			//pdfghost
					$output_including_status=shell_exec( "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dAutoRotatePages=/None -dQUIET -dBATCH -sOutputFile=". __DIR__.'/datapdf/'."out_" . $filename." ". __DIR__.'/datapdf/'.$filename);

			//$output_including_status = shell_exec("command 2>&1; echo $?");
			//echo "Warning : " .$output_including_status ;

			//sign digital signature

					putDigitalSignature(__DIR__.'/datapdf/'."out_" . $filename,__DIR__.'/datapdf/'."stamp_" . $filename);

			//storeftp
					StoreFileFTP($configFTP,$pathRemote . $originalFilename , __DIR__.'/datapdf/'."stamp_" . $filename,false);
				dellFilegambar(__DIR__.'/datapdf/'.$filename); //originalupload
				dellFilegambar(__DIR__.'/datapdf/'."out_" . $filename); //gsconfert
				dellFilegambar(__DIR__.'/datapdf/'."stamp_" . $filename); //stamp
			}
			else{
				//echo "<script>alert('ada yang error saat move data')</script>";
				$Respon = array("status"=>2, "message"=>"ada yang error saat move data temp");
				echo json_encode($Respon);
			}


		}else{
			//echo "<script>alert('ada yang error')</script>";
			$Respon = array("status"=>3, "message"=>"ada yang saat upload server");
			echo json_encode($Respon);
		}

	}
}else{
			$Respon = array("status"=>0, "message"=>"you have no authority");
			echo json_encode($Respon);
}


}


function uploadpdf($combo,$configFTP){

	$departemen= $_POST['departemen'];
	$jenis =$_POST['jenis'];
	$idnumber = $_POST['idnumber'];

	//$pathRemote= $departemen . "/" . $jenis . "/" ;

	$pathRemote= ConstructRemotepath($departemen, $idnumber,$jenis);



// Check if we've uploaded a file
	if (!empty($_FILES['upload']) && $_FILES['upload']['error'] == UPLOAD_ERR_OK) {
    // Be sure we're dealing with an upload
		if (is_uploaded_file($_FILES['upload']['tmp_name']) === false) {
			throw new \Exception('Error on upload: Invalid file definition');
		}


		$allow_ext = array('pdf','PDF');
		$allow_type = array('application/pdf');
		$image_name = $_FILES['upload']['name'];
		$image_name = explode('.',$image_name);
		//$originalFilename = $image_name[0] . ".pdf" ;
		$originalFilename = $jenis . "_cover" . ".pdf" ;
		$ext = end($image_name);
    //echo "sapip" .  $_FILES['upload']['tmp_name'];
		if(in_array($ext, $allow_ext) && in_array($_FILES["upload"]["type"], $allow_type)){

	           // Rename the uploaded file
			$uploadName = $_FILES['upload']['name'];
			$ext = strtolower(substr($uploadName, strripos($uploadName, '.')+1));
			$filename = round(microtime(true)).mt_rand().'.'.$ext;

			if(move_uploaded_file($_FILES['upload']['tmp_name'],__DIR__.'/datapdf/'.$filename) && is_writable('./datapdf/')){
			//pdfghost
				//$output_including_status=shell_exec( "gs -sDEVICE=pdfwrite -dCompatibilityLevel=1.4 -dNOPAUSE -dAutoRotatePages=/None -dQUIET -dBATCH -sOutputFile=". __DIR__.'/datapdf/'."out_" . $filename." ". __DIR__.'/datapdf/'.$filename);

			//$output_including_status = shell_exec("command 2>&1; echo $?");
			//echo "Warning : " .$output_including_status ;

			//sign digital signature

				//putDigitalSignature(__DIR__.'/datapdf/'."out_" . $filename,__DIR__.'/datapdf/'."stamp_" . $filename);

			//storeftp
				StoreFileFTP($configFTP,$pathRemote . $originalFilename , __DIR__.'/datapdf/'. $filename);
				dellFilegambar(__DIR__.'/datapdf/'.$filename); //originalupload
				//dellFilegambar(__DIR__.'/datapdf/'."out_" . $filename); //gsconfert
				//dellFilegambar(__DIR__.'/datapdf/'."stamp_" . $filename); //stamp
			}
			else{
				echo "<script>alert('ada yang error saat move data')</script>";
			}






		}else{
			echo "<script>alert('ada yang error')</script>";
		}

	}
	
}


function StoreFileFTP($configFTP,$remotepath, $localfilename, $web = true){
    // connect and login to FTP server

	$ftp_conn = ftp_connect($configFTP['host']) or die("Could not connect to $ftp_server");
	$login = ftp_login($ftp_conn, $configFTP['username'], $configFTP['password']);

	$file = $localfilename;
    //echo $file ;
    // upload file

	$folderremote = dirname($remotepath) . PHP_EOL;
	$folderremote =trim($folderremote) . "/"  ;
    //cek folder exist
	//echo $folderremote ;

	if (ftp_directory_exists($ftp_conn, $folderremote)==true) {
		ftp_mkdir($ftp_conn, $folderremote);
	}




	$upload = ftp_put($ftp_conn, $remotepath, $file, FTP_BINARY);

if ($web) {
    // check upload status
	if (!$upload) {
		echo "<script>alert('Upload Gagal ftp')</script>";
	} else {
		echo "<script>alert('Upload Berhasil'); location.reload(); </script>";
	}  
}else{
	if (!$upload) {
		//echo "<script>alert('Upload Gagal')</script>";
		$Respon = array("status"=>4, "message"=>"gagal upload ftp");
		echo json_encode($Respon);
	} else {
		//echo "<script>alert('Upload Berhasil'); location.reload(); </script>";
		$Respon = array("status"=>1, "message"=>"success");
		echo json_encode($Respon);
	}  	
}


    // close connection
	ftp_close($ftp_conn);
}

function ftp_directory_exists($ftp, $dir)
{
    // Get the current working directory
	$origin = ftp_pwd($ftp);

    // Attempt to change directory, suppress errors
	if (@ftp_chdir($ftp, $dir))
	{
        // If the directory exists, set back to origin
		ftp_chdir($ftp, $origin);   
		return false;
	}

    // Directory does not exist
	return true;
}


function CheckFileExistonFTP($configFTP, $pathRemote){

// set up a connection to the server we chose or die and show an error
	$ftp_conn = ftp_connect($configFTP['host']) or die("Could not connect to $ftp_server");
	$login = ftp_login($ftp_conn, $configFTP['username'], $configFTP['password']);


	$folderremote = dirname($pathRemote) . PHP_EOL;
	$folderremote =trim($folderremote) . "/"  ;

	//echo "sapi " . $folderremote ; 

        $contents_on_server = ftp_nlist($ftp_conn, $folderremote); //Returns an array of filenames from the specified directory on success or FALSE on error. 

// Test if file is in the ftp_nlist array
        //var_dump($contents_on_server);
        if (in_array($pathRemote, $contents_on_server)) 
        {
        	return true ;
        }
        else
        {
        	return false ;
        };

        

        ftp_close($conn_id);
    } 



    function dellFilegambar($alamat){
    	if (file_exists($alamat)) {
    		unlink($alamat);
    	}
    }

    function checkfileRemoteExist($configFTP){

    	$payload = $_POST['Nama'];
    	$listParam = explode("#", $payload);
    	$departemen=$listParam[0];
    	$jenis=$listParam[1];
    	$idnumber=$listParam[2];


    	$remotepath = ConstructRemotepath($departemen, $idnumber,$jenis) . $jenis . ".pdf" ;



    	if(CheckFileExistonFTP($configFTP, $remotepath)==true){

    		echo "<script>
    		if (confirm('File Already Exist Are you sure you want to overide?')) {
    			console.log('Thing was saved to the database.');
    			document.getElementById('tblsubmit').disabled = false; 
    			} else {
				  // Do nothing!
    				console.log('Thing was not saved to the database.');
    				document.getElementById('tblsubmit').disabled = true; 
    				$('.upload').val('');
    			}
    			</script>";

    		}else{
    			echo "<script>

    			document.getElementById('tblsubmit').disabled = false; 

    			</script>" ;
    		}

    	}

    	function putDigitalSignature($pdfversi14path,$pathoutput){

    		require_once('../class/CERTdigitalsignature.php');
    		require_once('../class/wraper.php');


    		date_default_timezone_set('Asia/Jakarta');

    		$file=$pdfversi14path;

    		$decrypted = fopen($file, 'rb');
    		$dumby=stream_get_contents ($decrypted);

    		$watermark = new PDFStampclass(VarStream::createReference($dumby),$pathoutput);


    		$watermark->CreatePDFStamp('drawingno',$status,$comment_currents,'0000000000',$noKOntrak);   	



    	}


    	function ConstructRemotepath($departemen, $idnumber,$jenis){

    		if ($departemen =="KLASS") {

    			$pathRemote = $departemen . "/" . ConstructpathfolderKlassregister($idnumber) . $jenis . "/" ;

    		}elseif($departemen== "MATKOM"){
    			$pathRemote = $departemen . "/" . $jenis . "/" . ConstructpathfolderKlassregister($idnumber) ;
    		}

    		return $pathRemote ;
    	}



    	function ConstructpathfolderKlassregister($noregister){

    		$register = floatval($noregister) ;

    		if ($register <101) {

    			$folder = "1-100/" . $register . "/" ;

    		}else{

    			if ($register % 100 == 0) { // pasdibagi 100
    				$folder_awal = $register - 99  ;
    				$folder_akhir =  $register ;
    				$folder= $folder_awal . "-" . $folder_akhir . "/" . $register. "/" ;
    			}else{ 

    				$result = $noregister / 100;
    				$bilbulat= (int) $result ;

    				$folder_awal = $bilbulat * 100  + 1;
    				$folder_akhir = ($bilbulat + 1) * 100 ;
    				$folder=  $folder_awal . "-" . $folder_akhir . "/"  .  $register . "/";

    			}

    		}
    		return $folder ;

    	}	








    	?>
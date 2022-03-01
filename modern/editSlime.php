<?php 

include "../functions.php";

include "../sis32/db_connect.php";
sec_session_start();
include "../class/init3.php";
include "../modern.php" ;

if(login_check ($mysqli) == false) {
  echo "<link href='../pengaturan/adminstyle.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=index.php><b>LOGIN</b></a></center>";
die;}

$objectid = $_GET['id'];
$linkFile=$obj->getfilelastrevision($objectid);
$Contener=$obj->ReadDoc($linkFile);
			$nameRelated= $obj->GetCorelationname($objectid);
				foreach($nameRelated as $namedsd){
				$nameRela=$namedsd['project'];
				$projectID=$namedsd['object_id'];
				}
				
?>

<!--
 *  Slimey - SLIdeshow Microformat Editor - http://slimey.sourceforge.net
 *  Copyright (C) 2007 - 2008 Ignacio de Soto
 *
 *  Editor.
-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html>

<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<title>RMS SlideShow Editor</title>
	<script type="text/javascript" src="../plugin/slimey_0.2/slang/en_us.js"></script>
	<script type="text/javascript" src="../plugin/slimey_0.2/slimey.js"></script>
	<script language="javascript" src='https://ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js'></script>
	<script language="javascript" src='js/modern.js'></script>
	<script language="javascript" src="../plugin/slimey_0.2/functions.js"></script>
	<script language="javascript" src="../plugin/slimey_0.2/stack.js"></script>
	<script language="javascript" src="../plugin/slimey_0.2/editor.js"></script>
	<script language="javascript" src="../plugin/slimey_0.2/navigation.js"></script>
	<script language="javascript" src="../plugin/slimey_0.2/actions.js"></script>
	<script language="javascript" src="../plugin/slimey_0.2/tools.js"></script>
	<script language="javascript" src="../plugin/slimey_0.2/toolbar.js"></script>

	<link rel="stylesheet" href="../plugin/slimey_0.2/slimey.css" />

</head>

<body>

<div style="position: absolute; left: 1%; top: 1%; width: 98%; height: 98%;" id="slimey">
</div>

<script type="text/javascript">
Slimey.loadJquery();
var slimecontent= unescapeSLIM("<?php echo $Contener ; ?>") ; 
	new Slimey({
		container: 'slimey',
		rootDir: '../plugin/slimey_0.2/',
		imagesDir: '../plugin/slimey_0.2/images/',
		filename: 'apaaja',
		slimContent: escapeSLIM(slimecontent),
		saveUrl: 'save.php',
		mode: 'edit',
		idDock : '<?php echo $objectid ; ?>',
		idproje : '<?php echo $projectID ; ?>'
	});
	

</script>

<div id="revison" class="revison" style="display:none"></div>
</body>

</html>

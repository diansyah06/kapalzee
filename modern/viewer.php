<?php
include("../sis32/db_connect.php");
include "../functions.php";
sec_session_start();
//get var from post
include "../class/init3.php";
include "../modern.php" ;
date_default_timezone_set('Asia/Jakarta');


cekLoginStatus ($mysqli) ;

$revision=$_GET['rev'];
$idgambar=$_GET['id'];

if ($revision == "1"){
$alamattt= $drawing->get_gambarrevisionByid($idgambar);

}else{
$alamattt= $drawing->get_proj_gambar_temp_almat($idgambar);	

}

$decrypted = $drawing->decrypt_file($alamattt);
$dumby=stream_get_contents ($decrypted);
/* header('Content-type: application/pdf');
fpassthru($decrypted); */
$document64= base64_encode($dumby);
//decript 
//base64



?>



<html>
<head>
  <meta charset="UTF-8">
  <title>OGS - Biro Klasifikasi Indonesia</title>
</head>
<body oncontextmenu="return false">
<canvas id="the-canvas" style="border:1px  solid black" class="noprint"></canvas>

<!-- for legacy browsers we need to use compatibility.js -->
<script src="js/compatibility.js"></script>

<script src="js/pdf.js"></script>

<script id="script">

  var pdfData = atob('<?php echo $document64 ;?>');

  PDFJS.workerSrc = 'js/pdf.worker.js';

  PDFJS.getDocument({data: pdfData}).then(function getPdfHelloWorld(pdf) {
    // Fetch the first page.
    pdf.getPage(1).then(function getPageHelloWorld(page) {
      var scale = 1.5;
      var viewport = page.getViewport(scale);

      // Prepare canvas using PDF page dimensions.
      var canvas = document.getElementById('the-canvas');
      var context = canvas.getContext('2d');
      canvas.height = viewport.height;
      canvas.width = viewport.width;

      // Render PDF page into canvas context.
      var renderContext = {
        canvasContext: context,
        viewport: viewport
      };
      page.render(renderContext);
    });
  });
</script>

</body>
<style>
@media print {
  .noprint, .comments, .sidebar, .footer {
     display: none;
   }
}
</style>
<script language="javascript">
document.onmousedown=disableclick;
status="Right Click Disabled";
function disableclick(event)
{
  if(event.button==2)
   {
     alert(status);
     return false;    
   }
}

/*     function AccessClipboardData() {
        try {
			 document.getElementById("message").focus();
    window.clipboardData.setData('text', "No print data");
        } catch (err) {
   txt = "There was an error on this page.\n\n";
   txt += "Error description: " + err.description + "\n\n";
   txt += "Click OK to continue.\n\n";
    alert(txt);
        }
    }
	
	setInterval("AccessClipboardData()", 300);
	var ClipBoardText = "";
         if (window.clipboardData) {
             ClipBoardText = window.clipboardData.getData('text');
             if (ClipBoardText != "No print data") {
               alert('Sorry you have to allow the page to access clipboard');
// hide the div which contains your data          

document.getElementById("the-canvas").style.display= "none";
             }
		 } */
</script>
</html>

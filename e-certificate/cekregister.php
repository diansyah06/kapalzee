<?php
$noregister = intval($_GET['noreg']);

  echo file_get_contents("https://cops.bki.co.id/web/bantuan_rc.asp?tipe=ceknoreg&noreg=" . $noregister  );

?>
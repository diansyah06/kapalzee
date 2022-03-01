<?php
include("../sis32/db_connect.php");
include "../functions.php";

//get var from post
include "../class/init3.php";
include "../modern.php" ;
//array kegiatan
$namakegiatan=array("error","Training","Schooling","Sidang","Meeting","Committee","Attendance","Presentation","Project or Research","launcing","Other");
$listUsers=$Users->get_users();

/* $head="<table class='table table-hover' id='sample-table-1'><thead><tr><th>#</th>";

for ($x = 1; $x <= 10; $x++) {
    $head=$head .  "<th>" . $namakegiatan[$x] .  "</th>";
} 
$head=$head . "</tr></thead><tbody>";
//echo $head;
$listKpis=$kpi->getBudgetOf(2,"jenis");
foreach($listUsers as $listUser){
	$idusernya=$listUser['id_user'];
	//$alluserArray[$idusernya]=$listUser['nama'];
	$head=$head . "<tr>";
		
		$head=$head . "<td>".$listUser['nama'] . "</td>";	
		for ($x = 1; $x <= 10; $x++) {
			$n=0;
			$r=0;
			foreach ($listKpis as $listKpi){
			
				$pos = strpos($listKpi['peserta'], "," . $idusernya);
				if (($pos!==false)&& ($x==$listKpi['jenis'])){
					$n= $n+1;
					if ($listKpi['realisasiStart']!="0000-00-00 00:00:00"){
					$r=$r +1 ;	
					}
				}
			
			}
		$head=$head . "<td>".$n . " / " . $r. "</td>";	
		
		} 
										
	$head=$head . "</tr>"   ;
	
}
$head=$head . "</tbody></table>";	

echo $head;
 $day = date('W', "26-05-2015");		

echo $day ; */

$start = $month = strtotime('2009-02-01');
$end = strtotime('2011-01-01');
while($month < $end)
{
     echo date('F Y', $month), PHP_EOL;
     $month = strtotime("+1 month", $month);
}

?>
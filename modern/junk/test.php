<?php
$datetime2 = date_create('2009-10-11');
$datetime1 = date_create('2009-10-13');
$interval = date_diff($datetime2, $datetime1);
//echo $interval->days;

echo daysdiff('2009-10-13','2009-10-15');

function daysdiff($dt2, $dt1, $timeZone = 'Asia/Jakarta') {
  $tZone = new DateTimeZone($timeZone);
   
  $dt1 = new DateTime($dt1, $tZone);
  $dt2 = new DateTime($dt2, $tZone);  
   
  // use the DateTime datediff function IF we have a non-buggy version
  // there is a bug in many Windows implementations that diff() always
  // returns 6015  
  if( $dt1->diff($dt1)->format("%a") != 6015 ) {
    return $dt1->diff($dt2)->format("%a");
  }
   
  // else let's use our own method
 
  $y1 = $dt1->format('Y');  
  $y2 = $dt2->format('Y');
  $z1 = $dt1->format('z');
  $z2 = $dt2->format('z');
   
  $diff = intval($y1 * 365.2425 + $z1) - intval($y2 * 365.2425 + $z2);
 
  return $diff;
}



?>
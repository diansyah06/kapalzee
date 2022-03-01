<?php
function AddSeparator($mac, $separator = ':')
{
  $result = '';
  while (strlen($mac) > 0)
  {
    $sub = substr($mac, 0, 2);
    $result .= $sub . $separator;
    $mac = substr($mac, 2, strlen($mac));
  }
 
  // remove trailing colon
  $result = substr($result, 0, strlen($result) - 1);
  
  return   $result ;
  
}





?>
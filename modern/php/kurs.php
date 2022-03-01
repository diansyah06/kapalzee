<?php
function fungsiCurl($url){
     $data = curl_init();
     curl_setopt($data, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($data, CURLOPT_URL, $url);
         curl_setopt($data, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6");
     $hasil = curl_exec($data);
     curl_close($data);
     return $hasil;
}
$url = fungsiCurl('http://www.bca.co.id/id/kurs-sukubunga/kurs_counter_bca/kurs_counter_bca_landing.jsp');
$pecah = explode('<tr bgcolor="#d7d7d7" style="text-align:center;" height="48px">', $url);
$pecah2 = explode ('<td><strong>Beli</strong></td>',$pecah[1]);
$pecah3 = explode ('<table style="width:200px;float:left;" border="1">', $pecah2[1]);
/* echo "<table border='1'>";
echo "<tr><td>JUAL</td><td>BELI</td></tr>";
echo $pecah3[0];
echo "</table>"; */
$pecah4=explode('<tr>',$pecah3[0]);
//echo $pecah4[1];
$pecah5= explode ('<td style="text-align:right;">',$pecah4[1]);
//print_r ($pecah5);

echo "USD Jual " . str_replace('</td>','',$pecah5[1]) . "Beli " .  str_replace('</td>','',$pecah5[2]);

?>
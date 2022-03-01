<?php
include "../../functions.php";

require '../../class/init4.php';

	$draw_id=intval($_POST['drawing_id']);
	
	$get_draws=$drawing->get_proj_gambar_id($draw_id);
	
	$get_hist_draws=$drawing->get_histori_gambar_on_id($draw_id) ;
	
	foreach ($get_draws as $get_draw) {
	$nama_gam=$get_draw['judul'] ;
	$no_gam=$get_draw['no_gambar'] ;
	}
	echo "<a id='historri' class='historri' style='position: absolute;'>show history</a> <p></p><hr></hr><div id='hidden_content'>"; 
	foreach ($get_hist_draws as $get_hist_draw) {
	$z=$get_draw['tipe'];
	if ($get_hist_draw['alamat']=="none"){ $edraw="No avaible" ; }else { $edraw="Avaible" ; }
	
	echo 
	"<p><a href='kontrak/read.php?module=re&kon=$get_hist_draw[id_kontrak]&gam=$get_hist_draw[id]'" .  "target='_blank'>" . $nama_gam . " Rev  " . $get_hist_draw['revisi'] ." </a></p> ";

	}
	echo "</div>" ;
	
	echo "<script type='text/javascript'>

        $(document).ready(function () {

			histor();



        });
</script>";
	
	
	
	
?>
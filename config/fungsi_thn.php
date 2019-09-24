<?php
include "server.php";

$tahun	= date("Y");
$bulan	= date("m");

if ($bulan < 13) {
	if($bulan > 6) {
		$tahun = $tahun;
	}
	else {
		$tahun = $tahun-1;
	}
}

$tahun1 = $tahun+1;
$tahune = substr($tahun1,2,2);

$ay		= "$tahun/$tahun1";
$nama	= "Tahun Pelajaran $tahun/$tahun1";
$sql	= mysql_num_rows(mysql_query("select * from cbt_setid where XKodeAY = '$ay'"));

if($sql < 1) {
	$sql1 	= mysql_query("update cbt_setid set XStatus = '0' ");
	$sql1	= mysql_query("insert into cbt_setid (XKodeAY, XNamaAY, XStatus) values ('$ay','$nama','1')"); 
}

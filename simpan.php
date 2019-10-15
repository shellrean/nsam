<?php 

include "config/server.php";
mysql_query("SET NAMES utf8");
if(isset($_COOKIE['PESERTA'])){
$user = $_COOKIE['PESERTA'];}
  $sqluser = mysql_query("SELECT * FROM  `cbt_siswa` s LEFT JOIN cbt_ujian u ON (s.XKodeKelas = u.XKodeKelas or u.XKodeKelas = 'ALL') 
  and (s.XKodeJurusan = u.XKodeJurusan or u.XKodeJurusan = 'ALL') WHERE XNomerUjian = 
  '$user' and u.XStatusUjian = '1'");
  $s = mysql_fetch_array($sqluser);
    $xkodesoal = $s['XKodeSoal'];
    $xtokenujian = $s['XTokenUjian'];
	$xnamkel = $s['XNamaKelas'];

  
  
if(isset($_REQUEST['soale'])){
$soalnja = $_REQUEST['soale'];
}
 $cek = mysql_num_rows(mysql_query("select * from cbt_jawaban where Urut='$soalnja' and XKodeSoal = '$xkodesoal' and XUserJawab = '$user'"));
 if($cek>0){
$tgl = date("Y-m-d");
$jam = date("H:i:s");

if(isset($_REQUEST['nama'])){
$nomber = str_replace(" ","",$_REQUEST['nama']);
$jawab_esai = str_replace("  ","",mysql_real_escape_string($_REQUEST['nama']));
}
$ambiljawaban = "X$nomber";

$sqljwb = mysql_query("select *,$ambiljawaban as hasile from cbt_jawaban where Urut='$soalnja' and XKodeSoal = '$xkodesoal' and XUserJawab = '$user' and XTokenUjian = '$xtokenujian'");
echo mysql_error();
$uj = mysql_fetch_array($sqljwb);
$jwb = $uj['hasile'];
$tkn = $uj['XTokenUjian'];
$knc = $uj['XKunciJawaban'];

$sqljenis = mysql_query("select * from cbt_jawaban where Urut='$soalnja' and XKodeSoal = '$xkodesoal' and XUserJawab = '$user' and XTokenUjian = '$xtokenujian'");
$uji = mysql_fetch_array($sqljenis);
$jenis = $uji['XJenisSoal'];


if($jenis==2){
	if(!$jawab_esai==""){
	$sql = mysql_query("update cbt_jawaban set XJawabanEsai = '$jawab_esai', XTglJawab = '$tgl',XJamJawab = '$jam',Campur = '$tkn',XTemp = '$soalnja' , XNamaKelas = '$xnamkel'
	where Urut='$soalnja' and XKodeSoal = '$xkodesoal' and XUserJawab = '$user'  and XTokenUjian = '$xtokenujian'");
	}
} elseif($jenis==1){
	if($jwb==$knc){$nil = 1;} else {$nil=0;}
	$sql = mysql_query("update cbt_jawaban set XJawaban = '$nomber',XKodeJawab = '$ambiljawaban',XNilaiJawab = '$jwb', XNilai='$nil', XTglJawab = '$tgl',XJamJawab = '$jam', 
	Campur = '$tkn', XNamaKelas = '$xnamkel'
	where Urut='$soalnja' and XKodeSoal = '$xkodesoal' and XUserJawab = '$user'  and XTokenUjian = '$xtokenujian'");
}

if(isset($jam)){
$sql2 = mysql_query("Update cbt_siswa_ujian set XLastUpdate = '$jam' where XNomerUjian = '$user' and XStatusUjian = '1'");
}

 
 } 

    if(mysql_query($sql)){
     return "success!";
   	} else {
    return "failed!";
  	}
 
?>  
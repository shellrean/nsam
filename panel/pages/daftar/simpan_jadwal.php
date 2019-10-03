<?php
include "../../../config/server.php";

$tgl = substr($_REQUEST['txt_waktu'],0,10);
$jam = substr($_REQUEST['txt_waktu'],11,5);
$jam = "$jam:00";
$mjam = substr($_REQUEST['mulai2'],0,2);
$mmen = substr($_REQUEST['mulai2'],3,2);

$minutes = $_REQUEST['txt_durasi'];
$d = floor ($minutes / 1440);
$h = floor (($minutes - $d * 1440) / 60);
$m = $minutes - ($d * 1440) - ($h * 60);

$hi = strlen($h);
$mi = strlen($m);
if($hi<2){$hi = "0".$h;}else{$hi=$h;}
if($mi<2){$mi = "0".$m;}else{$mi=$m;}
$jame = "$hi:$mi:00";


$xlambat = $_REQUEST['mulai2'];

$minutest = $_REQUEST['txt_durasi'];
$dt = floor ($minutest / 1440);
$ht = floor (($minutest - $dt * 1440) / 60);
$mt = $minutest - ($dt * 1440) - ($ht * 60);

$hit = strlen($ht);
$mit = strlen($mt);
if($hit<2){$hit = "0".$ht;}else{$hit=$ht;}
if($mit<2){$mit = "0".$mt;}else{$mit=$mt;}
$jamet = "$mjam:$mmen:00";


$xjumlahjam = $jamet;
$xjam = substr($xjumlahjam,0,2);
$xmnt = substr($xjumlahjam,3,2);
$xdtk = substr($xjumlahjam,6,2);


$jatahjam = $xjam;
$jatahmnt = $xmnt;
$menit = $jatahmnt+($jatahjam*60);
$timestamp = strtotime($jam) + $menit*60;
$tjam = date('H', $timestamp);
$tmnt = date('i', $timestamp);
$tdtk = date('s', $timestamp);

$jamlam = $_REQUEST['mulai2'];
$telatujian = "$tjam:$tmnt:$tdtk";


$loop = mysql_query("select * from cbt_paketsoal where XStatusSoal ='Y' and XKodeSoal = '$_REQUEST[txt_kodesoal]'");
while($s = mysql_fetch_array($loop)){
$val_jumsoal = $s['XJumSoal'];
$val_pilganda = $s['XPilGanda'];
$val_esai = $s['XEsai'];

	$sqlubah = mysql_num_rows(mysql_query("select * from cbt_ujian where XKodeSoal = '$_REQUEST[txt_kodesoal]' and  XKodeUjian = '$_REQUEST[txt_ujian]' and 
	XSemester = '$_REQUEST[txt_semester]' and XKodeKelas = '$s[XKodeKelas]' and XKodeJurusan = '$s[XKodeJurusan]' and 
	XKodeMapel = '$s[XKodeMapel]' and XSetId = '$_COOKIE[beetahun]' "));

$jumsoal = mysql_num_rows(mysql_query("select * from cbt_soal where  XKodeSoal = '$_REQUEST[txt_kodesoal]'"));
$val_banksoal =  "$jumsoal"; 


if($val_jumsoal==0){$ambilsoal = $val_banksoal;} 
elseif($val_jumsoal>$val_banksoal){$ambilsoal = $val_banksoal;} 
else {$ambilsoal = $val_jumsoal;}


$sqls = mysql_query("select u.*,m.*,u.Urut as Urutan,u.XKodeKelas as kokel from cbt_ujian u left join cbt_mapel m on m.XKodeMapel = u.XKodeMapel 
left join cbt_paketsoal p on p.XKodeSoal = u.XKodeSoal where u.XStatusUjian='1'");
								while($ss = mysql_fetch_array($sqls)){ 
$time1 = "$ss[XJamUjian]";
$time2 = "$ss[XLamaUjian]";

$secs = strtotime($time2)-strtotime("00:00:00");
$jamhabis = date("H:i:s",strtotime($time1)+$secs);	
$sekarang = date("H:i:s");	
$tglsekarang = date("Y-m-d");	
$tglujian = "$ss[XTglUjian]";	
		}
	
$sqlcek = mysql_num_rows(mysql_query("select * from cbt_ujian where XTokenUjian = '$_REQUEST[txt_token]'"));
	if($sqlcek>0){echo "<div class='alert alert-danger alert-dismissable' id='ndelik'>Simpan data dagal token sudah ada.</div>     ";
	} else {
				$sqlinsert = mysql_query("insert into cbt_ujian 						  
				(XKodeKelas,XKodeUjian,XSemester,XKodeJurusan,XJumPilihan,XAcakSoal,XKodeMapel,XTampil,
				 XTokenUjian,XTglUjian,XJamUjian,XLamaUjian,XBatasMasuk,XJumSoal
				,XKodeSoal,XStatusUjian,XGuru,XSetId,XSesi,XPilGanda,XEsai,XLambat,XStatusToken,XPdf,XFilePdf,XListening) values 		
				('$s[XKodeKelas]','$_REQUEST[txt_ujian]','$_REQUEST[txt_semester]','$s[XKodeJurusan]','$s[XJumPilihan]',
				'$s[XAcakSoal]','$s[XKodeMapel]','$_REQUEST[txt_hasil]','$_REQUEST[txt_token]','$tgl','$jam','$jame','$jamet','$ambilsoal',
				'$s[XKodeSoal]','1','$s[XGuru]','$_COOKIE[beetahun]','$_REQUEST[txt_sesi]','$val_pilganda','$val_esai','$xlambat',
				'$_REQUEST[txt_statustoken]','$_REQUEST[txt_pdf]','$_REQUEST[txt_filepdf]','$_REQUEST[txt_listen]')");
				echo "<div class='alert alert-success alert-dismissable' id='ndelik'>
                               Data berhasil disimpan 
                            </div>     ";

	}
}
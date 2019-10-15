<?php 
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}
include "../../config/server.php";

$hasil = mysql_query("select *, u.XStatusUjian as ujsta from cbt_siswa s left join cbt_siswa_ujian u on u.XNomerUjian = s.XNomerUjian left join cbt_ujian c on (u.XKodeSoal = c.XKodeSoal and u.XTokenUjian = c.XTokenUjian) left join cbt_paketsoal p on (u.XKodeSoal = c.XKodeSoal and u.XTokenUjian = c.XTokenUjian) where c.XKodeSoal = '$_REQUEST[soal]' and p.XKodeSoal = '$_REQUEST[soal]' and u.XNomerUjian = '$_REQUEST[siswa]' and c.XTokenUjian = '$_REQUEST[token]'");

$baris = 4;
$no = 0;

while($p = mysql_fetch_array($hasil)) {
	$var_token 	= $p['XTokenUjian'];
	$var_soal	= $p['XKodeSoal'];
	$var_mapel 	= $p['XKodeMapel'];
	$var_jumsoal = $p['XJumSoal'];
	$var_pil	= $p['XPilGanda'];
	$var_esai	= $p['XEsai'];
	$per_pil	= $p['XPersenPil'];
	$per_esai	= $p['XPersenEsai'];
	$tglujian	= $p['XTglUjian'];
}

$var_siswa = $_REQUEST['siswa'];

$sqlujian = mysql_query("select * from cbt_jawaban j left join cbt_soal s on s.XNomerSoal = j.XNomerSoal where j.XKodeSoal = '$var_soal' and j.XUserJawab = '$var_siswa' and XTokenUjian = '$_REQUEST[token]'");
$sqlmapel = mysql_query("select * from cbt_ujian c left join cbt_mapel m on m.XKodeMapel = c.XKodeMapel where c.XKodeSoal = '$var_soal'");
$u = mysql_fetch_array($sqlmapel);
$namamapel = $u['XNamaMapel'];
$kodemapel = $u['XKodeMapel'];

$sqlsiswa = mysql_query("select * from `cbt_siswa` where XNomerUjian= '$var_siswa'");
$s = mysql_fetch_array($sqlsiswa);
$namsis = $s['XNamaSiswa'];
$namkel = $s['XNamaKelas'];
$namjur = $s['XKodeJurusan'];
$grup = "$s[XKodeKelas] - $s[XKodeJurusan]";
$nomsis = $s['XNIK'];

$no = $no +1;
$sqldijawab = mysql_num_rows(mysql_query(" SELECT * FROM `cbt_jawaban` WHERE XKodeSoal = '$var_soal' and XUserJawab = '$var_siswa' and XJawaban != '' and XTokenUjian = '$var_token'"));
$sqljumlah = mysql_query("select sum(XNilaiEsai) as hasil from cbt_jawaban where XKodeSoal = '$var_soal' and XUserJawab = '$var_siswa' and XTokenUjian = '$var_token'");
$o = mysql_fetch_array($sqljumlah);

$nilai_esai = round($o['hasil'],2);
$sqljawaban = mysql_query("SELECT count( XNilai ) AS HasilUjian FROM `cbt_jawaban` WHERE XKodeSoal = '$var_soal' and XUserJawab = '$_REQUEST[siswa]' and XNilai = '1' and XTokenUjian = '$var_token'");
	$sqj = mysql_fetch_array($sqljawaban);
	$jumbenar = $sqj['HasilUjian'];
	$hasil_pil = $jumbenar;	
	$nilai_pil = round((($jumbenar/$var_pil)*$per_pil),2);		
	$total_pil = $nilai_pil;	
	$tot_pil = number_format($total_pil,2,',','.');	

$sqljawaban = mysql_query("SELECT sum( XNilaiEsai ) AS HasilEsai FROM `cbt_jawaban` WHERE XKodeSoal = '$var_soal' and XUserJawab = '$_REQUEST[siswa]' and XJenisSoal = '2' and XTokenUjian = '$var_token'");
	$sqj = mysql_fetch_array($sqljawaban);
	if($var_esai<1){$total_esai = 0; $hasil_esai = 0; $nilai_esai = 0;} else {
	$hasil_esai = $sqj['HasilEsai'];
	$nilai_esai = round(($hasil_esai*($per_esai/100)),2);	
	//$total_esai = round(($nilai_esai/$per_esai)*100,2);	
	$total_esai = $nilai_esai;	
	$tot_esai = round($nilai_esai,2);	
	}

	$total_nilai = number_format(($total_pil+$total_esai),2,',','.');
	

$var_soal = "$_REQUEST[soal]";
$var_siswa = "$_REQUEST[siswa]";

//Soal Pilihan Ganda
$sqlsoal = mysql_num_rows(mysql_query("select * from cbt_soal where XKodeSoal = '$var_soal' and XJenisSoal = '1'")); 
$sqltampil = mysql_query("select * from cbt_ujian where XKodeSoal = '$var_soal'"); 
$t1 = mysql_fetch_array($sqltampil);
$t = $t1['XPilGanda'];

$sqlbenar = mysql_query("select * from cbt_nilai where XKodeSoal = '$var_soal' and XNomerUjian = '$var_siswa' and XTokenUjian = '$var_token'"); 
$b1 = mysql_fetch_array($sqlbenar);
$b = $b1['XBenar'];

if($t > $sqlsoal){$jumsoal = $sqlsoal;} else {$jumsoal = $t;}
$nilai = ($b/$jumsoal)*100;
$nilaine = number_format($nilai, 2, ',', '.');

$xtokenujian = $var_token;
$sqlujian = mysql_query("select * from cbt_ujian c left join cbt_mapel m on m.XKodeMapel = c.XKodeMapel where c.XKodeSoal = '$var_soal' and c.XTokenUjian = '$var_token'"); 
$u = mysql_fetch_array($sqlujian);
$namamapel = $u['XNamaMapel'];
$kodeujian = $u['XKodeUjian'];

if($kodeujian == "UH"){ $kodeujian = "Harian";} 
elseif($kodeujian == "UTS"){ $kodeujian = "UTS";} 
elseif($kodeujian == "UAS"){ $kodeujian = "UAS";} 
else {$kodeujian = "TRY OUT";}
//$xtokenujian = $u['XTokenUjian'];

$nom = 1;			
$betul = 0;					

$sqljur = mysql_query("SELECT * FROM `cbt_siswa` WHERE XNomerUjian= '$var_siswa' ");
$sjur = mysql_fetch_array($sqljur);
$kojur = $sjur['XKodeJurusan'];

$sqlsiswa = mysql_query("SELECT * FROM `cbt_siswa` s left join cbt_kelas k on k.XKodeKelas = s.XKodeKelas WHERE XNomerUjian= '$var_siswa'");
$s = mysql_fetch_array($sqlsiswa);
$namsis = $s['XNamaSiswa'];
$kokel = $s['XKodeKelas'];
$nomsis = $s['XNIK'];
$namjur = $s['XKodeJurusan'];
$fotsis = $s['XFoto'];
$var_sesi = $s['XSesi'];
	
if(str_replace(" ","",$fotsis)==""){
$foto = "nouser.png";} else { $foto = "$fotsis";}

$sqlad = mysql_query("select * from cbt_admin");
$ad = mysql_fetch_array($sqlad);
$tingkat=$ad['XTingkat'];
if ($tingkat=="MA" or $tingkat=="SMA" or $tingkat=="SMK"  ){$rombel="Jurusan";}else{$rombel="Rombel";}
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Data peserta ujian
      </div>
      <div class="card-body">
      	 <table border="0" width="100%">                              
           <tr>
              <td rowspan="6" width="150px"><img src="../../foto_siswa/<?= $foto; ?>" width="100px" /></td></td>
              <td width="30%">Nomer Ujian </td><td width="40%">: <?= "$var_siswa ($xtokenujian | Sesi $var_sesi)"; ?></td>  
            </tr>
            <tr><td>Nomer Induk Siswa(NIS)</td><td>: <?= $nomsis; ?></td></tr>
            <tr><td>Nama Lengkap </td><td>: <?= $namsis; ?></td></tr>
            <tr><td>Kelas - <?= $rombel; ?> </td><td>: <?= "$kokel - $kojur   $namkel"; ?></td></tr>
            <tr><td>Mata Pelajaran</td><td>: <?= $namamapel; ?></td></tr>
            <tr><td>Tgl Pelaksanaan</td><td>: <?= $tglujian; ?></td></tr>
        </table>   
      </div>
    </div>
  </div>
  <div class="col-lg-12">
  	<div class="card">
  		<div class="card-header">
  			Nilai Ujian:
  		</div>
  		<div class="card-body">
  			<h2><?= $total_nilai; ?></h2>
  		</div>
  		<div class="card-footer">
  			Ujian : <?= $kodeujian; ?>
  		</div>
  	</div>
  </div>
  <div class="col-lg-12">
  	<div class="card">
  		<div class="card-header">
  			Prolehan nilai siswa
  		</div>
  		<div class="card-body">
  			<table width="100%" border="0">
  				<tr>
  					<th>Hasil pilihan ganda</th>
  					<th>Hasil soal esai</th>
  					<th>Nilai pilihan ganda</th>
  					<th>Nilai soal esai</th>
  					<th>Nilai akhir</th>
  				</tr>	
				<tr>
					<td><?= $hasil_pil; ?></td>
					<td><?= $hasil_esai; ?></td>
					<td><?= $nilai_pil; ?></td>
					<td><?= $nilai_esai; ?></td>
					<td><?= $total_nilai; ?></td>
				</tr>
			</table>
  		</div>
  	</div>
  </div>
  <div class="col-lg-12">
  	<div class="card">
  		<div class="card-header">
  			Hasil CBT siswa : soal pilihan ganda
  		</div>
  		<div class="card-body">
  			<table class="table table-bordered">
			<?php
			$nomer = 1;
			$sql = mysql_query("
			SELECT * FROM `cbt_jawaban` j left join cbt_soal s on s.XNomerSoal = j.XNomerSoal 
			left join cbt_ujian u on (u.XKodeSoal = s.XKodeSoal and u.XTokenUjian = j.XTokenUjian)
			WHERE j.XKodeSoal = '$var_soal' and  s.XKodeSoal = '$var_soal' and  j.XUserJawab = '$var_siswa' 
			and j.XJenisSoal = '1' and j.XTokenUjian = '$xtokenujian' order by j.Urut");


			while($r = mysql_fetch_array($sql)){
			$jumpil = $r['XJumPilihan'];

echo "<tr><td width=50px>$nomer.</td><td colspan=2>$r[XTanya] </td></tr>
<tr><td width=50px colspan=3>&nbsp;</td></tr>
";

	if(str_replace("  ","",$r['XGambarTanya']!=="")){
		echo "<tr><td width=50px colspan=3>&nbsp; </td></tr> <tr><td colspan=3><img src=../../../pictures/$r[XGambarTanya] width=50%></td></tr>";}
		echo "<tr><td width=50px colspan=3>&nbsp;</td></tr>";

	$PilA = $r['XA'];
	$PilJwb = "XJawab$PilA";
	$GbrJwb = "XGambarJawab$PilJwb";	
	$FileGbr = "XGambarJawab$PilA";	
	if($r[$FileGbr]==""){$GbrJwb=""; $lebar = "width=0px";}else{$GbrJwb = "<img src='../../../pictures/$r[$FileGbr]' width=80px>"; $lebar = "width=90px";}	
	echo "<tr><td width=50px align=center> A. </td>"; 
	$sqlpil = mysql_query("SELECT $PilJwb as pilsoal FROM `cbt_soal` WHERE XKodeSoal = '$var_soal' and XNomerSoal = '$r[XNomerSoal]'");
	$jwb = mysql_fetch_array($sqlpil);
	$jawab = $jwb['pilsoal'];
	echo "<td $lebar>$GbrJwb</td><td>$jawab</td></tr>";

	$PilB = $r['XB'];
	$PilJwb = "XJawab$PilB";
	$GbrJwb = "XGambarJawab$PilJwb";	
	$FileGbr = "XGambarJawab$PilB";	
	if($r[$FileGbr]==""){$GbrJwb=""; $lebar = "width=0px";}else{$GbrJwb = "<img src='../../../pictures/$r[$FileGbr]' width=80px>"; $lebar = "width=90px";}	
	echo "<tr><td width=50px align=center> B. </td>"; 
	$sqlpil = mysql_query("SELECT $PilJwb as pilsoal FROM `cbt_soal` WHERE XKodeSoal = '$var_soal' and XNomerSoal = '$r[XNomerSoal]'");
	$jwb = mysql_fetch_array($sqlpil);
	$jawab = $jwb['pilsoal'];
	echo "<td  $lebar>$GbrJwb</td><td>$jawab</td></tr>";	

	$PilC = $r['XC'];
	$PilJwb = "XJawab$PilC";
	$GbrJwb = "XGambarJawab$PilJwb";
	$FileGbr = "XGambarJawab$PilC";	
	if($r[$FileGbr]==""){$GbrJwb=""; $lebar = "width=0px";}else{$GbrJwb = "<img src='../../../pictures/$r[$FileGbr]' width=80px>"; $lebar = "width=90px";}	
	echo "<tr><td width=50px align=center> C. </td>"; 
		$sqlpil = mysql_query("SELECT $PilJwb as pilsoal FROM `cbt_soal` WHERE XKodeSoal = '$var_soal' and XNomerSoal = '$r[XNomerSoal]'");
		$jwb = mysql_fetch_array($sqlpil);
		$jawab = $jwb['pilsoal'];
	echo "<td $lebar>$GbrJwb</td><td>$jawab</td></tr>";	

	if($jumpil>3){
	$PilD = $r['XD'];
	$PilJwb = "XJawab$PilD";
	$GbrJwb = "XGambarJawab$PilJwb";
	$FileGbr = "XGambarJawab$PilD";	
	if($r[$FileGbr]==""){$GbrJwb=""; $lebar = "width=0px";}else{$GbrJwb = "<img src='../../../pictures/$r[$FileGbr]' width=80px>"; $lebar = "width=90px";}	
	echo "<tr><td width=50px align=center> D. </td>"; 
		$sqlpil = mysql_query("SELECT $PilJwb as pilsoal FROM `cbt_soal` WHERE XKodeSoal = '$var_soal' and XNomerSoal = '$r[XNomerSoal]'");
		$jwb = mysql_fetch_array($sqlpil);
		$jawab = $jwb['pilsoal'];
	echo "<td $lebar>$GbrJwb</td><td>$jawab</td></tr>";
	}
	if($jumpil>4){	
	$PilE = $r['XE'];
	$PilJwb = "XJawab$PilE";
	$GbrJwb = "XGambarJawab$PilJwb";
	$FileGbr = "XGambarJawab$PilE";	
	if($r[$FileGbr]==""){$GbrJwb=""; $lebar = "width=0px";}else{$GbrJwb = "<img src='../../../pictures/$r[$FileGbr]' width=80px>"; $lebar = "width=90px";}	
	echo "<tr><td width=50px align=center> E. </td>"; 
		$sqlpil = mysql_query("SELECT $PilJwb as pilsoal FROM `cbt_soal` WHERE XKodeSoal = '$var_soal' and XNomerSoal = '$r[XNomerSoal]'");
		$jwb = mysql_fetch_array($sqlpil);
		$jawab = $jwb['pilsoal'];
	echo "<td $lebar>$GbrJwb</td><td>$jawab</td></tr>";
	}

	if($r['XKunciJawaban']==$r['XA']){$jwbsiswa = "A";}
	elseif($r['XKunciJawaban']==$r['XB']){$jwbsiswa = "B";}	
	elseif($r['XKunciJawaban']==$r['XC']){$jwbsiswa = "C";}
	elseif($r['XKunciJawaban']==$r['XD']){$jwbsiswa = "D";}	
	elseif($r['XKunciJawaban']==$r['XE']){$jwbsiswa = "E";}
	else{$jwbsiswa = "S";}
	
	if($jwbsiswa==$r['XJawaban']){$ikon = "../../images/benar.gif"; $betul++;}else{$ikon = "../../images/salah.gif";}
echo "<tr><td colspan=3><br>Kunci Jawaban : $jwbsiswa, Jawaban Siswa : $r[XJawaban]&nbsp; &nbsp;  <img src=$ikon width=30px></td></tr>";	
echo "<tr><td colspan=3><hr></td></tr>";


$nomer++;


}
$var_soal = "$_REQUEST[soal]";
$var_siswa = "$_REQUEST[siswa]";
?>    </div>
    </div>
</table> 
  		</div>
  	</div>
  </div>
</div>
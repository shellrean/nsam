<?php
include "config/server.php"; 

if(isset($_COOKIE['PESERTA'])){
  $user = $_COOKIE['PESERTA'];
} else {
  header('Location:login.php');
}

$tgl = date("H:i:s");
$tgl2 = date("Y-m-d");

$sqltoken = mysql_query("SELECT * FROM `cbt_siswa_ujian` s left join cbt_ujian u on u.XKodeSoal = s.XKodeSoal WHERE s.XNomerUjian = '$user' and s.XStatusUjian = '1'");

$st = mysql_fetch_array($sqltoken);
$xtokenujian = $st['XTokenUjian'];

$sqlgabung = mysql_query("SELECT * FROM `cbt_siswa_ujian` s LEFT JOIN cbt_jawaban j ON j.XUserJawab = s.XNomerUjian and j.XTokenUjian = s.XTokenUjian left join cbt_siswa s1 on s1.XNomerUjian = s.XNomerUjian WHERE s.XNomerUjian = '$user' and s.XStatusUjian = '1'");


$s0 = mysql_fetch_array($sqlgabung);
$xkodesoal = $s0['XKodeSoal'];
$xtokenujian = $s0['XTokenUjian'];  
$xnomerujian = $s0['XNomerUjian'];  
$xnik = $s0['XNIK'];    
$xkodeujian = $s0['XKodeUjian'];
$xkodemapel = $s0['XKodeMapel'];
$xkodekelas = $s0['XKodeKelas'];  
$xkodejurusan = $s0['XKodeJurusan'];    
$xsemester = $s0['XSemester'];      
$xnamkel = $s0['XNamaKelas'];

$sqlsoal = mysql_query("SELECT * FROM cbt_ujian  WHERE XKodeSoal = '$xkodesoal'");
$sa = mysql_fetch_array($sqlsoal);

$xjumsoal = $sa['XJumSoal'];
$xjumpil = $sa['XPilGanda'];  
$xtampil = $sa['XTampil'];

$sql4 = mysql_query("SELECT * FROM cbt_mapel  WHERE XKodeMapel = '$xkodemapel'");
$km = mysql_fetch_array($sql4);
$kkm = $km['XKKM'];


if($xjumsoal>0){
  $sqlnilai = mysql_query(" SELECT * FROM cbt_paketsoal WHERE XKodeSoal = '$xkodesoal'");
  $sqn = mysql_fetch_array($sqlnilai);
  $per_pil = $sqn['XPersenPil'];  
  $per_esai = $sqn['XPersenEsai'];
  $xesai = $sqn['XEsai'];
  $xpilganda = $sqn['XPilGanda'];
  $sqltahun = mysql_query("select * from cbt_setid where XStatus = '1'");
  $st = mysql_fetch_array($sqltahun);
  $tahunz = $st['XKodeAY'];

  $xjumbenarz = mysql_query("select count(XNilai) as benar from cbt_jawaban where XUserJawab = '$user' and XJenisSoal = '1' and XKodeSoal = '$xkodesoal' and XTokenUjian = '$xtokenujian' and XNilai = '1'");
  $r = mysql_fetch_array($xjumbenarz);
  $xjumbenar = $r['benar'];
  $xjumsalah = $xjumpil-$xjumbenar;
  $nilaix = ($xjumbenar/$xjumpil)*100;
  if(isset($_COOKIE['beetahun'])){$setAY =$_COOKIE['beetahun'];}else{$setAY = "$tahunz";}

  $sqlceknilai= mysql_num_rows(mysql_query("select * from cbt_nilai where XNomerUjian = '$xnomerujian' and XKodeSoal = '$xkodesoal' and XTokenUjian = '$xtokenujian' and XSemester = '$xsemester' and XSetId = '$setAY' and XKodeMapel = '$xkodemapel' and XNIK = '$xnik'"));

  if($sqlceknilai>0){
    $sqlmasuk = mysql_query("update cbt_nilai set XJumSoal='$xjumsoal',XBenar='$xjumbenar',XSalah='$xjumsalah',XNilai='$nilaix',XTotalNilai=,'$nilaix' where XNomerUjian = '$xnomerujian' and XKodeSoal = '$xkodesoal' and XTokenUjian = '$xtokenujian' and XSemester = '$xsemester' and XSetId = '$setAY' and XKodeMapel = '$xkodemapel' and XNIK = '$xnik'");
  } else {
    $sqlmasuk = mysql_query("insert into cbt_nilai (XKodeUjian,XTokenUjian,XTgl,XJumSoal,XBenar,XSalah,XNilai,XKodeMapel,XKodeKelas,XKodeSoal,XNomerUjian,XNIK,XSemester,XSetId,XPersenPil,XPersenEsai,XTotalNilai,XPilGanda,XEsai,XNamaKelas) values ('$xkodeujian','$xtokenujian','$tgl2','$xjumsoal','$xjumbenar','$xjumsalah','$nilaix','$xkodemapel','$xkodekelas','$xkodesoal','$xnomerujian','$xnik','$xsemester','$setAY','$per_pil','$per_esai','$nilaix','$xpilganda','$xesai','$xnamkel')");
  }
          
  if(isset($xtokenujian)){
    $sql = mysql_query("Update cbt_siswa_ujian set XStatusUjian = '9' where XNomerUjian = '$user' and XStatusUjian = '1'  and XTokenUjian = '$xtokenujian'");
  }
    
  $sql = mysql_query("Update cbt_siswa_ujian set XStatusUjian = '9',XLastUpdate = '$tgl' where XNomerUjian = '$user' and XStatusUjian = '1'");
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Applikasi untuk memonitor sekolah">
    <meta name="author" content="Kuswandi">
    <link rel="shortcut icon" href="images/logo-dki.png" type="image/x-icon">
 
    <title><?= $skull ?> </title>
    <!-- Icons-->
    <link href="node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

    
    <!-- Main styles for this application-->
    <link href="panel/css/style.css" rel="stylesheet">
    
    <!-- Script Section -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/pace-progress/pace.min.js"></script>
    <script src="node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>

    <?php 
		$sqllogin = mysql_query("SELECT * FROM  `cbt_siswa` WHERE XNomerUjian = '$user'");
		 $sis = mysql_fetch_array($sqllogin);
		 
		  $xkodekelas = $sis['XKodeKelas'];
		  $xnamkelas = $sis['XNamaKelas'];
		  $xjurz = $sis['XKodeJurusan'];
		  $val_siswa = $sis['XNamaSiswa'];
		  $poto = $sis['XFoto'];  
		  
		  if($poto==''){
			  $gambar="avatar.gif";
		  } else{
			  $gambar=$poto;
		  } 
		?>
  </head>
  <body>
  	<header style="background-color: #32679C;" class="headers">
      <div class="group">
        <div class="left py-2 px-2">
          <img src="images/logo-dki.png " width="75px">
        </div>
        <div class="right">
          <table width="100%" border="0" style="margin-top:10px">   
            <tr><td rowspan="3" width="120px" align="center"><img src="foto_siswa/<?= "$gambar"; ?>" class="foto"></td></tr>
            <tr><td><span class="user"><?= $val_siswa.'<br>('.$xkodekelas.'-'.$xjurz.' | '.$xnamkelas.')'; ?></span></td></tr>
            <tr><td><span class="user">Jangan lupa do'a</span></td></tr>
          </table>
        </div>
      </div>
    </header>
    <div class="container">
  	<div class="row">
  		<div class="col-md-6">
  			<div class="card mt-5">
  				<div class="card-header">
  					Konfirmasi data peserta
  				</div>
  				<div class="card-body">
  					<p>	Terimakasih telah berpartisipasi dalam tes
					<br>	<?php 	if($xtampil=='1'){ ?>
					<br>	<font class="text-danger">
					<?php echo 	"Nilai pilihan ganda non esai" 
					?>
					<br>	<font size="2" class="text-primary">
					<?php	
					echo " KKM : ".$kkm."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Benar : ".$xjumbenar."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salah: ".$xjumsalah."</Font>"; 
					?>
					<br>
					<br>	<font size="7" color="blue">
					<?php
					echo " Nilai : ".$nilaix."</br></Font>";
					}
					?>
                                   
                    </p>
  				</div>
  				<div class="card-footer">
					<a href="logout.php">
                       <button type="submit" class="btn btn-success btn-block" data-dismiss="modal">LOGOUT</button>
                    </a>
  				</div>
  			</div>
  		</div>
  	</div>
  	</div>

  </body>
</html>
<?php 
include "config/server.php";

include "config/ip.php";
$tglbuat = date("Y-m-d");
$sqlcekdb = mysql_query("SELECT * FROM `cbt_siswa` limit 1");
if (!$sqlcekdb){header('Location:login.php?salah=2');}
 
if(isset($_COOKIE['PESERTA'])&&isset($_COOKIE['KUNCI'])){
	$user = "$_COOKIE[PESERTA]"; 
	$pass = "$_COOKIE[KUNCI]";
	$txtuser = $user;
	$txtpass = $pass; } 
else {	
	$txtuser = str_replace(" ","",$_REQUEST['UserName']);
	$txtpass = str_replace(" ","",$_REQUEST['Password']);
	setcookie('PESERTA',$txtuser);
	setcookie('KUNCI',$txtpass);
	$user = "$txtuser";
	$pass = "$txtpass";}

$sqllogin = mysql_query("SELECT * FROM  `cbt_siswa` WHERE XNomerUjian = '$txtuser' and XPassword = '$txtpass'");

$sis = mysql_fetch_array($sqllogin);
$val_siswa = $sis['XNamaSiswa'];
$xjeniskelamin= $sis['XJenisKelamin']; 
$xkelz = $sis['XKodeKelas'];
$xjurz = $sis['XKodeJurusan'];
$xnamkel = $sis['XNamaKelas'];  
$xsesi = $sis['XSesi']; 
$poto = $sis['XFoto'];  

if($poto==''){$gambar="avatar.gif";} else {$gambar=$poto;} 
if($xjeniskelamin=="L"){$jekel = "LAKI-LAKI";} else {$jekel = "PEREMPUAN";}
$jmlsqllogin = mysql_num_rows($sqllogin);
if($jmlsqllogin<1){ header('Location:login.php?salah=1&jumlah='.$jmlsqllogin); }
$tglujian = date("Y-m-d");
$xjam1 = date("H:i:s");

$sqluser = mysql_query("
	SELECT u.*,m.XNamaMapel FROM `cbt_ujian` u LEFT JOIN cbt_paketsoal p on p.XKodeKelas = u.XKodeKelas and p.XKodeMapel = u.XKodeMapel
	left join cbt_mapel m on u.XKodeMapel = m.XKodeMapel 
	WHERE (u.XKodeKelas = '$xkelz' or u.XKodeKelas = 'ALL') and (u.XKodeJurusan = '$xjurz' or u.XKodeJurusan = 'ALL') and u.XTglUjian = '$tglujian' and u.XJamUjian <= '$xjam1'
	and u.XStatusUjian = '1'");

	$s = mysql_fetch_array($sqluser);
	$xkodesoal = $s['XKodeSoal'];
	$xkodekelas = $s['XKodeKelas'];
	$xkodejurusan = $s['XKodeJurusan'];
	$xtglujian = $s['XTglUjian'];  
	$xkodemapel = $s['XKodeMapel'];
	$xjumlahsoal = $s['XJumSoal'];
	$xtokenujian = $s['XTokenUjian'];  
	$xlamaujian= $s['XLamaUjian'];
	$xjamujian= $s['XJamUjian'];    
	$xbatasmasuk= $s['XBatasMasuk'];   
	$xnamamapel = $s['XNamaMapel'];
	$xstatustoken = $s['XStatusToken'];
  
  
$sqlada0 = mysql_query("SELECT * FROM  `cbt_siswa_ujian` WHERE XNomerUjian = '$txtuser' and XTokenUjian = '$xtokenujian'");
	$ad0 = mysql_fetch_array($sqlada0);
	$user_ip2 = str_replace(" ","",$ad0['XGetIP']);
	$user_ip1 = $user_ip;
 
if($user_ip1<>$user_ip2&&!$user_ip2==""){header('Location:login.php?salah=3');}
  
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


  </head>

  <body>
  	<header style="background-color: #32679C;" class="headers">
  	  <div class="group">
  	  	<div class="left py-2 px-2">
  	  		<img src="images/logo-dki.png " width="75px">
  	  	</div>
  	  	<div class="right">
  	  		<table width="100%" border="0" style="margin-top:10px">   
     			<tr><td rowspan="3" width="120px" align="center"><img src="foto_siswa/<?= "$gambar"; ?>" class="foto"></td>
				<tr><td><span class="user"><?= $val_siswa.'<br>('.$xkelz.'-'.$xjurz.')'; ?></span></td></tr>
				<tr><td><span class="log"><a href="logout.php">Logout</a></span></td></tr>
			</table>
  	  	</div>
  	  </div>
  	</header>
  	<div class="container">
  	<div class="row">
  		<div class="col-md-6">
  			<div class="card mt-5">
  				<form action="mulai.php" method="post">
  				<div class="card-header">
  					Konfirmasi data peserta
  				</div>
  				<div class="card-body">
  					<?php 	
						if(isset($_REQUEST['salah'])){if($_REQUEST['salah']==1) {?>
  					<div id="myerror" class="alert alert-danger rounded-0" role="alert">
						<?php echo "Kode TOKEN Tidak sesuai"; ?>
					</div>
					<?php } } ?>
  				  <div class="form-group row">
				    <label class="col-sm-3 col-form-label">Kode peserta</label>
				    <div class="col-sm-9">
				      <input type="text" readonly class="form-control-plaintext"  value="<?= $user; ?>">
				      <input id="KodeNik" name="KodeNik" type="hidden" value="<?= "$user"; ?>">
				    </div>
				  </div>
				  <div class="form-group row">
				  	<label class="col-sm-3 col-form-label">Status peserta</label>
				  	<div class="col-sm-9">
				  		<input type="text" readonly class="form-control-plaintext" value="<?= $val_siswa.'('.$xkelz.'-'.$xjurz.'|'.$xnamkel.')' ?>">
				  		<input id="NamaPeserta" name="NamaPeserta" type="hidden" value="glyphicon-warning-sign">
				  	</div>
				  </div>
				  <div class="form-group row">
				  	<label class="col-sm-3 col-form-label">Jenis kelamin </label>
				  	<div class="col-sm-9">
				  		<input type="text" readonly class="form-control-plaintext" value="<?= $jekel; ?>">
				  		<input id="Gender" name="Gender" type="hidden" value="Pria">
				  	</div>
				  </div>

				  <?php
				  	$sqlada = mysql_query("select * from cbt_siswa_ujian where XNomerUjian = '$txtuser' and XTokenUjian='$xtokenujian'");
				  	$ad = mysql_fetch_array($sqlada);
				  	$jumsis = $ad['XStatusUjian'];
				  	$ada = mysql_num_rows($sqlada);

				  	$sqlt = mysql_query("SELECT * FROM  `cbt_ujian` where XKodeSoal ='$xkodesoal'and (XKodeKelas = '$xkelz' or XKodeKelas = 'ALL') and (XKodeJurusan = '$xjurz' or XKodeJurusan = 'ALL') and XStatusUjian = '1' and (XSesi =  '$xsesi' or XSesi = 'ALL') and XTglUjian = '$tglbuat' ") ;
					$ttt = mysql_fetch_array($sqlt);
					$xbatasmasuk = $ttt['XBatasMasuk'];
					$xtokuj = $ttt['XTokenUjian'];

					$sqlcekujian = mysql_num_rows(mysql_query("SELECT * FROM cbt_ujian where(XKodeKelas = '$xkelz' or XKodeKelas = 'ALL') and (XKodeJurusan = '$xjurz' or XKodeJurusan = 'ALL') and XStatusUjian = '1' and (XSesi =  '$xsesi' or XSesi = 'ALL')"));
					if($sqlcekujian>0){ ?>
				  
				  <div class="form-group row">
				  	<label class="col-sm-3 col-form-label">Mata pelajaran</label>
				  	<div class="col-sm-9">
				  		<input type="text" readonly class="form-control-plaintext" value="<?= $xnamamapel; ?>">
				  		<input id="KodePaket" name="KodePaket" type="hidden" value="IPA - SMP">
				  	</div>
				  </div>
				  <?php if(($xjam1<=$xbatasmasuk&&$xjam1>=$xjamujian)&&($tglujian==$xtglujian)&&($jumsis!=='9')){	?>    
				  <div class="form-group row">
				  	<label class="col-sm-3 col-form-label">TOKEN</label>
				  	<div class="col-sm-9">
				  		<input autocomplete="off" class="input-token form-control rounded-0 field-xs" data-val="true" data-val-required="Kode token wajib diisi" id="KodeToken" maxlength="20" name="KodeToken" placeholder="masukan token" type="text" value="">
				  		Token anda: [<span><b><?php if ($xstatustoken==1) {echo "$xtokuj";} 
					else {echo "Minta dari Proktor";}?></b></span>]
					<button type="submit" class="btn btn-success rounded-0 btn-block doblockui">SUBMIT</button>
				  	</div>
				  </div>
				  <?php } else { ?>
				  	<div class="form-group row">
				  		<label class="col-sm-3 col-form-label">Status ujian</label>
				  		<div class="col-sm-9">
				  			<?php if($jumsis=='9'){ ?>
		                    <input type="text" readonly class="form-control-plaintext" value="Status Tes sudah SELESAI">
		                    <?php } elseif($xjam1<$xjamujian||$tglujian!==$xtglujian){ ?>
		                    <input type="text" readonly class="form-control-plaintext" value="Tidak Ada Jadwal Ujian">
		                    <?php } elseif($xjam1>=$xjamujian&&$xjam1>$xbatasmasuk){ ?>
		                    <input type="text" readonly class="form-control-plaintext" value="Terlambat Untuk Mengikuti Ujian">
		                    <?php } ?>
				  		</div>
				  	</div>
				  <?php } ?>

				  <?php } else { ?>
				  	<div class="form-group row">
				  		<label class="col-sm-3 col-form-label">Status ujian</label>
				  		<div class="col-sm-9">
				  			<input type="text" readonly class="form-control-plaintext" value="Tidak ada mata ujian AKTIF">
				  		</div>
				  	</div>
				  <?php } ?>
  				</div>
  				</form>
  			</div>
  		</div>
  	</div>
  	</div>
  	<div class="fixed-bottom">
	 	<div style="margin-top:0px; bottom:50px; background-color:#dcdcdc; padding:7px; font-size:12px">
	    	<div class="content">
		 	<strong> NSAM-CBT v1.0</strong><br>
		 	<strong> SystemAppData</strong>
	    	</div>
		</div>
	 	<footer class="bg-dark text-center py-2">
			&copy; 2019, Shellrean Support by CV Bisma Cipta Solusi
		</footer>
 	</div>
  </body>
 </html>

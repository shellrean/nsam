<?php include "config/server.php";
if(isset($_COOKIE['PESERTA'])){
//echo "WAHA ";
}
if(isset($_REQUEST['KodeNik'])){
 $txtuser = str_replace(" ","",$_REQUEST['KodeNik']);
 
 $sqllogin = mysql_query("SELECT * FROM  `cbt_siswa` WHERE XNomerUjian = '$txtuser'");
 $sis = mysql_fetch_array($sqllogin);
  $val_siswa = $sis['XNamaSiswa'];
  $xjeniskelamin= $sis['XJenisKelamin']; 
  $xkelz = $sis['XKodeKelas'];
  $xjurz = $sis['XKodeJurusan'];
  $poto = $sis['XFoto'];  
  $xnamkel = $sis['XNamaKelas']; 
  
  if($poto==''){
	  $gambar="avatar.gif";
  } else{
	  $gambar=$poto;
  } 
  if($xjeniskelamin=="L"){$jekel = "LAKI-LAKI";} else {$jekel = "PEREMPUAN";}

   $tglujian = date("Y-m-d");
 $xjam1 = date("H:i:s");
 $user = "$_COOKIE[PESERTA]";

  $sqluser = mysql_query("SELECT u.*,m.XNamaMapel FROM `cbt_ujian` u LEFT JOIN cbt_paketsoal p on p.XKodeKelas = u.XKodeKelas and p.XKodeMapel = u.XKodeMapel
left join cbt_mapel m on u.XKodeMapel = m.XKodeMapel WHERE (u.XKodeKelas = '$xkelz' or u.XKodeKelas = 'ALL') and (u.XKodeJurusan = '$xjurz' or u.XKodeJurusan = 'ALL')   and u.XTglUjian = '$tglujian' and u.XJamUjian <= '$xjam1'
and u.XStatusUjian = '1'");


  $s = mysql_fetch_array($sqluser);
  $xkodesoal = $s['XKodeSoal'];
  $xkodekelas = $s['XKodeKelas'];
  $xtglujian = $s['XTglUjian'];  
  $xkodemapel = $s['XKodeMapel'];
  $xjumlahsoal = $s['XJumSoal'];
  $xtokenujian = $s['XTokenUjian'];  
  $xlamaujian= $s['XLamaUjian'];
  $xjamujian= $s['XJamUjian'];    
  $xbatasmasuk= $s['XBatasMasuk'];   
  $xnamamapel = $s['XNamaMapel'];
  $xkodejurusan = $s['XKodeJurusan'];
    
 if($_REQUEST['KodeToken']!==$xtokenujian){
header('Location:konfirm.php?salah=1');
 echo "Token Salah";
 } 
}

if(isset($xkodesoalz)){ echo "SELECT *,s.XKodeKelas as kelassiswa,u.XKodeSoal as kelsoal FROM  `cbt_siswa` s LEFT JOIN cbt_ujian u ON s.XKodeKelas =  
  u.XKodeKelas
  left join cbt_mapel m on  m.XKodeMapel = u.XKodeMapel
  WHERE XNomerUjian = '$user' and u.XStatusUjian = '1'"; }

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
    <link rel="shortcut icon" href="images/nsam.png" type="image/x-icon">
 
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
          <img src="images/logo.png " width="150px">
        </div>
        <div class="right">
          <table width="100%" border="0" style="margin-top:10px">   
            <tr><td rowspan="3" width="120px" align="center"><img src="foto_siswa/<?= "$gambar"; ?>" class="foto"></td></tr>
            <tr><td><span class="user"><?= $val_siswa.'<br>('.$xkelz.'-'.$xjurz.')'; ?></span></td></tr>
            <tr><td><span class="log"><a href="logout.php">Logout</a></span></td></tr>
          </table>
        </div>
      </div>
    </header>
    <div class="container">
    <div class="row">
      <div class="col-md-8">
        <div class="card mt-5">
          <div class="kiri">
          <form action="started.php" method="post"> 
            <div class="card-header">
              <h4>Konfirmasi data tes </h4>
            </div>
            <div class="card-body">
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Kode tes</label>
                <div class="col-sm-9">
                  <input type="text" readonly class="form-control-plaintext"  value="<?php if(isset($xkodesoal)){ echo "$xkodesoal"; } ?>">
                  <input id="KodeNik" name="KodeNik" type="hidden" value="<?php echo "$user"; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Status peserta</label>
                <div class="col-sm-9">
                  <input type="text" readonly class="form-control-plaintext"  value="<?= $val_siswa.'('.$xkodekelas.'-'.$xjurz.'|'.$xnamkel.')'; ?>">
                  <input id="NamaPeserta" name="NamaPeserta" type="hidden" value="">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Mata Uji Tes  -  Token</label>
                <div class="col-sm-9">
                  <input type="text" readonly class="form-control-plaintext"  value="<?= $xnamamapel.'-['.$xtokenujian.']' ?>">
                  <input id="Gender" name="Gender" type="hidden" value="Pria">
                </div>
              </div>

            <?php 
            $sqlcekujian = mysql_num_rows(mysql_query("SELECT * FROM cbt_ujian where XKodeKelas = '$xkodekelas' and XStatusUjian = '1'"));
            if($sqlcekujian>0){ 
            $xtglujian0 = strtotime($xtglujian);
            $xtglujian1 = date('d/m/Y', $xtglujian0);
            $xtglujian2 = date('d/M/Y', $xtglujian0);
            $j1 = substr($xlamaujian,0,2)*60;
            $m1 = substr($xlamaujian,3,2);
            $jumtotwaktu = $j1+$m1;
      
            ?>
            <div class="form-group row">
                <label class="col-sm-3 col-form-label">Tanggal tes</label>
                <div class="col-sm-9">
                  <input type="text" readonly class="form-control-plaintext"  value="<?= $xtglujian2; ?>">
                  <input id="KodePaket" name="KodePaket" type="hidden" value="IPA - SMP">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Waktu tes dibuka</label>
                <div class="col-sm-9">
                  <input type="text" readonly class="form-control-plaintext"  value="<?= $xjamujian.'-'.$xbatasmasuk; ?>">
                </div>
              </div>
              <div class="form-group row">
                <label class="col-sm-3 col-form-label">Alokasi waktu tes</label>
                <div class="col-sm-9">
                  <input type="text" readonly class="form-control-plaintext"  value="<?= $jumtotwaktu.' menit'; ?>">
                </div>
              </div>
            <?php } ?>
          </div>
        </form>
      </div>
      </div>
    </div>
      <div class="col-md-4">
        <div class="card mt-5">
          <div class="card-body">
    <div id="myerror" class="alert alert-warning" role="alert" style="font-size: 13px; font-style:normal; font-weight:normal">
      <i class="glyphicon glyphicon-warning-sign"></i>  
      <font size="3px">Tombol MULAI hanya akan aktif apabila waktu sekarang sudah melewati waktu mulai tes. Tekan tombol F5 untuk merefresh halaman</font>
      </div><a href=ujian.php><button type="submit" class="btn btn-danger btn-block doblockui">MULAI</button></a>

</div>
          </div>
        </div>
      </div>



            </form>
</div>

<div class="kanan">


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

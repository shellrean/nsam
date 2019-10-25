<?php
if(!isset($_COOKIE['beeuser'])){
	header('Location: login.php');
}
 
include "../../config/server.php";

$skul_pic	= $log['XLogo'];
$admpic		= $log['XPicAdmin']; 
$skul_ban	= $log['XBanner'];  
$skul_tkt	= $log['XTingkat']; 
$skul_warna	= $log['XWarna']; 
$skul_adm	= strtoupper($log['XAdmin']); 

$status_server = 1; 

if ($zo == "Asia/Jakarta"){$w ="WIB";} elseif($zo == "Asia/Makassar"){$w ="WITA";} else{$w ="WIT";}

if(isset($_REQUEST['simpan5'])){
	$sql 		= mysql_query("update cbt_server set XServer='$_REQUEST[server1]' where id = '1'");
	$sqlzona 	= mysql_query("update cbt_zona set XZona='$_REQUEST[zona1]'");
	$sqlheader 	= mysql_query("update cbt_header set Header='$_REQUEST[header]', HeaderUjian='$_REQUEST[headerujian]', XNilaiKelas='$_REQUEST[nilaikelas]', HakAkses='$_REQUEST[hakakses]'");
}

if(isset($_REQUEST['simpan_bd'])) {
	$teks0	= $_REQUEST['db_server'];
	$teks1	= "<?php ";
	$teks2	= "\$db_server=\"";
	$teks3	= "\";";

	$db_server = $teks1.$teks2.$teks3;

	$file	= fopen("../../config/db_server.php","w");
	if($file) {
		fputs($file,$db_server);
	}
	fclose($file);
	header("Location: logout.php");
}

$xadm5	= mysql_fetch_array(mysql_query("select * from cbt_server"));
$xserver= $xadm5['XServer'];

if(mysql_query("select * from cbt_zona LIMIT 1") == TRUE) {
	$hdr = mysql_fetch_array(mysql_query("select * from cbt_header"));
	$header = $hdr['Header'];

	if(mysql_query("select * from cbt_sync LIMIT 1") == TRUE) {
		$headerujian 	= $hdr['HeaderUjian'];
		$nilaikelas 	= $hdr['XNilaiKelas'];
		$hakakses 		= $hdr['HakAkses'];
	} 
	else {
		$headerujian = 0;
		$nilaikelas  = 0;
		$hakakses    = 0;
	}
}
else {
	$header 		= 0;	
	$headerujian 	= 0;
	$nilaikelas 	= 0;
	$hakakses 		= 0;
}

$srv = php_uname("n");
if (!$sqlconn) {
	$status_server = '0';
	die('Could not connect: '.mysql_error());
}
$a = mysql_get_server_info();
$b = substr($a, 0, strpos($a, "-"));
$b = str_replace(".","",$b);

if ($_COOKIE['beelogin'] == 'siswa') {
	$res 	= mysql_fetch_array(mysql_query("select * from cbt_siswa WHERE XNomorUjian = '$_COOKIE[beeuser]'"));
	$poto 	= $res['XFoto'];
	$nama 	= $res['XNamaSiswa'];
	$loginx = "3";
}
else {
	$re 	= mysql_fetch_array(mysql_query("select * from cbt_user WHERE Username='$_COOKIE[beeuser]'"));
	$poto	= $re['XPoto'];
	$loginx	= $re['login'];
	$nama 	= $re['Nama'];
}


/** Breadcrumb section **/


$tgljam		= date('d/m/Y H:i');
$tgl   		= date('d/m/Y');
if ($mode == "lokal") {
	$tmode	= "Mode Server Pusat";
}
else {
	$tmode 	= "Mode Server Lokal";
}

$Dd 	= date("D");
if ($Dd=="Sun"){$hari="Minggu";}
else if ($Dd=="Mon"){$hari="Senin, ";}
else if ($Dd=="Tue"){$hari="Selasa, ";}
else if ($Dd=="Wed"){$hari="Rabu, ";}
else if ($Dd=="Thu"){$hari="Kamis, ";}
else if ($Dd=="Fri"){$hari="Jum'at, ";}
else if ($Dd=="Sat"){$hari="Sabtu, ";}
else {$hari=$Dd;}

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
    <link rel="shortcut icon" href="../../images/logo3.png" type="image/x-icon">
 
    <title><?= $skull ?> </title>
    <!-- Icons-->
    <link href="../../node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="../../node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="../../node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../../node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <link href="../vendors/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

    
    <!-- Main styles for this application-->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendors/pace-progress/css/pace.min.css" rel="stylesheet">


    <!-- Script Section -->
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../node_modules/pace-progress/pace.min.js"></script>
    <script src="../../node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="../../node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>

     <!-- Datatable & Bootstrap -->
    <script src="../vendors/datatables/jquery.dataTables.min.js"></script>
    <script src="../vendors/datatables/dataTables.reload.js"></script>
    <script src="../vendors/datatables/dataTables.bootstrap4.min.js"></script>
    
    <script src="../js/app.js"></script>

  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    <header class="app-header navbar">
      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="../../images/logo3.png" width="70" alt="Logo Brand DKI">
        <img class="navbar-brand-minimized" src="../../images/logo3.png" width="30" alt="Logo Brand DKI">
      </a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
          <a class="nav-link" href="#"><?php echo $hari; echo date('d M Y'); ?></a>
        </li>
      </ul>
      <ul class="nav navbar-nav ml-auto">
        <li class="nav-item dropdown">
          <a class="nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
            <img class="img-avatar" src="../../images/avatars/default.png" alt="wandinak17@gmail.com">
          </a>
          <div class="dropdown-menu dropdown-menu-right">
            <div class="dropdown-header text-center">
              <strong>Account</strong>
            </div>
            <a class="dropdown-item" href="#">
              <i class="fa fa-envelope-o"></i> Messages
              <span class="badge badge-success">42</span>
            </a>
            <a class="dropdown-item" href="logout.php">
              <i class="fa fa-lock"></i> Logout</a>
          </div>
        </li>
      </ul>
      <button class="navbar-toggler aside-menu-toggler d-md-down-none" type="button" data-toggle="aside-menu-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <button class="navbar-toggler aside-menu-toggler d-lg-none" type="button" data-toggle="aside-menu-show">
        <span class="navbar-toggler-icon"></span>
      </button>
    </header>
    <div class="app-body">
      <div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="?">
                <i class="nav-icon icon-speedometer"></i> Dashboard
              </a>
            </li>
            <li class="nav-title">Utama</li>
            <?php if($loginx == "1"): ?>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-layers"></i> System Server</a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="#" data-toggle="modal" data-target="#myServer">
                    <i class="nav-icon icon-arrow-right"></i> Setting Server</a>
                </li>
                <?php if($xserver == "lokal"): ?>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=data_skul">
                    <i class="nav-icon icon-arrow-right"></i> Sekolah Klien</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=set_server">
                    <i class="nav-icon icon-arrow-right"></i> Setting Server Pusat</a>
                </li>
            	<?php endif; ?>
                <li class="nav-item">
                  <a class="nav-link" href="#" data-toggle="modal" data-target="#db_server">
                    <i class="nav-icon icon-arrow-right"></i> Ubah db/Install Baru</a>
                </li>
              </ul>
            </li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-book-open"></i>
                Data sekolah
              </a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="?modul=info_skul">
                    <i class="nav-icon icon-arrow-right"></i>
                    Identitas sekolah
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=data_user">
                    <i class="nav-icon icon-arrow-right"></i>
                    Manajemen user
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=backup">
                    <i class="nav-icon icon-arrow-right"></i>
                    Backup & Restore
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-notebook"></i>
                Administrasi
              </a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="?modul=daftar_kelas">
                    <i class="nav-icon icon-arrow-right"></i>
                    Daftar kelas
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=daftar_mapel">
                    <i class="nav-icon icon-arrow-right"></i>
                    Mata pelajaran
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=daftar_siswa">
                    <i class="nav-icon icon-arrow-right"></i>
                    Daftar siswa
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-briefcase"></i>
                Bank soal
              </a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="?modul=daftar_soal">
                    <i class="nav-icon icon-arrow-right"></i>
                    Banksoal
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=file_pendukung">
                    <i class="nav-icon icon-arrow-right"></i>
                    File pendukung soal
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-clock"></i>
                Status ujian
              </a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="?modul=daftar_tesbaru">
                    <i class="nav-icon icon-arrow-right"></i>
                    Settting ujian
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=aktifkan_jadwaltes">
                    <i class="nav-icon icon-arrow-right"></i>
                    Jadwal ujian
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=daftar_waktu">
                    <i class="nav-icon icon-arrow-right"></i>
                    Edit setting ujian
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=daftar_waktu_db">
                    <i class="nav-icon icon-arrow-right"></i>
                    Database ujian
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-printer"></i>
                Cetak
              </a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" data-toggle="modal" data-target="#myDaftarHadir">
                    <i class="nav-icon icon-arrow-right"></i>
                    Daftar hadir
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=berita_acara">
                    <i class="nav-icon icon-arrow-right"></i>
                    Berita acara
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="#" data-toggle="modal" data-target="#myCetakHasil">
                    <i class="nav-icon icon-arrow-right"></i>
                    Daftar nilai
                  </a>
                </li>
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?modul=daftar_peserta">
                <i class="nav-icon icon-user"></i> Status peserta
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?modul=aktifkan_jadwaltes">
                <i class="nav-icon icon-refresh"></i> Reset login peserta
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?modul=analisasoal">
                <i class="nav-icon icon-pie-chart"></i> Analisa
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php">
                <i class="nav-icon icon-logout"></i> Logout
              </a>
            </li>
        	  <?php endif; ?>
            <?php if ($loginx == "2"): ?>
              <li class="nav-item">
                <a class="nav-link" href="?modul=edit_biodata">
                  <i class="nav-icon icon-user"></i> Edit biodata
                </a>
              </li>
              <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-printer"></i>
                Bank soal
              </a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="?modul=daftar_soal">
                    <i class="nav-icon icon-arrow-right"></i>
                    Bank soal
                  </a>
                </li>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=upl_files">
                    <i class="nav-icon icon-arrow-right"></i>
                    File pendukug soal
                  </a>
                </li>
                <!-- <li class="nav-item">
                  <a class="nav-link" href="?modul=upl_tugas">
                    <i class="nav-icon icon-arrow-right"></i>
                    Upload nilai tugas
                  </a>
                </li> -->
              </ul>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="?modul=analisasoal">
                <i class="nav-icon icon-pie-chart"></i> Analisa
              </a>
            </li>
            <?php endif; ?>
          </ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
      </div>
      <main class="main">
        <!-- Breadcrumb-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">Home</li>
        </ol>
        <div class="container-fluid">
          <div class="animated fadeIn">
            <?php
            	if(isset($_REQUEST['modul']) == "") {include "none.php"; }


              /** 1**/
              elseif($_REQUEST['modul'] == "data_skul") {include "daftar/daftar_sekolah.php"; }
              elseif($_REQUEST['modul'] == "set_server") {include "set_server.php";}
              elseif($_REQUEST['modul'] == "sinkron" || $_REQUEST['modul'] == 'sinkronsatu'){include "sinkron.php";}


              /** 2 **/
              elseif($_REQUEST['modul'] == "info_skul") {include "sekolah/upl_skul.php"; }
              elseif($_REQUEST['modul'] == "data_user") {include "daftar/daftar_user.php"; }
              elseif($_REQUEST['modul'] == "upl_user" || $_REQUEST['modul'] == "uploaduser"){include "upload/upload_user.php";}
              elseif($_REQUEST['modul'] == 'backup'){include "tools/backup.php"; }

              /** 3 **/
              elseif($_REQUEST['modul'] == 'daftar_kelas') {include "daftar/daftar_kelas.php";}
              elseif($_REQUEST['modul'] == 'upl_kelas' || $_REQUEST['modul'] == 'uploadkelas'){include "upload/upload_kelas.php";}
              elseif($_REQUEST['modul'] == 'daftar_mapel'){include "daftar/daftar_mapel.php";}
              elseif($_REQUEST['modul'] == 'upl_mapel' || $_REQUEST['modul'] == 'uploadmapel') {include "upload/upload_mapel.php";}
              elseif($_REQUEST['modul'] == 'daftar_siswa') {include "daftar/daftar_siswa.php";}
              elseif($_REQUEST['modul'] == 'upl_siswa' || $_REQUEST['modul'] == 'uploadsiswa') {include "upload/upload_siswa.php";}
              elseif($_REQUEST['modul'] == 'upl_foto'){include "upload/upload_foto.php";}
              elseif($_REQUEST['modul'] == 'cetak_kartu'){include "tools/cetak_kartu.php";}

              /** 4 **/
              elseif($_REQUEST['modul'] == 'daftar_soal'){include "daftar/daftar_soal.php";}
              elseif($_REQUEST['modul'] == 'cetak_banksoal'){include "daftar/cetak_banksoal.php";}
              elseif($_REQUEST['modul'] == 'edit_soal'){include "daftar/edit_daftar_soal.php";}
              elseif($_REQUEST['modul'] == 'edit_soal_esai'){include "soal/bank_soal.php";}
              elseif($_REQUEST['modul']=="tambah_soal"){
                if($_REQUEST['jum']==5){include "soal/tambah_soal5.php";}
                elseif($_REQUEST['jum']==4){include "soal/tambah_soal4.php";}
                elseif($_REQUEST['jum']==3){include "soal/tambah_soal3.php";}
                elseif($_REQUEST['jum']==1){include "soal/tambah_soal.php";} 
              }
              elseif($_REQUEST['modul']=="edit_data_soal"){
                if($_REQUEST['jum']==5){include "soal/bank_soal5.php";}
                elseif($_REQUEST['jum']==4){include "soal/bank_soal4.php";}
                elseif($_REQUEST['jum']==3){include "soal/bank_soal3.php";}
                elseif($_REQUEST['jum']==1){include "soal/bank_soal.php";} 
              }
              elseif($_REQUEST['modul'] == 'file_pendukung'){include "soal/gambar.php";}
              elseif($_REQUEST['modul'] == 'upl_soal' ||$_REQUEST['modul']=="uploadsoal"){include "soal/upload_soal.php";}
              elseif($_REQUEST['modul'] == 'upl_filesoal'){ include "soal/upload_file.php";}           

              /** 6 **/
              elseif($_REQUEST['modul'] == "daftar_tesbaru"){include "daftar/daftar_tesbaru.php";}
              elseif($_REQUEST['modul'] == "edit_tes"){include "daftar/edit_tes.php";}
              elseif($_REQUEST['modul'] == "aktifkan_jadwaltes"){include "daftar/daftar_tes.php";}
              elseif($_REQUEST['modul'] == "daftar_waktu"){include "daftar/daftar_waktu.php";}
              elseif($_REQUEST['modul'] == "daftar_waktu_db"){include "daftar/daftar_waktu_db.php";}

              /** 7 **/
              elseif($_REQUEST['modul'] == "daftar_peserta"){include "daftar/daftarpeserta.php";}
              elseif($_REQUEST['modul'] == "reset_peserta"){include "tools/resetpeserta.php";}
              
              /** 8 **/
              elseif($_REQUEST['modul'] == "analisasoal"){include "soal/analisa_soal.php";}
              elseif($_REQUEST['modul'] == "analisajawaban"){include "soal/analisa_jawaban.php";}  
              elseif($_REQUEST['modul'] == "jawabansiswa"){include "soal/jawabansiswa.php";}
              elseif($_REQUEST['modul'] == "lks"){include "soal/lks.php";}
              elseif($_REQUEST['modul'] == "berita_acara"){include "soal/berita_acara.php";}
              elseif($_REQUEST['modul'] == "cetak_berita"){include "soal/cetak_berita.php";}
              elseif($_REQUEST['modul']=="cetak_hasil"){include "tools/cetak_hasil_ujian.php";} 

              elseif($_REQUEST['modul'] == "upl_files"){include "soal/upload_files.php";}
              elseif($_REQUEST['modul'] == "edit_biodata"){include "edit_biodata.php";}
            ?>
          </div> 
        </div>
      </main>
      <aside class="aside-menu">
        <!-- Tab panes-->
        <div class="tab-content">
          <div class="tab-pane active" id="timeline" role="tabpanel">
            <div class="list-group list-group-accent">
              <div class="list-group-item list-group-item-accent-secondary bg-light text-center font-weight-bold text-muted text-uppercase small">Hari ini</div>
              <div class="list-group-item list-group-item-accent-warning list-group-item-divider">
                <div>Meeting with
                  <strong>Lucas</strong>
                </div>
                <small class="text-muted mr-3">
                  <i class="icon-calendar"></i>  1 - 3pm</small>
                <small class="text-muted">
                  <i class="icon-location-pin"></i>  Palo Alto, CA</small>
              </div>
              <div class="list-group-item list-group-item-accent-info">
                <div>Skype with
                  <strong>Megan</strong>
                </div>
                <small class="text-muted mr-3">
                  <i class="icon-calendar"></i>  4 - 5pm</small>
                <small class="text-muted">
                  <i class="icon-social-skype"></i>  On-line</small>
              </div>
            </div>
          </div>
        </div>
      </aside>
    </div>
    <footer class="app-footer">
      <div>
        <a href="#">NSam-CBT</a>
        <span>&copy; 2019 Shellrean.</span>
      </div>
    </footer>

  <!-- Modal mode server -->
  <div class="modal fade" id="myServer" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="?&simpan5=yes" method="post" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Mode server</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <select class="form-control" id="server1" name="server1">
              <option value='lokal' <?php if ($mode=="lokal") {echo "selected";} ?>>Mode server pusat </option>
              <option value='pusat' <?php if ($mode=="pusat") {echo "selected";} ?>>Mode server lokal </option>
            </select>
          </div>
          <input type="hidden" name="zona1" value="Asia/Jakarta">
          <input type="hidden" name="hakakses" value="1">
          <input type="hidden" name="nilaikelas" value="0">
          <input type="hidden" name="headerujian" value="0">
          <input type="hidden" name="header" value="0">
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="tambah-simpan" class="btn btn-success">Simpan</button>
        </div>
    </div>
    </form>
  </div>
  </div>

<div class="modal fade" id="myCetakHasil" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Hasil ujian ujian</h5>
        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
          <span aria-hiden="true">x</span>
        </button>
      </div>
      <form action="?modul=cetak_hasil" method="post">
      <div class="modal-body">
        <div class="inner-content">
          <div class="wysiwyg-content">
          <p>
            <table width="100%">
              <tr height="40px"><td>Jenis Tes</td><td>: &nbsp;&nbsp;<td>                                  
                <select class="form-control" id="tes3"  name="tes3">
                  <?php $sqk = mysql_query("select * from cbt_tes");
                    echo "<option value='ALL' selected>SEMUA</option>"; 
                    while($rs = mysql_fetch_array($sqk)){echo "<option value=$rs[XKodeUjian]>$rs[XNamaUjian]</option>";}              
                  ?>  
                </select>
                </td>
              </tr>        
              <tr height="40px"><td width="30%">Semester</td><td>:<td>  
                <select class="form-control" id="sem3"  name="sem3">
                  <option class="form-control" value="1">SEMUA</option>
                  <option value=1>Ganjil</option>; 
                  <option value=2>Genap</option>; 
                </select>
                </td>
              </tr>
              <tr height="40px"><td><?php echo $rombel;?> </td><td>:<td>                                  
                <select class="form-control" id="jur3"  name="jur3">
                  <?php $sqk = mysql_query("select * from cbt_kelas group by XKodeJurusan");
                  while($rs = mysql_fetch_array($sqk)){echo "<option value='$rs[XKodeJurusan]'>$rs[XKodeJurusan]</option>";} 
                  ?>                                
                </select>
                </td>
              </tr> 
              <tr height="40px"><td width="30%">Kelas </td><td>:<td>  
                <select class="form-control" id="iki3"  name="iki3">
                  <?php $sqk = mysql_query("select * from cbt_kelas group by XKodeKelas");
                  while($rs = mysql_fetch_array($sqk)){echo "<option value='$rs[XKodeKelas]'>$rs[XKodeKelas]</option>";}
                  ?>                                
                </select>
                </td>
              </tr>
              <tr height="40px"><td>Mata Pelajaran </td><td>:<td>                               
                <select class="form-control" id="map3"  name="map3">
                  <?php $sqk = mysql_query("select * from cbt_mapel");
                  while($rs = mysql_fetch_array($sqk)){echo "<option value='$rs[XKodeMapel]'>$rs[XKodeMapel] - $rs[XNamaMapel]</option>";} 
                  ?>                                
                </select>
                </td>
              </tr> 
            </table>
          </p>
        </div>
      </div>
      </div>
      <div class="card-footer">
        <button type="submit" class="btn btn-primary btn-sm"><i class="glyphicon glyphicon-print"></i> Print preview</button>
        <button type="submit" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="glyphicon glyphicon-minus-sign"></i> Tutup</button>
      </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Database Server  -->
  <div class="modal fade" id="db_server" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="?&simpan_bd=yes" method="post" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Install database server baru</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>Ubah db/install db baru</label>
            <input type="text" class="form-control" name="db_server" value='<?= $db ?>'>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" id="tambah-simpan" class="btn btn-success">Simpan</button>
        </div>
    </div>
    </form>
  </div>
  </div>



<div class="modal fade" id="myDaftarHadir" role="dialog">
  <div class="modal-dialog">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title">Daftar hadir</h5>
    </div>
    <div class="modal-body">
      <form action="?modul=cetak_absensi" method="post">
        <table width="100%">
          <tr height="30px">
            <td><?php echo $rombel;?> </td><td>: &nbsp;&nbsp;<td>                          
              <select class="form-control" id="jur1"  name="jur1">
              <?php
              $sqk = mysql_query("select * from cbt_kelas group by XKodeJurusan");
              while($rs = mysql_fetch_array($sqk)){echo "<option value='$rs[XKodeJurusan]'>$rs[XKodeJurusan]</option>";} 
              ?>                                
              </select>
            </td>
          </tr> 
          <tr height="30px">
            <td width="30%">Kelas </td><td>: <td>
              <select class="form-control" id="iki1"  name="iki1">
              <?php   
              $sqk = mysql_query("select * from cbt_kelas group by XKodeKelas");
              while($rs = mysql_fetch_array($sqk)){
              echo "<option value='$rs[XKodeKelas]'>$rs[XKodeKelas]</option>";} 
              ?>                                
              </select>
            </td>
          </tr>
          <tr height="30px">
            <td width="30%">Sesi </td><td>: <td>
              <select class="form-control" id="sesi1"  name="sesi1">
              <?php 
              $sqk = mysql_query("select * from cbt_siswa group by XSesi");
              while($rs = mysql_fetch_array($sqk)){echo "<option value='$rs[XSesi]'>$rs[XSesi]</option>";} 
              ?>                                
              </select>
            </td>
          </tr> 
          <tr height="30px">
            <td width="30%">Ruang </td><td>: <td>
            <select class="form-control" id="ruang1"  name="ruang1">
            <?php 
            $sqk = mysql_query("select * from cbt_siswa group by XRuang");
            while($rs = mysql_fetch_array($sqk)){echo "<option value='$rs[XRuang]'>$rs[XRuang]</option>";} 
            ?>                                
            </select>
            </td>
          </tr>          
          <tr height="30px">
            <td width="30%">Mata Pelajaran </td><td>: <td>
            <select class="form-control" id="mapel1"  name="mapel1">
            <?php
            $sqk = mysql_query("select * from cbt_mapel group by XKodeMapel");
            while($rs = mysql_fetch_array($sqk)){echo "<option value='$rs[XNamaMapel]'>$rs[XKodeMapel] - $rs[XNamaMapel]</option>";} 
            ?>                              
            </select>
            </td>
          </tr>
          <tr height="30px">
            <td width="30%">Tanggal </td><td>: <td>
              <input class="form-control" id="tanggal1" name="tanggal1" type="text"/>
              <?php $tanggal1 = !empty($_POST['tanggal1']) ? $_POST['tanggal1'] : ''; ?> 
              <tr height="30px">
                <td width="30%">Jam Mulai </td><td>: <td>
                <input class="form-control" id="mulai1" name="mulai1" type="text"/>
                <?php $mulai1 = !empty($_POST['mulai1']) ? $_POST['mulai1'] : ''; ?> 
                </td>
              </tr>
              <tr height="30px"><td width="30%">Jam Selesai </td><td>: <td>
              <input class="form-control" id="akhir1" name="akhir1" type="text"/>
              <?php $akhir1 = !empty($_POST['akhir1']) ? $_POST['akhir1'] : ''; ?> 
                </td>
              </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="submit" class="btn btn-primary btn-sm">
        <i class="icon-printer"></i> Print Preview</button>
        <button type="submit" class="btn btn-secondary btn-sm" data-dismiss="modal">Tutup</button>
    </div>
    </form>
  </div>
</div>

  </body>
</html>

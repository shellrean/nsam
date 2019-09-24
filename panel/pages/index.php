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
    <link rel="shortcut icon" href="../../images/logo-dki.png" type="image/x-icon">
 
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
    <link href="../vendors/toastr/toastr.css" rel="stylesheet" type="text/css">


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
    
    <script src="../vendors/toastr/toastr.min.js"></script>
    <script src="../js/app.js"></script>

  </head>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    <header class="app-header navbar">
      <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" type="button" data-toggle="sidebar-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <a class="navbar-brand" href="#">
        <img class="navbar-brand-full" src="../../images/logo-dki.png" width="40" alt="Logo Brand DKI">
        <img class="navbar-brand-minimized" src="../../images/logo-dki.png" width="30" alt="Logo Brand DKI">
      </a>
      <button class="navbar-toggler sidebar-toggler d-md-down-none" type="button" data-toggle="sidebar-lg-show">
        <span class="navbar-toggler-icon"></span>
      </button>
      <ul class="nav navbar-nav d-md-down-none">
        <li class="nav-item px-3">
          <a class="nav-link" href="#">Dashboard</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="#">Users</a>
        </li>
        <li class="nav-item px-3">
          <a class="nav-link" href="#">Settings</a>
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
                <span class="badge badge-primary">Default</span>
              </a>
            </li>
            <li class="nav-title">Utama</li>
            <?php if($loginx == "1"): ?>
            <li class="nav-item nav-dropdown">
              <a class="nav-link nav-dropdown-toggle" href="#">
                <i class="nav-icon icon-cursor"></i> System Server</a>
              <ul class="nav-dropdown-items">
                <li class="nav-item">
                  <a class="nav-link" href="#" data-toggle="modal" data-target="#myServer">
                    <i class="nav-icon icon-cursor"></i> Setting Server</a>
                </li>
                <?php if($xserver == "lokal"): ?>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=data_skul">
                    <i class="nav-icon icon-cursor"></i> Sekolah Klien</a>
                </li>
                <?php else: ?>
                <li class="nav-item">
                  <a class="nav-link" href="?modul=set_server">
                    <i class="nav-icon icon-cursor"></i> Setting Server Pusat</a>
                </li>
            	<?php endif; ?>
                <li class="nav-item">
                  <a class="nav-link" href="#" data-toggle="modal" data-target="#db_server">
                    <i class="nav-icon icon-cursor"></i> Ubah db/Install Baru</a>
                </li>
              </ul>
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
        <a href="#">Shellrean</a>
        <span>&copy; 2019 Kuswandi.</span>
      </div>
      <div class="ml-auto">
        <span>Support</span>
        <a href="#">ICT43</a>
      </div>
    </footer>

  </body>
</html>

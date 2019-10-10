

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
            <tr><td><span class="user"><?= $val_siswa.'<br>('.$kodekelas.'-'.$kodejurusan.')'; ?></span></td></tr>
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
					<br>	<font color="red">
					<?php echo 	"Nilai Pilihan Ganda Non Esai" 
					?>
					<br>	<font size="2" color="blue">
					<?php	
					echo " KKM : ".$kkm."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Benar : ".$xjumbenar."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Salah: ".$xjumsalah."</Font>"; 
					?>
					<br>
					<br>	<font size="7" color="blue"><
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
<?php
include "../../config/server.php";

if (mysql_query("select * from cbt_zona LIMIT 1") == true) {
	if ($val == true) {
		$skullogin	= $log['XLogin'];
		$email		= $log['XEmail'];
		$web		= $log['XWeb'];
		$alamat		= $log['XAlamat'];
		$tlp		= $log['XTelp'];
		$h1			= $log['XH1'];
		$h2			= $log['XH2'];
		$h3			= $log['XH3'];
		$cbt_header	= mysql_query('select * from cbt_header');
		$ch 		= mysql_fetch_array($cbt_header);

		if (mysql_query("select * from cbt_sync LIMIT 1") == true) {
			$hakakses	= $ch['HakAkses'];
			$loginpanel	= $ch['LoginPanel'];
		}
		else {
			$hakakses 	= 0;
			$loginpanel = 0;
		}
	}
	else {
		$skull 		= "UJIAN BERBASIS KOMPUTER";
		$skullogin	= "pertama.png";
		$web		= "www.tuwagapat.com";
		$tlp		= "0000-00000";
		$h1			= "UJIAN BERBASIS KOMPUTER";
		$h2			= "BEESMART EDUCATION PARTNER";
		$h3			= "BEESMART-CBT Login";	
		$hakakses 	= "0";
		$loginpanel = "0";
	}
}
else {
	if($val == TRUE){
		$skullogin	= $log['XLogin'];
		$email		= $log['XEmail'];
		$web		= $log['XWeb'];
		$alamat		= $log['XAlamat'];
		$tlp		= $log['XTelp'];
		$h1			= $log['XH1'];
		$h2			= $log['XH2'];
		$h3			= $log['XH3'];
		$cbt_header = mysql_query('select * from cbt_header');
		$ch 		= mysql_fetch_array($cbt_header);	
		$hakakses 	= "0";
		$loginpanel ="0";
	}
	else{
		
		$skull 		= "UJIAN BERBASIS KOMPUTER";
		$skullogin 	= "pertama.png";
		$web		= "www.tuwagapat.com";
		$tlp		= "0000-00000";
		$h1			= "UJIAN BERBASIS KOMPUTER";
		$h2			= "BEESMART EDUCATION PARTNER";
		$h3			= "BEESMART-CBT Login";	
		$hakakses 	= "0";
		$loginpanel = "0";
	}
}

if(isset($sqlconn)){} else { $pesan1 = "Tidak dapat Koneksi Database.";}
if (!$sqlconn) { die('Could not connect: '.mysql_error());}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title><?= $skull ?> | Login</title>
    <link rel="shortcut icon" href="../../images/logo-dki.png" type="image/x-icon">
    <!-- Icons-->
    <link href="../../node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="../../node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="../../node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="../../node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">
    <!-- Main styles for this application-->
    <link href="../css/style.css" rel="stylesheet">
    <link href="../vendors/pace-progress/css/pace.min.css" rel="stylesheet">
  </head>
  <body class="app flex-row align-items-center">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8">
          <div class="card-group">
            <div class="card p-4">
              <div class="card-body">
                <h1>Login</h1>
                <p class="text-muted">Masuk akun anda</p>
                <form id="loginform" name="loginform" onSubmit="return validateForm();" method="post" action="ceklogin.php">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-user"></i>
                    </span>
                  </div>
                  <input class="form-control" type="text" placeholder="Username" id="userz" name="userz" required autofocus>
                </div>
                <div class="input-group mb-4">
                  <div class="input-group-prepend">
                    <span class="input-group-text">
                      <i class="icon-lock"></i>
                    </span>
                  </div>
                  <input class="form-control" type="password" placeholder="Password" id="passz" name="passz">
                </div>
                <div class="input-group mb-4">
                	<input type="radio" id="radio_admin" name="loginz" value="admin" checked/> <label for="radio_admin">Admin</label>
					<input type="radio" id="radio_guru" name="loginz" value="guru" /> <label for="radio_guru">Guru</label>
                </div>
                <div class="row">
                  <div class="col-6">
                    <button class="btn btn-primary px-4" type="submit">Login</button>
                  </div>
                  <div class="col-6 text-right">
                    <button class="btn btn-link px-0" type="button">Lupa password?</button>
                  </div>
                </div>
                </form>
              </div>
            </div>
            <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
              <div class="card-body text-center">
                <div>
                  <img src="../../images/logo-dki.png" width="100px">
                  <p>Selamat datang di aplikasi UBK/CBT. Silahkan masukkan Username dan Password </p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- CoreUI and necessary plugins-->
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="../../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="../../node_modules/pace-progress/pace.min.js"></script>
    <script src="../../node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="../../node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>

    <script>
    	function validateForm() {
    		let x = document.forms['loginform']['userz'].value;
    		let y = document.forms['loginform']['passz'].value;

    		if (x == null || x == "" || y == null || y == "") {
    			$('#ingat').style.display = "block";
    			$('#isine').textContent = "Username dan Password harus diisi";
    			return false;
    		}
    	}
    </script>
  </body>
</html>

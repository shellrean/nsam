<?php
if(isset($_SERVER['HTTP_COOKIE'])){
	$kue = $_SERVER['HTTP_COOKIE'];
	$cookies = explode(';', $kue);
	foreach($cookies as $cookie) {
		$parts = explode('=', $cookie);
        $user = trim($parts[0]);
        setcookie($user, '', time()-1000);
        setcookie($user, '', time()-1000, '/');
		setcookie("user", '', time()-1000);
		setcookie("apl", '', time()-1000);		
    	unset($_COOKIE['user']);
    	setcookie('user', '', time() - 3600, '/'); 
	}
}

include "config/server.php";
if($val == TRUE){
$logo = $log['XLogo'];
$banner = $log['XBanner'];
$footer = $log['XSekolah'];
$warna = $log['XWarna'];
}else{ 
$banner = "banner.png"; 
$logo ="logo.gif";
$warna = "#0AF713";
if  (file_exists('./config/madipo_cbt.sql')){$footer = "MADIPO-CBT";}else{
$footer = "BeeSMART-CBT";}
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


  </head>

  <body>
  	<header style="background-color: #32679C;" class="headers">
  	  <div class="group">
  	  	<div class="left py-2 px-2">
  	  		<img src="images/logo-dki.png " width="75px">
  	  	</div>
  	  	<div class="right">
  	  		<table width="100%" border="0" style="margin-top:10px">   
     			<tr><td rowspan="3" width="120px" align="center"><img src="images/avatar.gif" style=" margin-left:0px;" class="foto" ></td>
				<td>Selamat Datang Peserta Ujian</td></tr>
				<tr><td><span class="user">Jangan Lupa Berdo'a </span></td></tr>
				<tr><td><span class="log"><a href="index.php">Logout</a><span></td></tr>
			</table>
  	  	</div>
  	</header>

  	<div class="container mt-100">
  <div class="row">
    <div class="col-3">
    </div>
    <div class="col-sm">
      <div class="card">
      	<div class="card-header">
      		<h4>Login peserta</h4>
      	</div>
      	<div class="card-body py-5">
      		<form action="konfirm.php" method="post">
			  <div class="form-group row">
			    <label for="staticEmail" class="col-sm-3 col-form-label">Username</label>
			    <div class="col-sm-9">
			      <div class="input-group mb-2 mr-sm-2">
				    <div class="input-group-prepend">
				      <div class="input-group-text rounded-0"><i class="icon-user"></i></div>
				    </div>
				    <input type="text" class="form-control rounded-0" data-val="true" data-val-required="Username wajid diisi" id="inputUsername" name="UserName" placeholder="Username" required>
				    <span class="hide error-message"><span class="field-validation-valid" data-valmsg-for="UserName" data-valmsg-replace="true"></span></span>
				  </div>
			    </div>
			  </div>
			  <div class="form-group row">
			    <label for="inputPassword" class="col-sm-3 col-form-label">Password</label>
			    <div class="col-sm-9">
			      <div class="input-group mb-2 mr-sm-2">
				    <div class="input-group-prepend">
				      <div class="input-group-text rounded-0"><i class="icon-lock"></i></div>
				    </div>
				    <input type="password" class="form-control rounded-0" data-val="true" data-val-required="Password wajdi diisi" name="Password" placeholder="Password" required>

				  </div>
			    </div>
			  </div>
			  <div class="form-group row">
			  	<label for="inputPassword" class="col-sm-3 col-form-label">&nbsp;</label>
			  	<div class="col-sm-9">
			      <button type="submit" class="btn btn-success btn-block doblockui rounded-0" >LOGIN</button>
			    </div>
			   </div>
			</form>
      	</div>
      </div>
    </div>
    <div class="col-3">
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
 

<?php
if(isset($_POST['userz'], $_POST['passz'])) {
	include "../../config/server.php";
	require "../../config/fungsi_thn.php";

	$userz 	= mysql_real_escape_string($_REQUEST['userz']);
	$passz	= mysql_real_escape_string($_REQUEST['passz']);
	$loginz	= mysql_real_escape_string($_REQUEST['loginz']);

	if($loginz == "admin") {
		$peran 	= "1";
		$pass 	= md5($passz);
	}
	else if($loginz == "guru") {
		$peran 	= "2";
		$pass 	= md5($passz);
	}
	else {
		$perean = "0";
	}


	$sqladmin	= mysql_num_rows(mysql_query("select * from cbt_user where Username = '$userz' and Password = '$pass' and login = '$peran' and Status = '1'"));

	if($sqladmin > 0) {
		$sqltahun 	= mysql_query("select * from cbt_setid where XStatus = '1'");
		$st 		= mysql_fetch_array($sqltahun);
		$tahunz		= $st['XKodeAY'];
		$sqlsekolah = mysql_query("select * from cbt_admin");
		$sk 		= mysql_fetch_array($sqlsekolah);

		setcookie('beeuser', $userz);
		setcookie('beelogin', $loginz);
		setcookie('beepassz', $passz);
		setcookie('beetahun', $tahunz);
		setcookie('beesekolah', $sk['XKodeSekolah']);

		$_COOKIE['beeuser'] 	== $userz;
		$_COOKIE['beelogin']	== $loginz;
		$_COOKIE['beepassz']	== $passz;
		$_COOKIE['beetahun']	== $tahunz;
		$_COOKIE['beesekolah']	== $sk['XKodeSekolah'];

		header("Location: ../pages/?");
	}
	else {
		header("Location: login.php");
	}
}
else {
	header("Location: login.php");
}
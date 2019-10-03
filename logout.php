<?php 
include "config/server.php"; 

$tgl = date("H:i:s");
$tgl2 = date("Y-m-d");
if(isset($_COOKIE['PESERTA'])){
$user = $_COOKIE['PESERTA'];

  $sqlgabung = mysql_query("
SELECT * FROM `cbt_siswa_ujian` s LEFT JOIN cbt_jawaban j ON j.XUserJawab = s.XNomerUjian and j.XTokenUjian = s.XTokenUjian WHERE XNomerUjian = '$user' and s.XStatusUjian = '1'
  ");
  


}

if (isset($_SERVER['HTTP_COOKIE'])) {
    $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
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


header('location:./login.php');

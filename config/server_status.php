<?php

include "ipserver.php";

$link = @mysql_connect($host_name, $user_name, $password);

if(!$link) {
	$status_konek = "0";
}
else {
	$status_konek = "1";

	mysql_select_db($database, $link) or die('<b><span class="text-danger">Server tidak terhubung ke database 
	server pusat</span><br><br>Solusi : <br>Edit koneksi database </b> >> Langkah :
<li>Klik <span class="text-info">Setting Server</span> => <span style="color: #CCA600;">Setting Server Pusat</span> => ubah nama Database, Username Db dan Password dengan tepat sesuai database Server Pusat</li>
<br><b>Edit Id/Kode Sekolah dengan tepat </b> >> Langkah :
<li> Klik <span class="text-info">Data Sekolah </span> => <span style="color: #CCA600;">Identitas Sekolah </span>=> ubah data dengan tepat sesuai data yang ada di Sever Pusat');
}

date_default_timezone_set("$zo");
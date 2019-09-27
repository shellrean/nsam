<?php

if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

include "../../config/server.php";

$folderpusat 	= $log['XFolderPusat'];
$sql			= mysql_query("select * from server_pusat");
$xadm			= mysql_fetch_array($sql);
$serverid		= $xadm['XServerId'];
$skulnam		= $xadm['XSekolah'];
$ipserver		= $xadm['XIPSekolah'];
$skulala		= $xadm['XStatus'];
$database		= $xadm['XUsername'];
$passw			= $xadm['XPass'];
$dbnama			= $xadm['XDbName'];

?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-database"></i> Setting server pusat 
      </div>
      <div class="card-body">
      	<table class="table table-bordered">
      		<tr>
      			<td width="250px">Folder server pusat</td>
      			<td><input class="form-control" type="text" id="folderpusat" value="<?= $folderpusat ?>"> </td>
      		</tr>
      		<tr>
      			<td>IP/Hostname server pusat</td>
      			<td>
      				<input type="text" class="form-control" id="ip_server" value="<?= $ipserver ?>">
      			</td>
      		</tr>
      		<tr>
      			<td>Nama database</td>
      			<td>
      				<input type="text" class="form-control" id="nama_db" value="<?= $dbnama; ?>">
      			</td>
      		</tr>
      		<tr>
      			<td>Username Db</td>
      			<td>
      				<input type="text" class="form-control" id="userm" value="<?= $database; ?>">
      			</td>
      		</tr>
      		<tr>
      			<td>Pass Db</td>
      			<td>
      				<input type="password" class="form-control" id="pas_data" value="<?= $passw; ?>">
      			</td>
      		</tr>
      	</table>
      	<button type="submit" id="simpan" class="btn btn-success">
      		Simpan
      	</button>
      </div>
      <div class="card-footer">
          <i class="icon-info text-info"></i> Pastikan konfigurasi yang dimasukan sesuai dengan server pusat <br>
          <i class="icon-info text-info"></i> Password bisa dikosongkan bila tidak ada password dalam konfigurasi server pusat
      </div>
    </div>
  </div>
</div>

<script>
	$('#simpan').click(function() {
		 var txt_nama 	= $("#namaskul").val();
		 var txt_id 	= $("#server").val();
		 var txt_ip 	= $("#ip_server").val();
		 var txt_user 	= $("#userm").val();
		 var txt_pas 	= $("#pas_data").val();
		 var txt_db 	= $("#nama_db").val();
		 var folderpusat = $("#folderpusat").val();

		 $.ajax({
		 	type: "POST",
		 	url: "set_server_ubah.php",
		 	data: "aksi=simpan&txt_ip=" + txt_ip + "&txt_user=" + txt_user + "&txt_pas=" + txt_pas + "&txt_db=" + txt_db + "&folderpusat=" + folderpusat,
		 	success(data) {
		 		alert(data);
		 	} 
		 })
	})
</script>
<?php 
if(!isset($_COOKIE['beeuser'])) {
	header('Location: login.php');
}

include "../../config/server.php";

if(isset($_REQUEST['aksi'])) {
	$sql = mysql_query("delete from cbt_user where Urut='$_REQUEST[urut]'");
}

if(isset($_REQUEST['aksi1'])) {
	$sqlcek = mysql_query("select * from cbt_user where Urut = '$_REQUEST[urut]'");
	$sta = mysql_fetch_array($sqlcek);

	$status = $sta['Status'];
	if($status == "1") {
		$ubah = "0";
	}
	elseif($status == "0") {
		$ubah = "1";
	}

	$sqlpasaif = mysql_query("update cbt_user set Status = '$ubah' where Urut = '$_REQUEST[urut]'");

	var_dump($sqlpasaif);
}

if(isset($_REQUEST['simpan'])) {
	if($_REQUEST["txt_login"] >1) {
		$pass = md5($_REQUEST['txt_pass']);
	}
	else {
		$pass = md5($_REQUEST['txt_pass']);
	}

	if($_REQUEST['txt_pass'] == "") {
		$sql = mysql_query("update cbt_user set login='$_REQUEST[txt_login]', Username = '$_REQUEST[txt_usern]', NIP = '$_REQUEST[txt_nip]', Nama = '$_REQUEST[txt_nama]', Alamat = '$_REQUEST[txt_alamt]', HP = '$_REQUEST[txt_hp]', Email= '$_REQUEST[txt_email]' where Urut='$_REQUEST[id]'");
	} else {
		$sql = mysql_query("update cbt_user set Username = '$_REQUEST[txt_usern]', Password = '$pass', NIP = '$_REQUEST[txt_nip]', 
		Nama = '$_REQUEST[txt_nama]', Alamat = '$_REQUEST[txt_alamat]', HP = '$_REQUEST[txt_hp]', Email = '$_REQUEST[txt_email]' 
		where Urut = '$_REQUEST[id]'");
	}
}

if(isset($_REQUEST['tambah'])) {
	$axx = $_REQUEST['txt_level'];

	if($axx > 1) {
		$pass = md5($_REQUEST['txt_pass']);
	}
	else {
		$pass = md5($_REQUEST['txt_pass']);
	}

	$sqlcek = mysql_num_rows(mysql_query("select * from cbt_user where Username = '$_REQUEST[txt_usern]'"));
	if($sqlcek > 0) {
		$message = "Username sudah ada";
		echo "<script>alert('$message');</script>";
	}
	else {
		if($_REQUEST['txt_usern'] == "" || $_REQUEST['txt_pass'] == "") {
			$message = "Username dan Password harus diisi";
			echo "<script>alert('$message');</script>";
		}
		else {
			$sql = mysql_query("insert into cbt_user (Username, Password, NIP, Nama, Alamat, HP, Email, login, Status, XPoto) values ('$_REQUEST[txt_usern]', '$pass', '$_REQUEST[txt_nip]', '$_REQUEST[txt_nama]','$_REQUEST[txt_alamat]', '$_REQUEST[txt_hp]','$_REQUEST[txt_email]', '$_REQUEST[txt_level]','1','default.png'");
		}
	}
}
?> 

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar user
        <button class="btn btn-success btn-sm pull-right" id='custId' data-toggle='modal' data-id='' data-target="#myTam">Tambah user</button>
      </div>
      <div class="card-body">
      	 <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Username</th>
              <th>Nama</th>
              <th>Alamat</th>
              <th>Level</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          	$sql = mysql_query("select * from cbt_user order by Urut");
          	$no = 0;
          	while($s = mysql_fetch_array($sql)) {
          		$ssts = $s['Status'];
          		$login = $s['login'];
          	$no ++;
          	?>
          	<tr>
          		<td><?= $no ?></td>
          		<td><?= $s['Username'] ?></td>
          		<td><?= $s['Nama'] ?></td>
          		<td><?= $s['Alamat'] ?></td>
          		<td>
          			<?= ($login == "1") ? 'Admin' : 'Guru' ?>
          		</td>
          		<td>
          			<a href="?modul=data_user&aksi1=status&urut=<?= $s['Urut'] ?>" >
          			<?php if($ssts == "1"): ?>	
          				<button type="button" class="btn btn-success btn-sm">Aktif</button>
          			<?php else: ?>
          				<button type="button" class="btn btn-default btn-sm">Non Aktif</button>
          			<?php endif;?>
          			</a>
          		</td>
          		<td>
          			<a href="#myModal" id="custId" data-toggle="modal" data-id="<?= $s['Urut'] ?>" class="btn btn-primary btn-sm"><i class="icon-pencil"></i></a>
          			<a href="?modul=data_user&aksi=hapus&urut=<?= $s['Urut']; ?>" class="btn btn-danger btn-sm"><i class="icon-trash"></i></a>
          		</td>
          	</tr>

          	<?php }
          	?>
          </tbody>
      </table>
      </div>
    </div>
  </div>
</div>

<script>
	$('#appTable').DataTable();
</script>
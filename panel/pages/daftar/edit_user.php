<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: Login.php");
}

include "../../../config/server.php";

if($_REQUEST['urut']) :
	$id = $_POST['urut'];

	$sql = mysql_query("select * from cbt_user where Urut = '$id'");
	$r = mysql_fetch_array($sql);
?>
 
 	

	<form action="?modul=data_user&simpan=yes" method="post">
 		<div class="modal-body">
			<input type="hidden" name="id" value="<?= $r['Urut']; ?>">
		 	<div class="form-group">
            <label>Level</label>
            <select class="form-control" name="txt_login">
            	<?php
            		$log = $r['login'];
            	?>
            	<option value="1" <?= ($log == "1") ? 'selected' : '' ?>>Admin</option>
            	<option value="2" <?= ($log == "2") ? 'selected' : '' ?>>Guru</option>
            </select>
          </div>
          <div class="form-group">
            <label>Username</label>
            <input type="text" class="form-control" name="txt_usern" value="<?= $r['Username'] ?>">
          </div>
          <div class="form-group">
            <label>Password</label>
            <input type="text" class="form-control" name="txt_pass">
          </div>
          <div class="form-group">
          	<label>Nama</label>
          	<input type="text" class="form-control" name="txt_nama" value="<?= $r['Nama'] ?>">
          </div>
          <div class="form-group">
            <label>NIP</label>
            <input type="text" class="form-control" name="txt_nip" value="<?= $r['NIP'] ?>">
          </div>
          <div class="form-group">
            <label>Alamat</label>
            <input type="text" class="form-control" name="txt_alamat" value="<?= $r['Alamat'] ?>">
          </div>
          <div class="form-group">
            <label>HP/Telp</label>
            <input type="text" class="form-control" name="txt_hp" value="<?= $r['HP'] ?>">
          </div>
          <div class="form-group">
            <label>Email</label>
            <input type="text" class="form-control" name="txt_email" value="<?= $r['Email'] ?>">
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>

     </form>

<?php endif;
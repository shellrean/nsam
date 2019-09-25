<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: Login.php");
}

include "../../../config/server.php";

if($_REQUEST['urut']) :
	$id = $_POST['urut'];

	$sql = mysql_query("select * from server_sekolah where Urut = '$id'");
	$r = mysql_fetch_array($sql);
?>
 
 	

	<form action="?modul=data_skul&simpan=yes" method="post">
 		<div class="modal-body">
			<input type="hidden" name="urut" value="<?php echo $r['Urut']; ?>">
 	<div class="form-group">
 	    <label>Kode Sekolah</label>
 	    <input type="text" class="form-control" name="txt_kodsek" value="<?php echo $r['XServerId']; ?>">
 	</div>
 	<div class="form-group">
 	    <label>Nama Sekolah</label>
 	    <input type="text" class="form-control" name="txt_namsek" value="<?php echo $r['XSekolah']; ?>">
 	</div>
 	<div class="form-group">
 	    <label>Alamat Sekolah</label>
 	    <input type="text" class="form-control" name="txt_alsek" value="<?php echo $r['XAlamatSek']; ?>">
 	</div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Simpan</button>
        </div>

     </form>

<?php endif;
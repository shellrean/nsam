<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

include "../../../config/server.php";

$xadm = mysql_fetch_array(mysql_query("select * from cbt_admin"));
$skul_tkt = $xadm['XTingkat'];

if ($skul_tkt=="SMA" || $skul_tkt=="MA"||$skul_tkt=="STM"){$rombel="Jurusan";}else{$rombel="Rombel";}

if($_REQUEST['urut']) {
	$id = $_POST['urut'];
	$sql = mysql_query("select * from cbt_kelas where Urut='$id'");
	$r = mysql_fetch_array($sql);

	?>

	<form action="?modul=daftar_kelas&simpan=yes" method="post">
		<input type="hidden" name="id" value="<?= $r['Urut'] ?>">
        <div class="modal-body">
		  <div class="form-group">
            <label>Kode sekolah</label>
            <select class="form-control" name="txt_kodesek" id="txt_kodesek">
            	<?php 
				$sqle = mysql_query("SELECT * FROM server_sekolah WHERE XServerId = '$r[XKodeSekolah]'");
				$re = mysql_fetch_array($sqle);
				echo "<option value='$r[XKodeSekolah]' selected >$r[XKodeSekolah] $re[XSekolah]</option>";
                $sqlsek = mysql_query("select * from server_sekolah order by XServerId");
                while($sek = mysql_fetch_array($sqlsek)){
                echo "<option value='$sek[XServerId]'>$sek[XServerId] $sek[XSekolah]</option>";
                }
                ?>
				<option value='ALL'>SEMUA / ALL</option>
            </select>
          </div>
          <div class="form-group">
          	<label>Kode kelas</label>
          	<input type="text" class="form-control" name="txt_kodkel" value="<?= $r['XKodeKelas'] ?>">
          </div>
          <div class="form-group">
          	<label>Nama kelas</label>
          	<input type="text" class="form-control" name="txt_namkel" value="<?= $r['XNamaKelas'] ?>">
          </div>
          <div class="form-group">
          	<label>Kode level</label>
          	<input type="text" class="form-control" name="txt_kodlev" value="<?= $r['XKodeLevel'] ?>">
          </div>
          <div class="form-gropu">
          	<label>Jurusan</label>
          	<input type="text" class="form-control" name="txt_jur" value="<?= $r['XKodeJurusan'] ?>">
          </div>
        </div>
        <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          	<button type="submit" class="btn btn-success">Update</button>
        </div>
    </form>
<?php 
}
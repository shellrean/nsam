<?php
    if(!isset($_COOKIE['beeuser'])) {
        header("Location: login.php");
    }
include "../../../config/server.php";

if($_REQUEST['urut']) {
    $id = $_POST['urut'];
    $sql = mysql_query("select * from cbt_mapel where urut='$id'");
    $r = mysql_fetch_array($sql);
?>

    <form action="?modul=daftar_mapel&simpan=yes" method="post">
        <div class="modal-body">
        	<div class="form-group">
                <input type="hidden" name="id" value="<?= $r['Urut'] ?>">
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
        	<div class="row">
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Kode mapel</label>
        				<input type="text" class="form-control" name="txt_kokel" value="<?= $r['XKodeMapel'] ?>">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Nama mapel</label>
        				<input type="text" class="form-control" name="txt_nakel" value="<?= $r['XNamaMapel'] ?>">
        			</div>
        		</div>
        	</div>
        	<div class="form-group">
        		<label>Tipe mapel</label>
        		<select id="txt_mapelagama"  name="txt_mapelagama" class="form-control" >
        			<option value='N'  <?php if ($r['XMapelAgama']=="N"){echo "selected";} ?>>MAPEL UMUM</option>
                        <option value='Y' <?php if ($r['XMapelAgama']=="Y"){echo "selected";} ?>>PEMINATAN</option>                                
                        <option value='A' <?php if ($r['XMapelAgama']=="A"){echo "selected";} ?>>PEND. AGAMA</option>  
        		</select>
        	</div>
        	<div class="row">
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Peren Harian</label>
        				<input type="text" class="form-control" name="txt_UH" value="<?= $r['XPersenUH'] ?>">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Persen UTS</label>
        				<input type="text" class="form-control" name="txt_UTS" value="<?= $r['XPersenUTS'] ?>">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Persen UAS</label>
        				<input type="text" class="form-control" name="txt_UAS" value="<?= $r['XPersenUAS'] ?>">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Nilai KKM</label>
        				<input type="text" class="form-control" name="txt_KKM" value="<?= $r['XKKM'] ?>">
        			</div>
        		</div>
        	</div>
        </div>
        <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          	<button type="submit" class="btn btn-success">Tambah</button>
        </div>
     </form>
<?php
}
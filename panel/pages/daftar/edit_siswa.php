<?php
if(!isset($_COOKIE['beeuser'])) {
	header('Location: login.php');
}

include "../../../config/server.php";

if($_REQUEST['urut']) {
	$id = $_POST['urut'];

	$sql = mysql_query("select * from cbt_siswa where Urut='$id'");
	$r = mysql_fetch_array($sql);
	$kos = $r['XKodeSekolah'];

	$sqlad = mysql_query("select * from cbt_admin");
	$ad = mysql_fetch_array($sqlad);

	$tingkat = $ad['XTingkat'];

	if ($tingkat=="MA" or $tingkat=="SMA" or $tingkat=="SMK"  ){$rombel="Jurusan";}else{$rombel="Rombel";}

?>
		<form action="?modul=daftar_siswa&simpan=yes" method="post">
		<input type="hidden" name="id" value="<?php echo $r['Urut']; ?>">
        <div class="modal-body">
        	<div class="form-group">
        		<label>Kode sekolah</label>
        		<select class="form-control" name="txt_kodesek" id="txt_kodesek">
        		<?php
					$sqle = mysql_query("SELECT * FROM server_sekolah WHERE XServerId = '$r[XKodeSekolah]'");
					$re = mysql_fetch_array($sqle);
					if ($kos=="ALL"){echo "<option value='ALL' selected >SEMUA / ALL</option>";}
					else {echo "<option value='$kos' selected >$kos - $re[XSekolah]</option>";}
                   	$sqlsek = mysql_query("select * from server_sekolah order by XServerId");
                   	while($sek = mysql_fetch_array($sqlsek)){
                   	echo "<option value='$sek[XServerId]'>$sek[XServerId] $sek[XSekolah]</option>";
                   	}
                   	?>
        		<option value="ALL">SEMUA</option>
        		</select>
        	</div>
        	<div class="form-group">
        		<label>Nama peserta</label>
        		<input type="text" class="form-control" name="txt_nam" value="<?php echo $r['XNamaSiswa']; ?>">
        	</div>
        	<div class="form-group">
        		<label>Nomer ujian peserta</label>
        		<input type="text" class="form-control" name="txt_nom" value="<?php echo $r['XNomerUjian']; ?>">
        	</div>
        	<div class="row">
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Level</label>
        				<select id="txt_level"  name="txt_level" class="form-control" >
							<option value=''></option>
							<?php 
								echo "<option value='$r[XKodeLevel]' selected >$r[XKodeLevel]</option>";
								$sqk = mysql_query("select * from cbt_kelas group by XKodeLevel");
								while($rs = mysql_fetch_array($sqk)){
                             	echo "<option value='$rs[XKodeLevel]' class='form-control' >$rs[XKodeLevel]</option>";} ?>
                        </select> 
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Kelas</label>
        				<select id="txt_kelas"  name="txt_kelas" class="form-control" >
						<option value=''></option>
						<?php 
							echo "<option value='$r[XKodeKelas]' selected >$r[XKodeKelas]</option>";
							$sqk = mysql_query("select * from cbt_kelas group by XKodeKelas");
							while($rs = mysql_fetch_array($sqk)){
                            echo "<option value='$rs[XKodeKelas]' class='form-control' >$rs[XKodeKelas]</option>";} ?>                                
                        </select>  
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label><?= $rombel; ?></label>
        				<select id="jur2"  name="jur2" class="form-control">
						<option value=''></option>
						<?php 
						echo "<option value='$r[XKodeJurusan]' selected >$r[XKodeJurusan]</option>";
						$sqk = mysql_query("select * from cbt_kelas group by XKodeJurusan");
						while($rs = mysql_fetch_array($sqk)){
                            echo "<option value='$rs[XKodeJurusan]' class='form-control'>$rs[XKodeJurusan]</option>";
						} ?>                                 
                        </select> 
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Nomer Induk</label>
        				<input type="text" class="form-control" name="txt_nisn" value="<?php echo $r['XNIK']; ?>">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Foto peserta</label>
        				<input type="text" class="form-control" name="txt_potret" value="<?php echo $r['XFoto']; ?>">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Jenis kelamin</label>
        				<select id="txt_jekel"  name="txt_jekel" class="form-control">
							<option value='L' <?php if($r['XJenisKelamin']=="L"){echo "selected";} ?>>Laki-laki</option>
							<option value='P' <?php if($r['XJenisKelamin']=="P"){echo "selected";} ?>>Perempuan</option>
						</select>  
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Password</label>
        				<input type="text" class="form-control" name="txt_pas" value="<?php echo $r['XPassword']; ?>">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Sesi ujian</label>
        				<select id="txt_sesi"  name="txt_sesi" class="form-control">
							<option value='1'>1</option>
							<option value='2'>2</option>
							<option value='3'>3</option>
							<option value='4'>4</option>
							<option value='5'>5</option>
                        </select>   
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Ruang ujian</label>
        				<input type="text" class="form-control" name="txt_ruang" value="RUANG 1" >
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Tipe</label>
        				<select id="txt_agama"  name="txt_agama" class="form-control">
        					<?php 
								echo "<option value='$r[XAgama]' selected >$r[XAgama]</option>";
								?> 
							<option value=''>MAPEL UMUM</option>
							<option value='ISLAM'>ISLAM</option>
							<option value='KRISTEN'>KRISTEN</option>  
							<option value='PROTESTAN'>PROTESTAN</option>
							<option value='HINDU'>HINDU</option>
							<option value='BUDHA'>BUDHA</option>
							<option value='KONGHUCU'>KONGHUCU</option>
						</select>  
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Mapel pilihan</label>
        				<select id="txt_pilih"  name="txt_pilih" class="form-control">
						<option value=''>NON PILIHAN</option>								
							<?php 
								echo "<option value='$r[XPilihan]' selected >$r[XPilihan]</option>";
								$sqk = mysql_query("select * from cbt_mapel where XMapelAgama='Y'");
								while($rs = mysql_fetch_array($sqk)){
                             	echo "<option value='$rs[XNamaMapel]'>$rs[XNamaMapel]</option>";} 
								?>   
                        </select>   
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Nama kelas</label>
        				<select id="txt_namkel"  name="txt_namkel" class="form-control">
							<?php echo "<option value='$r[XNamaKelas]'> $r[XNamaKelas]</option>"; ?>
							<?php 								
								$sqnk = mysql_query("select * from cbt_kelas group by XNamaKelas");
								while($rsnk = mysql_fetch_array($sqnk)){echo "<option value='$rsnk[XNamaKelas]'>$rsnk[XNamaKelas]</option>";} 
							?> 				
						</select>
        			</div>
        		</div>
        	</div>
        </div>
       	<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          	<button type="submit" class="btn btn-success">Simpan</button>
       	</div>
       	</form>

<?php 
}
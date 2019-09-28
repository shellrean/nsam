<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}
include "../../config/server.php";

if(isset($_REQUEST['aksi'])) {
	$sql = mysql_query("delete from cbt_siswa where Urut = '$_REQUEST[urut]'");
}

if(isset($_REQUEST['simpan'])) {
	$sql = mysql_query("update cbt_siswa set XNamaSiswa = '$_REQUEST[txt_nam]', XPassword = '$_REQUEST[txt_pas]', XNomerUjian = '$_REQUEST[txt_nom]',XKodeJurusan = '$_REQUEST[jur2]', XKodeKelas = '$_REQUEST[txt_kelas]', XKodeLevel = '$_REQUEST[txt_level]',XNIK = '$_REQUEST[txt_nisn]', XFoto='$_REQUEST[txt_potret]',XJenisKelamin = '$_REQUEST[txt_jekel]',XSesi = '$_REQUEST[txt_sesi]',XRuang = '$_REQUEST[txt_ruang]',XAgama = '$_REQUEST[txt_agama]',XKodeSekolah = '$_REQUEST[txt_kodesek]',XPilihan = '$_REQUEST[txt_pilih]',XNamaKelas = '$_REQUEST[txt_namkel]' where Urut = '$_REQUEST[id]'");
}

if(isset($_REQUEST['tambah'])) {
	$sqlcek = mysql_num_rows(mysql_query("select * from cbt_siswa where (XNomerUjian = '$_REQUEST[txt_nom]' or XNIK = '$_REQUEST[txt_nisn]')"));

	if($sqlcek>0){
		$message = "NISN atau nomor ujian telah digunakan";
		echo "<script>alert('$message');</script>";
	} else {
		if(!$_REQUEST['txt_nom']==""||!$_REQUEST['txt_nisn']==""){
		$sql = mysql_query("insert into cbt_siswa (XNamaSiswa, XPassword, XNomerUjian, XKodeJurusan, XKodeKelas, XKodeLevel,
		XNIK, XFoto,XJenisKelamin,XSesi,XRuang,XAgama,XKodeSekolah,XPilihan,XNamaKelas) values 	
		('$_REQUEST[txt_nam]','$_REQUEST[txt_pas]','$_REQUEST[txt_nom]','$_REQUEST[jur2]','$_REQUEST[txt_kelas]','$_REQUEST[txt_level]','$_REQUEST[txt_nisn]', 
		'$_REQUEST[txt_potret]','$_REQUEST[txt_jekel]','$_REQUEST[txt_sesi]','$_REQUEST[txt_ruang]','$_REQUEST[txt_agama]','$_REQUEST[txt_kodesek]','$_REQUEST[txt_pilih]','$_REQUEST[txt_namkel]')");
		}
	}
}

$sqlad = mysql_query("select * from cbt_admin");
$ad = mysql_fetch_array($sqlad);
$tingkat=$ad['XTingkat'];
if ($tingkat=="MA" or $tingkat=="SMA" or $tingkat=="SMK"  ){$rombel="Jurusan";}else{$rombel="Rombel";}

?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar peserta ujian
        <button class="btn btn-success btn-sm pull-right" id='custId' data-toggle='modal' data-id='' data-target="#myTam">Tambah siswa</button>
        <a href="daftar/down_excel_siswa.php" target="_blank" class="btn btn-success btn-sm pull-right mx-2">
          <i class="icon-cloud-download"></i> Download data
        </a>
        <a href="?modul=upl_siswa" class="btn btn-primary btn-sm pull-right">
          <i class="icon-cloud-download"></i> Upload data siswa
        </a>
        <a href="?modul=upl_foto" class="btn btn-primary btn-sm mx-2 pull-right">
          <i class="icon-cloud-download"></i> Upload foto
        </a>
        <a href="#myCetakKartu" id='custId' data-toggle="modal" data-id='' class="btn btn-danger btn-sm pull-right">
        	<i class="icon-doc"></i> Cetak kartu
        </a>
      </div>
      <div class="card-body">
      	 <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th width="82px">Foto</th>
              <th>Kode Sekolah</th>
              <th>Nomor Peserta | Sesi</th>
              <th>Nama Peserta</th>
              <th>Kelas-<?= $rombel; ?></th>
              <th>Nama kelas</th>
              <th>Agama</th>
              <th>Mapel Pilihan</th>
              <th>Edit | Hapus</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          		$sql = mysql_query("select * from cbt_siswa order by XNomerUjian");

          		while($s= mysql_fetch_array($sql)) {
          			$gbr=str_replace(" ","",$s['XFoto']);
          			if($gbr==""){$gbr="nouser.png";}

          	?>
          	<tr>
          		<td>
          			<img src="../../foto_siswa/<?= "$gbr"; ?>" width="80">
          		</td>
          		<td>
          			<?= $s['XKodeSekolah']; ?>
          		</td>
          		<td>
          			<?= $s['XNomerUjian']; ?> | <?= $s['XSesi']; ?>
          		</td>
          		<td>
          			<?= $s['XNamaSiswa']; ?>
          		</td>
          		<td>
          			<?= $s['XKodeKelas']; ?>-<?=$s['XKodeJurusan']; ?>
          		</td>
          		<td>
          			<?= $s['XNamaKelas']; ?>
          		</td>
          		<td>
          			<?= $s['XAgama']; ?>
          		</td>
          		<td>
          			<?= $s['XPilihan']; ?>
          		</td>
          		<td>
          			<a href="#myModal" id="custId" data-toggle="modal" data-id="<?= $s['Urut'] ?>" class="btn btn-primary btn-sm">
          				<i class="icon-pencil"></i>
          			</a>
          			<a href="?modul=daftar_siswa&aksi=hapus&urut=<?= $s['Urut'] ?>" class="btn btn-danger btn-sm">
          				<i class="icon-trash"></i>
          			</a>
          		</td>
          	</tr>
          	<?php	}
          	?>
          </tbody>
         </table>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myCetakKartu" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cetak kartu ujian</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="?modul=cetak_kartu" method="post">
       	<div class="modal-body">
       		<div class="form-group">
       			<label><?= $rombel; ?></label>
	       		<select class="form-control" id="jur2" name="jur2">
	       			<?php
	       				$sql = mysql_query("select * from cbt_kelas group by XKodeJurusan");
	       				while($rs = mysql_fetch_array($sql)) {
	       				echo "<option value='$rs[XKodeJurusan]'>$rs[XKodeJurusan]</option>";}
	       			?>
	       		</select>
	       	</div>
	       	<div class="Form-group">
	       		<label>Kelas</label>
				<select class="form-control" id="iki2"  name="iki2">
				<?php 
				$sqk = mysql_query("select * from cbt_kelas group by XKodeKelas");
				while($rs = mysql_fetch_array($sqk)){
	               echo "<option value='$rs[XKodeKelas]'>$rs[XKodeKelas]</option>";
				} ?> 
	            </select>
	       	</div>
       	</div>
       	<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          	<button type="submit" class="btn btn-success">Tampilkan</button>
       	</div>
       </form>
    </div>
  </div>
</div>

<div class="modal fade" id="myTam" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah data siswa</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="?modul=daftar_siswa&tambah=yes" method="post">
        <div class="modal-body">
        	<div class="form-group">
        		<label>Kode sekolah</label>
        		<select class="form-control" name="txt_kodesek" id="txt_kodesek">
        		<?php
        			$sqlsek = mysql_query("select * from server_sekolah order by XServerId");
        			while($sek = mysql_fetch_array($sqlsek)) {
        				echo "<option value='$sek[XServerId]'>$sek[XServerId] $sek[XSekolah]</option>";
        			}
        		?>	
        		<option value="ALL">SEMUA</option>
        		</select>
        	</div>
        	<div class="form-group">
        		<label>Nama peserta</label>
        		<input type="text" class="form-control" name="txt_nam">
        	</div>
        	<div class="form-group">
        		<label>Nomer ujian peserta</label>
        		<input type="text" class="form-control" name="txt_nom">
        	</div>
        	<div class="row">
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Level</label>
        				<select id="txt_level"  name="txt_level" class="form-control" >
							<option value=''></option>
							<?php $sqk = mysql_query("select * from cbt_kelas group by XKodeLevel");
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
						<?php $sqk = mysql_query("select * from cbt_kelas group by XKodeKelas");
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
						$sqk = mysql_query("select * from cbt_kelas group by XKodeJurusan");
						while($rs = mysql_fetch_array($sqk)){
                            echo "<option value='$rs[XKodeJurusan]'>$rs[XKodeJurusan]</option>";
						} ?>                                
                        </select> 
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Nomer Induk</label>
        				<input type="text" class="form-control" name="txt_nisn">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Foto peserta</label>
        				<input type="text" class="form-control" name="txt_potret">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Jenis kelamin</label>
        				<select id="txt_jekel"  name="txt_jekel" class="form-control">
							<option value='L'>Laki-laki</option>
							<option value='P'>Perempuan</option>                                
                        </select>    
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Password</label>
        				<input type="text" class="form-control" name="txt_pas">
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
							<option value=''></option>
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
						<option value=''></option>								
							<?php 
							$sqk = mysql_query("select * from cbt_mapel where XMapelAgama='Y'");
							while($rs = mysql_fetch_array($sqk)){
                             echo "<option value='$rs[XNamaMapel]'>$rs[XNamaMapel]</option>";
							} ?>   
                        </select>   
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Nama kelas</label>
        				<select id="txt_namkel"  name="txt_namkel" class="form-control">
							<?php 	$sqnk = mysql_query("select * from cbt_kelas group by XNamaKelas");
									while($rsnk = mysql_fetch_array($sqnk)){echo "<option value='$rsnk[XNamaKelas]'>$rsnk[XNamaKelas]</option>";} 
							?> 			
						</select>
        			</div>
        		</div>
        	</div>
        </div>
       	<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          	<button type="submit" class="btn btn-success">Tambah</button>
       	</div>
       	</form>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit data siswa</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
       	<div class="fetched-data"></div>
    </div>
  </div>
</div>

<script>
	$('#appTable').DataTable();

	$('#myModal').on('show.bs.modal', function(e) {
		let rowid = $(e.relatedTarget).data('id')

		$.ajax({
			type : 'post',
			url : 'daftar/edit_siswa.php',
			data : 'urut='+rowid,
			success(data) {
				$('.fetched-data').html(data)
			}
		})
	})
</script>
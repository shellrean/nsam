<?php
if(!isset($_COOKIE['beeuser'])) {
	header('Location: login.php');
}
?>


<?php
include "../../config/server.php";
$skulut 	= $log['XLoginUtama'];
$elearning 	= $log['XeLearning'];
$skulpic	= $log['XLogo'];
$skulban 	= $log['XBanner'];
$skulnam	= $log['XSekolah'];
$skultin	= $log['XTingkat'];
$skulala	= $log['XAlamat'];
$skultel	= $log['XTelp'];
$skulfax	= $log['XFax'];
$skulema	= $log['XEmail'];
$skulweb	= $log['XWeb'];
$skulkep	= $log['XKepSek'];
$skulweb 	= $log['XWeb'];
$skuladm	= $log['XAdmin'];
$admpic		= $log['XPicAdmin'];
$skulkode	= $log['XKodeSekolah'];
$skulnip1	= $log['XNIPKepsek'];
$skulnip2	= $log['XNIPAdmin'];
$skullogin	= $log['XLogin'];
$prop		= $log['XProp'];
$kab		= $log['XKab'];
$kec		= $log['XKec'];
$colhead 	= $log['XWarna'];
$h1			= $log['XH1'];
$h2			= $log['XH2'];
$h3			= $log['XH3'];

$sql1	= mysql_query("select * from inf_lokasi where lokasi_kabupatenkota='$kab' and lokasi_propinsi='$prop' and lokasi_kecamatan='0000' and lokasi_kelurahan='0000'");

?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Data sekolah
      </div>
      <div class="card-body">
      	<div class="form-group">
          <label>Kode sekolah</label>
          <input type="text" class="form-control" id="txt_kode" value="<?= $skulkode ?>">
        </div>
        <div class="form-group">
          <label>Nama sekolah</label>
          <input type="text" class="form-control" id="namaskul" value="<?= $skulnam ?>">
        </div>
        <div class="form-group">
          <label>Level sekolah</label>
          <select class="form-control" id="tingkatskul">
          	<option value="SD" <?= ($skultin == "SD") ? 'selected' : '' ?>>
          		SD
          	</option>
          	<option value="MI" <?= ($skultin == "MI") ? 'selected' : '' ?>>
          		MI
          	</option>
          	<option value="SMP" <?= ($skultin == "SMP") ? 'selected' : '' ?>>
          		SMP
          	</option>
          	<option value="MTs" <?= ($skultin == "MTs") ? 'selected' : '' ?>>
          		MTs
          	</option>
          	<option value="MA" <?= ($skultin == "MA") ? 'selected' : '' ?>>
          		MA
          	</option>
          	<option value="SMK" <?= ($skultin == "SMK" ) ? 'selected' : '' ?>>
          		SMK
          	</option>
          </select>
        </div>
        <div class="form-group">
          <label>Alamat sekolah</label>
          <input type="text" class="form-control" id="alamatskul" value="<?= $skulala ?>">
        </div>
        <div class="form-group">
          <label>Login Header 1</label>
          <input type="text" class="form-control" id="txt_h1" value="<?= $h1 ?>">
        </div>
        <div class="form-group">
          <label>Login Header 2</label>
          <input type="text" class="form-control" id="txt_h2" value="<?= $h1 ?>">
        </div>
        <div class="form-group">
          <label>Teks login</label>
          <input type="text" class="form-control" id="txt_h3" value="<?= $h3 ?>">
        </div>
        <div class="form-group">
          <label>No. telp</label>
          <input type="text" class="form-control" id="telpskul" value="<?= $skultel ?>">
        </div>
        <div class="form-group">
          <label>No. fax.</label>
          <input type="text" class="form-control" id="faxskul" value="<?= $skulfax ?>">
        </div>
        <div class="form-group">
          <label>Email sekolah</label>
          <input type="text" class="form-control" id="emailskul" value="<?= $skulema ?>">
        </div>
        <div class="form-group">
          <label>Website sekolah</label>
          <input type="text" class="form-control" id="webskul" value="<?= $skulweb ?>">
        </div>
        <div class="form-group">
          <label>Kepala sekolah</label>
          <input type="text" class="form-control" id="kepsek" value="<?= $skulkep ?>">
        </div>
        <div class="form-group">
          <label>NIP Kepsek</label>
          <input type="text" class="form-control" id="nipkepsek" value="<?= $skulnip1 ?>">
        </div>
        <div class="form-group">
          <label>CBT Administrator</label>
          <input type="text" class="form-control" id="txt_adm" value="<?= $skuladm ?>">
        </div>
        <div class="form-group">
          <label>NIP Admin</label>
          <input type="text" class="form-control" id="nipadmin" value="<?= $skulnip2 ?>">
        </div>
        <div class="form-group">
          <label>Warna header</label>
          <input type="text" class="form-control" id="txt_col" value="<?= $colhead ?>">
        </div>
      </div>
      <div class="card-footer">
      	<button type="submit" class="btn btn-primary" id="simpan" name="simpan">Simpan data sekolah</button>
      </div>
    </div>
  </div>
</div>


<script>
	$(document).ready(function() {
		let loading 	= $('#loading');

		$('#simpan').click(function() {
			let txt_nama	= $('#namaskul').val();
			let txt_ting	= $('#tingkatskul').val();
			let txt_alam	= $('#alamatskul').val();
			let txt_telp	= $('#telpskul').val();
			let txt_facs	= $('#faxskul').val();
			let txt_emai	= $('#emailskul').val();
			let txt_webs	= $('#webskul').val();
			let txt_ip		= $('#kepsek').val();
			let txt_adm		= $('#txt_adm').val();
			let txt_nip1	= $('#nipkepsek').val();
			let txt_nip2	= $('#nipadmin').val();
			let txt_col		= $('#txt_col').val();
			let txt_kode	= $('#txt_kode').val();
			let txt_h1		= $('#txt_h1').val();
			let txt_h2 		= $('#txt_h2').val();
			let txt_h3		= $('#txt_h3').val();

			$.ajax({
				type : "POST",
				url  : "sekolah/ubahdata.php",
				data : "aksi=simpan&txt_nama=" + txt_nama + 
				"&txt_ting=" + txt_ting + 
				"&txt_alam=" + txt_alam + 
				"&txt_telp=" + txt_telp + 
				"&txt_facs=" + txt_facs + 
				"&txt_emai=" + txt_emai + 
				"&txt_webs=" + txt_webs + 
				"&txt_ip=" + txt_ip + 
				"&txt_adm=" + txt_adm + 
				"&txt_col=" + txt_col + 
				"&txt_kode=" + txt_kode + 
				"&txt_nip1=" + txt_nip1 + 
				"&txt_nip2=" + txt_nip2 + 
				"&txt_h1=" + txt_h1 + 
				"&txt_h2=" + txt_h2 + 
				"&txt_h3=" + txt_h3,
				success(data) {
					loading.fadeOut();
					$('#info').html(data);
					$('#info').fadeOut(2000);
				}

			})
		})
	})

</script>
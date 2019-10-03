<?php 
$tgx = 29;
$blx = 09;
$thx = 2016;

$tglx = date("Y/m/d");
$jamx = date("H:i:s");
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Aktifasi jadwal ujian
      </div>
      <div class="card-body">
      <?php 
     	$sql = mysql_query("select p.*,m.*,p.Urut as Urutan,p.XKodeKelas  as kokel from cbt_paketsoal p left join cbt_mapel m on m.XKodeMapel = p.XKodeMapel where p.XStatusSoal='Y' and p.Urut = '$_REQUEST[idtes]'");
		$s = mysql_fetch_array($sql);
	  ?>  
	  <div id="infoz" class="infoz"></div>
	  <div class="row">
	  	<div class="col-md-6">
		  <div class="form-group">
		  	<label>Jenis ujian</label>
		  	<select class="form-control" id="txt_ujian<?php echo $s['Urutan']; ?>">
				<?php	
				$sqlkelas = mysql_query("select * from cbt_tes order by Urut");
				while($k = mysql_fetch_array($sqlkelas)){
				echo "<option value='$k[XKodeUjian]'>$k[XNamaUjian]</option>";
				} ?>
			</select>
	      </div>
	      <div class="form-group">
	      	<label>Pemutaran listening</label>
	      	<select class="form-control" id="txt_listen<?php echo $s['Urutan']; ?>">
				<?php	
				echo "<option value='1'>Sekali</option>";
				echo "<option value='2'>Dua Kali</option>";
				echo "<option value='3'>terusan</option>";
				?>
			</select>
	      </div>
	      <div class="form-group">
	      	<label>Soal PDF</label>
			<select class="form-control" class="form-control" id="txt_pdf<?= $s['Urutan']; ?>">
				<?php 	
				echo "<option value='0'>Bukan PDF</option>";
				echo "<option value='1'>Soal PDF</option>";
				 ?>
			</select>
	      </div>
	      <div class="form-group">
	      	<label>Waktu pelaksanaan</label>
	      	<input class="form-control" type="datetime-local" size="25" value="" id="datetimepicker_mask<?= $s['Urutan']; ?>"/>
	      </div>
	      <div class="form-group">
	      	<label>Durasi tes (menit)</label>
	      	<input class="form-control" type="text" size="10" id="txt_durasi<?= $s['Urutan']; ?>"> 
	      </div>
	      <div class="form-group">
	      	<label>Ujian ditutup</label>
	      	<input class="form-control" type="time" size="10" value='' id="mulai2">
	      </div>
	      <div class="form-group">
	      	<label>TOKEN</label>
	      	<input class="form-control"type="text" size="10" id="txt_token<?= $s['Urutan']; ?>">
	      </div>
	    </div>
	    <div class="col-md-6">
	       <div class="form-group">
	       	  <label>Semester</label>
	       	  <select class="form-control" id="txt_semester<?php echo $s['Urutan']; ?>">
				<?php	
				echo "<option value='1'>Ganjil</option>";
				echo "<option value='2'>Genap</option>";
				?>
			  </select>
	       </div>
	       	<div class="form-group">
	      	  <label>Sesi ujian</label>
	      	  <select class="form-control" id="txt_sesi<?php echo $s['Urutan']; ?>">
				<?php	
				$sqlsesi = mysql_query("select * from cbt_siswa group by XSesi");
				while($sk = mysql_fetch_array($sqlsesi)){echo "<option value='$sk[XSesi]'>$sk[XSesi]</option>";}
				?>
				<option value='ALL'>Semua</option>
			  </select>
	        </div>

	        <div class="form-group">
	          <label>Nama file PDF</label>
	          <input class="form-control" type="text" size="25" id="txt_filepdf<?= $s['Urutan']; ?>">
	        </div>
	        <div class="form-group">
	          <label>Nilai</label>
	          <select class="form-control" id="txt_hasil<?php echo $s['Urutan']; ?>">
				<?php 	
				echo "<option value='1'>NILAI Ditampilkan</option>";	
				echo "<option value='0'>NILAI Tidak Ditampilkan </option>";
				?> 
			  </select>
	        </div>
	        <div class="Form-group">
 			  <label>Status TOKEN</label>
 			  <input class="form-control" type="hidden" size="3" id="txt_kodesoal<?php echo $s['Urutan']; ?>" value="<?php echo $s['XKodeSoal']; ?>">
 			  <select class="form-control" id="txt_statustoken<?php echo $s['Urutan']; ?>">
                <?php	
                echo "<option value='0'>TOKEN Tidak Ditampilkan </option>";
				echo "<option value='1'>TOKEN Ditampilkan</option>";	 
				?>
			  </select>
	        </div>
	    </div>
	  </div>
	  <button type="submit" class="btn btn-primary btn-sm" id="kirim<?= $s['Urutan'] ?>">Rilis token</button>
	  <a href="?modul=daftar_tesbaru" class="btn btn-light btn-sm">Kembali</a>
    </div>
 </div>
</div>

<script>
	$(document).ready(function() {
		$('#txt_durasi<?= $s['Urutan']; ?>').change(function() {
			let txt_durasi = $('#txt_durasi<?= $s['Urutan']; ?>').val()
			$.ajax({
				url: "tools/ambil_token.php",
				data: "txt_ujian="+txt_durasi,
				cache: false,
				success(msq) {
					$("#txt_token<?= $s['Urutan']; ?>").val(msq);
				}
			})
		})

		$("#kirim<?= $s['Urutan']; ?>").click(function() {
			let txt_ujian = $("#txt_ujian<?= $s['Urutan']; ?>").val();
			let txt_semester = $("#txt_semester<?= $s['Urutan']; ?>").val();
			let txt_waktu = $("#datetimepicker_mask<?= $s['Urutan']; ?>").val();
			let txt_token = $("#txt_token<?= $s['Urutan']; ?>").val();
			let txt_durasi = $("#txt_durasi<?= $s['Urutan']; ?>").val();
			let txt_kodesoal = $("#txt_kodesoal<?= $s['Urutan']; ?>").val();
			let txt_sesi = $("#txt_sesi<?= $s['Urutan']; ?>").val();
			let txt_hasil = $("#txt_hasil<?= $s['Urutan']; ?>").val();
			let txt_statustoken = $("#txt_statustoken<?= $s['Urutan']; ?>").val();
			let mulai2 = $("#mulai2").val();
			let txt_pdf = $("#txt_pdf<?= $s['Urutan']; ?>").val();
			let txt_filepdf = $("#txt_filepdf<?= $s['Urutan']; ?>").val();
			let txt_listen = $("#txt_listen<?= $s['Urutan']; ?>").val();
			
			if(txt_durasi==""){
				alert("Durasi Ujian masih KOSONG");
				return false;
			}

			$.ajax({
				type: 'POST',
				url: "daftar/simpan_jadwal.php",
				data: "aksi=simpan&txt_ujian=" + txt_ujian + "&txt_waktu=" + txt_waktu + "&txt_token=" + txt_token + "&txt_durasi=" + txt_durasi  + "&txt_filepdf=" + txt_filepdf + "&txt_pdf=" + txt_pdf+ "&txt_listen=" + txt_listen + "&txt_kodesoal=" + txt_kodesoal + "&txt_semester=" + txt_semester + "&txt_hasil=" + txt_hasil + "&txt_sesi=" + txt_sesi + "&txt_statustoken=" + txt_statustoken + "&mulai2=" + mulai2,
				success(data) {
					$('#infoz').html(data),
					$("#ndelik").css("display","block");
				}
			})

		})
	})
</script>
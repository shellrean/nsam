<?php

if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}
?>
<script>
	$(document).ready(function() {
		$("#baru").click(function(){
			let txt_ujian 	= $("#txt_ujian").val();
			let txt_jawab 	= $("#txt_jawabz").val();
			let txt_kelas 	= $("#txt_kelasz").val();
			let txt_jurusan = $("#txt_jurusanz").val();
			let txt_soal 	= $("#txt_soalz").val();  
			let txt_mapel 	= $("#txt_mapelz").val();
			let txt_level 	= $("#txt_levelz").val(); 
			let txt_nama 	= $("#txt_namaz").val();  
			let txt_jumsoal1 	= $("#txt_jumsoalz1").val();  
			let txt_jumsoal2 	= $("#txt_jumsoalz2").val(); 
			let txt_bobotsoal1 	= $("#txt_bobotsoalz1").val();  
			let txt_bobotsoal2 	= $("#txt_bobotsoalz2").val();  
			let txt_kodesek = $("#txt_kodesek").val(); 
			let txt_acak = $('#txt_acak').val();

			var n = txt_nama.includes(" ");
			if(n==true){
				alert("Kode Bank Soal mengandung Spasi");
				return false;
			}
			if(txt_nama==""){
				alert("Isikan Kode Bank Soal");
				return false;
			}

			if(txt_kelas=="Pilih Kelas"){
			alert("Belum Pilih Kelas ");
			return false;
			}

			$.ajax({
				type:"post",
				url: "daftar/database_soal_simpan.php",
				data: "aksi=simpan&txt_ujian=" + txt_ujian + "&txt_jawab=" + txt_jawab + "&txt_kelas=" + txt_kelas + "&txt_jurusan=" + txt_jurusan + "&txt_soal=" + txt_soal + "&txt_level=" + txt_level + "&txt_mapel=" + txt_mapel + "&txt_nama=" + txt_nama + "&txt_jumsoal1=" + txt_jumsoal1  + "&txt_jumsoal2=" + txt_jumsoal2 + "&txt_soal=" + txt_soal + "&txt_bobotsoal1=" + txt_bobotsoal1  + "&txt_bobotsoal2=" + txt_bobotsoal2 + "&txt_kodesek=" + txt_kodesek + "&txt_acak="+txt_acak,
				success(data) {
					$('#ndelink').css('display','block')
				}
			})
		})
	})
</script>
<style>
	#ndelink {
		display: none;
	}
</style>
<div class="alert alert-success" id="ndelink">
	Banksoal baru suskses dibuat...
</div>
<div class="row">
	<div class="col">
		<div class="form-group">
			<label>Kode sekolah</label>
			<select class="form-control" name="txt_kodesek" id="txt_kodesek">
				<option value='ALL' selected>SEMUA</option>
		        <?php 
		        $sqlsek = mysql_query("select * from server_sekolah order by XServerId");
		        while($sek = mysql_fetch_array($sqlsek))
				{echo "<option value='$sek[XServerId]'>$sek[XServerId] </option>"; }
		        ?>
			</select>
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label>Mata pelajaran</label>
			<select class="form-control" name="txt_mapelz" id="txt_mapelz">
		        <?php 
		        $sqlkelas = mysql_query("select * from cbt_mapel order by XKodeMapel");
		        while($sk = mysql_fetch_array($sqlkelas)){echo "<option value='$sk[XKodeMapel]'>$sk[XKodeMapel] - $sk[XNamaMapel]</option>";}
		        ?>

		        <?php
				$sqladmin = mysql_query("select * from cbt_admin");
				$sa = mysql_fetch_array($sqladmin);
				$skul = $sa['XTingkat'];
		        ?>
		    </select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col">
		<div class="form-group">
			<label>Tingkat sekolah</label>
			<select class="form-control" id="txt_levelz">                           
				<option value="SD" <?php if($skul=='SD'){echo "selected";} ?>>SD</option>
				<option value="MI" <?php if($skul=='MI'){echo "selected";} ?>>MI</option>                            
				<option value="SMP" <?php if($skul=='SMP'){echo "selected";} ?>>SMP</option>
				<option value="MTs" <?php if($skul=='MTs'){echo "selected";} ?>>MTs</option>                            
				<option value="SMA" <?php if($skul=='SMA'){echo "selected";} ?>>SMA</option>
				<option value="MA" <?php if($skul=='MA'){echo "selected";} ?>>MA</option>                            
				<option value="SMK" <?php if($skul=='SMK'){echo "selected";} ?>>SMK</option>                            
			</select>
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label>Jurusan</label>
			<select class="form-control" id="txt_jurusanz">
				<option value="ALL" selected>SEMUA</option>
		        <?php 
				$sqljur = mysql_query("select * from cbt_kelas group by XKodeJurusan");
				while($j = mysql_fetch_array($sqljur))
				{echo "<option value='$j[XKodeJurusan]' >$j[XKodeJurusan]</option>";}
				?>
			</select>
		</div>
	</div>
</div>


<div class="row">
	<div class="col">
		<div class="form-group">
			<label>kelas</label>
			<select class="form-control" id="txt_kelasz" required>
				<option value='ALL' selected>SEMUA</option>
				<?php 
				$sqlkelas = mysql_query("select * from cbt_kelas group by XKodeKelas");
				while($k = mysql_fetch_array($sqlkelas))
				{echo "<option value='$k[XKodeKelas]' selected>$k[XKodeKelas]</option>";}
				?>
			</select>
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label>Kode banksoal</label>
			<input class="form-control" type="text" id="txt_namaz" required /> 
		</div>
	</div>
</div>

<div class="row">
	<div class="col">
		<div class="form-group">
			<label>Jumlah opsi jawaban</label>
			<select class="form-control"id="txt_jawabz">
				<option value= '5' selected>5</option>
				<option value='4'>4</option>
				<option value='3'>3</option>
			</select>
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label>Acak soal</label>
			<select class="form-control"id="txt_jawabz">
				<option value= 'Y'>Acak</option>
				<option value="T">Tidak</option>
			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col">
		<div class="form-group">
			<label>Pilihan ganda</label>
			<input  class="form-control"size="2" type="text" id="txt_jumsoalz1"/> 
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label>Bobot pilihan ganda</label>
			<input  class="form-control"size="2" type="text" id="txt_bobotsoalz1"/>  
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label>Essai</label>
			<input  class="form-control"size="2" type="text" id="txt_jumsoalz2"/>  
		</div>
	</div>
	<div class="col">
		<div class="form-group">
			<label>Bobot essai</label>
			<input  class="form-control"size="2" type="text" id="txt_bobotsoalz2"/> 
		</div>
	</div>
</div>
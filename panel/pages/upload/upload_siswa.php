<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Download File excel (Template data siswa)
      </div>
      <div class="card-body">
      	Jangan ada inputan apapun setelah nomer terakhir</span>  Karena akan dibaca dan diacak oleh sistem. <p>Setelah selesai edit, Upload kembali untuk ditransfer ke
   		database melalui tool dibawah ini.
      </div>
      <div class="card-footer">
      	<a href="../downloads/excel/bee_siswa_temp.xls" target="_blank" class="btn btn-success btn-sm" >
      		<i class="icon-cloud-download"></i>
      		Download template
      	</a>
      	<a href="?modul=daftar_siswa" class="btn btn-success btn-sm">
      		<i class="icon-list"></i>
      		Lihat data siswa
      	</a>
      </div>
    </div>
  </div>

  <div class="col-lg-12">
  	<div class="card">
  		<div class="card-header py-3">
  			<i class="icon-cloud-upload"></i>
  			Upload template excel - siswa
  		</div>
  		<div class="card-body">
  			<form method="post" enctype="multipart/form-data" action="?modul=uploadsiswa">
  			<div class="form-group">
	            <label>File excel daftar siswa</label>
	            <input name="userfile" type="file" class="btn btn-default">
	            <input type="submit" name="upload" value="Import" class="btn btn-primary btn-sm">
          	</div>
          	Presentasi proses upload
          	<div id="progress" style="width:75%; border:1px solid #ccc; padding:5px; margin-top:10px; height:33px; background-color:#D9D9D9"></div>
			<div id="information" style="width"></div>
  			</form>
  		</div>
  	</div>
  </div>
</div>

<?php
if($_REQUEST['modul'] == "uploadsiswa") {
	include "excel_reader2.php";

	if(isset($xkodemapel)){
	$xkodemapel = "$_REQUEST[txt_mapel]";
	}
	if(isset($xkodesoal)){
	$xkodesoal = "$_REQUEST[txt_ujian]";
	}
	if(isset($xkodekelas)){
	$xkodekelas = "$_REQUEST[txt_level]";
	}

	$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);
	$baris = $data->rowcount($sheet_index=0);

	$sukses = 0;
	$gagal = 0;

	echo "<br><table class='table table-bordered'>";
	$query0 = "truncate table cbt_siswa";
		  $hasil0 = mysql_query($query0);

	for ($i=3; $i<=$baris; $i++)
	{

		$fieldz = $data->val($i, 1);
		$xnomer 	= $data->val($i, 1);
  		$xnama  	= $data->val($i, 2);
  		$xnik   	= $data->val($i, 3);
  		$xsesi  	= $data->val($i, 4);
  		$xruang 	= $data->val($i, 5);
  		$xlevel 	= $data->val($i, 6);
  		$xkelas 	= $data->val($i, 7);
  		$xjekel 	= $data->val($i, 8);
  		$xpass  	= $data->val($i, 9);
  		$xjur   	= $data->val($i, 10);
  		$xfoto  	= $data->val($i, 11);
  		$xagama  	= $data->val($i, 12); 
  		$xpilih  	= $data->val($i, 13); 
  		$xidsek  	= $data->val($i, 14);  
  		$xnakel  	= $data->val($i, 15);
  		$xnama  	= str_replace("'","\'",$xnama);
  		$xnama  	= str_replace("'","`",$xnama);

  		if(!str_replace(" ","",$xnomer)==""){ 
 
			$querykelas = "select XKodeKelas from cbt_kelas where XKodeKelas = '$xkelas' ";
			$hasilkelas = mysql_num_rows(mysql_query($querykelas));
			$queryjur = "select XKodeJurusan from cbt_kelas where  XKodeJurusan = '$xjur'";
			$hasiljur = mysql_num_rows(mysql_query($queryjur));
			$querylevel = "select XKodeLevel from cbt_kelas where XKodeLevel = '$xlevel' ";
			$hasillevel = mysql_num_rows(mysql_query($querylevel));
			$querynamakelas = "select XNamaKelas from cbt_kelas where XNamaKelas = '$xnakel' ";
			$hasilnamakelas = mysql_num_rows(mysql_query($querynamakelas));
			$querykode = mysql_query("select XKodeSekolah from cbt_admin");
			$hk = mysql_fetch_array($querykode);

			if($hasilkelas<1){ 
		 		echo "<tr><td>Gagal Insert data Siswa <b>$xnama</b>&nbsp;&nbsp;</td><td><font color=red> Kode Kelas $xkelas</font> Tidak Sesuai dengan Database Kelas</td> </tr>";
		  		$gagal++;
		  	}
		  	elseif($hasiljur<1){ 
			  echo "<tr><td>Gagal Insert data Siswa <b>$xnama</b>&nbsp;&nbsp;</td><td><font color=red> Kode Jurusan $xjur</font> Tidak Sesuai dengan Database Kelas</td> </tr>";
			  $gagal++;
			}
			elseif($hasillevel<1){ 
			  echo "<tr><td>Gagal Insert data Siswa <b>$xnama</b>&nbsp;&nbsp;</td><td><font color=red> Kode Level $xlevel</font> Tidak Sesuai dengan Database Kelas</td> </tr>";
			  $gagal++;
			}
			elseif($hasilnamakelas<1){ 
			  echo "<tr><td>Gagal Insert data Siswa <b>$xnama</b>&nbsp;&nbsp;</td><td><font color=red> Nama Kelas$xnakel</font> Tidak Sesuai dengan Database Kelas</td> </tr>";
			  $gagal++;
			}
			else {  	  
		 		$query = "insert into cbt_siswa (XNomerUjian, XNIK,XSesi,XRuang, XNamaSiswa,XKodeKelas, XJenisKelamin, XPassword, XKodeJurusan,XKodeLevel, XFoto,XAgama,XSetId,XKodeSekolah,XPilihan,XNamaKelas) values ('$xnomer', '$xnik','$xsesi', '$xruang', '$xnama','$xkelas','$xjekel','$xpass','$xjur','$xlevel','$xfoto','$xagama','$_COOKIE[beetahun]','$xidsek','$xpilih','$xnakel')";
		  
		  		$hasil = mysql_query($query);
  				$sukses++;
  			} 
  		}

  		$percent = intval($i/$baris * 100)."%";

  		echo '<script language="javascript">
	    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-image:url(../../images/bar/pbar-ani1.gif);\">&nbsp;</div>";
	    document.getElementById("information").innerHTML="  Proses Entri : '.$xnama.' ... <b>'.$i.'</b> row(s) of <b>'. $baris.'</b> processed.";
	    </script>';

	    echo str_repeat(' ',1024*64);

	    flush();

	    echo '<script language="javascript">document.getElementById("information").innerHTML=" Proses update database Siswa : Completed"</script>';
	}
	echo "</table>";
	?>
	<div class="card">
    <div class="card-body">
		<div class="alert alert-success">
			<?php
			echo "Jumlah data yang sukses diimport : ".$sukses."<br>";
			?>
		</div>
		<?php
			if($gagal >0) {
				?>
			<div class="alert alert-danger">
				<?php
				echo "Jumlah data yang gagal diimport :".$gagal;
				?>
			</div>
			<?php  } ?>
	</div>
</div>
<?php }
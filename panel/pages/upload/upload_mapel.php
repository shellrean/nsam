<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Download File excel (Template data mapel)
      </div>
      <div class="card-body">
      	Jangan ada inputan apapun setelah nomer terakhir</span>  Karena akan dibaca dan diacak oleh sistem. <p>Setelah selesai edit, Upload kembali untuk ditransfer ke
   		database melalui tool dibawah ini.
      </div>
      <div class="card-footer">
      	<a href="../downloads/excel/bee_mapel_temp.xls" target="_blank" class="btn btn-success btn-sm" >
      		<i class="icon-cloud-download"></i>
      		Download template
      	</a>
      	<a href="?modul=daftar_mapel" class="btn btn-success btn-sm">
      		<i class="icon-list"></i>
      		Lihat data mapel
      	</a>
      </div>
    </div>
  </div>

  <div class="col-lg-12">
  	<div class="card">
  		<div class="card-header py-3">
  			<i class="icon-cloud-upload"></i>
  			Upload template excel - mapel
  		</div>
  		<div class="card-body">
  			<form method="post" enctype="multipart/form-data" action="?modul=uploadmapel">
  			<div class="form-group">
	            <label>File excel daftar kelas</label>
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
if($_REQUEST['modul'] == "uploadmapel") {
	include "excel_reader2.php";

	$xkodemapel = "GAL1";
	$xkodesoal = "XGAL1SOAL2";

	$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

	$baris = $data->rowcount($sheet_index=0);
	$query = mysql_query("truncate table cbt_mapel");

	$sukses = 0;
	$gagal = 0;

	for($i=2; $i<=$baris; $i++)
	{
	  $fieldz = $data->val($i, 1);
	  $xlevel = $data->val($i, 1);
	  $xkelas = $data->val($i, 2);
	  $xUH  = $data->val($i, 3);
	  $xUTS = $data->val($i, 4);
	  $xUAS = $data->val($i, 5);
	  $xKKM = $data->val($i, 6); 
	  $xAGAMA = $data->val($i, 7);  
	  $xKodeSek = $data->val($i, 8); 

	  $xlevel = mysql_real_escape_string($xlevel);
 	  $xkelas = mysql_real_escape_string($xkelas);

 	   $query = "insert into cbt_mapel ( XKodeMapel, XNamaMapel,XPersenUH,XPersenUTS,XPersenUAS,XKKM,XMapelAgama,XKodeSekolah) VALUES 
		  ('$xlevel', '$xkelas', '$xUH', '$xUTS', '$xUAS', '$xKKM', '$xAGAMA', '$xKodeSek')";
 	  $hasil = mysql_query($query);

 	  if($hasil) $sukses++;
 	  else $gagal++;

 	  $percent = intval($i/$baris * 100)."%";

 	  echo '<script language="javascript">
	    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-image:url(../../images/bar/pbar-ani1.gif);\">&nbsp;</div>";
	    document.getElementById("information").innerHTML="  Proses Entri : '.$xkelas.' ... <b>'.$i.'</b> row(s) of <b>'. $baris.'</b> processed.";
	    </script>';

	  echo str_repeat(' ',1024*64);
	  flush();

	  echo '<script language="javascript">document.getElementById("information").innerHTML=" Proses update database mata pelajaran : Completed"</script>';
	} ?>
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
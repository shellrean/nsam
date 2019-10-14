<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}
?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Download File excel (Template data soal)
      </div>
      <div class="card-body">
      	Jangan ada inputan apapun setelah nomer terakhir</span>  Karena akan dibaca dan diacak oleh sistem. <p>Setelah selesai edit, Upload kembali untuk ditransfer ke
   		database melalui tool dibawah ini.
      </div>
      <div class="card-footer">
      	<a href="../downloads/excel/bee_soal_temp.xls" target="_blank" class="btn btn-success btn-sm" >
      		<i class="icon-cloud-download"></i>
      		Download template
      	</a>
      	<a href="?modul=daftar_soal" class="btn btn-success btn-sm">
      		<i class="icon-list"></i>
      		Lihat data soal
      	</a>
      </div>
    </div>
  </div>

  <div class="col-lg-12">
  	<div class="card">
  		<div class="card-header py-3">
  			<i class="icon-cloud-upload"></i>
  			Upload template excel - soal
  		</div>
  		<div class="card-body">
  			<form method="post" enctype="multipart/form-data" action="?modul=uploadsoal&mapel=<?= $_REQUEST['mapel']; ?>&soal=<?= $_REQUEST['soal']; ?>">
  			<div class="form-group">
	            <label>File excel daftar soal</label>
	            <input name="userfile" type="file" class="btn btn-default">
              <input type="hidden" name="txt_mapel" value="<?= $_REQUEST['mapel']; ?>">
              <input type="hidden" name="txt_mapel" value="<?= $_REQUEST['soal']; ?>">
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
if($_REQUEST['modul'] == "uploadsoal") {
  include "upload/excel_reader2.php";

  $xkodemapel = $_REQUEST['mapel'];
  $xkodesoal = $_REQUEST['soal'];

  $data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

  $baris = $data->rowcount($sheet_index=0);

  $baris +=1;

  $sukses = 0;
  $gagal = 0;

  for ($i = 3; $i< $baris; $i++)
  {
    $fieldz = $data->val($i, 1);
    $xnomer = $data->val($i, 1);
    $xjen     = $data->val($i, 2);
    $xkat     = $data->val($i, 3);
    $xacak    = $data->val($i,4);
    $xtanya     = $data->val($i, 5);
    $xjawab1    = $data->val($i, 6);
    $xfilejawab1  = $data->val($i, 7);
    $xjawab2    = $data->val($i, 8);
    $xfilejawab2  = $data->val($i, 9);  
    $xjawab3    = $data->val($i, 10);
    $xfilejawab3  = $data->val($i, 11);  
    $xjawab4    = $data->val($i, 12);
    $xfilejawab4  = $data->val($i, 13);  
    $xjawab5    = $data->val($i, 14);
    $xfilejawab5  = $data->val($i, 15);  
    $xaudio     = $data->val($i, 16);
    $xvideo     = $data->val($i, 17);
    $xgambar    = $data->val($i, 18);
    $xjwban     = $data->val($i, 19);
    $xacakopsi  = $data->val($i, 20);
    $xagama   = $data->val($i, 21);  
    
    $xtanya     = str_replace("'","`",$xtanya);
    $xjawab1    = str_replace("'","`",$xjawab1);
    $xjawab2    = str_replace("'","`",$xjawab2);  
    $xjawab3    = str_replace("'","`",$xjawab3);
    $xjawab4    = str_replace("'","`",$xjawab4);  
    $xjawab5    = str_replace("'","`",$xjawab5);

    if(!str_replace(" ","",$xkat)==""){ 
      $query = "INSERT INTO cbt_soal (XNomerSoal, XKodeMapel, XKodeSoal, XTanya, XJawab1, XGambarJawab1, XJawab2,XGambarJawab2, XJawab3,XGambarJawab3, XJawab4,XGambarJawab4, XJawab5,XGambarJawab5, XAudioTanya, XVideoTanya, XGambarTanya, XKunciJawaban,XJenisSoal,XKategori,XAcakSoal,XAcakOpsi,XAgama) VALUES ('$xnomer', '$xkodemapel','$xkodesoal','$xtanya','$xjawab1','$xfilejawab1','$xjawab2','$xfilejawab2','$xjawab3','$xfilejawab3','$xjawab4','$xfilejawab4','$xjawab5','$xfilejawab5','$xaudio','$xvideo','$xgambar','$xjwban','$xjen','$xkat','$xacak','$xacakopsi','$xagama')";
      $hasil = mysql_query($query);
      if ($hasil) $sukses++;
      else $gagal++;
    }
  }
  $percent = intval($i/$baris * 100)."%";

  echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-image:url(../../images/bar/pbar-ani1.gif);\">&nbsp;</div>";document.getElementById("information").innerHTML="  Proses Entri : Soal ... <b>'.$i.'</b> row(s) of <b>'. $baris.'</b> processed.";</script>';

  echo str_repeat(' ',1024*64);
  flush();
  echo '<script language="javascript">document.getElementById("information").innerHTML=" Proses update database Bank Soal : Completed"</script>';


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
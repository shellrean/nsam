<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Download File excel (Template administrasi user)
      </div>
      <div class="card-body">
      	<!-- <img src="../../images/xls.png"> -->
      	Upload data administrasi user untuk mempermudah pengelolaah user oleh admin yang meliputi 3 hak akses <br>
      	1. Admin : Hak penuh seluuh fitur <br>
      	2. Guru  : Hak fitur edit biodata banksoal dan analisa
      </div>
      <div class="card-footer">
      	<a href="../downloads/excel/bee_user_temp.xls" target="_blank" class="btn btn-success btn-sm" >
      		<i class="icon-cloud-download"></i>
      		Download template
      	</a>
      	<a href="?modul=data_user" class="btn btn-success btn-sm">
      		<i class="icon-list"></i>
      		Lihat data user
      	</a>
      </div>
    </div>
  </div>

  <div class="col-lg-12">
  	<div class="card">
  		<div class="card-header py-3">
  			<i class="icon-cloud-upload"></i>
  			Upload template excel - user
  		</div>
  		<div class="card-body">
  			<form method="post" enctype="multipart/form-data" action="?modul=uploaduser">
  			<div class="form-group">
	            <label>File excel daftar user</label>
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

if($_REQUEST['modul'] == "uploaduser") {
	include "excel_reader2.php";

	$data = new Spreadsheet_Excel_Reader($_FILES['userfile']['tmp_name']);

	$baris = $data->rowcount($sheet_index=0);

	$sukses = 0;
	$gagal = 0;

	echo "<div class='card'><div class='card-body'>";

	for($i=3; $i<= $baris; $i++) 
	{
		  $fieldz	= $data->val($i, 0);
  		$Username 	= $data->val($i, 1);
  		$Password  	= $data->val($i, 2);
  		$xnik   	= $data->val($i, 3);
  		$Nama  	= $data->val($i, 4);
  		$Alamat 	= $data->val($i, 5);
  		$HP 	= $data->val($i, 6);
  		$Faxs 	= $data->val($i, 7);
  		$Email 	= $data->val($i, 8);
  		$login  	= $data->val($i, 9);
  		$Status   	= $data->val($i, 10);
  		$xfoto  	= $data->val($i, 11);
  		$Password = md5($Password);
  		$Nama  	= str_replace("'","\'",$Nama);
  		$Nama  	= str_replace("'","`",$Nama);

  		if(!str_replace(" ", "", $Username) == "") {
  			$queryuser = "select Username from cbt_user where Username = '$Username' ";
  			$hasiluser = mysql_num_rows(mysql_query($queryuser));

  			if($hasiluser > 0) {
  				echo "<div class='tex-default'>Username <span class='text-danger'>$Username</span> Sudah Ada</div>";
		  		$gagal++;
  			}
  			else {
  				$query = "insert into cbt_user (Username,Password,NIP,Nama,Alamat,HP,Faxs,Email,login,Status,XPoto) VALUES 	('$Username','$Password','$xnik','$Nama','$Alamat','$HP','$Faxs','$Email','$login','$Status','$xfoto')";
		  		$hasil = mysql_query($query);
  				$sukses++;
  			}
  		}

  		$percent = intval($i/$baris * 100)."%";

  		echo '<script language="javascript">
    document.getElementById("progress").innerHTML="<div style=\"width:'.$percent.';background-image:url(../../images/bar/pbar-ani1.gif);\">&nbsp;</div>";
    document.getElementById("information").innerHTML="  Proses Entri : '.$Nama.' ... <b>'.$i.'</b> row(s) of <b>'. $baris.'</b> processed.";
    </script>';

    	echo str_repeat(' ', 1024*64);

    	flush();

	echo '<script language="javascript">document.getElementById("information").innerHTML=" Proses update database User : Completed"</script>';
	}
	echo "</table></div></div>";
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
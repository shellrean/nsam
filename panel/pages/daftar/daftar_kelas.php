<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}
 
include "../../config/server.php";
if(isset($_REQUEST['aksi'])) {
	$sql = mysql_query("delete from cbt_kelas where Urut='$_REQUEST[urut]'");
}

if(isset($_REQUEST['simpan'])) {
	$sql = mysql_query("update cbt_kelas set XKodeLevel = '$_REQUEST[txt_kodlev]', XNamaKelas='$_REQUEST[txt_namkel]', XKodeJurusan = '$_REQUEST[txt_jur]', XKodeKelas='$_REQUEST[txt_kodkel]', XKodeSekolah = '$_REQUEST[txt_kodesek]' where Urut = '$_REQUEST[id]'");
}

if(isset($_REQUEST['tambah'])) {
	$kelas 		= $_REQUEST['txt_kodkel'];
	$jurusan 	= $_REQUEST['txt_jur'];
	$namakelas	= $_REQUEST['txt_namkel'];
	$level 		= $_REQUEST['txt_kodlev'];
	$sqlcek1	= mysql_num_rows(mysql_query("select * from cbt_kelas where XNamaKelas='$namakelas'"));
	$sqlcek2 	= mysql_num_rows(mysql_query("select * from cbt_kelas where XKodeLevel = '$level' and XKodeKelas = '$kelas' and XKodeJurusan = '$jurusan'"));

	if($sqlcek1 > 0) {
		$message1 = "Nama kelas sudah ada";
		echo "<script>alert('$message1');</script>"; 
	} 
	else {
		if($sqlcek2 > 0) {
			$message2 = "Data kelas sudah ada";
		}
		else {
			if($_REQUEST['txt_kodkel'] == "" || $_REQUEST['txt_jur'] == "" || $_REQUEST['txt_kodlev'] == "" || $_REQUEST['txt_namkel'] == "") {
				$message = "Kolom tidak boleh ada yang kosong";
				echo "<script'>alert('$message');</script>";
			}
			else {
				$sql = mysql_query("insert into cbt_kelas (XKodeLevel, XNamaKelas, XKodeJurusan, XKodeKelas, XKodeSekolah) values ('$_REQUEST[txt_kodlev]','$_REQUEST[txt_namkel]','$_REQUEST[txt_jur]','$_REQUEST[txt_kodkel]','$_REQUEST[txt_kodesek]')");
			}
		}
	}
}

?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar kelas
        <button class="btn btn-success btn-sm pull-right" id='custId' data-toggle='modal' data-id='' data-target="#myTam">Tambah kelas & jurusan</button>
        <a href="daftar/down_excel_kelas.php" target="_blank" class="btn btn-success btn-sm pull-right mx-2">
          <i class="icon-cloud-download"></i> Download data
        </a>
        <a href="?modul=upl_kelas" class="btn btn-primary btn-sm pull-right">
          <i class="icon-cloud-download"></i> Upload data kelas
        </a>
      </div>
      <div class="card-body">
      	 <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode Sekolah</th>
              <th>Kode Level</th>
              <th>Kode Kelas</th>
              <th>Rombel</th>
              <th>Nama kelas</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          	<?php 
          	$no = 0;
          	$sql = mysql_query("select * from cbt_kelas order by Urut");
          	while($s = mysql_fetch_array($sql)) {
          		$no++;
          	?>
          	<tr>
          		<td><?= $no; ?></td>
          		<td><?= $s['XKodeSekolah'] ?></td>
          		<td><?= $s['XKodeLevel'] ?></td>
          		<td><?= $s['XKodeKelas'] ?></td>
          		<td><?= $s['XKodeJurusan'] ?></td>
          		<td><?= $s['XNamaKelas'] ?></td>
          		<td>
          			<a href="#myModal" id="custId" data-toggle="modal" data-id="<?= $s['Urut'] ?>" class="btn btn-primary btn-sm"><i class="icon-pencil"></i></a>
          			<a href="?modul=daftar_kelas&aksi=hapus&urut=<?= $s['Urut']; ?>" class="btn btn-danger btn-sm"><i class="icon-trash"></i></a>
          		</td>
          	</tr>
          	<?php } ?>
          </tbody>
      	</table>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="myTam" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah data kelas & rombel</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="?modul=daftar_kelas&tambah=yes" method="post">
        <div class="modal-body">
		  <div class="form-group">
            <label>Kode sekolah</label>
            <select class="form-control" name="txt_kodesek" id="txt_kodesek">
            	<option value="All">SEMUA (ALL)</option>
            	<?php 
				$sqlsek = mysql_query("select * from server_sekolah order by XServerId");
				while($sek = mysql_fetch_array($sqlsek)){
					echo "<option value='$sek[XServerId]'>$sek[XServerId] $sek[XSekolah]</option>";
				}
				?>
            </select>
          </div>
          <div class="form-group">
          	<label>Kode kelas</label>
          	<input type="text" class="form-control" name="txt_kodkel">
          </div>
          <div class="form-group">
          	<label>Nama kelas</label>
          	<input type="text" class="form-control" name="txt_namkel">
          </div>
          <div class="form-group">
          	<label>Kode level</label>
          	<input type="text" class="form-control" name="txt_kodlev">
          </div>
          <div class="form-gropu">
          	<label>Rombel</label>
          	<input type="text" class="form-control" name="txt_jur">
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
          <h5 class="modal-title">Edit data kelas</h5>
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
		let rowid = $(e.relatedTarget).data('id');
		$.ajax({
			type : 'post',
			url : 'daftar/edit_kelas.php',
			data : 'urut='+rowid,
			success(data) {
				$('.fetched-data').html(data)
			}
		})
	})
</script>
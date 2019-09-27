<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}
include "../../config/server.php";

if(isset($_REQUEST['aksi'])) {
	$sql = mysql_query("delete from cbt_mapel where Urut='$_REQUEST[urut]'");
}

if(isset($_REQUEST['simpan'])) {
	$sql = mysql_query("update cbt_mapel set XKodeMapel = '$_REQUEST[txt_kokel]',
		XNamaMapel = '$_REQUEST[txt_nakel]',
		XPersenUH = '$_REQUEST[txt_UH]',
		XPersenUTS = '$_REQUEST[txt_UTS]',
		XPersenUAS = '$_REQUEST[txt_UAS]',
		XKKM = '$_REQUEST[txt_KKM]',
		XMapelAgama = '$_REQUEST[txt_mapelagama]',
		XKodeSekolah = '$_REQUEST[txt_kodesek]' where Urut='$_REQUEST[id]'");
}

if(isset($_REQUEST['tambah'])) {
	$sqlcek = mysql_num_rows(mysql_query("select * from cbt_mapel where XKodeMapel = '$_REQUEST[txt_kokel]'"));
	if($sqlcek>0) {
		$message = "Kode mapel sudah ada";
		echo "<script>alert('$message
		');</script>";
	}
	else {
		$sql = mysql_query("insert into cbt_mapel (XKodeMapel, XNamaMapel, XPersenUH, XPersenUTS, XPersenUAS, XKKM, XMapelAgama, XKodeSekolah) values ('$_REQUEST[txt_kokel]','$_REQUEST[txt_nakel]','$_REQUEST[txt_UH]','$_REQUEST[txt_UTS]','$_REQUEST[txt_UAS]','$_REQUEST[txt_KKM]','$_REQUEST[txt_mapelagama]','$_REQUEST[txt_kodesek]')");
	}
}
?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar mata pelajaran
        <button class="btn btn-success btn-sm pull-right" id='custId' data-toggle='modal' data-id='' data-target="#myTam">Tambah mapel</button>
        <a href="daftar/down_excel_mapel.php" target="_blank" class="btn btn-success btn-sm pull-right mx-2">
          <i class="icon-cloud-download"></i> Download data mapel
        </a>
        <a href="?modul=upl_mapel" class="btn btn-primary btn-sm pull-right">
          <i class="icon-cloud-download"></i> Upload data mapel
        </a>
      </div>
      <div class="card-body">
      	 <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode sekolah</th>
              <th>Kode mapel</th>
              <th>Mata pelajaran</th>
              <th>Harian(%)</th>
              <th>UTS(%)</th>
              <th>UAS(%)</th>
              <th>KKM</th>
              <th>Jenis Mapel</th>
              <td>Aksi</td>
            </tr>
          </thead>
          <tbody>
          	<?php 
          	$no = 0;
          	$sql = mysql_query("select * from cbt_mapel order by Urut");
          	while($s = mysql_fetch_array($sql)){
          		$no++;
          	?>
          	<tr>
          		<td><?= $s['Urut'] ?></td>
          		<td><?= $s['XKodeSekolah']; ?></td>
          		<td>
          			<?= $s['XKodeMapel']; ?>
          		</td>
          		<td>
          			<?= $s['XNamaMapel']; ?>
          		</td>
          		<td>
          			<?= $s['XPersenUH']; ?>
          		</td>
          		<td>
          			<?= $s['XPersenUTS']; ?>
          		</td>
          		<td>
          			<?= $s['XPersenUAS']; ?>
          		</td>
          		<td>
          			<?= $s['XKKM']; ?>
          		</td>
          		<td>
          			<?= $s['XMapelAgama']; ?>
          		</td>
          		<td>
          			<a href="#myModal" id="custId" data-toggle="modal" data-id="<?= $s['Urut'] ?>" class="btn btn-primary btn-sm">
          				<i class="icon-pencil"></i>
          			</a>
          			<a href="?modul=daftar_mapel&aksi=hapus&urut=<?= $s['Urut'] ?>" class="btn btn-danger btn-sm">
          				<i class="icon-trash"></i>
          			</a>
          		</td>
          	</tr>
          	<?php 
          	} ?>
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
          <h5 class="modal-title">Tambah data mapel</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="?modul=daftar_mapel&tambah=yes" method="post">
        <div class="modal-body">
        	<div class="form-group">
        		<label>Kode sekolah</label>
        		 <select class="form-control" name="txt_kodesek" id="txt_kodesek">
        		 	 <?php 
                        $sqlsek = mysql_query("select * from server_sekolah order by XServerId");
                        while($sek = mysql_fetch_array($sqlsek)){
                        echo "<option value='$sek[XServerId]'>$sek[XServerId] $sek[XSekolah]</option>";
                        }
                        ?>
						<option value='ALL'>SEMUA</option>
        		 </select>
        	</div>
        	<div class="row">
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Kode mapel</label>
        				<input type="text" class="form-control" name="txt_kokel">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Nama mapel</label>
        				<input type="text" class="form-control" name="txt_nakel">
        			</div>
        		</div>
        	</div>
        	<div class="form-group">
        		<label>Tipe mapel</label>
        		<select id="txt_mapelagama"  name="txt_mapelagama" class="form-control" >
        			<option value='N' class='form-control' >MAPEL UMUM</option>
					<option value='Y' class='form-control' >PEMINATAN</option> <option value='A' class='form-control' >PEND. AGAMA</option>
        		</select>
        	</div>
        	<div class="row">
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Peren Harian</label>
        				<input type="text" class="form-control" name="txt_UH">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Persen UTS</label>
        				<input type="text" class="form-control" name="txt_UTS">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Persen UAS</label>
        				<input type="text" class="form-control" name="txt_UAS">
        			</div>
        		</div>
        		<div class="col-md-6">
        			<div class="form-group">
        				<label>Nilai KKM</label>
        				<input type="text" class="form-control" name="txt_KKM">
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
          <h5 class="modal-title">Edit data mapel</h5>
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
			url : 'daftar/edit_mapel.php',
			data : 'urut='+ rowid,
			success(data) {
				$('.fetched-data').html(data)
			}
		})
	})
</script>
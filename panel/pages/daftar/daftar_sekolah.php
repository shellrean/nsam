<?php
if(!isset($_COOKIE['beeuser'])){
	header('Location: login.php');
}

include "../../config/server.php";

if(isset($_REQUEST['aksi'])) {
	$sql = mysql_query("delete from server_sekolah where Urut = '$_REQUEST[urut]'");
}

if(isset($_REQUEST['aksi1'])) {
	$sqlcek = mysql_query("select * from server_sekolah where Urut = '$_REQUEST[urut]'");
	$sta	= mysql_fetch_array($sqlcek);
	$status = $sta['XStatus'];
	if($status == "1") {
		$ubah = "0";
	}
	elseif($status == "0") {
		$ubah = "1";
	}

	$sqlpasaif = mysql_query("update server_sekolah set XStatus = '$ubah' where Urut = '$_REQUEST[urut]'");
}

if(isset($_REQUEST['reset'])) {
	$sqlres = mysql_query("select * from server_sekolah where XServerId = '$_REQUEST[server]'");
	$stares = mysql_fetch_array($sqlres);
	$stres  = $stares['XStatus'];

	if($stres == "0") {
		$res = "0";
	}
	elseif($stres == "1") {
		$res = "0";
	}
	elseif ($stres=="2"){$res = "0";}

	$reset1 = mysql_query("update server_sekolah set XStatusSinc = '$res' where XServerId = '$_REQUEST[server]'");
	$reset0 = mysql_query("update cbt_sinc set XData1 = '0', XData2 = '0', XData3 = '0', XData4 = '0', XData5 = '0', XData6 = '0', XData7 = '0', XData8 = '0', XData9 = '0', XData10 = '0', XData11 = '0', XData12 = '0' where XServerId = '$_REQUEST[server]'");
}

if(isset($_REQUEST['simpan'])) {
	$sql = mysql_query("update server_sekolah set XServerId = '$_REQUEST[txt_kodsek]', XSekolah = '$_REQUEST[txt_namsek]', XAlamatSek = '$_REQUEST[txt_alsek]' where Urut = '$_REQUEST[urut]'");
}

if(isset($_REQUEST['tambah'])) {
	$sekolah = addslashes($_REQUEST['txt_namsek']);
	$sqlcek  = mysql_num_rows(mysql_query("select * from server_sekolah where XServerId = '$_REQUEST[txt_kodsek]'"));

	if($sqlcek > 0) {
		$message = "Kode Sekolah telah digunakan";
		echo "<script>alert('$message');</script>";
	}
	else {
		if(!$_REQUEST['txt_kodsek'] == "") {
			$sql = mysql_query("insert into server_sekolah (XServerId, XSekolah, XAlamatSek, XStatus) values  ('$_REQUEST[txt_kodsek]','$sekolah','$_REQUEST[txt_alsek]','1')");
		}
		else {
			echo "<script>alert('oke');</script>";
		}
	}
}

?>


<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar sekolah
        <button class="btn btn-success btn-sm pull-right" id='custId' data-toggle='modal' data-id='' data-target="#myTam">Tambah sekolah</button>
      </div>
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode sekolah</th>
              <th>Nama sekolah</th>
              <th>Alamat</th>
              <th>Status<br>Sinkron</th> 
              <th>Reset<br>Sinkron</th>
              <th>Status<br>Server</th>
              <th>Tindakan</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          	$sql = mysql_query("select * from server_sekolah order by XServerId");
          	$no = 0;
          	while($s = mysql_fetch_array($sql)) {
          		$stts = $s['XStatus'];
          		if(mysql_query("select * from cbt_sinc limit 1") == true) {
          			$ssync = $s['XStatusSinc'];
          		}
          		else {
          			$ssync = 3;
          		}

          		$no++;
          		?>

          		<tr>
          			<td><?= $no; ?></td>
          			<td><?= $s['XServerId'] ?></td>
          			<td><?= $s['XSekolah'] ?></td>
          			<td><?= $s['XAlamatSek'] ?></td>
          			<td>
          				<?php
          				if($ssync == 0) {
          					echo "Belum";
          				} elseif($ssync == 2) {
          					echo "Sukses";
          				}
          				elseif($ssync == 1) {
          					echo "Sedang Proses";
          				}
          				elseif($ssync == 3) {
          					echo "Tanpa Batas";
          				}
          				?>
          			</td>
          			<td>
          				<?php if($ssync == "3") {
          					echo "Tanpa Reset";
          				} else { ?>
          					<a href="?modul=data_skul&reset&server=<?= $s['XServerId']; ?>" class="btn btn-default btn-sm">
          						<i class="icon-refresh"></i>
          					</a>
          				<?php } ?>
          			</td>
          			<td>
          				<a href="?modul=data_skul&aksi1=status&urut=<?= $s['Urut'] ?>">
          					<?php if($stts == "1") { ?>
          						<button type="button" class="btn btn-success btn-sm">Aktif</button>
          					<?php } else { ?>
          						<button type="button" class="btn btn-default btn-sm">Non Aktif</button>
          					<?php } ?>
          				</a>
          			</td>
          			<td>
          				<a href="#myModal" id="custId" data-toggle="modal" data-id="<?= $s['Urut'] ?>" class="btn btn-primary btn-sm"><i class="icon-pencil"></i></a>
          				<a href="?modul=data_skul&aksi=hapus&urut=<?= $s['Urut'] ?>" class="btn btn-danger btn-sm"><i class="icon-trash"></i></a>
          			</td>
          		</tr>

          	<script>
          		$(document).ready(function() {
          			$("#simpan1<?= $s['Urut'] ?>").click(function() {
          				$.ajax({
							type:"POST",
							url:"simpan_sekolah.php",
							data :  'urut='+ rowid,
							success: function(data){
							document.location.reload();
							loading.fadeOut();
							tampilkan.html(data);
							tampilkan.fadeIn(100);
							tampildata();
							window.location.reload();
							}
						});
          			})
          		})
          	</script>
          	<?php } ?>
          </tbody>
        </table>
      </div>
    </form>
    </div>
  </div>
</div>


<!-- Modal Tambah Data -->
<div class="modal fade" id="myTam" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="?modul=data_skul&tambah=yes" method="post" >
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Tambah data sekolah</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="form-pesan"></div>
          <div class="form-group">
            <label>Nama sekolah</label>
            <input type="text" class="form-control" name="txt_namsek">
          </div>
          <div class="form-group">
          	<label>Alamat sekolah</label>
          	<input type="" class="form-control" name="txt_alsek">
          </div>
          <div class="fetched-data2"></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Tambah</button>
        </div>
    </div>
    </form>
  </div>
</div>

<!-- Modal Tambah Data -->
<div class="modal fade" id="myModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit data sekolah</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="fetched-data"></div>
    </div>
  </div>
</div>

<script >
	$('#appTable').DataTable();
	$(document).ready(function() {
		$('#myModal').on('show.bs.modal', function(e) {
			var rowid = $(e.relatedTarget).data('id');
			$.ajax({
				type : 'post',
				url  : 'daftar/edit_sekolah.php',
				data : 'urut='+ rowid,
				success: function(data) {
					$('.fetched-data').html(data);
				}
			})
		})
	})
</script>
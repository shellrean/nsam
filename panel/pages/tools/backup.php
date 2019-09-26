<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

if(!empty($_REQUEST['datax'])&&$_REQUEST['datax']=="ujian"){include "../../database/cbt_ujian.php";}
if(!empty($_REQUEST['datax'])&&$_REQUEST['datax']=="siswa"){include "../../database/cbt_siswa.php";}
if(!empty($_REQUEST['datax'])&&$_REQUEST['datax']=="media"){include "../../database/cbt_media.php";}
if(!empty($_REQUEST['datax'])&&$_REQUEST['datax']=="semua"){include "../../database/cbt_semua.php";}
if(!empty($_REQUEST['datax'])&&$_REQUEST['datax']=="hasil"){include "../../database/cbt_hasil_ujian.php";}

include "../../config/server.php"
?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-database"></i> Backup database 
      </div>
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Jenis data</th>
              <th>Backup database</th>
              <th>Hapus & backup</th>
            </tr>
          </thead>
          <tbody>
          	<tr>
          		<td>
          			1<input type="hidden" value="<?= $s['Urutan'] ?>" id="txt_mapel<?= $s['Urutan'] ?>">
          		</td>
          		<td>
          			Data sistem : mapel, kelas, siswa
          		</td>
          		<td>
          			<a href="?modul=backup&datax=siswa&aksi=1" class="btn btn-success btn-sm">
          				<i class="icon-folder-alt"></i> backup
          			</a>
          		</td>
          		<td>
          			<a href="?modul=backup&datax=siswa&aksi=2" class="btn btn-danger btn-sm">
          				<i class="icon-close"></i>
          				Hapus
          			</a>
          		</td>
          	</tr>
          	<tr>
          		<td>
          			2 <input type="hidden" value="<?= $s['Urutan'] ?>" id="txt_mapel<?= $s['Urutan'] ?>">
          		</td>
          		<td>
          			Semua data ujian: banksoal, data hasil ujian dan media pendukung
          		</td>
          		<td>
          			<a href="?modul=backup&datax=ujian&aksi=1" class="btn btn-success btn-sm">
          				<i class="icon-folder-alt"></i> backup
          			</a>
          		</td>
          		<td>
          			<a href="?modul=backup&datax=ujian&aksi=2" class="btn btn-sm btn-danger">
          				<i class="icon-close"></i>
          				Hapus
          			</a>
          		</td>
          	</tr>
          	<tr>
          		<td>
          			3 <input type="hidden" value="<?= $s['Urutan'] ?>" id="txt_mapel<?= $s['Urutan'] ?>">
          		</td>
          		<td>
          			Data hasil ujian: data ujian(kecuali bansoal dan nilai)
          		</td>
          		<td>
          			<a href="?modul=backup&datax=hasil&aksi=1" class="btn btn-success btn-sm">
          				<i class="icon-folder-alt"></i> backup
          			</a>
          		</td>
          		<td>
          			<a href="?modul=backup&datax=hasil&aksi=2" class="btn btn-danger btn-sm">
          				<i class="icon-close"></i>
          				Hapus
          			</a>
          		</td>
          	</tr>
          	<tr>
          		<td>
          			4 <input type="hidden" value="<?= $s['Urutan'] ?>" id="txt_mapel<?= $s['Urutan'] ?>">
          		</td>
          		<td>
          			Data media pendukung (hanya data SQLnya, file mdia tidak dihapus)
          		</td>
          		<td>
          			<a href="?modul=backup&datax=media&aksi=1" class="btn btn-success btn-sm">
          				<i class="icon-folder-alt"></i> backup
          			</a>
          		</td>
          		<td>
          			<a href="?modul=backup&datax=media&aksi=2" class="btn btn-danger btn-sm">
          				<i class="icon-close"></i>
          				Hapus
          			</a>
          		</td>
          	</tr>
          	<tr>
          		<td>
          			5 <input type="hidden" value="<?= $s['Urutan'] ?>" id="txt_mapel<?= $s['Urutan'] ?>">
          		</td>
          		<td>
          			Semua database
          		</td>
          		<td>
          			<a href="?modul=backup&datax=semua&aksi=1" class="btn btn-success btn-sm">
          				<i class="icon-folder-alt"></i>
          				backup
          			</a>
          		</td>
          		<td>
          			<a href="?modul=backup&datax=semua&aksi=2" class="btn btn-danger btn-sm">
          				<i class="icon-close"></i>
          				Hapus
          			</a>
          		</td>
          	</tr>
          </tbody>
        </table>
        <form action="?modul=restore" method="post">
        <input type="file" id="anu" name="anu">
        <button type="submit" class="btn btn-success btn-sm">
          <i class="icon-refresh"></i> restore
        </button>
      </div>
     </form>
      <div class="card-footer">
      	<small class="icon-info"></small>
      	Selain menghapus, juga akan membackup database sesuai pilihan, yang bisa direstor lagi suatu satat dibutukan. <br>
      	<small class="icon-info"></small>
      	Lokasi file backup anda, silahkan Lihat folder => C:/NSAM-Backup/nsam/

      </div>
    </div>
  </div>
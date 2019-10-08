<?php
  if(!isset($_COOKIE['beeuser'])) {
    header("Location: login.php");
  }
  include "../../config/server.php";

  if(isset($_REQUEST['aksi'])) {
    $sql = mysql_query("delete from cbt_ujian where Urut = '$_REQUEST[urut]'");
  }

  if(isset($_REQUEST['simpan'])) {
    $sql = mysql_query("update cbt_ujian set XTokenUjian = '$_REQUEST[txt_token]', XKodeUjian = '$_REQUEST[txt_koduji]',XKodeKelas = '$_REQUEST[txt_kodkel]',XKodeJurusan = '$_REQUEST[txt_jur]', XSesi = '$_REQUEST[txt_sesi]', XKodeSoal = '$_REQUEST[txt_kodsoal]',XTglUjian = '$_REQUEST[txt_tuji]',XJamUjian = '$_REQUEST[txt_juji]',XLamaUjian='$_REQUEST[txt_durasi]',XBatasMasuk ='$_REQUEST[txt_bmasuk]',XTampil = '$_REQUEST[txt_hasil]',XStatusToken ='$_REQUEST[txt_statustoken]',XListening = '$_REQUEST[txt_listen]',XStatusUjian = '$_REQUEST[txt_suji]',XPdf='$_REQUEST[txt_xpdf]',XFilePdf='$_REQUEST[txt_filepdf]',XPdf='$_REQUEST[txt_xpdf]',XFilePdf='$_REQUEST[txt_filepdf]' where Urut = '$_REQUEST[id]'");
  }

  if(isset($_REQUEST['tambah'])){

    $sqlcek = mysql_num_rows(mysql_query("select * from cbt_kelas where XKodeKelas = '$_REQUEST[txt_kodkel]'"));
      if($sqlcek>0){
      $message = "Kode Kelas SUDAH ADA";
      echo "<script type='text/javascript'>alert('$message');</script>";
      } else {
        if(!$_REQUEST['txt_kodkel']==""||!$_REQUEST['txt_jur']==""){
        $sql = mysql_query("insert into cbt_kelas (XKodeLevel, XNamaKelas, XKodeJurusan,XKodeKelas, XKodeSekolah) values  
        ('$_REQUEST[txt_kodlev]','$_REQUEST[txt_namkel]','$_REQUEST[txt_jur]','$_REQUEST[txt_kodkel]','$_REQUEST[txt_kodesek]')");
        }
      }
  }

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
        <i class="fa fa-align-justify"></i> Data & Jadwal Ujian
      </div>
      <div class="card-body">
      	 <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode Ujian</th>
              <th>Kelas</th>
              <th>Kode Mapel</th>
              <th>Kode Soal</th>
              <th>Tgl Ujian</th>
              <th>Ujian Mulai</th>
              <th>Ujian Tutup</th>
              <th>Status</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $no = 0;
            $sql = mysql_query("select u.*,m.*,u.Urut as Urut, u.XKodeKelas as kokel from cbt_ujian u left join cbt_mapel m on m.XKodeMapel = u.XKodeMapel left join cbt_paketsoal p on p.XKodeSoal = u.XKodeSoal where u.XStatusUjian = '1'");

            while($s = mysql_fetch_array($sql)):

            $time1 = $s['XJamUjian'];
            $time2 = $s['XLamaUjian'];

            $secs = strtotime($time2)-strtotime("00:00:00");
            $jamhabis = date("H:i:s",strtotime($time1)+$secs);
            $sekarang = date("H:i:s");
            $tglsekarang = date("Y-m-d");
            $tglujian = $s['XTglUjian'];
            $no++;

            if($s['XStatusUjian'] == "0" || $s['XStatusUjian'] == "9" || $tglsekarang > $tglujian || $sekarang > $jamhabis) {
              $status = "Selesai dikerjakan";
            }
            elseif($tglsekarang == $tglujian&&$sekarang<$time1) {
              $status = "Akan dikerjakan";
            }
            else {
              $status = "Sedang dikerjakan";
            }
          ?>
          <tr>
            <td>
              <input type="hidden" value="<?= $s['Urutan']; ?>" id="txt_mapel<?= $s['Urutan']; ?>">
              <?= $no; ?>
              <input type="hidden" value="<?= $s['Urutan']; ?>" id="txt_soal<?= $s['Urutan']; ?>">
            </td>
            <td><?= $s['XKodeUjian']; ?></td>
            <td><?= $s['kokel'].' - '.$s['XKodeJurusan']; ?></td>
            <td><?= $s['XKodeMapel']. ' - '.$s['XNamaMapel']; ?></td>
            <td><?= $s['XKodeSoal']; ?></td>
            <td><?= $s['XTglUjian']; ?></td>
            <td><?= $s['XJamUjian']; ?></td>
            <td><?= $s['XBatasMasuk']; ?></td>
            <td><?= $status; ?></td>
            <td>
              <a href="#myModal" id="custId" data-toggle="modal" data-id="<?= $s['Urut']; ?>" class="btn btn-sm btn-primary"><i class="icon-pencil"></i></a>
            </td>
          </tr>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
  <div class="modal fade" id="myModal" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Edit jadwal dan data ujian</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="fetched-data"></div>
            </div>
        </div>
    </div>
 

<script>
  $(document).ready(function() {
    $('#myModal').on('show.bs.modal', function(e) {
      let rowid = $(e.relatedTarget).data('id');

      $.ajax({
        type : 'post',
        url: 'daftar/edit_waktu.php',
        data: 'urut='+ rowid,
        success(data) {
          $('.fetched-data').html(data);
        }
      })
    })
  })
</script>
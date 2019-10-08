<?php
  if(!isset($_COOKIE['beeuser'])) {
    header("Location: login.php");
  }
  include "../../config/server.php";

  if(isset($_REQUEST['aksi'])) {
    $sql = mysql_query("delete from cbt_ujian where Urut = '$_REQUEST[urut]'");
  }

  if(isset($_REQUEST['simpan'])) {
    $sql = mysql_query("update cbt_ujian set XTokenUjian = '$_REQUEST[txt_token]', XKodeUjian = '$_REQUEST[txt_koduji]',XKodeKelas = '$_REQUEST[txt_kodkel]',XKodeJurusan = '$_REQUEST[txt_jur]', XSesi = '$_REQUEST[txt_sesi]', XKodeSoal = '$_REQUEST[txt_kodsoal]',XTglUjian = '$_REQUEST[txt_tuji]',XJamUjian = '$_REQUEST[txt_juji]',XLamaUjian='$_REQUEST[tt_durasi]',XBatasMasuk ='$_REQUEST[txt_bmasuk]',XTampil = '$_REQUEST[txt_hasil]',XStatusToken ='$_REQUEST[txt_statustoken]',XListening = '$_REQUEST[txt_listen]',XStatusUjian = '$_REQUEST[txt_suji]',XPdf='$_REQUEST[txt_xpdf]',XFilePdf='$_REQUEST[txt_filepdf]',XPdf='$_REQUEST[txt_xpdf]',XFilePdf='$_REQUEST[txt_filepdf]' where Urut = '$_REQUEST[id]'");
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

          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
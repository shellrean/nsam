<?php
  if(!isset($_COOKIE['beeuser'])) {
    header("Location: login.php");
  }

  include "../../config/server.php";

?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Daftar hasil ujian
        <?php $esai = mysql_num_rows(mysql_query("SELECT * FROM cbt_jawaban where XJenisSoal='2'"));
        if ($esai>0){$herf="daftar/down_excel_esai.php"; $kata="";}
        else{$herf=""; $kata="disabled";}?>
        <a href="<?= $herf; ?>" target="_blank">
          <button type="button" class="btn btn-success btn-sm pull-right" id="download" <?= $kata; ?>> <i class='fa fa-cloud-download  '></i> Jawaban ESAI Excel </button>
         </a>
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode</th>
              <th>Mata pelajaran</th>
              <th>Soal</th>
              <th>Kelas</th> 
              <th>Pembuat soal</th>
              <th>Rekap nilai</th>
              <th>Analisa hasil</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $no = 0;
            if($_COOKIE['beelogin']=='admin'){
              $sql = mysql_query("select p.*,m.*,p.Urut as Urutan,p.XKodeKelas  as kokel from cbt_paketsoal p left join cbt_mapel m on m.XKodeMapel = 
                p.XKodeMapel order by p.Urut desc");
            } else {
              $sql = mysql_query("select p.*,m.*,p.Urut as Urutan,p.XKodeKelas  as kokel from cbt_paketsoal p left join cbt_mapel m on m.XKodeMapel = 
                p.XKodeMapel where p.XGuru='$_COOKIE[beeuser]' order by p.Urut desc");                
            }

            while($s = mysql_fetch_array($sql)){ 
            $sqlsoal = mysql_num_rows(mysql_query("select * from cbt_soal where XKodeSoal = '$s[XKodeSoal]'"));
            $sqljawab = mysql_num_rows(mysql_query("select * from cbt_jawaban where XKodeSoal = '$s[XKodeSoal]'"));
            $sqlpakai = mysql_num_rows(mysql_query("select * from cbt_nilai where XKodeSoal = '$s[XKodeSoal]'"));
            $sqlpakai2 = mysql_num_rows(mysql_query("select * from cbt_siswa_ujian where XKodeSoal = '$s[XKodeSoal]' and XStatusUjian = '1'"));
            if($sqlsoal<1){$kata="disabled";$alink="";}  else {$kata=""; $alink = "tools/rekapexcel.php?soal=$s[XKodeSoal]&mapel=$s[XKodeMapel]&kelas=$s[XKodeKelas]";} 
            if($sqlpakai2>0){$katapakai="disabled";$alink="";}  else {$katapakai="";$alink = "tools/rekapexcel.php?soal=$s[XKodeSoal]&mapel=$s[XKodeMapel]&kelas=$s[XKodeKelas]";}
            if($sqljawab<1){$katapakai="disabled";$alink="";}  else {$katapakai="";$alink = "tools/rekapexcel.php?soal=$s[XKodeSoal]&mapel=$s[XKodeMapel]&kelas=$s[XKodeKelas]";}
            if($sqlpakai2>0){$katapakai2="disabled";$alink2="";}  else {$katapakai2="";$alink2 = "?modul=analisajawaban&soal=$s[XKodeSoal]&kelas=$s[XKodeKelas]";}                
            $no++  ;
          ?>
          <tr>
            <td>
              <input type="hidden" value="<?= $s['Urutan']; ?>" id="txt_mapel<?= $s['Urutan']; ?>">
              <?= $no; ?>
            </td>
            <td><?= $s['XKodeSoal']; ?></td>
            <td><?= $s['XNamaMapel']; ?></td>
            <td><?= $sqlsoal.'('.$s['XJumPilihan'].' Pilihan)'; ?></td>
            <td><?= $s['kokel'].' - '.$s['XKodeJurusan']; ?></td>
            <td><?= $s['XGuru']; ?></td>
            <td>
              <a href=<?= $alink; ?> target="_blank">
                <button type="button" class="btn btn-primary btn-sm" <?= $katapakai; ?> <?= $katapakai2; ?>><i class="fa fa-cloud-download"></i></button>
              </a>
            </td>
            <td>
              <a href=<?= $alink2; ?>>
                <button type="button" class="btn btn-primary btn-sm" <?= $katapakai; ?> <?= $katapakai2; ?>><i class="fa fa-bar-chart-o"></i></button>
              </a>
            </td>
            <td><?= ($s['XStatusSoal'] == "Y") ? 'Aktif' : 'Non Aktif'; ?></td>
          </tr>
          <?php } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<?php
  if(!isset($_COOKIE['beeuser'])){
  header("Location: login.php");}
  include "../../config/server.php";
  $xadm = mysql_fetch_array(mysql_query("select * from cbt_admin"));
  $skul_tkt= $xadm['XTingkat']; 
  if ($skul_tkt=="SMA" || $skul_tkt=="MA"||$skul_tkt=="STM"){$rombel="Jurusan";}else{$rombel="Rombel";} 

?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Analisa soal dan hasil jawaban
        <button class="btn btn-success btn-sm pull-right" id='custId' data-toggle='modal' data-id='' data-target="#myTam">Analisa butir soal</button>
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr> 
              <th>No.</th>
              <th>No. Ujian</th>
              <th>Ujian</th>
              <th>Nama</th>
              <th>Kelas</th> 
              <th>Rombel</th>
              <th>Token</th>
              <th>Nilai esai</th>
              <th>Skoring esai</th>
              <th>Hasil pg|esai</th>
            </tr>
          </thead> 
          <tbody>
          <?php
            $sql = mysql_query("select * from cbt_siswa_ujian c left join cbt_siswa s on s.XNomerUjian = c.XNomerUjian  left join cbt_ujian u on u.XTokenUjian = c.XTokenUjian  where c.XKodeSoal = '$_REQUEST[soal]'");
            $no = 1;
            while($s = mysql_fetch_array($sql)):
            
            $sqlsoal = mysql_num_rows(mysql_query("select * from cbt_soal where XKodeSoal = '$s[XKodeSoal]'"));
            $sqlpakai = mysql_num_rows(mysql_query("select * from cbt_nilai where XKodeSoal = '$s[XKodeSoal]'"));
            $sqljumlahx = mysql_query("select sum(XNilaiEsai) as hasil from cbt_jawaban where XKodeSoal = '$s[XKodeSoal]' and XUserJawab = 
            '$s[XNomerUjian]' and XTokenUjian = '$s[XTokenUjian]'");
            $o = mysql_fetch_array($sqljumlahx);
            $cekjum = mysql_num_rows($sqljumlahx);
            $nilaiawal = round($o['hasil'],2);
            $sqljur = mysql_query("SELECT * FROM `cbt_siswa` WHERE XNamaSiswa= '$s[XNamaSiswa]' ");
            $sjur = mysql_fetch_array($sqljur);
            $kojur = $sjur['XKodeJurusan'];
          ?>
          <tr>
            <td>
              <input type="hidden" value="<?= $s['Urutan']; ?>" id="txt_mapel<?= $s['Urut']; ?>">
              <?= $no; ?>
            </td>
            <td><?= $s['XNomerUjian']; ?></td>
            <td><?= $s['XKodeUjian']; ?></td>
            <td><?= $s['XNamaSiswa']; ?></td>
            <td><?= $s['XKodeKelas']; ?></td>
            <td><?= $kojur; ?></td>
            <td><?= $s['XTokenUjian']; ?></td>
            <td><?= $nilaiawal; ?></td>
            <td>
              <a href=?modul=lks&soal=<?php echo $s['XKodeSoal']; ?>&siswa=<?php echo $s['XNomerUjian']; ?>&token=<?php echo $s['XTokenUjian']; ?>>
                    <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-file-text-o"></i></button></a>
            </td>
            <td>
              <a href=?modul=jawabansiswa&soal=<?php echo $s['XKodeSoal']; ?>&siswa=<?php echo $s['XNomerUjian']; ?>&token=<?php echo $s['XTokenUjian']; ?>>
                      <button type="button" class="btn btn-success btn-sm"><i class="fa fa-file-text-o"></i></button>
                    </a>
                    <a href=?modul=jawabanesai_siswa&soal=<?php echo $s['XKodeSoal']; ?>&siswa=<?php echo $s['XNomerUjian']; ?>&token=<?php echo $s['XTokenUjian']; ?>>
                      <button type="button" class="btn btn-primary btn-sm"><i class="fa fa-file-text-o"></i></button>
                    </a>  
            </td>
          </tr>

          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
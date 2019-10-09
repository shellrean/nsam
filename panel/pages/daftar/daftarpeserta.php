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
        <i class="fa fa-align-justify"></i> Data jadwal ujian
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Nomer peserta</th>
              <th>Nama siswa</th>
              <th>kelas - rombel</th>
              <th>NIS/NISN</th> 
              <th>Status tes peserta</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $sqlad = mysql_query("select * from cbt_admin");
            $ad = mysql_fetch_array($sqlad);

            $tingkat = $ad['XTingkat'];

            $sql = mysql_query("SELECT *,u.XStatusUjian as ujsta FROM cbt_siswa s LEFT JOIN `cbt_siswa_ujian` u ON u.XNomerUjian = s.XNomerUjian
        LEFT JOIN cbt_ujian c ON (u.XKodeSoal = c.XKodeSoal and u.XTokenUjian = c.XTokenUjian) WHERE c.XStatusUjian = '1'"); 

            $nom = 1; 

            while($s= mysql_fetch_array($sql)){ 
            $nama = str_replace("  ","",$s['XNamaSiswa']); 
            $nouji = str_replace("  ","",$s['XNomerUjian']); 
            $kodekelas = str_replace("  ","",$s['XKodeKelas']); 
            $kodeNIK = str_replace("  ","",$s['XNIK']); 
            $kodeJUR = str_replace("  ","",$s['XKodeJurusan']); 
            $staujian = str_replace("  ","",$s['ujsta']); 
            if($staujian =='0'){$staujian = "Belum Login";}
            elseif($staujian =='1'){$staujian = "<font color='#629ad8'> Masih Dikerjakan </font>";}
            elseif($staujian =='9'){$staujian = "<font color='#be425f'> Tes SELESAI </font>";}    
          ?>
          <tr>
            <td><?= $nom; ?></td>
            <td><?= $nouji; ?></td>
            <td><?= $nama; ?></td>
            <td><?= $kodekelas.' - '.$kodeJUR; ?></td>
            <td><?= $kodeNIK; ?></td>
            <td><?= $staujian; ?></td>
          </tr>
          <?php   $nom++; } ?>
          </tbody>
          </table>
      </div>
    </div>
  </div>
</div>

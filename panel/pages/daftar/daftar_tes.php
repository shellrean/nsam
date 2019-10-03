<?php
  if(!isset($_COOKIE['beeuser'])) {
    header("Location: login.php");
  }

  if(isset($_REQUEST['statustoken'])) {
    $sqlcek = mysql_query("select * from cbt_ujian order by XStatusToken");
    $stat = mysql_fetch_array($sqlcek);
    $status = $stat['XStatusToken'];
    if($status==0){ $ubah = 1; } 
    elseif($status==1){ $ubah = 0; }
    $sqlpasaif = mysql_query("update cbt_ujian set XStatusToken = '$ubah'");
  }

  if(isset($_REQUEST['hasiltampil'])) {
    $sqlcekh = mysql_query("select * from cbt_ujian order by XTampil");
    $sh = mysql_fetch_array($sqlcekh);
    $statush= $sh['XTampil'];
    if($statush==0){ $ubahh = 1; } 
    elseif($statush==1){ $ubahh = 0; }
    $sqlpasaifh = mysql_query("update cbt_ujian set XTampil = '$ubahh'");
  }
  
  $sqlt = mysql_query("select * from cbt_ujian order by Urut  ");
  $st = mysql_fetch_array($sqlt);
  $stts= $st['XStatusToken']; 
  $sttsh= $st['XTampil'];

  $sqlad = mysql_query("select * from cbt_admin");
  $ad = mysql_fetch_array($sqlad);
  $tingkat=$ad['XTingkat'];
  if ($tingkat=="MA" or $tingkat=="SMA" or $tingkat=="SMK"  ){$rombel="Jurusan";}else{$rombel="Rombel";}
?>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Reset peserta | Kontrol tampil token & nilai
        <?php if($sttsh=="0"){ ?>
        <a href="?modul=aktifkan_jadwaltes&hasiltampil" class="btn btn-primary btn-sm pull-right mx-1">
          Tampilkan hasi semua
        </a>
        <?php } else { ?>
        <a href="?modul=aktifkan_jadwaltes&hasiltampil" class="btn btn-warning btn-sm pull-right mx-1">
          Sembunyikan hasil ujian semua
        </a>
        <?php } ?>
        <?php if($stts=="0"){ ?>
        <a href="?modul=aktifkan_jadwaltes&statustoken" class="btn btn-success btn-sm pull-right mx-1">
          Tampilkan semua token
        </a>
        <?php } else { ?>
        <a href="?modul=aktifkan_jadwaltes&statustoken" class="btn btn-warning btn-sm pull-right mx-1">
          Sembunyikan semua token
        </a>
        <?php } ?>
      </div>
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode bank soal</th>
              <th>Kelas-<?= $rombel; ?></th>
              <th>Sesi</th>
              <th>Tgl aktif</th> 
              <th>Durasi</th>
              <th>Hasil tampil</th>
              <th>Token tampil</th>
              <th>Token | Reset login</th>
              <th>Status tes</th>
            </tr>
          </thead>
          <tbody>
          <?php
            $no=0;
            $sql = mysql_query("select u.*,m.*,u.Urut as Urutan,u.XKodeKelas as kokel from cbt_ujian u left join cbt_mapel m on m.XKodeMapel = u.XKodeMapel left join cbt_paketsoal p on p.XKodeSoal = u.XKodeSoal where u.XStatusUjian='1'");

            while($s = mysql_fetch_array($sql)): 
              $sqlsoal = mysql_num_rows(mysql_query("select * from cbt_soal where XKodeSoal = '$s[XKodeSoal]'"));
              $sqlpakai = mysql_num_rows(mysql_query("select * from cbt_siswa_ujian where XKodeSoal='$s[XKodeSoal]' and XStatusUjian='1'"));
              $sqlsudah = mysql_num_rows(mysql_query("select * from cbt_jawaban where XKodeSoal='$s[XKodeSoal]'"));
              if($sqlsoal<1){$kata="disabled";}  else {$kata="";} 
              if($sqlsudah>0||$sqlpakai>0){$kata="disabled";}  else {$kata="";}     
              if($sqlpakai>0){$katapakai="disabled";}  else {$katapakai="";}

              $time1 = "$s[XJamUjian]";
              $time2 = "$s[XLamaUjian]";

              $secs = strtotime($time2)-strtotime("00:00:00");
              $jamhabis = date("H:i:s",strtotime($time1)+$secs);  
              $sekarang = date("H:i:s");  
              $tglsekarang = date("Y-m-d"); 
              $tglujian = "$s[XTglUjian]";
              $sttss= $s['XStatusToken']; 
              $no++;
          ?>
            <tr>
              <td>
                <input type="hidden" value="<?= $s['Urutan']; ?>" id="txt_mapel<?= $s['Urutan']; ?>">
                <?= $no; ?>
                <input type="hidden" value="<?= $s['Urutan']; ?>" id="txt_ujian<?= $s['Urutan']; ?>">
              </td>
              <td>
                <?= $s['XKodeSoal']; ?>
              </td>
              <td>
                <?= $s['kokel'].'-'.$s['XKodeJurusan']; ?>
              </td>
              <td>
                <?= $s['XSesi']; ?>
              </td>
              <td>
                <?= $s['XTglUjian']; ?>
              </td>
              <td>
                <?= $s['XLamaUjian']; ?>
              </td>
              <td>
                <?= ($s['XTampil'] == "1" ? '<span class="badge badge-primary">Tampil</span>' : '<span class="badge badge-light">Tidak</span>') ?>
              </td>
              <td>
                <?= ($s['XStatusToken'] == "1" ? '<span class="badge badge-primary">Tampil</span>' : '<span class="badge badge-light">Tidak</span>') ?>
              </td>
              <td>
                <a href="?modul=reset_peserta&token=<?= $s['XTokenUjian'] ?>" class="btn btn-light btn-sm"><i class="icon-refresh"></i> <?= $s['XTokenUjian']; ?></a>
              </td>
              <td>
                <?php 
                if(($s['XStatusUjian']=="0"||$s['XStatusUjian']=="9")||($tglsekarang>$tglujian||$sekarang > $jamhabis)) {
                  echo "<input type='button' id='selesai".$s['Urutan']."' class='btn btn-light btn-sm' value='Selesai' ".$katapakai;
                }
                elseif($tglsekarang==$tglujian&&$sekarang < $time1) {
                  echo "<input type='button' id='selesai".$s['Urutan']."' class='btn btn-light btn-sm' value='Segera'  ".$katapakai;
                }
                else {
                  echo "<input type='button' id='selesai".$s['Urutan']."' class='btn btn-primary btn-sm' value='Aktif' ".$katapakai;
                }
                ?>
              </td>
            </tr>
            <script>
              $('#selesai<?= $s['Urutan']; ?>').click(function() {
                let txt_ujian = $('#txt_ujian<?= $s['Urutan'] ?>').val();

                $.ajax({
                  type: "POST",
                  url: "tools/selesaites.php",
                  data: "aksi=selesai&txt_ujian="+txt_ujian,
                  success() {
                    location.reload()
                  }
                })
              })
            </script>
          <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

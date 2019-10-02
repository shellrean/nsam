<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Set aktifasi waktu ujian
      </div>
      <form id="form-hapus">
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode  banksoal</th>
              <th>Mata pelajaran</th>
              <th>Soal</th>
              <th>Kelas</th>
              <th>Waktu</th>
              <th>Sesi</th>
              <th>Status</th>
              <th>Jadwal</th>
            </tr>
          </thead>
          <tbody>
          <?php
          $no = 0;
          $sql = mysql_query("select p.*,m.*,p.Urut as Urutan,p.XKodeKelas as kokel from cbt_paketsoal p left join cbt_mapel m on m.XKodeMapel = p.XKodeMapel where p.XStatusSoal='Y' order by p.Urut desc");

          while($s = mysql_fetch_array($sql)):
            $sqlsoal = mysql_num_rows(mysql_query("select * from cbt_soal where XKodeSoal='$s[XKodeSoal]'"));
            $sqlpakai = mysql_num_rows(mysql_query("select * from cbt_siswa_ujian where XKodeSoal = '$s[XKodeSoal]' and XStatusUjian = '1'"));
            $sqlsudah = mysql_num_rows(mysql_query("select * from cbt_jawaban where XKodeSoal = '$s[XKodeSoal]'"));
            if($sqlsoal<1){$kata="disabled";}  else {$kata="";} 
            if($sqlsudah>0||$sqlpakai>0){$kata="disabled";}  else {$kata="";}     
            if($sqlpakai>0){$katapakai="disabled";}  else {$katapakai="";}  

            $sqltes = mysql_query("select XJamUjian, XTglUjian, XStatusUjian, XSesi, XTampil from cbt_ujian where XKodeSoal = '$s[XKodeSoal]' and XKodeMapel = '$s[XKodeMapel]' and XKodeJurusan = '$s[XKodeJurusan]' and XKodeKelas='$s[kokel]' and XStatusUjian='1'");

            $stu = mysql_fetch_array($sqltes);
            $tjamujian = $stu['XJamUjian'];
            $ttglujian = $stu['XTglUjian'];
            $sttsujian = $stu['XStatusUjian'];
            $no++;
          ?>
            <tr>
              <td>
                <input type="hidden" value="<?= $s['Urutan']; ?>" id="txt_mapel<?= $s['Urutan']; ?>">
                <?= $no; ?>
              </td>
              <td>
                <?= $s['XKodeSoal']; ?>
              </td>
              <td>
                <?= $s['XNamaMapel']." - ".$s['XKodeMapel']; ?>
              </td>
              <td>
                <?= $sqlsoal. "(".$s['XJumPilihan']." opsi)"; ?>
              </td>
              <td>
                <?= $s['kokel']."-".$s['XKodeJurusan']; ?>
              </td>
              <td>
                <?= $ttglujian.$tjamujian; ?>
              </td>
              <td>
                <?= $stu['XSesi']; ?>
              </td>
              <td>
                <?php if($sttsujian=="1"){ ?>
                <input type="button" id="simpan<?php echo $s['Urutan']; ?>" class="btn btn-success" value="Dikerjakan"  disabled>
                <?php } else { ?>
                <input type="button" id="simpan<?php echo $s['Urutan']; ?>" class="btn btn-default" value="Matikan">                                        
              <?php } ?>
              </td>
              <td>
                <a href="?modul=edit_tes&idtes=<?= $s['Urutan']; ?>" class="btn btn-primary btn-sm">
                  <i class="icon-clock"></i> Set
                </a>
              </td>
            </tr>
           <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      </form>
    </div>
  </div>
</div>

<script>
  $('#appTable').DataTable();
</script>
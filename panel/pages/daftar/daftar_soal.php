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
        <i class="fa fa-align-justify"></i> Daftar banksoal
        <?php
        $sql3     = mysql_query("select * from cbt_server");
        $xadm10   = mysql_fetch_array($sql3);
        $xserver  = $xadm10['XServer'];
        
        if($xserver == "lokal"): 
        ?>
        <button class="btn btn-success btn-sm pull-right" id='custId' data-toggle='modal' data-id='' data-target="#myModal">Buat banksoal</button>
        <a href="daftar/down_excel_kelas.php" target="_blank" class="btn btn-success btn-sm pull-right mx-2">
          <i class="icon-cloud-download"></i> Template soal umum
        </a>
        <a href="?modul=upl_kelas" class="btn btn-primary btn-sm pull-right">
          <i class="icon-cloud-download"></i> Template soal perminatan
        </a>
        <a href="?modul=upl_kelas" class="btn btn-primary btn-sm mx-2 pull-right">
          <i class="icon-cloud-download"></i> Template soal agama
        </a>
        <?php endif; ?>
      </div>
      <div class="card-body">
      	 <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode Sekolah</th>
              <th>Kode bank soal</th>
              <th>Mata pelajaran</th>
              <th>Soal</th>
              <th>Kelas</th>
              <th>Aksi</th>
              <th>Status</th>
              <th>Print&del</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $no=0;
            if($_COOKIE['beeuser'] == 'admin') {
              $sql = mysql_query("select p.*,m.*,p.Urut as Urutan,p.XKodeSekolah  as kosek,p.XKodeKelas  as kokel from cbt_paketsoal p left join cbt_mapel m on m.XKodeMapel = p.XKodeMapel order by p.Urut desc");
            } 
            else {
              $sql = mysql_query("select p.*,m.*,p.Urut as Urutan,p.XKodeSekolah  as kosek,p.XKodeKelas  as kokel from cbt_paketsoal p left join cbt_mapel m on m.XKodeMapel = p.XKodeMapel where p.XGuru = '$_COOKIE[beeuser]' order by p.Urut desc"); 
            }

            while($s = mysql_fetch_array($sql)):
              $sqlsoal  = mysql_num_rows(mysql_query("select * from cbt_soal where XKodeSoal = '$s[XKodeSoal]'"));
              $sqlpakai = mysql_num_rows(mysql_query("select * from cbt_siswa_ujian where XKodeSoal = '$s[XKodeSoal]' and XStatusUjian='1'"));
              $sqlsudah = mysql_num_rows(mysql_query("select * from cbt_jawaban where XKodeSoal='$s[XKodeSoal]'"));

              ($sqlsoal == 0 ? $katakosong = "disabled" : $katakosong = "");
              ($sqlsudah >0 || $sqlpakai>0 ? $katasudah="disabled" : $katasudah = "");
              ($sqlpakai>0 ? $katapakai = "disabled" : $katapakai = "");

              $no++;
            ?>
            <tr>
              <td>
                <input type="hidden" value="<?= $s['Urutan'] ?>" id="txt_mapel<?= $s['Urutan']; ?>">
                <?= $no; ?>
                <input type="hidden" value="<?= $s['XKodeSoal']; ?>" id="txt_soal<?= $s['Urutan']; ?>">
              </td>
              <td>
                <?= $s['kosek']; ?>
              </td>
              <td>
                <?= $s['XKodeSoal']; ?>
              </td>
              <td>
                <?= $s['XNamaMapel'].'('.$s['XKodeMapel'].')'; ?>
              </td>
              <td>
                <?= "$sqlsoal (". $s['XJumPilihan']." opsi)"; ?>
              </td>
              <td>
                <?= $s['kokel'].'-'.$s['XKodeJurusan']; ?>
              </td>
              <td>
                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myCopy<?= $s['Urutan'] ?>"><i class="icon-docs"></i>
                </button>
                <a href="?modul=upl_soal&soal=<?= $s['XKodeSoal'] ?>" class="btn btn-warning btn-sm">
                  <i class="icon-cloud-upload"></i>
                </a>
                <a href="?modul=edit_soal&jum=<?= $s['XJumPilihan'] ?>" class="btn btn-primary btn-sm <?= $katapakai ?>">
                  <i class="icon-list"></i>
                </a>
              </td>
              <td>
                <?php if($s['XStatusSoal']=="Y"){ ?>
                  <input type="button" id="simpan<?= $s['Urutan']; ?>" class="btn btn-success btn-sm" value="Aktif"  <?= "$katapakai $katakosong $katasudah"; ?> >
                  <input type="hidden" id="ingat<?= $s['Urutan']; ?>" value="AKTIF"> 
                <?php } else { ?> 
                  <input type="button" id="simpan<?= $s['Urutan']; ?>" class="btn btn-light btn-sm" value="Aktifkan" <?= "$katakosong";  ?> >                                 
                  <input type="hidden" id="ingat<?= $s['Urutan']; ?>" value="NON">                                               
                <?php } ?>
              </td>
              <td>
                <a href="?modul=cetak_banksoal&idsoal=<?= $s['XKodeSoal'] ?>" class="btn btn-success btn-sm">
                  <i class="icon-printer"></i>
                </a>
                <?php if($s['XStatusSoal']=="Y"){ ?>
                  <button type="button" class="btn btn-danger btn-sm" id="btnDelete<?= $s['Urutan']; ?>" 
                  <?= "disabled"; ?>> <i class="icon-trash"></i></button>
                <?php } else { ?> 
                  <button type="button" class="btn btn-danger btn-sm" id="btnDelete<?= $s['Urutan']; ?>" 
                <?= " "; ?>> <i class="icon-trash"></i></button>                                            
                <?php } ?>
              </td>
            </tr>
            <script>
               $(document).ready(function() {
                $('#simpan<?= $s['Urutan']; ?>').click(function() {
                  let txt_ujian   = $("#txt_ujian").val();
                  let txt_jawab   = $("#txt_jawab").val();
                  let txt_acak    = $("#switch_left").val();
                  let txt_durasi  = $("#txt_durasi").val();
                  let txt_telat   = $("#txt_telat").val();
                  let txt_soal    = $("#txt_soal<?= $s['Urutan']; ?>").val();  
                  let txt_mapel   = $("#txt_mapel<?= $s['Urutan']; ?>").val();
                  let txt_level   = $("#txt_level").val(); 
                  let txt_nama    = $("#txt_nama").val();  
                  let txt_status  = $("#ingat<?= $s['Urutan']; ?>").val();   
                  
                  $.ajax({

                  })
                })
                $('#acak<?= $s['Urutan'] ?>').click(function() {

                })
                $('#hapus<?= $s['Urutan'] ?>').click(function() {

                })
                $('#btnDelete<?= $s['Urutan'] ?>').click(function() {
                  confirmDialog("Apakah yakin akan menghapus banksoal in?", function() {
                    let txt_ujian   = $("#txt_ujian").val();
                    let txt_jawab   = $("#txt_jawab").val();
                    let txt_acak    = $("#switch_left").val();
                    let txt_durasi  = $("#txt_durasi").val();
                    let txt_telat   = $("#txt_telat").val();
                    let txt_soal    = $("#txt_soal<?= $s['Urutan']; ?>").val();  
                    let txt_mapel   = $("#txt_mapel<?= $s['Urutan']; ?>").val();
                    let txt_level   = $("#txt_level").val(); 
                    let txt_nama    = $("#txt_nama").val();  

                    $.ajax({
                      type: "POST",
                      url: "daftar/hapus_soal.php",
                      data: "aksi=hapus&txt_ujian=" + txt_ujian + "&txt_jawab=" + txt_jawab + "&txt_acak=" + txt_acak + "&txt_telat=" + txt_telat + "&txt_durasi=" + txt_durasi + "&txt_soal=" + txt_soal + "&txt_level=" + txt_level + "&txt_mapel=" + txt_mapel + "&txt_nama=" + txt_nama,
                      success(data) {
                        document.location.reload();
                      }
                    })
                  })
                })
                $('#tambah<?= $s['Urutan'] ?>').click(function() {

                })

              })
            </script>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
      <div class="card-footer">
        <span><i class="icon-arrow-right-circle text-success"></i> Membuat banksoal sesuai format excel template</span> <br>
        <span><i class="icon-arrow-right-circle text-success"></i> Upload file excel</span> <br>
        <span><i class="icon-arrow-right-circle text-success"></i> Edit soal bila dirasa perlu seperti equotion dan insert gambar dan jangan lup pengacakan soal dan kunci jawaban harus diisi</span>  <br>
        <span><i class="icon-arrow-right-circle text-success"></i> Mengaktifkan satatus bank soal</span> <br>
        <span><i class="icon-arrow-right-circle text-success"></i> Buat jadwal ujian & generate token</span>  <br><br>
        <span><i class="icon-arrow-right-circle text-danger"></i> Banksoal tidak bisa dihapus atau diedit selama sedang aktif digunakan ujian</span> <br>
        <span><i class="icon-arrow-right-circle text-danger"></i> Banksoal yang aktif belum bisa dipergunakan ujian bila belum di buat jadwal oleh administrator</span>  


      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="confirmModal" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-body" id="confirmMessage"></div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" id="confirmCancel">Cancel</button>
          <button type="button" class="btn btn-primary" id="confirmOk">Ok</button>
        </div>
    </div>
  </div>
</div>

<div class="modal fade" id="myModal" aria-hidden="true">
  <div class="modal-dialog modal-l" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Buat banksoal</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">
          <?php  include "buat_banksoalbaru.php"; ?>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          <input type="submit" class="btn btn-primary" id="baru" value="Buat banksoal baru" name="baru">
        </div>
    </div>
  </div>
</div>
<script>
  $('#appTable').DataTable();

  $('#myModal').on('shown.bs.modal', function () {
    $('#myInput').focus()
  })
  $('#myModal').on('hidden.bs.modal', function () {
    document.location.reload();
  })
  
  $('#confirmModal').on('hidden.bs.modal', function () {
    document.location.reload();
  })

  function confirmDialog(message, onConfirm){
    var fClose = function(){
        modal.modal("hide");
    };
    var modal = $("#confirmModal");
    modal.modal("show");
    $("#confirmMessage").empty().append(message);
    $("#confirmOk").one('click', onConfirm);
    $("#confirmOk").one('click', fClose);
    $("#confirmCancel").one("click", fClose);
  }


  function confirmDialog2(message, onConfirm){
    var fClose = function(){
        modal.modal("hide");
    };
    var modal = $("#confirmModal");
    modal.modal("show");
    $("#confirmMessage").empty().append(message);
    $("#confirmOk").one('click', onConfirm);
    $("#confirmOk").one('click', fClose);
    $("#confirmCancel").one("click", fClose);
  }

</script>
<?php
  if(!isset($_COOKIE['beeuser'])){
  header("Location: login.php");}

include "../../../config/server.php";
if($_REQUEST['urut']) {
  $id = $_POST['urut'];
  $sql = mysql_query("SELECT * FROM cbt_ujian WHERE Urut = '$id'");
  $r = mysql_fetch_array($sql);
  $nilai = $r['XTampil'];
  if ($nilai=='1') {$t="Tampil";}else{$t="Tidak";}
  $statustoken = $r['XStatusToken'];
  if ($statustoken=='1') {$tt="Tampil";}else{$tt="Tidak";}
  $statusujian = $r['XStatusUjian'];
  if ($statusujian=='1') {$tu="Sedang ujian";}else{$tu="Selesai Ujian";}
  $xpdf = $r['XPdf'];
  if ($xpdf=='1') {$pdf="Soal PDF";}else{$pdf="Bukan PDF";}
  $listen = $r['XListening'];
  if ($listen=='1') {$listenx="Sekali";}elseif($listen=='2'){$listenx="Dua Kali";}elseif($listen=='3'){$listenx="Terusan";}
?>


<form action="?modul=daftar_waktu&simpan=yes" method="post">
  <input type="hidden" name="id" value="<?= $r['Urut']; ?>">
 	<div class="modal-body">
     <div class="form-group">
       <label>Kode soal</label>
       <input type="text" class="form-control" name="txt_kodsoal" value="<?= $r['XKodeSoal'] ?>">
     </div>
     <div class="form-group">
        <label>Listening</label>
        <select class="form-control" name="txt_listen" id="txt_listen">
          <option value="1" <?= ($listen == 1) ? "selected" : ""; ?>>
            Sekali
          </option>
          <option value="2" <?= ($listen == 2) ? "selected" : ""; ?>>
             Dua kali
          </option>
          <option value="3" <?= ($listen == 3) ? "selected" : ""; ?>>
           Terusan
          </option>
        </select>
      </div>
      <div class="row">
        <div class="col-md-6">
          <div class="form-group">
            <label>Soal pdf</label>
            <select class="form-control" name="txt_xpdf" id="txt_xpdf"> 
              <option value="1" <?php if ($xpdf==1){echo "selected";}?>>Soal PDF</option>
              <option value="0" <?php if ($xpdf==0){echo "selected";}?>>Bukan PDF</option>  
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Nilai</label>
            <select class="form-control" name="txt_hasil" id="txt_hasil"> 
              <option value="1" <?php if ($nilai==1){echo "selected";}?>>Tampil</option>
              <option value="0" <?php if ($nilai==0){echo "selected";}?>>Tidak</option>  
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>File pdf</label>
            <input type="text" class="form-control" name="txt_filepdf" value="<?= $r['XFilePdf']; ?>">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Token</label>
            <select class="form-control" name="txt_statustoken" id="txt_statustoken">    
              <option value="1" <?php if ($statustoken==1){echo "selected";}?>>Tampil</option>
              <option value="0" <?php if ($statustoken==0){echo "selected";}?>>Tidak</option>   
            </select>
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Status</label>
            <select class="form-control" name="txt_suji" id="txt_suji"> 
              <option value="1" <?php if ($statusujian==1){echo "selected";}?>>Sedang Ujian</option>
              <option value="9" <?php if ($statusujian==9){echo "selected";}?>>Selesai Ujian</option>  
            </select>
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Kode kelas</label>
            <input type="text" class="form-control" name="txt_kodkel" value="<?= $r['XKodeKelas']; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Sesi</label>
            <input type="text" class="form-control" name="txt_sesi" value="<?php echo $r['XSesi']; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label><?= $rombel; ?></label>
            <input type="text" class="form-control" name="txt_jur" value="<?php echo $r['XKodeJurusan']; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Ujian</label>
            <input type="text" class="form-control" name="txt_koduji" value="<?php echo $r['XKodeUjian']; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Token</label>
            <input type="text" class="form-control" name="txt_token" value="<?php echo $r['XTokenUjian']; ?>">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Tgl ujian</label>
            <input type="text" class="form-control" name="txt_tuji" value="<?php echo $r['XTglUjian']; ?>">
          </div>
        </div>

        <div class="col-md-6">
          <div class="form-group">
            <label>Jam ujian</label>
            <input type="text" class="form-control" name="txt_juji" value="<?php echo $r['XJamUjian']; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Durasi</label>
            <input type="text" class="form-control" name="txt_durasi" value="<?php echo $r['XLamaUjian']; ?>">
          </div>
        </div>
        <div class="col-md-6">
          <div class="form-group">
            <label>Jam tutup</label>
            <input type="text" class="form-control" name="txt_bmasuk" value="<?php echo $r['XBatasMasuk']; ?>">
          </div>
        </div>
      </div>
   </div>
   <div class="modal-footer">
     <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
     <button type="submit" class="btn btn-success">Simpan</button>
   </div>
</form>

<?php 
}
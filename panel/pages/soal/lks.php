<?php
	if(!isset($_COOKIE['beeuser'])){
	header("Location: login.php");}
?>
<!-- <script type="text/javascript" src="./js/jquery.gdocsviewer.min.js"></script> 

<script src="../../MathJax/MathJax.js?config=AM_HTMLorMML-full"></script>

<script>
  MathJax.Hub.Queue(["Typeset",MathJax.Hub]);
</script>
 -->

<br />
<?php
include "../../config/server.php";

$var_soal = "$_REQUEST[soal]";
$var_siswa = "$_REQUEST[siswa]";
$var_token = "$_REQUEST[token]";

//Soal Pilihan Ganda
$sqlsoal = mysql_num_rows(mysql_query("select * from cbt_soal where XKodeSoal = '$var_soal' and XJenisSoal = '1'")); 
$sqltampil = mysql_query("select * from cbt_ujian where XKodeSoal = '$var_soal'"); 
$t1 = mysql_fetch_array($sqltampil);
//$t = $t1['XJumSoal'];
$t = $t1['XPilGanda'];

$sqlbenar = mysql_query("select * from cbt_nilai where XKodeSoal = '$var_soal' and XNomerUjian = '$var_siswa'  and XTokenUjian = '$var_token'"); 
$b1 = mysql_fetch_array($sqlbenar);
$b = $b1['XBenar'];

if($t > $sqlsoal){$jumsoal = $sqlsoal;} else {$jumsoal = $t;}
$nilai = ($b/$jumsoal)*100;
$nilaine = number_format($nilai, 2, ',', '.');


$sqlujian = mysql_query("select * from cbt_ujian c left join cbt_mapel m on m.XKodeMapel = c.XKodeMapel where c.XKodeSoal = '$var_soal'  and c.XTokenUjian = '$var_token'"); 
$u = mysql_fetch_array($sqlujian);
$namamapel = $u['XNamaMapel'];
$xtokenujian = $u['XTokenUjian'];

$nom = 1;			
$betul = 0;					

$sqljur = mysql_query("SELECT * FROM `cbt_siswa` WHERE XNomerUjian= '$var_siswa' ");
$sjur = mysql_fetch_array($sqljur);
$kojur = $sjur['XKodeJurusan'];
$namkel = $sjur['XNamaKelas'];

$sqlsiswa = mysql_query("SELECT * FROM `cbt_siswa` s left join cbt_kelas k on k.XKodeKelas = s.XKodeKelas WHERE XNomerUjian= '$var_siswa' ");
$s = mysql_fetch_array($sqlsiswa);
$namsis = $s['XNamaSiswa'];
$kokel = $s['XKodeKelas'];
$nomsis = $s['XNIK'];
$namjur = $s['XKodeJurusan'];
$fotsis = $s['XFoto'];
if(str_replace(" ","",$fotsis)==""){
$foto = "nouser.png";} else { $foto = "$fotsis";}

$sqljumlahx = mysql_query("select sum(XNilaiEsai) as hasil from cbt_jawaban where XKodeSoal = '$_REQUEST[soal]' and XUserJawab = '$_REQUEST[siswa]' and XTokenUjian = '$var_token'");
$o = mysql_fetch_array($sqljumlahx);
$nilaiawal = round($o['hasil'],2);

?>
<input type="hidden" id="soale" name="soale" value="<?= "$_REQUEST[soal]"; ?>" />
<input type="hidden" id="siswae" name="siswae" value="<?= "$_REQUEST[siswa]"; ?>" />
<input type="hidden" id="tokene" name="tokene" value="<?= "$var_token"; ?>" />

<div class="row">
  <div class="col-md-8">
    <div class="card">
      <div class="card-header">
        <a href=?modul=analisajawaban&soal=<?= $_REQUEST['soal']; ?> class="btn btn-light btn-sm">
          <i class="fa fa-arrow-circle-left"></i> Kembali ke daftar
        </a>
      </div>
      <div class="card-body">
        <table border="0" width="100%">                              
          <tr>
            <td rowspan="5" width="150px"><img src="../../foto_siswa/<?= $foto; ?>" width="100px" /></td>
            <td width="30%">Nomer Ujian </td><td width="40%">: <?= "$var_siswa [$var_token]"; ?></td> 
          </tr>
          <tr><td>Nomer Induk Siswa(NIS)</td><td>: <?= $nomsis; ?></td></tr>
          <tr><td>Nama Lengkap </td><td>: <?= $namsis; ?></td></tr>
          <tr><td>Kelas - Jurusan </td><td>: <?= "$kokel - $kojur ($namkel)"; ?></td></tr>
          <tr><td>Mata Pelajaran</td><td>: <?= $namamapel; ?></td></tr>
        </table>    
      </div>
    </div>
  </div>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">
        <h5>Nilai ujian esai : </h5>
      </div>
      <div class="card-body">
        <table border="0" width="100%">                              
          <tr>
            <td valign="top" align="center">
            <div style="font-size:90px" id="nilaiskor"><?= $nilaiawal; ?></div></td>
          </tr>
        </table>    
      </div>
    </div>
	</div>
</div>

<!-- <link href="../../mesin/css/jplayer.blue.monday.min.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../../mesin/lib/jquery.min.js"></script>
<script type="text/javascript" src="../../mesin/dist/jplayer/jquery.jplayer.min.js"></script> -->

<div class="card">
  <div class="card-header">
    <table>
      <tr>
        <td>
          <h5 class="panel-title">Hasil CBT online siswa : soal essai &nbsp;</h5>
        </td>
      </tr>
    </table>
  </div>
  <div class="card-body">
  <table class="table table-borderless">
  <?php
  $nomer = 1;
  $sql = mysql_query("
  SELECT * FROM `cbt_jawaban` j left join cbt_soal s on s.XNomerSoal = j.XNomerSoal 
  left join cbt_ujian u on (u.XKodeSoal = s.XKodeSoal and u.XTokenUjian = j.XTokenUjian)
  WHERE j.XKodeSoal = '$var_soal' and  s.XKodeSoal = '$var_soal' and  j.XUserJawab = '$var_siswa' 
  and j.XJenisSoal = '2' and j.XTokenUjian = '$var_token' order by j.Urut");

  while($r = mysql_fetch_array($sql)){
  $jumpil = $r['XJumPilihan'];
  $nosoal = $r['XNomerSoal'];
  $nil = $r['XNilaiEsai'];

  echo "<tr><td width=50px>$nomer.</td><td>$r[XTanya] </td></tr>
  ";
  ?>

  <?php
  if(str_replace("  ","",$r['XGambarTanya']!=="")){
  echo "
  <tr><td width=30px colspan=2>&nbsp; </td></tr>
  <tr><td colspan=2><img src=../../pictures/$r[XGambarTanya] width=150px></td></tr>";}
  echo "<tr><td width=50px colspan=2>&nbsp;</td></tr>";

  $jawab = $r['XJawabanEsai'];
  echo "
  <tr><td width=30px colspan=2><b>Jawaban : </b></td></tr>
  <tr><td colspan=2>$jawab</td></tr>

  <tr><td width=50px colspan=2>&nbsp;</td></tr>
  <tr><td colspan=2><b>Entry nilai</b></td></tr>
  <tr><td colspan=2>";	
  ?>
<script>
$(document).ready(function(){
  $(".masuk<?php echo "$nosoal"; ?>").keyup(function(){
		var jawabe = $('#jawab<?php echo "$nosoal"; ?>').val();
    var soale = $('#soale').val();	
    var siswae = $('#siswae').val();							
    var tokene = $('#tokene').val();							
    var nomere = $('#nomere<?php echo "$nosoal"; ?>').val();							
										
		var data = 'jawabe=' + jawabe + '& soale=' + soale + '& siswae=' + siswae + '& tokene=' + tokene + '& nomere=' + nomere;
    $.ajax({
      type: 'POST',
      url: "soal/simpan_nilai_esai.php",
      data: data,
      success: function(returnedData) {
				$('#nilaiskor').html(returnedData);
				$('#nilaiskor1').html(returnedData);
      }
    });
  });  
});
</script>

<input type="text" id="jawab<?= "$nosoal"; ?>" name="jawab<?= "$nosoal"; ?>" class="masuk<?= "$nosoal"; ?>" 
style="height:50px; width:60px; font-size:36px; padding-left:5px;color:#32689a" value="<?= "$nil"; ?>"/>
<input type="hidden" id="nomere<?= "$nosoal"; ?>" name="nomere<?= "$nosoal"; ?>" value="<?= "$nosoal"; ?>" />
<?php
echo "</td></tr><tr><td colspan=2><hr></td></tr>";

$nomer++;

}
?>

  </div>
</div>
</table>                              
</div>                           
</div>


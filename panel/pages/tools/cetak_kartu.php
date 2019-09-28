<?php

if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

function kartu($am,$kokel,$kojur) {
	$sqlam = mysql_query("select * from (select * from cbt_siswa where XKodeKelas = '$kokel' and XKodeJurusan='$kojur' order by Urut  limit $am) as ambil order by Urut Desc limit 1");
	
	$a 		= mysql_fetch_array($sqlam);

	$sqlad 	= mysql_query("select * from cbt_admin");
	$ad 	= mysql_fetch_array($sqlad);

	$namsek = $ad['XSekolah'];
	$kepsek = $ad['XKepSek'];
	$logsek = $ad['XLogo'];
	$skul_tkt= $ad['XTingkat']; 

	if ($skul_tkt=="SMA" || $skul_tkt=="MA"||$skul_tkt=="STM"){$rombel="Jurusan";}else{$rombel="Rombel";}
	if(str_replace(" ","",$a['XFoto'])==""){$pic = "nouser.png";}else{$pic="$a[XFoto]";}
?>
<table style="width:100%;border:1px solid black; padding:55px; font-family:Arial, Helvetica, sans-serif; font-size:12px" class="kartu" border="0">
					<tbody>
                    <tr>
						<td colspan="3" style="border-bottom:1px solid black; padding:2px" align="center">
							<table width="98%" class="kartu" cellpadding="10px">
							<tbody><tr>
								<td><img src="../../images/logo-dki.png" height="50"></td>
								<td align="center" style="font-weight:bold">
									<font size="2">KARTU PESERTA USBK <?php echo $_COOKIE['beetahun']; ?></font> 
									<br><font size="1">(UJIAN SEKOLAH BERBASIS KOMPUTER) </font></br>
							  </td>
							</tr>
							</tbody></table>
						</td>
					</tr>
			<tr height="20px"><td width="90">&nbsp;Nama Peserta </td><td width="8">:</td><td width="226" style="font-size:12px;font-weight:bold;">
			<?php echo "$a[XNamaSiswa] "; ?></td></tr>
			<tr height="20px"><td>&nbsp;Kelas-<?php echo $rombel;?> </td><td>:</td><td style="font-size:12px;font-weight:bold;">
			<?php echo "$a[XKodeKelas] - $kojur"; ?></td></tr>            
			<tr height="20px"><td>&nbsp;Sesi - Ruang</td><td>:</td><td style="font-size:12px;font-weight:bold;">
			<?php echo "$a[XSesi] - $a[XRuang]"; ?></td></tr>            
			<tr height="20px"><td height="25px">&nbsp;Username</td><td>:</td><td style="font-size:12px;font-weight:bold;">
			<?php echo "$a[XNomerUjian]"; ?></td></tr>
			<tr height="20px"><td>&nbsp;Password</td><td>:</td><td style="font-size:12px;font-weight:bold;"><?php echo $a['XPassword']; ?></td></tr>
			<tr height="76px"><td rowspan="3" align="center"><img src="../../foto_siswa/<?php echo $pic; ?>" height="76px" border="thin solid red"></td>

            <td colspan="2" valign="top" align="center">KEPALA<br><?php echo $namsek; ?></td></tr>                   
			<td style="font-size:12px;font-weight:bold;" colspan="2" align="center">Ttd ,</td></tr>
					<tr><td colspan="2" align="center"><?php echo $kepsek; ?></td></tr>
                    
				</tbody></table>
<?php } 
include "../../config/server.php";
$BatasWal = 50;

if(isset($_REQUEST['iki2'])&&isset($_REQUEST['jur2'])){ 
	$cekQuery = mysql_query("
	select * from cbt_siswa where XKodeKelas = '$_REQUEST[iki2]' and  XKodeJurusan = '$_REQUEST[jur2]' ");
} else {
	$cekQuery = mysql_query("select * from cbt_siswa"); 
}

$jumlahData = mysql_num_rows($cekQuery);
$jumlahn = 10;
$n = ceil($jumlahData/$jumlahn);
?>
<iframe src="<?php echo "tools/print_kartu.php?kelas=$_REQUEST[iki2]&jur=$_REQUEST[jur2]"; ?>" style="display:none;" name="frame"></iframe>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Cetak kartu peserta
        <button type="button" class="btn btn-success btn-sm mx-1 pull-right" onclick="frames['frame'].print()">
         <i class="icon-printer"></i> Print</button>
        <a href="#myCetakKartu" id='custId' data-toggle="modal" data-id='' class="btn btn-danger btn-sm pull-right">
        	<i class="icon-doc"></i> Cetak peserta lain
        </a>
      </div>
      <div class="card-body">
      	<?php
      	for($i=1;$i<=$n;$i++): ?>
      		<div style="background:#999; height:1600px;" ><br>
			  <div style="background:#fff; width:70%; margin:0 auto; padding:30px; height:98%;">
				<?php
				$mulai = $i-1;
				$batas = ($mulai*$jumlahn);
				$startawal = $batas;
				$batasakhir = $batas+$jumlahn;
				$kokelz = "$_REQUEST[iki2]";
				$kojurz = "$_REQUEST[jur2]";
				?>
				<table width="100%" border="0">
			        <tr><td width="50%"><?php if($startawal+1<=$jumlahData){kartu($startawal+1,$kokelz,$kojurz);} ?></td>
			        <td width="50%"><?php if($startawal+6<=$jumlahData){kartu($startawal+6,$kokelz,$kojurz);} ?></td></tr>
			        <tr><td width="50%"><?php if($startawal+2<=$jumlahData){kartu($startawal+2,$kokelz,$kojurz);} ?></td>
			        <td width="50%"><?php if($startawal+7<=$jumlahData){kartu($startawal+7,$kokelz,$kojurz);} ?></td></tr>
			        <tr><td width="50%"><?php if($startawal+3<=$jumlahData){kartu($startawal+3,$kokelz,$kojurz);} ?></td>
			        <td width="50%"><?php if($startawal+8<=$jumlahData){kartu($startawal+8,$kokelz,$kojurz);} ?></td></tr>
			        <tr><td width="50%"><?php if($startawal+4<=$jumlahData){kartu($startawal+4,$kokelz,$kojurz);} ?></td>
			        <td width="50%"><?php if($startawal+9<=$jumlahData){kartu($startawal+9,$kokelz,$kojurz);} ?></td></tr>
			        <tr><td width="50%"><?php if($startawal+5<=$jumlahData){kartu($startawal+5,$kokelz,$kojurz);} ?></td>
			        <td width="50%"><?php if($startawal+10<=$jumlahData){kartu($startawal+10,$kokelz,$kojurz);} ?></td></tr>        
		        </table>
		      </div>
		    </div>
      	<?php
      	endfor; ?>
      </div>
    </div>
  </div>
</div>


<div class="modal fade" id="myCetakKartu" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Cetak kartu ujian</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <form action="?modul=cetak_kartu" method="post">
       	<div class="modal-body">
       		<div class="form-group">
       			<label><?= $rombel; ?></label>
	       		<select class="form-control" id="jur2" name="jur2">
	       			<?php
	       				$sql = mysql_query("select * from cbt_kelas group by XKodeJurusan");
	       				while($rs = mysql_fetch_array($sql)) {
	       				echo "<option value='$rs[XKodeJurusan]'>$rs[XKodeJurusan]</option>";}
	       			?>
	       		</select>
	       	</div>
	       	<div class="Form-group">
	       		<label>Kelas</label>
				<select class="form-control" id="iki2"  name="iki2">
				<?php 
				$sqk = mysql_query("select * from cbt_kelas group by XKodeKelas");
				while($rs = mysql_fetch_array($sqk)){
	               echo "<option value='$rs[XKodeKelas]'>$rs[XKodeKelas]</option>";
				} ?> 
	            </select>
	       	</div>
       	</div>
       	<div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          	<button type="submit" class="btn btn-success">Tampilkan</button>
       	</div>
       </form>
    </div>
  </div>
</div>
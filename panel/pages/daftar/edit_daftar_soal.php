 <?php
 	if(!isset($_COOKIE['beeuser'])) {
 		header("Location: login.php");
 	}

 	include "../../config/server.php";

 	$sqlsoal 	= mysql_num_rows(mysql_query("select * from cbt_soal where XKodeSoal = '$_REQUEST[soal]'"));
 	$sqlpakai 	= mysql_num_rows(mysql_query("select * from cbt_siswa_ujian where XKodeSoal='$_REQUEST[soal]' and XStatusUjian='1'"));
 	$sqlsudah 	= mysql_num_rows(mysql_query("select * from cbt_jawaban where XKodeSoal='$_REQUEST[soal]'"));


	if(isset($_REQUEST['aksi'])&&$_REQUEST['aksi']=="hapus"){
		$sqldel = mysql_query("delete from cbt_soal where Urut = '$_REQUEST[nomer]' and XKodeSoal = '$_REQUEST[soal]'");
	}
 ?>

 <div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <a href="?modul=daftar_soal" class="btn btn-primary btn-sm"><i class="icon-arrow-left-circle"></i> Kembali ke banksoal</a>
        <a href="?modul=tambah_soal&jum=<?= $_REQUEST['jum'] ?>&tambahan=ok&soal=<?= $_REQUEST['soal'] ?>" class="btn btn-success btn-sm"><i class="icon-plus"></i> Pilihan ganda</a>
        <a href="?modul=tambah_soal&jum=1&pil=<?= $_REQUEST[jum] ?>&tambahan=ok&soal=<?= $_REQUEST[soal] ?>" class="btn btn-success btn-sm"><i class="icon-plus"></i> Soal essai</a>
        <a href="?soal_excel_php?idsoal=<?= $_REQUEST['soal'] ?>" target="_blank" class="btn btn-success btn-sm"><i class="icon-doc"></i> Download excel</a>
        <?php if($sqlpakai>0||$sqlsudah>0){ ?>
		<button type="button" class="btn btn-danger btn-sm" id="btnKosong" disabled><i class='icon-trash'></i> Kosongkan</button>
		<?php } else { ?>
		<button type="button" class="btn btn-danger btn-sm" id="btnKosong" onClick="deleteItem()"><i class='icon-trash'></i> Kosongkan</button>
    	<?php } ?>
      </div>
      <input type="hidden" name="check" id="check" value="0">
      <div class="card-body">
        <table class="table table-responsive-sm table-bordered table-striped table-sm" id="appTable">
          <thead>
            <tr>
              <th>No.</th>
              <th>Kode</th>
              <th>Pertanyaan</th>
              <th>Jenis</th>
              <th>Level</th> 
              <th>Soal</th>
              <th>Opsi</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
          	<?php
          	$sql0 = mysql_query("select * from cbt_soal where XKodeSoal='$_REQUEST[soal]' order by XnomerSoal");
          	$no=1;
          	while($xadm = mysql_fetch_array($sql0)):

          		if($xadm['XJenisSoal'] == 1){$jensoal = "Pilihan ganda";}
          		elseif($xadm['XJenisSoal'] == 2){$jensoal = "Essai";}
          		else{$Jenis="Unknown";}

          		if($xadm['XKategori']==1){$katsoal = "Mudah";} 
          		elseif($xadm['XKategori']==2){$katsoal = "Sedang";} 
          		else { $katsoal = "Susah";}

          		if($xadm['XAcakSoal']=="A"){$acaksoal = "Acak";} 
          		else { $acaksoal = "Tidak";}

          		if($xadm['XAcakOpsi']=="Y"){$acakopsi = "Acak";} 
          		elseif($xadm['XAcakOpsi']=="T"){ $acakopsi = "Tidak";}	
          		else { $acakopsi="";}

          		$sqlsoal = mysql_num_rows(mysql_query("select * from cbt_soal where XKodeSoal = '$xadm[XKodeSoal]'"));
          		$str = $xadm['XTanya'];
          		$soalnye = substr(strip_tags($str),0,110). "...";
          	?>
          	<tr>
          		<td><?= $no ?></td>
          		<td><?= $xadm['XKodeSoal'] ?></td>
          		<td><?= $soalnye ?></td>
          		<td><?= $jensoal; ?></td>
          		<td><?= $katsoal ?></td>
          		<td><?= $acaksoal; ?></td>
          		<td><?= $acakopsi; ?></td>
          		<?php
          		if($xadm['XJenisSoal'] == 1){
          			$ling = "<a href=?modul=edit_data_soal&jum=$_REQUEST[jum]&soal=$xadm[XKodeSoal]&nomer=$xadm[Urut] class='btn btn-primary btn-sm'><i class='icon-pencil'></i></a>";
          		}
          		else {
          			$ling = "<a href=?modul=edit_soal_esai&jum=$_REQUEST[jum]&soal=$xadm[XKodeSoal]&nomer=$xadm[Urut] class='btn btn-danger btn-sm'><i class='icon-trash'></i></a>";
          		}
          		?>
          		<td>
          			<button class="btn btn-success btn-sm" data-toggle="modal" data-target="#myModalR<?= $xadm['Urut']; ?>" alt="lihat"><i class="icon-magnifier"></i></button>
          			<?php
          			$sqlsudah1 = mysql_num_rows(mysql_query("select * from cbt_jawaban where XKodeSoal='$xadm[XNomerSoal]' and XNomerSoal='$xadm[XNomerSoal]'"));

					if($sqlpakai>0||$sqlsudah1>0){ 
						echo "<button type='button' class='btn btn-primary btn-sm' disabled><i class='icon-pencil'></i></button>";
						echo "<button type='button' class='btn btn-danger btn-sm' disabled><i class='icon-trash'></i></button>";
					}
					else {
						echo $ling;
						echo "<a href='?modul=edit_soal&aksi=hapus&jum=".$_REQUEST['jum']."&soal=".$xadm['XKodeSoal']."&nomer=".$xadm['Urut']."' class='btn btn-danger btn-sm mx-1'><i class='icon-trash'></i></a>";
					}
					?>

					<div class="modal fade" id="myModalR<?= $xadm['Urut'] ?>" aria-hidden="true">
					  <div class="modal-dialog modal-lg" role="document">
					    <form action="?modul=data_skul&tambah=yes" method="post" >
					    <div class="modal-content">
					        <div class="modal-header">
					          <h5 class="modal-title">Preview soal</h5>
					          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
					            <span aria-hidden="true">×</span>
					          </button>
					        </div>
					        <div class="modal-body">
					        	<?php
					        	$sqlprev = mysql_query("select * from cbt_soal where XKodeSoal = '$xadm[XKodeSoal]' and Urut = '$xadm[Urut]'");
					        	$sp = mysql_fetch_array($sqlprev);
					        	$js = $sp['XJenisSoal'];

					        	if(!$sp['XGambarTanya'] == '') {
					        		$gambarsoalnye = "<img src='../../pictures/$sp[XGambarTanya]' width='60%' align=center><br>";
					        	} 
					        	else {
					        		$gambarsoalnye = "";
					        	}
					        	if(!$sp['XAudioTanya']==''){
					        		$audiosoalnye = "$sp[XAudioTanya]<br>";} 
					        	else {
					        		$audiosoalnye = "";
					        	}
					        	if(!$sp['XVideoTanya']==''){
					        		$videosoalnye = "$sp[XVideoTanya]<br>";
					        	} 
					        	else {
					        		$videosoalnye = "";
					        	}
					        	if(str_replace(" ","",$sp['XGambarJawab1'])==''){
					        		$ambilfile1 = "";
					        	}
					        	else{									
									if(file_exists("../../pictures/$sp[XGambarJawab1]")){
										$ambilfile1 = "<img src=../../pictures/$sp[XGambarJawab1] width='100px'>";
									} else{
										$ambilfile1 = "<img src=../../images/kross.png> $sp[XGambarJawab1] tidak belum diUpload";
									}
								}

								if(str_replace(" ","",$sp['XGambarJawab2'])==''){
									$ambilfile2 = "";
								}else{	
									if(file_exists("../../pictures/$sp[XGambarJawab2]")){$ambilfile2 = "<img src=../../pictures/$sp[XGambarJawab2] width='100px'>";
									} else {
										$ambilfile2 = "<img src=../../images/kross.png> $sp[XGambarJawab2] tidak belum diUpload";
									}
								}
								if(str_replace(" ","",$sp['XGambarJawab3'])==''){
									$ambilfile3 = "";
								}else{									
									if(file_exists("../../pictures/$sp[XGambarJawab3]")){
										$ambilfile3 = "<img src=../../pictures/$sp[XGambarJawab3] width='100px'>";
									} else {
										$ambilfile3 = "<img src=images/kross.png> File Gambar tidak ada [Upload File]";
									}
								}
								if(str_replace(" ","",$sp['XGambarJawab4'])==''){
									$ambilfile4 = "";
								}else{									
									if(file_exists("../../pictures/$sp[XGambarJawab4]")){
										$ambilfile4 = "<img src=../../pictures/$sp[XGambarJawab4] width='100px'>";
									} else {
										$ambilfile4 = "<img src=../../images/kross.png> File Gambar tidak ada [Upload File]";
									}
								}
								if(str_replace(" ","",$sp['XGambarJawab5'])==''){
									$ambilfile5 = "";
								}else{	
									if(file_exists("../../pictures/$sp[XGambarJawab5]")){
										$ambilfile5 = "<img src=../../pictures/$sp[XGambarJawab5] width='100px'>";
									}
									else {
										$ambilfile5 = "<img src=../../images/kross.png> File Gambar tidak ada [Upload File]";
									}
								}
								if($js=='2'){
									$katsoal = "Esai/Uraiai";
									$soalnye = strip_tags($sp['XTanya']);
									echo "$soalnye
									<hr>						
									<p>$gambarsoalnye</p>								
									<hr>						
									<p>Audio Soal : $audiosoalnye</p>								
									<hr>						
									<p>Video Soal : $videosoalnye</p>								
									<hr>																
									";
								}
								elseif($_REQUEST['jum']<'5'){ 
									if($sp['XKunciJawaban']=='1'){
										$kunci1 = "<img src='../.../images/benar.png' width=20px>";
									} else {$kunci1="";}
									if($sp['XKunciJawaban']=='2'){
										$kunci2 = "<img src='../../images/benar.png' width=20px>";
									} else {$kunci2="";}
									if($sp['XKunciJawaban']=='3'){
										$kunci3 = "<img src='../../images/benar.png' width=20px>";
									} else {$kunci3="";}
									if($sp['XKunciJawaban']=='4'){
										$kunci4 = "<img src='../../images/benar.png' width=20px>";
									} else {$kunci4="";}

									$Jawab1 = str_replace("<p>","",$sp['XJawab1']);
									$Jawab1 = str_replace("</p>","",$Jawab1);									
									$Jawab2 = str_replace("<p>","",$sp['XJawab2']);
									$Jawab2 = str_replace("</p>","",$Jawab2);									
									$Jawab3 = str_replace("<p>","",$sp['XJawab3']);
									$Jawab3 = str_replace("</p>","",$Jawab3);									
									$Jawab4 = str_replace("<p>","",$sp['XJawab4']);
									$Jawab4 = str_replace("</p>","",$Jawab4);									
									$soalnye = strip_tags($sp['XTanya']);	

									echo "
									<p style='background-color:#eee; padding:10px'>$soalnye</font></p>";
									echo "
									<hr>						
									<p>$gambarsoalnye</p>								
									<hr>						
									<p>Audio Soal : $audiosoalnye</p>								
									<hr>						
									<p>Video Soal : $videosoalnye</p>								
									<hr>						
						

									<p>Jawaban  : </p>									
									<p>&#8226; $ambilfile1 $Jawab1 $kunci1</p>
									<p>&#8226; $ambilfile2 $Jawab2 $kunci2</p>									
									<p>&#8226; $ambilfile3 $Jawab3 $kunci3</p>
									<p>&#8226; $ambilfile4 $Jawab4 $kunci4</p>	
									";
								}

								 elseif($_REQUEST['jum']=='5'){ 
									if($sp['XKunciJawaban']=='1'){
										$kunci1 = "<img src='../../images/benar.png' width=20px>";
									} else {$kunci1="";}
									if($sp['XKunciJawaban']=='2'){
										$kunci2 = "<img src='../../images/benar.png' width=20px>";
									} else {$kunci2="";}
									if($sp['XKunciJawaban']=='3'){
										$kunci3 = "<img src='../../images/benar.png' width=20px>";
									} else {$kunci3="";}
									if($sp['XKunciJawaban']=='4'){
										$kunci4 = "<img src='../../images/benar.png' width=20px>";
									} else {$kunci4="";}
									if($sp['XKunciJawaban']=='5'){
										$kunci5 = "<img src='../../images/benar.png' width=20px>";
									} else {$kunci5="";}

									$Jawab1 = str_replace("<p>","",$sp['XJawab1']);
									$Jawab1 = str_replace("</p>","",$Jawab1);									
									$Jawab2 = str_replace("<p>","",$sp['XJawab2']);
									$Jawab2 = str_replace("</p>","",$Jawab2);									
									$Jawab3 = str_replace("<p>","",$sp['XJawab3']);
									$Jawab3 = str_replace("</p>","",$Jawab3);									
									$Jawab4 = str_replace("<p>","",$sp['XJawab4']);
									$Jawab4 = str_replace("</p>","",$Jawab4);									
									$Jawab5 = str_replace("<p>","",$sp['XJawab5']);
									$Jawab5 = str_replace("</p>","",$Jawab5);	
									$katsoal = "Pilihan Ganda (5 Pilihan Jawaban $js\)";	
									$soalnye = strip_tags($sp['XTanya'], '<br>');	
									$soalnye = str_replace("`","'",$soalnye);

									echo "
																
									<p style='background-color:#eee; padding:10px'>$soalnye</font></p>
									<hr>						
									<p>$gambarsoalnye</p>								
									<hr>						
									<p>Audio Soal : $audiosoalnye</p>								
									<hr>						
									<p>Video Soal : $videosoalnye</p>								
									<hr>						
									<p>Jawaban : <br>
									<ul>
									<p>&#8226; $ambilfile1 $Jawab1 $kunci1</p>
									<p>&#8226; $ambilfile2 $Jawab2 $kunci2</p>									
									<p>&#8226; $ambilfile3 $Jawab3 $kunci3</p>
									<p>&#8226; $ambilfile4 $Jawab4 $kunci4</p>	
									<p>&#8226; $ambilfile5 $Jawab5 $kunci5</p>											
									</ul></p>
									";
								}
								?>
					        </div>
					        <div class="modal-footer">
					          <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
					        </div>
					    </div>
					    </form>
					  </div>
					</div>
          		</td>
          	</tr>

			<div class="modal fade" id="lihat" tabindex="-1" role="dialog" aria-labelledby="lihat" aria-hidden="true">
			  <div class="modal-dialog">
			    <div class="modal-content">
			      <div class="modal-header">
			        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
			        <h4 class="modal-title" id="myModalLabel">Image preview</h4>
			      </div>
			      <div class="modal-body">
			        <img src="" id="imagepreview" style="width: 400px; height: 264px;" >
			      </div>
			      <div class="modal-footer">
			        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
			      </div>
			    </div>
			  </div>
			</div>

          	<?php $no++; endwhile; ?>
          </tbody>
        </table>
      </div>
  </div>
</div>


<script>
	$('#appTable').DataTable();
</script>
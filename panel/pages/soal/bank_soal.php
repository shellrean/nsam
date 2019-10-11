<?php
	if(!isset($_COOKIE['beeuser'])){
	header("Location: login.php");}

if(isset($_REQUEST['aksi'])&&$_REQUEST['aksi'] == "simpan") {
	$sss= str_replace("'","\'",$_REQUEST['tanyasoal']);
	$sql0 = mysql_query("update cbt_soal set XTanya = '$sss' where XKodeSoal = '$_REQUEST[soal]' and Urut = '$_REQUEST[nom]'");
}
?>
<script src="../vendors/tiny_mce/tiny_mce.js"></script>
<script>
	tinyMCE.init({
		mode : "textareas",
		theme : "advanced",
    	theme_advanced_buttons1 : "fontselect,fontsizeselect,formatselect,bold,italic,underline,strikethrough,separator,sub,sup,separator,cut,copy,paste,undo,redo",
    	theme_advanced_buttons2 : "justifyleft,justifycenter,justifyright,justifyfull,separator,numlist,bullist,outdent,indent,separator,forecolor,backcolor,separator,hr,link,unlink,image,media,table,code,separator,asciimath,asciimathcharmap,asciisvg",
    	theme_advanced_buttons3 : "",
    	theme_advanced_fonts : "Arial=arial,helvetica,sans-serif,Courier New=courier new,courier,monospace,Georgia=georgia,times new roman,times,serif,Tahoma=tahoma,arial,helvetica,sans-serif,Times=times new roman,times,serif,Verdana=verdana,arial,helvetica,sans-serif",
    	theme_advanced_toolbar_location : "top",
    	theme_advanced_toolbar_align : "left",
    	theme_advanced_statusbar_location : "bottom",
    	plugins : 'asciimath,asciisvg,table,inlinepopups,media',
    	AScgiloc : 'http://www.imathas.com/editordemo/php/svgimg.php',	  
    	ASdloc : 'http://www.imathas.com/editordemo/jscripts/tiny_mce/plugins/asciisvg/js/d.svg',

    });
</script>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <form action="#" method="post">
      <div class="card-header py-3">
        <a href=?modul=edit_soal&jum=<?= $_REQUEST['jum'] ?>&soal=<?= $_REQUEST['soal'] ?> class="btn btn-sm btn-primary"><i class='fa fa-arrow-left'></i> Kembali ke daftar soal</a>
        <button type="button" class="btn btn-success btn-sm pull-right" id="kirim"><i class='fa fa-save'></i> Update Soal</button>  
      </div>
      <div class="card-body">

      	<?php
      	$sql0 = mysql_query("select * from cbt_soal where XKodeSoal= '$_REQUEST[soal]' and Urut = '$_REQUEST[nomer]'");
		$s=mysql_fetch_array($sql0);

      	?>
      	<input type="hidden" id="soal" name="soal" value="<?php echo $_REQUEST['soal']; ?>" />
    	<input type="hidden" id="nom" name="nom" value="<?php echo $_REQUEST['nomer']; ?>" />
    	<?php
    	$sqlsoal = mysql_query("SELECT MAX(XNomerSoal) as maksi FROM `cbt_soal` WHERE XKodeSoal = '$_REQUEST[soal]'");
    	$sm = mysql_fetch_array($sqlsoal);
		$maks = $sm['maksi']+1; 
		?>
		<input type="hidden" id="nomax" name="nomax" value="<?php echo $maks ; ?>" />
		<input type="hidden" id="txt_kate" name="txt_kate" value="1" readonly>
		<input type="hidden" id="txt_ag" name="txt_ag" value="" >
		<div class="form-group">
			<label>Tingkat kesulitan</label>
			<select class="form-control col-md-4" id="txt_kes">
				<option value="1" <?php if($s['XKategori']=='1'){echo "selected";}?>>Mudah</option>
				<option value="2" <?php if($s['XKategori']=='2'){echo "selected";}?>>Sedang</option>
				<option value="3" <?php if($s['XKategori']=='3'){echo "selected";}?>>Sulit</option>
			</select>
		</div>
		<div class="form-group">
			<label>Acak soal</label>
			<select id="txt_aca" name="txt_aca" class="form-control col-md-4">
				<option value="A" <?php if($s['XAcakSoal']=='A'){echo "selected";}?>>Acak</option>
				<option value="T" <?php if($s['XAcakSoal']=='T'){echo "selected";}?>>Tidak</option>
			</select>
		</div>

      	<textarea name="tanyasoal"  id="tanyasoal" style="font-size:18px; width:100%; height:300px"><?php 
	echo "$s[XTanya]"; ?></textarea>
      	<input type="hidden" id="map" name="map" value="<?= $s['XKodeMapel']; ?>" />


      	<script src="../js/ajaxupload.3.5.js"></script>
      	<script>
      		$(function() {
      			let btnUpload = $('#upload');
      			let status = $('#status');

      			new AjaxUpload(btnUpload,{
      				action: 'upload/upload_gambar.php',
      				name: 'uploadfile',
      				onSubmit: function(file,ext) {
      					if(!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))){
      						status.text('Hanya JPG, PNG atau GIF yang diizinkan');
      						return false;
      					}
      					status.text('Uploading...');
      				},
      				onComplete: function(file,response) {
      					status.text('');
      					if(response==="success") {
      						$('#upload').html('<img src="../../pictures/'+file+'"  width="130" alt="" />').addClass('success');
							document.getElementById("gambar").value = file
      					}
      					else {
      						$('<li></li>').appendTo('#files').text(file).addClass('text-danger');
      					}
      				}
      			})
      		})
      	</script>

		<script type="text/javascript" >
			$(function(){
				let btnUpload2=$('#upload2');
				let status2=$('#status2');
				new AjaxUpload(btnUpload2, {
					action: 'upload/upload_audio.php',
					name: 'uploadfile2',
					onSubmit: function(file2, ext2){
						 if (! (ext2 && /^(mp3|wav)$/.test(ext2))){ 
							status2.text('Upload file dengan format mp3/wav');
							return false;
						}
						status2.text('Uploading...');
					},
					onComplete: function(file2, response2){
						status2.text('');
						
						if(response2==="success"){
						$('#upload2').html('<img src="../../images/mp3.png"  width="130" alt="" />').addClass('success');
				 			document.getElementById("audio").value = file2
						} else{
							$('<li></li>').appendTo('#files2').text(file2).addClass('text-danger');
						}
					}
				});
				
			});
		</script>
		<script type="text/javascript" >
		$(function(){
			let btnUpload3=$('#upload3');
			let status3=$('#status3');
			new AjaxUpload(btnUpload3, {
				action: 'upload/upload_video.php',
				name: 'uploadfile3',
				onSubmit: function(file3, ext3){
					 if (! (ext3 && /^(mp4|avi)$/.test(ext3))){ 
						status3.text('Upload file dengan format mp4/avi');
						return false;
					}
					status3.text('Uploading...');
				},
				onComplete: function(file3, response3){
					status3.text('');
					
					if(response3==="success"){
					$('#upload3').html('<img src="../../images/vid.png"  width="130" alt="" />').addClass('success');
					let henti = document.getElementById("fileUpload");
			 		document.getElementById("video").value = file3
					} else{
						$('<li></li>').appendTo('#files3').text(file3).addClass('text-danger');
					}
				}
			});
			
		});
	</script>
		<?php 
		if($s['XAudioTanya']==""){$ico_audx="../../images/no_aud.png";$file_audx="";}else {$ico_audx="../../images/mp3.png";$file_audx="$s[XAudioTanya]";}
		if($s['XVideoTanya']==""){$ico_vidx="../../images/no_vid.png";$file_vidx="";}else {$ico_vidx="../../images/vid.png";$file_vidx="$s[XVideoTanya]";}
		if($s['XGambarTanya']==""){$ico_gbrx="../../images/no_pic.png";$file_gbrx="";}else {$ico_gbrx="../../pictures/$s[XGambarTanya]";$file_gbrx="$s[XGambarTanya]";}
		?>
      	<table class="table">
        	<tr height="40">
        		<td align="center">Gambar Soal</td>
        		<td align="center">Audio Soal</td>
        		<td align="center">Video Soal</td>
        	</tr>
         	<tr>
         		<td align="center">
         			<br>               
         			<div id="upload" style="text-align:center; padding-right:10;">
         				<img src="<?php echo $ico_gbrx; ?>" width="130" style="margin-top:10"/>
         			</div>
         			<span id="status" ></span>
                    <ul id="files"></ul>
           			</div>
           			<?php echo $file_gbrx; ?>
           			<input type="text" class="form-control" id="gambar" name="gambar" readonly>
         		</td>
         		<td align="center">   
         			<br>            
                    <div id="upload2" style="text-align:center">
                    	<img src="<?php echo $ico_audx; ?>" width="130"/>
                    </div>
                    <span id="status2" ></span>
                    <ul id="files2"></ul>
           			</div>
           			<?php echo $file_audx; ?>
           			<input type="text" class="form-control" id="audio" name="audio" readonly>
         		</td>
         		<td align="center">  
         			<br>             
                    <div id="upload3" style="text-align:center">
                    	<img src="<?php echo $ico_vidx; ?>" width="130"/>
                    </div>
                    <span id="status3" ></span>
                    <ul id="files3"></ul>
           			</div>
           			<?php echo $file_vidx; ?>
           			<input type="text" class="form-control" id="video" name="video" readonly>
         		</td>
         	</tr>
         </table>
      </div>
    </form>
  </div>
</div>
<div class="modal" id="confirmModal" style="display: none; z-index: 1050;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body" id="confirmMessage">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id="confirmOk">Ok</button>
                <button type="button" class="btn btn-default" id="confirmCancel">Cancel</button>
            </div>
        </div>
    </div>
</div>
<script>
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

	$(document).ready(function(){
		$("#txt_durasi").change(function(){
			var txt_durasi = $("#txt_durasi").val();
			$.ajax({
				url: "tools/ambil_token.php",
				data: "txt_ujian="+txt_durasi,
				cache: false,
				success: function(msg){
					$("#txt_token").val(msg);
				}
			});
		});

		$("#kirim").click(function(){
		var ed = tinyMCE.get('tanyasoal');
		ed.setProgressState(1); // Show progress
		window.setTimeout(function() {
			ed.setProgressState(0); // Hide progress
		}, 2000);

		var a = tinymce.get('tanyasoal').getContent();
		var b6 = $("#gambar").val();
		var b7 = $("#audio").val();
		var b8 = $("#video").val();
		var c = $("#nom").val();
		var d = $("#soal").val();
		var e = $('input[name=radio1]:checked').val();
		var f = $("#map").val();
		var i = $("#txt_kate").val();
		var j = $("#txt_kes").val();
		var k = $("#txt_aca").val();
		var m = $("#txt_ag").val();
		 
		$.ajax({
			type:"POST",
			url:"simpan_soal_edit.php",    
			data: "aksi=simpan&txt_tanya=" + encodeURIComponent(a) + "&txt_gbr=" + b6  + "&txt_aud=" + b7  + "&txt_vid=" + b8 + "&txt_kunci=" + e + "&txt_soal=" + d + "&txt_nom=" + c + "&txt_mapel=" + f + "&txt_kate=" + i + "&txt_kes=" + j + "&txt_aca=" + k + "&txt_ag=" + m ,
			success: function(data){ alert("Update Soal Sukses"); }
		});
	})

</script>
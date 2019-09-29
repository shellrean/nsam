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
        <button type="button" class="btn btn-success btn-sm pull-right" id="kirim"><i class='fa fa-save'></i> Simpan Soal</button>  
      </div>
      <div class="card-body">

      	<?php
      	$sqltanya = mysql_query("select * from cbt_paketsoal where XKodeSoal='$_REQUEST[soal]'");
      	$so = mysql_fetch_array($sqltanya);

      	?>
      	<input type="hidden" id="soal" name="soal" value="<?php echo $_REQUEST['soal']; ?>" />
    	<input type="hidden" id="map" name="map" value="<?php echo $so['XKodeMapel']; ?>" />
    	<?php
    	$sqlsoal = mysql_query("SELECT MAX(XNomerSoal) as maksi FROM `cbt_soal` WHERE XKodeSoal = '$_REQUEST[soal]'");
    	$sm = mysql_fetch_array($sqlsoal);
		$maks = $sm['maksi']+1; 
		?>
		<input type="hidden" id="nomax" name="nomax" value="<?php echo $maks ; ?>" />
		<input type="hidden" id="txt_kate" name="txt_kate" value="1" readonly>
		<input type="hidden" id="txt_ag" name="txt_ag" value="" >
		<input type="hidden" id="txt_kes" name="txt_kes" value="3">
		<input type="hidden" id="txt_aca" name="txt_aca" value="A">
		<input type="hidden" id="txt_ops" name="txt_ops" value="Y">

      	<textarea name="tanyasoal"  id="tanyasoal" style="font-size:18px; width:100%; height:300px"></textarea>


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
         				<img src="../../images/no_pic.png" width="130" style="margin-top:10"/>
         			</div>
         			<span id="status" ></span>
                    <ul id="files"></ul>
           			</div>
           			<input type="text" class="form-control" id="gambar" name="image-upload" readonly>
         		</td>
         		<td align="center">   
         			<br>            
                    <div id="upload2" style="text-align:center">
                    	<img src="../../images/no_aud.png" width="130"/>
                    </div>
                    <span id="status2" ></span>
                    <ul id="files2"></ul>
           			</div>
           			<input type="text" class="form-control" id="audio" name="audio-upload" readonly>
         		</td>
         		<td align="center">  
         			<br>             
                    <div id="upload3" style="text-align:center">
                    	<img src="../../images/no_vid.png" width="130"/>
                    </div>
                    <span id="status3" ></span>
                    <ul id="files3"></ul>
           			</div>
           			<input type="text" class="form-control" id="video" name="video-upload" readonly>
         		</td>
         	</tr>
         </table>
         <hr>
         <h5>Jawaban </h5>
         <table>
         <?php
         for($i=1; $i<=$so['XJumPilihan']; $i++):
         $jwb = "XJawab$i";
         $gjwb = "XGambarJawab$i";
         $var = $i+3;
         ?>
         <script>
          	$(function() {
      			let btnUpload<?= $var; ?>=$('#upload<?= $var; ?>');
         		let status<?= $var; ?>=$('#status<?= $var; ?>');
          		new AjaxUpload(btnUpload<?= $var; ?>,{
         			action: 'upload/upload_gambar.php',
          			name: 'uploadfile',
         			onSubmit: function(file<?= $var; ?>,ext<?= $var; ?>) {
          				if (! (ext<?php echo $var; ?> && /^(jpg|png|jpeg|gif)$/.test(ext<?php echo $var; ?>)))
        				{ 
						status<?php echo $var; ?>.text('Hanya JPG, PNG or GIF yang diizinkan');
					 		return false;
					 	}
					 	status<?php echo $var; ?>.text('Uploading...');
        			},
         			onComplete: function(file<?php echo $var; ?>, response<?php echo $var; ?>){
					 	status<?php echo $var; ?>.text('');
					 	if(response<?php echo $var; ?>==="success"){
					 	$('#upload<?php echo $var; ?>').html('<img src="../../pictures/'+file<?php echo $var; ?>+'"  width="130" alt="" />').addClass('success');
							document.getElementById("gambar<?php echo $var; ?>").value = file<?php echo $var; ?>
						} else{
					 		$('<li></li>').appendTo('#files<?php echo $var; ?>').text(file<?php echo $var; ?>).addClass('error');
					 	}
					 }
         		})
         	})
         </script>
  			<tr>
	   			<td width="70px" height="50px">
	    		<div class="custom-control custom-radio custom-switch">
				  <input type="radio" id="customRadioInline<?= $i ?>" name="radio1" value="<?php echo $i; ?>" class="custom-control-input">
				  <label class="custom-control-label" for="customRadioInline<?= $i ?>">Kunci Jawaban</label>
				</div>
	    		</td>
	    		<td width="100%" colspan="3" > <hr>	
	    		</td> 
	  		</tr>
    		<tr>
    			<td>
    			<div class="col-sm-12"> 
    			<span>
 					<div id="upload<?php echo $var; ?>" style="text-align:center; padding-right:10;">
 						<img src="../../images/no_pic.png" width="130" style="margin-top:10"/>
 					</div>
 					<span id="status<?php echo $var; ?>" >
 				</span>
                <ul id="files<?php echo $var; ?>"></ul>
           		</div>
           		<input type="text" id="gambar<?php echo $var; ?>" class="form-control" name="image-upload<?php echo $var; ?>" readonly>
					<?php $jwb = "XGambarJawab$jwb";?>
				</span>
 				</div>
				</td>
    			<td align="right" colspan="2">
    				<textarea name="tanya"  id="jawab<?php echo $i; ?>" style="font-size:18px; width:95%; height:150px"></textarea>
    			</td>
  			</tr>         
  		<?php endfor; ?>
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
		$("#kirim").click(function(){
		let ed = tinyMCE.get('tanyasoal');

		let a 	= tinymce.get('tanyasoal').getContent();
		let b1 	= tinymce.get('jawab1').getContent();
		let b2 	= tinymce.get('jawab2').getContent();
		let b3 	= tinymce.get('jawab3').getContent();
		let b4 	= tinymce.get('jawab4').getContent();
		let b5 	= tinymce.get('jawab5').getContent();
		let b6 	= $("#gambar").val();
		let b7 	= $("#audio").val();
		let b8 	= $("#video").val();

		let c = $("#nom").val();
		let d = $("#soal").val();
		let e = $('input[name=radio1]:checked').val();

		if ($('input[type=radio]:checked').length >0) {

		}
		else {
			alert("Pilih kunci jawaban");
			return false;
		}

		let f = $("#map").val();

		var g1 = $("#gambar4").val();
		var g2 = $("#gambar5").val();
		var g3 = $("#gambar6").val();
		var g4 = $("#gambar7").val();
		var g5 = $("#gambar8").val();

		var h = $("#nomax").val();
		var i = $("#txt_kate").val();
		var j = $("#txt_kes").val();
		var k = $("#txt_aca").val();
		var l = $("#txt_ops").val();
		var m = $("#txt_ag").val();

		$.ajax({
     		type:"POST",
     		url:"soal/simpan_soal_tambah.php",    
     		data: "aksi=simpan&txt_tanya=" + encodeURIComponent(a) + "&txt_jawab1=" + encodeURIComponent(b1) + "&txt_jawab2=" + encodeURIComponent(b2) + "&txt_jawab3=" + encodeURIComponent(b3) + "&txt_jawab4=" + encodeURIComponent(b4)  + "&txt_jawab5=" + encodeURIComponent(b5)  + "&txt_gbr=" + b6  + "&txt_audio=" + b7  + "&txt_video=" + b8 + "&txt_kunci=" + e + "&txt_soal=" + d + "&txt_nom=" + c + "&txt_gbr1=" + g1 + "&txt_gbr2=" + g2 + "&txt_gbr3=" + g3 + "&txt_gbr4=" + g4 + "&txt_gbr5=" + g5 + "&txt_mapel=" + f + "&txt_nomax=" + h + "&txt_kate=" + i + "&txt_kes=" + j + "&txt_aca=" + k + "&txt_ops=" + l + "&txt_ag=" + m,

	 		success: function(data){
	  			alert("Simpan sukses");
	  			window.location.href = "?modul=edit_soal&jum=5&soal="+d;
	 		}
	 	});
		});
	})



</script>
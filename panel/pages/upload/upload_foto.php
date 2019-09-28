<?php

if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

?>
<script src="../js/jquery.wallform.js"></script>

<script>
$.noConflict();
jQuery( document ).ready(function( $ ) {
            $('#photoimg').on('change', function(){ 
				$("#imageform").ajaxForm({target: '#preview', 
				     beforeSubmit:function(){ 
					
						$("#imageloadstatus").show();
						 $("#imageloadbutton").hide();
					 }, 
					success:function(){ 
					 $("#imageloadstatus").hide();
					 $("#imageloadbutton").show();
					}, 
					error:function(){ 
					 $("#imageloadstatus").hide();
					$("#imageloadbutton").show();
					} }).submit();
			});
		});
</script>
<style>

body
{
font-family:arial;
}

#preview
{
color:#cc0000;
font-size:12px
}
.imgList 
{
max-height:150px;
margin-left:5px;
border:1px solid #dedede;
padding:4px;	
float:left;	
}

</style>
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Upload foto peserta ujian
      </div>
      <div class="card-body">
      	<div id='preview'></div>
      </div>
      <div class="card-footer">
      	<form id="imageform" method="post" enctype="multipart/form-data" action='upload/upload_foto_proses.php' style="clear:both">
            <div id='imageloadstatus' style='display:none'><img src="../../images/loading.gif" alt="Uploading...."/ width="80px"></div>
            <div id='imageloadbutton' style="margin-top:20px">
            <input type="file" name="photos[]" id="photoimg" multiple="true" />
            </div> 
        </form> <br>
      	<a href="?modul=daftar_siswa" class="btn btn-success btn-sm">
      		<i class="icon-list"></i>
      		Lihat data siswa
      	</a>
      </div>
    </div>
  </div>
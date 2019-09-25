<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Download File excel (Template administrasi user)
      </div>
      <div class="card-body">
      	<!-- <img src="../../images/xls.png"> -->
      	Upload data administrasi user untuk mempermudah pengelolaah user oleh admin yang meliputi 3 hak akses <br>
      	1. Admin : Hak penuh seluuh fitur <br>
      	2. Guru  : Hak fitur edit biodata banksoal dan analisa
      </div>
      <div class="card-footer">
      	<a href="../../file-excel/bee_user_temp.xls" target="_blank" class="btn btn-success btn-sm" >
      		<i class="icon-cloud-download"></i>
      		Download template
      	</a>
      	<a href="?modul=data_user" class="btn btn-success btn-sm">
      		<i class="icon-list"></i>
      		Lihat data user
      	</a>
      </div>
    </div>
  </div>

  <div class="col-lg-12">
  	<div class="card">
  		<div class="card-header py-3">
  			<i class="icon-cloud-upload"></i>
  			Upload template excel - user
  		</div>
  		<div class="card-body">
  			<form method="post" enctype="multipart/form-data" action="?modul=uploaduser">
  			<div class="form-group">
	            <label>File excel daftar user</label>
	            <input name="userfile" type="file" class="btn btn-default">
	            <input type="submit" name="upload" value="Import" class="btn btn-primary btn-sm">
          	</div>
          	Presentasi proses upload
          	<div id="progress" style="width:75%; border:1px solid #ccc; padding:5px; margin-top:10px; height:33px; background-color:#D9D9D9"></div>
			<div id="information" style="width"></div>
  			</form>
  		</div>
  	</div>
  </div>
</div>

<?php 

if($_REQUEST['modul'] == "uploaduser") {
	include "excel_reader2.php";
}
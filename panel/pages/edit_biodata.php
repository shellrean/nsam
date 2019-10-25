<?php
	if(!isset($_COOKIE['beeuser'])){
	header("Location: login.php");}
?>


<style>
.left {
    float: left;
    width: 73%;
}
.right {
    float: right;
    width: 25%;
}
.group:after {
    content:"";
    display: table;
    clear: both;
}
img {
    max-width: 100%;
    height: auto;
}
@media screen and (max-width: 480px) {
    .left, 
    .right {
        float: none;
        width: auto;
		margin-top:10px;		
    }
	
}
</style>
<script type="text/javascript">
$(document).ready(function(){
 	var loading = $("#loading");
	var tampilkan = $("#tampilkan");

	loading.hide()
//apabila terjadi event onchange terhadap object <select id=propinsi>
 $("#simpan").click(function(){

 var txt_user = $("#user").val();
 var txt_nama = $("#nama").val();
 var txt_nip = $("#nip").val();
 var txt_alamat = $("#alamat").val();
 var txt_telp = $("#telp").val();
 var txt_facs = $("#faxs").val();
 var txt_email = $("#email").val();
 
  
 $.ajax({
     type:"POST",
     url:"ubahbiodata.php",    
     data: "aksi=simpan&txt_nama=" + txt_nama + "&txt_nip=" + txt_nip + "&txt_alamat=" + txt_alamat + 
	 "&txt_telp=" + txt_telp + "&txt_facs=" + txt_facs + "&txt_email=" + txt_email + "&txt_user=" + txt_user,
	 success: function(data){
	 	loading.fadeOut();
		$("#info").html(data);
		$("#info").fadeOut(2000);
	 }
	 });
	 });
});
  
</script>
<div id="mainbody" >
<?php 
include "../../config/server.php";

	$sql = mysql_query("select * from cbt_user WHERE Username='$_COOKIE[beeuser]'");
	$xadm = mysql_fetch_array($sql);
	$nama= $xadm['Nama'];
	$nip= $xadm['NIP'];
	$alamat= $xadm['Alamat']; 
	$telp= $xadm['HP']; 
	$faxs= $xadm['Faxs'];
	$email= $xadm['Email']; 
	$poto= $xadm['XPoto'];
	$passw=$_COOKIE['beepassz'];
	
?>

<br />
<span>
    <div class="left">
    				<div class="card">
                        <div class="card-header">
                            Edit Biodata
                        </div>
                        <div class="card-body">
                            <table width="100%">
                            <tr height="42px"><td width="30%">User Name&nbsp;</td><td>:<td> <input class="form-control"type="text" id="user" value="<?php echo "$_COOKIE[beeuser]"; ?>"/>
							</td></tr>
							
                            <tr height="42px"><td >Nama&nbsp;</td><td>: <td> <input class="form-control"type="text" id="nama" value="<?php echo "$nama"; ?>"/> </td></tr>
                            <tr height="42px"><td>NIP&nbsp;</td><td>: <td> <input class="form-control"type="text" id="nip" value="<?php echo "$nip"; ?>"/> </td></tr>
                            <tr height="42px"><td>Alamat&nbsp;</td><td>:<td> <input class="form-control"type="textarea" id="alamat"  cols="20" rows="2" value="<?php echo "$alamat"; ?>"/> </td></tr>
                            <tr height="42px"><td>No. Telp&nbsp;</td><td>:<td> <input class="form-control"type="text" id="telp"  value="<?php echo "$telp"; ?>"/> </td></tr>
                            <tr height="42px"><td>No. Fax.&nbsp;</td><td>: <td> <input class="form-control"type="text" id="faxs"  value="<?php echo "$faxs"; ?>"/> </td></tr>
                            <tr height="42px"><td>Email&nbsp;</td><td>: <td> <input class="form-control"type="text" id="email"  value="<?php echo "$email"; ?>"/> </td></tr>
                          
                            </table>
                        </div>
						<div class="card-body">
						Bila user name diubah wajib untuk logout lalu login kembali dengan menggunakan username baru
						</div>
                        <div class="card-footer">
                            <input type="submit"  class="btn btn-primary btn-small" id="simpan" name="simpan" value="Simpan">
                            <div id="info"></div><div id="loading"><img src="../../images/loader1.gif" height="10"></div>
                        </div>
                    </div>
			
			</div>
</div>  
   
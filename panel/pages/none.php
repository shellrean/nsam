<?php
if(!isset($_COOKIE['beeuser'])) { header("Location: login.php");}
?>

<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header py-3">
        <i class="fa fa-align-justify"></i> Dashboard 
      </div>

      <div class="card-body">
      	<?php
      		if($_COOKIE['beelogin'] == "siswa" || $_COOKIE['beelogin'] == "guru") {

      		}
      		else {
      			include "../../config/server.php";

      			if($mode == "pusat") {
      				$sqlklien 	= mysql_query("select * from cbt_admin");
      				$sk 		= mysql_fetch_array($sqlklien);
      				$kodesekolah= $sk['XKodeSekolah'];

      				include "../../config/ipserver.php";

      				if (isset($_SERVER['SERVER_NAME'])) {
      					$serverIP	= $_SERVER['SERVER_NAME'];
      					$alamat2	= $_SERVER['SERVER_PORT'];
      				}
 
      				if ($soc = @fsockopen($ipserver, 80, $num, $error, 5)) {
      					$status_server = 1;

      					$host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);

      					$pc_client = $host_name;

      					include "../../config/server_status.php";

      					if($status_konek == '1') {
                  $sqlhost = mysql_query("select * from server_sekolah where XServerId = '$kodesekolah'");

                  $sqlstatus = mysql_num_rows($sqlhost);
                  $sq = mysql_fetch_array($sqlhost);
                  $var_status = $sq['XStatus'];
                }
                else {
                  $var_status = ''; $sqlstatus = 9;
                }
                


                if($sqlstatus > 0 && $var_status == '0') {
                  $warna = "warning"; 
                  $server_status = "STANDBY";
                  $txt_server_status = "Akses ke Server Pusat Ditutup SN sudah terdaftar di Server Pusat";
                  $huruf  = "#ffca01";
                  $bg     = "#ffca01";
                }

                elseif($var_status == '' && $sqlstatus > 0) {
                  $warna = "danger"; 
                  $server_status = "STANDBY";
                  $txt_server_status = "CBTSync tidak terkoneksi ke server pusat";
                  $huruf ="red";
                  $bg="red";
                }

                elseif($sqlstatus == 0 && $var_status =='') {
                  $warna = "danger"; 
                  $server_status = "OFFLINE";
                  $txt_server_status = "ID Server / SN tidak sesuai dengan data server pusat"; 
                  $huruf ="red";
                  $bg="red";
                }

                elseif($sqlstatus>0 && $var_status>0) {
                  $warna = "info"; 
                  $server_status = "AKTIF";
                  $txt_server_status = "CBTSync Aktif, Sinkronisasi Siap Digunakan"; 
                  $huruf ="#10d8f3";
                  $bg="#15c0d7";
                }

      				} ?>
                  <div>  
                    <div class="row">
                      <div class="col-md-4">
                        <h3 class="text-center">SERVER SEKOLAH</h3>
                        <div  class="text-center">
                        <h4 style="color:<?= $huruf; ?>; ?>"><?= "<b>$server_status</b>"; ?></h4><br/>
                      </div>
                    
                      <div class="alert alert-<?= $warna; ?> text-center">
                        <?= "$txt_server_status "; ?>
                      </div>
                      <div class="alert alert-light text-center">
                        <h6>Server ID : 
                          <span class="text-<?= $warna ?>">
                          <?= "$kodesekolah"; ?>
                          </span>
                        </h6>
                      </div>
                      <div>
                        <?php if($server_status == "AKTIF"){ ?>
                         <a href="?modul=sinkron"><button type="button"  class="btn btn-success" aria-hidden="true">Sinkronisasi</button></a>
                        <?php } else { ?>
                        <button type="button"  class="btn btn-default" aria-hidden="true" disabled="disabled">Sinkronisasi</button>
                        <?php } ?>
                      </div>
                    </div>
                  </div>
      		<?php	}

          else {

            include "../../config/server.php";
            $host_name = gethostbyaddr($_SERVER['REMOTE_ADDR']);

            $pc_client = $host_name;
            $status_server = 0;
            $status_internet = "Jaringan server ke Internet : Terhubung";

            $jumkelas = mysql_num_rows(mysql_query("select * from cbt_kelas"));
            $jumsiswa = mysql_num_rows(mysql_query("select * from cbt_siswa"));
            $jummapel = mysql_num_rows(mysql_query("select * from cbt_mapel"));
            $jumsoal = mysql_num_rows(mysql_query("select * from cbt_paketsoal"));
            $jumsek = mysql_num_rows(mysql_query("select * from server_sekolah"));
            $jummedia = mysql_num_rows(mysql_query("select * from cbt_upload_file"));

            ?>

            <div>  
              <div class="row">
                <div class="col-md-4">
                  <h3 class="text-center">SERVER PUSAT</h3> <br>
                  <div class="alert alert-success text-center">
                  CBTSync Lokal Aktif terhubung sebagai Server PUSAT
                </div>
                <div class="alert alert-light text-center">
                  <h6>Server ID : 
                    <span class="text-info">
                    <?php
                      $sqlklient  = mysql_query("select * from cbt_admin");
                      $sek        = mysql_fetch_array($sqlklient);
                      $kodesek    = $sek['XKodeSekolah'];
                      echo "$kodesek ";
                     ?>
                    </span>
                  </h6>
                </div>
                </div>
              </div>
              <div class="row">
              <div class="col-sm-6 col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                      <i class="icon-people"></i>
                    </div>
                    <div class="text-value"><?= $jumkelas; ?></div>
                    <small class="text-muted text-uppercase font-weight-bold">Kelas</small>
                    <div class="progress progress-xs mt-3 mb-0">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.col-->
              <div class="col-sm-6 col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                      <i class="icon-user-follow"></i>
                    </div>
                    <div class="text-value"><?= $jumsiswa; ?></div>
                    <small class="text-muted text-uppercase font-weight-bold">Siswa</small>
                    <div class="progress progress-xs mt-3 mb-0">
                      <div class="progress-bar bg-success" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.col-->
              <div class="col-sm-6 col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                      <i class="icon-book-open"></i>
                    </div>
                    <div class="text-value"><?= $jummapel; ?></div>
                    <small class="text-muted text-uppercase font-weight-bold">Mapel</small>
                    <div class="progress progress-xs mt-3 mb-0">
                      <div class="progress-bar bg-warning" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.col-->
              <div class="col-sm-6 col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                      <i class="icon-pie-chart"></i>
                    </div>
                    <div class="text-value"><?= $jumsoal; ?></div>
                    <small class="text-muted text-uppercase font-weight-bold">Banksoal</small>
                    <div class="progress progress-xs mt-3 mb-0">
                      <div class="progress-bar" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.col-->
              <div class="col-sm-6 col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                      <i class="icon-speedometer"></i>
                    </div>
                    <div class="text-value"><?= $jumsek; ?></div>
                    <small class="text-muted text-uppercase font-weight-bold">Sekolah</small>
                    <div class="progress progress-xs mt-3 mb-0">
                      <div class="progress-bar bg-danger" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.col-->
              <div class="col-sm-6 col-md-2">
                <div class="card">
                  <div class="card-body">
                    <div class="h1 text-muted text-right mb-4">
                      <i class="icon-folder"></i>
                    </div>
                    <div class="text-value"><?= $jummedia; ?></div>
                    <small class="text-muted text-uppercase font-weight-bold">File media</small>
                    <div class="progress progress-xs mt-3 mb-0">
                      <div class="progress-bar bg-info" role="progressbar" style="width: 25%" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- /.col-->
            </div>
            </div>
          <?php }} ?>
      </div>
    </div>
  </div>
</div>
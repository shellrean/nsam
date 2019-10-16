<?php
	if(!isset($_COOKIE['beeuser'])){
	header("Location: login.php");}
?>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <a href="?modul=aktifkan_jadwaltes" class="btn btn-light btn-sm">
						      <i class="fa fa-arrow-circle-left"></i> Kembali</i>
				            </a>
                            <button id="getSelectedRows" type="button" class="btn btn-primary btn-sm">Selesai / Online</button>
                            <button id="getPindahIP" type="button" class="btn btn-success btn-sm">Ganti station siswa sudah login di tempat lain</button>
                            <input type="hidden" id="nilai"><input type="hidden" id="tokez" value="<?php echo $_REQUEST['token']; ?>">
                        </div>
                        
                        <div class="card-body">
                            <table id="grid" class="table table-condensed table-hover table-striped" data-selection="true" data-multi-select="true" data-row-select="true" data-keep-selection="true">
                                <thead>
                                    <tr>
                                        <th data-column-id="id" data-identifier="true" data-type="numeric" data-align="right" data-width="20px">No.</th>
                                        <th data-column-id="nomer" data-order="asc" data-align="center" data-header-align="center" data-width="10%" data-filterable="true">No.Ujian</th>
                                        <th data-column-id="nama" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="30%" >Nama Siswa</th>
                                        <th data-column-id="nisn" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="9%" >NISN</th>      
                                        <th data-column-id="kelas" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="9%" >Kelas</th>               
                                        <th data-column-id="jurusan" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="10%" >Jurusan</th>  
                                        <th data-column-id="mapel" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="14%" >Mapel</th>
                                        <th data-column-id="status" data-css-class="cell" data-header-css-class="column" data-filterable="true" data-width="10%" >Status</th> 
                                        <th data-column-id="hidden" data-visible="false" data-visible-in-selection="false">Hidden</th>
                                    </tr>
                                </thead>
                            <tbody>
                            <?php 
                            include "../../config/server.php";
                            if(isset($_REQUEST['token'])){

		                      $sql = mysql_query("select su.*,s.*,su.urut as yoi,u.XKodeMapel,m.XNamaMapel from cbt_siswa_ujian su left join cbt_siswa s on s.XNomerUjian=su.XNomerUjian
		                      left join cbt_ujian u on u.XTokenUjian = su.XTokenUjian
		                      left join cbt_mapel m on m.XKodeMapel = u.XKodeMapel
		                      where u.XStatusUjian = '1' and su.XTokenUjian = '$_REQUEST[token]' order by su.Urut");
		                      while($s = mysql_fetch_array($sql)){
		                          if($s['XStatusUjian']=='1'){$xsta = "Online";}
		                          elseif($s['XStatusUjian']=='9'){$xsta = "Selesai";}
		                      echo "
							    <tr>
							    	<td>$s[yoi]</td>
							    	<td>$s[XNomerUjian]</td>
							    	<td>$s[XNamaSiswa]</td>
							    	<td>$s[XNIK]</td>
							    	<td>$s[XKodeKelas]</td>
							    	<td>$s[XKodeJurusan]</td>
							    	<td>$s[XNamaMapel]</td>
							    	<td>$xsta</td>
							    </tr>
		                      "; 
		                      }
		
                            } 		
                            ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <link href="../css/jquery.bootgrid.css" rel="stylesheet" />
        <script src="../js/jquery.bootgrid.js"></script>
     
        <script>
		var $jnoc = jQuery.noConflict();   
            $jnoc(function()
            {
                function init()
                {
                    $jnoc("#grid").bootgrid({
                        formatters: {
                            "link": function(column, row)
                            {
                                return "<a href=\"#\">" + column.id + ": " + row.id + "</a>";
                            }
                        },
                        rowCount: [-1, 10, 50, 75]
                    });
                }
                
                init();
                
                $jnoc("#append").on("click", function ()
                {
                    $jnoc("#grid").bootgrid("append", [{
                            id: 0,
                            sender: "hh@derhase.de",
                            received: "Gestern",
                            link: ""
                        },
                        {
                            id: 12,
                            sender: "er@fsdfs.de",
                            received: "Heute",
                            link: ""
                        }]);
                });
                
                $jnoc("#clear").on("click", function ()
                {
                    $jnoc("#grid").bootgrid("clear");
                });
                
                $jnoc("#removeSelected").on("click", function ()
                {
                    $jnoc("#grid").bootgrid("remove");
                });
                
                $jnoc("#clearSearch").on("click", function ()
                {
                    $jnoc("#grid").bootgrid("search");
                });
                
                $jnoc("#clearSort").on("click", function ()
                {
                    $jnoc("#grid").bootgrid("sort");
                });
                
                $jnoc("#getSelectedRows").on("click", function ()
                {
					var nilaix = $jnoc("#grid").bootgrid("getSelectedRows");
					var tokex = document.getElementById("tokez").value;
                    var data = 'nama=' + nilaix + '& token=' + tokex;
                    $jnoc.ajax({
                        type: 'POST',
                        url: "tools/reset.php",
                        data: data,
                        success: function() {
                            document.getElementById("nilai").value = nilaix;
							document.location.reload();
									
                        }
                    });				  
                });

				$jnoc("#getPindahIP").on("click", function ()
                {
					var nilaix = $jnoc("#grid").bootgrid("getSelectedRows");
					var tokex = document.getElementById("tokez").value;
                    var data = 'nama=' + nilaix + '& token=' + tokex;
					
                    $jnoc.ajax({
                        type: 'POST',
                        url: "tools/hapus_ip.php",
                        data: data,
                        success: function() {
                            document.getElementById("nilai").value = nilaix;
							document.location.reload();
									
                        }
                    });				  
					

                });
				
            });
        </script>
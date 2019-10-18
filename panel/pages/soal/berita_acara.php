<?php
if(!isset($_COOKIE['beeuser'])){
    header("Location: login.php");
}

$tgljam = date("Y/m/d H:i");  
$tgl = date("Y/m/d"); 

$tgx = 29;
$blx = 09;
$thx = 2016;

$tglx = date("Y/m/d");
$jamx = date("H:i:s");

?>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                Daftar pelaksanaan test
            </div>
            <div class="card-body">
                <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                    <thead>
                        <tr>
                            <th width="2%">No</th>
                            <th width="5%">Ujian</th>                                        
                            <th width="8%">Kode Soal</th>
                            <th width="12%">Mata Pelajaran</th>
                            <th width="4%">Kelas</th>   
                            <th width="4%">Token</th>   
                            <th width="5%">Waktu</th>
                            <th width="3%">Durasi</th>  
                            <th width="5%">Proktor - Pengawas</th>
                            <th width="10%">Catatan</th>
                            <th width="5%">Edit Pengawas | Print</th>                                        
                        </tr>
                    </thead>
                    <?php 
                    $sql = mysql_query("select u.*,m.*,u.Urut as Urutan,u.XKodeKelas as kokel from cbt_ujian u left join cbt_mapel m on m.XKodeMapel = u.XKodeMapel left join cbt_paketsoal p on p.XKodeSoal = u.XKodeSoal where u.XStatusUjian='9'");
                    while($s = mysql_fetch_array($sql)){ 
                    $sqlsoal  = mysql_num_rows(mysql_query("select * from cbt_soal where XKodeSoal = '$s[XKodeSoal]'"));
                    $sqlpakai = mysql_num_rows(mysql_query("select * from cbt_siswa_ujian where XKodeSoal = '$s[XKodeSoal]' and XStatusUjian = '1'"));
                    $sqlsudah = mysql_num_rows(mysql_query("select * from cbt_jawaban where XKodeSoal = '$s[XKodeSoal]'"));
                    if($sqlsoal<1){$kata="disabled";}  else {$kata="";} 
                    if($sqlsudah>0||$sqlpakai>0){$kata="disabled";}  else {$kata="";}           
                    if($sqlpakai>0){$katapakai="disabled";}  else {$katapakai="";}
                    
                    $time1 = "$s[XJamUjian]";
                    $time2 = "$s[XLamaUjian]";
                    
                    $secs = strtotime($time2)-strtotime("00:00:00");
                    $jamhabis = date("H:i:s",strtotime($time1)+$secs);  
                    $sekarang = date("H:i:s");  
                    $tglsekarang = date("Y-m-d");   
                    $tglujian = "$s[XTglUjian]";    
        
                    ?>

                    <script>    
                    $(document).ready(function(){
                        $("#awas<?php echo $s['XTokenUjian']; ?>").click(function(){
                         var txt_tokenx = $("#txt_tokenx<?php echo "$s[XTokenUjian]"; ?>").val();
                         var txt_proktorx = $("#txt_proktorx<?php echo "$s[XTokenUjian]"; ?>").val();
                         var txt_nipproktorx = $("#txt_nipproktorx<?php echo "$s[XTokenUjian]"; ?>").val();
                         var txt_pengawasx = $("#txt_pengawasx<?php echo "$s[XTokenUjian]"; ?>").val();
                         var txt_nip_pengawasx = $("#txt_nip_pengawasx<?php echo "$s[XTokenUjian]"; ?>").val();
                         var txt_catatanx = $("#txt_catatanx<?php echo "$s[XTokenUjian]"; ?>").val();
                          
                         $.ajax({
                             type:"POST",
                             url:"ubahpengawas.php",    
                             data: "aksi=simpan&txt_tokenx=" + txt_tokenx + "&txt_proktor=" + txt_proktorx + "&txt_nipproktor=" + txt_nipproktorx + "&txt_pengawas=" + txt_pengawasx + "&txt_nippengawas=" + txt_nip_pengawasx + "&txt_catatan=" + txt_catatanx,
                             success: function(data){
                                  document.location.reload();
                                  loading.fadeOut();
                                  tampilkan.html(data);
                                  tampilkan.fadeIn(100);
                                  tampildata();
                                }
                             });
                        });
                    }
                    );
                    </script>    

                    <tr class="odd gradeX">
                        <td align="center"> <input type="hidden" value="<?= $s['Urutan']; ?>" id="txt_mapel<?= $s['Urutan']; ?>"><?= $s['Urutan']; ?>
                            <input type="hidden" value="<?= $s['Urutan']; ?>" id="txt_ujian<?= $s['Urutan']; ?>">
                        </td>
                        <td align="center"><?= $s['XKodeUjian']; ?></td>
                        <td align="center"><?= $s['XKodeSoal']; ?></td>
                        <td align="center"><?= $s['XNamaMapel']; ?></td>
                        <td align="center"><?= $s['kokel']." - ".$s['XKodeJurusan']."."; ?></td> 
                        <td align="center"><?= $s['XTokenUjian']; ?></td>
                        <td align="center"><?= $s['XTglUjian']." ".$s['XJamUjian'] ; ?></td>                                        
                        <td align="center"><?= $s['XLamaUjian']; ?></td>
                        <td align="center"><?= $s['XProktor']." - ".$s['XPengawas']; ?></td>
                        <td align="center"><?= $s['XCatatan']; ?></td>
                        <td align="center">
                            <button type="button" class="btn btn-secondary btn-sm"  
                                data-toggle="modal" data-target="#myPengawas<?= $s['XTokenUjian']; ?>"><i class="fa fa-edit"></i>
                            </button>
                            <a href="?modul=cetak_berita&token=<?= $s['XTokenUjian']; ?>"><button type="button" class="btn btn-primary btn-sm"><i class="fa fa-print"></i></button></a>
                        </td>     
                    </tr>

                      <!-- Modal -->
                        <div class="modal fade" id="myPengawas<?= $s['XTokenUjian']; ?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <b class="modal-title" id="myModalLabel"><?= "Pengawas ujian mapel : $s[XNamaMapel]"; ?></b>
                                    </div>
                                    <div class="modal-body" >
                                        <input type="hidden" value="<?= $s['XTokenUjian']; ?>" id="txt_tokenx<?= $s['XTokenUjian']; ?>">
                                        <div class="form-group">
                                            <label>Nama proktor</label>
                                            <input type="text" id="txt_proktorx<?= $s['XTokenUjian']; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>NIP proktor</label>
                                            <input type="text" id="txt_nipproktorx<?= $s['XTokenUjian']; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nama pengawas</label>
                                            <input type="text" id="txt_pengawasx<?= $s['XTokenUjian']; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Nip pengawas</label>
                                            <input type="text" id="txt_nip_pengawasx<?= $s['XTokenUjian']; ?>" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Catatan</label>
                                            <textarea id="txt_catatanx<?= $s['XTokenUjian']; ?>" cols="45" rows="5" class="form-control"></textarea>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="submit"  class="btn btn-primary btn-sm" id="awas<?= $s['XTokenUjian']; ?>" value="Simpan">
                                        <button type="submit" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="glyphicon glyphicon-minus-sign"></i> Tutup</button>
                                    </div>                                        
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
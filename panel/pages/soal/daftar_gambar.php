<?php
    if(!isset($_COOKIE['beeuser'])){
    header("Location: login.php");}

if(isset($_REQUEST['gambar'])){
    $gambar=$_REQUEST['file'];
    $folder="../../pictures/$gambar";
    if(file_exists($folder)) {
    unlink($folder);
    }
    }
?>
<?php
    $folder = "../../pictures"; //folder tempat gambar disimpan 
    $handle = opendir($folder);
    $i=1;
?>
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <form>
                    <table>
                        <tr>
                            <td>
                                <a href="?modul=upl_filesoal" id="custId" class="btn btn-primary btn-sm">
                                    <i class="fa fa-plus-circle"></i> Tambah Gambar
                                </a>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="card-body">
                <table width="100%" class="table table-striped table-bordered table-hover">
                    <tbody>
                        <?php
                        while(false !== ($file = readdir($handle))){  
                            if($file != '.' && $file != '..'){ ?> 
                        <td style="border:1px solid #000000;">
                            <a href="?modul=file_pendukung&gambar=hapus&file=<?php echo $file; ?>">
                                <i class="fa fa-times "></i>
                            </a> 
                            <table width="100%">
                                <tr>
                                    <td align="center">
                                        <a class="fancybox" href="../../pictures/<?php echo $file; ?>" data-fancybox-group="gallery" target="popup" onclick="window.open('../../pictures/<?php echo $file; ?>','popup','width=600,height=600'); return false;" Open Link in Popup title="<?php echo $file; ?>"><img class="img-polaroid" src="../../pictures/<?php echo $file; ?>" alt="" width="50px"/>
                                        </a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                        <?php 
                        if(($i % 10) == 0){  
                            echo '</tr><tr>';  
                        }  
                        $i++;  
                        }  
                        }
                        ?>
                    </tbody>
                </table>
                </form>
            </div>
        </div>
    </div>
</div>

 <script>
    $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true
        });
    
    });
    </script>
    <script>$(document).ready(function() {
    var table = $('#example').DataTable();
 
    $('#example tbody').on( 'click', 'tr', function () {
        if ( $(this).hasClass('selected') ) {
            $(this).removeClass('selected');
        }
        else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    } );
 
    $('#button').click( function () {
        table.row('.selected').remove().draw( false );
    } );
} );

</script>
<?php
  if(!isset($_COOKIE['PESERTA'])) {
    header("Location: index.php");
  }

  include "config/server.php";
  include "config/fungsi_jam.php";
  include "config/ip.php";

  $tglbuat  = date("Y-m-d");
  $xtgl1     = date("Y-m-d");
  $xjam1    = date("H:i:s");

  $user     = $_COOKIE['PESERTA'];
  
  $sqluser  = mysql_query("select *, u.XKodeKelas as kelaz, s.XKodeKelas as kelasx, s.XKodeJurusan as jurusx, u.XKodeSoal as soalz, u.XKodeUjian as ujianz, s.XSesi as sesiz, s.XSetId as setidx, u.XKodeMapel as mapelx, u.XSemester as semex from cbt_siswa s left join cbt_ujian u on (s.XKodeKelas = u.XKodeKelas or u.XKodeKelas = 'ALL') and (s.XKodeJurusan = u.XKodeJurusan or u.XKodeJurusan = 'ALL') left join cbt_mapel m on m.XKodeMapel = u.XKodeMapel where s.XNomerUjian = '$_COOKIE[PESERTA]' and u.XStatusUjian = '1'");

  $s = mysql_fetch_array($sqluser);

  $val_siswa      = $s['XNamaSiswa'];
  $xnamakelas     = $s['XNamaKelas'];
  $xsesi          = $s['sesiz'];
  $xkodesoal      = $s['soalz'];
  $xkodemapel     = $s['mapelx'];
  $xsemester      = $s['semex'];
  $xkodekelas     = $s['kelaz'];
  $xkodekelasx    = $s['kelasx'];
  $xkodejurusx    = $s['jurusx'];
  $xkodeujianx    = $s['ujianz'];
  $xsetidx        = $s['setidx'];
  $xjumlahsoal    = $s['XJumSoal'];
  $xtokenujian    = $s['XTokenUjian'];  
  $xbatasmasuk    = $s['XBatasMasuk'];   
  $xnamamapel     = $s['XNamaMapel'];
  $xjamujian      = $s['XJamUjian']; 
  $xjumpilg       = $s['XPilGanda'];   
  $xjumesai       = $s['XEsai'];     
  $xacaksoal      = $s['XAcakSoal'];  
  $xjumlahpilihan = $s['XJumPilihan'];
  $xtglujian      = $s['XTglUjian'];
  $xmaxlambat     = $s['XLambat'];
  $xagama         = $s['XAgama']; 
  $xmapelagama    = $s['XMapelAgama']; 
  $xpilih         = $s['XPilihan']; 

  $xjumlahpilganda = $s['XPilGanda'];
  $xjumlahesai    = $s['XEsai'];  
  $poto           = $s['XFoto'];  

  if($poto==''){
    $gambar="avatar.gif";
  } else{
    $gambar=$poto;
  }

  $sqlIP = mysql_query("select * from cbt_siswa_ujian where XNomerUjian = '$user' and XTokenUjian = '$xtokenujian'");
  $ad0   = mysql_fetch_array($sqlIP);
  $user_ip2 = str_replace(" ", "", $ad0['XGetIP']);
  $sqlIP1 = mysql_query("update `cbt_siswa_ujian` set XGetIP = '$user_ip' WHERE XNomerUjian = '$user' and XTokenUjian = '$xtokenujian'");

  $sqlnk = mysql_query("select * from cbt_siswa where XNomerUjian = '$user'");
  $sNK = mysql_fetch_array($sqlnk);
  $NK = str_replace(" ","",$sNK['XNamaKelas']);
  $sqlNKsj = mysql_query("update cbt_siswa_ujian set XNamaKelas = '$NK' where XNomerUjian='$user' nad XTokenUjian = '$xtokenujian'");
  $kodekelas = $sNK['XKodeKelas'];
  $kodejurusan = $sNK['XKodeJurusan'];

  if($xtglujian <> $xtgl1){
    header('Location:index.php');
  } 

  $xlamaujian = $s['XLamaUjian'];

  $jm1 = substr($xjam1,0,2);
  $mn1 = substr($xjam1,3,2);
  $dt1 = substr($xjam1,6,2);

  $jm2 = substr($xjamujian,0,2);
  $mn2 = substr($xjamujian,3,2);
  $dt2 = substr($xjamujian,6,2);

  $tg1 = substr($xtgl1,8,2);
  $bl1 = substr($xtgl1,5,2);
  $th1 = substr($xtgl1,0,4);

  $selstart = mktime($jm1,$mn1,$dt1,$bl1,$tg1,$th1);
  $selend = mktime($jm2,$mn2,$dt2,$bl1,$tg1,$th1);
  $diffsec =  $selstart-$selend;
  $hr = (int) ($diffsec / 3600);
  $mn = (int) (($diffsec % 3600) / 60);
  $sc =  $diffsec - ($hr*3600 + $mn * 60); 

  $jm3 = substr($xlamaujian,0,2);
  $mn3 = substr($xlamaujian,3,2);
  $dt3 = substr($xlamaujian,6,2);
  $selstart2 = mktime($jm3,$mn3,$dt3,$bl1,$tg1,$th1);
  $selend2 = mktime($hr,$mn,$sc,$bl1,$tg1,$th1); 

  $diffsec2 =  $selstart2-$selend2;
  $hr2 = (int) ($diffsec2 / 3600);
  $mn2 = (int) (($diffsec2 % 3600) / 60);
  $sc2 =  $diffsec2 - ($hr2*3600 + $mn2 * 60);

  if($hr2=="0"){$hr2="00";}
  if($mn2=="0"){$mn2="00";}
  if($sc2=="0"){$sc2="00";}

  $hrz = strlen($hr2);
  $mnz = strlen($mn2);

  if($hrz<2){$hr2 = "0".$hr2;}else{$hr2=$hr2;}
  if($mnz<2){$mn2 = "0".$mn2;}else{$mn2=$mn2;}

  $sisawaktu = "$hr2:$mn2:$sc2";

  $sqlceksiswa = mysql_query("select * from cbt_siswa_ujian where XNomerUjian = '$user' and XKodeSoal = '$xkodesoal' and XTokenUjian ='$xtokenujian' and XSesi ='$xsesi'"); 
  $jumsqlceksiswa = mysql_num_rows($sqlceksiswa); 
  $s2 = mysql_fetch_array($sqlceksiswa);

  $xstatusujian = $s2['XStatusUjian'];
  if($xstatusujian==9){
   header('location:logout.php');
  }

  if($jumsqlceksiswa<1){
    if($xjam1>$xbatasmasuk){
      $sqlout = mysql_query("Update cbt_siswa_ujian set XStatusUjian = '9' where XNomerUjian = '$user' and XStatusUjian = '1' and XTokenUjian ='$xtokenujian' and XSesi ='$xsesi'");
    }

    if($xmaxlambat==1){
      $xlamaujian = $sisawaktu ;
    } 
    elseif($xmaxlambat==0) {
      $xlamaujian = $xlamaujian ;
    }
    $xjumlahjam = $xlamaujian;
    $xjam = substr($xjumlahjam,0,2);
    $xmnt = substr($xjumlahjam,3,2);
    $xdtk = substr($xjumlahjam,6,2);
    $xtgl1 = "$xtgl1 $xjam1";

    $sqlinputsiswa = mysql_query("insert into cbt_siswa_ujian 
  (XNomerUjian, XKodeKelas, XKodeMapel,XKodeSoal,XJumSoal,XTglUjian,XJamUjian, XMulaiUjian, XLastUpdate, XLamaUjian,XTokenUjian,XStatusUjian,XSesi,XPilGanda,XEsai,XGetIP) values 
  ('$user','$xkodekelasx','$xkodemapel','$xkodesoal','$xjumlahsoal','$xtgl1','$xjamujian','$xjam1',
  '$xjam1','$xlamaujian','$xtokenujian','1','$xsesi','$xjumpilg','$xjumesai','$user_ip')"); 

  }
  else {
    $tglbalik = date("H:i:s");
    if(isset($_COOKIE['PESERTA'])){
      $user = $_COOKIE['PESERTA'];
      $sql = mysql_query("Update cbt_siswa_ujian set XLastUpdate = '$tglbalik'  where XNomerUjian = '$user' and XStatusUjian = '1' ");
    }

    $j1 = substr($s2['XMulaiUjian'],0,2);
    $m1 = substr($s2['XMulaiUjian'],3,2);
    $d1 = substr($s2['XMulaiUjian'],6,2);

    $j2 = substr($s2['XLastUpdate'],0,2);
    $m2 = substr($s2['XLastUpdate'],3,2);
    $d2 = substr($s2['XLastUpdate'],6,2);

    $sekarang = date("Y-m-d");
    $tgls = substr($sekarang,8,2);
    $blns = substr($sekarang,5,2);
    $thns = substr($sekarang,0,4);

    $start = mktime($j1,$m1,$d1,$blns,$tgls,$thns);
    $end = mktime($j2,$m2,$d2,$blns,$tgls,$thns); 

    $diffSeconds =  $end-$start;
    $hrs = (int) ($diffSeconds / 3600);
    $mins = (int) (($diffSeconds % 3600) / 60);
    $secs =  $diffSeconds - ($hrs *3600 + $mins * 60);

    $awal = mktime($hrs,$mins,$secs,$blns,$tgls,$thns); 
    $j3 = substr($s2['XLamaUjian'],0,2);
    $m3 = substr($s2['XLamaUjian'],3,2);
    $d3 = substr($s2['XLamaUjian'],6,2);
    $akhir = mktime($j3,$m3,$d3,$blns,$tgls,$thns);
    $diffSeconds3 =  $akhir-$awal;
    $hrs3 = (int) ($diffSeconds3 / 3600);
    $mins3 = (int) (($diffSeconds3 % 3600) / 60);
    $secs3 =  $diffSeconds3 - ($hrs3 *3600 + $mins3 * 60);

    if(isset($xjam)){$jatahjam = $xjam;}
    if(isset($xmnt)){$jatahmnt = $xmnt;}
    if(isset($xjatahjam)&&isset($xjatahmnt)){$menit = $jatahmnt+($jatahjam*60);}
    if(isset($xmenit)){$timestamp = strtotime($s2['XMulaiUjian']) + $menit*60;}
    if(isset($timestamp)){
      $tjam = date('H', $timestamp);
      $tmnt = date('i', $timestamp);
      $tdtk = date('s', $timestamp); 
    }
    $xjam = $hrs3;
    $xmnt = $mins3;
    $xdtk = $secs3;
  }
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="Applikasi untuk memonitor sekolah">
    <meta name="author" content="Kuswandi">
    <link rel="shortcut icon" href="images/logo-dki.png" type="image/x-icon">
 
    <title><?= $skull ?> </title>
    <!-- Icons-->
    <link href="node_modules/@coreui/icons/css/coreui-icons.min.css" rel="stylesheet">
    <link href="node_modules/flag-icon-css/css/flag-icon.min.css" rel="stylesheet">
    <link href="node_modules/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="node_modules/simple-line-icons/css/simple-line-icons.css" rel="stylesheet">

    
    <!-- Main styles for this application-->
    <link href="panel/css/style.css" rel="stylesheet">
    
    <!-- Script Section -->
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="node_modules/popper.js/dist/umd/popper.min.js"></script>
    <script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="node_modules/pace-progress/pace.min.js"></script>
    <script src="node_modules/perfect-scrollbar/dist/perfect-scrollbar.min.js"></script>
    <script src="node_modules/@coreui/coreui/dist/js/coreui.min.js"></script>

    <script src="panel/js/app.js"></script>
    <script>
      $('input').on("click",function() {
        if ( $(this).attr("type") === "radio" ) {
          $(this).parent().siblings().removeClass("isSelected");
        }
        $(this).parent().toggleClass("isSelected");
      })
    </script>
    <script type="text/javascript" src="panel/js/sidein_menu.js"></script>
    <script>
      function toggle_select(id) {
        let anu = $('#id');
        let X = $('#id');
        if(X.checked == true) {
          X.value = "1"
        }
        else {
          X.value = "0"
        }

        let who = X.id
        let chk = X.value

        $.ajax({
          url: "simpanragu.php",
          type: "post",
          data: 'who='+who+'&chk='+chk+'&anu='+anu,
          success(data) {
            return false;
          }
        })
        return false;
      }
    </script>

    <link rel="stylesheet" type="text/css" href="panel/css/klien.css">
    <link rel="stylesheet" type="text/css" href="panel/css/sikil.css">
    <script scr="panel/js/inline.js"></script>

    <?php
    $cek = mysql_num_rows(mysql_query("select * from cbt_jawaban where XKodeSoal = '$xkodesoal' and XUserJawab = '$user' and XTokenUjian = '$xtokenujian'"));
    if($cek<1){  
      $hit = 1;
      if($xmapelagama=='Y'){
      $sqlambilsoalpilT1 = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'T' and XAgama = '$xpilih' order by Urut LIMIT  $xjumpilg");
    
      }else  if($xmapelagama=='A'){
      $sqlambilsoalpilT1 = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'T' and XAgama = '$xagama' order by Urut LIMIT  $xjumpilg");
   
      } else {
      $sqlambilsoalpilT1 = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'T' order by Urut LIMIT  $xjumpilg");

      }  

      while($r2=mysql_fetch_array($sqlambilsoalpilT1)){
        if($xjumlahpilihan==3){
        $a=array("1","2","3");
    
        if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
        shuffle($a); }

        $A1 = $a[0];
        $B1 = $a[1];
        $C1 = $a[2];
        $var = array_search($r2['XKunciJawaban'],$a);
        $kuncijawab1 = $var+1;
        if($kuncijawab1=='1'){$kuncijawab = $A1;}
        if($kuncijawab1=='2'){$kuncijawab = $B1; }  
        if($kuncijawab1=='3'){$kuncijawab = $C1; }
      
        $sql = mysql_query("insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 
        ('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$kuncijawab','$A1','$B1','$C1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx','$xsetidx','$xkodemapel','$xsemester')"); 
        $hit = $hit+1;
        } 
        elseif($xjumlahpilihan==4){
        $a=array("1","2","3","4");
    
        if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
        shuffle($a); }

        $A1 = $a[0];$X1 = "XGambarJawab1$A1";
        $B1 = $a[1];
        $C1 = $a[2];
        $D1 = $a[3];
        
        $var = array_search($r2['XKunciJawaban'],$a);
        $kuncijawab1 = $var+1;
        if($kuncijawab1=='1'){$kuncijawab = $A1;}
        if($kuncijawab1=='2'){$kuncijawab = $B1; }  
        if($kuncijawab1=='3'){$kuncijawab = $C1; }
        if($kuncijawab1=='4'){$kuncijawab = $D1; }  

    
        $sql = mysql_query("insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XD,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values  ('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$kuncijawab]','$A1','$B1','$C1','$D1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx','$xsetidx','$xkodemapel','$xsemester')"); 
        $hit = $hit+1;
        } 
        elseif($xjumlahpilihan==5){
        $a=array("1","2","3","4","5");
    
        if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
        shuffle($a); }

        $A1 = $a[0];
        $B1 = $a[1];
        $C1 = $a[2];
        $D1 = $a[3];
        $E1 = $a[4];  
        $var = array_search($r2['XKunciJawaban'],$a);
        $kuncijawab1 = $var+1;
        if($kuncijawab1=='1'){$kuncijawab = $A1;}
        if($kuncijawab1=='2'){$kuncijawab = $B1; }  
        if($kuncijawab1=='3'){$kuncijawab = $C1; }
        if($kuncijawab1=='4'){$kuncijawab = $D1; }  
        if($kuncijawab1=='5'){$kuncijawab = $E1; }  

        $sql = mysql_query("insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XD,XE,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values ('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$kuncijawab','$A1','$B1','$C1','$D1','$E1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx','$xsetidx','$xkodemapel','$xsemester')"); 
        $hit = $hit+1;
        } 
      }
  
      $jmlpilT = mysql_num_rows($sqlambilsoalpilT1);
      $jmlpilA = $xjumpilg - $jmlpilT;
      if($xmapelagama=='Y'){
      $sqlambilsoalpilA2 = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'A' and XAgama = '$xpilih' order by RAND() LIMIT  $jmlpilA");
      }elseif($xmapelagama=='A'){
      $sqlambilsoalpilA2 = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'A' and XAgama = '$xagama'
       order by RAND() LIMIT  $jmlpilA");
      } else {
      $sqlambilsoalpilA2 = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '1' and XAcakSoal = 'A' order by RAND() LIMIT  $jmlpilA");  
      }
      while($r2=mysql_fetch_array($sqlambilsoalpilA2)){
      if($xjumlahpilihan==3){
      $a=array("1","2","3");

      if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
      shuffle($a); }

      $A1 = $a[0];
      $B1 = $a[1];
      $C1 = $a[2];
        
      $sql = mysql_query("insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 
      ('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$r2[XKunciJawaban]','$A1','$B1','$C1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx',
    '$xsetidx','$xkodemapel','$xsemester')"); 
      $hit = $hit+1;
      }   
        
      elseif($xjumlahpilihan==4){
      $a=array("1","2","3","4");
        
        if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
        shuffle($a); }

      $A1 = $a[0];
      $B1 = $a[1];
      $C1 = $a[2];
      $D1 = $a[3];
      $sql = mysql_query("insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XD,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values   
      ('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$r2[XKunciJawaban]','$A1','$B1','$C1','$D1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx',
    '$xsetidx','$xkodemapel','$xsemester')"); 
      $hit = $hit+1;
      } 
      elseif($xjumlahpilihan==5){
        $a=array("1","2","3","4","5");

        if($r2['XAcakOpsi']=='Y'){ //jika opsijawaban diacak
        shuffle($a); }

      $A1 = $a[0];
      $B1 = $a[1];
      $C1 = $a[2];
      $D1 = $a[3];
      $E1 = $a[4];  
      $sql = mysql_query("insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XKunciJawaban,XA,XB,XC,XD,XE,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values 
      ('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$r2[XKunciJawaban]','$A1','$B1','$C1','$D1','$E1','$tglbuat','1','$xkodekelasx','$xkodejurusx','$xkodeujianx',
    '$xsetidx','$xkodemapel','$xsemester')"); 
      $hit = $hit+1;

      } 
   }
    if($xmapelagama=='A'){
      $sqlambilsoalesai = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'T' and XAgama = '$xagama' order by Urut LIMIT $xjumesai");
    } 
    elseif($xmapelagama=='Y'){
      $sqlambilsoalesai = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'T' and XAgama = '$xpilih' order by Urut LIMIT $xjumesai");
    } 
    else {
      $sqlambilsoalesai = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'T' order by Urut LIMIT $xjumesai");
    }  
  while($r1=mysql_fetch_array($sqlambilsoalesai)){
    $sqlsimpanesai = mysql_query("insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values   
    ('$hit','$r1[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$tglbuat','2','$xkodekelasx','$xkodejurusx','$xkodeujianx','$xsetidx','$xkodemapel','$xsemester'  
)");  
   $hit = $hit+1;   
  }
  //esai utama harus muncul bila acak=T
  $jmlesaiutama = mysql_num_rows($sqlambilsoalesai);
  //jika jml esai utama masih < xjumlahesai
  if($jmlesaiutama<$xjumesai){
  //ambil acak esai tambahan sebanyak sisa esai
    $sisaesai = $xjumesai - $jmlesaiutama;
    if($xmapelagama=='Y'){
    $sqlambilsoalesai = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'A' and XAgama = '$xpilih' order by RAND() 
    LIMIT $sisaesai");
    }elseif($xmapelagama=='A'){
    $sqlambilsoalesai = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'A' and XAgama = '$xagama' order by RAND() 
    LIMIT $sisaesai");
    } else {
    $sqlambilsoalesai = mysql_query("select * from cbt_soal where XKodeSoal = '$xkodesoal' and XJenisSoal = '2' and XAcakSoal = 'A' order by RAND() LIMIT $sisaesai");
    }
    while($r2=mysql_fetch_array($sqlambilsoalesai)){
    $sqlsimpanesai = mysql_query("insert into cbt_jawaban (Urut,XNomerSoal,XUserJawab,XKodeSoal,XTokenUjian,XTglJawab,XJenisSoal,XKodeKelas,XKodeJurusan,XKodeUjian,XSetId,XKodeMapel,XSemester) values   
    ('$hit','$r2[XNomerSoal]','$user','$xkodesoal','$xtokenujian','$tglbuat','2','$xkodekelasx','$xkodejurusx','$xkodeujianx','$xsetidx','$xkodemapel','$xsemester')");  
    $hit = $hit+1;
    }
    
  }
  
$xjumlahsoalpil = $xjumlahsoal - $xjumlahesai;

 } 
    ?>
  </head>

  <body>

    <?php
      $sqlhd = mysql_query("select * from cbt_header limit 1");
      $hu = mysql_fetch_array($sqlhd);
      $headerujian=$hu['HeaderUjian'];
      $xkodesoal = $s['soalz'];
      $pdf = mysql_query("select * from cbt_ujian where XKodeSoal = '$xkodesoal' ");
      $p = mysql_fetch_array($pdf);
      $pdf=$p['XPdf'];
      $filepdf=$p['XFilePdf'];
    ?>

    <header style="background-color: #32679C;" class="headers">
      <div class="group">
        <div class="left py-2 px-2">
          <img src="images/logo-dki.png " width="75px">
        </div>
        <div class="right">
          <table width="100%" border="0" style="margin-top:10px">   
            <tr><td rowspan="3" width="120px" align="center"><img src="foto_siswa/<?= "$gambar"; ?>" class="foto"></td></tr>
            <tr><td><span class="user"><?= $val_siswa.'<br>('.$kodekelas.'-'.$kodejurusan.')'; ?></span></td></tr>
            <tr><td><span class="user">Jangan lupa do'a</span></td></tr>
          </table>
        </div>
      </div>
    </header>

    <div class="container-fluid mt-5">
    <ul class="list-group rounded-0">
      <li class="list-group-item">
        <div class="header">
          <span class="flex-putih">SOAL NO. </span>
          <span class="flex-item" style="background-color:<?= $cssb; ?>"  id="soal">            
          </span>
          <span class="flex-biru"> <div id="h_timer"></div></span>
          <span class="flex-abu">Sisa Waktu</span>            
        </div>
      </li>
      <li class="list-group-item bg-light">
        <span id="hurufsoal"> Ukuran font soal : <a id="jfontsize-m2" href="#" style="font-size:16px; text-decoration:none">&nbsp; A &nbsp;</a> <a id="jfontsize-d2" href="#" style="font-size:18px; text-decoration:none">&nbsp; A &nbsp;</a> <a id="jfontsize-p2" href="#" style="font-size:24px; text-decoration:none">&nbsp; A &nbsp;</a></span>
      </li>
      <li class="list-group-item">
        <script src="panel/js/jquery.countdownTimer.js"></script>
    <?php if ($pdf>0){?>
    <embed src="./file-pdf/<?php echo $filepdf;?>" width="100%" height="400"> </embed>            
    <?php } ?>

    <script>
      $(function(){
        $('#h_timer').countdowntimer({
          hours : <?php echo $xjam; ?>, 
          minutes :<?php echo $xmnt; ?>,
          seconds:<?php echo $xdtk; ?>,  
          size : "lg",
          timeUp : timeisUp   
        })
      })
      function timeisUp() {
        alert("Waktu pengerjaan sudah habis");
        setTimeout(function() { 
          window.location.href = $("a")[0].href; 
        }, 2000);
          window.location="akhir.php";
      }                  
    </script>

    <script>
      $(document).ready(function() {
        $("#soal").html(1);
          $.post( "getsoal.php?kode=<?php echo $xkodesoal; ?>", { pic: "1"}, function( data ) {
            $("#picture").html( data );
            $("#soal").html(1);
          });
          
          $("#picture").on("click",".get_pic", function(e){
            var picture_id = $(this).attr('data-id');
            $("#picture").html("<div style=\"margin:50px auto;width:50px;\"><img src=\"images/loader.gif\" /></div>");
            $("#soal").html(picture_id);
            $.post( "getsoal.php", { pic: picture_id}, function( data ) {
              $("#picture").html( data );
            });
            return false;
          });
          
        });
    </script>
    <div id="picture">

    </div>
      </li>
    </ul>

    
    </div>
  </body>

  <script src="panel/js/jquery.cookie.js"></script>
  <script src="panel/js/common.js"></script>
  <script src="panel/js/main.js"></script>
  <script src="panel/js/cookieList.js"></script>
  <script src="panel/js/backend.js"></script>
</html>

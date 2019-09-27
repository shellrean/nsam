<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

require_once "PHPExcel.php";
include "../../../config/server.php";

$objPHPExcel = new PHPExcel();

$hasil = mysql_query("select * from cbt_mapel");

$objPHPExcel->getProperties()->setCreator("NASAM/CBT")
			->setLastModifiedBy("NSAM/CBT")
      		->setTitle("Office 2007 XLSX Test Document")
      		->setSubject("Office 2007 XLSX Test Document")
       		->setDescription("Mapel Export")
       		->setKeywords("office 2007 openxml php")
       		->setCategory("Daftar Mapel :");

$objPHPExcel->setActiveSheetIndex(0)
       		->setCellValue('A1', 'KODE')
       		->setCellValue('B1', 'NAMA MAPEL')
       		->setCellValue('C1', 'PERSEN UH')
       		->setCellValue('D1', 'PERSEN UTS')
       		->setCellValue('E1', 'PERSEN UAS')
       		->setCellValue('F1', 'KKM')
       		->setCellValue('G1', 'JENIS MAPEL')
       		->setCellValue('H1', 'KODE SEKOLAH');

$baris = 2;
$no = 0;		

while($p = mysql_fetch_array($hasil)){
	$no = $no +1;
	$objPHPExcel->setActiveSheetIndex(0)
	     		->setCellValue("A$baris", $p['XKodeMapel'])
	     		->setCellValue("B$baris", $p['XNamaMapel'])
	     		->setCellValue("C$baris", $p['XPersenUH'])
	     		->setCellValue("D$baris", $p['XPersenUTS'])
	     		->setCellValue("E$baris", $p['XPersenUAS'])
	     		->setCellValue("F$baris", $p['XKKM'])
	     		->setCellValue("G$baris", $p['XMapelAgama'])
	     		->setCellValue("H$baris", $p['XKodeSekolah']);
	$baris = $baris + 1;
}

$objPHPExcel->getActiveSheet()->setTitle('Mapel');
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="Excel-Mapel.xls"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
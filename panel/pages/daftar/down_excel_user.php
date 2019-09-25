<?php
if(!isset($_COOKIE['beeuser'])) {
	header('Location: login.php');
}
require_once 'PHPExcel.php';
include "../../../config/server.php";

$objPHPExcel = new PHPExcel();

$hasil = mysql_query("select * from cbt_user");

$objPHPExcel->getProperties()->setCreator("ICT-CBT")
			->setLastModifiedBy("ICT-CBT")
			->setTitle("Office 2007 XLSX Test Document")
			->setSubject("Office 2007 XLSX Test Document")
			->setDescription("Data Export")
			->setKeywords("Office 2007 opnxml php")
			->setCategory("Daftar User :");

$objPHPExcel->setActiveSheetIndex(0)	
			->mergeCells('A1:A2')
			->mergeCells('C1:C2')
			->mergeCells('D1:D2')
			->mergeCells('E1:E2')
			->mergeCells('F1:F2')
			->mergeCells('G1:G2')
			->mergeCells('H1:H2')
			->mergeCells('K1:K2')

			->setCellValue('A1', 'USERNAME')
			->setCellValue('B1', 'PASSWORD')
			->setCellValue('C1', 'NIP')
			->setCellValue('D1', 'NAMA')
			->setCellValue('E1', 'ALAMAT')
			->setCellValue('F1', 'HP')
			->setCellValue('G1', 'FAXS')
			->setCellValue('H1', 'EMAIL')
			->setCellValue('I1', 'HAK AKSES')
			->setCellValue('J1', 'STATUS')
			->setCellValue('K1', 'FOTO');

$baris = 3;
$no = 0;

while($p = mysql_fetch_array($hasil)) {
	$no++;

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("A$baris", $p['Username'])
				->setCellValue("B$baris", $p['Password'])
				->setCellValue("C$baris", $p['NIP'])
				->setCellValue("D$baris", $p['Nama'])
				->setCellValue("E$baris", $p['Alamat'])
				->setCellValue("F$baris", $p['HP'])
				->setCellValue("G$baris", $p['Faks'])
				->setCellValue("H$baris", $p['Email'])
				->setCellValue("I$baris", $p['login'])
				->setCellValue("J$baris", $p['Status'])
				->setCellValue("K$baris", $p['XPoto']);
	$baris++;
}

$objPHPExcel->getActiveSheet()->setTitle('Data Export');

$objPHPExcel->setActiveSheetIndex(0);

header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment; filename="Excel-User.xls"');
header("Cache-Control: max-age=0");

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');

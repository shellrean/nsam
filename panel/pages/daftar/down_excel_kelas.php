<?php
if(!isset($_COOKIE['beeuser'])) {
	header("Location: login.php");
}

require_once 'PHPExcel.php';

include "../../../config/server.php";

if ($log['XTingkat']=="SMA" || $log['XTingkat']=="MA"||$log['XTingkat']=="STM"){

	$objPHPExcel = new PHPExcel();

	$hasil = mysql_query("select * from cbt_kelas");

	$objPHPExcel->getProperties()->setCreator("NSAM/CBT")
				->setLastModifiedBy("NSAM/CBT")
				->setTitle("Office 2007 XLSX Test Document")
		  		->setSubject("Office 2007 XLSX Test Document")
		   		->setDescription("Kelas Export")
		   		->setKeywords("office 2007 openxml php")
		   		->setCategory("Daftar Kelas :");

	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A1', 'KODE KELAS')
				->setCellValue('B1', 'KODE LEVEL')
				->setCellValue('C1', 'NAMA KELAS')
				->setCellValue('D1', 'KODE JURUSAN')
				->setCellValue('E1', 'KODE SEKOLAH');

	$baris = 2;
	$no = 0;

	while($p=mysql_fetch_array($hasil)) {
		$no++;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue("A$baris", $p['XKodeKelas'])
					->setCellValue("B$baris", $p['XKodeLevel'])
					->setCellValue("C$baris", $p['XNamaKelas'])
					->setCellValue("D$baris", $p['XKodeJurusan'])
					->setCellValue("E$baris", $p['XKodeSekolah']);

		$baris++;
	}


	$objPHPExcel->getActiveSheet()->setTitle('Kelas');
	$objPHPExcel->setActiveSheetIndex(0);

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Excel-Kelas.xls"');
	header('Cache-Control: max-age=0');

	$objWriter = phpExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}
else {
	$objPHPExcel = new PHPExcel();

	$hasil = mysql_query("SELECT * FROM cbt_kelas");

	$objPHPExcel->getProperties()->setCreator("NSAM/CBT")
		  		->setLastModifiedBy("NSAM/CBT")
		  		->setTitle("Office 2007 XLSX Test Document")
		  		->setSubject("Office 2007 XLSX Test Document")
		   		->setDescription("Kelas Export")
		   		->setKeywords("office 2007 openxml php")
		   		->setCategory("Daftar Kelas :");
	 
	$objPHPExcel->setActiveSheetIndex(0)			
				->setCellValue('A1', 'KODE KELAS')
				->setCellValue('B1', 'KODE LEVEL')
				->setCellValue('C1', 'NAMA KELAS')
				->setCellValue('D1', 'KODE ROMBEL')
				->setCellValue('E1', 'KODE SEKOLAH');
		   
	$baris = 2;
	$no = 0;		

	while($p = mysql_fetch_array($hasil)){
	$no = $no +1;
	$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue("A$baris", $p['XKodeKelas'])
				->setCellValue("B$baris", $p['XKodeLevel'])
				->setCellValue("C$baris", $p['XNamaKelas'])
				->setCellValue("D$baris", $p['XKodeJurusan'])
				->setCellValue("E$baris", $p['XKodeSekolah']);
				
	$baris = $baris + 1;
	}
	 
	$objPHPExcel->getActiveSheet()->setTitle('transaksi');
	 
	$objPHPExcel->setActiveSheetIndex(0);

	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="Excel-Kelas.xls"');
	header('Cache-Control: max-age=0');
	 
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}
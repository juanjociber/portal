<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
//require_once dirname(__FILE__) . '/mycloud/library/PHPExcel-1.8/Classes/PHPExcel.php';
include($_SERVER['DOCUMENT_ROOT'].'/mycloud/library/PHPExcel-1.8/Classes/PHPExcel.php');


// Crear un nuevo objeto PHPExcel.
$objPHPExcel = new PHPExcel();

// Configurar las propiedades del documento.
$objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
	->setLastModifiedBy("Maarten Balliauw")
	->setTitle("Office 2007 XLSX Test Document")
	->setSubject("Office 2007 XLSX Test Document")
	->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
	->setKeywords("office 2007 openxml php")
	->setCategory("Test result file");

// Agregar la primra linea, cabecera.
$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'Id')
	->setCellValue('B1', 'Cod.Interno')
    ->setCellValue('C1', 'Cod.Externo')
    ->setCellValue('D1', 'Nombre')
    ->setCellValue('E1', 'Marca')
	->setCellValue('F1', 'Medida')
	->setCellValue('G1', 'Stock')
	->setCellValue('H1', 'Moneda')
	->setCellValue('I1', 'P.Publico')
	->setCellValue('J1', 'P.Mayorista')
	->setCellValue('K1', 'P.Flota')	
	->setCellValue('L1', 'Fecha')
	->setCellValue('M1', 'Observación')
	->setCellValue('N1', 'Estado');

// Poner en negrita la primera columna.
$objPHPExcel->getActiveSheet()->getStyle("A1:N1")->getFont()->setBold(true);




// Redimensionado de todas las columnas en automático.
//foreach(range('A','L') as $columnID) {
//    $objPHPExcel->getActiveSheet()->getColumnDimension($columnID)
//        ->setAutoSize(true);
//}

// Redimensionar las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
//$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(false);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);


// Agregar las lineas de la tabla Productos.
	try{
		$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt=$conmy->prepare("select id, codinterno, codexterno, nombre, marca, medida, stock, moneda, pvpublico, pvmayor, pvflota, fecha, observacion, estado from tblcatalogo;");
		$stmt->execute();
		$i=1;
		if($stmt->rowCount()>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$i+=1;
				$Estado="";
				switch ($row['estado']) {
					case 1:
						$Estado="Inactivo";
						break;
					case 2:
						$Estado="Activo";
						break;
					default:
						$Estado="Unknown";
				}
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$i, $row['id'])
					->setCellValue('B'.$i, $row['codinterno'])
					->setCellValue('C'.$i, $row['codexterno'])
					->setCellValue('D'.$i, $row['nombre'])
					->setCellValue('E'.$i, $row['marca'])
					->setCellValue('F'.$i, $row['medida'])
					->setCellValue('G'.$i, $row['stock'])
					->setCellValue('H'.$i, $row['moneda'])
					->setCellValue('I'.$i, $row['pvpublico'])
					->setCellValue('J'.$i, $row['pvmayor'])
					->setCellValue('K'.$i, $row['pvflota'])					
					->setCellValue('L'.$i, PHPExcel_Shared_Date::PHPToExcel(date("d/m/Y", strtotime($row['fecha']))))
					->setCellValue('M'.$i, $row['observacion'])
					->setCellValue('N'.$i, $Estado);
			};

			// ../mycloud/library/PHPExcel-1.8/Classes/PHPExcel/Style/NumberFormat.php
			// const FORMAT_DATE_AAAAMMDD           ='dd/mm/yyyy';

			$objPHPExcel->getActiveSheet()->getStyle('L2:L'.$i)->getNumberFormat()->setFormatCode("dd/mm/yyyy");

			//->setCellValue('K'.$i, date("d/m/Y",strtotime($row['fecha'])))
		}else{
			$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', "No se encontro resultados para esta consulta.");
		}
		$stmt=null;
	}catch(PDOException $e){
		$stmt=null;
		$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A1', $e);
	}

// Renombrar la hoja
$objPHPExcel->getActiveSheet()->setTitle('Productos');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="productos_'.date("YmdHis").'.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

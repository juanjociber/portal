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
	->setCellValue('B1', 'Cotización')
    ->setCellValue('C1', 'Fecha')
    ->setCellValue('D1', 'RUC Cliente')
    ->setCellValue('E1', 'Nombre Cliente')
	->setCellValue('F1', 'Direccion Cliente')
	->setCellValue('G1', 'Contacto Cliente')
	->setCellValue('H1', 'Nombre Vendedor')
	->setCellValue('I1', 'Forma Pago')
	->setCellValue('J1', 'Nota')
	->setCellValue('K1', 'Estado')
	->setCellValue('L1', 'Código')
	->setCellValue('M1', 'Producto')
	->setCellValue('N1', 'Cantidad')
	->setCellValue('O1', 'Medida')
	->setCellValue('P1', 'Precio')
	->setCellValue('Q1', 'Moneda');

// Poner en negrita la primera columna.
$objPHPExcel->getActiveSheet()->getStyle("A1:Q1")->getFont()->setBold(true);

// Redimensionar las columnas
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth(30);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);

// Agregar las lineas de la tabla Productos.
if(!empty($_GET['codigo'])){
	try{
		$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt=$conmy->prepare("select c.id, c.cotizacion, c.fecha, c.cliruc, c.clinombre, c.clidireccion, c.clicontacto, c.vendnombre, c.pago, c.moneda, 
		c.nota, c.estado, d.codigo, d.producto, d.cantidad, d.precio, d.medida from tblcotizaciones c inner join tbldetallecotizacion d on c.id=d.idcotizacion where d.codigo=:Codigo;");
		$stmt->execute(array('Codigo'=>$_GET['codigo']));
		$i=1;
		if($stmt->rowCount()>0){
			while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
				$i+=1;
				$Estado="";
				switch ($row['estado']) {
					case 1:
						$Estado="Anulado";
						break;
					case 2:
						$Estado="Abierto";
						break;
					case 3:
						$Estado="Cerrado";
						break;
					default:
						$Estado="Unknown";
				}
				$objPHPExcel->setActiveSheetIndex(0)
					->setCellValue('A'.$i, $row['id'])
					->setCellValue('B'.$i, $row['cotizacion'])
					->setCellValue('C'.$i, PHPExcel_Shared_Date::PHPToExcel(date("d/m/Y", strtotime($row['fecha']))))
					->setCellValue('D'.$i, $row['cliruc'])
					->setCellValue('E'.$i, $row['clinombre'])
					->setCellValue('F'.$i, $row['clidireccion'])
					->setCellValue('G'.$i, $row['clicontacto'])
					->setCellValue('H'.$i, $row['vendnombre'])
					->setCellValue('I'.$i, $row['pago'])				
					->setCellValue('J'.$i, $row['nota'])
					->setCellValue('K'.$i, $Estado)
					->setCellValue('L'.$i, $row['codigo'])
					->setCellValue('M'.$i, $row['producto'])
					->setCellValue('N'.$i, $row['cantidad'])					
					->setCellValue('O'.$i, $row['medida'])
					->setCellValue('P'.$i, $row['precio'])
					->setCellValue('Q'.$i, $row['moneda']);
			};
			$objPHPExcel->getActiveSheet()->getStyle('C2:C'.$i)->getNumberFormat()->setFormatCode("dd/mm/yyyy");
		}else{
			$objPHPExcel->setActiveSheetIndex(0)
				->setCellValue('A2', "No se encontro resultados para esta consulta.");
		}
		$stmt=null;
	}catch(PDOException $e){
		$stmt=null;
		$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A2', $e);
	}
}else{
	$objPHPExcel->setActiveSheetIndex(0)
		->setCellValue('A2', "No se reconoce el código del producto.");
}

// Renombrar la hoja
$objPHPExcel->getActiveSheet()->setTitle('Cotizaciones');

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="cotizaciones_v2_'.date("YmdHis").'.xlsx"');
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

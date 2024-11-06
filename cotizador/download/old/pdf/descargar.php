<?php
	require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

	$Id=0;
 
	$Id=$_GET['cotizacion'];
	$Cotizacion="";
	$Fecha="";
	$CliRuc="";
	$CliNombre="";
	$CliDireccion="";
	$VendId=0;
	$VendNombre="";
	$Estado=0;
 
	try{
		$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt=$conmy->prepare("select id, fecha, cliruc, clinombre, clidireccion, vendid, vendnombre, estado from tblcotizaciones where id=:Cotizacion;");
		$stmt->execute(array('Cotizacion'=>$Id));
		$row=$stmt->fetch();
		if($row){
			$Cotizacion=$row['id'];
			$Fecha=$row['fecha'];
			$CliRuc=$row['cliruc'];
			$CliNombre=$row['clinombre'];
			$CliDireccion=$row['clidireccion'];
			$VendId=$row['vendid'];
			$VendNombre=$row['vendnombre'];                
			$Estado=$row['estado'];
		}
		$stmt=null;
	}catch(PDOException $ex){
		$stmt=null;
	}

	require_once $_SERVER['DOCUMENT_ROOT']."/mycloud/library/dompdf_0-8-3/autoload.inc.php";
	use Dompdf\Dompdf;
	//$imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT']."/mycloud/logos/logo-gpem.png")); 

	$html5='
	<!DOCTYPE html>
	<html lang="es">
		<head>
			<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
			<title>Cotizacion</title>
			<style>
				@page {
					margin: 0cm 0cm;
				}

				*{
					font-family: DejaVu Sans, sans-serif;
					font-size: 11px;
				}

				.fs-9{
					font-size:9px;
				}

				.fs-12{
					font-size: 12px;
				}

				.fw-bold{
					font-weight:bold;
				}

				body {
					margin-top: 3cm;
					margin-left: 1cm;
					margin-right: 1cm;
					margin-bottom: 2cm;
				}

				header {
					position: fixed;
					top: 0.5cm;
					left: 1cm;
					right: 1cm;
					height: 4cm;
				}

				footer {
					position: fixed; 
					bottom: 0cm; 
					left: 0cm; 
					right: 0cm;
					height: 2cm;
				}

				main{
					left:1cm;
					right:1cm;
				}
			</style>
		</head>
		<body>';

			$html5.='
			<header>
				<table style="border-spacing:0; width: 100%;">
					<tr>
						<td rowspan="2" style="width: 25%;"><img src="'.$_SERVER['DOCUMENT_ROOT']."/mycloud/logos/logo-gpem.png".'" style="height: 50px;"></td>
						<td style="text-align:center; font-weight: bold; font-size:14px; padding:3px; width:50%;">GESTION DE PROCESOS EFICIENTES DE MANTENIMIENTO S.A.C.</td>                     
						<td style="border-right:1px solid; border-top: 1px solid; border-left:1px solid; padding:5px; text-align:center; font-weight:bold; font-size:16px; width:25%;">COTIZACION</td>                     
					</tr>
					<tr>
						<td style="text-align:center;">Av. Los Incas S/N - Comas <br> Telf: 01-7130628</td>
						<td style="border-bottom: 1px solid; border-right: 1px solid; border-left:1px solid; padding:5px; text-align:center; font-weight:bold; font-size:16px;">'.$Cotizacion.'</td>
					</tr>
				</table>
			</header>';

			$html5.='
			<footer>
				<table style="width: 100%;">
					<tr>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
					</tr>
					<tr>
						<td colspan="7" style="text-align: center">AV. Los Incas 4ta Cuadra S/N - Comas - Lima - Per&uacute; - Telf. (511) 7130629 Anexo 308</td>
					</tr>
					<tr>
						<td colspan="7" style="text-align: center">e-mail: g.administracion@gpemsac.com</td>
					</tr>
				</table>
			</footer>';

			$html5.='
			<main>
				<p><?php echo $Fecha; ?></p>
				<p style="margin-bottom: 3px;">Se&ntilde;ores:</p>
				<p style="margin: 3px 0px; font-weight:bold;">'.$CliNombre.'</p>
				<p style="margin: 3px 0px;">RUC: '.$CliRuc.'</p>
				<p style="margin: 3px 0px;">'.$CliDireccion.'</p>
				<p>De nuestra especial consideraci&oacute;n, es grato dirigirnos a Uds. para remitir la siguiente cotizaci&oacute;n.</p>

				<table style="width:100%; border-spacing:0;">
					<tr style="background-color:#001466; color:white; text-align:center;">
						<td style="padding:8px; text-align:right; width: 5%">Item</td>
						<td style="padding:8px; width: 40%;">Descripci&oacute;n</td>
						<td style="padding:8px; text-align:right;">Cantidad</td>
						<td style="padding:8px;">Medida</td>
						<td style="padding:8px; text-align:right;">Valor Unitario</td>
						<td style="padding:8px; text-align:right;">Precio Unitario</td>
						<td style="padding:8px; text-align:right;">Precio Venta</td>
					</tr>';

					try{
						$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
						$stmt=$conmy->prepare("select codigo, producto, cantidad, precio, medida from tbldetallecotizacion where idcotizacion=:Cotizacion;");
						$stmt->execute(array('Cotizacion'=>$Id));
						if($stmt->rowCount()>0){
							$i=1;
							$PrecioUnitario=0;
							$PrecioVenta=0;
							$BaseImponible=0;
							$TotalIgv=0;
							$MontoTotal=0;                  
							while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
								$PrecioUnitario=$row['precio']*1.18;
								$PrecioVenta=$PrecioUnitario*$row['cantidad'];
								$MontoTotal+=$PrecioVenta;
								$html5.='
									<tr>
										<td style="padding:8px 5px 8px 5px; text-align:right; border-bottom: 1px solid #B4B4B4;">'.$i.'</td>
										<td style="padding:8px 5px 8px 5px; border-bottom: 1px solid #B4B4B4;">'.$row['codigo'].' '.utf8_encode($row['producto']).'</td>
										<td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $row['cantidad']).'</td>
										<td style="padding:8px 5px 8px 5px; border-bottom: 1px solid #B4B4B4;">'.utf8_encode($row['medida']).'</td>
										<td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $row['precio']).'</td>
										<td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $PrecioUnitario).'</td>
										<td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $PrecioVenta).'</td>
									</tr>';
								$i+=1;
							}
							
							$BaseImponible=$MontoTotal/1.18;
							$TotalIgv=$MontoTotal-$BaseImponible;

							$html5.='
								<tr>
									<td colspan="6" style="padding:8px 5px 8px 5px; text-align: right;">Base Imponible $</td>
									<td style="padding:8px 5px 8px 5px; text-align: right;">'.sprintf('%.2f', $BaseImponible).'</td>
								</tr>
								<tr>
									<td colspan="6" style="padding:8px 5px 8px 5px; text-align: right;">Total IGV (18%) $</td>
									<td style="padding:8px 5px 8px 5px; text-align: right;">'.sprintf('%.2f', $TotalIgv).'</td>
								</tr>
								<tr>
									<td colspan="6" style="padding:8px 5px 8px 5px; text-align: right; font-weight:bold;">Monto Total $</td>
									<td style="padding:8px 5px 8px 5px; text-align:right; font-weight:bold;">'.sprintf('%.2f', $MontoTotal).'</td>
								</tr>';
						}else{
							//
						}
						$stmt=null;
					}catch(PDOException $e){
						$stmt=null;
					};

				$html5.='
				</table>
				<p>CONDICIONES COMERCIALES</p>
				<ul>
					<!--<li>Validez de cotización: 0X días.</li>
					<li>Condición de pago: Al Contado</li>-->
					<li>Plazo de Entrega: Previo env&iacute;o de Voucher de pago y orden de compra.</li>
					<li>Lugar de entrega: Instalaciones de GPEM SAC. o previa coordinaci&oacute;n con el cliente para env&iacute;o a sus instalaciones.</li>
					<li>Moneda: D&oacute;lares americanos</li>
				</ul>
				<table style="width: 100%; border-collapse: collapse; text-align:center; margin-bottom: 15px;">
					<tr>
						<td class="fs-9 fw-bold" style="border: 1px solid; padding: 5px; text-align: center;" colspan="6">GESTION DE PROCESOS EFICIENTES DE MANTENIMIENTO S.A.C.</td>
					</tr>
					<tr>
						<td class="fs-9" style="border: 1px solid; padding: 5px;" colspan="2">RUC: 20566384826</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;" colspan="4">DIRECCION: AV. LOS INCAS 4TA CUADRA S/N -COMAS</td>
					</tr>
					<tr>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">ITEM</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">BANCO</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">MONEDA</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">TIPO DE CUENTA</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">NRO DE CUENTA</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">CODIGO INTERBANCARIO</td>
					</tr>
					<tr>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">1</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">BBVA BANCO CONTINENTAL</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">MN</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">CUENTA CORRIENTE</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">001 0333 0100108365</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">001 333 000100108365 26</td>
					</tr>
					<tr>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">2</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">BBVA BANCO CONTINENTAL</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">ME</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">CUENTA CORRIENTE</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">001 0333 0100108373</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">001 333 000100108373 20</td>
					</tr>
					<tr>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">3</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">BANCO DE LA NACION</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">MN</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">CUENTA DETRACCION</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;">00-003-163202</td>
						<td class="fs-9" style="border: 1px solid; padding: 5px;"></td>
					</tr>
				</table>
				<p>Sin otro tema en particular nos despedimos de Ud, esperando la confirmaci&oacute;n de nuestros servicios.</p>
				<p>Saludos cordiales.</p>
				<p class="fs-12 fw-bold" style="text-decoration: underline; padding:0px; margin:0px;">'.$VendNombre.'</p>
				<p style="padding:0px; margin:0px;">Asesor Comercial</p>
				<p style="padding:0px; margin:0px;">GPEM SAC.</p>
			</main>
		</body>
	</html>';

























//$html=file_get_contents_curl($html5);
//$html=file_get_contents_curl("https://localhost/pdf/html.php");
//$html=file_get_contents_curl("https://gpemsac.com/portal/cotizador/print/GenerarPdfCotizacion.php?cotizacion=13");

// Instanciamos un objeto de la clase DOMPDF.
$pdf = new DOMPDF();

$pdf->set_option('enable_html5_parser', TRUE);
 
// Definimos el tamaño y orientación del papel que queremos.
$pdf->set_paper("letter", "portrait");
//$pdf->set_paper(array(0,0,104,250));
 
// Cargamos el contenido HTML.
//$pdf->load_html(utf8_decode($html));
$pdf->load_html(utf8_decode($html5));
 
// Renderizamos el documento PDF.
$pdf->render();
 
// Enviamos el fichero PDF al navegador.
$pdf->stream('COTIZACION.pdf');


function file_get_contents_curl($url) {
	$crl = curl_init();
	$timeout = 5;
	curl_setopt($crl, CURLOPT_URL, $url);
	curl_setopt($crl, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($crl, CURLOPT_CONNECTTIMEOUT, $timeout);
	$ret = curl_exec($crl);
	curl_close($crl);
	return $ret;
}

?>
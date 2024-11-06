<?php
	session_start();
	$Cotizacion="000";
	$bandera=true;

	if(empty($_SESSION['vgrole']) || empty($_GET)){
		$bandera=false;
    }else{
		if(!($_SESSION['vgrole']=='seller' || $_SESSION['vgrole']=='admin')){
			$bandera=false;
		}
	}

	if($bandera){
		require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
		if(!empty($_GET['cotizacion'])){
			$Id=$_GET['cotizacion'];
			$Fecha="";
			$CliRuc="";
			$CliNombre="";
			$CliDireccion="";
			$CliContacto="";
			$CliTelefono="";
			$CliCorreo="";
			$VendNombre="";
			$CotTiempo=0;
			$CotPago="";
			$CotEntrega="";
			$CotLugar="";
			$CotMoneda="";
			$Igv=0;
			$Descuento=0;
			$Observaciones="";
			$VerCodigo=true;

			$MonedaSimbolo="";
			$MonedaNombre="";

			$TotValorVenta=0; // suma del valor de los productos
			$TotDescuentos=0; // vlor de la venta * descuento
			$BaseImponible=0; // valor de la venta - descuentos
			$TotImpuestos=0; // base imponible por igv
			$TotPrecioVenta=0; // base imponible + impuestos
		
			try{
				$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				$stmt=$conmy->prepare("select id, cotizacion, fecha, cliruc, clinombre, clidireccion, clicontacto, clitelefono, clicorreo, vendnombre, tiempo, pago, entrega, lugar, moneda, igv, descuento, vercodigo, obs from tblcotizaciones where id=:Id;");
				$stmt->execute(array('Id'=>$Id));
				$row=$stmt->fetch();
				if($row){
					$Id=$row['id'];
					$Cotizacion=$row['cotizacion'];
					$Fecha=$row['fecha'];
					$CliRuc=$row['cliruc'];
					$CliNombre=$row['clinombre'];
					$CliDireccion=$row['clidireccion'];
					$CliContacto=$row['clicontacto'];
					$CliTelefono=$row['clitelefono'];
					$CliCorreo=$row['clicorreo'];
					$VendNombre=$row['vendnombre'];
					$CotTiempo=$row['tiempo'];
					$CotPago=$row['pago'];
					$CotEntrega=$row['entrega'];
					$CotLugar=$row['lugar'];
					$CotMoneda=$row['moneda'];
					$Igv=$row['igv'];
					$Descuento=$row['descuento'];
					$Observaciones=$row['obs'];
					$VerCodigo=$row['vercodigo'];
				}
				$stmt=null;
			}catch(PDOException $ex){
				$stmt=null;
				$html5='<h5>Error procesando el archivo.</h5>';
			};

			if($Id>0){

				if($CotMoneda=="USD"){
					$MonedaNombre = "D&oacute;lares Americanos";
					$MonedaSimbolo = "$";
				}elseif($CotMoneda=="PEN"){
					$MonedaNombre = "Soles";
					$MonedaSimbolo = "S/";
				}

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
								margin-bottom: 3.2cm;
							}

							header {
								position: fixed;
								top: 0.5cm;
								left: 1cm;
								right: 1cm;
								height: 2.3cm;
							}

							main{
								left:1cm;
								right:1cm;
							}

							footer {
								position: fixed;
								bottom:   0px;
								left:     0px;
								width:    21.8cm;
								height:   3.2cm;
								border-top:1px solid #B4B4B4;
								z-index:  -1000;
							}

						</style>
					</head>
					<body>';
						
						//$imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT']."/mycloud/logos/logo-gpem.png")); 
						//$html=file_get_contents_curl("https://gpemsac.com/portal/cotizador/print/GenerarPdfCotizacion.php?cotizacion=13");
						
						$html5.='
						<footer>
							<p style="text-align:center; padding:0px; margin:0px;">AV. Los Incas 4ta Cuadra S/N - Comas - Lima - Per&uacute; - Telf. (511) 7130629 Anexo 308</p>
							<p style="text-align:center; padding:0px; margin:0px;">e-mail: g.administracion@gpemsac.com</p>
							<img src="'.$_SERVER['DOCUMENT_ROOT']."/mycloud/portal/empresa/footer/gpemsac.jpg".'" width="100%" style="height:2.3cm;"/>
						</footer>';

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
						
						/*
						$html5.='
						<footer>
							<table style="width: 100%; border-top:1px solid #B4B4B4;">
								<tr>
									<td style="text-align:center;">AV. Los Incas 4ta Cuadra S/N - Comas - Lima - Per&uacute; - Telf. (511) 7130629 Anexo 308</td>
								</tr>
								<tr>
									<td style="text-align: center">e-mail: g.administracion@gpemsac.com</td>
								</tr>
								<tr>
									<td style="width: 100%;"><img src="'.$_SERVER['DOCUMENT_ROOT']."/mycloud/portal/empresa/footer/gpemsac.jpg".'" width="100%"></td>
								</tr>
							</table>
						</footer>';
						*/

						$html5.='
						<main>
							<p style="width: 95%; text-align: right; margin-bottom:1px;">'.$Fecha.'</p>
							<p style="margin-bottom: 1px;">Se&ntilde;ores:</p>
							<p style="margin: 1px 0px; font-weight:bold;">'.utf8_encode($CliNombre).'</p>
							<p style="margin: 1px 0px;">RUC: '.$CliRuc.'</p>
							<p style="margin: 1px 0px;">Direcci&oacute;n: '.utf8_encode($CliDireccion).'</p>';

							if(!empty($CliContacto)){
								$html5.='<p style="margin: 1px 0px;">Contacto: '.utf8_encode($CliContacto).'</p>';
							}

							if(!empty($CliTelefono)){
								$html5.='<p style="margin: 1px 0px;">Tel&eacute;fono: '.utf8_encode($CliTelefono).'</p>';
							}

							if(!empty($CliCorreo)){
								$html5.='<p style="margin: 1px 0px;">Correo: '.utf8_encode($CliCorreo).'</p>';
							}						
							
							$html5.='
							<p>De nuestra especial consideraci&oacute;n, es grato dirigirnos a Uds. para remitir la siguiente cotizaci&oacute;n.</p>
							<table style="width:100%; border-spacing:0;">
								<tr style="background-color:#001466; color:white; text-align:center;">
									<td style="padding:8px; text-align:right; width: 5%">Item</td>
									<td style="padding:8px; width: 40%;">Descripci&oacute;n</td>
									<td style="padding:8px; text-align:right;">Cantidad</td>
									<td style="padding:8px;">Medida</td>
									<td style="padding:8px; text-align:right;">Valor Unitario</td>
									<td style="padding:8px; text-align:right;">Precio Unitario</td>
									<td style="padding:8px; text-align:right;">Valor Venta</td>
								</tr>';

								$query=" producto as nombre, ";

								if($VerCodigo){
									$query=" concat(codigo, ' ', producto) as nombre, ";
								}

								try{
									$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
									$stmt=$conmy->prepare("select".$query."cantidad, precio, medida from tbldetallecotizacion where idcotizacion=:Cotizacion;");
									$stmt->execute(array('Cotizacion'=>$Id));
									if($stmt->rowCount()>0){
										$i=1;
										$PrecioUnitario=0;
										$ValorVenta=0;              
										while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
											$PrecioUnitario=$row['precio']*(1+($Igv/100));
											$ValorVenta=$row['cantidad']*$row['precio'];
											$TotValorVenta+=$ValorVenta;
											
											$html5.='
											<tr>
												<td style="padding:8px 5px 8px 5px; text-align:right; border-bottom: 1px solid #B4B4B4;">'.$i.'</td>
												<td style="padding:8px 5px 8px 5px; border-bottom: 1px solid #B4B4B4;">'.utf8_encode($row['nombre']).'</td>
												<td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $row['cantidad']).'</td>
												<td style="padding:8px 5px 8px 5px; border-bottom: 1px solid #B4B4B4;">'.utf8_encode($row['medida']).'</td>
												<td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $row['precio']).'</td>
												<td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $PrecioUnitario).'</td>
												<td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $ValorVenta).'</td>
											</tr>';
											$i+=1;
										}
										
										$TotDescuentos = $TotValorVenta * ($Descuento/100);
										$BaseImponible = $TotValorVenta - $TotDescuentos;
										$TotImpuestos = $BaseImponible * ($Igv/100);
										$TotPrecioVenta = $BaseImponible + $TotImpuestos;

										$html5.='
										<tr>
											<td colspan="6" style="padding:5px 5px 5px 5px; text-align: right;">Total Venta '.$MonedaSimbolo.'</td>
											<td style="padding:5px 5px 5px 5px; text-align: right;">'.sprintf('%.2f', $TotValorVenta).'</td>
										</tr>';

										if($Descuento>0){
											$html5.='
											<tr>
												<td colspan="6" style="padding:5px 5px 5px 5px; text-align: right;">Total con Descuento('.$Descuento.'%) '.$MonedaSimbolo.'</td>
												<td style="padding:5px 5px 5px 5px; text-align: right;">'.sprintf('%.2f', $BaseImponible).'</td>
											</tr>';
										}

										$html5.='											
										<tr>
											<td colspan="6" style="padding:5px 5px 5px 5px; text-align: right;">Total IGV('.$Igv.'%) '.$MonedaSimbolo.'</td>
											<td style="padding:5px 5px 5px 5px; text-align: right;">'.sprintf('%.2f', $TotImpuestos).'</td>
										</tr>
										<tr>
											<td colspan="6" style="padding:5px 5px 5px 5px; text-align: right; font-weight:bold;">Monto Total '.$MonedaSimbolo.'</td>
											<td style="padding:5px 5px 5px 5px; text-align:right; font-weight:bold;">'.sprintf('%.2f', $TotPrecioVenta).'</td>
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
							<ul>';
							
							if($Descuento>0){
								$html5.='<li>Descuento: '.$Descuento.'%</li>';
							}

							$html5.='<li>Moneda: '.$MonedaNombre.'</li>';
							
							
							if(!empty($CotTiempo)){
								$html5.='<li>Tiempo de oferta: '.$CotTiempo.' d&iacute;as</li>';
							}

							if(!empty($CotPago)){
								$html5.='<li>Condici&oacute;n de pago: '.utf8_encode($CotPago).'</li>';
							}

							if(!empty($CotEntrega)){
								$html5.='<li>Plazo de Entrega: '.utf8_encode($CotEntrega).'</li>';
							}

							if(!empty($CotLugar)){
								$html5.='<li>Lugar de entrega: '.utf8_encode($CotLugar).'</li>';
							}

							if(!empty($Observaciones)){
								$html5.='<li>Observaciones: '.utf8_encode($Observaciones).'</li>';
							}

							$html5.='							
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
							<p class="fs-12 fw-bold" style="text-decoration: underline; padding:0px; margin:0px;">'.utf8_encode($VendNombre).'</p>
							<p style="padding:0px; margin:0px;">Asesor Comercial</p>
							<p style="padding:0px; margin:0px;">GPEM SAC.</p>
						</main>
					</body>
				</html>';
			}else{
				$html5='<h5>No se encontr&oacute; la Cotizaci&oacute;n.</h5>';
			}
		}else{
			$html5='<h5>No se reconoce el n&uacute;mero de Cotizaci&oacute;n.</h5>';
		}
	}else{
		$html5='<h5>Acci&oacute;n no autorizada.</h5>';
	}


	require_once $_SERVER['DOCUMENT_ROOT']."/mycloud/library/dompdf_0-8-3/autoload.inc.php";
	use Dompdf\Dompdf;

	// Instanciamos un objeto de la clase DOMPDF.
	$pdf = new DOMPDF();
	$pdf->set_option('enable_html5_parser', TRUE);
	$pdf->set_paper("letter", "portrait");//Definimos el tamaño y orientación del papel que queremos.
	//$pdf->set_paper(array(0,0,104,250));
	$pdf->load_html(utf8_decode($html5));
	$pdf->render();//Renderizamos el documento PDF.
	$pdf->stream('COTIZACION '.$Cotizacion.'.pdf');// Enviamos el fichero PDF al navegador.

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
<?php
	function fnEnviarCorreos($idpedido){
		$res=false;
		if($idpedido>0){
			include($_SERVER['DOCUMENT_ROOT']."/portal/tienda/modulos/view/ConsultarPedidoPorId.php");
			$array_pedido=fnConsultarPedido($idpedido);
			if(!empty($array_pedido)){
				if (fnCorreoGpem($array_pedido)){
					$res=true;
				}
			}
		}
		return $res;
	}

	function fnCorreoGpem($array_pedido){
		$status=false;
		require($_SERVER['DOCUMENT_ROOT']."/mycloud/library/phpmailer/class.phpmailer.php");
		require($_SERVER['DOCUMENT_ROOT']."/mycloud/library/phpmailer/class.smtp.php");

		$mensaje="
		<html>
			<head>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
				<title>Email GPEM S.A.C.</title>
				<style>
					th { background-color: #FFC433;}
				</style>
			</head>
			<body>
				<h3>Su pedido Número ".$array_pedido['pedido']['factura_id']." ha sido confirmado.</h3>
				<p>Datos de Facturación:</p>
				<ul>
					<li><b>Fecha: </b>".$array_pedido['pedido']['factura_fecha']."</li>
					<li><b>Comprobante: </b>".$array_pedido['pedido']['factura_tipo']."</li>";
					
					if ($array_pedido['pedido']['factura_tipo']=='FACTURA'){
						$mensaje.="
							<li><b>RUC: </b>".$array_pedido['pedido']['factura_ruc']."</li>
							<li><b>Empresa: </b>".$array_pedido['pedido']['factura_empresa']."</li>";
						}
					
					$mensaje.="
					<li><b>Nombre: </b>".$array_pedido['pedido']['factura_apellidos'].", ".$array_pedido['pedido']['factura_nombres']."</li>
					<li><b>Teléfono: </b>".$array_pedido['pedido']['factura_telefono']."</li>
					<li><b>Correo: </b>".$array_pedido['pedido']['factura_correo']."</li>
					<li><b>Dirección: </b>".$array_pedido['pedido']['factura_direccion']."</li>
					<li><b>Nota: </b>".$array_pedido['pedido']['factura_nota']."</li>
				</ul>";

				$tabla="
				<p>Detalle del Pedido:</p>
				<table border='1' cellspacing='0' cellpadding='2'>
					<thead>
						<th>Producto</th>
						<th>Cantidad</th>
						<th>Medida</th>
					</thead>
					<tbody>";

					foreach($array_pedido['detalle'] as $producto){
						$tabla.="
						<tr>
							<td>".$producto['producto']."</td>
							<td>".$producto['cantidad']."</td>
							<td>".$producto['medida']."</td>
						</tr>";
					}

					$tabla.="
					</tbody>
				</table>";

				$mensaje.=$tabla."
				<p>Este es un email automático, por favor no responder a esta dirección.</p> 
				<p>Puedes contactarnos al número +51967829341 o ingresando a nuestro <a href='https://gpemsac.com/pages/contactos'>Centro de contactos</a>
				<p>Centro de notificaciones de comercio electrónico <a href='https://gpemsac.com'>www.gpemsac.com</a></p>
			</body>
		</html>";

		$mail = new PHPMailer();
		$mail->CharSet='UTF-8';
		$mail->IsSMTP();
		$mail->Host = "mail.gpemsac.com";
		$mail->From = "ti@gpemsac.com";
		$mail->FromName = "E-commerce GPEM SAC.";

		$mail->Subject = "Confirmación de pedido Nro ".$array_pedido['pedido']['factura_id'];/*Descripción del asunto*/
		$mail->AltBody = "Se ha generado el pedido Nro ".$array_pedido['pedido']['factura_id'].". Es es un mensaje enviado desde gpemsac.com. Para ver el contenido completo, ejecute un versión html del dispositivo";
		$mail->MsgHTML($mensaje);
		$mail->AddAddress($array_pedido['pedido']['factura_correo'], $array_pedido['pedido']['factura_nombres']);/*Cuenta del cliente*/
		$mail->AddCC('msarabia@gpemsac.com', 'GPEMSAC');/*Correo en copia para GPEM SAC.*/
		
		$mail->SMTPAuth = true;
		$mail->Username = "ti@gpemsac.com";
		$mail->Password = "T1gpem$2021";
		if($mail->Send()) {
			$status=true;
		}
		return $status;
	}


function fnPrueba($MsjGpem){
	require('../../../mycloud/library/phpmailer/class.phpmailer.php');
	require('../../../mycloud/library/phpmailer/class.smtp.php');
	$status=false;
	$mail = new PHPMailer();
	$mail->CharSet='UTF-8';
	$body = $MsjGpem;
	$mail->IsSMTP();
	// Sustituye (ServidorDeCorreoSMTP)  por el host de tu servidor de correo SMTP
	$mail->Host = "mail.gpemsac.com";
	// Sustituye  ( CuentaDeEnvio )  por la cuenta desde la que deseas enviar por ejem. prueba@domitienda.com
	$mail->From = "ti@gpemsac.com";
	$mail->FromName = "E-commerce GPEM SAC.";
	$mail->Subject = "Confirmación de pedido Nro ".$idpedido;
	$mail->AltBody = "Se ha generado el pedido Nro ".$idpedido.". Es es un mensaje enviado desde gpemsac.com. Para ver el contenido completo, ejecute un versión html del dispositivo";
	$mail->MsgHTML($body);
	// Sustituye  (CuentaDestino )  por la cuenta a la que deseas enviar por ejem. admin@domitienda.com
	$mail->AddAddress("msarabia@gpemsac.com", "E-HOLA");
	//$mail->AddAddress($email ,$nombre);
	$mail->AddCC('hqtvsarabia@gmail.com', 'Cliente');
	$mail->SMTPAuth = true;
	// Sustituye (CuentaDeEnvio )  por la misma cuenta que usaste en la parte superior en este caso  prueba@domitienda.com  y sustituye (Contrase�aDeEnvio)  por la contrase�a que tenga dicha cuenta
	$mail->Username = "ti@gpemsac.com";
	$mail->Password = "passw0rd$2019";
	if($mail->Send()) {
		$status=true;
	}
	return $status;
}
?>
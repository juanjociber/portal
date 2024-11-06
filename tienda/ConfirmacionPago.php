<?php

echo "ok";

function fnEnviarCorreoPago($idpedido){
    $res=false;
	include('../../modulos/view/ConsultarPedidoPorId.php');
	$array_pedido=fnConsultarPedido($idpedido);
    if(!empty($array_pedido)){
        if (fnCorreoConfirmacionPago($array_pedido)){
            $res=true;
        }
    }
	return $res;	
}

function fnCorreoConfirmacionPago($array_pedido){
	require('../../../mycloud/library/phpmailer/class.phpmailer.php');
	require('../../../mycloud/library/phpmailer/class.smtp.php');
	$status=false;

	$mensaje="
		<html>
			<head>
				<meta http-equiv='Content-Type' content='text/html; charset=UTF-8'>
				<title>Email con HTML</title>
			</head>
			<body>
				<h3>Estimado/a ".$array_pedido[0]['factura_nombres'].".</h3>
				<p>Queremos informarte que hemos recibido tu pago y estamos procesando tu orden # ".$array_pedido[0]['idpedido'].".</p>
                <p>Podrás consultar el estado de tu orden en cualquier momento al WhatsApp +51967829341. Puedes contactarnos también ingresando a nuestro <a href='https://gpemsac.com/pages/contactos'>Centro de contactos</a>
                </br>
                <p>Este es un email automático, por favor no responder a esta dirección.</p> 
			    <p>Centro de notificaciones de comercio electrónico <a href='https://gpemsac.com'>www.gpemsac.com</a></p>
            </body>
        </html>
    ";

	$mail = new PHPMailer();
	$mail->CharSet='UTF-8';
	$mail->IsSMTP();
	$mail->Host = "mail.gpemsac.com";
	$mail->From = "ti@gpemsac.com";
	$mail->FromName = "E-commerce GPEM SAC.";

	$mail->Subject = "Confirmación de pago de orden ".$array_pedido[0]['idpedido'];/*Descripción del asunto*/
	$mail->AltBody = "Estimado(a) ".$array_pedido[0]['factura_nombres']." hemos recibido tu pago y estamos procesando tu orden Nro ".$array_pedido[0]['idpedido'].". Es es un mensaje enviado desde gpemsac.com. Para ver el contenido completo, ejecute un versión html del dispositivo";
	$mail->MsgHTML($mensaje);
	$mail->AddAddress($array_pedido[0]['factura_correo'], $array_pedido[0]['factura_nombres']);/*Cuenta del cliente*/
	$mail->AddCC('msarabia@gpemsac.com', 'GPEMSAC');/*Correo en copia para GPEM SAC.*/
	
	$mail->SMTPAuth = true;
	$mail->Username = "ti@gpemsac.com";
	$mail->Password = "passw0rd$2019";
	if($mail->Send()) {
		$status=true;
	}
	return $status;
}
?>
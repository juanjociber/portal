<?php 
    session_start();
    if(empty($_SESSION['car'][0]['pedido'])){
        header("location:/carrito");
        exit();
    }

    $idpedido=$_SESSION['car'][0]['pedido'];
    $productos="Ningún productos seleccionado";

    include($_SERVER['DOCUMENT_ROOT']."/portal/tienda/modulos/view/ConsultarPedidoPorId.php");
    $array_pedido=fnConsultarPedido($idpedido);
    
    if(empty($array_pedido)){
        header("location:/carrito");
        exit();
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmar Orden de Compra | GPEM S.A.C.</title>
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-timeline.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    
    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php"); ?>
</head>
<body style="margin-top:90px">
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>
    <div class="container">
        <div class="row mb-1 pb-1">
            <div class="col-12 mb-2">
                <h5 class="fw-bold">CONFIRMACIÓN DEL PEDIDO</h5>
            </div>
            <div class="col-12 mb-1">
                <div class="card card-timeline">
                    <ul class="bs4-order-tracking mb-1 mt-3">
                        <li class="step active">
                            <div><i class="fas fa-check"></i></div> Revisar Pedido
                        </li>
                        <li class="step active">
                            <div><i class="fas fa-check"></i></div> Confirmar Pedido
                        </li>
                        <li class="step active">
                            <div><i class="fas fa-check"></i></div> Finalizar Pedido
                        </li>                        
                    </ul>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 mb-2">
                <p class="fw-bold fs-4">Estimado Usuario,</p>
                <p>Hemos recibido su pedido y en breve nos pondremos en contacto con Usted para coordinar la entrega.</p>
                <p>A continuación le brindamos los datos de su Operación.</p>
            </div>  
        </div>
        
        <div class="row">
            <div class="col-12 col-sm-6 mb-3">
                <h5 class="fw-bold text-secondary">RESUMEN DEL PEDIDO</h5>
                <p class="m-0">Fecha: <b><?php echo $array_pedido['pedido']['factura_fecha']; ?></b></p>
                <p class="m-0">N° Pedido: <b><?php echo $idpedido; ?></b></p>                
                <p class="m-0">Comprobante: <b><?php echo $array_pedido['pedido']['factura_tipo']; ?></b></p>
            </div>
            <div class="col-12 col-sm-6 mb-3 table-responsive">
                <h5 class="fw-bold text-secondary">DATOS DE FACTURACIÓN</h5>
                <?php
                    if($array_pedido['pedido']['factura_tipo']=="FACTURA"){
                        echo "
                        <p class='m-0'>RUC: <b>".$array_pedido['pedido']['factura_ruc']."</b></p>
                        <p class='m-0'>Razón Social: <b>".$array_pedido['pedido']['factura_empresa']."</b></p>";
                    }
                ?>                
                <p class="m-0">Nombre: <b><?php echo $array_pedido['pedido']['factura_apellidos'].', '.$array_pedido['pedido']['factura_nombres']; ?></b></p>
                <p class="m-0">Teléfono: <b><?php echo $array_pedido['pedido']['factura_telefono']; ?></b></p>
                <p class="m-0">Correo: <b><?php echo $array_pedido['pedido']['factura_correo']; ?></b></p>
                <p class="m-0">Direccion: <b><?php echo $array_pedido['pedido']['factura_direccion']; ?></b></p>
                <p class="m-0">Notas adicionales: <b><?php echo $array_pedido['pedido']['factura_nota']; ?></b></p>
            </div>
        </div>
        
        <div class="row mb-2">
            <h5 class="fw-bold text-secondary">DETALLE DEL PEDIDO</h5>
            <div class="col-12 table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr class="table-success fw-bold">
                            <td>Producto</td>
                            <td class="text-center">Cantidad</td>
                            <td class="text-center">Medida</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($array_pedido['detalle'] as $producto){                                 
                            echo "
                            <tr>
                                <td>".$producto['producto']."</td>
                                <td class='text-center'>".$producto['cantidad']."</td>
                                <td class='text-center'>".$producto['medida']."</td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12 col-md-6">
                <h5 class="fw-bold text-primary">INFORMACIÓN DE CONTACTO:</h5>
                <p><b>Oficina Central:</b></p>
                <p>Av. Los Incas S/N - Comas - Lima - Perú. (Final del parque zonal Sinchi Roca)</p>
                <p><b>Horarios de oficina:</b></p>
                <ul>
                    <li>Lunes a Viernes de 09:00 a 18:00</li>
                    <li>Sábados de 09:00 a 13:00</li>
                </ul>
                <p><b>Contactos:</b></p>
                <ul>
                    <li><a href="#" class="text-decoration-none"><i class="fas fa-phone-square-alt"></i> 01-7130628 / 01-7130629</a></li>
                    <li><a href="#" class="text-decoration-none"><i class="fas fa-envelope"></i> hola@gpemsac.com</a></li>
                    <li><a href="https://m.me/Gpemsac" target="_blank" class="text-info text-decoration-none"><i class="fab fa-facebook-messenger"></i> Messenger Gpemsac</a></li>
                    <li><a href="https://wa.me/51967829341?text=https%3A%2F%2Fgpemsac.com%0D%0A%0D%0AHola.+Deseo+cotizar+algunos+productos.+Puede+ayudarme%3F" target="_blank" class="text-success text-decoration-none"><i class="fab fa-whatsapp-square"></i> WhatsApp +51967829341</a></li>
                </ul>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <p><b>Síguenos, comenta y comparte:</b></p>
                <h2>
                    <a href="https://www.facebook.com/gpemsac" target="_blank" class="text-primary"><i class="fab fa-facebook-square"></i></a>
                    <a href="https://www.youtube.com/channel/UCnI6Svnk_AFSg0dd-sy32aw" target="_blank" class="text-danger"><i class="fab fa-youtube-square"></i></a>
                    <a href="https://pe.linkedin.com/company/gpem-sac" target="_blank" class="text-info"><i class="fab fa-linkedin"></i></a>
                    <a href="https://www.instagram.com/gpemsac/" target="_blank" class="text-danger"><i class="fab fa-instagram"></i></a>
                </h2>
            </div>
            <div class="col-12 text-center mb-3">
                <a class="btn btn-primary btn-lg" href="/productos" role="button">FINALIZAR</a>
            </div>
        </div>

    </div>
    <script src="/mycloud/library/gpemsac/portal/js/pedido-confirmado.js"></script>
    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
<?php 
    unset($_SESSION["car"]);
    session_destroy();
?>
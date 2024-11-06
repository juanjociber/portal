<?php
    session_start();
    if(empty($_SESSION['car'][0]['pedido'])){
        header("location:productos.php");
        exit();
    }

    $idpedido=$_SESSION['car'][0]['pedido'];
    //$idpedido=74;
    include($_SERVER['DOCUMENT_ROOT']."/tienda/modulos/view/ConsultarPedidoPorId.php");
    $array_pedido=fnConsultarPedido($idpedido);
    
    if(empty($array_pedido)){
        header("location:mostrarCarrito.php");
        exit();
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pago confirmado - GPEM SAC.</title>
    <link rel="stylesheet" href="/tienda/librerias/css/menu.css">
    <link rel="stylesheet" href="/tienda/librerias/css/gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <?php include($_SERVER['DOCUMENT_ROOT']."/tienda/pages/menu/navbar.php"); ?>
</head>
<body style="margin-top:80px;">
    <div class="container mb-4 bg-light">
        <div class="row">
            <div class="col-12 pt-2">
                <h1 class="display-4 text-center">¡Operación Exitosa!</h1>
                <h4 class="fw-bold">Estimado cliente,</h4>
                <p>Se ha completado exitosamente su Orden de Compra. A continuación se muestran los detalles de su operación:</p>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12">
                <h5 class="fw-bold text-secondary">RESUMEN DE PEDIDO</h5>
            </div>
            <div class="col-6 col-md-3">
                <p class="m-0 p-0">N° PEDIDO:</p>
                <p class="fw-bold"><?php echo $idpedido; ?></p>
            </div>
            <div class="col-6 col-md-3">
                <p class="m-0 p-0">FECHA:</p>
                <p class="fw-bold"><?php echo date('d-m-Y', strtotime($array_pedido['pedido']['factura_fecha'])); ?></p>
            </div>
            <div class="col-6 col-md-3">
                <p class="m-0 p-0">COMPROBANTE:</p>
                <p class="fw-bold"><?php echo $array_pedido['pedido']['factura_tipo']; ?></p>
            </div>
            <div class="col-6 col-md-3">
                <p class="m-0 p-0">TOTAL:</p>
                <p class="fw-bold"><?php echo 'S/ '.sprintf('%.2f', $array_pedido['pedido']['precio_venta']); ?></p>
            </div>            
        </div>
        <div class="row mb-3">
            <div class="col-12 col-md-6 mb-3">
                <h5 class="fw-bold text-secondary">DATOS DE FACTURACIÓN</h5>
                <?php
                    if($array_pedido['pedido']['factura_tipo']=="FACTURA"){
                        echo "
                            <p class='m-0'>RUC: <b>".$array_pedido['pedido']['factura_ruc']."</b></p>
                            <p class='m-0'>Razón Social: <b>".$array_pedido['pedido']['factura_empresa']."</b></p>                        
                        ";
                    }
                ?>                
                <p class="m-0">Nombre: <b><?php echo $array_pedido['pedido']['factura_apellidos'].', '.$array_pedido['pedido']['factura_nombres']; ?></b></p>
                <p class="m-0">Teléfono: <b><?php echo $array_pedido['pedido']['factura_telefono']; ?></b></p>
                <p class="m-0">Correo: <b><?php echo $array_pedido['pedido']['factura_correo']; ?></b></p>
                <p class="m-0">Direccion: <b><?php echo $array_pedido['pedido']['factura_direccion'].' - '.$array_pedido['pedido']['factura_distrito'].' - '.$array_pedido['pedido']['factura_provincia'].' - '.$array_pedido['pedido']['factura_departamento'].' - '.$array_pedido['pedido']['factura_pais']; ?></b></p>
                <p class="m-0">Notas adicionales: <b><?php echo $array_pedido['pedido']['factura_nota']; ?></b></p>
            </div>
            <div class="col-12 col-md-6">
            <h5 class="fw-bold text-secondary">DATOS DE ENTREGA</h5>
                <p class="m-0">Nombre: <b><?php echo $array_pedido['pedido']['delivery_apellidos'].', '.$array_pedido['pedido']['delivery_nombres']; ?></b></p>
                <p class="m-0">Teléfono: <b><?php echo $array_pedido['pedido']['delivery_telefono']; ?></b></p>
                <p class="m-0">Correo Electrónico: <b><?php echo $array_pedido['pedido']['delivery_correo']; ?></b></p>
                <p class="m-0">Direccion: <b><?php echo $array_pedido['pedido']['factura_direccion'].' - '.$array_pedido['pedido']['delivery_distrito'].' - '.$array_pedido['pedido']['delivery_provincia'].' - '.$array_pedido['pedido']['delivery_departamento'].' - '.$array_pedido['pedido']['delivery_pais']; ?></b></p>
                <p class="m-0">Tiempo de atención: <b><?php echo $array_pedido['pedido']['delivery_ndias'].' días'; ?></b></p>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 table-responsive">
                <h5 class="fw-bold text-secondary">DETALLE DEL PEDIDO</h5>
                <table class="table table-hover">
                    <thead>
                        <tr class="table-success fw-bold">
                            <td>Producto</td>
                            <td class="text-end">Cantidad</td>
                            <td class="text-center">Medida</td>
                            <td class="text-end">Precio</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach($array_pedido['detalle'] as $producto){
                            echo "
                                <tr>
                                    <td>".$producto['producto']."</td>
                                    <td class='text-end'>".$producto['cantidad']."</td>
                                    <td class='text-center'>".$producto['medida']."</td>
                                    <td class='text-end'>".$producto['precio']."</td>
                                </tr>";
                        }

                        echo "
                            <tr>
                                <td class='text-end fw-bold' colspan='3'>Subtotal S/: </td>
                                <td class='text-end fw-bold' colspan='3'>".sprintf('%.2f', $array_pedido['pedido']['valor_venta'])."</td>
                            </tr>                           
                            <tr>
                                <td class='text-end fw-bold' colspan='3'>Delivery S/: </td>
                                <td class='text-end fw-bold' colspan='3'>".sprintf('%.2f', $array_pedido['pedido']['precio_envio'])."</td>
                            </tr>
                            <tr>
                                <td class='text-end fw-bold' colspan='3'>Total S/: </td>
                                <td class='text-end fw-bold'>".sprintf('%.2f', $array_pedido['pedido']['precio_venta'])."</td>
                            </tr>";
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
                <a class="btn btn-primary btn-lg" href="/tienda/pages/productos.php" role="button">FINALIZAR</a>
            </div>
        </div>
    </div>    
    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>

<?php include($_SERVER['DOCUMENT_ROOT']."/tienda/pages/menu/footer.html"); ?>
</html>
<?php 
    //unset($_SESSION["car"]);
    //session_destroy();
?>
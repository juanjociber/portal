<?php 
   session_start();
    /* if(empty($_SESSION['car'][0]['pedido'])){
        header("location:mostrarCarrito.php");
        exit();
    }
*/
    //$idpedido=$_SESSION['car'][0]['pedido'];
    $idpedido=90;
    $productos="Ningún productos seleccionado";

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
    <title>Confirmar Orden de Compra - GPEM S.A.C.</title>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/tienda/librerias/css/menu.css">
    <link rel="stylesheet" href="/tienda/librerias/css/gpemsac.css">
    <link rel="stylesheet" href="/tienda/librerias/css/timeline.css">

    <?php include($_SERVER['DOCUMENT_ROOT']."/tienda/pages/menu/navbar.php"); ?>
</head>
<body style="margin-top:90px" class="bg-light">
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>
    <div class="container">
        <div class="row mb-3 pb-1">
            <div class="col-12 mb-2">
                <h5 class="fw-bold">CONFIRMACIÓN DEL PEDIDO</h5>
            </div>
            <div class="col-12 mb-1">
                <div class="card card-timeline">
                    <ul class="bs4-order-tracking mb-2 mt-3">
                        <li class="step active">
                            <div><i class="fas fa-check"></i></div> Revisar Orden
                        </li>
                        <li class="step active">
                            <div><i class="fas fa-check"></i></div> Confirmar Pedido
                        </li>
                        <li class="step active">
                            <div><i class="fas fa-check"></i></div> Metodos de pago
                        </li>                        
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <h5 class="fw-bold text-secondary">RESUMEN DE PEDIDO</h5>
            </div>
            <div class="col-6 col-md-3 border-right">
                <p class="m-0 p-0">N° PEDIDO:</p>
                <p class="fw-bold"><?php echo $idpedido; ?></p>
            </div>
            <div class="col-6 col-md-3 border-right">
                <p class="m-0 p-0">FECHA:</p>
                <p class="fw-bold"><?php echo $array_pedido['pedido']['factura_fecha']; ?></p>
            </div>
            <div class="col-6 col-md-3 border-right">
                <p class="m-0 p-0">COMPROBANTE:</p>
                <p class="fw-bold"><?php echo $array_pedido['pedido']['factura_tipo']; ?></p>
            </div>
            <div class="col-6 col-md-3">
                <p class="m-0 p-0">TOTAL:</p>
                <p class="fw-bold"><?php echo sprintf('%.2f', $array_pedido['pedido']['precio_venta']); ?></p>
            </div>            
        </div>
        
        <div class="row mb-3">
            <div class="col-12 col-md-6 mb-3">
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
                <p class="m-0">Direccion: <b><?php echo $array_pedido['pedido']['factura_direccion'].' - '.$array_pedido['pedido']['factura_distrito'].' - '.$array_pedido['pedido']['factura_provincia'].' - '.$array_pedido['pedido']['factura_departamento'].' - '.$array_pedido['pedido']['factura_pais']; ?></b></p>
                <p class="m-0">Notas adicionales: <b><?php echo $array_pedido['pedido']['factura_nota']; ?></b></p>
            </div>
            <div class="col-12 col-md-6">
                <h5 class="fw-bold text-secondary">DATOS DE ENTREGA</h5>
                <p class="m-0">Nombre: <b><?php echo $array_pedido['pedido']['delivery_apellidos'].', '.$array_pedido['pedido']['delivery_nombres']; ?></b></p>
                <p class="m-0">Teléfono: <b><?php echo $array_pedido['pedido']['delivery_telefono']; ?></b></p>
                <p class="m-0">Direccion: <b><?php echo $array_pedido['pedido']['delivery_direccion'].' - '.$array_pedido['pedido']['delivery_distrito'].' - '.$array_pedido['pedido']['delivery_provincia'].' - '.$array_pedido['pedido']['delivery_departamento'].' - '.$array_pedido['pedido']['delivery_pais']; ?></b></p>
                <p class="m-0">Tiempo de atención: <b><?php echo $array_pedido['pedido']['delivery_ndias']." días"; ?></b></p>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <h5 class="fw-bold text-secondary">DETALLE DEL PEDIDO</h5>
            </div>
            <div class="col-12">
                <div class="row mb-2">
                    <?php 
                        $n=0;
                        foreach($array_pedido['detalle'] as $producto){
                        $n+=1;   
                    ?>
                        <div class="col-12 bg-white mb-2 p-2">
                            <div class="row">
                                <div class="col-12 col-md-6 mb-2">
                                    <div class="row">
                                        <div class="col-4 col-md-2">
                                            <img src="/tienda/archivos/productos/165x165/<?php echo $producto['img'];?>" class="img-thumbnail">
                                        </div>
                                        <div class="col-8 col-md-10">
                                            <p class="text-secondary m-0"><?php echo $producto['marca'] ?></p>
                                            <p class="m-0"><?php echo $producto['producto']; ?></p>
                                            <p class="text-secondary m-0">SKU <?php echo $producto['codigo']; ?></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6 col-md-3 text-end">
                                    <p class="m-0"><?php echo sprintf('%.2f', $producto['cantidad']); ?></p>
                                    <p><?php echo $producto['medida']; ?></p>
                                </div>
                                <div class="col-6 col-md-3 text-end">
                                    <p class="m-0">S/ <?php echo sprintf('%.2f', $producto['precio']);?></p>
                                    <?php
                                        if($producto['oferta']<$producto['precio']){
                                            echo "<p class='text-danger fw-bold'>(Descuento) S/ ".sprintf('%.2f', $producto['oferta'])."</p>";
                                        }
                                    ?>
                                </div>
                            </div>
                        </div>
                    <?php 
                    $productos="Pedido: ".$idpedido.' - '.$n." Items"; 
                    } ?>
                        <div class="col-12 bg-white text-end">
                            <p class="m-0">Subtotal</p>
                            <h5>S/ <?php echo sprintf('%.2f', $array_pedido['pedido']['valor_venta']); ?></h5>
                            <p class="m-0">Delivery</p>
                            <h5>S/ <?php echo sprintf('%.2f', $array_pedido['pedido']['precio_envio']); ?></h5>
                            <?php
                                if($array_pedido['pedido']['descuento']>0){
                                    echo '
                                    <p class="text-danger m-0">Descuento</p>
                                    <h5 class="text-danger">S/ '.sprintf('%.2f', $array_pedido['pedido']['descuento']).'</h5>';
                                }                                
                            ?>
                            <p class="m-0">Total</p>
                            <h5 class="fw-bold">S/ <?php echo sprintf('%.2f', $array_pedido['pedido']['precio_venta']); ?></h5>
                        </div>
                </div>
            </div>
        </div>
        
        <div class="row mb-2">
            <div class="col-12 border-bottom mb-3">
                <h5 class="fw-bold text-secondary">OPCIONES DE PAGO</h5>
            </div>
            <div class="col-12 border-bottom mb-3">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="rbCulqi" onclick="fnOpcionesPago(1);" checked>
                            <label class="form-check-label" for="rbCulqi">
                                Paga en Linea. Es más Fácil y rápido!
                            </label>
                        </div> 
                    </div>
                    <style>
                        .cards ul li{
                            display:inline-block;
                            list-style-type: none;
                            text-align: left;
                        }

                        .img-cards {
                            border: 0 none;
                            margin:1px 4px, 1px, 4px;
                            margin-right:4px;
                            height: 40px;
                            vertical-align: middle;
                        }
                    </style>
                    <div class="col-12 col-md-6 text-right cards">
                        <ul class="p-0 m-0">
                            <li>
                                <img src="/tienda/archivos/logos/visa.jpg" class="img-cards" alt="Visa" />
                            </li>
                            <li>
                                <img src="/tienda/archivos/logos/mastercard.jpg" class="img-cards" alt="Mastercard" />
                            </li>
                            <li>
                                <img src="/tienda/archivos/logos/american-express.jpg" class="img-cards" alt="American Express" />
                            </li>                            
                            <li>
                                <img src="/tienda/archivos/logos/diners-club.jpg" class="img-cards" alt="Diners Club" />
                            </li>
                            <li>
                                <img src="/tienda/archivos/logos/pago-efectivo.jpg" class="img-cards" alt="Diners Club" />
                            </li>
                        </ul>
                    </div>
                    <div class="col-12" id="culqi-container">
                        <p class="ml-4 text-secondary">Se mostrará una ventana modal de CULQI despues de hacer clic en el botón de pago.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-12 border-bottom mb-3">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="rbPlin" onclick="fnOpcionesPago(2);">
                            <label class="form-check-label" for="rbPlin">
                                Plin (BBVA,Interbank, Scotiabank, Banbif)
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-right cards">
                        <ul class="p-0 m-0">
                            <li>
                                <img src="/tienda/archivos/logos/plin.jpg" class="img-cards" alt="Visa" />
                            </li>
                            <li>
                                <img src="/tienda/archivos/logos/bbva.jpg" class="img-cards" alt="Mastercard" />
                            </li>
                            <li>
                                <img src="/tienda/archivos/logos/interbank.jpg" class="img-cards" alt="American Express" />
                            </li>                            
                            <li>
                                <img src="/tienda/archivos/logos/scotiabank.jpg" class="img-cards" alt="Diners Club" />
                            </li>
                            <li>
                                <img src="/tienda/archivos/logos/banbif.jpg" class="img-cards" alt="Diners Club" />
                            </li>
                        </ul>
                    </div>
                    <div class="col-12" id="culqi-container">
                        <p class="ml-4 text-secondary">Usa el Nº del pedido como referencia para confirmar tu pedido. Se procesará cuando se confirme el pago..</p>
                    </div>
                </div>  
            </div>
            <div class="col-12 border-bottom mb-3">
                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="flexRadioDefault" id="rbYape" onclick="fnOpcionesPago(2);">
                            <label class="form-check-label" for="rbYape">
                                Yape (BCP)
                            </label>
                        </div>
                    </div>
                    <div class="col-12 col-md-6 text-right cards">
                        <ul class="p-0 m-0">
                            <li>
                                <img src="/tienda/archivos/logos/yape.jpg" class="img-cards" alt="Visa" />
                            </li>
                            <li>
                                <img src="/tienda/archivos/logos/bcp.jpg" class="img-cards" alt="Mastercard" />
                            </li>
                        </ul>
                    </div>
                    <div class="col-12" id="culqi-container">
                        <p class="ml-4 text-secondary">Usa el Nº del pedido como referencia para confirmar tu pedido. Se procesará cuando se confirme el pago..</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12 text-end">
                <button class="btn btn-success btn-lg fw-bold" id="btnCulqiPay"><i class="far fa-credit-card"></i>  Pagar Ahora</button>
                <button class="btn btn-success btn-lg fw-bold d-none" id="btnMetodoPago2"> Realizar pedido <i class="fas fa-chevron-right"></i></button>
            </div>
        </div>
    </div>
    
    <script src="/tienda/librerias/js/confirmar-pago.js"></script>
    <script src="/mycloud/library/jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="https://checkout.culqi.com/js/v3"></script>

    <script>
        var producto="";
        var precio="";

        $('#btnCulqiPay').on('click', function(e) {
            // Abre el formulario con la configuración en Culqi.settings
            //producto=document.getElementById("txtProducto").value;
            //precio=document.getElementById("txtPrecio").value*100;
            producto="<?php echo $productos; ?>";
            precio=<?php echo round($array_pedido['pedido']['precio_venta']*100,2); ?>;
            Culqi.publicKey = 'sk_test_e4af8aa6a21b1995';
            
            Culqi.options({
                style: {
                    logo: 'https://gpemsac.com/archivos/logos/logo-gpem.png',
                    maincolor: '#ff9311',
                    buttontext: '#ffffff'
                }
            });

            Culqi.settings({
                title: 'GPEMSAC Store',
                currency: 'PEN',
                description: producto,
                amount: precio
            });

            Culqi.open();
            e.preventDefault();
        });

        function culqi() {
            vgLoader.classList.remove('loader-full-hidden')
            if (Culqi.token) { // ¡Objeto Token creado exitosamente!
                var token = Culqi.token.id;
                var email = Culqi.token.email;
                //alert('Se ha creado un token:' + token);
                //En esta linea de codigo debemos enviar el "Culqi.token.id"
                //hacia tu servidor con Ajax
                $.ajax({
                    url:"../modulos/insert/ProcesarPago.php",
                    type:"POST",
                    data:{
                        producto:producto,
                        precio:precio,
                        token:token,
                        email:email
                    }
                }).done(function(resp){
                    window.location.href="PagoConfirmado.php";
                });
            } else { // ¡Hubo algún problema!
                // Mostramos JSON de objeto error en consola
                console.log(Culqi.error);
                alert(Culqi.error.user_message);
                vgLoader.classList.add('loader-full-hidden');
            }
        };
    </script>
</body>
</html>
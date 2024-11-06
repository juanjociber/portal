<?php
    session_start();
    date_default_timezone_set("America/Lima");

    $CliId=0;
    $CliNumero=0;
    $CliRuc="";
    $CliNombre="";
    $CliDireccion="";
    $CliContacto="";
    $CliTelefono="";
    $CliCorreo="";

    $CotMoneda="Dólares Americanos";
    $CotOferta="05 días";
    $CotTipo="Al Contado";
    $CotForma="Inmediato. Previo envío de Voucher de pago y orden de compra";
    $CotLugar="Instalaciones de GPEM SAC. o previa coordinación con el cliente para envío a sus instalaciones";
    $CotObs="";

    if(!empty($_SESSION['car']['cliente'])){
        $CliId=$_SESSION['car']['cliente']['id'];
        $CliNumero=$_SESSION['car']['cliente']['numero'];
        $CliRuc=$_SESSION['car']['cliente']['ruc'];
        $CliNombre=$_SESSION['car']['cliente']['nombre'];
        $CliDireccion=$_SESSION['car']['cliente']['direccion'];
        $CliContacto=$_SESSION['car']['cliente']['contacto'];
        $CliTelefono=$_SESSION['car']['cliente']['telefono'];
        $CliCorreo=$_SESSION['car']['cliente']['correo'];
    }

    if(!empty($_SESSION['car']['condiciones'])){
        $CotOferta=$_SESSION['car']['condiciones']['oferta'];
        $CotTipo=$_SESSION['car']['condiciones']['tipo'];
        $CotForma=$_SESSION['car']['condiciones']['forma'];
        $CotLugar=$_SESSION['car']['condiciones']['lugar'];
        $CotObs=$_SESSION['car']['condiciones']['obs'];
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Cotización | GPEM SAC.</title>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/css/gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/portal/cotizador/menu/sidebar.css">
    <link rel="shortcut icon" href="/mycloud/logos/favicon.ico">

    <style>
    .divselect {
        cursor: pointer;
        transition: all .25s ease-in-out;
    }

    .divselect:hover {
        background-color: #ccd1d1;
        transition: background-color .5s;
    }

    .container-wa{
        position: absolute;
        z-index: 3;
        right: 0px;
        margin:0px;
        padding:0px;
    }

    .link-wa:hover{
        color: red;
    }
</style>

</head>
<body>
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>
    
    <?php include($_SERVER['DOCUMENT_ROOT'].'/portal/cotizador/menu/sidebar.php');?>

    <div class="container section-top">
        <div class="row mb-3">
            <div class="col-12 btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-primary" onclick="fnCotizaciones(); return false;"><i class="fas fa-chevron-left"></i> Atrás</button>
                <button type="button" class="btn btn-outline-primary" onclick="fnAgregarCotizacion(); return false;"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
        <div class="row border-bottom mb-2 align-items-end">    
            <div class="col-12">
                <h5 class="fw-bold text-secondary mb-0">NUEVA COTIZACION</h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <?php 
                    //echo "<pre>";
                    //print_r($_SESSION);
                    //echo "<pre>";
                ?>
            </div>
        </div>

        <div class="row border-bottom pb-2">
            <div class="col-12">
                <div class="accordion" id="accordionExample">

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingOne">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="false" aria-controls="collapseOne">Cliente</button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-2">
                                <div class="row">
                                    <div class="col-12 col-sm-8 mb-2">
                                        <div class="input-group">
                                            <button class="btn btn-primary" type="button" id="button-addon2" style="z-index:0 !important" onclick="fnModalBuscarCliente(); return false;"><i class="fas fa-search"></i> Buscar</button>
                                            <input type="text" class="form-control" id="txtCliNombre" aria-describedby="button-addon2" placeholder="Nombre" value="<?php echo $CliNombre;?>" readonly />
                                        </div>
                                    </div>
                                    <div class="col-12 col-sm-4 mb-2">
                                        <input type="text" class="d-none" id="txtCliId" value="<?php echo $CliId;?>" readonly/>
                                        <input type="text" class="d-none" id="txtCliNumero" value="<?php echo $CliNumero;?>" readonly/>
                                        <input type="text" class="form-control" id="txtCliRuc" placeholder="RUC" value="<?php echo $CliRuc;?>" readonly>
                                    </div>
                                    <div class="col-12 mb-2">
                                        <input type="text" class="form-control" id="txtCliDireccion" placeholder="Direccion" value="<?php echo $CliDireccion;?>">
                                    </div>
                                    <div class="col-12 col-sm-4 mb-2">
                                        <input type="text" class="form-control" id="txtCliContacto" placeholder="Contacto" value="<?php echo $CliContacto;?>">
                                    </div>
                                    <div class="col-12 col-sm-4 mb-2">
                                        <input type="text" class="form-control" id="txtCliTelefono" placeholder="Teléfono" value="<?php echo $CliTelefono;?>">
                                    </div>
                                    <div class="col-12 col-sm-4 mb-2">
                                        <input type="text" class="form-control" id="txtCliCorreo" placeholder="Correo" value="<?php echo $CliCorreo;?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingTwo">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">Condiciones</button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-2">
                                <div class="row">
                                    <div class="col-12 col-sm-4 mb-2">
                                        <p class="m-0" style="font-size:11px;">Moneda</p>
                                        <input type="text" class="form-control" id="txtCotMoneda" value="<?php echo $CotMoneda;?>" readonly>
                                    </div>
                                    <div class="col-6 col-sm-4 mb-2">
                                        <p class="m-0" style="font-size:11px;">Tiempo de la oferta</p>
                                        <input type="text" class="form-control" id="txtCotTiempo" value="<?php echo $CotOferta;?>">
                                    </div>
                                    <div class="col-6 col-sm-4 mb-2">
                                        <p class="m-0" style="font-size:11px;">Condición de pago</p>
                                        <input type="text" class="form-control" id="txtCotPago" value="<?php echo $CotTipo;?>">
                                    </div>
                                    <div class="col-12 col-sm-6 mb-2">
                                        <p class="m-0" style="font-size:11px;">Plazo de Entrega</p>
                                        <input type="text" class="form-control" id="txtCotPlazo" value="<?php echo $CotForma;?>">
                                    </div>
                                    <div class="col-12 col-sm-6 mb-2">
                                        <p class="m-0" style="font-size:11px;">Lugar de Entrega</p>
                                        <input type="text" class="form-control" id="txtCotLugar" value="<?php echo $CotLugar;?>">
                                    </div>
                                    <div class="col-12 mb-2">
                                        <p class="m-0" style="font-size:11px;">Observaciones</p>
                                        <input type="text" class="form-control" id="txtCotObservaciones" value="<?php echo $CotObs;?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary" onclick="fnModificarCliente(); return false;"><i class="fas fa-edit"></i> Modificar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header" id="headingThree">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="true" aria-controls="collapseThree">Productos</button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse show" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body p-2">
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="input-group">
                                            <button class="btn btn-primary" type="button" id="button-addon2" style="z-index:0 !important" onclick="fnModalBuscarProductos(); return false;"><i class="fas fa-search"></i> Buscar</button>
                                            <input type="text" class="form-control" id="txtProNombre" aria-describedby="button-addon2" placeholder="Nombre" readonly />
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <input type="text" class="d-none" id="txtProId" value="0" readonly/>
                                        <input type="number" class="form-control" id="txtProCantidad" value="" placeholder="Cantidad"/>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <input type="number" class="form-control" id="txtProPrecio" value="" placeholder="Precio" readonly/>
                                    </div>
                                    <div class="col-12">
                                        <button type="button" class="btn btn-primary" onclick="fnAgregarProducto(document.getElementById('txtProId').value, document.getElementById('txtProCantidad').value); return false;"><i class="fas fa-plus"></i> Agregar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div class="row p-2">
            <?php
            if(!empty($_SESSION['car'])){
                if(count($_SESSION['car']['productos'])>0){
                    $ValorVenta=0;
                    $PrecioVenta=0;
                    $TotalIgv=0;
                    foreach($_SESSION['car']['productos'] as $indice=>$producto){
                        $ValorVenta+=$producto['cantidad']*$producto['precio'];
                        echo '
                        <div class="col-12 p-0 mb-1 border-bottom" style="position: relative;">
                            <div class="container-wa">
                                <a class="text-decoration-none text-secondary p-0" href="#" onclick="fnEliminarProducto('.$indice.'); return false;"><i class="fas fa-times link-wa fs-4"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <p class="text-secondary mb-0">'.$producto['codigo'].'</p>
                                    <p class="mb-0">'.$producto['nombre'].'</p>
                                    <div class="row justify-content-between">
                                        <div class="col-6">'.$producto['medida'].'</div>
                                        <div class="col-3 text-end">'.sprintf('%.2f', $producto['cantidad']).'</div>
                                        <div class="col-3 text-end fw-bold">$ '.sprintf('%.2f', $producto['precio']).'</div>
                                    </div>                                    
                                </div>                              
                            </div>
                        </div>';
                    }

                    $PrecioVenta=$ValorVenta*1.18;
                    $TotalIgv=$PrecioVenta-$ValorVenta;
                    echo '
                        <div class="col-12 text-end p-0 mt-2">
                            <p class="m-0">Subtotal $ <span class="fs-5">'.sprintf('%.2f', $ValorVenta).'</span></p>
                            <p class="m-0">IGV (18%) $ <span class="fs-5">'.sprintf('%.2f', $TotalIgv).'</span></p>
                            <p class="m-0 fw-bold">Total $ <span class="fs-5">'.sprintf('%.2f', $PrecioVenta).'</span></p>
                        </div>';
                }else{
                    echo '
                    <div class="col-12">
                        <p class="fst-italic">Busque un producto y haga clic en Agregar.</p>
                    </div>';
                }
            }else{
                echo '
                <div class="col-12">
                    <p class="fst-italic">Su carrito esta vacío, busque un producto y haga clic en Agregar.</p>
                </div>';
            }
            ?>
        </div>

    </div>
    
    <div class="modal fade" id="modalBuscarProductos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">BUSCAR PRODUCTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pb-0">
                    <div class="row">
                        <div class="col-12 border-bottom">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control border-primary" id="txtBuscar" placeholder="Código o Nombre" aria-describedby="button-addon2">
                                <button class="btn btn-outline-primary" type="button" id="button-addon2" style="z-index:0 !important" onclick="fnBuscarProductos(document.getElementById('txtBuscar').value); return false;"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2" id="divProductos">
                        <div class="col-12">
                            <p class="fst-italic">Haga clic en el botón Buscar para obtener resultados.</p>
                        </div>                        
                    </div>
                </div>
                <div class="modal-body" id="msjModalBuscarProductos"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBuscarClientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">BUSCAR CLIENTE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pb-0">
                    <div class="row">
                        <div class="col-12 border-bottom">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control border-primary" id="txtBuscarCliente" placeholder="Código o Nombre" aria-describedby="button-addon2">
                                <button class="btn btn-outline-primary" type="button" id="button-addon2" style="z-index:0 !important" onclick="fnBuscarClientes(document.getElementById('txtBuscarCliente').value); return false;"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2" id="divClientes">
                        <div class="col-12">
                            <p class="fst-italic">Haga clic en el botón Buscar para obtener resultados.</p>
                        </div>                        
                    </div>
                </div>
                <div class="modal-body" id="msjModalBuscarClientes"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                </div>              
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/portal/cotizador/menu/sidebar.js"></script>
    <script src="js/NuevaCotizacion.js"></script>
</body>
</html>
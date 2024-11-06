<?php
    session_start();
    if(empty($_SESSION['vgrole'])){
        header("location:/portal/admin/index.php");
        exit();
    }

    if(!($_SESSION['vgrole']=='seller' || $_SESSION['vgrole']=='admin')){
        header("location:/portal/admin/index.php");
        exit();
    }
    
    date_default_timezone_set("America/Lima");
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
        <div class="row border-bottom mb-2">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/NuevaCotizacionCliente.php">CLIENTE</a></li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/NuevaCotizacionCondiciones.php">CONDICIONES</a></li>
                        <li class="breadcrumb-item fw-bold active" aria-current="page">PRODUCTOS</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row mb-2 text-center">    
            <div class="col-12">
                <h5 class="text-secondary mb-0">PRODUCTOS DEL CARRITO</h5>
            </div>
        </div>
        <div class="row border-bottom">
            <div class="col-12 mb-2">
                <p class="m-0" style="font-size:12px;">Nombre</p>
                <div class="input-group" style="z-index: 0">
                    <button class="btn btn-outline-primary" type="button" id="button-addon2" style="z-index:1 !important" onclick="fnModalBuscarProductos(); return false;"><i class="fas fa-search"></i> Buscar</button>
                    <input type="text" class="form-control" id="txtProNombre" aria-describedby="button-addon2" readonly />
                </div>
            </div>
            <div class="col-6 mb-2">
                <p class="m-0" style="font-size:12px;">Cantidad</p>
                <input type="text" class="d-none" id="txtProId" value="0" readonly/>
                <input type="number" class="form-control" id="txtProCantidad" value="" placeholder="0.00"/>
            </div>
            <div class="col-6 mb-2">
                <p class="m-0" style="font-size:12px;">Precio</p>
                <input type="number" class="form-control" id="txtProPrecio" value="" placeholder="0.00" readonly/>
            </div>
            <div class="col-12 mb-2">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnAgregarProducto(document.getElementById('txtProId').value, document.getElementById('txtProCantidad').value); return false;"><i class="fas fa-plus"></i> Agregar Producto</button>
            </div>
        </div>

        <div class="row p-2">
            <?php
            if(!empty($_SESSION['car']['productos'])){
                if(count($_SESSION['car']['productos'])>0){
                    $CotDescuento=0;
                    $IGV=18;

                    if(!empty($_SESSION['car']['condiciones']['descuento'])){
                        $CotDescuento=$_SESSION['car']['condiciones']['descuento'];
                    }

                    $TotValorVenta=0; // suma del valor de los productos
                    $TotDescuentos=0; // vlor de la venta * descuento
                    $BaseImponible=0; // valor de la venta - descuentos
                    $TotImpuestos=0; // base imponible por igv
                    $TotPrecioVenta=0; // base imponible + impuestos


                    foreach($_SESSION['car']['productos'] as $indice=>$producto){
                        $TotValorVenta+=$producto['cantidad'] * $producto['precio'];
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

                    $TotDescuentos = $TotValorVenta * ($CotDescuento/100);
                    $BaseImponible = $TotValorVenta - $TotDescuentos;
                    $TotImpuestos = $BaseImponible * ($IGV/100);
                    $TotPrecioVenta = $BaseImponible + $TotImpuestos;

                    echo '
                        <div class="col-12 text-end p-0 mt-2">
                            <p class="m-0">Total Venta $ <span class="fs-5">'.sprintf('%.2f', $TotValorVenta).'</span></p>';

                    if($TotDescuentos>0){
                        echo '<p class="m-0">Total con Descuento ('.$CotDescuento.'%) $ <span class="fs-5">'.sprintf('%.2f', $BaseImponible).'</span></p>';
                    }

                    echo '
                        <p class="m-0">IGV ('.$IGV.'%) $ <span class="fs-5">'.sprintf('%.2f', $TotImpuestos).'</span></p>
                        <p class="m-0 fw-bold">Importe Total $ <span class="fs-5">'.sprintf('%.2f', $TotPrecioVenta).'</span></p>
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

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/portal/cotizador/menu/sidebar.js"></script>
    <script src="js/NuevaCotizacionProductos.js"></script>
    <script src="js/NuevaCotizacion.js"></script>
</body>
</html>
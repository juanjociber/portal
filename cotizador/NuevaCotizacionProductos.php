<?php
    session_start();
    if(empty($_SESSION['vgrole'])){
        header("location:/portal/admin/index.php");
        exit();
    }

    $CotDescuento = 0;
    $CotTipoPrecio = "publico";
    $CotIgv = 18;
    $CotMoneda = "";

    if(!empty($_SESSION['car']['condiciones'])){
        $CotDescuento = $_SESSION['car']['condiciones']['descuento'];
        $CotMoneda = $_SESSION['car']['condiciones']['moneda'];
        $CotTipoPrecio = $_SESSION['car']['condiciones']['tprecio'];
    }

    $Admin = false;
    $ReadOnly = "readonly";

    if($_SESSION['vgrole']=='admin'){
        $Admin=true;
        $ReadOnly = "";
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
    <?php if($Admin==false){echo '<link rel="stylesheet" href="/portal/cotizador/menu/sidebar.css">';}?> 
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
    
    <?php
        if($Admin){
            $ReadOnly="";
            require_once $_SERVER['DOCUMENT_ROOT']."/portal/admin/AdmMenu.php";
        }else{
            require_once $_SERVER['DOCUMENT_ROOT'].'/portal/cotizador/menu/sidebar.php';
        }
    ?>

    <div class="container section-top">
        <div class="row mb-3">
            <div class="col-12 btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-primary fw-bold" onclick="fnCotizaciones(); return false;"><i class="fas fa-list"></i><span class="d-none d-sm-block"> Cotizaciones</span></button>
                <button type="button" class="btn btn-outline-primary fw-bold" onclick="fnAgregarCotizacion(); return false;"><i class="fas fa-save"></i><span class="d-none d-sm-block"> Guardar</span></button>
            </div>
        </div>

        <div class="row border-bottom mb-2">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/NuevaCotizacionCliente.php">Cliente</a></li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/NuevaCotizacionCondiciones.php">Condiciones</a></li>
                        <li class="breadcrumb-item fw-bold active" aria-current="page">Productos</li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/NuevaCotizacionNotas.php">Notas</a></li>                       
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col-12 mb-2">
                <p class="m-0" style="font-size:12px;">Nombre</p>
                <div class="input-group" style="z-index: 0">
                    <button class="btn btn-outline-primary" type="button" id="button-addon2" style="z-index:1 !important" onclick="fnModalBuscarProductos(); return false;"><i class="fas fa-search"></i> Buscar</button>
                    <input type="text" class="form-control" id="txtProNombre" aria-describedby="button-addon2" <?php echo $ReadOnly;?>/>
                    <input type="text" class="d-none" id="txtProId" readonly/>
                    <input type="text" class="d-none" id="txtProMoneda" readonly/>
                </div>
            </div>
            <div class="col-6 col-sm-3 mb-2">
                <p class="m-0" style="font-size:12px;">Código</p>
                <input type="text" class="form-control" id="txtProCodigo" <?php echo $ReadOnly;?>/>
            </div>
            <div class="col-6 col-sm-2 mb-2">
                <p class="m-0" style="font-size:12px;">Precio</p>
                <div class="input-group">
                    <span class="input-group-text" id="spanProMoneda"></span>
                    <input type="number" id="txtProPrecio" class="form-control" aria-label="Sizing example input" aria-describedby="spanProMoneda" placeholder="0.00" <?php echo $ReadOnly;?>/>
                </div>
            </div>
            <div class="col-6 col-sm-2 mb-2">
                <p class="m-0" style="font-size:12px;">Cantidad</p>
                <input type="number" class="form-control" id="txtProCantidad" placeholder="0.00"/>
            </div>
            <div class="col-6 col-sm-2 mb-2">
                <p class="m-0" style="font-size:12px;">Medida</p>
                <input type="text" class="form-control" id="txtProMedida" <?php echo $ReadOnly;?>/>
            </div>
            <div class="col-sm-3 d-none d-sm-block mb-2">
                <p class="m-0" style="font-size:12px;">Estado</p>
                <select id="cbEstado" class="form-select">
                    <option value="0">Seleccionar</option>
                    <option value="1">STOCK</option>
                    <option value="2">IMPORTACION</option>
                </select>
            </div>
        </div>

        <div class="row border-bottom">
            <?php
                if($Admin){
                    echo '
                    <div class="col-6 d-none d-sm-block mb-2">
                        <div class="btn-group" style="width: 100%;">
                            <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-arrows-alt-v"></i> Productos</button>
                            <ul class="dropdown-menu" style="width:100%;">
                                <li><a class="dropdown-item" href="#" onclick="fnDescargarPlantilla(); return false;"><i class="fas fa-download"></i> Descargar plantilla de productos</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" onclick="fnModalCargarExcel(); return false;"><i class="fas fa-upload"></i> Carga masiva de productos</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-12 col-sm-6 mb-2">
                        <button type="button" class="btn btn-outline-primary form-control" onclick="fnAgregarProducto(); return false;"><i class="fas fa-plus"></i> Producto</button>
                    </div>';
                }else{
                    echo '
                    <div class="col-12 mb-2">
                        <button type="button" class="btn btn-outline-primary form-control" onclick="fnAgregarProducto(); return false;"><i class="fas fa-plus"></i> Producto</button>
                    </div>';
                }            
            ?>
        </div>

        <div class="row p-2">
            <?php
            if(!empty($_SESSION['car']['productos'])){
                if(count($_SESSION['car']['productos'])>0){

                    $TotValorVenta=0; // suma del valor de los productos
                    $TotDescuentos=0; // vlor de la venta * descuento
                    $BaseImponible=0; // valor de la venta - descuentos
                    $TotImpuestos=0; // base imponible por igv
                    $TotPrecioVenta=0; // base imponible + impuestos
                    $ProEstado = '';
                    foreach($_SESSION['car']['productos'] as $indice=>$producto){

                        switch ($producto['estado']) {
                            case 1:
                                $ProEstado = ' [Stock]';
                                break;
                            case 2:
                                $ProEstado = ' [Importación]';
                                break;                            
                            default:
                                $ProEstado = '';
                                break;
                        }

                        $TotValorVenta+=$producto['cantidad'] * $producto['precio'];
                        echo '
                        <div class="col-12 p-0 mb-1 border-bottom" style="position: relative;">
                            <div class="container-wa">
                                <a class="text-decoration-none text-secondary p-0" href="#" onclick="fnEliminarProducto('.$indice.'); return false;"><i class="fas fa-times link-wa fs-4"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <p class="text-secondary mb-0">'.$producto['codigo'].'</p>
                                    <p class="mb-0">'.$producto['nombre'].' <span style="font-size: 12px; color: #6c757d;">'.$ProEstado.'</span></p>
                                    <div class="row justify-content-between">
                                        <div class="col-6">'.$producto['medida'].'</div>
                                        <div class="col-3 text-end">'.sprintf('%.2f', $producto['cantidad']).'</div>
                                        <div class="col-3 text-end">'.sprintf('%.2f', $producto['precio']).'</div>
                                    </div>                                    
                                </div>                              
                            </div>
                        </div>';
                    }

                    $TotDescuentos = $TotValorVenta * ($CotDescuento/100);
                    $BaseImponible = $TotValorVenta - $TotDescuentos;
                    $TotImpuestos = $BaseImponible * ($CotIgv/100);
                    $TotPrecioVenta = $BaseImponible + $TotImpuestos;

                    echo '
                    <div class="row p-0 m-0">
                        <div class="col-8 col-sm-10 text-end">Total Venta ['.$CotMoneda.']</div>
                        <div class="col-4 col-sm-2 text-end p-0 fw-bold">'.sprintf('%.2f', $TotValorVenta).'</div>
                    </div>';
                    
                    if($TotDescuentos>0){
                        echo '
                        <div class="row p-0 m-0">
                            <div class="col-8 col-sm-10 text-end">Total con Descuento ('.$CotDescuento.'%) ['.$CotMoneda.']</div>
                            <div class="col-4 col-sm-2 text-end p-0 fw-bold">'.sprintf('%.2f', $BaseImponible).'</div>
                        </div>';
                    }

                    echo '
                    <div class="row p-0 m-0">
                        <div class="col-8 col-sm-10 text-end">IGV ('.$CotIgv.'%) ['.$CotMoneda.']</div>
                        <div class="col-4 col-sm-2 text-end p-0 fw-bold">'.sprintf('%.2f', $TotImpuestos).'</div>
                    </div>';

                    echo '
                    <div class="row p-0 m-0">
                        <div class="col-8 col-sm-10 text-end">Importe Total ['.$CotMoneda.']</div>
                        <div class="col-4 col-sm-2 text-end p-0 fw-bold">'.sprintf('%.2f', $TotPrecioVenta).'</div>
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
                    <p class="fst-italic">Su carrito esta vacío, busque un producto y haga clic en +Producto.</p>
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
                    <input type="text" class="d-none" id="txtCotTipoPrecio" value="<?php echo $CotTipoPrecio;?>" readonly/>
                </div>                
                <div class="modal-body pb-0">
                    <div class="row">
                        <div class="col-12 border-bottom">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control border-primary" id="txtBuscarProducto" placeholder="Código o Nombre" aria-describedby="button-addon2">
                                <button class="btn btn-outline-primary" type="button" id="button-addon2" style="z-index:0 !important" onclick="fnBuscarProductos(); return false;"><i class="fas fa-search"></i></button>
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
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalCargarExcel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Importación de productos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    <input type="text" class="d-none" id="txtCotTipoPrecio" value="<?php echo $CotTipoPrecio;?>" readonly/>
                </div>                
                <div class="modal-body pb-0">
                    <div class="row">
                        <div class="col-12 mb-2">
                            <label for="filePrueba" class="col-form-label form-control-sm pb-0 ">Adjunte la plantilla correcta de productos</label>
                            <input type="file" id="fileUpload" accept=".xls,.xlsx" class="form-control mb-2"/>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-6 mb-2">
                            <button type="button" id="btnProcesarExcel" class="btn btn-outline-primary form-control" onclick="fnProcesarExcel(); return false;" disabled><i class="fas fa-cog"></i> Procesar [1]</button>
                        </div>
                        <div class="col-6 mb-2">
                            <button type="button" id="btnGuardarExcel" class="btn btn-outline-primary form-control" onclick="fnGuardarExcel(); return false;" disabled><i class="fas fa-save"></i> Guardar [2]</button>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 mb-1">
                            <textarea id="txtExcelMensaje" class="form-control" rows="10" readonly></textarea>
                        </div>                    
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-sm btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>              
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>    
    <!--<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>-->
    <script src="/mycloud/library/xlsx-0.15.3/xlsx.full.min.js"></script>
    <script src="/portal/cotizador/js/NuevaCotizacionProductos.js"></script>
    <script src="/portal/cotizador/js/NuevaCotizacion.js"></script>
    <?php
        if($Admin){
            echo '<script src="/portal/cotizador/js/MenuAdminCotizaciones.js"></script>';
        }else{
            echo '<script src="/portal/cotizador/menu/sidebar.js"></script>';
            echo '<script src="/portal/cotizador/js/MenuPublicCotizaciones.js"></script>';
        }
    ?>
</body>
</html>
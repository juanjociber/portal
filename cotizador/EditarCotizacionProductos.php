<?php
    session_start();
    if(empty($_SESSION['vgrole'])){
        header("location:/portal/admin/index.php");
        exit();
    }

    $CotId=0;
    $Admin = false;
    $ReadOnly = "readonly";

    if($_SESSION['vgrole']=='admin'){
        $Admin=true;
        $ReadOnly = "";
    }

    date_default_timezone_set("America/Lima");
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    if(!empty($_GET['cotizacion'])){
        $CotId = $_GET['cotizacion'];
    }

    $Cotizacion = "";
    $CotTipoPrecio = "publico";
    $CotMoneda = "";
    $CotIgv = 0;
    $CotDescuento = 0;
    $Estado = 0;

    $TotValorVenta = 0; // suma del valor de los productos
    $TotDescuentos = 0; // vlor de la venta * descuento
    $BaseImponible = 0; // valor de la venta - descuentos
    $TotImpuestos = 0; // base imponible por igv
    $TotPrecioVenta = 0; // base imponible + impuestos

    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt=$conmy->prepare("select cotizacion, tipoprecio, moneda, igv, descuento, estado from tblcotizaciones where id=:Id;");
        $stmt->execute(array('Id'=>$CotId));
        $row=$stmt->fetch();
        if($row){
            $Cotizacion = $row['cotizacion'];
            $CotTipoPrecio = $row['tipoprecio'];
            $CotMoneda = $row['moneda'];
            $CotIgv = $row['igv'];
            $CotDescuento = $row['descuento'];       
            $Estado = $row['estado'];
        }
        $stmt=null;
    }catch(PDOException $ex){
        $stmt=null;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cotización | GPEM SAC.</title>
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
        <div class="row mb-1">
            <div class="col-12 btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-primary fw-bold" onclick="fnCotizaciones(); return false;"><i class="fas fa-list"></i><span class="d-none d-sm-block"> Cotizaciones</span></button>
                <button type="button" class="btn btn-outline-primary fw-bold" onclick="fnResumenCotizacion(<?php echo $CotId;?>); return false;"><i class="fas fa-desktop"></i><span class="d-none d-sm-block"> Resúmen</span></button>
            </div>
        </div>

        <div class="row p-2 mb-2">
            <div class="col-12">
                <div class="row border p-1">
                    <div class="col-5 border-end align-self-center text-center">
                        <img class="img-fluid" src="/mycloud/logos/logo-gpem.png" style="max-height: 60px;">
                    </div>
                    <div class="col-7 align-self-center">
                        <input type="text" class="d-none" id="txtCotId" value="<?php echo $CotId;?>" readonly/>                       
                        <p class="fs-6 text-center fw-bold m-0">COTIZACION</p>
                        <p class="fs-6 text-center fw-bold m-0"><?php echo $Cotizacion; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row border-bottom mb-2">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionCliente.php?cotizacion=<?php echo $CotId;?>">Cliente</a></li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionCondiciones.php?cotizacion=<?php echo $CotId;?>">Condiciones</a></li>
                        <li class="breadcrumb-item fw-bold active" aria-current="page">Productos</li>             
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionNotas.php?cotizacion=<?php echo $CotId;?>">Notas</a></li>
                        <li class="breadcrumb-item d-none d-sm-block fw-bold" aria-current="page"><a href="/portal/cotizador/EditarCotizacionImagenes.php?cotizacion=<?php echo $CotId; ?>">Imágenes</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row border-bottom">
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
            <div class="col-12 mb-2">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnAgregarProducto(); return false;"><i class="fas fa-plus"></i> Producto</button>
            </div>
        </div>

        <div class="row p-2">
            <?php
            try{
                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt=$conmy->prepare("select id, codigo, producto, cantidad, precio, medida, estado from tbldetallecotizacion where idcotizacion=:IdCotizacion;");
                $stmt->execute(array('IdCotizacion'=>$CotId));
                if($stmt->rowCount()>0){ 
                    $ProEstado = '';                  
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $TotValorVenta += $row['cantidad'] * $row['precio'];
                        switch ($row['estado']) {
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
                        echo '
                        <div class="col-12 p-0 mb-1 border-bottom" style="position: relative;">
                            <div class="container-wa">
                                <a class="text-decoration-none text-secondary p-0" href="#" onclick="fnEliminarProducto('.$row['id'].'); return false;"><i class="fas fa-times link-wa fs-4"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <p class="text-secondary mb-0">'.$row['codigo'].'</p>
                                    <p class="mb-0">'.$row['producto'].' <span style="font-size: 12px; color: #6c757d;">'.$ProEstado.'</span></p>
                                    <div class="row justify-content-between">
                                        <div class="col-6">'.$row['medida'].'</div>
                                        <div class="col-3 text-end">'.sprintf('%.2f', $row['cantidad']).'</div>
                                        <div class="col-3 text-end fw-bold">'.sprintf('%.2f', $row['precio']).'</div>
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
                            <div class="col-8 col-sm-10 text-end">Descuento ('.$CotDescuento.'%) ['.$CotMoneda.']</div>
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
                        <p class="fst-italic">Su carrito esta vacío, busque un producto y haga clic en Agregar.</p>
                    </div>';
                }
                $stmt=null;
            }catch(PDOException $e){
                $stmt=null;
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
                    <input type="text" class="d-none" id="txtTipoPrecio" value="<?php echo $CotTipoPrecio;?>" readonly/>
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
                <div class="modal-body pt-0" id="msjModalBuscarProductos"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                </div>              
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="js/EditarCotizacionProductos.js"></script>
    <script src="/portal/cotizador/js/EditarCotizacion.js"></script>
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
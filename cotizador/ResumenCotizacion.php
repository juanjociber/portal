<?php
    session_start();
    if(empty($_SESSION['vgrole'])){
        header("location:/portal/admin/index.php");
        exit();
    }

    $Admin=false;
    if($_SESSION['vgrole']=='admin'){
        $Admin=true;
    }

    /*if(!($_SESSION['vgrole']=='seller' || $_SESSION['vgrole']=='admin')){
        header("location:/portal/admin/index.php");
        exit();
    }*/

    date_default_timezone_set("America/Lima");
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $Id=0;

    $Id=$_GET['cotizacion'];
    $Cotizacion="";
    $Fecha="";
    $CliRuc="";
    $CliNombre="";
    $CliDireccion="";
    $CliContacto="";
    $CliTelefono="";
    $CliCorreo="";
    $VendNombre="";
    $CotPago="";
    $CotTiempo = 0;
    $CotMoneda="";
    $CotIgv=0;
    $CotDescuento=0;
    $Nota="";
    $Estado=0;

    $TotValorVenta=0; // suma del valor de los productos
    $TotDescuentos=0; // vlor de la venta * descuento
    $BaseImponible=0; // valor de la venta - descuentos
    $TotImpuestos=0; // base imponible por igv
    $TotPrecioVenta=0; // base imponible + impuestos

    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt=$conmy->prepare("select id, cotizacion, fecha, tipoprecio, cliruc, clinombre, clidireccion, clicontacto, clitelefono, clicorreo, vendnombre, pago, tiempo, moneda, igv, descuento, estado from tblcotizaciones where id=:Cotizacion;");
        $stmt->execute(array('Cotizacion'=>$Id));
        $row=$stmt->fetch();
        if($row){
            $Cotizacion = $row['cotizacion'];
            $Fecha = $row['fecha'];
            $CotTipoPrecio = $row['tipoprecio'];
            $CliRuc = $row['cliruc'];
            $CliNombre = $row['clinombre'];
            $CliDireccion = $row['clidireccion'];
            $CliContacto = $row['clicontacto'];
            $CliTelefono = $row['clitelefono'];
            $CliCorreo = $row['clicorreo'];
            $VendNombre = $row['vendnombre'];
            $CotPago = $row['pago'];
            $CotTiempo = $row['tiempo'];
            $CotMoneda = $row['moneda'];
            $CotIgv = $row['igv'];
            $CotDescuento = $row['descuento'];            
            $Estado = $row['estado'];
        }
        $stmt=null;
    }catch(PDOException $ex){
        $stmt=null;
    }

    $clsSecondary=" btn-outline-secondary ";
    $atrDisabled=" disabled ";
    if($Estado==2){
        $clsSecondary=" btn-outline-primary ";
        $atrDisabled="";
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resúmen Cotización | GPEM SAC.</title>
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
</style>

</head>
<body>
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>
    <?php
        if($Admin){
            require_once $_SERVER['DOCUMENT_ROOT']."/portal/admin/AdmMenu.php";
        }else{
            require_once $_SERVER['DOCUMENT_ROOT'].'/portal/cotizador/menu/sidebar.php';
        }
    ?>
    <div class="container section-top">
        <div class="row mb-2">
            <div class="col-12 btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-primary fw-bold" onclick="fnCotizaciones(); return false;"><i class="fas fa-list"></i><span class="d-none d-sm-block"> Cotizaciones</span></button>                
                <button type="button" class="btn btn-outline-primary fw-bold" onclick="fnDescargarCotizacion(); return false;"><i class="fas fa-file-pdf"></i><span class="d-none d-sm-block"> Descargar</span></button>
                <button type="button" class="btn <?php echo $clsSecondary;?> fw-bold" onclick="fnEditarCotizacion(<?php echo $Id; ?>); return false;"<?php echo $atrDisabled;?>><i class="fas fa-pen"></i><span class="d-none d-sm-block"> Editar</span></button>
                <button type="button" class="btn <?php echo $clsSecondary;?> fw-bold" onclick="fnModalAnularCotizacion(); return false;"<?php echo $atrDisabled;?>><i class="fas fa-ban"></i><span class="d-none d-sm-block"> Anular</span></button>
                <button type="button" class="btn <?php echo $clsSecondary;?> fw-bold" onclick="fnFinalizarCotizacion(); return false;"<?php echo $atrDisabled;?>><i class="fas fa-check-square"></i><span class="d-none d-sm-block"> Finalizar</span></button>
            </div>
        </div>
        <div class="row p-2 mb-2">
            <div class="col-12">
                <div class="row border p-1">
                    <div class="col-5 border-end align-self-center text-center">
                        <img class="img-fluid" src="/mycloud/logos/logo-gpem.png" style="max-height: 60px;">
                    </div>
                    <div class="col-7 align-self-center">
                        <input type="text" class="d-none" id="txtCotId" value="<?php echo $Id;?>" readonly/>
                        <p class="fs-6 text-center fw-bold m-0">COTIZACION</p>
                        <p class="fs-6 text-center fw-bold m-0"><?php echo $Cotizacion; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row p-1 mb-0">
            <div class="col-12 mb-0 border-bottom bg-light">
                <p class="m-0 fw-bold">General</p>
            </div>
        </div>

        <div class="row pb-0 mb-0">
            <div class="col-6 col-sm-4 mb-1">
                <input type="text" id="txtCotizacion" class="d-none" value="<?php echo $_GET['cotizacion']; ?>" readonly>
                <p class="m-0 text-secondary" style="font-size: 12px;">Fecha</p>    
                <p class="m-0 p-0"><?php echo $Fecha;?></p>
            </div>
            <div class="col-6 col-sm-4 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Moneda</p> 
                <p class="m-0 p-0"><?php echo $CotMoneda;?></p>
            </div>
            <div class="col-6 col-sm-4 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">IGV</p> 
                <p class="m-0"><?php echo $CotIgv;?> %</p>
            </div>
            <div class="col-6 col-sm-4 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Responsable</p> 
                <p class="m-0"><?php echo $VendNombre;?></p>
            </div>
            <div class="col-6 col-sm-4 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Descuento</p>
                <p class="m-0"><?php echo $CotDescuento;?> %</p>
            </div>
            <div class="col-6 col-sm-4 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Precio aplicado</p>
                <?php
                    switch ($CotTipoPrecio) {
                        case 'publico':
                            echo '<p class="m-0">Precio Público</p>';
                            break;
                        case 'mayor':
                            echo '<p class="m-0">Precio Mayorista</p>';
                            break;
                        case 'flota':
                            echo '<p class="m-0">Precio Flota</p>';
                            break;
                        default:
                            echo '<p class="m-0">Unknown</p>';
                            break;
                    }                
                ?>
            </div>
            <div class="col-6 col-sm-4 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Forma de Pago</p>
                <p class="m-0"><?php echo $CotPago;?></p>
            </div>
            <div class="col-6 col-sm-4 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Tiempo Oferta</p>
                <p class="m-0"><?php echo $CotTiempo;?> días</p>
            </div>
            <div class="col-6 col-sm-4 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Estado</p>
                <?php
                    switch ($Estado){
                        case 1:
                            echo "<span class='badge bg-danger'>Anulado</span>";
                            break;
                        case 2:
                            echo "<span class='badge bg-primary'>Abierto</span>";
                            break;
                        case 3:
                            echo "<span class='badge bg-success'>Cerrado</span>";
                            break;
                        default:
                            echo "<span class='badge bg-secondary'>Unknown</span>";
                    }
                ?>
            </div>
            <?php
                if($Estado==1){
                    echo '
                    <div class="col-12 col-sm-4 mb-1">
                        <p class="m-0 text-secondary" style="font-size: 12px;">Motivo de la anulación:</p>
                        <p class="m-0 text-danger">'.$Nota.'</p>
                    </div>';
                }
            ?>
        </div>

        <div class="row p-1 mb-0">
            <div class="col-12 mb-0 border-bottom bg-light">
                <p class="m-0 fw-bold">Cliente</p>
            </div>
        </div>

        <div class="row pb-0 mb-0">
            <div class="col-12 col-sm-6 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Nombre</p>
                <p class="m-0"><?php echo $CliNombre;?></p>
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">RUC</p>
                <p class="m-0"><?php echo $CliRuc;?></p>
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Dirección</p>
                <p class="m-0"><?php echo $CliDireccion;?></p>
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Contacto</p>
                <p class="m-0"><?php echo $CliContacto;?></p>
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Teléfono</p>
                <p class="m-0"><?php echo $CliTelefono;?></p>
            </div>
            <div class="col-12 col-sm-6 mb-1">
                <p class="m-0 text-secondary" style="font-size: 12px;">Correo</p>
                <p class="m-0"><?php echo $CliCorreo;?></p>
            </div>
        </div>

        <div class="row p-1 mb-0">
            <div class="col-12 mb-0 border-bottom bg-light">
                <p class="m-0 fw-bold">Notas</p>
            </div>
        </div>

        <div class="row ps-1 pe-1 mb-2">
            <div class="col-12">
                <ul class="m-0 ps-4">
                    <?php
                        try{
                            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $stmt=$conmy->prepare("select descripcion from tblnotascotizacion where cotid=:CotId;");
                            $stmt->execute(array('CotId'=>$Id));
                            if($stmt->rowCount()>0){                   
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                    echo '<li>'.$row['descripcion'].'</li>';                        
                                }
                            }else{
                                echo '<li>No hay notas.</li>';
                            }
                            $stmt=null;
                        }catch(PDOException $e){
                            $stmt=null;
                            echo '<li>'.$msg=$e->getMessage().'</li>';
                        }
                    ?>
                </ul>
            </div>
        </div>

        <div class="row p-1 mb-0">
            <div class="col-12 mb-0 border-bottom bg-light">
                <p class="m-0 fw-bold">Productos</p>
            </div>
        </div>
        <div class="row ps-1 pe-1 mb-3">
            <?php
            try{
                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt=$conmy->prepare("select codigo, producto, cantidad, precio, medida, estado from tbldetallecotizacion where idcotizacion=:Cotizacion;");
                $stmt->execute(array('Cotizacion'=>$Id));
                if($stmt->rowCount()>0){  
                    $ProEstado = '';                 
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $TotValorVenta+=$row['cantidad']*$row['precio'];
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
                        <div class="col-12 mb-1 border-bottom">
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
                    <div class="row m-0">
                        <div class="col-9 col-sm-10 text-end">Total Venta ['.$CotMoneda.']</div>
                        <div class="col-3 col-sm-2 text-end p-0 fw-bold">'.sprintf('%.2f', $TotValorVenta).'</div>
                    </div>';
                    
                    if($TotDescuentos>0){
                        echo '
                        <div class="row m-0">
                            <div class="col-9 col-sm-10 text-end">Total con Descuento ('.$CotDescuento.'%) ['.$CotMoneda.']</div>
                            <div class="col-3 col-sm-2 text-end p-0 fw-bold">'.sprintf('%.2f', $BaseImponible).'</div>
                        </div>';
                    }

                    echo '
                    <div class="row m-0">
                        <div class="col-9 col-sm-10 text-end">IGV ('.$CotIgv.'%) ['.$CotMoneda.']</div>
                        <div class="col-3 col-sm-2 text-end p-0 fw-bold">'.sprintf('%.2f', $TotImpuestos).'</div>
                    </div>';

                    echo '
                    <div class="row m-0">
                        <div class="col-9 col-sm-10 text-end">Importe Total ['.$CotMoneda.']</div>
                        <div class="col-3 col-sm-2 text-end p-0 fw-bold">'.sprintf('%.2f', $TotPrecioVenta).'</div>
                    </div>';
                }else{
                    //
                }
                $stmt=null;
            }catch(PDOException $e){
                $stmt=null;
            }
            ?>
        </div>

        
        <?php
            try{
                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt=$conmy->prepare("select id, nombre, descripcion from tblcotizacionimagenes where cotid=:CotId;");
                $stmt->execute(array('CotId'=>$Id));
                if($stmt->rowCount()>0){
                    echo '
                    <div class="row p-1 mb-0">
                        <div class="col-12 mb-0 border-bottom bg-light">
                            <p class="m-0 fw-bold">Imágenes</p>
                        </div>
                    </div>
                    <div class="row p-2">';

                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        echo '
                        <div class="col-12 col-sm-6 text-center p-1 mb-2">
                            <div class="border" style="position:relative;">
                                <img src="/mycloud/portal/cotizador/anexos/'.$row['nombre'].'" class="img-fluid">
                                <p>'.$row['descripcion'].'</p>
                            </div>                            
                        </div>';
                    }
                    echo '</div>';
                }
                $stmt=null;
            }catch(PDOException $e){
                $stmt=null;
                echo '
                <div class="row p-1 mb-0">
                    <div class="col-12">
                        <p class="fst-italic">'.$e->getMessage().'</p>
                    </div>
                <div/>';
            }
            ?>
        </div>
    </div>
    

    </div>

    <div class="modal fade" id="modalAnularCotizacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ANULAR COTIZACION</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pt-2 pb-1 mb-0">
                    <div class="form-row">
                        <div class="col-12">                            
                            <label for="txtNota" class="col-form-label pb-0" style="font-size:13px;">Motivo de la anulación:</label>                            
                            <input type="text" class="form-control" id="txtNota">
                        </div>                     
                    </div>
                </div>
                <div class="modal-body pt-1 pb-1 mb-1" id="msjAnularCotizacion"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="fnAnularCotizacion(); return false;">Guardar</button>
                </div>              
            </div>
        </div>
    </div>
    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/portal/cotizador/js/ResumenCotizacion.js"></script>
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
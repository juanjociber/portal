<?php
    session_start();
    if(empty($_SESSION['vgrole'])){
        header("location:/portal/admin/index.php");
        exit();
    }

    $IsAdmin = false;
    if($_SESSION['vgrole']=='admin'){
        $IsAdmin = true;
    }
    
    date_default_timezone_set("America/Lima");
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $CotId = 0;
    $Cotizacion = "";
    $CotTipoPrecio = "";
    $CotPago = "";
    $CotTiempo = 0;
    $CotMoneda = "";
    $CotTasa = 0;
    $CotDescuento = 0;
    $VerCodigo = 0;
    $VerCuentas = 0;
    $Estado = 0;

    $cbMonedas = "";
    $cbTiposPrecio = "";  

    if(!empty($_GET['cotizacion'])){
        if($IsAdmin){
            $query="select id, cotizacion, tipoprecio, pago, tiempo, moneda, tasa, descuento, vercodigo, vercuentas, estado from tblcotizaciones where id=:Id;";
        }else{
            $query="select id, cotizacion, tipoprecio, pago, tiempo, moneda, tasa, descuento, vercodigo, vercuentas, estado from tblcotizaciones where id=:Id and idvendedor=".$_SESSION['vgid'].";";
        }
        try{
            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt=$conmy->prepare($query);
            $stmt->execute(array('Id'=>$_GET['cotizacion']));
            $row=$stmt->fetch();
            if($row){
                $CotId = $row['id'];
                $Cotizacion = $row['cotizacion'];
                $CotTipoPrecio = $row['tipoprecio'];
                $CotPago = $row['pago'];
                $CotTiempo = $row['tiempo'];
                $CotMoneda = $row['moneda'];
                $CotTasa = $row['tasa'];
                $CotDescuento = $row['descuento'];
                $VerCodigo = $row['vercodigo'];
                $VerCuentas = $row['vercuentas'];
                $Estado = $row['estado'];
            }
            $stmt=null;
        }catch(PDOException $ex){
            $stmt=null;
        }

        $array_monedas=array('PEN'=>'SOLES', 'USD'=>'DOLARES');
        $array_tiposprecio = array('publico'=>'Precio público', 'mayor'=>'Precio mayorista', 'flota'=>'Precio Flota');

        foreach ($array_monedas as $indice=>$valor){ 
            if ($indice==$CotMoneda){
                $cbMonedas.="<option value='".$indice."' selected>".$valor."</option>";      
            } else {
                $cbMonedas.="<option value='".$indice."'>".$valor."</option>";
            }
        }
    
        foreach ($array_tiposprecio as $indice=>$valor){ 
            if ($indice==$CotTipoPrecio){
                $cbTiposPrecio.="<option value='".$indice."' selected>".$valor."</option>";      
            } else {
                $cbTiposPrecio.="<option value='".$indice."'>".$valor."</option>";
            }
        }        
    }   
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Actualizar Condiciones | GPEM SAC.</title>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/css/gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <?php if($IsAdmin==false){echo '<link rel="stylesheet" href="/portal/cotizador/menu/sidebar.css">';}?> 
    <link rel="shortcut icon" href="/mycloud/logos/favicon.ico">
</head>
<body>
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>

    <?php
        if($IsAdmin){
            require_once $_SERVER['DOCUMENT_ROOT']."/portal/admin/AdmMenu.php";
        }else{
            require_once $_SERVER['DOCUMENT_ROOT'].'/portal/cotizador/menu/sidebar.php';
        }
    ?>

    <div class="container section-top">
        <div class="row mb-1">
            <div class="col-12 btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-primary fw-bold" onclick="fnCotizaciones(); return false;"><i class="fas fa-list"></i><span class="d-none d-sm-block">Cotizaciones</span></button>
                <button type="button" class="btn btn-outline-primary fw-bold" onclick="fnResumenCotizacion(<?php echo $CotId;?>); return false;"><i class="fas fa-desktop"></i><span class="d-none d-sm-block">Resúmen</span></button>
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
                        <li class="breadcrumb-item fw-bold active" aria-current="page">Condiciones</li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionProductos.php?cotizacion=<?php echo $CotId;?>">Productos</a></li>              
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionNotas.php?cotizacion=<?php echo $CotId;?>">Notas</a></li>
                        <li class="breadcrumb-item d-none d-sm-block fw-bold" aria-current="page"><a href="/portal/cotizador/EditarCotizacionImagenes.php?cotizacion=<?php echo $CotId; ?>">Imágenes</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-6 mb-2">
                <p class="m-0" style="font-size:12px;">Moneda</p>
                <select class="form-select" id="cbCotMoneda"><?php echo $cbMonedas;?></select>
            </div>
            <div class="col-6 mb-2">
                <p class="m-0" style="font-size:12px;">T.Cambio</p>
                <input type="number" class="form-control" id="txtCotTasa" value="<?php echo $CotTasa;?>"/>
            </div>
            <div class="col-6 mb-2">
                <p class="m-0" style="font-size:12px;">Descuento(%)</p>
                <input type="number" class="form-control" id="txtCotDescuento" value="<?php echo $CotDescuento;?>">
            </div>
            <div class="col-6 mb-2">
                <p class="m-0" style="font-size:12px;">Tipo Precio</p>
                <select class="form-select" id="cbCotTipoPrecio"><?php echo $cbTiposPrecio;?></select>
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <p class="m-0" style="font-size:12px;">Condición de pago</p>
                <input type="text" class="form-control" id="txtCotPago" value="<?php echo $CotPago;?>">
            </div>
            <div class="col-6 mb-2">
                <p class="m-0" style="font-size:12px;">Tiempo Oferta(días)</p>
                <input type="number" class="form-control" id="txtCotTiempo" value="<?php echo $CotTiempo;?>">
            </div>
            <div class="col-12 mb-2">
                <p class="m-0" style="font-size:12px;">Configuraciones</p>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="chkMostrarCodigo" <?php if($VerCodigo=="1"){echo 'checked';}?>>
                    <label class="form-check-label" for="chkMostrarCodigo">Mostrar código de productos</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="chkMostrarCuentas" <?php if($VerCuentas=="1"){echo 'checked';}?>>
                    <label class="form-check-label" for="chkMostrarCuentas">Mostrar Cuentas Bancarias</label>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnActualizarCondiciones(); return false;"><i class="fas fa-save"></i> Guardar</button>
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/portal/cotizador/js/EditarCotizacionCondiciones.js"></script>
    <script src="/portal/cotizador/js/EditarCotizacion.js"></script>
    <?php
        if($IsAdmin){
            echo '<script src="/portal/cotizador/js/MenuAdminCotizaciones.js"></script>';
        }else{
            echo '<script src="/portal/cotizador/menu/sidebar.js"></script>';
            echo '<script src="/portal/cotizador/js/MenuPublicCotizaciones.js"></script>';
        }
    ?>
</body>
</html>
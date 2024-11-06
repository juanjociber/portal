<?php
    session_start();
    if(empty($_SESSION['vgrole'])){
        header("location:/portal/admin/index.php");
        exit();
    } 
    
    $Admin=false;
    $ReadOnly="readonly";

    if($_SESSION['vgrole']=='admin'){
        $Admin=true;
    }

    date_default_timezone_set("America/Lima");

    $CotTipoPrecio = "publico";
    $CotMoneda = "PEN";
    $CotTasa = 1;
    $CotDescuento = 0;
    $CotPago = "Al Contado";
    $CotTiempo = 0;
    $ChkCodigo = "true";
    $ChkCuentas = "true";

    $cbMonedas="";
    $cbTiposPrecio = "";

    $array_monedas=array('PEN'=>'SOLES', 'USD'=>'DOLARES');
    $array_tiposprecio = array('publico'=>'Precio público', 'mayor'=>'Precio mayorista', 'flota'=>'Precio Flota');

    if(!empty($_SESSION['car']['condiciones'])){
        $CotTipoPrecio = $_SESSION['car']['condiciones']['tprecio'];
        $CotMoneda = $_SESSION['car']['condiciones']['moneda'];
        $CotTasa = $_SESSION['car']['condiciones']['tasa'];
        $CotDescuento = $_SESSION['car']['condiciones']['descuento'];
        $CotTiempo = $_SESSION['car']['condiciones']['tiempo'];
        $CotPago = $_SESSION['car']['condiciones']['pago'];
        $ChkCodigo = $_SESSION['car']['condiciones']['chkcodigo'];
        $ChkCuentas = $_SESSION['car']['condiciones']['chkcuentas'];
    }

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


?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condiciones | GPEM SAC.</title>
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
                        <li class="breadcrumb-item fw-bold active" aria-current="page">Condiciones</li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/NuevaCotizacionProductos.php">Productos</a></li>                        
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/NuevaCotizacionNotas.php">Notas</a></li>                       
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="row mb-2">
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
                <p class="m-0" style="font-size:12px;">Configuraciones para PDF</p>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="chkMostrarCodigo" <?php if($ChkCodigo=="true"){echo 'checked';}?>>
                    <label class="form-check-label" for="chkMostrarCodigo">Mostrar código de productos</label>
                </div>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="chkMostrarCuentas" <?php if($ChkCuentas=="true"){echo 'checked';}?>>
                    <label class="form-check-label" for="chkMostrarCuentas">Mostrar Cuentas Bancarias</label>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnActualizarCondiciones(); return false;"><i class="fas fa-plus"></i> Condiciones</button>
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/portal/cotizador/js/NuevaCotizacionCondiciones.js"></script>
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
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

    $CotMoneda="Dólares Americanos";
    $CotDescuento=0;
    $CotTiempo=5;
    $CotPago="Al Contado";
    $CotEntrega="Inmediato. Previo envío de Voucher de pago y orden de compra";
    $CotLugar="Instalaciones de GPEM SAC. o previa coordinación con el cliente para envío a sus instalaciones";
    $CotObs="";
    $ChkCodigo="true";

    if(!empty($_SESSION['car']['condiciones'])){
        $CotTiempo=$_SESSION['car']['condiciones']['tiempo'];
        $CotDescuento=$_SESSION['car']['condiciones']['descuento'];
        $CotPago=$_SESSION['car']['condiciones']['pago'];
        $CotEntrega=$_SESSION['car']['condiciones']['entrega'];
        $CotLugar=$_SESSION['car']['condiciones']['lugar'];
        $CotObs=$_SESSION['car']['condiciones']['obs'];
        $ChkCodigo=$_SESSION['car']['condiciones']['chkcodigo'];
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
                        <li class="breadcrumb-item fw-bold active" aria-current="page">CONDICIONES</li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/NuevaCotizacionProductos.php">PRODUCTOS</a></li>                        
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row mb-2 text-center">    
            <div class="col-12">
                <h5 class="text-secondary mb-0">CONDICIONES COMERCIALES</h5>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 col-sm-6 mb-2">
                <p class="m-0" style="font-size:12px;">Moneda</p>
                <input type="text" class="form-control" id="txtCotMoneda" value="<?php echo $CotMoneda;?>" readonly>
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <p class="m-0" style="font-size:12px;">Descuento(%)</p>
                <input type="number" class="form-control" id="txtCotDescuento" value="<?php echo $CotDescuento;?>">
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <p class="m-0" style="font-size:12px;">Tiempo de la oferta(días)</p>
                <input type="number" class="form-control" id="txtCotTiempo" value="<?php echo $CotTiempo;?>">
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <p class="m-0" style="font-size:12px;">Condición de pago</p>
                <input type="text" class="form-control" id="txtCotPago" value="<?php echo $CotPago;?>">
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <p class="m-0" style="font-size:12px;">Plazo de Entrega</p>
                <input type="text" class="form-control" id="txtCotEntrega" value="<?php echo $CotEntrega;?>">
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <p class="m-0" style="font-size:12px;">Lugar de Entrega</p>
                <input type="text" class="form-control" id="txtCotLugar" value="<?php echo $CotLugar;?>">
            </div>
            <div class="col-12 mb-2">
                <p class="m-0" style="font-size:12px;">Observaciones</p>
                <input type="text" class="form-control" id="txtCotObs" value="<?php echo $CotObs;?>">
            </div>
            <div class="col-12 mb-2">
                <p class="m-0" style="font-size:12px;">Configuraciones</p>
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="chkMostrarCodigo" <?php if($ChkCodigo=="true"){echo 'checked';}?>>
                    <label class="form-check-label" for="chkMostrarCodigo">¿Mostrar código de productos en PDF?</label>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnActualizarCondiciones(); return false;"><i class="fas fa-plus"></i> Agregar Condiciones Comerciales</button>
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/portal/cotizador/menu/sidebar.js"></script>
    <script src="js/NuevaCotizacionCondiciones.js"></script>
    <script src="js/NuevaCotizacion.js"></script>
</body>
</html>
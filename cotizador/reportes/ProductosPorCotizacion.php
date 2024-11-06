<?php
    session_start();
    if(empty($_SESSION['vgrole'])){
        header("location:/portal/admin/index.php");
        exit();
    }

    //if(!($_SESSION['vgrole']=='seller' || $_SESSION['vgrole']=='admin')){
    //    header("location:/portal/admin/index.php");
    //    exit();
    //}

    $Admin = false;
    if($_SESSION['vgrole']=='admin'){
        $Admin = true;
    }

    date_default_timezone_set("America/Lima");
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotizaciones | GPEM SAC</title>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/css/gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <?php if($Admin==false){echo '<link rel="stylesheet" href="/portal/cotizador/menu/sidebar.css">';}?> 
    <link rel="shortcut icon" href="/mycloud/logos/favicon.ico">

    <style>
        a.link-colecciones {
            color: black;
            text-decoration: none;
        }
        .h-id{
            position: absolute;
            min-width: 40px;
            right: 0px;
        }
        .cls-container{
            position: relative;
        }
        .cls-container:hover{
            background-color: #C9C7C4;
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
        
        <div class="row border-bottom mb-2">
            <div class="col-12">
                <div><h5 class="fw-bold text-secondary mb-0">PRODUCTOS POR COTIZACION</h5></div>
            </div>
        </div>
        
        <div class="row mb-1 border-bottom">
            <div class="col-12 mb-2">
                <p class="m-0" style="font-size:12px;">Código</p>
                <input type="text" class="form-control" id="txtCodigo">
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnBuscarCotizaciones(); return false;"><i class="fas fa-search"></i> Buscar</button>
            </div>
            <div class="col-6 d-none d-sm-block mb-2">
                <button type="button" class="btn btn-outline-success form-control" onclick="fnReporteCotizaciones(); return false;"><i class="fas fa-download"></i> Descargar</button>
            </div>     
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row p-2" id="divCotizaciones">
                    <p class="fst-italic">Haga clic en el botón Buscar para obtener resultados.</p>
                </div>
            </div>
        </div>

        <div class="row p-2">            
            <div class="col-12 text-center mb-3 d-none" id="divPaginacion">
                <button type="button" class="btn btn-outline-primary" onclick="fnNuevaPagina(); return false;"><i class="fas fa-chevron-down"></i> Ver mas.. </button>
            </div>
        </div>
    </div>    

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="/portal/cotizador/js/ReporteProductosPorCotizacion.js"></script>
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
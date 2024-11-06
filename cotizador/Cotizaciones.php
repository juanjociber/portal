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
    $ColSm = "";
    if($_SESSION['vgrole']=='admin'){
        $Admin = true;
        $ColSm = "col-sm-4";
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
    <title>Cotizaciones | GPEM SAC.</title>
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
                <div><h5 class="fw-bold text-secondary mb-0">COTIZACIONES</h5></div>
            </div>
        </div>
        
        <div class="row mb-1 border-bottom">
            <div class="col-12 col-sm-4 mb-2">
                <p class="m-0" style="font-size:12px;">Cotización</p>
                <input type="text" class="form-control" id="txtCotizacion">
            </div>
            <div class="col-6 col-sm-4 mb-3">
                <p class="m-0" style="font-size:12px;">Fecha Inicial</p>
                <input type="date" class="form-control" id="dtpFechaInicial" value="<?php echo date('Y-m-d');?>"/>
            </div>
            <div class="col-6 col-sm-4 mb-3">
                <p class="m-0" style="font-size:12px;">Fecha Final</p>
                <input type="date" class="form-control" id="dtpFechaFinal" value="<?php echo date('Y-m-d');?>"/>
            </div>
            <div class="col-6 <?php echo $ColSm;?> mb-2">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnBuscarCotizaciones(); return false;"><i class="fas fa-search"></i> Buscar</button>
            </div>
            <div class="col-6 <?php echo $ColSm;?> mb-2">
                <a class="btn btn-outline-primary form-control" href="/portal/cotizador/NuevaCotizacionCliente.php" role="button"><i class="fas fa-plus"></i> Cotización</a>
            </div>

            <?php
                if($Admin){
                    echo '
                    <div class="col-4 d-none d-sm-block mb-2">
                        <div class="btn-group" style="width: 100%;">
                            <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-file-excel"></i> Reportes</button>
                            <ul class="dropdown-menu" style="width:100%;">
                                <li><a class="dropdown-item" href="#" onclick="fnReporteCotizacionesMin(); return false;"><i class="fas fa-download"></i> Exportar reporte de cotizaciones</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#" onclick="fnReporteCotizacionesFull(); return false;"><i class="fas fa-download"></i> Exportar reporte de cotizaciones y productos</a></li>
                            </ul>
                        </div>
                    </div>';
                }
            ?>            
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
    <script src="/portal/cotizador/js/Cotizaciones.js"></script>
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
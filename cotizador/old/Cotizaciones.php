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
    <link rel="stylesheet" href="/portal/cotizador/menu/sidebar.css">
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
    
    <?php include($_SERVER['DOCUMENT_ROOT'].'/portal/cotizador/menu/sidebar.php');?>

    <div class="container section-top">
        <div class="row border-bottom mb-2">
            <div class="col-12">
                <h4 class="fw-bold text-secondary mb-0">COTIZACIONES</h4>
            </div>
        </div>
        <div class="row mb-1 border-bottom">
            <div class="col-12 col-sm-4 mb-2">
                <label for="txtCotizacion" class="m-0">Cotización</label>
                <input type="text" class="form-control" id="txtCotizacion" value="">
            </div>
            <div class="col-6 col-sm-4 mb-3">
                <label for="dtpFechaInicial" class="m-0">Fecha Inicial</label>
                <input type="date" class="form-control" id="dtpFechaInicial" value="<?php echo date('Y-m-d');?>"/>
            </div>
            <div class="col-6 col-sm-4 mb-3">
                <label for="dtpFechaFinal" class="m-0">Fecha Final</label>
                <input type="date" class="form-control" id="dtpFechaFinal" value="<?php echo date('Y-m-d');?>"/>
            </div>            
            <div class="col-6 mb-2">
                <a class="btn btn-outline-primary form-control" href="/portal/cotizador/NuevaCotizacionCliente.php" role="button"><i class="fas fa-plus"></i> Cotización</a>
            </div>
            <div class="col-6 mb-2">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnBuscarCotizaciones(); return false;"><i class="fas fa-search"></i> Buscar</button>
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

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/portal/cotizador/menu/sidebar.js"></script>
    <script src="js/Cotizaciones.js"></script>
</body>
</html>
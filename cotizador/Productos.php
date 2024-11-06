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
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Productos | GPEM SAC.</title>
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
    <!--
    <nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-secondary">
        <div class="container-fluid">
            <a class="navbar-brand p-0" href="/portal/admin/AdmProductos.php"><img src="/mycloud/portal/empresa/logos/logo-gpem.png" alt="" height="40"></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 250px;">
                    <li class="nav-item">
                    <a class="nav-link active" id="MenuProductos" aria-current="page" href="/portal/cotizador/index.php">PRODUCTOS</a>
                    </li>
                </ul>
                <span class="navbar-text">
                    <a class="btn btn-outline-danger btn-sm" href="/portal/admin/salir.php" role="button"><?php echo $_SESSION['vgnombre'];?> <i class="fa fa-user-times" aria-hidden="true"></i></a>
                </span>
            </div>
        </div>
    </nav>
    -->

    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>
    
    <?php include($_SERVER['DOCUMENT_ROOT'].'/portal/cotizador/menu/sidebar.php');?>

    <div class="container section-top">
        <div class="row border-bottom mb-3 align-items-end">
            <div class="col-12">
                <h4 class="fw-bold text-secondary mb-0">PRODUCTOS</h4>
            </div>
            <!--
            <div class="col-sm-6 d-none d-sm-block">
                <h4 class="fw-bold text-secondary mb-0">PRODUCTOS</h4>
            </div>           
            <div class="col-6 text-end mb-0">                
                <h5 class="mb-0"><a class="text-decoration-none fw-bold mb-0" href="#" onClick="fnModalAgregarMuestra(); return false;"><i class="fas fa-plus fs-6"></i> Cotización</a></h5>
            </div>-->
        </div>

        <div class="row mb-1">
            <div class="col-12 border-bottom">
                <div class="input-group mb-3">
                    <input type="text" class="form-control border-primary" id="txtProducto" placeholder="Código o Nombre" aria-describedby="button-addon2">
                    <button class="btn btn-outline-primary" type="button" id="button-addon2" style="z-index:0 !important" onclick="fnBuscarProductos(); return false;"><i class="fas fa-search"></i> Buscar</button>
                </div>
            </div>
            <div class="col-12">
                <div class="row p-2" id="divProductos">
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
    <script src="/portal/cotizador/js/Productos.js"></script>
</body>
</html>
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

    $CliId=0;
    $CliNumero=0;
    $CliRuc="";
    $CliNombre="";
    $CliDireccion="";
    $CliContacto="";
    $CliTelefono="";
    $CliCorreo="";

    if(!empty($_SESSION['car']['cliente'])){
        $CliId=$_SESSION['car']['cliente']['id'];
        $CliNumero=$_SESSION['car']['cliente']['numero'];
        $CliRuc=$_SESSION['car']['cliente']['ruc'];
        $CliNombre=$_SESSION['car']['cliente']['nombre'];
        $CliDireccion=$_SESSION['car']['cliente']['direccion'];
        $CliContacto=$_SESSION['car']['cliente']['contacto'];
        $CliTelefono=$_SESSION['car']['cliente']['telefono'];
        $CliCorreo=$_SESSION['car']['cliente']['correo'];
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Cliente | GPEM SAC.</title>
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
                        <li class="breadcrumb-item fw-bold active" aria-current="page">CLIENTE</li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/NuevaCotizacionCondiciones.php">CONDICIONES</a></li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/NuevaCotizacionProductos.php">PRODUCTOS</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="row mb-2 text-center">    
            <div class="col-12">
                <h5 class="text-secondary mb-0">INFORMACION DEL CLIENTE</h5>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col-12 col-sm-8 mb-2">
                <p class="m-0" style="font-size:12px;">Nombre</p>
                <div class="input-group">
                    <button class="btn btn-primary" type="button" id="button-addon2" style="z-index:0 !important" onclick="fnModalBuscarCliente(); return false;"><i class="fas fa-search"></i> Buscar</button>
                    <input type="text" class="form-control" id="txtCliNombre" aria-describedby="button-addon2" placeholder="Nombre" value="<?php echo $CliNombre;?>" readonly />
                </div>
            </div>
            <div class="col-12 col-sm-4 mb-2">
                <p class="m-0" style="font-size:12px;">RUC</p>
                <input type="text" class="d-none" id="txtCliId" value="<?php echo $CliId;?>" readonly/>
                <input type="text" class="d-none" id="txtCliNumero" value="<?php echo $CliNumero;?>" readonly/>
                <input type="text" class="form-control" id="txtCliRuc" placeholder="RUC" value="<?php echo $CliRuc;?>" readonly>
            </div>
            <div class="col-12 mb-2">
                <p class="m-0" style="font-size:12px;">Dirección</p>
                <input type="text" class="form-control" id="txtCliDireccion" placeholder="Direccion" value="<?php echo $CliDireccion;?>">
            </div>
            <div class="col-12 col-sm-4 mb-2">
                <p class="m-0" style="font-size:12px;">Contacto</p>
                <input type="text" class="form-control" id="txtCliContacto" placeholder="Contacto" value="<?php echo $CliContacto;?>">
            </div>
            <div class="col-12 col-sm-4 mb-2">
                <p class="m-0" style="font-size:12px;">Teléfono</p>
                <input type="text" class="form-control" id="txtCliTelefono" placeholder="Teléfono" value="<?php echo $CliTelefono;?>">
            </div>
            <div class="col-12 col-sm-4 mb-2">
                <p class="m-0" style="font-size:12px;">Correo</p>
                <input type="text" class="form-control" id="txtCliCorreo" placeholder="Correo" value="<?php echo $CliCorreo;?>">
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnActualizarCliente(); return false;"><i class="fas fa-plus"></i> Agregar Cliente</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBuscarClientes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">BUSCAR CLIENTE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pb-0">
                    <div class="row">
                        <div class="col-12 border-bottom">
                            <div class="input-group mb-3">
                                <input type="text" class="form-control border-primary" id="txtBuscarCliente" placeholder="RUC o Nombre" aria-describedby="button-addon2">
                                <button class="btn btn-outline-primary" type="button" id="button-addon2" style="z-index:0 !important" onclick="fnBuscarClientes(document.getElementById('txtBuscarCliente').value); return false;"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row p-2" id="divClientes">
                        <div class="col-12">
                            <p class="fst-italic">Haga clic en el botón Buscar para obtener resultados.</p>
                        </div>                        
                    </div>
                </div>
                <div class="modal-body" id="msjModalBuscarClientes"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                </div>              
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/portal/cotizador/menu/sidebar.js"></script>
    <script src="js/NuevaCotizacionCliente.js"></script>
    <script src="js/NuevaCotizacion.js"></script>
</body>
</html>
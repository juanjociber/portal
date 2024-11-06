<?php
    session_start();
    if(empty($_SESSION['vgrole'])){
        header("location:/portal/admin/index.php");
        exit();
    }

    date_default_timezone_set("America/Lima");
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $IsAdmin = false;
    if($_SESSION['vgrole']=='admin'){
        $IsAdmin=true;
    }

    $CotId=0;
    $CliId=0;
    $Cotizacion="";
    $CliNumero=0;
    $CliRuc="";
    $CliNombre="";
    $CliDireccion="";
    $CliContacto="";
    $CliTelefono="";
    $CliCorreo="";
    $Estado=0;

    if(!empty($_GET['cotizacion'])){
        $Query = "";
        if($IsAdmin){
            $Query = "select id, idcliente, cotizacion, clinumero, cliruc, clinombre, clidireccion, clicontacto, clitelefono, clicorreo, estado from tblcotizaciones where id=:Id;";
        }else{
            $Query = "select id, idcliente, cotizacion, clinumero, cliruc, clinombre, clidireccion, clicontacto, clitelefono, clicorreo, estado from tblcotizaciones where id=:Id and idvendedor=".$_SESSION['vgid'].";";
        }
        try{
            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt=$conmy->prepare($Query);
            $stmt->execute(array('Id'=>$_GET['cotizacion']));
            $row=$stmt->fetch();
            if($row){
                $CotId = $row['id'];
                $CliId = $row['idcliente'];
                $Cotizacion = $row['cotizacion'];
                $CliNumero = $row['clinumero'];
                $CliRuc = $row['cliruc'];
                $CliNombre = $row['clinombre'];
                $CliDireccion = $row['clidireccion'];
                $CliContacto = $row['clicontacto'];
                $CliTelefono = $row['clitelefono'];
                $CliCorreo = $row['clicorreo'];   
                $Estado = $row['estado'];
            }
            $stmt=null;
        }catch(PDOException $ex){
            $stmt=null;
        }
    }    
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente | GPEM SAC.</title>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/css/gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <?php if($IsAdmin==false){echo '<link rel="stylesheet" href="/portal/cotizador/menu/sidebar.css">';}?> 
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
                        <li class="breadcrumb-item fw-bold active" aria-current="page">Cliente</li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionCondiciones.php?cotizacion=<?php echo $CotId;?>">Condiciones</a></li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionProductos.php?cotizacion=<?php echo $CotId;?>">Productos</a></li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionNotas.php?cotizacion=<?php echo $CotId;?>">Notas</a></li>
                        <li class="breadcrumb-item d-none d-sm-block fw-bold" aria-current="page"><a href="/portal/cotizador/EditarCotizacionImagenes.php?cotizacion=<?php echo $CotId; ?>">Imágenes</a></li>
                    </ol>
                </nav>
            </div>
        </div>

        <div class="row mb-3">
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
        <div class="row">
            <div class="col-12">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnActualizarCliente(); return false;"><i class="fas fa-save"></i> Guardar</button>
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
                <div class="modal-body pt-0" id="msjModalBuscarClientes"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CERRAR</button>
                </div>              
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="js/EditarCotizacionCliente.js"></script>
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
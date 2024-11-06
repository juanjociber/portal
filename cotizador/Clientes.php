<?php
    session_start();
    if(empty($_SESSION['vgrole'])){
        header("location:/portal/admin/index.php");
        exit();
    }

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
    <title>Clientes | GPEM SAC.</title>
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
                <h4 class="fw-bold text-secondary mb-0">CLIENTES</h4>
            </div>
        </div>
        <div class="row mb-1 border-bottom">
            <div class="col-12 col-sm-4 mb-2">
                <p class="m-0" style="font-size:12px;">RUC / Nombre</p>
                <input type="text" class="form-control" id="txtCliente">
            </div>
            <div class="col-6 col-sm-4 mb-3">
                <p class="m-0" style="font-size:12px;">Fecha Inicial</p>
                <input type="date" class="form-control" id="dtpFechaInicial" value="<?php echo date('Y-m-d');?>"/>
            </div>
            <div class="col-6 col-sm-4 mb-3">
                <p class="m-0" style="font-size:12px;">Fecha Final</p>
                <input type="date" class="form-control" id="dtpFechaFinal" value="<?php echo date('Y-m-d');?>"/>
            </div>
            <div class="col-4 d-none d-sm-block mb-2">
                <button type="button" class="btn btn-outline-success form-control" onclick="fnReporteClientes(); return false;"><i class="fas fa-file-excel"></i> Reporte</button>
            </div>
            <div class="col-6 col-md-4 mb-2">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnModalAgregarCliente(); return false;"><i class="fas fa-plus"></i> Cliente</button>
            </div>
            <div class="col-6 col-md-4 mb-2">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnBuscarClientes(); return false;"><i class="fas fa-search"></i> Buscar</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="row p-2" id="divClientes">
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

    <div class="modal fade" id="modalAgregarCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!--<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">AGREGAR CLIENTE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pt-2 pb-1 mb-0">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="txtCliRuc" class="col-form-label p-0" style="font-size:13px;">RUC:</label>
                            <input type="text" class="form-control" id="txtCliRuc">
                        </div>
                        <div class="col-md-12">
                            <label for="txtCliNombre" class="col-form-label p-0" style="font-size:13px;">Nombre:</label>
                            <input type="text" class="form-control" id="txtCliNombre">
                        </div>
                        <div class="col-12">
                            <label for="txtCliDireccion" class="col-form-label pb-0" style="font-size:13px;">Dirección:</label>
                            <input type="text" class="form-control" id="txtCliDireccion">
                        </div>
                        <div class="col-12">
                            <label for="txtCliContacto" class="col-form-label pb-0" style="font-size:13px;">Contacto:</label>
                            <input type="text" class="form-control" id="txtCliContacto">
                        </div>
                        <div class="col-12">
                            <label for="txtCliCorreo" class="col-form-label pb-0" style="font-size:13px;">Correo:</label>
                            <input type="text" class="form-control" id="txtCliCorreo">
                        </div>                        
                        <div class="col-12">
                            <label for="txtCliTelefono" class="col-form-label pb-0" style="font-size:13px;">Teléfono:</label>
                            <input type="text" class="form-control" id="txtCliTelefono">
                        </div> 
                        <div class="col-12">
                            <label for="txtObs" class="col-form-label pb-0" style="font-size:13px;">Observaciones:</label>
                            <textarea class="form-control" id="txtObs" rows="2"></textarea>
                        </div>                        
                    </div>
                </div>
                <div class="modal-body pt-1 pb-1 mb-1" id="msjAgregarCliente"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="fnAgregarCliente(); return false;">Guardar</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalModificarCliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!--<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">MODIFICAR CLIENTE</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pt-2 pb-1 mb-0">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="txtCliRuc2" class="col-form-label p-0" style="font-size:13px;">RUC:</label>
                            <input type="text" class="d-none" id="txtCliId2" readonly>
                            <input type="text" class="form-control" id="txtCliRuc2">
                        </div>
                        <div class="col-md-12">
                            <label for="txtCliNombre2" class="col-form-label p-0" style="font-size:13px;">Nombre:</label>
                            <input type="text" class="form-control" id="txtCliNombre2">
                        </div>
                        <div class="col-12">
                            <label for="txtCliDireccion2" class="col-form-label pb-0" style="font-size:13px;">Dirección:</label>
                            <input type="text" class="form-control" id="txtCliDireccion2">
                        </div>
                        <div class="col-12">
                            <label for="txtCliContacto2" class="col-form-label pb-0" style="font-size:13px;">Contacto:</label>
                            <input type="text" class="form-control" id="txtCliContacto2">
                        </div>
                        <div class="col-12">
                            <label for="txtCliCorreo2" class="col-form-label pb-0" style="font-size:13px;">Correo:</label>
                            <input type="text" class="form-control" id="txtCliCorreo2">
                        </div>                        
                        <div class="col-12">
                            <label for="txtCliTelefono2" class="col-form-label pb-0" style="font-size:13px;">Teléfono:</label>
                            <input type="text" class="form-control" id="txtCliTelefono2">
                        </div>
                        <div class="col-12">
                            <label for="txtObs2" class="col-form-label pb-0" style="font-size:13px;">Observaciones:</label>
                            <textarea class="form-control" id="txtObs2" rows="2"></textarea>
                        </div>  
                        <div class="col-12">
                            <label for="txtCliTelefono2" class="col-form-label pb-0" style="font-size:13px;">Estado:</label>
                            <select class="form-select" id="cbCliEstado2">
                                <option value="1">Inactivo</option>
                                <option value="2">Activo</option>
                            </select>
                        </div>                        
                    </div>
                </div>
                <div class="modal-body pt-1 pb-1 mb-1" id="msjModificarCliente"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="fnModificarCliente(); return false;">Guardar</button>
                </div>              
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/portal/cotizador/js/Clientes.js"></script>
    <?php
        if($Admin){
            echo '<script src="/portal/cotizador/js/MenuAdminClientes.js"></script>';
        }else{
            echo '<script src="/portal/cotizador/menu/sidebar.js"></script>';
            echo '<script src="/portal/cotizador/js/MenuPublicClientes.js"></script>';
        }
    ?>
</body>
</html>
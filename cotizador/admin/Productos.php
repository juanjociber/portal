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
    <title>Producto | GPEM SAC.</title>
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
    
    <?php require_once $_SERVER['DOCUMENT_ROOT']."/portal/admin/AdmMenu.php";?>
    
    <div class="container section-top">
        <div class="row">
            <div class="d-flex justify-content-between border-bottom mb-2">
                <div><h5 class="fw-bold text-secondary mb-0">PRODUCTOS DEL COTIZADOR</h5></div>
                <div><a class="text-decoration-none fw-bold" target="_blank" href="/portal/cotizador/Productos.php"><i class="fas fa-external-link-square-alt"></i> Public</a></div>
            </div>
        </div>
        <div class="row mb-1 border-bottom">
            <div class="col-12 mb-2">
                <label for="txtBuscarProducto" class="m-0">Código o Nombre</label>
                <input type="text" class="form-control" id="txtBuscarProducto">
            </div>
            <div class="col-6 col-sm-4 mb-2">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnBuscarProductos(); return false;"><i class="fas fa-search"></i> Buscar</button>
            </div>          
            <div class="col-6 col-sm-4 mb-2">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnModalAgregarProducto(); return false;"><i class="fas fa-plus"></i> Producto</button>
            </div>
            <div class="col-4 d-none d-sm-block mb-2">
                <div class="btn-group" style="width: 100%;">
                    <button type="button" class="btn btn-outline-success dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="fas fa-file-excel"></i> Reportes</button>
                    <ul class="dropdown-menu" style="width:100%;">
                        <li><a class="dropdown-item" href="#" onclick="fnDescargarReporteProductos(); return false;"><i class="fas fa-download"></i> Exportar reporte de productos</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="fnDescargarPlantillaPrecios(); return false;"><i class="fas fa-download"></i> Descargar plantilla de precios</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#" onclick="fnModalImportarPrecios(); return false;"><i class="fas fa-upload"></i> Carga masiva de precios</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="row">
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

    <div class="modal fade" id="modalAgregarProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!--<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">AGREGAR PRODUCTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pt-2 pb-1 mb-0">
                    <div class="row">
                        <div class="col-6">
                            <label for="txtProCodInterno" class="col-form-label p-0" style="font-size:13px;">Cod. Interno:</label>
                            <input type="text" class="form-control" id="txtProCodInterno">
                        </div>
                        <div class="col-6">
                            <label for="txtProCodExterno" class="col-form-label p-0" style="font-size:13px;">Cod. Externo:</label>
                            <input type="text" class="form-control" id="txtProCodExterno">
                        </div>
                        <div class="col-12">
                            <label for="txtProNombre" class="col-form-label p-0" style="font-size:13px;">Nombre:</label>
                            <input type="text" class="form-control" id="txtProNombre">
                        </div>
                        <div class="col-6">
                            <label for="txtProMarca" class="col-form-label p-0" style="font-size:13px;">Marca:</label>
                            <input type="text" class="form-control" id="txtProMarca">
                        </div>
                        <div class="col-6">
                            <label for="txtProMedida" class="col-form-label p-0" style="font-size:13px;">Medida:</label>
                            <input type="text" class="form-control" id="txtProMedida">
                        </div>
                        <div class="col-6">
                            <label for="txtProStock" class="col-form-label p-0" style="font-size:13px;">Stock:</label>
                            <input type="number" class="form-control" id="txtProStock">
                        </div>
                        <div class="col-6">
                            <label for="cbProMoneda" class="col-form-label p-0" style="font-size:13px;">Moneda:</label>
                            <select class="form-select" id="cbProMoneda">
                                <option value="USD">DOLARES</option>
                                <option value="PEN">SOLES</option>                                
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="txtProPvPublico" class="col-form-label p-0" style="font-size:13px;">Precio Público:</label>
                            <input type="number" class="form-control" id="txtProPvPublico">
                        </div>
                        <div class="col-6">
                            <label for="txtProPvMayor" class="col-form-label p-0" style="font-size:13px;">Precio Mayorista:</label>
                            <input type="number" class="form-control" id="txtProPvMayor">
                        </div>
                        <div class="col-6">
                            <label for="txtProPvFlota" class="col-form-label p-0" style="font-size:13px;">Precio Flota:</label>
                            <input type="number" class="form-control" id="txtProPvFlota">
                        </div>
                        <div class="col-6">
                            <label for="txtProFecha" class="col-form-label pb-0" style="font-size:13px;">Ultima Fecha:</label>
                            <input type="date" class="form-control" id="txtProFecha" value="<?php echo date("Y-m-d");?>">
                        </div>
                        <div class="col-12">
                            <label for="txtObservacion" class="col-form-label p-0" style="font-size:13px;">Observaciones(200):</label>
                            <textarea class="form-control" id="txtObservacion" rows="2"></textarea>
                        </div>                     
                    </div>
                </div>
                <div class="modal-body pt-1 pb-1 mb-1" id="msjAgregarProducto"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="fnAgregarProducto(); return false;">Guardar</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalModificarProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!--<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">MODIFICAR PRODUCTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pt-2 pb-1 mb-0">
                    <div class="row">
                        <div class="col-6">
                            <label for="txtProCodInterno2" class="col-form-label p-0" style="font-size:13px;">Cod.Interno:</label>
                            <input type="text" class="d-none" id="txtProId2" readonly>
                            <input type="text" class="form-control" id="txtProCodInterno2" readonly>
                        </div>
                        <div class="col-6">
                            <label for="txtProCodExterno2" class="col-form-label p-0" style="font-size:13px;">Cod.Externo:</label>
                            <input type="text" class="form-control" id="txtProCodExterno2">
                        </div>
                        <div class="col-12">
                            <label for="txtProNombre2" class="col-form-label p-0" style="font-size:13px;">Nombre:</label>
                            <input type="text" class="form-control" id="txtProNombre2">
                        </div>
                        <div class="col-6">
                            <label for="txtProMarca2" class="col-form-label p-0" style="font-size:13px;">Marca:</label>
                            <input type="text" class="form-control" id="txtProMarca2">
                        </div>
                        <div class="col-6">
                            <label for="txtProMedida2" class="col-form-label p-0" style="font-size:13px;">Medida:</label>
                            <input type="text" class="form-control" id="txtProMedida2">
                        </div>
                        <div class="col-6">
                            <label for="txtProStock2" class="col-form-label p-0" style="font-size:13px;">Stock:</label>
                            <input type="number" class="form-control" id="txtProStock2">
                        </div>
                        <div class="col-6">
                            <label for="cbProMoneda2" class="col-form-label p-0" style="font-size:13px;">Moneda:</label>
                            <select class="form-select" id="cbProMoneda2">
                                <option value="USD">DOLARES</option>
                                <option value="PEN">SOLES</option>
                            </select>
                        </div>
                        <div class="col-6">
                            <label for="txtProPvPublico2" class="col-form-label p-0" style="font-size:13px;">Precio Público:</label>
                            <input type="number" class="form-control" id="txtProPvPublico2">
                        </div>
                        <div class="col-6">
                            <label for="txtProPvMayor2" class="col-form-label p-0" style="font-size:13px;">Precio Mayorista:</label>
                            <input type="number" class="form-control" id="txtProPvMayor2">
                        </div>
                        <div class="col-6">
                            <label for="txtProPvFlot2" class="col-form-label p-0" style="font-size:13px;">Precio Flota:</label>
                            <input type="number" class="form-control" id="txtProPvFlota2">
                        </div>
                        <div class="col-6">
                            <label for="txtProFecha2" class="col-form-label pb-0" style="font-size:13px;">Ultima Fecha:</label>
                            <input type="date" class="form-control" id="txtProFecha2">
                        </div>
                        <div class="col-6">
                            <label for="cbEstado2" class="col-form-label p-0" style="font-size:13px;">Estado:</label>
                            <select class="form-select" id="cbEstado2">
                                <option value="2">ACTIVO</option>
                                <option value="1">INACTIVO</option>
                            </select>
                        </div> 
                        <div class="col-12">
                            <label for="txtObservacion2" class="col-form-label p-0" style="font-size:13px;">Observaciones(200):</label>
                            <textarea class="form-control" id="txtObservacion2" rows="2"></textarea>
                        </div>                    
                    </div>
                </div>
                <div class="modal-body pt-1 pb-1 mb-1" id="msjModificarProducto"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" class="btn btn-primary" onclick="fnModificarProducto(); return false;">Guardar</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalImportarPrecios" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">IMPORTAR PRECIOS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pb-0">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 mb-2">
                                <p class="text-secondary font-weight-bold">SELECIONE UN ARCHIVO DE EXCEL:</p>
                                <input type="file" class="form-control" id="filePrecios" required>
                            </div>
                            <div class="col-12">
                                <p class="mb-0">Solo adjunte la plantilla de Excel otorgada por el Administrador del Sistema. Cualquier otro archivo podría dañar el sistema</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="msjImportarPrecios"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" onclick="fnImportarPrecios(); return false;">IMPORTAR</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                </div>              
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script src="/portal/cotizador/menu/sidebar.js"></script>
    <script src="/portal/cotizador/admin/js/Productos.js"></script>
</body>
</html>
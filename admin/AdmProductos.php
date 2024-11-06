<?php
    session_start();
    if(empty($_SESSION['vgusuario'])){
        header("location:/portal/admin");
        exit();
    }
    
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $cbEtiquetas='';
    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt=$conmy->prepare("select nombre, name from tblfiltros where idpadre>0 and estado=2;");
        $stmt->execute();
		while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $cbEtiquetas.='<option value="'.$row['name'].'">'.$row['nombre'].'</option>';
		}
		$stmt=null;
    }catch(PDOException $e){
        $stmt=null;
        echo'<script type="text/javascript">
                alert("Tenemos problemas para listar las Etiquetas.");
            </script>';
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
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/css/gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/mycloud/logos/favicon.ico">

    <?php include('AdmMenu.php');?>
</head>

<body class="bg-light section-top">
    <div class="container">
        <div class="row border-bottom border-warning mb-3 align-items-end">
            <div class="col-12 col-sm-6">
                <h4 class="text-secondary fw-bold mb-0">Administración de Productos</h4>
            </div>
            <div class="col-6 text-end d-none d-sm-block">
                <h5><a class="text-decoration-none fw-bold mb-0 p-0" href="#" onClick="fnModalAgregarProducto(); return false;"><i class="fas fa-plus m-0 p-0"></i> PRODUCTO</a></h5>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-4 mb-3">
                <label for="cbEtiquetas" class="m-0">Etiquetas</label>
                <select class="form-select" id="cbEtiquetas">
                    <option value=0>Seleccionar</option>    
                    <?php echo $cbEtiquetas; ?>
                </select>
            </div>            
            <div class="col-12 col-sm-4 mb-3">
                <label for="txtProducto" class="m-0">Producto</label>
                <input type="text" class="form-control" id="txtProducto" value="">
            </div>
            <div class="col-12 col-sm-4 mb-3">
                <label for="cbEstados" class="m-0">Estados</label>
                <select class="form-select" id="cbEstados">
                    <option value="0">Todos los Estados</option>
                    <option value="1">INACTIVO</option>
                    <option value="2">ACTIVO</option>
                </select>
            </div>
            <!--<div class="col-12 col-sm-3 mb-3 align-self-end">-->
            <div class="d-none d-sm-block col-6 mb-3">
                <button type="button" class="btn btn-outline-success form-control" onclick="fnDescargarProductos(); return false;">
                <i class="fas fa-file-download"></i> DESCARGAR</button>
            </div>
            <div class="col-12 col-md-6 mb-3">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnBuscarProductos(
                    document.getElementById('cbEtiquetas').value,
                    document.getElementById('txtProducto').value,
                    document.getElementById('cbEstados').value,
                    1
                    )">
                <i class="fas fa-search"></i> BUSCAR</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row m-0">
                    <div class="col-12 table-responsive p-0">
                        <table class="table table-sm table-hover">
                            <thead>
                                <tr class="bg-secondary text-white text-center">
                                    <td><i class="fas fa-pen"></i></td>
                                    <td>Producto</td>
                                    <td>Código</td>                            
                                    <td>Marca</td>
                                    <td>Prioridad</td>
                                    <td>Estado</td>
                                </tr>
                            </thead>
                            <tbody id="tbody01">
                                <tr>
                                    <td colspan="7">Haga clic en BUSCAR para obtener resultados.</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>                
            </div>
            <div class="col-12">
                <nav aria-label="...">
                    <ul class="pagination" id="paginador">
                    </ul>
                </nav>
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
                <div class="modal-body pb-0">
                    <div class="form-row mb-2">
                        <div class="col-md-12">
                            <label for="txtCodigo1" class="col-form-label p-0">CODIGO:</label>
                            <input type="text" class="form-control" id="txtCodigo1" value="">
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col-md-12">
                            <label for="txtProducto1" class="col-form-label p-0">PRODUCTO:</label>
                            <input type="text" class="form-control" id="txtProducto1" value="">
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col-md-12">
                            <label for="txtSeoUrl1" class="col-form-label p-0">URL:</label>
                            <input type="text" class="form-control" id="txtSeoUrl1" value="">
                        </div>
                    </div>                                      
                    <div class="form-row mb-2">
                        <div class="col-md-12">
                            <label for="txtSerie1" class="col-form-label p-0">SERIE:</label>
                            <input type="text" class="form-control" id="txtSerie1" value="">
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col-md-12">
                            <label for="txtMarca1" class="col-form-label p-0">MARCA:</label>
                            <input type="text" class="form-control" id="txtMarca1" value="">
                        </div>
                    </div>
                    <div class="form-row mb-2">
                        <div class="col-md-12">
                            <label for="txtMedida1" class="col-form-label p-0">MEDIDA:</label>
                            <input type="text" class="form-control" id="txtMedida1" value="">
                        </div>
                    </div>                    
                </div>
                
                <div class="modal-body" id="msjAgregarProducto"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnAgregarProducto(); return false;">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="js/AdmProductos.js"></script>
</body>
</html>
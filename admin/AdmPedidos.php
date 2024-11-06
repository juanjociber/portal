<?php
    session_start();
    if(empty($_SESSION['vgusuario'])){
        header("location:/portal/admin");
        exit();
    }
    
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $cbCategorias='';
    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt1=$conmy->prepare("select idcategoria, categoria from tblcategorias;");
        $stmt1->execute();
		while ($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
            $cbCategorias.='<option value="'.$row1['idcategoria'].'">'.$row1['categoria'].'</option>';
		}
		$stmt1=null;
    }catch(PDOException $e){
        $stmt1=null;
        echo'<script type="text/javascript">
                alert("Tenemos problemas para listar las Categorias.");
            </script>';
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin [Pedidos]</title>

    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/css/gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <?php include('AdmMenu.php');?>
</head>

<body class="bg-light section-top">
    <div class="container">
        <div class="row border-bottom border-warning mb-3 align-items-end">
            <div class="col-12 col-sm-6">
                <h4 class="text-secondary fw-bold">[Administración de Pedidos]</h4>
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-sm-4 mb-3">
                <label for="dtpFechaInicial" class="m-0">DESDE</label>
                <input type="date" class="form-control" id="dtpFechaInicial" value="<?php echo date('Y-m-d');?>"/>
            </div>            
            <div class="col-12 col-sm-4 mb-3">
                <label for="dtpFechaFinal" class="m-0">HASTA:</label>
                <input type="date" class="form-control" id="dtpFechaFinal" value="<?php echo date('Y-m-d');?>"/>
            </div>
            <div class="col-12 col-sm-4 mb-3 d-flex align-items-end">
                <button type="button" class="btn btn-primary form-control" onclick="fnBuscarPedidos(
                    document.getElementById('dtpFechaInicial').value,
                    document.getElementById('dtpFechaFinal').value,
                    1
                    )">
                <i class="fas fa-search"></i> BUSCAR</button>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="row m-0">
                    <div class="col-12 table-responsive p-0">
                        <table class="table table-sm table-bordered table-hover">
                            <thead>
                                <tr class="bg-azul text-center">
                                    <td>ID</td>
                                    <td>FECHA</td>
                                    <td>RUC</td>                            
                                    <td>EMPRESA</td>
                                    <td>CONTACTO</td>
                                    <td>TELEFONO</td>
                                    <td>ESTADO</td>
                                </tr>
                            </thead>
                            <tbody id="tbody01">
                                <tr>
                                    <td colspan="7">Use los filtros y haga clic en BUSCAR para obtener resultados.</td>
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

    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="js/AdmPedidos.js"></script>
</body>
</html>
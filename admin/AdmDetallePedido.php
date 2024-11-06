<?php
    session_start();
    if(empty($_SESSION['vgusuario'])){
        header("HTTP/1.1 401 Unauthorized");
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $array_productos=array();
    $vlFacturaFecha="";
    $vlFacturaTipo="";        
    $vlFacturaRuc="";
    $vlFacturaEmpresa="";
    $vlFacturaNombres="";
    $vlFacturaApellidos="";
    $vlFacturaTelefono="";
    $vlFacturaCorreo="";
    $vlFacturaDireccion="";
    $vlFacturaNota="";
    $vlFacturaEstado=0;

    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt=$conmy->prepare('select factura_fecha, factura_tipo, factura_ruc, factura_empresa ,factura_nombres, factura_apellidos, factura_telefono, factura_correo, factura_direccion, factura_nota, factura_estado from tblpedidos where idpedido=:IdPedido;');
        $stmt->execute(array('IdPedido'=>$_GET['id']));
        $row=$stmt->fetch();
        $vlFacturaFecha=$row['factura_fecha'];
        $vlFacturaTipo=$row['factura_tipo'];        
        $vlFacturaRuc=$row['factura_ruc'];
        $vlFacturaEmpresa=$row['factura_empresa'];
        $vlFacturaNombres=$row['factura_nombres'];
        $vlFacturaApellidos=$row['factura_apellidos'];
        $vlFacturaTelefono=$row['factura_telefono'];
        $vlFacturaCorreo=$row['factura_correo'];
        $vlFacturaDireccion=$row['factura_direccion'];
        $vlFacturaNota=$row['factura_nota'];
        $vlFacturaEstado=$row['factura_estado'];

        $stmt=$conmy->prepare("select codigo, producto, cantidad, medida from tbldetallepedido where idpedido=:IdPedido;");
        $stmt->bindParam(':IdPedido', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $array_productos[]=array(
                'codigo'=>$row['codigo'],
                'producto'=>$row['producto'],
                'cantidad'=>$row['cantidad'],
                'medida'=>$row['medida']
            );
        }

        $stmt=null;
    }catch(PDOException $e){
        $stmt=null;
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin [Información del Pedido]</title>
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/css/gpemsac.css">
    <link rel="shortcut icon" href="/mycloud/icos/favicon.ico">
</head>
<body>
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>
    <div class="container mb-5 mt-2">
        <div class="row">
            <div class="col-12 p-2 mb-3 bg-secondary text-white text-center">
                <h5 class="fw-bold">INFORMACION DEL PEDIDO</h5>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col-12 border-bottom border-warning mb-2">
                <p class="fs-4 m-0">DATOS DEL PEDIDO</p>            
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <p class="text-secondary m-0">FECHA:</p>
                        <p class="fw-bold"><?php echo $vlFacturaFecha; ?></p>
                    </div>
                    <div class="col-6">
                        <p class="text-secondary m-0">ESTADO:</p>
                        <p>
                        <?php 
                            switch ($vlFacturaEstado) {
                                case 1:
                                    echo '<span class="badge bg-danger">ANULADO</span>';
                                break;
                                case 2:
                                    echo '<span class="badge bg-success">PEDIDO</span>';
                                break;
                                default:
                                    echo '<span class="badge bg-secondary">UNKNOWN</span>';
                            }
                        ?>
                        </p>
                    </div>
                    <div class="col-6">
                        <p class="text-secondary m-0">RUC:</p>
                        <p class="fw-bold"><?php echo $vlFacturaRuc; ?></p>
                    </div>
                    <div class="col-6">
                        <p class="text-secondary m-0">TIPO:</p>
                        <p class="fw-bold"><?php echo $vlFacturaTipo; ?></p>
                    </div>          
                    <div class="col-12">
                        <p class="text-secondary m-0">CLIENTE:</p>
                        <p class="fw-bold"><?php echo $vlFacturaEmpresa; ?></p>
                    </div>            
                    <div class="col-12">
                        <p class="text-secondary m-0">DIRECCION:</p>
                        <p class="fw-bold"><?php echo $vlFacturaDireccion; ?></p>
                    </div>
                    <div class="col-6">
                        <p class="text-secondary m-0">CONTACTO:</p>
                        <p class="fw-bold"><?php echo $vlFacturaNombres.' '.$vlFacturaApellidos; ?></p>
                    </div>
                    <div class="col-6">
                        <p class="text-secondary m-0">TELEFONO:</p>
                        <p class="fw-bold"><?php echo $vlFacturaTelefono; ?></p>
                    </div>
                    <div class="col-6">
                        <p class="text-secondary m-0">CORREO:</p>
                        <p class="fw-bold"><?php echo $vlFacturaCorreo; ?></p>
                    </div>                    
                    <div class="col-12 col-sm-6">
                        <p class="text-secondary m-0">NOTA:</p>
                        <p class="fw-bold"><?php echo $vlFacturaNota; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12 border-bottom border-warning mb-2">
                <p class="fs-4 m-0">DETALLE DEL PEDIDO</p>            
            </div>
            <div class="col-12 mb-3">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr class="text-center bg-azul">
                            <th>PRODUCTO</th>
                            <th>CANTIDAD</th>
                            <th>MEDIDA</th>
                        </tr>                        
                    </thead>
                    <tbody>
                        <?php 
                            if(!empty($array_productos)){
                                foreach($array_productos as $item){
                                    echo "
                                    <tr>
                                        <td>".$item['producto']."</td>
                                        <td class='text-end'>".$item['cantidad']."</td>
                                        <td class='text-center'>".$item['medida']."</td>
                                    </tr>";
                                }
                            }else{
                                echo "
                                <tr>
                                    <td colspan='3'>Pedido sin productos.</td>
                                </tr>";
                            }                                    
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="js/AdmDetallePedido.js"></script>
</body>
</html>
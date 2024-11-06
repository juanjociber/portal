<?php 
    session_start();
    include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");

    
    $cbRegiones='<option value=0>Seleccionar</option>';
    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt1 = $conmy->query("select idregion, region from tblregiones where estado=2");
        foreach ($stmt1 as $row1) {
            $cbRegiones.='<option value="'.$row1[1].'">'.$row1[1].'</option>';
        }
        $stmt1 = null;
    }catch(PDOException $e){
        $stmt1=null;
    }
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmación de Orden de Compra | GPEM S.A.C.</title>
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-timeline.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php"); ?>

</head>
<body style="margin-top:100px">
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>
    <div class="container">
        <div class="row mb-3 pb-1">
            <div class="col-12 mb-2">
                <h5 class="fw-bold">CONFIRMACIÓN DEL PEDIDO</h5>
            </div>
            <div class="col-12 mb-1">
                <div class="card card-timeline">
                    <ul class="bs4-order-tracking mb-2 mt-3">
                        <li class="step active">
                            <div><i class="fas fa-check"></i></div> Revisar Pedido
                        </li>
                        <li class="step active">
                            <div><i class="fas fa-check"></i></div> Confirmar Pedido
                        </li>
                        <li class="step">
                            <div><i class="fas fa-check"></i></div> Finalizar Pedido
                        </li>                        
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col-12 mb-3">
                <h5 class="fw-bold">DETALLE DE FACTURACION</h5>
            </div>
            <div class="col-12" id="Message1"></div>
            <div class="col-12 col-md-7 mb-3">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rbBoletaFactura" id="rbBoleta" value="boleta" checked onclick="fnBoletaFactura(1);">
                            <label class="form-check-label" for="rbBoleta">BOLETA DE VENTA</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="radio" name="rbBoletaFactura" id="rbFactura" value="factura" onclick="fnBoletaFactura(2);">
                            <label class="form-check-label" for="rbFactura">FACTURA</label>
                        </div>                     
                    </div>
                </div>
                <div id="factura-container" class="row mb-3 d-none">
                    <div class="col-6">
                        <label for="txtFacRuc" class="m-1">RUC: <small class="text-danger fw-bold">*</small></label>
                        <input type="text" class="form-control" name="txtFacRuc" id="txtFacRuc" value="">
                    </div>
                    <div class="col-6">
                        <label for="txtFacRazonSocial" class="m-1">Razón Social: <small class="text-danger fw-bold">*</small></label>
                        <input type="text" class="form-control" name="txtFacRazonSocial" id="txtFacRazonSocial" value="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="txtFacNombres" class="m-1">Nombres: <small class="text-danger fw-bold">*</small></label>
                        <input type="text" class="form-control" name="txtFacNombres" id="txtFacNombres" value="">
                    </div>
                    <div class="col-6">
                        <label for="txtFacApellidos" class="m-1">Apellidos: <small class="text-danger fw-bold">*</small></label>
                        <input type="text" class="form-control" name="txtFacApellidos" id="txtFacApellidos" value="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6">
                        <label for="txtFacTelefono" class="m-1">Teléfono: <small class="text-danger fw-bold">*</small></label>
                        <input type="text" class="form-control" name="txtFacTelefono" id="txtFacTelefono" value="">
                    </div>
                    <div class="col-6">
                        <label for="txtFacCorreo" class="m-1">Correo Electrónico: <small class="text-danger fw-bold">*</small></label>
                        <input type="text" class="form-control" name="txtFacCorreo" id="txtFacCorreo" value="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="txtFacDireccion" class="m-1">Dirección: <small class="text-danger fw-bold">*</small></label>
                        <input type="text" class="form-control" name="txtFacDireccion" id="txtFacDireccion" value="">
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-12">
                        <label for="txtFacNota" class="m-1">Notas del pedido:</label>
                        <textarea class="form-control" name="txtFacNota" id="txtFacNota" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 text-end">
                        <button class="btn btn-success btn-lg" name="orden" onclick="fnConfirmarPedido(); return false;"><i class="far fa-check-square"></i> CONFIRMAR PEDIDO</button>
                    </div>
                </div>  
            </div>
            <div class="col-12 col-md-5 mb-3">
                <div class="row">
                    <div class="col-12">
                        <h5 class="fw-bold mb-4">MIS PRODUCTOS</h5>
                        <table class="table table-hover">
                            <thead>
                                <tr class="fw-bold">
                                    <td>Producto</td>
                                    <td class="text-center">Cantidad</td>
                                    <td class="text-center">Medida</td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $subtotal=0;
                                $descuento=0;
                                $total=0;
                                if(!empty($_SESSION['car'])){
                                    foreach($_SESSION['car'][1] as $indice=>$producto){
                                        echo "
                                        <tr>
                                            <td>".$producto['producto']."</td>
                                            <td class='text-center'>".$producto['cantidad']."</td>
                                            <td class='text-center'>".$producto['medida']."</td>    
                                        </tr>";
                                    }
                                }else{
                                    echo "<td colspan='3'>No hay productos en el carrito.</td>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="col-12 text-end">
                        <a class="btn btn-secondary" href="/productos" role="button"><i class="fas fa-chevron-left"></i> Seguir comprando</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/mycloud/library/gpemsac/portal/js/orden-compra.js"></script>  
</body>
</html>
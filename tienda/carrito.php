<?php
    session_start();
    include($_SERVER['DOCUMENT_ROOT']."/portal/config/config.php"); 
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bolsa de compras | GPEM S.A.C.</title>
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-timeline.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php"); ?>

</head>
<body class="bg-light" style="margin-top:5.5rem">
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>

    <div class="container mb-5">
        <div class="row mb-4">
            <h3 class="border-bottom mb-3">BOLSA DE COMPRAS</h3>
            <div class="col-12">
                <div class="card card-timeline">
                    <ul class="bs4-order-tracking mb-2 mt-3">
                        <li class="step active">
                            <div><i class="fas fa-check"></i></div> Revisar Pedido
                        </li>
                        <li class="step">
                            <div><i class="fas fa-check"></i></div> Confirmar Pedido
                        </li>
                        <li class="step">
                            <div><i class="fas fa-check"></i></div> Finalizar Pedido
                        </li> 
                    </ul>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col-12">
                <div class="row mb-2">
                    <?php
                    if(!empty($_SESSION['car'])){
                        if(count($_SESSION['car'][1])>0){
                            echo '
                                <div class="col-12">
                                    <p>Los productos de tu bolsa de compras pueden agotarse próximamente. Cómpralos pronto para que no te quedes sin ellos.</p>
                                </div>';
                            foreach($_SESSION['car'][1] as $indice=>$producto){
                                echo '
                                <div class="col-12 bg-white mb-2 p-2">
                                    <div class="row">
                                        <div class="col-12 col-md-8 mb-2">
                                            <div class="row">
                                                <div class="col-4 col-md-2">
                                                    <img src="/mycloud/portal/tienda/productos/'.$producto['imagen'].'" class="img-thumbnail">
                                                </div>
                                                <div class="col-8 col-md-10">
                                                    <p class="text-secondary m-0">'.$producto['marca'].'</p>
                                                    <p class="m-0">'.$producto['producto'].'</p>
                                                    <p class="text-secondary m-0">SKU '.$producto['codigo'].'</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6 col-md-4 text-end mb-0">
                                            <p class="m-0">'.sprintf('%.2f', $producto['cantidad']).'</p>
                                            <p class="m-0">'.$producto['medida'].'</p>
                                        </div>
                                        <div class="col-12 text-end">
                                            <a class="btn text-secondary fs-5 p-0" href="#" role="button" onclick="fnModalUpdateCar('."'".openssl_encrypt($indice, COD, KEY)."', '".$producto['producto']."', '".$producto['medida']."', ".$producto['cantidad'].'); return false;"><i class="far fa-edit"></i></a>
                                            <a class="btn text-secondary fs-5 p-0" href="#" role="button" onclick="fnEliminarProducto('."'".openssl_encrypt($indice, COD, KEY)."'".'); return false;"><i class="far fa-trash-alt"></i></a>                               
                                        </div>
                                    </div>
                                </div>';
                            }                 

                            echo '
                            <div class="col-12 mb-3 text-end">
                                <a href="/productos" class="btn btn-primary btn-lg text-center mb-2" role="button" aria-pressed="true"><i class="fas fa-chevron-left"></i> Agregar más productos</a>
                                <a href="/orden-compra" class="btn btn-success btn-lg text-center mb-2" role="button" aria-pressed="true"><i class="fas fa-shopping-bag"></i> Continuar con mi compra</a>
                            </div>';

                        }else{
                            echo '
                            <div class="col-12 text-center">
                                <h3>Su carrito se encuentra vacío.</h3>
                                <a href="productos" class="btn btn-primary btn-lg text-center" role="button" aria-pressed="true"><i class="fas fa-chevron-left"></i> Continuar explorando</a>
                            </div>';
                        }
                    }else{
                        echo '
                        <div class="col-12 text-center">
                            <h3>Su carrito se encuentra vacío.</h3>
                            <a href="productos" class="btn btn-primary btn-lg text-center" role="button" aria-pressed="true"><i class="fas fa-chevron-left"></i> Continuar explorando</a>
                        </div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalUpdateCar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Modificar Cantidad</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <label for="txtCantidad2" id="lblProducto2" class="form-label">Email address</label>
                    <div class="input-group mb-3">
                        <input type="text" id="txtProducto2" class="d-none" disabled value="">
                        <input type="number" id="txtCantidad2" class="form-control" aria-label="Sizing example input" aria-describedby="txtMedida2">
                        <span class="input-group-text" id="txtMedida2">UNIDAD</span>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <a class="btn btn-primary" href="#" role="button" onclick="fnActualizarCantidad(document.getElementById('txtProducto2').value, document.getElementById('txtCantidad2').value); return false;">Guardar</a>
                </div>
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/mycloud/library/gpemsac/portal/js/mostrarCarrito.js"></script>
    <script>
        //Evitar el reenvio del formulario
        if (window.history.replaceState) { // verificamos disponibilidad
            window.history.replaceState(null, null, window.location.href);
        }
    </script>
</body>
<?php include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html"); ?>
</html>
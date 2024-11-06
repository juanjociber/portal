<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Culqui</title>
    <link rel="stylesheet" href="/tienda/librerias/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/tienda/librerias/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/tienda/librerias/gpemsac/img/favicon.ico">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="card text-center">
                    <div class="card-header">
                        Featured
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <label for="txtProducto">Productos</label>
                                <input type="text" id="txtProducto" class="form-control">
                            </div>
                            <div class="col-4">
                                <label for="txtPrecio">Precio</label>
                                <input type="text" id="txtPrecio" class="form-control">
                            </div>
                            <div class="col-4">
                                <button id="buyButton" class="btn btn-success">Comprar</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        2 days ago
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="/tienda/librerias/jquery-3.5.1/jquery-3.5.1.min.js"></script>
    <script src="/tienda/librerias/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="https://checkout.culqi.com/js/v3"></script>
    <script>

        var producto="";
        var precio="";
        

        $('#buyButton').on('click', function(e) {
            // Abre el formulario con la configuración en Culqi.settings
            producto=document.getElementById("txtProducto").value;
            precio=document.getElementById("txtPrecio").value*100;
            Culqi.publicKey = 'sk_test_e4af8aa6a21b1995';
                
            Culqi.settings({
                title: 'GPEMSAC Store',
                currency: 'PEN',
                description: producto,
                amount: precio
            });


            Culqi.open();
            e.preventDefault();
        });

        function culqi() {
            if (Culqi.token) { // ¡Objeto Token creado exitosamente!
                var token = Culqi.token.id;
                var email = Culqi.token.email;
                //alert('Se ha creado un token:' + token);
                //En esta linea de codigo debemos enviar el "Culqi.token.id"
                //hacia tu servidor con Ajax
                $.ajax({
                    url:"../modulos/insert/ProcesarPago.php",
                    type:"POST",
                    data:{
                        producto:producto,
                        precio:precio,
                        token:token,
                        email:email
                    }
                }).done(function(resp){
                    alert(resp)
                });
            } else { // ¡Hubo algún problema!
                // Mostramos JSON de objeto error en consola
                console.log(Culqi.error);
                alert(Culqi.error.user_message);
            }
        };
    </script>
</body>
</html>
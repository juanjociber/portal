<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitud enviada - GPEMSAC</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../librerias/css/menu.css">
    <link rel="stylesheet" href="../librerias/css/gpemsac.css">

    <?php include('menu/navbar.php'); ?>
    
</head>
<body class="bg-light" style="margin-top:100px;">
    <section>
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h3 class="text-center">Cotización solicitada.</h3>
                    <hr>
                    <p class="text-center lead">Se ha enviado correctamente su solicitud a nuestro centro de cotizaciones. En breves un personal nuestro le enviara su cotizacion y se pondra en contacto con Usted. </p>
                    <h4 class="display-4 text-center">Muchas Gracias.</h4>
                </div>
                <div class="col-12 text-center mb-5">
                    <a href="productos.php" class="btn btn-primary btn-lg" role="button" aria-pressed="true">CONTINUAR EXPLORANDO</a>
                </div>
            </div>
        </div>
    </section>

     <?php include('menu/footer.html'); ?>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/44f4eb5be4.js" crossorigin="anonymous"></script>
    
    <script>		
		$(document).ready(function () {
			$('#menu-carrito').addClass('activar-menu');
		});
    </script>
</body>
</html>
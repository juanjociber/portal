<?php 
     session_start();
     if(empty($_SESSION['quiz'][0]['encuesta'])){
         header("location: https://gpemsac.com");
         exit();
     }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Encuesta de satisfacción del Cliente | GPEM SAC.</title>
    <!--
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css"/>
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">-->

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="../../librerias/css/menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script src="https://kit.fontawesome.com/44f4eb5be4.js" crossorigin="anonymous"></script>


    <?php 
        //include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php");
        include($_SERVER['DOCUMENT_ROOT']."/pages/menu/navbar.php");
    ?>

</head>
<body style="margin-top:7rem">
    <div class="container bg-light p-4 mb-5">
        <div class="row mb-5">
            <div class="col-12 text-center mb-5">
                <h5 class="display-4 mb-5">Muchas Gracias por participar en esta encuesta.</h5>
                <h3 class="text-primary">Su opinión es muy importante para nosotros.</h3>
            </div>
            <div class="col-12 text-center">
                <a class="btn btn-primary btn-lg" href="https://gpemsac.com" role="button">ACEPTAR</a>
            </div>
        </div>
    </div>
</body>
<?php 
    //include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html");
    include($_SERVER['DOCUMENT_ROOT']."/pages/menu/footer.html");
?>

</html>
<?php 
    unset($_SESSION["car"]);
    session_destroy();
?>
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Limpieza y desinfección - GPEMSAC</title>

    <meta property="og:site_name" content="GPEM SAC"/>
    <meta property="og:type" content="article">
    <meta property="og:url" content="http://gpemsac.com/portal/pages/servicios/limpieza">
    <meta property="og:title" content="GPEM - Limpieza y desinfección">
    <meta property="og:description" content="En GPEM SAC Somos especialistas en limpieza e imágen de activos, la primera imágen, la más Importante."/>
    <meta property="og:image" content="http://gpemsac.com//mycloud/files/portal/servicios/limpieza01.jpg"/>

    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-whatsapp.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php");?>

</head>
<body style="margin-top:100px; background:#f7f7f7">

    <div class="wa-container-float">
        <a href="https://api.whatsapp.com/send?phone=51967829341&text=https://gpemsac.com%0D%0A%0D%0A🙋%E2%80%8D♂%EF%B8%8F%20Hola,%20¿podría%20brindarme%20más%20información%20de%20este%20servicio?" target="_blank">
            <img class="wa-button-float" src="/mycloud/portal/empresa/logos/wa-icon.png" alt="">
        </a>
    </div>

    <div class="container pb-3">
        <div class="row mb-3">
            <h4 class="fw-bold">LIMPIEZA Y DESINFECCIÓN</h4>
        </div>
        <div class="row bg-white">
            <div class="col-12 mb-3">
                <img src="/mycloud/files/portal/servicios/limpieza01.jpg" class="rounded mx-auto d-block img-fluid mb-3" alt="...">
                <ul>
                    <li>Somos especialistas en limpieza e imagen de activo. La primera imagen, la mas importante.</li>
                    <li>Limpieza automotriz en vehículos livianos y pesados.</li>
                    <li>Limpieza de maquinaria y equipos.</li>
                    <li>Limpieza de bienes muebles e inmuebles.</li>
                </ul>
            </div>
        </div>
        <div class="row">
            <div class="col-12 text-end mb-3 pr-4">
                <h4><a class="text-decoration-none text-primary fw-bold" href="http://www.facebook.com/sharer.php?u=https://gpemsac.com/portal/pages/servicios/limpieza" target="_blank" class="ml-5">Compartir <i class="fab fa-facebook"></i></a></h4>   
            </div>
        </div>
    </div>
    
    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>    
    <script>
         window.onload = async function(){
            document.getElementById('menu-servicios').classList.add('active','fw-bold');
            document.getElementById('submenu-limpieza').classList.add('active','fw-bold');
        };
    </script>
</body>

<?php include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html");?>

</html>
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blogs - GPEMSAC</title>
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php");?>

</head>
<body class="bg-light" style="margin-top:100px;">
    <div class="container mb-5">
        <h3 class="fw-bold">NOTICIAS</h3>
        <p class="lead">Ponte al día con nuestras publicaciones.</p>
        <hr>
        <div class="row">
            <!--Articulos-->
            <div class="col-12">
                <!--1er Artículo-->
                <div class="row mb-5 bg-white p-4">
                    <div class="col-12">
                        <p>21 de abril de 2020</p>
                    </div>
                    <div class="col-3 d-none d-lg-block">
                        <img src="/mycloud/portal/empresa/blogs/generador-electrico.jpg" alt="" class="img-fluid">
                    </div>
                    <div class="col-12 col-md-9">
                        <a href="/blogs/como-usar-un-generador-electrico"><h3>Uso y mantenimiento de un generador eléctrico para evitar daños: Pasos para su uso</h3></a>
                        <p>Recomendaciones muy claras sobre cómo utilizar un generador eléctrico, además de un paso a paso de la puesta de marcha y consejos para el mantenimiento del mismo.</p>
                        <a href="/blogs/como-usar-un-generador-electrico" class="btn btn-warning btn-sm text-white">Leer más ...</a>
                    </div>
                </div>
                <!--Fin 1er Artículo-->
                <!--2do Artículo-->
                <div class="row mb-5 bg-white p-4">
                    <div class="col-12">
                        <p>21 de abril de 2020</p>
                    </div>
                    <div class="col-3 d-none d-lg-block">
                        <img src="/mycloud/portal/empresa/blogs/mantto-preventivo.jpg" alt="" class="img-fluid">
                    </div>
                    <div class="col-12 col-md-9">
                        <a href="/blogs/beneficios-del-mantenimiento-preventivo"><h3>Beneficios del Mantenimiento Preventivo</h3></a>
                        <p>El mantenimiento preventivo disminuyen los correctivos.</p>
                        <a href="/blogs/beneficios-del-mantenimiento-preventivo" class="btn btn-warning btn-sm text-white">Leer más ...</a>
                    </div>
                </div>
                <!--Fin 2do Artículo-->
            </div>
            <!--Fin Articulos-->
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = async function(){
            document.getElementById('menu-blogs').classList.add('active','fw-bold');
        };
    </script>
</body>

<?php include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html");?>
</html>
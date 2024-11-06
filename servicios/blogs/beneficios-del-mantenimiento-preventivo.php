<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beneficios del Mantenimiento Preventivo - GPEMSAC</title>

    <meta name="description" content="Los generadores eléctricos son dispositivos muy útiles ya que siempre nos sacan de apuros como por ejemplo, cuando se produce un corte de electricidad porque la red eléctrica local ha fallado, o simplemente cuando lo necesitamos debido a que donde estamos no hay electricidad, dígase en el bosque, en una casa campestre">

    <!-- /snippets/social-meta-tags.liquid -->
    <meta property="og:site_name" content="GPEM SAC">
    <meta property="og:url" content="https://gpemsac.com/blogs/beneficios-del-mantenimiento-preventivo"/>
    <meta property="og:title" content="Beneficios del Mantenimiento Preventivo">
    <meta property="og:type" content="article">
    <meta property="og:description" content="El mantenimiento preventivo disminuyen los correctivos.">    
    <meta property="og:image" content="https://gpemsac.com/portal/empresa/blogs/mantto-preventivo.jpg"/>
    <meta property="og:image:width" content="500"/>
    <meta property="og:image:height" content="450"/>

    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php");?>

</head>
<body class="bg-light" style="margin-top:100px;">
    <section>
        <div class="container pb-3 mb-5 bg-white">
            <div class="row">
                <div class="12 p-3">
                    <p>22 de abril de 2020</p>
                </div>
                <div class="12 p-3">
                    <h4 class="font-weight-bold">Beneficios del Mantenimiento Preventivo</h4>
                    <p><b>El mantenimiento preventivo de los equipos de producción de una empresa ayuda a disminuir considerablemente la necesidad de llevar a cabo mantenimientos correctivos.</b> Como todos sabemos, el costo del mantenimiento correctivo a un equipo es mucho mayor que los costos implicados en los mantenimientos preventivos por lo que es importante tener un plan de mantenimientos preventivos para toda la empresa.</p>
                    <img src="/mycloud/portal/empresa/blogs/mantto-preventivo.jpg" class="rounded mx-auto d-block img-fluid" alt="...">
                </div>
                <div class="col-12 text-right p-3">
                    <style>
                        .a-size{
                            font-size:25px;
                        }
                    </style>
                        <a class="text-secondary">Compartir </a>
                        <a href="http://www.facebook.com/sharer.php?u=https://gpemsac.com/blogs/beneficios-del-mantenimiento-preventivo" target="_blank" class="text-secondary a-size ml-5"><i class="fab fa-facebook"></i></a>
                        <!--<a href="#" class="text-secondary a-size ml-3"><i class="fab fa-twitter-square"></i></a>
                        <a href="#" class="text-secondary a-size ml-3"><i class="fab fa-pinterest-square"></i></a>-->
                </div>
            </div>
        </div>
        <div class="container mb-5">
            <div class="col-12 text-center">
                <a href="/blogs">
                    <h4 class="font-weight-bold"><i class="fas fa-long-arrow-alt-left"></i> VOLVER A NOTICIAS</h4>
                </a>    
            </div>
        </div>
    </section>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        window.onload = async function(){
            document.getElementById('menu-blogs').classList.add('active','fw-bold');
        };
    </script>
</body>
<?php include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html");?>
</html>
<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Telemetría | GPEM SAC.</title>
    <meta name="application-name" content="Portal Web de GPEM SAC.">
    <meta name="description" content="En GPEM SAC apostamos por tu crecimiento profesional, te damos herramientas y capacitaciones constantes para alcanzar tu mejor versión">
    <meta name="author" content="GPEM S.A.C.">
    <meta name="keywords" content="certificados, ABE, talento, beneficios, convenios, familia, postula aquí, portula aqui">

    <meta property="og:site_name" content="Portal Web de GPEM SAC."/>
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://gpemsac.com/servicios/sistema-de-telemetria">
    <meta property="og:title" content="Somos una Empresa certificada por ABE">
    <meta property="og:description" content="En GPEM SAC apostamos por tu crecimiento profesional, te damos herramientas y capacitaciones constantes para alcanzar tu mejor versión"/>
    <meta property="og:image" content="https://gpemsac.com/mycloud/portal/empresa/logos/logo-gpem.jpg"/>

    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">


    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php");?>
</head>
<body class="bg-light" style="margin-top:90px;">
    <div class="container">

        <div class="row mb-3">
            <div class="col-12 text-center">
                <div class="d-none d-sm-block">
                    <img src="/mycloud/portal/empresa/trabaja/trabaja-con-nosotros-gpemsac-pc.jpg" class="img-fluid rounded" width="100%" alt="Trabaja con nosotros Promovemos la igualdad de oportunidades"><!--PC-->
                </div>
                <div class="d-sm-none">
                    <img src="/mycloud/portal/empresa/trabaja/trabaja-con-nosotros-gpemsac-movil.jpg" class="img-fluid rounded" width="100%" alt="Trabaja con nosotros Promovemos la igualdad de oportunidades"><!--Movil-->
                </div>
            </div>
        </div>
        
        <div class="row mb-3">
            <div class="col-12 text-center">
                <h3>¿Por qué trabajar en <span class="fw-bold">GPEM SAC</span>?</h3>
            </div>
        </div>

        <div class="row row-cols-md-3 g-4 mb-4">
            <div class="col">
                <div class="card h-100">
                    <img src="/mycloud/portal/empresa/trabaja/trabaja-con-nosotros-certificaciones.jpg" class="card-img-top" alt="Trabaja con nosotros Certificaciones">
                </div>
            </div>
            <div class="col">
                <div class="card h-100">
                    <img src="/mycloud/portal/empresa/trabaja/cultivamos-el-talento-trabaja-con-nosotros.jpg" class="card-img-top" alt="Trabaja con nosotros Cultivamos el talento">
                </div>
            </div>            
            <div class="col">
                <div class="card h-100">
                    <img src="/mycloud/portal/empresa/trabaja/trabaja-con-nosotros-gpemsac-beneficios-y-convenios.jpg" class="card-img-top" alt="Trabaja con nosotros GPEM SAC beneficion y convenios">
                </div>
            </div>           
        </div>

        <div class="row mb-2">
            <div class="col-12 text-center mb-3">
                <h3>¿Cómo trabajar en GPEM SAC?</h3>
                <h3 class="fw-bold">¡ Muy Fácil !</h3>
            </div>
            <div class="col-12 text-center mb-3">
                <h5 class="fw-bold">Llena tus datos y nos pondremos en contacto lo antes posible</h5>
            </div>
            <div class="col-12 text-center mb-4">
                <a class="btn btn-primary btn-lg fw-bold" href="https://forms.gle/q7PeA2Z9FVk2EDQ49" role="button" target="_blank">POSTULA AQUÍ <i class="fas fa-hand-point-up"></i></a>
            </div>
        </div>

    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>

    <script>
         window.onload = async function(){
            document.getElementById('menu-empresa').classList.add('active','fw-bold');
            document.getElementById('submenu-trabaja').classList.add('active','fw-bold');
        };
    </script>

    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html");?>
</body>
</html>
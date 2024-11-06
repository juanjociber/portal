<?php 
    session_start(); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Conoce nuestra política del sistema de salud - GPEMSAC</title>

    <meta name="application-name" content="Portal Web de GPEM S.A.C">
    <meta name="description" content="Conoce nuestra Política integrada del sistema de Gestión de de calidad, seguridad, salud ocupacional y medio ambiente">
    <meta name="author" content="GPEM S.A.C.">

    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://gpemsac.com"/>
    <meta property="og:image" content="https://gpemsac.com/mycloud/portal/empresa/logos/logo-gpem.jpg"/>
    <meta property="og:description" content="Somos especialistas en gestión de procesos eficientes en mantenimiento y operaciones."/>
    <meta property="og:site_name" content="GPEM SAC"/>

    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">

    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php");?>

</head>
<body class="bg-light" style="margin-top:100px;">
    <div class="container mb-4 pb-4">
        <div class="row">
            <div class="col-12 text-center">
                <img src="/mycloud/portal/empresa/politica/politica-integrada-del-sistema-de-gestion.jpg" class="img-fluid" alt="politica integrada del sistema de gestion">
            </div>
        </div>
        <!--
        <div class="row">
            <div class="col-12 border border-warning p-2" style="height: 100vh;">
                <object data="downloads/DescargarPoliticaSSOMA.php?file=politica-sistema-integrado-de-salud.pdf" type="application/pdf" width="100%" height="100%">
                    <p>It appears you do not have a PDF plugin for this browser. No biggie... you can <a href="downloads/DescargarPoliticaSSOMA.php?file=politica-sistema-integrado-de-salud.pdf">click here to download the PDF file.</a></p>
                </object>
            </div>
        </div>--> 
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script>
        window.onload = async function(){
            document.getElementById('menu-empresa').classList.add('active','fw-bold');
            document.getElementById('submenu-politica').classList.add('active','fw-bold');
        };
    </script>
</body>
<?php include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html");?>
</html>
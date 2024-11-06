<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="application-name" content="Portal Web de GPEM S.A.C">
    <meta name="description" content="GPEM SAC brinda soluciones de energía para los sectores de la industria, minería, construcción, equipos auxiliares marinos y offshore; atendemos necesidades estándares y específicas de acuerdo a su necesidad.">
    <meta name="author" content="GPEM S.A.C.">
    <meta name="keywords" content="Grupo, Grupos, Electrógenos, Electrógeno, Respaldo, Energía, Prime, Stand By, Continuo, Régimen, Alquiler, C135D6, C125D6, 100 KW, 120 KW, Tableros, Sub estaciones, Casa fuerza, 100kw, 100KVA, 120KVA, Trifasico, 220 V, 220 VAC, 380 v, 380 VAC, 440 VAC, 440 V, 60 Hz, Stamford, Alternador">

    <!-- Open Graph data -->
    <meta property="og:title" content="Gestion de Procesos Eficientes de Mantenimiento" />
    <!--<meta property="og:type" content="article"/>-->
    <meta property="og:type" content="website"/>
    <meta property="og:url" content="https://gpemsac.com"/>
    <meta property="og:image" content="https://gpemsac.com/mycloud/logos/logo-gpem.jpg"/>
    <meta property="og:image:width" content="256"/>
    <meta property="og:image:height" content="256"/>
    <meta property="og:description" content="GPEM SAC brinda soluciones de energía para los sectores de la industria, minería, construcción, equipos auxiliares marinos y offshore; atendemos necesidades estándares y específicas de acuerdo a su necesidad."/>
    <meta property="og:site_name" content="GPEM SAC"/>
    <!--<meta property="article:section" content="productos cummins"/>-->
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Energía - GPEMSAC</title>

    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-whatsapp.css">
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">

    
    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php");?>

</head>
<body class="bg-light" style="margin-top:100px;">

    <div class="wa-container-float">
        <a href="https://api.whatsapp.com/send?phone=51967829341&text=https://gpemsac.com%0D%0A%0D%0A🙋%E2%80%8D♂%EF%B8%8F%20Hola,%20¿podría%20brindarme%20más%20información%20sobre%20este%20servicio?" target="_blank">
            <img class="wa-button-float" src="/mycloud/portal/empresa/logos/wa-icon.png" alt="">
        </a>
    </div>

    <div class="container bg-white p-3 mb-3">
        <div class="row mb-3">
            <div class="col-12">
                <h3 class="fw-bold">ENERGIA</h3>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <p>GPEM SAC brinda soluciones de energía para los sectores de la industria, minería, construcción, equipos auxiliares marinos y offshore; atendemos necesidades estándares y específicas de acuerdo a su necesidad.</p>
                <p>Contamos con área de servicio especializada las 24 horas del día los 365 días del año, con disponibilidad de repuestos e insumos para lograr la mayor confiabilidad, disponibilidad y óptimo costo. Trabajamos con las marcas más reconocidas del mercado como Cummins Power Generation entre otras.</p>
            </div>
            <div class="col-12 mb-4">
                <div class="ratio ratio-16x9" style="border:double; color:#ff9a00">
					<iframe src="https://www.youtube.com/embed/-I5D_9wIG5U" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
				</div>
			</div>
            <div class="col-12">
                <h5 class="font-weight-bold">Ponemos a su disposición:</h5>
                <ul>
                    <li class="p-1">Grupos Electrógenos Diesel y Gas Natural.</li>
                    <li class="p-1">Alquiler de Grupos Electrógenos.</li>
                    <li class="p-1">Servicio de Mantenimiento y Diagnóstico.</li>
                    <li class="p-1">Fabricación de Tableros.</li>
                    <li class="p-1">Monitoreo remoto, telemetría y GPS.</li>
                </ul>
            </div>
            <div class="col-12 p-4">
                <h5 class="font-weight-bold mb-3">Características de nuestros equipos:</h5>
                <table class="table table-hover mb-4">
                    <tbody>
                        <tr>
                            <td><b>GENERADORES</b></td><td>RÉGIMEN PRIME O STAND BY</td>
                        </tr>
                        <tr>
                            <td><b>MARCA</b></td><td>CUMMINS</td>
                        </tr>
                        <tr>
                            <td><b>POTENCIA</b></td><td>135KW</td>
                        </tr>
                        <tr>
                            <td><b>MODELO</b></td><td>C135 D6</td>
                        </tr>
                        <tr>
                            <td><b>MOTOR</b></td><td>CUMMINS 6BTAA5.9-G6</td>
                        </tr>
                        <tr>
                            <td><b>CONTROLADOR</b></td><td>PC1.2</td>
                        </tr>
                        <tr>
                            <td><b>ALTERNADOR</b></td><td>STAMFORD UC22</td>
                        </tr>
                    </tbody>
                </table>
                <p>Suministramos e instalamos grupos electrógenos a través de la venta consultiva de las principales marcas del mercado, con altos estándares de calidad y de garantía postventa que asegura el retorno de su inversión a la medida de las necesidades del cliente.</p>
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <script>
        window.onload = async function(){
            document.getElementById('menu-energia').classList.add('active','fw-bold');
        };
    </script>
</body>

<?php include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html");?>

</html>
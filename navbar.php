<style>
  #search::placeholder{
    color: #929292;
    font-weight:300 !important;
  }
  @media(min-width:992px){
    .navbar-expand-lg .navbar-collapse{
      justify-content:space-between !important;
    }
  }
  .navbar-dark .navbar-toggler{
    border: unset;
    color: transparent;
  }
  .navbar.scrolled{
    box-shadow:1px 0px 18px #a0a0a0;
  }

  .contenedor-datos{ padding: 20px; padding-left:0;padding-top:0; }
  .contenedor-datos p, .contenedor-datos a, .contenedor-datos span{ color: #757575 !important; font-size:1.1rem; margin-left:10px; }
  .contenedor-datos p{ margin-left:0; }
  @media(min-width:768px){.contenedor-datos{display: flex; justify-content: space-between;}}
  @media(min-width:992px){ .contenedor-datos{ display:none; }}

  /** MENÚ */
  .menu-toggle {
    width: 30px;
    height: 19px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    cursor: pointer;
    position: relative;
    transition: transform 0.3s ease-in-out;
  }
  .bar {
    width: 100%;
    height: 2px;
    background-color: #a5a3a3;
    border-radius: 2px;
    transition: all 0.3s ease-in-out;
  }
  .menu-toggle.active .bar:nth-child(1) {
    transform: translateY(9px) rotate(45deg);
  }
  .menu-toggle.active .bar:nth-child(2) {
    opacity: 0;
  }
  .menu-toggle.active .bar:nth-child(3) {
    transform: translateY(-9px) rotate(-45deg);
  }

  /** BUSCADOR */
  .buscador-container {
    position: relative;
    margin: 0 auto; 
  }
  @media(min-width: 768px){
    .resultado{
      top:40px;
    }
  }
  @media(min-width: 992px){
    .resultado{
      top:40px !important;
    }
  }
  @media(min-width: 1200px){
    .resultado{
      top:43px !important;
    }
  }
  .resultado {
    position: absolute;
    z-index:999;
    width: 100%; 
    background-color: white;
    border: 1px solid #ccc;
    max-height: 300px;
    overflow-y: auto;
    display: none; 
    top:50px;
  }
  .resultado-item {
    padding: 10px;
    border-bottom: 1px solid #ddd;
    cursor: pointer;
    display: flex;
    align-items: center;
  }
  .resultado-item img {
    width: 50px;
    height: 50px;
    margin-right: 10px;
  }
  .resultado-item:hover {
    background-color: #f0f0f0;
  }

</style>

<link rel="shortcut icon" href="/mycloud/logos/favicon.ico">
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-menu">
  <div class="container-fluid">
    <a class="navbar-brand p-0" href="/index.php"><img src="/mycloud/portal/empresa/logos/logo-gpem.png" height="50" class="d-inline-block align-top" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <div class="menu-toggle" id="menu-toggle">
        <div class="bar"></div>
        <div class="bar"></div>
        <div class="bar"></div>
      </div>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <style>
      @media(max-width:991px){ .input-buscar form input{ padding: .675rem .75rem !important; }.input-buscar form button{top:5px;} }
      </style>
      <div class="w-100 input-buscar mt-4 mt-md-0">
        <form class="d-flex position-relative" action="/productos" method="GET">
          <input class="form-control" type="text" name="search" id="search" placeholder="Buscar suministro de componentes y repuestos" aria-label="Search">
          <button class="nav-item__button position-absolute" style="background: transparent;border: unset; color: #bcbcbc;right: 0;font-size: 25px;" type="submit"><i class="fa fa-search" style="line-height: 1; color: #13316c"></i></button>
          <div id="resultado" class="resultado"></div>
        </form>
      </div>
      <ul class="navbar-nav navbar-nav--mod mb-2 mb-lg-0 navbar-nav-scroll">
        <!-- <li class="nav-item">
          <a class="nav-link menu01" id="menu-inicio" href="/">INICIO <span class="sr-only">(current)</span></a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link fw-bold menu01" id="menu-productos" href="/productos">PRODUCTOS</a>
        </li>
        <li class="nav-item dropdown mt-2 mt-md-0">
          <a class="nav-link dropdown-toggle" href="#" id="menu-servicios" role="button" data-bs-toggle="dropdown" aria-expanded="false">SERVICIOS</a>
          <ul class="dropdown-menu" style="min-width: 20rem !important" aria-labelledby="menu-servicios">
            <!-- <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-mantenimiento" href="/servicios/gestion-de-mantenimiento-de-flotas-y-equipos">GESTION DE MANTENIMIENTO - En equipos y flotas vehiculares</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-allison" href="/servicios/service-dealer-allison-transmision">ALLISON - Dealer servicio y repuestos</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-cummins" href="/servicios/taller-autorizado-de-cummins">CUMMINS - Dealer Independiente</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-prestolite" href="/servicios/distribuidor-directo-de-prestolite">PRESTOLITE - Distribuidor directo en Perú</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-pentarkloft" href="/servicios/distribuidor-autorizado-pentar-kloft">PENTAR KLOFT - Distribuidor autorizado en Perú</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-telemetria" href="/servicios/sistema-de-telemetria">TELEMETRIA - Plataforma integrada de Gestión de Flotas</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-lubricacion" href="/servicios/servicio-de-lubricacion">LUBRICACION - Análisis de aceite y monitoreo</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-pintado" href="/servicios/servicio-de-pintado">PINTURA - Servicio de pintado automotríz</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-importacion" href="/servicios/importacion-y-acondicionamiento-de-equipos-usados">Importación y acondicionamiento de equipos usados</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-infraestructura" href="/servicios/mantenimiento-de-infraestructuras">Mantenimiento de infraestructuras</a></li> -->
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-cummins" href="/servicios/in-houser-o-por-proyectos">IN HOUSE O POR PROYECTOS</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-cummins" href="/servicios/servicio-taller">SERVICIO TALLER</a></li>
            <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-cummins" href="/servicios/auxilio-mecanico-o-emergencias">AUXILIO MECÁNICO O EMERGENCIAS</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="menu-empresa" role="button" data-bs-toggle="dropdown" aria-expanded="false">MUNDO GPEM</a>
          <ul class="dropdown-menu" style="min-width: 20rem !important" aria-labelledby="menu-empresa">
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-nosotros" href="/empresa/nosotros">ACERCA DE NOSOTROS</a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-trabaja" href="/empresa/trabaja-con-nosotros">BOLSA DE TRABAJO</a></li>
            <!-- <li class="mt-2"><a class="dropdown-item fw-bold" style="white-space: normal" id="submenu-politica" href="/empresa/politica">Política del Sistema Integrado de Gestión</a></li> -->
          </ul>
          <!--<div class="dropdown-menu" aria-labelledby="menu-empresa">
            <a class="dropdown-item submenu01 mt-2" id="submenu-nosotros" href="https://gpemsac.com/pages/nosotros.php">Nosotros</a>
            <a class="dropdown-item submenu01 mt-2" id="submenu-politica" href="https://gpemsac.com/pages/politica.php">Política Integrada del sistema de Gestión de calidad, seguridad, salud ocupacional y medio ambiente</a>
          </div>-->
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link menu01" id="menu-energia" href="/servicios/energia">ENERGIA</a>
        </li> -->
        <li class="nav-item">
          <a class="nav-link menu01" id="menu-contactanos" href="/servicios/contactanos">CONTÁCTANOS</a>
        </li>

        <li class="nav-item" style="width:60px;">
          <a class="nav-link menu01" id="menu-carrito" href="/carrito"><i class="fas fa-shopping-cart"></i> (<?php echo (empty($_SESSION['car'][1]))?0:count($_SESSION['car'][1]);?>) 
            <span class="sr-only">(current)</span>
          </a>
        </li>
        <!-- <li class="nav-item">
            <a class="nav-link menu01" id="menu-blogs" href="/blogs">BLOG</a>
        </li> -->
      </ul>

      <!-- <div class="contenedor-datos">
        <div class="telefono d-flex align-items-center mb-3">
          <div class="telefono-ubicacion">
            <p>¿Necesitas ayuda?</p>
            <div class="icon-telefono"><i class="fa fa-phone-alt text-secondary"></i><span style="font-weight:300 !important;">01-7130628 (300)</span></div>
          </div>
        </div>
        <div class="celular d-flex align-items-center mb-3">
          <div class="celular-ubicacion">
            <p>¿Tienes alguna pregunta?</p>
            <div class="icon-celular"><i class="fa fa-mobile-alt text-secondary"></i> <a href="tel:+51982827525" style="font-weight:300 !important; text-decoration:none; color:#ffffff;">+51982827525</a></div>
          </div>
        </div>
        <div class="email d-flex align-items-center mb-3">
          <div class="correo-ubicacion">
            <p>Envíenos un mesaje a:</p>
            <div class="icon-email"><i class="fa fa-envelope text-secondary"></i><a href="mailto:hola@gpemsac.com" style="font-weight:300 !important; text-decoration:none; color:#ffffff;">hola@gpemsac.com</a></div>
          </div>
        </div>
      </div> -->

      <!-- <ul class="navbar-nav mb-2 mb-lg-0 menu-gpem">
        <div class="dropdown">
          <a class="btn btn-warning text-white dropdown-toggle" href="#" role="button" id="menu-aplicaciones" data-bs-toggle="dropdown" aria-expanded="false">
              APLICACIONES CLIENTES
          </a>
          <div class="dropdown-menu" aria-labelledby="menu-aplicaciones">
            <a class="dropdown-item" href="/gesmannet/" target="_blank">ANÁLISIS DE LUBRICANTES</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item" href="https://my1442.geotab.com/gpem/#map" target="_blank">TELEMETRÍA</a>
          </div>
        </div>
      </ul> -->
    </div>
  </div>
</nav>

<script>
  let buscarInput = document.getElementById('search');
  let resultadoContainer = document.getElementById('resultado');
  let buscadorContainer = document.querySelector('.buscador-container');

  buscarInput.addEventListener('input', function() {
    const query = this.value;

    if (query.length > 2) { 
      fetch('/buscador/buscar.php?q=' + query)
        .then(response => response.json())
        .then(data => {
          resultadoContainer.innerHTML = ''; 
          if (data.length > 0) {
            resultadoContainer.style.display = 'block';
            data.forEach(item => {
              const div = document.createElement('div');
              div.classList.add('resultado-item');
              div.innerHTML = `
                <img src="http://gpemsac.com/mycloud/portal/tienda/productos/${item.imagen}">
                <div>
                  <span>${item.marca}</span><br>
                  <strong>${item.producto}</strong><br>
                  <span>${item.medida}</span>
                </div>`;
              resultadoContainer.appendChild(div);
            });
          } else {
            resultadoContainer.style.display = 'none';
          }
      });
    } else {
      resultadoContainer.innerHTML = '';
      resultadoContainer.style.display = 'none';
    }
  });

  document.addEventListener('click', function(event) {
    console.log(event);
    if (!buscadorContainer.contains(event.target)) {
      resultadoContainer.innerHTML = '';
      resultadoContainer.style.display = 'none';
      buscarInput.value = '';
    }
  });
</script>
<style>
  #search::placeholder{
    color: #5a5a5a;
    font-weight:200 !important;
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

</style>

<link rel="shortcut icon" href="/mycloud/logos/favicon.ico">
<nav class="navbar navbar-expand-lg fixed-top navbar-dark bg-menu">
  <div class="container-fluid">
    <a class="navbar-brand p-0" href="/index.php"><img src="/mycloud/portal/empresa/logos/logo-gpem.png" height="50" class="d-inline-block align-top" alt=""></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <i class="fa fa-bars" style="color: #13316c; font-size:30px;"></i>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav navbar-nav--mod mb-2 mb-lg-0 navbar-nav-scroll">
        <!-- <li class="nav-item">
          <a class="nav-link menu01" id="menu-inicio" href="/">INICIO <span class="sr-only">(current)</span></a>
        </li> -->
        <li class="nav-item dropdown">
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
            <a class="nav-link fw-bold menu01" id="menu-productos" href="/productos">PRODUCTOS</a>
        </li> -->
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
      <div class="w-100">
        <form class="d-flex position-relative" action="/productos" method="GET">
          <input class="form-control" type="text" name="search" id="search" placeholder="Encuentra los mejores aceites y repuestos aquí" aria-label="Search">
          <button class="nav-item__button position-absolute" style="background: transparent;border: unset; color: #bcbcbc;right: 0;font-size: 25px;" type="submit"><i class="fa fa-search" style="line-height: 1; color: #13316c"></i></button>
        </form>
      </div>
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
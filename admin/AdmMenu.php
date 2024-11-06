<link rel="shortcut icon" href="/mycloud/icos/favicon.ico">

<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-secondary">
  <div class="container-fluid">
        <a class="navbar-brand p-0" href="/portal/admin/AdmProductos.php">
          <img src="/mycloud/portal/empresa/logos/logo-gpem.png" alt="" height="40">
        </a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll" aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarScroll">
      <ul class="navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll" style="--bs-scroll-height: 250px;">
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="MenuProductos" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">PRODUCTOS</a>
          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">            
            <li><a class="dropdown-item" id="MenuProductosCotizador" href="/portal/cotizador/admin/Productos.php">COTIZADOR</a></li>
            <li><a class="dropdown-item" id="MenuProductosPaginaWeb" href="/portal/admin/AdmProductos.php">PAGINA WEB</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="MenuCotizaciones" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">COTIZACIONES</a>
          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <li><a class="dropdown-item" id="MenuCotizacionesCotizador" href="/portal/cotizador/Cotizaciones.php">COTIZADOR</a></li>
            <li><a class="dropdown-item" id="MenuCotizacionesPaginaWeb" href="/portal/admin/AdmPedidos.php">PAGINA WEB</a></li>            
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" id="MenuReportes" href="#" id="navbarScrollingDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">REPORTES</a>
          <ul class="dropdown-menu" aria-labelledby="navbarScrollingDropdown">
            <li><a class="dropdown-item" id="MenuReportesProductosPorCotizaciones" href="/portal/cotizador/reportes/ProductosPorCotizacion.php">PRODUCTOS X COTIZACION</a></li>           
          </ul>
        </li>
        <li class="nav-item">
          <a class="nav-link" id="MenuClientes" aria-current="page" href="/portal/cotizador/Clientes.php">CLIENTES</a>
        </li>
      </ul>
      <ul class="navbar-nav me-auto">
        <li class="nav-item">
          <a class="btn text-white btn-outline-primary btn-sm" href="/productos" role="button" target="_blank">PUBLIC</a>
        </li>
      </ul>
      <span class="navbar-text">
            <a class="btn btn-outline-danger btn-sm" href="/portal/admin/salir.php" role="button"><?php echo $_SESSION['vgnombre'];?> <i class="fa fa-user-times" aria-hidden="true"></i></a>
        </span>
    </div>
  </div>
</nav>


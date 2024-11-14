
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
    background-color: #f1f1f1;
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
      top:38px !important;
    }
  }
  @media(min-width: 1200px){
    .resultado{
      top:36.5px !important;
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
    top: 47px;
    padding: 10px;
    border-bottom-left-radius: 5px;
    border-bottom-right-radius: 5px;
    scrollbar-width: thin; 
    scrollbar-color: #f79109 #f0f0f0; 
  }
  .resultado::-webkit-scrollbar {
    width: 10px; 
    height: 10px; 
  }
  .resultado::-webkit-scrollbar-track {
    background: #f0f0f0; 
    border-radius: 20px;
  }
  .resultado::-webkit-scrollbar-thumb {
    background-color: #f79109; 
    border-radius: 20px;
    border: 2px solid #f0f0f0; 
  }
  .resultado::-webkit-scrollbar-thumb:hover {
    background-color: #e07a00; 
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
  .resultado-item > div span:first-child{
    color: #f79109;
    font-weight: 500;
  }
  .resultado-item > div strong{
    color: #737272;
    font-weight:700;
  }
  .resultado-item > div span:last-child{
    color: #737272;
    font-weight: 300;
  }
  .resultado-item:hover {
    background-color: #f0f0f0;
  }
  @media(max-width:991px){ .input-buscar form input{ padding: .675rem .75rem !important; }}
  @media(min-width:992px){ .input-buscar form button{top:-2px !important;} .mostrar-productos{display:none}}
  
  .form-control:focus {
    box-shadow: none; 
    border-color: #ccc; 
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
      <ul class="nav navbar-nav navbar-nav--mod mb-2 mb-lg-0 navbar-nav-scroll">
        <li class="nav-item dropdown mt-2 mt-md-0">
          <a class="nav-link dropdown-toggle" href="#" id="menu-servicios" role="button" data-bs-toggle="dropdown" aria-expanded="false">SERVICIOS</a>
          <ul class="dropdown-menu" style="min-width: 20rem !important" aria-labelledby="menu-servicios">
            <li class="mt-1"><a class="dropdown-item" style="white-space: normal; color:#858585 !important; font-weight:500" id="submenu-inhouse" href="/servicios/in-houser-o-por-proyectos">IN HOUSE O POR PROYECTOS</a></li>
            <li class="mt-1"><a class="dropdown-item" style="white-space: normal; color:#858585 !important; font-weight:500" id="submenu-sertaller" href="/servicios/servicio-taller">SERVICIO TALLER</a></li>
            <li class="mt-1"><a class="dropdown-item" style="white-space: normal; color:#858585 !important; font-weight:500" id="submenu-auxmecanico" href="/servicios/auxilio-mecanico-o-emergencias">AUXILIO MECÁNICO O EMERGENCIAS</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="menu-empresa" role="button" data-bs-toggle="dropdown" aria-expanded="false">MUNDO GPEM</a>
          <ul class="dropdown-menu" style="min-width: 20rem !important" aria-labelledby="menu-empresa">
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500" id="submenu-nosotros" href="https://gpemsac.com/pages/nosotros.php">ACERCA DE NOSOTROS</a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500" id="submenu-trabaja" href="/empresa/trabaja-con-nosotros">BOLSA DE TRABAJO</a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500" id="submenu-contactanos" href="/servicios/contactanos">CONTÁCTANOS</a></li>
          </ul>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="menu-categorias" role="button" data-bs-toggle="dropdown" aria-expanded="false">CATEGORÍAS</a>
          <ul class="dropdown-menu" style="min-width: 20rem !important" aria-labelledby="menu-categorias">
            <li class="mt-1 position-relative"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500; display:flex; justify-content: space-between; align-items:center;padding: 0 10px;" id="submenu-filtros" href="#">FILTROS <span style="font-size:25px;">&#8250;</span></a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500; display:flex; justify-content: space-between; align-items:center;padding: 0 10px;" id="submenu-aceites" href="#">ACEITES <span style="font-size:25px;">&#8250;</span></a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500; display:flex; justify-content: space-between; align-items:center;padding: 0 10px;" id="submenu-arrancadores" href="#">ARRANCADORES <span style="font-size:25px;">&#8250;</span></a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500; display:flex; justify-content: space-between; align-items:center;padding: 0 10px;" id="submenu-alternadores" href="#">ALTERNADORES <span style="font-size:25px;">&#8250;</span></a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500; display:flex; justify-content: space-between; align-items:center;padding: 0 10px;" id="submenu-transmisiones" href="#">TRANSMISIONES <span style="font-size:25px;">&#8250;</span></a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500; display:flex; justify-content: space-between; align-items:center;padding: 0 10px;" id="submenu-retardadores" href="#">RETARDADORES <span style="font-size:25px;">&#8250;</span></a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500; display:flex; justify-content: space-between; align-items:center;padding: 0 10px;" id="submenu-carroceria" href="#">CARROCERIA <span style="font-size:25px;">&#8250;</span></a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500; display:flex; justify-content: space-between; align-items:center;padding: 0 10px;" id="submenu-ejes" href="#">EJES <span style="font-size:25px;">&#8250;</span></a></li>
            <li class="mt-1"><a class="dropdown-item fw-bold" style="white-space: normal; color:#858585 !important; font-weight:500; display:flex; justify-content: space-between; align-items:center;padding: 0 10px;" id="submenu-frenos" href="#">FRENOS <span style="font-size:25px;">&#8250;</span></a></li>
          </ul>
        </li>
      </ul>
      <div class="input-buscar">
        <form class="d-flex position-relative buscador-container mt-2 m-lg-0" action="/productos" method="GET">
          <input class="form-control" type="text" name="search" id="search" placeholder="Buscar componentes, repuestos, aceites y más..." aria-label="Search">
          <button class="nav-item__button position-absolute" style="background: transparent;border: unset; color: #bcbcbc;right: 5px; top: 2px;font-size: 25px" type="submit">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.0" width="20px" height="30px" viewBox="0 0 1244.000000 1280.000000" preserveAspectRatio="xMidYMid meet">
              <g transform="translate(0.000000,1280.000000) scale(0.100000,-0.100000)" fill="#979797" stroke="none">
              <path d="M4025 12789 c-1029 -79 -1969 -501 -2704 -1214 -985 -955 -1456 -2292 -1285 -3650 156 -1244 849 -2360 1899 -3059 193 -129 272 -175 470 -274 452 -227 906 -362 1445 -429 207 -25 763 -25 970 0 404 50 752 138 1115 281 251 98 600 283 819 433 l80 54 1075 -1073 c3835 -3827 3770 -3762 3828 -3795 189 -105 411 -75 563 77 148 148 180 359 84 553 -21 43 -462 488 -2432 2459 -2212 2213 -2404 2408 -2392 2425 8 10 40 47 70 83 714 836 1088 1927 1031 3011 -32 610 -165 1136 -420 1664 -169 349 -340 615 -592 920 -106 128 -395 417 -524 524 -687 569 -1463 900 -2336 996 -174 19 -598 27 -764 14z m780 -949 c777 -118 1453 -463 1982 -1014 516 -536 829 -1194 930 -1951 24 -186 24 -618 0 -810 -54 -416 -158 -758 -342 -1125 -297 -593 -779 -1101 -1360 -1432 -964 -549 -2153 -590 -3152 -108 -975 470 -1667 1364 -1873 2420 -37 192 -51 323 -57 555 -6 258 4 423 42 651 161 971 742 1831 1588 2348 453 278 935 434 1512 490 22 2 164 3 315 1 217 -3 304 -8 415 -25z"/>
              </g>
            </svg>
          </button>  
          <div id="resultado" class="resultado"></div>
        </form>
      </div>
      <ul class="navbar-nav navbar-nav--mod mt-2 mt-lg-0 mb-2 mb-lg-0 navbar-nav-scroll">
        <li class="nav-item dropdown">
          <a class="nav-link menu01" style="font-weight: bold !important" id="menu-productos" href="/productos"><span class="mostrar-productos">VER TODOS LOS</span> PRODUCTOS</a>
        </li>
      </ul>
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
      fetch('/portal/admin/view/BuscarProductos2.php?filtro=' + query)
        .then(response => response.json())
        .then(data => {
          resultadoContainer.innerHTML = ''; 
          if (data.length > 0) {
            resultadoContainer.style.display = 'block';
            data.forEach(item => {
              const div = document.createElement('div');
              div.classList.add('resultado-item');
              div.innerHTML = `
                <img src="http://gpemsac.com/mycloud/portal/tienda/productos/${item.imagen}" alt="${item.seogoogle}">
                <div>
                  <span>${item.marca}</span><br>
                  <strong>${item.producto}</strong><br>
                  <span>${item.medida}</span>
                </div>`;
              div.addEventListener('click', function() {
                window.location.href = `/producto/${item.producto}`;
              });
              
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
    if (!buscadorContainer.contains(event.target)) {
      resultadoContainer.innerHTML = '';
      resultadoContainer.style.display = 'none';
      buscarInput.value = '';
    }
  });

  

</script>
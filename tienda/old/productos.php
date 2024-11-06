<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="application-name" content="Portal Web de GPEM S.A.C">
    <meta name="description" content="Tenemos todos los repuestos que usted necesita para su vehiculo. Trabajamos con marcas reconocidas como fleetguard, cummins, allison, prestolite.">
    <meta name="author" content="GPEM S.A.C.">
    <meta name="keywords" content="multimarca, aceites, alternadores, arrancadores, fleetguard, allison, cummins, repuestos, lubricantes">

    <title>Catálogo de productos | GPEM S.A.C.</title>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">

    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php"); ?>

    <?php 
        $filasxpagina=8;
        $total_paginas=0;

        $myArray=array();

        $array_sectores=array();
        $array_categorias=array();
        $array_marcas=array();

        $array_orden=array(
            '0'=>'Sin ordenamiento',
            //'price-desc'=>'Precio de mayor a menor',
            //'price-asc'=>'Precio de menor a mayor',
            'brand'=>'Ordenar por Marcas',
            'cat'=>'Ordenar por Categorías'
        );

        if(isset($_GET['cat'])){
            if(is_array($_GET['cat'])){
                $array_categorias=$_GET['cat'];
            }                        
        }
        
        if(isset($_GET['brand'])){
            if(is_array($_GET['brand'])){
                $array_marcas=$_GET['brand'];
            }                        
        }

        if(isset($_GET['sector'])){
            if(is_array($_GET['sector'])){
                $array_sectores=$_GET['sector'];
            }                        
        }

        $myArray = array_merge($array_sectores, $array_categorias, $array_marcas);
                   
        /*****************************************/
        /** Seleccionar el tipo de Ordenamiento **/
        /*****************************************/

        $ordenamiento="";
        if(isset($_GET['orderby'])){
            foreach($array_orden as $clave=>$valor){
                if($clave==$_GET['orderby']){
                    $ordenamiento.='<option value="'.$clave.'" selected>'.$valor.'</option>';
                }else{
                    $ordenamiento.='<option value="'.$clave.'">'.$valor.'</option>';
                }
            }
        }else{
            foreach($array_orden as $clave=>$valor){
                $ordenamiento.='<option value="'.$clave.'">'.$valor.'</option>';
            }
        }
        /*****************************************/
        /*****************************************/

        include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
        include($_SERVER['DOCUMENT_ROOT']."/portal/config/config.php");

        $query="";
        $query2="";
        $fila=0;
        $pagina_actual=1;
        
        if(!empty($_GET['search'])){
            $query=" and concat(seogoogle, caracteristicas) like '%".$_GET['search']."%'";
        }else{
            foreach($myArray as $a){
                $query .= " and etiquetas like '%".$a."%'";
            }

            /*
            if(count($array_categorias)>0){
                $query.=" and ncategoria in('".implode("','", $array_categorias)."')";
            }
    
            if(count($array_marcas)>0){
                $query.=" and nmarca in('".implode("','", $array_marcas)."')";
            }*/
    
            if(!empty($_GET['orderby'])){
                switch ($_GET['orderby']){
                    case "price-asc":
                        $query.=" order by precio asc";
                        break;
                    case "price-desc":
                        $query.=" order by precio desc";
                        break;
                    case "brand":
                        $query.=" order by nmarca asc";
                        break;
                    case "cat":
                        $query.=" order by ncategoria asc";
                        break;
                }
            }else{
                $query.=" order by prioridad desc";
            }
        }

        if(!empty($_GET['pag'])){
            $fila = (($_GET['pag']) - 1) * $filasxpagina;
            $pagina_actual=$_GET['pag'];              
        }

        $query2=$query." limit ".$fila.", ".$filasxpagina;
    ?>

</head>

<div class="container-loader-full">
    <div class="loader-full"></div>
</div>

<body class="bg-light" style="margin-top:90px;">
    <style>        
        .container-wa{
            position: absolute;
            z-index: 100;
        }

        .link-wa>a{
            color:#59e22d;
            font-size:3rem;
            margin-right: 10px;
        }

        .link-wa:hover a{
            color:#45ab24;
        }

        .li-quitar{
            display: inline-block;
            list-style: none;
            margin: 3px;
        }

        .ul-quitar{
            list-style: none;
            padding: 0;
            display: block;
        }

        .a-quitar {
            text-decoration: none;
            color: inherit;                        
            padding: 0.7px 4px;
            border-radius: 28px;
            background-color: #fff;
            border: 1px solid #d0d0d0;
            line-height: 16px;
            font-size: 12px;
            justify-content: center;
            align-items: center;
        }

        .a-quitar:hover{
            color:red;
        }

        .btn-filtros {
            position: -webkit-sticky;
            position: sticky;
            bottom: 0;
        }
    </style>
    <script>
        /*function fnSearchCat(e, url) {
            var option = e.options[e.selectedIndex];
            if(option.value>0){
                window.location.href = '/tienda/pages/productos?'+url+'&orderby='+option.value;
            }            
        }*/
    </script>

    <div class="container">
        <div class="row">         
            <div class="col-md-2 bg-white pt-2 d-none d-md-block">                
                <?php
                if(count($array_categorias)>0 || count($array_marcas)>0 || count($array_sectores)>0){
                    echo '<p class="fw-bold mb-1">Filtros aplicados <a class="text-dark m-0 p-0" style="float: right; font-size: 18px;" href="/productos" role="button"><i class="fas fa-times"></i></a></p>';
                    echo '<div class="border-bottom mb-2"><ul class="ul-quitar mb-1">';

                    foreach($array_sectores as $sector){
                        echo '<li class="li-quitar"><a class="a-quitar" href="#" onclick="fnQuitarUnFiltro('."'".$sector."'".'); return false;">'.$sector.' <i class="fas fa-times-circle"></i></a></li>';
                    }

                    foreach($array_categorias as $categoria){
                        echo '<li class="li-quitar"><a class="a-quitar" href="#" onclick="fnQuitarUnFiltro('."'".$categoria."'".'); return false;">'.$categoria.' <i class="fas fa-times-circle"></i></a></li>';
                    }
        
                    foreach($array_marcas as $marca){
                        echo '<li class="li-quitar"><a class="a-quitar" href="#" onclick="fnQuitarUnFiltro('."'".$marca."'".'); return false;">'.$marca.' <i class="fas fa-times-circle"></i></a></li>';
                    }
                    echo '</ul></div>';
                }
                ?>
                <div class="accordion text-nowrap overflow-auto mb-3 mx-auto" id="accordionPanelsStayOpenExample">
                    <div style="width: fit-content">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingThree">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseThree" aria-expanded="true" aria-controls="panelsStayOpen-collapseThree">
                                    SECTORES
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseThree" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingThree">
                                <div class="accordion-body p-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sectors[]" id="mineria" value="mineria" <?php if(in_array("mineria", $array_sectores)) echo "checked";?>>
                                        <label class="form-check-label" for="mineria">MINERIA </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sectors[]" id="industria" value="industria" <?php if(in_array("industria", $array_sectores)) echo "checked";?>>
                                        <label class="form-check-label" for="industria">INDUSTRIA </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="sectors[]" id="pesca" value="pesca" <?php if(in_array("pesca", $array_sectores)) echo "checked";?>>
                                        <label class="form-check-label" for="pesca">PESCA </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseOne" aria-expanded="true" aria-controls="panelsStayOpen-collapseOne">
                                    CATEGORIAS
                                </button>
                            </h2>
                            <div id="panelsStayOpen-collapseOne" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingOne">
                                <div class="accordion-body p-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cat[]" id="filtro" value="filtros" <?php if(in_array("filtros", $array_categorias)) echo "checked";?>>
                                        <label class="form-check-label" for="filtro">FILTROS </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cat[]" id="aceite" value="aceites" <?php if(in_array("aceites", $array_categorias)) echo "checked";?>>
                                        <label class="form-check-label" for="aceite">ACEITES </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cat[]" id="arrancador" value="arrancadores" <?php if(in_array("arrancadores", $array_categorias)) echo "checked";?>>
                                        <label class="form-check-label" for="arrancador">ARRANCADORES </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cat[]" id="alternador" value="alternadores" <?php if(in_array("alternadores", $array_categorias)) echo "checked";?>>
                                        <label class="form-check-label" for="alternador">ALTERNADORES </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cat[]" id="transmision" value="transmisiones" <?php if(in_array("transmisiones", $array_categorias)) echo "checked";?>>
                                        <label class="form-check-label" for="transmision">TRANSMISIONES </label>
                                    </div>                                    
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="cat[]" id="retardador" value="retardadores" <?php if(in_array("retardadores", $array_categorias)) echo "checked";?>>
                                        <label class="form-check-label" for="retardador">RETARDADORES </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="panelsStayOpen-headingTwo">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapseTwo" aria-expanded="true" aria-controls="panelsStayOpen-collapseTwo">MARCAS</button>
                            </h2>
                            <div id="panelsStayOpen-collapseTwo" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-headingTwo">
                                <div class="accordion-body p-2">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="brand[]" id="allison" value="allison" <?php if(in_array("allison", $array_marcas)) echo "checked";?>>
                                        <label class="form-check-label" for="allison">ALLISON</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="brand[]" id="cummins" value="cummins" <?php if(in_array("cummins", $array_marcas)) echo "checked";?>>
                                        <label class="form-check-label" for="cummins">CUMMINS</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="brand[]" id="prestolite" value="prestolite" <?php if(in_array("prestolite", $array_marcas)) echo "checked";?>>
                                        <label class="form-check-label" for="prestolite">PRESTOLITE</label>
                                    </div> 
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="brand[]" id="fleetguard" value="fleetguard" <?php if(in_array("fleetguard", $array_marcas)) echo "checked";?>>
                                        <label class="form-check-label" for="fleetguard">FLEETGUARD</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="brand[]" id="meccalte" value="meccalte" <?php if(in_array("meccalte", $array_marcas)) echo "checked";?>>
                                        <label class="form-check-label" for="meccalte">MECC ALTE</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="brand[]" id="pentarkloft" value="pentarkloft" <?php if(in_array("pentarkloft", $array_marcas)) echo "checked";?>>
                                        <label class="form-check-label" for="pentarkloft">PENTAR KLOFT</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-filtros p-2 bg-light" style="z-index: 10;"><button class="btn btn-primary form-control" onclick="fnAplicarFiltro(0); return false;">Aplicar filtros</button></div>
            </div>

            <div class="col-12 col-md-10">
                <div class="row mb-4 align-items-end">
                    <div class="col-12 col-md-7 mb-2">
                        <form action="/productos" method="GET">
                            <input type="text" class="form-control" id="txtSearch" name="search" value="<?php if(!empty($_GET['search'])){echo $_GET['search'];} ?>" placeholder="¿Qué estas buscando?">
                        </form>
                    </div>
                    <div class="col-12 col-md-5 mb-2">
                        <select class="form-select" id="cbOrdenamiento" onchange="fnAplicarFiltro(0)">
                            <?php echo $ordenamiento; ?>
                        </select>
                    </div>
                </div>
                <?php
                try{                        
                    $nfilas=0;
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt1=$conmy->query("select count(*) as cantidad from tblproductos where estado=2".$query.";");
                    $stmt1->execute();
                    $row1=$stmt1->fetch();
                    $nfilas=$row1['cantidad'];
                        
                    if($nfilas>0){
                        echo '<div class="row row-cols-1 row-cols-md-4 g-4">';
                            
                        $total_paginas=ceil($nfilas/$filasxpagina);
                        $stmt2=$conmy->prepare("select idproducto, producto, serie, marca, precio, seourl, imagen, stock from tblproductos where estado=2".$query2.";");
                        $stmt2->execute();
                        while ($row2 = $stmt2->fetch(PDO::FETCH_ASSOC)){
                            echo '
                            <div class="col mb-4 border-0">
                                <div class="card h-100 border-0">';
                                    echo '
                                    <a href="/producto/'.$row2['seourl'].'" class="text-decoration-none">
                                        <div class="contenedor-img-zoom">
                                            <img src="/mycloud/portal/tienda/productos/'.$row2['imagen'].'" class="card-img-top img-zoom" alt="'.$row2['producto'].'">
                                        </div>
                                    </a>                                             
                                    <div class="card-body pb-0 text-center">
                                        <h5 class="card-title text-secondary">'.$row2['marca'].'</h5>
                                        <a href="/producto/'.$row2['seourl'].'" class="text-decoration-none text-dark"><h5 class="fw-bold">'.$row2['producto'].'</h5></a>                                                            
                                        <h5 class="m-0 text-danger">'.$row2['serie'].'</h5>
                                    </div>';
                                    /*echo '<div class="col text-center">
                                        <p class="text-center text-danger fs-4 fw-bold m-0">S/ '.$row2['precio'].'</p>
                                    </div>';*/    
                                    
                                    //if($row2['stock']>0){
                                        echo '
                                        <div class="col-12 container-wa text-end">
                                            <h1 class="link-wa"><a class="text-decoration-none" href="https://wa.me/51967829341?text=https%3A%2F%2Fgpemsac.com%2Fproducto%2F'.$row2['seourl'].'%0D%0A%0D%0AHola%2C+estoy+interesado+en+cotizar+este+producto.+Puede+ayudarme%3F" target="_blank"><i class="fab fa-whatsapp-square"></i></a></h1>
                                        </div>
                                        <div class="card-footer bg-white p-1 border-0">
                                            <button class="btn btn-warning form-control text-white" onclick="fnAgregarCarrito('."'".openssl_encrypt($row2['idproducto'], COD, KEY)."'".', 1); return false;">
                                                <i class="fas fa-shopping-cart"></i> Agregar a la bolsa
                                            </button>
                                        </div>';
                                    //}else{
                                    //    echo '
                                    //    <div class="card-footer bg-white p-1 border-0">
                                    //        <a class="btn btn-verde form-control" href="https://wa.me/51967829341?text=https%3A%2F%2Fgpemsac.com%2Fportal%2Ftienda%2Fproducto%3Fid%3D'.$row2['idproducto'].'%0D%0A%0D%0AHola%2C+quiero+consultar+por+este+producto." role="button" target="_blank">
                                    //            <i class="fab fa-whatsapp"></i> Consulta Aquí
                                    //        </a>
                                    //    </div>';
                                    //}
                                echo '
                                </div>
                            </div>';
                        }
                        echo '</div>';
                        $stmt2=null;
                    }else{
                        echo '<div class="col-12"><h4>No se encontro productos para esta consulta.</h4></div>';
                    }
                    $stmt1=null;
                }catch(PDOException $e){
                    $stmt1=null;
                    $stmt2=null;
                    echo "<div class='col-12'><p>Ha ocurrido un problema . . .</p></div>".$e;
                }
                ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <nav aria-label="...">
                    <ul class="pagination justify-content-end">
                        <?php
                            $paginacion="";
                            $desde=1;
                            $hasta=$total_paginas;
                            $pagleft=false; 
                            $pagright=false;

                            if($total_paginas>5){
                                if ($pagina_actual<3){
                                    $pagright=true;
                                    $desde=1;
                                    $hasta=5;
                                }else{
                                    if($pagina_actual-2>0 and $total_paginas-$pagina_actual>2){
                                        $pagright=true;
                                        $desde=$pagina_actual-2;
                                        $hasta=$pagina_actual+2;
                                    }else{
                                        if($total_paginas-$pagina_actual<3){
                                            $desde=$total_paginas-4;
                                        }
                                    }
                                    $pagleft=true;
                                }
                            }                       

                            if($total_paginas>1){
                                if($pagleft){
                                    $paginacion.='<li class="page-item"><a class="page-link fs-5 fw-bold" href="#" onClick="fnAplicarFiltro(1); return false;"><span aria-hidden="true">&laquo;</span></a></li>';
                                    $paginacion.='<li class="page-item"><a class="page-link fs-5 fw-bold" href="#" onClick="fnAplicarFiltro('.($pagina_actual-1).'); return false;"><span aria-hidden="true">&lsaquo;</span></a></li>';
                                }
                                for ($i=$desde; $i<=$hasta; $i++) {
                                    if($i==$pagina_actual){
                                        $paginacion.='<li class="page-item active" aria-current="page"><a class="page-link fs-5 fw-bold" href="#" onClick="fnAplicarFiltro('.$i.'); return false;">'.$i.'</a></li>';
                                    }else{
                                        $paginacion.='<li class="page-item"><a class="page-link fs-5 fw-bold" href="#" onClick="fnAplicarFiltro('.$i.'); return false;">'.$i.'</a></li>';
                                    }
                                }
                                if($pagright){
                                    $paginacion.='<li class="page-item"><a class="page-link fs-5 fw-bold" href="#" onClick="fnAplicarFiltro('.($pagina_actual+1).'); return false;"><span aria-hidden="true">&rsaquo;</span></a></li>';
                                    $paginacion.='<li class="page-item"><a class="page-link fs-5 fw-bold" href="#" onClick="fnAplicarFiltro('.$total_paginas.'); return false;"><span aria-hidden="true">&raquo;</span></a></li>';
                                }
                            }
                            echo $paginacion;
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"><i class="far fa-check-circle text-success"></i> Producto agregado a la bolsa de compras</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-8" id="check-producto">
                        </div>
                        <div class="col-4" id="check-cantidad">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Seguir comprando</button>
                    <a class="btn btn-success" href="/carrito" role="button">Ver bolsa de compras</a>
                </div>
            </div>
        </div>
    </div>


    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/mycloud/library/gpemsac/portal/js/productos.js"></script>
    
    <!-- Código de instalación Cliengo para mi correo -->
    <!--<script type="text/javascript">
        (function () { 
            var ldk = document.createElement('script'); 
            ldk.type = 'text/javascript'; 
            ldk.async = true; 
            ldk.src = 'https://s.cliengo.com/weboptimizer/60b7fa9048995c002a4c96e7/60b7fa9248995c002a4c96ea.js?platform=registration'; 
            var s = document.getElementsByTagName('script')[0]; 
            s.parentNode.insertBefore(ldk, s); 
        })();
    </script>-->

    <!-- Smartsupp Live Chat script -->
    <!--<script type="text/javascript">
        var _smartsupp = _smartsupp || {};
        _smartsupp.key = '24d28d6fec887cca1a3efab19eeddfc9496290ce';
        window.smartsupp||(function(d) {
            var s,c,o=smartsupp=function(){
                o._.push(arguments)
            };
            o._=[];
            s=d.getElementsByTagName('script')[0];c=d.createElement('script');
            c.type='text/javascript';
            c.charset='utf-8';
            c.async=true;
            c.src='https://www.smartsuppchat.com/loader.js?';
            s.parentNode.insertBefore(c,s);
        })(document);
    </script>-->

</body>
<?php include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html");?>
</html>
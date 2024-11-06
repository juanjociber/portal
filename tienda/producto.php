<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
<?php
    include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
    include($_SERVER['DOCUMENT_ROOT']."/portal/config/config.php");

    $array_galerias=array();
    $array_etiquetas=array();
    $bandera=false;
    $seoggogle="";
    $producto="";
    $imagen="unknown.jpg";

    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt=$conmy->prepare('select idproducto, producto, serie, marca, caracteristicas, seogoogle, imagen, informacion, etiquetas from tblproductos where seourl=:Url and estado=2;');
        $stmt->execute(array('Url'=>$_GET['producto']));
        $row=$stmt->fetch();
        if($row){
            $bandera=true;
            $idproducto=$row['idproducto'];
            $producto=$row['producto'];            
            $serie=$row['serie'];
            $marca=$row['marca'];
            $caracteristicas=$row['caracteristicas'];
            $seoggogle=$row['seogoogle'];
            $imagen=$row['imagen'];
            $informacion=$row['informacion'];
            $etiquetas=$row['etiquetas'];

            $stmt=$conmy->prepare("select archivo, descripcion from tblgalerias where idproducto=:IdProducto and estado=2;");
            $stmt->bindParam(':IdProducto', $idproducto, PDO::PARAM_INT);
            $stmt->execute();
            while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                $array_galerias[]=array(
                    'archivo'=>$row['archivo'],
                    'descripcion'=>$row['descripcion']
                );
            }
        }        
        $stmt=null;
    }catch(PDOException $e){
        $stmt=null;
    }
?>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $producto." | GPEM SAC."; ?></title>
    
    <meta name="application-name" content="Productos GPEM SAC.">
    <meta name="description" content="<?php echo $seoggogle; ?>">
    <meta name="author" content="GPEM SAC.">

    <!-- Open Graph data -->
    <!--<meta property="og:type" content="article"/>-->
    <!--<meta property="og:type" content="product"/>-->
    <!--<meta property="og:image:secure_url" itemprop="image" content="https://gpemsac.com/mycloud/portal/tienda/productos/<?php //echo $imagen; ?>"/>-->
    <meta property="og:title" content="<?php echo $producto; ?>" />
    <meta property="og:url" content="https://gpemsac.com/producto/<?php echo $_GET['producto'];?>"/>
    <meta property="og:image" content="https://gpemsac.com/mycloud/portal/tienda/productos/<?php echo $imagen; ?>"/>
    <meta property="og:image:width" content="256"/>
    <meta property="og:image:height" content="256"/>
    <meta property="og:type" content="website" />
    <meta property="og:description" content="GPEM S.A.C."/>
    <meta property="og:site_name" content="e-comerce gpemsac.com"/>
    <!--<meta property="article:section" content="productos cummins"/>-->
    <!----Fin Open Graph data ---->

    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-menu.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-producto.css"/>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css"/>
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="/mycloud/library/gpemsac/portal/css/portal-gpemsac.css">
    
    <!--<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />-->
    <link rel="stylesheet" href="/mycloud/library/swiper-6.8.0/swiper-bundle.min.css">

    <?php include($_SERVER['DOCUMENT_ROOT']."/portal/navbar.php");?>

</head>
<body style="margin-top:90px">
    <!-- Load Facebook SDK for JavaScript -->
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v12.0" nonce="apSHZOIJ"></script>

    <?php 
    if ($bandera){ ?>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12 d-block d-md-none">
                <h5 class="text-secondary"><?php echo $marca; ?></h5>
                <h3 class="border-bottom pb-2"><?php echo $producto; ?></h3>
            </div>
            <div class="col-12 col-md-5 mb-4">
                <div class="row">
                    <div class="col-12 border border-1">
                        <div class="swiper-container gallery-top">
                            <div class="swiper-wrapper col-12">
                                <?php
                                    if(!empty($array_galerias)){
                                        foreach($array_galerias as $item){
                                            echo "
                                            <div class='swiper-slide'>
                                                <img class='img-fluid' src='/mycloud/portal/tienda/productos/".$item['archivo']."' alt='".$item['descripcion']."'>  
                                            </div>";
                                        }
                                    }else{
                                        echo "
                                        <div class='swiper-slide'>
                                            <img class='img-fluid' src='/mycloud/portal/tienda/productos/".$imagen."' alt='".$producto."'>  
                                        </div>";
                                    }                             
                                ?>
                            </div>
                            <div class="swiper-button-next"></div>
                            <div class="swiper-button-prev"></div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="swiper-container gallery-thumbs">
                            <div class="swiper-wrapper">
                                <?php
                                    if(!empty($array_galerias)){
                                        foreach($array_galerias as $item){
                                            echo "
                                            <div class='swiper-slide'>
                                                <img class='img-thumbnail' src='/mycloud/portal/tienda/productos/".$item['archivo']."' alt='".$item['descripcion']."'>  
                                            </div>";
                                        }
                                    }else{
                                        echo "
                                        <div class='swiper-slide'>
                                            <img class='img-thumbnail' src='/mycloud/portal/tienda/productos/".$imagen."' alt='".$producto."'>  
                                        </div>";
                                    }                           
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-12 col-md-7">
                <div class="row">
                    <div class="col-12 pb-1 d-none d-md-block">
                        <h5 class="text-secondary"><?php echo $marca; ?></h5>
                        <h2 class="border-bottom pb-1"><?php echo $producto; ?></h2>
                    </div>
                    <div class="col-12 col-md-6">
                        <div class="row p-2">
                            <div class="col-12">
                                <?php if(strlen($serie)>1){echo "<h5 class='text-danger fw-bold'>Part Number: ".$serie."</h5>";}?>
                            </div>
                            <div class="col-12 mb-3">
                                <?php echo $caracteristicas;?>
                            </div>
                            <div class="col-12">
                                 <a class="btn btn-verde" href="https://wa.me/51982827525?text=https%3A%2F%2Fgpemsac.com%2Fproducto%2F<?php echo $_GET['producto']; ?>%0D%0A%0D%0AHola%2C+estoy+interesado+en+cotizar+este+producto.+Puede+ayudarme%3F" target="_blank" role="button"><i class="fab fa-whatsapp"></i> Solicitar información</a>
                            </div>
                        </div>
                    </div>                   

                    <div class="col-12 col-md-6 pt-3">
                        <div class="row mb-3">                            
                            <div class="input-group input-group-lg">
                                <div class="input-group-prepend">
                                    <span class="input-group-text fw-bold" style="height: 100%" id="inputGroup-sizing-lg">CANTIDAD</span>
                                </div>
                                <input type="number" id="cantidad" class="form-control" min="1" aria-label="Large" aria-describedby="inputGroup-sizing-sm" value="1">
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-12">
                                <button class="btn btn-success btn-lg form-control mb-3" onclick="fnAgregarProducto('<?php echo openssl_encrypt($idproducto, COD, KEY); ?>', document.getElementById('cantidad').value);"><i class="fas fa-shopping-cart"></i> AGREGAR A LA BOLSA</a></button>
                                <a class="btn btn-outline-primary btn-lg form-control" href="/productos" role="button"><i class="fas fa-chevron-left"></i> SEGUIR COMPRANDO</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <!-- Your share button code -->
                        <p class="m-0 p-0" style="font-size: 12px">Dale me gusta y comparte con tus amigos.</p>
                        <div class="fb-like" data-href="https://gpemsac.com/producto/<?php echo $_GET['producto']; ?>" data-width="" data-layout="button_count" data-action="like" data-size="small" data-share="true"></div>
                        <p class="m-0 p-0" style="font-size: 12px">Síguenos tambien en nuestras redes sociales.</p>
                        <h2 class="ps-3">
                            <a href="https://www.facebook.com/gpemsac" target="_blank" class="text-primary"><i class="fab fa-facebook-square"></i></a>
                            <a href="https://www.youtube.com/channel/UCnI6Svnk_AFSg0dd-sy32aw" target="_blank" class="text-danger"><i class="fab fa-youtube-square"></i></a>
                            <a href="https://pe.linkedin.com/company/gpem-sac" target="_blank" class="text-info"><i class="fab fa-linkedin"></i></a>
                            <a href="https://www.instagram.com/gpemsac/" target="_blank" class="text-danger"><i class="fab fa-instagram" aria-hidden="true"></i></a>
                        </h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-4">
            <div class="col-12">
                <?php 
                    if (strlen($informacion)>5) {
                        echo "<p class='border-bottom pb-2 fw-bold fs-5'>DATOS IMPORTANTES</p>".nl2br($informacion);
                    }
                ?>
            </div>
        </div>
    </div>
    <?php
    }else{
        echo "
        <div class='container'>
            <div class='row text-center mb-3'>
                <div class='col-12'>
                    <p class='fs-3'>Lo sentimos, el producto no existe.</p>
                    <a href='/productos' class='btn btn-primary btn-lg active' role='button' aria-pressed='true'>Ir a productos</a>
                </div>
            </div>
        </div>";
    }
    ?>

    <?php if ($bandera){ ?>
    <div class="container bg-light mb-3">
        <div class="row mb-3">
            <div class="col-12 pt-2">
                <h3 class="text-center fw-bold">TAMBIEN TE PUEDE INTERESAR</h3>
            </div>
        </div>
        <div class="row row-cols-1 row-cols-md-4">
            <?php
            $query="";
            $array_etiquetas=explode(",",$etiquetas);
            if(!empty($array_etiquetas)){
                $query .= "(";
                foreach($array_etiquetas as $a){
                    $query .= "etiquetas like '%".$a."%' or ";
                };
                $query = substr($query, 0, -4);
                $query .= ") and";
            };

            try{
				$conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);							
				$stmt=$conmy->prepare("select idproducto, producto, serie, marca, seourl, imagen from tblproductos where ".$query." estado=2 and idproducto!=:IdProducto order by prioridad limit 8;");
                $stmt->bindParam(':IdProducto', $idproducto, PDO::PARAM_INT);
                $stmt->execute();
				$resultado = $stmt->fetchAll();
				foreach ($resultado as $fila){?>
                    <div class="col mb-4 border-0">
                        <div class="card h-100 border-0">
                            <?php
                            echo '
                            <div class="col-12 container-wa text-end">
                                <h1 class="link-wa"><a class="text-decoration-none" href="https://wa.me/51982827525?text=https%3A%2F%2Fgpemsac.com%2Fproducto%2F'.$fila['seourl'].'%0D%0A%0D%0AHola%2C+estoy+interesado+en+cotizar+este+producto.+Puede+ayudarme%3F" target="_blank"><i class="fab fa-whatsapp-square"></i></a></h1>
                            </div>';?>
                            <a href="/producto/<?php echo $fila['seourl'];?>" class="text-decoration-none">
                                <div class="contenedor-img-zoom">
                                    <img src="/mycloud/portal/tienda/productos/<?php echo $fila['imagen']; ?>" class="card-img-top img-zoom" alt="<?php echo $fila['producto']; ?>">
                                </div>
                            </a>                                             
                            <div class="card-body pb-1 text-center">                            
                                <h5 class="card-title text-secondary"><?php echo $fila['marca']; ?></h5>
                                <a href="/producto/<?php echo $fila['seourl'];?>" class="text-decoration-none text-dark"><h5 class="fw-bold"><?php echo $fila['producto']; ?></a></h5>
                                <h5 class="m-0 text-danger"><?php echo $fila['serie'] ?></h5>
                            </div>
                            <!--<div class="col text-center">
                                <p class="text-center text-danger fs-5 fw-bold m-1"><?php //echo "S/ ".$fila['precio']; ?></p>
                            </div>-->
                            <div class="card-footer bg-white p-1 border-0">
                                <?php
                                //if($fila['stock']>0){
                                echo '<button class="btn btn-warning form-control text-white" onclick="fnAgregarProducto('."'".openssl_encrypt($fila['idproducto'], COD, KEY)."'".', 1); return false;"><i class="fas fa-shopping-cart"></i> Agregar a la bolsa</a></button>';
                                //}else{
                                //    echo '<a class="btn btn-verde form-control" href="https://wa.me/51982827525?text=https%3A%2F%2Fgpemsac.com%2Fportal/%2Ftienda%2Fproducto%3Fid%3D'.$fila['idproducto'].'%0D%0A%0D%0AHola%2C+quiero+consultar+por+este+producto." role="button" target="_blank"><i class="fab fa-whatsapp"></i> Consulta Aquí</a>';
                                //}
                                ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $stmt=null; 
                }
			}catch(PDOException $e){
                $stmt =null;
				echo "<div>Tenemos problemas para mostrar productos sugeridos.</div>";                
			}?>
        </div>
    </div>
    <?php } ?>

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
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Seguir comprando</button>
                    <a class="btn btn-success" href="/carrito" role="button">Ver bolsa de compras</a>
                </div>
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.bundle.min.js"></script>
    <!--<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>-->
    <script src="/mycloud/library/swiper-6.8.0/swiper-bundle.min.js"></script> 
    <script src="/mycloud/library/jquery-3.5.1/jquery-3.5.1.js"></script>
    <script src="/mycloud/library/gpemsac/portal/js/producto.js"></script>
    
    <!-- Código de instalación Cliengo para mi correo
    <script type="text/javascript">
        (function () { 
            var ldk = document.createElement('script'); 
            ldk.type = 'text/javascript'; 
            ldk.async = true; 
            ldk.src = 'https://s.cliengo.com/weboptimizer/60b7fa9048995c002a4c96e7/60b7fa9248995c002a4c96ea.js?platform=registration'; 
            var s = document.getElementsByTagName('script')[0]; 
            s.parentNode.insertBefore(ldk, s); 
        })();
    </script> -->
    
</body>
<?php include($_SERVER['DOCUMENT_ROOT']."/portal/footer.html");?>
</html>
<?php
    session_start();
    if(empty($_SESSION['vgusuario'])){
        header("HTTP/1.1 401 Unauthorized");
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $array_etiquetas=array();
    $vlIdProducto=0;
    $vlProducto="";
    $vlCodigo="";
    $vlSerie="";
    $vlMarca="";
    $vlModelo="";
    $vlMedida="";
    $vlCaracteristicas="";
    $vlSeoGoogle="";
    $vlSeoUrl="";
    $vlImagen="";
    $vlDestacado="";
    $vlPrioridad="";
    $vlInformacion="";
    $vlEtiquetas="";
    $vlEstado=0;

    $cbCategorias='<option value=0>Seleccione categoría</option>';
    $array_galerias=array();

    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $stmt=$conmy->prepare('select idproducto, producto, codigo, serie, marca, medida, caracteristicas, seogoogle, seourl, imagen, destacado, prioridad, informacion, etiquetas, estado from tblproductos where idproducto=:Id;');
        $stmt->execute(array('Id'=>$_GET['id']));
        $row=$stmt->fetch();
        $vlProducto=$row['producto'];
        $vlCodigo=$row['codigo'];
        $vlSerie=$row['serie'];
        $vlMarca=$row['marca'];
        $vlMedida=$row['medida'];
        $vlCaracteristicas=$row['caracteristicas'];
        $vlSeoGoogle=$row['seogoogle'];
        $vlSeoUrl=$row['seourl'];
        $vlImagen=$row['imagen'];
        $vlDestacado=$row['destacado'];
        $vlPrioridad=$row['prioridad'];
        $vlInformacion=$row['informacion'];
        $vlEtiquetas=$row['etiquetas'];
        $vlEstado=$row['estado'];

        $stmt=$conmy->prepare("select idgaleria, archivo, descripcion from tblgalerias where idproducto=:IdProducto;");
        $stmt->bindParam(':IdProducto', $_GET['id'], PDO::PARAM_INT);
        $stmt->execute();
        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $array_galerias[]=array(
                'id'=>$row['idgaleria'],
                'archivo'=>$row['archivo'],
                'descripcion'=>$row['descripcion']
            );
        }

        $stmt=$conmy->prepare("select idcategoria, categoria from tblcategorias;");
        $stmt->execute();
		while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
            $cbCategorias.='<option value="'.$row['idcategoria'].'">'.$row['categoria'].'</option>';
		}

        $stmt1=null;
    }catch(PDOException $e){
        $stmt1=null;
    }

    $cbDestacado='';
    $arrayDestacados=array('0'=>'NO','1'=>'SI'); 
    foreach ($arrayDestacados as $indice=>$valor){ 
        if ($indice==$vlDestacado){ 
            $cbDestacado.="<option value='".$indice."' selected>".$valor."</option>";      
        } else {
            $cbDestacado.="<option value='".$indice."'>".$valor."</option>";
        }
    }

    $cbEstados='';
    $arrayEstados=array('1'=>'INACTIVO','2'=>'ACTIVO'); 
    foreach ($arrayEstados as $indice=>$valor){ 
        if ($indice==$vlEstado){ 
            $cbEstados.="<option value='".$indice."' selected>".$valor."</option>";      
        } else {
            $cbEstados.="<option value='".$indice."'>".$valor."</option>";
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Información del producto | GPEM SAC.</title>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/css/gpemsac.css">
    <link rel="shortcut icon" href="/mycloud/logos/favicon.ico">
</head>
<body>
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>
    <div class="container mb-5 mt-2">
        <div class="row">
            <div class="col-12 p-2 mb-3 bg-secondary text-white text-center">
                <h5>GESTION DEL PRODUCTO</h5>
            </div>
        </div>
        <div class="row border mb-3">
            <div class="col-12 border-bottom mb-2 bg-light">
                <p class="fw-bold m-0">INFORMACION DEL PRODUCTO</p>            
            </div>
            <div class="col-12 mb-1">
                <a class="text-primary text-decoration-none m-0 p-0" href="#" role="button" onclick="fnModalModificarDatosProducto(); return false;"><i class="fas fa-pen" style="font-size: 13px;" ></i> Editar</a>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-7 col-sm-9">
                        <p class="text-secondary m-0">Producto:</p>
                        <input type="text" class="d-none" id="txtId" value="<?php echo $_GET['id'];?>" readonly>
                        <p><?php echo $vlProducto; ?></p>
                    </div>
                    <div class="col-5 col-sm-3">
                        <p class="text-secondary m-0">Estado:</p>
                        <p>
                        <?php 
                            switch ($vlEstado) {
                                case 1:
                                    echo '<span class="badge bg-danger">INACTIVO</span>';
                                break;
                                case 2:
                                    echo '<span class="badge bg-success">ACTIVO</span>';
                                break;
                                default:
                                    echo '<span class="badge bg-secondary">UNKNOWN</span>';
                            }
                        ?>
                        </p>
                    </div>
                    <div class="col-6 col-sm-3">
                        <p class="text-secondary m-0">Codigo:</p>
                        <p><?php echo $vlCodigo; ?></p>
                    </div>
                    <div class="col-6 col-sm-3">
                        <p class="text-secondary m-0">Serie:</p>
                        <p><?php echo $vlSerie; ?></p>
                    </div>
                    <div class="col-6 col-sm-3">
                        <p class="text-secondary m-0">Marca:</p>
                        <p><?php echo $vlMarca; ?></p>
                    </div>
                    <div class="col-6 col-sm-3">
                        <p class="text-secondary m-0">Medida:</p>
                        <p><?php echo $vlMedida; ?></p>
                    </div>
                    <div class="col-6 col-sm-3">
                        <p class="text-secondary m-0">Destacado:</p>
                        <?php
                            if($vlDestacado){
                                echo '<p><span class="badge bg-success">SI</span></p>';
                            }else{
                                echo '<p><span class="badge bg-danger">NO</span></p>';
                            }                            
                        ?>
                    </div>
                    <div class="col-6 col-sm-3">
                        <p class="text-secondary m-0">Prioridad:</p>
                        <p><?php echo '<span class="badge bg-info text-dark">'.$vlPrioridad.'</span>';?></p>
                    </div>                   
                </div>
            </div>
        </div>

        <div class="row border mb-3">
            <div class="col-12 border-bottom mb-2 bg-light">
                <p class="fw-bold m-0">ETIQUETAS DE BUSQUEDA</p> 
            </div>
            <div class="col-12 mb-2">
                <a class="text-primary text-decoration-none m-0 p-0" href="#" role="button" onclick="fnModalModificarFiltros(); return false;"><i class="fas fa-pen" style="font-size: 13px;"></i> Editar</a>
                <p class="text-secondary m-0">Etiquetas:</p>
                <div style="display: inline-block;">
                    <?php
                        $array_etiquetas=explode(",",$vlEtiquetas);
                        foreach($array_etiquetas as $etiqueta){
                            echo '<span class="badge bg-success me-1 mb-1">'.$etiqueta.'</span>';
                        }            
                    ?>
                </div>                
            </div>
        </div>

        <div class="row border mb-3">
            <div class="col-12 border-bottom mb-2 bg-light">
                <p class="m-0 fw-bold">INFORMACION PARA SEO</p>            
            </div>
            <div class="col-12 mb-1">
                <a class="text-primary text-decoration-none m-0 p-0" href="#" role="button" onclick="fnModalModificarSeo(); return false;"><i class="fas fa-pen" style="font-size: 13px;" ></i> Editar</a>
            </div>
            <div class="col-12 col-sm-6 mb-2">
                <p class="text-secondary mb-0">SEO Google:</p>
                <p class="mb-0"><?php echo $vlSeoGoogle; ?></p>
            </div>
            <div class="col-12 col-sm-6">
                <p class="text-secondary m-0">URL:</p>
                <p><?php echo $vlSeoUrl; ?></p>
            </div>          
        </div>

        <div class="row border mb-3">
            <div class="col-12 border-bottom mb-2 bg-light">
                <p class="fw-bold m-0">CARACTERISTICAS RESUMIDAS</p>            
            </div>
            <div class="col-12 mb-1">
                <a class="text-primary text-decoration-none m-0 p-0" href="#" role="button" onclick="fnModalModificarCaracteristicas(); return false;"><i class="fas fa-pen" style="font-size: 13px;" ></i> Editar</a>
            </div>
            <div class="col-12">
                <p class="text-secondary mb-0">Características:</p>
                <?php echo $vlCaracteristicas; ?>
            </div>          
        </div>

        <div class="row mb-3 border">
            <div class="col-12 border-bottom mb-2 bg-light">
                <p class="fw-bold m-0">INFORMACION TECNICA</p>            
            </div>
            <div class="col-12 mb-1">
                <a class="text-primary text-decoration-none m-0 p-0" href="#" role="button" onclick="fnModalModificarInformacion(); return false;"><i class="fas fa-pen" style="font-size: 13px;" ></i> Editar</a>
            </div>
            <div class="col-12">
                <p class="text-secondary m-0">Información:</p>
                <?php echo $vlInformacion; ?>
            </div>         
        </div>

        <div class="row mb-3 border">
            <div class="col-12 border-bottom mb-2 bg-light">
                <p class="fw-bold m-0">IMAGENES DEL PRODUCTO</p>            
            </div>
            <div class="col-12 mb-3">
                <p class="mb-2 text-secondary">Imágen principal</p>
                <div class="row row-cols-1 row-cols-md-4 g-4">
                    <div class="col">
                        <div class="card h-100">
                            <img src="/mycloud/portal/tienda/productos/<?php echo $vlImagen;?>" class="card-img-top" alt="...">
                            <div class="card-body text-center">
                                <p class="card-text"><?php echo $vlProducto; ?></p>
                            </div>
                            <div class="card-footer">
                                <a class="text-primary text-decoration-none m-0 p-0" href="#" role="button" onclick="fnModalModificarImagenPrincipal('<?php echo $vlProducto; ?>'); return false;"><i class="fas fa-pen" style="font-size: 13px;" ></i> Editar</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <p class="mb-0 text-secondary">Galería de imágenes</p>
                <div class="row mb-1">
                    <div class="col-12">
                        <a class="text-success text-decoration-none" href="#" role="button" onclick="fnModalAgregarImagenGaleria(); return false;"><i class="fas fa-plus" style="font-size: 13px;" ></i> Nuevo</a>
                    </div>
                </div>
                <?php 
                    if(!empty($array_galerias)){
                        echo '<div class="row row-cols-1 row-cols-md-4 g-4 mb-2">';
                        foreach($array_galerias as $item){
                            echo '
                            <div class="col">
                                <div class="card h-100">
                                    <img src="/mycloud/portal/tienda/productos/'.$item['archivo'].'" class="card-img-top" alt="...">
                                    <div class="card-body text-center">
                                        <p class="card-text">'.$item['descripcion'].'</p>
                                    </div>
                                    <div class="card-footer">
                                        <a class="text-primary text-decoration-none m-0 p-0" href="#" role="button" onclick="fnModalModificarImagenGaleria('.$item['id'].",'".$item['descripcion']."'".'); return false;"><i class="fas fa-pen" style="font-size: 13px;" ></i> Editar</a>&nbsp;&nbsp;&nbsp;
                                        <a class="text-danger text-decoration-none m-0 p-0" href="#" role="button" onclick="fnModalEliminarImagenGaleria('.$item['id'].",'".$item['descripcion']."'".'); return false;"><i class="fas fa-times" style="font-size: 13px;" ></i> Eliminar</a>
                                    </div>
                                </div>
                            </div>';
                        };
                        echo '</div>';
                    };
                ?>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalModificarDatosProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">INFORMACION DEL PRODUCTO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="txtProducto" class="text-secondary m-0">PRODUCTO:</label>
                                <textarea class="form-control" id="txtProducto" rows="2"><?php echo $vlProducto; ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="txtCodigo" class="text-secondary m-0">CODIGO:</label>
                                <input type="text" class="form-control" id="txtCodigo" value="<?php echo $vlCodigo; ?>">
                            </div>
                            <div class="col-6">
                                <label for="txtSerie" class="text-secondary m-0">SERIE:</label>
                                <input type="text" class="form-control" id="txtSerie" value="<?php echo $vlSerie; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="txtMarca" class="text-secondary m-0">MARCA:</label>
                                <input type="text" class="form-control" id="txtMarca" value="<?php echo $vlMarca; ?>">
                            </div>
                            <div class="col-6">
                                <label for="txtMedida" class="text-secondary m-0">MEDIDA:</label>
                                <input type="text" class="form-control" id="txtMedida" value="<?php echo $vlMedida; ?>">
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label for="cbDestacado" class="text-secondary m-0">DESTACADO:</label>
                                <select class="form-select" id="cbDestacado">
                                    <?php echo $cbDestacado;?>
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="txtPrioridad" class="text-secondary m-0">PRIORIDAD:</label>
                                <input type="number" class="form-control" id="txtPrioridad" value="<?php echo $vlPrioridad; ?>">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="cbEstado" class="text-secondary m-0">ESTADO:</label>
                                <select class="form-select" id="cbEstado">
                                    <?php echo $cbEstados;?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body pt-1" id="msjModificarDatosProducto"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnModificarDatosProducto()">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalModificarSeo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">INFORMACION PARA SEO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="txtSeoGoogle" class="text-secondary m-0">SEO GOOGLE:</label>
                                <textarea class="form-control" id="txtSeoGoogle" rows="3"><?php echo $vlSeoGoogle; ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="txtSeoUrl" class="text-secondary m-0">SEO URL:</label>
                                <textarea class="form-control" id="txtSeoUrl" rows="2"><?php echo $vlSeoUrl; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body pb-1" id="msjModificarSeo"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnModificarSeo()">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>    

    <div class="modal fade" id="modalModificarCaracteristicas" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">CARACTERISTICAS</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="txtCaracteristicas" class="text-secondary m-0">CARACTERISTICAS:</label>
                                <textarea class="form-control" id="txtCaracteristicas" rows="10"><?php echo $vlCaracteristicas; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body pb-1" id="msjModificarCaracteristicas"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnModificarCaracteristicas()">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalModificarInformacion" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">INFORMACION TECNICA</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row mb-3">
                            <div class="col-md-12">
                                <label for="txtInformacion" class="text-secondary m-0">INFORMACION:</label>
                                <textarea class="form-control" id="txtInformacion" rows="15"><?php echo $vlInformacion; ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-body pb-1" id="msjModificarInformacion"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnModificarInformacion()">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalModificarImagenPrincipal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">MODIFICAR IMAGEN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pb-0">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="text-secondary m-0">DESCRIPCION:</label>
                            <textarea class="form-control" id="txtModificarDescripcionImagenPrincipal" rows="2" readonly></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="fileModificarImagenPrincipal" class="col-form-label form-control-sm pb-0 ">SELECCIONE UNA IMAGEN:</label>
                            <input type="file" name="archivo" id="fileModificarImagenPrincipal" required>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="msjModificarImagenPrincipal"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnModificarImagenPrincipal()">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalAgregarImagenGaleria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">NUEVA IMAGEN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pb-0">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="txtAgregarDescripcionImagenGaleria" class="text-secondary m-0">DESCRIPCION:</label>
                            <textarea class="form-control" id="txtAgregarDescripcionImagenGaleria" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="fileAgregarImagenGaleria" class="col-form-label form-control-sm pb-0 ">SELECCIONE UNA IMAGEN:</label>
                            <input type="file" name="archivo" id="fileAgregarImagenGaleria" required>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="msjAgregarImagenGaleria"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnAgregarImagenGaleria()">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalModificarImagenGaleria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">MODIFICAR IMAGEN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pb-0">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="txtModificarDescripcionGaleria" class="text-secondary m-0">DESCRIPCION:</label>
                            <input type="text" class="d-none" id="txtIdImagenGaleria" value="" readonly>
                            <textarea class="form-control" id="txtModificarDescripcionGaleria" rows="2"></textarea>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label for="fileModificarImagenGaleria" class="col-form-label form-control-sm pb-0 ">SELECCIONE UNA IMAGEN:</label>
                            <input type="file" name="archivo" id="fileModificarImagenGaleria" required>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="msjModificarImagenGaleria"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnModificarImagenGaleria()">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEliminarImagenGaleria" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">ELIMINAR IMAGEN</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pb-0">
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <h3>¿Está seguro de eliminar esta imágen?</h3>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-12">
                            <input type="text" class="d-none" id="txtEliminarIdImagenGaleria" value="" readonly>
                            <textarea class="form-control" id="txtEliminarDescripcionImagenGaleria" rows="2" readonly></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="msjEliminarImagenGaleria"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-danger" onclick="fnEliminarImagenGaleria()">ELIMINAR</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalModificarFiltros" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">OPCIONES DE FILTRADO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body">
                    <div class="container-fluid p-0">
                        <div class="row">
                        <?php
                            try{
                                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                $stmt=$conmy->query("select id, nombre, name from tblfiltros where idpadre>0 and estado=2;");
                                $stmt->execute();
                                if($stmt->rowCount()){
                                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){                                                                          
                                        if(in_array($row['name'], $array_etiquetas)){
                                            echo '
                                            <div class="col-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="chkFiltro'.$row['id'].'" name="chkFiltro[]" value="'.$row['name'].'" checked>
                                                    <label class="form-check-label" for="chkFiltro'.$row['id'].'">'.$row['nombre'].'</label>
                                                </div>
                                            </div>';
                                        }else{
                                            echo '
                                            <div class="col-6">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" id="chkFiltro'.$row['id'].'" name="chkFiltro[]" value="'.$row['name'].'">
                                                    <label class="form-check-label" for="chkFiltro'.$row['id'].'">'.$row['nombre'].'</label>
                                                </div>
                                            </div>';
                                        };                                        
                                    };          
                                }else{
                                    echo '<div class="col-12"><p>BD: No se pudo cargar los filtros.</p></div>';
                                };
                                $stmt=null;
                            }catch(PDOException $e){
                                $stmt=null;
                                echo '<div class="col-12"><p>'.$e.'</p></div>';
                            }           
                        ?>
                        </div>                        
                    </div>
                </div>
                <div class="modal-body pb-1" id="msjModificarFiltros"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnModificarFiltros()">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>

    <script src="js/AdmDetalleProducto.js"></script>
</body>
</html>
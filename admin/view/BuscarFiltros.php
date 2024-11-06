<?php
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $array_get=array();

    if(isset($_GET['dato'])){
        if(is_array($_GET['dato'])){
            $array_get=$_GET['dato'];
        }                        
    };

    $array_data=[];
    $array_hijos=[];
    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt=$conmy->query("select id, nombre, name, idpadre, estado from tblfiltros where estado=2;");
        $stmt->execute();
        if($stmt->rowCount()){
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                if($row['idpadre']==0){
                    $array_data[$row['id']]=array('nombre'=>$row['nombre'], 'name'=>$row['name']);
                }else{
                    $array_hijos[$row['id']]=array(
                        'nombre'=>$row['nombre'],
                        'name'=>$row['name'],
                        'idpadre'=>$row['idpadre'],
                    );
                }
            };

            foreach($array_hijos as $key=>$values){
                $array_data[$values['idpadre']]['hijos'][$key]=array('nombre'=>$values['nombre'], 'name'=>$values['name']);    
            };            
        }else{
            $msg='BD: No se ha encontrado resultados para esta consulta.';
        }
        $stmt=null;
    }catch(PDOException $e){
        $stmt=null;
        $msg='BD: Ha ocurrido un error en la BD.'.$e;
    }

    $htmlFiltros="";
    foreach($array_data as $key=>$values){
        $htmlFiltros.="<p>".$values['nombre']."</p>";
        if(!empty($values['hijos'])){
            $htmlFiltros.="<ul>";
            foreach($values['hijos'] as $key2=>$values2){
                $htmlFiltros.="<li> id:".$key2.", nombre:".$values2['nombre'].", name:".$values2['name']."</li>";
            }
            $htmlFiltros.="</ul>";
        }        
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                    print_r($array_get);
                ?>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="accordion text-nowrap overflow-auto mb-3 mx-auto" id="accordionPanelsStayOpenExample">
                    <div style="width: fit-content">
                        <?php
                            $htmlFiltros="";
                            foreach($array_data as $key=>$values){
                                $htmlFiltros.='
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="panelsStayOpen-heading'.$key.'">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#panelsStayOpen-collapse'.$key.'" aria-expanded="true" aria-controls="panelsStayOpen-collapse'.$key.'">'.$values['nombre'].'</button>
                                    </h2>
                                    <div id="panelsStayOpen-collapse'.$key.'" class="accordion-collapse collapse show" aria-labelledby="panelsStayOpen-heading'.$key.'">
                                        <div class="accordion-body p-2">';
                                    if(!empty($values['hijos'])){
                                        foreach($values['hijos'] as $key2=>$values2){
                                            $htmlFiltros.='<div class="form-check">';                                            
                                            $htmlFiltros.='<input class="form-check-input" type="checkbox" name="dato[]" id="'.$values2['name'].'" value="'.$values2['name'].'"';
                                            if(in_array($values2['name'], $array_get)){
                                                $htmlFiltros.=' checked';
                                            };
                                            $htmlFiltros.='>';                                            
                                            $htmlFiltros.='<label class="form-check-label" for="'.$values2['name'].'">'.$values2['nombre'].' </label>';
                                            $htmlFiltros.='</div>';
                                        }
                                    }                                
                                $htmlFiltros.='</div></div></div>';
                            }
                            echo $htmlFiltros;
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
</body>
</html>
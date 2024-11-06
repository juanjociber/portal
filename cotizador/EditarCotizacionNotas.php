<?php
    session_start();
    if(empty($_SESSION['vgrole'])){
        header("location:/portal/admin/index.php");
        exit();
    }
    date_default_timezone_set("America/Lima");
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $IsAdmin = false;
    $CotId = 0;
    $Cotizacion = "";

    if($_SESSION['vgrole'] == 'admin'){
        $IsAdmin = true;
    }

    if(!empty($_GET['cotizacion'])){
        $Query = "";
        if($IsAdmin){
            $Query = "select id, cotizacion from tblcotizaciones where id=:Id;";
        }else{
            $Query = "select id, cotizacion from tblcotizaciones where id=:Id and idvendedor=".$_SESSION['vgid'].";";
        }

        try{
            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt=$conmy->prepare($Query);
            $stmt->execute(array('Id'=>$_GET['cotizacion']));
            $row=$stmt->fetch();
            if($row){
                $CotId = $row['id'];
                $Cotizacion = $row['cotizacion'];
            }
            $stmt=null;
        }catch(PDOException $ex){
            $stmt=null;
        }
    }
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Condiciones | GPEM SAC.</title>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/css/gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <?php if($IsAdmin==false){echo '<link rel="stylesheet" href="/portal/cotizador/menu/sidebar.css">';}?> 
    <link rel="shortcut icon" href="/mycloud/logos/favicon.ico">

    <style>
        .divselect {
            cursor: pointer;
            transition: all .25s ease-in-out;
        }

        .divselect:hover {
            background-color: #ccd1d1;
            transition: background-color .5s;
        }

        .container-wa{
            position: absolute;
            z-index: 3;
            right: 5px;
            top: 0px;
            margin:0px;
            padding:0px;
        }

        .link-wa:hover{
            color: red;
        }

        a.link-colecciones {
            color: black;
            text-decoration: none;
        }
        
        .h-id{
            position: absolute;
            min-width: 40px;
            right: 0px;
        }
        
        .cls-container{
            position: relative;
        }
        
        .cls-container:hover{
            background-color: #C9C7C4;
        }
    </style>
</head>
<body>
    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>    
    <?php
        if($IsAdmin){
            require_once $_SERVER['DOCUMENT_ROOT']."/portal/admin/AdmMenu.php";
        }else{
            require_once $_SERVER['DOCUMENT_ROOT'].'/portal/cotizador/menu/sidebar.php';
        }
    ?>

    <div class="container section-top">
        <div class="row mb-1">
            <div class="col-12 btn-group" role="group" aria-label="Basic example">
                <button type="button" class="btn btn-outline-primary fw-bold" onclick="fnCotizaciones(); return false;"><i class="fas fa-list"></i><span class="d-none d-sm-block">Cotizaciones</span></button>
                <button type="button" class="btn btn-outline-primary fw-bold" onclick="fnResumenCotizacion(<?php echo $CotId;?>); return false;"><i class="fas fa-desktop"></i><span class="d-none d-sm-block">Resúmen</span></button>
            </div>
        </div>

        <div class="row p-2 mb-2">
            <div class="col-12">
                <div class="row border p-1">
                    <div class="col-5 border-end align-self-center text-center">
                        <img class="img-fluid" src="/mycloud/logos/logo-gpem.png" style="max-height: 60px;">
                    </div>
                    <div class="col-7 align-self-center">
                        <input type="text" class="d-none" id="txtCotId" value="<?php echo $CotId;?>" readonly/>
                        <p class="fs-6 text-center fw-bold m-0">COTIZACION</p>
                        <p class="fs-6 text-center fw-bold m-0"><?php echo $Cotizacion; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row border-bottom mb-2">
            <div class="col-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-2">
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionCliente.php?cotizacion=<?php echo $CotId;?>">Cliente</a></li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionCondiciones.php?cotizacion=<?php echo $CotId;?>">Condiciones</a></li>
                        <li class="breadcrumb-item fw-bold"><a href="/portal/cotizador/EditarCotizacionProductos.php?cotizacion=<?php echo $CotId;?>">Productos</a></li>
                        <li class="breadcrumb-item fw-bold active" aria-current="page">Notas</li>
                        <li class="breadcrumb-item d-none d-sm-block fw-bold" aria-current="page"><a href="/portal/cotizador/EditarCotizacionImagenes.php?cotizacion=<?php echo $CotId; ?>">Imágenes</a></li>
                    </ol>
                </nav>
            </div>
        </div>
        
        <div class="row border-bottom pb-2">
            <div class="col-md-12 mb-2">
                <p class="m-0" style="font-size:12px;">Descripción (200)</p>
                <textarea class="form-control" id="txtNota" rows="2"></textarea>
            </div> 
            <div class="col-12">
                <button type="button" class="btn btn-outline-primary form-control" onclick="fnAgregarNota(); return false;"><i class="fas fa-plus"></i> Nota</button>
            </div>
        </div>

        <div class="row p-2">
            <?php
            try{
                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt=$conmy->prepare("select id, descripcion from tblnotascotizacion where cotid=:CotId;");
                $stmt->execute(array('CotId'=>$CotId));
                if($stmt->rowCount()>0){                   
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        echo '
                        <div class="col-12 cls-container border-bottom pt-2 pb-2" style="position: relative;">
                            <div class="container-wa">
                                <a class="text-decoration-none text-secondary p-0" href="#" onclick="fnEliminarNota('.$row['id'].'); return false;"><i class="fas fa-times link-wa fs-4"></i></a>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-1">
                                    <p class="text-secondary mb-0">&#10003 '.$row['descripcion'].'</p>
                                </div>               
                            </div>
                        </div>';
                    }
                }else{
                    echo '
                    <div class="col-12">
                        <p class="fst-italic">No hay notas en la cotización.</p>
                    </div>';
                }
                $stmt=null;
            }catch(PDOException $e){
                $stmt=null;
                echo '
                <div class="col-12">
                    <p class="fst-italic">'.$e->getMessage().'</p>
                </div>';
            }
            ?>
        </div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="/portal/cotizador/js/EditarCotizacionNotas.js"></script>
    <script src="/portal/cotizador/js/EditarCotizacion.js"></script>
    <?php
        if($IsAdmin){
            echo '<script src="/portal/cotizador/js/MenuAdminCotizaciones.js"></script>';
        }else{
            echo '<script src="/portal/cotizador/menu/sidebar.js"></script>';
            echo '<script src="/portal/cotizador/js/MenuPublicCotizaciones.js"></script>';
        }
    ?>
</body>
</html>
<?php
    session_start();
    if(empty($_SESSION['vgusuario'])){
        header("location:/portal/admin");
        exit();
    }

    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";
    $cbRoles="<option value='unknown'>Seleccione un rol</option><option value='user'>Usuario</option><option value='admin'>Administrador</option>";
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios | GPEM SAC.</title>
    <link rel="stylesheet" href="/mycloud/library/fontawesome-free-5.9.0-web/css/all.css">
    <link rel="stylesheet" href="/mycloud/library/gpemsac/css/gpemsac.css">
    <link rel="stylesheet" href="/mycloud/library/bootstrap-5.0.2-dist/css/bootstrap.min.css">
    <link rel="shortcut icon" href="/mycloud/icos/favicon.ico">
    <?php include('AdmMenu.php');?>
</head>

<body class="bg-light section-top">
    <div class="container">
        <div class="row border-bottom border-warning mb-3 align-items-end">
            <div class="col-12 col-sm-6">
                <h4 class="text-secondary fw-bold">[Administración de Usuarios]</h4>
            </div>
            <div class="col-6 text-end d-none d-sm-block">
                <h5><a class="text-decoration-none fw-bold" href="#" onClick="fnModalAgregarUsuario(); return false;">[NUEVO USUARIO]</a></h5>
            </div>
        </div>
        
        <div class="row">
            <div class="col-12">
                <div class="row m-0">
                    <div class="col-12 table-responsive p-0">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr class="bg-azul text-center">
                                    <td>ID</td>
                                    <td>NOMBRE</td>
                                    <td>USUARIO</td>
                                    <td>ROL</td>
                                    <td>HASH</td>
                                    <td>ESTADO</td>
                                    <td><i class="fas fa-edit"></i></td>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    try{
                                        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);                
                                        $stmt1=$conmy->prepare("select idusuario, nombre, usuario, clave, role, estado from tblusuarios;");
                                        $stmt1->execute();
                                        $n=$stmt1->rowCount();
                                        if($n){
                                            while ($row1=$stmt1->fetch(PDO::FETCH_ASSOC)){
                                                $estado="";
                                                switch ($row1['estado']){
                                                    case 1:
                                                        $estado="<span class='badge bg-danger'>INACTIVO</span>";
                                                        break;
                                                    case 2:
                                                        $estado="<span class='badge bg-success'>ACTIVO</span>";
                                                        break;
                                                    default:
                                                        $estado="<span class='badge bg-secondary'>UNKNOWN</span>";
                                                }
                                                echo '<tr>
                                                    <td class="text-center">'.$row1['idusuario'].'</td>
                                                    <td>'.$row1['nombre'].'</td>
                                                    <td>'.$row1['usuario'].'</td>
                                                    <td>'.$row1['role'].'</td>                                           
                                                    <td>'.$row1['clave'].'</td>
                                                    <td class="text-center">'.$estado.'</td>
                                                    <td class="text-center"><a class="fw-bold" href="#" onClick="fnModalModificarUsuario('.$row1['idusuario'].'); return false;"><i class="fas fa-edit"></i></a></td>
                                                </tr>';
                                            }
                                        }else{
                                            echo "<tr><td class='text-center' colspan='7'>BD: No se ha encontrado usuarios para la Empresa.</td></tr>";
                                        }
                                        $stmt1=null;
                                    }catch(PDOException $e){
                                        $stmt1=null;
                                        echo "<tr><td class='text-center' colspan='7'>BD: Error consultando los usuarios.</td></tr>";
                                    }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="modalAgregarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <!--<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">-->
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">AGREGAR USUARIO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pb-0">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label for="cbRol01" class="col-form-label form-control-sm pb-0">ROL:</label>
                            <select id="cbRol01" class="form-select">
                                <option value='0'>Seleccione un rol</option>
                                <option value='admin'>Administrador</option>
                                <option value='seller'>Vendedor</option>
                                <option value='user'>Usuario</option>                                
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="txtNombre01" class="col-form-label form-control-sm pb-0">NOMBRE:</label>
                            <input type="text" class="form-control" id="txtNombre01" value="">
                        </div>
                        <div class="col-md-12">
                            <label for="txtUsuario01" class="col-form-label form-control-sm pb-0 ">USUARIO:</label>
                            <input type="text" class="form-control" id="txtUsuario01" value="">
                        </div>
                        <div class="col-md-12">
                            <label for="txtClave01" class="col-form-label form-control-sm pb-0 ">CONTRASEÑA:</label>
                            <input type="text" class="form-control" id="txtClave01" value="">
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="msjAgregarUsuario"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnAgregarUsuario(
                        document.getElementById('cbRol01').value,
                        document.getElementById('txtNombre01').value,
                        document.getElementById('txtUsuario01').value,
                        document.getElementById('txtClave01').value
                    )">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalModificarUsuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">MODIFICAR USUARIO</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>                
                <div class="modal-body pb-0">
                    <div class="form-row">
                        <div class="col-md-12">
                            <label class="col-form-label form-control-sm pb-0 ">USUARIO:</label>
                            <input type="text" class="d-none" id="txtId02" value="" readonly>
                            <input type="text" class="form-control" id="txtUsuario02" value="" readonly>
                        </div>
                        <div class="col-md-12">
                            <label for="cbRol02" class="col-form-label form-control-sm pb-0">ROL:</label>
                            <select id="cbRol02" class="form-select">
                                <option value='0'>Seleccione un rol</option>
                                <option value='admin'>Administrador</option>
                                <option value='seller'>Vendedor</option>
                                <option value='user'>Usuario</option>                                
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label for="txtNombre02" class="col-form-label form-control-sm pb-0 ">NOMBRE:</label>
                            <input type="text" class="form-control" id="txtNombre02" value="">
                        </div>
                        <div class="col-md-12">
                            <label for="txtClave02" class="col-form-label form-control-sm pb-0 ">CONTRASEÑA:</label>
                            <input type="text" class="form-control" id="txtClave02" value="">
                        </div>
                        <div class="col-md-12">
                            <label for="cbEstado02" class="col-form-label form-control-sm pb-0 ">ESTADO:</label>
                            <select class="form-select" id="cbEstado02">
                                <option value="1">INACTIVO</option>
                                <option value="2">ACTIVO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-body" id="msjModificarUsuario"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">CANCELAR</button>
                    <button type="button" class="btn btn-primary" onclick="fnModificarUsuario(
                        document.getElementById('txtId02').value,
                        document.getElementById('cbRol02').value,
                        document.getElementById('txtNombre02').value,
                        document.getElementById('txtClave02').value,
                        document.getElementById('cbEstado02').value
                    )">GUARDAR</button>
                </div>              
            </div>
        </div>
    </div>

    <div class="container-loader-full">
        <div class="loader-full"></div>
    </div>

    <script src="/mycloud/library/bootstrap-5.0.2-dist/js/bootstrap.min.js"></script>
    <script src="js/AdmUsuarios.js"></script>
</body>
</html>
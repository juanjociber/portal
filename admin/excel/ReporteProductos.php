<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

header("Content-Disposition: attachment; filename=ReporteProductos.xls"); +
header("Pragma: no-cache");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>     
<body>
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Producto</th>
                <th>Código</th>
                <th>Serie</th>
                <th>Marca</th>
                <th>Medida</th>
                <th>SEO_Google</th>
                <th>URL</th>
                <th>Imagen</th>
                <th>Destacado</th>
                <th>Prioridad</th>
                <th>Etiquetas</th>
                <th>Estado</th>
            </tr>
        </thead>
        <tbody>
            <?php            
            if(!empty($_SESSION['vgrole'])){
                $query="";
                if(!empty($_GET['producto'])){
                    $query=" where concat(producto, codigo) like '%".$_GET['producto']."%'";
                }else{
                    if(!empty($_GET['etiqueta'])){
                        $query=" where etiquetas like '%".$_GET['etiqueta']."%'";
                    }
        
                    if(!empty($_GET['estado'])){
                        if($query==""){
                            $query=" where estado=".$_GET['estado'];
                        }else {
                            $query.=" and estado=".$_GET['estado'];
                        }				
                    }
                }

                try{
                    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                    $stmt=$conmy->prepare("select idproducto, producto, codigo, serie, marca, medida, seogoogle, seourl, imagen, destacado, prioridad, etiquetas, estado from tblproductos".$query.";");
                    $stmt->execute();
                    if($stmt->rowCount()){
                        while ($row=$stmt->fetch(PDO::FETCH_ASSOC)){
                            $estado='';
                            switch ($row['estado']) {
                                case 1:
                                    $estado='Inactivo';
                                    break;
                                case 2:
                                    $estado='Activo';
                                    break;
                                default:
                                    $estado='Unknown';
                            };                            
                            echo '
                                <tr>
                                    <td>'.$row['idproducto'].'</td>
                                    <td>'.$row['producto'].'</td>
                                    <td>'.$row['codigo'].'</td>
                                    <td>'.$row['serie'].'</td>
                                    <td>'.$row['marca'].'</td>
                                    <td>'.$row['medida'].'</td>
                                    <td>'.$row['seogoogle'].'</td>
                                    <td>'.$row['seourl'].'</td>
                                    <td>'.$row['imagen'].'</td>
                                    <td>'.$row['destacado'].'</td>
                                    <td>'.$row['prioridad'].'</td>
                                    <td>'.$row['etiquetas'].'</td>
                                    <td>'.$estado.'</td>
                                </tr>';
                        };
                    }else{
                        echo "<tr><td colspan='13'>No se ha encontrado resultados para esta consulta.</td></tr>";
                    };
                    $stmt =null;
                }catch(PDOException $e){
                    $stmt=null;
                    echo "<tr><td colspan='13'>Se ha encontrado un error al descargar este reporte. Favor, comuníquese con el Administrador del sistema. ".$e."</td></tr>";
                }
            }else{
                echo "<tr><td colspan='13'>El Usuario no puede ejecutar esta consulta.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</body>
</html>
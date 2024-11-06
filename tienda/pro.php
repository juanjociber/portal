<?php

    include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
    include($_SERVER['DOCUMENT_ROOT']."/portal/config/config.php");

    $array_galerias=array();
    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt1=$conmy->prepare('select idproducto, idcategoria, producto, serie, marca, precio, caracteristicas, seogoogle, imagen, informacion, stock, cupon from tblproductos where seourl=:SeoUrl and estado=2');
        $stmt1->execute(array('SeoUrl'=>$_GET['producto']));
        $row1=$stmt1->fetch();
        $idcategoria=$row1['idcategoria'];
        $producto=$row1['producto'];
        $marca=$row1['marca'];
        $serie=$row1['serie'];
        $precio=$row1['precio'];
        $caracteristicas=$row1['caracteristicas'];
        $ceoggogle=$row1['ceogoogle'];
        $imagen=$row1['imagen'];
        $informacion=$row1['informacion'];
        $stock=$row1['stock'];
        $cupon=$row1['cupon'];
        $stmt1=null;
        echo $producto;

        $stmt2=$conmy->prepare("select archivo, descripcion from tblgalerias where idproducto=:IdProducto and estado=2;");
        $stmt2->bindParam(':IdProducto', $_GET['id'], PDO::PARAM_INT);
        $stmt2->execute();
        while ($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
            $array_galerias[]=array(
                'archivo'=>$row2['archivo'],
                'descripcion'=>$row2['descripcion']
            );
        }
        $stmt2=null;
    }catch(PDOException $e){
        $stmt1=null;
        $stmt2=null;
        echo $e;
    }

    echo $_GET['producto'];
?>
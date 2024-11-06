<?php
    //echo json_encode(fnConsultarPedido(90));
    function fnConsultarPedido($id){
        include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
        $data=array();

        try{
            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt1=$conmy->prepare("select idpedido, factura_fecha, factura_tipo, factura_ruc, factura_empresa, factura_nombres, factura_apellidos, factura_telefono, factura_correo, factura_direccion, factura_nota from tblpedidos where idpedido=:IdPedido;");
            $stmt1->execute(array('IdPedido'=>$id));
            $row1=$stmt1->fetch();
            if($row1){
                $data['pedido']=array(
                    'factura_id'=>$row1['idpedido'],
                    'factura_fecha'=>$row1['factura_fecha'],
                    'factura_tipo'=>$row1['factura_tipo'],
                    'factura_ruc'=>$row1['factura_ruc'],
                    'factura_empresa'=>$row1['factura_empresa'],
                    'factura_nombres'=>$row1['factura_nombres'],
                    'factura_apellidos'=>$row1['factura_apellidos'],
                    'factura_telefono'=>$row1['factura_telefono'],
                    'factura_correo'=>$row1['factura_correo'],
                    'factura_direccion'=>$row1['factura_direccion'],
                    'factura_nota'=>$row1['factura_nota']
                );
            }

            $stmt1=null;

            $stmt2=$conmy->prepare("select idproducto, codigo, producto, marca, cantidad, medida from tbldetallepedido where idpedido=:IdPedido;");
            $stmt2->bindParam(':IdPedido', $id, PDO::PARAM_INT);
            $stmt2->execute();
            while ($row2=$stmt2->fetch(PDO::FETCH_ASSOC)){
                $data['detalle'][]=array(
                    'codigo'=>$row2['codigo'],
                    'producto'=>$row2['producto'],
                    'marca'=>$row2['marca'],
                    'cantidad'=>$row2['cantidad'],
                    'medida'=>$row2['medida'],
                    'img'=>$row2['idproducto'].".jpg"                           
                );
            }
            $stmt2=null;
        }catch(PDOException $e){
            $stmt1=null;
            $stmt2=null;
        }
        return $data;
    }
?>
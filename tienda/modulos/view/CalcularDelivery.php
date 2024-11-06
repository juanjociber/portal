<?php
    session_start();
    
    $data=array();
    $res="400";
    $msg="Tenemos problemas para calcular el costo de envio.";
    $costo=0;

    if(!empty($_POST['distrito'] and !empty($_SESSION['car'][1]))){
        $costo=fnCalcularDelivery($_POST['distrito']);
        if(!empty($costo)){
            $res="200";
            $msg="ok.";
        }
    }

    $data[]=array('res'=>$res);
	$data[]=array('msg'=>$msg);
	$data[]=array('costo'=>$costo);

	echo json_encode($data);

    function fnCalcularDelivery($distrito){
        include($_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php");
        $NUM_PAQUETES=0;
        $UMT=0;//Unidad Medida de Transporte
        $COSTO_PAQUETE=0; //Costo minimo por movilidad
        $PRECIO_ENVIO=0; //Precio minimo por movilidad

        $delivery1=0;//Precio delivery en moto
        $delivery2=0;//Precio delivery en auto
        $delivery3=0;//Precio delivery en camión

        try{
            $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt3=$conmy->prepare("select umt, delivery1, delivery2, delivery3 from tbldistritos where distrito=:Distrito;");
            $stmt3->execute(array('Distrito'=>$distrito));
            $row3=$stmt3->fetch();
            if($row3){
                $UMT=$row3['umt'];
                $delivery1=$row3['delivery1'];
                $delivery2=$row3['delivery2'];
                $delivery3=$row3['delivery3'];
            }
            $stmt1=null;

            foreach($_SESSION['car'][1] as $indice=>$producto){
                $NUM_PAQUETES+=$producto['cantidad']*$producto['ump'];
            }
        
            $NUM_PAQUETES=ceil($NUM_PAQUETES);
            switch($NUM_PAQUETES){
                case($NUM_PAQUETES<=2):
                    $COSTO_PAQUETE=$delivery1;
                break;
                case (($NUM_PAQUETES>=3) && ($NUM_PAQUETES<=10)):
                    $COSTO_PAQUETE=$delivery2;
                break;
                default:
                    $COSTO_PAQUETE=$delivery3;
            }
        
            $PRECIO_ENVIO=$COSTO_PAQUETE*$UMT;

        }catch(PDOException $e){
            $stmt1=null;
        }

        return $PRECIO_ENVIO;
    }
?>
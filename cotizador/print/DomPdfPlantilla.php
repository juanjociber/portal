<?php 
    require_once $_SERVER['DOCUMENT_ROOT']."/portal/config/fnconexmysql.php";

    $Id=0;

    $Id=$_GET['cotizacion'];
    $Cotizacion="";
    $Fecha="";
    $CliRuc="";
    $CliNombre="";
    $CliDireccion="";
    $CliContacto="";
    $CliTelefono="";
    $CliCorreo="";
    $VendNombre="";
    $CotTiempo=0;
    $CotPago="";
    $CotEntrega="";
    $CotLugar="";
    $CotMoneda="";
    $Igv=0;
    $Descuento=0;
    $Observaciones="";

    $TotValorVenta=0; // suma del valor de los productos
    $TotDescuentos=0; // vlor de la venta * descuento
    $BaseImponible=0; // valor de la venta - descuentos
    $TotImpuestos=0; // base imponible por igv
    $TotPrecioVenta=0; // base imponible + impuestos

    try{
        $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt=$conmy->prepare("select id, cotizacion, fecha, cliruc, clinombre, clidireccion, clicontacto, clitelefono, clicorreo, vendnombre, tiempo, pago, entrega, lugar, moneda, igv, descuento, obs from tblcotizaciones where id=:Id;");
        $stmt->execute(array('Id'=>$Id));
        $row=$stmt->fetch();
        if($row){
            $Cotizacion=$row['cotizacion'];
            $Fecha=$row['fecha'];
            $CliRuc=$row['cliruc'];
            $CliNombre=$row['clinombre'];
            $CliDireccion=$row['clidireccion'];
            $CliContacto=$row['clicontacto'];
            $CliTelefono=$row['clitelefono'];
            $CliCorreo=$row['clicorreo'];
            $VendNombre=$row['vendnombre'];
            $CotTiempo=$row['tiempo'];
            $CotPago=$row['pago'];
            $CotEntrega=$row['entrega'];
            $CotLugar=$row['lugar'];
            $CotMoneda=$row['moneda'];
            $Igv=$row['igv'];
            $Descuento=$row['descuento'];
            $Observaciones=$row['obs'];
        }
        $stmt=null;
    }catch(PDOException $ex){
        $stmt=null;
    }

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Cotizacion</title>
    <style>
            /** 
                Establezca los márgenes de la página en 0, por lo que el pie de página y el encabezado
                puede ser de altura y anchura completas.
             **/
            @page {
                margin: 0cm 0cm;
            }

            *{
                font-family: DejaVu Sans, sans-serif;
                font-size: 11px;
            }

            .fs-9{
                font-size:9px;
            }

            .fs-12{
                font-size: 12px;
            }

            .fw-bold{
                font-weight:bold;
            }

            /** Defina ahora los márgenes reales de cada página en el PDF **/
            body {
                margin-top: 3cm;
                margin-left: 1cm;
                margin-right: 1cm;
                margin-bottom: 2cm;
            }

            /** Definir las reglas del encabezado **/
            header {
                position: fixed;
                top: 0.5cm;
                left: 1cm;
                right: 1cm;
                height: 4cm;
            }

            /** Definir las reglas del pie de página **/
            footer {
                position: fixed; 
                bottom: 1.5cm; 
                left: 0cm; 
                right: 0cm;
                height: 2cm;
            }

            main{
                left:1cm;
                right:1cm;
            }
        </style>

</head>
<body>
    <?php
        $imagenBase64 = "data:image/png;base64," . base64_encode(file_get_contents($_SERVER['DOCUMENT_ROOT']."/mycloud/logos/logo-gpem.png"));    
    ?>
    <header>
        <table style="border-spacing:0; width: 100%;">
            <tr>
                <td rowspan="2" style="width: 25%;"><img src="<?php echo $imagenBase64; ?>" style="height: 50px;"></td>
                <td style="text-align:center; font-weight: bold; font-size:14px; padding:3px; width:50%;">GESTION DE PROCESOS EFICIENTES DE MANTENIMIENTO S.A.C.</td>                     
                <td style="border-right:1px solid; border-top: 1px solid; border-left:1px solid; padding:5px; text-align:center; font-weight:bold; font-size:16px; width:25%;">COTIZACION</td>                     
            </tr>
            <tr>
                <td style="text-align:center;">Av. Los Incas S/N - Comas <br> Telf: 01-7130628</td>
                <td style="border-bottom: 1px solid; border-right: 1px solid; border-left:1px solid; padding:5px; text-align:center; font-weight:bold; font-size:16px;"><?php echo $Cotizacion; ?></td>
            </tr>
        </table>
    </header>

    <footer>
        <table style="width: 100%; border-top:1px solid #B4B4B4;">
            <tr>
                <td style="text-align:center;">AV. Los Incas 4ta Cuadra S/N - Comas - Lima - Per&uacute; - Telf. (511) 7130629 Anexo 308</td>
            </tr>
            <tr>
                <td style="text-align: center">e-mail: g.administracion@gpemsac.com</td>
            </tr>
            <tr>
                <td style="background-color: red;">
                    <img src="/mycloud/portal/empresa/footer/gpemsac.jpg" style="width:100%;">
                </td>
            </tr>
        </table>
    </footer>

    <main>
        <p style="width:95%; text-align:right; margin-bottom:1px;"><?php echo $Fecha; ?></p>
        <p style="margin-bottom: 3px;">Se&ntilde;ores:</p>
        <p style="margin: 3px 0px; font-weight:bold;"><?php echo utf8_encode($CliNombre); ?></p>
        <p style="margin: 3px 0px;">RUC: <?php echo $CliRuc; ?></p>
        <p style="margin: 3px 0px;">Dirección: <?php echo utf8_encode($CliDireccion); ?></p>
        <p style="margin: 3px 0px;">Contacto: <?php echo utf8_encode($CliContacto); ?></p>
        <p style="margin: 3px 0px;">Teléfono: <?php echo utf8_encode($CliTelefono);?></p>
        <p style="margin: 3px 0px;">Correo: <?php echo utf8_encode($CliCorreo);?></p>

        <p>De nuestra especial consideraci&oacute;n, es grato dirigirnos a Uds. para remitir la siguiente cotizaci&oacute;n.</p>

        <!--<table style="width: 100%; border-collapse: collapse;">-->
        <table style="width:100%; border-spacing:0; page-break-after: always;">
            <tr style="background-color:#001466; color:white; text-align:center;">
                <td style="padding:8px; text-align:right; width: 5%">Item</td>
                <td style="padding:8px; width: 40%;">Descripci&oacute;n</td>
                <td style="padding:8px; text-align:right;">Cantidad</td>
                <td style="padding:8px;">Medida</td>
                <td style="padding:8px; text-align:right;">Valor Unitario</td>
                <td style="padding:8px; text-align:right;">Precio Unitario</td>
                <td style="padding:8px; text-align:right;">Valor Venta</td>
            </tr>        
        <?php
            try{
                $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt=$conmy->prepare("select codigo, producto, cantidad, precio, medida from tbldetallecotizacion where idcotizacion=:Cotizacion;");
                $stmt->execute(array('Cotizacion'=>$Id));
                if($stmt->rowCount()>0){
                    $i=1;
                    $PrecioUnitario=0;
                    $ValorVenta=0;               
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                        $PrecioUnitario=$row['precio']*(1+($Igv/100));
                        $ValorVenta=$row['cantidad']*$row['precio'];
                        $TotValorVenta+=$ValorVenta;
                        echo '
                        <tr>
                            <td style="padding:8px 5px 8px 5px; text-align:right; border-bottom: 1px solid #B4B4B4;">'.$i.'</td>
                            <td style="padding:8px 5px 8px 5px; border-bottom: 1px solid #B4B4B4;">'.$row['codigo'].' '.utf8_encode($row['producto']).'</td>
                            <td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $row['cantidad']).'</td>
                            <td style="padding:8px 5px 8px 5px; border-bottom: 1px solid #B4B4B4;">'.utf8_encode($row['medida']).'</td>
                            <td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $row['precio']).'</td>
                            <td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $PrecioUnitario).'</td>
                            <td style="padding:8px 5px 8px 5px; text-align: right; border-bottom: 1px solid #B4B4B4;">'.sprintf('%.2f', $ValorVenta).'</td>
                        </tr>';
                        $i+=1;
                    }
                    
                    $TotDescuentos = $TotValorVenta * ($Descuento/100);
                    $BaseImponible = $TotValorVenta - $TotDescuentos;
                    $TotImpuestos = $BaseImponible * ($Igv/100);
                    $TotPrecioVenta = $BaseImponible + $TotImpuestos;

                    echo '
                        <tr>
                            <td colspan="6" style="padding:8px 5px 8px 5px; text-align: right;">Total Venta $</td>
                            <td style="padding:8px 5px 8px 5px; text-align: right;">'.sprintf('%.2f', $TotValorVenta).'</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding:8px 5px 8px 5px; text-align: right;">Total con Descuento('.$Descuento.'%) $</td>
                            <td style="padding:8px 5px 8px 5px; text-align: right;">'.sprintf('%.2f', $BaseImponible).'</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding:8px 5px 8px 5px; text-align: right;">Total IGV('.$Igv.'%) $</td>
                            <td style="padding:8px 5px 8px 5px; text-align: right;">'.sprintf('%.2f', $TotImpuestos).'</td>
                        </tr>
                        <tr>
                            <td colspan="6" style="padding:8px 5px 8px 5px; text-align: right; font-weight:bold;">Monto Total $</td>
                            <td style="padding:8px 5px 8px 5px; text-align:right; font-weight:bold;">'.sprintf('%.2f', $TotPrecioVenta).'</td>
                        </tr>';
                }else{
                    //
                }
                $stmt=null;
            }catch(PDOException $e){
                $stmt=null;
            }
            ?>
        </table>
        <p>CONDICIONES COMERCIALES</p>
        <ul>
            <li>Descuento: <?php echo $Descuento;?>%</li>
            <li>Moneda: D&oacute;lares americanos</li>
            <li>Tiempo de oferta: <?php echo $CotTiempo;?> d&iacute;as</li>
            <li>Condici&oacute;n de pago: <?php echo $CotPago;?></li>
            <li>Plazo de Entrega: <?php echo utf8_encode($CotEntrega);?></li>
            <li>Lugar de entrega: <?php echo utf8_encode($CotLugar);?></li>            
            <li>Observaciones: <?php echo utf8_encode($Observaciones);?></li>
        </ul>
        <table style="width: 100%; border-collapse: collapse; text-align:center; margin-bottom: 15px;">
            <tr>
                <td class="fs-9 fw-bold" style="border: 1px solid; padding: 5px; text-align: center;" colspan="6">GESTION DE PROCESOS EFICIENTES DE MANTENIMIENTO S.A.C.</td>
            </tr>
            <tr>
                <td class="fs-9" style="border: 1px solid; padding: 5px;" colspan="2">RUC: 20566384826</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;" colspan="4">DIRECCION: AV. LOS INCAS 4TA CUADRA S/N -COMAS</td>
            </tr>
            <tr>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">ITEM</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">BANCO</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">MONEDA</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">TIPO DE CUENTA</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">NRO DE CUENTA</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">CODIGO INTERBANCARIO</td>
            </tr>
            <tr>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">1</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">BBVA BANCO CONTINENTAL</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">MN</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">CUENTA CORRIENTE</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">001 0333 0100108365</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">001 333 000100108365 26</td>
            </tr>
            <tr>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">2</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">BBVA BANCO CONTINENTAL</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">ME</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">CUENTA CORRIENTE</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">001 0333 0100108373</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">001 333 000100108373 20</td>
            </tr>
            <tr>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">3</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">BANCO DE LA NACION</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">MN</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">CUENTA DETRACCION</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;">00-003-163202</td>
                <td class="fs-9" style="border: 1px solid; padding: 5px;"></td>
            </tr>
        </table>
        <p>Sin otro tema en particular nos despedimos de Ud, esperando la confirmaci&oacute;n de nuestros servicios.</p>
        <p>Saludos cordiales.</p>
        <p class="fs-12 fw-bold" style="text-decoration: underline; padding:0px; margin:0px;"><?php echo utf8_encode($VendNombre); ?></p>
        <p style="padding:0px; margin:0px;">Asesor Comercial</p>
        <p style="padding:0px; margin:0px;">GPEM SAC.</p>
    </main>
</body>
</html>
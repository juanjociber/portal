<?php
    try {
        // Cargamos Requests y Culqi PHP
        //include_once dirname(__FILE__).'/culqi/Requests/library/Requests.php';
        include_once ($_SERVER['DOCUMENT_ROOT'].'/tienda/librerias/culqi/Requests/library/Requests.php');
        Requests::register_autoloader();
        include_once ($_SERVER['DOCUMENT_ROOT'].'/tienda/librerias/culqi/culqi-php/lib/culqi.php');
        
        // Configurar tu API Key y autenticación
        $SECRET_KEY = "sk_test_e4af8aa6a21b1995";
        $culqi = new Culqi\Culqi(array('api_key' => $SECRET_KEY));

        $charge = $culqi->Charges->create(
            array(
                "amount" => $_POST['precio'],
                "currency_code" => "PEN",
                "description" => 'Venta de: '.$_POST['producto'],
                "email" => $_POST['email'],
                "source_id" => $_POST['token']
            )
        );
        echo json_encode($charge);
    } catch (Exception $e) {
        echo json_encode($e->getMessage());
    }
?>
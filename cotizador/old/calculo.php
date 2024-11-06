<?php
    $Moneda="USD";
    $Tasa=3.14;

    $ProductoMoneda="PEN";

    $ValorUnitario=10;

    echo "Moneda / Tasa Cotización: ".$Moneda." => ".$Tasa."</br></br>";
    echo "Precio original: ".$ProductoMoneda." => ".$ValorUnitario."</br></br>";

    // Bucle ForEach{};

    //Solo se considera USD como segunda moneda, el resto de casos se considera como PEN
    if($Moneda == "USD"){
        if($ProductoMoneda == "PEN"){
           $ValorUnitario = $ValorUnitario / $Tasa;
        }
    }else{
        if ($ProductoMoneda == "USD"){
            $ValorUnitario = $ValorUnitario * $Tasa;
        }
    }

    echo "Precio final: ".$Moneda." => ".$ValorUnitario."</br>";


?>
<?php
// Asegurate de que es un archivo realmente válido
// Recuperamos el archivo
//$archivo = "e:\clientes\empresa\prueba.xlsx";
$archivo = $_SERVER['DOCUMENT_ROOT'].'/mycloud/portal/cotizador/plantillas/plantilla_precios.xlsx';

// Nos aseguramos que el archivo exista
if (!file_exists($archivo)) {
    echo "El fichero $archivo no existe";
    exit;
}

// Establecemos el nombre del archivo
header('Content-Disposition: attachment;filename="'. 'plantilla_precios_v1.xlsx"');

// Esto  
// header("Content-Type: application/vnd.openxmlformats-   officedocument.spreadsheetml.sheet");
// lo cambiamos por esto
header('Content-Type: application/vnd.ms-excel');

// Indicamos el tamaño del archivo 
header('Content-Length: '.filesize($archivo));

// Evitamos que sea cachedo 
header('Cache-Control: max-age=0');

// Realizamos la salida del fichero
readfile($archivo);

// Fin del cuento
exit;
?>
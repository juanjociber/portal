<?php
    $host = 'localhost';
    $db = 'gpemsac_tienda';
    $usuario = 'root';
    $password = 'mysql';

    $conmy = new PDO("mysql:host=$host;dbname=$db", $usuario, $password);

    $conmy->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $query = !empty($_GET['filtro']) ? $_GET['filtro'] : '';

    if ($query !== '') {
        $stmt = $conmy->prepare("SELECT * FROM tblproductos WHERE producto LIKE ?");
        $stmt->execute(["%$query%"]);

        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        echo json_encode($results);
    } else {
        echo json_encode(array());
    }
?>
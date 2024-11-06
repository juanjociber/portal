<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <title>Subida de Excel con Javascript</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.15.3/xlsx.full.min.js"></script>
  

</head>
<body>
<div class="container">
        <h4>Subida de Excel con Javascript y conversion a JSON</h4>
        <div class="panel panel-primary">
            <div class="panel-heading">Converso de EXCEL a JSON</div>
            <div class="panel-body">
                <!-- Input type file to upload excel file -->
                <input type="file" id="fileUpload" accept=".xls,.xlsx"/><br />
                <button type="button" id="uploadExcel" onclick="fnConvertir(); return false;";>Convert</button>
                <button type="button" onclick="fnProcesarExcel(); return false;">Procesar</button>

                <!-- Render parsed JSON data here -->
                <div style="margin-top:10px;">
                    <pre id="jsonData"></pre>
                </div>
            </div>
        </div>
    </div>
    <script src="/portal/cotizador/js/ImportarExcel.js"></script>
  </body>
</html>
</body>
</html>
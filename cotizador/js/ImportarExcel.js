
var selectedFile;
var jsonObject;

document.getElementById("fileUpload").addEventListener("change", function(event) {
    selectedFile = event.target.files[0];
});

/*
document
  .getElementById("uploadExcel")
  .addEventListener("click", function() {
    if (selectedFile) {
      var fileReader = new FileReader();
      fileReader.onload = function(event) {
        var data = event.target.result;

        var workbook = XLSX.read(data, {
          type: "binary"
        });
        workbook.SheetNames.forEach(sheet => {
          let rowObject = XLSX.utils.sheet_to_row_object_array(
            workbook.Sheets[sheet]
          );
          //jsonObject = JSON.stringify(rowObject);
          jsonObject = rowObject;
          console.log(jsonObject);
        });
      };
      fileReader.readAsBinaryString(selectedFile);
    }
  });*/

var myArray;
async function fnConvertir(){
  if (selectedFile) {
    var fileReader = new FileReader();
    fileReader.onload = function(event){
      var data = event.target.result;
      var workbook = XLSX.read(data, {type: "binary"});
      workbook.SheetNames.forEach(sheet => {
        myArray = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
      });
    };
    fileReader.readAsBinaryString(selectedFile);
  }
  return false;
}
  


  async function fnProcesarExcel() {
    /*var jsonData = {
        Salida: [],
        Detalle: []
    };
    jsonData['Salida'] = {
        FacIdSerie: document.getElementById("cbSerie").value,
        FacTipo: document.getElementById("cbTipoComprobante").value,
        FacFechaEmision: document.getElementById('dtpFechaEmision').value,
    }
    productos.forEach(element => {
        jsonData['Detalle'].push({
            IdProducto: element.id,
            Codigo: element.codigo,
            Producto: element.producto,
            Medida: element.medida,
            MedIso: element.mediso,
            Cantidad: element.cantidad,
            PrecioUnitario: element.precio,
            TributoCodigo: element.tributo
        });
    })*/

    const response = await this.fetch("/portal/cotizador/excel/ProcesarExcel.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(myArray)
    })
   /*.then(res => res.json())
    .catch(err => console.log(err));*/
    .then(response => response.text())
    .then((response) => {
        console.log(response)
    })
    .catch(err => console.log(err))
    return response;
}
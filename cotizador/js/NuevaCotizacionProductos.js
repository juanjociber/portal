const vgLoader=document.querySelector('.container-loader-full');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    ActivarMenu();
};

var modalBuscarProductos=new bootstrap.Modal(document.getElementById('modalBuscarProductos'), {
    keyboard: false
});


function fnModalBuscarProductos(){
    document.getElementById('msjModalBuscarProductos').innerHTML="";
    modalBuscarProductos.show();
};

async function fnBuscarProductos() {
    vgLoader.classList.remove('loader-full-hidden');
    document.getElementById("divProductos").innerHTML = '';
    const data = await fnBuscarProductos2();
    if (data.res === '200') {
        data.data.forEach(prod => {
            document.getElementById("divProductos").innerHTML += `
            <div class="col-12 border-bottom mb-1 divselect" dataId='${prod.id}' dataCodigo='${prod.codigo}' dataMoneda='${prod.moneda}' dataNombre='${prod.nombre}' dataMedida='${prod.medida}' dataPrecio='${prod.precio}' onclick=fnCargarProducto(this); return false>
                <p class="mb-0">${prod.nombre}</p>
                <p class="mb-0">${prod.medida}</p>
                <p class="mb-0 fw-bold">${prod.moneda} ${prod.precio}</p>
            </div>`;
        });
        document.getElementById('msjModalBuscarProductos').innerHTML = '';
    } else {
        document.getElementById('msjModalBuscarProductos').innerHTML = `<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data.msg}</div>`;
    }
    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    })
    return false;
}

async function fnBuscarProductos2(){
    const data = new FormData();
    data.append('producto', document.getElementById('txtBuscarProducto').value);
    data.append('tprecio', document.getElementById('txtCotTipoPrecio').value);
    const response = await this.fetch('/portal/cotizador/search/BuscarProductosCotizacion.php', {
        method:'POST', 
        body:data
        })
    .then(res=>res.json())
    .catch(err => console.log(err));
    /*.then(response => response.text())
    .then((response) => {
        console.log(response)
    })
    .catch(err => console.log(err))*/
    return response;
}

function fnCargarProducto(producto) {
    document.getElementById('txtProId').value = producto.getAttribute('dataId');
    document.getElementById('txtProCodigo').value = producto.getAttribute('dataCodigo');
    document.getElementById('txtProNombre').value = producto.getAttribute('dataNombre');
    document.getElementById('txtProMedida').value = producto.getAttribute('dataMedida');
    document.getElementById('txtProCantidad').value = 1;
    document.getElementById('txtProPrecio').value = producto.getAttribute('dataPrecio');    
    document.getElementById('txtProMoneda').value = producto.getAttribute('dataMoneda');
    document.getElementById('spanProMoneda').innerHTML=producto.getAttribute('dataMoneda');
    modalBuscarProductos.hide();
    return false;
}

async function fnAgregarProducto(){
    vgLoader.classList.remove('loader-full-hidden');
    const data = await fnAgregarProducto2();
    if (data.res === '200') {
        location.reload();
    } else {
        alert(data.msg);
    }
    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    })
    return false;
}

async function fnAgregarProducto2(){
    const data = new FormData();
    data.append('action', 'add');
    data.append('proid', document.getElementById('txtProId').value);
    data.append('procodigo', document.getElementById('txtProCodigo').value);
    data.append('pronombre', document.getElementById('txtProNombre').value);
    data.append('promedida', document.getElementById('txtProMedida').value);    
    data.append('promoneda', document.getElementById('txtProMoneda').value);    
    data.append('proprecio', document.getElementById('txtProPrecio').value);
    data.append('procantidad', document.getElementById('txtProCantidad').value);
    data.append('proestado', document.getElementById('cbEstado').value);
    const response = await this.fetch('/portal/cotizador/update/ActualizarCotizacionProductosSesion.php', {
        method:'POST', 
        body:data
        })
    .then(res=>res.json())
    .catch(err => console.log(err));
    /*.then(response => response.text())
    .then((response) => {
        console.log(response)
    })
    .catch(err => console.log(err))*/
    return response;
}


async function fnEliminarProducto(indice){
    vgLoader.classList.remove('loader-full-hidden');
    const data = await fnEliminarProducto2(indice);
    if (data.res === '200') {
        location.reload();
    } else {
        alert(data.msg);
    }
    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    })
    return false;
}

async function fnEliminarProducto2(indice){
    const data = new FormData();
    data.append('action', 'del');
    data.append('indice', indice);
    const response = await this.fetch('/portal/cotizador/update/ActualizarCotizacionProductosSesion.php', {
        method:'POST', 
        body:data
        })
    .then(res=>res.json())
    .catch(err => console.log(err));
    /*.then(response => response.text())
    .then((response) => {
        console.log(response)
    })
    .catch(err => console.log(err))*/
    return response;
}


var myExcel;
var selectedFile;
var modalCargarExcel=new bootstrap.Modal(document.getElementById('modalCargarExcel'), {keyboard: false});

function fnModalCargarExcel(){
    modalCargarExcel.show();
};

//Detectar el archivo seleccionado
document.getElementById("fileUpload").addEventListener("change", function(event){
    selectedFile = event.target.files[0];
    document.getElementById('txtExcelMensaje').innerHTML += 'Archivo seleccionado.\n';
    document.getElementById('txtExcelMensaje').innerHTML += '=> Haga clic en el botón [Procesar].\n';
    document.getElementById('btnProcesarExcel').removeAttribute('disabled');
});

async function fnProcesarExcel(){
    vgLoader.classList.remove('loader-full-hidden');
    if (selectedFile) {
        var fileReader = new FileReader();
        fileReader.onload = function(event){
            var data = event.target.result;
            var workbook = XLSX.read(data, {type: "binary"});
            workbook.SheetNames.forEach(sheet => {
                myExcel = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheet]);
            });
        };
        console.log(myExcel);
        fileReader.readAsBinaryString(selectedFile);
        document.getElementById('txtExcelMensaje').innerHTML +='Archivo procesado.\n';
        document.getElementById('txtExcelMensaje').innerHTML += '=> Haga clic en el botón [Guardar].\n';
        document.getElementById('btnGuardarExcel').removeAttribute('disabled');
        document.getElementById('btnProcesarExcel').setAttribute('disabled', '')
    }else{
        document.getElementById('txtExcelMensaje').innerHTML += 'No hay archivo para procesar.\n';
    }
    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    });
  return false;
}

async function fnGuardarExcel(){
    vgLoader.classList.remove('loader-full-hidden');
    document.getElementById('btnGuardarExcel').setAttribute('disabled','');
    const datos = await fnGuardarExcel2();
    if (datos.res === '200') {
        document.getElementById('txtExcelMensaje').innerHTML +='Productos registrados correctamente.\n';
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                location.reload();
            }, 500)
        });        
    } else {
        document.getElementById('txtExcelMensaje').innerHTML += datos.msg + '.\n';
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                vgLoader.classList.add('loader-full-hidden');
            }, 500)
        });
    }    
    return false;
}

async function fnGuardarExcel2() {
    const response = await this.fetch("/portal/cotizador/update/ActualizarCotizacionProductosSesionMasivo.php", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(myExcel)
    })
    .then(res => res.json())
    .catch(err => console.log(err));
    /*.then(response => response.text())
      .then((response) => {
        console.log(response)
    })
    .catch(err => console.log(err))*/
    return response;
}

function fnDescargarPlantilla(){
    window.location.href='/portal/cotizador/download/PlantillaCotizacionProductos.php';
    return false;
}
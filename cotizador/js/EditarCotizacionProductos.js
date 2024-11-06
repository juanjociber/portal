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
            <div class="col-12 border-bottom mb-1 divselect" dataId='${prod.id}' dataCodigo='${prod.codigo}' dataNombre='${prod.nombre}' dataMedida='${prod.medida}' dataMoneda='${prod.moneda}' dataPrecio='${prod.precio}' onclick=fnCargarProducto(this); return false>
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
    data.append('tprecio', document.getElementById('txtTipoPrecio').value);
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
    document.getElementById('spanProMoneda').innerHTML = producto.getAttribute('dataMoneda');
    modalBuscarProductos.hide();
    return false;
}

async function fnAgregarProducto(){
    vgLoader.classList.remove('loader-full-hidden');    
    const datos = await fnAgregarProducto2();
    if (datos.res === '200') {
        location.reload();
    } else {
        alert(datos.msg);
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
    data.append('cotid', document.getElementById('txtCotId').value);
    data.append('proid', document.getElementById('txtProId').value);
    data.append('procodigo', document.getElementById('txtProCodigo').value);
    data.append('pronombre', document.getElementById('txtProNombre').value);
    data.append('promedida', document.getElementById('txtProMedida').value);
    data.append('proprecio', document.getElementById('txtProPrecio').value);
    data.append('promoneda', document.getElementById('txtProMoneda').value);
    data.append('procantidad', document.getElementById('txtProCantidad').value);
    data.append('proestado', document.getElementById('cbEstado').value);
    const response = await this.fetch('/portal/cotizador/update/ActualizarCotizacionProductosBd.php', {
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


async function fnEliminarProducto(id){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnEliminarProducto2(id);
    if (datos.res === '200') {
        location.reload();
    } else {
        alert(datos.msg);
    }
    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    })
    return false;
}

async function fnEliminarProducto2(id){
    const data = new FormData();
    data.append('action', 'del');
    data.append('indice', id);
    data.append('cotid',document.getElementById('txtCotId').value)
    const response = await this.fetch('/portal/cotizador/update/ActualizarCotizacionProductosBd.php', {
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
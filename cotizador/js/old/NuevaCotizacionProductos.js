const vgLoader=document.querySelector('.container-loader-full');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    document.getElementById('MenuCotizaciones').classList.add('menu-activo');
};

var modalBuscarProductos=new bootstrap.Modal(document.getElementById('modalBuscarProductos'), {
    keyboard: false
});

function fnModalBuscarProductos(){
    document.getElementById('msjModalBuscarProductos').innerHTML="";
    modalBuscarProductos.show();
};

async function fnBuscarProductos(producto) {
    vgLoader.classList.remove('loader-full-hidden');
    document.getElementById("divProductos").innerHTML = '';
    const data = await fnBuscarProductos2(producto);
    if (data.res === '200') {
        data.data.forEach(prod => {
            document.getElementById("divProductos").innerHTML += `
            <div class="col-12 border-bottom mb-1 divselect" dataId='${prod.id}' dataNombre='${prod.nombre}' dataPrecio='${prod.ppublico}' onclick=fnCargarProducto(this); return false>
                <p class="mb-0">${prod.nombre}</p>
                <p class="mb-0">${prod.medida}</p>
                <p class="mb-0 fw-bold">Precio $: ${prod.ppublico}</p>
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

async function fnBuscarProductos2(producto){
    const data = new FormData();
    data.append('producto', producto);
    data.append('pagina', 0);
    const response = await this.fetch('search/BuscarProductos.php', {
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
    document.getElementById('txtProNombre').value = producto.getAttribute('dataNombre');
    document.getElementById('txtProCantidad').value = 1;
    document.getElementById('txtProPrecio').value = producto.getAttribute('dataPrecio');
    modalBuscarProductos.hide();
    return false;
}

async function fnAgregarProducto(producto, cantidad){
    vgLoader.classList.remove('loader-full-hidden');
    const data = await fnAgregarProducto2(producto, cantidad);
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

async function fnAgregarProducto2(producto, cantidad){
    const data = new FormData();
    data.append('action', 'add');
    data.append('producto', producto);
    data.append('cantidad', cantidad);
    const response = await this.fetch('update/ActualizarCotizacionProductos.php', {
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


async function fnEliminarProducto(producto){
    vgLoader.classList.remove('loader-full-hidden');
    const data = await fnEliminarProducto2(producto);
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

async function fnEliminarProducto2(producto){
    const data = new FormData();
    data.append('action', 'del');
    data.append('producto', producto);
    const response = await this.fetch('update/ActualizarCotizacionProductos.php', {
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
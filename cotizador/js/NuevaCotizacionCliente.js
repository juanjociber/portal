const vgLoader=document.querySelector('.container-loader-full');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    ActivarMenu();
};

var modalBuscarClientes=new bootstrap.Modal(document.getElementById('modalBuscarClientes'), {
    keyboard: false
});

function fnModalBuscarCliente(){
    modalBuscarClientes.show();
};

async function fnBuscarClientes(cliente) {
    vgLoader.classList.remove('loader-full-hidden');
    document.getElementById("divClientes").innerHTML = '';
    document.getElementById('msjModalBuscarClientes').innerHTML = '';
    const data = await fnBuscarClientes2(cliente);
    if (data.res === '200') {
        data.data.forEach(cli => {
            document.getElementById("divClientes").innerHTML += `
            <div class="col-12 border-bottom mb-1 divselect" dataId='${cli.id}' dataNumero='${cli.numero}' dataRuc='${cli.ruc}' dataNombre='${cli.nombre}' dataDireccion='${cli.direccion}' dataCorreo='${cli.correo}' dataContacto='${cli.contacto}' dataTelefono='${cli.telefono}' onclick=fnCargarCliente(this); return false>
                <p class="fw-bold mb-0">${cli.nombre}</p>
                <p class="mb-0">${cli.ruc}</p>
            </div>`;
        });
    } else {
        document.getElementById('msjModalBuscarClientes').innerHTML = `<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data.msg}</div>`;
    }
    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    })
    return false;
}

async function fnBuscarClientes2(cliente){
    const data = new FormData();
    data.append('cliente', cliente);
    const response = await this.fetch('/portal/cotizador/search/BuscarClientesCotizacion.php', {
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

function fnCargarCliente(cliente) {
    document.getElementById('txtCliId').value = cliente.getAttribute('dataId');
    document.getElementById('txtCliNumero').value=cliente.getAttribute('dataNumero');
    document.getElementById('txtCliNombre').value = cliente.getAttribute('dataNombre');
    document.getElementById('txtCliRuc').value = cliente.getAttribute('dataRuc');
    document.getElementById('txtCliDireccion').value = cliente.getAttribute('dataDireccion');
    document.getElementById('txtCliContacto').value = cliente.getAttribute('dataContacto');
    document.getElementById('txtCliTelefono').value = cliente.getAttribute('dataTelefono');
    document.getElementById('txtCliCorreo').value = cliente.getAttribute('dataCorreo');
    modalBuscarClientes.hide();
    return false;
}

async function fnActualizarCliente(){
    vgLoader.classList.remove('loader-full-hidden');
    const data = await fnActualizarCliente2();
    if (data.res === '200') {
        location.reload();
    } else {
        alert(data.msg);
    }
    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    });
    return false;
}

async function fnActualizarCliente2(){
    const data = new FormData();
    data.append('cliid', document.getElementById('txtCliId').value);
    data.append('clinumero', document.getElementById('txtCliNumero').value);
    data.append('cliruc', document.getElementById('txtCliRuc').value);
    data.append('clinombre', document.getElementById('txtCliNombre').value);
    data.append('clidireccion', document.getElementById('txtCliDireccion').value);
    data.append('clicontacto', document.getElementById('txtCliContacto').value);
    data.append('clitelefono', document.getElementById('txtCliTelefono').value);
    data.append('clicorreo', document.getElementById('txtCliCorreo').value);

    const response = await this.fetch('update/ActualizarCotizacionClienteSesion.php', {
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
var vgCliente = '';
var vgFechaInicial = '';
var vgFechaFinal = '';
var vgPagina=0;
var vgBlockScroll=false;

const vgLoader=document.querySelector('.container-loader-full');
const vgDivClientes=document.getElementById('divClientes');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    ActivarMenu();
};

function fnBuscarClientes(){
    vgCliente=document.getElementById('txtCliente').value;
    vgFechaInicial=document.getElementById('dtpFechaInicial').value;
    vgFechaFinal=document.getElementById('dtpFechaFinal').value;
    vgPagina=0;
    vgDivClientes.innerHTML='';
    fnBuscarClientes2();
    return false;
}

async function fnBuscarClientes2(){
    vgBlockScroll = false;
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnBuscarClientes3();
    console.log(datos);
    if(datos.res==='200'){
        let estado="";
        datos.data.forEach(cliente=>{
            if(cliente.estado==1){
                estado='bg-danger';
            }else if(cliente.estado==2){
                estado='bg-success';
            }else{
                estado='bg-secondary';
            }
			document.getElementById('divClientes').innerHTML +=`
            <div class="col-12 cls-container border-bottom border-secondary mb-1 p-1">
                <a class="link-colecciones" href="#" onclick="fnModalModificarCliente(${cliente.id}); return false;">
                    <div class="row justify-content-between">
                        <div class="col-6 fw-bold">${cliente.ruc}</div>
                        <div class="col-6 fw-bold text-end"><span class="badge ${estado}">${cliente.numero}</span></div>
                    </div>
                    <p class="m-0">${cliente.nombre}</p>
					<p class="m-0">${cliente.direccion}</p>
                    <p class="text-secondary m-0 p-0 d-none d-sm-block" style="font-style:italic;">${cliente.obs}</p>
                </a>
            </div>`;
        });

        vgPagina += datos.page;
        if (datos.page == 20) {
            vgBlockScroll = true;
            document.getElementById("divPaginacion").classList.remove("d-none");
        } else {
            document.getElementById("divPaginacion").classList.add("d-none");
        }
    }else{
        document.getElementById('divClientes').innerHTML=`<tr><td class="text-danger" colspan="5">${datos.msg}</td></tr>`;
        alert(datos.msg);
    }

    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    })

    return false;
}

async function fnBuscarClientes3(){
    const data = new FormData();
    data.append('cliente', vgCliente);
    data.append('fechainicial', vgFechaInicial);
    data.append('fechafinal', vgFechaFinal);
    data.append('pagina', vgPagina);
    const response = await this.fetch('/portal/cotizador/search/BuscarClientes.php', {
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

var modalAgregarCliente=new bootstrap.Modal(document.getElementById('modalAgregarCliente'), {
    keyboard: false
});

function fnModalAgregarCliente(){
    document.getElementById('msjAgregarCliente').innerHTML="";
    modalAgregarCliente.show();
};

async function fnAgregarCliente(){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnAgregarCliente2();
    if (datos.res === '200') {
        document.getElementById('msjAgregarCliente').innerHTML=`<div class="alert alert-success p-2 mb-0" role="alert"><strong>Ok! </strong> ${datos.msg}</div>`;
        vgLoader.classList.add('loader-full-hidden');
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                location.reload();
            }, 1000)
        });
    } else {
        document.getElementById('msjAgregarCliente').innerHTML=`<div class="alert alert-danger p-2 mb-0" role="alert"><strong>Error! </strong> ${datos.msg}</div>`;
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                vgLoader.classList.add('loader-full-hidden');
            }, 500)
        });
    }
    return false;
}

async function fnAgregarCliente2(){
    const data = new FormData();
    data.append('ruc', document.getElementById('txtCliRuc').value);
    data.append('nombre', document.getElementById('txtCliNombre').value);
    data.append('direccion', document.getElementById('txtCliDireccion').value);
    data.append('contacto', document.getElementById('txtCliContacto').value);
    data.append('telefono', document.getElementById('txtCliTelefono').value);
    data.append('correo', document.getElementById('txtCliCorreo').value);
    data.append('obs', document.getElementById('txtObs').value);
    const response = await this.fetch('/portal/cotizador/insert/AgregarCliente.php', {
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


var modalModificarCliente=new bootstrap.Modal(document.getElementById('modalModificarCliente'), {
    keyboard: false
});

async function fnModalModificarCliente(cliente){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnModalModificarCliente2(cliente);
    console.log(datos);
    if (datos.res === '200') {
        document.getElementById('msjModificarCliente').innerHTML='';
        document.getElementById('txtCliId2').value = datos.data.id;
        document.getElementById('txtCliRuc2').value = datos.data.ruc;
        document.getElementById('txtCliNombre2').value = datos.data.nombre;
        document.getElementById('txtCliDireccion2').value = datos.data.direccion;
        document.getElementById('txtCliContacto2').value = datos.data.contacto;
        document.getElementById('txtCliCorreo2').value = datos.data.correo;
        document.getElementById('txtCliTelefono2').value = datos.data.telefono;
        document.getElementById('cbCliEstado2').value = datos.data.estado;
        document.getElementById('txtObs2').value = datos.data.obs;
        modalModificarCliente.show();
    } else {
        alert(datos.msg);
    }

    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    });

    return false;
}

async function fnModalModificarCliente2(cliente){
    const data = new FormData();
    data.append('cliente', cliente);
    const response = await this.fetch('/portal/cotizador/search/BuscarCliente.php', {
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

async function fnModificarCliente(){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnModificarCliente2();
    console.log(datos);
    if (datos.res === '200') {
        document.getElementById('msjModificarCliente').innerHTML=`<div class="alert alert-success p-2 mb-0" role="alert"><strong>Ok! </strong> ${datos.msg}</div>`;
        vgLoader.classList.add('loader-full-hidden');
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                location.reload();
            }, 1000)
        });
    } else {
        document.getElementById('msjModificarCliente').innerHTML=`<div class="alert alert-danger p-2 mb-0" role="alert"><strong>Error! </strong> ${datos.msg}</div>`;
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                vgLoader.classList.add('loader-full-hidden');
            }, 500)
        });
    }
    return false;
}

async function fnModificarCliente2(){
    const data = new FormData();
    data.append('id', document.getElementById('txtCliId2').value);
    data.append('nombre', document.getElementById('txtCliNombre2').value);
    data.append('direccion', document.getElementById('txtCliDireccion2').value);
    data.append('contacto', document.getElementById('txtCliContacto2').value);
    data.append('telefono', document.getElementById('txtCliTelefono2').value);
    data.append('correo', document.getElementById('txtCliCorreo2').value);
    data.append('estado', document.getElementById('cbCliEstado2').value);
    data.append('obs', document.getElementById('txtObs2').value);
    const response = await this.fetch('/portal/cotizador/update/ModificarCliente.php', {
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



function fnCotizaciones(){
    window.location.href='/portal/cotizador/Cotizaciones.php';
    return false;
}


function fnNuevaPagina() {
    if (vgBlockScroll) {
        fnBuscarClientes2();
    }
    return false;
}

function fnResumenCotizacion(cotizacion){
    if(cotizacion>0){
        window.location.href='/portal/cotizador/ResumenCotizacion.php?cotizacion='+cotizacion;
    }else{
        alert("No se reconoce el numero de Cotización.");
    }
    return false;
}

function fnReporteClientes(){
    window.location.href='/portal/cotizador/admin/download/ReporteClientes.php?'+
        'cliente='+document.getElementById('txtCliente').value+
        '&fechainicial='+document.getElementById('dtpFechaInicial').value+
        '&fechafinal='+document.getElementById('dtpFechaFinal').value;
    return false;
}

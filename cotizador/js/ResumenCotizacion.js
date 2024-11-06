const vgLoader=document.querySelector('.container-loader-full');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    ActivarMenu();
};

function fnDescargarCotizacion(){
    if(document.getElementById('txtCotizacion').value>0){
        window.location.href='/portal/cotizador/download/DescargarCotizacion.php?cotizacion='+document.getElementById('txtCotizacion').value;
    }else{
        alert('No se reconoce el número de Cotización.');
    }    
    return false;
}

async function fnFinalizarCotizacion(){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnFinalizarCotizacion2();
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

async function fnFinalizarCotizacion2(){
    const data = new FormData();
    data.append('cotizacion', document.getElementById('txtCotizacion').value);
    const response = await this.fetch('update/FinalizarCotizacion.php', {
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

var modalAnularCotizacion=new bootstrap.Modal(document.getElementById('modalAnularCotizacion'), {
    keyboard: false
});

function fnModalAnularCotizacion(){
    modalAnularCotizacion.show();
};

async function fnAnularCotizacion(){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnAnularCotizacion2();
    if (datos.res === '200') {
        document.getElementById('msjAnularCotizacion').innerHTML=`<div class="alert alert-success p-2 mb-0" role="alert"><strong>Ok! </strong> ${datos.msg}</div>`;
        vgLoader.classList.add('loader-full-hidden');
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                location.reload();
            }, 1000)
        });
    } else {
        document.getElementById('msjAnularCotizacion').innerHTML=`<div class="alert alert-danger p-2 mb-0" role="alert"><strong>Error! </strong> ${datos.msg}</div>`;
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                vgLoader.classList.add('loader-full-hidden');
            }, 500)
        });
    }
    return false;
}

async function fnAnularCotizacion2(){
    const data = new FormData();
    data.append('cotizacion', document.getElementById('txtCotizacion').value);
    data.append('nota', document.getElementById('txtNota').value);
    const response = await this.fetch('update/AnularCotizacion.php', {
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

function fnEditarCotizacion(cotizacion){
    if(cotizacion>0){
        window.location.href='/portal/cotizador/EditarCotizacionCliente.php?cotizacion='+cotizacion;
    }    
    return false;
}

function fnCotizaciones(){
    window.location.href='/portal/cotizador/Cotizaciones.php';
    return false;
}
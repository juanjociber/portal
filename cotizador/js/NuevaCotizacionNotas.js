const vgLoader=document.querySelector('.container-loader-full');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    ActivarMenu();
};

async function fnAgregarNota(){
   vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnAgregarNota2();
    if (datos.res === '200') {
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                location.reload();
            }, 500)
        });
    } else {
        alert(datos.msg)
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                vgLoader.classList.add('loader-full-hidden');
            }, 500)
        });
    }
    return false;
}

async function fnAgregarNota2(){
    const data = new FormData();
    data.append('action', 'add');
    data.append('nota', document.getElementById('txtNota').value);
    const response = await this.fetch('/portal/cotizador/update/ActualizarCotizacionNotasSesion.php', {
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

async function fnEliminarNota(indice){
    vgLoader.classList.remove('loader-full-hidden');
    const data = await fnEliminarNota2(indice);
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

async function fnEliminarNota2(indice){
    const data = new FormData();
    data.append('action', 'del');
    data.append('indice', indice);
    const response = await this.fetch('/portal/cotizador/update/ActualizarCotizacionNotasSesion.php', {
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
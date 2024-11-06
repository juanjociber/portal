async function fnAgregarCotizacion(){
    vgLoader.classList.remove('loader-full-hidden');
    const data = await fnAgregarCotizacion2();
    if (data.res === '200') {
        window.location.href='/portal/cotizador/ResumenCotizacion.php?cotizacion='+data.cot;
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

async function fnAgregarCotizacion2(){
    const data = new FormData();
    const response = await this.fetch('/portal/cotizador/insert/AgregarCotizacion.php', {
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
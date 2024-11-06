const vgLoader=document.querySelector('.container-loader-full');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    document.getElementById('MenuCotizaciones').classList.add('menu-activo');
};

async function fnActualizarCondiciones(){
   vgLoader.classList.remove('loader-full-hidden');
    const data = await fnActualizarCondiciones2();
    console.log(data);
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

async function fnActualizarCondiciones2(){
    const data = new FormData();
    data.append('cotmoneda', document.getElementById('txtCotMoneda').value);
    data.append('cotdescuento', document.getElementById('txtCotDescuento').value)
    data.append('cottiempo', document.getElementById('txtCotTiempo').value);
    data.append('cotpago', document.getElementById('txtCotPago').value);
    data.append('cotentrega', document.getElementById('txtCotEntrega').value);
    data.append('cotlugar', document.getElementById('txtCotLugar').value);
    data.append('cotobs', document.getElementById('txtCotObs').value);
    data.append('chkcodigo', document.getElementById('chkMostrarCodigo').checked);

    const response = await this.fetch('update/ActualizarCotizacionCondiciones.php', {
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
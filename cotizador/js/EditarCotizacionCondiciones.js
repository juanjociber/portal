const vgLoader=document.querySelector('.container-loader-full');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    ActivarMenu();
};

async function fnActualizarCondiciones(){
   vgLoader.classList.remove('loader-full-hidden');
    const data = await fnActualizarCondiciones2();
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
    data.append('cotid', document.getElementById('txtCotId').value);
    data.append('cotmoneda', document.getElementById('cbCotMoneda').value);
    data.append('cottasa', document.getElementById('txtCotTasa').value);
    data.append('cotdescuento', document.getElementById('txtCotDescuento').value)
    data.append('cottprecio', document.getElementById('cbCotTipoPrecio').value)
    data.append('cotpago', document.getElementById('txtCotPago').value);
    data.append('cottiempo', document.getElementById('txtCotTiempo').value);
    data.append('chkcodigo', document.getElementById('chkMostrarCodigo').checked);
    data.append('chkcuentas', document.getElementById('chkMostrarCuentas').checked);

    const response = await this.fetch('/portal/cotizador/update/ActualizarCotizacionCondicionesBd.php', {
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
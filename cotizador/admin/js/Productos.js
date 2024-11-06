var vgProducto='';
var vgPagina=0;
var vgBlockScroll=false;
const vgLoader=document.querySelector('.container-loader-full');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    document.getElementById('MenuProductos').classList.add('active','fw-bold');
    document.getElementById('MenuProductosCotizador').classList.add('active','fw-bold');
};

function fnBuscarProductos(){
    vgProducto=document.getElementById('txtBuscarProducto').value;
    vgPagina=0;
    document.getElementById('divProductos').innerHTML='';
    fnBuscarProductos2();
    return false;
}

async function fnBuscarProductos2(){
    vgBlockScroll = false;
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnBuscarProductos3();
    console.log(datos);
    if(datos.res==='200'){
        let estado = '';
        let observacion = '';
        datos.data.forEach(producto=>{
            switch (producto.estado) {
                case 1:
                    estado='bg-danger';
                    break;
                case 2:
                    estado='bg-success';
                    break;            
                default:
                    estado='bg-secondary';
                    break;
            }

            if(producto.observacion==null){observacion='';}else{observacion=producto.observacion;}

			document.getElementById('divProductos').innerHTML +=`
            <div class="col-12 cls-container border-bottom border-secondary mb-1 p-1">
                <a class="link-colecciones" href="#" onclick="fnModalModificarProducto(${producto.id}); return false;">
                    <p class="m-0">${producto.codigo} <span style="font-size:11px; font-style:italic;">Fecha: ${producto.fecha}</span></p>
                    <p class="m-0 fw-bold">${producto.nombre}</p>
                    <div class="row justify-content-between">
                        <div class="col-6">${producto.medida}</div>
                        <div class="col-6 text-end"><span class="badge ${estado}">${producto.moneda} ${producto.ppublico}</span></div>
                    </div>
                    <p style="font-size:11px; font-style:italic; color:red; margin:0px; padding:0px;">${observacion}</p>
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
        document.getElementById('divProductos').innerHTML=`<tr><td class="text-danger" colspan="5">${datos.msg}</td></tr>`;
        document.getElementById("divPaginacion").classList.add("d-none");
        alert(datos.msg);
    }

    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    })

    return false;
}

async function fnBuscarProductos3(){
    const data = new FormData();
    data.append('producto', vgProducto);
    data.append('pagina', vgPagina);
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

var modalAgregarProducto=new bootstrap.Modal(document.getElementById('modalAgregarProducto'), {
    keyboard: false
});

function fnModalAgregarProducto(){
    document.getElementById('msjAgregarProducto').innerHTML="";
    modalAgregarProducto.show();
};

async function fnAgregarProducto(){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnAgregarProducto2();
    if (datos.res === '200') {
        document.getElementById('msjAgregarProducto').innerHTML=`<div class="alert alert-success p-2 mb-0" role="alert"><strong>Ok! </strong> ${datos.msg}</div>`;
        vgLoader.classList.add('loader-full-hidden');
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                location.reload();
            }, 1000)
        });
    } else {
        document.getElementById('msjAgregarProducto').innerHTML=`<div class="alert alert-danger p-2 mb-0" role="alert"><strong>Error! </strong> ${datos.msg}</div>`;
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                vgLoader.classList.add('loader-full-hidden');
            }, 500)
        });
    }
    return false;
}

async function fnAgregarProducto2(){
    const data = new FormData();
    data.append('codinterno', document.getElementById('txtProCodInterno').value);
    data.append('codexterno', document.getElementById('txtProCodExterno').value);
    data.append('nombre', document.getElementById('txtProNombre').value);
    data.append('marca', document.getElementById('txtProMarca').value);
    data.append('medida', document.getElementById('txtProMedida').value);
    data.append('stock', document.getElementById('txtProStock').value);
    data.append('moneda', document.getElementById('cbProMoneda').value);
    data.append('ppublico', document.getElementById('txtProPvPublico').value);
    data.append('pmayor', document.getElementById('txtProPvMayor').value);
    data.append('pflota', document.getElementById('txtProPvFlota').value);
    data.append('fecha', document.getElementById('txtProFecha').value);
    data.append('observacion', document.getElementById('txtObservacion').value);
    const response = await this.fetch('insert/AgregarProducto.php', {
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


var modalModificarProducto=new bootstrap.Modal(document.getElementById('modalModificarProducto'), {
    keyboard: false
});

async function fnModalModificarProducto(producto){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnModalModificarProducto2(producto);
    console.log(datos);
    if (datos.res === '200') {
        document.getElementById('msjModificarProducto').innerHTML='';
        document.getElementById('txtProId2').value=datos.data.id;
        document.getElementById('txtProCodInterno2').value=datos.data.codinterno;
        document.getElementById('txtProCodExterno2').value=datos.data.codexterno;
        document.getElementById('txtProNombre2').value=datos.data.nombre;
        document.getElementById('txtProMarca2').value=datos.data.marca;
        document.getElementById('txtProMedida2').value=datos.data.medida;
        document.getElementById('txtProStock2').value=datos.data.stock;
        document.getElementById('cbProMoneda2').value=datos.data.moneda;
        document.getElementById('txtProPvPublico2').value=datos.data.ppublico;
        document.getElementById('txtProPvMayor2').value=datos.data.pmayor;
        document.getElementById('txtProPvFlota2').value=datos.data.pflota;
        document.getElementById('txtProFecha2').value=datos.data.fecha;
        document.getElementById('cbEstado2').value=datos.data.estado;
        document.getElementById('txtObservacion2').value=datos.data.observacion;
        modalModificarProducto.show();
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

async function fnModalModificarProducto2(producto){
    const data = new FormData();
    data.append('producto', producto);
    const response = await this.fetch('search/BuscarProducto.php', {
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

async function fnModificarProducto(){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnModificarProducto2();
    console.log(datos);
    if (datos.res === '200') {
        document.getElementById('msjModificarProducto').innerHTML=`<div class="alert alert-success p-2 mb-0" role="alert"><strong>Ok! </strong> ${datos.msg}</div>`;
        vgLoader.classList.add('loader-full-hidden');
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                location.reload();
            }, 1000)
        });
    } else {
        document.getElementById('msjModificarProducto').innerHTML=`<div class="alert alert-danger p-2 mb-0" role="alert"><strong>Error! </strong> ${datos.msg}</div>`;
        await new Promise((resolve, reject) => {
            setTimeout(function () {
                vgLoader.classList.add('loader-full-hidden');
            }, 500)
        });
    }
    return false;
}

async function fnModificarProducto2(){
    const data = new FormData();
    data.append('id', document.getElementById('txtProId2').value);
    data.append('codexterno', document.getElementById('txtProCodExterno2').value);
    data.append('nombre', document.getElementById('txtProNombre2').value);
    data.append('marca', document.getElementById('txtProMarca2').value);
    data.append('medida', document.getElementById('txtProMedida2').value);
    data.append('stock', document.getElementById('txtProStock2').value);
    data.append('moneda', document.getElementById('cbProMoneda2').value);
    data.append('ppublico', document.getElementById('txtProPvPublico2').value);
    data.append('pmayor', document.getElementById('txtProPvMayor2').value);
    data.append('pflota', document.getElementById('txtProPvFlota2').value);
    data.append('fecha', document.getElementById('txtProFecha2').value);    
    data.append('observacion', document.getElementById('txtObservacion2').value);
    data.append('estado', document.getElementById('cbEstado2').value);
    const response = await this.fetch('update/ModificarProducto.php', {
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

var modalImportarPrecios=new bootstrap.Modal(document.getElementById('modalImportarPrecios'), {
    keyboard: false
})
function fnModalImportarPrecios(){
    document.getElementById('msjImportarPrecios').innerHTML="";
    modalImportarPrecios.show();
}

async function fnImportarPrecios(){
    vgLoader.classList.remove('loader-full-hidden');
    const data=await fnImportarPrecios2()
    if(data.res==='200'){
        document.getElementById('msjImportarPrecios').innerHTML=`<div class="alert alert-success m-0 text-center" role="alert">${data.msg}</div>`;
        vgLoader.classList.add('loader-full-hidden');
        await new Promise((resolve, reject)=>{
            setTimeout(function(){                
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjImportarPrecios').innerHTML=`<div class="alert alert-danger m-0 text-center" role="alert">${data.msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}

async function fnImportarPrecios2(){
    let filePrecios = document.getElementById('filePrecios')
    var formData = new FormData();
    formData.append("archivo", filePrecios.files[0]);
    const response=await this.fetch("update/ModificarPreciosMasivo.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
    /* .then(response => response.text())
    .then((response) => {
        console.log(response)
    })
    .catch(err => console.log(err))*/
    return response;
}


function fnDescargarPlantillaPrecios(){
    window.location.href='/portal/cotizador/admin/download/DescargarPlantillaPrecios.php';
    return false;
}

function fnDescargarReporteProductos(){
    window.location.href='/portal/cotizador/admin/download/ExcelReporteProductos.php';
    return false;
}

function fnCotizaciones(){
    window.location.href='/portal/cotizador/Cotizaciones.php';
    return false;
}


function fnNuevaPagina() {
    if (vgBlockScroll) {
        fnBuscarProductos2();
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

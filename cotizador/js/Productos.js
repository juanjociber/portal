var vgProducto=0;
var vgPagina=0;
var vgBlockScroll=false;

const vgLoader=document.querySelector('.container-loader-full');
const $vgDivProductos=document.getElementById('divProductos');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    document.getElementById('MenuProductos').classList.add('menu-activo');
};

function fnBuscarProductos(){
    vgProducto=document.getElementById('txtProducto').value; 
    vgPagina=0;
    $vgDivProductos.innerHTML='';
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
                <a class="link-colecciones" href="#" onclick="fnProducto(${producto.id}); return false;">
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

function fnNuevaPagina() {
    if (vgBlockScroll) {
        fnBuscarProductos2();
    }
    return false;
}

function fnProducto(producto){
    console.log(producto);
    return false;
}

var codigo=0;
var pagina=0;
var vgBlockScroll=false;

const $vgLoader=document.querySelector('.container-loader-full');
const $vgDivCotizaciones=document.getElementById('divCotizaciones');

window.onload = async function(){
    $vgLoader.classList.add('loader-full-hidden');
    document.getElementById('MenuReportes').classList.add('active','fw-bold');
    document.getElementById('MenuReportesProductosPorCotizaciones').classList.add('active','fw-bold');
};

function fnBuscarCotizaciones(){
    codigo=document.getElementById('txtCodigo').value;
    pagina=0;
    $vgDivCotizaciones.innerHTML='';
    fnBuscarCotizaciones2();
    return false;
}

async function fnBuscarCotizaciones2(){
    vgBlockScroll = false;
    $vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnBuscarCotizaciones3();
    console.log(datos);
    if(datos.res==='200'){
        let estado='';
        datos.data.forEach(cot=>{
            switch(cot.cotestado){
                case 1:
                    estado='text-danger';
                    break;
                case 2:
                    estado='text-primary';
                    break;
                case 3:
                    estado='text-success';
                    break;
                default:
                    estado='text-secondary';
                
            }
			$vgDivCotizaciones.innerHTML +=`
                <div class="col-12 cls-container border-bottom border-secondary mb-1 p-1">
                    <a class="link-colecciones" href="#" onclick="fnResumenCotizacion(${cot.cotid}); return false;">
                        <p class="m-0 p-0"><span class="fw-bold">${cot.cotnombre}</span> <span style="font-size:12px; font-style:italic;">${cot.cotfecha}</span></p>
                        <div class="d-flex justify-content-between">
                            <span class="m-0 p-0">[${cot.cliruc}] ${cot.clinombre}</span>
                            <span class="m-0 p-0 fw-bold text-end ${estado}"> ${cot.cotmoneda} ${cot.proprecio}</span>                            
                        </div>
                        <div class="d-flex justify-content-between">
                            <span class="m-0 p-0">[${cot.procodigo}] ${cot.pronombre}</span>
                            <span class="m-0 p-0 text-end">${cot.procantidad} ${cot.promedida}</span>
                        </div>
                    </a>
                </div>`;
        });

        pagina += datos.page;
        if (datos.page == 20) {
            vgBlockScroll = true;
            document.getElementById("divPaginacion").classList.remove("d-none");
        } else {
            document.getElementById("divPaginacion").classList.add("d-none");
        }
    }else{
        $vgDivCotizaciones.innerHTML=`<tr><td class="text-danger" colspan="5">${datos.msg}</td></tr>`;
        alert(datos.msg);
    }

    await new Promise((resolve, reject) => {
        setTimeout(function () {
            $vgLoader.classList.add('loader-full-hidden');
        }, 500)
    })

    return false;
}

async function fnBuscarCotizaciones3(){
    const data = new FormData();
    data.append('codigo', codigo);
    data.append('pagina', pagina);
    const response = await this.fetch('/portal/cotizador/search/BuscarProductosPorCotizacion.php', {
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
        fnBuscarCotizaciones2();
    }
    return false;
}

function fnReporteCotizaciones(){
    window.location.href='/portal/cotizador/excel/ReporteProductosPorCotizacion.php?'+
        'codigo='+document.getElementById('txtCodigo').value;
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

var vgCotizacion=0;
var vgFechaInicial='';
var vgFechaFinal='';
var vgPagina=0;
var vgBlockScroll=false;

const vgLoader=document.querySelector('.container-loader-full');
const $vgDivCotizaciones=document.getElementById('divCotizaciones');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    ActivarMenu();
};

function fnBuscarCotizaciones(){
    vgCotizacion=document.getElementById('txtCotizacion').value;
    vgFechaInicial=document.getElementById('dtpFechaInicial').value;
    vgFechaFinal=document.getElementById('dtpFechaFinal').value;
    vgPagina=0;
    $vgDivCotizaciones.innerHTML='';
    fnBuscarCotizaciones2();
    return false;
}

async function fnBuscarCotizaciones2(){
    vgBlockScroll = false;
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnBuscarCotizaciones3();
    if(datos.res==='200'){
        let estado='';
        datos.data.forEach(cot=>{
            switch(cot.estado){
                case 1:
                    estado='bg-danger';
                    break;
                case 2:
                    estado='bg-primary';
                    break;
                case 3:
                    estado='bg-success';
                    break;
                default:
                    estado='bg-secondary';
                
            }
			$vgDivCotizaciones.innerHTML +=`
                <div class="col-12 cls-container border-bottom border-secondary mb-1 p-1">
                    <a class="link-colecciones" href="#" onclick="fnResumenCotizacion(${cot.id}); return false;">
                        <div class="row justify-content-between">
                            <div class="col-6 fw-bold">${cot.cotizacion}</div>
                            <div class="col-6 text-end"><span class="badge ${estado}"> ${cot.moneda} ${cot.total}</span></div>
                        </div>
                        <p class="m-0">${cot.fecha}<span style="font-size: 12px; font-style: italic;"> ${cot.vendedor}</span></p>
						<p class="m-0"><span>${cot.cliruc} ${cot.clinombre}</span></p>
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
        $vgDivCotizaciones.innerHTML=`<tr><td class="text-danger" colspan="5">${datos.msg}</td></tr>`;
        alert(datos.msg);
    }

    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    })

    return false;
}

async function fnBuscarCotizaciones3(){
    const data = new FormData();
    data.append('cotizacion', vgCotizacion);
    data.append('fechainicial', vgFechaInicial);
    data.append('fechafinal', vgFechaFinal);
    data.append('pagina', vgPagina);
    const response = await this.fetch('/portal/cotizador/search/BuscarCotizaciones.php', {
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

function fnReporteCotizacionesMin(){
    window.location.href='/portal/cotizador/admin/download/ReporteCotizacionesMin.php?'+
        'cotizacion='+document.getElementById('txtCotizacion').value+
        '&fechainicial='+document.getElementById('dtpFechaInicial').value+
        '&fechafinal='+document.getElementById('dtpFechaFinal').value;
    return false;
}

function fnReporteCotizacionesFull(){
    window.location.href='/portal/cotizador/admin/download/ReporteCotizacionesFull.php?'+
        'cotizacion='+document.getElementById('txtCotizacion').value+
        '&fechainicial='+document.getElementById('dtpFechaInicial').value+
        '&fechafinal='+document.getElementById('dtpFechaFinal').value;
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

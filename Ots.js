var vgBlockScroll=false;
var vgPagina=0;

var vgEmpresa=0;
var vgTipoOt=0;
var vgActivo=0;
var vgSistema=0;
var vgOrigen=0;
var vgOt='';
var vgActividad='';
var vgTrabajo='';
var vgFechaInicial='';
var vgFechaFinal='';

const cbEmpresas = document.getElementById("cbempresas");
const vgLoader=document.querySelector('.container-loader-min');
const vgTBody01=document.getElementById('tbody01');

window.onload = async function(){
    vgLoader.classList.add('loader-min-hidden');
};

window.addEventListener('scroll', () => {
    const { scrollTop, scrollHeight, clientHeight } = document.documentElement;
    if(clientHeight+scrollTop>=scrollHeight-5 && vgBlockScroll===true) {
        fnBuscarOts2();
    }
});

async function fnListarClases(empresa){
    let cbActivos=document.querySelector("#cbactivos")
    let cbTipoOts=document.querySelector("#cbtipoots")
    let cbOrigenes=document.querySelector("#cborigenes")
    let cbSistemas=document.querySelector("#cbsistemas")
    cbActivos.innerHTML=""
    cbTipoOts.innerHTML=""
    cbOrigenes.innerHTML=""
    cbSistemas.innerHTML=""
    
    if(empresa>0){
        vgLoader.classList.remove('loader-min-hidden');
        const data=await fnListarClases2(empresa);
        if (data[0].res==='200'){
            data[2].forEach(element => {
                cbActivos.add(new Option(element.activo, element.id));
            })
            data[3].forEach(element => {
                cbTipoOts.add(new Option(element.tipoot, element.id));
            })
            data[4].forEach(element => {
                cbOrigenes.add(new Option(element.origen, element.id));
            })
            data[5].forEach(element => {
                cbSistemas.add(new Option(element.sistema, element.id));
            })
        }else{
            cbActivos.add(new Option('Ningún Activo', 0));
            cbTipoOts.add(new Option('Ningún Tipo', 0));
            cbOrigenes.add(new Option('Ningún Orígen', 0));
            cbSistemas.add(new Option('Ningún Sistema', 0));
            alert(data[1].msg)
        }
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-min-hidden');
            },500)
        })
    }else{
        cbActivos.add(new Option('Ningún Activo', 0));
        cbTipoOts.add(new Option('Ningún Tipo', 0));
        cbOrigenes.add(new Option('Ningún Orígen', 0));
        cbSistemas.add(new Option('Ningún Sistema', 0));
    }
    return false;
}

async function fnListarClases2(empresa){
    const data = new FormData();
    data.append('empresa', empresa);
    const response = await this.fetch('list/ListarClases.php', {
        method:'POST', 
        body:data
        })
    .then(res=>res.json())
    .catch(err => console.log(err));
    return response;
}

function fnBuscarOts(empresa, tipoot, activo, sistema, origen, ot, actividad, trabajo, fechainicial, fechafinal){
    if(empresa>0){
        vgEmpresa=empresa;
        vgTipoOt=tipoot;
        vgActivo=activo;
        vgSistema=sistema;    
        vgOrigen=origen;
        vgOt=ot;
        vgActividad=actividad;
        vgTrabajo=trabajo;
        vgFechaInicial=fechainicial;
        vgFechaFinal=fechafinal;
        vgPagina=0;
        vgTBody01.innerHTML='';
        fnBuscarOts2();
    }else{
        vgTBody01.innerHTML=`<tr><td class="text-danger" colspan="6">Debe seleccionar una Empresa para continuar...</td></tr>`;
    }    
}

async function fnBuscarOts2(){
    vgBlockScroll=false;
    vgLoader.classList.remove('loader-min-hidden');
    const data = await fnBuscarOts3();
    if(data[0].res==='200'){
        data[3].forEach(ot=>{
            let estado='';
            switch (ot.estado){
                case 0:
                    estado='<span class="badge bg-danger">ANULADA</span>';
                break;
                case 1:
                    estado='<span class="badge bg-light text-dark">ABIERTA</span>';
                break;
                case 2:
                    estado='<span class="badge bg-primary">PROCESO</span>';
                break;
                case 3:
                    estado='<span class="badge bg-success">CERRADA</span>';
                break;
                case 4:
                    estado='<span class="badge bg-warning">OBSERVADA</span>';
                break;
                default:
                    estado='<span class="badge bg-secondary">UNKNOWN</span>';
            }
            vgTBody01.innerHTML +=`
                <tr>
                    <td class="fw-bold"><a class="text-decoration-none" href="#" onClick="fnDetalleOt(${ot.id});return false;">${ot.ot}</a></td>
                    <td>${ot.activo}</td>
                    <td>${ot.tipoot}</td>
                    <td class="text-center">${ot.fecha}</td>
                    <td>${ot.actividad}</td>
                    <td class="text-center">${estado}</td>
                </tr>`;
        }); 
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgPagina=data[1].page;
                if((data[1].page%30)==0){
                    vgBlockScroll=true;
                }
                console.log('pagina: '+data[1].page+', scroll: '+vgBlockScroll)
                vgLoader.classList.add('loader-min-hidden');
            },1500)
        })
    }else{
        vgTBody01.innerHTML=`<tr><td class="text-danger" colspan="6">${data[2].msg}</td></tr>`;
        alert(data[2].msg);
        vgLoader.classList.add('loader-min-hidden');
    }
    return false;
}

async function fnBuscarOts3(){
    const data = new FormData();
    data.append('empresa', vgEmpresa);
    data.append('activo', vgActivo);
    data.append('sistema', vgSistema)
    data.append('tipoot', vgTipoOt);
    data.append('origen', vgOrigen);
    data.append('ot', vgOt);
    data.append('actividad', vgActividad);
    data.append('trabajo', vgTrabajo);
    data.append('fechainicial', vgFechaInicial);
    data.append('fechafinal', vgFechaFinal);
    data.append('pagina', vgPagina);
    const response = await this.fetch('search/BuscarOts.php', {
        method:'POST', 
        body:data
        })
    .then(res=>res.json())
    .catch(err => console.log(err));
    return response;
}

function fnDetalleOt(id){
    ancho=1000;
    alto=600;
	var x=(screen.width/2)-(ancho/2);
    var y=(screen.height/2)-(alto/2);
    window.open('DetalleOt.php?id='+id, 'ot'+id, 'width=' + ancho + ', height=' + alto + ', left=' + x + ', top=' + y +', Scrollbars=YES'+'');
}

function fnReporteCierreOts(empresa, fechainicial, fechafinal){
    if(empresa>0){
        window.location.href='excel/ReporteCierreOts.php?empresa='+empresa+'&fechainicial='+fechainicial+'&fechafinal='+fechafinal;
    }else{
        alert("No se ha seleccionado una Empresa");
    }    
}

function fnReporteCierreTareos(empresa, fechainicial, fechafinal){
    if(empresa>0){
        window.location.href='excel/ReporteCierreTareos.php?empresa='+empresa+'&fechainicial='+fechainicial+'&fechafinal='+fechafinal;
    }else{
        alert("No se ha seleccionado una Empresa");
    }    
}

function fnReporteOts(empresa, fechainicial, fechafinal){
    if(empresa>0){
        window.location.href='excel/ReporteOts.php?empresa='+empresa+'&fechainicial='+fechainicial+'&fechafinal='+fechafinal;
    }else{
        alert("No se ha seleccionado una Empresa");
    }    
}

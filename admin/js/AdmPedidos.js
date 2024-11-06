const vgLoader=document.querySelector('.container-loader-full');
const vgTBody01=document.getElementById('tbody01');
const vgPaginador=document.getElementById('paginador');
var vgFechaInicial='';
var vgFechaFinal='';

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    document.getElementById('MenuCotizaciones').classList.add('active','fw-bold');
    document.getElementById('MenuCotizacionesPaginaWeb').classList.add('active','fw-bold');
};

function fnPaginacion(pagina_actual, total_paginas){
    let desde=1;
    let hasta=total_paginas;
    let pagleft=false 
    let pagright=false;

    if(total_paginas>5){
        if (pagina_actual<3){
            pagright=true
            desde=1
            hasta=5
        }else{
             if(pagina_actual-2>0 && total_paginas-pagina_actual>2){
                pagright=true
                desde=pagina_actual-2
                hasta=pagina_actual+2
            }else{
                if(total_paginas-pagina_actual<3){
                    desde=total_paginas-4
                }
            }
            pagleft=true
        }
    }

    if(total_paginas>1){
        if(pagleft){
            vgPaginador.innerHTML+=`<li class="page-item"><a class="page-link fw-bold" href="#" onClick="fnBuscarPedidos2(1); return false;"><span aria-hidden="true">&laquo;</span></a></li>`;
            vgPaginador.innerHTML+=`<li class="page-item"><a class="page-link fw-bold" href="#" onClick="fnBuscarPedidos2(${pagina_actual-1}); return false;"><span aria-hidden="true">&lsaquo;</span></a></li>`;
        }
        for (let i = desde; i <=hasta; i++) {
            if(i==pagina_actual){
                vgPaginador.innerHTML+=`<li class="page-item active" aria-current="page"><a class="page-link fw-bold" href="#" onClick="fnBuscarPedidos2(${i}); return false;">${i}</a></li>`;
            }else{
                vgPaginador.innerHTML+=`<li class="page-item"><a class="page-link fw-bold" href="#" onClick="fnBuscarPedidos2(${i}); return false;">${i}</a></li>`;
            }
         }
         if(pagright){
            vgPaginador.innerHTML+=`<li class="page-item"><a class="page-link fw-bold" href="#" onClick="fnBuscarPedidos2(${pagina_actual+1}); return false;"><span aria-hidden="true">&rsaquo;</span></a></li>`;
            vgPaginador.innerHTML+=`<li class="page-item"><a class="page-link fw-bold" href="#" onClick="fnBuscarPedidos2(${total_paginas}); return false;"><span aria-hidden="true">&raquo;</span></a></li>`;
        }
    }
    return false;
}

function fnBuscarPedidos(fechainicial, fechafinal, pagina){
    vgFechaInicial=fechainicial;
    vgFechaFinal=fechafinal;
    fnBuscarPedidos2(pagina)
}

async function fnBuscarPedidos2(pagina){
    vgLoader.classList.remove('loader-full-hidden');
    vgTBody01.innerHTML='';
    vgPaginador.innerHTML='';
    const data=await fnBuscarPedidos3(pagina);
    console.log(data);
    if(data[0].res==='200'){
        data[3].forEach(pedido => {
            var estado='';
            switch (pedido.estado){
                case 1:
                    estado='<span class="badge bg-danger">INACTIVO</span>';
                break;
                case 2:
                    estado='<span class="badge bg-success">PEDIDO</span>';
                break;
                default:
                    estado='<span class="badge bg-secondary">UNKNOWN</span>';
            }
            vgTBody01.innerHTML +=`
                <tr>
                    <td class="fw-bold text-center" width="50px"><a class="text-decoration-none" href="#" onClick="fnDetalleProducto(${pedido.id});return false;">${pedido.id}</a></h5></td>
                    <td class="text-center">${pedido.fecha}</td>
                    <td>${pedido.ruc}</td>
                    <td>${pedido.empresa}</td>
                    <td>${pedido.contacto}</td>
                    <td>${pedido.telefono}</td>
                    <td class="text-center">${estado}</td>
                </tr>`;
        });

        console.log(pagina, data[1].npg);
        fnPaginacion(pagina, data[1].npg);

        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },1000)
        })
    }else{
        vgTBody01.innerHTML=`<tr><td class="text-danger" colspan="7">${data[2].msg}</td></tr>`;
        alert('Disculpe, '+data[2].msg);
        vgLoader.classList.add('loader-full-hidden');
    }
    return false;
}

async function fnBuscarPedidos3(pagina){
    const data = new FormData();
    data.append('fechainicial', vgFechaInicial);
    data.append('fechafinal', vgFechaFinal);
    data.append('pagina', pagina);
    console.log(pagina, vgFechaFinal, vgFechaInicial);
    const response = await this.fetch('view/BuscarPedidos.php', {
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

function fnDetalleProducto(id){
    ancho=1000;
    alto=600;
	var x=(screen.width/2)-(ancho/2);/*Posición horizontal*/
    var y=(screen.height/2)-(alto/2);/*Posición vertical*/
    window.open('AdmDetallePedido.php?id='+id, 'Detalle'+id, 'width=' + ancho + ', height=' + alto + ', left=' + x + ', top=' + y +', Scrollbars=YES'+'');
    return false;
}

function fnDescargarProductos(){
    let categoria=document.getElementById('cbCategorias').value;
    let producto=document.getElementById('txtProducto').value;
    let estado=document.getElementById('cbEstados').value;
    window.location.href='excel/ReporteProductos.php?categoria='+categoria+'&producto='+producto+'&estado='+estado;
    return false;
}
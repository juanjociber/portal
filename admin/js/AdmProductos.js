const vgLoader=document.querySelector('.container-loader-full');
const vgTBody01=document.getElementById('tbody01');
const vgPaginador=document.getElementById('paginador');
var vgEtiqueta=0;
var vgProducto='';
var vgEstado=0;

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    document.getElementById('MenuProductos').classList.add('active','fw-bold');
    document.getElementById('MenuProductosPaginaWeb').classList.add('active','fw-bold');
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
            vgPaginador.innerHTML+=`<li class="page-item"><a class="page-link fw-bold" href="#" onClick="fnBuscarProductos2(1); return false;"><span aria-hidden="true">&laquo;</span></a></li>`;
            vgPaginador.innerHTML+=`<li class="page-item"><a class="page-link fw-bold" href="#" onClick="fnBuscarProductos2(${pagina_actual-1}); return false;"><span aria-hidden="true">&lsaquo;</span></a></li>`;
        }
        for (let i = desde; i <=hasta; i++) {
            if(i==pagina_actual){
                vgPaginador.innerHTML+=`<li class="page-item active" aria-current="page"><a class="page-link fw-bold" href="#" onClick="fnBuscarProductos2(${i}); return false;">${i}</a></li>`;
            }else{
                vgPaginador.innerHTML+=`<li class="page-item"><a class="page-link fw-bold" href="#" onClick="fnBuscarProductos2(${i}); return false;">${i}</a></li>`;
            }
         }
         if(pagright){
            vgPaginador.innerHTML+=`<li class="page-item"><a class="page-link fw-bold" href="#" onClick="fnBuscarProductos2(${pagina_actual+1}); return false;"><span aria-hidden="true">&rsaquo;</span></a></li>`;
            vgPaginador.innerHTML+=`<li class="page-item"><a class="page-link fw-bold" href="#" onClick="fnBuscarProductos2(${total_paginas}); return false;"><span aria-hidden="true">&raquo;</span></a></li>`;
        }
    }
    return false;
}

function fnBuscarProductos(etiqueta, producto, estado, pagina){
    vgEtiqueta=etiqueta;
    vgProducto=producto;
    vgEstado=estado;
    fnBuscarProductos2(pagina)
}

async function fnBuscarProductos2(pagina){
    vgLoader.classList.remove('loader-full-hidden');
    vgTBody01.innerHTML='';
    vgPaginador.innerHTML='';
    const data=await fnBuscarProductos3(pagina);
    if(data.res==='200'){
        data.data.forEach(producto => {
            var estado='';
            switch (producto.estado){
                case 1:
                    estado='<span class="badge bg-danger">Inactivo</span>';
                break;
                case 2:
                    estado='<span class="badge bg-success">Activo</span>';
                break;
                default:
                    estado='<span class="badge bg-secondary">Unknown</span>';
            }
            vgTBody01.innerHTML +=`
                <tr>
                    <td class="fw-bold text-center"><a class="text-decoration-none" href="#" onClick="fnDetalleProducto(${producto.id});return false;"><i class="fas fa-pen"></i></a></h5></td>
                    <td>${producto.producto}</td>
                    <td>${producto.codigo}</td>
                    <td>${producto.marca}</td>
                    <td class="text-center">${producto.prioridad}</td>
                    <td class="text-center">${estado}</td>
                </tr>`;
        });

        console.log(pagina, data.npg);
        fnPaginacion(pagina, data.npg);

        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },1000)
        })
    }else{
        vgTBody01.innerHTML=`<tr><td class="text-danger" colspan="6">${data.msg}</td></tr>`;
        alert('Disculpe, '+data.msg);
        vgLoader.classList.add('loader-full-hidden');
    }
    return false;
}

async function fnBuscarProductos3(pagina){
    const data = new FormData();
    data.append('etiqueta', vgEtiqueta);
    data.append('producto', vgProducto);
    data.append('estado', vgEstado);
    data.append('pagina', pagina);
    const response = await this.fetch('view/BuscarProductos.php', {
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
})
function fnModalAgregarProducto(){
    document.getElementById('msjAgregarProducto').innerHTML="";
    modalAgregarProducto.show();
}

async function fnAgregarProducto(){
    vgLoader.classList.remove('loader-full-hidden');
    const data=await fnAgregarProducto2()
    if(data[0].res==='200'){
        document.getElementById('msjAgregarProducto').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                modalAgregarProducto.hide();
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }else{
        document.getElementById('msjAgregarProducto').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}

async function fnAgregarProducto2(){
    var formData = new FormData();
    formData.append("codigo", document.getElementById('txtCodigo1').value);
    formData.append('producto', document.getElementById('txtProducto1').value);
    formData.append("seourl", document.getElementById('txtSeoUrl1').value);
    formData.append('serie', document.getElementById('txtSerie1').value);
    formData.append('marca', document.getElementById('txtMarca1').value);
    formData.append('medida', document.getElementById('txtMedida1').value);
    const response=await this.fetch("insert/AgregarProducto.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
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
    window.open('AdmDetalleProducto.php?id='+id, 'Detalle'+id, 'width=' + ancho + ', height=' + alto + ', left=' + x + ', top=' + y +', Scrollbars=YES'+'');
    return false;
}

function fnDescargarProductos(){
    let etiqueta=document.getElementById('cbEtiquetas').value;
    let producto=document.getElementById('txtProducto').value;
    let estado=document.getElementById('cbEstados').value;
    window.location.href='excel/ReporteProductos.php?etiqueta='+etiqueta+'&producto='+producto+'&estado='+estado;
    return false;
}
const vgLoader=document.querySelector('.container-loader-full');
const cbComponentes=document.getElementById('cbComponentes1');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden')
};

/** MODIFICAR IMAGEN PRINCIPAL**/
var modalModificarImagenPrincipal=new bootstrap.Modal(document.getElementById('modalModificarImagenPrincipal'), {
    keyboard: false
})

function fnModalModificarImagenPrincipal(descripcion){
    document.getElementById('txtModificarDescripcionImagenPrincipal').value=descripcion;
    modalModificarImagenPrincipal.show()
    return false;
}

async function fnModificarImagenPrincipal(){
    vgLoader.classList.remove('loader-full-hidden')
    const data=await fnModificarImagenPrincipal2()
    if(data[0].res === '200'){
        document.getElementById('msjModificarImagenPrincipal').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjModificarImagenPrincipal').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}

async function fnModificarImagenPrincipal2(){
    var formData = new FormData();
    formData.append("idproducto", document.getElementById('txtId').value);
    formData.append("descripcion", document.getElementById('txtModificarDescripcionImagenPrincipal').value)
    formData.append("imagen", document.getElementById('fileModificarImagenPrincipal').files[0]);
    const response=await this.fetch("update/ModificarImagenPrincipal.php", {
        method: "POST",
        body: formData,
        headers: {
            //No es necesario definirlo
            //'Content-Type': '"multipart/form-data;',
            //'Authorization': `Bearer ${token}`
        }
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


/** AGREGAR IMAGEN DE GALERIA**/
var modalAgregarImagenGaleria=new bootstrap.Modal(document.getElementById('modalAgregarImagenGaleria'), {
    keyboard: false
})

function fnModalAgregarImagenGaleria(){
    document.getElementById('msjAgregarImagenGaleria').innerHTML="";
    modalAgregarImagenGaleria.show()
    return false;
}

async function fnAgregarImagenGaleria(){
    vgLoader.classList.remove('loader-full-hidden')
    const data=await fnAgregarImagenGaleria2()
    if(data[0].res === '200'){
        document.getElementById('msjAgregarImagenGaleria').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjAgregarImagenGaleria').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}

async function fnAgregarImagenGaleria2(){
    var formData = new FormData();
    formData.append("idproducto", document.getElementById('txtId').value);
    formData.append("descripcion", document.getElementById('txtAgregarDescripcionImagenGaleria').value);
    formData.append("imagen", document.getElementById('fileAgregarImagenGaleria').files[0]);
    const response=await this.fetch("insert/AgregarImagenGaleria.php", {
        method: "POST",
        body: formData,
        headers: {
            //No es necesario definirlo
            //'Content-Type': '"multipart/form-data;',
            //'Authorization': `Bearer ${token}`
        }
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
    return response;
}


/** MODIFICAR IMAGEN DE GALERIA**/
var modalModificarImagenGaleria=new bootstrap.Modal(document.getElementById('modalModificarImagenGaleria'), {
    keyboard: false
})

function fnModalModificarImagenGaleria(idgaleria, descripcion){
    document.getElementById('txtIdImagenGaleria').value=idgaleria;
    document.getElementById('txtModificarDescripcionGaleria').value=descripcion;
    document.getElementById('msjModificarImagenGaleria').innerHTML="";
    modalModificarImagenGaleria.show()
    return false;
}

async function fnModificarImagenGaleria(){
    vgLoader.classList.remove('loader-full-hidden')
    const data=await fnModificarImagenGaleria2()
    if(data[0].res === '200'){
        document.getElementById('msjModificarImagenGaleria').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjModificarImagenGaleria').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}

async function fnModificarImagenGaleria2(){
    var formData = new FormData();
    formData.append("idproducto", document.getElementById('txtId').value);
    formData.append("idgaleria", document.getElementById('txtIdImagenGaleria').value);
    formData.append("descripcion", document.getElementById('txtModificarDescripcionGaleria').value);
    formData.append("imagen", document.getElementById('fileModificarImagenGaleria').files[0]);
    const response=await this.fetch("update/ModificarImagenGaleria.php", {
        method: "POST",
        body: formData,
        headers: {
            //No es necesario definirlo
            //'Content-Type': '"multipart/form-data;',
            //'Authorization': `Bearer ${token}`
        }
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


/** ELIMINAR IMAGEN DE GALERIA**/
var modalEliminarImagenGaleria=new bootstrap.Modal(document.getElementById('modalEliminarImagenGaleria'), {
    keyboard: false
})

function fnModalEliminarImagenGaleria(idgaleria, descripcion){
    document.getElementById('txtEliminarIdImagenGaleria').value=idgaleria;
    document.getElementById('txtEliminarDescripcionImagenGaleria').value=descripcion;
    document.getElementById('msjEliminarImagenGaleria').innerHTML="";
    modalEliminarImagenGaleria.show()
    return false;
}

async function fnEliminarImagenGaleria(){
    vgLoader.classList.remove('loader-full-hidden')
    const data=await fnEliminarImagenGaleria2()
    if(data[0].res === '200'){
        document.getElementById('msjEliminarImagenGaleria').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjEliminarImagenGaleria').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}

async function fnEliminarImagenGaleria2(){
    var formData = new FormData();
    formData.append("idgaleria", document.getElementById('txtEliminarIdImagenGaleria').value);
    const response=await this.fetch("delete/EliminarImagenGaleria.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
    return response;
}


/** MODIFICAR SEO GOOGLE **/
var modalModificarSeo=new bootstrap.Modal(document.getElementById('modalModificarSeo'), {
    keyboard: false
})

function fnModalModificarSeo(){
    modalModificarSeo.show()
    return false;
}

async function fnModificarSeo(){
    vgLoader.classList.remove('loader-full-hidden');
    const data=await fnModificarSeo2()
    if(data[0].res==='200'){
        document.getElementById('msjModificarSeo').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjModificarSeo').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}

async function fnModificarSeo2(){
    var formData = new FormData();
    formData.append("id", document.getElementById('txtId').value);
    formData.append("seogoogle", document.getElementById('txtSeoGoogle').value);
    formData.append('seourl', document.getElementById('txtSeoUrl').value);
    const response=await this.fetch("update/ModificarSeoProducto.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
    return response;
}


/** MODIFICAR CARACTERISTICAS DEL PRODUCTO**/
var modalModificarCaracteristicas=new bootstrap.Modal(document.getElementById('modalModificarCaracteristicas'), {
    keyboard: false
})

function fnModalModificarCaracteristicas(){
    modalModificarCaracteristicas.show()
    return false;
}

async function fnModificarCaracteristicas(){
    vgLoader.classList.remove('loader-full-hidden');
    const data=await fnModificarCaracteristicas2()
    if(data[0].res==='200'){
        document.getElementById('msjModificarCaracteristicas').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjModificarCaracteristicas').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}

async function fnModificarCaracteristicas2(){
    var formData = new FormData();
    formData.append("id", document.getElementById('txtId').value);
    formData.append("caracteristicas", document.getElementById('txtCaracteristicas').value);
    const response=await this.fetch("update/ModificarCaracteristicas.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
    return response;
}



/** MODIFICAR INFORMACION**/
var modalModificarInformacion=new bootstrap.Modal(document.getElementById('modalModificarInformacion'), {
    keyboard: false
})

function fnModalModificarInformacion(){
    modalModificarInformacion.show()
    return false;
}

async function fnModificarInformacion(){
    vgLoader.classList.remove('loader-full-hidden');
    const data=await fnModificarInformacion2()
    if(data[0].res==='200'){
        document.getElementById('msjModificarInformacion').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjModificarInformacion').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}

async function fnModificarInformacion2(){
    var formData = new FormData();
    formData.append("id", document.getElementById('txtId').value);
    formData.append("informacion", document.getElementById('txtInformacion').value);
    const response=await this.fetch("update/ModificarInformacion.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
    return response;
}


/** MODIFICAR INFORMACION DEL PRODUCTO**/
var modalModificarDatosProducto=new bootstrap.Modal(document.getElementById('modalModificarDatosProducto'), {
    keyboard: false
})

function fnModalModificarDatosProducto(){
    modalModificarDatosProducto.show()
    return false;
}

async function fnModificarDatosProducto(){
    vgLoader.classList.remove('loader-full-hidden');
    const data=await fnModificarDatosProducto2()
    if(data[0].res==='200'){
        document.getElementById('msjModificarDatosProducto').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjModificarDatosProducto').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}

async function fnModificarDatosProducto2(){
    var formData = new FormData();
    formData.append("id", document.getElementById('txtId').value);
    formData.append("producto", document.getElementById('txtProducto').value);
    formData.append("codigo", document.getElementById('txtCodigo').value);
    formData.append("serie", document.getElementById('txtSerie').value);
    formData.append('marca', document.getElementById('txtMarca').value);
    formData.append('medida', document.getElementById('txtMedida').value);
    formData.append('destacado', document.getElementById('cbDestacado').value);
    formData.append('prioridad', document.getElementById('txtPrioridad').value);
    formData.append('estado', document.getElementById('cbEstado').value);
    const response=await this.fetch("update/ModificarDatosProducto.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
    return response;
}

/** MODIFICAR INFORMACION DE LOS FILTROS**/
var modalModificarFiltros=new bootstrap.Modal(document.getElementById('modalModificarFiltros'), {
    keyboard: false
})

function fnModalModificarFiltros(){
    modalModificarFiltros.show()
    return false;
}

async function fnModificarFiltros(){
    vgLoader.classList.remove('loader-full-hidden');
    let filtros="";
    let array_filtros=[].filter.call(document.getElementsByName('chkFiltro[]'), function(c) {
            return c.checked;
        }).map(function(c) {
            return c.value;
    });

    array_filtros.forEach(element=>{
        filtros+=`${element},`;
    });
    
    if(filtros.length>0){
        filtros=filtros.substring(0, filtros.length-1);
    };

    const data=await fnModificarFiltros2(filtros)
    if(data.res==='200'){
        document.getElementById('msjModificarFiltros').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data.msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        });
    }else{
        document.getElementById('msjModificarFiltros').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data.msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        });
    }
    return false;
}

async function fnModificarFiltros2(filtros){
    var formData = new FormData();
    formData.append("id", document.getElementById('txtId').value);
    formData.append("filtros", filtros);
    const response=await this.fetch("update/ModificarFiltros.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
    return response;
}


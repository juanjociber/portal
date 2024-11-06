const vgLoader=document.querySelector('.container-loader-full');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
    document.getElementById('MenuUsuarios').classList.add('active','fw-bold');
};

/** AGREGAR NUEVO USUARIO */
var modalAgregarUsuario=new bootstrap.Modal(document.getElementById('modalAgregarUsuario'), {
    keyboard: false
})
async function fnModalAgregarUsuario(){
    document.getElementById('msjAgregarUsuario').innerHTML='';
    modalAgregarUsuario.show();
    return false;
}
async function fnAgregarUsuario(rol, nombre, usuario, clave){
    vgLoader.classList.remove('loader-full-hidden');
    const data=await fnAgregarUsuario2(rol, nombre, usuario, clave)
    if(data[0].res==='200'){
        document.getElementById('msjAgregarUsuario').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjAgregarUsuario').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}
async function fnAgregarUsuario2(rol, nombre, usuario, clave){
    var formData = new FormData();
    formData.append("role", rol);
    formData.append("nombre", nombre);
    formData.append("usuario", usuario);
    formData.append("clave", clave);  
    const response=await this.fetch("insert/AgregarUsuario.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
    return response;
}

/** MODAL PARA MODIFICAR UN USUARIO */
var modalModificarUsuario=new bootstrap.Modal(document.getElementById('modalModificarUsuario'), {
    keyboard: false
})
async function fnModalModificarUsuario(usuario){
    vgLoader.classList.remove('loader-full-hidden');
    const data=await fnModalModificarUsuario2(usuario)
    console.log(data)
    if(data[0].res==='200'){
        document.getElementById('txtId02').value=data[2][0].id;
        document.getElementById('txtUsuario02').value=data[2][0].usuario;
        document.getElementById('cbRol02').value=data[2][0].role;
        document.getElementById('txtNombre02').value=data[2][0].nombre;
        document.getElementById('cbEstado02').value=data[2][0].estado;
        document.getElementById('msjModificarUsuario').innerHTML='';
        modalModificarUsuario.show()
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }else{
        document.getElementById('msjModificarUsuario').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}
async function fnModalModificarUsuario2(usuario){
    var formData = new FormData();
    formData.append("id", usuario);    
    const response=await this.fetch("view/ModalModificarUsuario.php", {
        method: "POST",
        body: formData
    })
    .then(res => res.json())
    .catch(err=>console.log(err));
    return response;
}

/** MODIFICAR INFORMACION DEL USUARIO */
async function fnModificarUsuario(id, rol, nombre, clave, estado){
    vgLoader.classList.remove('loader-full-hidden');
    const data=await fnModificarUsuario2(id, rol, nombre, clave, estado)
    if(data[0].res==='200'){
        document.getElementById('msjModificarUsuario').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjModificarUsuario').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${data[1].msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}
async function fnModificarUsuario2(id, rol, nombre, clave, estado){
    var formData = new FormData();
    formData.append("id", id);
    formData.append("role", rol);
    formData.append("nombre", nombre);
    formData.append("clave", clave);
    formData.append('estado', estado);    
    const response=await this.fetch("update/ModificarUsuario.php", {
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
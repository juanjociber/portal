const vgLoader=document.querySelector('.container-loader-full');

window.onload = async function(){
    vgLoader.classList.add('loader-full-hidden');
};

const modalAgregarImagen=new bootstrap.Modal(document.getElementById('modalAgregarImagen'), {
    keyboard: false
})

function fnModalAgregarImagen(){
    document.getElementById('msjAgregarImagen').innerHTML = '';
    modalAgregarImagen.show();
}

const MAX_WIDTH = 1080;
const MAX_HEIGHT = 720;
const MIME_TYPE = "image/jpeg";
const QUALITY = 0.7;
const $fileImagen = document.getElementById("fileImagen");
const $divImagen = document.getElementById("divImagen");

$fileImagen.onchange = function (ev) {
    const file = ev.target.files[0]; // get the file
    const blobURL = URL.createObjectURL(file);
    const img = new Image();
    img.src = blobURL;
    img.onerror = function () {
        URL.revokeObjectURL(this.src);
        // Handle the failure properly
        console.log("No se pudo cargar la imágen.");
    };
    img.onload = function () {
        URL.revokeObjectURL(this.src);        
        if ( $divImagen.hasChildNodes()){
            while ($divImagen.childNodes.length >= 1){
                $divImagen.removeChild($divImagen.firstChild);
            }
        }

        const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
        const canvas = document.createElement("canvas");
        canvas.width = newWidth;
        canvas.height = newHeight;
        canvas.id="canvas";
        const ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0, newWidth, newHeight);
        ctx.font = "15px Verdana";
        ctx.strokeStyle = 'rgba(216, 216, 216, 0.7)';
        ctx.strokeText("GPEM SAC.", 10, newHeight-10);
        canvas.toBlob(
            (blob) => {
                // Handle the compressed image. es. upload or save in local state
                displayInfo('Original: ', file);
                displayInfo('Comprimido: ', blob);
            },
            MIME_TYPE,
            QUALITY
        );
        console.log(canvas);
        $divImagen.append(canvas);
    };
};

function calculateSize(img, maxWidth, maxHeight) {
    let width = img.width;
    let height = img.height;
    // calculate the width and height, constraining the proportions
    if (width > height) {
        if (width > maxWidth) {
            height = Math.round((height * maxWidth) / width);
            width = maxWidth;
        }
    } else {
        if (height > maxHeight) {
            width = Math.round((width * maxHeight) / height);
            height = maxHeight;
        }
    }
    return [width, height];
}

// Utility functions for demo purpose
function displayInfo(label, file) {
    const p = document.createElement('p');
    p.classList.add('text-secondary', 'm-0', 'fs-6');
    p.innerText = `${label} ${readableBytes(file.size)}`;
    $divImagen.append(p);
}

function readableBytes(bytes) {
    const i = Math.floor(Math.log(bytes) / Math.log(1024)),
    sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];
    return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
}


async function fnAgregarImagen(){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnAgregarImagen2();
    console.log(datos);
    if(datos.res === '200'){
        document.getElementById('msjAgregarImagen').innerHTML=`<div class="alert alert-success m-0 p-1 text-center" role="alert">${datos.msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
                location.reload();
            },500)
        })
    }else{
        document.getElementById('msjAgregarImagen').innerHTML=`<div class="alert alert-danger m-0 p-1 text-center" role="alert">${datos.msg}</div>`;
        await new Promise((resolve, reject)=>{
            setTimeout(function(){
                vgLoader.classList.add('loader-full-hidden');
            },500)
        })
    }
    return false;
}


async function fnAgregarImagen2(){
    let imagen='';
    if(document.getElementById('canvas')){
        let canvas = document.querySelector("#canvas");
        imagen = canvas.toDataURL("image/jpeg");
    }   
    const formData = new FormData();
    formData.append('action', 'add');
    formData.append('cotid', document.getElementById('txtCotId').value);
    formData.append('descripcion', document.getElementById('txtDescripcion').value);
	formData.append('imagen', imagen);
	const response = await fetch("/portal/cotizador/update/ModificarCotizacionImagen.php", {
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

async function fnEliminarImagen(id){
    vgLoader.classList.remove('loader-full-hidden');
    const datos = await fnEliminarImagen2(id);
    if (datos.res === '200') {
        location.reload();
    } else {
        alert(datos.msg);
    }
    await new Promise((resolve, reject) => {
        setTimeout(function () {
            vgLoader.classList.add('loader-full-hidden');
        }, 500)
    })
    return false;
}

async function fnEliminarImagen2(id){
    const data = new FormData();
    data.append('id', id);    
    data.append('cotid',document.getElementById('txtCotId').value);
    data.append('action', 'del');
    const response = await this.fetch('/portal/cotizador/update/ModificarCotizacionImagen.php', {
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

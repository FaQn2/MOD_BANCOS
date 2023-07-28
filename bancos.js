document.addEventListener('DOMContentLoaded', function() {
console.log("conectado")

const modal = $('#modal');
const tituloModal = document.getElementById('modal_titulo');
const btnAgregar = document.getElementById('btn_add');
const URL_APP = 'http://localhost/MOD_BANCOS/cnn.php';


let table = $("#table").DataTable({
    language:{
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    },  
    "responsive": true,
    "lengthChange": false,
    "autoWidth": false,
    columns: [
        {
            title: 'nombre',
            data: 'denom',
        },
        {
            title: 'Código de Entidad',
            data: 'cod_entidad',
        },
        {
            title: 'Acciones',
            data: null,
            defaultContent: `
            <div class= "d-flex justify-content-around">
                <button type="button" class="btn btn-danger" id="btn_modificar"><i class="fas fa-pen"></i></button>
            </div>`
        },
    ],
    "buttons": ["excel", "pdf"]
});
table.buttons().container().appendTo('#table_wrapper .col-md-6:eq(0)');





function showModal(type, message) {
    if (type === 'success') {
        swal({
            title: "¡Éxito!",
            text: message,
            icon: "success",
            button: "Aceptar"
        });
    } else if (type === 'error') {
        swal({
            title: "¡Error!",
            text: message,
            icon: "error",
            button: "Aceptar"
        });
    }
}
function showAlert(type, message) {
    const alertElement = document.createElement('div');
    alertElement.classList.add('alert', `alert-${type}`, 'fade', 'show');
    alertElement.role = 'alert';
    alertElement.textContent = message;

    const alertContainer = document.getElementById('alert-container');
    alertContainer.appendChild(alertElement);

    setTimeout(function() {
        alertContainer.removeChild(alertElement);
    }, 2500);
}


//  ELEMENTOS MODAL
// const inputCodigoContacto = document.getElementById('input_codigo_contacto'),
const form = document.getElementById('form'),
    inputBanco = document.getElementById('input_banco'),
    inputCodigoBanco = document.getElementById('input_cod');
    
//#endregion

//#region =>    VARIABLES
let tipoRegistro = 'insertBanco'; // Flag para determinar si es un insert o update
let idBancos;
//#endregion

//#region =>    EVENTOS DOM
/* validate(false, inputDescripcion); 
 */
btnAgregar.addEventListener("click", () => {
    tipoRegistro = 'insertBanco';
    idBancos = null;
    tituloModal.innerText = 'Alta de nuevo banco';
    modal.modal('toggle');
    document.getElementById("input_cod").style.display = 'block';
    document.getElementById("cod_label").style.display = 'block';
    
});

  table.on('click', '#btn_modificar', async function () {
    var bancos = table.row($(this).closest('tr')).data();
    idBancos = bancos.codigo;

    inputBanco.value = bancos.denom;
    inputCodigoBanco.value = bancos.cod_entidad;  
    tipoRegistro = 'updateBancos';
    tituloModal.innerText = `Modificar el banco ${bancos.denom} - ${bancos.cod_entidad} `
    modal.modal('toggle');
    document.getElementById("input_cod").style.display = 'none';
    document.getElementById("cod_label").style.display = 'none';


}) 

modal.on('shown.bs.modal', function () {
    inputBanco.focus();

})
modal.on('hide.bs.modal', function () {
    form.reset();
    inputBanco.classList.remove('is-valid', 'is-invalid');
}) 

form.addEventListener('submit', async e => {
    e.preventDefault();
   
    if (!inputBanco.value.trim()) {
        showModal('error', 'Debe ingresar un banco').then(() => {
            inputBanco.focus()
        })
        return;
    }
    
     if (!inputCodigoBanco.value.trim()) {
        showModal('error', 'Debe ingresar el codigo de banco').then(() => {
            inputCodigoBanco.focus()
        })
        return;
    }
   

    let formData = new FormData();
    formData.append('funcion', tipoRegistro);
    formData.append('denom', inputBanco.value.trim());
    formData.append('cod_entidad', inputCodigoBanco.value.trim());
    
    if (idBancos) {
        formData.append('codigo', idBancos);
        
    }
    try {
        const res = await fetch(URL_APP , {
            method: 'POST',
            body: formData
        });
        
        const data = await res.json();
       
        if (data.status === 200) {

           if (tipoRegistro === 'insertBanco') {
            showModal('success', 'Banco añadido').then(() => {
                table.row.add(data.data).draw();
                modal.modal('toggle')
            })           
 
        } else {
            showModal('success', 'Modelo modificado').then(() => {
                //retorna UNDEFINEd, reemplzar fila no esta definido aca
                reemplazarFila(table, 'codigo', data.data[0].codigo, data.data[0]);
                modal.modal('toggle') 
            })
        }
        
        }else {
            showModal('error', data.message);
            console.log("error al agregar el banco")
            console.log('Error: ', res.status);
        }  
         
    } catch (error) {
        console.log(error);
    }
})



// ### Detectar combinación de teclas -->
document.addEventListener('keydown', (e) => {
    //Combinación de tecla Open Modal Alta Cliente
    if (e.altKey && String.fromCharCode(e.keyCode) == 'A') {
        tipoRegistro = 'insertBanco';
        idBancos = null;
        tituloModal.innerText = 'Alta de nuevo Bancos';
        modal.modal('toggle');
    }
}, false);
//#endregion
  getBancos().then(bancos => {
     table.rows.add(bancos).draw(); 

});  


//#region =>    Funciones

// Función para reemplazar una fila en la tabla 
function reemplazarFila(table, columna, valor, nuevaData) {
    let filaIndex = -1;
    table.rows().every(function (rowIdx) {
        let data = this.data();
        if (data[columna] === valor) {
            filaIndex = rowIdx;
            return false;
        }
        return true;
    });

    if (filaIndex >= 0) {
        table.row(filaIndex).data(nuevaData).draw();
    }
}


  async function getBancos() {
    let formData = new FormData();
    formData.append('funcion', 'getBancos');
    try {
        const res = await fetch(URL_APP, {
            method: 'POST',
            body: formData
        });

        const jsonData = await res.json();

        if (jsonData.status === 200) {
            return jsonData.data;
        } else {
            showModal('error', jsonData.message);
            return [];
        }
    } catch (error) {
        console.log(error);
        return [];
    }
} 
}); 


//#endregion





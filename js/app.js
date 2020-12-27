//varibales globales
//obtenemos la etiqueta de formualrio
const formualrioCo = document.querySelector("#contacto");
const contactos =  document.querySelector("#listado-contactos");
const tbodyC = document.querySelector(".tbody");
const buscar = document.querySelector("#buscar");


//eventos
formualrioCo.addEventListener('submit',guardarContacto);

//se valida si lavariable contactos existe, ya que listado contactos solo esta en el index y no en editar.php(donde se editan los contactos)
if( contactos){
    contactos.addEventListener('click',eliminarContacto);
}
if(buscar){
    buscar.addEventListener('input',buscarContactos);
}
if(buscar){
    contadorContactos();
}



//se ejecuta tanto para editar contacto e insertar nuevo contacto, ya que en ambas se tiene que validar
//y esat funciona llama a otra para validadr
function guardarContacto(e){
    e.preventDefault();

    validarFormulario();
    
}

/*validampos los campos del formulario*/
function validarFormulario(){
     /*Extraemos todos los inputs para ser validados* */
     
    const nombre = document.querySelector("#nombre");
    const empresa = document.querySelector("#empresa");
    const telefono = document.querySelector("#telefono");
    const accion = document.querySelector("#accion").value;

    let numeros = /^([0-9])*$/;

    //valida si los campos tiene alguin valor
    if(nombre.value && empresa.value && telefono.value ){
        //si el valor de telefono son numero ejecuta ek fi
        if((numeros.test(telefono.value))){

            const infcontacto = new FormData();
            //se ingresa los datos en el areglo formdata para que php nos reconosca nuestro areglo asociativo
            infcontacto.append('nombre',nombre.value);
            infcontacto.append('empresa',empresa.value);
            infcontacto.append('telefono',telefono.value);
            infcontacto.append('accion',accion);
            //evalua si la etiqueta de accion es a crear, se ejecuta y realiza una insercion en la base de datos por medio de ajax
            //llamando a la funcion insertarDatosDB
            if(accion ==='crear'){
                insertarDatosDB(infcontacto);
                formualrioCo.reset();                
                mostrarNotificacion("Contacto agregado correctamente","exito");

                
            }
            //si la etiqueta no es crear entonces por defecto es editar
            else{

                const idregistro =  document.querySelector("#id").value;
                infcontacto.append("id",idregistro);
                formualrioCo.reset(); 
                actualizarContacto(infcontacto);
            }
        }
        //si el valor de telefono no es numeros ejecujat else
        else{
            mostrarNotificacion("telefono tiene que ser numeros","precaucion");
        }
        
    }
    //llama a la funcion para mostrar el mensaje de error y que son onligatorios todos los datos(inputs)
    else{
        mostrarNotificacion("Todos los campos son obligatorios","error");
    }

}  

//inserta datos en la db por medio de ajax
function insertarDatosDB(datos){
    
    const xmlhtt = new XMLHttpRequest();

    //abrimos el archivo el cual vamos ahacer uso y enviar datos a traves de POST
    xmlhtt.open('POST','inc/modelos/modelos-contacto.php',true);
    xmlhtt.onload= function(){
        if(this.status == 200){
            
            //extrae el json que del servidor para usarlo y crear un nuevo registro en la tabal de nuestro html
            //
            const jsonrespuestas = JSON.parse(this.responseText);
            //se crea un nuevo nodo(elemento html) y se agrega al contenedor tbody
            const newContact = document.createElement("tr");
            newContact.innerHTML = `<td>${jsonrespuestas.datos.nombre}</td>
                                    <td>${jsonrespuestas.datos.empresa}</td>
                                    <td>${jsonrespuestas.datos.telefono}</td>
                                    <td>
                                        <a href="editar.php?id=${jsonrespuestas.datos.id}" class="btn upd">
                                            <i class="material-icons">edit</i>
                                        </a>
                                        <button data-id="${jsonrespuestas.datos.id}" class="btn btn-borrar">
                                            <i class="delete material-icons">delete</i>
                                        </button>
                                    </td>
                                    `;
            tbodyC.append(newContact);
            contadorContactos();
        
        }
    }
    //enviamos los datos que recibimos, estos ya han sido extraidos del formulario
    xmlhtt.send(datos);

}
//funcion para actualizar algun contacto por medio de ajax
function actualizarContacto(datos){
    
    const xmlhtt = new XMLHttpRequest();

    xmlhtt.open('POST','inc/modelos/modelos-contacto.php',true);

    xmlhtt.onload = function(){
        if(this.status === 200){
            const actualizar = JSON.parse(this.responseText);
            if(actualizar.respuesta === "Correcto"){
                mostrarNotificacion("Cambios realizados exitosamente","exito");
            }
            
            setTimeout(()=>{
                window.location.href = "index.php";
            },3000);
        }
    }
    //enviamos peticion

    xmlhtt.send(datos);
}
//funcions para realizar un Delete por medio de ajax hacia la base de datos
function eliminarContacto(e){

    //para apuntar con exactitud hacia que elemento estamos dando click
    //es por ello que se usa la delegacion de evento
    if(e.target.parentElement.classList.contains("btn-borrar")){
        const id = e.target.parentElement.getAttribute('data-id');
        //pregunta si estamos seguro antes de elimnar algun contacto
        const respuesta = confirm("seguro de eliminar contacto");

        if(respuesta){
           
            const xhttp = new XMLHttpRequest();
            //abre archivo donde enviaremos por medio de get un id y  la accion que en este caso es borrar
            //se manda al archivo del servidor con nombre modelos-contacto.php
            xhttp.open('GET','inc/modelos/modelos-contacto.php?id='+id+'&accion=borrar',true);

            xhttp.onload =  function(){
                if(this.status ===200){
                    const res = JSON.parse(xhttp.responseText);
                    console.log(res);
                    if(res.respuesta === "Correcto"){
                        //como estamos dando click en ele lemento del boton, tenemos que ir subiendo niveles hasta encontrar el padre donde esta encapsulado
                        //este elemento, por lo cual ese elemento es un tr, y ese tr es el que vamos a eliminar del dom
                        e.target.parentElement.parentElement.parentElement.remove();
                        contadorContactos();
                        mostrarNotificacion("eliminado correctamente","exito");
                    }
             
                }
            }
            xhttp.send();
            
        }
        else{
            //si se desea no eliminar el contacto mostramos una notificacion de 'Cancelamos la eliminación de contacto'
            mostrarNotificacion("Cancelamos la eliminación de contacto","precaucion");
        }
    }
}
//para mostrar noficacion, ya sea exitosa al agregar nuevo contacto, o error al agregar contacto
//tambien para mostrar eliminar exitosamente un contacto  o error al eliminarlo
function mostrarNotificacion(mensaje,tipoMensaje){

    const notificacion = document.createElement("div");
    notificacion.classList.add('notificacion');
    notificacion.classList.add(tipoMensaje);
    notificacion.textContent = mensaje;

    //
    formualrioCo.insertBefore(notificacion,document.querySelector("#contacto legend"));

    //estilos para mostrar y ocultar la notificacion
    setTimeout(()=>{
        notificacion.classList.add("visible");
        setTimeout(()=>{
            notificacion.classList.remove("visible");
            
            setTimeout(()=>{
                notificacion.remove();
            },1500);
        },3000)
    },100);
    
}

//funcion para buscar contactos en especifico
function buscarContactos(e){
    //e captura lo del input y se va guardando en una expresion regular
    const buscarR = new RegExp(e.target.value,"i");
    const registro =  document.querySelectorAll("tbody tr");
    //se itera  el total de los tr dentro de la tabla body
    registro.forEach(registro=>{
        //al momenot de empezar a escibir se limpia los registro de la tabla para poder listar los nuevos a buscar
        registro.style.display = 'none';
        if(registro.childNodes[1].textContent.replace(/\s/g," ").search(buscarR)!=-1){
            registro.style.display = "table-row";
        }
    })

}
function contadorContactos(){
    const cntContactos  = document.querySelectorAll('tbody tr');
    const spanNumero = document.querySelector(".total-contactos span");
    let total = 0;

    cntContactos.forEach(contacto =>{
        if(contacto.style.display === ''|| contacto.style.display === "table-row"){
            total++;
        }
    })
    spanNumero.textContent = total;
}
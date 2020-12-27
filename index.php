<?php  include 'inc/funciones/consultas.php'; ?>

<?php  include 'inc/layout/header.php'; ?>


    <div class="contenedor-barra">
        <h1>Contactos Personales</h1>
    </div>
    <div class="bg-amarillo contenedor sombra">
        <form action="#" id="contacto">
            <legend>Añada un Contacto
                <span>Todos los campos son oligatorios</span>
            </legend>
            
            <?php  include 'inc/layout/formulario.php'; ?>
            
        </form>    
    </div>
    <div class="bg-contactos contenedor sombra contactos">
        <div class="contenedor-contactos">
            <h2>Contactos</h2>
            <input type="text" id="buscar" class="buscador sombra" placeholder="Buscar contactos"> 
            <p class="total-contactos"><span></span>Contactos</p>
            <div class = "contenedor-tabla">
                <table id="listado-contactos">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Empresa</th>
                            <th>Teléfono</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody class= "tbody">
                        <?php 
                            $contactos = obtenerContactos();
                            if($contactos ->num_rows){
                                
                                foreach($contactos as $valor){
                        ?>
                                    <tr class="<?php echo $valor['id']; ?>">
                                        
                                        <td>
                                            <?php echo $valor['nombre']; ?> 
                                        </td>
                                        
                                        <td>
                                        <?php echo $valor['empresa']; ?>
                                        </td>
                                        <td>
                                        <?php echo $valor['telefono']; ?>
                                        </td>
                                        <td>
                                            <a href="editar.php?id=<?php echo $valor['id']; ?>" class="btn upd">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <button data-id="<?php echo $valor['id']; ?>" class="btn btn-borrar">
                                                <i class="delete material-icons">delete</i>
                                            </button>
                                        </td>
                                    </tr>
                        <?php
                                }
                            }
                        ?>
                    </tbody>

                </table>

            </div>
        </div>
    </div>


<?php     include 'inc/layout/footer.php'; ?>
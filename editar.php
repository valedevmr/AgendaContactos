<?php  
//exportamos funciones donde tenemos la conexion a al bd y los estilos css
    include 'inc/funciones/consultas.php';
    include 'inc/layout/header.php';

    $id = filter_var( $_GET['id'],FILTER_VALIDATE_INT);

    if(!$id){
        die("no es valido");
    }

    $queryConsultar = editContacto($id);
    $resultado = $queryConsultar->fetch_assoc(); 

?>

    <div class="contenedor-barra">
        <div class="contenedor barra">
            <a href="index.php" class="btn volver"> volver</a>
            <h1>Contactos Personales</h1>
        </div>
       
    </div>

    <div class="bg-amarillo contenedor sombra">
        <form action="#" id="contacto">
            <legend>Edite un Contacto
            </legend>
            <?php  include 'inc/layout/formulario.php'; ?>
        </form>
    </div>


<?php   include 'inc/layout/footer.php'; ?>
<?php

    function obtenerContactos(){
        include_once('conexiondb.php');

        try{

            return $conn ->query("SELECT id,nombre, empresa,telefono FROM contactos");
        }
        catch(Exception $e){

            echo "error!".$e->getMessage()."<br>";
            return false;

        }
    }
    function editContacto($id){
        include_once('conexiondb.php');

        try{

            return $conn ->query("SELECT id,nombre, empresa,telefono FROM contactos WHERE id = $id");
        }
        catch(Exception $e){

            echo "error!".$e->getMessage()."<br>";
            return false;

        }
    }

?>
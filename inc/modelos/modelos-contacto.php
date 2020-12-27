<?php
    

    //lemos el campo de crear para crear un nuevo registro en la base de datos
    if($_POST){
        if($_POST['accion']=='crear'){
            require_once('../funciones/conexiondb.php');
            //validaremos para evitar alguna inyeccioon sql
    
            
            $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
            $empresa = filter_var($_POST['empresa'],FILTER_SANITIZE_STRING);
            $telefono = filter_var($_POST['telefono'],FILTER_SANITIZE_STRING);
            try{
                
                $statemen = $conn->prepare("INSERT INTO contactos (nombre, EMPRESA,telefono) VALUES (?,?,?)");
                $statemen->bind_param("sss",$nombre,$empresa,$telefono);
                $statemen->execute();
                    $Respuesta= array(
                        "respuesta"=>"correcto",
                        'datos'=> array(
                            "nombre"=>$nombre,
                            "empresa"=>$empresa,
                            "telefono"=>$telefono,
                            "id" => $conn->insert_id
                        )
        
                    );
                    
                    
                
                
                $statemen->close();
                $conn->close();
            }
            catch(Exception $e){
                $Respuesta = array(
                    'error'=>$e->getMessage()
                );
    
            }
                echo json_encode($Respuesta);
        }
        else{
            
            require_once('../funciones/conexiondb.php');
            $nombre = filter_var($_POST['nombre'],FILTER_SANITIZE_STRING);
            $empresa = filter_var($_POST['empresa'],FILTER_SANITIZE_STRING);
            $telefono = filter_var($_POST['telefono'],FILTER_SANITIZE_STRING);
            $id = filter_var($_POST['id'],FILTER_VALIDATE_INT);
            $queryUPDATE = "UPDATE contactos SET nombre = ?, empresa = ?, telefono = ? WHERE id = ?";

            try{
                $statemen = $conn->prepare($queryUPDATE);
                $statemen->bind_param("sssi",$nombre,$empresa,$telefono,$id);
                $statemen->execute();
                if($statemen->affected_rows == 1){
                    $Respuesta = array(
                        "respuesta"=>"Correcto"
                    );
                }
                else {
                    $Respuesta = array(
                        'respuesta'=>'error'
                    );
                }
                $statemen->close();
                $conn->close();
           }
           catch(Exception $e){
                $Respuesta =array(
                    "error"=> $e->getMessage()
                );
    
           }
            echo json_encode($Respuesta);
        }
    }
    

    //verificamos si la variable global  GET existe, esto con el fin de evitar propblemas al tratar de llamar el json 
    //respuesta tanto para crear y borrar
    if($_GET){
        if($_GET['accion']=='borrar'){
            require_once('../funciones/conexiondb.php');
            $id= $_GET['id'];
            $querySLQ = "DELETE FROM contactos WHERE id = ?";
           try{
                $statemen = $conn->prepare($querySLQ);
                $statemen->bind_param("i",$id);
                $statemen->execute();
                if($statemen->affected_rows == 1){
                    $Respuesta = array(
                        "respuesta"=>"Correcto"
                    );
                }
                $statemen->close();
                $conn->close();
           }
           catch(Exception $e){
                $Respuesta =array(
                    "error"=> $e->getMessage()
                );
    
           }
           echo json_encode($Respuesta);
        }
    }
    
?>
        <div class="campos">

                <div class="campo">

                    <label for="nombre">Nombre</label>
                    <input type="text" placeholder="ingresa nombre contacto" id="nombre" 
                    value="<?php 
                                if((isset($resultado))){
                                    echo $resultado['nombre'];
                                 }
                                 else {
                                     echo "";
                                 }
                            ?>">

                </div>
                <div class="campo">
                
                    <label for="empresa">Empresa</label>
                    <input type="text" placeholder="ingresa nombre empresa" id="empresa"
                     value="<?php 
                                if((isset($resultado))){
                                    echo $resultado['empresa'];
                                 }
                                 else {
                                     echo "";
                                 }
                            ?>">

                </div>
                <div class="campo">
                
                    <label for="telefono">Teléfono</label>
                    <input type="tel" placeholder="ingresa telefono" id="telefono" 
                    value="<?php 
                                if((isset($resultado))){
                                    echo $resultado['telefono'];
                                 }
                                 else {
                                     echo "";
                                 }
                            ?>" >

                </div>
                 

        </div>
            
        <div class="campo enviar">
                <?php 
                            
                    $hacer = "";
                    $bandera = "";
                    
                    if(isset($resultado['id'])){
                        $bandera = "editar";
                        $hacer = "Guardar";
                    ?>
                        <input type="hidden"  value="<?php echo $resultado['id']; ?>" id="id">
                        <?php
                    }
                    else{
                        $bandera = "crear";
                        $hacer = "Añadir";
                    }
                ?>
                <input type="hidden"  value="<?php echo $bandera ?>" id="accion">
                <input type="submit" value ="<?php echo $hacer?>" id="">

        </div>
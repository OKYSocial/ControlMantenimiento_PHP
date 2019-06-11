<!DOCTYPE html>
<html>
    <head>
           <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
           <title>Eliminar</title>      
    </head>
    <body>
         <?php 
                require_once '../Vistas/WebPage_Maestro.php';                
                require_once '../Controladores/Funciones.php';   
                
                $id = base64_decode(filter_input(INPUT_GET, 'id'), FILTER_SANITIZE_NUMBER_INT);                 
                $tabla = base64_decode($tabla= filter_input(INPUT_GET, 'tabla'), FILTER_SANITIZE_STRING);
              
                    if ( !empty($_POST))
                    {
                         $id = filter_input(INPUT_POST, 'itId', FILTER_SANITIZE_NUMBER_INT);
                         
                         $tabla= filter_input(INPUT_POST, 'itTabla', FILTER_SANITIZE_STRING);                  
                         $controlador  = Funciones::CrearControlador();
                         $Resultado=$controlador->EliminarRegistro($tabla, $id);
                            if ($Resultado == 0)
                            {
                                $mensaje=NULL;  
                                header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=R&mensaje=$mensaje");                                 
                            }
                            else if ($Resultado == 1)
                            {
                              if ($tabla== 'TBL_OPERARIOS')
                                { 
                                    $mensaje= Mensaje20;
                                    header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");                                                  
                                } 
                                elseif ($tabla == 'TBL_LISTAVALORES') 
                                {   
                                  $mensaje= Mensaje9;
                                  header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");                                
                                }
                                elseif ($tabla == 'TBL_EQUIPOS')
                                {
                                    $mensaje= Mensaje22;                                
                                    header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje"); 
                                }                              
                            }
                            else
                            {
                                $mensaje= MensajeErrorBD;
                                header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje"); 
                            }           
                        }                                           

	?>
        
  
 
 
	
        <form name="WebPage_Eliminar" action="WebPage_Eliminar.php" 
              class="formoid-solid-green" 
              style="background-color:#FFFFFF;
                     font-size:12px;
                     font-family:'Roboto', Arial,Helvetica,sans-serif;
                     color:#34495E;
                     max-width:480px;
                     min-width:150px"
                     method="post"> 
             
             <div class="title">
                    <h2><img src="../resources/Imagenes/Advertencia.jpg"/></h2>                      
             </div> 
            
             <input type="hidden" id="itId" name="itId" value="<?php echo $id;?>"/>
             <input type="hidden" id="itTabla" name="itTabla" value="<?php echo $tabla;?>"/>
	    
             
             <div align="center">
                 <button type="submit" style="background-color: red; color: #FFFFFF;">Si eliminar</button>
             </div>
             
             <div align="center">
                   <a  href="WebPage_Menu.php">NO</a>
             </div>
                    
             
             
        </form>     
      
  
    </body>
</html>

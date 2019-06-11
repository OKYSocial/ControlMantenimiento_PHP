<!DOCTYPE html>
<html>
    <head>			
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <title>Acceso</title>                  
          <script src="js/ValidacionesPaginas.js" type="text/javascript"></script>
          
    </head>    
    <body>        
            <?php 
               require_once '../Vistas/WebPage_Maestro.php';                          
               require_once '../Controladores/ControladorAcceso.php';             


               $mensajeError =  NULL;
               $documento=NULL;
               $clave=NULL;
             
               if ( !empty($_POST)) 
               {     
                $mensajeError =  Mensaje2;     
                $documento=trim(filter_input(INPUT_POST, 'itDocumento', FILTER_SANITIZE_STRING));
                $clave =trim(filter_input(INPUT_POST,'itClave', FILTER_SANITIZE_STRING));               
                $ingresar = true;
                
                if (Funciones::Validar_CampoRequerido($documento)) {
		    $ingresar = false;
                    $mensajeError ='Documento'.' '.MensajeCampoRequerido;	                    
		}  
                if (!preg_match('/^[0-9]+$/', $documento))
                { // No mostrar mensaje para que no se enteren que el campo es numérico
                   $ingresar = false;                                          
                }
                if(strlen($documento) < 6){
                    $ingresar = false;                    
                }
                if (Funciones::Validar_CampoRequerido($clave)){
                   $ingresar = false; 
                   $mensajeError ='Clave'.' '.MensajeCampoRequerido;		    
                }       
                if(strlen($clave) < 6){
                  $ingresar = false;                    
                }
                if ($ingresar)
                {             
                  ControladorAcceso::IngresarSistema($documento, $clave);
                }
               } 
	?>

        <form name="index" 
              action="index.php" 
              class="formoid-solid-green" 
              style="background-color:#FFFFFF;
                     font-size:12px;
                     font-family:'Roboto',Arial,Helvetica,sans-serif;
                     color:#34495E;
                     max-width:480px;
                     min-width:150px" 
              method="post">
            
         <div class="title"><h2><i class="fa fa-key"></i>&nbsp;Acceso</h2></div>
         
	 <div class="element-name">
              <label class="title">
                     <span class="required">Documento *</span>
              </label>
             <div class="nameFirst">
                  <input class="medium" 
                         type="text" 
                         id="itDocumento" 
                         name="itDocumento" 
                         required="required"
                         placeholder="Usuario"
                         value="<?php echo !empty($documento)?$documento:'';?>"/>                
                  <span class="icon-place"></span>
              </div>
         </div>
         
	 <div class="element-password">
              <label class="title">
                     <span class="required">Clave *</span>
              </label>

             <div class="item-cont">
                  <input class="medium" 
                         type="password" 
                         id="itClave" 
                         name="itClave" 
                         required="required"
                         placeholder="Password"
                         value="<?php echo !empty($clave)?$clave:'';?>"/>                  
                  <span class="icon-place"></span>
             </div>
         </div>
         
    
         
         <div>

             <input class="large" 
                     type="text" 
                     id="itMensajeError" 
                     name="itMensajeError" 
                     readonly="true"
                     style=" border-style: none; color: red; background: white"
                     value="<?php echo !empty($mensajeError)?$mensajeError:'';?>"/>              
         </div>
         
         <div class="submit">
             <input type="submit"  
                    value="Enviar" 
                    onmousedown="return VerificarAcceso();"/>
         </div>
            
         
         
     </form>
        
   </body>
 </html>

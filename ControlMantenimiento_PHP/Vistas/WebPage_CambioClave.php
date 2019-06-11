<!DOCTYPE html>
<html>
<head>       
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Cambio Clave</title>	
        <script src="js/ValidacionesPaginas.js" type="text/javascript"></script>
</head>
<body>
       <?php 
               require_once '../Vistas/WebPage_Maestro.php';            
               require_once '../Controladores/Funciones.php';              
               require_once '../Controladores/ControladorCambioClave.php';                 
               
               $mensajeError =  NULL;
               $clave=  NULL;
               $clavenueva=  NULL;
               $confirmar=  NULL;                           
 
               if (!empty($_POST))
               {
                 $clave =trim(filter_input(INPUT_POST, 'itClave', FILTER_SANITIZE_STRING));
                 $clavenueva =trim(filter_input(INPUT_POST, 'itClaveNueva', FILTER_SANITIZE_STRING));
                 $confirmar =trim(filter_input(INPUT_POST, 'itConfirmar', FILTER_SANITIZE_STRING));
                
                $grabar = true;                
                if (Funciones::Validar_CampoRequerido($clave)){   
                    $grabar = false;
	            $mensajeError ='Clave'.' '.MensajeCampoRequerido;	
		}	               
                if (Funciones::Validar_CampoRequerido($clavenueva)){   
                    $grabar = false;
		    $mensajeError ='ClaveNueva'.' '.MensajeCampoRequerido;
		}	
                if (strlen($clavenueva)<6) {
                    $grabar = false;
		    $mensajeError = Mensaje21;			
		}
                if ($clavenueva == $clave) {
		    $grabar = false;
                    $mensajeError = Mensaje4;		    
		}                
                if (Funciones::Validar_CampoRequerido($confirmar)){                  
		    $grabar = false;	
                    $mensajeError ='Confirmar'.' '.MensajeCampoRequerido;		
		}	
                if ($confirmar != $clavenueva) {
                    $grabar = false;
		    $mensajeError = Mensaje5;		    
		}
                if ($grabar)
                {             
                  ControladorCambioClave::GrabarCambioClave($clave, $clavenueva);
                }
               } 
	?>

    
     
       
        <form name="WebPage_CambioClave" 
              action="WebPage_CambioClave.php"
              class="formoid-solid-green" 
              style="background-color:#FFFFFF;
                     font-size:12px;
                     font-family:'Roboto', Arial,Helvetica,sans-serif;
                     color:#34495E;
                     max-width:480px;
                     min-width:150px" 
              method="post">
        
        <div class="title"><h2><i class="fa fa-key"></i>&nbsp;Cambio Clave</h2></div>
	 
	<div class="element-password">
             <label class="title">
                    <span class="required">Clave Actual *</span>
             </label>
            <div class="item-cont">
                 <input class="medium" 
                        type="password" 
                        id="itClave" 
                        name="itClave" 
                        maxLength="20" 
                        required="required" 
                        placeholder="Clave"
                        value="<?php echo !empty($clave)?$clave:'';?>"/>             
                 <span class="icon-place"></span>
            </div>
        </div>
        
        <div class="element-password">
             <label class="title">
                    <span class="required">Clave Nueva *</span>
             </label>
            <div class="item-cont">
                 <input class="medium" 
                        type="password" 
                        id="itClaveNueva" 
                        name="itClaveNueva" 
                        maxLength="20" 
                        required="required" 
                        placeholder="Clave Nueva"
                        value="<?php echo !empty($clavenueva)?$clavenueva:'';?>"/>                
                 <span class="icon-place"></span>
            </div>
        </div>
        
        <div class="element-password">
             <label class="title">
                    <span class="required">Confirmar *</span>
             </label>
            <div class="item-cont">
                 <input class="medium" 
                        type="password" 
                        id="itConfirmar" 
                        name="itConfirmar" 
                        maxLength="20" 
                        required="required" 
                        placeholder="Confirmar Clave"
                        value="<?php echo !empty($confirmar)?$confirmar:'';?>"/>                
                 <span class="icon-place"></span>
            </div>
        </div>    
        
        <div>
              <input class="large" 
                     type="text" 
                     id="itMensajeError" 
                     name="itMensajeError" 
                     readonly="readonly"
                     style=" border-style: none; color: red; background: white"
                     value="<?php echo !empty($mensajeError)?$mensajeError:'';?>"/>              
        </div>
        
        <div class="submit">
             <input type="submit" 
                    value="Enviar" 
                    onmousedown="return VerificarCambioClave();"/>              
         </div>
       </form>
           
    

</body>

</html>
<!DOCTYPE html>
<html>
    <head>     
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <title>Operarios</title>                  
          <script src="js/ValidacionesPaginas.js" type="text/javascript"></script>
    </head>    
    <body>        
       <?php           
          require_once '../Vistas/WebPage_Maestro.php';
          require_once '../Modelos/Operario.php';
          require_once '../Controladores/ControladorOperario.php';         
          require_once '../Controladores/Funciones.php';
                   
          $_SESSION['Listado']=NULL;
          $mensajeError= NULL;
          $id=0;          
          $documento= NULL;
          $nombres = NULL;
          $apellidos = NULL;
          $telefono =NULL;
          $correo =NULL;
          $foto =NULL;       
          $imagencargar='../resources/Imagenes/';

          $controlador = Funciones::CrearControlador();
 
          if ( !empty($_GET['id']))
          {       
                $id = base64_decode(filter_input(INPUT_GET, 'id'), FILTER_SANITIZE_NUMBER_INT); 
                $operario = $controlador->ObtenerOperario($id, "TBL_OPERARIOS");

                  if ($operario != NULL)
                  {
                      $id = $operario->getOperario_Id();
                      $documento = $operario->getDocumento();
                      $nombres = $operario->getNombres();
                      $apellidos = $operario->getApellidos();
                      $telefono =$operario->getTelefono();
                      $correo =$operario->getCorreo();                      
                      $foto = $operario->getFoto();
                      if ($operario->getFoto() !=NULL)
                      {
                       $imagencargar= $imagencargar . $operario->getFoto();
                      }
                      else
                      {
                          $imagencargar=NULL;
                      }
                  }
              
        }       
        
            if ( !empty($_POST)) {           
                $id=filter_input(INPUT_POST,'itCampoClave');  
                $documento=trim(filter_input(INPUT_POST,'itDocumento',FILTER_SANITIZE_STRING));
                $nombres =trim(ucwords(strtolower(filter_input(INPUT_POST, 'itNombres',FILTER_SANITIZE_STRING))));
                $apellidos =trim(ucwords(strtolower(filter_input(INPUT_POST, 'itApellidos',FILTER_SANITIZE_STRING))));
                $telefono=(filter_input(INPUT_POST, 'itTelefono',FILTER_SANITIZE_NUMBER_INT));  
                $correo=(filter_input(INPUT_POST, 'itCorreo', FILTER_SANITIZE_EMAIL)); 
                $foto=filter_input(INPUT_POST, 'itFoto',FILTER_SANITIZE_STRING);
            
             $grabar = true;
                if (Funciones::Validar_CampoRequerido($documento)){                
                        $grabar = false;
			$mensajeError ='Documento'.' '.MensajeCampoRequerido;			
		}          
                if (Funciones::Validar_SoloNumeros($documento)){                
                        $grabar = false;
                        $mensajeError = Mensaje25;
                }
                if(Funciones::Validar_Longitud($documento, 'Menor', 6, 0)){
                    $grabar = false;
                    $mensajeError = Mensaje15;		     
                }
                if(Funciones::Validar_PrimeraPosicion($documento)){
                    $grabar = false;
                    $mensajeError = Mensaje6;		     
                }	
                if (Funciones::Validar_CampoRequerido($nombres)){    
                        $grabar = false;
			$mensajeError ='Nombres'.' '.MensajeCampoRequerido;		
		}
                if (Funciones::Validar_CampoRequerido($apellidos)){   
                        $grabar = false;
			$mensajeError = 'Apellidos'.' '.MensajeCampoRequerido;		
		}	                
                if (Funciones::Validar_CampoRequerido($telefono)){   
                        $grabar = false;
			$mensajeError = 'Telefono'.' '.MensajeCampoRequerido;			
		}            
                if (Funciones::Validar_SoloNumeros($telefono)){                        
                        $grabar = false;
                        $mensajeError = Mensaje25;  
                }
                if(Funciones::Validar_PrimeraPosicion($telefono)){
                    $grabar = false;
                    $mensajeError = Mensaje6;		     
                }
                // Aceptar sólo 7 dígitos para teléfonos fijos y 10 para celulares
                if(Funciones::Validar_Longitud($telefono, 'Rango', 7, 10)){
                     $grabar = false;
                     $mensajeError = Mensaje17;		      
                }
                
                if ($correo != '') {
                   if (Funciones::Validar_Correo($correo)){
                       $grabar = false; 
                       $mensajeError = Mensaje16;                       
                     }
                }                
                if (isset($_FILES['image']['tmp_name'])) 
                {
                  $file=$_FILES['image']['tmp_name'];                  
                  if($file!=NULL)
                  {   
                    $type = $_FILES['image']['type'];
                    if($type == "image/jpeg" || $type == "image/gif" || $type == "image/jpg" || $type == "image/png")
	            {
                       $grabar = true; 
                    }
                    else
                    {
                        $grabar = false;                       
                        $mensajeError=Mensaje19;
                    }
                  }
                }                                                                               
                
                if ($grabar)
                {     
                   if($file!=NULL)
                   {
                   if (isset($_FILES['image']['tmp_name'])) 
                   {                      
                     $file=$_FILES['image']['tmp_name'];                     
                     if($file!=NULL)
                     {// Modificar la ruta de la carpeta de Imagenes, pues la foto debe quedar en el servidor                                    
                       move_uploaded_file($_FILES["image"]["tmp_name"],"../resources/Imagenes/" . $_FILES["image"]["name"]);
                       $foto=$_FILES["image"]["name"];                       
                     }
                   }
                  }
                  $accion =($id=='' ? "I": "U");
                  ControladorOperario::GrabarOperario($accion, $foto);                    
                }
          }
       ?>
                
           <form name="WebPage_Operarios" 
              enctype="multipart/form-data"
              action="WebPage_Operarios.php" 
              class="formoid-solid-green" 
              style="background-color:#FFFFFF;
                     font-size:12px;
                     font-family:'Roboto', Arial,Helvetica,sans-serif;
                     color:#34495E;
                     max-width:550px;
                     min-width:210px"
              method="post">
         
         <div class="title"><h2><i class="fa fa-group"></i>&nbsp;Operarios</h2></div>	                        
            
         <input id="itCampoClave" name="itCampoClave" type="hidden" value="<?php echo !empty($id)?$id:0;?>"/>
         <input id="itFoto" name="itFoto" type="hidden" value="<?php echo !empty($foto)?$foto:'';?>"/>

         <div align="center">
              <img src="<?php echo !empty($imagencargar)?$imagencargar:'';?>" width="100" height="100">
         </div> 
         
	<div class="element-input">
             <label class="title">
                    <span class="required">
                          Documento *
                    </span>
             </label>
            
             <div class="item-cont">
                  <input class="small"
                         type="text"
                         id="itDocumento"
                         name="itDocumento"                         
                         maxLength="10"      
                         placeholder="Solo Numeros"
                         required="required"
                         onkeypress="return ValidarNumeros(event)" 
                         onkeydown="return AnularPegado(event)" 
                         value="<?php echo !empty($documento)?$documento:'';?>"/>                   
                  <span class="icon-place"></span>
             </div>            
        </div>
        
	<div class="element-name">
             <label class="title">
                    <span class="required">
                          Nombres y Apellidos *
                    </span>
             </label>
             <span class="nameFirst">
                <input type="text"                       
                       id="itNombres" 
                       name="itNombres" 
                       required="required"
                       maxLength="25"        
                       placeholder="Nombres del Operario"
                       onkeypress="return SoloLetras(event)"    
                       onkeydown="return AnularPegado(event)"
                       value="<?php echo !empty($nombres)?$nombres:''; ?>"/>          
                
                <span class="icon-place"></span>
               
                </span><span class="nameLast">
                
                <input type="text"                        
                       id="itApellidos"
                       name="itApellidos"                        
                       required="required"             
                       maxLength="25"
                       placeholder="Apellidos del Operario"
                       onkeypress="return SoloLetras(event)"
                       onkeydown="return AnularPegado(event)"
                       value="<?php echo !empty($apellidos)?$apellidos:''; ?>"/>            
                <span class="icon-place"></span></span>
        </div>
                
	     <div class="element-phone">
                  <label class="title">
                         <span class="required">
                               Telefono *
                         </span>
                  </label>
                 <div class="item-cont">
                      <input class="small" 
                             type="tel" 
                             id="itTelefono" 
                             name="itTelefono" 
                             maxlength="10"  
                             required="required" 
                             placeholder="Solo Numeros"                        
                             onkeypress="return ValidarNumeros(event)" 
                             onkeydown="return AnularPegado(event)"                             
                             value="<?php echo !empty($telefono)?$telefono:'';?>"/>
                      
                      <span class="icon-place"></span>
                 </div>
             </div>
	     <div class="element-email">
                  <label class="title">
                         Email
                  </label>
                 <div class="item-cont">
                      <input class="medium" 
                             type="email"                              
                             id="itCorreo"
                             name="itCorreo" 
                             placeholder="Correo Electronico"
                             maxLength="50"
                             value="<?php echo !empty($correo)?$correo:'';?>">
                      
                      <span class="icon-place"></span>
                 </div>
             </div>
         
	     
	     <div class="element-file">
                  <label 
                        class="title">Foto
                  </label>
                 
              
                 <div class="item-cont">
                      <label class="medium">
                            <div class="button">
                                 Buscar Archivo
                            </div>
                            <input type="file" 
                                   class="file_input" 
                                   id="image"                                     
                                   name="image"/>
                            
                            <div class="file_text">No hay archivo seleccionado</div>                    
                            <span class="icon-place"></span>
                      </label>
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
                     onmousedown="return VerificarOperarios();"/>             
         </div>     
     </form>
        
   </body>
 </html>

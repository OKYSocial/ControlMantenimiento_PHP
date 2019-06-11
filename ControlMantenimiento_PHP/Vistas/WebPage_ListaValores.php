<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Lineas-Marcas</title>	
        <script src="../resources/js/ValidacionesPaginas.js" type="text/javascript"></script>
</head>
<body>
       <?php
              require_once '../Vistas/WebPage_Maestro.php';
              require_once '../Modelos/ListaValores.php';
              require_once '../Controladores/Funciones.php'; 
              require_once '../Controladores/ControladorListaValores.php';                    
            
              $_SESSION['Listado']=NULL;
              $mensajeError=NULL;
              $id=0;       
              $nombre =NULL;
              $descripcion=NULL;
              $tipo= base64_decode(filter_input(INPUT_GET, 'tipo',FILTER_SANITIZE_STRING));
             
              $controlador = Funciones::CrearControlador();    
              if ( !empty($_GET['id']))
              {
                   $id = base64_decode(filter_input(INPUT_GET, 'id'), FILTER_SANITIZE_NUMBER_INT);             
                   $listavalores = $controlador->ObtenerListaValores($id, 'TBL_LISTAVALORES');

                   if ($listavalores != NULL)
                   {	
                       $nombre = $listavalores->getNombre();
                       $descripcion = $listavalores->getDescripcion();
                       $tipo= $listavalores->getTipo();
                   }
              }
        
              if ( !empty($_POST)) 
              {
                   $id= (filter_input(INPUT_POST, 'itCampoClave', FILTER_SANITIZE_NUMBER_INT));                                           
                   $nombre=trim(strtoupper(filter_input(INPUT_POST, 'itNombre', FILTER_SANITIZE_STRING)));
                   $descripcion=trim(filter_input(INPUT_POST, 'itDescripcion', FILTER_SANITIZE_STRING));
                   $tipo = (filter_input(INPUT_POST, 'itTipo', FILTER_SANITIZE_STRING));  

                    $grabar = true;

                    if (Funciones::Validar_CampoRequerido($nombre))
                    {                    
                        $grabar = false; 
                        $mensajeError ='Nombre'.' '.MensajeCampoRequerido;			
                    }

                    if ($grabar)
                    {
                        ControladorListaValores::GrabarListaValores();   
                    }
              }
      
      ?>
    
           
       
        <form name="WebPage_ListaValores" action="WebPage_ListaValores.php" 
              class="formoid-solid-green" 
              style="background-color:#FFFFFF;
                     font-size:12px;
                     font-family:'Roboto', Arial,Helvetica,sans-serif;
                     color:#34495E;
                     max-width:480px;
                     min-width:150px" 
              method="post">   
              
         <?php if($tipo == 'MARCAS'){ ?>
            <div class="title"><h2><i class="fa fa-registered"></i>&nbsp;<?php echo !empty($tipo)?$tipo:'';?></h2></div>          
         <?php } ?>     
         <?php if($tipo == 'LINEAS'){ ?>
            <div class="title"><h2><i class="fa fa-list"></i>&nbsp;<?php echo !empty($tipo)?$tipo:'';?></h2></div>          
         <?php } ?>        
          <input id="itCampoClave" name="itCampoClave" type="hidden" value="<?php echo !empty($id)?$id:0;?>"/>
          <input id="itTipo" name="itTipo" type="hidden" value="<?php echo !empty($tipo)?$tipo:'';?>"/>
        

    <div class="element-input">
         <label class="title">
                <span class="required">
                      Nombre *
                </span>
         </label>
     <div class="item-cont">
          <input class="large" 
                 type="text" 
                 id="itNombre"
                 name="itNombre"
                 required="required" 
                 placeholder="Nombre"             
                 maxLength="50" 
                 value="<?php echo !empty($nombre)?$nombre:'';?>"/>       
        <span class="icon-place"></span>
     </div>
    </div>
    <div class="element-textarea">
        <label class="title">
               Descripcion
        </label>
        <div class="item-cont">
            <textarea class="medium"            
                      id="itDescripcion" 
                      name="itDescripcion" 
                      maxLength="255"
                      cols="20" 
                      placeholder="Descripcion"
                      rows="4"><?php echo !empty($descripcion)?$descripcion:'';?>                    
            </textarea>
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
                     onmousedown="return VerificarListaValores();"/>
         </div>
      </form>
           

</body>

</html>
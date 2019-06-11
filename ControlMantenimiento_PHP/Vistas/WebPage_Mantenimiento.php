<!DOCTYPE html>
<html>
<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title>Mantenimiento</title>	        
        <script src="js/ValidacionesPaginas.js" type="text/javascript"></script>
</head>
<body>
    
         <?php
          require_once '../Vistas/WebPage_Maestro.php'; 
          require_once '../Modelos/Mantenimiento.php';
          require_once '../Controladores/ControladorMantenimiento.php';
          require_once '../Controladores/Funciones.php';   
          
          $_SESSION['Listado']=NULL;
          $mensajeError= null;
          $id=0;
          $codigo=NULL;
          $documento=NULL;
          $fecha=NULL;         
          $observaciones=NULL;
          $arlistado = array();
          $arequipos = array();
          $aroperarios = array();                          
          $controlador  = Funciones::CrearControlador();       
                                           
          if ( !empty($_GET['id']))
          {
	      $id = base64_decode(filter_input(INPUT_GET, 'id'), FILTER_SANITIZE_NUMBER_INT);
              if(empty($_SESSION['ListadoEquipos']))               
              {
                $arlistado = $controlador->ControlProgramacion("PROGRAMACION");
                
                for($i=0; $i<(sizeof ($arlistado)); $i++)
                {              
                   if ($arlistado[$i] == "EQUIPOS")
                   {                   
                       array_push($arequipos, $arlistado[$i+1], $arlistado[$i+2]);
                       $i++;$i++;
                   }           
                   elseif ($arlistado[$i] == "OPERARIOS")
                   {                   
                       array_push($aroperarios, $arlistado[$i+1], $arlistado[$i+2]);
                       $i++;$i++;                       
                   }  
                } 
                if ($aroperarios == NULL) 
                {
                  $mensaje= Mensaje13;   
                  header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");
                }
                elseif ($arequipos == NULL)
                {
                  $mensaje= Mensaje14;
                  header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");
                }
                else
                {   
                  $_SESSION['ListadoEquipos'] = $arequipos;
                  $_SESSION['ListadoOperarios'] = $aroperarios;      
                }
              }
              $mantenimiento = $controlador->ObtenerMantenimiento($id, "TBL_MANTENIMIENTO");
              
             if ($mantenimiento != NULL)
             {
                 $id = $mantenimiento->getMantenimiento_Id();
                 $codigo = $mantenimiento->getEquipo_Id();                 
                 $documento = $mantenimiento->getOperario_Id();                 
                 $fecha = $mantenimiento->getFecha();                 
                 $observaciones =$mantenimiento->getObservaciones();                         
             }
          } 
          else 
          {
            if(empty($_SESSION['ListadoEquipos']))               
            { 
              $arlistado = $controlador->ControlProgramacion("PROGRAMAR");                 
              for($i=0; $i<(sizeof ($arlistado)); $i++)
              {
                if ($arlistado[$i] == "EQUIPOS")
                {                   
                    array_push($arequipos, $arlistado[$i+1], $arlistado[$i+2]);
                }           
                elseif ($arlistado[$i] == "OPERARIOS")
                {                   
                    array_push($aroperarios, $arlistado[$i+1], $arlistado[$i+2]);
                }           
              }
                $_SESSION['ListadoEquipos'] = $arequipos;
                $_SESSION['ListadoOperarios'] = $aroperarios;                    
            } 
          }
          
          if ( !empty($_POST)) {            
            $id=filter_input(INPUT_POST, 'itCampoClave', FILTER_SANITIZE_NUMBER_INT);  
            $codigo =filter_input(INPUT_POST, 'slEquipos', FILTER_SANITIZE_NUMBER_INT);
            $documento=filter_input(INPUT_POST, 'slOperarios', FILTER_SANITIZE_NUMBER_INT);           
            $fecha= filter_input(INPUT_POST, 'itFecha', FILTER_SANITIZE_STRING);          
            $observaciones = filter_input(INPUT_POST,'itObservaciones',FILTER_SANITIZE_STRING);
          
          $grabar=true;
          if ($fecha < date("Y-m-d")) // Ojo si desea conectar con Oracle Cambiar a D/M/Y
          {
              $grabar = false;
              $mensajeError= Mensaje27;
          }
          
          
          if ($grabar)
          {              
              unset($_SESSION['ListadoEquipos']);
              unset($_SESSION['ListadoOperarios']);                 
              ControladorMantenimiento::GrabarMantenimiento();
           }   

        }
        
     ?>
    

       
        <form name="WebPage_Mantenimiento" action="WebPage_Mantenimiento.php" 
              class="formoid-solid-green" 
              style="background-color:#FFFFFF;
                     font-size:12px;
                     font-family:'Roboto', Arial,Helvetica,sans-serif;
                     color:#34495E;
                     max-width:480px;
                     min-width:150px" 
              method="post">
              
          <div class="title"><h2><i class="fa fa-calendar"></i>&nbsp;Mantenimiento</h2></div>
	  <input id="itCampoClave" name="itCampoClave" type="hidden" value="<?php echo !empty($id)?$id:0;?>"/>
         
	<div class="element-select">
             <label class="title">
                    <span class="required">Equipo *</span>
             </label>
            <div class="item-cont">
                <div class="medium"><span>
                        <select id="slEquipos" 
                                name="slEquipos" 
                                required="required">
                                <?php for($i=0; $i<(sizeof ($_SESSION['ListadoEquipos'])); $i++){ ?>
                                <option value="<?php echo $_SESSION['ListadoEquipos'][$i];  ?>"
                                        <?php if (($id!=NULL) && ($_SESSION['ListadoEquipos'][$i] == $codigo)): ?>
                                                   selected="selected"
                                        <?php endif; ?>
                                        ><?php $i++; echo $_SESSION['ListadoEquipos'][$i]; } ?>
                                </option>
                        </select>
                        <i></i><span class="icon-place"></span></span>
                </div>
            </div>
        </div>
	<div class="element-select">
             <label class="title">
                    <span class="required">Operario *</span>
             </label>
            <div class="item-cont">
                <div class="medium"><span>
                        <select id="slOperarios" 
                                name="slOperarios" 
                                required="required">
                                <?php for($i=0; $i<(sizeof ($_SESSION['ListadoOperarios'])); $i++){ ?>
                                <option value="<?php echo $_SESSION['ListadoOperarios'][$i];  ?>"
                                        <?php if (($id!=NULL) && ($_SESSION['ListadoOperarios'][$i] == $documento)): ?>
                                                  selected="selected"
                                        <?php endif; ?>
                                        ><?php $i++; echo $_SESSION['ListadoOperarios'][$i]; } ?>
                                </option>
                        </select>
                        <i></i><span class="icon-place"></span></span>
                </div>
             </div>
        </div>
	<div class="element-date">
            <label class="title">
                   <span class="required">Fecha *</span>
            </label>
            <div class="item-cont">
                <input class="medium"                         
                       type="date" 
                       id="itFecha" 
                       name="itFecha" 
                       data-format="yyyy-mm-dd"
                       required="required"                       
                       value="<?php echo !empty($fecha)?$fecha: date("Y-m-d");?>"/>
            
                <span class="icon-place"></span>
            </div>
        </div>
	<div class="element-textarea">
             <label class="title">Observaciones</label>
             <div class="item-cont">             
                  <textarea id="itObservaciones"                                      
                            name="itObservaciones" 
                            placeholder="Observacion" 
                            maxlength="255"
                            cols="30"
                            rows="4"><?php echo !empty($observaciones)?$observaciones:'';?>
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
                     onmousedown="return VerificarMantenimiento();"/>             
         </div>
       </form>
           
   

</body>

</html>



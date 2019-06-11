<!DOCTYPE html>
<html>
    <head>     
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <title>Equipos</title>             
          <link href="../resources/css/bootstrap1.min.css" rel="stylesheet" type="text/css"/>
    </head>    
    <body>        
    
    <?php
          require_once '../Vistas/WebPage_Maestro.php';
          require_once '../Modelos/Equipo.php';
          require_once '../Controladores/Funciones.php'; 
          require_once '../Controladores/ControladorEquipo.php';                   
                  
           $_SESSION['Listado']=NULL;
           $mensajeError= NULL;
           $id = 0;
           $marca=NULL;  
           $linea=NULL;
           $nombre_equipo=NULL;
           $lubricacion=NULL;
           $serie=NULL;           
           $arlistado = array();
           $armarcas = array();
           $arlineas = array();
           $controlador = Funciones::CrearControlador(); 
           if(empty($_SESSION['ListadoMarcas']))               
           {
             $arlistado = $controlador->ControlProgramacion("CONTROLEQUIPOS");             
                for($j=0; $j<(sizeof ($arlistado)); $j++)
                {           
                    if ($arlistado[$j] == "MARCAS")
                    {                           
                        array_push($armarcas, $arlistado[$j+1], $arlistado[$j+2]);
                        $j++;$j++;
                    }           
                    elseif ($arlistado[$j] == "LINEAS")
                    {                   
                        array_push($arlineas, $arlistado[$j+1], $arlistado[$j+2]);
                        $j++;$j++;
                    }        
                }  
                if ($armarcas == NULL) 
                {
                  $mensaje= Mensaje11;   
                  header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");
                }
                elseif ($arlineas == NULL)
                {
                  $mensaje= Mensaje12;
                  header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");
                }
                else
                {   
                    $_SESSION['ListadoMarcas']=  $armarcas;//Los almacenamose en sesion para evitar viajes innecesarios a BD                               
                    $_SESSION['ListadoLineas']=  $arlineas;  
                }
           }
          
            if ( !empty($_GET['id']))
            {
	     
             $id = base64_decode(filter_input(INPUT_GET, 'id'), FILTER_SANITIZE_NUMBER_INT);          
             
             $equipo = $controlador->ObtenerEquipo($id,"EQUIPOS");

             if ($equipo != NULL)
             {
		 $nombre_equipo = $equipo->getNombre_equipo();
                 $marca = $equipo->getMarca();              
                 $serie =$equipo->getSerie();
                 $linea =$equipo->getLinea();
                 $lubricacion =$equipo->getLubricacion();
             }
     	}
        
            
           if ( !empty($_POST)) {
                $id =trim(filter_input(INPUT_POST, 'itCampoClave', FILTER_SANITIZE_NUMBER_INT));
                $nombre_equipo = trim(filter_input(INPUT_POST, 'itNombre', FILTER_SANITIZE_STRING));
                $serie =trim(strtoupper(filter_input(INPUT_POST, 'itSerie', FILTER_SANITIZE_STRING)));                    
                $marca=filter_input(INPUT_POST,'slMarcas');
                $linea=filter_input(INPUT_POST,'slLineas');                
                $lubricacion =(filter_input(INPUT_POST,'chLubricacion')?1:0);

                $grabar = true;
                if (Funciones::Validar_CampoRequerido($nombre_equipo)){
		    $grabar = false;
		    $mensajeError ='Nombre'.' '.MensajeCampoRequerido;		    
		}
                if (Funciones::Validar_CampoRequerido($serie))
                {
                    $grabar = false;
                    $mensajeError ='Serie'.' '.MensajeCampoRequerido;	    
                }
          
                if ($grabar)
                {                  
                  unset($_SESSION['ListadoMarcas']);
                  unset($_SESSION['ListadoLineas']);
                  ControladorEquipo::GrabarEquipo(); 
                }
           }      
        ?>
    

       
        <form name="WebPage_Equipos" 
              action="WebPage_Equipos.php"              
              class="formoid-solid-green" 
              style="background-color:#FFFFFF;
                     font-size:12px;
                     font-family:'Roboto',Arial,Helvetica,sans-serif;
                     color:#34495E;
                     max-width:480px;
                     min-width:150px" 
              method="post">
            
            <div class="title"><h2><i class="fa fa-wrench"></i>&nbsp;Equipos</h2></div>
            <input id="itCampoClave" name="itCampoClave" type="hidden" value="<?php echo !empty($id)?$id:0;?>"/>
                                
            
	    <div class="element-input">
                 <label class="title">
                        <span class="required">Nombre *</span>
                 </label>
                <div class="item-cont">
                     <input class="medium" 
                            type="text"
                            id="itNombre" 
                            name="itNombre"  
                            required="required"                            
                            maxLength="50"                        
                            placeholder="Nombre Equipo"
                            value="<?php echo !empty($nombre_equipo)?$nombre_equipo:'';?>"/> 
                   
                    <span class="icon-place"></span>
                </div>
            </div>
            

          <div class="element-select">
             <label class="title"><span class="required">Marca *</span></label>
             <div class="item-cont">
                  <div class="medium"><span>
                          <select id="slMarcas" 
                                  name="slMarcas"
                                  required="required">
                                  <?php for($i=0; $i<(sizeof ($_SESSION['ListadoMarcas'])); $i++){ ?>
                                  <option value="<?php echo $_SESSION['ListadoMarcas'][$i];  ?>"
                                          <?php if (($id!=0) &&  ($_SESSION['ListadoMarcas'][$i] == $marca)): ?>
                                                    selected="selected"
                                          <?php endif; ?>
                                          ><?php $i++; echo $_SESSION['ListadoMarcas'][$i]; } ?>
                                  </option>                             
                          </select>
                          <i></i><span class="icon-place"></span></span>
                  </div>
             </div>
        </div>
                
           <div class="element-input">
             <label class="title">
                    <span class="required">Serie *</span>
              </label>
             <div class="item-cont">
                  <input class="medium"
                         type="text"
                         id="itSerie" 
                         name="itSerie" 
                         maxLength="20"
                         required="required" 
                         placeholder="Serie"
                         value="<?php echo !empty($serie)?$serie:'';?>"/>
                   
                <span class="icon-place"></span>
             </div>
           </div>
	
          <div class="element-select">
             <label class="title"><span class="required">Linea *</span></label>
             <div class="item-cont">
                  <div class="medium"><span>
                          <select id="slLineas" 
                                  name="slLineas"
                                  required="required">
                                  <?php for($i=0; $i<(sizeof ($_SESSION['ListadoLineas'])); $i++){ ?>
                                  <option value="<?php echo $_SESSION['ListadoLineas'][$i];  ?>"
                                          <?php if (($id!=0) &&  ($_SESSION['ListadoLineas'][$i] == $linea)): ?>
                                                    selected="selected"
                                          <?php endif; ?>
                                          ><?php $i++; echo $_SESSION['ListadoLineas'][$i]; } ?>
                                  </option>                             
                          </select>
                          <i></i><span class="icon-place"></span></span>
                  </div>
             </div>
        </div>
               

	
	<div class="element-checkbox">
             <label class="title">Lubricacion</label>	
           <div class="column column1">
             <input type="checkbox" 
                    id="chLubricacion" 
                    name="chLubricacion"
                    <?php if ($lubricacion == 1): ?> checked="checked"<?php endif; ?>/>
           
             <span></span>
           </div>
             <span class="clearfix"></span>
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
                     onmousedown="return VerificarEquipos();"/>             
         </div>  
      </form>
           
    

</body>

</html>
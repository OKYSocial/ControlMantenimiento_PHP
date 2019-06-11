<!DOCTYPE html>
<html lang="es">
    <head> 
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
          <title>Listado Marcas</title>
          <link href="../resources/css/bootstrap1.min.css" rel="stylesheet" type="text/css"/>
    </head>


    <?php
    require_once '../Vistas/WebPage_Maestro.php';
    require_once '../Controladores/Funciones.php';

    $Tabla = 'MARCAS';
    $Eliminar = 'TBL_LISTAVALORES';
    $Pagina = 'WebPage_ListaValores.php';
    $DatoBuscar = NULL;
    $vector_resultado = array();

    if (!empty($_GET['Buscar']))
    {
        $DatoBuscar= strtoupper(filter_input(INPUT_GET, 'Buscar', FILTER_SANITIZE_STRING));        
    }

    $controlador = Funciones::CrearControlador();
    if (!empty($_POST)) {
        $Tabla = filter_input(INPUT_POST, 'itTabla');
        $Tipo = base64_encode($Tabla);
        if (filter_input(INPUT_POST, 'itBusqueda') != '') {
            $DatoBuscar = filter_input(INPUT_POST, 'itBusqueda');
            header("Location: ../Vistas/WebPage_ListadoMarcas.php?Buscar=$DatoBuscar");
        } else {
            if ($_SESSION['PerfilAcceso'] == 1) {
                unset($_SESSION['Listado']);
                header("Location: ../Vistas/$Pagina?tipo=$Tipo");
            }
        }
    }
    ?>   

    <body>     

        <form name="WebPage_ListadoMarcas" action="WebPage_ListadoMarcas.php" method="post">
            <input id="itTabla" name="itTabla" type="hidden" value="<?php echo!empty($Tabla) ? $Tabla : ''; ?>"/>
            <div class="container">
                <br/>

                <table width="55%" align="center" border="1" cellspacing="0" cellpadding="6">

                    <tr>
                        <td align="center" width="55%"  bgcolor="teal"><label class="titulos">Marcas&nbsp;<i class="fa fa-registered"></i></label></td>             
                    </tr>

                    <div align="center">
                        <input type="submit" name="btnNuevo" value="Nuevo"/>            
                        <input type="submit" name="btnBuscar" value="Buscar" />   
                        <input class="small"
                               type="text"
                               id="itBusqueda"
                               name="itBusqueda"                         
                               maxLength="50"                         
                               placeholder="Nombre Marca"
                               value="">
                        </input>                 
                    </div>
                    <table/>

                    <table width="55%" rules="all" border="1" align="center">
                        <tr>                         
                            <th>Nombre</th>
                            <th>Descripcion</th>
                            <th>Acciones</th>
                        </tr>

                        <?php        
                                if ($_SESSION['Listado'] == NULL)
                                {
                                    $vector_resultado = $controlador->cargarListas($Tabla, NULL);
                                    $_SESSION['Listado'] = $vector_resultado;
                                    for ($i = 0; $i < (sizeof($vector_resultado)); $i++)
                                    {
                                      echo
                                            '<tr> 	      				
                                             <td width=100>' . $vector_resultado[$i][1] . '</td>    
                                             <td width=100>' . $vector_resultado[$i][2] . '</td> 
                                             <td width=80>
                                                <a href="../Vistas/' . $Pagina . '?id=' . base64_encode($vector_resultado[$i][0]) . '" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>                                                                         
                                                &nbsp &nbsp    
                                                <a href="../Vistas/WebPage_Eliminar.php?id=' . base64_encode($vector_resultado[$i][0]) . '&tabla=' . base64_encode($Eliminar) . '" title="Eliminar" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                             </td>	                                                                                                         
                                            </tr>';
                                    }
                                } 
                                else
                                {            
                                    if ($DatoBuscar != NULL)
                                    {                
                                        $cantidad = sizeof($_SESSION['Listado']);
                                        for($i=0; $i<($cantidad); $i++)
                                        {
                                            if ($_SESSION['Listado'][$i][1]== $DatoBuscar)
                                            {   
                                                echo
                                                    '<tr> 	      				
                                                    <td width=100>' . $_SESSION['Listado'][$i][1] . '</td>    
                                                    <td width=100>' . $_SESSION['Listado'][$i][2] . '</td> 
                                                    <td width=80>
                                                    <a href="../Vistas/' . $Pagina . '?id=' . base64_encode($_SESSION['Listado'][$i][0]) . '" title="Editar datos" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>                                                                         
                                                    &nbsp &nbsp    
                                                    <a href="../Vistas/WebPage_Eliminar.php?id=' . base64_encode($_SESSION['Listado'][$i][0]) . '&tabla=' . base64_encode($Eliminar) . '" title="Eliminar" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>
                                                    </td>	                                                                                                         
                                                    </tr>';                        
                                                break;
                                            }
                                        }
                                    }
                                }      
                        ?>
                    </table>

            </div>

        </form>    

    </body>
</html>


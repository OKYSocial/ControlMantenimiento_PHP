<html>
<head>
      <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
      <title>Respuesta</title>
</head>

<body>
    <?php 
          require_once '../Vistas/WebPage_Maestro.php';
          $respuesta = filter_input(INPUT_GET,'respuesta');
    ?> 
 
            <form name="WebPage_Respuesta" 
                  action="WebPage_Respuesta.php"
                  class="formoid-solid-green" 
                  style="background-color:#FFFFFF;
                         font-size:12px;
                         font-family:'Roboto', Arial,Helvetica,sans-serif;
                         color:#34495E;
                         max-width:480px;
                         min-width:150px">                  
                
                <div class="title">                                       
                    <?php if($respuesta == "R"){ ?>  
                    <h2><img src="../resources/Imagenes/Informacion.jpg"/></h2>      
                    <?php } ?>     
                    <?php if($respuesta == "E"){ ?>
                    <h2><img src="../resources/Imagenes/Error.jpg"></h2>
                    <?php } ?>  
                </div>
                
                <br></br>
                
                <div>
                    <input class="large" 
                           type="text" 
                           id="itMensajeError" 
                           name="itMensajeError" 
                           readonly="true"
                           style=" border-style: none; color: red; background: white"
                           value="<?php echo filter_input(INPUT_GET,'mensaje'); ?>"/>         
                </div>
                <br></br>
                <div align="center">
                    <a href="WebPage_Menu.php" style="font-size:20px"><i class="fa fa-home"></i>&nbsp;Regresar Menu</a>
                </div>    
                <br></br>
            </form>     
</body>
</html>

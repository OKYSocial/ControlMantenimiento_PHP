<!DOCTYPE html>
<html>
    <head>    
          <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">        
          <title>SIMI</title>
    </head>
  
    <body>
          <form name="WebPage_Menu" method="post">  
                <?php                       
                     require_once '../Vistas/WebPage_MaestroMenu.php';  
                     require_once '../Vistas/SideBar.php';                     
                     $_SESSION['Listado']=NULL;              
                ?>            
                
                <div align="center"><img src="../resources/Imagenes/SIMI-LOGO.jpg"></div>
          </form>  
    </body>
</html>

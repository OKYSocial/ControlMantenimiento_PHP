  <?php             
        session_start();
        if(!empty($_SESSION['PerfilAcceso']))
        {
            $perfil = $_SESSION['PerfilAcceso'];
            $MostrarNombre =  $_SESSION['NombreUsuario'];
        }             
  ?>        
<div class="span3" id="sidebar"> 
    <div align="left"><label class="titulos"><?php echo 'Bienvenido:'." ".$MostrarNombre;?></label></div>            
    
    <ul class="nav nav-list bs-docs-sidenav nav-collapse collapse">
                                 
         <li><a href="./WebPage_ListadoOperarios.php"><i class="fa fa-group "></i> Operarios</a></li>                 
	 <?php if($perfil == 1){ ?>     
         <li><a href="./WebPage_ListadoEquipos.php"><i class="fa fa-wrench "></i> Equipos</a></li>
	 <li><a href="./WebPage_ListadoMarcas.php"><i class="fa fa-registered "></i> Marcas</a></li>
         <li><a href="./WebPage_ListadoLineas.php"><i class="fa fa-th-list "></i> Lineas</a></li>
         <li><a href="./WebPage_ListadoMantenimientos.php"><i class="fa fa-calendar "></i> Mantenimiento</a></li>
	 <?php } ?>            
         <li><a href="./WebPage_CambioClave.php"><i class="fa fa-key "></i> Modificar Clave</a></li>
	 <li><a href="../Controladores/Ayuda.php"><i class="fa fa-question "></i> Ayuda</a></li>
         
    </ul>        
</div>            
		

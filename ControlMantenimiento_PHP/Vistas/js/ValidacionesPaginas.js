function VerificarAcceso() {  
  document.getElementById("itDocumento").value = document.getElementById("itDocumento").value.replace(/^\s+|\s+$/g,"");
  if (document.getElementById("itDocumento").value === ""){
      document.getElementById("itMensajeError").value = "Documento es requerido";      
      document.getElementById("itDocumento").focus();
      return false;
  }
   if (document.getElementById("itDocumento").value.length < 6) 
   { 	
      document.getElementById("itMensajeError").value = 'Documento debe ser mayor de 6 digitos';	
      document.getElementById("itDocumento").focus();
      return false;
   }
  document.getElementById("isClave").value = document.getElementById("isClave").value.replace(/^\s+|\s+$/g,"");
  if (document.getElementById("isClave").value === ""){
      document.getElementById("itMensajeError").value = "Clave es requerido";	
      document.getElementById("isClave").focus();
      return false;
  }
  if (document.getElementById("isClave").value.length < 6) 
  {
      document.getElementById("isClave").focus();
      return false;
  }  
  
    return true;
}


function VerificarOperarios()
{
  if (document.getElementById.FileFoto.value !== "")  
  { 
    document.getElementById("ihFoto").value = document.getElementById.FileFoto.value;
  }  
  document.getElementById("itDocumento").value = document.getElementById("itDocumento").value.replace(/^\s+|\s+$/g,"");
  if (document.getElementById("itDocumento").value === ""){
      document.getElementById("itMensajeError").value = "Documento es requerido";      
      document.getElementById("itDocumento").focus();
      return false;
  } 
   if (document.getElementById("itDocumento").value.length < 6) 
   { 	
      document.getElementById("itMensajeError").value = 'Documento debe ser mayor de 6 digitos';	
      document.getElementById("itDocumento").focus();
      return false;
   }
   if (document.getElementById("itDocumento").value.substring(0,1)==='0') 
   { 	
       document.getElementById("itMensajeError").value = 'Error, primera cifra no puede ser 0';	
       document.getElementById("itDocumento").focus();             
       return false;
   }
   document.getElementById("itNombres").value = document.getElementById("itNombres").value.replace(/^\s+|\s+$/g,"");
   if (document.getElementById("itNombres").value === "")
   {    
        document.getElementById("itMensajeError").value= 'Nombres es requerido';
        document.getElementById("itNombres").focus();
	return false;
   }
   document.getElementById("itApellidos").value = document.getElementById("itApellidos").value.replace(/^\s+|\s+$/g,"");
   if (document.getElementById("itApellidos").value === "")
   {    
        document.getElementById("itMensajeError").value= 'Apellidos es requerido';	
        document.getElementById("itApellidos").focus();
	return false;
   }
  document.getElementById("itTelefono").value = document.getElementById("itTelefono").value.replace(/^\s+|\s+$/g,"");
  if (document.getElementById("itTelefono").value === "")
   {    
        document.getElementById("itMensajeError").value= 'Telefono es requerido';	
        document.getElementById("itTelefono").focus();
	return false;
   }
   if ((document.getElementById("itTelefono").value.length !== 7)  && (document.getElementById("itTelefono").value.length !== 10))
   { // Si es un teléfono celular debe ser de 10 dígitos	
       document.getElementById("itMensajeError").value= 'Por favor debe ingresar entre 7 y 10 digitos para el telefono';
       document.getElementById("itTelefono").focus();	 
       return false;
   }
   if (document.getElementById("itTelefono").value.substring(0,1)==='0') 
   { 	
       document.getElementById("itMensajeError").value = 'Error, primera cifra no puede ser 0';	
       document.getElementById("itTelefono").focus();             
       return false;
   }
   document.getElementById("itCorreo").value = document.getElementById("itCorreo").value.replace(/^\s+|\s+$/g,"");
   if (document.getElementById("itCorreo").value.length > 0)
   {
    if( !(/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/.test(document.getElementById("itCorreo").value)) )                        
     {
       document.getElementById("itMensajeError").value= 'Formato de correo errado';
       document.getElementById("itCorreo").focus();   
       return false;    
     }
   }
    document.getElementById("isClave").value = document.getElementById("isClave").value.replace(/^\s+|\s+$/g,"");  
   if (document.getElementById("isClave").value === ""){
      document.getElementById("itMensajeError").value = "Clave es requerido";
      document.getElementById("isClave").focus();
      return false;
   } 
   if ( document.getElementById("isClave").value.length < 6)
   {    
        document.getElementById("itMensajeError").value= 'Error, por favor ingrese una clave que contenga al menos 6 digitos';	
        document.getElementById("isClave").focus();
	return false;
   }       

   return true;
}

function VerificarListaValores()
{ 
   document.getElementById("itNombre").value = document.getElementById("itNombre").value.replace(/^\s+|\s+$/g,"");
   if (document.getElementById("itNombre").value === "")
   {    
       document.getElementById("itMensajeError").value= 'Nombre es requerido';	
       document.getElementById("itNombre").focus();
       return false;
   }
   return true;
}	

function VerificarEquipos() {  
  document.getElementById("itNombre").value = document.getElementById("itNombre").value.replace(/^\s+|\s+$/g,"");
  if (document.getElementById("itNombre").value === ""){
      document.getElementById("itMensajeError").value = "Documento es requerido";      
      document.getElementById("itNombre").focus();
      return false;
  }
  document.getElementById("itSerie").value = document.getElementById("itSerie").value.replace(/^\s+|\s+$/g,"");
  if (document.getElementById("itSerie").value === ""){
      document.getElementById("itMensajeError").value = "Serie es requerido";      
      document.getElementById("itSerie").focus();
      return false;
  }    
    return true;
}

function VerificarCambioClave()
{ 
  document.getElementById("isClave").value = document.getElementById("isClave").value.replace(/^\s+|\s+$/g,"");  
  if (document.getElementById("isClave").value === ""){
      document.getElementById("itMensajeError").value = "Clave es requerido";	
      document.getElementById("isClave").focus();
      return false;
  }
  if (document.getElementById("isClave").value.length < 6) 
  {
      document.getElementById("itMensajeError").value = "Clave debe ser mayor de 6 digitos";
      document.getElementById("isClave").focus();
      return false;
  }
  document.getElementById("isClaveNueva").value = document.getElementById("isClaveNueva").value.replace(/^\s+|\s+$/g,"");  
   if (document.getElementById("isClaveNueva").value === ""){
      document.getElementById("itMensajeError").value = "Clave Nueva es requerido";
      document.getElementById("isClaveNueva").focus();
      return false;
  }
  if (document.getElementById("isClaveNueva").value.length < 6) 
  {
      document.getElementById("itMensajeError").value = "Clave debe ser mayor de 6 digitos";
      document.getElementById("isClaveNueva").focus();
      return false;
  }
   if (document.getElementById("isClaveNueva").value === document.getElementById("isClave").value)
   {    
      document.getElementById("itMensajeError").value = "La clave debe ser diferente";
      document.getElementById("isClaveNueva").focus();
      return false;
   }
   document.getElementById("isConfirmar").value = document.getElementById("isConfirmar").value.replace(/^\s+|\s+$/g,"");  
   if (document.getElementById("isConfirmar").value === ""){
      document.getElementById("itMensajeError").value = "Debe confirmar la clave";
      document.getElementById("isConfirmar").focus();
      return false;
  }
   
   if (document.getElementById("isConfirmar").value !== document.getElementById("isClaveNueva").value)
   {    
      document.getElementById("itMensajeError").value = "La clave es diferente";
      document.getElementById("isConfirmar").focus();
      return false;
   }
   return true;
}	

function VerificarBusquedas()
{ 
   document.getElementById("itBusqueda").value = document.getElementById("itBusqueda").value.replace(/^\s+|\s+$/g,"");
   if (document.getElementById("itBusqueda").value === "")
   {    
      document.getElementById("itMensajeError").value = "Por favor seleccione o ingrese el dato a buscar";
      document.getElementById("itBusqueda").focus();
      return false;
   }   
   if (document.getElementById("itBusqueda").value.substring(0,1)==='0') 
   { 	
       document.getElementById("itMensajeError").value = 'Error, primera cifra no puede ser 0';	
       document.getElementById("itBusqueda").focus();             
       return false;
   }
   return true;
}

function ConfirmarBorrado()
{
 if (confirm("¿ Esta seguro que desea eliminar este registro ?")) 
 {
   return true;
 } 
 return false; 
}

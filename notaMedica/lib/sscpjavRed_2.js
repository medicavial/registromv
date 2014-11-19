
function objetoAjax(){
        var xmlhttp=false;
        try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
                try {
                   xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                        xmlhttp = false;
                }
        }

        if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                xmlhttp = new XMLHttpRequest();
        }
        return xmlhttp;
}

function guardaAccRed(fol,Not)
{
    divResultado = document.getElementById('resAgregaAccidentesAnterioresRed');
    
   for(i=0; i <document.accRed.Accidente.length; i++){
            if(document.accRed.Accidente[i].checked){
              var Accidente = document.accRed.Accidente[i].value;
                 }
                 }
                 
                
               
                 var Indice2 = document.getElementById('Lugar').value;
                 var Indice3 = document.getElementById('ObsAccidente').value;
  
    if(Accidente==""|| Indice2=="" || Indice3=="")
     {
           alert("No ha seleccionado todas las opciones");
     }
     
     else
         
    {
                 
                  Lugar=document.getElementById('Lugar').value;
                  ObsAccidente=document.getElementById('ObsAccidente').value;
                  
  
    
    
    
    //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaAccRed.php",true);
            
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarCamposAccRed();
                         }
               }
          
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Accidente="+Accidente+"&Lugar="+Lugar+"&ObsAccidente="+ObsAccidente+"&fol="+fol+"&Not="+Not)
    }
    }
  // esta funcion limpia los camposb
function LimpiarCamposAccRed()
{
           
            document.getElementById('Lugar').value="";
            document.getElementById('ObsAccidente').value="";
          
}

function eliminaAccAnt(cla,fol,Not){
	//donde se mostrará el resultado de la eliminacion
	divResultado = document.getElementById('resAgregaAccidentesAnterioresRed');

	//usaremos un cuadro de confirmacion
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		//instanciamos el objetoAjax
		ajax=objetoAjax();
		//uso del medotod GET
		//indicamos el archivo que realizará el proceso de eliminación
		//junto con un valor que representa el id del empleado
		ajax.open("GET", "eliminaAccAnt.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				//mostrar resultados en esta capa
				divResultado.innerHTML = ajax.responseText
			}
		}
		//como hacemos uso del metodo GET
		//colocamos null
		ajax.send(null)
	}
}


     
     
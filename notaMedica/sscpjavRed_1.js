
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

function guardaEstRealizadosRed(fol,Not)
{
    
    
   var Indice = document.getElementById("Estudio");
   var Indice2 = document.getElementById("Descripcion");
   var Indice3 = document.getElementById("Resultado");
   var Indice4 = document.getElementById("Observaciones");
     if(Indice.value <1 || Indice2.value <1 || Indice3.value <1)
     {
           alert("No ha llenado todas las opciones");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('resAgregaEstudioRed');
            //valores de los inputs
            Estudio=document.getElementById('Estudio').value;
            Descripcion=document.getElementById('Descripcion').value;
            Resultado=document.getElementById('Resultado').value;
            Observaciones=document.getElementById('Observaciones').value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaEstRealizadosRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarEstRealizadosRed();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Estudio="+Estudio+"&Descripcion="+Descripcion+"&Resultado="+Resultado+"&Observaciones="+Observaciones+"&fol="+fol+"&Not="+Not)
  }
  
function guardaEstRealizadosRedSub(fol,Sub)
  {
    
    
   var Indice = document.getElementById("Estudio");
   var Indice2 = document.getElementById("Descripcion");
   var Indice3 = document.getElementById("Resultado");
   var Indice4 = document.getElementById("Observaciones");
     if(Indice.value <1 || Indice2.value <1 || Indice3.value <1 || Indice4.value <1)
     {
           alert("No ha llenado todas las opciones");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('resAgregaEstudioRed');
            //valores de los inputs
            Estudio=document.getElementById('Estudio').value;
            Descripcion=document.getElementById('Descripcion').value;
            Resultado=document.getElementById('Resultado').value;
            Observaciones=document.getElementById('Observaciones').value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaEstRealizadosRedSub.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarEstRealizadosRed();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Estudio="+Estudio+"&Descripcion="+Descripcion+"&Resultado="+Resultado+"&Observaciones="+Observaciones+"&fol="+fol+"&Sub="+Sub)
  }
  // esta funcion limpia los camposb
function LimpiarEstRealizadosRed()
{
            document.getElementById('Estudio').value=" ";
            document.getElementById('Descripcion').value=" ";
            document.getElementById('Resultado').value=" ";
            document.getElementById('Observaciones').value="";
}

function eliminarEstRealizadoRed(cla,fol,Not){
	//donde se mostrará el resultado de la eliminacion
	divResultado = document.getElementById('resAgregaEstudioRed');

	//usaremos un cuadro de confirmacion
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		//instanciamos el objetoAjax
		ajax=objetoAjax();
		//uso del medotod GET
		//indicamos el archivo que realizará el proceso de eliminación
		//junto con un valor que representa el id del empleado
		ajax.open("GET", "eliminaEstRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
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

function eliminarEstRealizadoRedSub(cla,fol,Sub){
  //donde se mostrará el resultado de la eliminacion
  divResultado = document.getElementById('resAgregaEstudioRed');

  //usaremos un cuadro de confirmacion
  var eliminar = confirm("De verdad desea eliminar este dato?")
  if ( eliminar ) {
    //instanciamos el objetoAjax
    ajax=objetoAjax();
    //uso del medotod GET
    //indicamos el archivo que realizará el proceso de eliminación
    //junto con un valor que representa el id del empleado
    ajax.open("GET", "eliminaEstRedSub.php?cla="+cla+"&fol="+fol+"&Sub="+Sub);
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



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

function guardaHeredoRed(fol,Not)
{
    
    
   var Indice = document.getElementById("Enfermedad");
   var Indice2 = document.getElementById("Familiar");
   var Indice3 = document.getElementById("Estatus");
     if(Indice.value <1 || Indice2.value <1 || Indice3.value <1)
     {
           alert("No ha seleccionado todas las opciones");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('resAgregaAntecedenteRed');
            //valores de los inputs
            IdEnfermedad=document.getElementById('Enfermedad').value;
            IdFamiliar=document.getElementById('Familiar').value;
            IdEstatus=document.getElementById('Estatus').value;
            ObsHeredo=document.getElementById('ObsHeredo').value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHeredoRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarCamposHeredoRed();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdEnfermedad="+IdEnfermedad+"&IdFamiliar="+IdFamiliar+"&IdEstatus="+IdEstatus+"&ObsHeredo="+ObsHeredo+"&fol="+fol+"&Not="+Not)
  }
  // esta funcion limpia los camposb
function LimpiarCamposHeredoRed()
{
            document.getElementById('Enfermedad').value=-1;
            document.getElementById('Familiar').value=-1;
            document.getElementById('Estatus').value=-1;
            document.getElementById('ObsHeredo').value="";
}

function eliminarHeredoRed(cla,fol,Not){
	//donde se mostrará el resultado de la eliminacion
	divResultado = document.getElementById('resAgregaAntecedenteRed');

	//usaremos un cuadro de confirmacion
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		//instanciamos el objetoAjax
		ajax=objetoAjax();
		//uso del medotod GET
		//indicamos el archivo que realizará el proceso de eliminación
		//junto con un valor que representa el id del empleado
		ajax.open("GET", "eliminaEnfFamRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
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

function guardaPadCronRed(fol,Not)
{
   var Indice = document.getElementById("PadecimientosCronicos");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('Cronicos');
            //valores de los inputs
            IdCronico=document.getElementById('PadecimientosCronicos').value;
            ObsCronico=document.getElementById('ObsCronico').value;
            GuardaPad=document.getElementById('GuardaPad').value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaPadCronRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarPadCronRed();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdCronico="+IdCronico+"&ObsCronico="+ObsCronico+"&GuardaPad="+GuardaPad+"&fol="+fol+"&Not="+Not)
  }
  // esta funcion limpia los camposb
function LimpiarPadCronRed()
{
  document.getElementById('PadecimientosCronicos').value=-1;
  document.getElementById('ObsCronico').value="";
}

function eliminarPadCronRed(cla,fol,Not){

	divResultado = document.getElementById('Cronicos');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaPadecimientoRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}





function guardaOtrEnfRed(fol,Not)
{
    
   var Indice = document.getElementById("Otras");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('OtrasEnf');
            //valores de los inputs
            IdOtras=document.getElementById('Otras').value;
            ObsOtras=document.getElementById('ObsOtras').value;
            GuardaOtras=document.getElementById('GuardaOtras').value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaOtrasEnfRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarOtrEnfRed();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdOtras="+IdOtras+"&ObsOtras="+ObsOtras+"&GuardaOtras="+GuardaOtras+"&fol="+fol+"&Not="+Not)
  }
  
  function LimpiarOtrEnfRed()
{
  document.getElementById('Otras').value=-1;
  document.getElementById('ObsOtras').value="";
}


function eliminarOtrEnfRed(cla,fol,Not){

	divResultado = document.getElementById('OtrasEnf');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaOtrasEnfRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function guardaAlergiasRed(fol,Not)
{ 
   var Indice = document.getElementById("Alergias");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('resAlergias');
            //valores de los inputs
            IdAlergias=document.getElementById('Alergias').value;
            ObsAlergias=document.getElementById('ObsAlergias').value;
            GuardaAlergias=document.getElementById('GuardaAlergias').value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaAlergiasRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarAlergiasRed();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdAlergias="+IdAlergias+"&ObsAlergias="+ObsAlergias+"&GuardaAlergias="+GuardaAlergias+"&fol="+fol+"&Not="+Not)
  }
  
    function LimpiarAlergiasRed()
{
  document.getElementById('Alergias').value=-1;
  document.getElementById('ObsAlergias').value="";
}

function eliminarAlergiaRed(cla,fol,Not){

	divResultado = document.getElementById('resAlergias');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaAlergiasRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}






function guardaEspRed(fol,Not)
{
    var Esp= document.getElementById("ObsEspalda").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsEspalda").focus();
    }else{
            divResultado = document.getElementById('resPadEspalda');

            ObsEspalda=document.getElementById('ObsEspalda').value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaPadEspaldaRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                                divResultado.innerHTML = ajax.responseText
                                  LimpiarCamposEspalda();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("ObsEspalda="+ObsEspalda+"&fol="+fol+"&Not="+Not)
  }
}

function LimpiarCamposEspalda()
{
   document.getElementById('ObsEspalda').value="";
}

function eliminarEspRed(cla,fol,Not){

	divResultado = document.getElementById('resPadEspalda');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaEspaldaRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}



function guardaQuiroRed(fol,Not)
{
    var Esp= document.getElementById("ObsQuiro").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsQuiro").focus();
    }else{
            divResultado = document.getElementById('resQuiropractico');

            ObsQuiro=document.getElementById('ObsQuiro').value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaQuiropracticoRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                                divResultado.innerHTML = ajax.responseText
                                  LimpiarCamposQuiro();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("ObsQuiro="+ObsQuiro+"&fol="+fol+"&Not="+Not)
  }
}

function LimpiarCamposQuiro()
{
   document.getElementById('ObsQuiro').value="";
}

function eliminarQuiroRed(cla,fol,Not){
	divResultado = document.getElementById('resQuiropractico');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaQuiropracticoRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function guardaPlantillasRed(fol,Not)
{
    var Esp= document.getElementById("ObsPlan").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsPlan").focus();
    }else{
            divResultado = document.getElementById('resPlantillas');

            ObsPlan=document.getElementById('ObsPlan').value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaPlantillasRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                                divResultado.innerHTML = ajax.responseText
                                  LimpiarCamposPlantillas();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("ObsPlan="+ObsPlan+"&fol="+fol+"&Not="+Not)
  }
}

function LimpiarCamposPlantillas()
{
   document.getElementById('ObsPlan').value="";
}

function eliminarPlantillasRed(cla,fol,Not){
	divResultado = document.getElementById('resPlantillas');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaPlantillasRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}


function guardaTratamientosRed(fol,Not)
{
    var Esp= document.getElementById("ObsTratamiento").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsTratamiento").focus();
    }else{
            divResultado = document.getElementById('resTratamiento');

            ObsTrat=document.getElementById('ObsTratamiento').value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaTratamientosRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                                divResultado.innerHTML = ajax.responseText
                                  LimpiarCamposTratamientos();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("ObsTrat="+ObsTrat+"&fol="+fol+"&Not="+Not)
  }
}

function LimpiarCamposTratamientos()
{
   document.getElementById('ObsTratamiento').value="";
}

function eliminarTratamientosRed(cla,fol,Not){
	divResultado = document.getElementById('resTratamiento');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaTratamientosRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function guardaIntQxRed(fol,Not)
{
    var Esp= document.getElementById("ObsOperaciones").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsOperaciones").focus();
    }else{
            divResultado = document.getElementById('resIntQx');

            ObsIntQx=document.getElementById('ObsOperaciones').value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaIntQxRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                                divResultado.innerHTML = ajax.responseText
                                  LimpiarCamposIntQx();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("ObsIntQx="+ObsIntQx+"&fol="+fol+"&Not="+Not)
  }
}

function LimpiarCamposIntQx()
{
   document.getElementById('ObsOperaciones').value="";
}

function eliminarIntQxRed(cla,fol,Not){
	divResultado = document.getElementById('resIntQx');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaIntQxRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function guardaDepRed(fol,Not)
{
    var Esp= document.getElementById("ObsDeporte").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsDeporte").focus();
    }else{
            divResultado = document.getElementById('resDeportes');

            ObsDeporte=document.getElementById('ObsDeporte').value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaDepRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                                divResultado.innerHTML = ajax.responseText
                                  LimpiarCamposDepRed();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("ObsDeporte="+ObsDeporte+"&fol="+fol+"&Not="+Not)
  }
}

function LimpiarCamposDepRed()
{
   document.getElementById('ObsDeporte').value="";
}

function eliminarDepRed(cla,fol,Not){
	divResultado = document.getElementById('resDeportes');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaDepRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}









function guardaAdiRed(fol,Not)
{    
    var Esp= document.getElementById("ObsAdiccion").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsAdiccion").focus();
    }else{
            divResultado = document.getElementById('resAdiccionesRed');

            ObsAdiccion=document.getElementById('ObsAdiccion').value;
            
            
            ajax=objetoAjax();
            ajax.open("POST", "guardaAdiccionRed.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                                divResultado.innerHTML = ajax.responseText
                                  LimpiarCamposAdiRed();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("ObsAdiccion="+ObsAdiccion+"&fol="+fol+"&Not="+Not)
  }
}

function LimpiarCamposAdiRed()
{
   document.getElementById('ObsAdiccion').value="";
}

function eliminarAdiRed(cla,fol,Not){
	divResultado = document.getElementById('resAdiccionesRed');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaAdiccionRed.php?cla="+cla+"&fol="+fol+"&Not="+Not);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}




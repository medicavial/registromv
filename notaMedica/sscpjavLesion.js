
function guardaLesionRed(id, Not)
{

    val = document.getElementById("lesionRed").value;
   var Indice = document.getElementById("lesionRed");
     if(Indice.value <1)
     {
           alert("Seleccionar primero Lesion y despues Zona!");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaLesionRed');
            //valores de los inputs
            lesionRed=document.getElementById("lesionRed").value;
            guardaLesRed="guardaLesRed";
            cuerpo= id;
           
            
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaLesRed.php",true);

            divResultado.innerHTML= '<img src="anim.gif">';
            ajax.onreadystatechange=function()
                {
                  if (ajax.readyState==4)
                         {
                          

                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs

                             LimpiarCamposLesionRed();

                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("lesionRed="+lesionRed+"&cuerpo="+cuerpo+"&guardaLesRed="+guardaLesRed+"&Not="+Not);
  }
  // esta funcion limpia los camposb
function LimpiarCamposLesionRed()
{

  document.getElementById("lesionRed").value=-1;

}

function eliminarLesRed(cla,Not){

  divResultado = document.getElementById('TablaLesionRed');
  var eliminar = confirm("De verdad desea eliminar este dato?");  
  if ( eliminar ) {
    ajax=objetoAjax();
    ajax.open("GET", "eliminaLesionRed.php?cla="+cla+"&Not="+Not);
    divResultado.innerHTML= '<img src="anim.gif">';
    ajax.onreadystatechange=function() {
      if (ajax.readyState==4) {
        divResultado.innerHTML = ajax.responseText
      }
    }
    ajax.send(null)
  }
}


/// Esta funcion crea un objeto AJAX
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

function GEmbarazoRed(fol,Not){
            //donde se mostrará lo resultados
          
                     divResultado  = document.getElementById('MuestraEmbRed'); 
            //valores de los inputs
            for(i=0; i <document.embRed.Gine.length; i++)
             { 
                  if(document.embRed.Gine[i].checked)
                     {
                       var Indice1 = document.embRed.Gine[i].value;
                       
                     }
             }
             
            for(i=0; i <document.embRed.dolAbdominal.length; i++)
             {
                  if(document.embRed.dolAbdominal[i].checked)
                     {
                       var Indice3 = document.embRed.dolAbdominal[i].value;
                     }
             }
             
             
             
             
            for(i=0; i <document.embRed.movFet.length; i++)
             {
                  if(document.embRed.movFet[i].checked)
                     {
                       var Indice6 = document.embRed.movFet[i].value;
                     }
             }
            
                       var Indice2 = document.getElementById('semGes').value;
                       var Indice4 = document.getElementById('descEmb').value;
                       var Indice5 = document.getElementById('edoEmb').value;
                       var Indice7 = document.getElementById('obsEmb').value;
                     
          if( Indice1== "" || Indice2== "" || Indice3== "" || Indice4== "" || Indice5== "" || Indice6== "" || Indice7== "")
           {
           alert("Hay Campos Vacios");
     
           } 
           
           else{
          
                  Gine=document.embRed.Gine.value;   
                  semGes=document.getElementById('semGes').value;
                  dolAbdominal=document.embRed.dolAbdominal.value;
                  descEmb=document.getElementById('descEmb').value;
                  obsEmb=document.getElementById('obsEmb').value;
                  edoEmb=document.getElementById('edoEmb').value;
                  movFet= document.embRed.movFet.value;
                  guardaEmbRed=document.getElementById('guardaEmbRed').value;
          
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
              
            ajax.open("POST","guardaEmbRed.php",true);
          
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposEmb();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
 ajax.send("Gine="+Gine+"&semGes="+semGes+"&dolAbdominal="+dolAbdominal+"&descEmb="+descEmb+"&obsEmb="+obsEmb+"&edoEmb="+edoEmb+"&guardaEmbRed="+guardaEmbRed+"&movFet="+movFet+"&fol="+fol+"&Not="+Not)
  
}

}


function LimpiarCamposEmb()
{

    $("#semGes").attr('disabled', 'disabled');
    $("#dolAbdominal").attr('disabled', 'disabled');
    $("#descEmb").attr('disabled', 'disabled');
    $("#obsEmb").attr('disabled', 'disabled');
    $("#edoEmb").attr('disabled', 'disabled');
    $("#guardaEmbRed").attr('disabled', 'disabled');
}
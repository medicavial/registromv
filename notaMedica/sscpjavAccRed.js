
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


function cargaContenidoRed(idSelectOrigen)
{
	// Obtengo la posicion que ocupa el select que debe ser cargado en el array declarado mas arriba
	var posicionSelectDestino=buscarEnArray(listadoSelects, idSelectOrigen)+1;
	// Obtengo el select que el usuario modifico
	var selectOrigen=document.getElementById(idSelectOrigen);
	// Obtengo la opcion que el usuario selecciono
	var opcionSeleccionada=selectOrigen.options[selectOrigen.selectedIndex].value;
	// Si el usuario eligio la opcion "Elige", no voy al servidor y pongo los selects siguientes en estado "Selecciona opcion..."
	if(opcionSeleccionada==0)
	{
		var x=posicionSelectDestino, selectActual=null;
		// Busco todos los selects siguientes al que inicio el evento onChange y les cambio el estado y deshabilito
		while(listadoSelects[x])
		{
			selectActual=document.getElementById(listadoSelects[x]);
			selectActual.length=0;

			var nuevaOpcion=document.createElement("option");nuevaOpcion.value=0;nuevaOpcion.innerHTML="Selecciona Opci&oacute;n...";
			selectActual.appendChild(nuevaOpcion);selectActual.disabled=true;
			x++;
		}
	}
	// Compruebo que el select modificado no sea el ultimo de la cadena
	else if(idSelectOrigen!=listadoSelects[listadoSelects.length-1])
	{
		// Obtengo el elemento del select que debo cargar
		var idSelectDestino=listadoSelects[posicionSelectDestino];
		var selectDestino=document.getElementById(idSelectDestino);
		// Creo el nuevo objeto AJAX y envio al servidor el ID del select a cargar y la opcion seleccionada del select origen
		var ajax=objetoAjax();
		ajax.open("GET", "select_NotaMRed.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada, true);
		ajax.onreadystatechange=function()
		{
			if (ajax.readyState==1)
			{
				// Mientras carga elimino la opcion "Selecciona Opcion..." y pongo una que dice "Cargando..."
				selectDestino.length=0;
				var nuevaOpcion=document.createElement("option");nuevaOpcion.value=0;nuevaOpcion.innerHTML="Cargando...";
				selectDestino.appendChild(nuevaOpcion);selectDestino.disabled=true;
			}
			if (ajax.readyState==4)
			{
				selectDestino.parentNode.innerHTML=ajax.responseText;
			}
		}
		ajax.send(null);
	}
}

function cargaSelectRed()
{
 var sel =  document.getElementById("vehiculo").value;

    if(sel==0)
        {
         document.getElementById("Nod").style.display="block";
         document.getElementById("Nodtx").style.display="block";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Cintutx").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Bolsatx").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Ropatx").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Cascotx").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Roditx").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Codetx").style.display="none";
         document.getElementById("Costi").style.display="none";
         document.getElementById("Costitx").style.display="none";

         document.getElementById("Nodi").style.display="block";
         document.getElementById("Noditx").style.display="block";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Volctx").style.display="none";
         document.getElementById("Alca").style.display="none";
         document.getElementById("Alcatx").style.display="none";
         document.getElementById("Late").style.display="none";
         document.getElementById("Latetx").style.display="none";
         document.getElementById("Fron").style.display="none";
         document.getElementById("Frontx").style.display="none";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Derrtx").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Simptx").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Imaptx").style.display="none";
         document.getElementById("Caid").style.display="none";
          document.getElementById("Caidtx").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lesdeptx").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("Lestratx").style.display="none";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("ManSubtx").style.display="none";
         document.getElementById("Otr").style.display="none";
         document.getElementById("Otrtx").style.display="none";
        }

    if(sel == 1)
       {
         document.getElementById("Nod").style.display="none";
         document.getElementById("Nodtx").style.display="none";
         document.getElementById("Cintu").style.display="block";
         document.getElementById("Cintutx").style.display="block";
         document.getElementById("Bolsa").style.display="block";
         document.getElementById("Bolsatx").style.display="block";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Ropatx").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Cascotx").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Roditx").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Codetx").style.display="none";
         document.getElementById("Costi").style.display="none";
         document.getElementById("Costitx").style.display="none";

         document.getElementById("Nodi").style.display="none";
         document.getElementById("Noditx").style.display="none";
         document.getElementById("Volc").style.display="block";
         document.getElementById("Volctx").style.display="block";
         document.getElementById("Alca").style.display="block";
           document.getElementById("Alcatx").style.display="block";
         document.getElementById("Late").style.display="block";
         document.getElementById("Latetx").style.display="block";
         document.getElementById("Fron").style.display="block";
         document.getElementById("Frontx").style.display="block";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Derrtx").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Simptx").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Imaptx").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Caidtx").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lesdeptx").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("Lestratx").style.display="none";
         document.getElementById("ManSub").style.display="block";
         document.getElementById("ManSubtx").style.display="block";
         document.getElementById("Otr").style.display="block";
         document.getElementById("Otrtx").style.display="block";
       }
    if(sel==2)
        {

         document.getElementById("Nod").style.display="none";
         document.getElementById("Nodtx").style.display="none";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Cintutx").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Bolsatx").style.display="none";
         document.getElementById("Ropa").style.display="block";
         document.getElementById("Ropatx").style.display="block";
         document.getElementById("Casco").style.display="block";
         document.getElementById("Cascotx").style.display="block";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Roditx").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Codetx").style.display="none";
         document.getElementById("Costi").style.display="none";
         document.getElementById("Costitx").style.display="none";

         document.getElementById("Nodi").style.display="none";
            document.getElementById("Noditx").style.display="none";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Volctx").style.display="none";
         document.getElementById("Alca").style.display="block";
         document.getElementById("Alcatx").style.display="block";
         document.getElementById("Late").style.display="block";
         document.getElementById("Latetx").style.display="block";
         document.getElementById("Fron").style.display="block";
         document.getElementById("Frontx").style.display="block";
         document.getElementById("Derr").style.display="block";
         document.getElementById("Derrtx").style.display="block";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Simptx").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Imaptx").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Caidtx").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lesdeptx").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("Lestratx").style.display="none";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("ManSubtx").style.display="none";
         document.getElementById("Otr").style.display="none";
         document.getElementById("Otrtx").style.display="none";
        }
    if(sel==3)
        {
         document.getElementById("Nod").style.display="block";
         document.getElementById("Nodtx").style.display="block";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Cintutx").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Bolsatx").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Ropatx").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Cascotx").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Roditx").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Codetx").style.display="none";
         document.getElementById("Costi").style.display="none";
         document.getElementById("Costitx").style.display="none";

         document.getElementById("Nodi").style.display="none";
            document.getElementById("Noditx").style.display="none";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Volctx").style.display="none";
         document.getElementById("Alca").style.display="none";
          document.getElementById("Alcatx").style.display="none";
         document.getElementById("Late").style.display="none";
         document.getElementById("Latetx").style.display="none";
         document.getElementById("Fron").style.display="none";
         document.getElementById("Frontx").style.display="none";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Derrtx").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Simptx").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Imaptx").style.display="none";
         document.getElementById("Caid").style.display="block";
         document.getElementById("Caidtx").style.display="block";
         document.getElementById("Lesdep").style.display="block";
         document.getElementById("Lesdeptx").style.display="block";
         document.getElementById("Lestra").style.display="block";
         document.getElementById("Lestratx").style.display="block";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("ManSubtx").style.display="none";
         document.getElementById("Otr").style.display="none";
         document.getElementById("Otrtx").style.display="none";
        }
    if(sel==4)
        {
         document.getElementById("Nod").style.display="none";
         document.getElementById("Nodtx").style.display="none";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Cintutx").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Bolsatx").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Ropatx").style.display="none";
         document.getElementById("Casco").style.display="block";
         document.getElementById("Cascotx").style.display="block";
         document.getElementById("Rodi").style.display="block";
         document.getElementById("Roditx").style.display="block";
         document.getElementById("Code").style.display="block";
         document.getElementById("Codetx").style.display="block";
         document.getElementById("Costi").style.display="block";
         document.getElementById("Costitx").style.display="block";

         document.getElementById("Nodi").style.display="none";
            document.getElementById("Noditx").style.display="none";
         document.getElementById("Volc").style.display="none";
          document.getElementById("Volctx").style.display="none";
         document.getElementById("Alca").style.display="block";
         document.getElementById("Alcatx").style.display="block";
         document.getElementById("Late").style.display="block";
         document.getElementById("Latetx").style.display="block";
         document.getElementById("Fron").style.display="block";
         document.getElementById("Frontx").style.display="block";
         document.getElementById("Derr").style.display="none";
          document.getElementById("Derrtx").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Simptx").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Imaptx").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Caidtx").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lesdeptx").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("Lestratx").style.display="none";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("ManSubtx").style.display="none";
         document.getElementById("Otr").style.display="none";
         document.getElementById("Otrtx").style.display="none";
        }

       if(sel==5)
        {
         document.getElementById("Nod").style.display="block";
         document.getElementById("Nodtx").style.display="block";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Cintutx").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Bolsatx").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Ropatx").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Cascotx").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Roditx").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Codetx").style.display="none";
         document.getElementById("Costi").style.display="none";
         document.getElementById("Costitx").style.display="none";

         document.getElementById("Nodi").style.display="none";
            document.getElementById("Noditx").style.display="none";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Volctx").style.display="none";
         document.getElementById("Alca").style.display="none";
         document.getElementById("Alcatx").style.display="none";
         document.getElementById("Late").style.display="none";
         document.getElementById("Latetx").style.display="none";
         document.getElementById("Fron").style.display="none";
         document.getElementById("Frontx").style.display="none";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Derrtx").style.display="none";
         document.getElementById("Simp").style.display="block";
         document.getElementById("Simptx").style.display="block";
         document.getElementById("Imap").style.display="block";
         document.getElementById("Imaptx").style.display="block";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Caidtx").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lesdeptx").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("Lestratx").style.display="none";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("ManSubtx").style.display="none";
         document.getElementById("Otr").style.display="none";
         document.getElementById("Otrtx").style.display="none";
        }

         if(sel==6)
        {
         document.getElementById("Nod").style.display="block";
         document.getElementById("Nodtx").style.display="block";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Cintutx").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Bolsatx").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Ropatx").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Cascotx").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Roditx").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Codetx").style.display="none";
         document.getElementById("Costi").style.display="none";
         document.getElementById("Costitx").style.display="none";

         document.getElementById("Nodi").style.display="none";
        document.getElementById("Noditx").style.display="none";
         document.getElementById("Volc").style.display="block";
         document.getElementById("Volctx").style.display="block";
         document.getElementById("Alca").style.display="block";
         document.getElementById("Alcatx").style.display="block";
         document.getElementById("Late").style.display="block";
         document.getElementById("Latetx").style.display="block";
         document.getElementById("Fron").style.display="block";
         document.getElementById("Frontx").style.display="block";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Derrtx").style.display="none";
         document.getElementById("Simp").style.display="none";
          document.getElementById("Simptx").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Imaptx").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Caidtx").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lesdeptx").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("Lestratx").style.display="none";
         document.getElementById("ManSub").style.display="block";
         document.getElementById("ManSubtx").style.display="block";
         document.getElementById("Otr").style.display="block";
         document.getElementById("Otrtx").style.display="block";
        }
         if(sel==7)
        {
         document.getElementById("Nod").style.display="block";
         document.getElementById("Nodtx").style.display="block";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Cintutx").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Bolsatx").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Ropatx").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Cascotx").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Roditx").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Codetx").style.display="none";
         document.getElementById("Costi").style.display="none";
         document.getElementById("Costitx").style.display="none";

         document.getElementById("Nodi").style.display="block";
         document.getElementById("Noditx").style.display="block";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Volctx").style.display="none";
         document.getElementById("Alca").style.display="none";
         document.getElementById("Alcatx").style.display="none";
         document.getElementById("Late").style.display="none";
         document.getElementById("Latetx").style.display="none";
         document.getElementById("Fron").style.display="none";
         document.getElementById("Frontx").style.display="none";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Derrtx").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Simptx").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Imaptx").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Caidtx").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lesdeptx").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("Lestratx").style.display="none";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("ManSubtx").style.display="none";
         document.getElementById("Otr").style.display="none";
         document.getElementById("Otrtx").style.display="none";
        }
}


function setFocus(idnom)//Posiciona el cursor sobre el campo deseado
{
	document.getElementById(idnom).focus()
}

////////Funcion para calcular la Edad
function checkdate(objName,conedad)
{
var datefield = objName;
if (chkdate(objName,conedad) == false) {
datefield.select();
alert("Fecha invalida.  Intente nuevamente.");
datefield.focus();
return false;
}
else {
return true;
   }
}

function chkdate(objName, conedad)
{
//var strDatestyle = "US"; //United States date style
var strDatestyle = "EU";  //European date style
var strDate;
var strDateArray;
var strDay;
var strMonth;
var strYear;
var intday;
var intMonth;
var intYear;
var booFound = false;
var datefield = objName;
var strSeparatorArray = new Array("-"," ","/",".");
var intElementNr;
var err = 0;
var strMonthArray = new Array(12);

var d = new Date();
var dhoy =d.getDate();
var mhoy =d.getMonth()+1;
var ahoy =d.getFullYear();
var edad;

strMonthArray[0] = "Ene";
strMonthArray[1] = "Feb";
strMonthArray[2] = "Mar";
strMonthArray[3] = "Abr";
strMonthArray[4] = "May";
strMonthArray[5] = "Jun";
strMonthArray[6] = "Jul";
strMonthArray[7] = "Ago";
strMonthArray[8] = "Sep";
strMonthArray[9] = "Oct";
strMonthArray[10] = "Nov";
strMonthArray[11] = "Dic";
strDate = datefield.value;
if (strDate.length < 1) {
return true;
}
for (intElementNr = 0; intElementNr < strSeparatorArray.length; intElementNr++) {
if (strDate.indexOf(strSeparatorArray[intElementNr]) != -1) {
strDateArray = strDate.split(strSeparatorArray[intElementNr]);
if (strDateArray.length != 3) {
err = 1;
return false;
}
else {
strDay = strDateArray[0];
strMonth = strDateArray[1];
strYear = strDateArray[2];
}
booFound = true;
   }
}
if (booFound == false) {
if (strDate.length>5) {
strDay = strDate.substr(0, 2);
strMonth = strDate.substr(2, 2);
strYear = strDate.substr(4);
   }
}
if (strYear.length == 2) {
strYear = '20' + strYear;
}
// US style
if (strDatestyle == "US") {
strTemp = strDay;
strDay = strMonth;
strMonth = strTemp;
}
intday = parseInt(strDay, 10);
if (isNaN(intday)) {
err = 2;
return false;
}
intMonth = parseInt(strMonth, 10);
if (isNaN(intMonth)) {
for (i = 0;i<12;i++) {
if (strMonth.toUpperCase() == strMonthArray[i].toUpperCase()) {
intMonth = i+1;
strMonth = strMonthArray[i];
i = 12;
   }
}
if (isNaN(intMonth)) {
err = 3;
return false;
   }
}
intYear = parseInt(strYear, 10);
if (isNaN(intYear)) {
err = 4;
return false;
}
if (intMonth>12 || intMonth<1) {
err = 5;
return false;
}
if ((intMonth == 1 || intMonth == 3 || intMonth == 5 || intMonth == 7 || intMonth == 8 || intMonth == 10 || intMonth == 12) && (intday > 31 || intday < 1)) {
err = 6;
return false;
}
if ((intMonth == 4 || intMonth == 6 || intMonth == 9 || intMonth == 11) && (intday > 30 || intday < 1)) {
err = 7;
return false;
}
if (intMonth == 2) {
if (intday < 1) {
err = 8;
return false;
}
if (LeapYear(intYear) == true) {
if (intday > 29) {
err = 9;
return false;
}
}
else {
if (intday > 28) {
err = 10;
return false;
}
}
}
if (strDatestyle == "US") {
datefield.value = strMonthArray[intMonth-1] + " " + intday+" " + strYear;
}
else
	{//Regreso de fecha *********************************************************************************
	datefield.value = intday + " " + strMonthArray[intMonth-1] + " " + strYear;
	//si el mes es el mismo pero el d�a inferior aun no ha cumplido a�os, le quitaremos un a�o al actual
	if ((intMonth==mhoy)&&(intday > dhoy))
	{
	ahoy=ahoy-1;
	}
	//si el mes es superior al actual tampoco habr� cumplido a�os, por eso le quitamos un a�o al actual
	if (intMonth > mhoy)
	{
	ahoy=ahoy-1;
	}
	edad=ahoy-strYear;
	if (conedad==1)
	document.getElementById("txtedad").value=edad;
}

return true;
}

function LeapYear(intYear)
{
if (intYear % 100 == 0) {
if (intYear % 400 == 0) {return true;}
}
else {
if ((intYear % 4) == 0) {return true;}
}
return false;
}
//////////Fin funcion calcular edad

function requeridotxt(elem)//Quita los espacios de sobra y despues verifica si el campo tiene algo. Se debe indicar el id del input a verificar.
{
	  campo=document.getElementById(elem);
	  campo.value = campo.value.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/g,"");
	  if (campo.value==null||campo.value=="")
	  {
		alert("El campo es requerido. ("+elem+")");
		campo.focus();
		return false;
	  }	 
	  else return true;
}
function requeridoselect(elem)//se debe seleccionar un item de drop down
{
	  campo=document.getElementById(elem);
	  if (campo.value==null||campo.value==-1)
	  {
		alert("El campo es requerido. ("+elem+")");
		campo.focus();
		return false;
	  }	 
	  else return true;
}
function requeridotxtsm(elem)//= que requerido pero al encontrar el campo vacio no manda mensage
{
	  campo=document.getElementById(elem);
	  campo.value = campo.value.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/g,"");
	  if (campo.value==null||campo.value=="")
	  {
		return false;
	  }	 
	  else return true;
}
function valRadio(btn)//Verifica si se tiene seleccionada una opcion de un radio
{
    var cnt = -1;
    for (var i=btn.length-1; i > -1; i--) {
        if (btn[i].checked) {cnt = i;i = -1;}
    }
    if (cnt > -1) return btn[cnt].value;
    else return null;
}
function requeridorad(elem)//Verifica si se tiene seleccionada una opcion de un radio y manda mensage
{
	  campo=document.getElementsByName(elem);
	  if (valRadio(campo)==null)
	  {
		alert("Por favor seleccione una opci�n. ("+elem+")");
		return false;
	  } 
	  else return true;
}
function sinNumeros(e)//Verifica que tecla se presion� y si es n�mero lo elimina. //Utilizaci�n: onkeypress="return soloNumeros(event)"
{
var keynum
var keychar
var numcheck
if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /\d/
return !numcheck.test(keychar)
}
function soloLetras(e)//Verifica que tecla se presion�  y si no es letra lo elimina. //Utilizaci�n: onkeypress="return soloLetras(event)"
{
var keynum
var keychar
var numcheck
if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /[a-zA-Z������������ ]/;
return numcheck.test(keychar)
}
function soloNumeros(e)//Verifica que tecla se presion�  y si no es n�mero lo elimina. //Utilizaci�n: onkeypress="return soloNumeros(event)"
{
var keynum
var keychar
var numcheck

if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /\d/
return numcheck.test(keychar)
}
function soloNumerospunto(e)//Verifica que tecla se presion�  y si no es n�mero lo elimina. //Utilizaci�n: onkeypress="return soloNumeros(event)"
{
var keynum
var keychar
var numcheck

if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /[0-9.]/
return numcheck.test(keychar)
}
function soloNumLetraspuntocoma(e)//Verifica que tecla se presion�  y si no es n�mero lo elimina. //Utilizaci�n: onkeypress="return soloNumeros(event)"
{
var keynum
var keychar
var numcheck

if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /[0-9.,a-zA-Z ]/
return numcheck.test(keychar)
}
function nombrefiscal(e)//Verifica que tecla se presion�  y si no es n�mero lo elimina. //Utilizaci�n: onkeypress="return soloNumeros(event)"
{
var keynum
var keychar
var numcheck

if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /[0-9.,%&a-zA-Z ]/
return numcheck.test(keychar)
}
function rfcfiscal(e)//Verifica que tecla se presion�  y si no es n�mero lo elimina. //Utilizaci�n: onkeypress="return soloNumeros(event)"
{
var keynum
var keychar
var numcheck

if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /[0-9&a-zA-Z ]/
return numcheck.test(keychar)
}
function soloNumerosguion(e)//Verifica que tecla se presion�  y si no es n�mero lo elimina. //Utilizaci�n: onkeypress="return soloNumeros(event)"
{
var keynum
var keychar
var numcheck

if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /[0-9-,]/
return numcheck.test(keychar)
}
function sinSimbolospunto(e)//Verifica que tecla se presion�  y si  es simbolo lo elimina. //Utilizaci�n: onkeypress="return sinSimbolos(event)"
{
var keynum
var keychar
var numcheck
if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /[0-9a-zA-Z������������ ]/;
return numcheck.test(keychar)
}
function paraDatosAseguradora(e)//Verifica que tecla se presion� y deja pasar n�meros  y '-'  //Utilizaci�n: onkeypress="return sinSimbolos(event)"
{
var keynum
var keychar
var numcheck
if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /[0-9a-zA-Z-]/;
return numcheck.test(keychar)
}
function patRFC(e)//Verifica que tecla se presion�  y si  es simbolo diferente de '-' lo elimina.  //Utilizaci�n: onkeypress="return sinSimbolos(event)"
{
var keynum
var keychar
var numcheck
if(window.event) // IE
{
keynum = e.keyCode
}
else if(e.which) // Netscape/Firefox/Opera
{
keynum = e.which
}
keychar = String.fromCharCode(keynum)
numcheck = /[0-9a-zA-Z������������-]/;
return numcheck.test(keychar)
}
function ocultamuestra(elem)//Oculta o muestra una tabla
{
	if (document.getElementById(elem).style.display == "table")document.getElementById(elem).style.display = "none";
	else document.getElementById(elem).style.display = "table";
}
function RFC(cual)//*********************************Valida formato de RFC //requiere funcion comp
{
pat = /[a-z]|[A-Z]/;
pat2 = /[a-z]|[A-Z]|[0-9]/;
val = cual.split("-");
mensaje = "Debes poner un formato AAAA-999999-XXX";
if (val.length == 3)
{
	if(val[0].length == 4)
	{
		if(!comp(val[0],pat))
		{
			alert( mensaje);
			return false;
		}
	}
	if(val[1].length == 6)
	{
		if(isNaN(val[1]))
		{
			alert('No es un numero');
			return false;
		}
	}
	if(val[2].length == 3)
	{
		if(!comp(val[2],pat2))
		{
			alert(mensaje);
			return false;
		}
	}
	else
	{
		alert(mensaje);
		return false;
	}
}
	else
	{
		alert(mensaje);
		return false;
	}
	return true;
}
function comp(cual,pa)//Verifica que los caracteres de una cadena esten dentro de un patr�n. //Ligada a valida RFC
{
for(m=0;m<cual.length;m++){
	if(!pa.test(cual.charAt(m))){
		return false;
		break;
		}
	}
return true
}
function valEmail(elem)//Verifica que una direcci�n de E-mail este bien formada.
{
	campo=document.getElementById(elem);
    pat=/^[_a-z0-9-]+(.[_a-z0-9-]+)*@[a-z0-9-]+(.[a-z0-9-]+)*(.[a-z]{2,3})$/
    if(!pat.exec(campo.value))
    {
		alert("La direccion de correo no esta bien formada. ("+elem+")");
		campo.focus();
        return false;
    }
	else
	{
        return true;
    }
}
//**************************************************************************************************************
//*******************************************************************************Propios de la implementacion***
//**************************************************************************************************************
function validaregistro()
{	
	if(!requeridotxt("nom"))	{return false;}	
	if(!requeridotxt("pat"))	{return false;}
	if(!requeridotxt("mat"))	{return false;}
	if(!requeridotxt("element_4_1"))	{return false;}
	if(!requeridotxt("element_4_2"))	{return false;}
	if(!requeridotxt("element_4_3"))	{return false;}
	if(!requeridoselect("ase"))	{return false;}
	if((!requeridotxtsm("pol"))&&(!requeridotxtsm("sin"))&&(!requeridotxtsm("rep"))){alert("Debe ingresar algun dato de siniestro.");return false;}

	document.getElementById("btnenvio").style.display='none';
	document.getElementById("frmreg").submit();
}

function validaregistroprueba()
{
    var compania =$("#ase").val();
    var producto =$("#pro").val();    
	if(!requeridotxtsm("nom"))	{alert("Ingrese Nombre");return false;}
	if(!requeridotxtsm("pat"))	{alert("Ingrese Apellido Paterno");return false;}
	if(!requeridotxtsm("mat"))	{alert("Ingrese Apellido Materno");return false;}
	if(!requeridotxtsm("element_4_1"))	{alert("Ingrese Fecha de Nacimiento");return false;}
	if(!requeridotxtsm("element_4_2"))	{alert("Ingrese Fecha de Nacimiento");return false;}
	if(!requeridotxtsm("element_4_3"))	{alert("Ingrese Fecha de Nacimiento");return false;}
	if(!requeridoselect("ase"))	{return false;}
	if((!requeridotxtsm("pol"))&&(!requeridotxtsm("sin"))&&(!requeridotxtsm("rep"))&&(compania!=51)){alert("Debe ingresar algun dato de siniestro.");return false;}

        if(compania==7){
            if(!requeridoselect("pro"))	{return false;}
            if(!requeridoselect("esc"))	{return false;}
        }

        else if(compania==8){
            if(!requeridoselect("pro"))	{return false;}
            if(!requeridoselect("esc"))	{return false;}
            if(producto==2){
                if(!requeridotxtsm("DAPnombre"))	{alert("Ingrese Nombre del Asegurado");return false;}
                if(!requeridotxtsm("DAPnoreporte"))	{alert("Ingrese No. de Reporte en Cabina");return false;}
                if(!requeridotxtsm("DAPobs"))           {alert("Ingrese Observaciones");return false;}
                if(!requeridotxtsm("DAPdeducible"))	{alert("Ingrese el Deducible");return false;}
            }
        }

	document.getElementById("btnenvio").style.display='none';
	document.getElementById("frmreg").submit();
}

function validabusqueda()
{	
	if((!requeridotxtsm("nom"))&&(!requeridotxtsm("pat"))&&(!requeridotxtsm("mat"))&&(!requeridotxtsm("d"))&&(!requeridotxtsm("m"))&&(!requeridotxtsm("a"))&&(!requeridotxtsm("tel"))){alert("Debe ingresar alg�n dato de b�squeda.");return false;}
	document.getElementById("Bsubmit").style.display='none';
	document.getElementById("frmbusq").submit();
}
function validaFrmRfc(Brfc)
{
	if(RFC(Brfc)) document.getElementById("frmbusrfc").submit();
}
function validarfc()
{	
	if(!requeridotxt("nom"))		{return false;}	
	if(!requeridotxt("call"))		{return false;}
	if(!requeridotxt("col"))		{return false;}
	if(!requeridotxt("dmun"))		{return false;}
	if(!requeridotxt("ciudad"))		{return false;}
	if(!requeridotxt("cp"))			{return false;}
	if(!requeridotxt("entrecall"))	{return false;}
	if(!requeridotxt("correo"))		{return false;}
	if(!valEmail("correo"))			{return false;}
	return true;
}
function habilitaEd()
{
	if (document.getElementById("btned").value=="  Editar   ")
	{
		document.getElementById("nom").readOnly=false;
		document.getElementById("call").readOnly=false;
		document.getElementById("col").readOnly=false;
		document.getElementById("dmun").readOnly=false;
		document.getElementById("ciudad").readOnly=false;
		document.getElementById("cp").readOnly=false;
		document.getElementById("entrecall").readOnly=false;
		document.getElementById("correo").readOnly=false;
		document.getElementById("btned").value="  Guardar  ";
		document.getElementById("btnusar").style.display='none';
	}
	else
	{
		if (validarfc())
		{
			document.getElementById("frmrfc").action="editarfc.php";
			document.getElementById("frmrfc").submit();
		}
	}
}

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////// Js para HistoriaClinica´/////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function validaMail()
{
var x=document.forms["HistoriaClinica"]["mail"].value
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("Correo no Valido");
  return false;
  document.getElementById("mail").focus();
  }
  document.getElementById("mail").focus();
}
function validaMail2()
{
var x=document.forms["frmreg"]["mail"].value
var atpos=x.indexOf("@");
var dotpos=x.lastIndexOf(".");
if (atpos<1 || dotpos<atpos+2 || dotpos+2>=x.length)
  {
  alert("Correo no Valido Ejemplo: correo@medicavial.com");
  

  return false;
  }
}

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
//////// Funcion para pedir y procesar los datos, interactua con PHP
function pedirDatos(){
	//donde se mostrará el resultado
	divResultado = document.getElementById('resultado');
	//tomamos el valor de la lista desplegable
	uni=document.consulta.Unidad.value;
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//usamos el medoto POST
	//archivo que realizará la operacion
 //consulta.php
	ajax.open("POST", "consulta.php",true);
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			divResultado.innerHTML = ajax.responseText
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
 ajax.send("Unidad="+uni)
}
                          /////Historia Clinica Guarda Tabla Padecimientos Cronico-Degenerativos//////
function guardaPadCron()
{
   var Indice = document.getElementById("PadecimientosCronicos");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('Cronicos');
            //valores de los inputs
            IdCronico=document.HistoriaClinica.PadecimientosCronicos.value;
            ObsCronico=document.HistoriaClinica.ObsCronico.value;
            GuardaPad=document.HistoriaClinica.GuardaPad.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCampos();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdCronico="+IdCronico+"&ObsCronico="+ObsCronico+"&GuardaPad="+GuardaPad)
  }
  // esta funcion limpia los camposb
function LimpiarCampos()
{
  document.HistoriaClinica.PadecimientosCronicos.value=-1;
  document.HistoriaClinica.ObsCronico.value="";
}


function guardaOtras()
{
   var Indice = document.getElementById("Otras");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaOtras');
            //valores de los inputs
            IdOtras=document.HistoriaClinica.Otras.value;
            ObsOtras=document.HistoriaClinica.ObsOtras.value;
            GuardaOtras=document.HistoriaClinica.GuardaOtras.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposOtras();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdOtras="+IdOtras+"&ObsOtras="+ObsOtras+"&GuardaOtras="+GuardaOtras)
  }

  function historiasubmit()
{
   document.HistoriaClinica.submit();
   document.HistoriaClinica.guardaConsulta.disabled=true;

  }

  // esta funcion limpia los camposb
function LimpiarCamposOtras()
{
  document.HistoriaClinica.Otras.value=-1;
  document.HistoriaClinica.ObsOtras.value="";
}

function guardaAlergias()
{
   var Indice = document.getElementById("Alergias");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaAlergias');
            //valores de los inputs
            IdAlergias=document.HistoriaClinica.Alergias.value;
            ObsAlergias=document.HistoriaClinica.ObsAlergias.value;
            GuardaAlergias=document.HistoriaClinica.GuardaAlergias.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarCamposAlergias();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdAlergias="+IdAlergias+"&ObsAlergias="+ObsAlergias+"&GuardaAlergias="+GuardaAlergias)
  }
  // esta funcion limpia los camposb
function LimpiarCamposAlergias()
{
  document.HistoriaClinica.Alergias.value=-1;
  document.HistoriaClinica.ObsAlergias.value="";
}


function guardaHeredo()
{
   var Indice = document.getElementById("Enfermedad");
   var Indice2 = document.getElementById("Familiar");
   var Indice3 = document.getElementById("Estatus");
     if(Indice.value <1 || Indice2.value <1 || Indice3.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaHeredo');
            //valores de los inputs
            IdEnfermedad=document.HistoriaClinica.Enfermedad.value;
            IdFamiliar=document.HistoriaClinica.Familiar.value;
            IdEstatus=document.HistoriaClinica.Estatus.value;
            ObsHeredo=document.HistoriaClinica.ObsHeredo.value;
            GuardaHeredo=document.HistoriaClinica.GuardaHeredo.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarCamposHeredo();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdEnfermedad="+IdEnfermedad+"&IdFamiliar="+IdFamiliar+"&IdEstatus="+IdEstatus+"&ObsHeredo="+ObsHeredo+"&GuardaHeredo="+GuardaHeredo)
  }
  // esta funcion limpia los camposb
function LimpiarCamposHeredo()
{
  document.HistoriaClinica.Enfermedad.value=-1;
  document.HistoriaClinica.Familiar.value=-1;
  document.HistoriaClinica.Estatus.value=-1;
  document.HistoriaClinica.ObsHeredo.value="";
}

function guardaTrat()
{
        var Esp= document.getElementById("ObsTratamiento").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsTratamiento").focus();
    }else{
           //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaTratamiento');
           
           //valores de los inputs

             for(i=0; i <document.HistoriaClinica.Tratamiento.length; i++){
            if(document.HistoriaClinica.Tratamiento[i].checked){
              var Tratamiento = document.HistoriaClinica.Tratamiento[i].value;
                 }
                 }
            ObsTratamiento=document.HistoriaClinica.ObsTratamiento.value;
            GuardaTrat=document.HistoriaClinica.GuardaTrat.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarCamposTratamiento();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Tratamiento="+Tratamiento+"&ObsTratamiento="+ObsTratamiento+"&GuardaTrat="+GuardaTrat)
  }
}
  // esta funcion limpia los camposb
function LimpiarCamposTratamiento()
{
   document.HistoriaClinica.ObsTratamiento.value="";
}


function guardaOpe()
{
            var Esp= document.getElementById("ObsOperaciones").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsOperaciones").focus();
    }else{
           //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaOperaciones');
           //valores de los inputs
             for(i=0; i <document.HistoriaClinica.Operaciones.length; i++){
            if(document.HistoriaClinica.Operaciones[i].checked){
              var Operaciones = document.HistoriaClinica.Operaciones[i].value;
                 }
                 }
            ObsOperaciones=document.HistoriaClinica.ObsOperaciones.value;
            GuardaOpe=document.HistoriaClinica.GuardaOpe.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarCamposOperaciones();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Operaciones="+Operaciones+"&ObsOperaciones="+ObsOperaciones+"&GuardaOpe="+GuardaOpe)
  }
}
  // esta funcion limpia los camposb
function LimpiarCamposOperaciones()
{
   document.HistoriaClinica.ObsOperaciones.value="";
}

function guardaEsp()
{
    var Esp= document.getElementById("ObsEspalda").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsEspalda").focus();
    }else{
            divResultado = document.getElementById('TablaEspalda');
             for(i=0; i <document.HistoriaClinica.Espalda.length; i++){
            if(document.HistoriaClinica.Espalda[i].checked){
              var Espalda = document.HistoriaClinica.Espalda[i].value;
                 }
                 }
                    ObsEspalda=document.HistoriaClinica.ObsEspalda.value;
            GuardaEsp=document.HistoriaClinica.GuardaEsp.value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                                divResultado.innerHTML = ajax.responseText
                                  LimpiarCamposEspalda();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("Espalda="+Espalda+"&ObsEspalda="+ObsEspalda+"&GuardaEsp="+GuardaEsp)
  }
}
function LimpiarCamposEspalda()
{
   document.HistoriaClinica.ObsEspalda.value="";
}


function guardaQuiro()
{
       var Esp= document.getElementById("ObsQuiro").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsQuiro").focus();
    }else{
            divResultado = document.getElementById('TablaQuiro');
             for(i=0; i <document.HistoriaClinica.Quiro.length; i++){
            if(document.HistoriaClinica.Quiro[i].checked){
              var Quiro = document.HistoriaClinica.Quiro[i].value;
                 }
                 }
            ObsQuiro=document.HistoriaClinica.ObsQuiro.value;
            GuardaQuiro=document.HistoriaClinica.GuardaQuiro.value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                                divResultado.innerHTML = ajax.responseText
                                  LimpiarCamposQuiro();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("Quiro="+Quiro+"&ObsQuiro="+ObsQuiro+"&GuardaQuiro="+GuardaQuiro)
  }
}

function LimpiarCamposQuiro()
{
   document.HistoriaClinica.ObsQuiro.value="";
}


function guardaPlan()
{
           var Esp= document.getElementById("ObsPlan").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsPlan").focus();
    }else{
            divResultado = document.getElementById('TablaPlan');
             for(i=0; i <document.HistoriaClinica.Plan.length; i++){
            if(document.HistoriaClinica.Plan[i].checked){
              var Plan = document.HistoriaClinica.Plan[i].value;
                 }
                 }
            ObsPlan=document.HistoriaClinica.ObsPlan.value;
            GuardaPlan=document.HistoriaClinica.GuardaPlan.value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                                divResultado.innerHTML = ajax.responseText
                                  LimpiarCamposPlan();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("Plan="+Plan+"&ObsPlan="+ObsPlan+"&GuardaPlan="+GuardaPlan)
  }
}
function LimpiarCamposPlan()
{
   document.HistoriaClinica.ObsPlan.value="";
}


function guardaDep()
{
          var Esp= document.getElementById("ObsDeporte").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsDeporte").focus();
    }else{
           //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaDeporte');
           //valores de los inputs
             for(i=0; i <document.HistoriaClinica.Deporte.length; i++){
            if(document.HistoriaClinica.Deporte[i].checked){
              var Deporte = document.HistoriaClinica.Deporte[i].value;
                 }
                 }
            ObsDeporte=document.HistoriaClinica.ObsDeporte.value;
            GuardaDep=document.HistoriaClinica.GuardaDep.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarCamposDeporte();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Deporte="+Deporte+"&ObsDeporte="+ObsDeporte+"&GuardaDep="+GuardaDep)
  }
}
  // esta funcion limpia los camposb
function LimpiarCamposDeporte()
{
   document.HistoriaClinica.ObsDeporte.value="";
}

function guardaAdi()
{
           var Esp= document.getElementById("ObsAdiccion").value
    if(Esp=="" || Esp==null){
        alert("Llenar campo de Observaciones");
        document.getElementById("ObsAdiccion").focus();
    }else{
           //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaAdiccion');
           //valores de los inputs
             for(i=0; i <document.HistoriaClinica.Adiccion.length; i++){
            if(document.HistoriaClinica.Adiccion[i].checked){
              var Adiccion = document.HistoriaClinica.Adiccion[i].value;
                 }
                 }
            ObsAdiccion=document.HistoriaClinica.ObsAdiccion.value;
            GuardaAdi=document.HistoriaClinica.GuardaAdi.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarCamposAdiccion();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Adiccion="+Adiccion+"&ObsAdiccion="+ObsAdiccion+"&GuardaAdi="+GuardaAdi)
  }
}
  // esta funcion limpia los camposb
function LimpiarCamposAdiccion()
{
   document.HistoriaClinica.ObsAdiccion.value="";
}


function guardaAcc()
{
           //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaAccidente');
           //valores de los inputs
             for(i=0; i <document.HistoriaClinica.Accidente.length; i++){
            if(document.HistoriaClinica.Accidente[i].checked){
              var Accidente = document.HistoriaClinica.Accidente[i].value;
                 }
                 }
            IdLugar=document.HistoriaClinica.Lugar.value;
            ObsAccidente=document.HistoriaClinica.ObsAccidente.value;
            GuardaAcc=document.HistoriaClinica.GuardaAcc.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarCamposAccidente();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Accidente="+Accidente+"&ObsAccidente="+ObsAccidente+"&GuardaAcc="+GuardaAcc+"&IdLugar="+IdLugar)
  }
  // esta funcion limpia los camposb
function LimpiarCamposAccidente()
{
   document.HistoriaClinica.ObsAccidente.value="";
   document.HistoriaClinica.Lugar.value=-1;
}

function guardaZona()
{
   var Indice = document.getElementById("Zona");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaZona');
            //valores de los inputs
            IdZona=document.HistoriaClinica.Zona.value;
            ObsZona=document.HistoriaClinica.ObsZona.value;
            GuardaZona=document.HistoriaClinica.GuardaZona.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                            LimpiarCamposZona();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdZona="+IdZona+"&ObsZona="+ObsZona+"&GuardaZona="+GuardaZona)
  }
  // esta funcion limpia los camposb
function LimpiarCamposZona()
{
  document.HistoriaClinica.Zona.value=-1;
  document.HistoriaClinica.ObsZona.value="";
}

function guardaPaciente()
{
        
            //donde se mostrará lo resultados
            divResultado = document.getElementById('');
            //valores de los inputs
               for(i=0; i <document.HistoriaClinica.sexo.length; i++){
            if(document.HistoriaClinica.sexo[i].checked){
              var sexo = document.HistoriaClinica.sexo[i].value;
                 }
                 }
            fecnac=document.HistoriaClinica.fecnac.value;
            txtedad=document.HistoriaClinica.txtedad.value;
            txtmeses=document.HistoriaClinica.txtmeses.value;
            Ocupacion=document.HistoriaClinica.Ocupacion.value;
            EdoCivil=document.HistoriaClinica.EdoCivil.value;
            telefono=document.HistoriaClinica.telefono.value;
            mail=document.HistoriaClinica.mail.value;
            Religion=document.HistoriaClinica.Religion.value;
            next1=document.HistoriaClinica.next1.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
    
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("fecnac="+fecnac+"&txtedad="+txtedad+"&txtmeses="+txtmeses+"&Ocupacion="+Ocupacion+"&EdoCivil="+EdoCivil+"&telefono="+telefono+"&mail="+mail+"&Religion="+Religion+"&sexo="+sexo+"&next1="+next1)
}

function guardaO()
{
   var Indice = document.getElementById("Otras");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaVitales');
            //valores de los inputs
            IdOtras=document.HistoriaClinica.Otras.value;
            ObsOtras=document.HistoriaClinica.ObsOtras.value;
            GuardaOtras=document.HistoriaClinica.GuardaOtras.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaHistoria.php
            ajax.open("POST", "guardaHistoria.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposOtras();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdOtras="+IdOtras+"&ObsOtras="+ObsOtras+"&GuardaOtras="+GuardaOtras)
  }
  // esta funcion limpia los camposb
function LimpiarCamposOtras()
{
  document.HistoriaClinica.Otras.value=-1;
  document.HistoriaClinica.ObsOtras.value="";
}


function eliminarDato1(cla){
	//donde se mostrará el resultado de la eliminacion
	divResultado = document.getElementById('TablaHeredo');

	//usaremos un cuadro de confirmacion
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		//instanciamos el objetoAjax
		ajax=objetoAjax();
		//uso del medotod GET
		//indicamos el archivo que realizará el proceso de eliminación
		//junto con un valor que representa el id del empleado
		ajax.open("GET", "eliminaEnfFam.php?cla="+cla);
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


function eliminarDato2(cla){

	divResultado = document.getElementById('Cronicos');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaPadecimiento.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato3(cla){

	divResultado = document.getElementById('TablaOtras');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaOtra.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato4(cla){

	divResultado = document.getElementById('TablaAlergias');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaAlergia.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato5(cla){

	divResultado = document.getElementById('TablaTratamiento');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaTratamiento.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato6(cla){

	divResultado = document.getElementById('TablaOperaciones');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaOperacion.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato7(cla){

	divResultado = document.getElementById('TablaDeporte');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaDeporte.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato8(cla){

	divResultado = document.getElementById('TablaAdiccion');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaAdiccion.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato9(cla){

	divResultado = document.getElementById('TablaAccidente');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaAcc.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato10(cla){

	divResultado = document.getElementById('TablaZona');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaZona.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato11(cla){

	divResultado = document.getElementById('TablaEspalda');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaEspalda.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato12(cla){

	divResultado = document.getElementById('TablaQuiro');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaQuiro.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarDato13(cla){

	divResultado = document.getElementById('TablaPlan');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaPlan.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function enableE(Lb,Ob,Bt)
{
     document.getElementById(Lb).style.visibility="visible";
     document.getElementById(Ob).style.visibility="visible";
     document.getElementById(Bt).style.visibility="visible";
}
function disableE(Lb,Ob,Bt)
{
     document.getElementById(Lb).style.visibility="hidden";
     document.getElementById(Ob).style.visibility="hidden";
     document.getElementById(Bt).style.visibility="hidden";
}

function btnNext(id)
{
    if(id == "next1"){
    fecnac=document.HistoriaClinica.fecnac.value;
                  if(fecnac=="" || fecnac==null)
                       {
                           alert("Ingresar Fecha de Nacimiento")
                           document.getElementById("fecnac").focus();
                           return null;
                       }
   txtedad=document.HistoriaClinica.txtedad.value;
                   if(txtedad== "" || txtedad==null )
                       {
                           alert("Ingresar Edad")
                           document.getElementById("txtedad").focus();
                           return null;
                       }

 Ocupacion= document.HistoriaClinica.Ocupacion.value;
                   if(Ocupacion == -1)
                       {
                           alert("Elije Tipo de trabajo")
                           document.getElementById("Ocupacion").focus();
                           return null;
                       }
 EdoCivil= document.HistoriaClinica.EdoCivil.value;
                   if(EdoCivil == -1)
                       {
                           alert("Elije Estado Civil")
                           document.getElementById("EdoCivil").focus();
                           return null;
                       }
 telefono=document.HistoriaClinica.telefono.value;
                   if(telefono== "" || telefono==null )
                       {
                           alert("Ingresar Telefono")
                           document.getElementById("telefono").focus();
                           return null;
                       }

 Religion= document.HistoriaClinica.Religion.value;
                   if(Religion == -1)
                       {
                           alert("Elije Religion")
                           document.getElementById("Religion").focus();
                           return null;
                       }

    document.getElementById("tbAntecedentes").style.display="block";
    document.getElementById("Antecedentesdiv").style.display="block";
    document.getElementById(id).style.display="none";
    document.getElementById("divNext2").style.display="block";

    }

    if(id == "next2")
    {
        Enfermedad=document.HistoriaClinica.Enfermedad.value;
        Familiar=document.HistoriaClinica.Familiar.value;
        Estatus=document.HistoriaClinica.Estatus.value;
        ObsHeredo=document.HistoriaClinica.ObsHeredo.value;

        if(Enfermedad != -1 || Familiar != -1 || Estatus != -1 || ObsHeredo !="" )
            {
                alert("No se han guardado datos");
                document.getElementById("GuardaHeredo").focus();
                return null;
            }

       document.getElementById("tbAntecedentesP").style.display="block";
       document.getElementById("AntecedentesP").style.display="block";
       document.getElementById(id).style.display="none";
        document.getElementById("divNext3").style.display="block";
    }

    if(id == "next3")
        {
            PadecimientosCronicos=document.HistoriaClinica.PadecimientosCronicos.value;
            ObsCronico=document.HistoriaClinica.ObsCronico.value;
               if(PadecimientosCronicos != -1 || ObsCronico !="")
                   {
                       alert("No se han guardado Padecimientos Cronicos");
                       document.getElementById("GuardaPad").focus();
                       return null;
                   }
            Otras=document.HistoriaClinica.Otras.value;
            ObsOtras=document.HistoriaClinica.ObsOtras.value;
               if(Otras != -1 || ObsOtras !="")
                   {
                       alert("No se han guardado Otras Enfermedades");
                       document.getElementById("GuardaOtras").focus();
                       return null;
                   }
            Alergias=document.HistoriaClinica.Alergias.value;
            ObsAlergias=document.HistoriaClinica.ObsAlergias.value;
               if(Alergias != -1 || ObsAlergias !="")
                   {
                       alert("No se han guardado Alergias");
                       document.getElementById("GuardaAlergias").focus();
                       return null;
                   }

           ObsEspalda=document.HistoriaClinica.ObsEspalda.value;
           if(ObsEspalda !="")
               {
                   alert("No se ha guardado Padecimiento de Espalda");
                   document.getElementById("GuardaEsp").focus();
                   return null;
               }
           ObsQuiro=document.HistoriaClinica.ObsQuiro.value;
           if(ObsQuiro !="")
               {
                   alert("No se ha guardado Tratamiento Quiropractico");
                   document.getElementById("GuardaQuiro").focus();
                   return null;
               }
           ObsPlan=document.HistoriaClinica.ObsPlan.value;
           if(ObsPlan !="")
               {
                   alert("No se ha guardado Plantillas");
                   document.getElementById("GuardaPlan").focus();
                   return null;
               }
           ObsTratamiento=document.HistoriaClinica.ObsTratamiento.value;
           if(ObsTratamiento !="")
               {
                   alert("No se ha guardado Tratamiento");
                   document.getElementById("GuardaTrat").focus();
                   return null;
               }
           ObsOperaciones=document.HistoriaClinica.ObsOperaciones.value;
           if(ObsOperaciones !="")
               {
                   alert("No se han guardado Intervanciones Quirurgicas");
                   document.getElementById("GuardaOpe").focus();
                   return null;
               }
           ObsDeporte=document.HistoriaClinica.ObsDeporte.value;
           if(ObsDeporte !="")
               {
                   alert("No se ha guardado Deporte");
                   document.getElementById("GuardaDep").focus();
                   return null;
               }
           ObsAdiccion=document.HistoriaClinica.ObsAdiccion.value;
           if(ObsAdiccion !="")
               {
                   alert("No se ha guardado Adiccion");
                   document.getElementById("GuardaAdi").focus();
                   return null;
               }
   document.getElementById(id).style.display="none";
   document.getElementById("DivAntecedentes").style.display="block";
   document.getElementById("AccidentesA").style.display="block";
  // document.getElementById("divNext4").style.display="block";
   document.getElementById("divNext5").style.display="block";
        }

        if(id =="next4")
            {
                Lugar=document.HistoriaClinica.Lugar.value;
                ObsAccidente=document.HistoriaClinica.ObsAccidente.value;
                if(Lugar != -1 || ObsAccidente !=="" )
                    {
                        alert("No se ha guardado Accidente");
                        document.getElementById("GuardaAcc").focus();
                        return null;
                    }
                    Zona=document.HistoriaClinica.Zona.value;
                ObsZona=document.HistoriaClinica.ObsZona.value;
                if(Zona != -1 || ObsZona != "")
                    {
                        alert("No se ha guardado Zona con Dolor");
                        document.getElementById("GuardaZona").focus();
                        return false;
                    }
  document.getElementById(id).style.display="none";
  //document.getElementById("divNext5").style.display="block";
  document.getElementById("divConsulta").style.display="block";
  document.getElementById("divZonas").style.display="block";
  document.getElementById(id).style.display="none";
  document.getElementById("divMotivo").style.display="block";
            }
        if(id=="next5")
            {
                Zona=document.HistoriaClinica.Zona.value;
                ObsZona=document.HistoriaClinica.ObsZona.value;
                if(Zona != -1 || ObsZona != "")
                    {
                        alert("No se ha guardado Zona con Dolor");
                        document.getElementById("GuardaZona").focus();
                        return false;
                    }
    document.getElementById(id).style.display="none";
    document.getElementById("divMotivo").style.display="block";
            }
guardaPaciente();
}

////////////////////////////////////////////////////////////////
/////////// JS para Registro de Signos Vitales//////////////////
////////////////////////////////////////////////////////////////

function valid(id)
{
    if(id=="fr")
          {
              numero= document.getElementById(id).value
              if(numero=="" || numero==null){return false;}
              if(numero >250 )
                {
                  alert("FR no valida");
                  document.getElementById("fr").focus();
                  document.getElementById("fr").value="";
                }
          }

        if(id=="sist")
          {
             numero= document.getElementById(id).value
                if(numero=="" || numero==null){return false;}
              if(numero >250 || numero < 30)
                {
                  alert("Sistolica no valida");
                  document.getElementById("sist").focus();
                  document.getElementById("sist").value="";
                }
          }
                  if(id=="diast")
          {
              numero= document.getElementById(id).value
                 if(numero=="" || numero==null){return false;}
              if(numero >250 || numero <30)
                {
                  alert("Diastolica no valida");
                  document.getElementById("diast").focus();
                  document.getElementById("diast").value="";
                }
          }

          if(id=="fc")
          {
              numero= document.getElementById(id).value
                 if(numero=="" || numero==null){return false;}
              if(numero >250 )
                {
                  alert("FC no valida");
                  document.getElementById("fc").focus();
                  document.getElementById("fc").value="";
                }
          }
}

function tempe()
{
    temperatura = document.getElementById("temp").value;

    if(temperatura ==null || temperatura=="")
        {
            return false;
        }

    if(temperatura<30 || temperatura>50)
    {
        alert("Temperatura no valida");
        document.getElementById("temp").focus();
        document.getElementById("temp").value="";
        
    }
}

function tall()
{
    talla = document.getElementById("talla").value;

    if(talla==null || talla=="")
        {
            return false;
        }
    if(talla<=0 || talla>230)
    {
        alert("Talla no valida");
        document.getElementById("talla").focus();
        document.getElementById("talla").value="";
        
    }
}

function peso(){
  valor = document.getElementById("ps").value;
  if(valor =="" || valor==null){
return false;
  } 

  if(valor<=0 || valor>=500)
      {
           alert("Peso no valido");
    document.getElementById("ps").value="";
    document.getElementById("ps").focus();
      }
if( isNaN(valor) ) {
    alert("Formato no valido");
    document.getElementById("ps").value="";
    document.getElementById("ps").focus();
}
}

function presion(){
   Sist  = document.getElementById("sist").value;
   Diast = document.getElementById("diast").value;
   
   if(Sist >= 140 && Diast>=70){
       alert("Presion Arterial ALTA");
   }else if(Sist <= 90 && Diast<=60 ){
       alert("Precion Arterial BAJA");
              }else{
                  alert("Precion Arterial Normal");
              }
   
}



///////////////////////////////////////////////////////////////////////////////////
///////////////////////////// JS para NOTA MEDICA//////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////

function scroll() {
    	window.scrollBy(0,500); // horizontal and vertical scroll increments
    	//scrolldelay = setTimeout('pageScroll()',100); // scrolls every 100 milliseconds
}


function muestra(id)
{
    document.getElementById(id).style.display="block";
}

function oculta(id)
{
    document.getElementById(id).style.display="none";
}

// Declaro los selects que componen el documento HTML. Su atributo ID debe figurar aqui.
var listadoSelects=new Array();
listadoSelects[0]="vehiculo";
listadoSelects[1]="posicion";


function buscarEnArray(array, dato)
{// Retorna el indice de la posicion donde se encuentra el elemento en el array o null si no se encuentra
	var x=0;
	while(array[x])
	{
		if(array[x]==dato) return x;
		x++;
	}
	return null;
}

function cargaContenido(idSelectOrigen)
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
		ajax.open("GET", "select_NotaM.php?select="+idSelectDestino+"&opcion="+opcionSeleccionada, true);
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

function cargaSelect()
{
 var sel =  document.getElementById("vehiculo").value;

    if(sel==0)
        {
         document.getElementById("Nod").style.display="block";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Costi").style.display="none";

         document.getElementById("Nodi").style.display="block";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Alca").style.display="none";
         document.getElementById("Late").style.display="none";
         document.getElementById("Fron").style.display="none";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("Otr").style.display="none";
        }

    if(sel == 1)
       {
         document.getElementById("Nod").style.display="none";
         document.getElementById("Cintu").style.display="block";
         document.getElementById("Bolsa").style.display="block";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Costi").style.display="none";

         document.getElementById("Nodi").style.display="none";
         document.getElementById("Volc").style.display="block";
         document.getElementById("Alca").style.display="block";
         document.getElementById("Late").style.display="block";
         document.getElementById("Fron").style.display="block";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("ManSub").style.display="block";
         document.getElementById("Otr").style.display="block";
       }
    if(sel==2)
        {

         document.getElementById("Nod").style.display="none";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Ropa").style.display="block";
         document.getElementById("Casco").style.display="block";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Costi").style.display="none";

         document.getElementById("Nodi").style.display="none";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Alca").style.display="block";
         document.getElementById("Late").style.display="block";
         document.getElementById("Fron").style.display="block";
         document.getElementById("Derr").style.display="block";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("Otr").style.display="none";
        }
    if(sel==3)
        {
         document.getElementById("Nod").style.display="block";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Costi").style.display="none";

         document.getElementById("Nodi").style.display="none";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Alca").style.display="none";
         document.getElementById("Late").style.display="none";
         document.getElementById("Fron").style.display="none";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Caid").style.display="block";
         document.getElementById("Lesdep").style.display="block";
         document.getElementById("Lestra").style.display="block";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("Otr").style.display="none";
        }
    if(sel==4)
        {
         document.getElementById("Nod").style.display="none";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Casco").style.display="block";
         document.getElementById("Rodi").style.display="block";
         document.getElementById("Code").style.display="block";
         document.getElementById("Costi").style.display="block";

         document.getElementById("Nodi").style.display="none";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Alca").style.display="block";
         document.getElementById("Late").style.display="block";
         document.getElementById("Fron").style.display="block";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("Otr").style.display="none";
        }

       if(sel==5)
        {
         document.getElementById("Nod").style.display="block";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Costi").style.display="none";

         document.getElementById("Nodi").style.display="none";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Alca").style.display="none";
         document.getElementById("Late").style.display="none";
         document.getElementById("Fron").style.display="none";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Simp").style.display="block";
         document.getElementById("Imap").style.display="block";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("Otr").style.display="none";
        }

         if(sel==6)
        {
         document.getElementById("Nod").style.display="block";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Costi").style.display="none";

         document.getElementById("Nodi").style.display="none";
         document.getElementById("Volc").style.display="block";
         document.getElementById("Alca").style.display="block";
         document.getElementById("Late").style.display="block";
         document.getElementById("Fron").style.display="block";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("ManSub").style.display="block";
         document.getElementById("Otr").style.display="block";
        }
         if(sel==7)
        {
         document.getElementById("Nod").style.display="block";
         document.getElementById("Cintu").style.display="none";
         document.getElementById("Bolsa").style.display="none";
         document.getElementById("Ropa").style.display="none";
         document.getElementById("Casco").style.display="none";
         document.getElementById("Rodi").style.display="none";
         document.getElementById("Code").style.display="none";
         document.getElementById("Costi").style.display="none";

         document.getElementById("Nodi").style.display="block";
         document.getElementById("Volc").style.display="none";
         document.getElementById("Alca").style.display="none";
         document.getElementById("Late").style.display="none";
         document.getElementById("Fron").style.display="none";
         document.getElementById("Derr").style.display="none";
         document.getElementById("Simp").style.display="none";
         document.getElementById("Imap").style.display="none";
         document.getElementById("Caid").style.display="none";
         document.getElementById("Lesdep").style.display="none";
         document.getElementById("Lestra").style.display="none";
         document.getElementById("ManSub").style.display="none";
         document.getElementById("Otr").style.display="none";
        }
}


function guardaLesion(id)
{
    val = document.getElementById("lesion").value;
   var Indice = document.getElementById("lesion");
     if(Indice.value <1)
     {
           alert("Seleccionar primero Lesion y despues Zona!");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('TablaLesion');
            //valores de los inputs
            lesion=document.NotaMedica.lesion.value;
            GuardaLes="GuardaLes";
            cuerpo= id;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaNota.php",true);
            divResultado.innerHTML= '<img src="anim.gif">';
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposLesion();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("lesion="+lesion+"&cuerpo="+cuerpo+"&GuardaLes="+GuardaLes)
  }
  // esta funcion limpia los camposb
function LimpiarCamposLesion()
{
  document.NotaMedica.lesion.value=-1;

}

function eliminarLes(cla){

	divResultado = document.getElementById('TablaLesion');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaLesion.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}


function nota()
{
            //donde se mostrará lo resultados
            //divResultado = document.getElementById('MuesraRx');
            //valores de los inputs
            var Llega=document.getElementById("llega").value;
            //FechaAccidente=document.NotaMedica.ObsRx.value;//Pendiente
            //HoraA=document.NotaMedica.ObsRx.value;//Pendiente
            var Vehiculo=document.getElementById("vehiculo").value;
            var Posicion=document.getElementById("posicion").value;
            var Mecanismo=document.getElementById("mecanismo").value;
            var Vomito=document.getElementById("vomito").value;
            var Mareo=document.getElementById("mareo").value;
            var Nauseas=document.getElementById("nauseas").value;
            var Conocimiento=document.getElementById("conocimiento").value;
            var Cefalea=document.getElementById("cefalea").value;
            //Eqseguridad=document.NotaMedica.Seguridad.value;//Pendiente
            //Tipomecanismo=document.NotaMedica.Mecanismo.value;//Pendiente
            var EdoGeneral=document.getElementById("edoGeneral").value;
            var ExpFisica=document.getElementById("expFisica").value;
            var Diagnostico=document.getElementById("diagnostico").value;
            var ObsGenerales=document.getElementById("obsGenerales").value;
            var PronGeneral=document.getElementById("pronGeneral").value;
            var Lestab=document.getElementById("lesion").value;
            var GuardaNota=document.getElementById("GuardaNota").value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaNota.php",true);

   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("llega="+Llega+"&vehiculo="+Vehiculo+"&posicion="+Posicion+"&mecanismo="+Mecanismo+"&vomito="+Vomito+
            "&mareo="+Mareo+"&nauseas="+Nauseas+"&conocimiento="+Conocimiento+"&cefalea="+Cefalea+"&edoGeneral="+EdoGeneral+
            "&expFisica="+ExpFisica+"&diagnostico="+Diagnostico+"&obsGenerales="+ObsGenerales+"&pronGeneral="+PronGeneral+
            "&lestab="+Lestab+"&GuardaNota="+GuardaNota)
  }


function guardaRx(desde)
{
   var Indice = document.getElementById("Rx");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuesraRx');
            //valores de los inputs
            IdRx=document.NotaMedica.Rx.value;
            ObsRx=document.NotaMedica.ObsRx.value;
            DescRx=document.NotaMedica.DescRx.value;
            GuardaRx=document.NotaMedica.GuardaRx.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaNota.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposRx();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdRx="+IdRx+"&ObsRx="+ObsRx+"&DescRx="+DescRx+"&GuardaRx="+GuardaRx+"&DesdeRx="+desde)
  }

function guardaSolicitudRx(desde)
{
   var Indice = document.getElementById("Rx");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuesraRx');
            //valores de los inputs
            IdRx=document.NotaMedica.Rx.value;
            ObsRx=document.NotaMedica.ObsRx.value;
            DescRx=document.NotaMedica.DescRx.value;
            GuardaSolicitudRx=document.NotaMedica.GuardaSolicitudRx.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaNota.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposRx();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdRx="+IdRx+"&ObsRx="+ObsRx+"&DescRx="+DescRx+"&GuardaSolicitudRx="+GuardaSolicitudRx+"&DesdeRx="+desde)
  }
  // esta funcion limpia los camposb
function LimpiarCamposRx()
{
  document.NotaMedica.Rx.value=-1;
  document.NotaMedica.ObsRx.value="";
  document.NotaMedica.DescRx.value="";
}

function eliminarRx(cla){

	divResultado = document.getElementById('MuesraRx');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaRx.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarSolicitudRx(cla){

	divResultado = document.getElementById('MuesraRx');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaSolicitudRx.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function guardaEstu()
{


   var Indice = document.getElementById("Estudios");
   var ObsEstudios=document.NotaMedica.ObsEstudios.value;
       ObsEstudios= ObsEstudios.replace(/^(\s|\&nbsp;)*|(\s|\&nbsp;)*$/g,"");

     if(Indice.value <1 || ObsEstudios=="" )
     {
           if (Indice.value==-1){
               alert("Elija una opcion");
               document.getElementById("Estudios").focus();
           }
           if(ObsEstudios==""){
                              alert("ingresar Justificacion y observaciones.");
               document.getElementById("ObsEstudios").focus();
           }
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuesraEstu');
            //valores de los inputs
            Estudios=document.NotaMedica.Estudios.value;
          //  ObsEstudios=document.NotaMedica.ObsEstudios.value;
            anoA=document.NotaMedica.anoA.value;
            mesA=document.NotaMedica.mesA.value;
            diaA=document.NotaMedica.diaA.value;
            horaA=document.NotaMedica.horaA.value;
            minutoA=document.NotaMedica.minutoA.value;
            GuardaEstudios=document.NotaMedica.GuardaEstudios.value;

            fechaAccidente=anoA+"-"+mesA+"-"+diaA+" "+horaA+":"+minutoA
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaNota.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposEstu();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Estudios="+Estudios+"&ObsEstudios="+ObsEstudios+"&fechaAcci="+fechaAccidente+"&GuardaEstudios="+GuardaEstudios)
  }
  // esta funcion limpia los camposb
function LimpiarCamposEstu()
{
  document.NotaMedica.Estudios.value=-1;
  document.NotaMedica.ObsEstudios.value="";
}

function eliminarEstu(cla){

	divResultado = document.getElementById('MuesraEstu');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaEstu.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}


function guardaOrte()
{
   var Indice = document.getElementById("Ortesis");
   var Indice1 = document.getElementById("Ortpresentacin");
     if(Indice.value >0){

     if (Indice1.value <1)
     {
           alert("Seleccione Presentacion");
     } else{

            divResultado = document.getElementById('MuesraOrte');

            Ortesis=document.NotaMedica.Ortesis.value;
            Ortpresentacin=document.NotaMedica.Ortpresentacin.value;
            OrtCantidad=document.NotaMedica.OrtCantidad.value;
            Ortindicaciones=document.NotaMedica.Ortindicaciones.value;
            GuardaOrte=document.NotaMedica.GuardaOrte.value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaNota.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             divResultado.innerHTML = ajax.responseText
                             LimpiarCamposOrte();
                         }
               }
          }
          }
          else{
              alert("Seleccione Ortesis");
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("Ortesis="+Ortesis+"&Ortpresentacin="+Ortpresentacin+"&OrtCantidad="+OrtCantidad+"&Ortindicaciones="+Ortindicaciones+"&GuardaOrte="+GuardaOrte)
  }
function LimpiarCamposOrte()
{
 document.NotaMedica.Ortesis.value=-1;
 document.NotaMedica.Ortpresentacin.value=-1;
 document.NotaMedica.OrtCantidad.value="";
 document.NotaMedica.Ortindicaciones.value="";
}
function eliminarOrte(cla){
	divResultado = document.getElementById('MuesraOrte');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaOrte.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}
function eliminarItemTemp(cla, fol){
	divResultado = document.getElementById('listaItems');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {		
		ajax=objetoAjax();
		ajax.open("GET", "eliminaItempTemp.php?cla="+cla+"&fol="+fol);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}
function eliminarItemRec(cla, fol){
	divResultado = document.getElementById('listaItemsRec');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {		
		ajax=objetoAjax();
		ajax.open("GET", "eliminaItemRecibo.php?cla="+cla+"&fol="+fol);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarItemRecNuevo(cla, fol,cveRec){	
	divResultado = document.getElementById('listaItemsRec');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {		
		ajax=objetoAjax();
		ajax.open("GET", "eliminaItemReciboNuevo.php?cla="+cla+"&fol="+fol+"&cveRecibo="+cveRec);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function uno(){
  
   Obs = document.NotaMedica.Curaciones.value;
     if(Obs =="" || Obs==null)
     {
           alert("llenar campo");
           document.NotaMedica.Curaciones.focus();
     } else{

            divResultado = document.getElementById('MuesraCuraciones');

            Curaciones=document.NotaMedica.Curaciones.value;
            GuardaCuracion=document.NotaMedica.GuardaCuracion.value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaNota.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             divResultado.innerHTML = ajax.responseText
                             LimpiarCamposCuracion();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("Curaciones="+Curaciones+"&GuardaCuracion="+GuardaCuracion)
  }

function LimpiarCamposCuracion()
{
 document.NotaMedica.Curaciones.value="";
}
function eliminarCuracion(cla){
	divResultado = document.getElementById('MuesraCuraciones');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaCuraciones.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function guardaProc()
{
   var Indice = document.getElementById("Procedimientos");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuestraProc');
            //valores de los inputs
            Procedimientos=document.NotaMedica.Procedimientos.value;
            ObsPro=document.NotaMedica.ObsPro.value;
            GuardaProcedimiento=document.NotaMedica.GuardaProcedimiento.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaNota.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposProc();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Procedimientos="+Procedimientos+"&ObsPro="+ObsPro+"&GuardaProcedimiento="+GuardaProcedimiento)
  }
  // esta funcion limpia los camposb
function LimpiarCamposProc()
{
  document.NotaMedica.Procedimientos.value=-1;
  document.NotaMedica.ObsPro.value="";
}

function eliminarProcedimiento(cla){

	divResultado = document.getElementById('MuestraProc');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaProc.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function indic()
	{
	var mylist=document.getElementById("Suministro");
	document.getElementById("SumIndi").value=mylist.options[mylist.selectedIndex].title;
	}

function indicsymio()
	{
	var mylist=document.getElementById("CatalogoSymio");
	document.getElementById("SumIndiSymio").value=mylist.options[mylist.selectedIndex].title;
	}


function guardaSuministros()
{
   var Indice = document.getElementById("Suministro");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuesraSuministro');
            //valores de los inputs
            Suministro=document.NotaMedica.Suministro.value;
            SumCantidad=document.NotaMedica.SumCantidad.value;
            SumIndi=document.NotaMedica.SumIndi.value;
            GuardaSuministro=document.NotaMedica.GuardaSuministro.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaNota.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposSuministro();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Suministro="+Suministro+"&SumCantidad="+SumCantidad+"&SumIndi="+SumIndi+"&GuardaSuministro="+GuardaSuministro)
  }

  function guardaSuministrosSymio()
{
   var Indice = document.getElementById("CatalogoSymio");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuesraSuministroSymio');
            //valores de los inputs
            CatalogoSymio=document.NotaMedica.CatalogoSymio.value;
            SumCantidadSymio=document.NotaMedica.SumCantidadSymio.value;
            SumIndiSymio=document.NotaMedica.SumIndiSymio.value;
            GuardaSuministroSymio=document.NotaMedica.GuardaSuministroSymio.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaNota.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposSuministroSymio();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("CatalogoSymio="+CatalogoSymio+"&SumCantidadSymio="+SumCantidadSymio+"&SumIndiSymio="+SumIndiSymio+"&GuardaSuministroSymio="+GuardaSuministroSymio)
  }

  // esta funcion limpia los camposb
function LimpiarCamposSuministro()
{
  document.NotaMedica.Suministro.value=-1;
  document.NotaMedica.SumIndi.value="";
  document.NotaMedica.SumCantidad.value="";
}

function LimpiarCamposSuministroSymio()
{
  document.NotaMedica.CatalogoSymio.value=-1;
  document.NotaMedica.SumIndiSymio.value="";
  document.NotaMedica.SumCantidadSymio.value="";
}

function eliminarSuministro(cla){

	divResultado = document.getElementById('MuesraSuministro');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaSuministro.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function eliminarSuministroSymio(cla){

	divResultado = document.getElementById('MuesraSuministroSymio');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaSuministroSymio.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function indicG()
	{
	var mylist=document.getElementById("Indicacion");

        Ind1=document.getElementById("IndObs").value;
        Ind2=mylist.options[mylist.selectedIndex].text;

        document.getElementById("IndObs").value=Ind1+" "+Ind2;
        document.NotaMedica.IndObs.focus();
	
	}

function GEmbarazo()
{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuestraEmb');
            //valores de los inputs
          for(i=0; i <document.NotaMedica.Gine.length; i++)
             {
                  if(document.NotaMedica.Gine[i].checked)
                     {
                       var Gine = document.NotaMedica.Gine[i].value;
                     }
             }
          for(i=0; i <document.NotaMedica.dolAbdominal.length; i++)
             {
                  if(document.NotaMedica.dolAbdominal[i].checked)
                     {
                       var dolAbdominal = document.NotaMedica.dolAbdominal[i].value;
                     }
             }
         for(i=0; i <document.NotaMedica.movFet.length; i++)
             {
                  if(document.NotaMedica.movFet[i].checked)
                     {
                       var movFet = document.NotaMedica.movFet[i].value;
                     }
             }
            semGes=document.NotaMedica.semGes.value;
           // dolAbdominal=document.NotaMedica.dolAbdominal.value;
            descEmb=document.NotaMedica.descEmb.value;
            obsEmb=document.NotaMedica.obsEmb.value;
            edoEmb=document.NotaMedica.edoEmb.value;
            guardaEmb=document.NotaMedica.guardaEmb.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST","guardaNota.php",true);
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
   ajax.send("Gine="+Gine+"&semGes="+semGes+"&dolAbdominal="+dolAbdominal+"&descEmb="+descEmb+"&obsEmb="+obsEmb+"&edoEmb="+edoEmb+"&guardaEmb="+guardaEmb+"&movFet="+movFet)
}

function LimpiarCamposEmb()
{
    document.NotaMedica.semGes.value="";
    document.NotaMedica.dolAbdominal.value="";
    document.NotaMedica.descEmb.value="";
    document.NotaMedica.obsEmb.value="";
    document.NotaMedica.edoEmb.value="";
}

function GuardaIndi()
{
   var Indice = document.getElementById("Indicacion");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuesraIndi');
            //valores de los inputs
            Indicacion=document.NotaMedica.Indicacion.value;
            IndObs=document.NotaMedica.IndObs.value;
            GuardaInd=document.NotaMedica.GuardaInd.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaNota.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposInd();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("Indicacion="+Indicacion+"&IndObs="+IndObs+"&GuardaInd="+GuardaInd)
  }
  // esta funcion limpia los camposb
function LimpiarCamposInd()
{
  document.NotaMedica.Indicacion.value=-1;
  document.NotaMedica.IndObs.value="";
}

function eliminarInd(cla){

	divResultado = document.getElementById('MuesraIndi');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminarInd.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function validarRec(folio){
    Suministro   =  document.NotaMedica.Suministro.value;
    SumCantidad  =  document.NotaMedica.SumCantidad.value;
    SumIndi      =  document.NotaMedica.SumIndi.value;

    Ortesis          =  document.NotaMedica.Ortesis.value;
    Ortpresentacin   =  document.NotaMedica.Ortpresentacin.value;
    OrtCantidad      =  document.NotaMedica.OrtCantidad.value;
    Ortindicaciones  =  document.NotaMedica.Ortindicaciones.value;

    Indicacion       = document.NotaMedica.Indicacion.value;
    IndObs           = document.NotaMedica.IndObs.value;

    Diagnostico      = document.NotaMedica.diagnostico.value;

    if(Suministro != -1 || SumCantidad != "" || SumIndi!="" || Ortesis!= -1 || Ortpresentacin!= -1 || OrtCantidad!="" || Ortindicaciones!="" || Indicacion != -1 || IndObs != "")
    {

     var confirmar =  confirm("¿Deseas continuar sin datos guardados?");
     if( confirmar ){
         window.location.href='formatoReceta.php?fol='+folio;
     }
    }else{
                 window.location.href='formatoReceta.php?fol='+folio;
    }
}

function guardaDatAcc()
{
    alert("Si entro a la funcion");
           //donde se mostrará lo resultados
            divResultado = document.getElementById('divResultado');
            //valores de los inputs
            llega        = document.NotaMedica.llega.value;
            vehiculo     = document.NotaMedica.vehiculo.value;
            posicion     = document.NotaMedica.posicion.value;
            dia          = document.NotaMedica.element_4_1.value;
            mes          = document.NotaMedica.element_4_2.value;
            ano          = document.NotaMedica.element_4_3.value;
            horaA        = document.NotaMedica.horaA.value;
            minutoA      = document.NotaMedica.minutoA.value;
            mecanismo    = document.NotaMedica.mecanismo.value;
            vomito       = document.NotaMedica.vomito.value;
            conocimiento = document.NotaMedica.conocimiento.value;
            cefalea      = document.NotaMedica.cefalea.value;
            mareo        = document.NotaMedica.cefalea.value;
            nauseas      = document.NotaMedica.cefalea.value;
            next1        = document.NotaMedica.next1.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaNota.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("llega="+llega+"&vehiculo="+vehiculo+"&posicion="+posicion+"&dia="+dia+"&mes="+mes+"&ano="+ano+"&horaA="+horaA+"&minutoA="+minutoA+"&mecanismo="+mecanismo+"&vomito="+vomito+"&conocimiento="+conocimiento+"&cefalea="+cefalea+"&mareo="+mareo+"&nauseas="+nauseas+"&next1="+next1)
  }

function btnNextNota(id)
{
    if(id == "next1")
    {
      llega       =  document.NotaMedica.llega.value;
      element_4_1 =  document.NotaMedica.element_4_1.value;
      element_4_2 =  document.NotaMedica.element_4_2.value;
      element_4_3 =  document.NotaMedica.element_4_3.value;
      horaA       =  document.NotaMedica.horaA.value;
      vehiculo    =  document.NotaMedica.vehiculo.value;
      posicion    =  document.NotaMedica.posicion.value;
      mecanismo   =  document.NotaMedica.mecanismo.value;

      if(llega == -1){
          alert("Elige una opcion");
          document.getElementById("llega").focus();
          return null;
      }

      if(element_4_1 == "" || element_4_1==null){
          alert("Ingresa Fecha");
          document.getElementById("element_4_1").focus();
          return null;
      }
    
      if(element_4_2 == "" || element_4_2==null){
          alert("Ingresa Fecha");
          document.getElementById("element_4_2").focus();
          return null;
      }

      if(element_4_3 == "" || element_4_3==null){
          alert("Ingresa Fecha");
          document.getElementById("element_4_3").focus();
          return null;
      }

      if(horaA == "" || horaA == null){
          alert("Ingresar hora");
          document.getElementById("horaA").focus();
          return null;
      }

      if(vehiculo == 0){
          alert("Elige tipo de vehiculo");
          document.getElementById("vehiculo").focus();
          return null;  
      }
      if(mecanismo == "" || mecanismo == null){
          alert("Llenar campo Mecanismo de la lesion");
          document.getElementById("mecanismo").focus();
          return null;
      }

document.getElementById("divNext1").style.display="block";
document.getElementById("Next2").style.display="block";
document.getElementById("Next1").style.display="none";


    }


  if(id == "next2"){

      lesion      =  document.NotaMedica.lesion.value;
      edoGeneral  =  document.NotaMedica.edoGeneral.value;
      expFisica   =  document.NotaMedica.expFisica.value;

      if(lesion != -1){
          alert("No ha guardado Lesion, seleccione la parte del cuerpo!");
          document.getElementById("cuerpo2map").focus();
          return null;
      }

      if(edoGeneral == "" || edoGeneral == null){
          alert("Llenar campo Estado General");
          document.getElementById("edoGeneral").focus();
          return null;
      }
      if(expFisica == "" || expFisica == null){
          alert("Llenar campo Exploracion Fisica");
          document.getElementById("expFisica").focus();
          return null;
      }

      document.getElementById("divNext2").style.display="block";
      document.getElementById("Next2").style.display="none";
      document.getElementById("Next3").style.display="block";

   }
   if(id == "next3"){
       Rx          =   document.NotaMedica.Rx.value;
       ObsRx       =   document.NotaMedica.ObsRx.value;
       DescRx      =   document.NotaMedica.DescRx.value;
       diagnostico =   document.NotaMedica.diagnostico.value;

        if(Rx != -1 || ObsRx != "" || DescRx != "")
        {
            alert("No se han guardado Rx");
            document.getElementById("GuardaRx").focus();
            return null;
        }

        if(diagnostico == "" || diagnostico == null){
            alert("Llenar campo Diagnostico");
            document.getElementById("diagnostico").focus();
            return null;
        }
 document.getElementById("Next3").style.display="none";
 document.getElementById("divNext3").style.display="block";
 document.getElementById("Next4").style.display="block";
   }

   if(id == "next4" ){

      Procedimientos  =  document.NotaMedica.Procedimientos.value;
      ObsPro          =  document.NotaMedica.ObsPro.value;
  

      if(Procedimientos != -1 || ObsPro != ""){
          alert("No se guardaron Procedimientos");
          document.getElementById("GuardaProcedimiento").focus();
          return null;
      }

document.getElementById("Next4").style.display="none";
document.getElementById("divNext4").style.display="block";
document.getElementById("Next5").style.display="block";
   
   }

   if(id == "next5"){
           Curaciones      =  document.NotaMedica.Curaciones.value;
           Estudios        =  document.NotaMedica.Estudios.value;
           ObsEstudios     =  document.NotaMedica.ObsEstudios.value;
      if(Curaciones != ""){
          alert("No se guardaron Curaciones");
          document.getElementById("GuardaCuracion").focus();
          return null;
      }

      if(Estudios != -1 || ObsEstudios != ""){
          alert("No se guardaron Estudios e interconsultas");
          document.getElementById("GuardaEstudios").focus();
          return null;
      }
         document.getElementById("Next5").style.display="none";
   document.getElementById("divNext5").style.display="block";
   document.getElementById("Next6").style.display="block";

   }

}

function GInciRx()
{
    IncRx=document.NotaMedica.IncRx.value;
    if(IncRx=="" || IncRx==null){
        alert("Favor de especificar problema operativo");
        document.NotaMedica.IncRx.focus();
    }else{

            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuesraIncRx');
            //valores de los inputs
            
           
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            ajax.open("POST", "guardaIncidenteRx.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposIncRx();
                         }
               }
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IncRx="+IncRx)
    }
  }
  // esta funcion limpia los camposb
function LimpiarCamposIncRx()
{
  document.NotaMedica.IncRx.value="";
}
/////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////          Js para Incidentes       ////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////

function GuardaInci()
{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuesraIncidente');
            //valores de los inputs
            IdCom=document.SegIncidentes.ClaveIn.value;
            Com=document.SegIncidentes.ComentIncidente.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaComIncidente.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposInc();
                         }
               }
    ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IdCom="+IdCom+"&Com="+Com)
  }
  // esta funcion limpia los camposb
function LimpiarCamposInc()
{
  document.SegIncidentes.ComentIncidente.value="";
}
////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////    JS para Control de Expedientes       //////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////


function Doctos(folio)
{
             //donde se mostrará lo resultados
            divResultado = document.getElementById('Doctos');
            //valores de los inputs
          fol=folio;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "CheckDoctos.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposInd();
                         }
               }
          
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("fol="+fol)
    
}

function offPase()
{
    if(document.ControlExpediente.pase.checked==1)
    {
    document.ControlExpediente.autorizado.checked=0;
    document.ControlExpediente.vigencia.checked=1;
    document.ControlExpediente.identidad.checked=1;
    document.ControlExpediente.alteraciones.checked=1;
    } else{
    document.ControlExpediente.autorizado.checked=1;
    document.ControlExpediente.vigencia.checked=1;
    document.ControlExpediente.identidad.checked=1;
    document.ControlExpediente.alteraciones.checked=1;
    }
}

function offNota()
{
  if(document.ControlExpediente.nota.checked==1)
  {
    document.ControlExpediente.letra.checked=1;
    document.ControlExpediente.llena.checked=1;
    document.ControlExpediente.suministros.checked=1;
    document.ControlExpediente.estudios.checked=1;
    document.ControlExpediente.diagnostico.checked=1;
    document.ControlExpediente.firmaLes.checked=1;
    document.ControlExpediente.firmaMed.checked=1;
  }else{
    document.ControlExpediente.letra.checked=0;
    document.ControlExpediente.llena.checked=0;
    document.ControlExpediente.suministros.checked=0;
    document.ControlExpediente.estudios.checked=0;
    document.ControlExpediente.diagnostico.checked=0;
    document.ControlExpediente.firmaLes.checked=0;
    document.ControlExpediente.firmaMed.checked=0;
  }
}

function offCuest()
{
   if(document.ControlExpediente.cuest.checked==1)
    {
     document.ControlExpediente.identificado.checked=1;
     document.ControlExpediente.firmaCues.checked=1;
    }else{
     document.ControlExpediente.identificado.checked=0;
     document.ControlExpediente.firmaCues.checked=0;
    }
}

function offId()
{
    if(document.ControlExpediente.identificacion.checked==1)
        {
          document.ControlExpediente.pertenezca.checked=1;
          document.ControlExpediente.oficial.checked=1;
          document.ControlExpediente.copia.checked=1;
          document.ControlExpediente.formatoId.checked=0;
        }else{
               document.ControlExpediente.pertenezca.checked=0;
               document.ControlExpediente.oficial.checked=0;
               document.ControlExpediente.copia.checked=0;
               document.ControlExpediente.formatoId.checked=1;
             }
}

function offAviso()
{
    if(document.ControlExpediente.aviso.checked==1)
        {
          document.ControlExpediente.AfirmaLes.checked=1;
        }else{
               document.ControlExpediente.AfirmaLes.checked=0;
             }
}

function offFini()
{
    if(document.ControlExpediente.finiquito.checked==1)
        {
            document.ControlExpediente.FfirmaLes.checked=1;
        }else{
               document.ControlExpediente.FfirmaLes.checked=0;
             }
}


//////////////////////////////////////////////////////////////////////////////////
//////////////////////  JS para Control de REMESAS   /////////////////////////////
//////////////////////////////////////////////////////////////////////////////////

function Rems(folio)
{
             //donde se mostrará lo resultados
            divResultado = document.getElementById('formRem');
            //valores de los inputs
          fol=folio;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "CheckRem.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposInd();
                         }
               }

   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("fol="+fol)

}

/////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////    JS para Registro de Informacion complementaria  ///////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////////////////////////////

function InFecha(){
    document.getElementById("element_4_3").focus();
    document.getElementById("fecnac").focus();
 alert("Funciona el eveto");

}
/////////////////////////////////////////////////////////////
///////////////////  Js para Registro ///////////////////////
/////////////////////////////////////////////////////////////

function RegComp(Cia)
{

    if(Cia==19)
        {
         document.getElementById("regQUALITAS").style.display="block";
         document.getElementById("regGNP").style.display="none";

        }else if(Cia==10){
                     document.getElementById("regQUALITAS").style.display="none";
                     document.getElementById("regGNP").style.display="block";
        }else{
                     document.getElementById("regQUALITAS").style.display="none";
                     document.getElementById("regGNP").style.display="none";
        }


}

function fechareg(){

    dia= document.getElementById("element_4_1").value;
    mes=document.getElementById("element_4_2").value;
    ano=document.getElementById("element_4_3").value;
    fecha=fecha.getFullYear();

    dial = dia.length;
    mesl = mes.length;
    anol = ano.length;
    if(dia>32 || dia<=0){
        alert('Formato intorecto');
        document.getElementById("element_4_1").focus();
        return null;
    }
    if(mes>12 || mes<=0){
        alert('Formato intorecto');
        document.getElementById("element_4_2").focus();
        return null;
    }
    if(ano>anoA){
        alert('Formato intorecto');
        document.getElementById("element_4_2").focus();
        return null;

    }

    if (dial < 2 || mesl < 2 || anol<4){
        alert("Formato de fecha incorrecto: dd-mm-aaaa")
        document.getElementById("element_4_1").focus();
        return null;

    }
}

///////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////     Js para Subsecuencias    /////////////////////////////////
///////////////////////////////////////////////////////////////////////////////////////////

function GSub(){
     var Indice = document.getElementById("SubSum");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MSubSum');
            //valores de los inputs
            SubSum=    document.Subsecuencias.SubSum.value;
            SubSumCan= document.Subsecuencias.SubSumCan.value;
            SubSumInd= document.Subsecuencias.SubSumInd.value;
            GsubSum=   document.Subsecuencias.GsubSum.value;

            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaSub.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposSub();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
    ajax.send("SubSumCan="+SubSumCan+"&SubSumInd="+SubSumInd+"&GsubSum="+GsubSum+"&SubSum="+SubSum);
}

function LimpiarCamposSub(){
    document.Subsecuencias.SubSum.value=-1;
    document.Subsecuencias.SubSumCan.value=1;
    document.Subsecuencias.SubSumInd.value="";
}

function eliminarSubSum(cla){

	divResultado = document.getElementById('MSubSum');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminarSubSum.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function GortSub(){
    var Indice = document.getElementById("OrtSub");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{

            divResultado = document.getElementById('MuesraOrte');

            OrtSub=document.Subsecuencias.OrtSub.value;
            OrtSubPres=document.Subsecuencias.OrtSubPres.value;
            OrtSubCan=document.Subsecuencias.OrtSubCan.value;
            OrtSubind=document.Subsecuencias.OrtSubind.value;
            GOrtSub=document.Subsecuencias.GOrtSub.value;
            ajax=objetoAjax();
            ajax.open("POST", "guardaSub.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             divResultado.innerHTML = ajax.responseText
                             LimpiarCamposSubOrte();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   ajax.send("OrtSub="+OrtSub+"&OrtSubPres="+OrtSubPres+"&OrtSubCan="+OrtSubCan+"&OrtSubind="+OrtSubind+"&GOrtSub="+GOrtSub)
}

function LimpiarCamposSubOrte(){
    document.Subsecuencias.OrtSub.value=-1;
    document.Subsecuencias.OrtSubPres.value=-1;
    document.Subsecuencias.OrtSubCan.value=1;
    document.Subsecuencias.OrtSubind.value="";
}

function eliminarSubOrt(cla){

	divResultado = document.getElementById('MuesraOrte');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminarSubOrt.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}


function GuardaIndiSub()
{
   var Indice = document.getElementById("IndSub");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MindSub');
            //valores de los inputs
            IndSub=document.Subsecuencias.IndSub.value;
            IndObsSub=document.Subsecuencias.IndObsSub.value;
            GIndSub=document.Subsecuencias.GIndSub.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaSub.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposIndSub();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("IndSub="+IndSub+"&IndObsSub="+IndObsSub+"&GIndSub="+GIndSub)
  }
  // esta funcion limpia los camposb
function LimpiarCamposIndSub()
{
  document.Subsecuencias.IndSub.value=-1;
  document.Subsecuencias.IndObsSub.value="";
}

function eliminarInSu(cla){

	divResultado = document.getElementById('MindSub');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminarIndSub.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function guardaRxSub()
{
   var Indice = document.getElementById("RxSub");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MuRxSub');
            //valores de los inputs
            RxSub=document.Subsecuencias.RxSub.value;
            ObsRxSub=document.Subsecuencias.ObsRxSub.value;
            IntRxSub=document.Subsecuencias.IntRxSub.value;
            GrxSub=document.Subsecuencias.GrxSub.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaSub.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposRxSub();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("RxSub="+RxSub+"&ObsRxSub="+ObsRxSub+"&IntRxSub="+IntRxSub+"&GrxSub="+GrxSub)
  }
  // esta funcion limpia los camposb
function LimpiarCamposRxSub()
{
  document.Subsecuencias.RxSub.value=-1;
  document.Subsecuencias.ObsRxSub.value="";
  document.Subsecuencias.IntRxSub.value="";
}

function eliminarRxSub(cla){

	divResultado = document.getElementById('MuRxSub');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaRxSub.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

function guardaEstuSub()
{
   var Indice = document.getElementById("EstSub");
     if(Indice.value <1)
     {
           alert("Opcion no valida");
     } else{
            //donde se mostrará lo resultados
            divResultado = document.getElementById('MEstSub');
            //valores de los inputs
            EstSub=document.Subsecuencias.EstSub.value;
            ObsEstSub=document.Subsecuencias.ObsEstSub.value;
            GEstSub=document.Subsecuencias.GEstSub.value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            //guardaNota.php
            ajax.open("POST", "guardaSub.php",true);
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposEstuSub();
                         }
               }
          }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("EstSub="+EstSub+"&ObsEstSub="+ObsEstSub+"&GEstSub="+GEstSub)
  }
  // esta funcion limpia los camposb
function LimpiarCamposEstuSub()
{
  document.Subsecuencias.EstSub.value=-1;
  document.Subsecuencias.ObsEstSub.value="";
}

function eliminarEstSub(cla){
	divResultado = document.getElementById('MEstSub');
	var eliminar = confirm("De verdad desea eliminar este dato?")
	if ( eliminar ) {
		ajax=objetoAjax();
		ajax.open("GET", "eliminaEstSub.php?cla="+cla);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				divResultado.innerHTML = ajax.responseText
			}
		}
		ajax.send(null)
	}
}

/////////////////// JS Clasificacion //////////////

function conCla(){
    
    //donde se mostrará el resultado
	divResultado = document.getElementById('MClas');
	//tomamos el valor de la lista desplegable
	Dedia=document.getElementById('Dedia').value;
	Demes=document.getElementById('Demes').value;
	Deano=document.getElementById('Deano').value;
	Adia=document.getElementById('Adia').value;
	Ames=document.getElementById('Ames').value;
	Aano=document.getElementById('Aano').value;
	les=document.getElementById('les').checked;
	pol=document.getElementById('pol').checked;
	sin=document.getElementById('sin').checked;
	rep=document.getElementById('rep').checked;
	ase=document.getElementById('ase').checked;
	cla=document.getElementById('cla').checked;
	fec=document.getElementById('fec').checked;
	cos=document.getElementById('cos').checked;
	cia=document.getElementById('cia').value;
	foli=document.getElementById('foli').value;
	genClas=document.getElementById('genClas').value;
        Unidad=document.getElementById('Unidad').value;
	//instanciamos el objetoAjax
	ajax=objetoAjax();
	//usamos el medoto POST
	//archivo que realizará la operacion
 //consulta.php
	ajax.open("POST", "ConsultaClasificacion.php",true);
        divResultado.innerHTML= '<img src="anim.gif">';
	ajax.onreadystatechange=function() {
		if (ajax.readyState==4) {
			//mostrar resultados en esta capa
			divResultado.innerHTML = ajax.responseText
		}
	}
	ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
	//enviando los valores
 ajax.send("Dedia="+Dedia+"&Demes="+Demes+"&Deano="+Deano+"&Adia="+Adia+"&Ames="+Ames+"&Aano="+Aano+"&les="+les+"&pol="+pol+"&sin="+sin+"&rep="+rep+"&ase="+ase+"&cla="+cla+"&fec="+fec+"&cia="+cia+"&cos="+cos+"&foli="+foli+"&genClas="+genClas+"&Unidad="+Unidad)
    
}

function TodoClas()
{
    if(document.getElementById('ClasTodos').checked==true){

       document.getElementById('pol').checked=true;
       document.getElementById('sin').checked=true;
       document.getElementById('rep').checked=true;
       document.getElementById('ase').checked=true;
       document.getElementById('fec').checked=true;
    }else{
       document.getElementById('pol').checked=false;
       document.getElementById('sin').checked=false;
       document.getElementById('rep').checked=false;
       document.getElementById('ase').checked=false;
       document.getElementById('fec').checked=false;

    }
}


///// JS Subsecuencias///
function valiRecSub(folio){
    Suministro   =  document.Subsecuencias.SubSum.value;
    SumCantidad  =  document.Subsecuencias.SubSumCan.value;
    SumIndi      =  document.Subsecuencias.SubSumInd.value;

    Ortesis          =  document.Subsecuencias.OrtSub.value;
    Ortpresentacin   =  document.Subsecuencias.OrtSubPres.value;
    OrtCantidad      =  document.Subsecuencias.OrtSubCan.value;
    Ortindicaciones  =  document.Subsecuencias.OrtSubind.value;

    Indicacion       = document.Subsecuencias.IndSub.value;
    IndObs           = document.Subsecuencias.IndObsSub.value;

    if(Suministro != -1 || SumCantidad != 1 || SumIndi!="" || Ortesis!= -1 || Ortpresentacin!= -1 || OrtCantidad!=1 || Ortindicaciones!="" || Indicacion != -1 || IndObs != "")
    {
     var confirmar =  confirm("¿Deseas continuar sin datos guardados?");
     if( confirmar ){
         window.location.href='formatoRecSub.php?fol='+folio;
     }
    }else{
                 window.location.href='formatoRecSub.php?fol='+folio;
    }
}

function indicSub()
	{
	var mylist=document.getElementById("SubSum");
	document.getElementById("SubSumInd").value=mylist.options[mylist.selectedIndex].title;
	}

        function indicGSub()
	{
	var mylist=document.getElementById("IndSub");

        Ind1=document.getElementById("IndObsSub").value;
        Ind2=mylist.options[mylist.selectedIndex].text;

        document.getElementById("IndObsSub").value=Ind1+" "+Ind2;
        document.NotaMedica.IndObs.focus();

	}

function BtnNextSub(id){

    if(id=="next1"){

        SigSint=document.Subsecuencias.SigSint.value;
        evo=document.Subsecuencias.evo.value;

        if(SigSint=="" || SigSint==null){
                alert("Llenar campo Signos y sintomas");
                   document.getElementById("SigSint").focus();
                return null;
            }
       if(evo=="" || evo==null){
               alert("Llenar campo Evolucion");
               document.getElementById("evo").focus();
               return null;
           }

document.getElementById("divNext1").style.display="none";
document.getElementById("divNext2").style.display="block";
document.getElementById("divNext3").style.display="block";
       }

       if(id=="next2"){
           
           RxSub=      document.Subsecuencias.RxSub.value;
           ObsRxSub=   document.Subsecuencias.ObsRxSub.value;
           IntRxSub=   document.Subsecuencias.IntRxSub.value;
           diagSub=    document.Subsecuencias.diagSub.value;

           if(RxSub != -1 || ObsRxSub != "" || IntRxSub != ""){

               alert("No se guardaron datos");
               document.getElementById("GrxSub").focus();
               return null;
           }

           if(diagSub == "" || diagSub==null){
               alert("Llenar Diagnostico");
               document.getElementById("diagSub").focus();
               return null;
           }

document.getElementById("divNext3").style.display="none";
document.getElementById("divNext4").style.display="block";
document.getElementById("divNext5").style.display="block";
           
       }

       if(id=="next3"){

document.getElementById("divNext5").style.display="none";
document.getElementById("divNext6").style.display="block";
       }


       }

    
/////////////////////REMESA

function envRemesa()
          {
              alert("Si entra");
		ajax=objetoAjax();
		ajax.open("GET", "enviaRemesa.php?folRem="+folRem);
		divResultado.innerHTML= '<img src="anim.gif">';
		ajax.onreadystatechange=function() {
			if (ajax.readyState==4) {
				
			}
		}
		ajax.send(null)
           }

/////

function rep1(){

            //donde se mostrará lo resultados
            divResultado = document.getElementById('divRep1');
            //valores de los inputs
            dia=document.getElementById('element_4_1').value;
            mes=document.getElementById('element_4_2').value;
            ano=document.getElementById('element_4_3').value;
            //instanciamos el objetoAjax
            ajax=objetoAjax();
            //uso del medotod POST
            //archivo que realizará la operacion
            ajax.open("POST", "ConsultaReporte1.php",true);
            divResultado.innerHTML= '<img src="anim.gif">';
            ajax.onreadystatechange=function()
                {
                   if (ajax.readyState==4)
                         {
                             //mostrar resultados en esta capa
                             divResultado.innerHTML = ajax.responseText
                             //llamar a funcion para limpiar los inputs
                             LimpiarCamposEstuSub();
                         }
               }
   ajax.setRequestHeader("Content-Type","application/x-www-form-urlencoded");
   //enviando los valores
   ajax.send("dia="+dia+"&mes="+mes+"&ano="+ano)

}
/////

function facturaDeducible()
{
	var form =document.FacturaDeducible;

	if (form.nombre.value==0)
	{
		alert("Ingrese El Nombre");
		form.nombre.value="";
		form.nombre.focus();
		return false;
	}
        if (form.rfc.value==0)
	{
		alert("Ingrese RFC");
		form.rfc.value="";
		form.rfc.focus();
		return false;
	}
        if (form.calle.value==0)
	{
		alert("Ingrese La Calle");
		form.calle.value="";
		form.calle.focus();
		return false;
	}
        if (form.noint.value==0)
	{
		alert("Ingrese No. Interior");
		form.noint.value="";
		form.noint.focus();
		return false;
	}
        if (form.colonia.value==0)
	{
		alert("Ingrese La Colonia");
		form.colonia.value="";
		form.colonia.focus();
		return false;
	}
        if (form.municipio.value==0)
	{
		alert("Ingrese El Municipio");
		form.municipio.value="";
		form.municipio.focus();
		return false;
	}
        if (form.cp.value==0)
	{
		alert("Ingrese CP");
		form.cp.value="";
		form.cp.focus();
		return false;
	}
        if (form.estado.value==0)
	{
		alert("Ingrese Estado");
		form.estado.value="";
		form.estado.focus();
		return false;
	}
        if (form.importe.value==0)
	{
		alert("Ingrese El Importe");
		form.importe.value="";
		form.importe.focus();
		return false;
	}
        if (form.correo.value==0)
	{
		alert("Ingrese E-mail Del Cliente");
		form.correo.value="";
		form.correo.focus();
		return false;
	}


                document.FacturaDeducible.submit();
                document.FacturaDeducible.guardar.disabled=true;
}



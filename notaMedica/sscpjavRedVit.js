////////////////////////////////////////////////////////////////
/////////// JS para Registro de Signos Vitales//////////////////
////////////////////////////////////////////////////////////////

function soloNumeros(e)//Verifica que tecla se presion  y si no es numero lo elimina. //Utilizaciï¿½n: onkeypress="return soloNumeros(event)"
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






function valid(id)
{
    if(id=="frecResp")
          {
              numero= document.getElementById(id).value
              if(numero=="" || numero==null){return false;}
              if(numero >250 )
                {
                  alert("FR no valida");
                  document.getElementById("frecResp").focus();
                  document.getElementById("frecResp").value="";
                }
          }

        if(id=="sistole")
          {
             numero= document.getElementById(id).value
                if(numero=="" || numero==null){return false;}
              if(numero >250 || numero < 30)
                {
                  alert("Sistolica no valida");
                  document.getElementById("sistole").focus();
                  document.getElementById("sistole").value="";
                }
          }
                  if(id=="astole")
          {
              numero= document.getElementById(id).value
                 if(numero=="" || numero==null){return false;}
              if(numero >250 || numero <30)
                {
                  alert("Diastolica no valida");
                  document.getElementById("astole").focus();
                  document.getElementById("astole").value="";
                }
          }

          if(id=="frecCard")
          {
              numero= document.getElementById(id).value
                 if(numero=="" || numero==null){return false;}
              if(numero >250 )
                {
                  alert("Frecuencia cardiaca no valida");
                  document.getElementById("frecCard").focus();
                  document.getElementById("frecCard").value="";
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
  valor = document.getElementById("peso").value;
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
   sistole  = document.getElementById("sistole").value;
   astole = document.getElementById("astole").value;
   
   if(sistole >= 140 && astole>=70){
       alert("Presion Arterial ALTA");
   }else if(sistole <= 90 && astole<=60 ){
       alert("Precion Arterial BAJA");
              }else{
                  alert("Precion Arterial Normal");
              }
   
}


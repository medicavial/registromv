$(function(){

var itemsString='';

 
    $("#tipoItem").change(function(event){
        var id = $("#tipoItem").find(':selected').val();
        
        var fol= document.getElementById('fol').value;
        $("#itemOrtho").load('select-itemsDepen.php?id='+id+'&fol='+fol);     
        
    });

    $('#btn-submit').on('click',function(){        
        var str = $('#agregaItem').serialize();
        $.ajax({
            type:"POST",
            url: 'guardaItem.php',
            data: str,
            success: function(data){
                $('#resultado').html(data);
                $('select').val('-1');
                $('#precioItem').val('');
            },
            error: function(){
                $("#resultado").html('There was an error updating the settings');
            }
        });  //End Ajax
        
        
    });//End click btn-submit


    //*************************

    $('#btn-addProcMedicos').on('click',function(){
        var str = $('#form-procMedicoRed').serialize();
        $.ajax({
            type:"POST",
            url: 'addProcMedicoRed.php',
            data: str,
            success: function(data){
                $('#resultadoPMR').html(data);
                $('#proc,#obs').val('');
            },
            error: function(){
                $("#resultadoPMR").html('There was an error updating the settings');
            }
        });  //End Ajax
    });

    //**************************************************

    $('#btn-addSuministros').on('click',function(){
        if($('#tipoSumin').val()==''||$('#desc').val()==''){alert('Campos tipo y descripcion obligatorios')}
        else{
        var str = $('#form-suministrosRed').serialize();
        $.ajax({
            type:"POST",
            url: 'addSuministroRed.php',
            data: str,
            success: function(data){
                $('#resultadoSR').html(data);
                $('#tipoSumin').val('-1');
                $('#desc,#obs').val('');
            },
            error: function(){
                $("#resultadoSR").html('There was an error updating the settings');
            }
        });  //End Ajax
    }
    });

    $('#form-suministrosRedSub').submit(function(event){
        event.preventDefault();  
        var str = $('#form-suministrosRedSub').serialize();
        $.ajax({
            type:"POST",
            url: 'addSuministroRedSub.php',
            data: str,
            success: function(data){
                $('#resultadoSR').html(data);
                $('#tipoSumin').val('-1');
                $('#desc,#obs').val('');
            },
            error: function(){
                $("#resultadoSR").html('Hubo un error en el env&iacute;o');
            }
        });  //End Ajax
    });

    $('#verFactura').submit(function(event){
        event.preventDefault();  
        var str = $('#verFactura').serialize();
        $.ajax({
            type:"POST",
            url: 'verificaFolio.php',
            data: str,
            success: function(data){
                if(data=='error'){               
                    $('#validaFolio').val('');
                    $('#mensajeError').show("slow");
                    $("#mensajeError").html("<div class='alert alert-danger'>No existe recibo para este Folio</div>");
                    $("#mensajeError").delay(2000);
                    $('#mensajeError').hide("slow");
                }else{
                    $('#validaFolioRecibo').show("slow");
                    $('#verFactura').hide("slow");
                    $('#cargaListaItems').html(data);
                    
                }                            
            },
            error: function(){
                $("#resultadoSR").html('Hubo un error en el env&iacute;o');
            }
        });  //End Ajax
    });
   

    //**************************

///////////fincion de envio de items agregados////////////////////
        $("#agregaItem").submit(function(event) {
        event.preventDefault();         
        var values = $(this).serialize();        
        $.ajax({
            url: "guardaItem.php",
            type: "post",
            data: values,
            success: function(data){           
                $("#resultado").html(data);
            },
            error:function(){           
                $("#resultado").html('Error en el envío de datos');
            }
            });
    });

///////////funcion de guardar e imprimir recibo////////////////////
        $("#formRecibo").submit(function(event) {
        event.preventDefault();  
        $('#respuesta').html('<div align="center"><img style="width:50px; hight:50px;" src="imgs/loading.gif"/></div>');       
        var values = $(this).serialize();        
        $.ajax({
            url: "pruebaFormato.php",
            type: "get",
            data: values,
            success: function(data){           
                $("#respuesta").html(data);
            },
            error:function(){           
                $("#respuesta").html('Error en el envío de datos');
            }
            });
    });




/******************************** envio de solicitud de factura ********************************************/

 $("#SolicitudFactura").submit(function(event) {
        event.preventDefault();         
        var values = $(this).serialize();
        if($('#datosGuardados').val()==0){
            alert('Tienes que agregar al menos un Item');
            $("#itCodigo").focus();
        } 
        else{
        $.ajax({
            url: "envioFactura.php",
            type: "post",
            data: values,
            success: function(data){ 

                if(data=='error'){
                    $('#confirmacion').show("slow");
                    $("#confirmacion").html("<div class='alert alert-danger'>No se a podido enviar el correo</div>");
                    $("#confirmacion").delay(3000);
                    $('#confirmacion').show("hide");
                }
                if(data=='lleno'){
                     $('#confirmacion').show("slow");
                    $("#confirmacion").html("<div class='alert alert-warning'>Ya has enviado una solicitud!!</div>");
                    $("#confirmacion").delay(3000);
                    $('#confirmacion').show("hide");   
                }
                else{
                    $("#SolicitudFactura")[0].reset(); 
                    $("#botonEnvio").attr('disabled', true);                  
                    $("#confirmacion").html("<div class='alert alert-success'>El correo se envi&oacute; correctamente!.</div>");

                    setTimeout(function(){
                        url = "soporte.php?fol="+data;
                        $(location).attr('href',url);
                        },3000);                    
                }
                
            },
            error:function(){           
                $("#confirmacion").html('Error en el envío de datos');
            }
            });
        }
    });

$("#SolicitudFactura1").submit(function(event) {
        event.preventDefault();         
        var values = $(this).serialize();
        var folRecibo = $("#folRecibo").val();       
        if($('#datosGuardados').val()==0){
            alert('Tienes que agregar al menos un Item');
            $("#itCodigo").focus();
        } 
        else{            
        $.ajax({
            url: "envioFactura1.php",
            type: "post",
            data: values,
            success: function(data){ 

                if(data=='error'){
                    $('#confirmacion').show("slow");
                    $("#confirmacion").html("<div class='alert alert-danger'>No se a podido enviar el correo</div>");
                    $("#confirmacion").delay(3000);
                    $('#confirmacion').show("hide");
                }
                if(data=='lleno'){
                     $('#confirmacion').show("slow");
                    $("#confirmacion").html("<div class='alert alert-warning'>Ya has enviado una solicitud!!</div>");
                    $("#confirmacion").delay(3000);
                    $('#confirmacion').show("hide");   
                }
                else{                                                       
                    $("#SolicitudFactura1")[0].reset(); 
                    $("#botonEnvio").attr('disabled', true);                  
                    $("#confirmacion").html("<div class='alert alert-success'>El correo se envi&oacute; correctamente!.</div>");

                    setTimeout(function(){
                        url = "soporte.php?fol="+data;
                        $(location).attr('href',url);
                        },3000);                    
                }
                
            },
            error:function(){           
                $("#confirmacion").html('Error en el envío de datos');
            }
            });
        }
    });


 $("#sinFacturaForm").submit(function(event) {
        event.preventDefault();         
        var values = $(this).serialize();
       
        $.ajax({
            url: "envioSinFactura.php",
            type: "post",
            data: values,
            success: function(data){ 

                if(data=='error'){
                    $('#confirmacionSin').show("slow");
                    $("#confirmacionSin").html("<div class='alert alert-danger'>No se a podido enviar el correo</div>");
                    $("#confirmacionSin").delay(2000);
                    $('#confirmacionSin').hide("slow"); 
                }
                if(data=='lleno'){
                     $('#confirmacion').show("slow");
                    $("#confirmacion").html("<div class='alert alert-warning'>Ya has enviado una solicitud!!</div>");
                    $("#confirmacion").delay(3000);
                    $('#confirmacion').show("hide");   
                }
                else{
                    $("#sinFacturaForm")[0].reset();                   
                    $("#confirmacionSin").html("<div class='alert alert-success'>El correo se envi&oacute; correctamente!.</div>");

                    setTimeout(function(){
                        url = "soporte.php?fol="+data;
                        $(location).attr('href',url);
                        },3000);                    
                }
                
            },
            error:function(){           
                $("#confirmacion").html('Error en el envío de datos');
            }
            });        
    });


$("#facRfc").blur(function(event){
        var rfc = $("#facRfc").val();        
       $.ajax({
            url: "buscaRFC.php",
            type: "post",
            data: {rfc:rfc},
            success: function(data){                  
                var datos = data.split("/");                
                $("#facSocNom").val(datos[0]);
                $("#facCalle").val(datos[1]);
                $("#facNoEx").val(datos[2]);
                $("#facNoInt").val(datos[3]);
                $("#facCol").val(datos[4]);
                $("#facDel").val(datos[5]);
                $("#facCodP").val(datos[6]);
                $("#facRef").val(datos[7]);
                $("#facEmail").val(datos[8]);
                $("#facPer").val(datos[9]);
                $("#facMed").val(datos[10]);
                $("#facPago").val(datos[11]);
                $("#facObs").val(datos[12]);                
            },
            error:function(){           
                $("#respuesta").html('Error en el envío de datos');
            }
            });    
    });



 /****************************  fin de envio de solicitud de factura *************************************/


    $("#agregarItemButton").click(function() {            
        var codigo = $("#itCodigo").val(); 
        var concepto = $("#itConcepto").val();       
        var precio = $("#itPrecio").val();        
        var descuento = $("#itDesc").val();
        var folio = $("#fol").val();        
        if(codigo != '' && precio!='' && concepto!=''){
            $("#listaItems").html('');        
            $('#listaItems').html('<div align="center"><img style="width:50px; hight:50px;" src="imgs/loading.gif"/></div>');
            $.ajax({
            url: "guardaItemOrthoTemp.php",
            type: "post",
            data: {cod:codigo,con:concepto,pre:precio,desc:descuento,fol:folio},
            success: function(data){   
                $("#itCodigo").val('');
                $("#itConcepto").val('');
                $("#itPrecio").val('');
                $("#itDesc").val('');        
                $("#listaItems").html(data);
            },
            error:function(){           
                $("#listaItems").html('Error en el envío de datos');
            }
            });
        }
        else{                   
            $('#mensaje').show("slow");
            $("#mensaje").html('<div class="alert alert-warning">C&oacute;digo, Concepto y Precio son obligatorios</div>');
            $("#mensaje").delay(2000)
            $("#mensaje").hide("slow");
        }
    });
 $("#agregarItemRecibo").click(function() {            
       
        var concepto = $("#itConceptoRec").val();       
        var precio = $("#itPrecioRec").val(); 
        var desc = $("#itDescRec").val();                
        var folio = $("#fol").val();        
        if(precio!='' && concepto!=''){
            $("#listaItemsRec").html('');        
            $('#listaItemsRec').html('<div align="center"><img style="width:50px; hight:50px;" src="imgs/loading.gif"/></div>');
            $.ajax({
            url: "guardaItemRecibo.php",
            type: "post",
            data: {con:concepto,pre:precio,fol:folio,des:desc},
            success: function(data){                  
                $("#itConceptoRec").val('');
                $("#itPrecioRec").val('');
                $("#itDescRec").val('');                
                $("#listaItemsRec").html(data);
            },
            error:function(){           
                $("#listaItemsRec").html('Error en el envío de datos');
            }
            });
        }
        else{                   
            $('#mensaje').show("slow");
            $("#mensaje").html('<div class="alert alert-warning">Concepto y Precio son obligatorios</div>');
            $("#mensaje").delay(2000)
            $("#mensaje").hide("slow");
        }
    });
$("#agregarItemReciboNuevo").click(function() {            
               
        clave=$("#item").val();
        res= clave.split("/");
        item=res[0];
        var fol  = $("#fol").val();
        var folRec  = $("#folRec").val(); 
        var precio = $("#precio").val();
        var desc = $("#descuento").val();        
        if(item!=''){
            $("#listaItemsRec").html('');        
            $('#listaItemsRec').html('<div align="center"><img style="width:50px; hight:50px;" src="imgs/loading.gif"/></div>');
            $.ajax({
            url: "guardaItemReciboNuevo.php",
            type: "post",
            data: {it:item,fol:fol,folRec:folRec, pre:precio,des:desc},
            success: function(data){                  
                $("#item").val('');  
                $("#precio").val('');          
                $("#listaItemsRec").html(data);
            },
            error:function(){           
                $("#listaItemsRec").html('Error en el envío de datos');
            }
            });
        }
        else{                   
            $('#mensaje').show("slow");
            $("#mensaje").html('<div class="alert alert-warning">No ha seleccionado Item</div>');
            $("#mensaje").delay(2000)
            $("#mensaje").hide("slow");
        }
    });
/*****************solo numeros *///////////////////////
$(".solonum").keydown(function(event) {
   if(event.shiftKey)
   {
        event.preventDefault();
   }
 
   if (event.keyCode == 46 || event.keyCode == 8)    {
   }
   else {
        if (event.keyCode < 95) {
          if (event.keyCode < 48 || event.keyCode > 57) {
                event.preventDefault();
          }
        } 
        else {
              if (event.keyCode < 96 || event.keyCode > 105) {
                  event.preventDefault();
            }
        }
      }
   });

    
/************************************************************/    

/*********agregar item solo con jquery******************/
  /*  $("#agregarItemButton").click(function() {            
        var codigo = $("#itCodigo").val();        
        var precio = $("#itPrecio").val();        
        var descuento = $("#itDesc").val(); 
        var agrega ='';               
        if(codigo != '' && precio!=''){
            if(itemsString==''){
                itemsString=codigo+'-'+precio+'-'+descuento;    
            }
            else{
                itemsString=itemsString+'/'+codigo+'-'+precio+'-'+descuento;
            }            
            presenta=itemsString.split("/");
            alert(presenta[0]);
            agrega='<table class="table">';
            agrega=agrega+'<tr><th>C&oacute;digo</th><th>Precio</th><th>Descuento</th></tr>';
            agrega=agrega+'<tr><td>'+codigo+'</td><td>'+precio+'</td><td>'+descuento+'</td></tr>';
            agrega=agrega+'</table>';              
            $('#listaItems').show();        
            $("#listaItems").html(itemsString);
            $("#itCodigo").val('');        
            $("#itPrecio").val('');        
            $("#itDesc").val(''); 
        }
        else            
            $('#mensaje').show("slow");
            $("#mensaje").html('<div class="alert alert-success">El precio y el código son obligatorios</div>');
            $("#mensaje").delay(2000)
            $("#mensaje").hide("slow");
    });
*/
/************************fin de items agregados con jquery********************/
//////////////////// fin de aitems agregados /////////////////////


});//End function Principal jQuery

//*************** Funciones JavaScript

function eliminaItem(id,fol){
    //alert(id+fol);
    $.ajax({
        type:"GET",
        url: 'eliminaItem.php?id='+id+'&fol='+fol,
        //data: id,fol,
        success: function(data){
            $('#resultado').html(data);
            $('select').val('-1');
        },
        error: function(){
            $("#resultado").html('There was an error updating the settings');
        }
    });  //End Ajax
} // End function eliminaItem 

//*****************************************

function buscaPrecio(valor){
    $.ajax({
                type:"GET",
                url: 'buscaPrecioItem.php?id='+valor,
                //data: id,fol,
                success: function(data){
                    //$('#rpItem').html(data);
                    document.getElementById('precioItem').value=data;
                },
                error: function(){
                    $("#rpItem").html('There was an error updating the settings');
                }
            });  //End Ajax
}// End function buscaPrecio

//****************************************

function removeProcMedico(cons,fol,not){
      //alert(cons+fol+not);  
     
     $.ajax({
        type:"GET",
        url: 'removeProcMedico.php?cons='+cons+'&fol='+fol+'&Not='+not,
        //data: id,fol,
        success: function(data){
            $('#resultadoPMR').html(data);
            $('select').val('-1');
        },
        error: function(){
            $("#resultadoPMR").html('There was an error updating the settings');
        }
    });  //End Ajax

}

//***************************************

function removeSuministroRed(cons,fol,not){
      //alert(cons+fol+not);  
     
     $.ajax({
        type:"GET",
        url: 'removeSuministroRed.php?cons='+cons+'&fol='+fol+'&Not='+not,
        //data: id,fol,
        success: function(data){
            $('#resultadoSR').html(data);
            //$('select').val('-1');
        },
        error: function(){
            $("#resultadoSR").html('There was an error updating the settings');
        }
    });  //End Ajax

}

function removeSuministroRedSub(cons,fol,not){
      //alert(cons+fol+not);  
     
     $.ajax({
        type:"GET",
        url: 'removeSuministroRedSub.php?cons='+cons+'&fol='+fol+'&Sub='+not,
        //data: id,fol,
        success: function(data){
            $('#resultadoSR').html(data);
            //$('select').val('-1');
        },
        error: function(){
            $("#resultadoSR").html('There was an error updating the settings');
        }
    });  //End Ajax

}

//*****************************************************

function generaComprobanteItem(){
    //alert("Bu");
    $('#cargando').show();
    
     $.ajax({
        type:"GET",
        url: 'generaComprobanteItem.php',
        //data: id,fol,
        success: function(data){
            //$('#probando').html(data);
            $(location).attr('href', 'lanzador.php');
            //$('select').val('-1');
            $('#cargando').hide();
        },
        error: function(){
            $("#probando").html('There was an error updating the settings');
            $('#cargando').hide();
        }
    });  //End Ajax    
}

function veFactura(){
    var opcion = $("input[name='factura']:checked").val(); 
    if(opcion=='S'){
        $("#sinFactura").hide("slow");
        $("#facturaForm").show("slow");
    }
    else{
        $("#facturaForm").hide("slow");
        $("#sinFactura").show("slow");
    }
}

function aMays(e, elemento) {
tecla=(document.all) ? e.keyCode : e.which; 
 elemento.value = elemento.value.toUpperCase();
}

function verOtro(){
    $("#otro").show("slow");
}

function ponerPrecio(precio){
    clave=$("#item").val();
    res= clave.split("/");
    $("#precio").val(res[1]);

}

function selectItem(){
    clave=$("#familia").val();
    $.ajax({
            type:"POST",
            url: 'familiaItem.php',
            data: {'cveFam':clave},
            success: function(data){
                $("#selectItem").html(data);
                $("#precio").val('');                        
            },
            error: function(){
                $("#selectItem").html('Hubo un error en el env&iacute;o');
            }
        });  //End Ajax
}

function verFacturaLink(folRec, fol){

    $.ajax({
            type:"POST",
            url: 'verificaFolio.php',
            data: {'validaFolio':folRec,'fol':fol},
            success: function(data){
                if(data=='error'){               
                    $('#validaFolio').val('');
                    $('#mensajeError').show("slow");
                    $("#mensajeError").html("<div class='alert alert-danger'>No existe recibo para este Folio</div>");
                    $("#mensajeError").delay(2000);
                    $('#mensajeError').hide("slow");
                }else{
                    $('#validaFolioRecibo').show("slow");
                    $('#verFactura').hide("slow");
                    $('#cargaListaItems').html(data);
                    
                }                            
            },
            error: function(){
                $("#resultadoSR").html('Hubo un error en el env&iacute;o');
            }
        });  //End Ajax
}
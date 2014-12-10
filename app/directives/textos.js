// coleccion de directivas para inputs


//funcion para convertir mayusculas
app.directive('mayusculas', function() {
   return {
     require: 'ngModel',
     link: function(scope, element, attrs, modelCtrl) {
        // var capitalize = function(inputValue) {
        //    var capitalized = inputValue.toUpperCase();
        //    if(capitalized !== inputValue) {
        //       modelCtrl.$setViewValue(capitalized);
        //       modelCtrl.$render();
        //     }         
        //     return capitalized;
        //  }
        //  modelCtrl.$parsers.push(capitalize);
        //  capitalize(scope[attrs.ngModel]);  // capitalize initial value
        element.on('keyup',function(e){

          if (typeof modelCtrl.$modelValue != 'undefined') {

            if(e.keyCode != 32){
              var nuevo = modelCtrl.$modelValue.toUpperCase();
              modelCtrl.$setViewValue(nuevo);
              modelCtrl.$render();
              scope.$apply();
            }
          };

        });
     }
   };
});

//directiva para teclear un folio medicavial 
app.directive('folio', function() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function(scope, element, attrs, modelCtrl) {

          var functionToCall = scope.$eval(attrs.folio);

          //console.log(functionToCall);
          //console.log(modelCtrl.$modelValue);
          //console.log(attrs);
          console.log(scope);

          var rellenaFolio = function(folio){

            if (folio != '') {

              var totalletras = folio.length;

              var letras = folio.substr(0,4);
              var numeros = folio.substr(4,totalletras);

              if(letras.length < 4 ){

                var faltantes = 4 - letras.length;

                for (var i = 0; i < faltantes; i++) {

                  var letra = letras.charAt(i);
                  letras = letras + "0";
                }
              }

              if(numeros.length < 6 ){

                var faltantes = 6 - numeros.length;

                for (var i = 0; i < faltantes; i++) {
                  
                  numeros = "0" + numeros;
                }
              }

              folio = letras + numeros;

              return folio;

            }else{

              return folio

            }
          }
          
          element.on('blur',function(){

            if (modelCtrl.$modelValue.length > 3) {
              var nuevo = rellenaFolio(modelCtrl.$modelValue);
              //console.log(nuevo);
              modelCtrl.$setViewValue(nuevo);
              modelCtrl.$render();
              scope.$apply();
            };

          });

          element.on('keydown', function(e){
                

                var cantidad = modelCtrl.$modelValue.length;

                //console.log(e.keyCode);

                //los primero cuatro caracteres NO deben ser numeros
                if(cantidad <= 3){

                  if (e.keyCode >= 48 && e.keyCode <= 57 || e.keyCode >= 96 && e.keyCode <= 105) {
                        e.preventDefault();
                  }else{
                        modelCtrl.$parsers.push(function (inputValue) {

                           if (inputValue == undefined) return '' 
                           var transformedInput = inputValue.toUpperCase();
                           if (transformedInput!=inputValue) {
                              modelCtrl.$setViewValue(transformedInput);
                              modelCtrl.$render();
                           }         

                           return transformedInput; 

                        });
                  }

                }

                //los ultimos 6 NO deben ser letras
                if(cantidad >= 4 && cantidad <= 9){

                  if (e.keyCode >= 65 && e.keyCode <= 90 || e.keyCode >= 106) {
                        e.preventDefault();
                  }

                }

                //Si son mas de 10 digitos no escribas mas
                if(cantidad >= 10){
                    
                    if (e.keyCode >= 65 && e.keyCode <= 90 || e.keyCode >= 48 && e.keyCode <= 57 || e.keyCode >= 96 && e.keyCode <= 105 || e.keyCode >= 106) {
                      e.preventDefault();
                    }else{
                      //console.log('Presionaste ' + e.keyCode);
                    } 

                }

                if (e.keyCode == 13 || e.keyCode == 9) {

                      if (cantidad > 4) {

                        
                        var nuevo = rellenaFolio(modelCtrl.$modelValue);
                        //console.log(nuevo);
                        modelCtrl.$setViewValue(nuevo);
                        modelCtrl.$render();
                        scope.$apply();
                        functionToCall(modelCtrl.$modelValue);
                              
                      };
                      
                          
                }


          });



      }

    };
    
});

//directiva que activa una funcion al apretar enter
app.directive('enter', function() {
    return {
      restrict: 'A',
      require: 'ngModel',
      link: function(scope, element, attrs, modelCtrl) {

          var functionToCall = scope.$eval(attrs.enter);

          element.on('keydown', function(e){

              if (e.keyCode == 13) {

                      functionToCall(modelCtrl.$modelValue);
 
              }

          });



      }

    };
    
});


//directiva para escribir solo numeros
app.directive('numeros', function(){
   return {
     require: 'ngModel',
     link: function(scope, element, attrs, modelCtrl) {

       modelCtrl.$parsers.push(function (inputValue) {
           if (inputValue == undefined) return '' 
           var transformedInput = inputValue.replace(/[^0-9]/g, ''); 
           if (transformedInput!=inputValue) {
              modelCtrl.$setViewValue(transformedInput);
              modelCtrl.$render();
           }         

           return transformedInput;         
       });
     }
   };
});


//directiva para escribir cantidades decimal
app.directive('dinero', function () {

  var NUMBER_REGEXP = /^\s*(\-|\+)?(\d+|(\d*(\.\d*)))\s*$/;

  function link(scope, el, attrs, ngModelCtrl) {
    var min = parseFloat(attrs.min || 0);
    var precision = parseFloat(attrs.precision || 2);
    var lastValidValue;

    function round(num) {
      var d = Math.pow(10, precision);
      return Math.round(num * d) / d;
    }

    function formatPrecision(value) {
      return parseFloat(value).toFixed(precision);
    }

    function formatViewValue(value) {
      return ngModelCtrl.$isEmpty(value) ? '' : '' + value;
    }


    ngModelCtrl.$parsers.push(function (value) {
      // Handle leading decimal point, like ".5"
      if (value.indexOf('.') === 0) {
        value = '0' + value;
      }

      // Allow "-" inputs only when min < 0
      if (value.indexOf('-') === 0) {
        if (min >= 0) {
          value = null;
          ngModelCtrl.$setViewValue('');
          ngModelCtrl.$render();
        } else if (value === '-') {
          value = '';
        }
      }

      var empty = ngModelCtrl.$isEmpty(value);
      if (empty || NUMBER_REGEXP.test(value)) {
        lastValidValue = (value === '')
          ? null
          : (empty ? value : parseFloat(value));
      } else {
        // Render the last valid input in the field
        ngModelCtrl.$setViewValue(formatViewValue(lastValidValue));
        ngModelCtrl.$render();
      }

      ngModelCtrl.$setValidity('number', true);
      return lastValidValue;
    });
    ngModelCtrl.$formatters.push(formatViewValue);

    var minValidator = function(value) {
      if (!ngModelCtrl.$isEmpty(value) && value < min) {
        ngModelCtrl.$setValidity('min', false);
        return undefined;
      } else {
        ngModelCtrl.$setValidity('min', true);
        return value;
      }
    };
    ngModelCtrl.$parsers.push(minValidator);
    ngModelCtrl.$formatters.push(minValidator);

    if (attrs.max) {
      var max = parseFloat(attrs.max);
      var maxValidator = function(value) {
        if (!ngModelCtrl.$isEmpty(value) && value > max) {
          ngModelCtrl.$setValidity('max', false);
          return undefined;
        } else {
          ngModelCtrl.$setValidity('max', true);
          return value;
        }
      };

      ngModelCtrl.$parsers.push(maxValidator);
      ngModelCtrl.$formatters.push(maxValidator);
    }

    // Round off
    if (precision > -1) {
      ngModelCtrl.$parsers.push(function (value) {
        return value ? round(value) : value;
      });
      ngModelCtrl.$formatters.push(function (value) {
        return value ? formatPrecision(value) : value;
      });
    }

    el.bind('blur', function () {
      var value = ngModelCtrl.$modelValue;
      if (value) {
        ngModelCtrl.$viewValue = formatPrecision(value);
        ngModelCtrl.$render();
      }
    });
  }

  return {
    restrict: 'A',
    require: 'ngModel',
    link: link
  };

});


//directiva que agrega el atributo download a un boton para que descargue archivo con ruta especiica
// app.directive('archivo', function() {
//     return {
//       restrict: 'A',
//       require: 'ngModel',
//       link: function(scope, element, attrs, modelCtrl) {
//           debugger;
//           var file = scope.$eval(attrs.archivo);
//           console.log(file);

//           element.on('click', function(){

//               var link = document.createElement("a");    
//               link.href = file;
              
//               //set the visibility hidden so it will not effect on your web-layout
//               link.style = "visibility:hidden";
//               link.download = file;
              
//               //this part will append the anchor tag and remove it after automatic click
//               document.body.appendChild(link);
//               link.click();
//               document.body.removeChild(link);

//           });



//       }

//     };
    
// });

//directiva que agrega boton para descargar lo que pongas como atributo
app.directive('descarga', function(){
    return {
        restrict: 'E',
        scope: true,
        scope: { info: '=' },
        template: '<button ng-click="click(info)" class="btn btn-primary btn-sm glyphicon glyphicon-download-alt"> Descargar</button>',
        controller: function($scope, $element){

            $scope.click = function(info){
              
              console.log(info);
              
              //this trick will generate a temp <a /> tag
              var link = document.createElement("a");    
              link.href = info;
              
              //set the visibility hidden so it will not effect on your web-layout
              link.style = "visibility:hidden";
              link.download = info;
              
              //this part will append the anchor tag and remove it after automatic click
              document.body.appendChild(link);
              link.click();
              document.body.removeChild(link);

            }
        }
    }
});


app.directive('archivo', function() {
  return {
      scope: {
          archivo: '=',
      },
      link: function($scope, element, attrs) {
        
        element.on('click',function(){
          
            var file = attrs.archivo;

            var link = document.createElement("a");    
            link.href = file;
            
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = file;
            
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);



        })
      }
    }
});



//directiva que agrega boton para descargar lo que pongas como atributo
app.directive('pdf', function(){
    return {
        restrict: 'E',
        scope: true,
        scope: { data: '=' },
        template: '<button ng-click="click(data)" class="btn btn-default">Imprimir Comprobante</button>',
        controller: function($scope, $element, busquedas){

            var getImageFromUrl = function(url, callback, clave) {
        
                var img = new Image(), data, ret = {
                    data: null,
                    pending: true
                };
                
                img.onError = function() {
                    throw new Error('Cannot load image: "'+url+'"');
                };
                img.onload = function() {
                    var canvas = document.createElement('canvas');
                    document.body.appendChild(canvas);
                    canvas.width = img.width;
                    canvas.height = img.height;

                    var ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0);
                    // Grab the image as a jpeg encoded in base64, but only the data
                    data = canvas.toDataURL('image/jpeg').slice('data:image/jpeg;base64,'.length);
                    // Convert the data to binary form
                    data = atob(data);
                    document.body.removeChild(canvas);

                    ret['data'] = data;
                    ret['pending'] = false;
                    if (typeof callback === 'function') {
                        callback(data,clave);
                    }
                };
                img.src = url;

                return ret;
            };

            var createPDF = function(imgData,clave) {

                var doc = new jsPDF();

                doc.addImage(imgData, 'JPEG', 85, 10, 35, 20);
                //rectangulo
                //doc.setDrawColor(0);
                //doc.setFillColor(255, 255, 255);
                //doc.roundedRect(10, 40, 190, 200, 3, 3, 'FD');

                busquedas.detalleSolicitud(clave).success(function (data){
                  console.log(data);

                  var datos = data.info;
                  //encabezado
                  doc.setFontSize(9);
                  doc.text(160, 10, FechaAct + ' ' + FechaActHora); 

                  doc.setFontSize(18);
                  doc.setFont("helvetica");
                  doc.setFontType("bold");
                  doc.text(20, 52, 'Solicitud: '+ datos.tiponombre); 

                  doc.setTextColor(0, 136, 204);
                  doc.text(160, 52, clave); 

                  doc.setTextColor(100);
                  doc.setLineWidth(0.5);
                  doc.line(20, 60, 190, 60);

                  doc.setFontSize(14);
                  //contenido
                  doc.setFontType("normal");

                  doc.text(20, 70, 'Folio:'); 
                  doc.text(50, 70, datos.folio); 
                  doc.text(90, 70, 'Cliente:');
                  doc.text(110, 70, datos.cliente); 

                  doc.text(20, 80, 'Lesionado:'); 
                  doc.text(50, 80, datos.lesionado);

                  doc.text(20, 90, 'Unidad:'); 
                  doc.text(50, 90, 'MV Operaciones');

                  //encabezado tipo
                  doc.setFontSize(15);
                  doc.setTextColor(0);
                  doc.setFontType("bold");
                  
                  if (datos.tipo == 4) {

                    ///para interconsulta
                    doc.text(20, 105, 'Tipo de Solicitud :');
                    doc.text(70, 105, 'INTERCONSULTA ' + datos.DES_intertipo.toUpperCase()); 

                    //linea
                    doc.setLineWidth(0.5);
                    doc.line(20, 110, 190, 110);

                    doc.setTextColor(100);

                    doc.setFontSize(14);
                    doc.setFontType("normal");

                    if(datos.DES_intertipo == 'Ginecologia'){

                      doc.text(20, 120, 'Embarazo:'); 

                      if (datos.DES_embarazo) {

                        doc.text(60, 120, 'SI'); 
                        doc.text(90, 120, 'Sometida a control ginecológico:'); 
                        doc.text(170, 120, datos.DES_controlgineco);

                        doc.text(20, 130, 'Semanas de gestación:'); 
                        doc.text(80, 130, datos.DES_semanas); 
                        doc.text(90, 130, 'Dolor abdominal:'); 
                        doc.text(140, 130, datos.DES_dolorabdominal);

                        doc.text(20, 140, 'Frecuencia cardiaca fetal:'); 
                        doc.text(80, 140, datos.DES_frecuencia); 
                        doc.text(110, 140, 'Movimientos fetales:'); 
                        doc.text(160, 140, datos.DES_movimientosfetales);

                        doc.text(20, 160, 'Observaciones:'); 
                        doc.text(20, 170, doc.splitTextToSize(datos.DES_embarazoObs,170));

                        doc.setFontSize(14);
                        doc.text(20, 190, 'Diagnostico Actual:'); 
                        doc.setFontSize(12);
                        doc.text(20, 200, doc.splitTextToSize(datos.DES_diagnostico, 170)); 

                        doc.setFontSize(14);
                        doc.text(20, 220, 'Justificación y Observaciones:'); 
                        doc.setFontSize(12);
                        doc.text(20, 230, doc.splitTextToSize(datos.DES_justificacion, 170)); 

                      }else{

                        doc.text(60, 120, 'NO'); 
                        doc.setFontSize(14);
                        doc.text(20, 130, 'Diagnostico Actual:'); 
                        doc.setFontSize(12);
                        doc.text(20, 140, doc.splitTextToSize(datos.DES_diagnostico, 170)); 

                        doc.setFontSize(14);
                        doc.text(20, 160, 'Justificación y Observaciones:'); 
                        doc.setFontSize(12);
                        doc.text(20, 170, doc.splitTextToSize(datos.DES_justificacion, 170)); 

                      }
 
                         


                    }else{

                      doc.setFontSize(14);
                      doc.text(20, 120, 'Diagnostico Actual:'); 
                      doc.setFontSize(12);
                      doc.text(20, 130, doc.splitTextToSize(datos.DES_diagnostico, 170)); 

                      doc.setFontSize(14);
                      doc.text(20, 150, 'Justificación y Observaciones:'); 
                      doc.setFontSize(12);
                      doc.text(20, 160, doc.splitTextToSize(datos.DES_justificacion, 170));    

                    }

                    
                  };

                  if (datos.tipo == 3) {

                    // estudio especial
                    doc.text(20, 105, 'Tipo de Solicitud :');
                    doc.text(70, 105, datos.DES_estudiotipo); 
                    // linea
                    doc.setLineWidth(0.5);
                    doc.line(20, 110, 190, 110);

                    doc.setTextColor(100);

                    doc.setFontSize(14);
                    doc.setFontType("normal");

                    doc.text(20, 120, 'Detalle:'); 
                    doc.setFontSize(12);
                    doc.text(20, 130, doc.splitTextToSize(datos.DES_estudioDetalle, 170));

                    doc.setFontSize(14);
                    doc.text(20, 160, 'Diagnostico Actual:'); 
                    doc.setFontSize(12);
                    doc.text(20, 170, doc.splitTextToSize(datos.DES_diagnostico, 170)); 

                    doc.setFontSize(14);
                    doc.text(20, 190, 'Justificación y Observaciones:'); 
                    doc.setFontSize(12);
                    doc.text(20, 200, doc.splitTextToSize(datos.DES_justificacion, 170));    

                  }

                  if (datos.tipo == 1) {

                    //rehabilitacion

                    doc.text(20, 105, 'Detalle de Solicitud :');

                    //linea
                    doc.setLineWidth(0.5);
                    doc.line(20, 110, 190, 110);

                    doc.setTextColor(100);

                    doc.setFontSize(14);
                    doc.setFontType("normal");

                    doc.text(20, 120, 'Escala de dolor del paciente:'); 
                    doc.text(90, 120, datos.DES_dolor);

                    doc.text(20, 130, 'Numero de sesiones de rehabilitación del paciente:'); 
                    doc.text(140, 130, datos.DES_rehabilitaciones); 

                    doc.text(20, 140, 'Escala de mejoria:'); 
                    doc.text(70, 140, datos.DES_mejora);

                    doc.setFontSize(14);
                    doc.text(20, 150, 'Diagnostico Actual:'); 
                    doc.setFontSize(12);
                    doc.text(20, 160, doc.splitTextToSize(datos.DES_diagnostico, 170)); 

                    doc.setFontSize(14);
                    doc.text(20, 180, 'Justificación y Observaciones:'); 
                    doc.setFontSize(12);
                    doc.text(20, 190, doc.splitTextToSize(datos.DES_justificacion, 170));

                  }

                  if (datos.tipo == 9) {
                    
                    // Suministro

                    doc.text(20, 105, 'Detalle de Solicitud :');

                    //linea
                    doc.setLineWidth(0.5);
                    doc.line(20, 110, 190, 110);

                    doc.setTextColor(100);

                    doc.setFontSize(14);
                    doc.setFontType("normal");

                    doc.text(20, 120, 'Detalle del suministro requerido:'); 
                    doc.setFontSize(12);
                    doc.text(20, 130, doc.splitTextToSize(datos.DES_suministroDetalle, 170));

                    doc.setFontSize(14);
                    doc.text(20, 160, 'Diagnostico Actual:'); 
                    doc.setFontSize(12);
                    doc.text(20, 170, doc.splitTextToSize(datos.DES_diagnostico, 170)); 

                    doc.setFontSize(14);
                    doc.text(20, 190, 'Justificación y Observaciones:'); 
                    doc.setFontSize(12);
                    doc.text(20, 200, doc.splitTextToSize(datos.DES_justificacion, 170));  
                  }

                  if (datos.tipo == 11) {
                    
                    // Prestamo info

                    doc.text(20, 105, 'Detalle de Solicitud :');
                    
                    //linea
                    doc.setLineWidth(0.5);
                    doc.line(20, 110, 190, 110);

                    doc.setTextColor(100);

                    doc.setFontSize(14);
                    doc.setFontType("normal");

                    doc.text(20, 120, 'Nota medica:'); 
                    if (datos.DES_notamedica) {
                      doc.text(55, 120, 'SI'); 
                    }else{
                      doc.text(55, 120, 'NO'); 
                    }
                    
                    
                    doc.text(90, 120, 'Rx:');
                    if (datos.DES_rx) {
                      doc.text(105, 120, 'SI'); 
                    }else{
                      doc.text(105, 120, 'NO'); 
                    }
 
                    doc.text(130, 120, 'Resultado de estudios:');
                    if (datos.DES_resultados) {
                      doc.text(185, 120, 'SI'); 
                    }else{
                      doc.text(185, 120, 'NO'); 
                    }
                    
                    doc.text(20, 130, 'Motivo por el cual el paciente requiere esta información:'); 
                    doc.setFontSize(12);
                    doc.text(20, 140, doc.splitTextToSize(datos.DES_infoDetalle, 170));

                    doc.setFontSize(14);
                    doc.text(20, 160, 'Diagnostico Actual:'); 
                    doc.setFontSize(12);
                    doc.text(20, 170, doc.splitTextToSize(datos.DES_diagnostico, 170)); 

                    doc.setFontSize(14);
                    doc.text(20, 190, 'Justificación y Observaciones:'); 
                    doc.setFontSize(12);
                    doc.text(20, 200, doc.splitTextToSize(datos.DES_justificacion, 170));  

                  }

                  if (datos.tipo == 2) {

                    // Problema Documental

                    doc.text(20, 105, 'Detalle de Solicitud :');

                    //linea
                    doc.setLineWidth(0.5);
                    doc.line(20, 110, 190, 110);

                    doc.setTextColor(100);

                    doc.setFontSize(14);
                    doc.setFontType("normal");

                    doc.text(20, 120, 'Problema pase médico:'); 
                    if (datos.DES_pase) {
                      doc.text(80, 120, 'SI'); 
                    }else{
                      doc.text(80, 120, 'NO'); 
                    }

                    doc.text(100, 120, 'Problema identificación:');

                    if (datos.DES_identificacion) {
                      doc.text(160, 120, 'SI'); 
                    }else{
                      doc.text(160, 120, 'NO'); 
                    }

                    doc.text(20, 130, 'Motivo del problema:'); 

                    //cambiamos de fuente por que se espera un texto largo
                    doc.setFontSize(12);
                    //la funcion splitTextToSize nos permite delimitar el texto para que no se pase y corte texto
                    doc.text(20, 140, doc.splitTextToSize(datos.DES_documentalDetalle, 170));

                    doc.setFontSize(14);
                    doc.text(20, 160, 'Diagnostico Actual:'); 
                    doc.setFontSize(12);
                    doc.text(20, 170, doc.splitTextToSize(datos.DES_diagnostico, 170)); 

                    doc.setFontSize(14);
                    doc.text(20, 190, 'Justificación y Observaciones:'); 
                    doc.setFontSize(12);
                    doc.text(20, 200, doc.splitTextToSize(datos.DES_justificacion, 170));  
                    
                  }

                  if (datos.tipo == 21) {
                    // salida de paquete

                    doc.text(20, 105, 'Detalle de Solicitud :');

                    //linea
                    doc.setLineWidth(0.5);
                    doc.line(20, 110, 190, 110);

                    doc.setTextColor(100);

                    doc.setFontSize(14);
                    doc.setFontType("normal");

                    doc.text(20, 120, 'Detalle:'); 
                    doc.text(20, 130, doc.splitTextToSize(datos.DES_hosDetalle, 170));

                    doc.setFontSize(14);
                    doc.text(20, 160, 'Diagnostico Actual:'); 
                    doc.setFontSize(12);
                    doc.text(20, 170, doc.splitTextToSize(datos.DES_diagnostico, 170)); 

                    doc.setFontSize(14);
                    doc.text(20, 190, 'Justificación y Observaciones:'); 
                    doc.setFontSize(12);
                    doc.text(20, 200, doc.splitTextToSize(datos.DES_justificacion, 170)); 
                     

                  }


                  doc.save(clave + '-comprobante.pdf');

                });
                  
                


            }

            $scope.click = function(clave){

              getImageFromUrl('imgs/logomv.jpg', createPDF, clave);


            }
        }
    }
});
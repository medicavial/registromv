app.controller('reciboParticularCtrl', function($scope,$rootScope,$location,$cookies,WizardHandler,busquedas,$http) {
	$rootScope.folio=$cookies.folio;	
  $rootScope.usrLogin= $cookies.usrLogin;
  $rootScope.uniClave=$cookies.uniClave;
  $scope.cargador=true;
  $scope.cargador1=false;
  $scope.cargador2=false;
  $scope.cargador3=false;
  $scope.listadoItems='';
  $scope.valItems=false;
  $scope.formularios={}; 
  $scope.porMayor=false;
  $scope.formu=false;
  $scope.guardado=false; 
  $scope.datos={
    fecExp:'',
    noRec:'',
    folMv:'',
    pac:'',
    fecAt:''
  }
  $scope.items={
    fam:'',
    item:'',
    descuento:'',
    precio:''
  }
  $scope.datosRec={
    fPago:'',
    fec:'',
    noRec:'',
    medico:''
  }


 
  
  $scope.interacted = function(field) {          
    return $scope.formularios.formItem.$submitted && field.$invalid;          
  };
  $scope.interacted1 = function(field) {          
    return $scope.formularios.formRecibo.$submitted && field.$invalid;          
  };

  busquedas.datosRecibo($rootScope.folio).success(function(data){  
      $scope.datos={
        fecExp:data.fecExp,
        noRec:data.noRec,
        folMv:$rootScope.folio,
        pac:data.nombre,
        fecAt:data.fecReg
      }                         

      busquedas.familiaItems($rootScope.folio).success(function(data){        
        $scope.famItems=data;
        $scope.items.precio='';          
        $scope.cargador=false;
      });
      busquedas.medicos($rootScope.uniClave).success(function(data){         
        $scope.medicos=data;        
      });
    });


  $scope.selectItem = function(){
        $scope.cargador1=true;          
          var fam=$scope.items.fam;                                               
              $http({
                      url:'api/api.php?funcion=SelectItems&cveFam='+fam,
                      method:'POST', 
                      contentType: 'application/json', 
                      dataType: "json", 
                      data: $scope.datos1
                      }).success( function (data){  
                        $scope.items.precio='';                                                   
                        $scope.listItems=data;
                        $scope.cargador1=false;
                      }).error( function (xhr,status,data){
                          $scope.mensaje ='no entra';            
                          alert('Error');
                      });
              }
        $scope.ponerPrecio = function(){                
                if($scope.items.item){
                  precio=$scope.items.item.split('/');
                  $scope.items.precio=precio[1];
                }else{
                  $scope.items.precio='';
                }
              }
        


  $scope.verDatosAcc = function(){          
          //console.log($scope.datos1);
            
            
            if($scope.acc.fecSin==''){
              $scope.cargador=true;
              $http({
                      url:'api/api.php?funcion=datosAcc&folio='+$rootScope.folio,
                      method:'POST', 
                      contentType: 'application/json', 
                      dataType: "json", 
                      data: $scope.datos1
                      }).success( function (data){ 
                                            
                        $scope.acc.fecSin=data.Not_fechaAcc;
                        $scope.acc.fecAtn=data.Not_fechareg;
                        $scope.acc.doc=data.Med_nombre;
                        $scope.acc.diag=data.ObsNot_diagnosticoRx;
                        $scope.cargador=false;
                      }).error( function (xhr,status,data){
                          $scope.mensaje ='no entra';            
                          alert('Error');
                      });
              }
        }  

  $scope.verExpdiente = function(){                                            
            //if($scope.acc.fecSin==''){
              if(!$scope.validaEx){
              $scope.cargador=true;
              $http({
                    url:'api/api.php?funcion=datosExp&folio='+$rootScope.folio,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.datos1
                    }).success( function (data){                                     
                      if(data.nota=='SI'){
                        $scope.nota=true;
                      }
                      $scope.subsec=data.Subs;
                      $scope.cargador=false;
                      $scope.validaEx=true;
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
                  }
              //}
        }  

  $scope.guardaItem = function(){                                                     
           if($scope.formularios.formItem.$valid){               
              if($scope.items.descuento<=100){ 
              $scope.cargador2=true; 
              $scope.porMayor=false;             
              $http({
                    url:'api/api.php?funcion=guardaItem&folio='+$rootScope.folio+'&usr='+$rootScope.usrLogin+'&cveRec='+$scope.datos.noRec,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: $scope.items
                    }).success( function (data){ 
                      $scope.cargador2=false;                      
                      
                      if(!data.respuesta){
                        $scope.listadoItems=data;
                        subtotal=0;
                        total=0;
                        porcentaje=0;
                        descuento=0;
                        for (var i = 0; i < $scope.listadoItems.length; i++) {                          
                           subtotal=parseFloat(subtotal)+parseFloat($scope.listadoItems[i].it_precio);
                           porcentaje=($scope.listadoItems[i].it_precio*$scope.listadoItems[i].it_descuento)/100;
                           descuento=descuento+porcentaje;
                           total=subtotal-descuento
                        }
                      }else{
                        $scope.listadoItems='';
                      }
                      $scope.items={                        
                        item:'',
                        descuento:'',
                        precio:''
                      }
                      
                      $scope.subtotal=subtotal.toFixed(2);
                      $scope.descuento=descuento.toFixed(2);
                      $scope.total=total.toFixed(2);
                      
                     
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });
                  }else{
                      $scope.porMayor=true;
                  }
              }
        }  
  

  $scope.eliminarItemRec = function(cons,folRec){                                                               
              $scope.cargador2=true; 
                                       
              $http({
                    url:'api/api.php?funcion=eliminarItemRecibo&folio='+$rootScope.folio+'&cons='+cons+'&folRec='+folRec,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data: {'clave':'valor'}
                    }).success( function (data){ 
                     if(!data.respuesta){
                     if(data==''){
                        $scope.listadoItems='';
                     }else{
                        $scope.listadoItems=data;
                     }                        
                        
                        subtotal=0;
                        total=0;
                        porcentaje=0;
                        descuento=0;
                        for (var i = 0; i < $scope.listadoItems.length; i++) {                           
                           subtotal=parseFloat(subtotal)+parseFloat($scope.listadoItems[i].it_precio);
                           porcentaje=($scope.listadoItems[i].it_precio*$scope.listadoItems[i].it_descuento)/100;
                           descuento=descuento+porcentaje;
                           total=subtotal-descuento
                        }
                      $scope.subtotal=subtotal.toFixed(2);
                      $scope.descuento=descuento.toFixed(2);
                      $scope.total=total.toFixed(2);
                     }
                      else{
                        $scope.listadoItems='';
                      }
                      $scope.cargador2=false; 
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });           
        }  

  $scope.guardaRecibo = function(){                                                     
           if($scope.formularios.formRecibo.$valid){               
              $scope.cargador3=true;
              $scope.datosRec.fec=$scope.datos.fecExp;
              $scope.datosRec.noRec=$scope.datos.noRec              
              $http({
                    url:'api/api.php?funcion=validaItems&folio='+$rootScope.folio+'&cveRec='+$scope.datos.noRec,
                    method:'POST', 
                    contentType: 'application/json', 
                    dataType: "json", 
                    data:{'clave':'valor'}
                    }).success( function (data){ 
                      if(data==''){
                        $scope.valItems=true;
                        $('#familia').focus();
                      }else{                          
                        var fileName = "Reporte";
                        var uri = 'api/classes/imprimirRecibo.php?fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin+'&fecha='+$scope.datosRec.fec+'&facPago='+$scope.datosRec.fPago+'&cveRec='+$scope.datos.noRec+'&medico='+$scope.datosRec.medico;
                        var link = document.createElement("a");    
                        link.href = uri;
                        
                        //set the visibility hidden so it will not effect on your web-layout
                        link.style = "visibility:hidden";
                        link.download = fileName + ".pdf";
                        
                        //this part will append the anchor tag and remove it after automatic click
                        document.body.appendChild(link);
                        link.click();
                        $scope.cargador=false;
                        document.body.removeChild(link);
                        $scope.formu=true; 
                        $scope.guardado=true;
                      }
                      $scope.cargador3=false;                     
                    }).error( function (xhr,status,data){
                        $scope.mensaje ='no entra';            
                        alert('Error');
                    });                  
              }
        }  
  

  
  $scope.irDocumentos = function(){         
        $location.path("/documentos");          
  }
  $scope.imprimirReceta = function(){
    $scope.cargador=true;          
      var fileName = "Reporte";
      var uri = 'api/classes/formatoRecSub.php?fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin;
      var link = document.createElement("a");    
      link.href = uri;
      
      //set the visibility hidden so it will not effect on your web-layout
      link.style = "visibility:hidden";
      link.download = fileName + ".pdf";
      
      //this part will append the anchor tag and remove it after automatic click
      document.body.appendChild(link);
      link.click();
      $scope.cargador=false;
      document.body.removeChild(link);
  
  }
  $scope.imprimirSub = function(){          
    $scope.cargador=true;          
      var fileName = "Reporte";
      var uri = 'api/classes/formatoSub.php?fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin;
      var link = document.createElement("a");    
      link.href = uri;
      
      //set the visibility hidden so it will not effect on your web-layout
      link.style = "visibility:hidden";
      link.download = fileName + ".pdf";
      
      //this part will append the anchor tag and remove it after automatic click
      document.body.appendChild(link);
      link.click();
      $scope.cargador=false;
      document.body.removeChild(link);
  }

  $scope.imprimirSubList = function(cont){          
          $scope.cargador=true;          
            var fileName = "Reporte";
            var uri = 'api/classes/formatoSubList.php?fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin+'&cont='+cont;
            var link = document.createElement("a");    
            link.href = uri;
            
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".pdf";
            
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            $scope.cargador=false;
            document.body.removeChild(link);
        }

  $scope.imprimirNota = function(){ 
          $scope.cargador=true;        
            var fileName = "Reporte";
            var uri = 'api/classes/formatoNota.php?fol='+$rootScope.folio;
            var link = document.createElement("a");    
            link.href = uri;
            
            //set the visibility hidden so it will not effect on your web-layout
            link.style = "visibility:hidden";
            link.download = fileName + ".pdf";
            
            //this part will append the anchor tag and remove it after automatic click
            document.body.appendChild(link);
            link.click();
            $scope.cargador=false;
            document.body.removeChild(link);
        }


});
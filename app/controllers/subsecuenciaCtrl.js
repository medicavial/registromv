app.controller('subsecuenciaCtrl', function($scope,$rootScope,$location,$cookies,WizardHandler,busquedas,$http) {
	$rootScope.folio=$cookies.folio;	
  $rootScope.usrLogin= $cookies.usrLogin;
  $rootScope.uniClave=$cookies.uniClave;
  $scope.sub={
    sigYSin:'',
    evo:''
  }
  $scope.estudiosSub={
    rx:'',
    obs:'',
    interp:''
  }
  $scope.diagnosticoSub={
          diagnostico:'',
          obs:''
        }
  $scope.progreso=10;
  busquedas.validaSubsec($rootScope.folio).success(function(data){                      
    if(data.Cons==null){
      data.Cons=1;
    }
    $scope.noSubsec=data.Cons; 
    console.log(data);                         
  });

  $scope.guardaSigYSinSub = function(){
    console.log($scope.accidente);
    $http({
      url:'api/api.php?funcion=guardaSigYSinSub&fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin+'&cons='+$scope.noSubsec,
      method:'POST', 
      contentType: 'application/json', 
      dataType: "json", 
      data: $scope.sub
    }).success( function (data){                        
      if(data.respuesta=='correcto'){
       $scope.sub={
          sigYSin:'',
          evo:''
        };
        busquedas.listaRX().success(function(data){                      
          $scope.listRX=data; 
          console.log($scope.listRX);                         
        }); 
        busquedas.listaEstSolSub($rootScope.folio).success(function(data){                      
                  $scope.listEstSoliSub=data; 
                console.log($scope.listEstSoliSub);                         
                });          
        $scope.progreso=25; 
        WizardHandler.wizard().next();                  
      }
      else{
        console.log(data);
        alert('error en la inserción');
      }
      console.log(data);
    }).error( function (xhr,status,data){
        $scope.mensaje ='no entra';            
        alert('Error');
    }); 
  }

   $scope.guardaEstudiosSub = function(){
    console.log($scope.estudiosSub);
    $http({
      url:'api/api.php?funcion=guardaEstudiosSub&fol='+$rootScope.folio,
      method:'POST', 
      contentType: 'application/json', 
      dataType: "json", 
      data: $scope.estudiosSub
    }).success( function (data){                        
      if(data.respuesta=='correcto'){
      $scope.estudiosSub={
        rx:'',
        obs:'',
        interp:''
      }    
      busquedas.listaEstSolSub($rootScope.folio).success(function(data){                      
                $scope.listEstSoliSub=data; 
              console.log($scope.listEstSoliSub);                         
              });                              
      }
      else{
        console.log(data);
        alert('error en la inserción');
      }
      console.log(data);
    }).error( function (xhr,status,data){
        $scope.mensaje ='no entra';            
        alert('Error');
    }); 
  }

  $scope.eliminarEstSolSub = function(claveEst){  
            console.log(claveEst);                  
            $http({
            url:'api/api.php?funcion=eliminaEstRealizadoSub&fol='+$rootScope.folio+'&cveEst='+claveEst,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: {cve:'valor'}
            }).success( function (data){                        
              if(data.respuesta=='correcto'){               
                  busquedas.listaEstSolSub($rootScope.folio).success(function(data){                      
                    $scope.listEstSoliSub=data; 
                  console.log($scope.listEstSoliSub);                         
              });                                    
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                     
          console.log( $scope.lesion);
        }

        $scope.diagnSig = function(){
               
            $scope.progreso=50;           
             busquedas.listaDiagnosticos().success(function(data){                      
              $scope.listaDiagnostico=data; 
            console.log($scope.listaDiagnostico);                         
            });  
            WizardHandler.wizard().next();  
        }

         $scope.despliegaDiagnosticos = function(diagnostic){
            busquedas.despDiagnosticos(diagnostic).success(function(data){                      
              $scope.listaDiagnostics=data; 
            console.log($scope.listaDiagnostics);                         
            });                              
        }
        $scope.agregaDiagnostico = function(diag){
            console.log(diag);
            if($scope.diagnosticoSub.diagnostico==''){
              $scope.diagnosticoSub.diagnostico=diag;
            }else{
              $scope.diagnosticoSub.diagnostico=$scope.diagnosticoSub.diagnostico+' // '+diag;
            }            
        }

         $scope.guardaDiagnosticoSub = function(diag){
            console.log($scope.diagnosticoSub);
            $http({
            url:'api/api.php?funcion=guardaDiagnosticoSub&fol='+$rootScope.folio,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.diagnosticoSub
            }).success( function (data){                        
              if(data.respuesta=='correcto'){                
                  busquedas.listaMedicamentos().success(function(data){                      
                    $scope.listaMedicamento=data; 
                    console.log($scope.listaMedicamento);                         
                  });
                  busquedas.listaOrtesis().success(function(data){                      
                    $scope.listaOrt=data; 
                    console.log($scope.listaOrt);                         
                  });
                  busquedas.listaIndicaciones().success(function(data){                      
                    $scope.listaIndicacion=data; 
                    console.log($scope.listaIndicacion);                         
                  });  
                  /*busquedas.listaMedicamentosAgreg($rootScope.folio).success(function(data){                      
                    $scope.listaMedicamentosAgreg=data; 
                    console.log($scope.listaMedicamentosAgreg);
                  }); 
                  busquedas.listaOrtesisAgreg($rootScope.folio).success(function(data){                      
                    $scope.listaOrtesisAgreg=data; 
                    console.log($scope.listaOrtesisAgreg);
                  });  
                  busquedas.listaIndicAgreg($rootScope.folio).success(function(data){                      
                    $scope.listaIndicAgreg=data; 
                    console.log($scope.listaIndicAgreg);
                  });*/ 
                  $scope.progreso=75;     
                  WizardHandler.wizard().next();                                                               
              }              
              else{
                console.log(data);
                alert('error en la inserción');
              }
              console.log(data);
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            }); */     
        }


});

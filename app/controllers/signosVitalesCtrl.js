app.controller('signosVitalesCtrl', function($scope,$rootScope,$location,$cookies,busquedas,$http) {
	$rootScope.folio=$cookies.folio;	
  $rootScope.usrLogin =$cookies.usrLogin;
  $scope.formularios={};  
   $scope.vitales={      
      tem:"",
      talla:"",
      peso:"",
      frecResp:"",
      sistole:"",
      astole:"",
      frecCard:"",
      obs:''
  };
  $rootScope.cargador=false;

  $scope.interacted = function(field) {
    //$dirty es una propiedad de formulario que detecta cuando se esta escribieno algo en el input
    return $scope.formularios.vital.$submitted && field.$invalid;          
  };

  busquedas.listaVitales($rootScope.folio).success(function(data){
            $scope.listVitales=data;                
            $rootScope.cargador=false;            
        });
       
  $scope.guardaVitales = function(){
    if($scope.formularios.vital.$valid){    
    $scope.cargador=true;
    $http({
      url:'api/api.php?funcion=guardaVitalesP&fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin,
      method:'POST', 
      contentType: 'application/json', 
      dataType: "json", 
      data: $scope.vitales
      }).success( function (data){                        
        if(!data.respuesta){                                            
          $scope.listVitales=data;           
          $scope.vitales={      
            tem:"",
            talla:"",
            peso:"",
            frecResp:"",
            sistole:"",
            astole:"",
            frecCard:"",
            obs:''
          };
          $scope.formularios.vital.$submitted=false;
          $scope.cargador=false;
        }
        else{
          $scope.cargador=false;          
          alert('error en la inserción');         
        }      
      }).error( function (xhr,status,data){
          $scope.cargador=false;
          $scope.mensaje ='no entra';            
          alert('Error');
      }); 
      } 
  }

  $scope.irDocumentos = function(){         
              $location.path("/documentos");          
        }
        
});



app.controller('signosVitalesCtrl', function($scope,$rootScope,$location,$cookies,busquedas,$http) {
	$rootScope.folio=$cookies.folio;	
  $rootScope.usrLogin =$cookies.usrLogin;
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

  busquedas.listaVitales($rootScope.folio).success(function(data){
            $scope.listVitales=data;                
            console.log(data);
        });
       
  $scope.guardaVitales = function(){
    console.log($scope.vitales);
    $http({
      url:'api/api.php?funcion=guardaVitalesP&fol='+$rootScope.folio+'&usr='+$rootScope.usrLogin,
      method:'POST', 
      contentType: 'application/json', 
      dataType: "json", 
      data: $scope.vitales
      }).success( function (data){                        
        if(data.respuesta=='correcto'){
          busquedas.listaVitales($rootScope.folio).success(function(data){
            $scope.listVitales=data;                
            console.log(data);
          });         
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

  $scope.irDocumentos = function(){         
              $location.path("/documentos");          
        }
        
});



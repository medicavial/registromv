app.controller('busquedaCtrl', function($scope,$rootScope,$location,$cookies,busquedas,$http) {
	$rootScope.cveUni=$cookies.uniClave;
	$scope.busca={
		nombre:'',
		folio:''
	}	
	$rootScope.cargador=false;
	$rootScope.cargador1=false;
	$scope.error=false;
	$rootScope.permisos=JSON.parse($cookies.permisos);	
	busquedas.listadoFolios($rootScope.cveUni).success(function(data){		
		$scope.list=data;	
		$rootScope.cargador=false;
	});
	$scope.mandaPortada = function(folio){  
		$cookies.folio = folio;
        $location.path("/portada");
	}
	$scope.mandaDocumentos = function(folio){  
		$cookies.folio = folio;
        $location.path("/documentos");
	}
	$scope.buscaParametros = function(){ 
	$rootScope.cargador1=true;	 
		$http({
            url:'api/api.php?funcion=buscaParametros&cveUnidad='+$rootScope.cveUni,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.busca
            }).success( function (data){                                                      
            	$rootScope.cargador1=false;
				if(data.respuesta!='error'){
					$scope.error=false;					
					$scope.listaFolPar=data;   
					$scope.busca={
						nombre:'',
						folio:''
					}                
				}else{
					$scope.error=true;
				}
            }).error( function (xhr,status,data){
                $scope.mensaje ='no entra';            
                alert('Error');
            });                        
	}

});

//busqueda solo para administrador para buscar en todas las unidades
app.controller('busquedaUniCtrl', function($scope,$rootScope,$location,$cookies,busquedas,$http) {
	

	$scope.inicio = function(){

		$scope.buscar = false;
		$scope.cveUni = '';
		$scope.busca = {
			nombre:'',
			folio:''
		}	
		$scope.error=false;

		busquedas.listaUnidades().success(function(data){
			$scope.unidades = data;
		});

	}

	$scope.muestraFolios = function(){

		$scope.buscar = true;
		busquedas.listadoFolios($scope.cveUni).success(function(data){			
			$scope.list=data;
			$scope.buscar = false;	
		});
		
	}

	$scope.mandaPortada = function(folio){  
		$cookies.folio = folio;
        $location.path("/portada");
	}
	$scope.mandaDocumentos = function(folio){  
		$cookies.folio = folio;
        $location.path("/documentos");
	}
	$scope.buscaParametros = function(){ 	 	
	 	$scope.buscar = true;
	 	// if ($scope.cveUni == '') {

	 	// 	alert('Necesitas seleccionar unidad');
	 	// }else{

			$http({
	            url:'api/api.php?funcion=buscaParametros&cveUnidad='+$scope.cveUni,
	            method:'POST', 
	            contentType: 'application/json', 
	            dataType: "json", 
	            data: $scope.busca
	        }).success( function (data){ 

				if(data.respuesta!='error'){
					$scope.error=false;					
					$scope.listaFolPar=data;   
					$scope.busca={
						nombre:'',
						folio:''
					} 
					$scope.cveUni = '';
					               
				}else{
					$scope.error=true;
				}

				$scope.buscar = false;

	        }).error( function (xhr,status,data){
	            $scope.mensaje ='no entra';            
	            alert('Error');
	        });                        

	 	// }
	}

});
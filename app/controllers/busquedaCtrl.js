app.controller('busquedaCtrl', function($scope,$rootScope,$location,$cookies,busquedas,$http) {
	$rootScope.cveUni=$cookies.uniClave;
	$scope.busca={
		nombre:'',
		folio:''
	}	
	$scope.error=false;
	$rootScope.permisos=JSON.parse($cookies.permisos);	
	busquedas.listadoFolios($rootScope.cveUni).success(function(data){
		console.log(data);		
		$scope.list=data;	
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
	 	console.log($rootScope.cveUni);
		$http({
            url:'api/api.php?funcion=buscaParametros&cveUnidad='+$rootScope.cveUni,
            method:'POST', 
            contentType: 'application/json', 
            dataType: "json", 
            data: $scope.busca
            }).success( function (data){                                                      
				if(data.respuesta!='error'){
					$scope.error=false;
					console.log(data); 
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

		busquedas.listadoFolios($scope.cveUni).success(function(data){
			console.log(data);		
			$scope.list=data;	
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
	 	console.log($scope.cveUni);

	 	if ($scope.cveUni == '') {

	 		alert('Necesitas seleccionar unidad');
	 	}else{

			$http({
	            url:'api/api.php?funcion=buscaParametros&cveUnidad='+$scope.cveUni,
	            method:'POST', 
	            contentType: 'application/json', 
	            dataType: "json", 
	            data: $scope.busca
	        }).success( function (data){ 

				if(data.respuesta!='error'){
					$scope.error=false;
					console.log(data); 
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
	}

});
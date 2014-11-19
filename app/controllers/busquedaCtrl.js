app.controller('busquedaCtrl', function($scope,$rootScope,$location,$cookies,busquedas,$http) {
	$rootScope.cveUni=$cookies.uniClave;	
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

});
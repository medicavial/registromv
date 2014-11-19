app.controller('documentosCtrl', function($scope,$rootScope,$location,$cookies) {
	$rootScope.folio=$cookies.folio;	
	$scope.irHistoriaClinica = function(folio){  
		$cookies.folio = folio;
        $location.path("/historiaClinica");
	}
	$scope.irSignosVitales = function(folio){  
		$cookies.folio = folio;
        $location.path("/signosVitales");
	}
	$scope.irNotaMedica = function(folio){  
		$cookies.folio = folio;
        $location.path("/notaMedica");
	}

	
});
app.controller('homeCtrl', function($scope, $rootScope,$cookies,busquedas) {   
   $scope.init = function() {
	    $rootScope.permisos=JSON.parse($cookies.permisos); 
	    $scope.cargador=true;
	    $rootScope.ruta='api/Avisos/';
	    $rootScope.ruta1='#toolbar=0';       
	    busquedas.listaAvisos().success(function(data){             
	         $rootScope.avisos  = data;
	         $rootScope.noAviso = $rootScope.avisos.length; 
	         $scope.cargador=false;	         
	    });
	}
    
});


///estructura de controlador
// app.controller('nombredelcontroladorCtrl',function (dependencias $scope,nombrefactoria,$rootScope) {
// 	// codigos con funciones varaibles
// 	// $scope.variable
// })